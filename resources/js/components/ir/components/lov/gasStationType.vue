<template>
  <div class="el_field">
    <el-select  v-model="result"
                :placeholder="placeholder"
                :name="name"
                :remote-method="remoteMethod"
                :loading="loading"
                remote
                :clearable="true"
                @focus="focus"
                filterable
                @change="change"
                :popper-append-to-body="popperBody"
                :size="size">
      <el-option  v-for="(data, index) in rows"
                  :key="index"
                  :label="data.description"
                  :value="data.description">
      </el-option>
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-components-lov-gas-station-type',
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
  ],
  methods: {
    remoteMethod(query) {
      this.getDataRows({
        keyword: query
      })
    },
    getDataRows(params) {
      this.loading = true;
      axios.get(`/ir/ajax/lov/gas-stations-type`, { params })
      .then(({data}) => {
        this.loading = false;
        this.rows = data.data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    focus () {
      if(this.rows.length === 0) {
          this.getDataRows({
            keyword: ''
          })
        }
    },
    change (value) {
      this.$emit('change-lov', value)
    },
  },
  created() {
    this.getDataRows({
      keyword: ''
    })
  }
};
</script>

