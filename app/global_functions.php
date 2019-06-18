<?php
function getExcelDate($excel_date) {
    $unix_date = ($excel_date - 25569) * 86400;
    return gmdate('Y-m-d', $unix_date);
}

function getFormatDate($val) {
    $date = explode(' ', $val);

    $day = $date[0];
    $month = getMonthNumber($date[1]);
    $year = $date[2];

    return $year.'-'.$month.'-'.$day;
}

function getMonthNumber($val) {
    switch($val) {
        case 'Jan':
            return '01';
            break;
        
        case 'Feb':
            return '02';
            break;

        case 'Mar':
            return '03';
            break;

        case 'Apr':
            return '04';
            break;

        case 'Mei':
            return '05';
            break;

        case 'Jun':
            return '06';
            break;

        case 'Jul':
            return '07';
            break;

        case 'Aug':
            return '08';
            break;

        case 'Sep':
            return '09';
            break;

        case 'Okt':
            return '10';
            break;

        case 'Nov':
            return '11';
            break;

        case 'Des':
            return '12';
            break;
    }
}