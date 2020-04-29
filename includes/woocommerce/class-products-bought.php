<?php

/**
 * Handling which products were bought.
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    PageRestrictForWooCommerce\Includes\WooCommerce
 */
namespace PageRestrictForWooCommerce\Includes\WooCommerce;
/**
 * Handling which products were bought.
 *
 *
 * @package    PageRestrictForWooCommerce\Includes\WooCommerce
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
class Products_Bought {
	/**
     * Checking whether the product was purchased.
     *
     * @since    1.0.0
     * @param    int    $user_id    Users ID.
     * @param    array     $product    Product that need to be searched for.
     * @return   bool	
     */
	public function has_user_bought_product(int $user_id, array $product=[]) {
		if(count($this->get_purchased_products_by_ids($user_id, $product))) {
			return true;
		}
		else {
			return false;
		}
	}
	/**
     * Get purchased products. 
	 * Array of purchased products as WC_Order_Item_Product object.
     *
     * @since    1.0.0
     * @param    int    		$user_id     Users ID.
     * @param    array     		$products    Products that need to be searched for.
     * @return   array|bool	
     */
	public function get_purchased_products_by_ids(int $user_id, array $products=[]) {
		if(gettype($products) === "integer") $products = [$products];
		if(!count($products)) return [];
		$bought_products = [];
		// Get all customer orders
		$customer_orders = wc_get_orders([
			'customer' => $user_id,
			'status' => 'wc-completed',
			'orderby' => 'date',
			'limit' => 9999999999,
		]);
		foreach ( $customer_orders as $customer_order ) {
			// Updated compatibility with WooCommerce 3+
			$order = wc_get_order( $customer_order );
			// Iterating through each current customer products bought in the order
			foreach ($order->get_items() as $item) {
				// WC 3+ compatibility
				if ( version_compare( WC()->version, '3.0', '<' ) ) 
					$product_id = $item['product_id'];
				else
					$product_id = $item->get_product_id();
				// Your condition related to your 2 specific products Ids
				if ( in_array( $product_id, $products ) ) {
					$item['order_id']  				= $order->get_id(); 					// Get the order ID
					$item['user_id']   				= $order->get_user_id(); 				// Get the costumer ID
					$item['currency']      			= $order->get_currency(); 				// Get the currency used  
					$item['payment_method'] 		= $order->get_payment_method(); 		// Get the payment method ID
					$item['payment_method_title'] 	= $order->get_payment_method_title(); 	// Get the payment method title
					$item['date_created']  			= $order->get_date_created(); 			// Get date created (WC_DateTime object)
					$item['date_modified'] 			= $order->get_date_modified(); 			// Get date modified (WC_DateTime object)
					$item['date_completed'] 		= $order->get_date_completed(); 		// Get date completed (WC_DateTime object)
					$item['billing_country'] 		= $order->get_billing_country(); 		// Customer billing country
					for($i=0; $i<$item['quantity']; $i++){
						$bought_products[] = $item;
					}
				}
			}
		}
		return $bought_products;
	}
}