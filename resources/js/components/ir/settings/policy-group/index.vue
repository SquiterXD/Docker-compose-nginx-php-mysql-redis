<template>
  <div>
    <index-header @editValue='clickEdit'
      :btn-trans="btnTrans"
    />
  </div>
</template>

<script>
  import FormPolicyGroup from './formPolicyGroup.vue'
  import IndexHeader from './indexHeader'

  export default {
    name: 'index-policy-group',
    props: [
      'btnTrans'
    ],
    data() {
      return {
        showIndex: true,
        policy: {
          mode: 'create'
        }
      }
    },
    components: {
      IndexHeader,
      FormPolicyGroup
    },
    methods: {
      clickEdit(obj) {
        const vm = this
        vm.showIndex = obj.showIndex
         
        vm.policy = {...vm.policy, ...obj.row}
        vm.policy.mode = 'edit'
      }
    }
  }
</script>