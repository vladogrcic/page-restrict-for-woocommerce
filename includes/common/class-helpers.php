<?php

/**
 * Helper classes
 *
 * @link       vladogrcic.com
 * @since      1.1.0
 *
 * @package    PageRestrictForWooCommerce\Includes\Common
 */
namespace PageRestrictForWooCommerce\Includes\Common;
use PageRestrictForWooCommerce\Includes\Common\Page_Plugin_Options;
use PageRestrictForWooCommerce\Includes\WooCommerce\Products_Bought;
use PageRestrictForWooCommerce\Includes\Common\Restrict_Types;
/**
 * General classes that can be used for both public and admin pages.
 *
 * @package    PageRestrictForWooCommerce\Includes\Common
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
class Helpers {
	/**
	 * Initialize class instances and other variables.
	 *
	 * @since    1.1.0
	 */
	public function __construct() {
	}
	/**
     * Converts seconds to this format: 2 days, 23 hours, 29 minutes and 59 seconds
     *
     * @since    1.1.0
     * @param    int    	$seconds       		Seconds.
     * @param    string     $custom_format      Date and time format to print it.
	 * @return	 string
     */
	public function seconds_to_dhms($seconds, $custom_format='%a days, %h hours, %i minutes and %s seconds'){
		$dtF = new \DateTime('@0');
		$dtT = new \DateTime("@$seconds");
		return $dtF->diff($dtT)->format($custom_format);
	}
	/**
     * Gets meta values by searching by meta_key value.
     *
     * @since    1.1.0
     * @param    string    $key       Meta key.
     * @param    string    $type      Post type.
     * @param    string    $status    Post status.
	 * @return	 array
     */
	public function get_meta_values($key = '', $type = 'post', $status = 'publish'){
		global $wpdb;
		if (empty($key)) {
			return;
		}
		$r = $wpdb->get_results($wpdb->prepare("
			SELECT pm.post_id, pm.meta_key, pm.meta_value FROM {$wpdb->postmeta} pm
			LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
			WHERE pm.meta_key = %s
			AND p.post_status = %s
			AND p.post_type = %s
		", $key, $status, $type));
		return $r;
	}
	/**
     * Gets inputted data paginated.
     *
     * @since    1.1.0
     * @param    string    $data          Data to paginate.
     * @param    int    $limit         Number of pages.
	 * @return	 array
     */
	public function calc_pagination(array $data, int $limit=2){
		$pages_inc = 0;
		$page = 1;
		$total = count( $data );
		$totalPages = ceil( $total/ $limit );
		$page = max($page, 1);
		$page = min($page, $totalPages);
		$offset = ($page - 1) * $limit;
		if( $offset < 0 ) $offset = 0;
		$page_users_paginated = [];
		$offsetGroup = 0;
		for ($t=0; $t < $totalPages; $t++) { 
			$offset = $t;
			if($t !== 0){
				$offsetGroup = $offsetGroup+$limit;
			}
			$page_users_paginated[] = array_slice( $data, $offsetGroup, $limit, true );
		}
		return [
			'totalPages' => $totalPages,
			'page_users_paginated' => $page_users_paginated,
		];
	}
	/**
     * Gets user meta from users with a views key.
     *
     * @since    1.1.1
	 * @return	 array
     */
	public function get_user_meta_values_with_views(){
		global $wpdb;
		$view_count_pages_users = $wpdb->get_results("SELECT * FROM `".$wpdb->usermeta."` WHERE meta_key LIKE 'prwc_view_count_%'");
		return $view_count_pages_users;
	}
}