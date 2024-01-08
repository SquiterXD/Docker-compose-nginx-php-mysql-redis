<template>
  <div class="el_select">
    <el-select  v-model="result"
                placeholder="Cost Center"
                :name="attrName"
                @change="change"
                :popper-append-to-body="false"
                :clearable="true"
                :remote-method="remoteMethod"
                :loading="loading"
                remote
                filterable
                :disabled='disabled'
                @focus="focus">
      <el-option  v-for="(data, index) in dataRows"
                  :key="index"
                  :label="data.meaning + ': ' + data.description"
                  :value="data.cost_center_code">
      </el-option>
    </el-select>
  </div>
</template>

<script>
  export default {
    name: 'ir-components-lov-segments-lov-product',
    data () {
      return {
        dataRows: [],
        loading: false,
        result: this.value,
        department_code: ''
      }
    },
    props: [
      'attrName',
      'value',
      'departmentCode',
      'disabled'
    ],
    methods: {
      remoteMethod (query) {
        this.getDataRows({
          cost_center_code: '',
          keyword: query,
          department_code: this.department_code
        });
      },
      getDataRows (params) {
        this.loading = true;
        axios.get(`/ir/ajax/lov/cost-center-code`, { params })
        .then(({data}) => {
          let response = data.data
          this.loading = false;
          this.dataRows = response;
        })
        .catch((error) => {
          swal('Error', error, 'error')
        })
      },
      focus (event) {
        this.getDataRows({
          cost_center_code: '',
          keyword: '',
          department_code: this.department_code
        });
      },
      change (value) {
        if (value) {
          for (let i in this.dataRows) {
            let row = this.dataRows[i]
            if (row.cost_center_code === value) {
              let data = {
                value: value,
                desc: row.description
              }
              this.$emit('change-lov-segment', data)
              return
            }
          }
        }
        let data = {
          value: value,
          desc: ''
        }
        this.$emit('change-lov-segment', data)
      }
    },
    mounted() {
      this.department_code = this.departmentCode
      this.getDataRows({
        cost_center_code: '',
        keyword: '',
        department_code: this.department_code
      });
    },
    watch: {
      'value' (newVal, oldVal) {
        this.result = newVal;
        // this.getDataRows({
        //   cost_center_code: newVal,
        //   keyword: '',
        //   department_code: this.department_code
        // });
      },
      'departmentCode' (newVal, oldVal) {
        this.department_code = newVal
        this.getDataRows({
          cost_center_code: '',
          keyword: '',
          department_code: newVal
        });
      }
    }
  }
</script>

