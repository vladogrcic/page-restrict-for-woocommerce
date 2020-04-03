<?php

/**
 * Methods to see if current user bought products and if he is authorized to see the page.
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    Page_Restrict_Wc
 * @subpackage Page_Restrict_Wc/admin/includes
 */

/**
 * Class with several methods to see whether the current user has authorization to access the pages.
 *
 *
 * @package    Page_Restrict_Wc
 * @subpackage Page_Restrict_Wc/admin/includes
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
class Page_Restrict_Wc_Restrict_Types {
    /**
     * Checks if the current users page visits exceeded the view count.
     *
     * @since    1.0.0
     * @param    int    $user_id               Users ID.
     * @param    int    $post_id               Posts ID.
     * @param    int    $views                 View count.
     * @param    array     $purchased_products    List of purchased products to compare.
     * @return   bool
     */
    public function check_views(int $user_id, int $post_id, int $views, array $purchased_products, $update_usr_meta=false)
    {
        $view_count = 0;
        $views_to_compare = 0;
        
        $view_count_meta = get_user_meta($user_id, "prwc_view_count_$post_id", true);
        if(isset($view_count_meta['views'])){
            $view_count = (int)$view_count_meta['views'];
            $viewed = (int)$view_count_meta['viewed'];
        }
        else{
            $view_count = 0;
            $viewed = 0;
        }
        if(is_int($view_count)){
            $views_to_compare = count($purchased_products)*$views;
            if($view_count < $views_to_compare){
                if($update_usr_meta){
                    return [
                        'view_count'=>$view_count, 
                        'views_to_compare'=>$views_to_compare, 
                        'view'=>true
                    ];
                }
                else{
                    return true;
                }
            }
            else{
                if($viewed){
                    if($update_usr_meta){
                        return [
                            'view_count'=>$view_count, 
                            'views_to_compare'=>$views_to_compare, 
                            'view'=>false
                        ];
                    }
                    else{
                        return false;
                    }
                }
                else{
                    if($update_usr_meta){
                        return [
                            'view_count'=>$view_count, 
                            'views_to_compare'=>$views_to_compare, 
                            'view'=>true
                        ];
                    }
                    else{
                        return true;
                    }
                }
            }
        }
        else{
            if($update_usr_meta){
                return [
                    'view_count'=>$view_count, 
                    'views_to_compare'=>$views_to_compare, 
                    'view'=>true
                ];
            }
            else{
                return true;
            }
        }
    }
    /**
     * Checks the time since the current user bought the product or products.
     *
     * @since     1.0.0
     * @param     float    $timeout_sec           The time, in seconds, elapsed since the first product was bought (excluding the time between bought products).
     * @param     array     $purchased_products    List of purchased products to compare.
     * @return    bool
     */
    public function check_time(float $timeout_sec, array $purchased_products)
    {
        if(!count($purchased_products)){
            return true;
        }
        $startTimeStamp = $purchased_products[0]['date_completed']->getTimestamp();
        // Time between the expiration of one product to the begginning of the next.
        $time_between_buy = 0;
        for ($i=0; $i < count($purchased_products); $i++) { 
            if($i !== 0){
                $current_time       = $purchased_products[$i]  ['date_completed']->getTimestamp();
                $next_time          = $purchased_products[$i-1]['date_completed']->getTimestamp();
                $time_between_buy   += ($current_time - $next_time) - $timeout_sec;
            }
        }
        
        /**
         * Reset if its a negative number since it only requires a positive number. 
         * A negative number is part of the $timeout_page_option_sum below so there shouldn't be anything subtracted.
         */
        if ($time_between_buy < 0){
            $time_between_buy = 0;
        }
        $endTimeStamp = strtotime(date("Y-m-d H:i:s"));
        // $endTimeStamp = strtotime("2019-08-27 00:45:34");
        $timeDiff = abs($endTimeStamp - $startTimeStamp);
        // Time between first bought product and current date.
		$time_elapsed = 0;
        $time_elapsed = intval($timeDiff);
        // Timeout time times number of products.
        $timeout_page_option_sum = $timeout_sec * count($purchased_products);
        // Sum of all seconds from options to compare to.
        $timeout_compare = $timeout_page_option_sum + $time_between_buy;
        $days_elapsed = $time_elapsed     / 86400;
        $days_compare = $timeout_compare  / 86400;
        if($time_elapsed < $timeout_compare){
            // If products are bought and their times are valid.
            return true;
        }
        else{
            // If product not bought or expired.
            return false;
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
        if( ($check_views) && ($check_time) ){
            return true;
        }
        else{
            return false;
        }
    }
    /**
     * Checks if any product was bought by current user.
     *
     * @since    1.0.0
     * @param    array     $products_arr          List of products used to restrict the page.
     * @param    array     $purchased_products    List of purchased products to compare.
     * @return   bool
    */
    public function check_products_only(array $products_arr, array $purchased_products)
    {
        $checkJustByProducts = [];
        for ($i=0; $i < count($purchased_products); $i++) { 
            if(in_array($purchased_products[$i]->get_product_id(), $checkJustByProducts)){
                continue;
            }
            $checkJustByProducts[] = $purchased_products[$i]->get_product_id();
        }
        for ($i=0; $i < count($products_arr); $i++) { 
            if (!in_array((int)$products_arr[$i], $checkJustByProducts)) {
                return false;
            }
        }
        return true;
    }
    /**
     * Checks all possible restrict timeout options like by products only, views and time, just time and just views. 
     *
     * @since    1.0.0
     * @param    int       $user_id               Users ID.
     * @param    int       $post_id               Posts ID.
     * @param    array     $purchased_products    List of purchased products to compare.
     * @param    array     $products_arr          List of products used to restrict the page.
     * @param    int       $views                 View count.
     * @param    int       $timeout_sec           The time elapsed since the first product was bought (excluding the time between bought products).
     * @return   bool
     */
    public function check_final_all_types( $user_id, $post_id, $purchased_products, $products_arr, $views, $timeout_sec ){
        $perm_granted_views         = false;
        $perm_granted_time          = false;
        $perm_granted_views_time    = false;
        $perm_granted_products_only = false;

        if($views){
            $perm_granted_views         = $this->check_views($user_id, $post_id, $views, $purchased_products);
        }
        if($timeout_sec){
            $perm_granted_time          = $this->check_time($timeout_sec, $purchased_products);
        }
        if($views && $timeout_sec){
            $perm_granted_views_time    = $this->check_views_time($perm_granted_views, $perm_granted_time);
        }
        if(count($purchased_products)){
            $perm_granted_products_only = $this->check_products_only($products_arr, $purchased_products);
        }
        if($views && $timeout_sec){
            if($perm_granted_views_time){
                return true;
            }
            else{
                return false;
            }
        }
        if(
            (($perm_granted_views || $perm_granted_time) 
            || 
            !($views || $timeout_sec)) && $perm_granted_products_only
        ){
            return true;
        } 
        else{
            return false;
        }
    }
} 
