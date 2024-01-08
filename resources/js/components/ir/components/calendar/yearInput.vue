<template>
  <!-- input-group -->
  <div :class="` date ${sizeSmall ? 'el-input--small' : ''}`">
        <!-- style="padding-top: 5px;" -->
    <input  class="input-medium form-control year_input el-input__inner" 
            type="text"
            v-model="year"
            :name="attrName" 
            data-provide="datepicker"
            data-date-language="th-th"
            :placeholder="placeholder"
            autocomplete="off">
  </div>
</template>

<script>
export default {
  name: 'ir-components-calendar-year-input',
  data () {
    return {
      year: this.value
    }
  },
  props: [
    'attrName',
    'value',
    'sizeSmall',
    'placeholder'
  ],
  mounted () {
    let _this = this
    $(document).ready(function () {
       
      $(`input.year_input`).datepicker({
        format: 'yyyy',
        autoclose: true,
        keyboardNavigation: false,
        startView: 'years',
        minViewMode: 'years'
      })
      $(`input[name="${_this.attrName}"]`).on('change', function (event) {
         
        let value = event.target.value
        let param = {
          value: value,
          getTime: $(`input[name="${_this.attrName}"]`).datepicker('getDate').getTime()
        }
        _this.$emit('change-year', param)
      })
    })
  },
  watch: {
    'value' (newVal, oldVal) {
      this.year = newVal;
    }
  }
}
</script>
