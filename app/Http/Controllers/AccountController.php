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
    App\User,
    App\Block,
    Illuminate\Http\Request;

class AccountController extends Controller
{
    
    /**
     * @var  object
     */
    
    private $user = null;
    
    /**
     * Узнаем, что за юзер
     * 
     * @param  void
     * @return object class AccountController
     * @access public
     */
    
    public function __construct() {$this->user = User::first();}
    
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
        $stats = array(
            'ccBlocks'   => Block::where('site_id', 4)->count(),
            'ccPages'    => Page::where('site_id', 4)->count()
        );
        
        return view('account.overview', compact('sites', 'stats'));
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
