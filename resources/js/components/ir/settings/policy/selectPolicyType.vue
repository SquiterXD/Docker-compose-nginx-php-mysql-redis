<template>
  <div class="el_select">
    <input type="hidden" name="policy_type_code" :value="policy_type_code" autocomplete="off">
    <el-select  v-model="policy_type_code"
                filterable
                remote
                :remote-method="remoteMethod"
                :loading="loading"
                @change="updateDropdowns"
                :clearable="true"
                placeholder="แบบของการประกัน"
                :validate-event='true'
                required>
      <el-option  v-for="(data, index) in policy"
                  :key="index"
                  :label="`${data.department_code}: ${data.description}`"
                  :value="data.department_code"
      ></el-option>
    </el-select>
  </div>
</template>

<script>
export default {
    name: 'ir-select-policy-type',
    data() {
      return {
        policy: [],
        loading: false,
        policy_type_code: '',
        account_id: ''
      }
    },
    mounted() {
      this.getPolicies({ account_id: '', keyword: '' });
    },
    methods: {
      remoteMethod(query) {
        this.getPolicies({ department_code: '', keyword: query });
      },
      getPolicies(params) {
        this.loading = true;
        axios.get(`/ir/ajax/lov/department-code`, { params })
        .then(res => {
          let response = res.data
          this.loading = false;
          this.policy = response.data
        });
      },
      change (value) {
        if (value) {
          for (let i in this.policy) {
            let data = this.policy[i]
            if (value === data.account_code) {
              $('input[name="account_combine"]').val(data.account_combine)
              $('input[name="account_id"]').val(data.account_id)
            }
          }
        } else {
          $('input[name="account_combine"]').val('')
          $('input[name="account_id"]').val('')
        }
      },
      updateDropdowns(policy) {
        this.$emit('policy', policy)
      }
    },
    watch: {
      'account_id' (newVal, oldVal) {
        this.getPolicies({ department_code: newVal, keyword: '' });
      }
    }
};
</script>

<style>
  .el_select .el-select {
    width: 100%;
  }
</style>
