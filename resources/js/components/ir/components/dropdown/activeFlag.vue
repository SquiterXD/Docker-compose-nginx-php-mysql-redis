<template>
  <div class="el_field">
    <el-select  v-model="result"
                :placeholder="placeholder"
                :name="name"
                :clearable="true"
                :disabled="disabled"
                :size="size"
                :popper-append-to-body="popperBody"
                @change="onchange">
      <el-option  v-for="(data, index) in rows"
                  :key="index"
                  :label="data.label"
                  :value="data.value" />
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'ir-components-dropdown-active-flag',
  data () {
    return {
      result: this.value,
      rows: [{
        label: 'Active',
        value: 'Y'
      }, {
        label: 'Inactive',
        value: 'N'
      }]
    }
  },
  props: [
    'value',
    'placeholder',
    'name',
    'disabled',
    'size',
    'popperBody'
  ],
  methods: {
    onchange (value) {
      this.$emit('change-dropdown', value)
    }
  },
  watch: {
    'value' (newVal, oldVal) {
      this.result = newVal
    }
  }
}
</script>
