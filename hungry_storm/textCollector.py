# -*- coding: utf-8
#!/usr/bin/python

from bs4 import BeautifulSoup
import MySQLdb
import redis
import concurrent.futures
import urllib2
import urllib
import time
import urlparse
from pprint import pprint
import collections
import string
import sys

#------------------------------------------------------------------------------------------------------
# Настройки мускула и самого текст коллектора
#------------------------------------------------------------------------------------------------------

db 		        = MySQLdb.connect(host="localhost", user="root", passwd="Ceknfyjd123321", db="getloc", charset='utf8')
r               = redis.StrictRedis(host='localhost', port=6379, db=0)
cursor          = db.cursor()
countPools      = 10
countWords      = 0
countSymbols    = 0
countBlocks     = 0
tags            = ['title', 'p', 'a', 'div', 'th',
                   'td', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'i', 'b', 'strong', 'li', 'pre', 'code', 'option',
                   'label', 'span', 'button', 'meta', 'input', 'button', 'img', 'textarea']
siteID          = 4

db.autocommit(True)

#------------------------------------------------------------------------------------------------------
# Получаем настройки проекта
#------------------------------------------------------------------------------------------------------

sql = 'SELECT auto_publishing, auto_translate FROM sites_settings WHERE site_id = 4'
cursor.execute(sql)
auto_publishing, auto_translate = cursor.fetchall()[0]

#------------------------------------------------------------------------------------------------------
# Магические функции для работы коллектора
#------------------------------------------------------------------------------------------------------

def count_letters(word):
    return len(word) - word.count(' ')

def iri2uri(uri):
    (scheme, authority, path, query, fragment) = urlparse.urlsplit(uri)
    if fragment == '' and query == '' and path == '/':
        path = ''
    authority = authority.encode('idna').encode('utf8')
    path = urllib.quote(urllib.unquote(path.encode('utf8')), safe="%/:=&?~#+!$,;'@()*[]")
    query = urllib.quote(query.encode('utf8'), safe="%/:=&?~#+!$,;'@()*[]")
    fragment = urllib.quote(fragment.encode('utf8'), safe="%/:=&?~#+!$,;'@()*[]")
    uri = urlparse.urlunsplit((scheme, authority, path, query, fragment))
    uri = uri.encode('utf8')
    return uri

def load_url(url, timeout):
    response = urllib2.urlopen(iri2uri(url), timeout=timeout)
    return response.read()

def makeBlock(siteID, text, element):
    global countWords, countSymbols, countBlocks

    text  = text.strip()
    block = cursor.execute('SELECT `text` FROM blocks WHERE `text` = "{text}"'.format(text=MySQLdb.escape_string(text.encode('utf8'))))

    if cursor.fetchone() is None:
        ccword = len(text.split())
        ccsymb = count_letters(text)
        sql    = """INSERT INTO blocks SET site_id = {site_id}, `text` = "{text}", 
                    `type` = "{type}", count_words = {ccword}, count_symbols = {ccsymb},
                    created_at = NOW(), updated_at = NOW(), enabled = {enable}""".format(site_id=siteID, text=MySQLdb.escape_string(text.encode('utf8')), 
                                                                                        type=MySQLdb.escape_string(element), ccword=ccword, ccsymb=ccsymb, enable=auto_publishing)
        cursor.execute(sql)

        countWords      += ccword
        countSymbols    += ccsymb
        countBlocks     += 1

        return db.insert_id()
    else:
        return False

def getPageID(url, siteID):
    block = cursor.execute('SELECT `id` FROM pages WHERE site_id = {siteID} AND url = "{url}"'.format(siteID=siteID, url=MySQLdb.escape_string(url)))
    return cursor.fetchone()[0]

def finishStats(siteID, words, symbols, blocks):
    sql    = """UPDATE sites SET count_blocks = {blocks}, count_words={words}, 
                count_symbols={symbols}, updated_at = NOW() WHERE id = {siteID} LIMIT 1""".format(siteID=siteID, blocks=blocks, words=words, symbols=symbols)
    cursor.execute(sql)


def makePageBlock(pageID, blockID):
    block = cursor.execute('SELECT `block_id` FROM page_block WHERE block_id = {blockID}'.format(blockID=blockID))
    block = cursor.fetchone()
    if block is None:
        sql    = "INSERT INTO page_block SET page_id = {pageID}, block_id = {blockID}".format(pageID=pageID, blockID=blockID)
        print(sql)
        cursor.execute(sql)
    else:
        return False

#------------------------------------------------------------------------------------------------------
# Ждем команды от редиса и начинаем потоковую обработку всех ссылок
# По-дефелту 1к потоков
#------------------------------------------------------------------------------------------------------

start = time.time()
urls  = []

#ps = r.pubsub()
#ps.subscribe('spider_listen')

#for item in ps.listen():
#   if (item['type'] == "message"):
#       print (item['data'].decode("utf-8"))

sql = 'SELECT * FROM pages WHERE site_id = 4 AND collected != 0'
cursor.execute(sql)
pages = cursor.fetchall()

for page in pages:
    pageID, siteID, url, code, level, visited, collected, created_at, updated_at = page
    urls.append(str(url))

count = 0

with concurrent.futures.ThreadPoolExecutor(max_workers=countPools) as executor:
    future_to_url = {executor.submit(load_url, url, 60): url for url in urls }
    for future in concurrent.futures.as_completed(future_to_url):
        url = future_to_url[future]
        try:
            html = future.result()
            soup = BeautifulSoup(html, 'html.parser')

            for script in soup(["script", "style"]):
                script.extract()

            for tag in tags:
                for element in soup.find_all(tag):
                    if element.name == 'meta' and 'name' in element and (element['name'] == 'keywords' or element['name'] == 'description'):
                        block_id = makeBlock(siteID, element['content'], 'meta')
                        if block_id is not False:
                            makePageBlock(getPageID(url, siteID), block_id)
                    elif element.name == 'title':
                        block_id = makeBlock(siteID, element.string, element.name)
                        if block_id:
                            makePageBlock(getPageID(url, siteID), block_id)
                    else:
                        if element.contents:
                            print(element.contents[0])

        except Exception as exc:
            print '%r generated an exception: %s, %s, %s' % (url, exc, sys.exc_info()[-1].tb_lineno, element.name)
            pass
        except urllib2.HTTPError as e:
            print(e.code)
            print(url)
        except urllib2.URLError as e:
            print 'We failed to reach a server.'
            print 'Reason: ', e.reason
        else:
            #print '"%s" fetched in %ss' % (url,(time.time() - start))
            pass
        count += 1

    finishStats(siteID, countWords, countSymbols, countBlocks)

print count
print "Elapsed Time: %ss" % (time.time() - start)

	