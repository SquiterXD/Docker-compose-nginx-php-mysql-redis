<template>
  <div class="el_select">
    <input type="hidden" name="type_cost" :value="type_cost" autocomplete="off">
    <el-select  v-model="type_cost"
                filterable
                remote
                :remote-method="remoteMethod"
                :loading="loading"
                @change="change"
                :clearable="true"
                placeholder="ประเภทค่าใช้จ่าย">
      <el-option  v-for="(data, index) in typeCosts"
                  :key="index"
                  :label="`${data.account_code}: ${data.description}`"
                  :value="data.account_code"
      ></el-option>
    </el-select>
  </div>
</template>

<script>
export default {
    name: 'ir-select-option-policy-type',
    data() {
      return {
        typeCosts: [],
        loading: false,
        type_cost: this.valueTypeCost,
      }
    },
    props: [
      'valueTypeCost',
      'id_account'
    ],
    mounted() {
      this.getTypeCosts({ account_id: '', keyword: '' });
    },
    methods: {
      remoteMethod(query) {
        this.getTypeCosts({ account_id: '', keyword: query });
      },
      getTypeCosts(params) {
        this.loading = true;
        axios.get(`/ir/ajax/lov/account-code-combine`, { params })
        .then(res => {
          let response = res.data
          this.loading = false;
          this.typeCosts = response.data
          if (this.id_account) {
            for (let i in this.typeCosts) {
              let data = this.typeCosts[i]
              if (parseInt(this.id_account) === parseInt(data.account_id)) {
                this.type_cost = data.account_code
                this.callbackTypeCode(data.account_combine, data.account_id)
              }
            }
          }
        });
      },
      change (value) {
        if (value) {
          for (let i in this.typeCosts) {
            let data = this.typeCosts[i]
            if (value === data.account_code) {
              this.callbackTypeCode(data.account_combine, data.account_id)
            }
          }
        } else {
          this.callbackTypeCode('', '')
        }
      },
      callbackTypeCode (combine, id) {
        this.$emit('typeCode', combine, id)
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
      'account_id' (newVal, oldVal) {
        this.getTypeCosts({ account_id: '', keyword: '' });
      },
      'id_account' (newVal, oldVal) {
        this.getTypeCosts({ account_id: '', keyword: '' });
      }
    }
};
</script>

<style>
  .el_select .el-select {
    width: 100%;
  }
</style>
