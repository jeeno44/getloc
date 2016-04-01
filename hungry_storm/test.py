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

db 		        = MySQLdb.connect(host="localhost", user="root", passwd="Ceknfyjd123321", db="getloc", charset='utf8')
cursor          = db.cursor()
trans_client    = 'blackgremlin2'
trans_secret    = 'SMnjwvLx0bB2u9Cn05K2vkTE1bSkX0'
translator 		= Translator(trans_client, trans_secret)

def translateBlock(block):
    translate = translator.translate(block[2].encode('utf-8'), lang_from='en', lang_to='ru')
    sql 	  = """INSERT INTO translates SET block_id = {id}, language_id = 1, `text` = "{text}", updated_at = NOW(), type_translate_id = 1, site_id = 2, count_words = {cc}""".format(
    				id=block[0], text=MySQLdb.escape_string(str(translate.encode('utf-8'))), cc=len(translate.split())
    			)
    cursor.execute(sql) #Lost connection to MySQL server during query
    

translator = Translator('blackgremlin2', 'SMnjwvLx0bB2u9Cn05K2vkTE1bSkX0+fsLp/23gsytU=')
pool       = ThreadPool(4)
sql        = 'SELECT * FROM blocks WHERE site_id = {projectID}'.format(projectID=2)

cursor.execute(sql)
blocks = cursor.fetchall()

results    = pool.map(translateBlock, blocks)
pool.close()
pool.join()