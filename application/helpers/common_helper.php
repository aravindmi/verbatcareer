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


function show_job_status($raw_id)
{
    switch ($raw_id) {

        case "1":
            return "<span class=\"label label-success\">Open</span>";
            break;
        case "0":
            return "<span class=\"label label-default\">Close</span>";
            break;
        default:
            return "";

    }
}

function show_applicant_status($raw_id)
{
    switch ($raw_id) {

        case "1":
            return "New";
            break;
        case "2":
            return "Shortlisted";
            break;
        case "3":
            return "Rejected";
            break;
        default:
            return "";

    }
}

function get_email($job_location)
{
    switch ($job_location) {

        case "India":
            return "hr.india@verbat.com";
            break;
        case "UAE":
            return "hr.uae@verbat.com";
            break;
        case "UK":
            return "hr.uk@verbat.com";
            break;
        case "USA":
            return "hr.usa@verbat.com";
            break;
        default:
            return "hr.india@verbat.com";
    }
}



