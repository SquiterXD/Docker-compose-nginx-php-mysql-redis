import _get from 'lodash/get';
import _set from 'lodash/set';

export function customSelectDropDownLabelDecorator(v, normalLabelBuilder, onDropDownBuilder, listName, modelName = null, labelName = 'label') {

    let ori = [...this[listName]];
    this[listName] = [];
    this[listName] = [
        ...ori.map(it => {
            return {
                ...it,
                [labelName]: v ? onDropDownBuilder(it) : normalLabelBuilder(it)
            };
        })
    ];

    //if has model, force refresh value for re-render
    if (modelName === null) return;
    let s = _get(this, modelName);
    _set(this, modelName, null);
    Vue.nextTick(() => {
        _set(this, modelName, s);
    });
}
