<?php
/**
 * +--------------------------------------------------------------------------
 * |   get-loc.ru
 * |   =============================================
 * |   by Sultanov Denis aka DenSul aka Mio
 * |   (c) 2016
 * |   http://vk.com/programmers
 * |   =============================================
 * |   Web: http://get-loc.ru/
 * |   Email: <sultanden@gmail.com>
 * |   TODO: ДЕЛЕНИЕ НА НОЛЬ, проверка на наличие настройки, добавить проверку на наличие сайта везде
 * +---------------------------------------------------------------------------
 */

namespace App\Http\Controllers;

use App\Events\Event;
use App\HistoryPhrase;
use App\Site,
    App\Page,
    URL,
    Session,
    DB,
    App\Block,
    App\Translate,
    App\TypeTranslate,
    App\Language,
    Illuminate\Http\Request;
use Carbon\Carbon;

class AccountController extends Controller
{

    /**
     * @var  array
     */

    private $sites = array();

    /**
     * Узнаем, что за юзер
     *
     * @param  void
     * @return object class AccountController
     * @access public
     */

    public function __construct()
    {
        parent::__construct();
        $this->sites = Site::where('user_id', $this->user->id)->orderBy('url')->get(); //TODO: Команды
        \View::share('sites', $this->sites);
    }

    /**
     * Страница выбора проектов
     *
     * @param  void
     * @return \Illuminate\Http\Response
     * @access public
     */

    public function selectProject()
    {
        $mySites = $this->sites;
        Session::remove('projectID');
        return view('account.selectProject', compact('mySites'));
    }

    /**
     * Установка выбраного проекта
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @access public
     */

    public function setProject($id)
    {
        // Проверка прав на сайт, TODO: команды
        if ( Site::where('id', $id)->where('user_id', $this->user->id)->first() )
          {
            Session::set('projectID', $id);
            return redirect()->route('main.account.overview');        
          } 
        else 
            return redirect()->route('main.account.selectProject');
    }

    /**
     * Обзор проекта.
     * Метод "по-дефелту".
     * Выводим юзеру, сколько страниц в проекте, кол. фраз (на всех языках).
     * Выводим некоторые настройки проекта.
     * Немного статистики.
     *
     * @param  void
     * @return string view
     * @access public
     */

    public function projectOverview(Request $request)
    {
        $siteID     = Session::get('projectID');
        $site       = Site::find($siteID);
        $ccBlocks   = Block::where('site_id', $siteID)->count();
        
        if ( !$siteID || !$site || $ccBlocks == 0 ) 
          {
            Session::remove('projectID');
            return redirect(URL::route('main.account.selectProject'));
          }
          
        if ( Page::where('site_id', $siteID)->count() == Page::where('site_id', $siteID)->where('collected', 1)->count() )
          {
            $stats = array(
                'ccBlocks'  => Block::where('site_id', $siteID)->count(),
                'ccPages'   => Page::where('site_id', $siteID)->count(),
                'listLangs' => $site->languages()->where('enabled', 1)->orderBy('name')->get(),
                'lineGraph' => $this->lineStatistics($siteID, $ccBlocks),
                'langStats' => $this->getStatusLangs($siteID, $ccBlocks)
            );
            
            $site_settings = DB::table('sites_settings')->where('site_id', $siteID)->first();
            return view('account.overview', compact('sites', 'stats', 'site', 'site_settings'));
          }
          
        $pages = $site->pages()->paginate(20);
        return view('account.waiting', compact('sites', 'site', 'pages'));
    }

    /**
     * Получаем статистику по направлению переведовов
     *
     * @param  int $siteID
     * @param  int $allCountBlocks
     * @return array
     * @access public
     */

    private function getStatusLangs($siteID, $allCountBlocks)
    {
        $stats = array();
        $langs = DB::table('site_language')->where('site_language.site_id', $siteID)
                                           ->leftJoin('languages', 'languages.id', '=', 'site_language.language_id')
                                           ->orderBy('site_language.enabled', 'desc')
                                           ->select('site_language.language_id as id', 'site_language.enabled', 'languages.name', 'languages.short', 'languages.icon_file')
                                           ->get();

        foreach ( $langs as $lang )
        {
            $ccTranslate = Translate::where('site_id', $siteID)->where('language_id', $lang->id)->whereNotNull('type_translate_id')->count();
            $graph       = round(($ccTranslate / $allCountBlocks) * 100);
            
            $stats[$lang->short] = array('name' => $lang->name, 'icon' => $lang->icon_file, 'enabled' => $lang->enabled,
                                         'per' => $graph, 'cc' => $ccTranslate, 'ccb' => $allCountBlocks);
        }

        return $stats;
    }

    /**
     * Получаем статистику для графика
     *
     * @param  int $siteID
     * @param  int $allCountBlocks
     * @return mixed
     * @access private
     */

    private function lineStatistics($siteID, $allCountBlocks)
    {
        $data = array();
        $langs = Site::find($siteID)->languages()->where('enabled', 1)->orderBy('name')->get();

        foreach ( $langs as $lang ) 
        {
            $stats = array();
            
            $stats['notLangTrans'] = Translate::where('site_id', $siteID)->where('language_id', $lang->id)->where('type_translate_id', NULL)->count(); //Не переведено в этом языке
            $dynamicStats          = DB::table('translates')->join('types_translates', 'translates.type_translate_id', '=', 'types_translates.id')
                                                            ->select('types_translates.name', DB::raw('count(*) as cc'))
                                                            ->where('site_id', $siteID)
                                                            ->where('language_id', $lang->id)
                                                            ->groupBy('translates.type_translate_id')
                                                            ->lists('cc', 'types_translates.name'); //Остальные типы
            $_lines                = array_merge($dynamicStats, $stats);
            $lines                 = array();
            $iter                  = 1;

            foreach ( $_lines as $key => $line )
            {
                if ( $allCountBlocks == 0 )
                    continue;

                if ( $key == 'notLangTrans' ) 
                    $graph = array('cc' => $line, 'i' => '4', 'name' => 'Не переведено', 'per' => round(($line / $allCountBlocks) * 100));
                else 
                  {
                    $graph = array('cc' => $line, 'i' => $iter, 'name' => $key, 'per' => round(($line / $allCountBlocks) * 100));
                    $iter++;
                  }

                $lines[] = $graph;
            }

            $data[$lang->name] = $lines;
        }

        return $data;

    }

    /**
     * Делаем автоматический перевод проекта | настройки проекта [AJAX]
     *
     * @param  Request $request
     * @return string
     * @access public
     */

    public function setAutoTranslate(Request $request)
    {
        $siteID = Session::get('projectID');
        $site = Site::find($siteID);

        if ( !$siteID || !$site ) 
            return abort(403, 'Need select project');
        
        $status = (DB::table('sites_settings')->where('site_id', $siteID)->first()->auto_translate == 1) ? 0 : 1;

        DB::table('sites_settings')->where('site_id', $siteID)->update(array('auto_translate' => $status));

        if ( $status ) 
            return trans('account.successAutoTranslate');
        else 
            return trans('account.failAutoTranslate');
        
    }

    /**
     * Автопубликация блоков проекта | настройки проекта [AJAX]
     *
     * @param  Request $request
     * @return string
     * @access public
     */

    public function setAutoPublishing(Request $request)
    {
        $siteID = Session::get('projectID');
        $site   = Site::find($siteID);

        if ( !$siteID || !$site )
            return abort(403, 'Need select project');

        $status = (DB::table('sites_settings')->where('site_id', $siteID)->first()->auto_publishing == 1) ? 0 : 1;
        DB::table('sites_settings')->where('site_id', $siteID)->update(array('auto_publishing' => $status));

        if ( $status )
            return trans('account.successAutoPublish');
        else
            return trans('account.failAutoPublish');
    }

    /**
     * Стата для языков
     *
     * @param  int $siteID
     * @param  int $allCountBlocks
     * @return array
     * @access private
     */

    private function getLangsStats($siteID, $allCountBlocks)
    {
        $data  = array();
        $langs = Site::find($siteID)->languages()->where('enabled', true)->orderBy('name')->get();

        foreach ( $langs as $lang )
        {
            $stats                 = array();
            $stats['ccTranslates'] = Translate::where('site_id', $siteID)->where('language_id', $lang->id)->whereNotNull('type_translate_id')->count(); //Сколько переведено в этом языке
            $stats['notLangTrans'] = Translate::where('site_id', $siteID)->where('language_id', $lang->id)->where('type_translate_id', NULL)->count(); //Не переведено в этом языке
            $dynamicStats          = DB::table('translates')->join('types_translates', 'translates.type_translate_id', '=', 'types_translates.id')
                                                            ->select('types_translates.name', DB::raw('count(*) as cc'))
                                                            ->where('site_id', $siteID)
                                                            ->where('language_id', $lang->id)
                                                            ->groupBy('translates.type_translate_id')
                                                            ->pluck('cc', 'types_translates.name'); //Остальные типы
            $_lines                = array_merge($dynamicStats, $stats);
            $lines                 = array();
            $iter                  = 1;

            foreach ( $_lines as $key => $line )
            {
                if ( $key == 'ccTranslates' )
                    continue;

                if ( $key == 'notLangTrans' ) 
                    $graph = array('cc' => $line, 'i' => '4', 'name' => 'Не переведено', 'per' => round(($line / $allCountBlocks) * 100));
                else
                  {
                    $graph = array('cc' => $line, 'i' => $iter, 'name' => $key, 'per' => round(($line / $allCountBlocks) * 100));
                    $iter++;
                  }

                $lines[] = $graph;
            }

            $data['on'][$lang->name]['ccTranslates'] = $stats['ccTranslates'];
            $data['on'][$lang->name]['langID']       = $lang->id;
            $data['on'][$lang->name]['lines']        = $lines;
        }

        $langs = Site::find($siteID)->languages()->where('enabled', false)->orderBy('name')->get();

        foreach ( $langs as $lang )
        {
            $stats                 = array();
            $stats['ccTranslates'] = Translate::where('site_id', $siteID)->where('language_id', $lang->id)->whereNotNull('type_translate_id')->count(); //Сколько переведено в этом языке
            $stats['notLangTrans'] = Translate::where('site_id', $siteID)->where('language_id', $lang->id)->where('type_translate_id', NULL)->count(); //Не переведено в этом языке
            $dynamicStats          = DB::table('translates')->join('types_translates', 'translates.type_translate_id', '=', 'types_translates.id')
                                                            ->select('types_translates.name', DB::raw('count(*) as cc'))
                                                            ->where('language_id', $lang->id)
                                                            ->where('site_id', $siteID)
                                                            ->groupBy('translates.type_translate_id')
                                                            ->lists('cc', 'types_translates.name'); //Остальные типы
            $_lines                = array_merge($dynamicStats, $stats);
            $lines                 = array();
            $iter                  = 1;

            foreach ( $_lines as $key => $line )
            {
                if ($key == 'ccTranslates')
                    continue;

                if ( $key == 'notLangTrans' ) 
                    $graph = array('cc' => $line, 'i' => '4', 'name' => 'Не переведено', 'per' => round(($line / $allCountBlocks) * 100));
                else
                  {
                    $graph = array('cc' => $line, 'i' => $iter, 'name' => $key, 'per' => round(($line / $allCountBlocks) * 100));
                    $iter++;
                  }

                $lines[] = $graph;
            }

            $data['off'][$lang->name]['ccTranslates'] = $stats['ccTranslates'];
            $data['off'][$lang->name]['langID'] = $lang->id;
            $data['off'][$lang->name]['lines'] = $lines;
        }

        return $data;
    }
    
    /**
     * Отправляем в архив перевод
     * Или наоборот.
     * 
     * @param  Request $request
     * @return string
     * @access public
     */
    
    public function setArchiveTranslate(Request $request)
    {
        $siteID = Session::get('projectID');
                
        if ( !$siteID )
            return abort(403, 'Need select project');
        
        $trans = Translate::find($request->get('id'));
        
        if ( $trans->enabled )
          {
            $trans->enabled = 0;
            $trans->update();
          }
        else 
          {
            $trans->enabled = 1;
            $trans->update();
          }
        
        $languageID = Session::get('filter')['languageID'];

        if (!$languageID)
            $languageID = Site::find($siteID)->languages()->where('enabled', true)->orderBy('id')->first()->id;

        $arrData = compact('siteID', 'languageID');
        $stats   = $this->generateStatsForPhraseFilter($arrData);
        
        return json_encode(array('message' => trans('account.successArhive' . $trans->enabled), 'stats' => $stats['stats']));
    }
    
    /**
     * Добавляем язык в проект
     * Как я понимаю, тут же и будет управление.
     *
     * @param  void
     * @return string
     * @access public
     */

    public function addLanguage()
    {
        if ( !$siteID = Session::get('projectID') ) 
            return redirect(URL::route('main.account.selectProject'));
        
        $site  = Site::find($siteID);
        $langs = Language::where('id', '!=', $site->language_id)->get();
        
        return view('account.addLanguage', compact('site', 'langs'));
    }

    /**
     * Смотрим какие были отключены и добавлены языки в проект
     * Если отключили, то не удаляем переводы
     *
     * @param  Request $request
     * @return void
     * @access public
     */

    public function postAddLanguage(Request $request)
    {
        if ( !$siteID = Session::get('projectID') ) 
            return redirect(URL::route('main.account.selectProject'));
        
        $newLangs = $request->get('languages', []);
        $langs    = Site::find($siteID)->languages();

        foreach ( $newLangs as $langID )
        {
            if ( $lang = DB::table('site_language')->where('site_id', $siteID)->where('language_id', $langID)->get() )
                DB::table('site_language')->where('site_id', $siteID)->where('language_id', $langID)->update(['enabled' => $lang[0]->enabled]);
            else
                DB::table('site_language')->insert(['site_id' => $siteID, 'language_id' => $langID, 'enabled' => 0]);
        }

        \Event::fire('site.changed', Site::find($siteID));
        \Event::fire('blocks.changed', Site::find($siteID));
        
        return redirect()->back();
    }

    /**
     * Добавление нового проекта
     *
     * @param  void
     * @return void
     * @access public
     */

    public function addProject()
    {
        return view('account.addProject');
    }

    /**
     * Показываем виджет
     *
     * @param  void
     * @return string
     * @access public
     */

    public function widget()
    {
        $siteID = Session::get('projectID');
        $site   = Site::find($siteID);
        
        if ( !$siteID || !$site )
          {
            Session::remove('projectID');
            return redirect(URL::route('main.account.selectProject'));
          }
          
        return view('account.widget', compact('site'));
    }

    /**
     * Генерируем статистику для фильтра во фразах
     *
     * @param  int $siteID
     * @param  int $languageID
     * @return array
     * @access public
     */

    private function generateStatsForPhraseFilter($arrData)
    {
        $filter = array();
        $filter['stats']['menu']          = array(1 => 0, 2 => 0, 3 => 0);
        $filter['stats']['in_translate']  = $this->getStatsInTranslate($arrData);
        $filter['stats']['not_translate'] = $this->getStatsNotTranslate($arrData);
        $filter['stats']['publish']       = $this->getStatsPublish($arrData);
        $filter['stats']['all']           = $this->getStatsAll($arrData);


        foreach ( $filter['stats']['all'] as $key => $val )
            $filter['stats']['menu'][$val->id] = $val->cc;

        $filter['stats']['all'] = array_sum(array_values($filter['stats']['menu']));
        $filter['colors']       = [1 => array('block' => 'blue', 'hex' => '#18baea'),
                                   2 => array('block' => 'green', 'hex' => '#70d579'),
                                   3 => array('block' => 'orange', 'hex' => '#ffa630')];

        $filter['menu'] = array();

        $filter['menu']['langs']        = Site::find($arrData['siteID'])->languages()->where('enabled', true)->orderBy('name')->get(); //Доступные языки
        $filter['menu']['types']        = TypeTranslate::orderBy('id')->get();
        $filter['menu']['active_lang']  = $arrData['languageID'];
        $filter['menu']['active_type']  = Session::get('filter')['typeID'];
        foreach ( $filter['menu']['langs'] as $lang )
        {
            $ccNull  = Translate::where('site_id', $arrData['siteID'])->where('language_id', $lang->id)->whereNotNull('type_translate_id')->count();
            $ccTrans = Translate::where('site_id', $arrData['siteID'])->where('language_id', $lang->id)->count();

            if ($ccTrans > 0) {
                $filter['stats']['proc'][$lang->id] = round(($ccNull / $ccTrans) * 100);
            } else {
                $filter['stats']['proc'][$lang->id]  = 0;
            }

        }
        
        $filter['pages_url'] = Session::get('pages_url');
        return $filter;
    }
    
    /**
     * Не переведено в этом языке
     * 
     * @param  array $arrData
     * @return int
     * @access public
     */
    
    public function getStatsNotTranslate($arrData)
    {
        $buildQuery = Translate::where('translates.site_id', $arrData['siteID'])
                               ->where('translates.language_id', $arrData['languageID'])
                               ->where('translates.type_translate_id', NULL)
                               ->join('blocks', 'blocks.id', '=', 'translates.block_id')
                               ->where('blocks.enabled', 1);

        if ( isset($arrData['pagesUrl']) && count($arrData['pagesUrl']) > 0 )
            $buildQuery->leftJoin('page_block', 'page_block.block_id', '=', 'blocks.id')
                       ->leftJoin('pages', 'pages.id', '=', 'page_block.page_id')
                       ->whereIn('pages.url', $arrData['pagesUrl'])
                       ->where('pages.enabled', '=', 1);

        if ( !empty($arrData['phraseInOrder']) ) 
            $buildQuery->where('translates.is_ordered', $arrData['phraseInOrder']);

        if ( !empty($arrData['searchText']) )
            $buildQuery->where(function ($query) use ($arrData)
            {
                $query->where('blocks.text', 'LIKE', '%' . $arrData['searchText'] . '%')
                      ->orWhere('translates.text', 'LIKE', '%' . $arrData['searchText'] . '%');
            });

        if ( isset($arrData['minDate']) && $arrData['minDate'] > 0 ) 
            $buildQuery->where('translates.updated_at', '>=', Carbon::parse($arrData['minDate'])->toDateTimeString());
		
        if ( isset($arrData['maxDate']) && $arrData['maxDate'] > 0 ) 
            $buildQuery->where('translates.updated_at', '<=', Carbon::parse($arrData['maxDate'])->toDateTimeString());
		
        return $buildQuery->count(); //Не переведено в этом языке
    }
    
    /**
     * Сколько переведено в этом языке
     * 
     * @param  array $arrData
     * @return int
     * @access public
     */
    
    public function getStatsInTranslate($arrData)
    {
        $buildQuery = Translate::where('translates.site_id', $arrData['siteID'])
                               ->where('translates.language_id', $arrData['languageID'])
                               ->whereNotNull('translates.type_translate_id')
                               ->join('blocks', 'blocks.id', '=', 'translates.block_id')
                               ->where('blocks.enabled', 1);

        if ( isset($arrData['pagesUrl']) && count($arrData['pagesUrl']) > 0 ) 
            $buildQuery->leftJoin('page_block', 'page_block.block_id', '=', 'blocks.id')
                       ->leftJoin('pages', 'pages.id', '=', 'page_block.page_id')
                       ->whereIn('pages.url', $arrData['pagesUrl'])
                       ->where('pages.enabled', '=', 1);      

        if ( !empty($arrData['phraseInOrder']) ) 
            $buildQuery->where('translates.is_ordered', $arrData['phraseInOrder']);

        if ( !empty($arrData['typeID']) )
            $buildQuery->where('translates.type_translate_id', $arrData['typeID']);
            
        if ( !empty($arrData['searchText']) ) 
            $buildQuery->where(function ($query) use ($arrData)
            {
                $query->where('blocks.text', 'LIKE', '%' . $arrData['searchText'] . '%')
                      ->orWhere('translates.text', 'LIKE', '%' . $arrData['searchText'] . '%');
            });
        
        if ( isset($arrData['minDate']) && $arrData['minDate'] > 0 ) 
            $buildQuery->where('translates.updated_at', '>=', Carbon::parse($arrData['minDate'])->toDateTimeString());
            
        if ( isset($arrData['maxDate']) && $arrData['maxDate'] > 0 ) 
            $buildQuery->where('translates.updated_at', '<=', Carbon::parse($arrData['maxDate'])->toDateTimeString());
            

        return $buildQuery->count(); //Сколько переведено в этом языке
    }
    
    /**
     * Сколько опубликованных
     * 
     * @param  array $arrData
     * @return int
     * @access public
     */
    
    public function getStatsPublish($arrData)
    {
        $buildQuery = Translate::where('translates.site_id', $arrData['siteID'])
                               ->where('translates.language_id', $arrData['languageID'])
                               ->where('translates.enabled', 1)
                               ->join('blocks', 'blocks.id', '=', 'translates.block_id')
                               ->where('blocks.enabled', 1);

        if ( isset($arrData['pagesUrl']) && count($arrData['pagesUrl']) > 0 )
            $buildQuery->leftJoin('page_block', 'page_block.block_id', '=', 'blocks.id')
                       ->leftJoin('pages', 'pages.id', '=', 'page_block.page_id')
                       ->whereIn('pages.url', $arrData['pagesUrl'])
                       ->where('pages.enabled', '=', 1);

        if ( !empty($arrData['phraseInOrder']) ) 
            $buildQuery->where('translates.is_ordered', $arrData['phraseInOrder']);
		
        if ( !empty($arrData['searchText']) ) 
            $buildQuery->where(function ($query) use ($arrData) 
            {
                $query->where('blocks.text', 'LIKE', '%' . $arrData['searchText'] . '%')
                      ->orWhere('translates.text', 'LIKE', '%' . $arrData['searchText'] . '%');
            });

        if ( !empty($arrData['typeID']) )
            $buildQuery->where('translates.type_translate_id', $arrData['typeID']);
        
        if ( isset($arrData['minDate']) && $arrData['minDate'] > 0 ) 
            $buildQuery->where('translates.updated_at', '>=', Carbon::parse($arrData['minDate'])->toDateTimeString());
		
        if ( isset($arrData['maxDate']) && $arrData['maxDate'] > 0 ) 
            $buildQuery->where('translates.updated_at', '<=', Carbon::parse($arrData['maxDate'])->toDateTimeString());
		
        return $buildQuery->count();
    }
    
    /**
     * Получаем тоже какую-то статистику
     * 
     * @param  array $arrData
     * @return array
     * @access public
     */
    
    public function getStatsAll($arrData)
    {
        $buildQuery = DB::table('translates')
                        ->join('types_translates', 'translates.type_translate_id', '=', 'types_translates.id')
                        ->select('types_translates.id', DB::raw('count(*) as cc'))
                        ->where('translates.site_id', $arrData['siteID'])
                        ->where('language_id', $arrData['languageID'])
                        ->join('blocks', 'blocks.id', '=', 'translates.block_id')
                        ->where('blocks.enabled', 1);

        if ( isset($arrData['pagesUrl']) && count($arrData['pagesUrl']) > 0 ) 
            $buildQuery->leftJoin('page_block', 'page_block.block_id', '=', 'blocks.id')
                       ->leftJoin('pages', 'pages.id', '=', 'page_block.page_id')
                       ->whereIn('pages.url', $arrData['pagesUrl'])
                       ->where('pages.enabled', '=', 1);
            
        if ( !empty($arrData['phraseInOrder']) )
            $buildQuery->where('translates.is_ordered', $arrData['phraseInOrder']);
            
        if ( !empty($arrData['searchText']) ) 
            $buildQuery->where(function ($query) use ($arrData)
            {
                $query->where('blocks.text', 'LIKE', '%' . $arrData['searchText'] . '%')
                      ->orWhere('translates.text', 'LIKE', '%' . $arrData['searchText'] . '%');
            });

        if ( isset($arrData['minDate']) && $arrData['minDate'] > 0 ) 
            $buildQuery->where('translates.updated_at', '>=', Carbon::parse($arrData['minDate'])->toDateTimeString());
        
        if ( isset($arrData['maxDate']) && $arrData['maxDate'] > 0 ) 
            $buildQuery->where('translates.updated_at', '<=', Carbon::parse($arrData['maxDate'])->toDateTimeString());
        
        return $buildQuery->groupBy('translates.type_translate_id')->get();
    }

    /**
     * Установка фильтра во фразах и редирект в нужный таб, на первую страницу
     *
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @access public
     */

    public function setFilterPharse(Request $request)
    {
        $filter = $request->get('filter');
        $tab    = $request->get('view_page');

        Session::set('filter', $filter);

        if ( $request->get('clearFilter') )
            Session::set('filter', NULL);

        return redirect()->back();
    }

    /**
     * Без перевода, первый таб.
     * @TODO: Команды
     *
     * @param  Request $request
     * @return string phraseAjaxRender
     * @access public
     */

    public function phraseNotTranslatesTab(Request $request)
    {
        $siteID    = Session::get('projectID');
        $viewType  = Session::get('typeViewID', 1);
        $filterDef = 0;
        $site      = Site::find($siteID);

        if ( !$siteID || !$site )
          {
            Session::remove('projectID');
            return redirect(URL::route('main.account.selectProject'));
          }

        if ( $request->input('language_id') ) 
            $languageID = $request->input('language_id');
        else 
            $languageID = Session::get('filter')['languageID'];
	    
        if ( !$languageID ) 
            $languageID = Site::find($siteID)->languages()->where('enabled', true)->orderBy('id')->first()->id;
            $filterDef = 1;
        
        $arrData = compact('siteID', 'languageID');
        if (!empty(Session::get('filter')['typeID'])) {
            $arrData['typeID'] = Session::get('filter')['typeID'];
        }
        $pagesUrl = !empty(Session::get('pages_url_'.$siteID)) ? explode(',', Session::get('pages_url_'.$siteID)) : [];
        if (!empty($pagesUrl)) {
            $arrData['pagesUrl'] = $pagesUrl;
        }
        $filter  = $this->generateStatsForPhraseFilter($arrData);
        if ( (int)$filter['stats']['not_translate'] === 0 )
            $tab = 'tab_translated';
         else 
            $tab = 'tab_not_translated';
        $tab_name = $tab;
        $arrData  = compact('tab', 'siteID', 'languageID');

        $blocks   = $this->buildQueryPhrase($arrData);
        $phrasesInOrder = $this->getCountPhrasesInOrder();
        $costOrder      = $this->getCostOrder();

        return view('account.phrase', compact('tab_name', 'blocks', 'filter', 'viewType', 'filterDef', 'phrasesInOrder', 'costOrder', 'siteID'));
    }

    /**
     * Сколько в заказе
     * 
     * @para,  void
     * @return int
     * @access public
     */
    
    public function getCountPhrasesInOrder()
    {
        $siteID = Session::get('projectID');
        
        $translate_is_ordered =  Translate::where('is_ordered', 1)->where('site_id', $siteID)->get();
        return $phrasesInOrder = $translate_is_ordered->count();
    }

   /**
    * Получаем стоимость заказа
    * 
    * @param  void
    * @return int
    * @access public
    */
    
    public function getCostOrder()
    {
        $siteID = Session::get('projectID');
        
        $translate_is_ordered =  Translate::where('is_ordered', 1)->where('site_id', $siteID)->get();
        $count_words          = 0;

        if ( $translate_is_ordered ) 
          {
            foreach ( $translate_is_ordered as $item )
            {
                $block_is_ordered = $item->block;
                $count_words      = (int)$count_words + $block_is_ordered->count_words;
            }
          }

        return (int)$count_words * $this->options['word_cost'];
    }

    /**
     * Опубликовать или нет [AJAX]
     *
     * @param  Request $request
     * @return void
     * @access public
     */

    public function turnStatusPublishing(Request $request)
    {
        $allowed_status = array(1, 0);

        $ids    = $request->get('ids', []);
        $status = $request->get('status');

        if ( !in_array($status, $allowed_status) )
            $status = 0;
        
        $siteID     = Session::get('projectID');
        $languageID = Session::get('filter')['languageID'];
        
        if ( !$languageID )
            $languageID = Site::find($siteID)->languages()->where('enabled', true)->orderBy('id')->first()->id;
        
        $arrData = compact('siteID', 'languageID');
        
        if ( $ids )
          {
            DB::table('translates')->whereIn('id', $ids)->update(array('enabled' => $status));
            $stats   = $this->generateStatsForPhraseFilter($arrData);

            return json_encode(array('message' => trans('account.success'), 'stats' => $stats['stats']));
          }
        else
            return json_encode(array('message' => trans('account.needCheckBlock'), 'stats' => $this->generateStatsForPhraseFilter($arrData)['stats'], 'isError' => true));
    }

    /**
     * Установка, как отображать фразы [AJAX]
     *
     * @param  Request $request
     * @return void
     * @access public
     */

    public function setTypeView(Request $request)
    {
        $allowed_type = array(1, 2);
        $type         = $request->get('typeViewID', 1);

        if ( !in_array($type, $allowed_type) )
            $type = 1;

        Session::set('typeViewID', $type);
    }

    /**
     * Ручной перевод [Ajax]
     *
     * @param  Request $request
     * @return void
     * @access public
     */

    public function saveTranslate(Request $request)
    {
        $siteID = Session::get('projectID');

        if (!$siteID)
            return redirect(URL::route('main.account.selectProject'));

        $siteID     = Session::get('projectID');
        $viewType   = Session::get('typeViewID', 1);
        $filterDef  = 0;
        $languageID = Session::get('filter')['languageID'];

        if ( !$languageID )
            $languageID = Site::find($siteID)->languages()->where('enabled', true)->orderBy('id')->first()->id;

        $text   = trim(strip_tags($request->get('text')));
        $id     = intval($request->get('id'));
        
        $trans                      = Translate::find($id);
        $trans->text                = $text;
        $trans->type_translate_id   = $request->get('type', 2);
        $trans->updated_at          = date('Y-m-d H:i:s');
        
        $connect = $trans->save();
        
        if ( $connect ) 
            $this->setHistoryPhrase($trans);
        
        $arrData = compact('siteID', 'languageID');
        $stats   = $this->generateStatsForPhraseFilter($arrData);

        $block = Translate::where('translates.id', $id)
                          ->leftJoin('blocks', 'blocks.id', '=', 'translates.block_id')
                          ->leftJoin('types_translates', 'types_translates.id', '=', 'translates.type_translate_id')
                          ->orderBy('translates.id')
                          ->select('translates.id as tid', 'blocks.enabled as enabled', 'translates.*',
                                   'types_translates.name as name_translate', DB::raw('date_format(translates.updated_at, "%h:%i") as time'),
                                    DB::raw('date_format(translates.updated_at, "%Y-%m-%d") as date'), 'blocks.text as original')
                          ->first();


        $monthes = array(
            1 => trans('account.yan'), 2 => trans('account.feb'), 3 => trans('account.mar'), 4 => trans('account.apr'),
            5 => trans('account.may'), 6 => trans('account.iun'), 7 => trans('account.iul'), 8 => trans('account.avg'),
            9 => trans('account.sem'), 10 => trans('account.okt'), 11 => trans('account.noy'), 12 => trans('account.dec')
        );

        $color = array(3 => 'phrases__item_mark-orange', 1 => 'phrases__item_mark-blue', 2 => 'phrases__item_mark-green');
        $icons = array(3 => 'phrases__item-controls-type_prof', 2 => 'phrases__item-controls-type_handler', 1 => 'phrases__item-controls-type_machine');
        $month = date('d', strtotime($block->date)) . ' ' . $monthes[(date('n', strtotime($block->date)))] . ' ' . date('Y', strtotime($block->date));
        $block = array(
            'typeTranslate' => $block->name_translate,
            'datetime' => $block->date,
            'time' => $block->time,
            'date' => '<span>' . $block->time . '</span> ' . $month,
            'color' => 'phrases__item ' . $color[$block->type_translate_id],
            'icon' => 'phrases__item-controls-type  ' . $icons[$block->type_translate_id],
        );

        return json_encode(array('message' => trans('account.successTranslate'), 'stats' => $stats['stats'], 'block' => $block));
    }

    /**
     * Отдаем рендер перевода фраз [AJAX]
     * Учитываем все фильтра и сохраняем их в сессию юзера
     * Так же учитываем страницу, по которой хотят получить все слова
     *
     * @param  Request $request
     * @return string [JSON]
     * @access public
     */

    public function phraseAjaxRender(Request $request)
    {       
        $filter         = $request->get('filter');
        $tab            = $request->get('tab');
        $languageID     = $filter['languageID'];
        $siteID         = $request->get('site_id');
        $viewType       = $request->get('view_type');
        $typeID         = $filter['typeID'];
        $pagesUrl       = $request->get('name_none') != '' ? explode(',', $request->get('name_none')) : [];
        $phraseInOrder  = $request->get('phrase_in_order');
        $minDate        = $request->get('min_date');
        $maxDate        = $request->get('max_date');
        $pathName       = $request->get('pathname');

        $ttt = 2;

        Session::set('filter', $filter);

	    $searchText = false;
	
        if ( $request->get('search_text') )
            $searchText = $request->get('search_text');
	    
        if ( $request->get('name_none') ) 
            Session::set('pages_url_'.$siteID, $request->get('name_none'));
        
        if ( $request->get('name_none') === null ) 
            Session::set('pages_url_'.$siteID, null);
        
        if ( $request->get('clearFilter') ) 
            Session::set('filter', NULL);
      
        if ( !$siteID ) 
            return redirect(URL::route('main.account.selectProject'));
        
        $arrQuery = compact('tab', 'siteID', 'languageID', 'typeID', 'pagesUrl', 'phraseInOrder', 'searchText', 'minDate', 'maxDate', 'ttt');
        $json     = [];

        $arrData = compact('siteID', 'languageID');
        $filter  = $this->generateStatsForPhraseFilter($arrQuery);

        $blocks        = $this->buildQueryPhrase($arrQuery);
        $blockIds      = $blocks->lists('tid');
        $data          = compact('blocks', 'filter', 'viewType', 'tab', 'pathName');
        $json['html']  = (String)\View::make('account.phraseAjax', $data)->render();
        
        unset($filter['menu']['langs']);
        
        $json['info'] = $filter;
        $json['data'] = $arrQuery;
        
        return json_encode($json, JSON_HEX_QUOT | JSON_HEX_TAG);
    }

    /**
     |------------------------------------------------------------
     | Генерируем запрос на получение фраз
     |------------------------------------------------------------
     | @return array
     | @internal param string $type
     | @access public
     | @param $arrQuery
     | @return
     */

    private function buildQueryPhrase($arrQuery)
    {
        $buildQuery = Page::where('pages.site_id', $arrQuery['siteID']);
        if ( isset($arrQuery['pagesUrl']) && count($arrQuery['pagesUrl']) > 0 )
            $buildQuery->whereIn('pages.url', $arrQuery['pagesUrl']);
        
        $buildQuery->leftJoin('page_block', 'page_block.page_id', '=', 'pages.id')
                   ->leftJoin('blocks', 'blocks.id', '=', 'page_block.block_id')
                   ->where('blocks.enabled', '=', 1)
                   ->where('translates.language_id', '=', $arrQuery['languageID'])
                   ->leftJoin('translates', 'translates.block_id', '=', 'page_block.block_id')
                   ->groupBy('page_block.block_id');

        switch ($arrQuery['tab']) 
        {
            case 'tab_not_translated':
            default:
                $buildQuery->where('translates.type_translate_id', NULL);
            break;
            case 'tab_translated':
                $buildQuery->whereNotNull('translates.type_translate_id');
                if (!empty($arrQuery['typeID']))
                    $buildQuery->where('translates.type_translate_id', $arrQuery['typeID']);
                break;
            case 'tab_published':
                $buildQuery->where('translates.enabled', '=', 1);
                if (!empty($arrQuery['typeID']))
                    $buildQuery->where('translates.type_translate_id', $arrQuery['typeID']);
                break;
            case 'tab_acrhive':
                $buildQuery->where('translates.enabled', 0);
                if (!empty($arrQuery['typeID']))
                    $buildQuery->where('translates.type_translate_id', $arrQuery['typeID']);
            break;
        }

        if ( !empty($arrQuery['phraseInOrder']) ) 
            $buildQuery->where('translates.is_ordered', $arrQuery['phraseInOrder']);

	if ( !empty($arrQuery['searchText']) )
            $buildQuery->where(function ($query) use ($arrQuery) 
            {
                $query->where('blocks.text', 'LIKE', '%' . $arrQuery['searchText'] . '%')
                      ->orWhere('translates.text', 'LIKE', '%' . $arrQuery['searchText'] . '%');
            });

        if ( isset($arrQuery['minDate']) && $arrQuery['minDate'] > 0 ) 
            $buildQuery->where('translates.updated_at', '>=', Carbon::parse($arrQuery['minDate'])->toDateTimeString());
	    
        $buildQuery->where('pages.enabled', '=', 1);

        if ( isset($arrQuery['maxDate']) && $arrQuery['maxDate'] > 0 ) 
            $buildQuery->where('translates.updated_at', '<=', Carbon::parse($arrQuery['maxDate'])->toDateTimeString());
	    

        $buildQuery->leftJoin('types_translates', 'types_translates.id', '=', 'translates.type_translate_id')
                   ->orderBy('pages.id')
                   ->select('pages.id as pages_id', 
                            'pages.*', 'translates.id as tid', 'blocks.enabled as blocks_enabled', 'translates.*',
                            'translates.enabled as translates_enabled', 'types_translates.name as name_translate',
                            DB::raw('date_format(translates.updated_at, "%h:%i") as time'),
                            DB::raw('date_format(translates.updated_at, "%Y-%m-%d") as date'), 'blocks.text as original');

        return $buildQuery->paginate(25);
    }

    /**
     * Отмечаем как ручной перевод
     *
     * @param  int $id
     * @return void
     * @access public
     */

    public function markHandTranslate($id)
    {
        $trans = Translate::find($id);
        
        $trans->type_translate_id = 2;
        $trans->save();
    }

    /**
     * Включение и выключение языка [AJAX]
     *
     * @param  Request $request
     * @return array
     * @access public
     */

    public function turnLang(Request $request)
    {
        if ( !$siteID = Session::get('projectID') )
            return abort(403, 'Need select project');

        $enabled = DB::table('site_language')->where('language_id', $request->input('langID'))->where('site_id', $siteID)->first()->enabled;
        DB::table('site_language')->where('language_id', $request->input('langID'))->where('site_id', $siteID)->update(['enabled' => ($enabled == 1) ? 0 : 1]);
    }

    /**
     * Показываем языки проекта.
     * Так же осуществляем управление языками в проекте
     *
     * @param  void
     * @return string view
     * @access public
     */

    public function projectLanguages()
    {
        if ( !Session::get('projectID') ) 
            return redirect(URL::route('main.account.selectProject'));
        
        $siteID    = Session::get('projectID');
        $langs     = Site::find($siteID)->languages()->orderBy('name')->get();
        $ccBlocks  = Block::where('site_id', $siteID)->count();
        $lineStats = $this->getLangsStats($siteID, $ccBlocks);

        return view('account.languages', compact('langs', 'lineStats', 'ccBlocks'));
    }

    /**
     * Выводим названия страничек [AJAX]
     * 
     * @param Request $request
     * @return array
     * @access public
     */

    public function ajaxRenderingTitlePages(Request $request)
    {
        $ret_data  = [];
        $tab       = $request->input('tab');
        $viewType  = Session::get('typeViewID', 1);
        $name_none = explode(',', $request->input('name_none'));
        $blocks    = $this->buildQueryTitle($request->input('site_id'), $request->input('name'), $name_none);

        $ret_data['blocks']  = $blocks;
        $ret_data['data']    = $name_none;
        $ret_data['success'] = true;
        
        return $ret_data;
    }
    
    /**
     * Выводим блоки [AJAX]
     * Я не знаю что это.
     * 
     * @param  Request $request
     * @return array
     * @access public
     */
    
    public function ajaxRenderingBlocksPages(Request $request)
    {
        $ret_data = [];
        $tab      = $request->input('tab');
	    
        $viewType   = '';
        $pageUrl    = explode(',', $request->input('name_none'));
        $siteID     = $request->input('site_id');
        $languageID = $request->input('language_id');
        $arrData    = compact('siteID', 'languageID');
        $filter     = $this->generateStatsForPhraseFilter($arrData);
        $blocks     = $this->buildQueryBlocks($tab, $request->input('site_id'), $request->input('language_id'), $pageUrl);
        
        $ret_data['html']    = (String)\View::make('account.pagesAjax', compact('blocks', 'filter', 'viewType', 'tab'))->render();
        $ret_data['data']    = $blocks;
        $ret_data['success'] = true;
        
        return $ret_data;
    }
    
   /**
    * @param  int $site_id
    * @param  string $value
    * @param  string $name_none
    * @return array
    * @access public
    */
    
    public function buildQueryTitle($site_id, $value, $name_none = [])
    {
        return Page::where('site_id', $site_id)->whereNotIn('url', $name_none)->where('url', 'LIKE', '%' . $value . '%')->get();
    }

    
    /**
     * 
     * @param  array $arrQuery
     * @return array
     * @access private
     */
    
    private function buildQueryPages($arrQuery)
    {
        $buildQuery = Page::where('site_id', $arrQuery['siteID'])->select('pages.*');

        return $buildQuery->paginate(25);
    }
	
    /**
     * Отключаем/подключаем блок
     * 
     * @param Request $request
     * @return string
     * @access public
     */
    
    public function disableDisplayPhrase(Request $request)
    {
        $retData        = [];
        $siteId         = $request->input('site_id');
        $languageId     = $request->input('language_id');
        $translatesId   = $request->input('translates_id');

        $query = Translate::find($translatesId);
        
        if ( $query ) 
          {
            $block          = $query->block;
            $block->enabled = 0;
            $connect        = $block->save();
            $arrData        = compact('siteID', 'languageID');
            $stats          = $this->generateStatsForPhraseFilter($arrData);
            
            if ( $connect ) 
              {
                $retData['success'] = true;
                $retData['message'] = trans('account.outputPhraseMessage_' . $block->enabled);
                $retData['stats']   = $stats['stats'];
              } 
            else 
              {
                $retData['success'] = false;
                $retData['message'] = trans('account.errorOutputPhrase_' . $block->enabled);
                $retData['stats']   = $stats['stats'];
              }
            }

        echo json_encode($retData);
    }
    
    /**
     * Отключаем/включаем страницу и блоки принадлежащие только ей
     * 
     * @param  Request $request
     * @return void
     * @access public
     */
    
    public function setPagesDisable(Request $request)
    {
        $query = Page::where('url', $request->input('url'))->first();
        
        $query->enabled = (int) $request->input('check');
        $query->save();
        
        $blocks   = $query->blocks;
        $ret_data = [];
        
        foreach ( $blocks as $block )
        {
            if ( $block->pages->count() > 1 )
              {
                $ret_data[]     = $block->id;
                $block->enabled = (int)$request->input('check');
                $block->save();
              }
        }
        
        echo json_encode($ret_data);
    }

    /**
     * Добавляем страницу в сессию
     * 
     * @param  Request $request
     * @return string
     * @access public
     */
    
    public function setPagesSession(Request $request)
    {
        $ret_data = [];
        
        Session::set('pages_url', null);
        Session::set('pages_url', $request->input('url'));
        
        $pages_url = Session::get('pages_url');
        
        if ( $pages_url ) 
            $ret_data['success'] = true;
        
        echo json_encode($ret_data);
    }

    /**
     * Добавление/удаление фразы в заказ
     * 
     * @param  Request $request
     * @access public
     */
    
    public function setOrderingTranslation(Request $request)
    {
        $data_id  = $request->input('data_id');
        if (empty($data_id)) {
            $ret_data['isError'] = 1;
            $ret_data['message'] = 'Не выбрано ни одной фразы';
            return json_encode($ret_data);
        }
        foreach ($data_id as $item) {
            $translates = Translate::find($item['id']);
            
            $translates->is_ordered = $item['check'];
            $save                   = $translates->save();
            $ret_data[$item['id']]  = $save;
        }
        $ret_data['phrasesInOrder'] = $this->getCountPhrasesInOrder();
        $ret_data['costOrder']      = $this->getCostOrder();
        $ret_data['message'] = 'Фразы добавлены в заказ';
        if (count($data_id) == 0) {
            $ret_data['isError'] = 1;
            $ret_data['message'] = 'Не выбрано ни одной фразы';
        }
        echo json_encode($ret_data);
    }
    
    /**
     * Вывод страниц сайта
     * 
     * @param  Request $request
     * @return string
     * @access public
     */
    
    public function pagesView(Request $request)
    {
        $site = Site::find(Session::get('projectID'));
        
        if ( !$site ) 
          {
            Session::remove('projectID');
            return redirect(URL::route('main.account.selectProject'));
          }
          
        $blocks = $site->pages()->paginate(25);
        return view('account/pages', compact('blocks'));
    }
    
    /**
     * Save history block
     * 
     * @param  object $model
     * @return void
     * @access public
     */
    
    public function setHistoryPhrase($model)
    {
        $historyData = [
            'translate_id'  => $model->id,
            'text'          => $model->text,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ];
        
        HistoryPhrase::create($historyData);
    }

    /**
     * Очистка сессий фильтров
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearFilter()
    {
        $siteID = Session::get('projectID');
        Session::remove('filter');
        Session::remove('typeViewID');
        Session::remove('pages_url');
        Session::remove('pages_url_'.$siteID);
        return redirect()->route('main.account.phrase');
    }

    public function getHistory($id)
    {
        $history = HistoryPhrase::where('translate_id', $id)->latest()->get();
        return view('account.history', compact('history'));
    }
}
