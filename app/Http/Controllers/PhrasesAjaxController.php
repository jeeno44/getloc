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
  |   Фразы проекта на AJAX
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

class PhrasesAjaxController extends Controller {
    
    /**
     * @param  void
     * @return object class PhrasesAjaxController
     * @access public
     */
    
    public function __construct() 
    {
        parent::__construct();
        $this->sites = Site::where('user_id', $this->user->id)->orderBy('url')->get(); //TODO: Команды
        \View::share('sites', $this->sites);
    }
    
}