<template>
    <div>
        <el-date-picker 
              v-model="data_value"
              style="width: 100%;"
              type="date"
              :placeholder="this.text_detail"
              :name="this.dataName"
              format="dd-MM-yyyy"
              >
        </el-date-picker> 
    </div>
</template>
<script>
export default {
    props: ['dataName', 'defaultValue', 'old', 'textDetail'],
    data() {
    return {
      data_value: this.defaultValue ? this.defaultValue : '',
      text_detail:this.textDetail   ? this.textDetail   : '',
    };
  },
}
</script>