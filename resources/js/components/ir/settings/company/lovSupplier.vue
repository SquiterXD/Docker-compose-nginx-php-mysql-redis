<template>
  <div class="el_field">
    <el-select  v-model="result"
                filterable
                remote
                :placeholder="placeholder"
                :remote-method="remoteMethod"
                :loading="loading"
                :name="name"
                :clearable="true"
                @change="change"
                @focus="focus"
                :size="size"
                :popper-append-to-body="popperBody"
                @click.native="onclick()"
                @blur="onblur">
        <el-option  v-for="(data, index) in rows"
                    :key="index"
                    :label="data.vendor_number + ': ' + data.vendor_name"
                    :value="data.vendor_id" />
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-settings-company-lov-supplier',
  data() {
    return {
      rows: [],
      loading: false,
      result:  this.value ? +this.value : this.value,
      first: true
    };
  },
  props: [
    'value',
    'name',
    'placeholder',
    'size',
    'popperBody'
  ],
  methods: {
    remoteMethod(query) {
      this.getDataRows({
        vendor_id: '',
        keyword: query
      })
    },
    getDataRows(params) {
      this.loading = true;
      axios.get(`/ir/ajax/lov/vendor`, { params })
      .then(({data}) => {
        this.loading = false;
        this.rows = data.data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    focus () {
      if (!this.result) {
        this.getDataRows({
          vendor_id: '',
          keyword: ''
        })
      }
    },
    change (value) {
      let params = {
        code: '',
        desc: '',
        id: ''
      }
      if (value) {
        for (let i in this.rows) {
          for (let i in this.rows) {
            let row = this.rows[i]
            if (row.vendor_id == value) {
              params.code = row.vendor_number
              params.desc = row.vendor_name
              params.id = value
            }
          }
        }
        this.result = +value
        this.getDataRows({
          vendor_id: value,
          keyword: ''
        })
      } else {
        params.code = ''
        params.desc = ''
        params.id = ''
        this.result = value
      }
      this.$emit('change-lov', params)
    },
    onclick () {
      if (this.rows.length === 0) {
        this.getDataRows({
          vendor_id: this.result,
          keyword: ''
        })
      }
    },
    onblur () {
      this.rows.filter((row) => {
        if (row.vendor_id != this.result) {
          this.result = '';
        }
      })
    }
  },
  // mounted() {
  //   this.getDataRows({
  //     vendor_id: '',
  //     keyword: ''
  //   })
  // },
  watch: {
    'value' (newVal, oldVal) {
      if (this.first) {
        this.result = newVal ? +newVal : newVal
        this.getDataRows({
          vendor_id: newVal,
          keyword: ''
        })
        this.first = false
      }
    },
    'result' (newVal, oldVal) {
      let params = {
        code: '',
        desc: '',
        id: newVal
      }
      this.$emit('change-lov', params)
    }
  }
};
</script>

