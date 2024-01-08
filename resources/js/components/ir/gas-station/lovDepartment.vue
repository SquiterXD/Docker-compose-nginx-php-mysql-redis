<template>
  <div class="el_field">
    <el-select  v-model="result"
                :placeholder="placeholder"
                remote
                :remote-method="remoteMethodDepartment"
                :clearable="true"
                @change="handleChange"
                @focus="focusDepartment"
                filterable
                :size='sizeDefault'
                :popper-append-to-body="popperBody"
                :disabled='disabled'>
      <el-option  v-for="(data, index) in list"
                  :key="index"
                  :label="data.department_code  + ': ' + data.description"
                  :value="data.department_code">
      </el-option>
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-gas-station-lov-department',
  data() {
    return {
      result: this.value,
      list: [],
      sizeDefault: this.sizeSmall ? 'small' : 'large'
    }
  },
  props: [
    'value',
    'placeholder',
    'popperBody',
    'sizeSmall',
    'disabled'
  ],
  mounted() {
    const vm = this
    vm.getDepartment({department_code: '', keyword: this.value})
  },
  methods: {
     remoteMethodDepartment (query) {
        this.getDepartment({ department_code: '', keyword: query });
      },
    getDepartment(params) {
      const vm = this
       axios.get(`/ir/ajax/lov/department-code`, { params })
      .then(({data: response}) => {
        vm.list = response.data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
     focusDepartment() {
      this.getDepartment({ department_code: '', keyword: '' });
    },
    handleChange(value) {
      const vm = this
      for (let i in vm.list) {
        let row = vm.list[i]
        if (row.department_code === value) {
          this.$emit('department', row)
        }
      }
      if (!value) this.$emit('department', '')
    }
  },
  watch: {
    value(newVal) {
      const vm = this
      vm.result = newVal;
      this.getDepartment({ department_code: '', keyword: newVal });
    }
  }
}
</script>