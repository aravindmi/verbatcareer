<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * Local server Data Base configuration
 * 
 * @package		Project Management
 * @author		Prasanth Mathew <prasanth.mathew@verbat.com>
 * @copyright           Copyright (c) 2014, Verbat Techonologies, Inc.
 * @license		www.verbat.com//user_guide/license.html
 * @since		Version 1.0
 * @filesource
 */


//TABLE INFO


$database_tables = array(
    'TBL_SCHOOLS' => 'schools',
    'TBL_CANDIDATES' => 'candidates',
    'TBL_EVENTS' => 'events',
    'TBL_ASSIGN_FORMS' => 'assign_forms',
    'TBL_BADGE_TYPE' => 'badge_types_master',
    'TBL_CONTACTS' => 'contacts',
    'TBL_COUNTRIES' => 'countries_master',
    'TBL_DOCUMENTS' => 'documents',
    'TBL_FORM_TEMPLATES' => 'form_template_master',
    'TBL_ORDERS' => 'orders',
    'TBL_ORDERS_PRODUCTS' => 'orders_products',
    'TBL_PRODUCTS' => 'products',
    'TBL_PRODUCT_STOCK' => 'product_stock',
    'TBL_SHOWS' => 'shows',
    'TBL_STAND_TYPES' => 'stand_types_master',
    'TBL_STATUS' => 'status_master',
    'TBL_COMPONENTS' => 'form_components',
    'TBL_SHOW_CATEGORIES' => 'show_categories_master',
    'TBL_EVENT_THEME' => 'event_themes_master',
    'TBL_EXHIBITORS' => 'exhibitors',
    'TBL_EXHIBITORS_TEMP' => 'exhibitors_temp',
    'TBL_EXHIBITOR_CUSTOM_STATUS' => 'exhibitor_custom_status_master',
    'TBL_COMPONENTS_EXHIBITOR' => 'form_components_exhibitor',
    'TBL_ORDERS' => 'orders',
    'TBL_ORDERS_DETAILS' => 'order_details',
    'TBL_BILLING_INFO' => 'billing_info',
    'TBL_DOCUMENT_TYPE' => 'document_types_master',
    'TBL_EXHIBITOR_CONTACTS' => 'exhibitor_contacts',
    'TBL_EXHIBITOR_CONTACT_TYPES' => 'exhibitor_contact_types_master',
    'TBL_ADMIN_FEES' => 'admin_fees_master',
    'TBL_LOGIN_ACTIVITY' => 'exhibitor_login_activity',
    'TBL_PAYMENTS' => 'payments',
    'TBL_LAYOUT_SETTINGS' => 'layout_settings',
    'TBL_FEEDS' => 'feeds',
    'TBL_TOKENS' => 'tokens',
    'TBL_AUDIT_TRAIL' => 'audit_trail',
    'TBL_AUDIT_TRAIL_TYPE' => 'audit_trail_type_master',
    'TBL_PAGE_SETTINGS' => 'page_settings_master'

);

$config['DB_TABLES'] = $database_tables;

/* End of file db.constants.php */
/* Location: ./application/config/db.constants.php */