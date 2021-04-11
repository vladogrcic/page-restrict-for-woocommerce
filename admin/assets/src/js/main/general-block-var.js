window.__ = wp.i18n.__; //translation functions
window.prwc_plugin_name = page_restrict_wc.plugin_name;
window.prwc_blockName = page_restrict_wc.block_name;
window.prwc_termNames = page_restrict_wc.products_available;
window.prwc_plugin_title = page_restrict_wc.plugin_title;
/**
 * Defines extend function.
 * It merges two objects.
 *
 * @param {Object} obj
 * @param {Object} src
 */
function extend(obj, src) {
	if (typeof obj === 'undefined') return src;
	if (typeof src === 'undefined') return obj;
	Object.keys(src).forEach(function (key) {
		obj[key] = src[key];
	});
	return obj;
}
window.editor_loc = 'core/block-editor';
if (wp.hasOwnProperty('blockEditor')) {
	editor_loc = 'core/block-editor';
} else {
	editor_loc = 'core/editor';
}
page_restrict_wc = extend(page_restrict_wc, {
	attributes: {},
	func: {
		CustomPanel: function CustomPanel(elements, options) {
			const PanelBody = wp.components.PanelBody;
			if (options.initialOpen) options.initialOpen;
			else options.initialOpen = false;

			return (
				<PanelBody
					title={options.title}
					icon={options.icon}
					initialOpen={options.initialOpen}
					className={'custom-panel'}
				>
					{elements}
				</PanelBody>
			);
		},
		getSectionBlocksSlim() {
			const blocks = wp.data
				.select(editor_loc)
				.getBlocks()
				.filter(function (x) {
					return x.name === prwc_blockName;
				})
				.map(function (obj, index) {
					return { value: index, label: obj.clientId };
				});
			return blocks;
		},
		/**
		 * Returns all 'Restrict Section' blocks.
		 *
		 * @return {Object}
		 */
		getSectionBlocks() {
			const blocks = wp.data
				.select(editor_loc)
				.getBlocks()
				.filter(function (x) {
					return x.name === prwc_blockName;
				})
				.map(function (obj, index) {
					return obj;
				});
			return blocks;
		},
		noAboveBlockNotice() {
			wp.data.dispatch('core/notices').createNotice(
				'warning', // Can be one of: success, info, warning, error.
				__(
					'You had the "Above block" or "Below block" setting checked but you dont have a usable block. Add a Section Block below or above in order to be able to check that setting',
					'page_restrict_domain'
				), // Text string to display.
				{
					id: 'no-above-block', //assigning an ID prevents the notice from being added repeatedly
					isDismissible: true, // Whether the user can dismiss the notice.
				}
			);
		},
		disableAboveBlockCheck() {
			wp.data.subscribe(function () {
				if (
					wp.data.select(editor_loc).hasSelectedBlock() &&
					wp.data.select(editor_loc).hasChangedContent()
				) {
					page_restrict_wc.func.noAboveBlockNotice();
					this.attributes.aboveBlockAttr = false;
					disabledInput = false;
				}
			});
		},
	},
});
