import Select from 'react-select';
const __ = wp.i18n.__;
import MetaSelectGroupControl from '../sidebars/elements/MetaSelectGroupControl';
const { InnerBlocks, InspectorControls } = wp.hasOwnProperty('blockEditor')
	? wp.blockEditor
	: wp.editor; //Block inspector wrapper
const getSectionBlocks = page_restrict_wc.func.getSectionBlocks;
const noAboveBlockNotice = page_restrict_wc.func.noAboveBlockNotice;

const registerBlockType = wp.blocks.registerBlockType;
const icon = (
	<svg>
		<image href={page_restrict_wc.sidebar_img} />
	</svg>
);
// const page_options = page_restrict_wc.page_options;
const pages = page_restrict_wc.pages;

const { PanelBody, TextControl, ToggleControl, Disabled } = wp.components;
registerBlockType('page-restrict-wc/restrict-section', {
	title: __('Restrict Section for WooCommerce', 'page_restrict_domain'),
	description: __(
		'Restricts access to sections of pages using WooCommerce products.',
		'page_restrict_domain'
	),
	icon,
	category: 'layout',
	keywords: ['restrict Section for WooCommerce'],
	attributes: {
		uniqueID: {
			type: 'string',
			default: '',
		},
		inverse: {
			type: 'boolean',
			default: false,
		},
		defRestrictMessage: {
			type: 'boolean',
			default: false,
		},
		aboveBlockAttr: {
			type: 'boolean',
			default: false,
		},
		belowBlockAttr: {
			type: 'boolean',
			default: false,
		},
		products: {
			type: 'array',
			default: [],
		},
		notAllProductsRequired: {
			type: 'boolean',
			default: false,
		},
		days: {
			type: 'int',
			default: 0,
		},
		hours: {
			type: 'int',
			default: 0,
		},
		minutes: {
			type: 'int',
			default: 0,
		},
		seconds: {
			type: 'int',
			default: 0,
		},
		// views: {
		// 	type: 	 'int',
		// 	default: 0
		// }
	},
	edit(props) {
		page_restrict_wc.attributes = attributes;
		const initAttributes = page_restrict_wc.attributes
			? page_restrict_wc.attributes
			: false;
		let disabledInput = false;

		var attributes = props.attributes;

		const setAttributes = props.setAttributes;
		/**
		 * Changes current block attributes with the attributes from a block above or below.
		 * This is for the active block.
		 *
		 * @param side
		 * @param attributesIn
		 * @param disable
		 * @param disableNABNotice
		 * @return {Object}
		 */
		const changeOtherBlocksValues = function (
			side,
			attributesIn,
			disable,
			disableNABNotice
		) {
			let next = 0;
			if (side === 'above') {
				next = -1;
			} else if (side === 'below') {
				next = 1;
			}
			if (attributesIn[side + 'BlockAttr']) {
				if (disable) {
					disabledInput = true;
				}
				const sectionBlocks = getSectionBlocks();
				for (let i = 0; i < sectionBlocks.length; i++) {
					if (props.clientId === sectionBlocks[i].clientId) {
						if (typeof sectionBlocks[i + next] !== 'undefined') {
							attributesIn.products =
								sectionBlocks[i + next].attributes.products;
							attributesIn.days =
								sectionBlocks[i + next].attributes.days;
							attributesIn.hours =
								sectionBlocks[i + next].attributes.hours;
							attributesIn.minutes =
								sectionBlocks[i + next].attributes.minutes;
							attributesIn.seconds =
								sectionBlocks[i + next].attributes.seconds;
							// attributesIn.views 		= sectionBlocks[i + next].attributes.views;
							attributesIn.redirect =
								sectionBlocks[i + next].attributes.redirect;
							attributesIn.notAllProductsRequired =
								sectionBlocks[
									i + next
								].attributes.notAllProductsRequired;
						} else {
							if (typeof disableNABNotice === 'undefined') {
								noAboveBlockNotice();
							} else if (disableNABNotice) noAboveBlockNotice();
							attributesIn[side + 'BlockAttr'] = false;
							if (disable) {
								disabledInput = false;
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
		 *
		 * @param side
		 * @param attributesIn
		 * @param disable
		 * @param disableNABNotice
		 * @return {Object}
		 */
		const changeOtherBlocksValuesNonActive = function (
			side,
			attributesIn,
			disable,
			disableNABNotice
		) {
			let next = 0;
			if (side === 'above') {
				next = -1;
			} else if (side === 'below') {
				next = 1;
			}
			if (attributesIn[side + 'BlockAttr']) {
				if (disable) {
					disabledInput = true;
				}
				const sectionBlocks = getSectionBlocks();
				for (let i = 0; i < sectionBlocks.length; i++) {
					if (typeof sectionBlocks[i + next] !== 'undefined') {
						attributesIn.products =
							sectionBlocks[i + next].attributes.products;
						attributesIn.days =
							sectionBlocks[i + next].attributes.days;
						attributesIn.hours =
							sectionBlocks[i + next].attributes.hours;
						attributesIn.minutes =
							sectionBlocks[i + next].attributes.minutes;
						attributesIn.seconds =
							sectionBlocks[i + next].attributes.seconds;
						// attributesIn.views 		= sectionBlocks[i + next].attributes.views;
						attributesIn.redirect =
							sectionBlocks[i + next].attributes.redirect;
						attributesIn.notAllProductsRequired =
							sectionBlocks[
								i + next
							].attributes.notAllProductsRequired;
					}
				}
			}
			return attributesIn;
		};
		attributes = changeOtherBlocksValues('above', attributes, true, true);
		attributes = changeOtherBlocksValues('below', attributes, true, true);
		/**
		 * Function loops through all 'Restrict Section' blocks and changes their attributes. It excludes the currently open one.
		 *
		 * @return {void}
		 */
		function changeAllBlocks() {
			const sectionBlocksGen = getSectionBlocks();
			for (let j = 0; j < sectionBlocksGen.length; j++) {
				sectionBlocksGen[
					j
				].attributes = changeOtherBlocksValuesNonActive(
					'above',
					sectionBlocksGen[j].attributes,
					false,
					false
				);
				sectionBlocksGen[
					j
				].attributes = changeOtherBlocksValuesNonActive(
					'below',
					sectionBlocksGen[j].attributes,
					false,
					false
				);
			}
		}
		/**
		 * Function to call if 'Lock by Products' field has changed.
		 *
		 * @param {Array} content Array of ids of products that need to be updated with.
		 * @return {void}
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
		 *
		 * @param {string} 			name 		Name of the field.
		 * @param {Object | string} 	content 	Object or string of the input value that need to be changed.
		 * @return {void}
		 */
		const emptyTextInput = function (name, content) {
			const attributes = {};
			attributes[name] = '';
			if (typeof content === 'object') {
				if (!parseInt(content.currentTarget.value)) {
					if (content.type == 'change') {
						content.currentTarget.value = '';
					}
					if (content.type == 'focus') {
						content.currentTarget.value = '';
					}
					if (content.type == 'blur') {
						content.currentTarget.value = 0;
					}
				}
				attributes[name] = content.currentTarget.value;
			} else {
				if (!content) {
					content = 0;
				}
				attributes[name] = content;
			}
			setAttributes(attributes);
		};
		/**
		 * Function to call if 'Days' field has changed.
		 *
		 * @param 	{int} content Number of days that need to be updated with.
		 * @return {void}
		 */
		function changeDays(content) {
			emptyTextInput('days', content);
			changeAllBlocks();
		}
		/**
		 * Function to call if 'Hours' field has changed.
		 *
		 * @param 	{int} content Number of hours that need to be updated with.
		 * @return {void}
		 */
		function changeHours(content) {
			emptyTextInput('hours', content);
			changeAllBlocks();
		}
		/**
		 * Function to call if 'Minutes' field has changed.
		 *
		 * @param 	{int} content Number of minutes that need to be updated with.
		 * @return {void}
		 */
		function changeMinutes(content) {
			emptyTextInput('minutes', content);
			changeAllBlocks();
		}
		/**
		 * Function to call if 'Seconds' field has changed.
		 *
		 * @param 	{int} content Number of seconds that need to be updated with.
		 * @return {void}
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
		// return <div> Hello in Editor. </div>;
		const colourStyles = {
			control: styles => ({ ...styles, backgroundColor: 'white' }),
			option: (styles, { data, isDisabled, isFocused, isSelected }) => {
				let color = 'black';
				if(isDisabled){
					color = 'black';
				}
				else{
					if(isSelected){
						color = 'white';
					}
					else{
						if(isFocused){
							color = 'white';
						}
						else{
							color = 'black';
						}
					}
				}
				return {
					...styles,
					backgroundColor: isDisabled
						? null
						: isSelected
							? data.color
							: isFocused
								? '#168eff'
								: null,
					color: color,
					cursor: isDisabled ? 'not-allowed' : 'pointer',

					':active': {
						...styles[':active'],
						backgroundColor: !isDisabled && (isSelected ? data.color : '#168eff'),
						color: 'white',

					},
					':focus': {
						backgroundColor: data.color,
						color: 'white',
					},
					':hover': {
						backgroundColor: data.color,
						color: 'white',
					},
				};
			},
			multiValue: (styles, { data }) => {
				return {
					...styles,
					backgroundColor: '#168eff',
					color: 'white',
				};
			},
			multiValueLabel: (styles, { data }) => ({
				...styles,
				color: 'white',
			}),
			multiValueRemove: (styles, { data }) => ({
				...styles,
				color: 'white',
			}),
		};
		return (
			<div className={attributes.className} attributes={attributes}>
				<InnerBlocks></InnerBlocks>
				<InspectorControls>
					{/**
					 * General settings for the block.
					 */}
					<PanelBody
						title={__('General', 'page_restrict_domain')}
						icon="admin-generic"
						initialOpen={true}
						className={'custom-panel'}
					>
						<label>
							{__(
								'Show restricted content',
								'page_restrict_domain'
							)}
						</label>
						<br />
						<br />
						<ToggleControl
							label={__('Inverse Block', 'page_restrict_domain')}
							checked={attributes.inverse}
							onChange={function (inverse) {
								setAttributes({ inverse });
								setAttributes({ defRestrictMessage: false });
							}}
						/>
						<span className={'block-description'}>
							<span>
								{__(
									'Show content if user has no access.',
									'page_restrict_domain'
								)}
							</span>
							<br />
							<span>
								{__(
									"This is to notify the user they don't have access and what to do to access it.",
									'page_restrict_domain'
								)}
							</span>
						</span>
						<br />
						<span className={'block-description-default'}>
							{__(
								'Default: The user will not see the text in the section',
								'page_restrict_domain'
							)}
						</span>
						<br />
						<br />
						<ToggleControl
							label={__(
								'Default Restrict Message',
								'page_restrict_domain'
							)}
							checked={attributes.defRestrictMessage}
							onChange={function (defRestrictMessage) {
								setAttributes({
									defRestrictMessage,
								});
								setAttributes({ inverse: false });
							}}
						/>
						<span className="block-description">
							{__(
								'Show a Restrict Message which contains products needed to buy instead of nothing.',
								'page_restrict_domain'
							)}
						</span>

						<br />
						<span className="block-description-default">
							{__(
								'Default: Section will be empty.',
								'page_restrict_domain'
							)}
						</span>
						<hr />
						<label>
							{__(
								'Copy settings from another block',
								'page_restrict_domain'
							)}
						</label>
						<br />
						<br />
						<ToggleControl
							label={__('Above block', 'page_restrict_domain')}
							checked={attributes.aboveBlockAttr}
							onChange={function (aboveBlockAttr) {
								setAttributes({
									aboveBlockAttr,
								});
								setAttributes({ belowBlockAttr: false });
								disabledInput = false;
							}}
						/>
						<ToggleControl
							label={__('Below block', 'page_restrict_domain')}
							checked={attributes.belowBlockAttr}
							onChange={function (belowBlockAttr) {
								setAttributes({
									belowBlockAttr,
								});
								setAttributes({ aboveBlockAttr: false });
								disabledInput = false;
							}}
						/>
					</PanelBody>
					{/**
					 * Choose which product to lock the block with.
					 */}
					<PanelBody
						title={__('Products', 'page_restrict_domain')}
						icon="products"
					>
						<div>
							{prwc_termNames.length ? (
								<Select
									styles={colourStyles}
									value={attributes.products}
									label={__(
										'Lock by Products',
										'page_restrict_domain'
									)}
									isDisabled={disabledInput}
									onChange={changeProducts}
									options={prwc_termNames}
									isMulti
									className="basic-multi-select"
									classNamePrefix="select"
									filterOption={(candidate, input) => {
										if (input) {
											return candidate.label.includes(
												input
											);
										}
										return true;
									}}
								/>
							) : (
								<>
								<label style={{color: "red"}}>
									{__(
										'No available products to show',
										'page_restrict_domain'
									)}
								</label>
								<br/>
								<br/>
								</>
							)}
							<br/>
							{disabledInput ? (
								<Disabled>
									<ToggleControl
										label={__(
											'Not all products required',
											'page_restrict_domain'
										)}
										disable={disabledInput}
										checked={
											attributes.notAllProductsRequired
										}
										onChange={function (
											notAllProductsRequired
										) {
											setAttributes({
												notAllProductsRequired,
											});
											changeAllBlocks();
										}}
									/>
								</Disabled>
							) : (
								<ToggleControl
									label={__(
										'Not all products required',
										'page_restrict_domain'
									)}
									disable={disabledInput}
									checked={attributes.notAllProductsRequired}
									onChange={function (
										notAllProductsRequired
									) {
										setAttributes({
											notAllProductsRequired,
										});
										changeAllBlocks();
									}}
								/>
							)}
						</div>
					</PanelBody>
					{/**
					 * Time to specify for page access to run out.
					 */}
					<PanelBody
						title={__('Timeout', 'page_restrict_domain')}
						icon="calendar"
					>
						<TextControl
							value={attributes.days}
							label={__('Days', 'page_restrict_domain')}
							onChange={changeDays}
							onFocus={changeDays}
							onBlur={changeDays}
							type="number"
							disabled={disabledInput}
							min={0}
							step={1}
						/>
						<TextControl
							value={attributes.hours}
							label={__('Hours', 'page_restrict_domain')}
							onChange={changeHours}
							onFocus={changeHours}
							onBlur={changeHours}
							type="number"
							disabled={disabledInput}
							min={0}
							step={1}
						/>
						<TextControl
							value={attributes.minutes}
							label={__('Minutes', 'page_restrict_domain')}
							onChange={changeMinutes}
							onFocus={changeMinutes}
							onBlur={changeMinutes}
							type="number"
							disabled={disabledInput}
							min={0}
							step={1}
						/>
						<TextControl
							value={attributes.seconds}
							label={__('Seconds', 'page_restrict_domain')}
							onChange={changeSeconds}
							onFocus={changeSeconds}
							onBlur={changeSeconds}
							type="number"
							disabled={disabledInput}
							min={0}
							step={1}
						/>
						{/*<hr/>*/}
						{/*<TextControl
						// 	value= 		{attributes.views}
						// 	label= 		{__('Views', 'page_restrict_domain')}
						// 	onChange= 	{changeViews}
						// 	onFocus= 	{changeViews}
						// 	onBlur= 	{changeViews}
						// 	type= 		'number'
						// 	disabled= 	{disabledInput}
						// 	min= 		0
						// 	step= 		1
						/>*/}
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
