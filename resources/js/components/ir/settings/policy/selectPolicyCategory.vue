<template>
  <div class="el_select">
    <input type="hidden" name="policy_lookup" :value="policy_lookup" autocomplete="off">
    <el-select  v-model="policy_lookup"
                filterable
                remote
                :remote-method="remoteMethod"
                :loading="loading"
                @change="change"
                :clearable="true"
                placeholder="ประเภทกรมธรรม์">
      <el-option  v-for="(data, index) in categories"
                  :key="index"
                  :label="`${data.description  }`"
                  :value="data.lookup_code"
      ></el-option>
    </el-select>
  </div>
</template>

<script>
export default {
    name: 'ir-select-group',
    data() {
      return {
        categories: [],
        loading: false,
        policy_lookup: this.valueTypeCost,
        account_id: ''
      }
    },
    props: [
      'url',
      'valueTypeCost'
    ],
    mounted() {
      this.getPolicyCategory({ account_id: '', keyword: '' });
    },
    methods: {
      remoteMethod() {
        this.getPolicyCategory({ account_id: '', keyword: query });
      },
      getPolicyCategory() {
        this.loading = true;
        axios.get(`/ir/ajax/lov/policy-category`)
        .then(({data: response}) => {
          this.loading = false
          this.categories = response.data
        });
      },
      change (value) {
        if (value) {
          this.callbackCategory(value)
        } else {
          this.callbackCategory('')
        }
      },
      callbackCategory (value) {
        this.$emit('category', value)
      }
    },
    updated () {
      this.$nextTick(function () {
        let data = window.localStorage.getItem('data')
        let result = JSON.parse(data)
        this.account_id = location.href.split("/")[7]
      })
    },
    watch: {
      'valueTypeCost' (newVal, oldVal) {
        this.policy_lookup = newVal
      }
    }
};
</script>

<style>
  .el_select .el-select {
    width: 100%;
  }
</style>
