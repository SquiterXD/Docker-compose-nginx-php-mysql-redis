<template>
  <div>
    <div class="block">
      <el-date-picker
        v-model="dateValue"
        type="daterange"
        range-separator="ถึง"
        :start-placeholder="this.startDate"
        :end-placeholder="this.endDate"
        format="dd/MM/yyyy"
        value-format="dd/MM/yyyy"
      >
      </el-date-picker>
      <input type="hidden" name="start_date" :value="dateValue ? dateValue[0] : ''">
      <input type="hidden" name="end_date" :value="dateValue ? dateValue[1] : ''">
    </div>
  </div>
</template>

<script>
export default ({
    props: ['startDate', 'endDate'],
    data() {
        return {
            dateValue: '',
        }
    },
})
</script>

<style lang="scss"> 
 .el-date-editor .el-range-separator {
    width: 10%;
    white-space: nowrap;
}

 .el-range-editor.el-input__inner{
   width: 100%;
 }
</style>
