<template>
  <div class="el_field">
    <el-select  v-model="data"
                filterable
                remote
                :clearable="true"
                :size='sizeDefault'
                :loading="loading"
                placeholder="ประเภทการต่ออายุ"
                @change="changeRenewType"
                @click.native="click($event)"
                :disabled='disabled'
                :popper-append-to-body="popperBody">
      <el-option  v-for="(data) in renewTypeList"
                  :key="data.rn"
                  :label="`${data.description}`"
                  :value="data.description">
      </el-option>
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'car-renew-type',
  data() {
    return {
      loading: false,
      data: this.value,
      renewTypeList: [],
      sizeDefault: this.sizeSmall ? 'small' : 'large'
    }
  },
  props: ['value','popperBody', 'disabled', 'sizeSmall'],
  // mounted() {
  //   const vm = this
  //   vm.getLovGasStationType()
  // },
  methods: {
    getLovGasStationType(params = {keyword: ''}) {
      const vm = this
      vm.loading = true
      axios.get('/ir/ajax/lov/renew-type', {params})
      .then(({data:response}) => {
        vm.loading = false
        vm.renewTypeList = response.data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    click (evt) {
      const vm = this
      if(evt.target.value){
        vm.getLovGasStationType({keyword:evt.target.value})
      } else {
        vm.getLovGasStationType(this.paramasQuery)
      }
    },
    changeRenewType(value) {
      const vm = this

      const find = this.renewTypeList.find((item)=>{
        return item.meaning === value;
      })

      vm.$emit('renewType', find)
    }
  },
  watch: {
    value(newVal) {
      const vm = this
      vm.data = newVal
    }
  },
  created(){
    // this.getLovGasStationType();
  },
}
</script>