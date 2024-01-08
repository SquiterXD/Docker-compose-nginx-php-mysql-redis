<template>
  <div>
    <form-policy :policy='policy' :btn-trans="btnTrans"/>
  </div>
</template>

<script>
  import FormPolicy from './formPolicy'
  export default {
    props: [
      'btnTrans',
      'runningNo'
    ],
    data() {
      return {
        policy: {
          policy_set_number: this.runningNo,
          policy_set_description: '',
          policy_type_code: '',
          policy_age: '',
          type_cost: '',
          account_combine: '',
          account_combine_gl: '',
          include_tax_flag: true,
          active_flag: true,
          policy_set_header_id: '',
          policyTypeCodes: [],
          group_code: '',
          policy_category_code: '',
          id_account: '',
          id_account_gl: '',
          gl_expense_account_id: '',
          mode: 'create'
        }
      }
    },
    components: {
      FormPolicy
    }
  }
</script>