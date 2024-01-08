<template>
    <el-select
        reserve-keyword
        filterable
        clearable
        remote
        :disabled="disabled"
        :placeholder="placeholder"
        :value-key="keyField"
        :loading="loading"
        :remote-method="remoteMethod"
        :visible="isVisible"
        v-bind:value="currentValue"
        v-on:change="dispatchChange"
        v-on:input="dispatchInput">

        <el-option
            v-for="item in options"
            :key="item.key"
            :label="item.label"
            :value="item.value">
        </el-option>
    </el-select>
</template>

<!--suppress JSUnresolvedFunction -->
<script>

//TODO import package
import {instance as http} from '../pm/httpClient'
import {$route} from '../router'
import _isNil from "lodash/isNil";
import _isEmpty from "lodash/isEmpty";

export function defaultRemoteDataSource(tableName, searchKeys, query, maxResults, filterBy) {
    return http.get($route('api.db.lookup'), {
        params: {
            tableName, searchKeys, query, maxResults, filterBy,
        }
    }).then(({data}) => {
        return data
    });
}

export function defaultLabelFormatter(item, labels, labelFormat) {
    let delimiterCount = labelFormat.split('{$}').length - 1;
    if (labels.length !== delimiterCount) {
        throw 'Delimiter and label must has a equal number.'
    }

    let labelValues = labels.map(label => {
        if (typeof item[label] === 'undefined') {
            throw `Label field '${label}' does not exist in the object!`;
        }
        return item[label];
    });

    let formattedLabel = labelFormat;
    for (let value of labelValues) {
        formattedLabel = formattedLabel.replace('{$}', value);
    }

    return formattedLabel;
}

function execOrValue(mayBeFunction) {
    if (typeof mayBeFunction === 'function') return mayBeFunction()
    return mayBeFunction
}

export default {
    model: {
        prop: 'model',
        event: 'input',
    },
    computed: {
        isVisible(){
            this.currentValue = this.model
            return this.model !== null;

            // if(!this.model){
            //     this.currentValue = null
            // }
        },
    },
    props: {
        model: {},
        remoteDataSource: {
            type: Function,
            default: defaultRemoteDataSource,
        },
        tableName: {
            type: String,
            default: null,
        },
        placeholder: {
            type: String,
            default: 'พิมพ์เพื่อค้นหา',
        },
        keyField: {
            type: String,
            default: null,
        },
        searchKeys: {
            type: Array,
            default: () => [],
        },
        valueField: {
            type: String,
            default: null,
        },
        labelFormatter: {
            type: Function,
            default: defaultLabelFormatter,
        },
        labelField: {
            type: String,
            default: null,
        },
        labelFields: {
            type: Array,
            default: () => [],
        },
        labelPattern: {
            type: String,
            default: null,
        },
        selectedLabelFormatter: {
            type: Function,
            default: defaultLabelFormatter,
        },
        selectedLabelField: {
            type: String,
            default: null,
        },
        selectedLabelFields: {
            type: Array,
            default: () => [],
        },
        selectedLabelPattern: {
            type: String,
            default: null,
        },
        maxResults: {
            type: Number,
            default: 30,
        },
        initialObject: {
            type: Object,
            default: null,
        },
        prePopulateText: {
            type: String,
            default: null,
        },
        preFetch: {
            type: Boolean,
            default: false,
        },
        filterBy: {
            type: Function,
            default: () => {
                return {}
            },
        },
        disabled: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            options: [],
            currentValue: null,
            loading: false,
            dataSource: this.remoteDataSource,
        }
    },
    created() {
    },
    mounted() {
        this.validateData(
            this.remoteDataSource,
            this.tableName,
            this.keyField,
            this.labelField,
            this.labelFields,
            this.selectedLabelField,
            this.selectedLabelFields,
        );

        if (this.initialObject && this.prePopulateText) {
            console.warn('Both initial-object and pre-populate-text are set.' +
                ' initial-object will take precedent over pre-populate-text.')
        }

        if (this.initialObject) {
            console.debug('initial-object', this.initialObject);

            let key = this.initialObject[this.keyField];
            let label = this.getLabel(this.initialObject, this.labelField, this.labelFields, this.labelPattern);

            this.options = [{
                key: key,
                label: label,
                value: this.getValue(this.initialObject, this.valueField),
            }];
            this.currentValue = this.initialObject;

            console.debug('option', this.options);

        } else if (this.prePopulateText) {
            console.debug('pre-populate-text', this.prePopulateText);

            this.options = [{
                key: this.prePopulateText,
                label: this.prePopulateText,
                value: this.prePopulateText,
            }];
            this.currentValue = this.prePopulateText;
        }

        if (this.preFetch) {
            if (this.initialObject) {
                this.remoteMethod(this.initialObject[this.keyField]);

            } else if (this.prePopulateText) {
                this.remoteMethod(this.prePopulateText);

            } else {
                this.remoteMethod('');
            }
        }
    },
    methods: {
        async remoteMethod(query) {
            this.loading = true;

            console.debug('remoteMethod', {query});

            if (query !== null) {
                this.validateData(
                    this.remoteDataSource,
                    this.tableName,
                    this.keyField,
                    this.labelField,
                    this.labelFields,
                    this.selectedLabelField,
                    this.selectedLabelFields,
                );

                console.debug(
                    {
                        tableName: this.tableName,
                        keyField: this.keyField,
                        valueField: this.valueField,
                        searchKeys: this.searchKeys,
                        labelField: this.labelField,
                        labelFields: this.labelFields,
                        selectedLabelField: this.selectedLabelField,
                        selectedLabelFields: this.selectedLabelFields,
                        labelPattern: this.labelPattern,
                        maxResults: this.maxResults,
                        prePopulateText: this.prePopulateText,
                        preFetch: this.preFetch,
                        remoteDataSource: this.remoteDataSource,
                        labelFormatter: this.labelFormatter,
                        selectedLabelFormatter: this.selectedLabelFormatter,
                        currentValue: this.currentValue,
                    });

                let searchKeys;
                if (this.searchKeys === null || this.searchKeys.length === 0) {
                    searchKeys = [this.keyField];
                } else {
                    searchKeys = this.searchKeys;
                }

                console.debug('processed searchKeys: ', {searchKeys});

                let filterBy = execOrValue(this.filterBy)

                //long run operation here
                let data = await this.remoteDataSource(this.tableName, searchKeys, query, this.maxResults, filterBy);
                if (_isNil(data)) {
                    console.warn('Remote data source should return empty array instead of null');
                    data = [];
                }

                console.debug('remote data source finished', data);

                this.options = data.map(item => {
                    if (typeof item[this.keyField] === 'undefined') {
                        throw 'Key field does not exist in the object!';
                    }

                    let formattedLabel = this.getLabel(
                        item,
                        this.labelField,
                        this.labelFields,
                        this.labelPattern,
                        this.labelFormatter,
                    );

                    return {
                        key: item[this.keyField],
                        label: formattedLabel,
                        value: item,
                    }
                });

                this.loading = false;
            } else {
                this.options = [];
            }

            console.debug('remoteMethod', {
                'options': this.options,
                'currentValue': this.currentValue,
            });
        },
        validateData(remoteDataSource, tableName, keyField, labelField, labelFields, selectedLabelField, selectedLabelFields) {
            if (tableName === null && remoteDataSource === defaultRemoteDataSource) {
                throw 'table-name must has value';
            }
            if (keyField === null) {
                throw 'key-field must has value';
            }
            if (labelField === null && (labelFields === null || labelFields.length === 0)) {
                throw 'Either label-field or label-fields must has a value!';
            }
            if (labelField !== null && (labelFields !== null && labelFields.length !== 0)) {
                console.warn('Both label-field and label-fields has value. Ignore label-field');
            }
            if (selectedLabelField !== null && (selectedLabelFields !== null && selectedLabelFields.length !== 0)) {
                console.warn('Both selected-label-field and selected-label-fields has value. Ignore selected-label-field');
            }
        },
        getLabel(item, labelField, labelFields, labelPattern, labelFormatter) {
            if (!item) {
                return '';
            }

            if (labelFields === null || labelFields.length === 0) {
                labelFields = [labelField];
            }

            if (labelPattern === null) {
                labelPattern = '{$}';
            }

            let delimiterCount = labelPattern.split('{$}').length - 1;
            if (labelFields.length !== delimiterCount) {
                throw 'Label pattern delimiter count must be with same label-filed count.';
            }

            return labelFormatter(item, labelFields, labelPattern);
        },
        getSelectedLabel(item) {
            console.debug('getSelectedLabel', item)
            if (_isEmpty(this.selectedLabelField) && _isEmpty(this.selectedLabelFields)) {
                return this.getLabel(item, this.labelField, this.labelFields, this.labelPattern, this.labelFormatter);
            } else {
                return this.getLabel(item, this.selectedLabelField, this.selectedLabelFields, this.selectedLabelPattern, this.selectedLabelFormatter);
            }
        },
        getValue(item, valueField) {
            let value;
            if (valueField) {
                value = item[valueField];
            } else {
                value = item;
            }

            return value;
        },
        clearInput() {
            this.currentValue = null;
            this.dispatchChange(null);
            this.dispatchInput(null);
        },
        dispatchChange(item) {
            console.debug('dispatchChange', item);

            // change the current value to update the 'selected' value on <select> component
            this.currentValue = this.getSelectedLabel(item);

            this.$emit('change', this.getValue(item, this.valueField));
        },
        dispatchInput(item) {
            console.debug('dispatchInput', item);

            // required for update the v-model of derived component
            this.$emit('input', this.getValue(item, this.valueField));
        },
    }
}
</script>
