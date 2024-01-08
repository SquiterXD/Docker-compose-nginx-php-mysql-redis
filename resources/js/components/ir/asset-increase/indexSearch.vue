<template>
  <div>
    <el-form  :model="search"
              ref="search"
              label-width="120px"
              class="demo-ruleForm">
              <!-- :rules="rules"  -->

      <div class="row">
        <div class="col-lg-6">
          <div class="row">
            <label class="col-md-4 col-form-label lable_align">
              <strong>ปี</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item prop="year">
                <datepicker-th  style="width: 100%;"
                                class="el-input__inner"
                                :name="`year`"
                                p-type="year"
                                placeholder="ปี"
                                :value="search.year"
                                :format="vars.formatYear"
                                @dateWasSelected="getValueYear" />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-md-4 col-form-label lable_align">
              <strong>วันที่คิดค่าเบี้ย</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item prop="start_calculate_date">
                <datepicker-th  style="width: 100%;"
                                class="el-input__inner"
                                :name="`start_calculate_date`"
                                p-type="date"
                                placeholder="วันที่คิดค่าเบี้ย"
                                :value="search.start_calculate_date"
                                :format="vars.formatDate"
                                @dateWasSelected="getValueCalStDate" />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-md-4 col-form-label lable_align">
              <strong>กรมธรรม์ชุดที่</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item>
                <el-select  v-model="search.policy_set_header_id"
                            placeholder="กรมธรรม์ชุดที่"
                            name="policy_set_header_id"
                            :remote-method="remoteMethodPolicySt"
                            :loading="loading"
                            remote
                            :clearable="true"
                            @focus="focusPolicySt"
                            filterable
                            @change="changePolicySt"
                            class="w-100">
                  <el-option  v-for="(data, index) in policies"
                              :key="index"
                              :label="data.policy_set_number + ': ' + data.policy_set_description"
                              :value="data.policy_set_header_id">
                  </el-option>
                </el-select>
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-md-4 col-form-label lable_align">
              <strong>วันที่ขึ้นทะเบียน/ตัดจำหน่าย</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item prop="start_addition_date">
                <datepicker-th  style="width: 100%;"
                                class="el-input__inner style_icon_calendar"
                                :name="`start_addition_date`"
                                p-type="date"
                                placeholder="วันที่ขึ้นทะเบียน/ตัดจำหน่าย"
                                :value="search.start_addition_date"
                                :format="vars.formatDate"
                                @dateWasSelected="getValueAddiStDate" />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-md-4 col-form-label lable_align">
              <strong>สถานะ</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <dropdown-status-ir v-model="search.status"
                                  name="status"
                                  size=""
                                  :popperBody="true"
                                  :disabled="false"
                                  placeholder="สถานะ"
                                  @change-lov="getValueStatus"
                                  class="w-100" />
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="row">
            <label class="col-md-3 col-form-label lable_align">
              <strong>ครั้งที่</strong>
            </label>
            <div class="col-xl-7 col-lg-8 col-md-8 el_field">
              <el-form-item prop="revision">
                <el-select  v-model="search.revision"
                            placeholder="ครั้งที่"
                            name="revision">
                  <el-option  v-for="(data, index) in revisions"
                              :key="index"
                              :label="data.revision"
                              :value="data.revision">
                  </el-option>
                </el-select>
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-md-3 col-form-label lable_align">
              <strong>ถึง</strong>
            </label>
            <div class="col-xl-7 col-lg-8 col-md-8 el_field">
              <el-form-item prop="end_calculate_date">
                <datepicker-th  style="width: 100%;"
                                class="el-input__inner"
                                :name="`end_calculate_date`"
                                p-type="date"
                                placeholder="ถึงวันที่คิดค่าเบี้ย"
                                :value="search.end_calculate_date"
                                :format="vars.formatDate"
                                @dateWasSelected="getValueCalEnDate"
                                :disabledDateTo="search.start_calculate_date" />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-md-3 col-form-label lable_align">
              <strong>ถึง</strong>
            </label>
            <div class="col-xl-7 col-lg-8 col-md-8 el_field">
              <el-form-item>
                <el-select  v-model="search.policy_set_header_id_end"
                            placeholder="ถึงกรมธรรม์ชุดที่"
                            name="policy_set_header_id_end"
                            :remote-method="remoteMethodPolicyEn"
                            :loading="loading"
                            remote
                            :clearable="true"
                            @focus="focusPolicyEn"
                            filterable
                            @change="changePolicyEn">
                  <el-option  v-for="(data, index) in policies"
                              :key="index"
                              :label="data.policy_set_number + ': ' + data.policy_set_description"
                              :value="data.policy_set_header_id">
                  </el-option>
                </el-select>
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-md-3 col-form-label lable_align">
              <strong>ถึง</strong>
            </label>
            <div class="col-xl-7 col-lg-8 col-md-8 el_field">
              <el-form-item prop="end_addition_date">
                <datepicker-th  style="width: 100%;"
                                class="el-input__inner style_icon_calendar"
                                :name="`end_addition_date`"
                                p-type="date"
                                placeholder="ถึงวันที่ขึ้นทะเบียน/ตัดจำหน่าย"
                                :value="search.end_addition_date"
                                :format="vars.formatDate"
                                @dateWasSelected="getValueAddiEnDate"
                                :disabledDateTo="search.start_addition_date" />
              </el-form-item>
            </div>
          </div>

        </div>
      </div>

      <!-- ของเดิม -->
      <!-- <div class="col-lg-11">
        <div class="row">
          <label class="col-md-4 col-form-label lable_align">
            <strong>ปี</strong>
          </label>
          <div class="col-xl-4 col-lg-5 col-md-6 el_field">
            <el-form-item prop="year">
              <datepicker-th  style="width: 100%;"
                              class="el-input__inner"
                              :name="`year`"
                              p-type="year"
                              placeholder="ปี"
                              :value="search.year"
                              :format="vars.formatYear"
                              @dateWasSelected="getValueYear" />
            </el-form-item>
          </div>
        </div>
        <div class="row">
          <label class="col-md-4 col-form-label lable_align">
            <strong>ครั้งที่</strong>
          </label>
          <div class="col-xl-4 col-lg-5 col-md-6 el_field">
            <el-form-item prop="revision">
              <el-select  v-model="search.revision"
                          placeholder="ครั้งที่"
                          name="revision">
                <el-option  v-for="(data, index) in revisions"
                            :key="index"
                            :label="data.revision"
                            :value="data.revision">
                </el-option>
              </el-select>
            </el-form-item>
          </div>
        </div>
        <div class="row">
          <label class="col-md-4 col-form-label lable_align">
            <strong>กรมธรรม์ชุดที่</strong>
          </label>
          <div class="col-xl-4 col-lg-5 col-md-6 el_field">
            <el-form-item>
              <el-select  v-model="search.policy_set_header_id"
                          placeholder="กรมธรรม์ชุดที่"
                          name="policy_set_header_id"
                          :remote-method="remoteMethodPolicySt"
                          :loading="loading"
                          remote
                          :clearable="true"
                          @focus="focusPolicySt"
                          filterable
                          @change="changePolicySt">
                <el-option  v-for="(data, index) in policies"
                            :key="index"
                            :label="data.policy_set_number + ': ' + data.policy_set_description"
                            :value="data.policy_set_header_id">
                </el-option>
              </el-select>
            </el-form-item>
          </div>
        </div>
        <div class="row">
          <label class="col-md-4 col-form-label lable_align">
            <strong>ถึง</strong>
          </label>
          <div class="col-xl-4 col-lg-5 col-md-6 el_field">
            <el-form-item>
              <el-select  v-model="search.policy_set_header_id_end"
                          placeholder="ถึงกรมธรรม์ชุดที่"
                          name="policy_set_header_id_end"
                          :remote-method="remoteMethodPolicyEn"
                          :loading="loading"
                          remote
                          :clearable="true"
                          @focus="focusPolicyEn"
                          filterable
                          @change="changePolicyEn">
                <el-option  v-for="(data, index) in policies"
                            :key="index"
                            :label="data.policy_set_number + ': ' + data.policy_set_description"
                            :value="data.policy_set_header_id">
                </el-option>
              </el-select>
            </el-form-item>
          </div>
        </div>
        <div class="row">
          <label class="col-md-4 col-form-label lable_align">
            <strong>วันที่คิดค่าเบี้ย</strong>
          </label>
          <div class="col-xl-4 col-lg-5 col-md-6 el_field">
            <el-form-item prop="start_calculate_date">
              <datepicker-th  style="width: 100%;"
                              class="el-input__inner"
                              :name="`start_calculate_date`"
                              p-type="date"
                              placeholder="วันที่คิดค่าเบี้ย"
                              :value="search.start_calculate_date"
                              :format="vars.formatDate"
                              @dateWasSelected="getValueCalStDate" />
            </el-form-item>
          </div>
        </div>
        <div class="row">
          <label class="col-md-4 col-form-label lable_align">
            <strong>ถึง</strong>
          </label>
          <div class="col-xl-4 col-lg-5 col-md-6 el_field">
            <el-form-item prop="end_calculate_date">
              <datepicker-th  style="width: 100%;"
                              class="el-input__inner"
                              :name="`end_calculate_date`"
                              p-type="date"
                              placeholder="ถึงวันที่คิดค่าเบี้ย"
                              :value="search.end_calculate_date"
                              :format="vars.formatDate"
                              @dateWasSelected="getValueCalEnDate"
                              :disabledDateTo="search.start_calculate_date" />
            </el-form-item>
          </div>
        </div>
        <div class="row">
          <label class="col-md-4 col-form-label lable_align">
            <strong>วันที่ขึ้นทะเบียน/ตัดจำหน่าย</strong>
          </label>
          <div class="col-xl-4 col-lg-5 col-md-6 el_field">
            <el-form-item prop="start_addition_date">
              <datepicker-th  style="width: 100%;"
                              class="el-input__inner style_icon_calendar"
                              :name="`start_addition_date`"
                              p-type="date"
                              placeholder="วันที่ขึ้นทะเบียน/ตัดจำหน่าย"
                              :value="search.start_addition_date"
                              :format="vars.formatDate"
                              @dateWasSelected="getValueAddiStDate" />
            </el-form-item>
          </div>
        </div>
        <div class="row">
          <label class="col-md-4 col-form-label lable_align">
            <strong>ถึง</strong>
          </label>
          <div class="col-xl-4 col-lg-5 col-md-6 el_field">
            <el-form-item prop="end_addition_date">
              <datepicker-th  style="width: 100%;"
                              class="el-input__inner style_icon_calendar"
                              :name="`end_addition_date`"
                              p-type="date"
                              placeholder="ถึงวันที่ขึ้นทะเบียน/ตัดจำหน่าย"
                              :value="search.end_addition_date"
                              :format="vars.formatDate"
                              @dateWasSelected="getValueAddiEnDate"
                              :disabledDateTo="search.start_addition_date" />
            </el-form-item>
          </div>
        </div>
        <div class="form-group row">
          <label class="col-md-4 col-form-label lable_align">
            <strong>สถานะ</strong>
          </label>
          <div class="col-xl-4 col-lg-5 col-md-6 el_field">
            <dropdown-status-ir v-model="search.status"
                                name="status"
                                size=""
                                :popperBody="true"
                                :disabled="false"
                                placeholder="สถานะ"
                                @change-lov="getValueStatus" />
          </div>
        </div>
      </div> -->
      <div class="text-right el_field">
        <el-form-item>
          <button type="button" class="btn btn-default" @click="clickSearch()">
            <i class="fa fa-search"></i> ค้นหา
          </button>
          <button type="button"
                  class="btn btn-success"
                  data-toggle="modal"
                  :data-target="`#modal_asset_increase_fetch`"
                  @click="clickFetch()" >
            <i class="fa fa-database"></i> ดึงข้อมูล
          </button>
          <button type="button" class="btn btn-warning" @click="clickClear()">
            <i class="fa fa-repeat"></i> รีเซต
          </button>
        </el-form-item>
      </div>
    </el-form>
    <modal-fetch :setYearCE="setYearCE"
                  ref="modal_fetch"
                  @fetch-table-header="fetchTableHeader"
                  :vars="vars"
                  :covertFomatDateMoment="covertFomatDateMoment"
                  :setBudgetYearFromFieldStCalendar="setBudgetYearFromFieldStCalendar"
                  :getDateByBudgetYear="getDateByBudgetYear" />
  </div>
</template>

<script>
import lovAssetGroup from './lovAssetGroup'
import yearInput from '../components/calendar/yearInput'
import dateInput from '../components/calendar/dateInput'
import modalFetch from './moalFetch'
import moment from 'moment'
import dropdownStatusAsset from '../components/dropdown/statusAsset'
import dropdownStatusIr from '../components/dropdown/statusIr'
export default {
  name: 'ir-asset-increase-index-search',
  data () {
    return {
      policies: [],
      rules: {
        year: [
          {required: true, message: 'กรุณาระบุปี', trigger: 'change'}
        ],
        // revision: [
        //   {required: true, message: 'กรุณาระบุครั้งที่', trigger: 'change'}
        // ],
        start_calculate_date: [
          {required: true, message: 'กรุณาระบุวันที่คิดค่าเบี้ย', trigger: 'change'}
        ],
        end_calculate_date: [
          {required: true, message: 'กรุณาระบุถึงวันที่คิดค่าเบี้ย', trigger: 'change'}
        ],
        start_addition_date: [
          {required: true, message: 'กรุณาระบุวันที่ขึ้นทะเบียน/ตัดจำหน่าย', trigger: 'change'}
        ],
        end_addition_date: [
          {required: true, message: 'กรุณาระบุถึงวันที่ขึ้นทะเบียน/ตัดจำหน่าย', trigger: 'change'}
        ]
      },
      loading: false,
      getTimeCalStDate: '',
      getTimeCalEnDate: '',
      getTimeAddiStDate: '',
      getTimeAddiEnDate: '',
      qtyDay: 0,
      revisions: []
    }
  },
  props: [
    'search',
    'setYearCE',
    'vars',
    'covertFomatDateMoment',
    'setBudgetYearFromFieldStCalendar',
    'getDateByBudgetYear',
  ],
  computed: {
    checkCalculateDate () {
      let start = this.search.start_calculate_date
      let end = this.search.end_calculate_date
      if (start && end) {
        if (this.getTimeCalStDate <= this.getTimeCalEnDate) {
          return true
        }
        return false
      }
      return true
    },
    checkAdditionDate () {
      let start = this.search.start_addition_date
      let end = this.search.end_addition_date
      if (start && end) {
        if (this.getTimeAddiStDate <= this.getTimeAddiEnDate) {
          return true
        }
        return false
      }
      return true
    }
  },
  methods: {
    getDataAssetGroup (value) {
      this.search.location_code = value
    },
    clickSearch() {
      this.$refs.search.validate((valid) => {
        if (valid) {
          if (this.reqDate()) {
            if (this.checkRangeCalculateDate()) {
              if (this.checkRangeAdditionDate()) {
                this.$emit('click-search', this.search)
              }
            }
          }
        } else {
          return false;
        }
      })
    },
    clickClear () {
      window.location.href = '/ir/assets/asset-increase'
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
        type: '20',
        type2: ''
      })
    },
    focusPolicySt (event) {
      this.getDataPolicySetHeaderId({
        policy_set_header_id: '',
        keyword: '',
        type: '20',
        type2: ''
      })
    },
    changePolicySt (value) {
      this.search.policy_set_header_id = value;
      this.search.policy_set_header_id_end = value;
    },
    remoteMethodPolicyEn (query) {
      this.getDataPolicySetHeaderId({
        policy_set_header_id: '',
        keyword: query
      })
    },
    focusPolicyEn (event) {
      this.getDataPolicySetHeaderId({
        policy_set_header_id: '',
        keyword: '',
        type: '20',
        type2: ''
      })
    },
    changePolicyEn (value) {
      this.search.policy_set_header_id_end = value
    },
    reqDate () {
      let _this = this;
      if (!this.checkCalculateDate && this.checkAdditionDate) {
        swal({
          title: "Warning",
          text: "ฟิลด์วันที่คิดค่าเบี้ยต้องน้อยกว่าหรือเท่ากับฟิลด์ถึงวันที่คิดค่าเบี้ย!",
          type: "warning",
        },
        function(isConfirm) {
          if (isConfirm) {
            _this.search.start_calculate_date = ''
            _this.search.end_calculate_date = ''
          }
        });
      } else if (!this.checkAdditionDate && this.checkCalculateDate) {
        swal({
          title: "Warning",
          text: "ฟิลด์วันที่ขึ้นทะเบียน/ตัดจำหน่ายต้องน้อยกว่าหรือเท่ากับฟิลด์ถึงวันที่ขึ้นทะเบียน/ตัดจำหน่าย!",
          type: "warning",
        },
        function(isConfirm) {
          if (isConfirm) {
            _this.search.start_addition_date = ''
            _this.search.end_addition_date = ''
          }
        });
      } else if (!this.checkCalculateDate && !this.checkAdditionDate) {
        swal({
          title: "Warning",
          text: "ฟิลด์วันที่คิดค่าเบี้ยต้องน้อยกว่าหรือเท่ากับฟิลด์ถึงวันที่คิดค่าเบี้ย!",
          type: "warning",
        },
        function(isConfirm) {
          if (isConfirm) {
            _this.search.start_calculate_date = ''
            _this.search.end_calculate_date = ''
          }
        });
      } else {
        return true
      }
    },
    getDataRevision () {
      axios.get(`/ir/ajax/lov/revision`)
      .then(({data}) => {
        this.revisions = data.data.filter((row) => {
          row.revision = row.revision === null ? 1 : row.revision
          return row
        })
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    fetchTableHeader (dataRows) {
      this.$emit('fetch-show-table-header', dataRows)
    },
    clickFetch () {
      this.$refs.modal_fetch.resetFields()
    },
    checkRangeCalculateDate () {
      let start = this.search.start_calculate_date;
      let end = this.search.end_calculate_date;
      if (start === '' && end === '' ) {
        return true
      } else if (start && end) {
        return true
      } else {
        swal('Warning', 'กรุณาระบุช่วงวันที่คิดค่าเบี้ยให้ครบ!', 'warning')
      }
    },
    checkRangeAdditionDate () {
      let start = this.search.start_addition_date;
      let end = this.search.end_addition_date;
      if (start === '' && end === '') {
        return true
      } else if (start && end) {
        return true
      } else {
        swal('Warning', 'กรุณาระบุช่วงวันที่ขึ้นทะเบียน/ตัดจำหน่ายให้ครบ!', 'warning')
      }
    },
    getValueYear (date) {
      let formatYear = this.vars.formatYear
      if (date) {
        this.search.year = moment(date).format(formatYear)
      } else {
        this.search.year = ''
      }
    },
    getValueCalStDate (date) {
      this.search.start_calculate_date = date === null ? '' : date
      if (date && this.search.end_calculate_date) {
        if (date > this.search.end_calculate_date) {
          // this.search.end_calculate_date = '';
        }
      }
      this.search.end_calculate_date = this.setBudgetYearFromFieldStCalendar(date);
    },
    getValueCalEnDate (date) {
      this.search.end_calculate_date = date === null ? '' : date;
    },
    getValueAddiStDate (date) {
      this.search.start_addition_date = date === null ? '' : date;
      if (date && this.search.end_addition_date) {
        if (date > this.search.end_addition_date) {
          this.search.end_addition_date = '';
        }
      }
    },
    getValueAddiEnDate (date) {
      this.search.end_addition_date = date === null ? '' : date;
    },
    getValueAssetStatus (value) {
      this.search.asset_status = value;
    },
    getValueStatus (value) {
      this.search.status = value;
    }
  },
  components: {
    lovAssetGroup,
    yearInput,
    dateInput,
    modalFetch,
    dropdownStatusAsset,
    dropdownStatusIr
  },
  mounted () {
    this.getDataPolicySetHeaderId({
      policy_set_header_id: '',
      keyword: '',
      type: '20',
      type2: ''
    })
  },
  created () {
    this.getDataRevision()
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
