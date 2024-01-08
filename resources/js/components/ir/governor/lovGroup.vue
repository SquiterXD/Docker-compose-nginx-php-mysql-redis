<template>
  <div class="row col-lg-6 col-md-6 align-items-center justify-content-center my-3">
    <label class="col-lg-3 col-md-6 col-form-label text-right">
      <strong>เลขที่ใบแจ้งหนี้</strong>
    </label>
    <div class='col-lg-7 col-md-7 w-100'>
      <el-select  v-model="result"
                  filterable
                  remote
                  :clearable="true"
                  size="large"
                  placeholder="เลขที่ใบแจ้งหนี้"
                  @change="handleChange"
                  class="w-100">
        <el-option  v-for="(data, index) in list"
                    :key="index"
                    :label="`${data.meaning}`"
                    :value="data.group_code">
        </el-option>
      </el-select>
    </div>
  </div>
</template>

<script>
export default {
  name: 'gas-station-lov-oil-type',
  data() {
    return {
      result: this.value,
      list: []
    }
  },
  props: ['value'],
  mounted() {
    const vm = this
    // vm.getLovGasStationType()
  },
  methods: {
    getLovGasStationType(params = {keyword: ''}) {
      const vm = this
      axios.get('/ir/ajax/lov/group-code', {params})
      .then(({data:response}) => {
        vm.list = response.data
      })
      .catch((error) => {
        swal("Error", error, "error")
      })
    },
    handleChange(value) {
      const vm = this
      vm.$emit('groupType', value)
    }
  },
}
</script>