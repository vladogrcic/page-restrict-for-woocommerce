jQuery(function () {
	jQuery('.tab-menu li').on('click', function () {
		const el_tab = jQuery('#prwc-plugin-main-wrapper .tab');
		for (let i = 0; i < el_tab.length; i++) {
			jQuery(el_tab[i])
				.find('.pages-list')
				.find('.pagination li')
				.removeClass('active');
			jQuery(el_tab[i])
				.find('.pages-list')
				.find('.pagination li:first-child')
				.addClass('active');
			/**
			 * Reset everything.
			 */
			jQuery(el_tab[i])
				.find('.pages-list')
				.find('.page-pagination')
				.slideUp();
			jQuery(el_tab[i])
				.find('.pages-list')
				.find('.page-pagination:first-child')
				.slideDown();
			jQuery(el_tab[i])
				.find('.pages-list')
				.find('.pagination li')
				.removeClass('active');
			jQuery(el_tab[i])
				.find('.pages-list')
				.find('.pagination li:first-child')
				.addClass('active');
			/**
			 * -----
			 */
		}
	});
});
