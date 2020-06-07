<?php

/**
 * Authorization check class.
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    PageRestrictForWooCommerce\Includes\Admin
 */
namespace PageRestrictForWooCommerce\Includes\Admin;

/**
 * Methods for authorization.
 *
 *
 * @package    PageRestrictForWooCommerce\Includes\Admin
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
class Authorization_Checks {
	/**
	 * Initialize class instances and other variables.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
	}
	/**
     * Checks if the user is authorized.
     *
     * @since    1.0.0
     * @param    string    $nonce       Nonce.
     * @param    string    $nonce_name  Nonce name.
	 * @return	 string
     */
	public function check_authorization($nonce=false, $nonce_name=false){
        $plugin_name = PAGE_RESTRICT_WC_NAME;
		
		if($nonce_name){
			$nonce_name = sanitize_key( $nonce_name );
		}
		else{
			$nonce_name = $plugin_name.'-nonce';
		}
        if($nonce){
			$nonce = sanitize_key( $nonce );
		}
		else{
			if(isset($_POST['nonce'])){
				$nonce = sanitize_key( $_POST['nonce'] );
			}
			else{
				if( isset( $_POST[$nonce_name] ) ){
					$nonce = sanitize_key( $_POST[$nonce_name] );
				}
			}
		}
		// Verify the nonce. If isn't there, stop the script.
		if ( isset( $nonce ) ){
			if ( wp_verify_nonce( $nonce, $nonce_name ) ) {
				return true;
			}
			else{
				return false;
			}
		}
        // Stop the script if the user does not have edit permissions.
        if ( current_user_can( 'edit_posts' ) ) {
            return true;
		}
		else{
			return false;
		}
        if ( current_user_can( 'edit_others_posts' ) ) {
            return true;
		}
		else{
			return false;
		}
    }
}