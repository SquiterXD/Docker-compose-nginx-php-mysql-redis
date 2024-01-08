<template>
  <div :class="`el-input el-input-group el-input-group--append ${sizeSmall ? 'el-input--small' : ''} ${disabled ? 'is-disabled' : ''}`">
    <input  type="text" 
            v-model="displayValue" 
            @blur="blur"
            @focus="focus()"
            class="el-input__inner"
            :name="name"
            :placeholder="placeholder"
            autocomplete="off"
            :disabled="disabled"
            maxlength="15" />
    <div  v-if="showAppend"
          class="el-input-group__append">
      {{wordingAppend}}
    </div>
  </div>
</template>

<script>
export default {
  name: 'ir-components-currency-input-group-append',
  data () {
    return {
      isInputActive: false
    }
  },
  props: [
    'value',
    'name',
    'sizeSmall',
    'placeholder',
    'disabled',
    'showAppend',
    'wordingAppend'
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
    blur (event) {
      this.isInputActive = false
      this.$emit('blur-currency', event.target.value)
    },
    focus () {
       
      this.isInputActive = true
    }
  }
}
</script>
