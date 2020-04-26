<?php

/**
 * Helper classes
 *
 * @link       vladogrcic.com
 * @since      1.1.0
 *
 * @package    Page_Restrict_Wc
 * @subpackage Page_Restrict_Wc/includes
 */
namespace PageRestrictForWooCommerce\Includes;
use PageRestrictForWooCommerce\Admin_Facing\Page_Plugin_Options;
use PageRestrictForWooCommerce\Admin_Facing\Products_Bought;
use PageRestrictForWooCommerce\Admin_Facing\Restrict_Types;
/**
 * General classes that can be used for both public and admin pages.
 *
 * @package    Page_Restrict_Wc
 * @subpackage Page_Restrict_Wc/includes
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
	public function calc_pagination($data, $limit=2){
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
     * Gets inputted data paginated.
     *
     * @since    1.1.0
	 * @param    bool    $single_user          Choose whether to get data just for a single user.
	 * @return	 array
     */
	public function user_restrict_data($single_user=false){
		$page_options = new Page_Plugin_Options();
		$products_bought = new Products_Bought();
		$postID_products = [];
		$products_db = $this->get_meta_values('prwc_products', 'page');
		for ($i = 0; $i < count($products_db); $i++) {
			$postID_products[$products_db[$i]->post_id] = $products_db[$i]->meta_value;
		}
		/**
		 *  $purchased_products_by_user = [
		 *      post_id => [
		 *          user_id => [
		 *              WC_Order_Item_Product
		 *          ]
		 *      ],
		 *      post_id => [
		 *          user_id => [
		 *              WC_Order_Item_Product
		 *          ]
		 *      ],
		 *  ];
		 */
		$purchased_products_by_user = [];
		$users = get_users();
		foreach ($users as $user) {
			$user_id = $user->ID;
			foreach ($postID_products as $post_id => $product_id) {
				$products = explode(',', $product_id);
				if (gettype($products) == "string") {
					$products_arr = array_map(function ($item) {
						return (int) trim($item);
					}, explode(",", $products));
				} elseif (gettype($products) == "array") {
					$products_arr = $products;
				}
				$purchased_products = $products_bought->get_purchased_products_by_ids(
					$user_id,
					$products_arr
				);
				$purchased_products_by_user[$post_id][$user_id] = [
					'purchased_products' => $purchased_products,
					'user' => $user,                    
				];
			}
		}
		$time_data = [];
		$restrict = new Restrict_Types();
		foreach ($purchased_products_by_user as $post_id => $value) {
			$products = explode(',', $postID_products[$post_id]);
			$days = $page_options->get_page_options($post_id, 'prwc_timeout_days');
			$hours = $page_options->get_page_options($post_id, 'prwc_timeout_hours');
			$minutes = $page_options->get_page_options($post_id, 'prwc_timeout_minutes');
			$seconds = $page_options->get_page_options($post_id, 'prwc_timeout_seconds');
			$timeout_sec = abs($seconds + ($minutes * 60) + ($hours * 3600) + ($days * 86400));
			foreach ($value as $sub_user_id => $subvalue) {
				$user_id = $sub_user_id;
				$purchased_products = $subvalue['purchased_products'];
				
				$times_to_use = $restrict->check_time(
					$timeout_sec,
					$purchased_products,
					true
				);
				if (is_array($times_to_use) && $timeout_sec) {
					if(count($purchased_products_by_user[$post_id][$user_id]['purchased_products'])){
						$locked_posts[$post_id]['post'] = get_post($post_id);
						$locked_posts[$post_id]['time'] = [
							'days' 		=> $days,
							'hours' 	=> $hours,
							'minutes' 	=> $minutes,
							'seconds' 	=> $seconds,
						];
						if($single_user){
							if((int)$single_user === (int)$user_id){
								$time_data[$post_id] = array_merge($times_to_use, ['username' => $subvalue['user'], 'post' => get_post($post_id)]);
							}
						}
						else{
							$time_data[$post_id][$user_id] = array_merge($times_to_use, ['username' => $subvalue['user']]);
						}
					}
				}
			}
		}
		global $wpdb;
		$view_count_pages_users = $wpdb->get_results("SELECT * FROM `".$wpdb->usermeta."` WHERE meta_key LIKE 'prwc_view_count_%'");
		$view_data = [];
		foreach ($view_count_pages_users as $index => $meta) {
			$post_id = (int)str_replace("prwc_view_count_","",$meta->meta_key);
			
			$user_id = (int)str_replace("prwc_view_count_","",$meta->user_id);
			if(isset($purchased_products_by_user[$post_id])){
				$views = $page_options->get_page_options($post_id, 'prwc_timeout_views');
				if(/*!isset($locked_posts[$post_id]['post']) && */$views){
					if(count($purchased_products_by_user[$post_id][$user_id]['purchased_products'])){
						$locked_posts[$post_id]['post'] = get_post($post_id);
						$locked_posts[$post_id]['views'] = $views;
						$view_input_check = $restrict->check_views( $user_id, $post_id, $views, $purchased_products_by_user[$post_id][$user_id]['purchased_products'], true);
						$merge_view_data = array_merge(unserialize($meta->meta_value), [
							'view_expiration_num' => $view_input_check['views_to_compare'],
							'post' => get_post($post_id),
							'user' => $purchased_products_by_user[$post_id][$user_id]['user'],
						]);
						if($single_user){
							if((int)$single_user === (int)$user_id){
								$view_data[$post_id] = $merge_view_data;
							}
						}
						else{
							$view_data[$post_id][$user_id] = $merge_view_data;
						}
					}
				}
			}
		}
		return [
			'locked_posts' => $locked_posts,
			'time_data' => $time_data,
			'view_data' => $view_data,
		];
	}
}