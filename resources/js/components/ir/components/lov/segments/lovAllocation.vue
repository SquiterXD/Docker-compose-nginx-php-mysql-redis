<template>
  <div class="el_select">
    <el-select  v-model="result"
                placeholder="Sub Account"
                :name="attrName"
                @change="change"
                :popper-append-to-body="false"
                :clearable="true"
                :remote-method="remoteMethod"
                :loading="loading"
                remote
                filterable
                :disabled='disabled'
                @focus="focus">
      <el-option  v-for="(data, index) in dataRows"
                  :key="index"
                  :label="data.meaning + ': ' + data.description"
                  :value="data.sub_account">
      </el-option>
    </el-select>
  </div>
</template>

<script>
  export default {
    name: 'ir-components-lov-segments-lov-allocation',
    data () {
      return {
        dataRows: [],
        loading: false,
        result: this.value,
        main_account: ''
      }
    },
    props: [
      'attrName',
      'value',
      'mainAccount',
      'disabled'
    ],
    methods: {
      remoteMethod (query) {
        this.getDataRows({
          sub_account: '',
          keyword: query,
          main_account: this.main_account
        });
      },
      getDataRows (params) {
        this.loading = true;
        axios.get(`/ir/ajax/lov/sub-account`, { params })
        .then(({data}) => {
          let response = data.data
          this.loading = false;
          this.dataRows = response;
        })
        .catch((error) => {
          swal('Error', error, 'error')
        })
      },
      focus (event) {
        this.getDataRows({
          sub_account: '',
          keyword: '',
          main_account: this.main_account
        });
      },
      change (value) {
        if (value) {
          for (let i in this.dataRows) {
            let row = this.dataRows[i]
            if (row.sub_account === value) {
              let data = {
                value: value,
                desc: row.description
              }
              this.$emit('change-lov-segment', data)
              return
            }
          }
        }
        let data = {
          value: value,
          desc: ''
        }
        this.$emit('change-lov-segment', data)
      }
    },
    mounted() {
      this.main_account = this.mainAccount
      this.getDataRows({
        sub_account: '',
        keyword: '',
        main_account: this.main_account
      });
    },
    watch: {
      'value' (newVal, oldVal) {
        this.result = newVal;
        // this.getDataRows({
        //   sub_account: newVal,
        //   keyword: '',
        //   main_account: this.main_account
        // });
      },
      'mainAccount' (newVal, oldVal) {
        this.main_account = newVal
        this.getDataRows({
          sub_account: this.result,
          keyword: '',
          main_account: newVal
        });
      }
    }
  }
</script>

