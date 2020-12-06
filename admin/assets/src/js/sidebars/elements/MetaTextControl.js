const __ = wp.i18n.__;
const components = wp.components;
const data = wp.data;
const compose = wp.compose;
const { TextControl } = components;
const { withSelect, withDispatch } = data;
export default compose.compose(
	withDispatch(function (dispatch, props) {
		return {
			setMetaValue(metaValue) {
				dispatch('core/editor').editPost({
					meta: { [props.metaKey]: metaValue },
				});
			},
		};
	}),
	withSelect(function (select, props) {
		return {
			metaValue: select('core/editor').getEditedPostAttribute('meta')[
				props.metaKey
			],
		};
	})
)(function (props) {
	if (typeof props.type === 'undefined') {
		props.type = 'string';
	}
	const emptyNumberInput = function (content, props, type, input) {
		if (typeof content === 'object') {
			if (!parseInt(content.currentTarget.value) && type === 'number') {
				props.setMetaValue(input);
			} else {
				props.setMetaValue(content.currentTarget.value);
			}
		} else if (!content && type === 'number') {
			props.setMetaValue(input);
		} else {
			props.setMetaValue(content);
		}
	};
	return (
		<TextControl
			key={Math.random()}
			label={props.title}
			value={props.metaValue}
			type={props.type}
			min={0}
			step={1}
			onChange={function (content) {
				/**
				 * Adds empty space to number text inputs if its empty.
				 */
				emptyNumberInput(content, props, props.type, '');
			}}
			onFocus={function (content) {
				/**
				 * Adds a empty space to number text inputs if its empty.
				 */
				emptyNumberInput(content, props, props.type, '');
			}}
			onBlur={function (content) {
				/**
				 * Adds a 0 to number text inputs if its empty.
				 */
				emptyNumberInput(content, props, props.type, '0');
			}}
		/>
	);
});
