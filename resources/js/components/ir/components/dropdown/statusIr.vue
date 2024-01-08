<template>
  <div class="el_field">
    <el-select  v-model="result"
                placeholder="สถานะ"
                :name="name"
                :clearable="true"
                @change="change"
                :size="size"
                :popper-append-to-body="popperBody"
                :disabled="disabled">
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
  name: 'ir-components-lov-status-ir',
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
    'popperBody',
    'disabled',
    'placeholder'
  ],
  methods: {
    getDataRows() {
      axios.get(`/ir/ajax/lov/status`)
      .then(({data}) => {
        this.rows = data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    change (value) {
      this.$emit('change-lov', value)
    },
  },
  watch: {
    'value' (newVal, oldVal) {
      this.result = newVal
    }
  },
  created () {
    this.getDataRows()
  }
};
</script>

