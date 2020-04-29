<?php 

/**
 * Variables needed for all menu pages.
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    PageRestrictForWooCommerce
 */

/**
 * Variables needed for all menu pages.
 *
 * @package    PageRestrictForWooCommerce
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
    $args = array(
        'public'   => true,
        // '_builtin' => false
    );
    $registered_post_types         = get_post_types($args);
    $post_types                    = $prwc_post_types_general;

    $excluded_posttypes = ['product'];
    $registered_post_types         = array_diff($registered_post_types, $excluded_posttypes);
    $args = array(
        'posts_per_page'   => -1,
        'sort_order' => 'asc',
        'sort_column' => 'post_title',
        'post_type' => $prwc_post_types_general,
        'post_status' => array('publish', 'private', 'future')
    );
    $all_pages = [];
    foreach ($post_types as $key => $value) {
        $args['post_type'] = $value;
        if (count(get_posts($args))) {
            if($value === 'product') continue;
            $all_pages[$value] = get_posts($args);
        }
        else{
            continue;
        }
    }
    $post_types_out = [];
    
    foreach ($all_pages as $post_types_key => $post_types_value) {
        if(!count(get_posts(['post_type' => $post_types_key]))) continue;
        $post_types_out[] = [
            "value" => $post_types_key,
            "label" => $post_types_key
        ];
    }
    
    $args = array(
        'posts_per_page'   => -1,
        'sort_order' => 'asc',
        'sort_column' => 'post_title',
        'post_type' => $prwc_post_types_general,
        'post_status' => array('publish', 'future')
    );
    // $pages = get_posts($args); 
    $all_pages_published = [];
    foreach ($post_types as $key => $value) {
        $args['post_type'] = $value;
        if (count(get_posts($args))) {
            if($value === 'product') continue;
            $all_pages_published[$value] = get_posts($args);
        }
        else{
            continue;
        }
    }
?>
