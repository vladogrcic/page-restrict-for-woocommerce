<?php

/**
 * Wrapper HTML elements for the pages cards and also the loop.
 *
 * This file provides the loop for pages that need to be restricted with wrapper HTML elements.
 *
 * @link       vladogrcic.com
 * @since      1.0.0
 *
 * @package    PageRestrictForWooCommerce
 */

/**
 * Wrapper HTML elements for the pages cards and also the loop.
 *
 * This file provides the loop for pages that need to be restricted with wrapper HTML elements.
 *
 * @package    PageRestrictForWooCommerce
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
?>
<div class="pages-all">
    <h3>
        <?php 
        $check_page_exists = array_key_exists("page", $published_pages);
        esc_html_e('Filter by Post Type', 'page_restrict_domain')
        ?>
    </h3>
    <select class="two-column text-small filter-by-post-types slimselect" style="width: 98.8%;" autocomplete="off">
    <?php if($check_page_exists): ?><option value="page" selected>page</option><?php endif; ?>
    <?php foreach($post_types_out as $post_types_out_key => $post_types_out_value): if($post_types_out_value['value']==="page") continue; ?>
        <option value="<?php echo $post_types_out_value['value']; ?>"><?php echo $post_types_out_value['label']; ?></option>
    <?php endforeach; ?>
    </select>
    <hr style="margin-left:0; margin-right:0; margin-top:15px; width: 98.8%;">
    <div class="pages-list">
        <?php
            foreach ($all_pages as $post_type => $pages) {
                $page_type_style = '';
                if($check_page_exists){
                    if (!($post_type === "page")) {
                        $page_type_style = "display: none;";
                    }
                } 
                else{
                    if(!(key($published_pages)==$post_type)){
                        $page_type_style = "display: none;";
                    }
                }
                ?>
                    <div class="page-type" data-page-type="<?php echo $post_type; ?>" style="<?php echo $page_type_style; ?>">
                    <?php
                        $pages_inc = 0;
                        $page = 1;
                        $total = count( $pages );
                        $limit = 6; //per page    
                        $totalPages = ceil( $total/ $limit );
                        $page = max($page, 1);
                        $page = min($page, $totalPages);
                        $offset = ($page - 1) * $limit;
                        if( $offset < 0 ) $offset = 0;
                        $pages_paginated = [];
                        $offsetGroup = 0;
                        for ($s=0; $s < $totalPages; $s++) { 
                            $offset = $s;
                            if($s !== 0){
                                $offsetGroup = $offsetGroup+$limit;
                            }
                            $pages_paginated[] = array_slice( $pages, $offsetGroup, $limit );
                        }
                        for ($s=0; $s < count($pages_paginated); $s++) { 
                            if($s === 0){
                                $page_display_style = 'display: block;';
                            }
                            else{
                                $page_display_style = 'display: none;';
                            }
                            ?>
                            <div id="page_<?php echo $s+1; ?>" class="page-pagination" data-pagination-page="<?php echo $s+1; ?>" style="<?php echo $page_display_style; ?>">
                            <?php
                            foreach ($pages_paginated[$s] as $key => $value) {
                                $pages_inc++;
                                $prwc_products      =   $page_options->get_page_options($value->ID, 'prwc_products');
                                $prwc_not_all_products_required  =   $page_options->get_page_options($value->ID, 'prwc_not_all_products_required');
                                $prwc_timeout_days       =   $page_options->get_page_options($value->ID, 'prwc_timeout_days');
                                $prwc_timeout_hours      =   $page_options->get_page_options($value->ID, 'prwc_timeout_hours');
                                $prwc_timeout_minutes    =   $page_options->get_page_options($value->ID, 'prwc_timeout_minutes');
                                $prwc_timeout_seconds    =   $page_options->get_page_options($value->ID, 'prwc_timeout_seconds');
                                $prwc_timeout_views      =   $page_options->get_page_options($value->ID, 'prwc_timeout_views');

                                $prwc_not_bought_page        = $page_options->get_page_options($value->ID, 'prwc_not_bought_page');
                                $prwc_redirect_not_bought    = $page_options->get_page_options($value->ID, 'prwc_redirect_not_bought');
                                $prwc_not_logged_in_page     = $page_options->get_page_options($value->ID, 'prwc_not_logged_in_page');
                                $prwc_redirect_not_logged_in = $page_options->get_page_options($value->ID, 'prwc_redirect_not_logged_in');
                                $upOne = dirname(__DIR__);
                                include(plugin_dir_path( __FILE__ )."pages-page.php");
                            }
                            ?>
                            </div>
                            <?php
                        }
                    ?>
                    <div class="pagination">
                        <ul>
                            <?php
                            for ($s=0; $s < $totalPages; $s++):
                                $page_class = '';
                                if($s === 0){
                                    $page_class = 'active';
                                }
                                else{
                                    $page_class = '';
                                }
                                ?>
                                <li class="<?php echo $page_class; ?>" data-pagination-page="<?php echo $s+1; ?>">
                                <?php
                                echo $s+1;
                                ?>
                                </li>
                                <?php
                            endfor;
                            ?>
                        </ul>
                    </div>
                </div>
            <?php
            }
        ?>
    </div>
</div>