<template>
  <div class="el_field">
    <el-select  v-model="result"
                filterable
                remote
                placeholder="ประเภทค่าใช้จ่าย"
                :remote-method="remoteMethod"
                :loading="loading"
                name="type_cost"
                :clearable="true"
                @change="change"
                @focus="focus">
        <el-option  v-for="(data, index) in rows"
                    :key="index"
                    :label="data.account_code + ': ' + data.description"
                    :value="data.account_id" />
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-settings-gas-station-lov-type-cost',
  data() {
    return {
      rows: [],
      loading: false,
      code: '',
      desc: '',
      result: this.value
    };
  },
  props: [
    'value',
    'account_id'
  ],
  methods: {
    remoteMethod(query) {
      this.getDataRows({
        account_id: '',
        keyword: query
      })
    },
    getDataRows(params) {
      let obj = {
        code: '',
        id: '',
        account_combine: '',
      }
      this.loading = true;
      axios.get(`/ir/ajax/lov/account-code-combine`, { params })
      .then(({data}) => {
        this.loading = false;
        this.rows = data.data
        if (this.account_id && this.account_id !== null && this.account_id !== undefined) {
          for (let i in this.rows) {
            let row = this.rows[i]
            if (row.account_id == this.account_id) {
              this.result = row.account_id
              obj.code = row.account_code
              obj.id = row.account_id
              obj.account_combine = row.account_combine
            }
          }
        } else {
          obj.code = ''
          obj.id = ''
          obj.account_combine = ''
        }
        this.$emit('change-lov', obj)
         
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    focus () {
      this.getDataRows({
        account_id: '',
        keyword: ''
      })
    },
    change (value) {
       
      let params = {
        code: '',
        id: '',
        account_combine: '',
      }
      if (value) {
        for (let i in this.rows) {
          let row = this.rows[i]
           
          if (row.account_id == value) {
            params.code = value
            params.id = row.account_id
            params.account_combine = row.account_combine
          }
        }
      } else {
        params.code = ''
        params.id = ''
        params.account_combine = ''
      }
      this.$emit('change-lov', params)
    }
  },
  created() {
    this.getDataRows({
      account_id: '',
      keyword: ''
    })
  },
  watch: {
    'account_id' (newVal, oldVal) {
      this.getDataRows({
        account_id: newVal,
        keyword: ''
      })
    }
  }
};
</script>

