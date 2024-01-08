<template>
  <div class="el_select">
    <el-select  v-model="result"
                :placeholder="placeholder"
                :name="attrName"
                :clearable="true"
                :size="size"
                :disabled="disabled"
                @change="change">
                <!-- :remote-method="remoteMethod"
                :loading="loading"
                remote
                @focus="focus"
                filterable -->
      <el-option  v-for="(data, index) in dataRows"
                  :key="index"
                  :label="data[prop]"
                  :value="data[prop]">
      </el-option>
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-stock-yearly-lov-insurance-date',
  data () {
    return {
      dataRows: [],
      loading: false,
      result: this.value
    }
  },
  props: [
    'placeholder',
    'attrName',
    'value',
    'size',
    'year',
    'prop',
    'disabled'
  ],
  methods: {
    remoteMethod (query) {
      this.getDataRows({
        year: this.year ? +this.year - 543 : this.year,
        keyword: query
      });
    },
    getDataRows (params) {
      this.loading = true;
      axios.get(`/ir/ajax/lov/effective-date`, { params })
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
        year: this.year ? +this.year - 543 : this.year,
        keyword: ''
      });
    },
    change (value) {
       
      let params = {}
      for (let i in this.dataRows) {
        let row = this.dataRows[i]
         
        if (row[this.prop] === value) {
          params = row
        }
      }
       
      this.$emit('change-insurance-date', params)
    }
  },
  mounted() {
    this.getDataRows({
      year: this.year ? +this.year - 543 : this.year,
      keyword: ''
    });
  },
  watch: {
    'year' (newVal, oldVal) {
       
      if (newVal) {
        this.getDataRows({
          year: +newVal - 543,
          keyword: ''
        });
      } else {
        this.result = ''
        this.getDataRows({
          year: newVal,
          keyword: ''
        });
      }
    }
  }
}
</script>
