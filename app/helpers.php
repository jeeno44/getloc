<?php

/**
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

function prepareUri($uri)
{
    $uri = rtrim($uri, '/');
    $uri = str_replace('http://', '', $uri);
    return 'http://'.$uri.'/';
}

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
