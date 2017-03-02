<?php

/**
 * Получить код ответа сервера
 * @param string $url
 * @return int|null
 */
function getPageCode($url)
{
    if (empty($url)) {
        return null;
    }
    $url = rtrim($url, '/');
    $url = strtolower($url);
    try{
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec ($ch);
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);
        if (strpos($contentType, 'text/html') !== false && $code < 400) {
            return $code;
        }
        return null;
    } catch (Exception $e) {
        Log::error($e->getMessage());
        return null;
    }
}

/**
 * Получить контент страницы
 * @param string $url
 * @return string|null
 */
function getPageContent($url)
{
    $url = rtrim($url, '/');
    $url = strtolower($url);
    try{
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true);
        $response = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);
        if (isset($code) && $code < 400) {
            return $response;
        }
        Log::info($url.' - '.$code);
        return null;
    } catch (Exception $e) {
        Log::error($e->getMessage());
        return null;
    }
}

/**
 * Приведение урлов к единому стандарту
 * @param $uri
 * @return string
 */
function prepareUri($uri)
{
    $uri = rtrim($uri, '/');
    $url = strtolower($uri);   

    return $uri;
}

/**
 * Транслитерация типа
 * @param $str
 * @return string
 */
function testTranslate($str)
{
    $converter = [

        'а' => 'a',   'б' => 'b',   'в' => 'v',
        'г' => 'g',   'д' => 'd',   'е' => 'e',
        'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
        'и' => 'i',   'й' => 'y',   'к' => 'k',
        'л' => 'l',   'м' => 'm',   'н' => 'n',
        'о' => 'o',   'п' => 'p',   'р' => 'r',
        'с' => 's',   'т' => 't',   'у' => 'u',
        'ф' => 'f',   'х' => 'h',   'ц' => 'c',
        'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
        'ь' => '',  'ы' => 'y',   'ъ' => '',
        'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

        'А' => 'A',   'Б' => 'B',   'В' => 'V',
        'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
        'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',
        'И' => 'I',   'Й' => 'Y',   'К' => 'K',
        'Л' => 'L',   'М' => 'M',   'Н' => 'N',
        'О' => 'O',   'П' => 'P',   'Р' => 'R',
        'С' => 'S',   'Т' => 'T',   'У' => 'U',
        'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
        'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',
        'Ь' => '',  'Ы' => 'Y',   'Ъ' => '',
        'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',

    ];
    $str =  strtr($str, $converter);
    return $str;
}

/**
 * Отправка запроса к api.get-loc.ru
 * @param string $getaway
 * @param array $data
 */
function sendApiQuery($getaway, $data)
{
    $fields = http_build_query($data);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $getaway);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $fields);
    curl_exec($curl);
    curl_close($curl);
}

function ruDate($date){
    $timestamp = strtotime($date);
    $d = date('d', $timestamp);
    $y = date('Y', $timestamp);
    $m = date('m', $timestamp);
    $h = date('H', $timestamp);
    $i = date('i', $timestamp);
    switch($m) {
        case '01': $m = 'января'; break;
        case '02': $m = 'февраля'; break;
        case '03': $m = 'марта'; break;
        case '04': $m = 'апреля'; break;
        case '05': $m = 'мая'; break;
        case '06': $m = 'июня'; break;
        case '07': $m = 'июля'; break;
        case '08': $m = 'августа'; break;
        case '09': $m = 'сентября'; break;
        case '10': $m = 'октября'; break;
        case '11': $m = 'ноября'; break;
        default: $m = 'декабря';
    }
    return "{$d} {$m} {$y} - {$h}:{$i}";
}

/**
 * Обрезка URL
 * @param string $url
 * @return string
 */
function beautyUrl($url)
{
    if (strpos('_'.$url, 'https:') > 0) {
        return trim(str_replace('https://', '', $url), '/');
    }
    return trim(str_replace('http://', '', $url), '/');
}

/**
 * @param string $class
 * @return mixed
 */
function widget($class)
{
    return app('App\Widgets\\'.$class)->run();
}

/**
 * Устанавливаем ID последнего блока, входящего в подписку
 * @param \App\Subscription $subscription
 * @return void
 */
function rebuildAvailableBlocks(\App\Subscription $subscription)
{
    $maxCountWords = $subscription->count_words;
    $countWords = 0;
    $lastBlockId = null;
    $blocks = \App\Block::where('site_id', $subscription->site_id)->where('enabled', 1)->get();
    foreach ($blocks as $block) {
        if ($block->count_words + $countWords <= $maxCountWords) {
            $lastBlockId = $block->id;
        }
        $countWords += $block->count_words;
        if ($countWords > $maxCountWords) {
            break;
        }
    }
    if ($lastBlockId) {
        $subscription->last_id = $lastBlockId;
        $subscription->save();
    }
}

/**
 * Списко языков в формате json
 * @return string
 */
function getLanguagesJson()
{
    $languages = [];
    foreach (\App\Language::orderBy('sort')->get() as $lang) {
        $languages[] = [
            'id' => $lang->id,
            'name'  => $lang->name,
            'src' => '/icons/'.$lang->icon_file,
        ];
    }
    return json_encode(['languages' => $languages]);
}

/**
 * Название статуса по ключу
 * @param string $key
 * @return string
 */
function getPaymentStatus($key)
{
    $statuses = [
        'new'           => '<span class="label label-info">Новый</span>',
        'confirmed'     => '<span class="label label-success">Обработан</span>',
        'canceled'      => '<span class="label label-default">Отменен</span>'
    ];
    if (!empty($statuses[$key])) {
        return $statuses[$key];
    }
    return '';
}

/**
 * Название статуса по ключу
 * @param string $key
 * @return string
 */
function getOrderStatus($key)
{
    $statuses = [
        'new'           => '<span class="label label-info">Новый</span>',
        'wait'          => '<span class="label label-primary">Ожидает оплаты</span>',
        'process'       => '<span class="label label-primary">В работе</span>',
        'done'          => '<span class="label label-success">Завершен</span>',
        'canceled'      => '<span class="label label-default">Отменен</span>'
    ];
    if (!empty($statuses[$key])) {
        return $statuses[$key];
    }
    return '';
}

/**
 * @param \App\Translate $trans
 * @param \App\Site $site
 * @throws Exception
 * @return void
 */
function autoTranslate($trans, $site)
{
    $clientID     = "blackgremlin2";
    $clientSecret = "SMnjwvLx0bB2u9Cn05K2vkTE1bSkX0+fsLp/23gsytU=";
    $authUrl      = "https://datamarket.accesscontrol.windows.net/v2/OAuth2-13/";
    $scopeUrl     = "http://api.microsofttranslator.com";
    $grantType    = "client_credentials";
    $authObj      = new \Blackgremlin\Microsofttranslator\AccessTokenAuthentication();
    $accessToken  = $authObj->getTokens($grantType, $scopeUrl, $clientID, $clientSecret, $authUrl);
    $authHeader = "Authorization: Bearer ". $accessToken;
    $translatorObj = new \Blackgremlin\Microsofttranslator\HTTPTranslator();
    $inputStr = $trans->block->text;
    $translateUri = "http://api.microsofttranslator.com/v2/Http.svc/Translate?text=" .urlencode($inputStr). "&from=".$site->language->short."&to=".$trans->language->short;
    $strResponse = $translatorObj->curlRequest($translateUri, $authHeader);
    $xmlObj = simplexml_load_string($strResponse);
    $text = strval($xmlObj[0]);
    $trans->text = $text;
    $trans->type_translate_id = 1;
    $trans->save();
}

/**
 * @param string $key
 * @return array|mixed
 */
function getCouponTypes($key = '') {
    $types = [
        'once'          => 'Разовый',
        'fixed'         => 'Действителен до',
        'unlimited'     => 'Бессрочный'
    ];
    if (!empty($key) && !empty($types[$key])) {
        return $types[$key];
    }
    return $types;
}

/**
 * Проверка состояния купона
 * @param string $code
 * @param int $siteId
 * @return bool
 */
function getCouponState($code, $siteId)
{
    $site = \App\Site::find($siteId);
    $coupon = \App\Coupon::where('code', $code)->first();
    if (!$coupon
        || !$site
        || $coupon->enabled == 0
        || ($coupon->type == 'fixed' && $coupon->ends_at <= date('Y-m-d H:i:s'))
        || ($coupon->site_id != null && $coupon->site_id != $site->id)
        || ($coupon->user_id != null && $coupon->user_id != $site->user_id)) {
        return null;
    }
    return $coupon;
}

/**
 * Обновление состояния купона
 * @param \App\Coupon $coupon
 * @param \App\Site $site
 */
function updateCouponState($coupon, $site)
{
    if($coupon->activated_at == '0000-00-00 00:00:00') {
        $coupon->activated_at = date('Y-m-d H:i:s');
    }
    if($coupon->site_id == null) {
        $coupon->site_id = $site->id;
    }
    if($coupon->user_id == null) {
        $coupon->user_id = $site->user->id;
    }
    if($coupon->type == 'once' || ($coupon->type == 'fixed' && $coupon->ends_at <= date('Y-m-d H:i:s'))) {
        $coupon->enabled = 0;
    }
    $coupon->save();
}

function getDurations()
{
    $items =  [
        1   => trans('phrases.1_month'),
        3   => trans('phrases.3_months_discount'),
        6   => trans('phrases.6_months_discount'),
        12  => trans('phrases.1_year_discount'),
    ];
    return $items;
}

function getDurationsByKey($key = 0)
{
    $items =  [
        1   => trans('phrases.1_month'),
        3   => trans('phrases.3_months'),
        6   => trans('phrases.6_months'),
        12  => trans('phrases.1_year'),
    ];
    return !empty($items[$key]) ? $items[$key] : $items;
}

/**
 * Размер скидки платежа в зависимости от срока
 * @param int $key
 * @return int
 */
function getDiscountByTime($key)
{
    $discounts = [
        1   => 0,
        3   => 15,
        6   => 20,
        12  => 25
    ];
    return !empty($discounts[$key]) ? $discounts[$key] : 0;
}

/**
 * Расчет итоговой суммы для оплаты
 * @param float $cost
 * @param string $code
 * @param int $siteId
 * @param int $time
 * @return float
 */
function getSubTotal($cost, $code, $siteId, $time = 0)
{
    $subtotal = $cost * $time;
    $couponDiscount = 0;
    if ($coupon = getCouponState($code, $siteId)) {
        if ($coupon->is_percent == 0) {
            $couponDiscount = $coupon->discount;
        } else {
            $couponDiscount = $subtotal / 100 * $coupon->discount;
        }
        $site = \App\Site::find($siteId);
        if ($site) {
            updateCouponState($coupon, $site);
        }
    }
    $subtotal = $subtotal - $couponDiscount;
    $timeDiscount = getDiscountByTime($time);
    $timeDiscountSum = $subtotal / 100 * $timeDiscount;
    $subtotal = $subtotal - $timeDiscountSum;
    if ($subtotal < 0) {
        $subtotal = 0;
    }
    return $subtotal;
}

/**
 * @param $cost
 * @param $code
 * @param $siteId
 * @return int
 */
function getOrderSubTotal($cost, $code, $siteId)
{
    $subtotal = $cost;
    $couponDiscount = 0;
    if ($coupon = getCouponState($code, $siteId)) {
        if ($coupon->is_percent == 0) {
            $couponDiscount = $coupon->discount;
        } else {
            $couponDiscount = $subtotal / 100 * $coupon->discount;
        }
        $site = \App\Site::find($siteId);
        if ($site) {
            updateCouponState($coupon, $site);
        }
    }
    $subtotal = $subtotal - $couponDiscount;
    if ($subtotal < 0) {
        $subtotal = 0;
    }
    return $subtotal;
}

function getCountOrders($siteID = null)
{
    if ($siteID) {
        $count = \App\Order::where('site_id', $siteID)->whereIn('status', ['process', 'wait'])->count();
        if ($count > 0) {
            return '<span>'.$count.'</span>';
        }
    }
    return '';
}

function array_to_xml(array $arr, SimpleXMLElement $xml)
{
    foreach ($arr as $k => $v) {
        is_array($v)
            ? array_to_xml($v, $xml->addChild('item'))
            : $xml->addChild($k, $v);
    }
    return $xml;
}

function messageAboutTariff()
{
    $projectID = Session::get('projectID');
    if (!$projectID) {
        return '';
    }
    $project = \App\Site::find($projectID);
    if (!$project || empty($project->subscription)) {
        return '';
    }
    if ($project->count_words > $project->subscription->count_words || $project->languages()->count() > $project->subscription->count_languages) {
        return view('partials.tariff-message', compact('project'));
    }
    return '';
}

function trimStrLen($str, $len = 100)
{
    if (mb_strlen($str, 'utf-8') > $len) {
        return mb_substr($str, 0, $len, 'utf-8').'...';
    }
    return $str;
}

function strPosInArr($haystack, $needles, $offset=0)
{
    $chr = [];
    foreach($needles as $needle) {
        $res = strpos($haystack, $needle, $offset);
        if ($res !== false) $chr[$needle] = $res;
    }
    if(empty($chr)) return false;
    return min($chr);
}

function accountMenu()
{
    $path = \Request::path();
    $disable = \Session::has('projectID') ? '' : 'disabled';
    $siteID     = \Session::get('projectID');
    if ($siteID) {
        $site       = \App\Site::find($siteID);
    }
    if (!empty($site) && $site->demo == 1) {
        $items = [
            trans('account.menu_analytics')         => [
                trans('account.menu_site_create')       => ['account/add-project', ''],
                trans('account.menu_text_collect')      => ['account/collect', $disable],
                trans('account.menu_docs_images')       => ['account/docs', $disable],
                'Добавить проект на локализацию'  => ['account/build', ''],
            ],
            trans('account.menu_site_translate')    => [

                trans('account.menu_site_langs')        => ['account/languages', 'disabled'],
                trans('account.menu_project_pages')     => ['account/pages', 'disabled'],
                trans('account.menu_manage_trans')      => ['account/phrase', 'disabled'],
                trans('account.menu_import')            => ['account/import', 'disabled'],
            ],
            trans('account.menu_integration')       => [
                trans('account.menu_widget')            => ['account/widget', 'disabled'],
                trans('account.menu_code')              => ['account/code', 'disabled'],
                trans('account.menu_payment')           => ['account/payment', 'disabled'],
            ],
            trans('account.menu_account')           => [
                trans('account.menu_my_profile')        => ['account/personal', ''],
                trans('account.menu_my_payments')       => ['account/payments', ''],
            ],
        ];
    } else {
        $items = [
            trans('account.menu_analytics')         => [
                trans('account.menu_site_create')       => ['account/add-project', ''],
                trans('account.menu_text_collect')      => ['account/collect', $disable],
                trans('account.menu_docs_images')       => ['account/docs', $disable],
                trans('account.menu_project_review')    => ['account/overview', $disable],
            ],
            trans('account.menu_site_translate')    => [
                trans('account.menu_site_langs')        => ['account/languages', $disable],
                trans('account.menu_project_pages')     => ['account/pages', $disable],
                trans('account.menu_manage_trans')      => ['account/phrase', $disable],
                trans('account.menu_import')            => ['account/import', $disable],
            ],
            trans('account.menu_integration')       => [
                trans('account.menu_widget')            => ['account/widget', $disable],
                trans('account.menu_code')              => ['account/code', $disable],
                //trans('account.menu_payment')           => ['account/payment', $disable],
            ],
            trans('account.menu_account')           => [
                trans('account.menu_my_profile')        => ['account/personal', ''],
                trans('account.menu_my_payments')       => ['account/payments', ''],
            ],
        ];
    }

    return view('partials.new-account-menu', compact('items', 'path'));
}
