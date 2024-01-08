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
                @change="onchange"
                @focus="onfocus"
                :size="size"
                :popper-append-to-body="popperBody"
                @click.native="onclick()"
                @blur="onblur"
                :disabled="disabled">
        <el-option  v-for="(data, index) in rows"
                    :key="index"
                    :label="data.vehicle_type_name"
                    :value="data.vehicle_type_code" />
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-settings-vehicle-lov-vehicle-type',
  data() {
    return {
      rows: [],
      loading: false,
      result:  this.value,
      first: true
    };
  },
  props: [
    'value',
    'name',
    'placeholder',
    'size',
    'popperBody',
    'disabled'
  ],
  methods: {
    remoteMethod(query) {
      this.getDataRows({
        keyword: query
      })
    },
    getDataRows(params) {
      this.loading = true;
      axios.get(`/ir/ajax/lov/vehicles-type`, { params })
      .then(({data}) => {
        this.loading = false;
        this.rows = data.data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    onfocus () {
      if (!this.result) {
        this.getDataRows({
          keyword: ''
        })
      }
    },
    onchange (value) {
      let params = {
        code: '',
        desc: '',
        id: ''
      }
      if (value) {
        for (let i in this.rows) {
          let row = this.rows[i]
          if (row.vehicle_type_code == value) {
            params.code = row.vehicle_type_code
            params.desc = row.vehicle_type_name
            params.id = ''
          }
        }
        this.result = value
        this.getDataRows({
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
          keyword: ''
        })
      }
    },
    onblur () {
      this.rows.filter((row) => {
        if (row.vehicle_type_code != this.result) {
          this.result = '';
        }
      })
    }
  },
  mounted() {
    this.getDataRows({
      keyword: ''
    })
  },
  watch: {
    'value' (newVal, oldVal) {
      this.result = newVal
      if (this.first) {
        this.getDataRows({
          keyword: ''
        })
        this.first = false
      }
    },
    'result' (newVal, oldVal) {
      if (!newVal) {
        let params = {
          code: newVal,
          desc: '',
          id: ''
        }
        this.$emit('change-lov', params)
      }
    }
  }
};
</script>

