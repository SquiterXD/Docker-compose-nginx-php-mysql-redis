<template>
  <div class="el_field">
    <el-select  v-model="result"
                filterable
                remote
                :clearable="true"
                :size="sizeDefault"
                placeholder="ประเภทใบแจ้งหนี้"
                @change="handleChange"
                :disabled='disabled'>
      <el-option  v-for="(data, index) in list"
                  :key="index"
                  :label="`${data.invoice_type}`"
                  :value="data.invoice_type">
      </el-option>
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'governor-invoice-lov',
  data() {
    return {
      result: this.value,
      list: [],
      sizeDefault: this.sizeSmall ? 'small' : 'large'
    }
  },
  props: ['value','disabled', 'sizeSmall', 'fetchInvoice'],
  mounted() {
    const vm = this
    vm.getLovInvoiceType()
  },
  methods: {
    getLovInvoiceType(params = {keyword: ''}) {
      const vm = this
      axios.get('/ir/ajax/lov/invoice-type', {params})
      .then(({data:response}) => {
        vm.list = response.data
      })
      .catch((error) => {
        swal("Error", error, "error")
      })
    },
    handleChange(value) {
      const vm = this
      vm.$emit('invoice', value)
    }
  },
  watch: {
    fetchInvoice(neVal) {
       
      const vm = this
      vm.getLovInvoiceType()
    }
  }
}
</script>