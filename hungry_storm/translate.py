# -*- coding: utf-8
#!/usr/bin/python

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

r = redis.StrictRedis(host='localhost', port=6379, db=0)
ps = r.pubsub()
ps.subscribe('translater')


def getTranslate(translateID, translator, originalText, fromLang, langTo):
    translate = translator.translate(originalText.encode('utf-8'), lang_from=fromLang, lang_to=langTo)
    if translate:
        return 'UPDATE translates SET `text` = "{text}", updated_at = NOW(), type_translate_id = 1 WHERE id = {id} LIMIT 1'.format(id=translateID, text=MySQLdb.escape_string(str(translate.encode('utf-8'))))

for item in ps.listen():
   if ( item['type'] == "message" ):
        start 			= time.time()
        data_  			= json.loads(item['data'].decode("utf-8"))
        db     			= MySQLdb.connect(host=mysql_credentials['host'], user=mysql_credentials['user'], passwd=mysql_credentials['password'], db=mysql_credentials['db'], charset=mysql_credentials['charset'])
        trans_client    = 'blackgremlin2'
        trans_secret    = 'SMnjwvLx0bB2u9Cn05K2vkTE1bSkX0+fsLp/23gsytU='
        cursor          = db.cursor()
        translator 		= Translator(trans_client, trans_secret)
        ids				= data_['translatesID']
        fromLang        = data_['langFrom']
        langTo          = data_['langTo']
        dataID          = dict()
        SQLTranslates   = []

        cursor.execute('SELECT b.text, t.id FROM translates t LEFT JOIN blocks b ON (b.id = t.block_id) WHERE t.id IN ('+','.join(str(v) for v in ids)+')')
        
        dbIDs  = cursor.fetchall()
        dataID = {v[1]:v[0] for v in dbIDs}

        db.autocommit(True)

        with concurrent.futures.ThreadPoolExecutor(max_workers=100) as executor:
            future_to_translate = {executor.submit(getTranslate, id, translator, dataID[id], fromLang, langTo): id for id in ids }
            for future in concurrent.futures.as_completed(future_to_translate):
                id = future_to_translate[future]
                try:
                    translateSQL = future.result()
                    if translateSQL:
                        SQLTranslates.append(translateSQL)

                except Exception as exc:
                    print '%r generated an exception: %s, %s' % (url, exc, sys.exc_info()[-1].tb_lineno)
                    pass    
                    
        for sql in SQLTranslates:
            cursor.execute(sql)

        del db

        print "Отработал за: %ss" % (time.time() - start)
                    