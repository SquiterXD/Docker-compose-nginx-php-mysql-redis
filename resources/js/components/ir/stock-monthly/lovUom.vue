<template>
  <div class="el_field">
    <el-select  v-model="result"
                filterable
                remote
                placeholder="UOM"
                :remote-method="remoteMethod"
                :loading="loading"
                :name="name"
                :clearable="true"
                @change="change"
                @focus="focus"
                size="small">
        <el-option  v-for="(data, index) in rows"
                    :key="index"
                    :label="data.description"
                    :value="data.uom_code" />
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-stock-monthly-lov-uom',
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
    'index'
  ],
  methods: {
    remoteMethod(query) {
      this.getDataRows({
        keyword: query
      })
    },
    getDataRows(params) {
      this.loading = true;
      axios.get(`/ir/ajax/lov/uom`, { params })
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
            if (row.uom_code === value) {
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
  mounted() {
    this.getDataRows({
      keyword: ''
    })
  },
  watch: {
    'value' (newVal, oldVal) {
      // if (newVal) {
        this.result = newVal
      // }
    },
  }
};
</script>

