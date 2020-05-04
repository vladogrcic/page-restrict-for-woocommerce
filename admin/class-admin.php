<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    PageRestrictForWooCommerce\Admin
 */
namespace PageRestrictForWooCommerce\Admin;

use PageRestrictForWooCommerce\Includes\Admin\Menus;
use PageRestrictForWooCommerce\Includes\Admin\Ajax;
use PageRestrictForWooCommerce\Includes\Admin\Shortcodes;
use PageRestrictForWooCommerce\Includes\Admin\Classic_Metabox_Main;

use PageRestrictForWooCommerce\Includes\Front\Restricted_Pages_List_Blocks;

use PageRestrictForWooCommerce\Includes\Common\Section_Blocks;
use PageRestrictForWooCommerce\Includes\Common\Page_Plugin_Options;
use PageRestrictForWooCommerce\Includes\Common\Restrict_Types;
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    PageRestrictForWooCommerce\Admin
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
class Admin
{

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
     * @param      string    $plugin_name   The name of this plugin.
     * @param      string    $version       The version of this plugin.
     * @param      string    $plugin_title   The title of this plugin.
     */
    public function __construct($plugin_name, $version, $plugin_title)
    {
        $this->plugin_name      = $plugin_name;
        $this->plugin_title     = $plugin_title;
        $this->version          = $version;
        $this->blocks           = new Section_Blocks();
        $this->shortcodes       = new Shortcodes();
        $this->restrict         = new Restrict_Types();
        $this->ajax             = new Ajax();
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style( 'jquery-ui',       plugin_dir_url(__FILE__) . 'assets/css/lib/jquery-ui.css', false,          $this->version );
        wp_enqueue_style( 'jquery-ui-theme', plugin_dir_url(__FILE__) . 'assets/css/lib/jquery-ui.theme.css', false,    $this->version );
        wp_enqueue_style( 'slimselect',      plugin_dir_url(__FILE__) .'assets/css/lib/slimselect.css', false,          $this->version );
        wp_enqueue_style( 'zoomify',         plugin_dir_url(__FILE__) .'assets/css/lib/zoomify.css', false,             $this->version );
        wp_enqueue_style( 'oxanium', plugin_dir_url(__FILE__) .'assets/font/oxanium/oxanium-load.css', array(),         $this->version ); 
        wp_enqueue_style( $this->plugin_name, plugin_dir_url(__FILE__) . 'assets/css/admin.css', array(), $this->version, 'all' );
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        $plugin_name = $this->plugin_name;
        wp_enqueue_script( 'jquery-ui-tabs');
        wp_enqueue_script( 'jquery-ui-accordion' );
        wp_enqueue_script( 'jquery-ui-resizable' );
        wp_enqueue_script( 'jquery.zoom',       plugin_dir_url(__FILE__) .'assets/js/lib/jquery.zoom.js', array('jquery'),          $this->version, false );
        wp_enqueue_script( 'slimselect',        plugin_dir_url(__FILE__) .'assets/js/lib/slimselect.js', array('jquery'),           $this->version, false );
        wp_enqueue_script( 'options',           plugin_dir_url(__FILE__) .'assets/js/options.js', array( 'jquery' ),                $this->version, false );
        wp_enqueue_script( $this->plugin_name,  plugin_dir_url(__FILE__) .'assets/js/admin.js', array( 'jquery' ),    $this->version, false );
        wp_localize_script('options', 'page_restrict_wc', [
            'nonce'   => wp_create_nonce( $plugin_name.'-nonce' ),
        ]);
    }
    /**
     * Register the JavaScript for the page editing admin area. Some additional variables as well.
     *
     * @since    1.0.0
     */
    public function enqueue_block_editor_scripts()
    {
        if (!function_exists('register_block_type') || !function_exists('wp_set_script_translations')) {
            return;
        } //Gutenberg is not active
        global $post;
        global $wp_version;
        $plugin_title   = $this->plugin_title;
        $plugin_name    = $this->plugin_name;
        $page_options   = new Page_Plugin_Options();
        $prwc_limit_virtual_products        =   $page_options->get_general_options('prwc_limit_to_virtual_products');
        $prwc_limit_downloadable_products   =   $page_options->get_general_options('prwc_limit_to_downloadable_products');
        $prwc_post_types_general            =   $page_options->get_general_options('prwc_general_post_types');
        
        if((int)$prwc_limit_virtual_products)        {
            $args['virtual']        = (int)$prwc_limit_virtual_products;
        }
        if((int)$prwc_limit_downloadable_products)   {
            $args['downloadable']   = (int)$prwc_limit_downloadable_products;
        }
        $args['order']          = 'DESC'; 

        $products = wc_get_products($args);
        $products_out = [];
        $newtext = [];
        for ($i=0; $i < count($products); $i++) {
            $products_out[] = ["value" => $products[$i]->get_id(), "label" => $products[$i]->get_slug()];
            $newtext[] = wordwrap($products[$i]->get_id(), 20, " ");
        }
        include_once(plugin_dir_path( __FILE__ )."partials/menu-pages/pages/pages-vars.php");
        $pages_out = [];
        foreach ($all_pages as $key => $value) {
            for ($i=0; $i < count($value); $i++) { 
                if($key && $post->ID !== $value[$i]->ID)
                $pages_out[$key][] = [
                    "value" => $value[$i]->ID,
                    "label" => $value[$i]->post_name
                ];
            }
        }
        wp_enqueue_script(
            'general-block-var',
            plugin_dir_url(__FILE__) .'assets/js/general-block-var.js',
            array( 'wp-i18n', 'wp-blocks', 'wp-edit-post', 'wp-element', 'wp-editor', 'wp-components', 'wp-data', 'wp-plugins', 'wp-edit-post' ),
            true
        );
        wp_enqueue_script(
            'block-section-restrict',
            plugin_dir_url(__FILE__) .'assets/js/block-section-restrict.js',
            array( 'wp-i18n', 'wp-blocks', 'wp-edit-post', 'wp-element', 'wp-editor', 'wp-components', 'wp-data', 'wp-plugins', 'wp-edit-post' ),
            true
        );
        wp_enqueue_script(
            'block-restricted-pages-list',
            plugin_dir_url(__FILE__) . 'assets/js/block-restricted-pages-list.js',
            array( 'wp-i18n', 'wp-blocks', 'wp-edit-post', 'wp-element', 'wp-editor', 'wp-components', 'wp-data', 'wp-plugins', 'wp-edit-post' ),
            true
        );
        wp_enqueue_script(
            'metas',
            plugin_dir_url(__FILE__) .'assets/js/metas.js',
            array( 'wp-i18n', 'wp-blocks', 'wp-edit-post', 'wp-element', 'wp-editor', 'wp-components', 'wp-data', 'wp-plugins', 'wp-edit-post' ),
            true
        );
        wp_localize_script('general-block-var', 'page_restrict_wc', [
            "plugin_name"            => $plugin_name,
            "block_name"            => $plugin_name.'/restrict-section',
            // "block_name_restricted_pages_list"            => $plugin_name.'/restricted-pages-list',
            'nonce'   => wp_create_nonce( $plugin_name.'-nonce' ),
            "plugin_title"          => esc_html__($plugin_title, 'page_restrict_domain'),
            "products_available"    => $products_out,
            "pages"                 => $pages_out,
            "sidebar_img"           => plugins_url('/assets/img/logo-no-back-menu-dark.svg', __FILE__)
        ]);
        wp_localize_script('general-block-var', 'site_url', site_url());
        if (version_compare($wp_version, '5.0', '<')) {
            /**
             * Fixing 'Undefined function' errors for older Wordpress versions.
             * 
             * @since    1.0.0
             */
            function wp_set_script_translations()
            {
            }
        }
        else{
            wp_set_script_translations( 'general-block-var',      'page_restrict_domain', dirname( plugin_dir_path( __FILE__ ) ). '/languages/' );
            wp_set_script_translations( 'block-section-restrict', 'page_restrict_domain', dirname( plugin_dir_path( __FILE__ ) ). '/languages/' );
            wp_set_script_translations( 'metas',                  'page_restrict_domain', dirname( plugin_dir_path( __FILE__ ) ). '/languages/' );
        }
    }
    /**
     * Register shortcodes.
     *
     * @since    1.0.0
     */
    public function register_shortcodes()
    {
        add_shortcode('prwc_is_purchased', array( $this->shortcodes, 'is_purchased'));
        add_shortcode('prwc_restricted_pages_list', array( $this->shortcodes, 'restricted_pages_list'));
    }
    /**
     * Register gutenberg blocks for page editing.
     *
     * @since    1.0.0
     */
    public function register_blocks()
    {
        if (!function_exists('register_block_type')) {
            return;
        } //Gutenberg is not active
        global $wp_version;
        $plugin_name = $this->plugin_name;
        if (version_compare($wp_version, '5.0', '<')) {
            /**
             * Fixing 'Undefined function' errors for older Wordpress versions.
             * 
             * @since    1.0.0
             */
            function register_post_meta()
            {
            }
            /**
             * Fixing 'Undefined function' errors for older Wordpress versions.
             * 
             * @since    1.0.0
             */
            function register_block_type()
            {
            }
        }
        //Register block
        
        $prwc_block_options = [
            'editor_script' => $plugin_name,
            'attributes' => [
                'products' => [
                    'default' => [],
                    'type'    => 'array',
                    'items' => [
                        'type' => 'string',
                    ],
                ],
                'uniqueID' => [
                    'default' => "",
                    'type'    => 'string'
                    
                ],
                'inverse' => [
                    'default' => false,
                    'type'    => 'boolean'
                    
                ],
                'defRestrictMessage' => [
                    'default' => false,
                    'type'    => 'boolean'
                    
                ],
                'aboveBlockAttr' => [
                    'default' => false,
                    'type'    => 'boolean'
                    
                ],
                'belowBlockAttr' => [
                    'default' => false,
                    'type'    => 'boolean'
                    
                ],
                'days' => [
                    'default' => 0,
                    'type'    => 'number'
                    
                ],
                'hours' => [
                    'default' => 0,
                    'type'    => 'number'
                    
                ],
                'minutes' => [
                    'default' => 0,
                    'type'    => 'number'
                    
                ],
                'seconds' => [
                    'default' => 0,
                    'type'    => 'number'
                    
                ],
                'views' => [
                    'default' => 0,
                    'type'    => 'number'
                    
                ],
                'redirect' => [
                    'default' => 'm',
                    'type'    => 'string'
                ]
            ]
        ];
        if (!is_admin()) {
            $prwc_block_options['render_callback'] = [$this->blocks, 'process_section'];
        }
        register_block_type( $plugin_name.'/restrict-section', $prwc_block_options );

        $this->blocks_restricted_pages_list           = new Restricted_Pages_List_Blocks();
        $prwc_block_options_restricted_pages_list = [
            'editor_script' => $plugin_name,
            'attributes' => [
                'time' => [
                    'default' => true,
                    'type'    => 'boolean'
                    
                ],
                'view' => [
                    'default' => false,
                    'type'    => 'boolean'
                    
                ],
                'disable_table_class' => [
                    'default' => false,
                    'type'    => 'boolean'
                    
                ],
            ]
        ];
        if (!is_admin()) {
            $prwc_block_options_restricted_pages_list['render_callback'] = [$this->blocks_restricted_pages_list, 'process_restricted_pages_list'];
        }
        register_block_type( $plugin_name.'/restricted-pages-list', $prwc_block_options_restricted_pages_list );
    }
    /**
     * Register meta boxes for page editing.
     *
     * @since    1.0.0
     */
    public function register_meta()
    {
        global $wp_version;
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if (version_compare($wp_version, '5.0', '>=') && !is_plugin_active('classic-editor/classic-editor.php')) {
            register_meta('post', 'prwc_products', array(
                'type'    => 'string',
                'single'	=> true,
                'show_in_rest'	=> true,
                'sanitize_callback'	=> 'sanitize_text_field',
                'auth_callback'	=> function ()
                {
                    return current_user_can('edit_posts');
                },
            ));
            register_meta('post', 'prwc_not_bought_page', array(
                'type'		=> 'string',
                'single'	=> true,
                'show_in_rest'	=> true,
                'sanitize_callback'	=> 'sanitize_text_field',
                'auth_callback'	=> function ()
                {
                    return current_user_can('edit_posts');
                },
            ));
            register_meta('post', 'prwc_redirect_not_bought', array(
                'type'    => 'boolean',
                'single'	=> true,
                'show_in_rest'	=> true,
                'sanitize_callback'	=> 'sanitize_text_field',
                'auth_callback'	=> function ()
                {
                    return current_user_can('edit_posts');
                },
            ));
            register_meta('post', 'prwc_not_logged_in_page', array(
                'type'		=> 'string',
                'single'	=> true,
                'show_in_rest'	=> true,
                'sanitize_callback'	=> 'sanitize_text_field',
                'auth_callback'	=> function ()
                {
                    return current_user_can('edit_posts');
                },
            ));
            register_meta('post', 'prwc_redirect_not_logged_in', array(
                'type'    => 'boolean',
                'single'	=> true,
                'show_in_rest'	=> true,
                'sanitize_callback'	=> 'sanitize_text_field',
                'auth_callback'	=> function ()
                {
                    return current_user_can('edit_posts');
                },
            ));
            register_meta('post', 'prwc_timeout_days', array(
                'type'    => 'integer',
                'single'	=> true,
                'show_in_rest'	=> true,
                'sanitize_callback'	=> 'sanitize_text_field',
                'auth_callback'	=> function ()
                {
                    return current_user_can('edit_posts');
                },
            ));
            register_meta('post', 'prwc_timeout_hours', array(
                'type'    => 'integer',
                'single'	=> true,
                'show_in_rest'	=> true,
                'sanitize_callback'	=> 'sanitize_text_field',
                'auth_callback'	=> function ()
                {
                    return current_user_can('edit_posts');
                },
            ));
            register_meta('post', 'prwc_timeout_minutes', array(
                'type'    => 'integer',
                'single'	=> true,
                'show_in_rest'	=> true,
                'sanitize_callback'	=> 'sanitize_text_field',
                'auth_callback'	=> function ()
                {
                    return current_user_can('edit_posts');
                },
            ));
            register_meta('post', 'prwc_timeout_seconds', array(
                'type'    => 'integer',
                'single'	=> true,
                'show_in_rest'	=> true,
                'sanitize_callback'	=> 'sanitize_text_field',
                'auth_callback'	=> function ()
                {
                    return current_user_can('edit_posts');
                },
            ));
            register_meta('post', 'prwc_timeout_views', array(
                'type'    => 'integer',
                'single'	=> true,
                'show_in_rest'	=> true,
                'sanitize_callback'	=> 'sanitize_text_field',
                'auth_callback'	=> function ()
                {
                    return current_user_can('edit_posts');
                },
            ));
        }
        else{
            $classic_metabox_main = new Classic_Metabox_Main();
            add_action( 'add_meta_boxes',   array($classic_metabox_main, 'init_metabox'), 10, 2 );
            add_action( 'save_post',        array($classic_metabox_main, 'save_metabox'), 10, 2 );
        }
    }
    /**
     * Register the plugin admin menus and submenus.
     *
     * @since    1.0.0
     */
    public function register_admin_menu()
    {
        if( is_plugin_active( 'woocommerce/woocommerce.php') ){
            $menus = new Menus();
            add_menu_page(esc_html__('Page Restrict', 'page_restrict_domain'), esc_html__('Page Restrict', 'page_restrict_domain'), 'manage_options', 'prwc-pages-menu', array( $menus, 'prwc_menu_pages' ), plugins_url('/assets/img/logo-no-back-menu.svg', __FILE__));
            add_submenu_page( 'prwc-pages-menu', esc_html__('Page Restrict Pages', 'page_restrict_domain'), esc_html__('Pages', 'page_restrict_domain'),
                'manage_options', 'prwc-pages-menu');
            add_submenu_page( 'prwc-pages-menu', esc_html__('Page Restrict User Overview', 'page_restrict_domain'), esc_html__('User Overview', 'page_restrict_domain'),
                'manage_options', 'prwc-user-overview-menu', array( $menus, 'prwc_menu_user_overview'));
            add_submenu_page( 'prwc-pages-menu', esc_html__('Page Restrict Settings', 'page_restrict_domain'), esc_html__('Settings', 'page_restrict_domain'),
                'manage_options', 'prwc-settings-menu', array( $menus, 'prwc_menu_settings'));
            add_submenu_page( 'prwc-pages-menu', esc_html__('Page Restrict Quick Start', 'page_restrict_domain'), esc_html__('Quick Start', 'page_restrict_domain'),
                'manage_options', 'prwc-quick-start-menu', array( $menus, 'prwc_menu_quick_start'));
        }
    }
    /**
     * Register ajax calls.
     *
     * @since    1.0.0
     */
    public function register_ajax()
    {
        add_action( 'wp_ajax_pages_options', array( $this->ajax, 'pages_options') );
        add_action( 'wp_ajax_nopriv_pages_options', array( $this->ajax, 'pages_options') );

        add_action( 'wp_ajax_prwc_plugin_options', array( $this->ajax, 'plugin_options') );
        add_action( 'wp_ajax_nopriv_prwc_plugin_options', array( $this->ajax, 'plugin_options') );
    }
    /**
     * Prevent saving of empty metaboxes. Currently it deletes them after the post has been saved.
     * 
     * @since    1.0.0
     */
    public function post_meta_on_update()
    {
        add_action( 'the_post', __NAMESPACE__.'\\after_post_saved' );
        /**
         * Currently it deletes them after the post has been saved.
         *     
         * @param    class    $post       Wordpress Post Class.
         * @since    1.0.0
         */
        function after_post_saved( $post ) {
            $post_id = $post->ID;
            $possible_page_options = (new Page_Plugin_Options())->possible_page_options;
            foreach ($possible_page_options as $meta_key => $type) {
                $meta_value = sanitize_text_field(get_post_meta( $post_id, $meta_key, true ));
                if(!(strlen($meta_key) < 100)){
                    return;
                }
                $delete = false;
                if(is_numeric($meta_value)){
                    $meta_value = (int)$meta_value;
                    if(!$meta_value){
                        $delete = true;
                    }
                }
                elseif(empty($meta_value)){
                    $delete = true;
                }
                if($delete){
                    delete_post_meta( $post_id, $meta_key );
                }
            }
        }
    }
    /**
     * Adding Quick Start and Settings links to the installed plugins page for this plugin.
     *
     * @param    array    		$links                      An array of plugin links like activate and delete.
     * @param    string    		$plugin_name_plug_page      Name of the plugin.
     * @since    1.0.0
     */
    public function plugin_action_links( $links, $plugin_name_plug_page ) {
        $plugin_name = $this->plugin_name;
        if($plugin_name_plug_page === basename(PAGE_RESTRICT_WC_LOCATION_URL).'/'.$plugin_name.'.php' && is_plugin_active( 'woocommerce/woocommerce.php')){
            $settings_link = '<a href="'.esc_url( admin_url( "admin.php?page=prwc-settings-menu" ) ).'">'.esc_html__('Settings', 'page_restrict_domain').'</a>';
            array_unshift( $links, $settings_link ); 
            $settings_link = '<a href="'.esc_url( admin_url( "admin.php?page=prwc-quick-start-menu" ) ).'">'.esc_html__('Quick Start', 'page_restrict_domain').'</a>';
            array_unshift( $links, $settings_link ); 
        }
        return $links; 
    }
}



