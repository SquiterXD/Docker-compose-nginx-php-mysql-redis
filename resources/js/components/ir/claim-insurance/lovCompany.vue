<template>
  <div class="el_select">
    <el-select  v-model="result"
                :placeholder="placeholder"
                :name="attrName"
                :remote-method="remoteMethod"
                :loading="loading"
                remote
                :clearable="true"
                filterable
                @change="onchange"
                :size="size"
                :disabled="disabled"
                @click.native="onclick">
                <!-- @focus="onfocus" -->
      <el-option  v-for="(data, index) in rows"
                  :key="index"
                  :label="data.company_number + ': ' + data.company_name"
                  :value="data.company_id">
      </el-option>
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-claim-insurance-lov-company',
  data () {
    return {
      rows: [],
      loading: false,
      result: this.value ? +this.value : this.value
    }
  },
  props: [
    'placeholder',
    'attrName',
    'value',
    'size',
    'index',
    'disabled',
    'resData'
  ],
  methods: {
    remoteMethod (query) {
      this.getDataRows({
        company_id: '',
        keyword: query
      });
    },
    getDataRows (params) {
      this.loading = true;
      axios.get(`/ir/ajax/lov/companies`, { params })
      .then(({data}) => {
         
        let response = data.data
        this.loading = false;
        this.rows = response;
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    onfocus () {
      if (this.rows.length === 0 && this.result || this.rows.length > 0 && this.result) {
        this.getDataRows({ company_id: '', keyword: this.result });
      } else if (this.rows.length === 0 && !this.result) {
        this.getDataRows({ company_id: '', keyword: '' });
      }
    },
    onchange (value) {
      let code = ''
      let desc = ''
      let id = ''
      if (value) {
        for (let i in this.rows) {
          let row = this.rows[i]
          if (row.company_id === +value) {
            code = row.company_number
            desc = row.company_name,
            id = value
          }
        }
      } else {
        code = ''
        desc = ''
        id = ''
      }
      let data = {
        code: code,
        desc: desc,
        id: id,
        index: this.index
      }
       
      this.$emit('change-lov', data)
    },
    onclick () {
      if (this.rows.length >= 0 && this.result) {
        this.getDataRows({ company_id: '', keyword: this.result });
      } else if (this.rows.length >= 0 && !this.result) {
        this.getDataRows({ company_id: '', keyword: '' });
      }
    }
  },
  mounted() {
     
    // this.getDataRows({ company_id: this.value, keyword: '' })
  },
  watch: {
    'value' (newVal, oldVal) {
       
      this.result = newVal
      // this.getDataRows({ company_id: this.result, keyword: '' })
    },
    'resData' (newVal, oldVal) {
      this.rows = newVal;
    }
  }
}
</script>
