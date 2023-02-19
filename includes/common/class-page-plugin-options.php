<?php

/**
 * Handling options for pages.
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    PageRestrictForWooCommerce\Includes\Common
 */
namespace PageRestrictForWooCommerce\Includes\Common;
/**
 * Handling options for pages.
 *
 *
 * @package    PageRestrictForWooCommerce\Includes\Common
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
class Page_Plugin_Options {
    /**
     * List of possible per page metabox page options.
     *
     * @since    1.0.0
     * @access   public
     * @var      array      $possible_page_options    List of possible metabox page options.
     */
    public $possible_page_options;
    /**
     * List of possible general metabox page or plugin options.
     *
     * @since    1.0.0
     * @access   public
     * @var      array      $possible_page_options    List of possible general metabox page or plugin options.
     */
    public $possible_general_options;
    /**
	 * Initialize class instances and other variables.
	 *
	 * @since    1.0.0
	 */
    public function __construct()
    {
        $this->possible_page_options = [
            'prwc_products'                 => 'array',
            'prwc_not_all_products_required'=> 'bool',
            'prwc_timeout_days'             => 'number',
            'prwc_timeout_hours'            => 'number',
            'prwc_timeout_minutes'          => 'number',
            'prwc_timeout_seconds'          => 'number',
            'prwc_timeout_views'            => 'number',
            'prwc_not_bought_page'          => 'number',
            'prwc_redirect_not_bought'      => 'bool',
            'prwc_not_logged_in_page'       => 'number',
            'prwc_redirect_not_logged_in'   => 'bool',
            'prwc_not_bought_section'       => 'number',
            'prwc_not_logged_in_section'    => 'number',
        ];
        $this->possible_general_options = [
            'prwc_limit_to_virtual_products'          => 'number',
            'prwc_limit_to_downloadable_products'     => 'number',
            'prwc_general_post_types'                 => 'array|post,page',
            'prwc_general_not_bought_page'            => 'number',
            'prwc_general_login_page'                 => 'number',
            'prwc_general_not_bought_section'            => 'number',
            'prwc_general_login_section'                 => 'number',
            'prwc_general_redirect_not_bought'        => 'bool',
            'prwc_general_redirect_login'             => 'bool',
            'prwc_delete_plugin_data_on_uninstall'    => 'number',
            'prwc_my_account_rp_page_disable_endpoint'      => 'number',
            'prwc_my_account_rp_page_hide_time_table'       => 'number',
            'prwc_my_account_rp_page_hide_view_table'       => 'number',
            'prwc_my_account_rp_page_disable_plugin_designed_table'    => 'number',
        ];
    }
    /**
     * Get general page metabox values.
     *
     * @since      1.0.0
     * @param      string         $page_option    Page content passed.
     * @return     int|array      $meta           Metabox value.
     */
    public function get_general_options($page_option){
        $meta = '';
        foreach ($this->possible_general_options as $key => $type) {
            $type_exp = explode('|', $type);
            $type = $type_exp[0];
            $default = isset($type_exp[1])?$type_exp[1]:false;
            if($type === 'array'){
                if($page_option === $key){
                    $meta = get_option($key);
                    if(!(strlen($meta) < 512)){
                        return;
                    }
                    if($default){
                        $meta =   $meta?explode(",", sanitize_text_field($meta)):explode(",", $default);
                    }
                    else{
                        $meta =   $meta?explode(",", sanitize_text_field($meta)):[];
                    }
                    
                }
            }
            if($type === 'number'){
                if($page_option === $key){
                    $meta = get_option($key);
                    if(!(strlen($meta) < 512)){
                        return;
                    }
                    $meta =   $meta?(int)$meta:0;
                }
            }
            if($type === 'bool'){
                if($page_option === $key){
                    $meta = get_option($key);
                    if(!(strlen($meta) < 512)){
                        return;
                    }
                    $meta =   $meta?1:0;
                }
            }
        }
        return $meta;
    }
    /**
     * Get general page metabox values.
     *
     * @since      1.0.0
     * @param      string         $post_id        Post ID.
     * @param      string         $page_option    Page content passed.
     * @return     int|array      $meta           Metabox value.
     */
    public function get_page_options($post_id, $page_option){
        global $wpdb;
        $meta = '';
        if(!$post_id) return false;
        foreach ($this->possible_page_options as $key => $type) {
            if($type === 'array'){
                if($page_option === $key){
                    $meta = [];
                    $table = $wpdb->prefix . 'postmeta';
                    $result = $wpdb->get_results( "SELECT meta_value FROM $table WHERE `post_id`='$post_id' AND `meta_key`='$key'" );
                    if(isset($result[0])) {
                        $meta = $result[0]->meta_value;
                        // $meta =   get_post_meta($post_id, $key, true);
                        if(!(strlen($meta) < 512)){
                            return;
                        }
                        $meta =   $meta?explode(",", sanitize_text_field($meta)):[];
                    }
                }
            }
            if($type === 'number'){
                if($page_option === $key){
                    $meta = 0;
                    $meta =   get_post_meta($post_id, $key, true);
                    if(!(strlen($meta) < 512)){
                        return;
                    }
                    $meta =   $meta?(int)$meta:0;
                }
            }
            if($type === 'bool'){
                if($page_option === $key){
                    $meta = false;
                    $meta =   (int)get_post_meta($post_id, $key, true);
                    if(!(strlen($meta) < 512)){
                        return;
                    }
                    $meta =   $meta?1:0;
                }
            }
        }
        return $meta;
    }
    /**
     * Sanitize page options.
     *
     * @since      1.0.0
     * @param      string         $page_option      Meta key to sanitize.
     * @param      string         $page_value       Meta value to sanitize.
     * @param      string         $type             Type of key to sanitize.
     * @return     string         $meta             Metabox value.
     */
    public function sanitize_page_options($page_option, $page_value, $type=false){
        $sanitized_value = '';
        if($type){
            $sanitized_value = $this->sanitize_value_by_type_for_pages($type, $page_value);
        }
        else{
            foreach ($this->possible_page_options as $key => $type) {
                if($page_option === $key){
                    $sanitized_value = $this->sanitize_value_by_type_for_pages($type, $page_value);
                }
            }
        }
        
        return $sanitized_value;
    }
    /**
     * Sanitize page option value.
     *
     * @since      1.0.0
     * @param      string         $type             Type of key to sanitize.
     * @param      string         $page_value       Meta value to sanitize.
     * @return     string         $meta             Metabox value.
     */
    public function sanitize_value_by_type_for_pages($type, $page_value){
        $sanitized_value = '';
        if($type === 'array'){
            $sanitized_value =   sanitize_text_field($page_value);
        }
        if($type === 'number'){
            $sanitized_value =   (int)$page_value;
        }
        if($type === 'bool'){
            $sanitized_value =   $page_value?1:0;
        }
        return $sanitized_value;
    }
    /**
     * Get general page metabox values.
     *
     * @since      1.0.0
     * @param      this->possible_page_options   $pages_lock_data    Page content passed.
     */
    public function process_page_options($pages_lock_data){
        global $wpdb;
        foreach ($pages_lock_data as $post_id => $value) {
            foreach ($value as $meta_key => $meta_value) {
                if(!(strlen($meta_key) < 100 && strlen($meta_value) < 512 && strlen($post_id) < 20)){
                    return;
                }
                if (is_array($meta_value)) {
                    $meta_value = implode(",", $meta_value);
                }
                $meta_value = $this->sanitize_page_options($meta_key, $meta_value);
                if ($meta_value) {
                    /**
                     * FIXME For some reason in wp-includes/meta.php on line 207, sanitize_meta removes the comma and everything after it.
                     */
                    // update_post_meta((int)$post_id, $meta_key, $meta_value);
                    $table = $wpdb->prefix . 'postmeta';
                    $data = ['meta_value' => $meta_value];
                    $where = ['post_id'=>$post_id, 'meta_key' => $meta_key];
                    
                    $result = $wpdb->get_results( "SELECT meta_id FROM $table WHERE `post_id`='$post_id' AND `meta_key`='$meta_key'" );
                    if(is_array($result) && count($result)){
                        $wpdb->update( $table, $data, $where );     
                    }
                    else{
                        $wpdb->insert($table, array_merge($data, $where));
                    }
                } else {
                    delete_post_meta((int)$post_id, $meta_key);
                }
            }
        }
    }
    /**
     * Get general page metabox values.
     *
     * @since      1.0.0
     * @param      this->possible_page_options   $pages_lock_data    Page content passed.
     */
    public static function process_general_options($pages_lock_data){
        if( !current_user_can( 'manage_options' ) ){
            return "You don't have access to this!";
        }
        foreach ($pages_lock_data as $page_option => $meta_value) {
            if(!(strlen($page_option) < 100 && strlen($meta_value) < 512)){
                return;
            }
            if($meta_value) {
                update_option( $page_option, $meta_value );
            }
            else {
                delete_option( $page_option );
            }
        }
        self::process_remove_unnecessary_metadata($pages_lock_data);
    }
    /**
     * Remove not needed post or user metadata.
     *
     * This is to remove metadata that aren't able to be used on the site. 
     * For example if you reduce products for restriction to only virtual products every non-virtual product will be removed from metadata like prwc_products.
     * 
     * @since      1.0.0
     * @param      this->possible_page_options   $pages_lock_data    Page content passed.
     */
    public static function process_remove_unnecessary_metadata($pages_lock_data){
        global $wpdb;
        if( isset($pages_lock_data['prwc_limit_to_virtual_products']) && isset($pages_lock_data['prwc_limit_to_downloadable_products'])){
            $args = array(
                "numberposts" => -1,
                "post_type" => "any",
                "meta_query" => array(
                    array(
                        "key"       => "prwc_products",
                        "compare"   => "="
                    )
                ),
            );
            $cache_name = '';
            $url_string = http_build_query($args);
            $cache_name = urldecode($url_string); 
            $posts = wp_cache_get( $cache_name );
            if(!is_object($posts)){
                $posts = new \WP_Query($args);
                wp_cache_add( $cache_name, $posts );
            }
            for ($i=0; $i < count($posts->posts); $i++) { 
                $product_id = explode(',', get_post_meta($posts->posts[$i]->ID, 'prwc_products', true));
                if($pages_lock_data['prwc_limit_to_virtual_products'] && $pages_lock_data['prwc_limit_to_downloadable_products']){
                    for ($j=0; $j < count($product_id); $j++) { 
                        $is_virtual         = wc_get_product($product_id[$j])->is_virtual();
                        $is_downloadable    = wc_get_product($product_id[$j])->is_downloadable();
                        if((!$is_virtual && !$is_downloadable) || (!$is_virtual && $is_downloadable) || ($is_virtual && !$is_downloadable)){
                            unset($product_id[$j]);
                        }
                    }
                }
                if($pages_lock_data['prwc_limit_to_virtual_products'] && !$pages_lock_data['prwc_limit_to_downloadable_products']){
                    for ($j=0; $j < count($product_id); $j++) { 
                        $is_virtual         = wc_get_product($product_id[$j])->is_virtual();
                        $is_downloadable    = wc_get_product($product_id[$j])->is_downloadable();
                        if((!$is_virtual && $is_downloadable) || (!$is_virtual && !$is_downloadable)){
                            unset($product_id[$j]);
                        }
                    }
                }
                if(!$pages_lock_data['prwc_limit_to_virtual_products'] && $pages_lock_data['prwc_limit_to_downloadable_products']){
                    for ($j=0; $j < count($product_id); $j++) { 
                        $is_virtual         = wc_get_product($product_id[$j])->is_virtual();
                        $is_downloadable    = wc_get_product($product_id[$j])->is_downloadable();
                        if(($is_virtual && !$is_downloadable) || (!$is_virtual && !$is_downloadable)){
                            unset($product_id[$j]);
                        }
                    }
                }
                if($product_id){
                    /**
                     * FIXME For some reason in wp-includes/meta.php on line 207, sanitize_meta removes the comma and everything after it.
                     */
                    // update_post_meta($posts->posts[$i]->ID, 'prwc_products', implode(',', $product_id));
                    $table = $wpdb->prefix . 'postmeta';
                    $meta_key = 'prwc_products';
                    $meta_value = implode(',', $product_id);
                    $post_id = $posts->posts[$i]->ID;
                    $data = ['meta_value' => $meta_value];
                    $where = ['post_id'=>$post_id, 'meta_key' => $meta_key];
                    
                    $result = $wpdb->get_results( "SELECT meta_id FROM $table WHERE `post_id`='$post_id' AND `meta_key`='$meta_key'" );  
                    if(is_array($result) && count($result)){
                        $wpdb->update( $table, $data, $where );     
                    }
                    else{
                        $wpdb->insert($table, array_merge($data, $where));
                    }
                }
                else{
                    delete_post_meta($posts->posts[$i]->ID, 'prwc_products');
                }
            }
        }
    }
}
