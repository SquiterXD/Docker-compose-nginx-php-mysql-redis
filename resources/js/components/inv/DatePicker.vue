<template>
  <div class="block">
    <el-date-picker
        v-model="dateValue"
        type="date"
        placeholder="Pick a day"
        format="dd/MM/yyyy"
        value-format="dd/MM/yyyy">
    </el-date-picker>
    <input type="hidden" :name="name" :value="dateValue">
  </div>
</template>

<script>
export default {
  props: {
    name: {
      type: String,
      default: 'start_date'
    },
  },
  data() {
    return {
      dateValue: '',
    };
  }
};
</script>