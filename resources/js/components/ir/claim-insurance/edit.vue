<template>
  <div>
    <form-claim-insurance :claim="claim"
                          :isNullOrUndefined="funcs.isNullOrUndefined"
                          :checkStatusInterface="funcs.checkStatusInterface"
                          :checkStatusConfirmed="funcs.checkStatusConfirmed"
                          :action="action"
                          :setYearCE="funcs.setYearCE"
                          :vars="vars"
                          :checkStatusCancelled="funcs.checkStatusCancelled" />
  </div>
</template>

<script>
import formClaimInsurance from './form-claim'
import * as scripts from '../scripts'
export default {
  name: 'ir-claim-insurance-edit',
  data () {
    return {
      claim: {
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
        group: [],
        flag: 'edit'
      },
      action: 'edit',
      funcs: scripts.funcs,
      vars: scripts.vars
    }
  },
  props: [
    'claimHeaderId'
  ],
  methods: {
    getDataEdit (claim_header_id) {
      axios.get(`/ir/ajax/claim/${claim_header_id}`)
      .then(({data}) => {
           

        this.claim = this.setPropertyForm(data.data)
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    setPropertyForm (data) {
       
      data.claim_policy_group_rows.filter((group) => {
         
        group.company =  group.company_rows.filter((comp,index_comp) => {
          comp.claim_percent = comp.claim_percent ? +comp.claim_percent : comp.claim_percent
          comp.claim_amount = group.amount * comp.claim_percent / 100
          comp.flag = 'edit'
           
          comp.detail = comp.line_rows.filter((detl, index_detail) => {
            detl.line_number = index_detail + 1
            // detl.line_amount = comp.claim_amount
            detl.flag = 'edit'
            return detl;
          })
          comp.req_modal = comp.invoice_date && comp.gl_date ? '1' : ''
          comp.modal = {
            informant_date: comp.informant_date,
            invoice_date: comp.invoice_date === null ? '' : comp.invoice_date,
            gl_date: comp.gl_date === null ? '' : comp.gl_date,
            ar_invoice_num: comp.ar_invoice_num,
            policy_number: comp.policy_number,
            ar_receipt_date: comp.ar_receipt_date,
            ar_receipt_number: comp.ar_receipt_number,
            ar_received_amount: comp.ar_received_amount
          }
          return comp;
        })
        group.flag = 'edit'
        if(group.group_code === ''){
            group.showLovCompany = true
        }else{
            group.showLovCompany = false
        }
        return group;
      })
      let files = data.file.filter((row) => {
        row.name = row.original_file_name
        return row
      })
      let params = {
        headers: {
          ...data.header,
          year: data.header.accident_date.split('/')[2] - 543 ,
          //year: data.header.year ? data.header.year : '', // current
          file: files
        },
        group: data.claim_policy_group_rows,
        flag: 'edit'
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
      return data
    }
  },
  components: {
    formClaimInsurance
  },
  mounted () {
     
    this.getDataEdit(this.claimHeaderId)
  }
}
</script>
