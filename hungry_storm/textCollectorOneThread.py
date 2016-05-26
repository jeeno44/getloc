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
import json
import re
from db_access import mysql_credentials

parseDocs = ['xls', 'xlsx', 'ppt', 'pptx', 'txt', 'odt', 'tif', 'jpeg', 'rtf', 'doc', 'docx', 'png', 'jpg', 'gif']

#------------------------------------------------------------------------------------------------------
# Настройки мускула и самого текст коллектора
#------------------------------------------------------------------------------------------------------

r = redis.StrictRedis(host='localhost', port=6379, db=0)

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

#------------------------------------------------------------------------------------------------------
# Функция делает перевод на нужные языки
#------------------------------------------------------------------------------------------------------

def translateBlock(block):
    global iBlockInsert, insertSQLTrans, loadSQL, langTo, loadSQL
    try:
        translate = translator.translate(block[2].encode('utf-8'), lang_from=fromLang, lang_to=langTo)
        if translate:
            sql = "({id}, {language_id}, '{text}', NOW(), NOW(), 1, {siteID}, {cc}, 1, 0, 0)".format(id=block[0], language_id=langID, siteID=siteID, text=MySQLdb.escape_string(str(translate.encode('utf-8'))), cc=len(translate.split()))
        else:
            sql = "({id}, {language_id}, '', NOW(), NOW(), 1, {siteID}, NULL, 1, 0, 0)".format(id=block[0], language_id=langID, siteID=siteID)
        loadSQL.append(insertSQLTrans + sql + ";")
    except Exception as exc:
        pass

def createEmptyTranslate(block):
    global iBlockInsert, insertSQLTrans, loadSQL, langTo
    loadSQL.append("({id}, {language_id}, '', NOW(), NOW(), 1, 1, 0, {pub}, 0)".format(id=block[0], language_id=langID, pub=auto_publishing))
    iBlockInsert += 1

    if len(loadSQL) >= maxBlockInsert:
        iBlockInsert = 0
        cursor.execute(insertSQLTrans + ','.join(loadSQL) + ";")
        loadSQL = []


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

def iri2uri(uri, encoding='utf-8'):
    scheme, authority, path, query, frag = urlparse.urlsplit(uri)
    scheme = scheme.encode(encoding)

    if ":" in authority:
        host, port = authority.split(":", 1)
        authority = host.encode('idna') + ":%s" % port
    
    path = urllib.quote(
      path.encode(encoding), 
      safe="/;%[]=:$&()+,!?*@'~"
    )
    query = urllib.quote(
      query.encode(encoding), 
      safe="/;%[]=:$&()+,!?*@'~"
    )
    frag = urllib.quote(
      frag.encode(encoding), 
      safe="/;%[]=:$&()+,!?*@'~"
    )

    return urlparse.urlunsplit((scheme, authority, path, query, frag))

#------------------------------------------------------------------------------------------------------
# Загружаем страницу
#------------------------------------------------------------------------------------------------------

def load_url(url, siteID, cursor, timeout):
    headers = { 'User-Agent' : 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36' }
    req = urllib2.Request(iri2uri(url), None, headers)
    response = urllib2.urlopen(req, timeout=timeout)
    html = response.read()
    if html:
        return html

#------------------------------------------------------------------------------------------------------
# Создаем блок и возвращаем insert_id
#------------------------------------------------------------------------------------------------------

def makeBlock(siteID, text, element, url):
    global countWords, countSymbols, countBlocks

    #block = cursor.execute('SELECT `text` FROM blocks WHERE `text` = "{text}"'.format(text=MySQLdb.escape_string(text.encode('utf8'))))

    text  = text.strip()
    
    if text not in issetBlocks:
        ccword = len(text.split())
        ccsymb = count_letters(text)
        sql    = """INSERT INTO blocks SET site_id = {site_id}, `text` = "{text}", 
                    `type` = "{type}", count_words = {ccword}, count_symbols = {ccsymb},
                    created_at = NOW(), updated_at = NOW(), enabled = {enable}""".format(site_id=siteID, text=MySQLdb.escape_string(text.encode('utf8')), 
                                                                                        type=MySQLdb.escape_string(element), ccword=ccword, ccsymb=ccsymb, enable=1)
        cursor.execute(sql)

        countWords      += ccword
        countSymbols    += ccsymb
        countBlocks     += 1

        issetBlocks.append(text)

        id = db.insert_id()
        blocksID[text] = id
        return id
    else:
        makePageBlock(urlPageID[str(url)], blocksID[text])
        return False

#------------------------------------------------------------------------------------------------------
# Парсим документы и картинки сайта, затем записываем их в отдельную таблицу
#------------------------------------------------------------------------------------------------------

def parseDocInSite(url, element):
    global docSQL

    docs = {}
    if element.name == 'a' and element.has_attr('href'):
        if element['href'].split(".")[-1] in parseDocs:
            url = urlparse.urljoin(domain, element['href'])
            docs = {'full_url': url.encode('utf8'), 'ftype': 'doc', 'link_text': element.getText().encode('utf8'), 'doc_type': element['href'].split(".")[-1].encode('utf8'), 'site_id': siteID}
    elif element.name == 'img' and element.has_attr('src'):
        if element['src'].split(".")[-1] in parseDocs:
            url = urlparse.urljoin(domain, element['src'])
            altString = ''
            if element.has_attr('alt'):
                altString = element['alt']
            docs = {'full_url': url.encode('utf8'), 'ftype': 'image', 'link_text': altString.encode('utf8'), 'doc_type': element['src'].split(".")[-1].encode('utf8'), 'site_id': siteID}
    else:
        pass

    if docs:
        docSQL.append(docs)

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
    sql    = """UPDATE sites SET count_blocks = count_blocks + {blocks}, count_words= count_words + {words}, updated_at = NOW(),
                count_symbols= count_symbols + {symbols}, updated_at = NOW() WHERE id = {siteID} LIMIT 1""".format(siteID=siteID, blocks=blocks, words=words, symbols=symbols)
    cursor.execute(sql)

#------------------------------------------------------------------------------------------------------
# Делаем связь block -> pageID
#------------------------------------------------------------------------------------------------------

def makePageBlock(pageID, blockID):
    sql    = "SELECT * FROM page_block WHERE page_id = {pageID} AND block_id = {blockID}".format(pageID=pageID, blockID=blockID)
    cursor.execute(sql)
    isset = cursor.fetchone()
    if isset is None:
        sql    = "INSERT INTO page_block SET page_id = {pageID}, block_id = {blockID}".format(pageID=pageID, blockID=blockID)
        cursor.execute(sql)

#------------------------------------------------------------------------------------------------------
# Ждем команды от редиса и начинаем потоковую обработку всех ссылок
# По-дефелту 100 потоков
#------------------------------------------------------------------------------------------------------

ps = r.pubsub()
ps.subscribe('textCollectorOneThread')
for item in ps.listen():
   if ( item['type'] == "message" ):
        start = time.time()
        urls  = []

        urlPageID = {}

        data_           = json.loads(item['data'].decode("utf-8"))
        if mysql_credentials['unix_socket']:
            db          = MySQLdb.connect(host=mysql_credentials['host'], user=mysql_credentials['user'], passwd=mysql_credentials['password'], db=mysql_credentials['db'], charset=mysql_credentials['charset'], unix_socket=mysql_credentials['unix_socket'])
        else:
            db          = MySQLdb.connect(host=mysql_credentials['host'], user=mysql_credentials['user'], passwd=mysql_credentials['password'], db=mysql_credentials['db'], charset=mysql_credentials['charset'])
        trans_client    = 'blackgremlin2'
        trans_secret    = 'SMnjwvLx0bB2u9Cn05K2vkTE1bSkX0+fsLp/23gsytU='
        
        cursor          = db.cursor()
        countPools      = 10
        countWords      = 0
        countSymbols    = 0
        countBlocks     = 0
        tags            = ['meta', 'title', 'p', 'a', 'div', 'th',
                           'td', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'i', 'b', 'strong', 'li', 'pre', 'code', 'option',
                           'label', 'span', 'button', 'input', 'button', 'img', 'textarea', 'font']
        siteID          = data_['site']
        auto_publishing = None
        auto_translate  = None
        fromLang        = None
        issetBlocks     = []
        blocksID        = {}

        maxBlockInsert  = 50
        iBlockInsert    = 0
        insertSQLTrans  = 'INSERT INTO translates (block_id, language_id, `text`, created_at, updated_at, type_translate_id, site_id, count_words, `enabled`, is_ordered, archive) VALUES '
        loadSQL         = []
        langTo          = ''
        langID          = 0
        translator      = None
        docSQL          = []

        db.autocommit(True)

        getSettingsProject(siteID)
        getAllBlocks(siteID)

        #------------------------------------------------------------------------------------------------------
        # Получаем все урлы проекта
        # И записываем их
        #------------------------------------------------------------------------------------------------------

        sql = 'SELECT * FROM pages WHERE site_id = {projectID} AND collected != 1 ORDER BY id DESC'.format(projectID=siteID)
        cursor.execute(sql)
        pages = cursor.fetchall()

        for page in pages:
            pageID, siteID, url, code, level, visited, collected, enabled, created_at, updated_at = page
            urls.append(str(url.encode('utf8')))
            urlPageID[str(url.encode('utf8'))] = pageID

        count = 0

        parsed_uri = urlparse.urlparse(urls[0])
        domain     = '{uri.scheme}://{uri.netloc}/'.format(uri=parsed_uri)

        print('В один поток принял, работаю!')

        #------------------------------------------------------------------------------------------------------
        # Запускаем потоки и bs4
        #------------------------------------------------------------------------------------------------------

        for url in urls:
            try:
                print(url)

                html = load_url(url, siteID, cursor, 10)
                soup = BeautifulSoup(html, 'html.parser')

                cursor.execute('UPDATE pages SET collected = 1 WHERE url = "{url}" AND site_id = {siteid}'.format(url=MySQLdb.escape_string(url), siteid=siteID))

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
                        if element.name == 'meta' and element.has_attr('name') and (element['name'].lower() == 'keywords' or element['name'].lower() == 'description'):
                            if element['content']:
                                block_id = makeBlock(siteID, element['content'], 'meta', url)
                                if block_id is not False:
                                    makePageBlock(getPageID(url, siteID), block_id)
                        elif element.name == 'title':
                            if element.string:
                                block_id = makeBlock(siteID, element.string, element.name, url)
                                if block_id:
                                    makePageBlock(getPageID(url, siteID), block_id)
                        elif element.name == 'img' and element.has_attr('alt'):
                            if element['alt'].isdigit() != True and element['alt']: 
                                block_id = makeBlock(siteID, element['alt'], element.name, url)
                                if block_id is not False:
                                    makePageBlock(getPageID(url, siteID), block_id)
                        elif element.name == 'input':
                            if element.has_attr('placeholder') and element['placeholder'].isdigit() != True and element['placeholder'] and element['type'] != 'hidden':
                                block_id = makeBlock(siteID, element['placeholder'], element.name, url)
                                if block_id is not False:
                                    makePageBlock(getPageID(url, siteID), block_id)
                            if element.has_attr('value') and element['value'].isdigit() != True and element['value'] and element['type'] != 'hidden':
                                block_id = makeBlock(siteID, element['value'], element.name, url)
                                if block_id is not False:
                                    makePageBlock(getPageID(url, siteID), block_id)
                        else:
                            if element.name == 'meta':
                                    continue                          

                            for str_ in element.findAll(text=True, recursive=False):
                                string = re.sub(' +',' ', str_)
                                if string.isdigit() != True and string: #Цифры нам нинужныыыы!
                                    block_id = makeBlock(siteID, string, element.name, url)
                                    if block_id is not False:
                                        makePageBlock(getPageID(url, siteID), block_id)


                        # Сначала чекаем на файлы и картинки
                        if element.name == 'img' or element.name == 'IMG' or element.name == 'a':
                            parseDocInSite(url, element)

                count += 1
                time.sleep(0.7)
                
                del html

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
                
        if count > 0:    
            finishStats(siteID, countWords, countSymbols, countBlocks)

        #------------------------------------------------------------------------------------------------------
        # Сохраняем все картинки, файлы, документы
        #------------------------------------------------------------------------------------------------------

        if docSQL:
            for doc in docSQL:
                cursor.execute('SELECT * FROM docs_sites WHERE site_id = {site_id} AND full_url = "{full_url}"'.format(site_id=doc['site_id'], full_url=doc['full_url']))
                docDB = cursor.fetchone()
                if docDB is None:
                    link_text = ''
                    if doc['link_text']:
                        link_text = MySQLdb.escape_string(str(doc['link_text']))

                    sql = """
                    INSERT INTO docs_sites (site_id, link_text, ftype, doc_type, full_url) VALUES ({site_id}, "{link_text}", "{ftype}", "{doc_type}", "{full_url}")
                    """.format(site_id=MySQLdb.escape_string(str(doc['site_id'])), link_text=link_text, ftype=MySQLdb.escape_string(str(doc['ftype'])),
                               doc_type=MySQLdb.escape_string(str(doc['doc_type'])), full_url=MySQLdb.escape_string(str(doc['full_url'])))
                    cursor.execute(sql)
                    #cursor.execute('INSERT INTO docs_sites (site_id, link_text, ftype, doc_type, full_url) VAALUES ({site_id}, "{link_text}", "{ftype}", "{doc_type}", "{full_url}")'
                    #    .format(site_id=MySQLdb.escape_string(doc['site_id']), link_text=MySQLdb.escape_string(doc['link_text']), ftype=MySQLdb.escape_string(doc['ftype']), 
                    #        doc_type=MySQLdb.escape_string(doc['doc_type']), full_url=MySQLdb.escape_string(doc['full_url'])))

        #------------------------------------------------------------------------------------------------------
        # Запускаем автоперевод блоков, тоже в потоках
        # Если была такая настройка у проекта
        #------------------------------------------------------------------------------------------------------

        
        translator = Translator(trans_client, trans_secret)
        langs      = getLangsProject(siteID)
        
        sql        = 'SELECT * FROM blocks WHERE site_id = {projectID}'.format(projectID=siteID)

        cursor.execute(sql)
        blocks = cursor.fetchall()
        for lang in langs:
            langTo  = lang[3]
            langID  = lang[0]
            pool    = ThreadPool(2)
            results = pool.map(translateBlock, blocks)
            pool.close()
            pool.join()

        for sql in loadSQL:
            cursor.execute(sql)
        cursor.close()

        del soup
        del issetBlocks
        del urls
        del db

        site = data_['site']
        api  = 'http://' + data_['api'] + '/python/collector/' + str(site)
        urllib2.urlopen(api, timeout=10)

        print "Страниц %s" % count
        print "Отработал за: %ss" % (time.time() - start)
