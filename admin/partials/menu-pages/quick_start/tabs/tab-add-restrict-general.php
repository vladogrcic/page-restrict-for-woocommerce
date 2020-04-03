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

$img[]          = '/en/page/all-pages-in-one.png';

// translators: Replace this entire string with the url to your image.
$trans_img[]    = esc_html__('/en/page/all-pages-in-one.png',        'page_restrict_domain');

$trans_text[]   = esc_html__('You can look over multiple pages at once and restrict them by going to the', 'page_restrict_domain')
                .'</br>'
                .esc_html__('[ Page Restrict ] --> [ Pages ] menu page.', 'page_restrict_domain');
?>
<div class="card-main">
    <div class="content">
        <h2>
            <?php esc_html_e('General features available for the plugin', 'page_restrict_domain'); ?>
        </h2>
        <?php
            include(plugin_dir_path( __FILE__ ).'tab-add-restrict-doc-loop.php');
        ?>
    </div>
</div>