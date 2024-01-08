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
  name: 'ir-settings-gas-station-lov-policy-group',
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
    'policy_set_header_id'
  ],
  methods: {
    remoteMethod(query) {
      this.getDataRows({
        policy_set_header_id: '',
        keyword: query
      })
    },
    getDataRows(params) {
      this.loading = true;
      axios.get(`/ir/ajax/lov/policy-set-header?policy_set_header_id&type=40`)
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
  watch: {
    'value' (newVal, oldVal) {
      if (newVal) {
        this.result = newVal
      }
    },
    'policy_set_header_id' (newVal, oldVal) {
       
      if (newVal) {
        this.result = +newVal
      }
      this.getDataRows({
        policy_set_header_id: newVal,
        keyword: ''
      })
    }
  }
}
</script>
