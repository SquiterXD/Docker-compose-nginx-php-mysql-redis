<template>
  <div class="el_field">
    <el-select  v-model="result"
                placeholder="Organization"
                :name="name"
                :clearable="true"
                size="small"
                @change="change"
                @focus="focus"
                :remote-method="remoteMethod"
                :loading="loading"
                filterable
                remote>
        <el-option  v-for="(data, index) in rows"
                    :key="index"
                    :label="data.organization_code + ': ' + data.organization_name"
                    :value="data.organization_code" />
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-stock-monthly-lov-org',
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
      axios.get(`/ir/ajax/lov/org`, { params })
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
        desc: '',
        id: '',
        index: this.index
      }
      if (value) {
        for (let i in this.rows) {
          let row = this.rows[i]
          if (row.organization_code === value) {
            params.code = value
            params.desc = row.organization_name
            params.id = row.organization_id
          }
        }
      } else {
        params.code = ''
        params.desc = ''
        params.id = ''
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

