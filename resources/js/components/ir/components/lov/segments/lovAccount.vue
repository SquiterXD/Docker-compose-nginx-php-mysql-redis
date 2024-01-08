<template>
  <div class="el_select">
    <el-select  v-model="result"
                placeholder="Budget Type"
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
                  :value="data.budget_type">
      </el-option>
    </el-select>
  </div>
</template>

<script>
  export default {
    name: 'ir-components-lov-segments-lov-account',
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
          budget_type: '',
          keyword: query
        });
      },
      getDataRows (params) {
        this.loading = true;
        axios.get(`/ir/ajax/lov/budget-type`, { params })
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
          budget_type: '',
          keyword: ''
        });
      },
      change (value) {
         
        if (value) {
          for (let i in this.dataRows) {
            let row = this.dataRows[i]
             
            if (row.budget_type === value) {
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
        budget_type: '',
        keyword: ''
      });
    },
    watch: {
      'value' (newVal, oldVal) {
        this.result = newVal;
        this.getDataRows({
          budget_type: newVal,
          keyword: ''
        });
      }
    }
  }
</script>

