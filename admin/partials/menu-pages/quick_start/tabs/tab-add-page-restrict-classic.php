<?php

/**
 * General plugin wide settings.
 *
 * This file provides general plugin settings.
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    PageRestrictForWooCommerce
 */

/**
 * General plugin wide settings.
 *
 * This file provides general plugin settings.
 *
 * @package    PageRestrictForWooCommerce
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
$image_location = PAGE_RESTRICT_WC_LOCATION_URL.'admin/assets/img/screenshots';
/**
 * Initial image which is used to check whether there are translated images.
 */
$img = [];
/**
 * These are Translatable images that shown.
 * translators: Replace this entire string with the url to your image.
 */
$trans_img = [];
/**
 * Image descriptions.
 */
$trans_text = [];

$img[]          = '/en/page/all-page-settings-classic.png';
$img[]          = '/en/page/all-page-settings-classic-screen-options.png';

// translators: Replace this entire string with the url to your image.
$trans_img[]    = esc_html__('/en/page/all-page-settings-classic.png',        'page_restrict_domain');
// translators: Replace this entire string with the url to your image.
$trans_img[]    = esc_html__('/en/page/all-page-settings-classic-screen-options.png',        'page_restrict_domain');

$trans_text[] = [
    esc_html__('For older WordPress versions or if you just want to use the classic editor you will see classic WordPress metaboxes. The options are the same as on the new gutenberg editor.', 'page_restrict_domain'),
    esc_html__('In the Products section you can choose which product to restrict the page with.', 'page_restrict_domain'),
    esc_html__("In the Page to Show section you can choose which pages to show if the user hasn't bought a product, if it expired or if the user hasn't logged in. You can also choose to redirect to that page instead of just inserting the content into your chosen restricted page which is the default.", 'page_restrict_domain'),
    esc_html__("In the Timeout section set the time you want the bought product to expire if at all. You can choose to also expire it by views.", 'page_restrict_domain')
];
$trans_text[] = esc_html__("If you don't see it remember to turn it on in Screen Options.", 'page_restrict_domain');
?>
<div class="card-main">
    <div class="content">
        <h2>
            <?php esc_html_e('Restrict the entire page if using the classic editor', 'page_restrict_domain'); ?>
        </h2>
        <?php
            include(plugin_dir_path( __FILE__ ).'tab-add-restrict-doc-loop.php');
        ?>
    </div>
</div>
