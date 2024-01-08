<template>
  <div :class="`${sizeSmall ? 'el-input--small' : ''}`">
    <input  v-if="isChangeCeli"
            type="text" 
            v-model="displayValue" 
            @blur="isInputActive = false"
            @focus="isInputActive = true"
            class="form-control el-input__inner text-right"
            autocomplete="off"
            @change="ceilTheTens($event.target.value)"
            :placeholder="placeholder"
            :name="name"
            maxlength="15" />
    <input  v-if="isBlurCeli"
            type="text" 
            v-model="displayValue" 
            @blur="ceilTheTens(value)"
            @focus="isInputActive = true"
            class="form-control el-input__inner text-right"
            autocomplete="off"
            :placeholder="placeholder"
            :name="name"
            maxlength="15" />
  </div>
</template>

<script>
export default {
  name: 'ir-stock-monthly-ceil-ten-currency-input',
  data: function() {
    return {
      isInputActive: false
    }
  },
  props: [
    'value',
    'rows',
    'index',
    'isChangeCeli',
    'isBlurCeli',
    'sizeSmall',
    'placeholder',
    'name',
    'disabled',
    'line_amount',
    'flag'
  ],
  computed: {
    displayValue: {
      get: function() {
        if (this.isInputActive) {
          let value = this.value === undefined || this.value === null ? '' : this.value
          // Cursor is inside the input field. unformat display value for user
          return value.toString()
        } else {
          if (this.value || this.value === 0 && this.value !== undefined && this.value !== null) {
            let num = parseFloat(this.value)
            // User is not modifying now. Format display value for user interface
            return num.toFixed(2).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,")
          }
        }
      },
      set: function(modifiedValue) {
        let newValue = +modifiedValue;
        if (isNaN(newValue)) {
          newValue = ''
        }
        this.$emit('input', newValue)
        // // Recalculate value after ignoring "$" and "," in user input
        // let newValue = parseFloat(modifiedValue.replace(/[^\d\.]/g, ""))
        // // Ensure that it is not NaN
        // if (isNaN(newValue)) {
        //   newValue = ''
        // }
        // // Note: we cannot set this.value as it is a "prop". It needs to be passed to parent component
        // // $emit the event so that parent component gets it
        // this.$emit('input', newValue)
      }
    },
    sizeInput () {
      if (this.sizeSmall) {
        return 'small'
      }
      return ''
    }
  },
  methods: {
    ceilTheTens (value) {
      const vm = this;
      let coverage_amount = 0;
      value = value === '' || value === null || value === undefined ? 0 : value

      if (this.isBlurCeli) {
        this.isInputActive = false
      }
      let arrStr = value.toString().split('.')
      let orderLast = parseInt(arrStr[0].charAt(arrStr[0].length - 1))
      let result = 0
      if (arrStr[0].length > 0 && orderLast !== 0) {
        result = Math.ceil(arrStr[0] / 10) * 10;
        if (isNaN(result)) result = ''
        coverage_amount = result
        // this.rows[this.index].start_date = ''
        // this.rows[this.index].end_date = ''
        // this.rows[this.index].days = ''
         
        // if (this.rows[this.index].flag === 'add') {
        //   this.manual_cover_amounts = this.rows
        // }
         
        vm.$emit('ceil-rows', {coverage_amount: coverage_amount})
        return
      }
      result = arrStr[0]
      if (isNaN(result)) result = ''
      coverage_amount = result
      // this.rows[this.index].start_date = ''
      // this.rows[this.index].end_date = ''
      // this.rows[this.index].days = ''
       
      // if (this.rows[this.index].flag === 'add') {
      //   this.manual_cover_amounts = this.rows
      // }
       
      vm.$emit('ceil-rows', {coverage_amount: coverage_amount})
      return
    }
  },
  watch: {
    'line_amount' (newVal, oldVal) {
       
      if (this.flag === 'add') {
        this.ceilTheTens(newVal)
      }
    }
  }
}
</script>
