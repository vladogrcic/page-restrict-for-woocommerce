import PreviewTimeViewTables from './components/preview-time-view-tables';

const __ = wp.i18n.__;
const { InnerBlocks, InspectorControls } = wp.hasOwnProperty('blockEditor')
	? wp.blockEditor
	: wp.editor; //Block inspector wrapper

const registerBlockType = wp.blocks.registerBlockType;

const { PanelBody, ToggleControl } = wp.components;

registerBlockType('page-restrict-wc/restricted-pages-list', {
	title: __('Restricted Pages List', 'page_restrict_domain'),
	description: __(
		'Shows a list of all pages that the current user bought a product needed for unlock.',
		'page_restrict_domain'
	),
	icon: 'schedule',
	category: 'widgets',
	keywords: ['restrict Section for WooCommerce'],
	attributes: {
		time: {
			type: 'boolean',
			default: true,
		},
		view: {
			type: 'boolean',
			default: false,
		},
		disable_table_class: {
			type: 'boolean',
			default: false,
		},
	},
	edit(props) {
		// page_restrict_wc.attributes = attributes;

		const attributes = props.attributes;
		const setAttributes = props.setAttributes;

		const _props$attributes = props.attributes,
			content = _props$attributes.content,
			alignment = _props$attributes.alignment,
			className = props.className;

		const onChangeContent = function onChangeContent(newContent) {
			props.setAttributes({
				content: newContent,
			});
		};

		const onChangeAlignment = function onChangeAlignment(newAlignment) {
			props.setAttributes({
				alignment: newAlignment === undefined ? 'none' : newAlignment,
			});
		};
		return (
			<div>
				<div className={attributes.className} attributes={attributes}>
					<div>
						<PreviewTimeViewTables
							disable_table_class={attributes.disable_table_class}
							time={attributes.time}
							view={attributes.view}
						/>
					</div>
				</div>
				<InspectorControls>
					<PanelBody
						title={__('General', 'page_restrict_domain')}
						icon={'admin-generic'}
						initialOpen={true}
						className={'custom-panel'}
					>
						<ToggleControl
							label={__(
								'Show Time Table',
								'page_restrict_domain'
							)}
							checked={attributes.time}
							onChange={function (time) {
								setAttributes({ time });
								setAttributes({ view: false });
								if (!(time && attributes.view)) {
									setAttributes({ time: false });
									setAttributes({ view: true });
								}
							}}
						/>
						<ToggleControl
							label={__(
								'Show View Table',
								'page_restrict_domain'
							)}
							checked={attributes.view}
							onChange={function (view) {
								setAttributes({ view });
								setAttributes({ time: false });
								if (!(attributes.time && view)) {
									setAttributes({ time: true });
									setAttributes({ view: false });
								}
							}}
						/>
						<span className="block-description">
							<span>
								{__(
									'Show a table containing all pages the current user bought products for in order to access them.',
									'page_restrict_domain'
								)}
							</span>
						</span>
						<br />
						<br />
						<ToggleControl
							label={__(
								'Disable default table design',
								'page_restrict_domain'
							)}
							checked={attributes.disable_table_class}
							onChange={function (disable_table_class) {
								setAttributes({
									disable_table_class,
								});
							}}
						/>
					</PanelBody>
				</InspectorControls>
			</div>
		);
	},
	save(props) {
		return (
			<div className={props.className}>
				<div className={'custom-sec-inner'}>
					<InnerBlocks.Content></InnerBlocks.Content>
				</div>
			</div>
		);
	},
});
