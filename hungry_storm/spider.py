import json
import collections
from grab import Grab
g = Grab()

STOP_WORDS = ['mailto', 'redirect_to', 'youtube.com', 'uploads', 'upload', '(', '#', 'share', 'facebook.com']

def prep(href):
    href = href.strip('/')
    if href == '':
        return False
    for br in STOP_WORDS:
        if (href.find(br) != -1):
            return False
    return href

STARTING_URL = 'http://sad.andrey-malygin.ru'

urls_queue = collections.deque()
urls_queue.append(STARTING_URL)
found_urls = set()
found_urls.add(STARTING_URL)
visited_urls = set()

while len(urls_queue):
    url = urls_queue.popleft()
    g.go(url)
    if g.response.code < 400 and g.response.headers['Content-Type'].find('text/html') != -1:
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


print(json.dumps(list(found_urls)))
