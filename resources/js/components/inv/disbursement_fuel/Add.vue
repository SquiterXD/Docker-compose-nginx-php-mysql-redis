<template>
    <div class="container" v-loading="loading">
        <div class="form-group row">
            <label class="col-md-2 col-form-label">ทะเบียนรถ</label>
            <div class="col-md-6">
                <el-select
                    v-model="car_license_plate"
                    filterable
                    remote
                    :debounce="2000"
                    :remote-method="getCarInfos"
                    placeholder="ทะเบียนรถ"
                    :loading="loadingInput.carInfos"
                    style="width: 100%"
                >
                    <el-option
                        v-for="(item, index) in carInfos"
                        :key="index"
                        :label="item.car_license_plate"
                        :value="item.car_license_plate"
                    >
                    </el-option>
                </el-select>
            </div>
        </div>
         <div class="form-group row">
            <label class="col-md-2 col-form-label">รหัสสินทรัพย์</label>
            <div class="col-md-6">
                <input
                    type="text"
                    readonly
                    class="form-control"
                    v-if="selectedCar.asset_number"
                    :value="selectedCar.asset_number || ''"
                />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label">กลุ่มรถยนต์</label>
            <div class="col-md-6">
                <el-select
                    v-model="car_group"
                    filterable
                    remote
                    :debounce="2000"
                    :remote-method="getCarType"
                    placeholder="กลุ่มรถยนต์"
                    :loading="loadingInput.carTypes"
                    style="width: 100%"
                >
                    <el-option
                        v-for="(item, index) in carTypes"
                        :key="index"
                        :label="item.description"
                        :value="item.flex_value"
                    >
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label">ยี่ห้อรถ</label>
            <div class="col-md-6">
                <el-select
                    v-model="car_brand"
                    filterable
                    remote
                    :debounce="2000"
                    :remote-method="getCarBrand"
                    placeholder="ยี่ห้อรถ"
                    :loading="loadingInput.carBrands"
                    style="width: 100%"
                >
                    <el-option
                        v-for="(item, index) in carBrands"
                        :key="index"
                        :label="item.description"
                        :value="item.flex_value"
                    >
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label">ชนิดน้ำมันที่เติม</label>
            <div class="col-md-6">
                <el-select
                    v-model="car_fuel"
                    filterable
                    remote
                    :debounce="2000"
                    :remote-method="getCarFuel"
                    placeholder="ชนิดน้ำมันที่เติม"
                    :loading="loadingInput.carFuels"
                    style="width: 100%"
                >
                    <el-option
                        v-for="(item, index) in carFuels"
                        :key="index"
                        :label="item.description"
                        :value="item.segment1"
                    >
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label">ภาษีรถยนต์ขอคืนได้</label>
            <div class="col-md-6">
                <el-select
                    v-model="tax_refund_yn"
                    placeholder="ภาษีรถยนต์ขอคืนได้"
                    style="width: 100%"
                >
                    <el-option label="Y" value="Y"></el-option>
                    <el-option label="N" value="N"></el-option>
                </el-select>
            </div>
        </div>
        <div class="form-group row" hidden>
            <label class="col-md-2 col-form-label">รหัสพนักงาน</label>
            <div class="col-md-6">
                <input
                    type="text"
                    readonly
                    class="form-control-plaintext"
                    v-if="selectedCar.car_user"
                    :value="selectedCar.car_user || ''"
                />
            </div>
        </div>
        <div class="form-group row" hidden>
            <label class="col-md-2 col-form-label">ประเภท</label>
            <div class="col-md-6">
                <el-input disabled></el-input>
            </div>
        </div>
        <div class="form-group row" hidden>
            <label class="col-md-2 col-form-label">ตำแหน่ง</label>
            <div class="col-md-6">
                <el-input disabled></el-input>
            </div>
        </div>
        <div class="form-group row" hidden>
            <label class="col-md-2 col-form-label">สังกัด</label>
            <div class="col-md-6">
                <input
                    type="text"
                    readonly
                    class="form-control-plaintext"
                    v-if="selectedCar.department"
                    :value="selectedCar.department.description || ''"
                />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label">รหัสบัญชี</label>
            <div class="col-md-6">
                <el-select
                    v-model="account_code"
                    filterable
                    remote
                    :debounce="2000"
                    :remote-method="getAliasName"
                    placeholder="รหัสบัญชี"
                    :loading="loadingInput.aliasName"
                    style="width: 100%"
                >
                    <el-option
                        v-for="(item, index) in aLiasNames"
                        :key="index"
                        :label="`${item.alias_name} - ${item.description}`"
                        :value="item.alias_name"
                    >
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-md-2 col-md-6">
                {{ this.acc_segment }}
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">ขอสิทธิ์จำนวน</label>
                    <div class="col-md-2 p-0">
                        <el-input 
                            type="number"
                            v-model="quota_per_month"
                        >
                        </el-input>  
                    </div>
                    <label class="col-md-2 col-form-label">ลิตร / เดือน</label>
                </div>
            </div>
        </div>

        <div class="col-md-12 text-right mt-4 p-0">
            <el-button class="btn-success" type="primary" @click="confirm()">ยืนยัน</el-button>
            <el-button class="text-refresh" type="text" @click.native.prevent="refresh()">ล้างข้อมูล</el-button>
        </div>

    </div>
</template>

<style scoped>
    .btn-success {
        background-color: #1ab394;
        border-color: #1ab394;
    }
    .btn-cancle {
        background-color: #EC4958;
        border-color: #EC4958;
        color: white;
    }
    .text-refresh {
        color: #ec4958;
    }
</style>

<script>
export default {
    props: ["carInfo"],
    data() {
        return {
            carInfos: [],
            carTypes: [],
            carBrands: [],
            carFuels: [],
            aLiasNames: [],
            form: [],
            selectedCar: {},

            car_license_plate: this.carInfo?.car_license_plate || "",
            account_code: this.carInfo?.account_code || "",
            car_group: this.carInfo?.car_group || "",
            car_brand: this.carInfo?.car_brand || "",
            car_fuel: this.carInfo?.car_fuel || "",
            asset_number: "",
            asset_id: this.carInfo?.asset_id || "",
            department_code: "",
            quota_per_month: "",
            car_vehicle_number: this.carInfo?.car_vehicle_number || "", 
            tax_refund_yn: this.carInfo?.tax_refund_yn || "",

            loadingInput: {
                carInfos: false,
                carTypes: false,
                carBrands: false,
                carFuels: false,
                aliasName: false,
            },
            
            loading: false,
        }
    },

    watch: {
        car_license_plate: function (val) {
            this.selectedCar = this.carInfos.find((c) => {
                return c.car_license_plate == this.car_license_plate
            });

            this.asset_number = this.selectedCar?.asset_number;
            this.car_group = this.selectedCar?.car_group;
            this.car_brand = this.selectedCar?.car_brand;
            this.car_fuel = this.selectedCar?.car_fuel;
            this.car_user = this.selectedCar?.car_user;
            this.account_code = this.selectedCar?.account_code;
            this.department_code = this.selectedCar?.department_code;
            this.quota_per_month = this.selectedCar?.quota_per_month;
            this.asset_id = this.selectedCar?.asset_id;
            this.tax_refund_yn = this.selectedCar?.tax_refund_yn;
        },

    },

    created: function() {
        this.getMasterData();
	},

    mounted() {
        if (this.carInfo) {
            this.selectedCar = this.carInfo;
            this.account_code = this.selectedCar?.account_code;
            this.quota_per_month = this.selectedCar?.quota_per_month;
        }
    },

    methods: {
        getMasterData() {
            this.getCarInfos();
            this.getCarType();
            this.getCarBrand();
            this.getCarFuel();
            this.getAliasName();
        },
        getCarInfos(query) {
            this.loadingInput.carInfos = true;
            axios
                .get("/inv/ajax/car_info", { params: { text: query, source_data: 'FA' } })
                .then((response) => {
                    this.carInfos = response.data;
                })
                .catch((err) => {
                    console.log("error get car info")
                })
                .then(() => {
                    this.loadingInput.carInfos = false;
                });
        },
        getCarType(query) {
            this.loadingInput.carTypes = true;
            axios
                .get("/inv/ajax/car_types", { params: { text: query } })
                .then((response) => {
                    this.carTypes = response.data;
                })
                .catch((err) => {
                    console.log("error get car types")
                })
                .then(() => {
                    this.loadingInput.carTypes = false;
                });
        },
        getCarBrand(query) {
            this.loadingInput.carBrands = true;
            axios
                .get("/inv/ajax/car_brands", { params: { text: query } })
                .then((response) => {
                    this.carBrands = response.data;
                })
                .catch((err) => {
                    console.log("error get car brands")
                })
                .then(() => {
                    this.loadingInput.carBrands = false;
                });
        },
        getCarFuel(query) {
            this.loadingInput.carFuels = true;
            axios
                .get("/inv/ajax/car_fuels", { params: { text: query } })
                .then((response) => {
                    this.carFuels = response.data;
                })
                .catch((err) => {
                    console.log("error get car fuels")
                })
                .then(() => {
                    this.loadingInput.carFuels = false;
                });
        },
        getAliasName(query) {
            this.loadingInput.aliasName = true;
            axios
                .get("/inv/ajax/alias_name", { params: { text: query, prefix: "T21" } })
                .then((response) => {
                this.aLiasNames = response.data;
                })
                .catch((err) => {
                console.log("error get alias name");
                })
                .then(() => {
                this.loadingInput.aliasName = false;
                });
        },
        refresh() {
            window.location.reload();
        },
        confirm() {
            if ( confirm("ยืนยันการขอสิทธิ์เติมน้ำมัน ?")) {
                this.loading = true;
                axios
                    .get("/inv/disbursement_fuel/update-car-interface", { 
                        params: {
                                car_license_plate: this.car_license_plate,
                                asset_id: this.asset_id,
                                car_group: this.car_group,
                                car_brand: this.car_brand,
                                car_fuel: this.car_fuel,
                                account_code: this.account_code,
                                quota_per_month: this.quota_per_month,
                                tax_refund_yn: this.tax_refund_yn,
                        }
                    })
                    .then((res) => {
                        this.$notify({
                            title: 'Success',
                            message: 'Update Successfully',
                            type: 'success'
                        });
                        window.location("/inv/disbursement_fuel/show");
                    })
                    .catch((err) => {
                        this.loading = false;
                        
                        let errorMessage = this.$formatErrorMessage(err);
                        var items = errorMessage.getElementsByTagName("li");
                        for(var i = 0, size = items.length; i< size; i++){
                            this.$notify.error({
                            title: 'Error',
                            message: items[i].innerHTML,
                            duration: 2000,
                            });
                        }
                    });
            }
           
            
        }
    },
    computed: {
        acc_segment: function() {
            let selectedAliasName = this.aLiasNames.find((a) => {
                return a.alias_name == this.account_code;
            })?.template || '';

            return selectedAliasName;
        }
    }
}
</script>