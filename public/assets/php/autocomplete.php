<?php

$val = $_GET['value'];

    $json_data = '[{
        "caption": "translation-services/translation/technical-translation.html"
    },
    {
        "caption": "translation-services/translation/about.html"
    },
    {
        "caption": "translation-services/translation/services.html"
    },
    {
        "caption": "translation-services/translation/technical-translation.html"
    },
    {
        "caption": "translation-services/translation/about.html"
    },
    {
        "caption": "translation-services/translation/services.html"
    },
    {
        "caption": "translation-services/translation/technical-translation.html"
    },
    {
        "caption": "translation-services/translation/about.html"
    },
    {
        "caption": "translation-services/translation/services.html"
    }]';


$json_data = str_replace("\r\n",'',$json_data);
$json_data = str_replace("\n",'',$json_data);
echo $json_data;
exit;
?>
