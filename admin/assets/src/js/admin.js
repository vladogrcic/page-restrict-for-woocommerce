jQuery(function () {
    save_main_options_ajax();
});
window.sendDataAjax = function ($this, data) {
    jQuery($this).css('background-image', 'url(' + plugin_dir_url + '/assets/img/loading.svg)');
    jQuery($this).addClass('loading');
    jQuery($this).attr('disabled', 'disabled');
    var el = $this;
    jQuery.ajax({
        url: ajaxurl,
        type: 'POST',
        data: data,
        beforeSend: function () {
        },
        success: function (response) {
            setTimeout(() => {
                jQuery(el).css('background-image', 'none');
                jQuery(el).removeClass('loading');
                jQuery(el).removeAttr('disabled');
            }, 10);
        }
    });
};
function save_main_options_ajax() {
    jQuery('.filter-by-post-types').on('change', function () {
        var post_type = jQuery(".filter-by-post-types").val();
        jQuery(".pages-list").find('.page-type').slideUp("slow");
        jQuery(".pages-list").find('.page-type[data-page-type="' + post_type + '"]').slideDown("slow");
        /**
         * Reset everything.
         */
        jQuery(".pages-list").find('.page-pagination').slideUp();
        jQuery(".pages-list").find('.page-pagination:first-child').slideDown();
        jQuery(".pages-list").find('.pagination li').removeClass('active');
        jQuery(".pages-list").find('.pagination li:first-child').addClass('active');
        /**
         * -----
         */
    });
    jQuery('.pagination li').on('click', function () {
        var page = jQuery(this).data('pagination-page');
        if (jQuery('.tab').length) {
            var main_el = jQuery('.tab .pages-list');
        }
        else {
            var main_el = jQuery('.pages-list');
        }
        main_el.find('.page-pagination').slideUp("slow");
        main_el.find('.pagination li').removeClass('active');
        jQuery(this).toggleClass('active');
        main_el.find('.page-pagination[data-pagination-page="' + page + '"]').slideDown("slow");
    });
    jQuery('.tab-menu li').on('click', function () {
        var el_tab = jQuery('#prwc-plugin-main-wrapper .tab');
        for (var i = 0; i < el_tab.length; i++) {
            jQuery(el_tab[i]).find(".pages-list").find('.pagination li').removeClass('active');
            jQuery(el_tab[i]).find(".pages-list").find('.pagination li:first-child').addClass('active');
            /**
             * Reset everything.
             */
            jQuery(el_tab[i]).find(".pages-list").find('.page-pagination').slideUp();
            jQuery(el_tab[i]).find(".pages-list").find('.page-pagination:first-child').slideDown();
            jQuery(el_tab[i]).find(".pages-list").find('.pagination li').removeClass('active');
            jQuery(el_tab[i]).find(".pages-list").find('.pagination li:first-child').addClass('active');
            /**
             * -----
             */
        }
    });
    /**
     * This is to send plugin or page options data to the database.
     */
    jQuery('.button-submit').on('click', function () {
        if (jQuery('.plugin-options-wrapper').length) {
            var limit_to_virt_products = +(jQuery("input[name='prwc_limit_to_virtual_products']").is(":checked"));
            var limit_to_down_products = +(jQuery("input[name='prwc_limit_to_downloadable_products']").is(":checked"));

            var gen_log_page = +(jQuery("select[name='prwc_general_login_page']")).val();
            var redirect_gen_log = +(jQuery("input[name='prwc_general_redirect_login']").is(":checked"));

            var gen_not_bought_page = +(jQuery("select[name='prwc_general_not_bought_page']")).val();
            var redirect_gen_not_bought = +(jQuery("input[name='prwc_general_redirect_not_bought']").is(":checked"));

            var post_types_general = [];
            var delete_plugin_data_on_uninstall = +(jQuery("input[name='prwc_delete_plugin_data_on_uninstall']").is(":checked"));
            var prwc_my_account_rp_page_disable_endpoint = +(jQuery("input[name='prwc_my_account_rp_page_disable_endpoint']").is(":checked"));
            var prwc_my_account_rp_page_hide_time_table = +(jQuery("input[name='prwc_my_account_rp_page_hide_time_table']").is(":checked"));
            var prwc_my_account_rp_page_hide_view_table = +(jQuery("input[name='prwc_my_account_rp_page_hide_view_table']").is(":checked"));
            var prwc_my_account_rp_page_disable_plugin_designed_table = +(jQuery("input[name='prwc_my_account_rp_page_disable_plugin_designed_table']").is(":checked"));

            if (jQuery("select[name='prwc_general_post_types']").length)
                post_types_general = jQuery("select[name='prwc_general_post_types']").val() ? jQuery("select[name='prwc_general_post_types']").val().join() : [];
            else post_types_general = false
            var data = {
                action: "prwc_plugin_options",
                nonce: page_restrict_wc.nonce,
                option_page: 'prwc-settings-group',
                prwc_limit_to_virtual_products: limit_to_virt_products,
                prwc_delete_plugin_data_on_uninstall: delete_plugin_data_on_uninstall,
                prwc_limit_to_downloadable_products: limit_to_down_products,

                prwc_general_login_page: gen_log_page,
                prwc_general_redirect_login: redirect_gen_log,

                prwc_general_not_bought_page: gen_not_bought_page,
                prwc_general_redirect_not_bought: redirect_gen_not_bought,

                prwc_general_post_types: post_types_general,
                prwc_my_account_rp_page_disable_endpoint: prwc_my_account_rp_page_disable_endpoint,
                prwc_my_account_rp_page_hide_time_table: prwc_my_account_rp_page_hide_time_table,
                prwc_my_account_rp_page_hide_view_table: prwc_my_account_rp_page_hide_view_table,
                prwc_my_account_rp_page_disable_plugin_designed_table: prwc_my_account_rp_page_disable_plugin_designed_table
            };
            sendDataAjax(this, data);
        }
        if (jQuery('.pages-options-wrapper').length) {
            var data = {
                action: "prwc_pages_options",
                nonce: page_restrict_wc.nonce,
                option_page: 'prwc-settings-group',
            };
            var pages = jQuery(".pages-all > .pages-list > .page-type > .page-pagination > .card");
            window.pages_lock_data = {};
            for (var i = 0; i < pages.length; i++) {
                // console.log(jQuery(pages[i]).data('page-slug'));
                var prwc_products = jQuery(pages[i]).find('.lock-by-product').val();
                if (Array.isArray(prwc_products)) {
                    prwc_products = prwc_products.join(',');
                }
                var prwc_not_all_products_required = +(jQuery(pages[i]).find('.not-all-products-required').is(':checked'));

                var prwc_not_bought_page = jQuery(pages[i]).find('.redirect-not-bought-page').val();
                var prwc_redirect_not_bought = +(jQuery(pages[i]).find('.redirect-prod-page').is(':checked'));
                var prwc_not_logged_in_page = jQuery(pages[i]).find('.redirect-not-logged-in-page').val();
                var prwc_redirect_not_logged_in = +(jQuery(pages[i]).find('.redirect-user-page').is(':checked'));
                var prwc_timeout_days = jQuery(pages[i]).find('.timeout-days').val();
                var prwc_timeout_hours = jQuery(pages[i]).find('.timeout-hours').val();
                var prwc_timeout_minutes = jQuery(pages[i]).find('.timeout-minutes').val();
                var prwc_timeout_seconds = jQuery(pages[i]).find('.timeout-seconds').val();
                var prwc_timeout_views = jQuery(pages[i]).find('.timeout-views').val();

                pages_lock_data[jQuery(pages[i]).data('page-id')] = {
                    'prwc_products': prwc_products,
                    'prwc_not_all_products_required': prwc_not_all_products_required,
                    'prwc_not_bought_page': prwc_not_bought_page,
                    'prwc_redirect_not_bought': prwc_redirect_not_bought,
                    'prwc_not_logged_in_page': prwc_not_logged_in_page,
                    'prwc_redirect_not_logged_in': prwc_redirect_not_logged_in,
                    'prwc_timeout_days': prwc_timeout_days,
                    'prwc_timeout_hours': prwc_timeout_hours,
                    'prwc_timeout_minutes': prwc_timeout_minutes,
                    'prwc_timeout_seconds': prwc_timeout_seconds,
                    'prwc_timeout_views': prwc_timeout_views,
                };
            }
            data.pages_lock_data = pages_lock_data;
            sendDataAjax(this, data);
        }
    });
} 