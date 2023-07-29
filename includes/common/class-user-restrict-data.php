<?php

/**
 * Gets users with bought products which are needed to access restricted pages.
 *
 * @link       vladogrcic.com
 * @since      1.1.1
 *
 * @package    PageRestrictForWooCommerce\Includes\Common
 */
namespace PageRestrictForWooCommerce\Includes\Common;
use PageRestrictForWooCommerce\Includes\Common\Helpers;
use PageRestrictForWooCommerce\Includes\Common\Page_Plugin_Options;
use PageRestrictForWooCommerce\Includes\WooCommerce\Products_Bought;
use PageRestrictForWooCommerce\Includes\Common\Restrict_Types;
/**
 * Gets users with bought products which are needed to access restricted pages.
 *
 * @package    PageRestrictForWooCommerce\Includes\Common
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
class User_Restrict_Data {
	/**
     * @since    1.1.1
     * @access   public
     * @var      class      $page_options    Initialize Page_Plugin_Options class.
     */
	public $page_options;
	/**
     * @since    1.1.1
     * @access   public
     * @var      class      $products_bought    Initialize Products_Bought class.
     */
	public $products_bought;
	/**
     * @since    1.1.1
     * @access   public
     * @var      class      $helpers    Initialize Helpers class.
     */
	public $helpers;
	/**
     * @since    1.1.1
     * @access   public
     * @var      class      $restrict    Initialize Restrict_Types class.
     */
	public $restrict;
	/**
     * @since    1.1.1
     * @access   public
     * @var      array      $locked_posts    Locked posts.
     */
	public $locked_posts;
	/**
	 * Initialize class instances and other variables.
	 *
	 * @since    1.1.1
	 */
	public function __construct() {
		$this->page_options = new Page_Plugin_Options();
		$this->products_bought = new Products_Bought();
		$this->helpers = new Helpers();
		$this->restrict = new Restrict_Types();
		$this->locked_posts = [];
	}
	/**
     * Products id array arranged by post id.
     *
     * @since      1.1.1
     * @param      array     $products_db       Product that are restricting posts.
     * @return     array
     */
	private function post_id_products( $products_db ){
		$postID_products = [];
		for ($i = 0; $i < count($products_db); $i++) {
			$postID_products[$products_db[$i]->post_id] = $products_db[$i]->meta_value;
		}	
		return $postID_products;
	}
	/**
	* Purchased products array.
	*
	* @since      1.1.1
	* @param      array     $postID_products       			  Post id products.
	* @return     array
	*/
	private function purchased_products_by_user( $postID_products, $user_id=false ){
		$purchased_products_by_user = [];
		$purchased_products = [];
		if($user_id){
			foreach ($postID_products as $post_id => $product_id) {
				$products = explode(',', $product_id);
				$products_arr = [];
				if (gettype($products) == "string") {
					$products_arr = array_map(function ($item) {
						return (int) trim($item);
					}, $products);
				} elseif (gettype($products) == "array") {
					$products_arr = $products;
				}
				$purchased_products = $this->products_bought->get_purchased_products_by_ids(
					$user_id,
					$products_arr
				);
				if($purchased_products){
					$user = get_userdata($user_id);
					$purchased_products_by_user[$post_id][$user_id] = [
						'purchased_products' => $purchased_products,
						'user' => $user,
					];
				}
			}
		}
		else{
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
			$users = get_users();
			foreach ($users as $user) {
				$user_id = $user->ID;
				foreach ($postID_products as $post_id => $product_id) {
					$products = explode(',', $product_id);
					$products_arr = [];
					if (gettype($products) == "string") {
						$products_arr = array_map(function ($item) {
							return (int) trim($item);
						}, $products);
					} elseif (gettype($products) == "array") {
						$products_arr = $products;
					}
					$purchased_products = $this->products_bought->get_purchased_products_by_ids(
						$user_id,
						$products_arr
					);
					if($purchased_products){
						$purchased_products_by_user[$post_id][$user_id] = [
							'purchased_products' => $purchased_products,
							'user' => $user,                    
						];
					}
				}
			}
		}
		return $purchased_products_by_user;
	}
	/**
	* Time data.
	*
	* @since      1.1.1
	* @param      array     $postID_products       			  Post id products.
	* @param      array     $purchased_products_by_user       Purchased products by user.
	* @param      bool      $single_user          			  Choose whether to get data just for a single user.
	* @return     array
	*/
	public function time_data( $postID_products, $purchased_products_by_user, $single_user ){
		$time_data = [];
		foreach ($purchased_products_by_user as $post_id => $users_data) {
			$products = isset($postID_products[$post_id]) && $postID_products[$post_id] ? explode(',', $postID_products[$post_id]) : [];
			$not_all_products_required = $this->page_options->get_page_options($post_id, 'prwc_not_all_products_required');
			$days = $this->page_options->get_page_options($post_id, 'prwc_timeout_days');
			$hours = $this->page_options->get_page_options($post_id, 'prwc_timeout_hours');
			$minutes = $this->page_options->get_page_options($post_id, 'prwc_timeout_minutes');
			$seconds = $this->page_options->get_page_options($post_id, 'prwc_timeout_seconds');
			$timeout_sec = abs($seconds + ($minutes * 60) + ($hours * 3600) + ($days * 86400));
				$this->locked_posts[$post_id]['post'] = get_post($post_id);
				foreach ($users_data as $sub_user_id => $user_data) {
					if($timeout_sec){
						$purchased_products = $user_data['purchased_products'];
					
						$this->restrict->products = $products;
						$this->restrict->user_id = $sub_user_id;
						$this->restrict->post_id = $post_id;
						$this->restrict->purchased_products = $purchased_products;
						$times_to_use = $this->restrict->check_time(
							$timeout_sec,
							true,
							$not_all_products_required
						);
						if (is_array($times_to_use)) {
							if(count($purchased_products_by_user[$post_id][$sub_user_id]['purchased_products'])){
								$this->locked_posts[$post_id]['time'] = [
									'days' 		=> $days,
									'hours' 	=> $hours,
									'minutes' 	=> $minutes,
									'seconds' 	=> $seconds,
								];
								if($single_user){
									$time_data[$post_id] = array_merge($times_to_use, [
										'restrict_by' => 'time',
										'user' => $user_data['user'], 
										'post' => get_post($post_id)
									]);
								}
								else{
									$time_data[$post_id][$sub_user_id] = array_merge($times_to_use, [
										'restrict_by' => 'time',
										'user' => $user_data['user']
									]);
								}
							}
						}
					}
					else{
						if($single_user){
							$time_data[$post_id] = [
								'restrict_by' => 'product',
								'user' => $user_data['user'], 
								'post' => get_post($post_id)
							];
						}
						else{
							$time_data[$post_id][$sub_user_id] = [
								'restrict_by' => 'product',
								'user' => $user_data['user']
							];
						}
					}
			}
			
			
		}
		return $time_data;
	}   
	/**
	* View data.
	*
	* @since      1.1.1
	* @param      array     $postID_products       			  Post id products.
	* @param      array     $purchased_products_by_user       Purchased products by user.
	* @param      bool      $single_user          			  Choose whether to get data just for a single user.
	* @return     array
	*/
	public function view_data( $postID_products, $purchased_products_by_user, $single_user ){
		$view_count_pages_users = $this->helpers->get_user_meta_values_with_views();
		$restricted_pages = $this->helpers->get_restricted_pages_by_views();
		$view_data = [];
		for ($i=0; $i < count($restricted_pages); $i++) { 
			$page = $restricted_pages[$i];
			$post_id = (int)$page->ID;
			$products = isset($postID_products[$post_id]) && $postID_products[$post_id] ? explode(',', $postID_products[$post_id]) : [];
			if(isset($purchased_products_by_user[$post_id])){
				foreach ($purchased_products_by_user[$post_id] as $user_id => $value) {
					$views = $this->page_options->get_page_options($post_id, 'prwc_timeout_views');
					if($views){
						if(count($purchased_products_by_user[$post_id][$user_id]['purchased_products'])){
							$not_all_products_required = $this->page_options->get_page_options($post_id, 'prwc_not_all_products_required');
							$this->locked_posts[$post_id]['post'] = get_post($post_id);
							$this->locked_posts[$post_id]['views'] = $views;

							$this->restrict->products = $products;
							$this->restrict->user_id = $user_id;
							$this->restrict->post_id = $post_id;
							// $this->restrict->products = $products_arr;
							$this->restrict->purchased_products = $purchased_products_by_user[$post_id][$user_id]['purchased_products'];
							$view_input_check = $this->restrict->check_views($views, true, $not_all_products_required);

							$merge_view_data = [
								'views' => 0,
								'view_expiration_num' => $view_input_check['views_to_compare'],
								'post' => get_post($post_id),
								'user' => $purchased_products_by_user[$post_id][$user_id]['user'],
							];
							if($single_user){
								$view_data[$post_id] = $merge_view_data;
							}
							else{
								$view_data[$post_id][$user_id] = $merge_view_data;
							}
						}
					}
				}
			}
			
			foreach ($view_count_pages_users as $index => $meta) {
				$post_id = (int)str_replace("prwc_view_count_","",$meta->meta_key);
				if($post_id != $page->ID) continue;
				$user_id = (int)str_replace("prwc_view_count_","",$meta->user_id);

				if(isset($purchased_products_by_user[$post_id])){
					$views = $this->page_options->get_page_options($post_id, 'prwc_timeout_views');
					if($views){
						if(count((array)$purchased_products_by_user[$post_id][$user_id]['purchased_products'])){
							$this->locked_posts[$post_id]['post'] = get_post($post_id);
							$this->locked_posts[$post_id]['views'] = $views;
		
							$this->restrict->user_id = $user_id;
							$this->restrict->post_id = $post_id;
							// $this->restrict->products = $products_arr;
							$this->restrict->purchased_products = $purchased_products_by_user[$post_id][$user_id]['purchased_products'];
							$view_input_check = $this->restrict->check_views($views, true, $not_all_products_required);

							$merge_view_data = array_merge(unserialize($meta->meta_value), [
								'view_expiration_num' => $view_input_check['views_to_compare'],
								'post' => get_post($post_id),
								'user' => $purchased_products_by_user[$post_id][$user_id]['user'],
							]);
							if($single_user){
								$view_data[$post_id] = $merge_view_data;
							}
							else{
								$view_data[$post_id][$user_id] = $merge_view_data;
							}
						}
					}
				}
			}
		}
		return $view_data;
	}
	/**
     * Return User_Restrict_Data data;
	 * 
     * @since    1.1.1
	 * @param    bool      $single_user          Choose whether to get data just for a single user.
	 * @return	 array
     */
	public function return_data($single_user=false, $user_id=false){
		$products_db = $this->helpers->get_meta_values('prwc_products');
		$postID_products = $this->post_id_products($products_db);
		
		$purchased_products_by_user = $this->purchased_products_by_user( $postID_products, $user_id );

		$time_data = $this->time_data( $postID_products, $purchased_products_by_user, $single_user );
		$view_data = $this->view_data( $postID_products, $purchased_products_by_user, $single_user );

		return [
			'locked_posts' => $this->locked_posts,
			'purchased_products_by_user' => $purchased_products_by_user,
			'time_data' => $time_data,
			'view_data' => $view_data,
		];
	}
}