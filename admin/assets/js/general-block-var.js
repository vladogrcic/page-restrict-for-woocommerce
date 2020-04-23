var __ = wp.i18n.__; //translation functions
// var prwc_blockName 		= page_restrict_wc.block_name;
// var prwc_blockName_restricted_pages_list 		= page_restrict_wc.block_name_restricted_pages_list;
var prwc_termNames 		= page_restrict_wc.products_available;
var prwc_plugin_title 	= page_restrict_wc.plugin_title;
/**
 * Defines extend function.
 * It merges two objects.
 * @param {object} obj 
 * @param {object} src 
 */
function extend(obj, src) {
	if (typeof obj === "undefined") return src;
	if (typeof src === "undefined") return obj;
	Object.keys(src).forEach(function (key) { obj[key] = src[key]; });
	return obj;
}
var editor_loc = 'core/block-editor';
if(wp.hasOwnProperty('blockEditor')){
	editor_loc = 'core/block-editor';
}
else{
	editor_loc = 'core/editor';
}
page_restrict_wc = extend(page_restrict_wc, {
	attributes: {},
	func: {
		CustomPanel: function CustomPanel(elements, options) {
			var PanelBody = wp.components.PanelBody;
			if (options.initialOpen)
				options.initialOpen
			else
				options.initialOpen = false;
			return wp.element.createElement(
				PanelBody,
				{
					title: 		 options.title,
					icon: 		 options.icon,
					initialOpen: options.initialOpen,
					className: 'custom-panel'
				},
				elements
			);
		},
		slimSelectEnable: function () {
			if (document.querySelectorAll(".slim-select")){
				var select_element = document.querySelectorAll("select.slim-select");
				for (var i = 0; i < select_element.length; i++) {
					if (!(select_element[i].getAttribute("data-ssid"))) {
						new SlimSelect({
							select: 			select_element[i],
							placeholder: 		__('Select Value', 	'page_restrict_domain'),
							text:				__('', 			   	'page_restrict_domain'),
							searchPlaceholder: 	__('Search', 		'page_restrict_domain'),
							searchText: 		__('No Results', 	'page_restrict_domain'),
							searchingText: 		__('Searching...', 	'page_restrict_domain'),
							allowDeselect: 		true,
						});
					}
				}
			}
		},
		getSectionBlocksSlim: function () {
			var blocks = wp.data.select(editor_loc).getBlocks().filter(function (x) {
				return x.name === (prwc_blockName);
			}).map(function (obj, index) {
				return { "value": index, "label": obj.clientId };
			});
			return blocks;
		},
		/**
		 * Returns all 'Restrict Section' blocks.
		 * @returns {object}
		 */
		getSectionBlocks: function () {
			var blocks = wp.data.select(editor_loc).getBlocks().filter(function (x) {
				return x.name === (prwc_blockName);
			}).map(function (obj, index) {
				return obj;
			});
			return blocks;
		},
		noAboveBlockNotice: function () {
			wp.data.dispatch('core/notices').createNotice(
				'warning', // Can be one of: success, info, warning, error.
				__('You had the "Above block" or "Below block" setting checked but you dont have a usable block. Add a Section Block below or above in order to be able to check that setting', 'page_restrict_domain'), // Text string to display.
				{
					id: 'no-above-block', //assigning an ID prevents the notice from being added repeatedly
					isDismissible: true, // Whether the user can dismiss the notice.
				}
			);
		},
		disableAboveBlockCheck: function () {
			wp.data.subscribe(function () {
				if (wp.data.select(editor_loc).hasSelectedBlock() && wp.data.select(editor_loc).hasChangedContent()) {
					page_restrict_wc.func.noAboveBlockNotice();
					this.attributes.aboveBlockAttr = false;
					disabledInput = false;
				}
			});
		},
		checkForEmptyInputs: function (element, prwc_termNames, missingElement) {
			if(prwc_termNames.length){
				return element;
			}
			else{
				return missingElement;
			}
		},
	}
});