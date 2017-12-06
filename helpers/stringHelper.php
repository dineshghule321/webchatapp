<?php


/**
 * ----------------------------------------------------------------------------------------
 * parse query and clean query from XSS and SQL Injections
 * ----------------------------------------------------------------------------------------
 * @param $string
 * @return string
 */
function cleanQuery($string)
{
    $string = htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    $string = trim($string);
    $string = addslashes($string);
    return $string;
}

function NOWTime()
{
    return date("Y-m-d H:i:s", time());
}

/**
 * @param $date
 * @param $timezone
 * @param $format
 * @return false|string
 */
function uDateTime($format, $date)
{


    if ($format == "") {
        $format = "d-m-Y h:i:s A";
    }

    if ($date == "") {
        $date = date($format);
    }
    $timezone = $_SESSION["timezone"];

    if ($timezone == "") {
        $timezone = "UTC";
    }

    $dateTimeZonec = new DateTimeZone($timezone);
    $dateTimeZone = new DateTime("now", $dateTimeZonec);
    $timeOffset = $dateTimeZonec->getOffset($dateTimeZone);
    if (strpos($date, '-') !== false || strpos($date, '/') !== false) {
        $offset_time = strtotime($date) + $timeOffset;
    } else {
        $offset_time = strtotime(date($format, $date / 1000)) + $timeOffset;
    }
    $finalDate = date($format, $offset_time);
    return $finalDate;
}


function getUTCTime($format, $TimeStr)
{
    $TimeZoneNameFrom = $_SESSION["timezone"];
    $TimeZoneNameTo = "UTC";
    return $bet_start_date = date_create($TimeStr, new DateTimeZone($TimeZoneNameFrom))
        ->setTimezone(new DateTimeZone($TimeZoneNameTo))->format($format);
}

?>