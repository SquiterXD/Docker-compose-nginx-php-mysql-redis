<template>
  <div>
    <el-select  v-model="result"
                filterable
                remote
                :clearable="true"
                size="large"
                :placeholder="placeholder"
                @change="handleChange"
                class="w-100">
      <el-option  v-for="(data, index) in list"
                  :key="index"
                  :label="`${data.meaning}`"
                  :value="data.lookup_code">
      </el-option>
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'gas-station-lov-status',
  data() {
    return {
      result: this.value,
      list: []
    }
  },
  props: ['value', 'placeholder'],
  mounted() {
    const vm = this
    vm.getLovStatus()
  },
  methods: {
    getLovStatus(params = {keyword: ''}) {
      const vm = this
      axios.get('/ir/ajax/lov/status')
      .then(({data:response}) => {
        vm.list = response
      })
      .catch((error) => {
        swal("Error", error, "error")
      })
    },
    handleChange(value) {
      const vm = this
      vm.$emit('status', value)
    }
  },
}
</script>