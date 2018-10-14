<?php
function formatMoney($number, $fractional=false) {
    if ($fractional) {
        $number = sprintf('%.2f', $number);
    }
    while (true) {
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
        if ($replaced != $number) {
            $number = $replaced;
        } else {
            break;
        }
    }
    
    return $number;
}

function getInvoiceToken() {
    return date('mYHdis');
}

function clean($str) {
    $str = @trim($str);
    if(get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }
    return $str;
}

function getTodayDate(){
    return date('Y-m-d');
    
}

function getDuedate(){
    return date('Y-m-d',strtotime("+10 days"));
    
}

function getCustomDate($indate){
    $date=date_create($indate);
    return date_format($date,"d-M-Y");
}

?>