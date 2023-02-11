<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    PageRestrictForWooCommerce\Front
  */
namespace PageRestrictForWooCommerce\Front;
use PageRestrictForWooCommerce\Includes\Front\My_Account;

use PageRestrictForWooCommerce\Includes\WooCommerce\Products_Bought;

use PageRestrictForWooCommerce\Includes\Common\Page_Plugin_Options;
use PageRestrictForWooCommerce\Includes\Common\Restrict_Types;
use PageRestrictForWooCommerce\Includes\Common\Section_Blocks;
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    PageRestrictForWooCommerce\Front
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
class Front {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/css/front.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/js/front.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Initiating processing page content to restrict.
	 *
	 * @since    1.0.0
	 * @param    string		$content 	Page content.
	 * @return	 void
	 */
    public function initiate_process_page($content)
	{
		$restrict_process = new Section_Blocks();
		if(!is_admin()){
			return $restrict_process->process_page($content);
		}
	}

	/**
	 * Initiating processing page content to restrict for redirecting if required.
	 *
	 * @since    1.0.0
	 * @param    string		$content 	Page content.
	 * @return	 void
	 */
    public function initiate_process_page_redirect()
	{
		$restrict_process = new Section_Blocks();
		if(!is_admin()){
			return $restrict_process->process_page_redirect();
		}
	}
	/**
	 * Adds or updates the page view count for users.
	 *
	 * @since    1.0.0
	 * @return	 void
	 */
	public function update_user_view_count(){
		$section_blocks 	= new Section_Blocks();
		$restrict_types 	= new Restrict_Types();
		$products_bought 	= new Products_Bought();

		$user_id = get_current_user_id();
		$post_id = get_the_ID();

		$days         =   $section_blocks->page_options->get_page_options($post_id, 'prwc_timeout_days');
        $hours        =   $section_blocks->page_options->get_page_options($post_id, 'prwc_timeout_hours');
        $minutes      =   $section_blocks->page_options->get_page_options($post_id, 'prwc_timeout_minutes');
        $seconds      =   $section_blocks->page_options->get_page_options($post_id, 'prwc_timeout_seconds');
		$timeout_sec  =   abs($seconds+($minutes*60)+($hours*3600)+($days*86400));

		$views 		  =   $section_blocks->page_options->get_page_options($post_id, 'prwc_timeout_views');
		$products     =   $section_blocks->page_options->get_page_options($post_id, 'prwc_products');
		$not_all_products_required     = $section_blocks->page_options->get_page_options($post_id, 'prwc_not_all_products_required');

		if(!($views && $products)){
			return;
		}
		
		if (gettype($products) == "string") {
			$products_arr = array_map(function ($item) {
				return (int)trim($item);
			}, explode(",", $products));
		} elseif (gettype($products) == "array") {
			$products_arr = $products;
		}
		$purchased_products = $products_bought->get_purchased_products_by_ids(
			$user_id,
			$products_arr
		);

		$restrict_types->user_id = $user_id;
		$restrict_types->post_id = $post_id;
		$restrict_types->products = $products_arr;
		$restrict_types->purchased_products = $purchased_products;

		$check_views = $restrict_types->check_views($views, true, $not_all_products_required);
		$check_final = $restrict_types->check_final_all_types(
			$timeout_sec,
			$views,
			$not_all_products_required
		);
		
		$meta_value = [
			'views' => 1,
			'viewed' => 0
		];
		if($check_views['view'] && $check_final && count($purchased_products)){
			if($check_views['view_count'] !== ''){
				if($check_views['view_count'] >= $check_views['views_to_compare']){
					$meta_value['views'] = (int)$check_views['view_count'];
					$meta_value['viewed'] = 1;
				}
				else{
					$meta_value['views'] = (int)$check_views['view_count']+1;
					$meta_value['viewed'] = 0;
				}
			}
			update_user_meta( $user_id, "prwc_view_count_$post_id", $meta_value);
		}
	}
	/**
	 * Adds a page to the WooCommerce My Account page.
	 *
	 * @since    1.1.0
	 * @return	 void
	 */
	public function wc_my_account_page(){
		$page_options = new Page_Plugin_Options();
		$prwc_my_account_rp_page_disable_endpoint = $page_options->get_general_options('prwc_my_account_rp_page_disable_endpoint');
		$wc_my_account = new My_Account(!$prwc_my_account_rp_page_disable_endpoint);
		add_filter( 'woocommerce_account_menu_items', array( $wc_my_account, 'account_menu_items' ), 10, 1 );
		add_action( 'woocommerce_account_restrict-pages-overview_endpoint', function() use($page_options, $wc_my_account){
			$prwc_my_account_rp_page_hide_time_table = $page_options->get_general_options('prwc_my_account_rp_page_hide_time_table');
			$prwc_my_account_rp_page_hide_view_table = $page_options->get_general_options('prwc_my_account_rp_page_hide_view_table');
			$wc_my_account->restrict_pages_overview_endpoint_content( $prwc_my_account_rp_page_hide_time_table, $prwc_my_account_rp_page_hide_view_table );
		});
	}
}
