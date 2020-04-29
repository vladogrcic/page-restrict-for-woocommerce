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

$img[]          = '/en/general-overview/all-pages-in-one.png';

// translators: Replace this entire string with the url to your image.
$trans_img[]    = esc_html__('/en/general-overview/all-pages-in-one.png',        'page_restrict_domain');

$trans_text[]   = esc_html__('You can look over multiple pages at once and restrict them by going to the', 'page_restrict_domain')
                .'</br>'
                .esc_html__('[ Page Restrict ] --> [ Pages ] menu page.', 'page_restrict_domain');
$img[]          = '/en/general-overview/user-page-restricted-time-data.png';

// translators: Replace this entire string with the url to your image.
$trans_img[]    = esc_html__('/en/general-overview/user-page-restricted-time-data.png',        'page_restrict_domain');

$trans_text[]   = esc_html__("You can look over pages with their users which either have or had access to them. It won't show all restricted pages only the ones with those users where they have bought products which are needed to access those pages. Get there by going to the", 'page_restrict_domain')
                .'</br>'
                .esc_html__('[ Page Restrict ] --> [ User Overview ] menu page.', 'page_restrict_domain')
                .'</br>'
                .esc_html__('Look at users by pages that expire by time.', 'page_restrict_domain');

$img[]          = '/en/general-overview/user-page-restricted-view-data.png';

// translators: Replace this entire string with the url to your image.
$trans_img[]    = esc_html__('/en/general-overview/user-page-restricted-view-data.png',        'page_restrict_domain');

$trans_text[]   = esc_html__('Or look at them by pages that expire by view count.', 'page_restrict_domain');
?>
<div class="card-main">
    <div class="content">
        <h2>
            <?php esc_html_e('General overview features available for the plugin', 'page_restrict_domain'); ?>
        </h2>
        <?php
            include(plugin_dir_path( __FILE__ ).'tab-add-restrict-doc-loop.php');
        ?>
    </div>
</div>