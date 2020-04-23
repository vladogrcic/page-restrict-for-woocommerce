<?php

/**
 * General plugin wide settings.
 *
 * This file provides general plugin settings.
 *
 * @link       vladogrcic.com
 * @since      1.1.0
 *
 * @package    Page_Restrict_Wc
 * @subpackage Page_Restrict_Wc/admin/partials/menu-pages/user-overview/tabs
 */

/**
 * General plugin wide settings.
 *
 * This file provides general plugin settings.
 *
 * @package    Page_Restrict_Wc
 * @subpackage Page_Restrict_Wc/admin/partials/menu-pages/user-overview/tabs
 * @author     Vlado Grčić <vladogrcic1993@gmail.com>
 */
?>
<style>
  table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
  }

  td,
  th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
  }

  tr:nth-child(even) {
    background-color: #dddddd;
  }
</style>
<div class="">
  <h3><?php esc_html_e('Check users page expiration by view count', 'page_restrict_domain'); ?></h3>
  <hr style="margin-bottom: 25px; border: 2px solid grey;">
  <div class="users-inline pages-list">
    <?php
    if (empty($page_users_paginated_view)){
      echo '<b>'.esc_html__( "There aren't any users that bought any products needed to access restricted pages.", 'page_restrict_domain' ).'</b>';
    }
    foreach ($page_users_paginated_view as $page_num => $user_data):
      if ($page_num === 0) {
        $page_display_style = 'display: block;';
      } else {
          $page_display_style = 'display: none;';
      }
      ?>
      <div id="page_view_<?php echo $page_num + 1; ?>" class="page-pagination" data-pagination-page="<?php echo $page_num + 1; ?>" style="<?php echo $page_display_style; ?>">
      <?php
      foreach ($user_data as $post_id => $value):
        ?>
        <div class="locked-pages">
          <div class="page-boxes">
            <div>
              <h3><?php esc_html_e( 'Post ID', 'page_restrict_domain' ); ?></h3>
              <span><?php echo $locked_posts[$post_id]['post']->ID; ?></span>

            </div>
            <div>
              <h3><?php esc_html_e( 'Post Title', 'page_restrict_domain' ); ?></h3>
              <span><?php echo $locked_posts[$post_id]['post']->post_title; ?></span>
            </div>
            <div>
              <h3><?php esc_html_e( 'Post Slug', 'page_restrict_domain' ); ?></h3>
              <span><?php echo $locked_posts[$post_id]['post']->post_name; ?></span>
            </div>
            <?php
            if(isset($locked_posts[$post_id]['views'])):
            ?>
            <div>
              <h3><?php esc_html_e( 'Expiration Views', 'page_restrict_domain' ); ?></h3>
              <span><?php echo $locked_posts[$post_id]['views']; ?></span>
            </div>
            <?php
            endif;
            ?>
            <div>
              <div class="edit">
                <?php 
                      echo '<a href="'.get_post_permalink($locked_posts[$post_id]['post']->ID).'">'.esc_html__("View", "page_restrict_domain").'</a>';
                      echo '<a href="'.get_site_url().'/wp-admin/post.php?post='.$locked_posts[$post_id]['post']->ID.'&action=edit">'.esc_html__("Edit", "page_restrict_domain").'</a>';
                      ?>
              </div>
            </div>
          </div>
          <div class="user-boxes">
            <?php
            foreach ($value as $user_id => $vars):
              $expiration = (int)$vars['view_expiration_num'] - (int)$vars['views'];
              // if(!$vars['views']) continue;
              ?>
              <div class="inline-boxes <?php echo $expiration <= 0?'red-palette':''; ?>"
                style="border: 3px solid <?php echo $expiration <= 0?'Crimson':'DodgerBlue'; ?>; border-top: 15px solid <?php echo $expiration <= 0?'Crimson':'DodgerBlue'; ?>;">
                <div>
                  <h3><?php esc_html_e( 'Username', 'page_restrict_domain' ); ?></h3>
                  <span><?php echo $vars['user']->user_login; ?></span>
                </div>
                <div>
                  <h3><?php esc_html_e( 'Email', 'page_restrict_domain' ); ?></h3>
                  <span><?php echo $vars['user']->user_email; ?></span>
                </div>
                <div style="background-color: <?php echo $expiration <= 0?'#BB4F4D':''; ?>;">
                  <h3><?php esc_html_e( 'Times Viewed', 'page_restrict_domain' ); ?></h3>
                  <span><?php echo $vars['views']; ?></span>
                </div>
                <div>
                  <h3><?php esc_html_e( 'Number of views until expiration', 'page_restrict_domain' ); ?></h3>
                  <span><?php echo $expiration; ?></span>
                </div>
              </div>
            <?php
            endforeach;
            ?>
          </div>
        </div>
        <?php
        endforeach;
        ?>
        </div>
        <?php
      endforeach;
    ?>
    <div class="pagination">
      <ul>
        <?php
        for ($s = 0; $s < $totalPages_view; $s++):
          $page_class = '';
          if ($s === 0) {
              $page_class = 'active';
          } else {
              $page_class = '';
          }
          ?>
          <li class="<?php echo $page_class; ?>" data-pagination-page="<?php echo $s + 1; ?>">
          <?php
          echo $s + 1;
          ?>
          </li>
        <?php
        endfor;
        ?>
      </ul>
    </div>
  </div>
</div>