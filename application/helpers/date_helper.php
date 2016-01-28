<?php

defined('BASEPATH') OR
    exit('No direct script access allowed');
 function sqlDateToUTC($sqlDate) {
        list($y, $m, $da) = explode('-', $sqlDate);
        $m--;
        return "Date.UTC($y, $m, $da)";
    }

