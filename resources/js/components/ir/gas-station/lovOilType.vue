<template>
  <div class="el_field">
    <el-select  v-model="oil"
                :value='oil'
                filterable
                remote
                :clearable="true"
                :size="sizeDefault"
                :placeholder='placeholder'
                @change="changeOilType"
                class="w-100"
                :popper-append-to-body="popperBody"
                :disabled='disabled'>
      <el-option  v-for="(data, index) in oilTypeList"
                  :key="index"
                  :label="`${data.type_code}`"
                  :value="data.type_code">
      </el-option>
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'gas-station-lov-oil-type',
  data() {
    return {
      oil: this.value,
      oilTypeList: [],
      sizeDefault: this.sizeSmall ? 'small' : 'large'
    }
  },
  props: ['value', 'popperBody', 'sizeSmall', 'placeholder', 'disabled'],
  mounted() {
    const vm = this
    vm.getLovGasStationType()
  },
  methods: {
    getLovGasStationType(params = {keyword: ''}) {
      const vm = this
      axios.get('/ir/ajax/lov/gas-station-type-master', {params})
      .then(({data:response}) => {
        vm.oilTypeList = response.data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    changeOilType(value) {
      const vm = this
      let result =  vm.oilTypeList.find(({type_code}) => type_code === value)
      vm.$emit('oilType', result)
    }
  },
  watch: {
    value(newVal) {
      const vm = this
      vm.oil = newVal
    }
  }
}
</script>