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