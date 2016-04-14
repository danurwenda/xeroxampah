<?php

defined('BASEPATH') OR
        exit('No direct script access allowed');

function sqlDateToUTC($sqlDate) {
    list($y, $m, $da) = explode('-', $sqlDate);
    $m--;
    return "Date.UTC($y, $m, $da)";
}

function jsonToNeo4J($json) {
    $decoded = json_decode($json, true);
    return arrayToString($decoded);
}

function arrayToString($arr) {
    $label_prop = '';
    foreach ($arr as $key => $value) {
        switch (gettype($value)) {
            case 'boolean':
            case 'integer':
            case 'double':
            case 'NULL';
                $label_prop.="$key:$value,";
                break;
            case 'string':
                $label_prop.="$key:'$value',";
                break;
            case 'array':
                $label_prop.="$key:{" . arrayToString($value) . '},';
                break;
            default:
                break;
        }
    }
    return substr($label_prop, 0, -1);
}

function postNeoQuery($q) {
    if (false) {
        $url = 'https://tci.polkam.go.id:7473/db/data/cypher';
        $data = array('query' => $q, 'params' => []);

        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === FALSE) {
            
        }
    }
}
