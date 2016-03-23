<?php

/**
 * Check is logged in
 */
if (!function_exists('logged_in')) {

    function logged_in()
    {
        $CI = &get_instance();

        return (bool)$CI->session->userdata('user_id');
    }

}

/**
 * Check is admin
 */

if (!function_exists('is_admin')) {

    function is_admin()
    {
        $CI = &get_instance();

        if ($CI->session->userdata('role_id') == '1') {

            return true;
        } else {

            return false;
        }
    }

}

/**
 * @param string $timestamp
 * @param string $format
 * @return string
 */

function show_date($timestamp = '', $format = 'd-m-Y')
{
    if ($timestamp == '' || $timestamp == '0000-00-00 00:00:00' || $timestamp == '0000-00-00') {
        return '';
    }
    try {
        //$mysql_date = strtotime($timestamp);
        $date = new DateTime($timestamp);
        return $date->format($format);
    } catch (Exception $baddob) {
        return '';
    }
}

/**
 * @param string $given_date
 * @param bool $srttotime
 * @return bool|string
 */
function add_date($given_date = '', $srttotime = false)
{

    if ($given_date == '') {
        return '0000-00-00 00:00:00';
    }
    try {
        if ($srttotime) {

            $date = date('Y-m-d H:i:s', $given_date);
        } else {

            $date = date('Y-m-d H:i:s', strtotime($given_date));
        }

        //return strtotime($given_date);

        return $date;
    } catch (Exception $baddob) {

        return '0000-00-00 00:00:00';
    }
}

/**
 * @param string $given_date
 * @param bool $srttotime
 * @return bool|string
 */
function add_date_only($given_date = '', $srttotime = false)
{

    if ($given_date == '') {
        return '0000-00-00';
    }
    try {
        if ($srttotime) {

            $date = date('Y-m-d', $given_date);
        } else {

            $date = date('Y-m-d', strtotime($given_date));
        }

        //return strtotime($given_date);

        return $date;
    } catch (Exception $baddob) {

        return '0000-00-00';
    }
}

function is_same($value1, $value2)
{
    if ($value1 == $value2) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function is_grade_count($db_grade, $given_grade)
{
    if (isset($db_grade[$given_grade])) {
        return $db_grade[$given_grade]['candidate_count'];
    } else {
        return 0;
    }
}

function is_grade_amount($db_grade, $given_grade)
{
    if (isset($db_grade[$given_grade])) {
        return $db_grade[$given_grade]['amount'];
    } else {
        return 0;
    }
}

function get_amountxcount($count, $amount)
{
    $total = array();
    foreach ($count as $key => $value) {
        $total[] = $value * $amount[$key];
    }

    return $total;
}

function conver_classname($raw_name)
{
    switch (trim($raw_name)) {

        case "LKG":
            return "LKG";
            break;
        case "UKG":
            return "UKG";
            break;
        case "1":
            return "I";
            break;
        case "2":
            return "II";
            break;
        case "3":
            return "III";
            break;
        case "4":
            return "IV";
            break;
        case "5":
            return "V";
            break;
        case "6":
            return "VI";
            break;
        case "7":
            return "VII";
            break;
        case "8":
            return "VIII";
            break;
        case "9":
            return "IX";
            break;
        case "10":
            return "X";
            break;
        default:
            return "";

    }
}



