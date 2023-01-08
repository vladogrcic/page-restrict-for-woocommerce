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

$img[]          = '/en/section/add-restrict-section.png';
$img[]          = '/en/section/general-section-settings.png';
$img[]          = '/en/section/products-sections-settings.png';
$img[]          = '/en/section/timeout-sections-settings.png';
$img[]          = '';

// translators: Replace this entire string with the url to your image.
$trans_img[]    = esc_html__('/en/section/add-restrict-section.png',          'page_restrict_domain');
// translators: Replace this entire string with the url to your image.
$trans_img[]    = esc_html__('/en/section/general-section-settings.png',      'page_restrict_domain');
// translators: Replace this entire string with the url to your image.
$trans_img[]    = esc_html__('/en/section/products-sections-settings.png',    'page_restrict_domain');
// translators: Replace this entire string with the url to your image.
$trans_img[]    = esc_html__('/en/section/timeout-sections-settings.png',     'page_restrict_domain');
$trans_img[]    = '';

$trans_text[] = esc_html__('The Restrict Section for WooCommerce block is located under Layout Elements pictured below.', 'page_restrict_domain');
$trans_text[] = esc_html__("Using Inverse Block you can tell the user what to buy to access the page. By default, without this option, the block hides the section content from the user until they buy the required product.", 'page_restrict_domain').'<br>'.
                esc_html__('You can mirror settings from a block above or below the current one.', 'page_restrict_domain').'<br>'.
                esc_html__('For example if you put a 100 day timeout in that other block this block will have a 100 day timeout as well.', 'page_restrict_domain');
$trans_text[] = esc_html__('Products using which you can restrict access to the blocks content. You can choose one or multiple products from the "Lock by Products" dropdown.', "page_restrict_domain")
                .'<br>'
                .esc_html__('Choose whether you want for the user to just buy at least one of the above listed products or require all of those products to purchase in order to be able to access that section. By default it requires all products selected to be bought.', "page_restrict_domain");
$trans_text[] = esc_html__('Restrict access to the section by setting the time you want the bought product to expire.', 'page_restrict_domain').'<br>'.
                esc_html__('Leave it 0 to just restrict by products only. That means it just checks if the user bought the product. If they did it will give them access to the page indefinitely.', 'page_restrict_domain');
$trans_text[] = esc_html__('Using a shortcode is also an option. This can be used for the Classic Editor as well.', 'page_restrict_domain')
                .'<br>'
                .'<span style="display: block; text-align: left; line-height: 16px;"><b><code>[prwc_is_purchased products="1,2" days="25" hours="2" minutes="45" seconds="15" inverse="false" defRestrictMessage="Restrict Message" notAllProductsRequired="false" defaultPageNotBoughtSections="4" defaultPageNotLoggedSections="5"]</code></b></span>'
                .'<br>'
                .esc_html__('* products - choose which products to restrict with. Add product IDs separated by a comma.".', 'page_restrict_domain')
                .'<br>'
                .esc_html__('* Timeout options for this are days, hours, minutes, seconds.', 'page_restrict_domain')
                .'<br>'
                .esc_html__('* inverse - using the inverse option you can choose inverse="false" to hide the content in order for the user to not see it. Choose inverse="true" for the user to see it in order to show them instructions on what to do to access the desired content you chose using inverse="false".', 'page_restrict_domain')
                .'<br>'
                .esc_html__("* defRestrictMessage - is the message you want to show if the user didn't buy the product.", 'page_restrict_domain')
                .'<br>'
                .esc_html__("* notAllProductsRequired - set to true if the user doesn't need to buy all products.", 'page_restrict_domain')
                .'<br>'
                .esc_html__("* defaultPageNotBoughtSections - you can choose a page to show instead of a message like in defRestrictMessage.", 'page_restrict_domain')
                .'<br>'
                .esc_html__("* defaultPageNotLoggedSections - you can choose a page to show if the user isn't logged in.", 'page_restrict_domain')
                .'<br>'
                .'<br>'
                .esc_html__('Prints links to products which are needed to buy to access the restricted page its in.', 'page_restrict_domain')
                .'<span style="display: block; text-align: left; line-height: 16px;"><b><code>[prwc_restricted_pages_products]</code></b></span>';
?>
<div class="card-main">
    <div class="content">
        <h2>
            <?php esc_html_e('Restrict blocks', 'page_restrict_domain'); ?>
        </h2>
        <?php
            include(plugin_dir_path( __FILE__ ).'tab-add-restrict-doc-loop.php');
        ?>
    </div>
</div>