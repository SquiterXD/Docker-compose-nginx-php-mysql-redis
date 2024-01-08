<template>
  <div class="el_field">
    <el-select  v-model="policy"
                filterable
                remote
                :clearable="true"
                :size="sizeDefault"
                placeholder="ประเภทกรมธรรม์"
                @change="changePolicyType"
                :disabled='disabled'>
      <el-option  v-for="(data) in policyTypeList"
                  :key="data.rn"
                  :label="`${data.description}`"
                  :value="data.lookup_code">
      </el-option>
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'governor-lov-policy-type',
  data() {
    return {
      policy: this.value,
      policyTypeList: [],
      sizeDefault: this.sizeSmall ? 'small' : 'large'
    }
  },
  props: ['value', 'disabled', 'sizeSmall','fetchPolicy'],
  mounted() {
    const vm = this
    vm.getPolicyType()
  },
  methods: {
    getPolicyType(params = {keyword: ''}) {
      const vm = this
      axios.get('/ir/ajax/lov/governer-policy-type', {params})
      .then(({data:response}) => {
        vm.policyTypeList = response.data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    changePolicyType(value) {
      const vm = this;
      let obj = {
        code: '',
        desc: '',
        tag: ''
      }
      if (value) {
        for (let i in vm.policyTypeList) {
          let row = vm.policyTypeList[i];
          if (row.lookup_code == value) {
            obj.code = value;
            obj.desc = row.description;
            obj.tag = row.tag;
          }
        }
      } else {
        obj.code = '';
        obj.desc = '';
        obj.tag = '';
      }
      vm.$emit('policyType', obj)
    }
  },
  watch: {
    fetchPolicy(newval) {
       
      // const vm = this
      // vm.getPolicyType()
      if (newval) this.getPolicyType()
    }
  }
}
</script>
