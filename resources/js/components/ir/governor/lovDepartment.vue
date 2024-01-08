<template>
  <div class="row col-lg-6 col-md-6 align-items-center justify-content-center my-3">
    <label class="col-lg-3 col-md-6 col-form-label text-right">
      <strong>{{placeholder}}</strong>
    </label>
    <div class='col-lg-7 col-md-7 w-100'>
      <el-select  v-model="result"
                  :placeholder="placeholder"
                  :remote-method="remoteMethodDepartment"
                  :clearable="true"
                  @change="handleChange"
                  @focus="focusDepartment"
                  filterable
                  class='w-100'>
        <el-option  v-for="(data, index) in list"
                    :key="index"
                    :label="data.department_code + ': ' + data.description"
                    :value="data.department_code">
        </el-option>
      </el-select>
    </div>
  </div>
</template>

<script>
export default {
  name: 'gas-station-lov-department',
  data() {
    return {
      result: this.value,
      list: []
    }
  },
  props: [
    'value',
    'placeholder'
  ],
  mounted() {
    const vm = this
    vm.getDepartment()
  },
  methods: {
    getDepartment(params = {keyword: ''}) {
      const vm = this
       axios.get(`/ir/ajax/lov/department-code`, { params })
      .then(({data: response}) => {
        vm.list = response.data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    handleChange(value) {
      const vm = this
      vm.$emit('department', value)
    }
  }
}
</script>