<?php
/**
 * Provide a Settings page admin area view for the plugin
 *
 * This file is used to markup the admin-facing settings page of the plugin. 
 *
 * @link       vladogrcic.com
 * @since      1.1.0
 *
 * @package    PageRestrictForWooCommerce
 */

?>
<header id="prwc-plugin-menu">
    <img src="<?php echo $logo; ?>" alt="" class="prwc-logo">
    <!-- <h1>
        <?php esc_html_e('Page Restrict User Overview', 'page_restrict_domain'); ?>
    </h1> -->
</header>
<hr style="width: 96.5%;float: left;">
<div id="prwc-plugin-main-wrapper">
    <div class="plugin-user-over-wrapper">
        <ul class="tab-menu">
            <li><a href="#tabs-1"><?php esc_html_e('Expire by Timeout', 'page_restrict_domain'); ?></a></li>
            <li><a href="#tabs-2"><?php esc_html_e('Expire by Views', 'page_restrict_domain'); ?></a></li>
        </ul>
        <div id="tabs-1" class="tab" style="display: block;">
            <div class="pages-user-over">
                <?php
                    include_once(plugin_dir_path( __FILE__ )."menu-pages/user_overview/tabs/tab-timeout.php");
                ?>
            </div>
        </div>
        <div id="tabs-2" class="tab" style="display: none;">
            <div class="pages-user-over">
                <?php
                    include_once(plugin_dir_path( __FILE__ )."menu-pages/user_overview/tabs/tab-view.php");
                ?>
            </div>
        </div>
    </div>
    <!-- <footer class="submit-row">
        <input type="submit" class="button-submit" value="➤ <?php esc_html_e('Save', 'page_restrict_domain'); ?>" style="padding-top: 5px;">
    </footer> -->
</div>
<script>
    window.plugin_dir_url = "<?php echo plugin_dir_url( dirname( __FILE__ ) ); ?>";
    jQuery(document).ready(function($) {
        jQuery( "#prwc-plugin-main-wrapper" ).tabs({active: 0});
    });
</script>