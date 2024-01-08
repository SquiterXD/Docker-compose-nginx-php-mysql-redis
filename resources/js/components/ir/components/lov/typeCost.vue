<template>
  <div class="el_field">
    <el-select  v-model="result"
                filterable
                remote
                :placeholder="placeholder"
                :remote-method="remoteMethod"
                :loading="loading"
                :name="name"
                :clearable="true"
                @change="onchange"
                :popper-append-to-body="popperBody"
                :disabled="disabled"
                @click.native="onclick"
              >
        <el-option  v-for="(data, index) in rows"
                    :key="index"
                    :label="data.account_code + ': ' + data.description"
                    :value="data.account_id" />
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-components-lov-type-cost',
  data() {
    return {
      rows: [],
      loading: false,
      code: '',
      desc: '',
      result: this.value,
      account: {
        company: '',
        branch: '',
        department: '',
        product: '',
        source: '',
        account: '',
        subAccount: '',
        projectActivity: '',
        interCompany: '',
        allocation: '',
        futureUsed1: '',
        futureUsed2: '',
        // type_cost: ''
      },
      description: {
        company: '',
        branch: '',
        department: '',
        product: '',
        source: '',
        account: '',
        subAccount: '',
        projectActivity: '',
        interCompany: '',
        allocation: '',
        futureUsed1: '',
        futureUsed2: '',
        // type_cost: ''
      },
      accountId: ''
    };
  },
  props: [
    'value',
    'placeholder',
    'popperBody',
    'name',
    'disabled'
  ],
  methods: {
    remoteMethod(query) {
      this.getDataRows({
        account_id: '',
        keyword: query
      })
    },
    getDataRows(params) {
      this.loading = true;
      axios.get(`/ir/ajax/lov/account-code-combine`, { params })
      .then(({data}) => {
        this.loading = false;
        this.rows = data.data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    onchange (value) {
       
      let params = {
        code: '',
        id: '',
        desc: '',
        account_combine: '',
        account_combine_desc: ''
      }
      if (value) {
        for (let i in this.rows) {
          let row = this.rows[i]
           
          if (row.account_id == value) {
            params.code = row.account_code
            params.id = value
            params.desc = row.description
            params.account_combine = row.account_combine
            params.account_combine_desc = row.account_combine_desc
          }
        }
      } else {
        params.code = ''
        params.id = ''
        params.desc = ''
        params.account_combine = ''
        params.account_combine_desc = ''
      }
      this.result = value;
      this.setPropAccountSplitCombine(params);
      this.$emit('change-lov', params);
    },
    onclick () {
       
        this.getDataRows({ account_id: this.result, keyword: '' });
    },
    setPropAccountSplitCombine (params) {
       
       
      let _this = this;
      if (params.account_combine != '') {
        let accountSplit = params.account_combine.split('.');
        let descSplit = params.account_combine_desc.split('.');
         
         
        let indexCode = 0;
        let indexDesc = 0;
        for (let i in this.account) {
          this.account[i] = accountSplit[indexCode];
          indexCode++
        }
        for (let i in this.description) {
          this.description[i] = descSplit[indexDesc];
          indexDesc++
        }
        this.$emit('split-account', {
          account: params.account_combine,
          description: params.account_combine_desc,
          type_cost: params.code,
          type_cost_id: params.id
        });
      } else {
        this.$emit('split-account', {
          account: '',
          description: '',
          type_cost: '',
          type_cost_id: ''
        });
      }
    },
    receivedDataRows(params) {
       
      let obj = {
        code: '',
        id: '',
        desc: '',
        account_combine: '',
        account_combine_desc: ''
      }
      this.loading = true;
      axios.get(`/ir/ajax/lov/account-code-combine`, { params })
      .then(({data}) => {
        this.loading = false;
        this.rows = data.data
        if (this.accountId && this.accountId !== null && this.accountId !== undefined) {
          if (this.rows.length > 0) {
            for (let i in this.rows) {
              let row = this.rows[i]
              if (row.account_id == this.accountId) {
                this.result = row.account_id;
                obj.code = row.account_code
                obj.id = row.account_id
                obj.desc = row.description
                obj.account_combine = row.account_combine
                obj.account_combine_desc = row.account_combine_desc
              }
            }
          } else {
            this.result = '';
            obj.code = ''
            obj.id = this.accountId
            obj.desc = ''
            obj.account_combine = ''
            obj.account_combine_desc = ''
          }
        } else {
          obj.code = ''
          obj.id = ''
          obj.desc = ''
          obj.account_combine = ''
          obj.account_combine_desc = ''
        }
        this.$emit('change-lov', obj)
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    }
  },
  mounted() {
    //
  },
  watch: {
    'value' (newVal, oldVal) {
      this.result = newVal;
    },
    // 'account_id' (newVal, oldVal) {
    //    
    //   this.accountId = newVal;
    //   this.receivedDataRows({
    //     account_id: newVal,
    //     keyword: ''
    //   })
    // }
  }
};
</script>

