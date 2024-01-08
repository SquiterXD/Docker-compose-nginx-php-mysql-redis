<template>
  <div class="el_field">
    <el-select  v-model="result"
                :placeholder="placeholder"
                remote
                :clearable="true"
                @change="handleChange"
                @click.native="click()"
                :loading = "loading"
                filterable
                :size='sizeDefault'
                :disabled='disabled'>
      <el-option  v-for="(data, index) in list"
                  :key="index"
                  :label="data.description"
                  :value="data.flex_value_meaning">
      </el-option>
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'car-lov-assets',
  props: [
    'value', 'placeholder', 'disabled', 'sizeSmall',
  ],
  data() {
    return {
      loading: false,
      result: this.value,
      list: [],
      sizeDefault: this.sizeSmall ? 'small' : 'large'
    }
  },
  methods: {
    getAssetStatus(params = {keyword: ''}) {
      const vm = this
       vm.loading = true
       axios.get(`/ir/ajax/lov/asset-status`, { params })
      .then(({data: response}) => {
        vm.loading = false
        vm.list = response.data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    click () {
      const vm = this
      vm.getAssetStatus()
    },
    handleChange(value) {
      const vm = this
      vm.$emit('assetStaus', value)
    }
  },
  watch: {
    value(newVal) {
      const vm = this
      vm.result = newVal
    }
  }
}
</script>