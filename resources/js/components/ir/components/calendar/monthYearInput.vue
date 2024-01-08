<template>
  <!-- input-group -->
  <div :class="`el-input date ${sizeSmall ? 'el-input--small' : ''}`">
        <!-- style="padding-top: 5px;" -->
    <input  class="input-medium form-control month_input el-input__inner" 
            type="text"
            v-model="month"
            :name="attrName"
            data-provide="datepicker"
            data-date-language="th-th"
            :placeholder="placeholder"
            autocomplete="off">
            <!-- @blur="blur" -->
  </div>
  <!-- <div>
    <el-input :placeholder="placeholder" 
              v-model="month"
              :name="attrName"
              :size="sizeDate"
              data-provide="datepicker"
              data-date-language="th-th"
              autocomplete="off"
              class="input-medium month_input" />
  </div> -->
</template>

<script>
export default {
  name: 'ir-components-calendar-month-year-input',
  data () {
    return {
      month: this.value,
      monthNameShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec']
    }
  },
  props: [
    'attrName',
    'value',
    'sizeSmall',
    'placeholder'
  ],
  computed: {
    sizeDate () {
      if (this.sizeSmall) {
        return 'small'
      }
      return ''
    }
  },
  mounted () {
    let _this = this
    $(document).ready(function () {
       
      $(`input.month_input`).datepicker({
        format: 'mm/yyyy',
        autoclose: true,
        keyboardNavigation: false,
        startView: 'months', 
        minViewMode: "months"
      })
      .on('changeYear', function(e) {
         
      });
      $(`input[name="${_this.attrName}"]`).on('change', function (event) {
         
         
        let monthName = _this.monthNameShort[$(`input[name="${_this.attrName}"]`).datepicker('getDate').getMonth()]
        let getFullYear = $(`input[name="${_this.attrName}"]`).datepicker('getDate').getFullYear()
        let getFullYearStr = getFullYear.toString()
        let yearShort = getFullYearStr.substr(getFullYearStr.length - 2)
         
        let setMonthYearCE = ''
        let value = event.target.value
        if (value && value !== null && value !== undefined) {
          let arrYearCE = value ? value.split('/') : value
          let yearCE = +arrYearCE[1] - 543
          setMonthYearCE = `${arrYearCE[0]}/${yearCE}`
        }
         
        let param = {
          value: value,
          getTime: $(`input[name="${_this.attrName}"]`).datepicker('getDate').getTime(),
          name: `${monthName}-${yearShort}`,
          yearCE: setMonthYearCE
        }
         
        _this.$emit('change-month', param)
      })
    })
  },
  watch: {
    'value' (newVal, oldVal) {
       
      this.month = newVal
    }
  }
  // methods: {
  //   blur (event) {
  //      
  //     this.isInputActive = false
  //     this.$emit('blur-month-year', event.target.value)
  //   }
  // }
}
</script>