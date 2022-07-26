jQuery(function () {
	jQuery('.filter-by-post-types').on('change', function () {
		const post_type = jQuery('.filter-by-post-types').val();
		jQuery('.pages-list').find('.page-type').slideUp('slow');
		jQuery('.pages-list')
			.find('.page-type[data-page-type="' + post_type + '"]')
			.slideDown('slow');
		/**
		 * Reset everything.
		 */
		jQuery('.pages-list').find('.page-pagination').slideUp();
		jQuery('.pages-list').find('.page-pagination:first-child').slideDown();
		jQuery('.pages-list').find('.pagination li').removeClass('active');
		jQuery('.pages-list')
			.find('.pagination li:first-child')
			.addClass('active');
		/**
		 * -----
		 */
	});
});
