<template>
  <div class="el_select">
    <el-select  v-model="result"
                placeholder="Department"
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
                  :value="data.department_code">
      </el-option>
    </el-select>
  </div>
</template>

<script>
  export default {
    name: 'ir-components-lov-segments-lov-department',
    data () {
      return {
        dataRows: [],
        loading: false,
        result: this.value
      }
    },
    props: [
      'attrName',
      'value',
      'disabled'
    ],
    methods: {
      remoteMethod (query) {
        this.getDataRows({
          department_code: '',
          keyword: query
        });
      },
      getDataRows (params) {
        this.loading = true;
        axios.get(`/ir/ajax/lov/department-code`, { params })
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
          department_code: '',
          keyword: ''
        });
      },
      change (value) {
         
        if (value) {
          for (let i in this.dataRows) {
            let row = this.dataRows[i]
             
            if (row.department_code === value) {
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
      this.getDataRows({
        department_code: '',
        keyword: ''
      });
    },
    watch: {
      'value' (newVal, oldVal) {
        this.result = this.value;
        this.getDataRows({
          department_code: this.result,
          keyword: this.result
        });
      }
    }
  }
</script>

