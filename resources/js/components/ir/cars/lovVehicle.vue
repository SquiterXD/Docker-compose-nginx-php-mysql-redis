<template>
  <div class="el_field">
    <el-select  v-model="result"
                filterable
                remote
                :clearable="true"
                :size="sizeDefault"
                :remote-method="getLovVehicles"
                placeholder="ทะเบียนรถยนต์"
                @change="handleChange"
                @click.native="click($event)"
                class="w-100"
                :disabled='disabled'
                :popper-append-to-body="popperBody"
                :loading = "loading">
      <el-option  v-for="(data, index) in list"
                  :key="index"
                  :label="`${data.license_plate}`"
                  :value="data.license_plate">
      </el-option>
    </el-select>
  </div>
</template>

<script>
export default {
  name: 'car-lov-vehicles',
  data() {
    return {
      result: this.value,
      list: [],
      sizeDefault: this.sizeSmall ? 'small' : 'large',
      loading: false
    }
  },
  props: ['value','popperBody', 'sizeSmall', 'disabled', 'paramsQuery'],
  // mounted() {
  //   const vm = this
  //   vm.getLovVehicles(this.paramsQuery)
  // },
  methods: {
    getLovVehicles(query) {
      this.loading = true;
      const vm = this
      axios.get('/ir/ajax/lov/vehicle-license-plate', {
                params: {
                    license_plate: query,
                    group: this.paramsQuery.group,
                }
              })
      .then(({data:response}) => {
        vm.list = response.data
        vm.loading = false;
      })
      .catch((error) => {
        swal("Error", error, "error")
      })
    },
    click (evt) {
      const vm = this
      if(evt.target.value){
        vm.getLovVehicles({keyword:evt.target.value})
      } else {
        vm.getLovVehicles(this.paramasQuery)
      }
    },
    handleChange(value) {
      const vm = this
      let result =  vm.list.find((row) => row.license_plate === value)
      vm.$emit('vehicle', result)
    },
    onclick() {
      const vm = this
      vm.getLovVehicles({renew_type:''})
    }
  },
  watch: {
    value(newVal) {
      const vm = this
      vm.result = newVal
    },
    'paramsQuery.license_plate'(newVal) {
      this.getLovVehicles(this.paramsQuery)
       if(this.paramsQuery.renew_type)
      {this.getLovVehicles(this.paramsQuery)
      }else{this.getLovVehicles({renew_type:''})}
    },
    'paramsQuery.renew_type'(newVal) {
      this.getLovVehicles(this.paramsQuery)
    },
    'paramsQuery.group'(newVal) {
      this.getLovVehicles(this.paramsQuery)
    },
  }
}
</script>