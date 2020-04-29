<?php

/**
 * Provide a Pages page for editing page options for this plugin.
 *
 * This file is used to markup the page options aspects of the plugin.
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
        <?php esc_html_e('Page Restrict Pages', 'page_restrict_domain'); ?>
    </h1> -->
</header>
<hr>
<?php
    include(plugin_dir_path( __FILE__ )."includes/all-menu-vars.php");
?>
<div id="prwc-plugin-main-wrapper" class="">
	<div class="pages-options-wrapper">
        <?php
            include(plugin_dir_path( __FILE__ )."menu-pages/pages/pages-vars.php");
        ?>
        <div class="pages-options">
            <?php
                include(plugin_dir_path( __FILE__ )."menu-pages/pages/pages.php");
            ?>
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
            new SlimSelect({
                select: jQuery('select.slimselect')[i],
                showContent: 'down',
                placeholder: '<?php esc_html_e('Select Value', 'page_restrict_domain'); ?>',
                allowDeselect: true,

                text: '<?php esc_html_e('', 'page_restrict_domain'); ?>',
                searchPlaceholder: '<?php esc_html_e('Search', 'page_restrict_domain'); ?>',
                searchText: '<?php esc_html_e('No Results', 'page_restrict_domain'); ?>',
                searchingText: '<?php esc_html_e('Searching..', 'page_restrict_domain'); ?>',
            });
        }
        jQuery( ".accordion" ).accordion({
            heightStyle: "content"
        });
        jQuery( ".accordion" ).accordion({
            heightStyle: "fill"
        });
        jQuery( ".accordion-resizer" ).resizable({
            minHeight: 350,
            minWidth: 200,
            handles: 'n, s',
            resize: function() {
                jQuery( ".accordion" ).accordion( "refresh" );
            }
        });
        window.post_types_general_original        = [];
        post_types_general_original = post_types_general_original.concat(<?php echo json_encode($prwc_post_types_general_original); ?>);
    });
</script>