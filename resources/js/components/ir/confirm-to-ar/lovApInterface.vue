<template>
  <div class="el_select">
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
                  :value="data.lookup_code"> <!-- document_number -->
      </el-option>
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-confirm-to-ar-lov-ap-interface',
  data () {
    return {
      rows: [],
      loading: false,
      result: this.value
    }
  },
  props: [
    'name',
    'value',
    'placeholder',
    'popperBody',
    'size'
  ],
  methods: {
    remoteMethod (query) {
      this.gatDataRows({
        keyword: query
      });
    },
    gatDataRows (params) {
      this.loading = true;
      axios.get(`/ir/ajax/lov/ap-interface-type?lookup_code&keyword`, { params })
      .then(({data}) => {
        let response = data.data
        this.loading = false;
        this.rows = response;
      })
      .catch((error) => {
        swal('Error', error, 'error')
      })
    },
    focus (event) {
      this.gatDataRows({
        keyword: ''
      });
    },
    change (value) {
      this.$emit('change-lov', value)
    }
  },
  mounted() {
    this.gatDataRows({ keyword: '' });
  },
  watch: {
    'value' (newVal, oldVal) {
      this.result = newVal
    }
  }
}
</script>
