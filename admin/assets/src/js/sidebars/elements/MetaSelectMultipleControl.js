import Select from 'react-select';
const __ = wp.i18n.__;
const data = wp.data;
const compose = wp.compose;
const { withSelect, withDispatch } = data;
if (typeof prwc_ReactSelectElementSave === 'undefined') {
	window.prwc_ReactSelectElementSave = {};
}
export default compose.compose(
	withDispatch(function (dispatch, props) {
		return {
			setMetaValue(metaValue) {
				dispatch('core/editor').editPost({
					meta: {
						[props.metaKey]: metaValue,
					},
				});
			},
			setMetaValueElement(metaValue) {
				prwc_ReactSelectElementSave[props.metaKey] = metaValue;
			},
		};
	}),
	withSelect(function (select, props) {
		const metaValue = select('core/editor').getEditedPostAttribute('meta')[
			props.metaKey
		];
		let metaValueElement = prwc_ReactSelectElementSave[props.metaKey];
		if (!metaValueElement || !Object.keys(metaValueElement)) {
			metaValueElement = props.metaValueElement;
		}
		return {
			metaValue,
			metaValueElement,
		};
	})
)(function (props) {
	const labels = props.options;
	const missingText = props.missingText;
	prwc_ReactSelectElementSave[props.metaKey] = props.metaValueElement;
	if (labels.length) {
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
			<div key={Math.random()} className={'sidebar-section'}>
				<label htmlFor="">{props.title}</label>
				<Select
					styles={colourStyles}
					value={prwc_ReactSelectElementSave[props.metaKey]}
					isMulti
					name="colors"
					options={labels}
					className="basic-multi-select"
					classNamePrefix="select"
					onChange={function (content) {
						props.setMetaValue(JSON.stringify(content));
						props.setMetaValueElement(content);
					}}
					filterOption={(candidate, input) => {
						if (input) {
							return candidate.label.includes(input);
						}
						return true;
					}}
				/>
			</div>
		);
	}

	return <label style={{color: "red"}}> {missingText} </label>;
});
