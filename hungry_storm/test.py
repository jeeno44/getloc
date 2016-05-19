import json
import collections
from grab import Grab
g = Grab()
import time
import urllib.parse
start = time.time()

STOP_WORDS = ['mailto', 'redirect_to', 'youtube.com', 'uploads', 'upload',
              '(', '#', 'share', 'facebook.com', '.pdf', '..', '.ppt', '.jpg', 'redirect',
              'tel:', 'doc', 'docx', '.eps', '.cdr']

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

STARTING_URL = 'http://aispir.ru'

urls_queue = collections.deque()
urls_queue.append(STARTING_URL)
found_urls = set()
found_urls.add(STARTING_URL)
visited_urls = set()
c = 1
while len(urls_queue):
    url = urls_queue.popleft()
    try:
        g.go(url)
        c = c + 1
        if g.response.code < 400 and g.response.headers['Content-Type'].find('text/html') != -1 and g.response.url.startswith(STARTING_URL):
            print(str(c) + '. ' + url + ' ' + str(g.response.code))
            links = g.doc.select('//a[@href]')
            for link in links:
                href = prep(link.attr('href'))
                if href == False:
                    continue
                if href.startswith('http') == False:
                    href = STARTING_URL + '/' + href
                elif href.startswith('http') and href.startswith(STARTING_URL) == False:
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

#print(json.dumps(list(found_urls)))
print(len(found_urls))
print ("Elapsed Time: %ss" % (time.time() - start))