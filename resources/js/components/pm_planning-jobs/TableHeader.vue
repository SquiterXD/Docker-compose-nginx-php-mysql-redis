<template>
  <thead>
    <tr>
      <th></th>
      <th style="min-width: 200px;">ขอบเขตเครื่องจักร</th>
      <th>หัวจ่าย</th>
      <th v-for="date in dateRange" :key="date" :class="{ 'bg-muted' : !getWorkingHour(date)}">
        <div>{{ formatTableDate(date) }}</div>
        <hr />
        <div class="text-right">
            {{getWorkingHour(date)}}
        </div>
      </th>
    </tr>
      <!-- <th v-for="date in dateList" :key="date.date" :class="{ 'bg-muted' : date.working_hour  == 0}">
        <div>{{ formatTableDate(date.date) }}</div>
        <hr />
        <div class="text-right">
            {{date.working_hour}}
        </div>
      </th>
    </tr> -->
  </thead>
</template>

<script>
import { DateTime } from "luxon";

export default {
  props: ["dateList", "dateRange"],
  methods: {
    formatTableDate(date) {
      return DateTime.fromFormat(date, "yyyy-LL-dd hh:mm:ss", { locale: "th"}).plus({years: 543}).toFormat(
        "d-MMM-yy"
      );
    },
    getWorkingHour(findDate) {
        let found = this.dateList.find( d => {
            // console.log(d, findDate)
            // console.log("xx", findDate == d.date)
            return findDate == d.date
        })

        return found?.working_hour || "-"
    }
  },
};
</script>

