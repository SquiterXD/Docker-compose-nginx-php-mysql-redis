<template>
  <div class="el_select">
    <el-select  v-model="result"
                placeholder="Budget Detail"
                :name="attrName"
                @change="change"
                :popper-append-to-body="false"
                :clearable="true"
                :remote-method="remoteMethod"
                :loading="loading"
                :disabled='disabled'
                remote
                filterable
                @focus="focus">
      <el-option  v-for="(data, index) in dataRows"
                  :key="index"
                  :label="data.budget_detail + ': ' + data.meaning"
                  :value="data.budget_detail">
      </el-option>
    </el-select>
  </div>
</template>

<script>
  export default {
    name: 'ir-components-lov-segments-lov-sub-account', // ไม่มี description
    data () {
      return {
        dataRows: [],
        loading: false,
        result: this.value,
        budget_type: ''
      }
    },
    props: [
      'attrName',
      'value',
      'budgetType',
      'disabled'
    ],
    methods: {
      remoteMethod (query) {
        this.getDataRows({
          budget_detail: '',
          keyword: query,
          budget_type: this.budget_type
        });
      },
      getDataRows (params) {
        this.loading = true;
        axios.get(`/ir/ajax/lov/budget-detail`, { params })
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
          budget_detail: '',
          keyword: '',
          budget_type: this.budget_type
        });
      },
      change (value) {
        if (value) {
          for (let i in this.dataRows) {
            let row = this.dataRows[i]
            if (row.budget_detail === value) {
              let data = {
                value: value,
                desc: row.meaning
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
      this.budget_type = this.budgetType
      this.getDataRows({
        budget_detail: '',
        keyword: '',
        budget_type: this.budget_type
      });
    },
    watch: {
      'value' (newVal, oldVal) {
        this.result = newVal;
        // this.getDataRows({
        //   budget_detail: newVal,
        //   keyword: '',
        //   budget_type: this.budget_type
        // });
      },
      'budgetType' (newVal, oldVal) {
        this.budget_type = newVal
        this.getDataRows({
          budget_detail: '',
          keyword: '',
          budget_type: newVal
        });
      }
    }
  }
</script>

