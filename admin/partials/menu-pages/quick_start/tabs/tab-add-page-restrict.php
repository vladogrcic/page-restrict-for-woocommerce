<?php

/**
 * General plugin wide settings.
 *
 * This file provides general plugin settings.
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    Page_Restrict_Wc
 * @subpackage Page_Restrict_Wc/admin/partials/menu-pages/quick_start/tabs
 */

/**
 * General plugin wide settings.
 *
 * This file provides general plugin settings.
 *
 * @package    Page_Restrict_Wc
 * @subpackage Page_Restrict_Wc/admin/includes
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

$img[]          = '/en/page/check-plugin-box.png';
$img[]          = '/en/page/enable-meta.png';
$img[]          = '/en/page/products-page-settings.png';
$img[]          = '/en/page/page-to-show-page-settings.png';
$img[]          = '/en/page/timeout-page-settings.png';

// translators: Replace this entire string with the url to your image.
$trans_img[]    = esc_html__('/en/page/check-plugin-box.png',               'page_restrict_domain');
// translators: Replace this entire string with the url to your image.
$trans_img[]    = esc_html__('/en/page/enable-meta.png',               'page_restrict_domain');
// translators: Replace this entire string with the url to your image.
$trans_img[]    = esc_html__('/en/page/products-page-settings.png',               'page_restrict_domain');
// translators: Replace this entire string with the url to your image.
$trans_img[]    = esc_html__('/en/page/page-to-show-page-settings.png',           'page_restrict_domain');
// translators: Replace this entire string with the url to your image.
$trans_img[]    = esc_html__('/en/page/timeout-page-settings.png',                'page_restrict_domain');

$trans_text[] = esc_html__('While editing your page click on the menu shown below.', 'page_restrict_domain');
$trans_text[] = esc_html__('If its not there click on', 'page_restrict_domain')
                .'</br>'
                .esc_html__('[ More tools & options ] --> [ Plugins ] --> [ Page Restrict for WooCommerce ].', 'page_restrict_domain');
$trans_text[] = esc_html__('Choose which product or products you want to use in order to restrict the page.', 'page_restrict_domain');
$trans_text[] = esc_html__("Choose which pages to use for restrict messages if the user didn't buy the product, the bought product expired or didn't login into the site.", 'page_restrict_domain').
                '<br>'.
                esc_html__("Choose whether you want to redirect to those pages instead of the default which is to insert the selected page content into the restricted page.", "page_restrict_domain").
                '<br>';
$trans_text[] = esc_html__('Restrict access to the page by setting the time you want the bought product to expire or you can choose to also expire it by views as well.', 'page_restrict_domain').'<br>'.
                esc_html__('Leave it 0 to just restrict by products only. That means it just checks if the user bought the product. If they did it will give them access to the page indefinitely.', 'page_restrict_domain');
?>
<div class="card-main">
    <div class="content">
        <h2>
            <?php esc_html_e('Restrict the entire page', 'page_restrict_domain'); ?>
        </h2>
        <?php
            include(plugin_dir_path( __FILE__ ).'tab-add-restrict-doc-loop.php');
        ?>
    </div>
</div>