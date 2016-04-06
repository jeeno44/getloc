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


r = redis.StrictRedis(host='localhost', port=6379, db=0)

r.publish('collector', json.dumps({'site': 3, 'api': 'api.'}))
#r.publish('spider', json.dumps({'site': 3, 'api': 'api.'}))