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

	registerBlockType('page-restrict-wc/restrict-section', {
		title: 		 __('Restrict Section for WooCommerce', 'page_restrict_domain'),
		description: __('Restricts access to sections of pages using WooCommerce products.', 'page_restrict_domain'),
		icon: 		 icon,
		category: 	 'layout',
		keywords: 	 ['restrict Section for WooCommerce'],
		attributes:  {
			uniqueID: {
				type: 	 'string',
				default: "",
			},
			inverse: {
				type: 	 'boolean',
				default: false,
			},
			defRestrictMessage: {
				type: 	 'boolean',
				default: false,
			},
			aboveBlockAttr: {
				type: 	 'boolean',
				default: false,
			},
			belowBlockAttr: {
				type: 	 'boolean',
				default: false,
			},
			products: {
				type: 	 'array',
				default: [],
			},
			days: {
				type: 	 'int',
				default: 0
			},
			hours: {
				type: 	 'int',
				default: 0
			},
			minutes: {
				type: 	 'int',
				default: 0
			},
			seconds: {
				type: 	 'int',
				default: 0
			},
			// views: {
			// 	type: 	 'int',
			// 	default: 0
			// }
		},
		edit: function (props) {
			page_restrict_wc.attributes = attributes;
			var disabledInput 		= false;

			var attributes 		= props.attributes;
			var setAttributes 	= props.setAttributes;
			/**
			 * Changes current block attributes with the attributes from a block above or below. 
			 * This is for the active block.
			 * @returns {object}
			 */
			var changeOtherBlocksValues = function (side, attributesIn, disable, disableNABNotice) {
				var next = 0;
				if(side === 'above'){
					next = -1;
				}
				else if(side === 'below'){
					next = 1;
				}
				if (attributesIn[side+'BlockAttr']) {
					if(disable){
						disabledInput = true;
					}
					var sectionBlocks = getSectionBlocks();
					for (let i = 0; i < sectionBlocks.length; i++) {
						if (props.clientId === sectionBlocks[i].clientId) {
							if (typeof sectionBlocks[i + next] !== "undefined") {
								attributesIn.products 	= sectionBlocks[i + next].attributes.products;
								attributesIn.days 		= sectionBlocks[i + next].attributes.days;
								attributesIn.hours 		= sectionBlocks[i + next].attributes.hours;
								attributesIn.minutes 	= sectionBlocks[i + next].attributes.minutes;
								attributesIn.seconds 	= sectionBlocks[i + next].attributes.seconds;
								// attributesIn.views 		= sectionBlocks[i + next].attributes.views;
								attributesIn.redirect 	= sectionBlocks[i + next].attributes.redirect;
							}
							else {
								if(typeof disableNABNotice === 'undefined'){
									noAboveBlockNotice();
								}
								else{
									if(disableNABNotice)
										noAboveBlockNotice();
								}
								attributesIn[side+'BlockAttr'] = false;
								if(disable){
									disabledInput 			 = false;
								}
							}
						}
					}
				}
				return attributesIn;
			};
			/**
			 * Changes current block attributes with the attributes from a block above or below. 
			 * This is for going through non-active blocks to update them with current data.
			 * @returns {object}
			 */
			var changeOtherBlocksValuesNonActive = function (side, attributesIn, disable, disableNABNotice) {
				var next = 0;
				if(side === 'above'){
					next = -1;
				}
				else if(side === 'below'){
					next = 1;
				}
				if (attributesIn[side+'BlockAttr']) {
					if(disable){
						disabledInput = true;
					}
					var sectionBlocks = getSectionBlocks();
					for (let i = 0; i < sectionBlocks.length; i++) {
						if (typeof sectionBlocks[i + next] !== "undefined") {
							attributesIn.products 	= sectionBlocks[i + next].attributes.products;
							attributesIn.days 		= sectionBlocks[i + next].attributes.days;
							attributesIn.hours 		= sectionBlocks[i + next].attributes.hours;
							attributesIn.minutes 	= sectionBlocks[i + next].attributes.minutes;
							attributesIn.seconds 	= sectionBlocks[i + next].attributes.seconds;
							// attributesIn.views 		= sectionBlocks[i + next].attributes.views;
							attributesIn.redirect 	= sectionBlocks[i + next].attributes.redirect;
						}
					}
				}
				return attributesIn;
			};
			attributes = changeOtherBlocksValues('above', attributes, true, true);
			attributes = changeOtherBlocksValues('below', attributes, true, true);
			/**
			 * Function loops through all 'Restrict Section' blocks and changes their attributes. It excludes the currently open one.
			 * @returns {void}
			 */
			function changeAllBlocks(){
				var sectionBlocksGen = getSectionBlocks();
				for (var j = 0; j < sectionBlocksGen.length; j++) {
					sectionBlocksGen[j].attributes = changeOtherBlocksValuesNonActive('above', sectionBlocksGen[j].attributes, false, false);
					sectionBlocksGen[j].attributes = changeOtherBlocksValuesNonActive('below', sectionBlocksGen[j].attributes, false, false);
				}
			}
			/**
			 * Function to call if 'Lock by Products' field has changed.
			 * @param {array} content Array of ids of products that need to be updated with.
			 * @returns {void}
			 */
			function changeProducts(content) {
				attributes = page_restrict_wc.attributes;
				if (Array.isArray(content)) {
					setAttributes({ products: content });
				}
				changeAllBlocks();
			}
			/**
			 * Function to call if the text field is empty.
			 * @param {string} 			name 		Name of the field.
			 * @param {object|string} 	content 	Object or string of the input value that need to be changed.
			 * @returns {void}
			 */
			var emptyTextInput = function (name, content) {
				var attributes = {};
				attributes[name] = '';
				if(typeof(content) === "object"){
					if(!parseInt(content.currentTarget.value)){
						if(content.type == 'change'){
							content.currentTarget.value = '';
						}
						if(content.type == 'focus'){
							content.currentTarget.value = '';
						}
						if(content.type == 'blur'){
							content.currentTarget.value = 0;
						}
					}
					attributes[name] = content.currentTarget.value;
				}
				else{
					if(!content){
						content = 0;
					}
					attributes[name] = content;
				}
				setAttributes(attributes);
			}
			/**
			 * Function to call if 'Days' field has changed.
			 * @param 	{int} content Number of days that need to be updated with.
			 * @returns {void}
			 */
			function changeDays(content) {
				emptyTextInput('days', content);
				changeAllBlocks();
			}
			/**
			 * Function to call if 'Hours' field has changed.
			 * @param 	{int} content Number of hours that need to be updated with.
			 * @returns {void}
			 */
			function changeHours(content) {
				emptyTextInput('hours', content);
				changeAllBlocks();
			}
			/**
			 * Function to call if 'Minutes' field has changed.
			 * @param 	{int} content Number of minutes that need to be updated with.
			 * @returns {void}
			 */
			function changeMinutes(content) {
				emptyTextInput('minutes', content);
				changeAllBlocks();
			}
			/**
			 * Function to call if 'Seconds' field has changed.
			 * @param 	{int} content Number of seconds that need to be updated with.
			 * @returns {void}
			 */
			function changeSeconds(content) {
				emptyTextInput('seconds', content);
				changeAllBlocks();
			}
			// /**
			//  * Function to call if 'Views' field has changed.
			//  * @param 	{int} content Number of views that need to be updated with.
			//  * @returns {void}
			//  */
			// function changeViews(content) {
			// 	emptyTextInput('views', content);
			// 	changeAllBlocks();
			// }
			return [
				el('div', {
					className:  props.className,
					attributes: attributes,
				},
					el(
						InnerBlocks,
						{
							// allowedBlocks: allowedBlocks 
						}
					)
				),
				el(InspectorControls, {},
					[
						/**
						 * General settings for the block.
						 */
						CustomPanel(
							[
								el('label', {}, __('Show restricted content', 'page_restrict_domain')),
								el('br'),
								el('br'),
								el(ToggleControl, {
									label: 	 __('Inverse Block', 'page_restrict_domain'),
									checked: attributes.inverse,
									onChange: function (inverse) { 
										setAttributes({ inverse: inverse }); 
										setAttributes({ defRestrictMessage: false }); 
									},
								}),
								el('span', {
									className: 'block-description',
								}, [
									el('span', {}, __("Show content if user has no access.", 'page_restrict_domain')),
									el('br'),
									el('span', {}, __("This is to notify the user they don't have access and what to do to access it.", 'page_restrict_domain'))
								]),
								el('br'),
								el('span', {
									className: 'block-description-default',
								}, 
									__('Default: The user will not see the text in the section', 'page_restrict_domain')
								),
								el('br'),
								el('br'),
								el(ToggleControl, {
									label: 	 __('Default Restrict Message', 'page_restrict_domain'),
									checked: attributes.defRestrictMessage,
									onChange: function (defRestrictMessage) { 
										setAttributes({ defRestrictMessage: defRestrictMessage }); 
										setAttributes({ inverse: false });
									},
								}),
								el('span', {
									className: 'block-description',
								}, __("Show a Restrict Message which contains products needed to buy instead of nothing.", 'page_restrict_domain')),
								el('br'),
								el('span', {
									className: 'block-description-default',
								}, 
									__('Default: Section will be empty.', 'page_restrict_domain')
								),
								el('hr'),
								el('label', {}, __('Copy settings from another block', 'page_restrict_domain')),
								el('br'),
								el('br'),
								el(ToggleControl, {
									label: 	 __('Above block', 'page_restrict_domain'),
									checked: attributes.aboveBlockAttr,
									onChange: function (aboveBlockAttr) {
										setAttributes({ aboveBlockAttr: aboveBlockAttr });
										setAttributes({ belowBlockAttr: false });
										disabledInput = false;
										setTimeout(() => {
											slimSelectEnable();
										}, 10);
									},
								}),
								el(ToggleControl, {
									label: 	 __('Below block', 'page_restrict_domain'),
									checked: attributes.belowBlockAttr,
									onChange: function (belowBlockAttr) {
										setAttributes({ belowBlockAttr: belowBlockAttr });
										setAttributes({ aboveBlockAttr: false });
										disabledInput = false;
										setTimeout(() => {
											slimSelectEnable();
										}, 10);
									},
								})
							], { title: __("General", 'page_restrict_domain'), icon: "admin-generic", initialOpen: true }),
						/**
						 * Choose which product to lock the block with.
						 */
						CustomPanel(
							el("div", 
								{
									// className: 'slim-select',
								}, 
								checkForEmptyInputs(
									el('div', {
										ref: function () {
											slimSelectEnable();
										},
									},
										el(SelectControl, {
											value: 		attributes.products,
											label: 		__('Lock by Products', 'page_restrict_domain'),
											class: 		'slim-select',
											disabled: 	disabledInput,
											onChange: 	changeProducts,
											multiple: 	true,
											options: 	prwc_termNames,
											// ref: function () {
											// 	slimSelectEnable();
											// },
										})
									), prwc_termNames, 
									el('label', {}, __('No available products to show', 'page_restrict_domain')),
								)
							), { title: __("Products", 'page_restrict_domain'), icon: "products" }
						),
						/**
						 * Time to specify for page access to run out.
						 */
						CustomPanel(
							[
								el(TextControl, {
									value: 		attributes.days,
									label: 		__('Days', 'page_restrict_domain'),
									onChange: 	changeDays,
									onFocus: 	changeDays,
									onBlur: 	changeDays,
									type: 		'number',
									disabled: 	disabledInput,
									min: 		0,
									step: 		1
								}),
								el(TextControl, {
									value: 		attributes.hours,
									label: 		__('Hours', 'page_restrict_domain'),
									onChange: 	changeHours,
									onFocus: 	changeHours,
									onBlur: 	changeHours,
									type: 		'number',
									disabled: 	disabledInput,
									min: 		0,
									step: 		1
								}),
								el(TextControl, {
									value: 		attributes.minutes,
									label: 		__('Minutes', 'page_restrict_domain'),
									onChange: 	changeMinutes,
									onFocus: 	changeMinutes,
									onBlur: 	changeMinutes,
									type: 		'number',
									disabled: 	disabledInput,
									min: 		0,
									step: 		1
								}),
								el(TextControl, {
									value: 		attributes.seconds,
									label: 		__('Seconds', 'page_restrict_domain'),
									onChange: 	changeSeconds,
									onFocus: 	changeSeconds,
									onBlur: 	changeSeconds,
									type: 		'number',
									disabled: 	disabledInput,
									min: 		0,
									step: 		1
								}),
								// el('hr', {}),
								// el(TextControl, {
								// 	value: 		attributes.views,
								// 	label: 		__('Views', 'page_restrict_domain'),
								// 	onChange: 	changeViews,
								// 	onFocus: 	changeViews,
								// 	onBlur: 	changeViews,
								// 	type: 		'number',
								// 	disabled: 	disabledInput,
								// 	min: 		0,
								// 	step: 		1
								// })
							], { title: __("Timeout", 'page_restrict_domain'), icon: "calendar" }
						),
					]
				)
			]
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