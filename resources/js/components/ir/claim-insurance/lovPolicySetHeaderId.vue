<template>
  <div class="el_field">
    <el-select  v-model="result"
                :placeholder="placeholder"
                :name="name"
                :remote-method="remoteMethod"
                :loading="loading"
                remote
                :clearable="true"
                @focus="onfocus"
                filterable
                @change="onchange"
                :size="size"
                :popper-append-to-body="popperBody"
                :disabled="isDisabled">
      <el-option  v-for="(data, index) in rows"
                  :key="index"
                  :label="data.policy_set_number + ': ' + data.policy_set_description"
                  :value="data.policy_set_header_id">
      </el-option>
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-claim-insurance-lov-policy-set-header-group',
  // name: 'ir-claim-insurance-lov-policy-set-header',
  data() {
    return {
      rows: [],
      loading: false,
      result: this.value,
      isDisabled: this.disabled === undefined ? false :  this.disabled
    };
  },
  props: [
    'value',
    'name',
    'size',
    'placeholder',
    'popperBody',
    'fixTypeFr',
    'fixTypeSc',
    'disabled',
    'group_header_id'
  ],
  methods: {
    remoteMethod(query) {
      this.getDataRows({
        group_header_id: this.group_header_id,
        keyword: query,
        // type: this.fixTypeFr,
        // type2: this.fixTypeSc
      })
    },
    getDataRows(params) {
      this.loading = true;
      axios.get(`/ir/ajax/lov/policy-set-header-group`, { params })
      // axios.get(`/ir/ajax/lov/policy-set-header`, { params })
      .then(({data}) => {
        this.loading = false;
        this.rows = data.data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    onfocus () {
      this.getDataRows({
        group_header_id: this.group_header_id,
        keyword: '',
        // type: this.fixTypeFr,
        // type2: this.fixTypeSc
      })
    },
    onchange (value) {
      let params = {
        code:'',
        desc:'',
        id: ''
      }
      if (value) {
        for (let i in this.rows) {
          let row = this.rows[i]
          if (row.policy_set_header_id === value) {
            params.code = row.policy_set_number
            params.desc = row.policy_set_description
            params.id = value
          }
        }
      } else {
        params.code = ''
        params.desc =  ''
        params.id = ''
      }
       
      this.$emit('change-lov', params)
    },
  },
  created() {
     
    this.result = this.value
    this.getDataRows({
      group_header_id: this.group_header_id,
      policy_set_header_id: this.value,
      keyword: '',
      // type: this.fixTypeFr,
      // type2: this.fixTypeSc
    })
  },
  watch: {
    'value' (newVal, oldVal) {
      this.result = newVal;
      this.getDataRows({
        group_header_id: this.group_header_id,
        keyword: '',
        // type: this.fixTypeFr,
        // type2: this.fixTypeSc
      })
    }
  }
};
</script>

