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
                @change="chang"
                @focus="focus">
        <el-option  v-for="(data, index) in rows"
                    :key="index"
                    :label="data[propCodeDisp] + ': ' + data[propDescDisp]"
                    :value="data[propCode]"
        ></el-option>
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-settings-company-lov-search',
  data() {
    return {
      rows: [],
      loading: false,
      result: this.value,
      code: '',
      desc: ''
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
    'propDescDisp'
  ],
  computed: {
    setProperty () {
       
      let data = {}
      data[this.propCode] = this.code
      data[this.propDesc] = this.desc
      return data
    }
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
    chang (value) {
      this.$emit('change-lov', value)
    },
    setCode (value) {
      for (let i in this.rows) {
        let row = this.rows[i]
        let id = row[this.propCode]
        if (id.toString() === value) {
          this.result = row[this.propCode]
          return
        } else {
          this.$emit('id-not-match', this.result)
        }
      }
    }
  },
  mounted() {
    this.code = ''
    this.desc = ''
    this.getDataRows(this.setProperty)
  },
  watch: {
    'rows' (newVal, oldVal) {
      if (newVal) {
        this.setCode(this.value)
      }
    },
    'value' (newVal, oldVal) {
      if (newVal) {
        this.code = newVal
        this.desc = ''
        this.getDataRows(this.setProperty)
      }
    }
  }
};
</script>
