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
                :disabled="disabled"
                @change="change"
                @focus="focus">
        <el-option  v-for="(data, index) in rows"
                    :key="index"
                    :label="data.policy_set_number + ' : ' + data.policy_set_description"
                    :value="data.policy_set_header_id" />
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-settings-vehicle-lov-policy-group',
  data () {
    return {
      rows: [],
      loading: false,
      result: this.value
    }
  }, 
  props: [
    'value',
    'name',
    'disabled',
    'placeholder',
    'assetId'
  ],
  methods: {
    remoteMethod(query) {
      this.getDataRows({
        policy_set_header_id: '',
        asset_id: this.assetId,
        keyword: query
      })
    },
    getDataRows(params) {
      this.loading = true;
      axios.get(`/ir/ajax/lov/policy-set-header?policy_set_header_id&type=30`)
      .then(({data}) => {
        this.loading = false;
        this.rows = data.data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    focus () {
      this.getDataRows({
        asset_id: this.assetId,
        policy_set_header_id: '',
        keyword: ''
      })
    },
    change (value) {
      let param = {
        code: '',
        id: '',
        desc: ''
      }
      if (value) {
        for (let i in this.rows) {
          let data = this.rows[i]
          if (data.policy_set_header_id === value) {
            param.code = data.policy_set_number
            param.id = value
            param.desc = data.policy_set_description
          }
        }
      } else {
        param.code = ''
        param.id = ''
        param.desc = ''
      }
      this.$emit('change-lov-policy-group', param)
    }
  },
  mounted() {
     this.result = this.value ? +this.value : this.value;
     this.getDataRows({
      asset_id: this.assetId,
      policy_set_header_id: this.value,
      keyword: ''
    })
  },
  watch: {
    'value' (newVal, oldVal) {
      this.result = newVal ? +newVal : newVal;
      this.getDataRows ({
        asset_id: this.assetId,
        keyword: ''
      })
    },
  }
}
</script>
