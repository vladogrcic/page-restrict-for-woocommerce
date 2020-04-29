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
		if(!(is_plugin_active( 'woocommerce/woocommerce.php'))) {
			$action = 'install-plugin';
			$slug = 'woocommerce';
			$wc_install_link = wp_nonce_url(
				add_query_arg(
					array(
						'action' => $action,
						'plugin' => $slug
					),
					admin_url( 'update.php' )
				),
				$action.'_'.$slug
			);
			$wc_path_init = plugins_url( 'woocommerce/woocommerce.php' );
			?>
			<div class="error notice">
				<p><?php esc_html_e( $plugin_title.' requires WooCommerce in order to function. Please install and activate it in order to use this plugin.', 'page_restrict_domain' ); ?></p>
				<?php if(!file_exists($wc_path_init)): ?>
					<a href="<?php echo $wc_install_link; ?>"><?php esc_html_e( 'Click here to install WooCommerce (direct installation link).', 'page_restrict_domain' ); ?></a>
				<?php endif; ?>
			</div>
			<?php
			exit;
		}
	}
}

