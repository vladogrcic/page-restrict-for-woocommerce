<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    PageRestrictForWooCommerce\Includes
 */
namespace PageRestrictForWooCommerce\Includes;
use PageRestrictForWooCommerce\Admin\Admin;
use PageRestrictForWooCommerce\Front\Front;
use PageRestrictForWooCommerce\Includes\Core\Loader;
use PageRestrictForWooCommerce\Includes\Core\i18n;
use function PageRestrictForWooCommerce\Functions\is_woocommerce_active;
use function PageRestrictForWooCommerce\Functions\activation_notices;
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    PageRestrictForWooCommerce\Includes
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
class Page_Restrict_Wc {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_title;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PAGE_RESTRICT_WC_VERSION' ) ) {
			$this->version = PAGE_RESTRICT_WC_VERSION;
		} 
		else {
			$this->version = '1.0.0';
		}
		if ( defined( 'PAGE_RESTRICT_WC_NAME' ) ) {
			$this->plugin_name 		= PAGE_RESTRICT_WC_NAME;
		}
		else{
			$this->plugin_name 		= 'page-restrict-wc';
		}
		if ( defined( 'PAGE_RESTRICT_WC_TITLE' ) ) {
			$this->plugin_title 		= PAGE_RESTRICT_WC_TITLE;
		}
		else{
			$this->plugin_title 		= esc_html__('Page Restrict for WooCommerce', 'page_restrict_domain');
		}

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Loader. Orchestrates the hooks of the plugin.
	 * - i18n. Defines internationalization functionality.
	 * - Admin. Defines all hooks for the admin area.
	 * - Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( ( __FILE__ ) ) . 'core/class-loader.php';
		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( ( __FILE__ ) ) . 'core/class-i18n.php';
		/**
		 * The class responsible for defining helper methods.
		 */
		require_once plugin_dir_path( ( __FILE__ ) ) . 'common/class-helpers.php';
		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( (dirname( __FILE__ )) ) . 'admin/class-admin.php';
		/**
		 * The class responsible for defining all methods that receive data through ajax.
		 */
		require_once plugin_dir_path( ( __FILE__ ) ) . 'admin/class-ajax.php';
		/**
		 * The class responsible for defining all methods that update page and general plugin options 
		 * and get general plugin and page options. 
		 * You can get an array of all plugin and page options for further processing.
		 */
		require_once plugin_dir_path( ( __FILE__ ) ) . 'common/class-page-plugin-options.php';
		/**
		 * The class responsible for defining all methods that handle authorization processing.
		 */
		require_once plugin_dir_path( ( __FILE__ ) ) . 'admin/class-auth-checks.php';
		/**
		 * The class responsible for defining all methods that handle shortcodes processing.
		 */
		require_once plugin_dir_path( ( __FILE__ ) ) . 'admin/class-shortcodes.php';
		/**
		 * The class responsible for defining all methods that checks users for various page timeout methods.
		 */
		require_once plugin_dir_path( ( __FILE__ ) ) . 'common/class-restrict-types.php';
		/**
		 * The class responsible for defining all methods that handle processing for classic metaboxes.
		 */
		require_once plugin_dir_path( ( __FILE__ ) ) . 'admin/class-classic-metabox-main.php';
		/**
		 * The class responsible for defining all methods that display plugin menus.
		 */
		require_once plugin_dir_path( ( __FILE__ ) ) . 'admin/class-menus.php';
		/**
		 * The class responsible for defining all methods that handle custom WooCommerce 
		 * methods regarding checking users if they bought the required product to view the page.
		 */
		require_once plugin_dir_path( ( __FILE__ ) ) . 'woocommerce/class-products-bought.php';
		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( (dirname( __FILE__ )) ) . 'front/class-front.php';
		/**
		 * The class responsible for defining all front facing processing for shortcodes, blocks and entire pages.
		 */
		require_once plugin_dir_path( ( __FILE__ ) ) . 'common/class-section-blocks.php';
		/**
 		 * Gets users with bought products which are needed to access restricted pages.
		 */
		require_once plugin_dir_path( ( __FILE__ ) ) . 'common/class-user-restrict-data.php';
		/**
		 * The class responsible for defining all front facing processing for listing pages that the current user purchased products for in order to access them.
		 */
		require_once plugin_dir_path( ( __FILE__ ) ) . 'front/class-restricted-pages-list-blocks.php';
		/**
		 * The class responsible for defining all front facing processing for the WooCommerce My Account shortcode.
		 */
		require_once plugin_dir_path( ( __FILE__ ) ) . 'front/class-wc-my-account.php';

		$this->loader = new Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		$plugin_i18n = new i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		activation_notices();
		if( is_woocommerce_active( true ) ){
			$plugin_admin = new Admin( $this->get_plugin_name(), $this->get_version(), $this->get_plugin_title() );
			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
			$this->loader->add_action( 'enqueue_block_editor_assets', $plugin_admin, 'enqueue_block_editor_scripts' );
			$this->loader->add_action( 'admin_menu', $plugin_admin, 'register_admin_menu' );
			$this->loader->add_action( 'init', $plugin_admin, 'register_blocks' );
			$this->loader->add_action( 'init', $plugin_admin, 'register_meta' );
			$this->loader->add_action( 'init', $plugin_admin, 'register_shortcodes' );
			$this->loader->add_action( 'init', $plugin_admin, 'register_ajax' );
			$this->loader->add_action( 'init', $plugin_admin, 'post_meta_on_update' );
			$this->loader->add_filter( 'plugin_action_links', $plugin_admin, 'plugin_action_links',10,2 );
		}
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		if( is_woocommerce_active( true ) ){
            $plugin_public = new Front( $this->get_plugin_name(), $this->get_version() );

            $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
            $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
            
            $this->loader->add_filter( 'the_content', $plugin_public, 'initiate_process_page');
            $this->loader->add_filter( 'template_redirect', $plugin_public, 'initiate_process_page_redirect');
            $this->loader->add_action( 'wp', $plugin_public, 'update_user_view_count');
            $this->loader->add_action( 'init', $plugin_public, 'wc_my_account_page');
        }
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}
	/**
	 * The title of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_title() {
		return $this->plugin_title;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
