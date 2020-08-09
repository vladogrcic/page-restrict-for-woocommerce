<?php

/**
 * Handling ajax requests for options pages for page and plugin settings.
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    PageRestrictForWooCommerce\Includes\Admin
 */
namespace PageRestrictForWooCommerce\Includes\Admin;

use PageRestrictForWooCommerce\Includes\Admin\Authorization_Checks;
use PageRestrictForWooCommerce\Includes\Common\Page_Plugin_Options;
/**
 * Handling ajax requests for options pages for page and plugin settings.
 *
 *
 * @package    PageRestrictForWooCommerce\Includes\Admin
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
class Ajax {
    /**
     * Handles plugin options sent via ajax.
     * 
     * @since    1.0.0
     */
    public function plugin_options(){
        $auth_class = new Authorization_Checks();
		if(!$auth_class->check_authorization()){
			return;
		}
        $pages_lock_data = [];
        $page_options_class = new Page_Plugin_Options();
        foreach ($page_options_class->possible_general_options as $key => $type) {
            $type_exp = explode('|', $type);
            $type = $type_exp[0];
            if($type === 'array'){
                $pages_lock_data[$key] = sanitize_text_field($_POST[$key]);
            }
            if($type === 'number'){
                $pages_lock_data[$key] = (int)sanitize_text_field($_POST[$key]);
            }
            if($type === 'bool'){
                $pages_lock_data[$key] = (int)sanitize_text_field($_POST[$key]);
            }
        }
        $page_options_class::process_general_options($pages_lock_data);
    }
    /**
     * Handles lock options for site pages sent via ajax.
     * 
     * @since    1.0.0
     */
    public function pages_options(){
        $auth_class = new Authorization_Checks();
		if(!$auth_class->check_authorization()){
			return;
		}
        $pages_lock_data_post = [];
        if(is_array($_POST['pages_lock_data'])){
            $pages_lock_data_post = isset( $_POST['pages_lock_data'] ) ? (array) $_POST['pages_lock_data'] : [];
        }
        $pages_lock_data = [];
        foreach ($pages_lock_data_post as $key => $value) {
            $key = (int)$key;
            $validate_sum = [];
            $validate_sum = array_sum(array_map( 'strlen', $value ));
            if($validate_sum > (count($value)*512)){
                return;
            }
            $pages_lock_data[$key] = array_map( 'sanitize_text_field', $value );
        }
        $page_options_class = new Page_Plugin_Options();
        $page_options_class->process_page_options($pages_lock_data);
    }
}