<?php

/**
 * Classic Metaboxes class.
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    PageRestrictForWooCommerce\Includes\Admin
 */
namespace PageRestrictForWooCommerce\Includes\Admin;

use PageRestrictForWooCommerce\Admin\Admin;
use PageRestrictForWooCommerce\Includes\Common\Page_Plugin_Options;

/**
 * Methods for metaboxes for the classic editor.
 *
 *
 * @package    PageRestrictForWooCommerce\Includes\Admin
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
class Classic_Metabox_Main {
	/**
	 * Initialize class instances and other variables.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
	}
	/**
     * Checks and prints appropriate data depending on whether the user bought a product.
     *
     * @since    1.0.0
	 * @return	 void
     */
    public function init_metabox(){
		$post_types = get_post_types( array('public' => true) );
		foreach($post_types as $post_type) { 
			add_meta_box( 'prwc_restrict_page', esc_html__( 'Restrict Page for WooCommerce', 'page_restrict_domain' ), array($this, 'display_metabox'), $post_type, 'side', 'high' );
		}
	}
	/**
     * Displays the metabox on the classic editor page.
     *
     * @since    1.0.0
     * @param    class    $post       Wordpress Post Class.
	 * @return	 void
     */
	public function display_metabox( $post ){
		$page_options_class = new Page_Plugin_Options();
		$prwc_limit_virtual_products         = $page_options_class->get_general_options('prwc_limit_to_virtual_products');
		$prwc_limit_downloadable_products    = $page_options_class->get_general_options('prwc_limit_to_downloadable_products');
		$prwc_post_types_general             = $page_options_class->get_general_options('prwc_general_post_types');

		foreach ($page_options_class->possible_page_options as $page_option => $type) {
			$$page_option      =   $page_options_class->get_page_options($post->ID, $page_option);
		}
		$plugin_name = PAGE_RESTRICT_WC_NAME;
		$nonce =   wp_nonce_field( $plugin_name . '-nonce', $plugin_name . '-nonce', true, false );
		include_once(PAGE_RESTRICT_WC_LOCATION_DIR."admin/partials/includes/all-menu-vars.php");
		include_once(PAGE_RESTRICT_WC_LOCATION_DIR."admin/partials/menu-pages/pages/pages-vars.php");
		include_once(PAGE_RESTRICT_WC_LOCATION_DIR."admin/partials/page-edit-classic-metabox.php");
	}
	/**
     * Saves metabox data on the classic editor page.
     *
     * @since    1.0.0
     * @param    int    $post_id       Post id.
	 * @return	 void
     */
	public function save_metabox( $post_id ){
		$auth_class = new Authorization_Checks();
		if(!$auth_class->check_authorization()){
			return;
		}
		$page_options_class = new Page_Plugin_Options();
		foreach ($page_options_class->possible_page_options as $page_option => $type) {
			if(is_array($_POST[$page_option])){
				$page_value = isset($_POST[$page_option])?array_map('sanitize_key',  $_POST[$page_option] ):'';
			}
			else{
				$page_value = isset($_POST[$page_option])?sanitize_key($_POST[$page_option] ):'';
			}
			if(is_array($page_value)){
				$page_value = implode(',', $page_value);
			}
			$pages_lock_data[$post_id][$page_option] = $page_options_class->sanitize_page_options($page_option, $page_value, $type);
		}
		$page_options_class->process_page_options($pages_lock_data);
	}
}