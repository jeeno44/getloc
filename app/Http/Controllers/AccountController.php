<?php
/**
  +--------------------------------------------------------------------------
  |   get-loc.ru
  |   =============================================
  |   by Sultanov Denis aka DenSul aka Mio
  |   (c) 2016
  |   http://vk.com/programmers
  |   =============================================
  |   Web: http://get-loc.ru/
  |   Email: <sultanden@gmail.com>
  +---------------------------------------------------------------------------
 */

namespace App\Http\Controllers;

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
     * @return void
     * @access public
     */
    
    public function selectProject()
    {
        $mySites = $this->sites;
        return view('account.selectProject', compact('mySites'));
    }
    
    /**
     * Установка выбраного проекта
     * 
     * @param  int $id
     * @return void
     * @access public
     */
    
    public function setProject($id)
    {
        // Проверка прав на сайт, TODO: команды
        if ( Site::where('id', $id)->where('user_id', $this->user->id)->first() )
          {
            Session::set('projectID', $id);
            return redirect(URL::route('main.account.overview'));  
          }
        else
          {
            return redirect(URL::route('main.account.selectProject'));  
          }
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
    
    public function projectOverview()
    {
        if ( !Session::get('projectID') )
          {
            return redirect(URL::route('main.account.selectProject'));  
          }
        
        $siteID   = Session::get('projectID');
        $ccBlocks = Block::where('site_id', $siteID)->count();
        
        $stats = array(
            'ccBlocks'   => Block::where('site_id', $siteID)->count(),
            'ccPages'    => Page::where('site_id', $siteID)->count(),
            'listLangs'  => Site::find($siteID)->languages()->orderBy('name')->get(),
            'lineGraph'  => $this->lineStatistics($siteID, $ccBlocks),
            'langStats'  => $this->getStatusLangs($siteID, $ccBlocks)
        );
        
        return view('account.overview', compact('sites', 'stats'));
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
        $langs = Site::find($siteID)->languages()->orderBy('name')->get();
        
        foreach ( $langs as $lang )
        {
            $ccTranslate = Translate::where('site_id', $siteID)->where('language_id', $lang->id)->whereNotNull('type_translate_id')->count();
            $graph       = round(($ccTranslate/$allCountBlocks) * 100);
            
            $stats[$lang->short] = array('name' => $lang->name, 'per' => $graph, 'cc' => $ccTranslate, 'ccb' => $allCountBlocks);
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
        $data    = array();
        $langs   = Site::find($siteID)->languages()->orderBy('name')->get();
        
        foreach ( $langs as $lang )
        {
            $stats                 = array(); 
            $stats['notLangTrans'] = Translate::where('site_id', $siteID)->where('language_id', $lang->id)->where('type_translate_id', NULL)->count(); //Не переведено в этом языке
            $dynamicStats          = DB::table('translates')->join('types_translates', 'translates.type_translate_id', '=', 'types_translates.id')
                                                            ->select('types_translates.name', DB::raw('count(*) as cc'))
                                                            ->where('site_id', $siteID)
                                                            ->where('language_id', $lang->id)
                                                            ->groupBy('translates.type_translate_id')
                                                            ->lists('cc','types_translates.name'); //Остальные типы
            $_lines                = array_merge($dynamicStats, $stats);
            $lines                 = array();
            $iter                  = 1;
            
            foreach ( $_lines as $key => $line )
            {
                if ( $allCountBlocks == 0 )
                    continue;
                
                if ( $key == 'notLangTrans' )
                  {
                     $graph = array('cc' => $line, 'i' => '4', 'name' => 'Не переведено', 'per' => round(($line/$allCountBlocks) * 100));
                  }
                else
                  {
                      $graph = array('cc' => $line, 'i' => $iter, 'name' => $key, 'per' => round(($line/$allCountBlocks) * 100));
                      $iter++;
                  }
                  
                $lines[] = $graph;
            }
            
            $data[$lang->name] = $lines;
        }

        return $data;
        
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
        $data    = array();
        $langs   = Site::find($siteID)->languages()->where('enabled', true)->orderBy('name')->get();
        
        foreach ( $langs as $lang )
        {
            $stats                 = array(); 
            $stats['ccTranslates'] = Translate::where('site_id', $siteID)->where('language_id', $lang->id)->whereNotNull('type_translate_id')->count(); //Сколько переведено в этом языке
            $stats['notLangTrans'] = Translate::where('site_id', $siteID)->where('language_id', $lang->id)->where('type_translate_id', NULL)->count(); //Не переведено в этом языке
            $dynamicStats          = DB::table('translates')->join('types_translates', 'translates.type_translate_id', '=', 'types_translates.id')
                                                            ->select('types_translates.name', DB::raw('count(*) as cc'))
                                                            ->where('site_id', $siteID)
                                                            ->groupBy('translates.type_translate_id')
                                                            ->lists('cc','types_translates.name'); //Остальные типы
            $_lines                = array_merge($dynamicStats, $stats);
            $lines                 = array();
            $iter                  = 1;
            
            foreach ( $_lines as $key => $line )
            {
                if ( $key == 'ccTranslates' )
                    continue;
                
                if ( $key == 'notLangTrans' )
                  {
                    $graph = array('cc' => $line, 'i' => '4', 'name' => 'Не переведено', 'per' => round(($line/$allCountBlocks) * 100));
                  }
                else
                  {
                      $graph = array('cc' => $line, 'i' => $iter, 'name' => $key, 'per' => round(($line/$allCountBlocks) * 100));
                      $iter++;
                  }
                  
                $lines[] = $graph;
            }
            
            $data['on'][$lang->name]['ccTranslates'] = $stats['ccTranslates'];
            $data['on'][$lang->name]['langID']       = $lang->id;
            $data['on'][$lang->name]['lines']        = $lines;
        }
        
        $langs   = Site::find($siteID)->languages()->where('enabled', false)->orderBy('name')->get();
        
        foreach ( $langs as $lang )
        {
            $stats                 = array(); 
            $stats['ccTranslates'] = Translate::where('site_id', $siteID)->where('language_id', $lang->id)->whereNotNull('type_translate_id')->count(); //Сколько переведено в этом языке
            $stats['notLangTrans'] = Translate::where('site_id', $siteID)->where('language_id', $lang->id)->where('type_translate_id', NULL)->count(); //Не переведено в этом языке
            $dynamicStats          = DB::table('translates')->join('types_translates', 'translates.type_translate_id', '=', 'types_translates.id')
                                                            ->select('types_translates.name', DB::raw('count(*) as cc'))
                                                            ->where('site_id', $siteID)
                                                            ->groupBy('translates.type_translate_id')
                                                            ->lists('cc','types_translates.name'); //Остальные типы
            $_lines                = array_merge($dynamicStats, $stats);
            $lines                 = array();
            $iter                  = 1;
            
            foreach ( $_lines as $key => $line )
            {
                if ( $key == 'ccTranslates' )
                    continue;
                
                if ( $key == 'notLangTrans' )
                  {
                     $graph = array('cc' => $line, 'i' => '4', 'name' => 'Не переведено', 'per' => round(($line/$allCountBlocks) * 100));
                  }
                else
                  {
                      $graph = array('cc' => $line, 'i' => $iter, 'name' => $key, 'per' => round(($line/$allCountBlocks) * 100));
                      $iter++;
                  }
                  
                $lines[] = $graph;
            }
            
            $data['off'][$lang->name]['ccTranslates'] = $stats['ccTranslates'];
            $data['off'][$lang->name]['langID']       = $lang->id;
            $data['off'][$lang->name]['lines']        = $lines;
        }
        
        return $data;
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
          {
            return redirect(URL::route('main.account.selectProject'));  
          }
        
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
          {
            return redirect(URL::route('main.account.selectProject'));  
          } 
          
        $newLangs = $request->get('languages', []);
        $langs    = Site::find($siteID)->languages();
        
        #DB::table('site_language')->where('site_id', $siteID)->update(['enabled' => 0]);
        foreach ( $newLangs as $langID )
        {
            if ( $lang = DB::table('site_language')->where('site_id', $siteID)->where('language_id', $langID)->get() )
                DB::table('site_language')->where('site_id', $siteID)->where('language_id', $langID)->update(['enabled' => $lang[0]->enabled]);
            else
                DB::table('site_language')->insert(['site_id' => $siteID, 'language_id' => $langID, 'enabled' => 1]);
        }
        
        \Event::fire('site.changed', Site::find($siteID));
        
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
               
       if ( !$siteID )
            return redirect(URL::route('main.account.selectProject'));  
       
       $site = Site::find($siteID);

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
   
   private function generateStatsForPhraseFilter($siteID, $languageID)
   {
       $filter = array();
       
       $filter['stats']['menu']          = array(1 => 0, 2 => 0, 3 => 0);
       $filter['stats']['in_translate']  = Translate::where('site_id', $siteID)->where('language_id', $languageID)->whereNotNull('type_translate_id')->count(); //Сколько переведено в этом языке
       $filter['stats']['not_translate'] = Translate::where('site_id', $siteID)->where('language_id', $languageID)->where('type_translate_id', NULL)->count(); //Не переведено в этом языке
       $filter['stats']['publish']       = Block::where('site_id', $siteID)->where('enabled', 1)->count();
       $filter['stats']['all']           = DB::table('translates')->join('types_translates', 'translates.type_translate_id', '=', 'types_translates.id')
                                                                  ->select('types_translates.id', DB::raw('count(*) as cc'))
                                                                  ->where('site_id', $siteID)
                                                                  ->where('language_id', $languageID)
                                                                  ->groupBy('translates.type_translate_id')
                                                                  ->get();
       
       foreach ( $filter['stats']['all'] as $key => $val )
            $filter['stats']['menu'][$val->id] = $val->cc;
       
       $filter['stats']['all'] = array_sum(array_values($filter['stats']['menu'])); 
       $filter['colors']       = [1 => array('block' => 'blue', 'hex' => '#18baea'), 
                                  2 => array('block' => 'green', 'hex' => '#70d579'), 
                                  3 => array('block' => 'orange', 'hex' => '#ffa630')];
       
       $filter['menu'] = array();
       
       $filter['menu']['langs']       = Site::find($siteID)->languages()->where('enabled', true)->orderBy('name')->get(); //Доступные языки
       $filter['menu']['types']       = TypeTranslate::orderBy('id')->get();
       $filter['menu']['active_lang'] = $languageID;
       $filter['menu']['active_type'] = Session::get('filter')['typeID'];
       
       foreach ( $filter['menu']['langs'] as $lang )
       {
           $ccNull  = Translate::where('site_id', $siteID)->where('language_id', $lang->id)->whereNotNull('type_translate_id')->count(); 
           $ccTrans = Translate::where('site_id', $siteID)->where('language_id', $lang->id)->count();
           
           $filter['stats']['proc'][$lang->id] = round(($ccNull/$ccTrans) * 100);
       }
       
       return $filter;
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
    * @return string
    * @access public
    */
   
   public function phraseNotTranslatesTab(Request $request)
   {
       $siteID      = Session::get('projectID');
       $tab_name    = 'not_translated';
       $viewType    = Session::get('typeViewID', 1);
       
       if ( !$siteID )
           return redirect(URL::route('main.account.selectProject'));  
       
       $languageID = Session::get('filter')['languageID'];
       
       if ( !$languageID )
           $languageID = Site::find($siteID)->languages()->where('enabled', true)->orderBy('id')->first()->id;
              
       $filter     = $this->generateStatsForPhraseFilter($siteID, $languageID);
       $buildQuery = Translate::where('translates.site_id', $siteID)
                              ->where('translates.language_id', $languageID)
                              ->where('translates.type_translate_id', NULL)
                              ->leftJoin('blocks', 'blocks.id', '=', 'translates.block_id')
                              ->leftJoin('types_translates', 'types_translates.id', '=', 'translates.type_translate_id')
                              ->orderBy('translates.id')
                              ->select('translates.id as tid', 'blocks.enabled as enabled', 'translates.*',
                                     'types_translates.name as name_translate', DB::raw('date_format(translates.updated_at, "%h:%i") as time'),
                                     DB::raw('date_format(translates.updated_at, "%Y-%m-%d") as date'), 'blocks.text as original');
       
       $blocks = $buildQuery->paginate(25);
                                  
       return view('account.phrase', compact('tab_name', 'blocks', 'filter', 'viewType'));
   }
   
   /**
    * Переведенные, второй таб
    * @TODO: Команды
    * 
    * @param  Request $request
    * @return string
    * @access public
    */
   
   public function phraseTranslatesTab(Request $request)
   {
       $siteID      = Session::get('projectID');
       $tab_name    = 'translated';
       $viewType    = Session::get('typeViewID', 1);
       
       if ( !$siteID )
           return redirect(URL::route('main.account.selectProject'));  
       
       $languageID = Session::get('filter')['languageID'];
       
       if ( !$languageID )
           $languageID = Site::find($siteID)->languages()->where('enabled', true)->orderBy('id')->first()->id;
       
       $filter     = $this->generateStatsForPhraseFilter($siteID, $languageID);
       $buildQuery = Translate::where('translates.site_id', $siteID)
                              ->where('translates.language_id', $languageID)
                              ->whereNotNull('translates.type_translate_id')
                              ->leftJoin('blocks', 'blocks.id', '=', 'translates.block_id')
                              ->leftJoin('types_translates', 'types_translates.id', '=', 'translates.type_translate_id')
                              ->orderBy('translates.id')
                              ->select('translates.id as tid', 'blocks.enabled as enabled', 'translates.*',
                                       'types_translates.name as name_translate', DB::raw('date_format(translates.updated_at, "%h:%i") as time'),
                                       DB::raw('date_format(translates.updated_at, "%Y-%m-%d") as date'), 'blocks.text as original');
       
       if ( Session::get('filter')['typeID'] )
           $buildQuery->where('translates.type_translate_id', '=', Session::get('filter')['typeID']);  
       
       $blocks = $buildQuery->paginate(25);
                                  
       return view('account.phrase', compact('tab_name', 'blocks', 'filter', 'viewType'));
   }
   
   /**
    * Опубликованные, третий таб
    * @TODO: Команды
    * 
    * @param  Request $request
    * @return string
    * @access public
    */
   
   public function phrasePublishingTab(Request $request)
   {
       $siteID      = Session::get('projectID');
       $tab_name    = 'published';
       $viewType    = Session::get('typeViewID', 1);
       
       if ( !$siteID )
           return redirect(URL::route('main.account.selectProject'));  
       
       $languageID = Session::get('filter')['languageID'];
       
       if ( !$languageID )
           $languageID = Site::find($siteID)->languages()->where('enabled', true)->orderBy('id')->first()->id;
       
       $filter     = $this->generateStatsForPhraseFilter($siteID, $languageID);
       $buildQuery = Translate::where('translates.site_id', $siteID)
                              ->where('translates.language_id', $languageID)
                              ->where('blocks.enabled', '=', 1)
                              ->leftJoin('blocks', 'blocks.id', '=', 'translates.block_id')
                              ->leftJoin('types_translates', 'types_translates.id', '=', 'translates.type_translate_id')
                              ->orderBy('translates.id')
                              ->select('translates.id as tid', 'blocks.enabled as enabled', 'translates.*',
                                       'types_translates.name as name_translate', DB::raw('date_format(translates.updated_at, "%h:%i") as time'),
                                       DB::raw('date_format(translates.updated_at, "%Y-%m-%d") as date'), 'blocks.text as original');
       
       if ( Session::get('filter')['typeID'] )
           $buildQuery->where('translates.type_translate_id', '=', Session::get('filter')['typeID']);  
       
       $blocks = $buildQuery->paginate(25);
                                  
       return view('account.phrase', compact('tab_name', 'blocks', 'filter', 'viewType'));
   }
   
   /**
    * Архив блоков и переводов, крайний таб.
    * TODO: уточнить все детали у АЛ.
    * @TODO: Команды
    * 
    * @param  Request $request
    * @return string
    * @access public
    */
   
   public function phraseArchiveTab(Request $request)
   {
       return '';
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
       
       $ids     = $request->get('ids', []);
       $status  = $request->get('status');
       
       if ( !in_array($status, $allowed_status) )
            $status = 0;
       
       DB::table('blocks')->whereIn('id', $ids)->update(array('enabled' => $status));
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
   
   public function handTranslate(Request $request)
   {
       if ( !$siteID = Session::get('projectID') )
            return abort(403, 'Need select project');  
          
        $text  = trim(strip_tags($request->get('text')));
        $id    = intval($request->get('id'));
        $trans = Translate::find($id);
        
        $trans->text              = $text;
        $trans->type_translate_id = 2;
        
        $trans->save();
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
          {
            return redirect(URL::route('main.account.selectProject'));  
          }
        
        $siteID     = Session::get('projectID');
        $langs      = Site::find($siteID)->languages()->orderBy('name')->get();
        $ccBlocks   = Block::where('site_id', $siteID)->count();
        $lineStats  = $this->getLangsStats($siteID, $ccBlocks);
        
        return view('account.languages', compact('langs', 'lineStats', 'ccBlocks'));
    }
}
