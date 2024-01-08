<template>
  <div class="el_field">
    <el-select  v-model="result"
                filterable
                remote
                :placeholder="placeholder"
                :remote-method="remoteMethod"
                :loading="loading"
                :clearable="true"
                @change="change"
                @focus="focus"
                :name="name"
                size="small">
      <el-option  v-for="(data, index) in rows"
                  :key="index"
                  :label="data.sub_group_code + ': ' + data.sub_group_description"
                  :value="data.sub_group_code" />
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-stock-monthly-lov-location',
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
    'isTable',
    'index',
    'placeholder',
    'headerRow'
  ],
  methods: {
    remoteMethod(query) {
      this.getDataRows({
        policy_set_header_id: this.headerRow.policy_set_header_id,
        keyword: query
        // header_id: this.headerRow.header_id,
        // status: this.search.status,
        // location: query
      })
    },
    getDataRows(params) {
      this.loading = true;
      axios.get(`/ir/ajax/lov/sub-group`, { params })
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
        policy_set_header_id: this.headerRow.policy_set_header_id,
        keyword: ''
        // header_id: this.headerRow.header_id,
        // status: this.search.status,
        // location: this.search.sub_group_code
      })
    },
    change (value) {
      let params = {
        code: '',
        desc: '',
        index: this.index
      }
      if (value) {
        // if (this.isTable) {
          for (let i in this.rows) {
            let row = this.rows[i]
            if (row.sub_group_code === value) {
              params.code = value
              params.desc = row.sub_group_description
            }
          }
        // }
      } else {
        params.code = ''
        params.desc = ''
      }
      this.$emit('change-lov-location', params)
    },
  },
  mounted() {
    this.getDataRows({
      policy_set_header_id: this.headerRow.policy_set_header_id,
      keyword: ''
      // header_id: this.headerRow.header_id,
      // status: this.search.status,
      // location: this.search.sub_group_code
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

