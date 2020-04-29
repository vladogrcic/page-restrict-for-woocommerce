<?php
/**
 * Provide a Quick Start page admin area view for the plugin
 *
 * This file is used to markup the admin-facing quick start page of the plugin. 
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    PageRestrictForWooCommerce
 */

?>
<style>
    #prwc-plugin-main-wrapper > .plugin-options-wrapper #tabs label{
        font-size: 15px;
    }
    #prwc-plugin-main-wrapper > .plugin-options-wrapper .card-main > .content{
        margin-left: 25%;
        margin-right: 25%;
        text-align: justify;
    }
    #prwc-plugin-main-wrapper > .plugin-options-wrapper .card-main > .content > span{
        display: block;
        margin-left: auto;
        margin-right: auto;
        max-width:100%;
        width: 100%;
        padding: 10px;
    }
    #prwc-plugin-main-wrapper > .plugin-options-wrapper .card-main > .content > span > img{
        display: block;
        margin-left: auto;
        margin-right: auto;
        margin-top: 50px;
        margin-bottom: 50px;
        max-width:100%;
        box-shadow: 0px 0px 10px 1px #c3c3c3;
    }
    #prwc-plugin-main-wrapper > .plugin-options-wrapper h2{
        /* font-weight: normal; */
        font-size: 22px;
        background-color: #ececec;
        padding: 25px;
    }
    #prwc-plugin-main-wrapper > .plugin-options-wrapper p{
        font-weight: normal;
        font-size: 18px;
        background-color: #ececec;
        padding: 25px;
    }
    #prwc-plugin-main-wrapper > .plugin-options-wrapper .card-main:not(:first-child) {
        margin-top: 0;
    }
</style>
<header id="prwc-plugin-menu">
    <img src="<?php echo $logo; ?>" alt="" class="prwc-logo">
    <!-- <h1>
        <?php esc_html_e('Page Restrict Quick Start', 'page_restrict_domain'); ?>
    </h1> -->
</header>
<hr>
<div id="prwc-plugin-main-wrapper" class="ui-tabs ui-corner-all ui-widget ui-widget-content">
    <div class="plugin-options-wrapper">
        <ul role="tablist" class="ui-tabs-nav ui-corner-all ui-helper-reset ui-helper-clearfix ui-widget-header">
            <li role="tab" tabindex="0" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab ui-tabs-active ui-state-active" aria-controls="tabs-1" aria-labelledby="ui-id-1" aria-selected="true" aria-expanded="true"><a href="#tabs-1" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-1"><?php esc_html_e('Add Section Restrict', 'page_restrict_domain'); ?></a></li>
            <li role="tab" tabindex="-1" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab" aria-controls="tabs-2" aria-labelledby="ui-id-2" aria-selected="false" aria-expanded="false"><a href="#tabs-2" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-2"><?php esc_html_e('Add Page Restrict', 'page_restrict_domain'); ?></a></li>
            <li role="tab" tabindex="-2" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab" aria-controls="tabs-3" aria-labelledby="ui-id-3" aria-selected="false" aria-expanded="false"><a href="#tabs-3" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-3"><?php esc_html_e('Add Page Restrict - Classic Editor', 'page_restrict_domain'); ?></a></li>
            <li role="tab" tabindex="-3" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab" aria-controls="tabs-4" aria-labelledby="ui-id-4" aria-selected="false" aria-expanded="false"><a href="#tabs-4" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-4"><?php esc_html_e('General Overview', 'page_restrict_domain'); ?></a></li>
            <li role="tab" tabindex="-4" class="ui-tabs-tab ui-corner-top ui-state-default ui-tab" aria-controls="tabs-5" aria-labelledby="ui-id-5" aria-selected="false" aria-expanded="false"><a href="#tabs-5" role="presentation" tabindex="-1" class="ui-tabs-anchor" id="ui-id-5"><?php esc_html_e('Frontend', 'page_restrict_domain'); ?></a></li>
        </ul>
        <div id="tabs-1" aria-labelledby="ui-id-1" role="tabpanel" class="ui-tabs-panel ui-corner-bottom ui-widget-content" aria-hidden="false" style="display: block;">
            <div class="pages-options">
                <?php
                    include(plugin_dir_path( __FILE__ )."menu-pages/quick_start/tabs/tab-add-section-restrict.php");
                ?>
            </div>
        </div>
        <div id="tabs-2" aria-labelledby="ui-id-2" role="tabpanel" class="ui-tabs-panel ui-corner-bottom ui-widget-content" aria-hidden="false" style="display: none;">
            <div class="pages-options">
                <?php
                    include(plugin_dir_path( __FILE__ )."menu-pages/quick_start/tabs/tab-add-page-restrict.php");
                ?>
            </div>
        </div>
        <div id="tabs-3" aria-labelledby="ui-id-3" role="tabpanel" class="ui-tabs-panel ui-corner-bottom ui-widget-content" aria-hidden="false" style="display: none;">
            <div class="pages-options">
                <?php
                    include(plugin_dir_path( __FILE__ )."menu-pages/quick_start/tabs/tab-add-page-restrict-classic.php");
                ?>
            </div>
        </div>
        <div id="tabs-4" aria-labelledby="ui-id-4" role="tabpanel" class="ui-tabs-panel ui-corner-bottom ui-widget-content" aria-hidden="false" style="display: none;">
            <div class="pages-options">
                <?php
                    include(plugin_dir_path( __FILE__ )."menu-pages/quick_start/tabs/tab-add-restrict-general-overview.php");
                ?>
            </div>
        </div>
        <div id="tabs-5" aria-labelledby="ui-id-5" role="tabpanel" class="ui-tabs-panel ui-corner-bottom ui-widget-content" aria-hidden="false" style="display: none;">
            <div class="pages-options">
                <?php
                    include(plugin_dir_path( __FILE__ )."menu-pages/quick_start/tabs/tab-add-restrict-frontend.php");
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function() {
        jQuery( "#prwc-plugin-main-wrapper" ).tabs({active: 0});
        jQuery(window).on('load', function() {
            var offset = 500;
            for (var i = 0; i < jQuery('#prwc-plugin-main-wrapper img').length; i++) {
                var span_el = jQuery(jQuery('#prwc-plugin-main-wrapper img')[i]).parent()[0];
                var img_el = jQuery('#prwc-plugin-main-wrapper img')[i];
                if(img_el.naturalWidth-offset > (jQuery(span_el).innerWidth())){
                    jQuery(span_el).on('mouseout', function () { 
                        jQuery(this).css('border', 'none');
                    });
                    jQuery(span_el).on('mouseover', function () { 
                        jQuery(this).css('border', 'solid 1px grey');
                    });
                    jQuery(img_el).css('display', 'block')
                        .parent()
                        .zoom({
                            on: 'mouseover'
                        });
                }
            }
        });
    });
</script>