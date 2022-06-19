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
		$cache_name = 'prwc_get_purchased_products_by_ids_' . $user_id.'='.implode(',', $products);
		$bought_products = [];
		$bought_products_cached = wp_cache_get( $cache_name );
		if(is_array($bought_products_cached)){
			return $bought_products_cached;
		}
		// Get all customer orders
		$customer_orders = [];
		$user_cache_name = 'prwc_user_orders_'.$user_id;
		$customer_orders = wp_cache_get( $user_cache_name );
		if(!is_array($customer_orders)){
			$customer_orders = wc_get_orders([
				'customer' => $user_id,
				'status' => 'wc-completed',
				'orderby' => 'date',
				'limit' => 9999999999,
			]);
			wp_cache_add( $user_cache_name, $customer_orders );
		}
		// Get all customer orders END

		foreach ( $customer_orders as $order ) {
			// Updated compatibility with WooCommerce 3+
			// $order = wc_get_order( $customer_order );
			// Iterating through each current customer products bought in the order
			foreach ($order->get_items() as $item) {
				
				// WC 3+ compatibility
				if ( version_compare( WC()->version, '3.0', '<' ) ) 
					$product_id = $item['product_id'];
				else
					$product_id = $item->get_product_id();
				// Your condition related to your 2 specific products Ids
				if ( in_array( $product_id, $products ) ) {
					$order_data = $order->get_data();
					$order_product 				= $order_data; 					
					$order_product['product'] = $item;
					$order_product['order_id']  				= $order_data['id']; 					// Get the order ID
					$order_product['user_id']   				= $order_data['customer_id']; 			// Get the costumer ID
					$order_product['currency']      			= $order_data['currency']; 				// Get the currency used  
					$order_product['payment_method'] 		= $order_data['payment_method']; 		// Get the payment method ID
					$order_product['payment_method_title'] 	= $order_data['payment_method_title']; 	// Get the payment method title
					$order_product['date_created']  			= $order_data['date_created']; 			// Get date created (WC_DateTime object)
					$order_product['date_modified'] 			= $order_data['date_modified']; 		// Get date modified (WC_DateTime object)
					$order_product['date_completed'] 		= $order_data['date_completed']; 		// Get date completed (WC_DateTime object)
					$order_product['date_paid'] 		= $order_data['date_paid']; 		// Get date completed (WC_DateTime object)
					$order_product['billing'] 				= $order_data['billing']; 				// Customer billing country
					$order_product['shipping'] 				= $order_data['shipping']; 				// Customer billing country
					for($i=0; $i<$item['quantity']; $i++){
						$bought_products[] = $order_product;
					}
				}
			}
		}
		wp_cache_add( $cache_name, $bought_products );
		return $bought_products;
	}
}