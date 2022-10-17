import sendDataAjax from './ajax.js';
/**
 * This is to send plugin or page options data to the database.
 */
jQuery(function () {
	jQuery('.button-submit').on('click', function () {
		/**
		 * Plugin options page.
		 */
		if (jQuery('.plugin-options-wrapper').length) {
			const limit_to_virt_products = +jQuery(
				"input[name='prwc_limit_to_virtual_products']"
			).is(':checked');
			const limit_to_down_products = +jQuery(
				"input[name='prwc_limit_to_downloadable_products']"
			).is(':checked');

			const gen_log_page = +jQuery(
				"select[name='prwc_general_login_page']"
			).val();

			const redirect_gen_log = +jQuery(
				"input[name='prwc_general_redirect_login']"
			).is(':checked');

			const gen_not_bought_page = +jQuery(
				"select[name='prwc_general_not_bought_page']"
			).val();
			const redirect_gen_not_bought = +jQuery(
				"input[name='prwc_general_redirect_not_bought']"
			).is(':checked');

			const gen_not_bought_section = +jQuery(
				"select[name='prwc_general_not_bought_section']"
			).val();

			const gen_log_section = +jQuery(
				"select[name='prwc_general_login_section']"
			).val();

			let post_types_general = [];
			const delete_plugin_data_on_uninstall = +jQuery(
				"input[name='prwc_delete_plugin_data_on_uninstall']"
			).is(':checked');
			const prwc_my_account_rp_page_disable_endpoint = +jQuery(
				"input[name='prwc_my_account_rp_page_disable_endpoint']"
			).is(':checked');
			const prwc_my_account_rp_page_hide_time_table = +jQuery(
				"input[name='prwc_my_account_rp_page_hide_time_table']"
			).is(':checked');
			const prwc_my_account_rp_page_hide_view_table = +jQuery(
				"input[name='prwc_my_account_rp_page_hide_view_table']"
			).is(':checked');
			const prwc_my_account_rp_page_disable_plugin_designed_table = +jQuery(
				"input[name='prwc_my_account_rp_page_disable_plugin_designed_table']"
			).is(':checked');

			if (jQuery("select[name='prwc_general_post_types']").length)
				post_types_general = jQuery(
					"select[name='prwc_general_post_types']"
				).val()
					? jQuery("select[name='prwc_general_post_types']")
							.val()
							.join()
					: [];
			else post_types_general = false;
			var data = {
				action: 'prwc_plugin_options',
				nonce: page_restrict_wc.nonce,
				option_page: 'prwc-settings-group',
				prwc_limit_to_virtual_products: limit_to_virt_products,
				prwc_delete_plugin_data_on_uninstall: delete_plugin_data_on_uninstall,
				prwc_limit_to_downloadable_products: limit_to_down_products,

				prwc_general_login_page: gen_log_page,
				prwc_general_redirect_login: redirect_gen_log,

				prwc_general_not_bought_page: gen_not_bought_page,
				prwc_general_redirect_not_bought: redirect_gen_not_bought,

				prwc_general_login_section: gen_log_section,
				prwc_general_not_bought_section: gen_not_bought_section,

				prwc_general_post_types: post_types_general,
				prwc_my_account_rp_page_disable_endpoint,
				prwc_my_account_rp_page_hide_time_table,
				prwc_my_account_rp_page_hide_view_table,
				prwc_my_account_rp_page_disable_plugin_designed_table,
			};
			sendDataAjax(this, data);
		}
		/**
		 * Page restrict page.
		 */
		if (jQuery('.pages-options-wrapper').length) {
			var data = {
				action: 'prwc_pages_options',
				nonce: page_restrict_wc.nonce,
				option_page: 'prwc-settings-group',
			};
			const pages = jQuery(
				'.pages-all > .pages-list > .page-type > .page-pagination > .card'
			);
			window.pages_lock_data = {};
			for (let i = 0; i < pages.length; i++) {
				let prwc_products = jQuery(pages[i])
					.find('.lock-by-product')
					.val();
				if (Array.isArray(prwc_products)) {
					prwc_products = prwc_products.join(',');
				}
				const prwc_not_all_products_required = +jQuery(pages[i])
					.find('.not-all-products-required')
					.is(':checked');

				const prwc_not_bought_page = jQuery(pages[i])
					.find('.redirect-not-bought-page')
					.val();
				const prwc_redirect_not_bought = +jQuery(pages[i])
					.find('.redirect-prod-page')
					.is(':checked');
				const prwc_not_logged_in_page = jQuery(pages[i])
					.find('.redirect-not-logged-in-page')
					.val();
				const prwc_redirect_not_logged_in = +jQuery(pages[i])
					.find('.redirect-user-page')
					.is(':checked');
				const prwc_timeout_days = jQuery(pages[i])
					.find('.timeout-days')
					.val();
				const prwc_timeout_hours = jQuery(pages[i])
					.find('.timeout-hours')
					.val();
				const prwc_timeout_minutes = jQuery(pages[i])
					.find('.timeout-minutes')
					.val();
				const prwc_timeout_seconds = jQuery(pages[i])
					.find('.timeout-seconds')
					.val();
				const prwc_timeout_views = jQuery(pages[i])
					.find('.timeout-views')
					.val();

				pages_lock_data[jQuery(pages[i]).data('page-id')] = {
					prwc_products,
					prwc_not_all_products_required,
					prwc_not_bought_page,
					prwc_redirect_not_bought,
					prwc_not_logged_in_page,
					prwc_redirect_not_logged_in,
					prwc_timeout_days,
					prwc_timeout_hours,
					prwc_timeout_minutes,
					prwc_timeout_seconds,
					prwc_timeout_views,
				};
			}
			data.pages_lock_data = pages_lock_data;
			sendDataAjax(this, data);
		}
	});
});
