import redis
import json
import collections
from grab import Grab
import time
import pymysql
import urllib.request

start = time.time()
r = redis.Redis()
ps = r.pubsub()
ps.subscribe('spider')
STOP_WORDS = ['mailto', 'redirect_to', 'youtube.com', 'uploads', 'upload', '(', '#', 'share', 'facebook.com', '.pdf', '..', '.ppt', '.jpg']

def prep(href):
    href = href.strip('/')
    if href == '':
        return False
    for br in STOP_WORDS:
        if (href.find(br) != -1):
            return False
    return href

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
            if g.response.code < 400 and g.response.headers['Content-Type'].find('text/html') != -1:
                #print(str(cn) + '. ' + url)
                #cn += 1
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
    return found_urls


for item in ps.listen():
   if (item['type'] == "message"):
       try:
           data = json.loads(item['data'].decode("utf-8"))
           site = data['site']
           api  = 'http://' + data['api'] + '/python/map-done/' + str(site)
           connection = pymysql.connect(host='localhost', user='root', password='fastdick228', db='getloc', charset='utf8', unix_socket="/var/run/mysqld/mysqld.sock")
           try:
               with connection.cursor() as cursor:
                   sql = "SELECT `url`, `secret` FROM `sites` WHERE `id` = %s"
                   cursor.execute(sql, site)
                   url = cursor.fetchone()
                   if url[0]:
                       urls = scan(url[0])
                       for page in urls:
                           sql = "SELECT `url` FROM `pages` WHERE `url` = %s"
                           res = cursor.execute(sql, page)
                           if not res:
                               sql = "INSERT INTO `pages` (`site_id`, `url`, `code`, `visited`, `level`, `collected`) VALUES (%s, %s, 200 ,1, 1, 0)"
                               cursor.execute(sql, (site, page))
                               connection.commit()

           finally:
               connection.close()
           urllib.request.urlopen(api)
       except:
           pass