<?php

/**
 * Methods to see if current user bought products and if he is authorized to see the page.
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    PageRestrictForWooCommerce\Includes\Common
 */
namespace PageRestrictForWooCommerce\Includes\Common;

use Error;

/**
 * Class with several methods to see whether the current user has authorization to access the pages.
 *
 *
 * @package    PageRestrictForWooCommerce\Includes\Common
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
class Restrict_Types
{
        
    /**
     * user_id
     * @since    1.2.0
     * @var int
     */
    public $user_id;
    /**
     * post_id
     * @since    1.2.0
     * @var int
     */
    public $post_id;
    /**
     * Products that are required to access the page.
     * @since    1.2.0
     * @var array
     */
    public $products;
    /**
     * Products user purchased.
     * @since    1.2.0
     * @var array
     */
    public $purchased_products;
    
    /**
     * Products user purchased.
     * @since    1.2.0
     * @var array
     */
    protected $processed_purchased_products;
    /**
     * Products user purchased.
     * @since    1.2.0
     * @var array
     */
    protected $purchased_products_count;
    /**
     * Minimal number of purchased products which is used to check how many valid pack of products the user purchased.
     * @since    1.2.0
     * @var bool
     */
    protected $valid_purchased_product_amount;
    /**
     * Products user purchased.
     * @since    1.2.0
     * @var array
     */
    protected $purchased_products_packs;
    /**
     * The latest date the user purchased the specific pack of products in $products property.
     * @since    1.2.0
     * @var array
     */
    protected $biggest_time_in_pack;
    protected $purchased_products_ids;
    protected $processed_purchased_products_packs;

    /**
     * Initialize properties.
     * @since    1.2.0
     *
     */
    public function __construct()
    {
        $this->processed_purchased_products = [];
        $this->purchased_products_count = [];
        $this->valid_purchased_product_amount = 0;
        $this->purchased_products_packs = [];
        $this->biggest_time_in_pack = [];

        $this->user_id = 0;
        $this->post_id = 0;
        $this->products = [];
        $this->purchased_products = [];
    }
    /**
     * Calculate required class variables for the class to operate.
     *
     * @since    1.2.0
     *
     * @return void
     */
    public function calc_purchased_products()
    {
        if (!$this->user_id && !$this->post_id) {
            throw new Error('No post or user selected.');
        }
        if (!count($this->purchased_products)) {
            return;
        }

        $this->purchased_products_ids = [];
        $this->purchased_products_packs = [];
        $purchased_products = [];
        for ($i=0; $i < count($this->purchased_products); $i++) {
            $product_id = $this->purchased_products[$i]['product']->get_product_id();
            if (in_array($product_id, $this->products)) {
                $purchased_products[] = $this->purchased_products[$i];
                $this->purchased_products_ids[] = $product_id;
                $this->purchased_products_packs[$product_id][] = $this->purchased_products[$i];
            }
        }
        // $this->purchased_products = $purchased_products;
        $this->purchased_products_count = array_count_values($this->purchased_products_ids);
        if ($this->purchased_products_count) {
            $this->valid_purchased_product_amount = min($this->purchased_products_count);
        }
        $prods_to_keep_count = [];
        foreach ($this->purchased_products as $index => $value) {
            $product_id = $value['product']->get_product_id();
            if (in_array($product_id, $this->products)) {
                $prods_to_keep_count[ $product_id ] = $this->valid_purchased_product_amount;
            }
        }
        $this->processed_purchased_products = [];
        $this->processed_purchased_products_packs = [];
        foreach ($this->purchased_products as $index => $value) {
            $product_id = $value['product']->get_product_id();
            if ($prods_to_keep_count[ $product_id ]) {
                $this->processed_purchased_products[] = $value;
                $this->processed_purchased_products_packs[ $product_id ][] = $value;
                $prods_to_keep_count[ $product_id ] = $prods_to_keep_count[ $product_id ]-1;
            } else {
                continue;
            }
        }
    }
    /**
     * Calc time between products.
     *
     * @since    1.2.0
     *
     * @param  float     $timeout_sec           The time, in seconds, elapsed since the first product was bought (excluding the time between bought products).
     * @param  bool      $not_all_products_required
     * @return int
     */
    public function calc_time_between_products(float $timeout_sec, bool $not_all_products_required=false)
    {
        $time_between_buy = 0;
        if ($not_all_products_required) {
            // Time between the expiration of one product to the begginning of the next.
            for ($i=0; $i < count($this->purchased_products); $i++) {
                if ($i !== 0) {
                    $current_time       = $this->purchased_products[$i]  ['date_completed']->getTimestamp();
                    $next_time          = $this->purchased_products[$i-1]['date_completed']->getTimestamp();
                    $time_between_buy   += ($current_time - $next_time) - $timeout_sec;
                }
            }
        } else {
            // Time between the expiration of one pack of products to the begginning of the next.
            if ($this->valid_purchased_product_amount > 0) {
                $time_pack = [];
                for ($i=$this->valid_purchased_product_amount; $i > 0; $i--) {
                    $index = $i-1;
                    foreach ($this->processed_purchased_products_packs as $product_id => $product_item) {
                        $order = wc_get_order( $product_item[$index]['order_id'] );
                        $prod_timestamp = $order->get_date_completed()->getTimestamp();
                        $time_pack[] = $prod_timestamp;
                    }
                    $this->biggest_time_in_pack[$index] = max($time_pack);
                }
                sort($this->biggest_time_in_pack);
                for ($i=0; $i < count($this->biggest_time_in_pack); $i++) {
                    if ($i !== 0) {
                        $current_time       = $this->biggest_time_in_pack[$i];
                        $next_time          = $this->biggest_time_in_pack[$i-1];
                        $time_between_buy   += ($current_time - $next_time) - $timeout_sec;
                    }
                }
            }
        }
        /**
         * Reset if its a negative number since it only requires a positive number.
         * A negative number is part of the $timeout_page_option_sum below so there shouldn't be anything subtracted.
         * Which means there aren't any extra times between product purchases.
         */
        if ($time_between_buy < 0) {
            $time_between_buy = 0;
        }
        return $time_between_buy;
    }
    /**
     * Checks if the current users page visits exceeded the view count.
     *
     * @since    1.0.0
     * @param    int    $views                 View count.
     * @param    bool   $update_usr_meta       Choose to output bool or array.
     * @param    bool   $not_all_products_required       Do users need to buy some or all products in the list in order to access.
     * @return   mixed
     */
    public function check_views(int $views, bool $update_usr_meta=false, bool $not_all_products_required=false)
    {
        if (!count($this->purchased_products)) {
            return false;
        }
        $this->calc_purchased_products();
        $view_count = 0;
        $views_to_compare = 0;
        
        $view_count_meta = get_user_meta($this->user_id, "prwc_view_count_$this->post_id", true);
        if (isset($view_count_meta['views'])) {
            $view_count = (int)$view_count_meta['views'];
            $viewed = (int)$view_count_meta['viewed'];
        } else {
            $view_count = 0;
            $viewed = 0;
        }
        if (is_int($view_count)) {
            if ($not_all_products_required) {
                $views_to_compare = count($this->purchased_products) * $views;
            } else {
                $views_to_compare = $this->valid_purchased_product_amount * $views;
            }
            if ($view_count < $views_to_compare) {
                if ($update_usr_meta) {
                    return [
                        'view_count'=>$view_count,
                        'views_to_compare'=>$views_to_compare,
                        'view'=>true
                    ];
                } else {
                    return true;
                }
            } else {
                if ($viewed) {
                    if ($update_usr_meta) {
                        return [
                            'view_count'=>$view_count,
                            'views_to_compare'=>$views_to_compare,
                            'view'=>false
                        ];
                    } else {
                        return false;
                    }
                } else {
                    if ($update_usr_meta) {
                        return [
                            'view_count'=>$view_count,
                            'views_to_compare'=>$views_to_compare,
                            'view'=>true
                        ];
                    } else {
                        return true;
                    }
                }
            }
        } else {
            if ($update_usr_meta) {
                return [
                    'view_count'=>$view_count,
                    'views_to_compare'=>$views_to_compare,
                    'view'=>true
                ];
            } else {
                return true;
            }
        }
    }
    /**
     * Checks the time since the current user bought the product or products.
     *
     * @since     1.0.0
     * @param     float     $timeout_sec           The time, in seconds, elapsed since the first product was bought (excluding the time between bought products).
     * @param     bool      $output_time           Choose to output bool or array.
     * @param     bool      $not_all_products_required       Do users need to buy some or all products in the list in order to access.
     * @return    mixed
     */
    public function check_time(float $timeout_sec, $output_time=false, bool $not_all_products_required=false)
    {
        if (!count($this->purchased_products)) {
            return false;
        }
        $this->calc_purchased_products();
        $endTimeStamp = strtotime(date("Y-m-d H:i:s"));
        if ($not_all_products_required || !(count($this->purchased_products) > 1)) {
            $startTimeStamp = $this->purchased_products[0]['date_completed']->getTimestamp();
            $time_between_buy = $this->calc_time_between_products($timeout_sec);
            // Timeout time times number of products.
            $timeout_page_option_sum = $timeout_sec * count($this->purchased_products);
        } else {
            $time_between_buy = $this->calc_time_between_products($timeout_sec, $not_all_products_required);
            if (count($this->biggest_time_in_pack)) {
                $startTimeStamp = $this->biggest_time_in_pack[0];
            } else {
                $startTimeStamp = $endTimeStamp;
            }
            // Timeout time times number of products.
            $timeout_page_option_sum = $timeout_sec * $this->valid_purchased_product_amount;
        }
        // $endTimeStamp = strtotime("2019-08-27 00:45:34");
        $timeDiff = abs($endTimeStamp - $startTimeStamp);
        // Time between first bought product and current date.
        $time_elapsed = 0;
        $time_elapsed = intval($timeDiff);
        // Sum of all seconds from options to compare to.
        $timeout_compare = $timeout_page_option_sum + $time_between_buy;
        //! For testing only.
        $days_elapsed = $time_elapsed     / 86400;
        //! For testing only.
        $days_compare = $timeout_compare  / 86400;
        if ($output_time) {
            return [
                'time_elapsed' => $time_elapsed,
                'time_compare' => $timeout_compare,
            ];
        } else {
            if ($time_elapsed < $timeout_compare) {
                // If products are bought and their times are valid.
                return true;
            } else {
                // If product not bought or expired.
                return false;
            }
        }
    }
    /**
     * Checks both view count and time passed by current user.
     *
     * @since    1.0.0
     * @param    bool    $check_views    The output from check_views method.
     * @param    bool    $check_time     The output from check_time method.
     * @return   bool
    */
    public function check_views_time(bool $check_views, bool $check_time)
    {
        if (($check_views) && ($check_time)) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Checks if any product was bought by current user.
     *
     * @since    1.0.0
     * @param    bool   $not_all_products_required       Do users need to buy some or all products in the list in order to access.
     * @return   bool
    */
    public function check_products_only(bool $not_all_products_required=false)
    {
        if (!count($this->purchased_products)) {
            return false;
        }
        $this->calc_purchased_products();
        if ($not_all_products_required) {
            for ($i=0; $i < count($this->products); $i++) {
                if (in_array((int)$this->products[$i], $this->purchased_products_ids)) {
                    return true;
                }
            }
            return false;
        } else {
            for ($i=0; $i < count($this->products); $i++) {
                if (!in_array((int)$this->products[$i], $this->purchased_products_ids)) {
                    return false;
                }
            }
            return true;
        }
    }
    /**
     * Checks all possible restrict timeout options like by products only, views and time, just time and just views.
     *
     * @since    1.0.0
     * @param    int       $timeout_sec           The time elapsed since the first product was bought (excluding the time between bought products).
     * @param    int       $views                 View count.
     * @param    bool      $not_all_products_required       Do users need to buy some or all products in the list in order to access.
     * @return   bool
     */
    public function check_final_all_types($timeout_sec, $views=false, $not_all_products_required=false)
    {
        if (!count($this->purchased_products)) {
            return false;
        }

        $perm_granted_products_only = false;
        $perm_granted_products_only = $this->check_products_only($not_all_products_required);
        if(!$perm_granted_products_only){
            return false;
        }
        $perm_granted_views         = false;
        $perm_granted_time          = false;
        $perm_granted_views_time    = false;
        if ($views) {
            $perm_granted_views         = $this->check_views($views, false, $not_all_products_required);
        }
        if ($timeout_sec) {
            $perm_granted_time          = $this->check_time($timeout_sec, false, $not_all_products_required);
        }
        if ($views && $timeout_sec) {
            $perm_granted_views_time    = $this->check_views_time($perm_granted_views, $perm_granted_time);
        }
        if ($views && $timeout_sec) {
            if ($perm_granted_views_time) {
                return true;
            } else {
                return false;
            }
        }
        if (
            (($perm_granted_views || $perm_granted_time)
            ||
            !($views || $timeout_sec))
        ) {
            return true;
        } else {
            return false;
        }
    }
}
