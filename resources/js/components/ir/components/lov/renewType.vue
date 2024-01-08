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
                  :value="data.lookup_code">
      </el-option>
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-components-lov-renew-type',
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
        renew_type: query
      })
    },
    getDataRows(params) {
      this.loading = true;
      axios.get(`/ir/ajax/lov/renew-type`, { params })
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
        renew_type: ''
      })
    },
    change (value) {
      this.$emit('change-lov', value)
    },
  },
  mounted() {
    this.getDataRows({
      renew_type: ''
    })
  }
};
</script>

