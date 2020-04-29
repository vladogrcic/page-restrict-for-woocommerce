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
if((int)$prwc_limit_virtual_products){
    $args['virtual']        = (int)$prwc_limit_virtual_products;
}
if((int)$prwc_limit_downloadable_products){
    $args['downloadable']   = (int)$prwc_limit_downloadable_products;
}
$args['order']          = 'DESC';
$products = wc_get_products($args);
$products_out = [];
$newtext = [];
for ($i=0; $i < count($products); $i++) {
    $products_out[] = ["value" => $products[$i]->get_id(), "label" => $products[$i]->get_slug()];
    $newtext[] = wordwrap($products[$i]->get_id(), 20, " ");
}
$args = array(
    'numberposts' => -1,
    'sort_order' => 'asc',
    'sort_column' => 'post_title',
    'post_type' => $prwc_post_types_general,
); 

$post_types = $prwc_post_types_general;
$args = array(
    'numberposts' => -1,
    'sort_order' => 'asc',
    'sort_column' => 'post_title',
    'post_type' => $prwc_post_types_general,
    'post_status' => array('publish', 'future', 'inherit')
);
$all_pages = [];
foreach ($prwc_post_types_general as $key => $value) {
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
    'numberposts' => -1,
    'sort_order' => 'asc',
    'sort_column' => 'post_title',
    'post_type' => $prwc_post_types_general,
);
$published_pages = [];
foreach ($post_types as $key => $value) {
    $args['post_type'] = $value;
    if (count(get_posts($args))) {
        if($value === 'product') continue;
        $published_pages[$value] = get_posts($args);
    }
    else{
        continue;
    }
}
$pages_out = $post_types_out;
$post_types_out = [];
foreach ($published_pages as $post_types_key => $post_types_value) {
    if(!count(get_posts(['post_type' => $post_types_key]))) continue;
    $post_types_out[] = [
        "value" => $post_types_key,
        "label" => $post_types_key
    ];
}
$pages_redirect = get_posts($args);
$pages_redirect_out = [];
if(!$pages_redirect) return;
for ($i=0; $i < count($pages_redirect); $i++) {
    $pages_redirect_out[] = [
        "value" => $pages_redirect[$i]->ID,
        "label" => $pages_redirect[$i]->post_name
    ];
}
?>
