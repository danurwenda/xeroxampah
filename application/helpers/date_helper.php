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
    if (true) {
        // Define URL where the form resides
        $form_url = "'https://tci.polkam.go.id:7473/db/data/cypher'";

// This is the data to POST to the form. The KEY of the array is the name of the field. The value is the value posted.
    $data = array('query' => $q, 'params' => []);
        

// Initialize cURL
        $curl = curl_init();

// Set the options
        curl_setopt($curl, CURLOPT_URL, $form_url);

// This sets the number of fields to post
        curl_setopt($curl, CURLOPT_POST, sizeof($data));

// This is the fields to post in the form of an array.
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//execute the post
        $result = curl_exec($curl);

//close the connection
        curl_close($curl);
        if ($result === FALSE) {
            
        }
    }
}
