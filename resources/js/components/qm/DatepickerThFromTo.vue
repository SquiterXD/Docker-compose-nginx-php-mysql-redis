<template>
    <div class="row">
        <div class="col-12">
            <div class="row form-group">
                <label class="col-md-4 col-form-label required"> {{ label }} </label>
                <template v-if="timeInputHidden != 'true'">
                    <div class="col-md-5">
                        <qm-datepicker-th
                            class="form-control md:tw-mb-0 tw-mb-2"
                            :name="fromDateName"
                            :id="fromDateId"
                            :placeholder="fromDatePlaceholder ? fromDatePlaceholder : ''"
                            :value="fromDateValue"
                            @dateWasSelected="fromDateWasSelected"
                        />
                    </div>
                    <div class="col-md-3">
                        <qm-timepicker 
                            :name="fromTimeName"
                            :id="fromTimeId"
                            :value="fromTimeValue"
                        />
                    </div>
                </template>
                <template v-else>
                    <div class="col-md-8">
                        <qm-datepicker-th
                            class="form-control md:tw-mb-0 tw-mb-2"
                            :name="fromDateName"
                            :id="fromDateId"
                            :placeholder="fromDatePlaceholder ? fromDatePlaceholder : ''"
                            :value="fromDateValue"
                            @dateWasSelected="fromDateWasSelected"
                        />
                    </div>
                    <div class="tw-hidden col-md-0">
                        <qm-timepicker 
                            :name="fromTimeName"
                            :id="fromTimeId"
                            :value="fromTimeValue"
                        />
                    </div>
                </template>
            </div>
            <div class="row form-group">
                <label class="col-md-4 col-form-label"> &nbsp; </label>
                <template v-if="timeInputHidden != 'true'">
                    <div class="col-md-5">
                        <qm-datepicker-th
                            class="form-control md:tw-mb-0 tw-mb-2 qm-to-date"
                            :name="toDateName"
                            :id="toDateId"
                            :placeholder="toDatePlaceholder ? toDatePlaceholder : ''"
                            :value="toDateValue"
                            :disabled-date-to="disabledDateTo"
                        />
                    </div>
                    <div class="col-md-3">
                        <qm-timepicker 
                            :name="toTimeName"
                            :id="toTimeId"
                            :value="toTimeValue"
                        />
                    </div>
                </template>
                <template v-else>
                    <div class="col-md-8">
                        <qm-datepicker-th
                            class="form-control md:tw-mb-0 tw-mb-2 qm-to-date"
                            :name="toDateName"
                            :id="toDateId"
                            :placeholder="toDatePlaceholder ? toDatePlaceholder : ''"
                            :value="toDateValue"
                            :disabled-date-to="disabledDateTo"
                        />
                    </div>
                    <div class="tw-hidden col-md-0">
                        <qm-timepicker 
                            :name="toTimeName"
                            :id="toTimeId"
                            :value="toTimeValue"
                        />
                    </div>
                </template>
            </div>
        </div>
    </div>
</template>

<script>

import moment from "moment";

export default {
    props: [
        "label",
        "fromDateName",
        "fromDateId",
        "fromDatePlaceholder",
        "fromDateValue",
        "fromTimeName",
        "fromTimeId",
        "fromTimeValue",
        "toDateName",
        "toDateId",
        "toDatePlaceholder",
        "toDateValue",
        "toTimeName",
        "toTimeId",
        "toTimeValue",
        "timeInputHidden"
    ],

    data() {
        return {
            disabledDateTo: this.fromDateValue ? this.fromDateValue : null
        };
    },

    methods: {
        fromDateWasSelected(date) {
            // change disabled_date_to of to_date = from_date
            this.disabledDateTo = moment(date).format("DD/MM/YYYY");
        }
    }
};
</script>
