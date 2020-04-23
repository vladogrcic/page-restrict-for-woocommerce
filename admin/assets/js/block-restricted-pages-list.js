(function () {
	var element = wp.element;
	
	var __			= wp.i18n.__;
	var el 			= element.createElement;
	if(wp.hasOwnProperty('blockEditor')){
		var InnerBlocks 	= wp.blockEditor.InnerBlocks; //Block inspector wrapper
		var InspectorControls 	= wp.blockEditor.InspectorControls; //Block inspector wrapper
	}
	else{
		var InnerBlocks 	= wp.editor.InnerBlocks; //Block inspector wrapper
		var InspectorControls 	= wp.editor.InspectorControls; //Block inspector wrapper
	}
	var CustomPanel 				= page_restrict_wc.func.CustomPanel;
	var slimSelectEnable 			= page_restrict_wc.func.slimSelectEnable;
	var getSectionBlocks 			= page_restrict_wc.func.getSectionBlocks;
	var noAboveBlockNotice 			= page_restrict_wc.func.noAboveBlockNotice;
	var checkForEmptyInputs 		= page_restrict_wc.func.checkForEmptyInputs;

	var registerBlockType 		= wp.blocks.registerBlockType;
	var icon = el('svg', {}, el('image', {href: page_restrict_wc.sidebar_img }));
	
	var TextControl 		= wp.components.TextControl;
	var SelectControl 		= wp.components.SelectControl;
	var ToggleControl 		= wp.components.ToggleControl;

	registerBlockType('page-restrict-wc/restricted-pages-list', {
		title: 		 __('Restricted Pages List', 'page_restrict_domain'),
		description: __('Shows a list of all pages that the current user bought a product needed for unlock.', 'page_restrict_domain'),
		icon: 		 'schedule',
		category: 	 'widgets',
		keywords: 	 ['restrict Section for WooCommerce'],
		attributes:  {
			time: {
				type: 	 'boolean',
				default: true,
			},
			view: {
				type: 	 'boolean',
				default: false,
			},
			disable_table_class: {
				type: 	 'boolean',
				default: false,
			},
		},
		edit: function (props) {
			page_restrict_wc.attributes = attributes;

			var attributes 		= props.attributes;
			var setAttributes 	= props.setAttributes;
			var table;
			var time_class = 'timeout_table time';
			if( attributes.disable_table_class ){
				time_class = '';
			}
			var time_table = el('table', {
				className:  time_class,
			}, el('tbody', {}, [
				el('tr', {}, [el('th', {}, 'Page'), el('th', {}, 'Time of Expiration')]), 
				el('tr', {}, [el('td', {}, 'Sint quam voluptatem sed accusamus ut'), el('td', {}, '18.04.2020 19:11')]),
				el('tr', {}, [el('td', {}, 'Phasellus et fringilla velit'), el('td', {}, '08.04.2020 04:32')]),
				el('tr', {}, [el('td', {}, 'Animi maxime numquam veniam aliquam aut distinctio'), el('td', {}, '14.04.2020 19:11')])
			]));
			var view_class = 'timeout_table view';
			if( attributes.disable_table_class ){
				view_class = '';
			}
			var view_table = el('table', {
				className:  view_class,
			}, el('tbody', {}, [
				el('tr', {}, [el('th', {}, 'Page'), el('th', {}, 'View'), el('th', {}, 'Views left')]), 
				el('tr', {}, [el('td', {}, 'Fugiat repellat qui harum minus recusandae'), el('td', {}, '2'), el('td', {}, '4')]),
				el('tr', {}, [el('td', {}, 'Doloremque non sunt sint dolorum'), el('td', {}, '2'), el('td', {}, '3')]),
				el('tr', {}, [el('td', {}, 'Ut vel quibusdam totam'), el('td', {}, '2'), el('td', {}, '3')])
			]));
			if(attributes.time){
				table = time_table;
			}
			if(attributes.view){
				table = view_table;
			}
			







			var _props$attributes = props.attributes,
				content = _props$attributes.content,
				alignment = _props$attributes.alignment,
				className = props.className;

			var onChangeContent = function onChangeContent(newContent) {
			props.setAttributes({
				content: newContent
			});
			};

			var onChangeAlignment = function onChangeAlignment(newAlignment) {
			props.setAttributes({
				alignment: newAlignment === undefined ? 'none' : newAlignment
			});
			};
			return [
				el('div', {
					className:  props.className,
					attributes: attributes,
				},
					el(
						'div',
						{
							// allowedBlocks: allowedBlocks 
						}
						, table
					)
				),
				el(InspectorControls, {},
					[
						CustomPanel(
							[
								el('label', {}, __('Show Time Table', 'page_restrict_domain')),
								el('br'),
								el('br'),
								el(ToggleControl, {
									label: 	 __('Show Time Table', 'page_restrict_domain'),
									checked: attributes.time,
									onChange: function (time) { 
										setAttributes({ time: time }); 
										setAttributes({ view: false }); 
									},
								}),
								el(ToggleControl, {
									label: 	 __('Show View Table', 'page_restrict_domain'),
									checked: attributes.view,
									onChange: function (view) { 
										setAttributes({ view: view }); 
										setAttributes({ time: false }); 
									},
								}),
								el('span', {
									className: 'block-description',
								}, [
									el('span', {}, __("Show a table containing all pages the current user bought products for in order to access them.", 'page_restrict_domain')),
								]),								
								el('br'),
								el('br'),
								el(ToggleControl, {
									label: 	 __('Disable default table design', 'page_restrict_domain'),
									checked: attributes.disable_table_class,
									onChange: function (disable_table_class) { 
										setAttributes({ disable_table_class: disable_table_class }); 
									},
								}),
							], { title: __("General", 'page_restrict_domain'), icon: "admin-generic", initialOpen: true }
						),
					]
				)
			];
		},
		save: function (props) {
			return (
				el('div', { className: props.className }, //Need add props.className to render saved content
					el('div', { className: 'custom-sec-inner' },
						el(InnerBlocks.Content, null)
					)
				)
			);
		}
	});
})();