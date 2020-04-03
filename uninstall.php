<?php

/**
 * Fired when the plugin is uninstalled.
 *
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    Page_Restrict_Wc
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
require_once(dirname(__FILE__).'/admin/includes/class-page-restrict-admin-page-plugin-options.php');
$page_options_class = new Page_Restrict_Wc_Page_Plugin_Options();
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
	$page_meta_for_user = [];
	for ($i=0; $i < count($page_meta); $i++) { 
		$page_IDs = get_post_id_by_meta_key($page_meta[$i]);
		if($page_meta[$i] == 'prwc_timeout_views'){
			$page_meta_for_user = $page_IDs;
		}
		if(count($page_IDs))
			for ($j=0; $j < count($page_IDs); $j++) { 
				delete_post_meta($page_IDs[$j], sanitize_text_field($page_meta[$i]));
			}
	}
	$meta_key_del = 'prwc_view_count_';
	for ($i=0; $i < count($page_meta_for_user); $i++) { 
		$user_IDs = get_user_id_by_meta_key($meta_key_del);
		if(count($user_IDs))
			for ($j=0; $j < count($user_IDs); $j++) { 
				delete_user_meta($user_IDs[$j], $meta_key_del.$page_meta_for_user[$i]);
			}
	}
}
/**
 * Get post IDs from all meta fields with specified key.
 *
 * @since    1.0.0
 * @param    array    $key        Meta key to search for in postmeta table.
 * @return   array
 */
function get_post_id_by_meta_key($key) {
	global $wpdb;
	$IDs = [];
	$meta = $wpdb->get_results("SELECT * FROM `".$wpdb->postmeta."` WHERE meta_key='".($key)."'");
	for ($i=0; $i < count($meta); $i++) { 	
		$IDs[] = $meta[$i]->post_id;
	}
	return $IDs;
}
/**
 * Get user IDs from all meta fields with specified key.
 *
 * @since    1.0.0
 * @param    array    $key        Meta key to search for in usermeta table.
 * @return   array
 */
function get_user_id_by_meta_key($key) {
	global $wpdb;
	$IDs = [];
	$meta = $wpdb->get_results("SELECT * FROM `".$wpdb->usermeta."` WHERE meta_key LIKE '".$key."%'");
	for ($i=0; $i < count($meta); $i++) { 	
		$IDs[] = $meta[$i]->user_id;
	}
	return $IDs;
}
