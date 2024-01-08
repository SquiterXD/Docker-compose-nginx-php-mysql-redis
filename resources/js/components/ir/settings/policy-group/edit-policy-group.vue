<template>
  <div>
    <form-policy-group  :policy='policy'
                        :vars="vars"
                        :setYearCE="funcs.setYearCE"
                        :btn-trans="btnTrans" />
  </div>
</template>

<script>
import FormPolicyGroup from './formPolicyGroup'
import * as scripts from '../../scripts'

export default {
  props: [
    'btnTrans'
  ],
  data() {
    return {
      policy: {
        mode: 'edit'
      },
      vars: scripts.vars,
      funcs: scripts.funcs
    }
  },
  components: {
    FormPolicyGroup
  }
}
</script>