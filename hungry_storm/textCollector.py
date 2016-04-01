# -*- coding: utf-8
#!/usr/bin/python

from bs4 import BeautifulSoup
from bs4 import Comment
from mstranslator import Translator
from pprint import pprint

import MySQLdb
import redis
import concurrent.futures
from multiprocessing.dummy import Pool as ThreadPool
import urllib2
import urllib
import time
import urlparse
import collections
import string
import sys

#------------------------------------------------------------------------------------------------------
# Настройки мускула и самого текст коллектора
#------------------------------------------------------------------------------------------------------

db 		        = MySQLdb.connect(host="localhost", user="root", passwd="Ceknfyjd123321", db="getloc", charset='utf8')
trans_client    = 'blackgremlin2'
trans_secret    = 'SMnjwvLx0bB2u9Cn05K2vkTE1bSkX0'
r               = redis.StrictRedis(host='localhost', port=6379, db=0)
cursor          = db.cursor()
countPools      = 100
countWords      = 0
countSymbols    = 0
countBlocks     = 0
tags            = ['title', 'p', 'a', 'div', 'th',
                   'td', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'i', 'b', 'strong', 'li', 'pre', 'code', 'option',
                   'label', 'span', 'button', 'meta', 'input', 'button', 'img', 'textarea', 'font']
siteID          = 2
auto_publishing = None
auto_translate  = None
fromLang        = None
issetBlocks     = []

db.autocommit(True)

#------------------------------------------------------------------------------------------------------
# Получаем настройки проекта
#------------------------------------------------------------------------------------------------------

def getSettingsProject(projectID):
    global auto_publishing, auto_translate, fromLang
    sql = 'SELECT auto_publishing, auto_translate FROM sites_settings WHERE site_id = {projectID}'.format(projectID=projectID)
    cursor.execute(sql)
    auto_publishing, auto_translate = cursor.fetchall()[0]
    sql = 'SELECT l.short FROM sites s LEFT JOIN languages l ON (l.id = s.language_id) WHERE s.id = {projectID}'.format(projectID=projectID)
    cursor.execute(sql)
    fromLang = cursor.fetchone()[0]

def translateBlock(blockID, text, fromlang, to, langID):
    #translator = Translator(trans_client, trans_secret)
    print(blockID)
    pass

#------------------------------------------------------------------------------------------------------
# Получаем языки проекта
#------------------------------------------------------------------------------------------------------

def getLangsProject(projectID):
    sql = 'select l.* from site_language sl left join languages l ON (l.id = sl.language_id) where sl.site_id = {projectID}'.format(projectID=projectID)
    cursor.execute(sql)
    return cursor.fetchall()

#------------------------------------------------------------------------------------------------------
# Получаем все блоки в переменную, затем смотрим по ней блоки
#------------------------------------------------------------------------------------------------------

def getAllBlocks(projectID):
    global issetBlocks
    sql = 'SELECT text FROM blocks where site_id = {projectID}'.format(projectID=projectID)
    cursor.execute(sql)
    for block in cursor.fetchall():
        issetBlocks.append(block[0])

#------------------------------------------------------------------------------------------------------
# Кол. слов в блоке
#------------------------------------------------------------------------------------------------------

def count_letters(word):
    return len(word) - word.count(' ')

#------------------------------------------------------------------------------------------------------
# Работаем со всеми типами УРЛа
#------------------------------------------------------------------------------------------------------

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

#------------------------------------------------------------------------------------------------------
# Загружаем страницу
#------------------------------------------------------------------------------------------------------

def load_url(url, timeout):
    response = urllib2.urlopen(iri2uri(url), timeout=timeout)
    return response.read()

#------------------------------------------------------------------------------------------------------
# Создаем блок и возвращаем insert_id
#------------------------------------------------------------------------------------------------------

def makeBlock(siteID, text, element):
    global countWords, countSymbols, countBlocks

    text  = text.strip()
    #block = cursor.execute('SELECT `text` FROM blocks WHERE `text` = "{text}"'.format(text=MySQLdb.escape_string(text.encode('utf8'))))

    if text not in issetBlocks:
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

        issetBlocks.append(text)

        return db.insert_id()
    else:
        return False

#------------------------------------------------------------------------------------------------------
# Получаем айди страницы с нужного URL'а, TODO: тоже переделать на переменную
#------------------------------------------------------------------------------------------------------

def getPageID(url, siteID):
    block = cursor.execute('SELECT `id` FROM pages WHERE site_id = {siteID} AND url = "{url}"'.format(siteID=siteID, url=MySQLdb.escape_string(url)))
    return cursor.fetchone()[0]

#------------------------------------------------------------------------------------------------------
# Обновляем статистику о проекте
#------------------------------------------------------------------------------------------------------

def finishStats(siteID, words, symbols, blocks):
    sql    = """UPDATE sites SET count_blocks = {blocks}, count_words={words}, updated_at = NOW(),
                count_symbols={symbols}, updated_at = NOW() WHERE id = {siteID} LIMIT 1""".format(siteID=siteID, blocks=blocks, words=words, symbols=symbols)
    cursor.execute(sql)

#------------------------------------------------------------------------------------------------------
# Делаем связь block -> pageID
#------------------------------------------------------------------------------------------------------

def makePageBlock(pageID, blockID):
    block = cursor.execute('SELECT `block_id` FROM page_block WHERE block_id = {blockID}'.format(blockID=blockID))
    block = cursor.fetchone()
    if block is None:
        sql    = "INSERT INTO page_block SET page_id = {pageID}, block_id = {blockID}".format(pageID=pageID, blockID=blockID)
        cursor.execute(sql)
    else:
        return False

#------------------------------------------------------------------------------------------------------
# Ждем команды от редиса и начинаем потоковую обработку всех ссылок
# По-дефелту 100 потоков
#------------------------------------------------------------------------------------------------------

getSettingsProject(siteID)
getAllBlocks(siteID)

start = time.time()
urls  = []

#ps = r.pubsub()
#ps.subscribe('spider_listen')

#for item in ps.listen():
#   if (item['type'] == "message"):
#       print (item['data'].decode("utf-8"))

#------------------------------------------------------------------------------------------------------
# Получаем все урлы проекта
# И записываем их
#------------------------------------------------------------------------------------------------------

sql = 'SELECT * FROM pages WHERE site_id = {projectID} AND collected != 0'.format(projectID=siteID)
cursor.execute(sql)
pages = cursor.fetchall()

for page in pages:
    pageID, siteID, url, code, level, visited, collected, created_at, updated_at = page
    urls.append(str(url))

count = 0

#------------------------------------------------------------------------------------------------------
# Запускаем потоки и bs4
#------------------------------------------------------------------------------------------------------

with concurrent.futures.ThreadPoolExecutor(max_workers=countPools) as executor:
    future_to_url = {executor.submit(load_url, url, 60): url for url in urls }
    for future in concurrent.futures.as_completed(future_to_url):
        url = future_to_url[future]
        try:
            html = future.result()
            soup = BeautifulSoup(html, 'html.parser')

            #-------------------------------------------
            # Вырезаем скрипты, ксс и комменты
            #-------------------------------------------

            for script in soup(["script", "style"]):
                script.extract()
            
            comments = soup.findAll(text=lambda text:isinstance(text, Comment))
            [comment.extract() for comment in comments]    

            #-------------------------------------------
            # Начинаем парсить и создавать теги
            #-------------------------------------------

            for tag in tags:
                for element in soup.find_all(tag):
                    string = ''
                    if element.name == 'meta' and 'name' in element and (element['name'] == 'keywords' or element['name'] == 'description'):
                        block_id = makeBlock(siteID, element['content'], 'meta')
                        if block_id is not False:
                            makePageBlock(getPageID(url, siteID), block_id)
                    elif element.name == 'title':
                        block_id = makeBlock(siteID, element.string, element.name)
                        if block_id:
                            makePageBlock(getPageID(url, siteID), block_id)
                    elif element.name == 'img' and element.has_attr('alt'):
                        block_id = makeBlock(siteID, element['alt'], 'meta')
                        if block_id is not False:
                            makePageBlock(getPageID(url, siteID), block_id)
                    elif element.name == 'input':
                        if element.has_attr('placeholder'):
                            block_id = makeBlock(siteID, element['placeholder'], element.name)
                            if block_id is not False:
                                makePageBlock(getPageID(url, siteID), block_id)
                        if element.has_attr('value'):
                            block_id = makeBlock(siteID, element['value'], element.name)
                            if block_id is not False:
                                makePageBlock(getPageID(url, siteID), block_id)
                    else:
                        if element.name == 'meta':
                            continue

                        for str_ in element.findAll(text=True, recursive=False):
                            string += (str_)

                        string = string.strip()    
                        if string.isdigit() != True and string: #Цифры нам нинужныыыы!
                            block_id = makeBlock(siteID, string, element.name)
                            if block_id is not False:
                                makePageBlock(getPageID(url, siteID), block_id)

        except Exception as exc:
            print '%r generated an exception: %s, %s' % (url, exc, sys.exc_info()[-1].tb_lineno)
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

#------------------------------------------------------------------------------------------------------
# Запускаем автоперевод блоков, тоже в потоках
# Если была такая настройка у проекта
#------------------------------------------------------------------------------------------------------

if auto_translate:
    translator = Translator('blackgremlin2', 'SMnjwvLx0bB2u9Cn05K2vkTE1bSkX0+fsLp/23gsytU=')
    langs      = getLangsProject(siteID)
    pool       = ThreadPool(4)
    sql        = 'SELECT * FROM blocks WHERE site_id = {projectID}'.format(projectID=siteID)

    cursor.execute(sql)
    blocks = cursor.fetchall()

    results    = pool.map(translateBlock, blocks)
    pool.close()
    pool.join()

    #for lang in langs:
        #short = lang[4]
        #multiprocessing.Process(target=getFollowers, args=(self.username,self.twitch_token, self.token,self,))

auto_publishing = None
auto_translate  = None
fromLang        = None
issetBlocks     = []

print count
print "Elapsed Time: %ss" % (time.time() - start)

	