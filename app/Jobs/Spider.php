<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Site;
use App\Page;
use Htmldom;

class Spider extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $site;
    protected $stopWords = [];

    public function __construct(Site $site)
    {
        $this->site = $site;
        $this->stopWords = ['mailto', 'redirect_ro', 'youtube.com', 'uploads', 'upload', '(', '#', 'share', 'facebook.com', '..'];
    }

    public function handle()
    {
        set_time_limit(0);
        while(Page::where('site_id', $this->site->id)->where('visited', 0)->count() > 0) {
            $pages = Page::where('site_id', $this->site->id)->where('visited', 0)->get();
            foreach($pages as $page) {
                $answer = getPageContent($page->url);
                if (!empty($answer)) {
                    $html = new Htmldom($answer);
                    foreach ($html->find('a') as $element){
                        $href = $this->prepare($element->href);
                        $p = Page::where('url', $href)->where('site_id', $this->site->id)->first();
                        if ($p == null && !empty($href)) {
                            /**
                             * Внутри условия для того, чтобы не дергать лишний раз curl, если страница существует.
                             * Если её нет, тогда курлом проверяем код ответа и тип контента
                             */
                            $code = getPageCode($href);
                            if (!empty($code)) {
                                Page::create(['site_id' => $this->site->id, 'url' => $href, 'level' => $page->level + 1, 'code' => $code]);
                            }
                        }
                    }
                } else {
                    $page->code = 500;
                    $page->collected = 1;
                }
                $page->visited = 1;
                $page->save();
            }
        }
        \Event::fire('maps.done', $this->site);
    }

    protected function strPosInArr($text)
    {
        foreach ($this->stopWords as $word) {
            if (strpos($text, $word) !== false || strpos($text, $word) > 0) {
                return false;
            }
        }
        return true;
    }

    protected function prepare($url)
    {
        $url = trim($url, '#');
        $url = trim($url, '/');
        $url = str_replace('../', '', $url);
        if (empty($url)) {
            return null;
        }
        if ($this->strPosInArr('_'.$url) === false) { // чтобы strpos 0 не ловил
            return null;
        }
        if (mb_strpos($url, 'http') === false) {
            return $this->site->url.$url.'/';
        } elseif (mb_strpos($url, 'http') !== false && mb_strpos($url, $this->site->url) === false) {
            return null;
        }
        return $url.'/';
    }
}
