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
	var icon = el('img', 
	{
		src: page_restrict_wc.sidebar_img
	});

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
					target: prwc_blockName.split("/")[0],
					icon: icon,
				},
				prwc_plugin_title
			),
			el(PluginSidebar,
				{
					name: prwc_blockName.split("/")[0],
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
	registerPlugin(prwc_blockName.split("/")[0], {
		render: renderBoxGenRender
	});
})();
