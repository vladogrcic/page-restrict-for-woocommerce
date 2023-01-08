<?php

/**
 * Shortcode class.
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    PageRestrictForWooCommerce\Includes\Admin
 */
namespace PageRestrictForWooCommerce\Includes\Admin;
use PageRestrictForWooCommerce\Includes\Common\Section_Blocks;
use PageRestrictForWooCommerce\Includes\Front\Restricted_Pages_List_Blocks;
use PageRestrictForWooCommerce\Includes\Common\Page_Plugin_Options;
/**
 * Methods for shortcodes.
 *
 *
 * @package    PageRestrictForWooCommerce\Includes\Admin
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
class Shortcodes {
	/**
	 * Section_Blocks class instance.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $section_block    The current version of the plugin.
	 */
	protected $section_block;
	/**
	 * Initialize class instances and other variables.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->section_block = new Section_Blocks();
	}
	/**
     * Checks and prints appropriate data depending on whether the user bought a product.
     *
     * @since    1.0.0
     * @param    string    $atts       Shortcode attributes.
     * @param    string    $content    Shortcode content.
	 * @return	 string
     */
    public function is_purchased(array $atts, string $content){
		return $this->section_block->process_section($atts, $content);
	}
	/**
     * Checks and prints appropriate data depending on whether the user bought a product.
     *
     * @since    1.1.0
     * @param    array     $atts       Shortcode atts.
     * @param    string    $content    Shortcode content.
	 * @return	 string
     */
    public function restricted_pages_list( $atts, string $content){
		if(is_array($atts)){
			$a = shortcode_atts(array(
				'table' => 'time',
				'disable_table_class' => 'false',
			), $atts);
		}
		else{
			$a = [
				'table' => 'time',
				'disable_table_class' => 'false',
			];
		}
		if(is_user_logged_in()){
			$Restricted_Pages_List = new Restricted_Pages_List_Blocks();
			$print = '';
			if($a['table'] === 'time'){
				$print = $Restricted_Pages_List->process_restricted_pages_list_time( $a['disable_table_class'] );
			}
			if($a['table'] === 'view'){
				$print = $Restricted_Pages_List->process_restricted_pages_list_view( $a['disable_table_class'] );
			}
			return $print;
		}
	}
	/**
     * 
     *
     * @since    1.6.0
     * @param    array     $atts       Shortcode atts.
     * @param    string    $content    Shortcode content.
	 * @return	 string
     */
    public function get_restricted_pages_products( $atts, string $content){
		$product_urls = "";
		$post_id = get_the_ID();
		$products =   (new Page_Plugin_Options())->get_page_options($post_id, 'prwc_products');
		$prod_count = count($products);
		for ($i=0; $i < $prod_count; $i++) { 
			$product = wc_get_product($products[$i]);
			$url = get_permalink( $products[$i] );
			if(count($products)-1===$i){
				$multi_sep = '';
			}
			else{
				$multi_sep = ', ';
			}
			$product_urls .= "<a href='$url'>".$product->get_title()."</a>".$multi_sep;
		}
		return $product_urls;
	}
}