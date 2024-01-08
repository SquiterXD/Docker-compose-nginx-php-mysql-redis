<template>
  <div class="el_field">
    <el-select  v-model="result"
                filterable
                remote
                placeholder="รายการ"
                :remote-method="remoteMethod"
                :loading="loading"
                :name="name"
                :clearable="true"
                :disabled="!assetGroupCode || !rows.length"
                @change="change"
                size="small">
        <el-option  v-for="(data, index) in rows"
                    :key="index"
                    :label="data.description + ' : ' + data.account_combine"
                    :value="data.value" />
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-stock-monthly-lov-group-products',
  data() {
    return {
      rows: [],
      loading: false,
      result: this.value
    };
  },
  props: [
    'value',
    'name',
    'index',
    'isTable',
    'headerRow',
    'assetGroupCode'
  ],
  methods: {
    remoteMethod(query) {
      this.getDataRows({
        policy_set_header_id: this.headerRow.policy_set_header_id,
        asset_group_code: this.assetGroupCode,
        keyword: query
      })
    },
    async getDataRows(params) {
      this.loading = true;
      await axios.get(`/ir/ajax/lov/group-products`, { params })
      .then(({data}) => {
        this.loading = false;
        this.rows = data.data.filter((row) => {
          return row.active_flag === 'Y';
        });
      })
      .catch((error) => {
        swal("Error", error, "error");
      });
    },
    async checkData(){
      await this.getDataRows({
        policy_set_header_id: this.headerRow.policy_set_header_id,
        asset_group_code: this.assetGroupCode,
        keyword: ''
      }).then(() => {
        if(this.rows.length == 1){
          this.result = this.rows[0].value;
          // this.change(this.result);
        }else {
          this.result = null;
        }
      }).then(()=>{
        this.change(this.result);
      });
    },
    focus () {
      this.getDataRows({
        policy_set_header_id: this.headerRow.policy_set_header_id,
        asset_group_code: this.assetGroupCode,
        keyword: ''
      })
    },
    change (value) {
      let params = {
        code: '',
        index: this.index,
        des: ''
      }
      if (value) {
        for (let i in this.rows) {
          for (let i in this.rows) {
            let row = this.rows[i]
            if (row.value === value) {
              params.code = value
              params.desc = row.description
            }
          }
        }
      } else {
        params.code = ''
        params.desc = ''
      }
      this.$emit('change-lov', params)
    },
  },
  // mounted() {
  //   this.getDataRows({
  //     policy_set_header_id: this.headerRow.policy_set_header_id,
  //     asset_group_code: this.assetGroupCode,
  //     keyword: ''
  //   })
  // },
  watch: {
    'value' (newVal, oldVal) {
       
      if (newVal) {
        this.result = newVal
      }
    },
    'assetGroupCode' (newVal, oldVal) {
      if(newVal){
        this.checkData();
      }
    },
  }
};
</script>

