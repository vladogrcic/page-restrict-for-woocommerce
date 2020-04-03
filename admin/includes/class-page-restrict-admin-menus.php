<?php

/**
 * Plugin menus and submenus.
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    Page_Restrict_Wc
 * @subpackage Page_Restrict_Wc/admin/includes
 */

/**
 * Methods for initializing plugin menus and submenus.
 *
 *
 * @package    Page_Restrict_Wc
 * @subpackage Page_Restrict_Wc/admin/includes
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
class Page_Restrict_Wc_Menus {
		/**
		 * Page_Restrict_Wc_Page_Plugin_Options class instance.
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
			$this->page_options = new Page_Restrict_Wc_Page_Plugin_Options();
			$this->logo = plugins_url('/assets/img/logo-menu.svg', dirname(__FILE__));
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
            $prwc_limit_virtual_products        =   $page_options->get_general_options('prwc_limit_to_virtual_products');
            $prwc_limit_downloadable_products   =   $page_options->get_general_options('prwc_limit_to_downloadable_products');
            $prwc_post_types_general_original   =   $page_options->get_general_options('prwc_general_post_types');
            $prwc_post_types_general            =   $prwc_post_types_general_original;
            $redirect_prod_not_bought_id        =   0;
            $redirect_user_not_logged_in_id     =   0;
            include_once(dirname(plugin_dir_path( __FILE__ ))."/partials/menu-pages/pages/pages-vars.php");
            include_once(dirname(plugin_dir_path( __FILE__ )).'/partials/page-restrict-admin-pages.php');
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
            $page_options             = $this->page_options;
            $gen_log_page             = $page_options->get_general_options('prwc_general_login_page');
            $redirect_gen_log         = $page_options->get_general_options('prwc_general_redirect_login');
            $prwc_limit_virtual_products        =   $page_options->get_general_options('prwc_limit_to_virtual_products');
            $prwc_limit_downloadable_products   =   $page_options->get_general_options('prwc_limit_to_downloadable_products');
            $prwc_post_types_general            =   $page_options->get_general_options('prwc_general_post_types');
            $gen_not_bought_page                =   $page_options->get_general_options('prwc_general_not_bought_page');
            $redirect_gen_not_bought            =   $page_options->get_general_options('prwc_general_redirect_not_bought');
            $redirect_prod_not_bought_id        =   0;
            $redirect_user_not_logged_in_id     =   0;
            $prwc_delete_plugin_data_on_uninstall   =   $page_options->get_general_options('prwc_delete_plugin_data_on_uninstall');
            include_once(dirname(plugin_dir_path( __FILE__ )).'/partials/page-restrict-admin-settings.php');
        }
        /**
         * Displays the Quick Start page.
         *
         * @since      1.0.0
         * plugin_menus         * @return     void
         */
        public function prwc_menu_quick_start()
        {
            $logo = $this->logo;
            include_once(dirname(plugin_dir_path( __FILE__ )).'/partials/page-restrict-admin-quick-start.php');
        }
}