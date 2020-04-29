<?php
/**
 * Provide a Settings page admin area view for the plugin
 *
 * This file is used to markup the admin-facing settings page of the plugin. 
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    PageRestrictForWooCommerce
 */

?>
<header id="prwc-plugin-menu">
    <img src="<?php echo $logo; ?>" alt="" class="prwc-logo">
    <!-- <h1>
        <?php esc_html_e('Page Restrict Settings', 'page_restrict_domain'); ?>
    </h1> -->
</header>
<hr>
<?php
    include_once(plugin_dir_path( __FILE__ )."includes/all-menu-vars.php");
?>
<div id="prwc-plugin-main-wrapper">
    <div class="plugin-options-wrapper">
        <ul>
            <li><a href="#tabs-1"><?php esc_html_e('General', 'page_restrict_domain'); ?></a></li>
            <li><a href="#tabs-2"><?php esc_html_e('Frontend', 'page_restrict_domain'); ?></a></li>
            <li><a href="#tabs-3"><?php esc_html_e('Plugin', 'page_restrict_domain'); ?></a></li>
        </ul>
        <div id="tabs-1" style="display: block;">
            <div class="pages-options">
                <?php
                    include_once(plugin_dir_path( __FILE__ )."menu-pages/settings/tabs/tab-general.php");
                ?>
            </div>
        </div>
        <div id="tabs-2" style="display: none;">
            <div class="pages-options">
                <?php
                    include_once(plugin_dir_path( __FILE__ )."menu-pages/settings/tabs/tab-frontend.php");
                ?>
            </div>
        </div>
        <div id="tabs-3" style="display: none;">
            <div class="pages-options">
                <?php
                    include_once(plugin_dir_path( __FILE__ )."menu-pages/settings/tabs/tab-plugin.php");
                ?>
            </div>
        </div>
    </div>
    <footer class="submit-row">
        <input type="submit" class="button-submit" value="➤ <?php esc_html_e('Save', 'page_restrict_domain'); ?>" style="padding-top: 5px;">
    </footer>
</div>
<script>
    window.plugin_dir_url = "<?php echo plugin_dir_url( dirname( __FILE__ ) ); ?>";
    jQuery(document).ready(function($) {
        for (var i = 0; i < jQuery('select.slimselect').length; i++) {
            var addable = false;
            if(jQuery(jQuery('select.slimselect')[i]).attr('id') == 'prwc_general_post_types'){
                addable = function (value) {
                    return {
                        text: value
                            .toLowerCase()
                            .replace(/[^\w ]+/g,'')
                            .replace(/ +/g,'-'),
                        value: value
                            .toLowerCase()
                            .replace(/[^\w ]+/g,'')
                            .replace(/ +/g,'-')
                    }
                }
            }
            var slimselectOptions = {
                select:             jQuery('select.slimselect')[i],
                showContent:        'down',
                placeholder:        '<?php esc_html_e('Select Value', 'page_restrict_domain'); ?>',

                text:               '<?php esc_html_e('', 'page_restrict_domain'); ?>',
                searchPlaceholder:  '<?php esc_html_e('Search', 'page_restrict_domain'); ?>',
                searchText:         '<?php esc_html_e('No Results', 'page_restrict_domain'); ?>',
                searchingText:      '<?php esc_html_e('Searching..', 'page_restrict_domain'); ?>',
                allowDeselect: true

            };
            if(addable) slimselectOptions.addable = addable;
            new SlimSelect(slimselectOptions);
        }
        jQuery( "#prwc-plugin-main-wrapper" ).tabs({active: 0});
    });
</script>