const sendDataAjax = function ($this, data) {
	jQuery($this).css(
		'background-image',
		'url(' + plugin_dir_url + '/assets/img/loading.svg)'
	);
	jQuery($this).addClass('loading');
	jQuery($this).attr('disabled', 'disabled');
	const el = $this;
	jQuery.ajax({
		url: ajaxurl,
		type: 'POST',
		data,
		beforeSend() {},
		success(response) {
			setTimeout(() => {
				jQuery(el).css('background-image', 'none');
				jQuery(el).removeClass('loading');
				jQuery(el).removeAttr('disabled');
			}, 10);
		},
	});
};
export default sendDataAjax;
