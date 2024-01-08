<template>
    <date-picker
        :input-class="[inputClass]"
        v-model="date"
        :default-value="defaultDate"
        :input-attr="{ name, id }"
        :placeholder="placeholder"
        :lang="lang"
        :type='type'
        :disabled-date="disabledDate"
        :format="format"
        @change="dateWasSelected"
        ref="input"
    ></date-picker>
</template>

<script>
  import DatePicker from "vue2-datepicker";
  import "vue2-datepicker/index.css";
  import moment from "moment";
  export default {
    props: ["value", "name", "id", "inputClass", "placeholder", "disabledDateTo", "format", "pType"],
    mounted() {
    },
    watch: {
        disabledDateTo : async function (value) {
            if(await moment(value, this.format).toDate() > this.date) {
                this.date = null;
            }
        },
        value : async function (value, oldValue) {
            if (value) {
                this.date = value ? moment(value, this.format).toDate() : null;
            } else {
                this.date = null;
            }
        },
    },
    components: {
        DatePicker
    },
    data() {
        return {
            type: (this.pType != undefined && this.pType != '') ? this.pType : 'date',
            date: this.value ? moment(this.value, this.format).toDate() : null,
            defaultDate: this.value ? moment(this.value, this.format).toDate() : moment().toDate(),
            lang: {
                formatLocale: {
                    months: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
                    monthsShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
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
                return date < moment(this.disabledDateTo, this.format).toDate();
            }
        };
    },
    methods: {
        dateWasSelected(date) {
            this.date = date;
            this.$emit("period-date", date);
        }
    }
  };
</script>
<style type="text/css">
    .mx-datepicker-popup{
        z-index: 9999 !important;
    }
</style>