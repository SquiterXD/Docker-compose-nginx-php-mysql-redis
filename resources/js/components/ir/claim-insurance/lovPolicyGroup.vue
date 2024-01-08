<template>
  <div class="el_field">
    <el-select  v-model="result"
                :placeholder="placeholder"
                :name="name"
                :remote-method="remoteMethod"
                :loading="loading"
                remote
                :clearable="true"
                filterable
                @change="onchange"
                :size="size"
                :popper-append-to-body="popperBody"
                @click.native="onclick"
                :disabled="disabled"
                @focus="onfocus" >
      <el-option  v-for="(data, index) in rows"
                  :key="index"
                  :label="data.group_code + ': ' + data.group_description" 
                  :value="data.group_header_id">
      </el-option>
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-claim-insurance-lov-policy-group',
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
    'size',
    'placeholder',
    'popperBody',
    'disabled'
  ],
  methods: {
    remoteMethod(query) {
      this.getDataRows({
        group_header_id: '',
        keyword: query
        // group_header_id: ''
      })
    },
    getDataRows(params) {
      this.loading = true;
      axios.get(`/ir/ajax/lov/policy-group-header`, { params })
      .then(({data}) => {
        this.loading = false;
        this.rows = data.data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    onfocus () {
       
      if (this.rows.length >= 0 && this.result) {
        this.getDataRows({
          group_header_id: '',
          keyword: this.result
        });
      } else if (this.rows.length >= 0 && !this.result) {
        this.getDataRows({
          group_header_id: '',
          keyword: ''
        });
      }
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
          if (row.group_header_id === value) {
            params.code = row.group_code
            params.desc = row.group_description
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
    onclick () {
       
      if (this.rows.length >= 0 && this.result) {
        this.getDataRows({
          keyword: this.result,
          group_header_id: ''
        });
      } else if (this.rows.length >= 0 && !this.result) {
        this.getDataRows({
          keyword: '',
          group_header_id: ''
        });
      }
    }
  },
  mounted() {
     
    // this.result = this.value ? +this.value : this.value;
    // this.getDataRows({
    //  group_header_id: this.value,
    //  keyword: ''
      
    // })
  },
  // watch: {
  //   'value' (newVal, oldVal) {
  //     this.result = newVal
  //   }
  // }
}
</script>
