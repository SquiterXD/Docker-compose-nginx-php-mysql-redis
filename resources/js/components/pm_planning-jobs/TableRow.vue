<template>
  <tbody>
    <template v-for="(groupByFeeder, machine) in groupByMachineAndDate">
      <template v-for="(groupByDate, feeder) in groupByFeeder">
        <tr>
          <td></td>
          <td>
            {{ machine }}
          </td>
          <td>
            {{ feeder }}
          </td>
          <template v-for="date in dateRange">
            <td :class="{ 'bg-muted' : ! getWorkingHour(date) }" >
              <PlanCell
                :date="date"
                :groupByDates="groupByDate[date]"
                :showQuantity="showQuantity"
              ></PlanCell>
            </td>
          </template>
        </tr>
      </template>
    </template>
  </tbody>
</template>

<script>
import PlanCell from "./PlanCell";
export default {
  props: ["dateRange", "groupByMachineAndDate", "dateList", "showQuantity"],
  components: { PlanCell },
  data() {
      return {
          lineNum: 1,
      }
  },

  methods: {
      getWorkingHour(findDate) {
        let found = this.dateList.find( d => {
            // console.log(d, findDate)
            // console.log("xx", findDate == d.date)
            return findDate == d.date
        })

        return found?.working_hour
    }

  }
};
</script>
