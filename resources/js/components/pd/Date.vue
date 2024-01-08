<template>
  <div class="col-md-9" :class="{required: requiredClass }">
    <el-date-picker
      v-model="from_date"
      type="date"
      placeholder="Pick a Date"
      name="from_date"
      format="dd-MM-yyyy"
      value-format="dd-MM-yyyy"
      @change="chooseStartDate()"
    ></el-date-picker>
    <span class="mx-2 tw-font-bold tw-text-grey-dark tw-text-xs">TO</span>
    <el-date-picker
      v-model="to_date"
      type="date"
      placeholder="Pick a Date"
      name="to_date"
      format="dd-MM-yyyy"
      value-format="dd-MM-yyyy"
      @change="checkEndDate()"
    ></el-date-picker>
  </div>
</template>

<script>
import DatePicker from 'element-ui';
Vue.use(DatePicker);
// dayjs.locale('en')
export default {
  props: [
    "defaultFromDate",
    "defaultToDate",
    "from-date",
    "to-date",
    "required"
  ],

  data() {
    return {
      requiredClass: this.required || false,
      from_date: this.defaultFromDate ? this.defaultFromDate : this.fromDate,
      to_date: this.defaultToDate ? this.defaultToDate : this.toDate
    };
  },
  methods: {
    chooseStartDate() {
      if (this.from_date != '' || this.from_date != null) {
        this.to_date = this.from_date;
      }
    },
    checkEndDate() {
      if (this.from_date != null && moment(this.from_date, "DD-MM-YYYY") > moment(this.to_date, "DD-MM-YYYY")) {
        this.$notify.error({
            title: 'มีข้อผิดพลาด',
            message: 'End Date ไม่สามารถน้อยกว่า Start Date',
            duration: 3000
        });
        this.to_date = '';
      }
    },
  },
};
</script>

<style scope>
.el-date-editor .el-range-separator {
  padding: 0;
}
.required .el-input__inner {
  background: #fff6db;
}
</style>