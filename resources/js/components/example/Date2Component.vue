<template>
    <div class="container">
            <!-- :enableDate="date => isInRange(date, null, toJSDate(search.plan_start_date_to), true)" -->
        <ct-datepicker
            class="my-1 col-sm-12 form-control"
            style="width: 200px;"
            placeholder="โปรดเลือกวันที่"
            :value="toJSDate(search.fm_date, 'yyyy-MM-dd')"
            @change="(date) => {
                search.fm_date = jsDateToString(date)
            }"
        />
    </div>
</template>

<script>
import {isInRange, jsDateToString, toJSDate, toThDateString} from '../../dateUtils'

export default {
    props: ["pFmDate", "pDateFormat"],
    data() {
        return {
            isInRange,
            jsDateToString,
            toJSDate,
            toThDateString,
            search: {
                fm_date: this.pFmDate
            },
        };
    },
    mounted() {
    },
    methods: {
  }
};
</script>
