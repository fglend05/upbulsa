<?php

function esc($str)
{
    return htmlspecialchars($str);
}

function show($stuff)
{
    echo "<pre>";
    print_r($stuff);
    echo "</pre>";
}

function console_log($output, $with_script_tags = true)
{
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) .
        ');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}

function redirect($path)
{
    header("Location: " . ROOT . "/" . $path);
    die;
}

function extractData($dataArray, $key, $returnAssociative = false)
{
    $result = array();

    foreach ($dataArray as $data) {
        $extracted = $returnAssociative ? (array)$data : json_decode(json_encode($data), true);

        if (isset($extracted[$key])) {
            $result[] = $extracted[$key];
        }
    }

    return $result;
}
