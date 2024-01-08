<template>
  <div>
    <el-form  
      :model="search"
      ref="search_stock_monthly" 
      label-width="120px" 
      class="demo-ruleForm">
      <div class="row">
        <div class="col-lg-6">
          <div class="row">
            <label class="col-lg-5 col-md-4 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>ปี</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item prop="period_year">
                <el-select
                  style="width: 100%;"
                  v-model="search.period_year"
                  placeholder="ปี"
                  name="period_year"
                  :clearable="true"
                  @change="changeYear">
                  <el-option  
                    v-for="(data, index) in years"
                    :key="index"
                    :label="showYearBE('year', data)"
                    :value="data">
                  </el-option>
                </el-select>
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-lg-5 col-md-4 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>กรมธรรม์ชุดที่</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item>
                <el-select
                  style="width: 100%;"
                  v-model="search.policy_set_header_id"
                  placeholder="กรมธรรม์ชุดที่"
                  name="policy_set_header_id"
                  :remote-method="remoteMethodPolicySt"
                  :loading="loading"
                  remote
                  :clearable="true"
                  @focus="focusPolicySt"
                  filterable
                  @change="changePolicySt">
                  <el-option
                    v-for="(data, index) in policies"
                    :key="index"
                    :label="data.policy_set_number + ': ' + data.policy_set_description"
                    :value="data.policy_set_header_id">
                  </el-option>
                </el-select>
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-lg-5 col-md-4 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>ตั้งแต่รหัสหน่วยงาน</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item>
                <lov-department 
                  v-model="search.department_from"
                  placeholder="ตั้งแต่รหัสหน่วยงาน"
                  attrName="department_from"
                  @change-lov="getValueDepartmentFrom" />
              </el-form-item>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="row">
            <label class="col-lg-4 col-md-3 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>เดือนปิดบัญชี</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item prop="period_name">
                <el-select
                  style="width: 100%;"
                  v-model="search.period_name"
                  placeholder="เดือนปิดบัญชี"
                  name="period_name"
                  :clearable="true"
                  @change="changeMonth">
                  <el-option
                    v-for="(data, index) in months"
                    :key="index"
                    :label="data.month_th_format"
                    :value="data.month_th_format">
                  </el-option>
                </el-select>
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-lg-4 col-md-3 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>สถานะ</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item prop="type_cost">
                <dropdown-status-ir
                  v-model="search.status"
                  name="status"
                  size=""
                  :popperBody="true"
                  :disabled="false"
                  placeholder="สถานะ"
                  @change-lov="getValueStatus" />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-lg-4 col-md-3 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>ถึง</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item>
                <lov-department
                  v-model="search.department_to"
                  placeholder="ถึงรหัสหน่วยงาน"
                  attrName="department_to"
                  @change-lov="getValueDepartmentTo" />
              </el-form-item>
            </div>
          </div>
        </div>
      </div>
      <div class="text-right el_field">
        <el-form-item>
          <button type="button" class="btn btn-default" @click="clickSearch()">
            <i class="fa fa-search"></i> ค้นหา
          </button>
          <button type="button" 
                  class="btn btn-success"
                  data-toggle="modal"
                  :data-target="`#modal_stock_monthly_fetch`"
                  @click="clickFetch()" >
            <i class="fa fa-database"></i> ดึงข้อมูล
          </button>
          <button type="button" class="btn btn-warning" @click="clickCancel()">
            <i class="fa fa-repeat"></i> รีเซต
          </button>
        </el-form-item>
      </div>
    </el-form>
    <modal-fetch 
      :setYearCE="setYearCE"
      ref="modal_fetch"
      @fetch-table-header="fetchTableHeader"
      :showYearBE="showYearBE" />
  </div>
</template>

<script>
  import lovDepartment from './lovDepartment'
  import yearInput from '../components/calendar/yearInput'
  import monthYearInput from '../components/calendar/monthYearInput'
  import modalFetch from './moalFetch'
  import dropdownStatusIr from '../components/dropdown/statusIr'
  export default {
    name: 'ir-stock-monthly-index-search',
    data () {
      return {
        rules: {
          period_year: [
            {required: true, message: 'กรุณาระบุปี', trigger: 'change'}
          ],
          period_name: [
            {required: true, message: 'กรุณาระบุเดือน', trigger: 'change'}
          ]
        },
        defaultRowTotal: {
          department_code: '',
          department_desc: '',
          document_number: '',
          period_from: '',
          period_to: '',
          policy_set_description: '',
          policy_set_header_id: '',
          status: '',
          year: '',
          inventory_desc: 'Inventory',
          inventory_amount: '',
          inventory_cover_amount: '',
          inventory_insu_amount: '',
          manual_desc: 'Manual',
          manual_amount: '',
          manual_cover_amount: '',
          manual_insu_amount: '',
          total_desc: 'Total',
          total_amount: '',
          total_cover_amount: '',
          total_insu_amount: '',
          inventory_duty_amount: '',
          inventory_vat_amount: '',
          inventory_net_amount: '',
          manual_duty_amount: '',
          manual_vat_amount: '',
          manual_net_amount: '',
          total_duty_amount: '',
          total_vat_amount: '',
          total_net_amount: ''
        },
        policies: [],
        loading: false,
        period_name: [],
        // months: 12,
        budget_period_year: [],
        months: [],
        years: []
      }
    },
    props: [
      'search',
      // 'yearTh',
      // 'status',
      'showYearBE',
      'setYearCE'
    ],
    computed: {},
    methods: {
      clickSearch () {
        this.$refs.search_stock_monthly.validate((valid) => {
          if (valid) {
            let data = {
              search: this.search,
              rowTotal: this.defaultRowTotal
            }
            this.$emit('click-search', data)
          } else {
            return false;
          }
        })
      },
      clickClear () {
        window.location.href = '/ir/stocks/monthly'
      },
      changePeriodYear (value) {
        this.$emit('change-period-year', value)
      },
      changeYear (value) {
        this.search.period_year = value
        if (value) {
          this.months = this.budget_period_year.filter((row) => {
            if (value === row.period_year) {
              return row
            }
          })
        } else {
          this.months = []
        }
        this.search.period_name = ''
        this.search.data_month = ''
      },
      // changeYear (obj) {
      //   this.search.period_year = obj.value
      //   this.period_name = []
      //   let set_period_name = []
      //   if (obj.value) {
      //     let test = ''
      //     let set = []
      //     for (let i = 1; i <= this.months; i++) {
      //       let num = i.toString()
      //       if (num.length === 1) {
      //         test = `01/0${num}/${obj.value}`
      //       } else {
      //         let year = +num > 9 && +num <= 12 ? +obj.value - 1 : obj.value
      //         test = `01/${num}/${year}`
      //       }
      //       set.push(test)
      //     }
      //     let test1 = set => {
      //       let test2 = (a, b) => {
      //         return new Date(a).getTime() - new Date(b).getTime();
      //       }
      //       set.sort(test2);
      //     };
      //     test1(set);
      //     set.filter((row) => {
      //       let arr = row.split('/')
      //       return set_period_name.push(`${arr[1]}/${arr[2]}`)
      //     })
      //     this.period_name = set_period_name
      //   }
      // },
      changeMonth (value) {
        this.search.period_name = value
        if (value) {
          this.months.filter((row) => {
            if (value === row.month_th_format) {
              this.search.data_month = row.bef_month_th_format
            }
          })
        } else {
          this.search.data_month = ''
        }
        // if (value) {
        //   let arrMonth = value.split('/')
        //   let month = +arrMonth[0] === 1 ? '12' : +arrMonth[0] - 1
        //   let year = +month === 12 ? +arrMonth[1] - 1 : arrMonth[1]
        //   this.search.data_month = `${month}/${year}`
        // } else {
        //   this.search.data_month = ''
        // }
        //  
        // // this.search.period_name = obj.value
      },
      changeDataMonth (obj) {
        this.search.data_month = obj.value
      },
      getDataPolicySetHeaderId (params) {
        this.loading = true;
        axios.get(`/ir/ajax/lov/policy-set-header`, { params })
        .then(({data}) => {
          this.loading = false;
          this.policies = data.data
        })
        .catch((error) => {
          swal("Error", error, "error");
        })
      },
      remoteMethodPolicySt (query) {
        this.getDataPolicySetHeaderId({
          policy_set_header_id: '',
          keyword: query,
          type: '10',
          type2: ''
        })
      },
      focusPolicySt (event) {
        this.getDataPolicySetHeaderId({
          policy_set_header_id: '',
          keyword: '',
          type: '10',
          type2: ''
        })
      },
      changePolicySt (value) {
        this.search.policy_set_header_id = value
      },
      clickCancel () {
        window.location.href = '/ir/stocks/monthly'
      },
      getDataBudgetPeriodYear () {
        axios.get(`/ir/ajax/lov/budget-period-year`)
        .then(({data}) => {
          this.budget_period_year = data.data
        })
        .catch((error) => {
          swal("Error", error, "error");
        })
      },
      unique () {
        var result = [];
        $.each(this.budget_period_year, function(i, e) {
          if ($.inArray(e.period_year, result) == -1) result.push(e.period_year);
        });
        return result;
      },
      getValueDepartmentFrom (value) {
        this.search.department_from = value
      },
      getValueDepartmentTo (value) {
        this.search.department_to = value
      },
      fetchTableHeader (dataRows) {
        this.$emit('fetch-show-table-header', dataRows)
      },
      clickFetch () {
        this.$refs.modal_fetch.resetFields()
      },
      getValueStatus (value) {
        this.search.status = value;
      }
    },
    components: {
      lovDepartment,
      // yearInput,
      // monthYearInput,
      modalFetch,
      dropdownStatusIr
    },
    mounted () {
      this.getDataPolicySetHeaderId({
        policy_set_header_id: '',
        keyword: '',
        type: '10',
        type2: ''
      })
    },
    watch: {
      'budget_period_year' (newVal, oldVal) {
        if (newVal.length > 0) {
          this.years = this.unique()
        }
      }
    },
    created () {
      this.getDataBudgetPeriodYear()
    }
  }
</script>

<style>
  .el-form-item__content{
    line-height: 40px;
    position: relative;
    font-size: 14px;
    margin-left: 0px !important;
  }
</style>

