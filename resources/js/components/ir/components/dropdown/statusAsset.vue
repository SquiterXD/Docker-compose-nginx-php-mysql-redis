<template>
  <div class="el_field">
    <el-select  v-model="result"
                :placeholder="placeholder"
                :name="name"
                :clearable="true"
                @change="onchange"
                :size="size"
                :popper-append-to-body="popperBody"
                :disabled="disabled">
      <el-option  v-for="(data, index) in rows"
                  :key="index"
                  :label="data.label"
                  :value="data.value">
      </el-option>
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-components-dropdown-status-asset',
  data() {
    return {
      rows: [{
        label: 'Active',
        value: 'Y'
      }, {
        label: 'Inactive',
        value: 'N'
      }],
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
    onchange (value) {
      this.$emit('change-dropdown', value)
    },
  },
  watch: {
    'value' (newVal, oldVal) {
      this.result = newVal
    }
  }
};
</script>

