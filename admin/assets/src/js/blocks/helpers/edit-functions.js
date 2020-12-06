const getSectionBlocks = page_restrict_wc.func.getSectionBlocks;
// var disabledInput 		= false;
// /**
//  * Changes current block attributes with the attributes from a block above or below.
//  * This is for the active block.
//  * @returns {object}
//  */
// export var changeOtherBlocksValues = function (side, attributesIn, props, disable, disableNABNotice) {
// 	var next = 0;
// 	if(side === 'above'){
// 		next = -1;
// 	}
// 	else if(side === 'below'){
// 		next = 1;
// 	}
// 	if (attributesIn[side+'BlockAttr']) {
// 		if(disable){
// 			disabledInput = true;
// 		}
// 		var sectionBlocks = getSectionBlocks();
// 		for (let i = 0; i < sectionBlocks.length; i++) {
// 			if (props.clientId === sectionBlocks[i].clientId) {
// 				if (typeof sectionBlocks[i + next] !== "undefined") {
// 					attributesIn.products 	= sectionBlocks[i + next].attributes.products;
// 					attributesIn.days 		= sectionBlocks[i + next].attributes.days;
// 					attributesIn.hours 		= sectionBlocks[i + next].attributes.hours;
// 					attributesIn.minutes 	= sectionBlocks[i + next].attributes.minutes;
// 					attributesIn.seconds 	= sectionBlocks[i + next].attributes.seconds;
// 					// attributesIn.views 		= sectionBlocks[i + next].attributes.views;
// 					attributesIn.redirect 	= sectionBlocks[i + next].attributes.redirect;
// 				}
// 				else {
// 					if(typeof disableNABNotice === 'undefined'){
// 						noAboveBlockNotice();
// 					}
// 					else{
// 						if(disableNABNotice)
// 							noAboveBlockNotice();
// 					}
// 					attributesIn[side+'BlockAttr'] = false;
// 					if(disable){
// 						disabledInput 			 = false;
// 					}
// 				}
// 			}
// 		}
// 	}
// 	return attributesIn;
// };
// /**
//  * Changes current block attributes with the attributes from a block above or below.
//  * This is for going through non-active blocks to update them with current data.
//  * @returns {object}
//  */
// export var changeOtherBlocksValuesNonActive = function (side, attributesIn, disable, disableNABNotice) {
// 	var next = 0;
// 	if(side === 'above'){
// 		next = -1;
// 	}
// 	else if(side === 'below'){
// 		next = 1;
// 	}
// 	if (attributesIn[side+'BlockAttr']) {
// 		if(disable){
// 			disabledInput = true;
// 		}
// 		var sectionBlocks = getSectionBlocks();
// 		for (let i = 0; i < sectionBlocks.length; i++) {
// 			if (typeof sectionBlocks[i + next] !== "undefined") {
// 				attributesIn.products 	= sectionBlocks[i + next].attributes.products;
// 				attributesIn.days 		= sectionBlocks[i + next].attributes.days;
// 				attributesIn.hours 		= sectionBlocks[i + next].attributes.hours;
// 				attributesIn.minutes 	= sectionBlocks[i + next].attributes.minutes;
// 				attributesIn.seconds 	= sectionBlocks[i + next].attributes.seconds;
// 				// attributesIn.views 		= sectionBlocks[i + next].attributes.views;
// 				attributesIn.redirect 	= sectionBlocks[i + next].attributes.redirect;
// 			}
// 		}
// 	}
// 	return attributesIn;
// };

class EditFunc {
	constructor(props, disabledInput) {
		this.props = props;
		this.disabledInput = disabledInput;
		this.attributes = props.attributes;
		this.setAttributes = props.setAttributes;
	}
	changeOtherBlocksValues(side, attributesIn, disable, disableNABNotice) {
		let next = 0;
		if (side === 'above') {
			next = -1;
		} else if (side === 'below') {
			next = 1;
		}
		if (attributesIn[side + 'BlockAttr']) {
			if (disable) {
				this.disabledInput = true;
			}
			const sectionBlocks = getSectionBlocks();
			for (let i = 0; i < sectionBlocks.length; i++) {
				if (this.props.clientId === sectionBlocks[i].clientId) {
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
					} else {
						if (typeof disableNABNotice === 'undefined') {
							this.noAboveBlockNotice();
						} else if (disableNABNotice) this.noAboveBlockNotice();
						attributesIn[side + 'BlockAttr'] = false;
						if (disable) {
							this.disabledInput = false;
						}
					}
				}
			}
		}
		return attributesIn;
	}
	static changeOtherBlocksValuesNonActive(
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
				this.disabledInput = true;
			}
			const sectionBlocks = getSectionBlocks();
			for (let i = 0; i < sectionBlocks.length; i++) {
				if (typeof sectionBlocks[i + next] !== 'undefined') {
					attributesIn.products =
						sectionBlocks[i + next].attributes.products;
					attributesIn.days = sectionBlocks[i + next].attributes.days;
					attributesIn.hours =
						sectionBlocks[i + next].attributes.hours;
					attributesIn.minutes =
						sectionBlocks[i + next].attributes.minutes;
					attributesIn.seconds =
						sectionBlocks[i + next].attributes.seconds;
					// attributesIn.views 		= sectionBlocks[i + next].attributes.views;
					attributesIn.redirect =
						sectionBlocks[i + next].attributes.redirect;
				}
			}
		}
		return attributesIn;
	}
	/**
	 * Function loops through all 'Restrict Section' blocks and changes their attributes. It excludes the currently open one.
	 *
	 * @return {void}
	 */
	changeAllBlocks() {
		const sectionBlocksGen = getSectionBlocks();
		for (let j = 0; j < sectionBlocksGen.length; j++) {
			sectionBlocksGen[
				j
			].attributes = this.constructor.changeOtherBlocksValuesNonActive(
				'above',
				sectionBlocksGen[j].attributes,
				false,
				false
			);
			sectionBlocksGen[
				j
			].attributes = this.constructor.changeOtherBlocksValuesNonActive(
				'below',
				sectionBlocksGen[j].attributes,
				false,
				false
			);
		}
	}

	/**
	 * Function to call if the text field is empty.
	 *
	 * @param {string} 			name 		Name of the field.
	 * @param {Object | string} 	content 	Object or string of the input value that need to be changed.
	 * @return {void}
	 */
	emptyTextInput(name, content) {
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
		return attributes;
	}
}
export default EditFunc;
