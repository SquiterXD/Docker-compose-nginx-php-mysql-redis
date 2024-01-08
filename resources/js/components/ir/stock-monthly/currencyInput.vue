<template>
  <div :class="`el-input ${sizeSmall ? 'el-input--small' : ''}`">
    <input  type="text"
            v-model="dataValue"
            @blur="blur"
            @focus="isInputActive = true"
            class="form-control el-input__inner input-currency  text-right"
            :name="name"
            :placeholder="placeholder"
            autocomplete="off"
            :disabled="disabled"
            />
  </div>
</template>

<script>
export default {
  name: 'ir-components-currency-input',
  data () {
    return {
      isInputActive: false,
      decimalValue: this.decimal === undefined ? 2 : this.decimal,
      dataValue: this.value ? this.value : '',
    }
  },
  props: [
    'value',
    'name',
    'sizeSmall',
    'placeholder',
    'disabled',
    'decimal'
  ],
  computed: {
    // displayValue: {
    //   get: function() {
    //     if (this.isInputActive) {
    //       let value = this.value === undefined || this.value === null ? '' : this.value
    //       return value.toString()
    //     } else {
    //       if (this.value || this.value === 0 && this.value !== undefined && this.value !== null) {
    //         // let num = parseFloat(this.value)
    //         // let covertToCurrency = this.value.toString().split('.')
    //         // let currency = null
    //         // if (covertToCurrency[1] === undefined) {
    //         //   let decimal = parseInt(covertToCurrency[0]).toFixed(this.decimalValue).split('.')[1]
    //         //   currency = `${parseInt(covertToCurrency[0]).toLocaleString()}.${decimal}`
    //         //   return currency
    //         // } else {
    //         //   if (num.toString().split('.')[0] == 0) {
    //         //     let decimal = num.toFixed(this.decimalValue).split('.')[1]
    //         //     return `${num.toString().split('.')[0]}.${decimal}`
    //         //   }
    //         //   let decimal = num.toFixed(this.decimalValue).split('.')[1]
    //         //   let currency =  `${parseInt(covertToCurrency[0]).toLocaleString()}.${decimal}`
    //         //   return currency
    //         // }
    //         return this.value;
    //       }
    //     }
    //   },
    //   set: function(modifiedValue) {
         
    //     let newValue = +modifiedValue;
    //     if (isNaN(newValue)) {
    //       newValue = ''
    //     }
    //     this.$emit('input', newValue)
    //     // // let newValue = parseFloat(modifiedValue.replace(/[^\d\.]/g, ""))
    //     // // if (isNaN(newValue)) {
    //     // //   newValue = ''
    //     // // }
    //   }
    // }
  },
  methods: {
    blur (event) {
      this.isInputActive = false
      this.$emit('blur-currency', event.target.value)
    }
  },
  watch: {
    'value' (newVal, oldVal) {
      this.$emit('watch-value', newVal)
    }
  }
}
</script>


<style scoped>
  .text-right {
    text-align: right;
  }
</style>
