<template>
  <div>
    <div class="row">
      <div class="col-lg-2 col-sm-2 padding_12 el_field">
        <el-select  v-model="search.license_plate"
                    filterable
                    remote
                    placeholder="ระบุทะเบียนรถ"
                    :remote-method="remoteMethod"
                    :loading="loading"
                    :clearable="true"
                    @change="change"
                    @focus="focus">
          <el-option  v-for="(data, index) in license_plates"
                      :key="index"
                      :label="data.license_plate"
                      :value="data.license_plate" />
      </el-select>
      </div>
      <div class="col-lg-2 col-sm-2 padding_12">
        <lov-vehicle-type v-model="search.vehicle_type_code"
                          name="vehicle_type_code"
                          placeholder="ระบุประเภทรถ"
                          size=""
                          :popperBody="true"
                          :disabled="false"
                          @change-lov="getValueVehicleType" />
      </div>
      <div class="col-lg-2 col-sm-2 padding_12 ">
       <lov-insurance-type v-model="search.insurance_type_code"
                          name="insurance_type_code"
                          placeholder="ระบุประเภทประกันภัย"
                          size=""
                          :popperBody="true"
                          :disabled="false"
                          @change-lov="getValueInsuranceType" />
      </div>
      <div class="col-lg-2 col-sm-2 padding_12 el_field">
        <location-input-value set-name="FA_LOCATION"
                              :set-data="search.location_code"
                              placeholder="รหัสสถานที่"
                              @getLocation="getLocation" />
      </div>
      <div class="col-lg-2 col-sm-2 padding_12 el_field">
        <dropdown-return-vat-flag v-model="search.return_vat_flag"
                                  placeholder="ขอคืนภาษี"
                                  name="return_vat_flag"
                                  :disabled="false"
                                  size=""
                                  :popperBody="true"
                                  @change-dropdown="getValueReturnVatFlag" />
      </div>
      <div class="col-lg-2 col-sm-2 padding_12 el_field">
        <dropdown-active-flag v-model="search.active_flag"
                              placeholder="Status"
                              name="active_flag"
                              :disabled="false"
                              size=""
                              :popperBody="true"
                              @change-dropdown="getValueActiveFlag" />
      </div>
    </div>
    <div class="row text-right mt-3">
      <div class="offset-md-9 col-md-3 col-sm-12 padding_12" style="margin-top: auto; margin-bottom: auto;">
        <button type="button" :class="btnTrans.search.class+' btn-lg tw-w-25' " @click.prevent="clickSearch()">
          <i :class="btnTrans.search.icon"></i>
          {{ btnTrans.search.text }}
        </button>
        <button type="button" :class="btnTrans.reset.class+' btn-lg tw-w-25'" @click.prevent="clickCancel()">
          <i :class="btnTrans.reset.icon"></i>
          {{ btnTrans.reset.text }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import lovSearch from './lovSearch'
import lovVehicleType from './lovVehicleType'
import lovInsuranceType from './lovInsuranceType'
import dropdownReturnVatFlag from '../../components/dropdown/returnVatFlag'
import dropdownActiveFlag from '../../components/dropdown/activeFlag'
import LocationInputValue from './LocationDescInputValueComponent'
export default {
  name: 'ir-settings-vehicle-search',
  data () {
    return {
      license_plates: [],
      loading: false,
      create: {
        license_plate: '',
        policy_set_header_id: '',
        group_code: '',
        vehicle_type_code: '',
        vehicle_brand_code: '',
        vehicle_cc: '',
        engine_number: '',
        tank_number: '',
        return_vat_flag: true,
        vat_percent: '',
        revenue_stamp_percent: '',
        insurance_type_code: '',
        asset_number: '',
        account_id: '',
        account_description: '',
        active_flag: true,
        vehicle_id: ''
      }
    }
  },
  props: [
    'search', 'btnTrans'
  ],
  methods: {
    clickSearch () {
      this.$emit('click-search', this.search)
    },
    clickCancel () {
      this.search.license_plate = '';
      this.search.vehicle_type_code = '';
      this.search.insurance_type_code = '';
      this.search.return_vat_flag = '';
      this.search.active_flag = '';
      this.search.location_code = '';
      window.location.href = '/ir/settings/vehicle';
    },
    remoteMethod(query) {
      this.getDataRows({ license_plate: query })
    },
    focus () {
      this.getDataRows({ license_plate: '' })
    },
    change (value) {
      this.$emit('change-lov', value)
    },
    getDataRows(params) {
      this.loading = true;
      axios.get(`/ir/ajax/lov/license-plate`, { params })
      .then(({data}) => {
        this.loading = false;
        this.license_plates = data.data
      })
      .catch((error) => {
        swal("Error", error, "error");
      })
    },
    getDataVehicleType (value) {
      this.search.vehicle_type_code = value
    },
    getValueVehicleType (obj) {
      this.search.vehicle_type_code = obj.code
    },
    getValueInsuranceType (obj){
      this.search.insurance_type_code = obj.code
    },
    getValueReturnVatFlag (value) {
      this.search.return_vat_flag = value
    },
    getValueActiveFlag (value) {
      this.search.active_flag = value
    },
    getLocation(res){
      this.search.location_code = res.value_code;
    }
  },
  components: {
    lovSearch,
    lovVehicleType,
    dropdownReturnVatFlag,
    dropdownActiveFlag,
    lovInsuranceType,
    LocationInputValue
  },
  mounted () {
    this.getDataRows({ license_plate: '' })
  }
}
</script>
