<template>
  <div class="el_field">
   <el-select v-model="result"
              :placeholder="placeholder"
              :name="name"
              :clearable="true"
              @change="change">
      <el-option  v-for="(data, index) in period_name"
                  :key="index"
                  :label="data"
                  :value="data" />
   </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-components-lov-month-budget-year',
  data () {
    return {
      // result: this.value
      period_name: [],
      months: 12
    }
  },
  props: [
    'value',
    'name',
    'placeholder',
    'param_year'
  ],
  computed: {
    result: {
      get: function () {
        return this.value
      },
      set: function (change) {
        this.$emit('change-lov', change)
      }
    }
  },
  methods: {
    setMonths (input_year) {
      this.period_name = []
      let set_period_name = []
      if (input_year) {
        let test = ''
        let set = []
        for (let i = 1; i <= this.months; i++) {
          let num = i.toString()
          if (num.length === 1) {
            test = `01/0${num}/${input_year}`
          } else {
            let year = +num > 9 && +num <= 12 ? +input_year - 1 : input_year
            test = `01/${num}/${year}`
          }
          set.push(test)
        }
        let test1 = set => {
          let test2 = (a, b) => {
             
            return new Date(a).getTime() - new Date(b).getTime();
          }
          set.sort(test2);
        };
        test1(set);
        set.filter((row) => {
          let arr = row.split('/')
          return set_period_name.push(`${arr[1]}/${arr[2]}`)
        })
        this.period_name = set_period_name
      }
    },
    change (value) {
      this.$emit('change-lov', value)
    }
  },
  watch: {
    'param_year' (newVal, oldVal) {
      this.setMonths(newVal)
    }
  }
}
</script>

<style>

</style>