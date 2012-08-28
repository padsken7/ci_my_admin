<?php 

// обрезание строки до нужной длины
function cut_string($string, $maxlen) {
    $len = (mb_strlen($string) > $maxlen)
        ? mb_strripos(mb_substr($string, 0, $maxlen), ' ')
        : $maxlen
    ;
    $cutStr = mb_substr($string, 0, $len);
    return (mb_strlen($string) > $maxlen)
        ? $cutStr. '...'
        : $cutStr
    ;
}

// функция приведения даты в нормальный вид
function date_reverse($date)
{
	$date_arr = explode('-', $date);
	return $date = $date_arr[2].".".$date_arr[1].".".$date_arr[0];
}

// uppercase певрой буквы
if(!function_exists('mb_ucfirst'))
{
    function mb_ucfirst($str, $encoding = NULL)
    {
        if($encoding === NULL)
        {
            $encoding    = mb_internal_encoding();
        }
        
        return mb_substr(mb_strtoupper($str, $encoding), 0, 1, $encoding) . mb_substr($str, 1, mb_strlen($str)-1, $encoding);
    }
}