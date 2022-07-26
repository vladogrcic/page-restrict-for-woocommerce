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
    <h3><?php esc_html_e('Limit Available Products to Restrict Pages With', 'page_restrict_domain'); ?></h3>
    <div class="limit-products">
        <div>
            <input type="checkbox" id="prwc_limit_to_virtual_products" name="prwc_limit_to_virtual_products" value="1" <?php checked($prwc_limit_virtual_products, '1'); ?>/>
            <label for="prwc_limit_to_virtual_products"><?php esc_html_e('Limit to Virtual Products', 'page_restrict_domain'); ?></label><br>
        </div>
        <div>
            <input type="checkbox" id="prwc_limit_to_downloadable_products" name="prwc_limit_to_downloadable_products" value="1" <?php checked($prwc_limit_downloadable_products, '1'); ?>/>
            <label for="prwc_limit_to_downloadable_products"><?php esc_html_e('Limit to Downloadable Products', 'page_restrict_domain'); ?></label><br>
        </div>
    </div>
    <hr style="border: 2px solid lightgrey; margin-top: 50px;">
    <div class="description">
        <p>
            <i>
                <b style="color: red;"><?php esc_html_e('* Warning:', 'page_restrict_domain'); ?></b> 
                <?php esc_html_e('If you decide to reduce available products to choose from for page restriction,', 'page_restrict_domain'); ?>
                <b style="color: red;"><?php esc_html_e('all products not matching', 'page_restrict_domain'); ?></b>
                <?php esc_html_e('those checked attributes for all existing restricted pages', 'page_restrict_domain'); ?>
                <b style="color: red;"><?php esc_html_e('will be removed.', 'page_restrict_domain'); ?></b>
            </i>
        </p>
    </div>
</div>

<div class="card-main">
    <h3><?php esc_html_e('Limit Pages by Post Type', 'page_restrict_domain'); ?></h3>
    <div>
        <label class=""> <?php esc_html_e('Post Types', 'page_restrict_domain'); ?> </label>
        <br>
        <br>
        <select class="post-types slimselect" id="prwc_general_post_types" name="prwc_general_post_types" multiple>
            <optgroup label="Registered">
            <?php 
                foreach($registered_post_types as $key => $value){
                    if($prwc_post_types_general){
                        ?>
                            <option value="<?php echo $value; ?>" <?php echo in_array($value, $prwc_post_types_general)?'selected="selected"':''; ?>><?php echo $value; ?></option>
                        <?php
                    }
                    else{
                        ?>
                            <option value="<?php echo $value; ?>" <?php echo ($value == 'page' || $value == 'post')?'selected="selected"':''; ?>><?php echo $value; ?></option>
                        <?php
                    }
                } 
                if($prwc_post_types_general){
                    array_intersect($prwc_post_types_general, $registered_post_types);
                    $prwc_post_types_general_added = array_diff( array_unique(
                        array_merge(
                            array_values($prwc_post_types_general)
                        )),
                        $registered_post_types 
                    );
                } 
            ?>
            </optgroup>
            <?php 
            if($prwc_post_types_general_added)
            {
            ?>
            <optgroup label="Unregistered">
            <?php
            foreach($prwc_post_types_general_added as $subkey => $subvalue){
                if($prwc_post_types_general){
                    ?>
                        <option value="<?php echo $subvalue; ?>" selected="selected"><?php echo $subvalue; ?></option>
                    <?php
                }
            }
            ?>
            </optgroup>
            <?php 
            }
            ?>
        </select>
    </div>
    <hr style="border: 2px solid lightgrey; margin-top: 50px;">
    <div class="description">
        <p>
            <i><?php 
                esc_html_e("* Filters out pages which are shown in not bought and not logged in options when restricting pages.", 'page_restrict_domain'); ?>
            </i>
        </p>
        <p>
            <i>
            <?php 
                esc_html_e("* When you have chosen your post types", 'page_restrict_domain'); 
                ?>
                <b>
                <?php
                esc_html_e("only pages matching them", 'page_restrict_domain');
                ?>
                </b>
                <?php
                esc_html_e("can be used for", 'page_restrict_domain'); 
                ?>
                <b>
                <?php
                esc_html_e("restrict messages.", 'page_restrict_domain'); 
                ?>
                </b>
                </br>
                <b>
                <?php
                esc_html_e("Restrict messages", 'page_restrict_domain'); 
                ?>
                </b>
                <?php
                esc_html_e("= Messages used to show your users they have no access to them either because they haven't logged in, haven't bought the product or their bought product expired.", 'page_restrict_domain'); 
            ?>
            </i>
        </p>
    </div>
</div>
<h2>Pages</h2>
<hr>
<div class="card-main">
    <h3><?php esc_html_e('Default page if product not bought on site pages', 'page_restrict_domain'); ?></h3>
    <div class="not-bought-pages">
        <div>
            <label for=""><?php esc_html_e('Page to show if not bought', 'page_restrict_domain'); ?></label><br>
            <select name="prwc_general_not_bought_page" class="gen_not_bought_page slimselect">
                <option value="" class="empty-option"></option>
                <?php 
                    foreach ($all_pages as $subpost_type => $pages_in_subtype) {
                        ?>
                        <optgroup label="<?php echo $subpost_type; ?>">
                        <?php
                            foreach($pages_in_subtype as $subkey => $subvalue): 
                        ?>
                                <option value="<?php echo $subvalue->ID; ?>" <?php echo $subvalue->ID == $gen_not_bought_page?'selected="selected"':''; ?>><?php echo $subvalue->post_name; ?></option>
                        <?php 
                            endforeach; 
                        ?>
                        </optgroup>
                <?php 
                    } 
                ?>
            </select>
        </div>
        <div class="description">
            <p>
                <i>
                <?php 
                    esc_html_e("Choose which page to use if a", 'page_restrict_domain');
                    ?>
                    <b>
                    <?php
                    esc_html_e("product wasn't bought or expired", 'page_restrict_domain');
                    ?>
                    </b>
                    <?php
                    esc_html_e("for all restricted pages.", 'page_restrict_domain'); 
                ?>
                </i>
            </p>
        </div>
        <hr style="margin-top: 25px; margin-bottom: 25px;">
        <div>
            <input id="redirect_gen_not_bought_id" class="redirect-gen-not_bought-page" name="prwc_general_redirect_not_bought" type="checkbox" name="" value="1" <?php checked($redirect_gen_not_bought, '1'); ?>>
            <label for="redirect_gen_not_bought_id"><?php esc_html_e('Redirect if page not bought', 'page_restrict_domain'); ?></label>
        </div>
        <div class="description">
            <p>
                <i>
                <?php 
                    esc_html_e('Choose to', 'page_restrict_domain');
                    ?>
                    <b>
                    <?php
                    esc_html_e('redirect to the page', 'page_restrict_domain');
                    ?>
                    </b>
                    <?php
                    esc_html_e('instead of the default which is to show the chosen page into the content area of the restricted page.', 'page_restrict_domain'); 
                ?>
                </i>
            </p>
            <p>
                <i>
                    <b style="color: red;"><?php esc_html_e('Warning:', 'page_restrict_domain'); ?></b> 
                    <?php esc_html_e("If you decide to choose a private page (or pages with similar statuses like draft) regular users won't be able to redirect to it. It will just return a 404 error.", 'page_restrict_domain'); ?>
                </i>
            </p>
        </div>
    </div>
    <hr style="border: 2px solid lightgrey; margin-top: 50px;">
    <div class="description">
        <p>
            <i>
            <?php 
                esc_html_e("* General settings for pages when the user", 'page_restrict_domain'); 
                ?>
                <b>
                <?php
                esc_html_e("didn't buy the product or it expired", 'page_restrict_domain');
                ?>
                </b>
                <?php
                esc_html_e("if a page wasn't chosen on a per page bases.", 'page_restrict_domain'); 
            ?>
            </i>
        </p>
    </div>
</div>

<div class="card-main">
    <h3><?php esc_html_e('Default page if user is not logged on site pages', 'page_restrict_domain'); ?></h3>
    <div class="log-reg-pages">
        <div>
            <label for=""><?php esc_html_e('Page to show if not logged in', 'page_restrict_domain'); ?></label><br>
            <select name="prwc_general_login_page" class="gen_log_page slimselect">
                <option value="" class="empty-option"></option>
                <?php 
                    foreach ($all_pages as $subpost_type => $pages_in_subtype) {
                        ?>
                        <optgroup label="<?php echo $subpost_type; ?>">
                        <?php
                            foreach($pages_in_subtype as $subkey => $subvalue): 
                        ?>
                                <option value="<?php echo $subvalue->ID; ?>" <?php echo $subvalue->ID == $gen_log_page?'selected="selected"':''; ?>><?php echo $subvalue->post_name; ?></option>
                        <?php 
                            endforeach; 
                        ?>
                        </optgroup>
                <?php 
                    } 
                ?>
            </select>
        </div>
        <div class="description">
            <p>
                <i>
                <?php 
                    esc_html_e("Choose which page to use if a user", 'page_restrict_domain');
                    ?>
                    <b>
                    <?php
                    esc_html_e("wasn't logged", 'page_restrict_domain');
                    ?>
                    </b>
                    <?php
                    esc_html_e("in for all restricted pages.", 'page_restrict_domain'); 
                ?>
                </i>
            </p>
        </div>
        <hr style="margin-top: 25px; margin-bottom: 25px;">
        <div>
            <input id="redirect_gen_log_id" class="redirect-gen-user-page" name="prwc_general_redirect_login" type="checkbox" name="" value="1" <?php checked($redirect_gen_log, '1'); ?>>
            <label for="redirect_gen_log_id"><?php esc_html_e('Redirect if user is not logged in', 'page_restrict_domain'); ?></label>
        </div>
        <div class="description">
            <p>
                <i>
                <?php 
                    esc_html_e('Choose to ', 'page_restrict_domain');
                    ?>
                    <b>
                    <?php
                    esc_html_e('redirect to the page', 'page_restrict_domain');
                    ?>
                    </b>
                    <?php
                    esc_html_e(' instead of the default which is to show the chosen page into the content area of the restricted page.', 'page_restrict_domain'); 
                ?>
                </i>
            </p>
            <p>
                <i>
                    <b style="color: red;"><?php esc_html_e('Warning:', 'page_restrict_domain'); ?></b> 
                    <?php esc_html_e("If you decide to choose a private page (or pages with similar statuses like draft) regular users won't be able to redirect to it. It will just return a 404 error.", 'page_restrict_domain'); ?>
                </i>
            </p>
        </div>
    </div>
    <hr style="border: 2px solid lightgrey; margin-top: 50px;">
    <div class="description">
        <p>
            <i>
                <?php 
                esc_html_e("* General settings for pages when the user", 'page_restrict_domain');
                ?>
                <b>
                <?php
                esc_html_e("wasn't logged in", 'page_restrict_domain');
                ?>
                </b>
                <?php
                esc_html_e("if a page wasn't chosen on a per page bases.", 'page_restrict_domain'); 
                ?>
            </i>
        </p>
    </div>
</div>
<h2>Sections</h2>
<hr>
<div class="card-main">
    <h3><?php esc_html_e('Default page if product not bought on site sections', 'page_restrict_domain'); ?></h3>
    <div class="not-bought-pages">
        <div>
            <label for=""><?php esc_html_e('Page to show if not bought', 'page_restrict_domain'); ?></label><br>
            <select name="prwc_general_not_bought_section" class="gen_not_bought_page slimselect">
                <option value="" class="empty-option"></option>
                <?php 
                    foreach ($all_pages as $subpost_type => $pages_in_subtype) {
                        ?>
                        <optgroup label="<?php echo $subpost_type; ?>">
                        <?php
                            foreach($pages_in_subtype as $subkey => $subvalue): 
                        ?>
                                <option value="<?php echo $subvalue->ID; ?>" <?php echo $subvalue->ID == $gen_not_bought_section?'selected="selected"':''; ?>><?php echo $subvalue->post_name; ?></option>
                        <?php 
                            endforeach; 
                        ?>
                        </optgroup>
                <?php 
                    } 
                ?>
            </select>
        </div>
        <div class="description">
            <p>
                <i>
                <?php 
                    esc_html_e("Choose which page to use if a", 'page_restrict_domain');
                    ?>
                    <b>
                    <?php
                    esc_html_e("product wasn't bought or expired", 'page_restrict_domain');
                    ?>
                    </b>
                    <?php
                    esc_html_e("for all restricted sections.", 'page_restrict_domain'); 
                ?>
                </i>
            </p>
        </div>
    </div>
    <hr style="border: 2px solid lightgrey; margin-top: 50px;">
    <div class="description">
        <p>
            <i>
            <?php 
                esc_html_e("* General settings for pages when the user", 'page_restrict_domain'); 
                ?>
                <b>
                <?php
                esc_html_e("didn't buy the product or it expired", 'page_restrict_domain');
                ?>
                </b>
                <?php
                esc_html_e("if a page wasn't chosen on a per page bases.", 'page_restrict_domain'); 
            ?>
            </i>
        </p>
    </div>
</div>

<div class="card-main">
    <h3><?php esc_html_e('Default page if user is not logged on site sections', 'page_restrict_domain'); ?></h3>
    <div class="log-reg-pages">
        <div>
            <label for=""><?php esc_html_e('Page to show if not logged in', 'page_restrict_domain'); ?></label><br>
            <select name="prwc_general_login_section" class="gen_log_page slimselect">
                <option value="" class="empty-option"></option>
                <?php 
                    $all_pages;
                    $pages_redirect_out;
                    foreach ($all_pages as $subpost_type => $pages_in_subtype) {
                        ?>
                        <optgroup label="<?php echo $subpost_type; ?>">
                        <?php
                            foreach($pages_in_subtype as $subkey => $subvalue): 
                        ?>
                                <option value="<?php echo $subvalue->ID; ?>" <?php echo $subvalue->ID == $gen_log_section?'selected="selected"':''; ?>><?php echo $subvalue->post_name; ?></option>
                        <?php 
                            endforeach; 
                        ?>
                        </optgroup>
                <?php 
                    } 
                ?>
            </select>
        </div>
        <div class="description">
            <p>
                <i>
                <?php 
                    esc_html_e("Choose which page to use if a user", 'page_restrict_domain');
                    ?>
                    <b>
                    <?php
                    esc_html_e("wasn't logged", 'page_restrict_domain');
                    ?>
                    </b>
                    <?php
                    esc_html_e("in for all restricted sections.", 'page_restrict_domain'); 
                ?>
                </i>
            </p>
        </div>
    </div>
    <hr style="border: 2px solid lightgrey; margin-top: 50px;">
    <div class="description">
        <p>
            <i>
                <?php 
                esc_html_e("* General settings for sections when the user", 'page_restrict_domain');
                ?>
                <b>
                <?php
                esc_html_e("wasn't logged in", 'page_restrict_domain');
                ?>
                </b>
                <?php
                esc_html_e("if a page wasn't chosen on a per page bases.", 'page_restrict_domain'); 
                ?>
            </i>
        </p>
    </div>
</div>
