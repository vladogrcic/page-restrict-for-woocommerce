<?php 

/**
 * Variables needed for the rest of the files.
 *
 * This file creates variables which are needed for several other files.
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    PageRestrictForWooCommerce
 */

/**
 * Variables needed for the rest of the files.
 *
 * This file creates variables which are needed for several other files.
 *
 * @package    PageRestrictForWooCommerce
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
$args = [
    'status' => array( 'publish' ),  
    'limit' => -1,  
    'order' => 'DESC',  
    'paginate' => false,  
];
if((int)$prwc_limit_virtual_products){
    $args['virtual']        = (int)$prwc_limit_virtual_products;
}
if((int)$prwc_limit_downloadable_products){
    $args['downloadable']   = (int)$prwc_limit_downloadable_products;
}
$cache_name = '';
$cache_name = sha1(serialize($args)); 
$products = wp_cache_get( $cache_name );
if(!is_array($products)){
    $products = wc_get_products($args);
    wp_cache_add( $cache_name, $products );
}
$products_out = [];
$products_by_id_out = [];
$newtext = [];
for ($i=0; $i < count($products); $i++) {
    $products_out[] = ["value" => $products[$i]->get_id(), "label" => $products[$i]->get_slug()];
    $products_by_id_out[$products[$i]->get_id()] = [
        'title' => $products[$i]->get_title(),
        'slug' => $products[$i]->get_slug()
    ];
    $newtext[] = wordwrap($products[$i]->get_id(), 20, " ");
}
$post_types = $prwc_post_types_general;
$args = array(
    'numberposts' => -1,
    'sort_order' => 'asc',
    'sort_column' => 'post_title',
    'post_type' => $prwc_post_types_general,
    'post_status' => array('publish', 'future', 'draft', 'pending')
);

$post_types_out = [];
foreach ($all_pages as $post_types_key => $post_types_value) {
    $cache_name = '';
    $cache_name = sha1(serialize(['post_type' => $post_types_key])); 
    $posts = wp_cache_get( $cache_name );
    if(!is_object($posts)){
        $posts = new WP_Query( ['post_type' => $post_types_key] );
        wp_cache_add( $cache_name, $posts );
    }
    $posts = $posts->posts;
    if(!count($posts)) continue;
    $post_types_out[] = [
        "value" => $post_types_key,
        "label" => $post_types_key
    ];
}
$args = array(
    'numberposts' => -1,
    'sort_order' => 'asc',
    'sort_column' => 'post_title',
    'post_type' => $prwc_post_types_general,
);
$published_pages = [];
foreach ($post_types as $key => $value) {
    $args['post_type'] = $value;
    $cache_name = '';
    $cache_name = sha1(serialize($args)); 
    $posts = wp_cache_get( $cache_name );
    if(!is_object($posts)){
        $posts = new WP_Query( $args );
        wp_cache_add( $cache_name, $posts );
    }
    $posts = $posts->posts;
    if (count($posts)) {
        if($value === 'product') continue;
        $published_pages[$value] = $posts;
    }
    else{
        continue;
    }
}
$pages_out = $post_types_out;
$post_types_out = [];
foreach ($published_pages as $post_types_key => $post_types_value) {
    $cache_name = '';
    $cache_name = sha1(serialize(['post_type' => $post_types_key])); 
    $posts = wp_cache_get( $cache_name );
    if(!is_object($posts)){
        $posts = new WP_Query( ['post_type' => $post_types_key] );
        wp_cache_add( $cache_name, $posts );
    }
    $posts = $posts->posts;
    if(!count($posts)) continue;
    $post_types_out[] = [
        "value" => $post_types_key,
        "label" => $post_types_key
    ];
}
$cache_name = '';
$cache_name = sha1(serialize($args)); 
$posts = wp_cache_get( $cache_name );
if(!is_object($posts)){
    $posts = new WP_Query( $args );
    wp_cache_add( $cache_name, $posts );
}
$posts = $posts->posts;
$pages_redirect = $posts;
$pages_redirect_out = [];
if(!$pages_redirect) return;
for ($i=0; $i < count($pages_redirect); $i++) {
    $pages_redirect_out[] = [
        "value" => $pages_redirect[$i]->ID,
        "label" => $pages_redirect[$i]->post_name
    ];
}
?>
