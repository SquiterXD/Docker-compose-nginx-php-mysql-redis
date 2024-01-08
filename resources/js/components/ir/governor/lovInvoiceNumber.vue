<template>
  <div>
    <el-select  v-model="result"
                filterable
                remote
                :clearable="true"
                size="large"
                placeholder="เลขที่ใบแจ้งหนี้"
                @change="handleChange"
                class="w-100"
                :disabled='disabled'>
      <el-option  v-for="(data, index) in list"
                  :key="index"
                  :label="`${data.invoice_number}`"
                  :value="data.invoice_number">
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
      list: []
    }
  },
  props: ['value','disabled','fetchInvoice'],
  mounted() {
    const vm = this
    vm.getLovInvoiceType()
  },
  methods: {
    getLovInvoiceType(params = {keyword: ''}) {
      const vm = this
      axios.get('/ir/ajax/lov/invoice-number', {params})
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
    },
  },
  watch: {
    fetchInvoice(newVal) {
      if (newVal) this.getLovInvoiceType()
    }
  }
}
</script>