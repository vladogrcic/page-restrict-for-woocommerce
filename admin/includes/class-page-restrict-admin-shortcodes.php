<?php

/**
 * Shortcode class.
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    Page_Restrict_Wc
 * @subpackage Page_Restrict_Wc/admin/includes
 */

/**
 * Methods for shortcodes.
 *
 *
 * @package    Page_Restrict_Wc
 * @subpackage Page_Restrict_Wc/admin/includes
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
class Page_Restrict_Wc_Shortcodes {
	/**
	 * Page_Restrict_Wc_Section_Blocks class instance.
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
		$this->section_block = new Page_Restrict_Wc_Section_Blocks();
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
} 















