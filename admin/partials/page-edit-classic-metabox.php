<?php

/**
 * Provide a admin area view for individual pages for each page.
 *
 * This file is used to markup the metabox for older Wordpress versions.
 * 
 * @ignore
 * 
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    PageRestrictForWooCommerce
 */

?>
<style>
    .prwc-wrapper > .prwc-item-wrapper{
        margin-bottom: 35px;
        padding-bottom: 10px;
        border-bottom: grey 1px solid;
    }
    .prwc-wrapper > .prwc-item-wrapper > label{
        display: block;
        padding: 20px 15px;
        margin-bottom: 10px;
        background-color: lightgray;
        font-weight: 800;
    }
    .prwc-wrapper > .prwc-item-wrapper > .prwc-item{
        margin-bottom: 0px;
        padding-bottom: 10px;
        padding-left: 10px;
        padding-right: 10px;
    }
    .prwc-wrapper > .prwc-item-wrapper > .prwc-item > .labeled-wrapper{
        margin-bottom: 15px;
    }
    .prwc-wrapper > .prwc-item-wrapper > .prwc-item > .labeled-wrapper > input[type="number"],
    .prwc-wrapper > .prwc-item-wrapper > .prwc-item > .labeled-wrapper > input[type="text"]{
        width: 100%;
    }
    .prwc-wrapper > .prwc-item-wrapper > .prwc-item > .labeled-wrapper > .prwc_select{
        margin-top: 5px;
    }
    .prwc-wrapper > .prwc-item-wrapper > .prwc-item select.prwc_select{
        width: 100%;
    }
</style>
<?php echo $nonce; ?>
<div class="prwc-wrapper">
    <div class="prwc-item-wrapper">
        <label><?php esc_html_e('Products', 'page_restrict_domain'); ?></label>
        <div class="prwc-item">
            <div class="labeled-wrapper">
                <label><?php esc_html_e('Lock by Products', 'page_restrict_domain'); ?></label>
                <select name="prwc_products[]" class="prwc_select slimselect" multiple>
                    <?php 
                    for ($i=0; $i < count($products); $i++) { 
                        $products[$i];
                    ?>
                    <option value="<?php echo $products[$i]->get_id(); ?>" <?php echo in_array($products[$i]->get_id(), $prwc_products)?'selected':''; ?>><?php echo $products[$i]->get_slug(); ?></option>
                    <?php
                    }
                    ?>
                </select>
                <br>
                <br>
                <input type="checkbox" name="prwc_not_all_products_required" id="prwc_not_all_products_required" value="1" <?php checked($prwc_not_all_products_required, '1'); ?>>
                <label for="prwc_not_all_products_required" class=""> <?php esc_html_e('Not all products required', 'page_restrict_domain'); ?></label>
                <br>
            </div>
        </div>
    </div>
    <div class="prwc-item-wrapper">
        <label><?php esc_html_e('Page to Show', 'page_restrict_domain'); ?></label>
        <div class="prwc-item">
            <div class="labeled-wrapper">
                <label><?php esc_html_e('Page to show if product not bought', 'page_restrict_domain'); ?></label>
                <select name="prwc_not_bought_page" class="prwc_select slimselect">
                    <option value=""></option>
                    <?php 
                    foreach ($all_pages as $subpost_type => $pages_in_subtype) {
                        ?>
                        <optgroup label="<?php echo $subpost_type; ?>">
                    <?php
                        foreach($pages_in_subtype as $subkey => $subvalue): 
                            if($subvalue->ID == $post->ID) continue;
                    ?>
                            <option value="<?php echo $subvalue->ID; ?>" <?php echo $subvalue->ID === $prwc_not_bought_page?'selected="selected"':''; ?>><?php echo $subvalue->post_name; ?></option>
                        <?php endforeach ?>
                        </optgroup>
                    <?php 
                    } 
                    ?>
                </select>
            </div>
            <div class="labeled-wrapper">
                <input type="checkbox" name="prwc_redirect_not_bought" id="prwc_redirect_not_bought" value="1" <?php echo $prwc_redirect_not_bought?'checked="checked"':''; ?>><label for="prwc_redirect_not_bought"><?php esc_html_e('Redirect if product was not bought', 'page_restrict_domain'); ?></label>
            </div>
            <p>
                <i>
                    <b style="color: red;"><?php esc_html_e('Warning:', 'page_restrict_domain'); ?></b> 
                    <?php esc_html_e("If you decide to choose a private page (or pages with similar statuses like draft) regular users won't be able to redirect to it. It will just return a 404 error.", 'page_restrict_domain'); ?>
                </i>
            </p>
        </div>
        <div class="prwc-item">
            <div class="labeled-wrapper">
                <label><?php esc_html_e('Page to show if user is not logged in', 'page_restrict_domain'); ?></label>
                <select name="prwc_not_logged_in_page" class="prwc_select slimselect">
                    <option value=""></option>
                    <?php
                    foreach ($all_pages as $subpost_type => $pages_in_subtype) {
                        ?>
                        <optgroup label="<?php echo $subpost_type; ?>">
                    <?php
                        foreach($pages_in_subtype as $subkey => $subvalue): 
                            if($subvalue->ID == $post->ID) continue;
                    ?>
                            <option value="<?php echo $subvalue->ID; ?>" <?php echo $subvalue->ID === $prwc_not_logged_in_page?'selected="selected"':''; ?>><?php echo $subvalue->post_name; ?></option>
                        <?php endforeach ?>
                        </optgroup>
                    <?php 
                    } 
                    ?>
                </select>
            </div>
            <div class="labeled-wrapper">
                <input type="checkbox" name="prwc_redirect_not_logged_in" id="prwc_redirect_not_logged_in" value="1" <?php echo $prwc_redirect_not_logged_in?'checked="checked"':''; ?>><label for="prwc_redirect_not_logged_in"><?php esc_html_e('Redirect if user is not logged in', 'page_restrict_domain'); ?></label>
            </div>
            <p>
                <i>
                    <b style="color: red;"><?php esc_html_e('Warning:', 'page_restrict_domain'); ?></b> 
                    <?php esc_html_e("If you decide to choose a private page (or pages with similar statuses like draft) regular users won't be able to redirect to it. It will just return a 404 error.", 'page_restrict_domain'); ?>
                </i>
            </p>
        </div>
    </div>
    <div class="prwc-item-wrapper">
        <!-- NOTE Hasn't been implemented yet. -->
        <!-- <label><?php esc_html_e('Page text to show for sections', 'page_restrict_domain'); ?></label>
        <div class="prwc-item">
            <div class="labeled-wrapper">
                <label><?php esc_html_e('Page text to show if product not bought', 'page_restrict_domain'); ?></label>
                <select name="prwc_not_bought_section" class="prwc_select slimselect">
                    <option value=""></option>
                    <?php 
                    foreach ($all_pages as $subpost_type => $pages_in_subtype) {
                        ?>
                        <optgroup label="<?php echo $subpost_type; ?>">
                    <?php
                        foreach($pages_in_subtype as $subkey => $subvalue): 
                            if($subvalue->ID == $post->ID) continue;
                    ?>
                            <option value="<?php echo $subvalue->ID; ?>" <?php echo $subvalue->ID === $prwc_not_bought_section?'selected="selected"':''; ?>><?php echo $subvalue->post_name; ?></option>
                        <?php endforeach ?>
                        </optgroup>
                    <?php 
                    } 
                    ?>
                </select>
            </div>
        </div> -->
        <div class="prwc-item">
            <div class="labeled-wrapper">
                <label><?php esc_html_e('Page text to show if user is not logged in', 'page_restrict_domain'); ?></label>
                <select name="prwc_not_logged_in_section" class="prwc_select slimselect">
                    <option value=""></option>
                    <?php
                    foreach ($all_pages as $subpost_type => $pages_in_subtype) {
                        ?>
                        <optgroup label="<?php echo $subpost_type; ?>">
                    <?php
                        foreach($pages_in_subtype as $subkey => $subvalue): 
                            if($subvalue->ID == $post->ID) continue;
                    ?>
                            <option value="<?php echo $subvalue->ID; ?>" <?php echo $subvalue->ID === $prwc_not_logged_in_section?'selected="selected"':''; ?>><?php echo $subvalue->post_name; ?></option>
                        <?php endforeach ?>
                        </optgroup>
                    <?php 
                    } 
                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="prwc-item-wrapper">
        <label><?php esc_html_e('Timeout', 'page_restrict_domain'); ?></label>
        <div class="prwc-item">
            <div class="labeled-wrapper">
                <label for="prwc_timeout_days"><?php esc_html_e('Days', 'page_restrict_domain'); ?></label>
                <input type="number" min="0" name="prwc_timeout_days" id="prwc_timeout_days" value="<?php echo $prwc_timeout_days; ?>">
            </div>
            <div class="labeled-wrapper">
                <label for="prwc_timeout_hours"><?php esc_html_e('Hours', 'page_restrict_domain'); ?></label>
                <input type="number" min="0" name="prwc_timeout_hours" id="prwc_timeout_hours" value="<?php echo $prwc_timeout_hours; ?>">
            </div>
            <div class="labeled-wrapper">
                <label for="prwc_timeout_minutes"><?php esc_html_e('Minutes', 'page_restrict_domain'); ?></label>
                <input type="number" min="0" name="prwc_timeout_minutes" id="prwc_timeout_minutes" value="<?php echo $prwc_timeout_minutes; ?>">
            </div>
            <div class="labeled-wrapper">
                <label for="prwc_timeout_seconds"><?php esc_html_e('Seconds', 'page_restrict_domain'); ?></label>
                <input type="number" min="0" name="prwc_timeout_seconds" id="prwc_timeout_seconds" value="<?php echo $prwc_timeout_seconds; ?>">
            </div>
            <div class="labeled-wrapper">
                <label for="prwc_timeout_views"><?php esc_html_e('Views', 'page_restrict_domain'); ?></label>
                <input type="number" min="0" name="prwc_timeout_views" id="prwc_timeout_views" value="<?php echo $prwc_timeout_views; ?>">
            </div>
        </div>
    </div>
</div>
<script>
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
</script>
