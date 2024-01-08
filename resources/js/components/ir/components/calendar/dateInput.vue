<template>
  <!-- input-group -->
  <div  :class="`el-input date ${sizeSmall ? 'el-input--small' : ''}`">
        <!-- style="padding-top: 5px;" -->
    <input  class="input-medium form-control date_input el-input__inner" 
            type="text"
            v-model="date"
            :name="attrName" 
            data-provide="datepicker"
            data-date-language="th-th"
            :placeholder="placeholder"
            autocomplete="off"
            :disabled="disabled">
  </div>
</template>

<script>
export default {
  name: 'ir-components-calendar-date-input',
  data () {
    return {
      date: this.value
    }
  },
  props: [
    'attrName',
    'value',
    'sizeSmall',
    'placeholder',
    'disabled'
  ],
  computed: {},
  mounted () {
    let _this = this
    $(document).ready(function () {
      $(`input.date_input`).datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        keyboardNavigation: false,
        // updateViewDate: false,
        // immediateUpdates: true
      })
      $(`input[name="${_this.attrName}"]`).on('change', function (event) {
         
        let params = {
          value: event.target.value,
          getTime: $(`input[name="${_this.attrName}"]`).datepicker('getDate').getTime()
        }
        _this.$emit('change-date', params)
         
      })
    })
  },
  watch: {
    'value' (newVal, oldVal) {
      this.date = newVal
    }
  },
  // updated () {
  //   /** SET DATE */
  //    
  //   if (this.value) {
  //     $(`input[name="${this.attrName}"]`).datepicker('update', this.value)
  //   }
  // }
}
</script>
