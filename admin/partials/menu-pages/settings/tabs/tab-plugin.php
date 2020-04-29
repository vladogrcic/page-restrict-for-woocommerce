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
?>
<div class="card-main">
    <h3><?php esc_html_e('On Plugin Uninstallion', 'page_restrict_domain'); ?></h3>
    <div class="uninstall-plugin">
        <div>
            <input type="checkbox" id="prwc_delete_plugin_data_on_uninstall" name="prwc_delete_plugin_data_on_uninstall" value="1" <?php checked($prwc_delete_plugin_data_on_uninstall, '1'); ?>/>
            <label for="prwc_delete_plugin_data_on_uninstall"><?php esc_html_e('Delete all data connected to the plugin on uninstall', 'page_restrict_domain'); ?></label><br>
        </div>
    </div>
</div>