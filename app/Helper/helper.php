<?php
use Hekmatinasser\Verta\Verta;

function jalaliToGergia($value, $spliter = '/', $exitSpliter = '-'){
    $date = explode($spliter , $value); // 1400  03   01  Part Part mikone  
    $date = Verta::getGregorian($date[0],$date[1],$date[2]);   // Convert To Milady Date  2021  5  22 
    $date = implode($exitSpliter ,$date);  // 2021-5-22  implode Mikone
    return $date;
}