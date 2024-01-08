<template>
  <div class="el_select">
    <el-select  v-model="department_cost_code"
                :placeholder="'รหัสหน่วยงานตามค่าใช้จ่าย'"
                :name="attrName"
                :remote-method="remoteMethodDepartmentCost"
                :loading="loading"
                remote
                :clearable="true"
                filterable
                size="small"
                @change="changeDepartmentCost"
                @focus="focusDepartmentCost">
      <el-option  v-for="(data, index) in departmentCosts"
                  :key="index"
                  :label="data.meaning + ': ' + data.description"
                  :value="data.meaning">
      </el-option>
    </el-select>
  </div>
</template>

<script>
  export default {
    name: 'ir-asset-increase-lov-department-cost',
    data () {
      return {
        departmentCosts: [],
        loading: false,
        department_cost_code: this.departmentCostCode
      }
    },
    props: [
      // 'placeholder',
      'attrName',
      'departmentCostCode',
      'row',
    ],
    methods: {
      remoteMethodDepartmentCost (query) {
        this.getDepartmentCosts({ department_code: '', keyword: query });
      },
      getDepartmentCosts (params) {
        this.loading = true;
        axios.get(`/ir/ajax/lov/department-code`, { params })
        .then(({data}) => {
          let response = data.data
          this.loading = false;
          this.departmentCosts = response;
        })
        .catch((error) => {
          swal('Error', error, 'error')
        })
      },
      focusDepartmentCost (event) {
        this.getDepartmentCosts({ department_code: '', keyword: '' });
      },
      changeDepartmentCost (value) {
        if (value) {
          for (let i in this.departmentCosts) {
            let cost = this.departmentCosts[i]
            if (cost.meaning === value) {
              this.row.department_cost_code = value
              this.row.department_cost_desc = cost.description
            }
          }
        } else {
          this.row.department_cost_code = ''
          this.row.department_cost_desc = ''
        }
      }
    },
    mounted() {
      this.getDepartmentCosts({ department_code: '', keyword: '' })
    },
    watch: {
      'departmentCostCode' (newVal, oldVal) {
        this.department_cost_code = newVal;
      }
    }
  }
</script>

