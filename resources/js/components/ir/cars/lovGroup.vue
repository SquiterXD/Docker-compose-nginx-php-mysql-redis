<template>
  <div>
    <el-select  v-model="result"
                filterable
                remote
                :clearable="true"
                size="meduim"
                placeholder="กลุ่ม"
                @change="handleChange"
                @click.native="click()"
                :loading="loading"
                class="w-100"
                :popper-append-to-body="popperBody">
      <el-option  v-for="(data, index) in list"
                  :key="index"
                  :label="`${data.meaning}`"
                  :value="data.group_code">
      </el-option>
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'car-lov-group',
  data() {
    return {
      loading: false,
      result: this.value,
      list: []
    }
  },
  props: ['value','popperBody'],
  // mounted() {
  //   const vm = this
  //   vm.getLovGasStationType()
  // },
  methods: {
    getLovGasStationType(params = {keyword: ''}) {
      const vm = this
      vm.loading = true
      axios.get('/ir/ajax/lov/group-code', {params})
      .then(({data:response}) => {
        vm.loading = false
        vm.list = response.data
      })
      .catch((error) => {
        swal("Error", error, "error")
      })
    },
    click() {
      const vm = this
      vm.getLovGasStationType()
    },
    handleChange(value) {
      const vm = this
      vm.$emit('groupType', value)
    }
  },
  watch: {
    value(newVal) {
      const vm = this
      vm.result = newVal
    }
  }
}
</script>