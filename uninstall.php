<?php

/**
 * Fired when the plugin is uninstalled.
 *
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    PageRestrictForWooCommerce
 */
use PageRestrictForWooCommerce\Includes\Common\Page_Plugin_Options;

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
require_once(dirname(__FILE__).'/includes/common/class-page-plugin-options.php');
$page_options_class = new Page_Plugin_Options();
$prwc_delete_plugin_data_on_uninstall        =   $page_options_class->get_general_options('prwc_delete_plugin_data_on_uninstall');

if($prwc_delete_plugin_data_on_uninstall){
	$options = [];
	$page_meta = [];
	foreach ($page_options_class->possible_page_options as $meta_key => $type) {
		$page_meta[] = $meta_key;
	}
	foreach ($page_options_class->possible_general_options as $meta_key => $type) {
		$options[] = $meta_key;
	}
	for ($i=0; $i < count($options); $i++) { 
		delete_option($options[$i]);
	}
	global $wpdb;
	for ($i=0; $i < count($page_meta); $i++) { 
		$wpdb->query( 
				"DELETE FROM $wpdb->postmeta WHERE meta_key='$page_meta[$i]'"
		);
	}
	
	$meta_key_del = 'prwc_view_count_';
	$wpdb->query( 
			"DELETE FROM $wpdb->usermeta WHERE meta_key LIKE '".$meta_key_del."%'"
	);
}