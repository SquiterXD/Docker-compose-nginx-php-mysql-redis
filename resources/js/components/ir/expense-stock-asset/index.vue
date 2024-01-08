<template>
  <div v-loading="showLoading">
    <expense-search :search="search"
                    @click-search="getDataSearch"
                    @get-value-month="getValueMonth"
                    @fetch-show-table-header="fetchShowTableHeader"
                    :showYearBE="funcs.showYearBE"
                    :setYearCE="funcs.setYearCE"
                    :vars="vars" />
    <expense-table-total  :tableTotal="tableTotal"
                          :formatCurrency="funcs.formatCurrency" />
    <expense-table-line :setFirstLetterUpperCase="funcs.setFirstLetterUpperCase"
                        :isNullOrUndefined="funcs.isNullOrUndefined"
                        :formatCurrency="funcs.formatCurrency"
                        :tableLineAll="tableLineAll"
                        :form="form"
                        :expense_id="expense_id"
                        :checkStatusInterface="funcs.checkStatusInterface"
                        :checkStatusCancelled="funcs.checkStatusCancelled"
                        :vars="vars"
                        :setValuePeriodNameFormat="funcs.setValuePeriodNameFormat"
                        :perPage="per_page"
                        @toggle-loading="toggleLoading"
                        ref="tableline"
                        />
                        <!-- @click-row="getDataShowTableTotal" -->
  </div>
</template>

<script>
  import search from './search'
  import tableTotal from './tableTotal'
  import tableLine from './tableLine'
  import * as scripts from '../scripts'
  export default {
    name: 'ir-expense-stock-asset-index',
    data() {
      return {
        tableLineAll: [],
        form: {
          tableLine: []
        },
        search: {
          month: '',
          expense_type_code: '',
          expense_type_meaning: '',
          policy_set_header_id: '',
          status: '',
          period_name: ''
        },
        tableTotal: [],
        account_code_combine: [],
        expenseTypeCode: [],
        expense_id: '',
        funcs: scripts.funcs,
        vars: scripts.vars,
        showLoading: false,
        per_page: 100,
      };
    },
    methods: {
      toggleLoading(value){
        this.showLoading = value;
      },
      getTableLine () {
        this.showLoading = true
        let params = {
          // year: this.setYearCE('year', this.search.year),
          // year: this.search.year,
          month: this.funcs.setYearCE('month', this.search.month),
          type: this.search.expense_type_code,
          policy_set_header_id: this.search.policy_set_header_id,
          status: this.search.status,
          period_name: this.funcs.setYearCE('month', this.search.period_name)
        }
        axios.get(`/ir/ajax/expense-asset-stock`, { params })
        .then(({data}) => {
          this.showLoading = false
          this.tableLineAll = this.setPropertyTableLine(data.data);
          let filterSearch = this.tableLineAll.filter((row, index) => {return row;});
          this.form.tableLine = filterSearch;
          if (this.form.tableLine.length === 0) this.tableTotal = [];
        })
        .catch((error) => {
          swal("Error", error, "error");
        })
      },
      getDataSearch (obj) {
        this.search = obj
        this.getTableLine()
      },
      getDataShowTableTotal (dataRow) {
        this.tableTotal = [dataRow]
      },
      getDaysInMonth (value) {
        if (value) {
          let arrMonth = value.split('/')
          let setMonth = +arrMonth[0]
          let setYearCE = +arrMonth[1]
          return new Date(setYearCE, setMonth, 0).getDate()
        }
        return ''
      },
      getValueMonth (value) {
        this.search.month = value
      },
      setPropertyTableLine (array) {
        return array.filter((row, index) => {
          this.expense_id = row.expense_id
          // // let insurance_amount = row.insurance_amount === '' || row.insurance_amount === null || row.insurance_amount === undefined ? 0 : +row.insurance_amount
          // let dayOfMonth = row.day === '' || row.day === null || row.day === undefined ? 0 : +row.day
          // let qtyDaysRemain = row.remain_day === '' || row.remain_day === null || row.remain_day === undefined ? 0 : +row.remain_day
          // // let coverage_amount = row.coverage_amount === '' || row.coverage_amount === null || row.coverage_amount === undefined ? 0 : +row.coverage_amount
          // let net_amount = row.net_amount === '' || row.net_amount === null || row.net_amount === undefined ? 0 : +row.net_amount
          // // let premium_rate = row.premium_rate === '' || row.premium_rate === null || row.premium_rate === undefined ? 0 : +row.premium_rate
          // let params = {
          //   // insurance_amount: insurance_amount,
          //   dayOfMonth: dayOfMonth,
          //   qtyDaysRemain: qtyDaysRemain,
          //   // coverage_amount: coverage_amount,
          //   net_amount: net_amount,
          //   // premium_rate: premium_rate
          // }
          row.sector_code = row.expense_type_code === 'ASSET001' ? row.sector_code : (row.flag === 'ASSET001' ? row.department_code : '')
          row.sector_name = row.expense_type_code === 'ASSET001' ? row.sector_name : (row.flag === 'ASSET001' ? row.department_name : '')
          row.department_code = row.department_cost_code ?? row.department_code
          row.department_name =  row.department_cost_desc ?? row.department_name
          row.insurance_premium = row.insurance_premium ?? row.premium_rate
          // this.getAccountIdSetDesc(row, 'expense_account_id', 'expense_account', 'expense_account_desc') // , 'expense_account_id'
          // this.getAccountIdSetDesc(row, 'prepaid_account_id', 'prepaid_account', 'prepaid_account_desc') // , 'prepaid_account_id'
          // // // row.insurance_amount = insurance_amount * dayOfMonth / 365
          // // // this.calCoverageAmount(row, params)
          // // // this.calInsuranceAmount(row, params)
          // // this.calNetAmount(row, params)
          row.program_code = 'IRP0008'
          let insurance_amount = row.insurance_amount || row.insurance_amount === 0 ? +row.insurance_amount : 0
          let insurance_amount_cal = row.insurance_amount_cal || row.insurance_amount_cal === 0 ? +row.insurance_amount_cal : 0
          row.net_amount = insurance_amount + insurance_amount_cal
          row.rowId = index
          return row
        })
      },
      getAccountCodeCombine () {
        let params = {
          account_id: '',
          keyword: ''
        }
        axios.get(`/ir/ajax/lov/account-code-combine`, { params })
        .then(({data}) => {
          this.account_code_combine = data.data
          // this.getTableLine()
        })
        .catch(error => {
          swal("Error", error, "error");
        })
      },
      getAccountIdSetDesc (dataRow, account_id, propCode, propDesc, propId) {
        this.account_code_combine.filter((account) => {
          if (dataRow[account_id] && account.account_id && +dataRow[account_id] === +account.account_id) {
            dataRow[propCode] = account.account_combine
            dataRow[propDesc] = account.account_combine_desc
            // dataRow[propId] = account.account_combine_desc
            return dataRow
          }
        })
        return dataRow
      },
      calCoverageAmount (dataRow, setParams) {
        if (dataRow.flag === 'STOCK001') {
          dataRow.coverage_amount_cal = setParams.coverage_amount 
        } else if (dataRow.flag === 'ASSET001') {
          dataRow.coverage_amount_cal = setParams.insurance_amount * setParams.dayOfMonth / setParams.qtyDaysRemain
        }
        return dataRow
      },
      calInsuranceAmount (dataRow, setParams) {
        if (dataRow.flag === 'STOCK001') {
          dataRow.insurance_amount_cal = setParams.insurance_amount 
        } else if (dataRow.flag === 'ASSET001') {
          dataRow.insurance_amount_cal = setParams.coverage_amount * 0.08 * setParams.dayOfMonth / setParams.qtyDaysRemain
          // dataRow.insurance_amount_cal = setParams.coverage_amount * setParams.premium_rate * setParams.dayOfMonth / setParams.qtyDaysRemain
        }
        return dataRow
      },
      calNetAmount (dataRow, setParams) {
        if (dataRow.flag === 'STOCK001') {
          dataRow.net_amount = setParams.net_amount 
        } else if (dataRow.flag === 'ASSET001') {
          dataRow.net_amount = setParams.net_amount * setParams.dayOfMonth / setParams.qtyDaysRemain
        }
        return dataRow
      },
      getExpenseTypeCode () {
        return this.form.tableLine.filter((line) => {
          this.expenseTypeCode.filter((row) => {
            if (line.flag === row.lookup_code) {
              line.expense_type_code = row.lookup_code
              line.expense_type_desc = row.description
              return line
            }
          })
        })
      },
      getDataExpenseType () {
        let params = {
          lookup_code: '',
          keyword: ''
        }
        axios.get(`/ir/ajax/lov/exp-asset-stock-type`, { params })
        .then(({data}) => {
          this.expenseTypeCode = data.data
        })
        .catch((error) => {
          swal("Error", error, "error");
        })
      },
      calTableTotal () {
        let total_coverage_amount = 0
        let total_insu_amount = 0
        let total_coverage_amount_cal = 0
        let total_insurance_amount_cal = 0
        let total_net_amount = 0
        total_coverage_amount = this.form.tableLine.reduce((sum, number) => {
          if (number.coverage_amount === '' || number.coverage_amount === null || number.coverage_amount === undefined) {
            return sum + 0
          }
          return sum + parseFloat(number.coverage_amount)
        }, 0)
        total_insu_amount = this.form.tableLine.reduce((sum, number) => {
          if (number.insurance_amount === '' || number.insurance_amount === null || number.insurance_amount === undefined) {
            return sum + 0
          }
          return sum + parseFloat(number.insurance_amount)
        }, 0)
        total_coverage_amount_cal = this.form.tableLine.reduce((sum, number) => {
          if (number.coverage_amount_cal === '' || number.coverage_amount_cal === null || number.coverage_amount_cal === undefined) {
            return sum + 0
          }
          return sum + parseFloat(number.coverage_amount_cal)
        }, 0)
        total_insurance_amount_cal = this.form.tableLine.reduce((sum, number) => {
          if (number.insurance_amount_cal === '' || number.insurance_amount_cal === null || number.insurance_amount_cal === undefined) {
            return sum + 0
          }
          return sum + parseFloat(number.insurance_amount_cal)
        }, 0)
        total_net_amount = this.form.tableLine.reduce((sum, number) => {
          if (number.net_amount === '' || number.net_amount === null || number.net_amount === undefined) {
            return sum + 0
          }
          return sum + parseFloat(number.net_amount)
        }, 0)
        this.tableTotal = [{
          total_cover_amount: total_coverage_amount,
          total_insu_amount: total_insu_amount,
          coverage_amount_cal: total_coverage_amount_cal,
          insurance_amount_cal: total_insurance_amount_cal,
          net_amount: total_net_amount
        }]
      },
      fetchShowTableHeader (data) {
        this.search.policy_set_header_id = '';
        this.search.status = '';
        this.showLoading = true;
        this.tableLineAll = this.setPropertyTableLine(data);
        let filterSearch = this.tableLineAll.filter((row, index) => {return row;});
        this.form.tableLine = filterSearch;
        this.$refs.tableline.complete = true;
        if (this.form.tableLine.length === 0) this.tableTotal = []
        setTimeout(() => {
          this.showLoading = false;
        }, 5000);
      },
    },
    components: {
      'expense-search': search,
      'expense-table-total': tableTotal,
      'expense-table-line': tableLine
    },
    watch: {
      'search.month' (newVal, oldVal) {
        if (newVal) {
          this.getDaysInMonth(newVal)
        }
      },
      'form.tableLine' (newVal, oldVal) {
        if (newVal.length > 0) {
          this.getExpenseTypeCode()
          this.calTableTotal()
        } else {
          this.tableTotal = []
        }
      },
    },
    created () {
      this.getAccountCodeCombine()
      // this.getTableLine()
      this.getDataExpenseType()
    }
  }
</script>