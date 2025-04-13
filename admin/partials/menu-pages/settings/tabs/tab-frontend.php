<?php

/**
 * Frontend plugin wide settings.
 *
 * This file provides frontend plugin settings.
 *
 * @link       vladogrcic.com
 * @since      1.1.0
 *
 * @package    PageRestrictForWooCommerce
 */

/**
 * Frontend plugin wide settings.
 *
 * This file provides frontend plugin settings.
 *
 * @package    PageRestrictForWooCommerce
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
?>
<div class="card-main">
    <h3><?php esc_html_e('Restricted Pages', 'page_restrict_domain'); ?></h3>
    <div class="frontend-plugin">
        <div>
            <label for="prwc_user_roles_show_pages"><?php esc_html_e('Disable page restriction for specific users.', 'page_restrict_domain'); ?></label><br>
            <select class="post-types slimselect" id="prwc_user_roles_show_pages" name="prwc_user_roles_show_pages" multiple>
            <!-- <optgroup label="Registered"> -->
            <?php
            foreach ($site_user_roles as $role_key => $role) {
                echo $role['name'] . '<br>';
                ?>
                <option value="<?php echo $role_key; ?>" <?php echo in_array($role_key, $prwc_user_roles_show_pages)?'selected="selected"':''; ?>><?php echo $role['name']; ?></option>
                <?php
            }
            ?>
            <!-- </optgroup> -->
        </select>
        </div>
    </div>
    <hr style="border: 2px solid lightgrey; margin-top: 50px;">
    <div class="description">
        <p>
            <i>
            <?php 
                esc_html_e("* Choose users that will be able to see pages regardless of their restriction.", 'page_restrict_domain'); 
                ?>
            </i>
        </p>
    </div>
</div>
<div class="card-main">
    <h3><?php esc_html_e('WooCommerce My Account "Restricted Pages"', 'page_restrict_domain'); ?></h3>
    <div class="frontend-plugin">
        <div>
            <input type="checkbox" id="prwc_my_account_rp_page_disable_endpoint" name="prwc_my_account_rp_page_disable_endpoint" value="1" <?php checked($prwc_my_account_rp_page_disable_endpoint, '1'); ?>/>
            <label for="prwc_my_account_rp_page_disable_endpoint"><?php esc_html_e('Disable Restricted Pages List My Account page.', 'page_restrict_domain'); ?></label><br>
        </div>
        <hr>
        <div>
            <input type="checkbox" id="prwc_my_account_rp_page_hide_time_table" name="prwc_my_account_rp_page_hide_time_table" value="1" <?php checked($prwc_my_account_rp_page_hide_time_table, '1'); ?>/>
            <label for="prwc_my_account_rp_page_hide_time_table"><?php esc_html_e('Hide time table', 'page_restrict_domain'); ?></label><br>
        </div>
        <div>
            <input type="checkbox" id="prwc_my_account_rp_page_hide_view_table" name="prwc_my_account_rp_page_hide_view_table" value="1" <?php checked($prwc_my_account_rp_page_hide_view_table, '1'); ?>/>
            <label for="prwc_my_account_rp_page_hide_view_table"><?php esc_html_e('Hide view table', 'page_restrict_domain'); ?></label><br>
        </div>
        <div>
            <input type="checkbox" id="prwc_my_account_rp_page_disable_plugin_designed_table" name="prwc_my_account_rp_page_disable_plugin_designed_table" value="1" <?php checked($prwc_my_account_rp_page_disable_plugin_designed_table, '1'); ?>/>
            <label for="prwc_my_account_rp_page_disable_plugin_designed_table"><?php esc_html_e('Disable default table plugin design ( removes table CSS classes )', 'page_restrict_domain'); ?></label><br>
        </div>
    </div>
    <hr style="border: 2px solid lightgrey; margin-top: 50px;">
    <div class="description">
        <p>
            <i>
            <?php 
                esc_html_e("* Change settings for the plugin page on the WooCommerce", 'page_restrict_domain'); 
                ?>
                <b>
                <?php
                esc_html_e("My Account", 'page_restrict_domain');
                ?>
                </b>
                <?php
                esc_html_e("page on which the", 'page_restrict_domain'); 
                ?>
                <b>[woocommerce_my_account]</b>
                <?php
                esc_html_e("shortcode was used.", 'page_restrict_domain'); 
                ?>
            </i>
        </p>
    </div>
</div>