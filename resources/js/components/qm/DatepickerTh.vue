<template>

    <date-picker
        :input-class="[inputClass]"
        v-model="date"
        :default-value="defaultDate"
        :input-attr="{ name, id }"
        :placeholder="placeholder"
        :lang="lang"
        :disabled-date="disabledDate"  
        format="DD/MM/YYYY"
        @change="dateWasSelected"
    ></date-picker>

</template>

<script>

import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
import moment from "moment";

export default {
    props: ["value", "name", "id", "inputClass", "placeholder", "disabledDateTo"],

    watch: {
        disabledDateTo : function (value) {
            if(moment(value, "DD/MM/YYYY").toDate() > this.date) {
                this.date = null;
            }
        }
    },

    components: {
        DatePicker
    },

    data() {
        return {
            date: this.value ? moment(this.value, "DD/MM/YYYY").toDate() : null,
            defaultDate: this.value ? moment(this.value, "DD/MM/YYYY").toDate() : moment().add(543, 'years').toDate(),
            lang: {
                formatLocale: {
                    months: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
                    monthsShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
                    weekdays: ['พฤหัสบดี', 'ศุกร์', 'เสาร์', 'อาทิตย์', 'จันทร์', 'อังคาร', 'อังคาร'],
                    weekdaysShort: ['พฤหัสบดี', 'ศุกร์', 'เสาร์', 'อาทิตย์', 'จันทร์', 'อังคาร', 'อังคาร'],
                    weekdaysMin: ['พฤ.', 'ศ.', 'ส.', 'อา.', 'จ.', 'อ.', 'พ.'],
                    firstDayOfWeek: 3,
                },
                yearFormat: 'YYYY',
                monthFormat: 'MMM',
                monthBeforeYear: true
            },
            disabledDate: (date) => {
                if(!this.disabledDateTo){ return }
                return date < moment(this.disabledDateTo, "DD/MM/YYYY").toDate();
            }
        };
    },

    methods: {
        dateWasSelected(date) {
            this.date = date;
            this.$emit("dateWasSelected", date);
        }
    }
};
</script>
