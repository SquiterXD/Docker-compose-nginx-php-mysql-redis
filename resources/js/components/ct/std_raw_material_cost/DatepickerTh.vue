<template>
    <date-picker
        :input-class="[inputClass]"
        v-model="date"
        :default-value="defaultDate"
        :input-attr="{ name, id }"
        :placeholder="placeholder"
        :lang="lang"
        :disabled="disableDate"
        format="DD/MM/YYYY"
        @change="dateWasSelected"
    ></date-picker>
</template>

<script>
import DatePicker from "vue2-datepicker";
import "vue2-datepicker/index.css";
import moment from "moment";
import {DateTime} from "luxon";

export default {
    props: ["value", "name", "id", "inputClass", "placeholder", "disableDate"],

    components: {
        DatePicker
    },

     data() {
        return {
            date: this.value ? moment(this.value, "DD/MM/YYYY").toDate() : null,
            defaultDate: this.value
                ? moment(this.value, "DD/MM/YYYY").toDate()
                : moment()
                      .toDate(),
            
            lang: {
                formatLocale: {
                    months: [
                        "มกราคม",
                        "กุมภาพันธ์",
                        "มีนาคม",
                        "เมษายน",
                        "พฤษภาคม",
                        "มิถุนายน",
                        "กรกฎาคม",
                        "สิงหาคม",
                        "กันยายน",
                        "ตุลาคม",
                        "พฤศจิกายน",
                        "ธันวาคม"
                    ],
                    monthsShort: [
                        "ม.ค.",
                        "ก.พ.",
                        "มี.ค.",
                        "เม.ย.",
                        "พ.ค.",
                        "มิ.ย.",
                        "ก.ค.",
                        "ส.ค.",
                        "ก.ย.",
                        "ต.ค.",
                        "พ.ย.",
                        "ธ.ค."
                    ],
                    weekdays: [
                        "พฤหัสบดี",
                        "ศุกร์",
                        "เสาร์",
                        "อาทิตย์",
                        "จันทร์",
                        "อังคาร",
                        "อังคาร"
                    ],
                    weekdaysShort: [
                        "พฤหัสบดี",
                        "ศุกร์",
                        "เสาร์",
                        "อาทิตย์",
                        "จันทร์",
                        "อังคาร",
                        "อังคาร"
                    ],
                    weekdaysMin: ["พฤ.", "ศ.", "ส.", "อา.", "จ.", "อ.", "พ."],
                    firstDayOfWeek: 3
                },
                yearFormat: "YYYY",
                monthFormat: "MMM",
                monthBeforeYear: true
            },
           
        };
    },

    watch: {
        value: function(value) {
            this.date = value ? moment(value, "DD/MM/YYYY").toDate() : null;
        },
        disableDate: function(value) {
            this.disableDate = value;
        }
    },

   

    methods: {
        dateWasSelected(date) {
            this.date = date;
            this.$emit("dateWasSelected", date);
        }
    }
};
</script>
<style>
.input-disable {
    background-color: #f5f7fa !important;
    border-color: #e4e7ed !important;
    color: #c0c4cc !important;
    cursor: not-allowed !important;
    pointer-events: none;
}
</style>
