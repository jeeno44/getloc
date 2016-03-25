<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Site;
use App\Page;
use App\Block;
use Htmldom;

class TextsCollector extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * @var    object
     * @access protected
     */

    protected $site;

    /**
     * Тэги, которые нужно прочекать на несколько параметров
     *
     * @var    array
     * @access private
     */

    private $need_check_attr = [
        'input' => array('placeholder', 'value'),
        'a' => array('title'),
        'img' => array('alt'),
        'button' => array('value'),
        'meta' => array('keywords', 'description')
    ];

    /**
     * Тэги, которые мы будем искать
     *
     * @var    array
     * @access private
     */

    private $tags = ['title', 'p', 'a', 'div', 'th',
        'td', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'i', 'b', 'strong', 'li', 'pre', 'code', 'option',
        'label', 'span', 'button', 'meta', 'input', 'button', 'img', 'textarea', 'font'
    ];

    /**
     * @param object Site $site
     * @return object TextsCollector
     * @access public
     */

    public function __construct(Site $site)
    {
        $this->site = $site;
    }

    /**
     * Выполняем работу, поиск тегов и их последующее создание в блоки
     *
     * @param  void
     * @return mixed
     * @access public
     */

    public function handle()
    {
        set_time_limit(0);
        $pages = Page::where('site_id', $this->site->id)->where('collected', 0)->where('code', '<', 400)->where('visited', 1)->get();

        foreach ($pages as $page) {
            $content = getPageContent($page->url);
            if (strpos($content, $this->site->secret) === false && $this->site->demo == 0) {
                 //Если на сайте не найден секрет кей, игнорим страницу
                $page->code = 1000;
                $page->save();
                continue;
            }
            if (!empty($content)) {
                $html = new Htmldom($content);
                foreach ($this->tags as $tag) {
                    foreach ($html->find($tag) as $element) {
                        $this->makeBlock($element, $page, $tag);
                    }
                }
                $this->scanCurveTexts($page, $content);
                $page->collected = 1;
            } else {
                $page->code = 500;
                $page->collected = 1;
            }
            $page->save();
        }

        \Event::fire('site.done', $this->site);
    }

    /**
     * Создаем блок с DOM-дерева страницы сайта
     *
     * @param  object $element
     * @param  object $page
     * @param  string $type
     * @return void
     * @access protected
     */

    protected function makeBlock($element, $page, $type)
    {
        #--------------------------------------------------------------------
        # Создание "проблемных" тегов
        #--------------------------------------------------------------------

        if (array_key_exists($type, $this->need_check_attr)) {
            if ($type == 'meta') {
                if (strtolower($element->name) == 'description' || strtolower($element->name) == 'keywords') {
                    $this->createBlock($element->content, $page, $type);
                    return;
                }
            } elseif ($type == 'input') {
                foreach ($this->need_check_attr[$type] as $attr) {
                    if ($element->{$attr} && $element->type != 'hidden') {
                        if ($plaintext = $element->{$attr}) {
                            $this->createBlock($plaintext, $page, $type);
                        }
                    }
                }
            } else {
                if ($type != 'meta' && $type != 'input') {
                    foreach ($this->need_check_attr[$type] as $attr) {
                        if ($element->{$attr}) {
                            if ($plaintext = $element->{$attr}) {
                                $this->createBlock($plaintext, $page, $type);
                            }
                        }
                    }
                }
            }
        }

        #--------------------------------------------------------------------
        # Создание "нормальных" тегов
        #--------------------------------------------------------------------

        $element->plaintext = trim($element->plaintext);
        $element->innertext = trim($element->innertext);

        if (!empty($element->plaintext) && $element->plaintext == $element->innertext && $element->plaintext != '&nbsp;') {
            $this->createBlock($element->plaintext, $page, $type);
        }
    }

    /**
     * Считаем слова
     *
     * @param  string $text
     * @return int
     * @access protected
     */

    protected function countWords($text)
    {
        return count(explode(' ', $text));
    }

    /**
     * Эта функция нужна для создания блоков для атрибутов
     * Например таких как: input, meta
     *
     * @param  string $text
     * @param  object $page
     * @param  string $type
     * @return boolean
     * @access public
     */

    private function createBlock($text, $page, $type)
    {
        $text = trim(strip_tags($text));

        if (!$text || $text == '&nbsp;' || !$this->isExistsAlpha($text)) {
            return false;
        }

        $block = Block::where('site_id', $this->site->id)->where('text', $text)->first();

        if ($block == null) {
            $countSymbols = mb_strlen($text, 'UTF-8');
            $countWords = $this->countWords($text);

            $block = new Block([
                'site_id' => $this->site->id,
                'text' => $text,
                'type' => $type,
                'count_words' => $countWords,
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

        return true;
    }

    public function scanCurveTexts($page, $content)
    {
        $pattern = '/>[a-zа-я0-9\.\,\s\;\:\?\$\%\№\"«»\+\-\!\(\)]+</ui';
        preg_match_all($pattern, $content, $matches);
        foreach ($matches[0] as $key => $value) {
            $item = trim($value, '><');
            $item = trim($item, ',.!?\\/*+-=_#@');
            if (!empty($item)) {
                $item = str_replace(["\r", "\n"], ' ', $item);
                $item = trim($item);
                $this->createBlock($item, $page, 'curve');
            }
        }
    }

    /**
     * Есть ли в тексте буквы
     * @param string $text
     * @return bool
     */
    private function isExistsAlpha($text = '') {
        preg_match_all('/[a-zа-я]/ui', $text, $matches);
        if (!$matches[0]) {
            return false;
        }
        return true;
    }

}

?>