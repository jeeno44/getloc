<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Site;
use App\Page;
use App\Block;
use Htmldom;

class TextsCollector extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $site;

    public function __construct(Site $site)
    {
        $this->site = $site;
    }

    public function handle()
    {
        set_time_limit(0);
        $pages = Page::where('site_id', $this->site->id)->where('collected', 0)->where('code', '<',  400)->where('visited', 1)->get();
        $tags = ['p', 'a', 'div', 'th', 'td', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'i', 'b', 'strong', 'li', 'pre', 'code', 'option', 'label', 'span'];
        foreach ($pages as $page) {
            $content = getPageContent($page->url);
            if (!empty($content)) {
                $html = new Htmldom($page->url);
                foreach ($tags as $tag) {
                    foreach($html->find($tag) as $element) {
                        $this->makeBlock($element, $page, $tag);
                    }
                }
                $page->collected = 1;
            } else {
                $page->code = 500;
            }
            $page->save();
        }
    }

    protected function makeBlock($element, $page, $type)
    {
        $element->plaintext = trim($element->plaintext);
        if (!empty($element->plaintext) && $element->plaintext == $element->innertext && $element->plaintext != '&nbsp;') {
            $block = Block::where('site_id', $this->site->id)->where('text', $element->plaintext)->first();
            if ($block == null) {
                $countSymbols = mb_strlen($element->plaintext, 'UTF-8');
                $countWords = $this->countWords($element->plaintext);
                $block = new Block([
                    'site_id'       => $this->site->id,
                    'text'          => $element->plaintext,
                    'type'          => $type,
                    'count_words'   => $countWords,
                    'count_symbols' => $countSymbols,
                ]);
                $block->save();
                $this->site->increment('count_words', $countWords);
                $this->site->increment('count_symbols', $countSymbols);
                $this->site->increment('count_blocks', 1);
            }
            if (!$page->hasBlock($block->id)) {
                $page->blocks()->attach($block->id);
            }
        }
    }

    protected function countWords($text)
    {
        return count(explode(' ', $text));
    }
}
