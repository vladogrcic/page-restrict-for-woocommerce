<?php

/**
 * Plugin menus and submenus.
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    PageRestrictForWooCommerce\Includes\Admin
 */
namespace PageRestrictForWooCommerce\Includes\Admin;
use PageRestrictForWooCommerce\Includes\Common\Helpers;
use PageRestrictForWooCommerce\Includes\Common\User_Restrict_Data;
use PageRestrictForWooCommerce\Includes\Common\Page_Plugin_Options;
/**
 * Methods for initializing plugin menus and submenus.
 *
 *
 * @package    PageRestrictForWooCommerce\Includes\Admin
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
class Menus{
    /**
     * Page_Plugin_Options class instance.
     *
     * @since    1.0.0
     * @access   private
     * @var      class      $page_options    Get page options from the database like the products that the page is limited with and the time till timeout.
     */
    private $page_options;
    /**
     * Plugin logo location.
     *
     * @since    1.0.0
     * @access   private
     * @var      string      $logo    Plugin logo location.
     */
    private $logo;
    /**
     * Initialize class instances and other variables.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        $this->page_options = new Page_Plugin_Options();
        $this->logo = PAGE_RESTRICT_WC_LOCATION_URL.'/admin/assets/img/logo-menu.svg';
    }
    /**
     * Submenu page.
     *
     * @since    1.0.0
     */
    public function prwc_menu_pages()
    {
        global $post;
        $logo = $this->logo;
        $page_options = $this->page_options;
        $prwc_limit_virtual_products = $page_options->get_general_options('prwc_limit_to_virtual_products');
        $prwc_limit_downloadable_products = $page_options->get_general_options('prwc_limit_to_downloadable_products');
        $prwc_post_types_general_original = $page_options->get_general_options('prwc_general_post_types');
        $prwc_post_types_general = $prwc_post_types_general_original;
        $redirect_prod_not_bought_id = 0;
        $redirect_user_not_logged_in_id = 0;
        $not_all_products_required_id = 0;
        $page_display_style = 'display: none;';
        // include(plugin_dir_path( __FILE__ )."includes/all-menu-vars.php");
        // include_once(dirname(plugin_dir_path( __FILE__ ))."/partials/menu-pages/pages/pages-vars.php");
        include_once PAGE_RESTRICT_WC_LOCATION_DIR . '/admin/partials/menu-page-pages.php';
    }
    /**
     * Main menu page.
     *
     * @since    1.0.0
     */
    public function prwc_menu_settings()
    {
        global $post;
        $logo = $this->logo;
        $page_options = $this->page_options;
        $gen_log_page = $page_options->get_general_options('prwc_general_login_page');
        $gen_log_section = $page_options->get_general_options('prwc_general_login_section');
        $redirect_gen_log = $page_options->get_general_options('prwc_general_redirect_login');
        $prwc_limit_virtual_products = $page_options->get_general_options('prwc_limit_to_virtual_products');
        $prwc_limit_downloadable_products = $page_options->get_general_options('prwc_limit_to_downloadable_products');
        $prwc_post_types_general = $page_options->get_general_options('prwc_general_post_types');
        $gen_not_bought_page = $page_options->get_general_options('prwc_general_not_bought_page');
        $gen_not_bought_section = $page_options->get_general_options('prwc_general_not_bought_section');
        $redirect_gen_not_bought = $page_options->get_general_options('prwc_general_redirect_not_bought');
        $redirect_prod_not_bought_id = 0;
        $redirect_user_not_logged_in_id = 0;
        $prwc_delete_plugin_data_on_uninstall = $page_options->get_general_options('prwc_delete_plugin_data_on_uninstall');
        $prwc_my_account_rp_page_disable_endpoint = $page_options->get_general_options('prwc_my_account_rp_page_disable_endpoint');
        $prwc_my_account_rp_page_hide_time_table = $page_options->get_general_options('prwc_my_account_rp_page_hide_time_table');
        $prwc_my_account_rp_page_hide_view_table = $page_options->get_general_options('prwc_my_account_rp_page_hide_view_table');
        $prwc_my_account_rp_page_disable_plugin_designed_table = $page_options->get_general_options('prwc_my_account_rp_page_disable_plugin_designed_table');
        include_once PAGE_RESTRICT_WC_LOCATION_DIR . '/admin/partials/menu-page-settings.php';
    }
    /**
     * Main menu page.
     *
     * @since    1.1.0
     */
    public function prwc_menu_user_overview()
    {
        global $post;
        $logo = $this->logo;
        $helpers = new Helpers();
        $user_restrict_data = new User_Restrict_Data();

        $user_data_all = $user_restrict_data->return_data();
        $time_data = $user_data_all['time_data'];
        $purchased_products_by_user = $user_data_all['purchased_products_by_user'];
        $locked_posts = $user_data_all['locked_posts'];

        $view_data = $user_data_all['view_data'];
        $date_format = get_option('date_format');
        $time_format = get_option('time_format');
        
        if($time_data){
            $calc_pagination_all_time = $helpers->calc_pagination($time_data);
        }
        
        $totalPages_time = isset($calc_pagination_all_time['totalPages']) ? $calc_pagination_all_time['totalPages'] : null;
        $page_users_paginated_time = isset($calc_pagination_all_time['page_users_paginated']) ? $calc_pagination_all_time['page_users_paginated'] : null;

        $calc_pagination_all_view = $helpers->calc_pagination($view_data);
        $totalPages_view = $calc_pagination_all_view['totalPages'];
        $page_users_paginated_view = $calc_pagination_all_view['page_users_paginated'];

        $page_display_style = 'display: none;';
        include_once PAGE_RESTRICT_WC_LOCATION_DIR . '/admin/partials/menu-page-user-overview.php';
    }
    /**
     * Displays the Quick Start page.
     *
     * @since      1.0.0
     * plugin_menus         
     * @return     void
     */
    public function prwc_menu_quick_start()
    {
        $logo = $this->logo;
        include_once PAGE_RESTRICT_WC_LOCATION_DIR . '/admin/partials/menu-page-quick-start.php';
    }
}
