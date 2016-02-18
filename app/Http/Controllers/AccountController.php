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

use App\Http\Requests,
    App\Site,
    App\Page,
    URL,
    App\User,
    Session,
    DB,
    App\Block,
    App\Translate,
    App\TypeTranslate,
    Auth,
    App\Language,
    Illuminate\Http\Request;

class AccountController extends Controller
{
    
    /**
     * @var  object
     */
    
    private $user  = null;
    
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
        $this->user  = Auth::user();
        $this->sites = Site::where('user_id', $this->user->id)->orderBy('url')->get(); //TODO: Команды
        \View::share('sites', $this->sites);
        
        parent::__construct();
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
        
        $siteID = Session::get('projectID');
 
        $stats = array(
            'ccBlocks'   => Block::where('site_id', $siteID)->count(),
            'ccPages'    => Page::where('site_id', $siteID)->count(),
            'listLangs'  => Site::find($siteID)->languages()->orderBy('name')->get(),
            'lineGraph'  => $this->lineStatistics($siteID, Block::where('site_id', $siteID)->count())
        );
        
        return view('account.overview', compact('sites', 'stats'));
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
            $stats['notTranslate'] = Translate::where('site_id', $siteID)->where('type_translate_id', NULL)->count(); //Не переведено
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
                if ( $key == 'notTranslate' )
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
     * Показываем языки проекта.
     * Так же осуществляем управление языками в проекте
     * 
     * @param  void
     * @return string view
     * @access public
     */
    
    public function projectLanguages()
    {
        return view('account.languages');
    }
}
