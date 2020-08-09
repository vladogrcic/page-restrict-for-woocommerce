(function () {
	var CustomPanel 		= page_restrict_wc.func.CustomPanel;
	var slimSelectEnable 	= page_restrict_wc.func.slimSelectEnable;
	var pages = page_restrict_wc.pages;

	var plugins 	= wp.plugins; 
	var editPost 	= wp.editPost; 
	var element 	= wp.element; 
	var components 	= wp.components; 
	var data 		= wp.data; 
	var compose 	= wp.compose;

	var __ = wp.i18n.__;
	var el = element.createElement;

	var Fragment 					= element.Fragment;
	var registerPlugin 				= plugins.registerPlugin;
	var PluginSidebar 				= editPost.PluginSidebar;
	var PluginSidebarMoreMenuItem 	= editPost.PluginSidebarMoreMenuItem;
	var PanelBody 					= components.PanelBody;

	var TextControl 		= components.TextControl;
	var SelectControl 		= components.SelectControl;
	var ToggleControl 		= components.ToggleControl;

	var withSelect 			= data.withSelect;
	var withDispatch 		= data.withDispatch;
	
	var sidebar_title = prwc_plugin_title;

	var icon = el("svg", { xmlns: "http://www.w3.org/2000/svg", width: "24", height: "24", enableBackground: "new", viewBox: "0 0 260.2 260.2" }, el("defs", null, el("filter", { id: "a", colorInterpolationFilters: "sRGB" }, el("feBlend", { in2: "BackgroundImage", mode: "saturation" }))), el("path", { fill: "none", stroke: "#1c1c1c", strokeWidth: "3.388", d: "M101.3 89.351V57.592", transform: "translate(0 -22.767)" }), el("path", { fill: "none", stroke: "#1c1c1c", strokeWidth: "3.388", d: "M201.23 74.704V58.277m0 34.634V74.704l22.989-6.16v-9.857", transform: "translate(.567 -23.022)" }), el("path", { fill: "none", stroke: "#1c1c1c", strokeWidth: "3.388", d: "M219.85 115.63h25.873m-52.02 0h26.147l6.266-18.172h10.024", transform: "translate(0 -19.515)" }), el("path", { fill: "none", stroke: "#1c1c1c", strokeWidth: "3.388", d: "M192.2 160.95h20.808l14.785-14.785h18.618M179.33 188.19h29.843M222.86 204.07h18.207m-36.825 0h18.618l7.844-13.587h20.63m-82.41 13.587h35.32l7.688 13.318h10.93", transform: "translate(0 -24.664)" }), el("path", { fill: "none", stroke: "#1c1c1c", strokeWidth: "3.388", d: "M162.9 222.41v30.125m0-48.195v18.07l18.042 17.19v17.148M132.24 216.39v18.07l-5.418 9.384v8.96M109.36 227.61v23.231m0-36.305v13.074l-25.987 6.963v24.371", transform: "translate(0 -26.833)" }), el("path", { fill: "none", stroke: "#1c1c1c", strokeWidth: "3.388", d: "M50.925 210.64H17.249m85.696 0h-52.02l-12.491-21.635h-22.28M33.539 148.35H12.594m39.426 0H33.539l-8.25 14.289H11.91m62.013-14.289H52.02l-6.916-11.979h-9.648M71.048 100.99h-15.88l-18.481 18.481H16.7", transform: "translate(0 -24.664)" }), el("path", { fill: "none", stroke: "#1c1c1c", strokeWidth: "3.388", d: "M59.166 74.965v-16m0 26.128V74.966l17.294-6.981v-7.127m-17.294 39.45V85.093l-22.48-7.921V64.989", transform: "translate(3.795 -26.291)" }), el("path", { fill: "none", stroke: "#1c1c1c", strokeWidth: "3.388", d: "M171.94 90.994V66.901", transform: "translate(0 -24.664)" }), el("g", { fill: "#4d4d4d", stroke: "#1c1c1c" }, el("path", { strokeWidth: "3.388", d: "M82.684 173.95H46.27", transform: "translate(0 -24.664)" }), el("g", { strokeWidth: "2.561", paintOrder: "fill markers stroke", transform: "translate(0 -24.664)" }, el("circle", { cx: "101.4", cy: "52.954", r: "9.959", strokeWidth: "5.122" }), el("circle", { cx: "224.57", cy: "51.338", r: "9.959", strokeWidth: "5.122" }), el("circle", { cx: "200.96", cy: "57.592", r: "4.979", transform: "translate(.567 1.643)" }), el("circle", { cx: "243.94", cy: "100.25", r: "9.959", strokeWidth: "5.122" }), el("circle", { cx: "247.23", cy: "115.36", r: "4.979", transform: "translate(0 5.15)" }), el("circle", { cx: "247.5", cy: "145.2", r: "9.959", strokeWidth: "5.122" }), el("circle", { cx: "210.82", cy: "187.37", r: "9.959", strokeWidth: "5.122" }), el("circle", { cx: "250.79", cy: "190.11", r: "4.979" }), el("circle", { cx: "242.03", cy: "203.79", r: "4.979" }), el("circle", { cx: "228.89", cy: "218.8", r: "9.959", strokeWidth: "5.122" }), el("circle", { cx: "181.02", cy: "254.52", r: "4.979" }), el("ellipse", { cx: "163.18", cy: "250.37" }), el("circle", { cx: "126.95", cy: "258.12", r: "9.959", strokeWidth: "5.122" }), el("circle", { cx: "109.52", cy: "250.04", r: "4.979" }), el("circle", { cx: "83.232", cy: "255.18", r: "9.959", strokeWidth: "5.122" }), el("circle", { cx: "15.332", cy: "210.91", r: "9.959", strokeWidth: "5.122" }), el("circle", { cx: "13.963", cy: "189.01", r: "4.979" }), el("circle", { cx: "10.404", cy: "161.91", r: "4.979" }), el("circle", { cx: "12.594", cy: "147.67", r: "4.979" }), el("circle", { cx: "34.497", cy: "136.17", r: "4.979" }), el("circle", { cx: "16.154", cy: "118.65", r: "9.959", strokeWidth: "5.122" }), el("circle", { cx: "40.68", cy: "58.116", r: "9.959", strokeWidth: "5.122" }), el("circle", { cx: "63.231", cy: "59.771", r: "4.979" }), el("circle", { cx: "80.168", cy: "55.946", r: "4.979" }), el("circle", { cx: "171.86", cy: "58.251", r: "9.959", strokeWidth: "5.122" }), el("circle", { cx: "42.711", cy: "173.4", r: "9.959", strokeWidth: "5.122" }), el("circle", { cx: "161.91", cy: "255.08", r: "9.959", strokeWidth: "5.122" }))), el("g", { fill: "#3a3a3a", stroke: "#1c1c1c" }, el("g", { transform: "translate(13.782 5.143) scale(3.6295)" }, el("path", { d: "M22 33H42V45H22z" }), el("path", { d: "M36 34.5c0-.511-.049-1.009-.119-1.5H22v11.39a10.46 10.46 0 003.5.61C31.299 45 36 40.299 36 34.5z" }), el("circle", { cx: "32", cy: "39", r: "2" }), el("path", { d: "M36 33v-6a4 4 0 00-8 0v6h-4v-6a8 8 0 0116 0v6z" }), el("path", { fill: "#ececec", strokeWidth: "43.784", d: "M242.5 467.84C134.75 433.638 60.73 333.66 60.73 219.34V109.56c75.698-16.503 131.31-46.998 181.77-81.797 51.542 35.756 106.07 65.653 181.77 81.917v109.78c0 114.21-74.024 214.18-181.77 248.38z", transform: "translate(9.32 7.949) scale(.09636)" })), el("path", { fill: "#1a1a1a", stroke: "#4d4d4d", strokeWidth: "3.154", d: "M131.63 78.91c-4.873 0-8.936 3.951-8.822 8.823.06 2.547 2.428 5.276 4.724 6.214l-.544 1.83-4.97 16.273h19.436l-4.951-16.202-.588-1.869c1.959-.635 4.487-3.275 4.537-6.247.083-4.872-3.95-8.822-8.822-8.822z", transform: "translate(-76.633 -63.742) scale(1.5879)" })), el("g", null, el("g", { fill: "#fff" }, el("g", { transform: "scale(.95016) rotate(8 43.226 162.646)" }, el("path", { d: "M133.39 113.97H165.051V138.194H133.39z", paintOrder: "fill markers stroke" }), el("path", { d: "M147.48 113.72H150.66799999999998V140.228H147.48z", paintOrder: "fill markers stroke" }), el("path", { stroke: "#eee", strokeWidth: "1.626", d: "M165.05 113.97l-15.829-2.613M133.39 113.97l15.223-1.988" })), el("g", { transform: "matrix(-.81491 0 0 .81491 238.45 30.729)" }, el("path", { d: "M133.39 113.97H165.051V138.194H133.39z", paintOrder: "fill markers stroke" }), el("path", { d: "M147.48 113.72H150.66799999999998V140.228H147.48z", paintOrder: "fill markers stroke" }), el("path", { stroke: "#fff", strokeWidth: "1.896", d: "M165.05 113.97l-16.025-2.56M133.39 113.97l14.64-2.283" }))), el("path", { fill: "#757575", d: "M126.88 264.36h345.97l-29.178 119.82-275.98 9.56z", transform: "translate(74.685 79.304) scale(.19477)" }), el("path", { fill: "#303030", d: "M169.77 399.67l276.5-7.676a7.5 7.5 0 007.149-6.382l30.002-122.07a7.504 7.504 0 00-1.734-6.006 7.539 7.539 0 00-5.683-2.606h-348.51l-17.864-61.1c-.015-.062-.037-.12-.053-.182a7.746 7.746 0 00-.134-.457c-.031-.095-.067-.187-.103-.28a7.38 7.38 0 00-.161-.398c-.048-.106-.099-.21-.15-.313-.056-.11-.111-.22-.173-.326a6.654 6.654 0 00-.203-.336c-.058-.09-.116-.18-.177-.267a7.688 7.688 0 00-.251-.335c-.063-.08-.125-.157-.189-.233a9.259 9.259 0 00-.499-.53 7.498 7.498 0 00-.847-.701 6.999 6.999 0 00-1.234-.716 6.955 6.955 0 00-.686-.275c-.113-.038-.227-.077-.342-.11a7.426 7.426 0 00-.39-.1c-.103-.024-.204-.048-.308-.067a7.554 7.554 0 00-.455-.07c-.089-.01-.178-.022-.268-.03a6.944 6.944 0 00-.5-.025c-.059-.001-.116-.01-.175-.01H59.661a7.5 7.5 0 00-7.5 7.5c0 4.144 3.36 7.657 7.5 7.5H96.41l55.963 189.8c-.175 16.979-1.344 10.66-1.344 24.676 0 20.678 4.298 33.325 24.976 33.325l.02-.001h257.46c4.142 0 7.5-3.358 7.5-7.5s-3.358-7.5-7.5-7.5h-257.47 9.727c-12.4-.006-17.947-3.814-18.65-16.04-.262-14.561 2.691-20.16 2.691-20.16zm210.74-65.923l-6.492 45.819-60.515 2.162v-47.98h67.007zm-67.007-15v-48.82h74.422l-6.303 48.82zm-15 63.516l-60.709 2.168-8.902-50.684h69.611zm141.01-5.037l-50.411 1.801 6.452-45.28h56.744zm15.035-58.479h-57.882l6.303-48.82h64.33zm-156.04-48.82v48.82h-71.056l-8.187-48.82zm-94.312 0l8.187 48.82h-65.248l-16.065-48.82zm-53.489 63.82h63.121l8.954 51.221-53.679 1.818z", transform: "translate(74.685 79.304) scale(.19477)" }), el("g", { display: "none" }, el("path", { fill: "#e6e9ed", d: "M121.32 233.74h350.15l-27.786 150.44-275.98 9.56z", transform: "translate(0 -36.805) translate(74.685 106.62) scale(.19477)" }), el("path", { fill: "#ccd1d9", d: "M176 402c.884 0 1.729-.161 2.517-.442l267.75-9.564a7.5 7.5 0 007.149-6.382l30.002-152.69a7.504 7.504 0 00-1.734-6.007 7.539 7.539 0 00-5.683-2.606h-354.08l-17.864-61.099c-.015-.063-.037-.121-.053-.183a7.746 7.746 0 00-.134-.457c-.031-.095-.067-.187-.103-.279a7.38 7.38 0 00-.161-.399c-.048-.106-.099-.21-.15-.313-.056-.11-.111-.219-.173-.326a6.654 6.654 0 00-.203-.336c-.058-.09-.116-.18-.177-.267a7.688 7.688 0 00-.251-.335c-.063-.079-.125-.157-.189-.233a9.259 9.259 0 00-.499-.529 7.498 7.498 0 00-.847-.702 6.999 6.999 0 00-1.234-.716 6.955 6.955 0 00-.686-.275c-.113-.038-.227-.077-.342-.11a7.426 7.426 0 00-.39-.1c-.103-.024-.204-.048-.308-.067a7.554 7.554 0 00-.455-.069c-.089-.011-.178-.023-.268-.031a6.944 6.944 0 00-.5-.025c-.059-.001-.116-.009-.175-.009H54.088a7.5 7.5 0 00-7.5 7.5c0 4.143 3.357 7.5 7.5 7.5h36.749l66.814 219.36c-11.42 6.435-19.153 18.671-19.153 32.687 0 20.678 16.822 37.5 37.5 37.5l.019-.001h269.98c4.143 0 7.5-3.358 7.5-7.5s-3.357-7.5-7.5-7.5h-270l-.013.001c-12.401-.007-22.487-10.098-22.487-22.5 0-12.409 10.093-22.502 22.499-22.502zm204.51-84.952l-6.492 62.518-60.515 2.162v-64.679h67.007zm-67.007-15v-62.735h74.422l-6.303 62.735zm-15 80.215l-60.709 2.168-8.902-67.383h69.611zm141.01-5.037l-50.411 1.801 6.452-61.979h56.744zm15.035-75.178h-57.882l6.303-62.735h64.33zm-156.04-62.735v62.735h-71.056l-8.187-62.735zm-94.312 0l8.187 62.735h-66.64l-20.24-62.735zm-54.881 77.735h64.513l8.954 67.92-50.896 1.818z", transform: "translate(0 -36.805) translate(74.685 106.62) scale(.19477)" })), el("g", { fill: "#fff", stroke: "#dfdfdf", strokeWidth: "4.125", paintOrder: "fill markers stroke" }, el("circle", { cx: "113.95", cy: "170.05", r: "5.057", stroke: "#000" }), el("circle", { cx: "150.66", cy: "170.24", r: "5.057", stroke: "#070707" }))), el("g", { display: "none", filter: "url(#a)" }, el("path", { fillOpacity: "0.973", d: "M-0.233 -0.935H261.007V260.915H-0.233z", paintOrder: "fill markers stroke" })));
	
	var MetaTextControl = function (type) {
		if (typeof type === "undefined") {
			type = 'string';
		}
		var emptyNumberInput = function(content, props, type, input){
			if(typeof(content) === "object"){
				if (!parseInt(content.currentTarget.value) && type === "number") 
				{
					props.setMetaValue(input);
				}
				else{
					props.setMetaValue(content.currentTarget.value);
				
				}
			}
			else{
				if (!content && type === "number") 
				{
					props.setMetaValue(input);
				}
				else{
					props.setMetaValue(content);
				
				}
			}
		};
		return compose.compose(
			withDispatch(function (dispatch, props) {
				return {
					setMetaValue: function (metaValue) {
						dispatch('core/editor').editPost(
							{ meta: { [props.metaKey]: metaValue } }
						);
					}
				}
			}),
			withSelect(function (select, props) {
				return {
					metaValue: select('core/editor').getEditedPostAttribute('meta')[props.metaKey],
				}
			}))(function (props) {
				return el(TextControl, 
					{
						label: 	props.title,
						value: 	props.metaValue,
						type: 	type,
						min: 		0,
						step: 		1,
						onChange: function (content) {
							/**
							 * Adds empty space to number text inputs if its empty.
							 */
							emptyNumberInput(content, props, type, '');
						},
						onFocus: function (content) {
							/**
							 * Adds a empty space to number text inputs if its empty.
							 */
							emptyNumberInput(content, props, type, '');
						},
						onBlur: function (content) {
							/**
							 * Adds a 0 to number text inputs if its empty.
							 */
							emptyNumberInput(content, props, type, '0');
						},
						ref: function (content) {
						},
					}
				);
			}
		);
	};
	var MetaToggleControl = function(){ 
		return compose.compose(
			withDispatch(function (dispatch, props) {
				return {
					setMetaValue: function (metaValue) {
						dispatch('core/editor').editPost(
							{ meta: { [props.metaKey]: metaValue } }
						);
					}
				}
			}),
			withSelect(function (select, props) {
				return {
					metaValue: select('core/editor').getEditedPostAttribute('meta')[props.metaKey],
				}
			}))(function (props) {
				return el(ToggleControl, {
					label: props.title,
					onChange: function (content) {
						props.setMetaValue(content);
					},
					checked: props.metaValue,
				});
			}
		);
	};
	var MetaSelectGroupControl = function (labels, missingText) {
		return compose.compose(
			withDispatch(function (dispatch, props) {
				return {
					setMetaValue: function (metaValue) {
						dispatch('core/editor').editPost(
							{ 
								meta: { 
									[props.metaKey]: metaValue 
								} 
							}
						);
					}
				}
			}),
			withSelect(function (select, props) {
				var metaValue = select('core/editor').getEditedPostAttribute('meta')[props.metaKey];
				return {
					metaValue: metaValue,
				}
			}))(function (props) {
				if (typeof props.metaValue !== "undefined") {
					if (props.metaValue.constructor === String) {
						props.metaValue = props.metaValue.split(",");
					}
				}
				var optgroup = [];
				var options = [];
				var optgroup = [el('option', {
					value: ''
				}, '')];
				for (var key in labels) {
					var obj = labels[key];
					options = [];
					for (var i = 0; i < obj.length; i++) {
						options.push(el('option', {
							value: obj[i].value
						}, obj[i].label));
					}
					optgroup.push(el('optgroup', {
						label: key
					}, options));
				}
				var out = el('label', {}, '');
				if(props.metaValue.length){
					out = [el('div', {
						className: 'sidebar-section'
					}, el('label', {
					}, props.title), el('select', {
						name: props.metaKey,
						value: props.metaValue,
						class: 'slim-select',
						onChange: function (content) {
								props.setMetaValue(content.target.value);
						},
						ref: function () {
							slimSelectEnable();
						},
					}, optgroup))];
				}
				else{
					return el('label', {}, missingText);
				}
				return out;
			}
		)
	};
	var MetaSelectMultipleControl = function (labels, missingText) {
		return compose.compose(
			withDispatch(function (dispatch, props) {
				return {
					setMetaValue: function (metaValue) {
						if (typeof metaValue !== "undefined") {
							if (metaValue.constructor === Array) {
								var filtered_filtered = metaValue.filter(function(item) {
									return item;
								});
								metaValue = filtered_filtered.join();
							}
						}
						dispatch('core/editor').editPost(
							{ meta: { [props.metaKey]: metaValue } }
						);
					}
				}
			}),
			withSelect(function (select, props) {
				var metaValue = select('core/editor').getEditedPostAttribute('meta')[props.metaKey];
				if (typeof metaValue !== "undefined") {
					if (metaValue.constructor === Array) {
						var filtered_filtered = metaValue.filter(function(item) {
							return item;
						});
						metaValue = filtered_filtered.join();
					}
				}
				return {
					metaValue: metaValue,
				}
			}))(function (props) {
				if (typeof props.metaValue !== "undefined") {
					if (props.metaValue.constructor === String) {
						props.metaValue = props.metaValue.split(",");
					}
				}
				
				var options = [];
				for (var i = 0; i < labels.length; i++) {
					options.push(el('option', {
						value: labels[i].value
					}, labels[i].label));
				}
				var out = el('label', {}, '');
				if(props.metaValue.length){
					out = [el('div', {
						className: 'sidebar-section'
					}, el('label', {
					}, props.title), el('select', {
						name: props.metaKey,
						value: props.metaValue,
						class: 'slim-select',
						onChange: function (content) {
							var metavalue = props.metaValue;
							var values = [];
							for (var i = 0; i < content.target.selectedOptions.length; i++) {
								var element = content.target.selectedOptions[i];
								values.push(element.value);
							}
							metavalue.push(content.target.value);
							var filtered_filtered = values.filter(function(item) {
								return item;
							});
							props.setMetaValue(filtered_filtered);
						},
						ref: function () {
							slimSelectEnable();
						},
						multiple: true,
					}, options))];
				}
				else{
					return el('label', {}, missingText);
				}
				return out;
			}
		)
	};
	var renderBoxGenElements = function () { 
		return el(PanelBody, {},
			CustomPanel(
				[
					el("div", {
						className: 'slim-select',
					},
						[
							el(MetaSelectMultipleControl(prwc_termNames, __('No available products to show', 'page_restrict_domain')),
								{
									metaKey: 'prwc_products',
									title: __('Lock by Products', 'page_restrict_domain'),
								}
							),
							el('br', {}),
							el(MetaToggleControl(),
							{
								metaKey: 'prwc_not_all_products_required',
								title: __('Not all products required', 'page_restrict_domain'),
							}
						),
						]
					),								
				], { title: __("Products", 'page_restrict_domain'), icon: "products" }),
			CustomPanel(
				[
					el(MetaSelectGroupControl(pages, __('No available pages to show', 'page_restrict_domain')),
						{
							metaKey: 'prwc_not_bought_page',
							title: __('Page to show if product not bought', 'page_restrict_domain'),
						}
					),
					el(MetaToggleControl(),
						{
							metaKey: 'prwc_redirect_not_bought',
							title: __('Redirect if product was not bought', 'page_restrict_domain'),
						}
					),
					el('span', {
						className: 'block-description-default',
					}, __('Default: Render the not bought page content into the current page', 'page_restrict_domain')),
					el('hr', {}),
					el(MetaSelectGroupControl(pages, __('No available pages to show', 'page_restrict_domain')),
						{
							metaKey: 'prwc_not_logged_in_page',
							title: __('Page to show if user is not logged in', 'page_restrict_domain'),
						}
					),
					el(MetaToggleControl(),
						{
							metaKey: 'prwc_redirect_not_logged_in',
							title: __('Redirect if user is not logged in', 'page_restrict_domain'),
						}
					),
					el('span', {
						className: 'block-description-default',
					}, __('Default: Render the user is not logged in page content into the current page', 'page_restrict_domain')),
				], { title: __("Page to Show", 'page_restrict_domain'), icon: "welcome-widgets-menus" }),
			CustomPanel(
				[
					el(MetaTextControl('number'),
						{
							metaKey: 'prwc_timeout_days',
							title: __('Days', 'page_restrict_domain'),
						}
					),
					el(MetaTextControl('number'),
						{
							metaKey: 'prwc_timeout_hours',
							title: __('Hours', 'page_restrict_domain'),
						}
					),
					el(MetaTextControl('number'),
						{
							metaKey: 'prwc_timeout_minutes',
							title: __('Minutes', 'page_restrict_domain'),
						}
					),
					el(MetaTextControl('number'),
						{
							metaKey: 'prwc_timeout_seconds',
							title: __('Seconds', 'page_restrict_domain'),
						}
					),
					el('hr', {}),
					el(MetaTextControl('number'),
						{
							metaKey: 'prwc_timeout_views',
							title: __('Views', 'page_restrict_domain'),
						}
					)
				], { title: __("Timeout", 'page_restrict_domain'), icon: "calendar" }
			),
		);
	};
	var renderBoxGen = function (panelElements) {
		return el(Fragment, {},
			el(PluginSidebarMoreMenuItem,
				{
					target: prwc_plugin_name,
					icon: icon,
				},
				prwc_plugin_title
			),
			el(PluginSidebar,
				{
					name: prwc_plugin_name,
					icon: icon,
					title: sidebar_title,
				},
				panelElements
			)
		);
	};
	var renderBoxGenRender = function () { 
		return renderBoxGen(renderBoxGenElements());
	};
	registerPlugin('page-restrict-wc', {
		render: renderBoxGenRender
	});
})();
