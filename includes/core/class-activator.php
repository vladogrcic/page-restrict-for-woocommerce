<?php

/**
 * Fired during plugin activation
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    PageRestrictForWooCommerce\Includes\Core
 */
namespace PageRestrictForWooCommerce\Includes\Core;
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    PageRestrictForWooCommerce\Includes\Core
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
class Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        $plugin_name = 'page-restrict-for-woocommerce';
        $plugin_title = 'Page Restrict for WooCommerce';
		
		if(version_compare(PHP_VERSION, '7.0', '<')) {
            $plugin = basename(PAGE_RESTRICT_WC_LOCATION_URL).'/'.$plugin_name.'.php';
            // Plugin was not-active, uh oh, do not allow this plugin to activate
            deactivate_plugins( $plugin );
            if(isset($_GET['activate'])){
                unset( $_GET['activate'] );
            }
			?>
			<div class="error notice">
				<p><?php esc_html_e( $plugin_title.' requires PHP version to be at least 7.0.25.', 'page_restrict_domain' ); ?></p>
			</div>
			<?php
			exit;
		}
	}
}

