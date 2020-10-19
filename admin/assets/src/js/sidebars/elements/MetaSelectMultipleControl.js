import Select from 'react-select';
const __ = wp.i18n.__;
const data 		    = wp.data; 
const compose 	    = wp.compose;
const {withSelect, withDispatch} = data;
if( typeof prwc_ReactSelectElementSave === 'undefined' ){
    window.prwc_ReactSelectElementSave = {};
}
export default compose.compose(
    withDispatch(function (dispatch, props) {
        return {
            setMetaValue: function (metaValue) {
                dispatch('core/editor').editPost(
                    { 
                        meta: 
                        { 
                            [props.metaKey]: metaValue 
                        } 
                    }
                );
            },
            setMetaValueElement: function (metaValue) {
                prwc_ReactSelectElementSave[props.metaKey] = metaValue;
            }
        }
    }),
    withSelect(function (select, props) {
        let metaValue = select('core/editor').getEditedPostAttribute('meta')[props.metaKey];
        let metaValueElement = prwc_ReactSelectElementSave[props.metaKey];
        if( !metaValueElement || !Object.keys(metaValueElement) ){
            metaValueElement = props.metaValueElement;
        }
        return {
            metaValue: metaValue,
            metaValueElement: metaValueElement,
        }
    }))(function (props) {
        const labels        = props.options;
        const missingText   = props.missingText;
        prwc_ReactSelectElementSave[props.metaKey] = props.metaValueElement;
        if(labels.length){
            return <div
                key= {Math.random()}
                className= {'sidebar-section'}
            >
                <label htmlFor="">
                {props.title}
                </label>
                <Select
                    value={prwc_ReactSelectElementSave[props.metaKey]}
                    isMulti
                    name="colors"
                    options={labels}
                    className="basic-multi-select"
                    classNamePrefix="select"
                    onChange= {function (content) {
                        props.setMetaValue( JSON.stringify(content) );
                        props.setMetaValueElement( content );
                    }}
                    filterOption={
                        (candidate, input) => {
                            if (input) {
                                return candidate.label.includes(input);
                            }
                            return true;
                        }
                    }
                />
            </div>
        }
        else{
            return <label> {missingText} </label>;
        }
    }
);