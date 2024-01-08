<template>
  <div class="el_select">
    <el-select  v-model="department_location_code"
                :placeholder="'รหัสหน่วยงานตามสถานที่'"
                :name="attrName"
                :remote-method="remoteMethodDepartmentLocation"
                :loading="loading"
                remote
                :clearable="true"
                filterable
                size="small"
                @change="changeDepartmentLocation"
                @focus="focusDepartmentLocation">
      <el-option  v-for="(data, index) in departmentLocations"
                  :key="index"
                  :label="data.meaning + ': ' + data.description"
                  :value="data.meaning">
      </el-option>
    </el-select>
  </div>
</template>

<script>
  export default {
    name: 'ir-asset-increase-department-location',
    data () {
      return {
        departmentLocations: [],
        loading: false,
        department_location_code: this.departmentLocationCode
      }
    },
    props: [
      // 'placeholder',
      'attrName',
      'departmentLocationCode',
      'row'
    ],
    methods: {
      remoteMethodDepartmentLocation (query) {
        this.getDepartmentLocations({ meaning: '', keyword: query });
      },
      getDepartmentLocations (params) {
        this.loading = true;
        axios.get(`/ir/ajax/lov/department-location`, { params })
        .then(({data}) => {
          let response = data.data
          this.loading = false;
          this.departmentLocations = response;
        })
        .catch((error) => {
          swal('Error', error, 'error')
        })
      },
      focusDepartmentLocation (event) {
        this.getDepartmentLocations({ meaning: '', keyword: '' });
      },
      changeDepartmentLocation (value) {
        if (value) {
          for (let i in this.departmentLocations) {
            let location = this.departmentLocations[i]
            if (location.meaning === value) {
              this.row.department_location_code = value
              this.row.department_location_desc = location.description
            }
          }
        } else {
          this.row.department_location_code = ''
          this.row.department_location_desc = ''
        }
      }
    },
    mounted() {
      this.getDepartmentLocations({ meaning: '', keyword: '' })
    },
    watch: {
      'departmentLocationCode' (newVal, oldVal) {
        this.department_location_code = newVal;
      }
    }
  }
</script>

