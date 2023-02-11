<?php 

/**
 * Helper classes
 *
 * @link       vladogrcic.com
 * @since      1.1.1
 *
 * @package    PageRestrictForWooCommerce\Includes
 */
namespace PageRestrictForWooCommerce\Functions;

/**
 * Checks whether WooCommerce is activated.
 * 
 * @since    1.1.1
 * @param    boolean     $deactivate      Should this plugin be deactivated if WooCommerce not active.
 */
function is_woocommerce_active( $deactivate ){
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$plugin_name = PAGE_RESTRICT_WC_NAME;
	$plugin_title = PAGE_RESTRICT_WC_TITLE;
	if(!(is_plugin_active( 'woocommerce/woocommerce.php'))) {
		if( $deactivate ){
			$plugin = basename(PAGE_RESTRICT_WC_LOCATION_URL).'/'.$plugin_name.'.php';
			deactivate_plugins( $plugin );
			if(isset($_GET['activate'])){
				unset( $_GET['activate'] );
			}
		}
		return false;
	}
	else{
		return true;
	}
}
/**
 * Call activation notices.
 *
 * @since    1.1.1
 */
function activation_notices()
{
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$plugin_name = PAGE_RESTRICT_WC_NAME;
	$plugin_title = PAGE_RESTRICT_WC_TITLE;
	if(!(is_plugin_active( 'woocommerce/woocommerce.php'))) {
		$plugin = basename(PAGE_RESTRICT_WC_LOCATION_URL).'/'.$plugin_name.'.php';
		// Plugin was not-active, uh oh, do not allow this plugin to activate
		deactivate_plugins( $plugin );
		if(isset($_GET['activate'])){
			unset( $_GET['activate'] );
		}
		add_action('admin_notices', function () use ($plugin_title) {
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
			<div class="error notice" style="padding-top: 10px;padding-bottom: 25px;">
				<p><?php esc_html_e( $plugin_title.' requires WooCommerce in order to function. Please install and activate it in order to use this plugin.', 'page_restrict_domain' ); ?></p>
				<?php if(!file_exists($wc_path_init)): ?>
					<a href="<?php echo $wc_install_link; ?>"><?php esc_html_e( 'Click here to install WooCommerce ( direct installation link ).', 'page_restrict_domain' ); ?></a>
				<?php endif; ?>
			</div>
			<?php
		});
	}
	if(is_plugin_active( 'woocommerce/woocommerce.php')) {
		if(get_option('woocommerce_enable_guest_checkout')){
			if(get_option('woocommerce_enable_guest_checkout') === 'yes'){
				add_action( 'admin_notices', function () use ($plugin_title) {
					?>
					<div class="notice notice-error">
						<h2><?php echo $plugin_title; ?></h2>
						<h4><?php esc_html_e( "You haven't disabled GUEST CHECKOUT in WooCommerce!", 'page_restrict_domain' ); ?></h4>
						<p><?php esc_html_e( "If your unregistered users are buying products with WooCommerce without that disabled the products will not be able to be connected to any account which means this plugin can't know who bought it and can't allow access to specified pages correctly.", 'page_restrict_domain' ); ?></p>
						<p><?php esc_html_e( "Go to:", 'page_restrict_domain' ); ?></p>
						<a href="<?php echo admin_url( 'admin.php?page=wc-settings&tab=account', 'https' ); ?>"><?php echo esc_html_e( 'WooCommerce --> Settings --> Accounts & Privacy', 'page_restrict_domain' ); ?></a>
						<p><?php echo esc_html_e( 'Disable option: "Allow customers to place orders without an account".', 'page_restrict_domain' ); ?></p>
					</div>
					<?php
				});
			}
		}
	}
}