<template>
  <div>
    <form-claim-insurance :claim="claim"
                          :isNullOrUndefined="funcs.isNullOrUndefined"
                          :checkStatusInterface="funcs.checkStatusInterface"
                          :checkStatusConfirmed="funcs.checkStatusConfirmed"
                          :checkStatusCancelled="funcs.checkStatusCancelled"
                          :action="action"
                          :setYearCE="funcs.setYearCE"
                          :vars="vars" />
  </div>
</template>

<script>
import formClaimInsurance from './form-claim'
import * as scripts from '../scripts'
import moment from 'moment'
export default {
  name: 'ir-claim-insurance-create',
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
          // files: [],
          year: moment().format('YYYY')
        },
        group: [],////
        flag: 'add'
      },
      action: 'add',
      funcs: scripts.funcs,
      vars: scripts.vars
    }
  },
  components: {
    formClaimInsurance
  }
}
</script>
