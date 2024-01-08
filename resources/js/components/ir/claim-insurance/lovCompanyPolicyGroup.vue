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
                :size="size"
                @change="onchange"
                @click.native="onclick"
                :disabled="disabled">ß
               <!--  @focus="onfocus" -->
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
  name: 'ir-claim-insurance-lov-company-policy-group',
  data () {
    return {
      rows: [],
      loading: false,
      result: this.value
    }
  },
  props: [
    'placeholder',
    'attrName',
    'value',
    'size',
    'index',
    'disabled',
    'group_header_id',
    'year'
  ],
  methods: {
    remoteMethod (query) {
      
       
      this.getDataRows({
        company_id: '',
        keyword: query,
        group_header_id: this.group_header_id,
        year: this.year
      });
    },
    getDataRows (params) {
      this.loading = true;
      axios.get(`/ir/ajax/lov/company-percent`, { params })
      .then(({data}) => {
        
        let response = data.data
        this.loading = false;
        this.rows = response;
        
        this.$nextTick(() => {
          this.$emit('response-company-percent', response)
        });
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    onfocus () {
       
      if (this.rows.length === 0 && this.result || this.rows.length > 0 && this.result) {
        this.getDataRows({
          company_id: '',
          keyword: this.result,
          group_header_id: this.group_header_id,
          year: this.year
        });
      } else if (this.rows.length === 0 && !this.result) {
        this.getDataRows({
          company_id: '',
          keyword: '',
          group_header_id: this.group_header_id,
          year: this.year
        });
      }
    },
    onchange (value) {
      let params = {
        code: '',
        desc: '',
        id: '',
        percent: ''
      }
      if (value) {
        for (let i in this.rows) {
          let row = this.rows[i]
          if (row.company_id == value) {
            params.code = row.company_number
            params.desc = row.company_name,
            params.id = value
            params.percent = row.company_percent ? +row.company_percent : 0
          }
        }
      } else {
        params.code = ''
        params.desc = ''
        params.id = ''
        params.percent = ''
      }
      
     this.$emit('change-lov', params)
    },
    onclick () {
       
      if (this.rows.length > 0 && this.result) {
        this.getDataRows({
          company_id: '',
          keyword: this.result,
          group_header_id: this.group_header_id,
          year: this.year
        });
      } else if (this.rows.length > 0 && !this.result) {
        this.getDataRows({
          company_id: '',
          keyword: '',
          group_header_id: this.group_header_id,
          year: this.year 
        });
      }
    }
  },
  mounted() {
  //   
  //     
    //  this.getDataRows({
     //   company_id: this.value,
     //   keyword: '',
     //   group_header_id: this.group_header_id,
    //    year: this.year
  //    })
  },
  watch: {
    'value' (newVal, oldVal) {
   //    
   //    
  //     
     this.result = newVal
  ///    this.getDataRows({
   //     company_id: '',
   //     keyword: newVal,
   //     group_header_id: this.group_header_id,
   //     year: this.year
   //   })
    }
  }
}
</script>
