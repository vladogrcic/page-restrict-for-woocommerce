const __ = wp.i18n.__;
const components = wp.components;
const data = wp.data;
const compose = wp.compose;
const { ToggleControl } = components;
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
	return (
		<ToggleControl
			key={Math.random()}
			label={props.title}
			onChange={function (content) {
				props.setMetaValue(content);
			}}
			checked={props.metaValue}
		/>
	);
});
