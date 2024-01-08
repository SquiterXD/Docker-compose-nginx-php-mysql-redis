<template>
  <div>
    <el-select  v-model="result"
                filterable
                remote
                :clearable="true"
                size="large"
                :placeholder="placeholder"
                @change="handleChange"
                @click.native="click()"
                :loading="loading"
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
      loading: false,
      result: this.value,
      list: []
    }
  },
  props: ['value', 'placeholder'],
  // mounted() {
  //   const vm = this
  //   vm.getLovStatus()
  // },
  methods: {
    getLovStatus(params = {keyword: ''}) {
      const vm = this
      vm.loading = true
      axios.get('/ir/ajax/lov/status')
      .then(({data:response}) => {
        vm.loading = false
        vm.list = response
      })
      .catch((error) => {
        swal("Error", error, "error")
      })
    },
    click () {
      const vm = this
      vm.getLovStatus()
    },
    handleChange(value) {
      const vm = this
      vm.$emit('status', value)
    }
  },
}
</script>