jQuery(function () {
	jQuery('.pagination li').on('click', function () {
		const page = jQuery(this).data('pagination-page');
		if (jQuery('.tab').length) {
			var main_el = jQuery('.tab .pages-list');
		} else {
			var main_el = jQuery('.pages-list');
		}
		main_el.find('.page-pagination').slideUp('slow');
		main_el.find('.pagination li').removeClass('active');
		jQuery(this).toggleClass('active');
		main_el
			.find('.page-pagination[data-pagination-page="' + page + '"]')
			.slideDown('slow');
	});
});
