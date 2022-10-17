<?php

/**
 * Option cards for specific pages.
 *
 * This file creates cards for specific pages that need this plugins restrict options.
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    PageRestrictForWooCommerce
 */

/**
 * Option cards for specific pages.
 *
 * This file creates cards for specific pages that need this plugins restrict options.
 *
 * @package    PageRestrictForWooCommerce
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */

?>
<div class="card resizable" data-page-slug="<?php echo $value->post_name; ?>" data-page-id="<?php echo $value->ID; ?>">
    <?php
        $redirect_prod_not_bought_id++;
        $redirect_user_not_logged_in_id++;
        $not_all_products_required_id++;
    ?>
    <div class="page-info">
        <div class="page-title">
            <h3 for=""><?php esc_html_e('Post Title', 'page_restrict_domain'); ?></h3>
            <span class="title">
                <?php 
                echo $value->post_title;
                ?>
            </span>
        </div>
        <div class="page-subtitle">
            <h3 for=""><?php esc_html_e('Post Slug', 'page_restrict_domain'); ?></h3>
            
            <span class="subtitle">
                <?php 
                echo $value->post_name;
                ?>
            </span>
            <h4 for=""><?php esc_html_e('Post ID', 'page_restrict_domain'); echo '&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;'.$value->ID;?></h4>
            <!-- <span class="">
                <?php 
                echo $value->ID;
                ?>
            </span> -->
        </div>
        <?php if($value->post_status === 'publish' || $value->post_status === 'future'): ?>
        <div class="page-status">
            <div class="page-name">
                <h3 for=""><?php esc_html_e('Post Status', 'page_restrict_domain'); ?></h3>
                <span class="subtitle">
                    <?php 
                    $timezone       = get_option( 'timezone_string' );
                    $date_format    = get_option( 'date_format' );
                    $time_format    = get_option( 'time_format' );
                    switch ($value->post_status) {
                        case 'publish':
                            esc_html_e('Published', 'page_restrict_domain');
                            break;
                        case 'future':
                            esc_html_e('Scheduled', 'page_restrict_domain');
                            echo '<p>'.date_format(date_create($value->post_date), $date_format.' '.$time_format).'</p>';
                            break;
                    }
                    ?>
                </span>
            </div>
            <?php if($value->post_type === 'post' || $value->post_type === 'page'): ?>
            <span class="edit">
                <?php 
                echo '<a href="'.get_post_permalink($value->ID).'">'.esc_html__("View", "page_restrict_domain").'</a>';
                echo '<a href="'.get_site_url().'/wp-admin/post.php?post='.$value->ID.'&action=edit">'.esc_html__("Edit", "page_restrict_domain").'</a>';
                ?>
            </span>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
    <div class="page-options accordion-resizer">
        <div class="accordion ">
            <span class="subtitle">
                <?php esc_html_e('Products', 'page_restrict_domain'); ?>
            </span>
            <div class="panel also">
                    <label class=""> <?php esc_html_e('Lock by Products', 'page_restrict_domain'); ?> </label>
                    <select class="lock-by-product slimselect" multiple><?php 
                        foreach($products_out as $subkey => $subvalue): 
                            if(is_array($products)): ?>
                                <option value="<?php echo $subvalue['value']; ?>" <?php echo in_array($subvalue['value'], $prwc_products) ?'selected="selected"':''; ?>><?php echo $subvalue['label']; ?></option><?php 
                            else: ?>
                                <option value="<?php echo $subvalue['value']; ?>" <?php echo $subvalue['value'] === $prwc_products?'selected="selected"':''; ?>><?php echo $subvalue['label']; ?></option><?php
                            endif;
                        endforeach ?>
                    </select>
                    <br>
                    <br>
                    <input type="checkbox" class="not-all-products-required" id="not_all_products_required_id_<?php echo $not_all_products_required_id; ?>" value="1" <?php checked($prwc_not_all_products_required, '1'); ?>>
                    <label for="not_all_products_required_id_<?php echo $not_all_products_required_id; ?>" class=""> <?php esc_html_e('Not all products required', 'page_restrict_domain'); ?></label>
                    <br>
                    <hr>
                    <label class=""> <?php esc_html_e('Page to show if product not bought', 'page_restrict_domain'); ?> </label>
                    <select class="redirect-not-bought-page slimselect">
                        <option value="" class="empty-option"></option>
                        <?php 
                        foreach ($all_pages as $subpost_type => $pages_in_subtype) {
                            ?>
                            <optgroup label="<?php echo $subpost_type; ?>">
                            <?php
                            foreach($pages_in_subtype as $subkey => $subvalue): 
                                if($subvalue->ID == $value->ID) continue;
                            ?>
                                <option value="<?php echo $subvalue->ID; ?>" <?php echo $subvalue->ID === $prwc_not_bought_page?'selected="selected"':''; ?>><?php echo $subvalue->post_name; ?></option>
                            <?php endforeach ?>
                            </optgroup>
                        <?php 
                        } 
                        ?>
                    </select>
                    <br>
                    <br>
                    <input id="redirect_prod_not_bought_id_<?php echo $redirect_prod_not_bought_id; ?>" class="redirect-prod-page" type="checkbox" name="" value="1" <?php checked($prwc_redirect_not_bought, '1'); ?>>
                    <label for="redirect_prod_not_bought_id_<?php echo $redirect_prod_not_bought_id; ?>"><?php esc_html_e('Redirect if product was not bought', 'page_restrict_domain'); ?></label>
                    <hr>
                    <label class=""> <?php esc_html_e('Page to show if user is not logged in', 'page_restrict_domain'); ?> </label>
                    <select class="redirect-not-logged-in-page slimselect">
                        <option value="" class="empty-option"></option>
                    <?php 
                        foreach ($all_pages as $subpost_type => $pages_in_subtype) {
                            ?>
                            <optgroup label="<?php echo $subpost_type; ?>">
                            <?php
                            foreach($pages_in_subtype as $subkey => $subvalue): 
                                if($subvalue->ID == $value->ID) continue;
                                ?>
                                <option value="<?php echo $subvalue->ID; ?>" <?php echo $subvalue->ID === $prwc_not_logged_in_page?'selected="selected"':''; ?>><?php echo $subvalue->post_name; ?></option>
                            <?php endforeach ?>
                            </optgroup>
                        <?php 
                        } 
                        ?>
                    </select>
                    <br>
                    <br>
                    <input id="redirect_user_not_logged_in_id_<?php echo $redirect_user_not_logged_in_id; ?>" class="redirect-user-page" type="checkbox" name="" value="1" <?php checked($prwc_redirect_not_logged_in, '1'); ?>>
                    <label for="redirect_user_not_logged_in_id_<?php echo $redirect_user_not_logged_in_id; ?>"><?php esc_html_e('Redirect if user is not logged in', 'page_restrict_domain'); ?></label>
                    <div class="warning-private-page-redirect">
                        <hr/>
                        <p>
                            <i>
                                <b style="color: red;"><?php esc_html_e('Warning:', 'page_restrict_domain'); ?></b> 
                                <?php esc_html_e("If you decide to choose a private page (or pages with similar statuses like draft) regular users won't be able to redirect to it. It will just return a 404 error.", 'page_restrict_domain'); ?>
                            </i>
                        </p>
                    </div>
                </div>
            <span class="subtitle">
                <?php esc_html_e('Timeout', 'page_restrict_domain'); ?>
            </span>
            <div class="panel">
                <div>
                    <label class="two-column"> <?php esc_html_e('Days', 'page_restrict_domain'); ?> </label>
                    <input type="number" min="0" class="two-column timeout-days" value="<?php echo $prwc_timeout_days;?>"><br>
                </div>
                <hr>
                <div>
                    <label class="two-column"> <?php esc_html_e('Hours', 'page_restrict_domain'); ?> </label>
                    <input type="number" min="0" class="two-column timeout-hours" value="<?php echo $prwc_timeout_hours;?>"><br>
                </div>
                <hr>
                <div>
                    <label class="two-column"> <?php esc_html_e('Minutes', 'page_restrict_domain'); ?> </label>
                    <input type="number" min="0" class="two-column timeout-minutes" value="<?php echo $prwc_timeout_minutes;?>"><br>
                </div>
                <hr>
                <div>
                    <label class="two-column"> <?php esc_html_e('Seconds', 'page_restrict_domain'); ?> </label>
                    <input type="number" min="0" class="two-column timeout-seconds" value="<?php echo $prwc_timeout_seconds;?>"><br>
                </div>
                <hr>
                <div>
                    <label class="two-column"> <?php esc_html_e('Views', 'page_restrict_domain'); ?> </label>
                    <input type="number" min="0" class="two-column timeout-views" value="<?php echo $prwc_timeout_views;?>"><br>
                </div>
            </div>
        </div>
    </div>
</div>