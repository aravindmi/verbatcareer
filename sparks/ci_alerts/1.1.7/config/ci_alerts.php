<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ci_alerts
 * 
 * The config file containing HTML for ci_alerts
 * 
 * @license		http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author		Mike Funk
 * @link		http://mikefunk.com
 * @email		mike@mikefunk.com
 * 
 * @file		ci_alerts.php
 * @version		1.1.7
 * @date		03/09/2012
 */

// --------------------------------------------------------------------------
/**
 * alert html
 * 
 * The html wrapping around alerts
 */
$config['before_all'] = '';
$config['before_each'] = '';
$config['before_error'] = '<div class="alert alert-danger alert-dismissable">';
$config['before_success'] = '<div class="alert alert-success alert-dismissable">';
$config['before_warning'] = '<div class="alert alert-warning alert-dismissable">';
$config['before_info'] = '';
$config['before_no_type'] = '<div class="alert alert-info fade in"><a class="close" href="#" data-dismiss="alert">&times;</a>';

$config['after_all'] = '';
$config['after_each'] = '<button class="close" type="button" data-dismiss="alert"><i class="fa fa-times"></i></button></div>';
$config['after_error'] = '';
$config['after_success'] = '';
$config['after_warning'] = '';
$config['after_info'] = '';
$config['after_no_type'] = '';

// --------------------------------------------------------------------------
/**
 * remove_duplicates
 * 
 * Whether to remove duplicate alerts
 */
$config['remove_duplicates'] = TRUE;

// --------------------------------------------------------------------------

/* End of file ci_alerts.php */
/* Location: ./ci_authentication/config/ci_alerts.php */