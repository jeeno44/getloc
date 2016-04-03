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
        if (Site::where('id', $id)->where('user_id', $this->user->id)->first()) {
            Session::set('projectID', $id);
            return redirect(URL::route('main.account.overview'));
        } else {
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
        $siteID = Session::get('projectID');
        $site = Site::find($siteID);
        if (!$siteID || !$site) {
            return redirect(URL::route('main.account.selectProject'));
        }
        $ccBlocks = Block::where('site_id', $siteID)->count();

        if (Page::where('site_id', $siteID)->count() == Page::where('site_id', $siteID)->where('collected', 1)->count()) {
            $stats = array(
                'ccBlocks' => Block::where('site_id', $siteID)->count(),
                'ccPages' => Page::where('site_id', $siteID)->count(),
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
        $langs = Site::find($siteID)->languages()->orderBy('name')->get();

        foreach ($langs as $lang) {
            $ccTranslate = Translate::where('site_id', $siteID)->where('language_id', $lang->id)->whereNotNull('type_translate_id')->count();
            $graph = round(($ccTranslate / $allCountBlocks) * 100);

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
        $data = array();
        $langs = Site::find($siteID)->languages()->where('enabled', 1)->orderBy('name')->get();

        foreach ($langs as $lang) {
            $stats = array();
            $stats['notLangTrans'] = Translate::where('site_id', $siteID)->where('language_id', $lang->id)->where('type_translate_id', NULL)->count(); //Не переведено в этом языке
            $dynamicStats = DB::table('translates')->join('types_translates', 'translates.type_translate_id', '=', 'types_translates.id')
                ->select('types_translates.name', DB::raw('count(*) as cc'))
                ->where('site_id', $siteID)
                ->where('language_id', $lang->id)
                ->groupBy('translates.type_translate_id')
                ->lists('cc', 'types_translates.name'); //Остальные типы
            $_lines = array_merge($dynamicStats, $stats);
            $lines = array();
            $iter = 1;

            foreach ($_lines as $key => $line) {
                if ($allCountBlocks == 0)
                    continue;

                if ($key == 'notLangTrans') {
                    $graph = array('cc' => $line, 'i' => '4', 'name' => 'Не переведено', 'per' => round(($line / $allCountBlocks) * 100));
                } else {
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

        if (!$siteID || !$site) {
            return abort(403, 'Need select project');
        }
        $status = (DB::table('sites_settings')->where('site_id', $siteID)->first()->auto_translate == 1) ? 0 : 1;

        DB::table('sites_settings')->where('site_id', $siteID)->update(array('auto_translate' => $status));

        if ($status) {
            return trans('account.successAutoTranslate');
        } else {
            return trans('account.failAutoTranslate');
        }
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
        $site = Site::find($siteID);

        if (!$siteID || !$site)
            return abort(403, 'Need select project');

        $status = (DB::table('sites_settings')->where('site_id', $siteID)->first()->auto_publishing == 1) ? 0 : 1;

        DB::table('sites_settings')->where('site_id', $siteID)->update(array('auto_publishing' => $status));

        if ($status)
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
        $data = array();
        $langs = Site::find($siteID)->languages()->where('enabled', true)->orderBy('name')->get();

        foreach ($langs as $lang) {
            $stats = array();
            $stats['ccTranslates'] = Translate::where('site_id', $siteID)->where('language_id', $lang->id)->whereNotNull('type_translate_id')->count(); //Сколько переведено в этом языке
            $stats['notLangTrans'] = Translate::where('site_id', $siteID)->where('language_id', $lang->id)->where('type_translate_id', NULL)->count(); //Не переведено в этом языке
            $dynamicStats = DB::table('translates')->join('types_translates', 'translates.type_translate_id', '=', 'types_translates.id')
                ->select('types_translates.name', DB::raw('count(*) as cc'))
                ->where('site_id', $siteID)
                ->where('language_id', $lang->id)
                ->groupBy('translates.type_translate_id')
                ->pluck('cc', 'types_translates.name'); //Остальные типы
            $_lines = array_merge($dynamicStats, $stats);
            $lines = array();
            $iter = 1;

            foreach ($_lines as $key => $line) {
                if ($key == 'ccTranslates')
                    continue;

                if ($key == 'notLangTrans') {
                    $graph = array('cc' => $line, 'i' => '4', 'name' => 'Не переведено', 'per' => round(($line / $allCountBlocks) * 100));
                } else {
                    $graph = array('cc' => $line, 'i' => $iter, 'name' => $key, 'per' => round(($line / $allCountBlocks) * 100));
                    $iter++;
                }

                $lines[] = $graph;
            }

            $data['on'][$lang->name]['ccTranslates'] = $stats['ccTranslates'];
            $data['on'][$lang->name]['langID'] = $lang->id;
            $data['on'][$lang->name]['lines'] = $lines;
        }

        $langs = Site::find($siteID)->languages()->where('enabled', false)->orderBy('name')->get();

        foreach ($langs as $lang) {
            $stats = array();
            $stats['ccTranslates'] = Translate::where('site_id', $siteID)->where('language_id', $lang->id)->whereNotNull('type_translate_id')->count(); //Сколько переведено в этом языке
            $stats['notLangTrans'] = Translate::where('site_id', $siteID)->where('language_id', $lang->id)->where('type_translate_id', NULL)->count(); //Не переведено в этом языке
            $dynamicStats = DB::table('translates')->join('types_translates', 'translates.type_translate_id', '=', 'types_translates.id')
                ->select('types_translates.name', DB::raw('count(*) as cc'))
                ->where('language_id', $lang->id)
                ->where('site_id', $siteID)
                ->groupBy('translates.type_translate_id')
                ->lists('cc', 'types_translates.name'); //Остальные типы
            $_lines = array_merge($dynamicStats, $stats);
            $lines = array();
            $iter = 1;

            foreach ($_lines as $key => $line) {
                if ($key == 'ccTranslates')
                    continue;

                if ($key == 'notLangTrans') {
                    $graph = array('cc' => $line, 'i' => '4', 'name' => 'Не переведено', 'per' => round(($line / $allCountBlocks) * 100));
                } else {
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
        
        $stats = $this->generateStatsForPhraseFilter($siteID, $languageID);  
        
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
        if (!$siteID = Session::get('projectID')) {
            return redirect(URL::route('main.account.selectProject'));
        }

        $site = Site::find($siteID);
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
        if (!$siteID = Session::get('projectID')) {
            return redirect(URL::route('main.account.selectProject'));
        }

        $newLangs = $request->get('languages', []);
        $langs = Site::find($siteID)->languages();

        #DB::table('site_language')->where('site_id', $siteID)->update(['enabled' => 0]);
        foreach ($newLangs as $langID) {
            if ($lang = DB::table('site_language')->where('site_id', $siteID)->where('language_id', $langID)->get())
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

        if (!$siteID)
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

        $filter['stats']['menu'] = array(1 => 0, 2 => 0, 3 => 0);
        $filter['stats']['in_translate'] = Translate::where('site_id', $siteID)->where('language_id', $languageID)->whereNotNull('type_translate_id')->count(); //Сколько переведено в этом языке
        $filter['stats']['not_translate'] = Translate::where('site_id', $siteID)->where('language_id', $languageID)->where('type_translate_id', NULL)->count(); //Не переведено в этом языке
        $filter['stats']['publish'] = Translate::where('site_id', $siteID)->where('language_id', $languageID)->where('enabled', 1)->count();
        $filter['stats']['all'] = DB::table('translates')->join('types_translates', 'translates.type_translate_id', '=', 'types_translates.id')
            ->select('types_translates.id', DB::raw('count(*) as cc'))
            ->where('site_id', $siteID)
            ->where('language_id', $languageID)
            ->groupBy('translates.type_translate_id')
            ->get();

        foreach ($filter['stats']['all'] as $key => $val)
            $filter['stats']['menu'][$val->id] = $val->cc;

        $filter['stats']['all'] = array_sum(array_values($filter['stats']['menu']));
        $filter['colors'] = [1 => array('block' => 'blue', 'hex' => '#18baea'),
            2 => array('block' => 'green', 'hex' => '#70d579'),
            3 => array('block' => 'orange', 'hex' => '#ffa630')];

        $filter['menu'] = array();

        $filter['menu']['langs'] = Site::find($siteID)->languages()->where('enabled', true)->orderBy('name')->get(); //Доступные языки
        $filter['menu']['types'] = TypeTranslate::orderBy('id')->get();
        $filter['menu']['active_lang'] = $languageID;
        $filter['menu']['active_type'] = Session::get('filter')['typeID'];

        foreach ($filter['menu']['langs'] as $lang) {
            $ccNull = Translate::where('site_id', $siteID)->where('language_id', $lang->id)->whereNotNull('type_translate_id')->count();
            $ccTrans = Translate::where('site_id', $siteID)->where('language_id', $lang->id)->count();

            $filter['stats']['proc'][$lang->id] = round(($ccNull / $ccTrans) * 100);
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
        $tab = $request->get('view_page');

        Session::set('filter', $filter);

        if ($request->get('clearFilter'))
            Session::set('filter', NULL);

        return redirect()->back();
    }

    /**
     * Без перевода, первый таб.
     * @TODO: Команды
     *
     * @param  Request $request
     * @return stringphraseAjaxRender
     * @access public
     */

    public function phraseNotTranslatesTab(Request $request)
    {
        #Session::set('filter', NULL);
        $siteID = Session::get('projectID');
        $tab_name = 'tab_not_translated';
        $viewType = Session::get('typeViewID', 1);
        $filterDef = 0;

        if (!$siteID)
            return redirect(URL::route('main.account.selectProject'));

        $languageID = Session::get('filter')['languageID'];

        if (!$languageID) {
            $languageID = Site::find($siteID)->languages()->where('enabled', true)->orderBy('id')->first()->id;
            $filterDef = 1;
        }

        $filter = $this->generateStatsForPhraseFilter($siteID, $languageID);
        $buildQuery = Translate::where('translates.site_id', $siteID)
            ->where('translates.language_id', $languageID)
            ->where('translates.enabled', 1)
            ->where('translates.type_translate_id', NULL)
            ->leftJoin('blocks', 'blocks.id', '=', 'translates.block_id')
            ->leftJoin('types_translates', 'types_translates.id', '=', 'translates.type_translate_id')
            ->orderBy('translates.id')
            ->select('translates.id as tid', 'blocks.enabled as enabled', 'translates.*',
                'types_translates.name as name_translate', DB::raw('date_format(translates.updated_at, "%h:%i") as time'),
                DB::raw('date_format(translates.updated_at, "%Y-%m-%d") as date'), 'blocks.text as original');

        $blocks = $buildQuery->paginate(25);

        return view('account.phrase', compact('tab_name', 'blocks', 'filter', 'viewType', 'filterDef'));
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

        $ids = $request->get('ids', []);
        $status = $request->get('status');

        if (!in_array($status, $allowed_status))
            $status = 0;

        DB::table('translates')->whereIn('id', $ids)->update(array('enabled' => $status));
        
        $siteID     = Session::get('projectID');
        $languageID = Session::get('filter')['languageID'];

        if (!$languageID)
            $languageID = Site::find($siteID)->languages()->where('enabled', true)->orderBy('id')->first()->id;
        
        $stats = $this->generateStatsForPhraseFilter($siteID, $languageID);
        
        return json_encode(array('message' => trans('account.success'), 'stats' => $stats['stats']));
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
        $type = $request->get('typeViewID', 1);

        if (!in_array($type, $allowed_type))
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

        $siteID = Session::get('projectID');
        $viewType = Session::get('typeViewID', 1);
        $filterDef = 0;
        $languageID = Session::get('filter')['languageID'];

        if (!$languageID)
            $languageID = Site::find($siteID)->languages()->where('enabled', true)->orderBy('id')->first()->id;

        $text = trim(strip_tags($request->get('text')));
        $id = intval($request->get('id'));
        $trans = Translate::find($id);

        $trans->text = $text;
        $trans->type_translate_id = $request->get('type', 2);
        $trans->updated_at = date('Y-m-d H:i:s');
        $trans->save();

        $stats = $this->generateStatsForPhraseFilter($siteID, $languageID);

        $block = Translate::where('translates.id', $id)
            ->leftJoin('blocks', 'blocks.id', '=', 'translates.block_id')
            ->leftJoin('types_translates', 'types_translates.id', '=', 'translates.type_translate_id')
            ->orderBy('translates.id')
            ->select('translates.id as tid', 'blocks.enabled as enabled', 'translates.*',
                'types_translates.name as name_translate', DB::raw('date_format(translates.updated_at, "%h:%i") as time'),
                DB::raw('date_format(translates.updated_at, "%Y-%m-%d") as date'), 'blocks.text as original')->first();


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
        $filter = $request->get('filter');
        $tab = $request->get('tab');
        $viewType = Session::get('typeViewID', 1);

        Session::set('filter', $filter);

        if ($request->get('clearFilter'))
            Session::set('filter', NULL);

        $siteID = Session::get('projectID');
        $viewType = Session::get('typeViewID', 1);

        if (!$siteID)
            return redirect(URL::route('main.account.selectProject'));

        $json = array();
        $languageID = Session::get('filter')['languageID'];
        $filter = $this->generateStatsForPhraseFilter($siteID, $languageID);
        $blocks = $this->buildQueryPhrase($tab, $siteID, $languageID);

        $json['html'] = (String)\View::make('account.phraseAjax', compact('blocks', 'filter', 'viewType', 'tab'))->render();
        unset($filter['menu']['langs']);
        $json['info'] = $filter;

        return json_encode($json, JSON_HEX_QUOT | JSON_HEX_TAG);
    }

    /**
     * Генерируем запрос на получение фраз
     *
     * @param  string $type
     * @return array
     * @access public
     */

    private function buildQueryPhrase($type, $siteID, $languageID)
    {
        $buildQuery = null;

        switch ($type) {
            case 'tab_not_translated':
            default:
                $buildQuery = Translate::where('translates.site_id', $siteID)
                    ->where('translates.language_id', $languageID)
                    ->where('translates.type_translate_id', NULL)
                    ->leftJoin('blocks', 'blocks.id', '=', 'translates.block_id')
                    ->leftJoin('types_translates', 'types_translates.id', '=', 'translates.type_translate_id')
                    ->orderBy('translates.id')
                    ->select('translates.id as tid', 'blocks.enabled as enabled', 'translates.*',
                        'types_translates.name as name_translate', DB::raw('date_format(translates.updated_at, "%h:%i") as time'),
                        DB::raw('date_format(translates.updated_at, "%Y-%m-%d") as date'), 'blocks.text as original');
                break;
            case 'tab_translated':
                $buildQuery = Translate::where('translates.site_id', $siteID)
                    ->where('translates.language_id', $languageID)
                    ->whereNotNull('translates.type_translate_id')
                    ->leftJoin('blocks', 'blocks.id', '=', 'translates.block_id')
                    ->leftJoin('types_translates', 'types_translates.id', '=', 'translates.type_translate_id')
                    ->orderBy('translates.id')
                    ->select('translates.id as tid', 'blocks.enabled as enabled', 'translates.*',
                        'types_translates.name as name_translate', DB::raw('date_format(translates.updated_at, "%h:%i") as time'),
                        DB::raw('date_format(translates.updated_at, "%Y-%m-%d") as date'), 'blocks.text as original');

                if (Session::get('filter')['typeID'])
                    $buildQuery->where('translates.type_translate_id', '=', Session::get('filter')['typeID']);
                break;
            case 'tab_published':
                $buildQuery = Translate::where('translates.site_id', $siteID)
                    ->where('translates.language_id', $languageID)
                    ->where('blocks.enabled', '=', 1)
                    ->leftJoin('blocks', 'blocks.id', '=', 'translates.block_id')
                    ->leftJoin('types_translates', 'types_translates.id', '=', 'translates.type_translate_id')
                    ->orderBy('translates.id')
                    ->select('translates.id as tid', 'blocks.enabled as enabled', 'translates.*',
                        'types_translates.name as name_translate', DB::raw('date_format(translates.updated_at, "%h:%i") as time'),
                        DB::raw('date_format(translates.updated_at, "%Y-%m-%d") as date'), 'blocks.text as original');

                if (Session::get('filter')['typeID'])
                    $buildQuery->where('translates.type_translate_id', '=', Session::get('filter')['typeID']);
            break;
            case 'tab_acrhive':
                $buildQuery = Translate::where('translates.site_id', $siteID)
                    ->where('translates.language_id', $languageID)
                    ->where('translates.enabled', 0)
                    ->leftJoin('blocks', 'blocks.id', '=', 'translates.block_id')
                    ->leftJoin('types_translates', 'types_translates.id', '=', 'translates.type_translate_id')
                    ->orderBy('translates.id')
                    ->select('translates.id as tid', 'blocks.enabled as enabled', 'translates.*',
                        'types_translates.name as name_translate', DB::raw('date_format(translates.updated_at, "%h:%i") as time'),
                        DB::raw('date_format(translates.updated_at, "%Y-%m-%d") as date'), 'blocks.text as original');
            break;
        }

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
        if (!$siteID = Session::get('projectID'))
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
        if (!Session::get('projectID')) {
            return redirect(URL::route('main.account.selectProject'));
        }

        $siteID = Session::get('projectID');
        $langs = Site::find($siteID)->languages()->orderBy('name')->get();
        $ccBlocks = Block::where('site_id', $siteID)->count();
        $lineStats = $this->getLangsStats($siteID, $ccBlocks);

        return view('account.languages', compact('langs', 'lineStats', 'ccBlocks'));
    }



    public function ajaxRenderingTitlePages(Request $request)
    {
        $ret_data = [];
        $tab = $request->input('tab');
        $viewType = Session::get('typeViewID', 1);
        $blocks = $this->buildQueryTitle($request->input('site_id'), $request->input('value'));
        $ret_data['html'] = (String)\View::make('account.titleAjax', compact('blocks'))->render();
        $ret_data['data'] = $request->input();
        $ret_data['success'] = true;
        return $ret_data;
    }

    public function ajaxRenderingBlocksPages(Request $request)
    {
        $ret_data = [];
        $tab = $request->input('tab');
        $viewType = Session::get('typeViewID', 1);
        $filter = $this->generateStatsForPhraseFilter($request->input('site_id'), $request->input('language_id'));
        $blocks = $this->buildQueryBlocks($request->input('site_id'), $request->input('page_id'), $request->input('language_id'));
        $ret_data['html'] = (String)\View::make('account.pagesAjax', compact('blocks', 'filter', 'viewType', 'tab'))->render();
        $ret_data['data'] = $request->input();
        $ret_data['success'] = true;
        return $ret_data;
    }

    public function buildQueryTitle($site_id, $value)
    {
        return Page::where('site_id', $site_id)->where('url', 'LIKE', '%' . $value . '%')->get();
    }

    public function buildQueryBlocks($site_id, $page_id, $language_id)
    {
        return Page::where('pages.site_id', $site_id)
	        ->where('pages.id', $page_id)
	        ->leftJoin('page_block', 'page_block.page_id', '=', 'pages.id')
	        ->leftJoin('blocks', 'blocks.id', '=', 'page_block.block_id')
	        ->leftJoin('translates', function($join) use ($language_id) {
		        $join->on('translates.block_id', '=', 'page_block.block_id')
			        ->where('translates.language_id', '=', $language_id);
	        })
	        ->leftJoin('types_translates', 'types_translates.id', '=', 'translates.type_translate_id')
	        ->orderBy('pages.id')
	        ->select('translates.id as tid', 'pages.*', 'blocks.text as original', 'translates.*')
	        ->paginate(25);
    }
}
