<template>
  <div class="el_field">
    <el-select  v-model="result"
                :placeholder="placeholder"
                remote
                :clearable="true"
                @change="handleChange"
                @click.native="click()"
                :loading="loading"
                filterable
                size='small'
                :disabled='disabled'>
      <el-option  v-for="(data, index) in list"
                  :key="index"
                  :label="data.company_number + ': ' + data.company_name"
                  :value="data.company_id">
      </el-option>
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'gas-station-lov-company',
  data() {
    return {
      loading: false,
      result: this.value ? parseInt(this.value) : '',
      list: [],
    }
  },
  props: [
    'value',
    'placeholder',
    'disabled',
    'size',
    'isSave'
  ],
  mounted() {
    const vm = this
    if(vm.value) vm.getCompany()
  },
  methods: {
    getCompany(params = {keyword: ''}) {
      const vm = this
      vm.loading = true
       axios.get(`/ir/ajax/lov/companies`, { params })
      .then(({data: response}) => {
        vm.loading = false
        vm.list = response.data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    click() {
      const vm = this
      vm.getCompany()
    },    
    handleChange(value) {
      let code = ''
      let desc = ''
      let id = ''
      if (value) {
        for (let i in this.list) {
          let row = this.list[i]
          if (row.company_id === +value) {
            code = row.company_number
            desc = row.company_name,
            id = value
          }
        }
      } else {
        code = ''
        desc = ''
        id = ''
      }
      let data = {
        code: code,
        desc: desc,
        id: id
      }
      this.$emit('company', data)
    }
  },
  watch: {
    value(newVal) {
      const vm = this
      vm.result = newVal ? +newVal : newVal
    }
  }
}
</script>