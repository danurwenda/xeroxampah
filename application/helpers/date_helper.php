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

function postNeoQueryArr($arrQ) {
    if (true) {
        $statements = [];
        foreach ($arrQ as $q) {
            $statements[] = ['statement' => $q];
        }
        $data = [
            'statements' => $statements
        ];
        $data_string = json_encode($data);
        //print_r($data_string);
//open connection
        $ci=& get_instance();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ci->config->item('NEO_URL'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json; charset=UTF-8', 'Content-Type: application/json', 'Content-Length: ' . strlen($data_string), 'X-Stream: true'));
//curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//execute post
        $result = curl_exec($ch);
//echo
        //echo $result;
//close connection
        curl_close($ch);
    }
}

function postNeoQuery($q) {
    if (is_array($q)) {
        foreach ($q as $qq) {
            postNeoQuery($qq);
        }
    } else {
        
        if (true) {
            $data = [
                'statements' => [
                    [
                        'statement' => $q
                    ]
                ]
            ];
            $data_string = json_encode($data);
            //print_r($data_string);
//open connection
            $ch = curl_init();
            $ci=& get_instance();
            curl_setopt($ch, CURLOPT_URL, $ci->config->item('NEO_URL'));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json; charset=UTF-8', 'Content-Type: application/json', 'Content-Length: ' . strlen($data_string), 'X-Stream: true'));
//curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//execute post
            $result = curl_exec($ch);
//echo
            //echo $result;
//close connection
            curl_close($ch);
        }
    }
}
