<template>
  <div :class="`${sizeSmall ? 'el-input--small' : ''}`">
    <input  v-if="isChangeCeli"
            type="text" 
            v-model="displayValue" 
            @blur="isInputActive = false"
            @focus="isInputActive = true"
            class="form-control el-input__inner text-right"
            autocomplete="off"
            @change="ceilThousand($event.target.value)"
            :placeholder="placeholder"
            maxlength="15" />
    <input  v-if="isBlurCeli"
            type="text" 
            v-model="displayValue" 
            @blur="ceilThousand(value)"
            @focus="isInputActive = true"
            class="form-control el-input__inner text-right"
            autocomplete="off"
            :placeholder="placeholder"
            maxlength="15" />
  </div>
</template>

<script>
export default {
  name: 'ir-asset-plan-ceil-thousand-currency-input',
  data: function() {
    return {
      isInputActive: false,
      cover_amount_edit: ''
    }
  },
  props: [
    'value',
    'row',
    'isChangeCeli',
    'isBlurCeli',
    'insurance_amount_master',
    'vat_amount_master',
    'sizeSmall',
    'placeholder'
  ],
  computed: {
    displayValue: {
      get: function() {
        this.cover_amount_edit = this.value
        if (this.isInputActive) {
          let value = this.value === undefined || this.value === null ? '' : this.value
          return value.toString()
        } else {
          if (this.value || this.value === 0 && this.value !== undefined && this.value !== null) {
            let num = parseFloat(this.value)
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
      }
    }
  },
  methods: {
    ceilThousand (value) {
      value = value === '' || value === null || value === undefined ? '0' : value
      let replace = ''
      if (this.isBlurCeli) {
        this.isInputActive = false
        replace = this.displayValue === undefined || this.displayValue === null ? '' :  this.displayValue
      } else if (this.isChangeCeli) {
        replace = value.replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,")
      }
      let arrStr = replace.toString().split(',')
      let arrFull = value.toString().split('.')
      let arrLast = arrStr.length - 1
      let orderLast = parseInt(arrStr[arrLast])
      let result = ''
      if (orderLast <= 999) {
        result = Math.ceil(arrFull[0] / 1000) * 1000;
        if (isNaN(result)) {
          result = ''
        }
      }
      this.$emit('value-cover-amount', result)
    },
    calFromCoverageAmountFlgEdit (insurance_amount_master, vat_amount_master) {
      if (this.isChangeCeli) {
        let value = this.cover_amount_edit
        if (value === '' || value === null || value === undefined) value = 0
      }
    }
  }
}
</script>
