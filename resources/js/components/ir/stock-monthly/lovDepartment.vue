<template>
  <div class="el_select">
    <el-select
      style="width: 100%;"
      v-model="result"
      :placeholder="placeholder"
      :name="attrName"
      :remote-method="remoteMethod"
      :loading="loading"
      remote
      :clearable="true"
      @focus="focus"
      filterable
      @change="change">
      <el-option
        v-for="(data, index) in rows"
        :key="index"
        :label="data.department_code + ': ' + data.description"
        :value="data.department_code">
      </el-option>
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-stock-monthly-lov-department',
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
    'value'
  ],
  methods: {
    remoteMethod (query) {
      this.getDataRows({
        department_code: '',
        keyword: query
      });
    },
    getDataRows (params) {
      this.loading = true;
      axios.get(`/ir/ajax/lov/department-code`, { params })
      .then(({data}) => {
        let response = data.data
        this.loading = false;
        this.rows = response;
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    focus (event) {
      this.getDataRows({ department_code: '', keyword: '' });
    },
    change (value) {
      this.$emit('change-lov', value)
    }
  },
  mounted() {
    this.getDataRows({ department_code: '', keyword: '' })
  }
}
</script>
