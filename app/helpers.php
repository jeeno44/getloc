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
        if (mb_strpos($contentType, 'text/html', 0, 'UTF-8') !== false && $code < 400) {
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
    try{
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true);
        $response = curl_exec ($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close ($ch);
        if (!empty($code) && $code < 400) {
            return $response;
        }
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
    $uri = str_replace('http://', '', $uri);
    return 'http://'.$uri.'/';
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

/**
 * Обрезка URL
 * @param string $url
 * @return string
 */
function beautyUrl($url)
{
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
 * Получаем id последнего оплаченного переведеннго блока (table translates)
 * @param \App\User $user
 * @return int
 */
function rebuildAvailableTranslates(\App\User $user)
{
    
}

/**
 * Получаем новую дату при смене тарифа пользователем
 * @param \App\User $user
 * @param \App\Plan $newPlan
 * @return string
 */
function calculateEndAt(\App\User $user, \App\Plan $newPlan)
{
   
}

/**
 * Списко языков в формате json
 * @return string
 */
function getLanguagesJson()
{
    $languages = [];
    foreach (\App\Language::all() as $lang) {
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
function getStatus($key)
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