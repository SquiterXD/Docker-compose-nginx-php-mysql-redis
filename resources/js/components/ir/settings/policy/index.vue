<template>
  <div>
    <index-header @click-edit='clickEdit'
                  @changeMode='changeModeCreate'
                  :setDefaultActive="funcs.setDefaultActive"
                  :btn-trans="btnTrans" />
  </div>
</template>

<script>
import IndexHeader from './indexHeader.vue'
import FormPolicy from './formPolicy'
import * as scripts from '../../scripts'

export default {
  components: {
    IndexHeader,
    FormPolicy
  },
  name: 'index-policy',
  props: [
    'btnTrans'
  ],
  data() {
    return { 
      showIndex: true,
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
        mode: 'create'
      },
      funcs: scripts.funcs
    }
  },
  methods: {
    clickEdit(obj) {
      const vm = this
      vm.showIndex = obj.showIndex
      vm.policy = {
        ...vm.policy,
        ...obj.row,
        mode: 'edit',
      }
    },
    changeModeCreate() {
      const vm = this
      vm.showIndex = false
    }
  },
  computed: {
    textStatus() {
      if (!this.showIndex && this.policy.mode === 'create') 
        return ' / Create'
      else if (!this.showIndex && this.policy.mode === 'edit')
        return ' / Edit'
      return ''
    }
  }
}
</script>