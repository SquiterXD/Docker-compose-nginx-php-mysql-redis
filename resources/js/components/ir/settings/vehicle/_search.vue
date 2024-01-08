<template>
    <form :action="search_url" id="searchForm">
        <div class="row">
            <div class="col-lg-2 col-sm-2 padding_12 el_field">
                <input type="hidden" name="license_plate" :value="search.license_plate">
                <el-select  v-model="search.license_plate"
                            filterable
                            clearable
                            remote
                            placeholder="ระบุทะเบียนรถ"
                            :remote-method="getLicensePlate">
                    <el-option  v-for="(data, index) in licensePlates"
                                :key="index"
                                :label="data.license_plate"
                                :value="data.license_plate" />
                </el-select>
            </div>
            <div class="col-lg-2 col-sm-2 padding_12">
                <input type="hidden" name="vehicle_type_code" :value="search.vehicle_type_code">
                <el-select  v-model="search.vehicle_type_code"
                            filterable
                            clearable
                            remote
                            placeholder="ระบุประเภทรถ"
                            :remote-method="getVehicleType">
                    <el-option  v-for="(data, index) in vehicleTypes"
                                :key="index"
                                :label="data.vehicle_type_name"
                                :value="data.vehicle_type_code" />
                </el-select>
            </div>
            <div class="col-lg-2 col-sm-2 padding_12">
                <input type="hidden" name="insurance_type_code" :value="search.insurance_type_code">
                <el-select  v-model="search.insurance_type_code"
                            filterable
                            clearable
                            remote
                            placeholder="ระบุประเภทประกันภัย"
                            :remote-method="getInsuranceType">
                    <el-option  v-for="(data, index) in insuranceTypes"
                                :key="index"
                                :label="data.lookup_code+ ' : ' +data.description"
                                :value="data.lookup_code" />
                </el-select>
            </div>
            <div class="col-lg-2 col-sm-2 padding_12 el_field">
                <input type="hidden" name="location_code" :value="search.location_code">
                <location-input-value set-name="FA_LOCATION"
                                    :set-data="search.location_code"
                                    placeholder="รหัสสถานที่"
                                    @getLocation="getLocation" />
            </div>
            <div class="col-lg-2 col-sm-2 padding_12">
                <input type="hidden" name="return_vat_flag" :value="search.return_vat_flag">
                <el-select  v-model="search.return_vat_flag"
                            filterable
                            clearable
                            remote
                            placeholder="ขอคืนภาษี">
                    <el-option  v-for="(data, index) in returnVatLists"
                                :key="index"
                                :label="data.label"
                                :value="data.value" />
                </el-select>
            </div>
            <div class="col-lg-2 col-sm-2 padding_12">
                <input type="hidden" name="active_flag" :value="search.active_flag">
                <el-select  v-model="search.active_flag"
                            filterable
                            clearable
                            remote
                            placeholder="Status">
                    <el-option  v-for="(data, index) in activeLists"
                                :key="index"
                                :label="data.label"
                                :value="data.value" />
                </el-select>
            </div>
        </div>
        <div class="row text-right mt-3">
            <div class="offset-md-9 col-md-3 col-sm-12 padding_12" style="margin-top: auto; margin-bottom: auto;">
                <button type="button" :class="btnTrans.search.class+' btn-lg tw-w-25' " @click="clickSearch">
                    <i :class="btnTrans.search.icon"></i>
                    {{ btnTrans.search.text }}
                </button>
                <button type="button" :class="btnTrans.reset.class+' btn-lg tw-w-25'" @click.prevent="clickCancel()">
                    <i :class="btnTrans.reset.icon"></i>
                    {{ btnTrans.reset.text }}
                </button>
            </div>
        </div>
    </form>
</template>

<script>
import LocationInputValue from './LocationDescInputValueComponent'

export default {
    components: {
        LocationInputValue
    },

    props: ['btnTrans', 'search_url', 'dataSearch'],
    data () {
        return {
            licensePlates: [],
            vehicleTypes: [],
            insuranceTypes: [],
            loading: false,
            search: {
                license_plate: '',
                vehicle_type_code: '',
                insurance_type_code: '',
                return_vat_flag: '',
                location_code: '',
                active_flag: '',
            },
            returnVatLists: [{
                label: 'ขอคืนภาษีได้',
                value: 'Y'
            }, {
                label: 'ขอคืนภาษีไม่ได้',
                value: 'N'
            }],
            activeLists: [{
                label: 'Active',
                value: 'Y'
            }, {
                label: 'Inactive',
                value: 'N'
            }],
        }
    },
    mounted () {
        if (this.dataSearch) {
            this.search.license_plate       = this.dataSearch.license_plate;
            this.search.vehicle_type_code   = this.dataSearch.vehicle_type_code;
            this.search.insurance_type_code = this.dataSearch.insurance_type_code;
            this.search.return_vat_flag     = this.dataSearch.return_vat_flag;
            this.search.location_code       = this.dataSearch.location_code;
            this.search.active_flag         = this.dataSearch.active_flag;
        }
        this.getLicensePlate(this.search.license_plate);
        this.getVehicleType(this.search.vehicle_type_code);
        this.getInsuranceType(this.search.insurance_type_code);
    },
    methods: {
        getLicensePlate(query) {
            this.licensePlates = [];
            axios.get(`/ir/ajax/lov/license-plate`, { 
                params: {
                    license_plate: query,
                }
            })
            .then(({data}) => {
                this.loading = false;
                this.licensePlates = data.data
            })
            .catch((error) => {
                swal("Error", error, "error");
            })
        },
        getVehicleType(query) {
            this.vehicleTypes = [];
            axios.get(`/ir/ajax/lov/vehicles-type`, { 
                params: {
                    keyword: query,
                } 
            })
            .then(({data}) => {
                this.loading = false;
                this.vehicleTypes = data.data
            })
            .catch((error) => {
                swal("Error", error, "error");
            })
        },
        getInsuranceType(query) {
            this.insuranceTypes = [];
            axios.get(`/ir/ajax/lov/renew-type-irm0007`, { 
                params: {
                    keyword: query,
                }
            })
            .then(({data}) => {
                this.loading = false;
                this.insuranceTypes = data.data
            })
            .catch((error) => {
                swal("Error", error, "error");
            })
        },
        getLocation(res){
            this.search.location_code = res.value_code;
        },
        async clickSearch () {
            $( "#searchForm" ).submit();
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
    },
}
</script>