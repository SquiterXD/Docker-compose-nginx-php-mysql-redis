<template>
  <div class="el_field">
    <el-select  v-model="result"
                filterable
                remote
                :placeholder="placeholder"
                :remote-method="remoteMethod"
                :loading="loading"
                :name="attrName"
                :clearable="true"
                :disabled="disabled"
                @change="change"
                @focus="focus">
        <el-option  v-for="(data, index) in rows"
                    :key="index"
                    :label="data[propDescDisp]"
                    :value="data[propCodeDisp]" />
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-settings-vehicle-lov-search',
  data() {
    return {
      rows: [],
      loading: false,
      code: '',
      desc: '',
      result: this.value
    };
  },
  props: [
    'url',
    'value',
    'placeholder',
    'attrName',
    'propCode',
    'propDesc',
    'propCodeDisp',
    'propDescDisp',
    'disabled'
  ],
  computed: {
    setProperty () {
      let data = {}
      data[this.propDesc] = this.desc
      return data
    },
  },
  methods: {
    remoteMethod(query) {
      this.code = ''
      this.desc = query
      this.getDataRows(this.setProperty)
    },
    getDataRows(params) {
      this.loading = true;
      axios.get(`/ir/ajax/lov/${this.url}`, { params })
      .then(({data}) => {
        this.loading = false;
        this.rows = data.data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    focus () {
      this.code = ''
      this.desc = ''
      this.getDataRows(this.setProperty)
    },
    change (value) {
      this.$emit('change-lov', value)
    }
  },
  mounted() {
    this.code = ''
    this.desc = ''
    this.getDataRows(this.setProperty)
  },
  watch: {
    'value' (newVal, oldVal) {
      if (newVal) {
        this.result = newVal
      }
    }
  }
};
</script>

