<template>
  <div>
    <form-comp  :company="company"
                :action="action"
                ref="editFormComp"
                :btn-trans="btnTrans" />
  </div>
</template>

<script>
import formComp from './form'
export default {
  name: 'ir-settings-company-edit',
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
        active_flag: '',
        company_id: ''
      },
      action: 'edit'
    }
  },
  props: [
    'companyId', 'btnTrans'
  ],
  components: {
    formComp
  },
  methods: {
    getDateEdit (company_id) {
      axios.get(`/ir/ajax/company/${company_id}`)
      .then(({data}) => {
        let res = data.data;
        res.active_flag = res.active_flag == 'Y' ? true : false
        this.company = res
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    }
  },
  mounted () {
     
    this.getDateEdit(this.companyId)
    this.$refs.editFormComp.$refs.company.clearValidate()
  }
}
</script>