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
  name: 'ir-stock-yearly-ceil-ten-currency-input',
  data: function() {
    return {
      isInputActive: false
    }
  },
  props: [
    'value',
    'isChangeCeli',
    'isBlurCeli',
    'sizeSmall',
    'placeholder',
    'name',
    'line_amount',
    'flag'
  ],
  computed: {
    displayValue: {
      get: function() {
        if (this.isInputActive) {
          let value = this.value === undefined || this.value === null ? '' : this.value
          return value.toString()
        } else {
          if (this.value || this.value === 0 && this.value !== undefined && this.value !== null) {
            let num = parseFloat(this.value)
            return num.toFixed(2).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,")
            // return num
          }
        }
      },
      set: function(modifiedValue) {
        let newValue = +modifiedValue;
        if (isNaN(newValue)) {
          newValue = ''
        }
        this.$emit('input', newValue)
      }
    }
  },
  methods: {
    ceilTheTens (value) {
      const vm = this;
      let coverage_amount = 0;
      value = value === '' || value === null || value === undefined ? 0 : value

      if (vm.isBlurCeli) {
        vm.isInputActive = false
      }
      let arrStr = value.toString().split('.')
      let orderLast = parseInt(arrStr[0].charAt(arrStr[0].length - 1))
      let result = 0
      if (arrStr[0].length > 0 && orderLast !== 0) {
        result = Math.ceil(arrStr[0] / 10) * 10;
        if (isNaN(result)) result = ''
        coverage_amount = result
         
        // if (vm.flag === 'add') {
        //   vm.manual_cover_amounts = vm.rows
        // }
         
        vm.$emit('ceil-rows', {coverage_amount: coverage_amount})
        return
      }
      result = arrStr[0]
      if (isNaN(result)) result = ''
      coverage_amount = result
       
      // if (vm.flag === 'add') {
      //   vm.manual_cover_amounts = vm.rows
      // }
       
      vm.$emit('ceil-rows', {coverage_amount: coverage_amount})
      return
    }
  },
  mounted () {
    // $(".numeric").on("keypress keyup blur", function (event) {
    //   $(this).val($(this).val().replace(/[^\d].+/, ""));
    //   if ((event.which < 48 || event.which > 57)) {
    //     event.preventDefault();
    //   }
    // });
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
