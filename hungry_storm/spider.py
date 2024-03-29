import redis
import json
import collections
from grab import Grab
import time
import MySQLdb
import urllib.request
from db_access import mysql_credentials
import sys

from pprint import pprint

start = time.time()
r = redis.Redis()
ps = r.pubsub()
ps.subscribe('spider')
STOP_WORDS = ['mailto', 'redirect_to', 'youtube.com', 'uploads', 'upload', '(', '#', 'share', 'facebook.com', '.pdf', '..', '.ppt', '.jpg', 'redirect', 'tel:', '.doc', '.docx', '.eps', '.cdr']

def bot_error(message):
    r.publish('telebot', json.dumps({'msg': message}))

def prep(href):
    href = href.strip('/')
    if href == '':
        return False
    for br in STOP_WORDS:
        if (href.find(br) != -1):
            return False
    return iri2uri(href)

escape_range = [
    (0xA0, 0xD7FF),
    (0xE000, 0xF8FF),
    (0xF900, 0xFDCF),
    (0xFDF0, 0xFFEF),
    (0x10000, 0x1FFFD),
    (0x20000, 0x2FFFD),
    (0x30000, 0x3FFFD),
    (0x40000, 0x4FFFD),
    (0x50000, 0x5FFFD),
    (0x60000, 0x6FFFD),
    (0x70000, 0x7FFFD),
    (0x80000, 0x8FFFD),
    (0x90000, 0x9FFFD),
    (0xA0000, 0xAFFFD),
    (0xB0000, 0xBFFFD),
    (0xC0000, 0xCFFFD),
    (0xD0000, 0xDFFFD),
    (0xE1000, 0xEFFFD),
    (0xF0000, 0xFFFFD),
    (0x100000, 0x10FFFD),
]

def encode(c):
    retval = c
    i = ord(c)
    for low, high in escape_range:
        if i < low:
            break
        if i >= low and i <= high:
            retval = "".join(["%%%2X" % o for o in c.encode('utf-8')])
            break
    return retval


def iri2uri(uri):
    """Convert an IRI to a URI. Note that IRIs must be
    passed in a unicode strings. That is, do not utf-8 encode
    the IRI before passing it into the function."""
    if isinstance(uri ,str):
        (scheme, authority, path, query, fragment) = urllib.parse.urlsplit(uri)
        authority = authority.encode('idna').decode('utf-8')
        # For each character in 'ucschar' or 'iprivate'
        #  1. encode as utf-8
        #  2. then %-encode each octet of that utf-8
        uri = urllib.parse.urlunsplit((scheme, authority, path, query, fragment))
        uri = "".join([encode(c) for c in uri])
    return uri

def scan(starting_url):
    g = Grab()
    urls_queue = collections.deque()
    urls_queue.append(starting_url)
    found_urls = set()
    found_urls.add(starting_url)
    visited_urls = set()
    #cn = 1
    while len(urls_queue):
        url = urls_queue.popleft()
        try:
            g.go(url)
            if g.response.code < 400 and g.response.headers['Content-Type'].find('text/html') != -1 and g.response.url.startswith(starting_url):
                #print(str(cn) + '. ' + url)
                #cn += 1
                print(url)
                links = g.doc.select('//a[@href]')
                for link in links:
                    href = prep(link.attr('href'))
                    if href == False:
                        continue
                    if href.startswith('http') == False:
                        href = starting_url + '/' + href
                    elif href.startswith('http') and href.startswith(starting_url) == False:
                        continue
                    if href not in found_urls:
                        found_urls.add(href)
                    else:
                        continue
                    if url not in visited_urls:
                        urls_queue.append(href)
                visited_urls.add(url)
            elif url in found_urls:
                found_urls.remove(url)
        except:
            pass
        time.sleep(0.2)
    return found_urls


for item in ps.listen():
    if (item['type'] == "message"):
        try:
            data = json.loads(item['data'].decode("utf-8"))
            site = data['site']
            api  = 'http://' + data['api'] + '/python/map-done/' + str(site)
            try:
                connection      = MySQLdb.connect(
                    host        = mysql_credentials['host'],
                    user        = mysql_credentials['user'],
                    passwd      = mysql_credentials['password'],
                    db          = mysql_credentials['db'],
                    charset     = mysql_credentials['charset']
                )
            except Exception as e:
                bot_error("!!! ПАУК !!! - Error %s" % (str(e)))
                print("!!! ПАУК !!! - Error %s" % (str(e)))
            else:
                try:
                    with connection.cursor() as cursor:
                        sql = "INSERT INTO `site_state` (`site_id`, `status`) VALUES ({}, 'Паук начал обработку')".format(site)
                        cursor.execute(sql)
                        connection.commit()
                        cursor.execute("SELECT `url`, `secret` FROM `sites` WHERE `id` = {}".format(site))
                        url = cursor.fetchone()
                        pprint(url)
                        if url[0]:
                            urls = scan(url[0])
                            for page in urls:
                                sql = "SELECT `url` FROM `pages` WHERE `url` = '{}'".format(page)
                                res = cursor.execute(sql)
                                if not res:
                                    sql = "INSERT INTO `pages` (`site_id`, `url`, `code`, `visited`, `level`, `collected`) VALUES ({}, '{}', 200 ,1, 1, 0)".format(site, page)
                                    cursor.execute(sql)
                                    connection.commit()
                except Exception as e:
                    bot_error("!!! ПАУК !!! - Error %s" % (str(e)))
                    print("!!! ПАУК !!! - Error %s" % (str(e)))
                    pass

                finally:
                    connection.close()
                    urllib.request.urlopen(api)

        except Exception as e:
            bot_error("!!! ПАУК !!! - Error %s" % (str(e)))
            print("!!! ПАУК !!! - Error %s" % (str(e)))
            pass
            