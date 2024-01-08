<template>
  <div>
    <form-comp  :company="company"
                :action="action"
                :btn-trans="btnTrans" />
  </div>
</template>

<script>
import formComp from './form'
export default {
  name: 'ir-settings-compony-create',
  props:[
    'btnTrans'
  ],
  data () {
    return {
      company: {
        company_number: '',
        company_name: '',
        company_address: '',
        company_telephone: '',
        vendor_id: '',
        vendor_site_id: '', // branch_code: '',
        customer_id: '',
        active_flag: 'Y',
        company_id: ''
      },
      action: 'add'
    }
  },
  components: {
    formComp
  },
  methods: {
    getGenCompanyNumber () {
      axios.get(`/ir/ajax/lov/gen-company-number`)
      .then(({data}) => {
        let res = data.data;
        this.company.company_number = res.company_number;
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    }
  },
  created () {
    this.getGenCompanyNumber()
  }
}
</script>