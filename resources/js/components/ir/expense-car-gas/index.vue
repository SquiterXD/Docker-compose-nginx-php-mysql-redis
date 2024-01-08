<template>
  <div v-loading = loading>
    <expense-search :search="search"
                    :showYearBE="funcs.showYearBE"
                    @click-search="getDataSearch"
                    @fetch-show-table-header="fetchShowTableHeader"
                    :setYearCE="funcs.setYearCE"
                    :vars="vars" />
    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
          <tr class="text-center">
            <th width="120px"></th>
            <th style="padding-right: 120px;">Total Net Amount<br> ค่าเบี้ยประกันสุทธิต่อเดือนรวม </th>
          </tr>
        </thead>
        <tbody id="table_search">
          <tr class="text-center"
              v-show="tableTotal.length > 0"
              v-for="(data, index) in tableTotal"
              :key="index">
              <td style="font-weight: bold;">{{ data.group_name }}</td>
              <td style="padding-right: 120px;">{{setZeroWhenIsNullOrUndefined(data.net_amount)}}</td>
          </tr>
          <tr class="text-center" v-if="tableTotal.length === 0"><td colspan="2">ไม่มีข้อมูล</td></tr>
        </tbody>
        <tfoot></tfoot>
      </table>
    </div>
    <expense-table-line :form="form"
                        :setFirstLetterUpperCase="funcs.setFirstLetterUpperCase"
                        :isNullOrUndefined="funcs.isNullOrUndefined"
                        :showYearBE="funcs.showYearBE"
                        :formatCurrency="funcs.formatCurrency"
                        :formatfloat="funcs.formatfloat"
                        :expense_id="expense_id"
                        :checkStatusInterface="funcs.checkStatusInterface"
                        :checkStatusCancelled="funcs.checkStatusCancelled"
                        :vars="vars"
                        @show-loading="showLoading"
                        :setValuePeriodNameFormat="funcs.setValuePeriodNameFormat"
                        ref="tableline"
                        />
  </div>
</template>

<script>
  import search from './search'
  import tableLine from './tableLine'
  import * as scripts from '../scripts'
  export default {
    name: 'ir-expense-car-gas-index',
    data() {
      return {
        tableTotal: [],
        search: {
          year: '',
          month: '',
          expense_type_code: '',
          group_code: '',
          gas_station_type: '',
          license_plate: '',
          renew_type: '',
          status: '',
          period_name: ''
        },
        form: {
          tableLine: [],
        },
        account_code_combine: [],
        expenseTypeCode: [],
        expense_id: '',
        funcs: scripts.funcs,
        vars: scripts.vars,
        loading: false
      };
    },
    methods: {
      getDataSearch (obj) {
        this.search = obj
        this.getTableLine()
      },
      showLoading(value){
        const vm = this;
        vm.loading = value;
      },
      getTableLine () {
        this.loading = true
        let params = {
          year: this.search.year,
          month: this.funcs.setYearCE('month', this.search.month),
          group_code: this.search.group_code,
          type_code: this.search.gas_station_type,
          status: this.search.status,
          license_plate: this.search.license_plate,
          type: this.search.expense_type_code,
          renew_type: this.search.renew_type,
          period_name: this.funcs.setYearCE('month', this.search.period_name)
        }
        axios.get(`/ir/ajax/expense-car-gas`, { params })
        .then(({data}) => {
          this.loading = false
          this.form.tableLine = this.setPropertyTableLine(data.data)
          if (this.form.tableLine.length === 0) this.tableTotal = []
        })
        .catch((error) => {
          this.loading = false
          swal("Error", error, "error");
        }).then(()=>{
          
        })
      },
      fetchShowTableHeader (data) {
        this.loading = true;
        this.form.tableLine = this.setPropertyTableLine(data)
        if (this.form.tableLine.length === 0) this.tableTotal = []
        setTimeout(() => {
          this.loading = false;
        }, 2000);
      },
      setPropertyTableLine (array) {
        return array.filter((row, index) => {
          // this.expense_id = row.expense_id
          // let insurance_amount = row.insurance_amount === '' || row.insurance_amount === null || row.insurance_amount === undefined ? 0 : +row.insurance_amount
          // let dayOfMonth = row.day === '' || row.day === null || row.day === undefined ? 0 : +row.day
          // let qtyDaysRemain = row.remain_day === '' || row.remain_day === null || row.remain_day === undefined ? 0 : +row.remain_day
          // let net_amount = row.net_amount === '' || row.net_amount === null || row.net_amount === undefined ? 0 : +row.net_amount
          // let discount = row.discount === '' || row.discount === null || row.discount === undefined ? 0 : +row.discount
          // let duty_amount =  row.duty_amount === '' || row.duty_amount === null || row.duty_amount === undefined ? 0 : +row.duty_amount
          // let params = {
          //   insurance_amount: insurance_amount,
          //   dayOfMonth: dayOfMonth,
          //   qtyDaysRemain: qtyDaysRemain,
          //   net_amount: net_amount,
          //   discount: discount,
          //   duty_amount: duty_amount
          // }
          // // this.getAccountIdSetDesc(row, 'expense_account_id', 'expense_account', 'expense_account_desc') // , 'expense_account_id'
          // // this.getAccountIdSetDesc(row, 'prepaid_account_id', 'prepaid_account', 'prepaid_account_desc') // , 'prepaid_account_id'
          // this.calNetAmount(row, params)
          row.program_code = 'IRP0009'
          row.gas_station_type_name = row.gas_station_type_name ?? row.type_name
          row.gas_station_type_code = row.gas_station_type_code ?? row.type_code
          row.document_line_id = '' // หลังบ้านให้ส่งเป็นว่างได้
          row.rowId = index
          return row
        })
      },
      // getAccountIdSetDesc (dataRow, account_id, propCode, propDesc, propId) {
      //   this.account_code_combine.filter((account) => {
      //     if (dataRow[account_id] && account.account_id && +dataRow[account_id] === +account.account_id) {
      //       dataRow[propCode] = account.account_combine
      //       dataRow[propDesc] = account.account_combine_desc
      //       // dataRow[propId] = account.account_combine_desc
      //       return dataRow
      //     }
      //   })
      //   return dataRow
      // },
      getAccountCodeCombine () {
        let params = {
          account_id: '',
          keyword: ''
        }
        axios.get(`/ir/ajax/lov/account-code-combine`, { params })
        .then(({data}) => {
          this.account_code_combine = data.data
        })
        .catch(error => {
          swal("Error", error, "error");
        })
      },
      setZeroWhenIsNullOrUndefined (value) {
        if (value === '' || value === null || value === undefined) {
          return this.funcs.formatCurrency('0')
        }
        return this.funcs.formatCurrency(value)
      },
      calTableTotal () {
        let _this = this;
        let find = null;
        let amount = 0;
        let total_net_amount = 0;
        this.tableTotal = [];

        _this.form.tableLine.forEach((item) => {
          amount = (Math.round(item.net_amount * 100) / 100);
          find = null;
          find = _this.tableTotal.find((search)=>{
            return search.group_name == item.group_name;
          });

          if(find){
            find.net_amount += amount;
          }else {
            _this.tableTotal.push({
              group_name: item.group_name,
              net_amount: amount,
            });
          }
          total_net_amount += amount;
        });

        // if(this.tableTotal.length == 1){
        //   this.tableTotal = [{
        //     group_name: 'Total',
        //     net_amount: total_net_amount
        //   }];
        // }else {
          this.tableTotal.push({
            group_name: 'Total',
            net_amount: total_net_amount
          });
        // }
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
      calNetAmount (dataRow, setParams) {
        if (dataRow.vat_refund === 'Y') {
          dataRow.net_amount = setParams.insurance_amount - setParams.discount + setParams.duty_amount * setParams.dayOfMonth / 365
        } else if (dataRow.vat_refund === 'N') {
          dataRow.net_amount = setParams.net_amount * setParams.dayOfMonth / 365
        }
        return dataRow
      },
      getDataExpenseType () {
        let params = {
          lookup_code: '',
          keyword: ''
        }
        axios.get(`/ir/ajax/lov/exp-car-gas-type`, { params })
        .then(({data}) => {
          this.expenseTypeCode = data.data
          // this.getTableLine()
        })
        .catch((error) => {
          swal("Error", error, "error");
        })
      }
    },
    components: {
      'expense-search': search,
      'expense-table-line': tableLine
    },
    watch: {
      'form.tableLine' (newVal, oldVal) {
        if (newVal.length > 0) {
          this.getExpenseTypeCode()
          this.calTableTotal()
        } else {
          this.tableTotal = []
        }
      }
    },
    created () {
      this.getDataExpenseType()
      // this.getAccountCodeCombine()
      // this.getTableLine()
    }
  }
</script>