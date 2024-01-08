<template>
  <div class="el_select">
    <el-select  v-model="department_code"
                :placeholder="'รหัสสังกัด'"
                :name="attrName"
                :remote-method="remoteMethodDepartment"
                :loading="loading"
                remote
                :clearable="true"
                filterable
                size="small"
                @change="changeDepartment"
                @focus="focusDepartment">
      <el-option  v-for="(data, index) in departments"
                  :key="index"
                  :label="data.meaning + ': ' + data.description"
                  :value="data.meaning">
      </el-option>
    </el-select>
  </div>
</template>

<script>
  export default {
    name: 'ir-asset-plan-lov-department',
    data () {
      return {
        departments: [],
        loading: false,
        department_code: this.departmentCode
      }
    },
    props: [
      // 'placeholder',
      'attrName',
      'departmentCode',
      'row',
    ],
    methods: {
      remoteMethodDepartment (query) {
        this.getDepartments({ value: '', keyword: query });
      },
      getDepartments (params) {
        this.loading = true;
        axios.get(`/ir/ajax/lov/cat-segment1`, { params })
        .then(({data}) => {
          let response = data.data
          this.loading = false;
          this.departments = response;
        })
        .catch((error) => {
          swal('Error', error, 'error')
        })
      },
      focusDepartment (event) {
        this.getDepartments({ value: '', keyword: '' });
      },
      changeDepartment (value) {
        if (value) {
          for (let i in this.departments) {
            let department = this.departments[i]
            if (department.meaning === value) {
              this.row.department_code = value;
              this.row.department_name = department.description;
            }
          }
        } else {
          this.row.department_code = '';
          this.row.department_name = '';
        }
        // this.$emit('change-value-departments', this.rows)
      }
    },
    mounted() {
      this.getDepartments({ value: '', keyword: '' })
    },
    watch: {
      'departmentCode' (newVal, oldVal) {
        this.department_code = newVal;
      }
    }
  }
</script>

