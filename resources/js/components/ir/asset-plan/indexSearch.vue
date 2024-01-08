<template>
  <div>
    <el-form  :model="search"
              ref="search_index_asset_plan" 
              label-width="120px" 
              class="demo-ruleForm">
              <!-- :rules="rules"  -->

      <div class="row">
        <div class="col-lg-6">
          <div class="row">
            <label class="col-lg-5 col-md-4 col-sm-12 col-xs-12 col-form-label lable_align">
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
            <label class="col-lg-5 col-md-4 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>วันที่คุ้มครอง</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item>
                <el-input v-model="search.insurance_start_date"
                          placeholder="วันที่คุ้มครอง"
                          disabled />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-lg-5 col-md-4 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>กรมธรรม์ชุดที่</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12 align-item-center">
              <el-form-item>
                <el-select  v-model="search.policy_set_header_id_start"
                            placeholder="กรมธรรม์ชุดที่"
                            name="policy_set_header_id_start"
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
            <label class="col-lg-5 col-md-4 col-sm-12 col-xs-12 col-form-label lable_align">
              <strong>ณ วันที่</strong>
            </label>
            <div class="col-lg-6 col-md-7 col-sm-12 col-xs-12">
              <el-form-item prop="as_of_date">
                <datepicker-th  style="width: 100%;"
                                class="el-input__inner"
                                :name="`as_of_date`"
                                p-type="date"
                                placeholder="ณ วันที่"
                                :value="search.as_of_date"
                                :format="vars.formatDate"
                                @dateWasSelected="getValueAsOfDate" />
              </el-form-item>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="row">
            <label class="col-md-3 col-form-label lable_align">
              <strong>กลุ่มของทรัพย์สิน</strong>
            </label>
            <div class="col-xl-7 col-lg-8 col-md-8 el_field">
              <el-form-item>
                <lov-asset-group  attrName="asset_group"
                                  v-model="search.asset_group"
                                  :isTable="false"
                                  @change-value-asset-group="getDataAssetGroup"
                                  size=""
                                  class="w-100" />
              </el-form-item>
            </div>
          </div>
          <div class="row">
            <label class="col-md-3 col-form-label lable_align">
              <strong>ถึง</strong>
            </label>
            <div class="col-xl-7 col-lg-8 col-md-8 el_field">
              <el-form-item>
                <el-input v-model="search.insurance_end_date"
                          placeholder="ถึงวันที่คุ้มครอง"
                          disabled
                          class="w-100" />
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
                            @change="changePolicyEn"
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
            <label class="col-md-3 col-form-label lable_align">
              <strong>สถานะ</strong>
            </label>
            <div class="col-xl-7 col-lg-8 col-md-8 el_field">
              <el-form-item>
                <dropdown-status-ir v-model="search.status"
                                    name="status"
                                    size=""
                                    :popperBody="true"
                                    :disabled="false"
                                    placeholder="สถานะ"
                                    @change-lov="getValueStatus"
                                    class="w-100" />
              </el-form-item>
            </div>
          </div>
        </div>
      </div>

      <!-- ของเดิม -->
      <!-- <div class="col-lg-11">
        <div class="row">
          <label class="col-md-5 col-form-label lable_align">
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
          <label class="col-md-5 col-form-label lable_align">
            <strong>วันที่คุ้มครอง</strong>
          </label>
          <div class="col-xl-4 col-lg-5 col-md-6 el_field">
            <el-form-item>
              <el-input v-model="search.insurance_start_date"
                        placeholder="วันที่คุ้มครอง"
                        disabled />
            </el-form-item>
          </div>
        </div>
        <div class="row">
          <label class="col-md-5 col-form-label lable_align">
            <strong>ถึง</strong>
          </label>
          <div class="col-xl-4 col-lg-5 col-md-6 el_field">
            <el-form-item>
              <el-input v-model="search.insurance_end_date"
                        placeholder="ถึงวันที่คุ้มครอง"
                        disabled />
            </el-form-item>
          </div>
        </div>
        <div class="row">
          <label class="col-md-5 col-form-label lable_align">
            <strong>กรมธรรม์ชุดที่</strong>
          </label>
          <div class="col-xl-4 col-lg-5 col-md-6 el_field">
            <el-form-item>
              <el-select  v-model="search.policy_set_header_id_start"
                          placeholder="กรมธรรม์ชุดที่"
                          name="policy_set_header_id_start"
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
          <label class="col-md-5 col-form-label lable_align">
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
          <label class="col-md-5 col-form-label lable_align">
            <strong>ณ วันที่</strong>
          </label>
          <div class="col-xl-4 col-lg-5 col-md-6 el_field">
            <el-form-item prop="as_of_date">
              <datepicker-th  style="width: 100%;"
                              class="el-input__inner"
                              :name="`as_of_date`"
                              p-type="date"
                              placeholder="ณ วันที่"
                              :value="search.as_of_date"
                              :format="vars.formatDate"
                              @dateWasSelected="getValueAsOfDate" />
            </el-form-item>
          </div>
        </div>
        <div class="row">
          <label class="col-md-5 col-form-label lable_align">
            <strong>กลุ่มของทรัพย์สิน</strong>
          </label>
          <div class="col-xl-4 col-lg-5 col-md-6 el_field">
            <el-form-item>
              <lov-asset-group  attrName="asset_group"
                                v-model="search.asset_group"
                                :isTable="false"
                                @change-value-asset-group="getDataAssetGroup"
                                size="" />
            </el-form-item>
          </div>
        </div>
        <div class="row">
          <label class="col-md-5 col-form-label lable_align">
            <strong>สถานะ</strong>
          </label>
          <div class="col-xl-4 col-lg-5 col-md-6 el_field">
            <el-form-item>
              <dropdown-status-ir v-model="search.status"
                                  name="status"
                                  size=""
                                  :popperBody="true"
                                  :disabled="false"
                                  placeholder="สถานะ"
                                  @change-lov="getValueStatus" />
            </el-form-item>
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
                  :data-target="`#modal_asset_plan_fetch`"
                  @click="clickFetch()" >
            <i class="fa fa-database"></i> ดึงข้อมูล
          </button>
          <button type="button" class="btn btn-warning" @click="clickCancel()">
            <i class="fa fa-repeat"></i> รีเซต
          </button>
        </el-form-item>
      </div>
    </el-form>
    <modal-fetch :setYearCE="setYearCE"
                  ref="modal_fetch"
                  @fetch-table-header="fetchTableHeader"
                  :vars="vars" />
  </div>
</template>

<script>
import lovAssetGroup from './lovAssetGroup'
import modalFetch from './moalFetch'
import moment from 'moment'
import dropdownStatusAsset from '../components/dropdown/statusAsset'
import dropdownStatusIr from '../components/dropdown/statusIr'
export default {
  name: 'ir-asset-plan-index-search',
  data () {
    return {
      rules: {
        year: [
          {required: true, message: 'กรุณาระบุปี', trigger: 'change'}
        ],
        as_of_date: [
          {required: true, message: 'กรุณาระบุ ณ วันที่', trigger: 'change'}
        ]
      },
      status: [],
      getTimeInsuSt: '',
      getTimeInsuEn: '',
      policies: [],
      loading: false
    }
  },
  props: [
    'search',
    'setYearCE',
    'vars'
  ],
  computed: {
    // checkInsuranceDateRange () {
    //   let start = this.search.insurance_start_date
    //   let end = this.search.insurance_end_date
    //   if (start && end) {
    //     let arrSt = start.split('/')
    //     let arrEn = end.split('/')
    //     let setSt = new Date(`${arrSt[1]}/${arrSt[0]}/${+arrSt[2] - 543}`).getTime()
    //     let setEn = new Date(`${arrEn[1]}/${arrEn[0]}/${+arrEn[2] - 543}`).getTime()
    //     if (setSt <= setEn) {
    //       return false
    //     } else {
    //       swal({ title: "ฟิลด์วันที่คุ้มครองต้องน้อยกว่าหรือเท่ากับฟิลด์วันที่คุ้มครองถึง!" })
    //       return true
    //     }
    //   }
    //   return false
    // }
    checkInsuranceDate () {
      let start = this.search.insurance_start_date
      let end = this.search.insurance_end_date
      if (start && end) {
        if (this.getTimeInsuSt <= this.getTimeInsuEn) {
          return true
        }
        return false
      }
      return true
    }
  },
  methods: {
    clickSearch() {
      this.$refs.search_index_asset_plan.validate((valid) => {
        // if (valid && !this.checkInsuranceDateRange) {
        if (valid) {
          if (this.reqDate()) {
            this.$emit('click-search', this.search)
          }
        } else {
          return false;
        }
      });
    },
    clickClear () {
      window.location.href = '/ir/assets/asset-plan'
    },
    getDataStatus () {
      axios.get(`/ir/ajax/lov/status`)
      .then(({data}) => {
        this.status = data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    getDataAssetGroup (value) {
      this.search.asset_group = value
    },
    reqDate () {
      if (!this.checkInsuranceDate) {
        swal('Warning', 'ฟิลด์วันที่คุ้มครองต้องน้อยกว่าหรือเท่ากับฟิลด์วันที่คุ้มครองถึง!', 'warning')
      } else {
        return true
      }
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
      this.search.policy_set_header_id_start = value
      this.search.policy_set_header_id_end = value;
    },
    remoteMethodPolicyEn (query) {
      this.getDataPolicySetHeaderId({
        policy_set_header_id: '',
        keyword: query,
        type: '20',
        type2: ''
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
    getDataInsuranceDate (params) {
      axios.get(`/ir/ajax/lov/effective-date`, { params })
      .then(({data}) => {
        let response = data.data
        if (response === null) {
          this.search.insurance_start_date = ''
          this.search.insurance_end_date = ''
        } else {
          this.search.insurance_start_date = response.start_date_active
          this.search.insurance_end_date = response.end_date_active
        }
      })
      .catch((error) => {
        swal('Error', error, 'error')
      })
    },
    clickCancel () {
      window.location.href = '/ir/assets/asset-plan'
    },
    fetchTableHeader (dataRows) {
      this.$emit('fetch-show-table-header', dataRows)
    },
    clickFetch () {
      this.$refs.modal_fetch.resetFields()
    },
    getValueYear (date) {
      let formatYear = this.vars.formatYear
      if (date) {
        this.search.year = moment(date).format(formatYear)
        this.getDataInsuranceDate({
          year: this.setYearCE('year', this.search.year),
          keyword: ''
        });
      } else {
        this.search.year = ''
        this.search.insurance_start_date = ''
        this.search.insurance_end_date = ''
        this.getDataInsuranceDate({
          year: this.search.year,
          keyword: ''
        });
      }
    },
    getValueAsOfDate (date) {
      let formatDate = this.vars.formatDate
      if (date) {
        this.search.as_of_date = moment(date).format(formatDate)
      } else {
        this.search.as_of_date = ''
      }
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