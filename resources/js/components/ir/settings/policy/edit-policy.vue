<template>
  <div>
    <form-policy :policy='policy' :btn-trans="btnTrans"/>
  </div>
</template>

<script>
  import FormPolicy from './formPolicy'
  export default {
    props: [
      'btnTrans'
    ],
    data() {
      return {
        policy: {
          policy_set_number: '',
          policy_set_description: '',
          policy_type_code: '',
          policy_age: '',
          type_cost: '',
          account_combine: '',
          include_tax_flag: true,
          active_flag: true,
          policy_set_header_id: '',
          policyTypeCodes: [],
          group_code: '',
          policy_category_code: '',
          id_account: '',
          id_account_gl: '',
          gl_expense_account_id: '',
          account_combine_gl: '',
          mode: 'edit'
        }
      }
    },
    components: {
      FormPolicy
    },
    methods: {
      getDataEdit () {
        let id = window.location.href.split("/").pop()
        axios.get(`/ir/ajax/policy/${id}`)
        .then((response) => {
          const data = response.data.data
          this.policy.policy_set_number = data.policy_set_number,
          this.policy.policy_set_description =  data.policy_set_description,
          this.policy.policy_type_code = data.policy_type_code,
          this.policy.policy_age = data.policy_age,
          this.policy.type_cost = data.type_cost,
          this.policy.id_account_gl = data.gl_expense_account_id,
          this.policy.include_tax_flag = data.include_tax_flag === 'Y' ? true : false,
          this.policy.account_combine = data.account_combine
          this.account_combine_gl =  data.account_combine_gl
          this.policy.active_flag = data.active_flag === 'Y' ? true : false
          this.policy.id_account = data.account_id
          this.policy.group_code = data.group_code
          this.policy.policy_category_code = data.policy_category_code
          this.policy.policy_set_header_id = id
        })
        .catch((error) => {
          if (error.response.data.status === 400) {
            swal({
              title: "Warning",
              text:  error.response.data.message,
              timer: 3000,
              type: "warning",
            })
          } else {
            swal({
              title: "Error",
              text:  error.response.data.message,
              timer: 3000,
              type: "error",
            })
          }
        })
      },
    },
    created() {
      const vm = this
      vm.getDataEdit()
    }
  }
</script>