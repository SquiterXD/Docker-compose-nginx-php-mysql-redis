<template>
  <div>
    <index-search :search="search"
                  @click-create="getCreateDefault"
                  @click-search="getDataSearch"
                  :vars="vars" />
    <index-table-header :isNullOrUndefined="funcs.isNullOrUndefined"
                        :tableHeader="tableHeader"
                        :formatCurrency="funcs.formatCurrency"
                        @click-edit="getDataRowEditToForm"
                        :checkStatusInterface="funcs.checkStatusInterface"
                        :setFirstLetterUpperCase="funcs.setFirstLetterUpperCase"
                        :showYearBE="funcs.showYearBE"
                        @cancel-success="cancelSuccess" />
  </div>
  <!-- <div class="col-lg-12">
    <div class="ibox" v-if="showIndex">
      <div class="ibox-title">
        <h5>เคลมประกัน (Claim Insurance)</h5>
      </div>
      <div class="ibox-content">
        <index-search :search="search"
                      @click-create="getCreateDefault"
                      @click-search="getDataSearch"
                      :vars="vars" />
        <index-table-header :isNullOrUndefined="funcs.isNullOrUndefined"
                            :tableHeader="tableHeader"
                            :formatCurrency="funcs.formatCurrency"
                            @click-edit="getDataRowEditToForm"
                            :checkStatusInterface="funcs.checkStatusInterface"
                            :setFirstLetterUpperCase="funcs.setFirstLetterUpperCase"
                            :showYearBE="funcs.showYearBE"
                            @cancel-success="cancelSuccess" />
                            @click-cancel="getDataRowCancel"
      </div>
    </div>
    <div class="ibox" v-else>
      <div class="ibox-title">
        <h5>Edit / Create New</h5><br>
        <h5>เคลมประกัน</h5>
      </div>
      <div class="ibox-content">
        <form-claim-insurance :claim="claim"
                              :isNullOrUndefined="funcs.isNullOrUndefined"
                              :checkStatusInterface="funcs.checkStatusInterface"
                              :checkStatusConfirmed="funcs.checkStatusConfirmed"
                              :action="action"
                              :setYearCE="funcs.setYearCE" />
      </div>
    </div>
  </div> -->
</template>

<script>
import indexSearch from './indexSearch'
import indexTableHeader from './indexTableHeader'
import formClaimInsurance from './form-claim'
import * as scripts from '../scripts'
export default {
  name: 'ir-claim-insurance-index',
  data () {
    return {
      showIndex: true,
      search: {
        start_year: '',
        end_year: '',
        accident_start_date: '',
        accident_end_date: '',
        department_start: '',
        department_end: '',
        ar_invoice_num: '',
        policy_number: '',
        status: ''
      },
      action: '',
      claim: {
        // claim_header_id: '',
        // status: '',
        // document_number: '',
        // accident_date: '',
        // accident_time: '',
        // location_code: '',
        // location_name: '',
        // department_code: '',
        // department_name: '',
        // requestor_id: '',
        // requestor_name: '',
        // requestor_tel: '',
        // claim_amount: '',
        // year: '',
        // tableLine: [],
        // apply: {
        //   apply_companies: []
        // },
        // informant_date: '',
        // invoice_date: '',
        // gl_date: '',
        // ar_invoice_num: '',
        // policy_number: '',
        // ar_receipt_date: '',
        // ar_receipt_id: '',
        // ar_receipt_number: '',
        // ar_received_amount: '',
        headers: {
          claim_header_id: '',
          status: '',
          document_number: '',
          accident_date: '',
          accident_time: '',
          location_code: '',
          location_name: '',
          department_code: '',
          department_name: '',
          requestor_id: '',
          requestor_name: '',
          requestor_tel: '',
          claim_amount: '',
          year: ''
        },
        group: []
      },
      tableHeader: [],
      test: '',
      funcs: scripts.funcs,
      mocks: scripts.mocks,
      vars: scripts.vars
    }
  },
  methods: {
    getCreateDefault (obj) {
      this.showIndex = obj.showIndex
      this.action = obj.action
      this.claim = obj.create
    },
    getDataSearch (obj) {
      this.search = obj
      this.getTableHeader()
    },
    getDataRowEditToForm (obj) {
       
      this.showIndex = obj.showIndex
      this.action = obj.action
      // this.claim = obj.row
      this.getDataEdit(obj.row)
    },
    getDate (value) {
       
      this.test = value
    },
    submit () {
       
    },
    getTableHeader () {
       
      let start_year = this.funcs.covertFomatDateMoment(this.search.start_year, 'year');
      let end_year = this.funcs.covertFomatDateMoment(this.search.end_year, 'year');
      let start_acci = this.funcs.covertFomatDateMoment(this.search.accident_start_date, 'date');
      let end_acci = this.funcs.covertFomatDateMoment(this.search.accident_end_date, 'date');
      let params = {
        year_from: this.funcs.setYearCE('year', start_year),
        year_to:  this.funcs.setYearCE('year', end_year),
        accident_start: this.funcs.setYearCE('date', start_acci),
        accident_end: this.funcs.setYearCE('date', end_acci),
        department_from: this.search.department_start,
        department_to: this.search.department_end,
        ar_invoice_num: this.search.ar_invoice_num,
        policy_number: this.search.policy_number,
        status: this.search.status
      }
      axios.get(`/ir/ajax/claim`, { params })
      .then(({data}) => {
        this.tableHeader = data.data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    getDataEdit (dataRow) {
      axios.get(`/ir/ajax/claim/${dataRow.claim_header_id}`)
      .then(({data}) => {
        // this.claim = this.setPropertyForm(this.mocks.irp0010_form)
        this.claim = this.setPropertyForm(data.data)
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    setPropertyForm (data) {
       
      data.company_rows.filter((company, index_comp) => {
        company.claim_percent = company.claim_percent ? +company.claim_percent : company.claim_percent
        company.flag = 'edit'
        company.line_rows.filter((detail, index_detail) => {
          detail.line_number = index_detail + 1
          detail.flag = 'edit'
          return detail
        })
        company.apply_details = company.line_rows
        company.req_modal = ''
      })
      let params = {
        headers: {
          ...data.header
        },
        apply: {
          apply_company: data.company_rows
        }
      }
       
      return params
      // data.apply.apply_company.filter((company, index_comp) => {
      //   company.flag = 'edit'
      //   company.apply_details.filter((detail, index_detail) => {
      //     detail.line_number = index_detail + 1
      //     detail.flag = 'edit'
      //     return detail
      //   })
      //   return company
      // })
      // return data
    },
    cancelSuccess (value) {
      this.getTableHeader()
    }
  },
  components: {
    indexSearch,
    indexTableHeader,
    formClaimInsurance
  },
  created () {
    this.getTableHeader()
  }
}
</script>
