<template>
    <date-picker
        :input-attr="{ name, id, placeholder }"
        :disabled="disabled"
        :clearable="clearable"
        :disabled-date="(date) => !enableDate(date)"
        :formatter="datePickerCustom.formatter"
        :lang="datePickerCustom.lang"
        :value="value"
        @open="datePickerCustom.onUiFrameChange"
        @calendar-change="datePickerCustom.onUiFrameChange"
        @panel-change="datePickerCustom.onUiFrameChange"
        @change="onChange"/>
</template>

<script>
import DatePicker from "vue2-datepicker"
import "vue2-datepicker/index.css";

import {DateTime} from 'luxon';
import {customBuddhistYearDatePicker, toJSDate, toDateTime, isInRange} from '../dateUtils'

let datePickerCustom = customBuddhistYearDatePicker()

export default {
    components: {
        DatePicker,
    },
    props: {
        enableDate: {type: Function, default: (_) => true},
        value: {default: null},
        id: {type: String, default: null},
        name: {type: String, default: null},
        placeholder: {type: String, default: 'โปรดเลือกวันที่'},
        disabled: {type: Boolean, default: false},
        clearable: {type: Boolean, default: true},
    },
    model: {
        prop: "value",
        event: "input",
    },
    computed: {
        dateValue() {
            return toJSDate(this.value)
        },
    },
    data() {
        return {
            console,
            datePickerCustom,
        }
    },
    methods: {
        onChange(value) {
            this.$emit('input', value)
            this.$emit('change', value)
        },
    }
};
</script>
