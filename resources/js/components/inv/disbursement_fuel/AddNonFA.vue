<template>
    <div class="container" v-loading="loading">
        <div class="form-group row">
            <label class="col-md-2 col-form-label required">เลขที่เครื่องจักร</label>
            <div class="col-md-6">
                <el-select
                    v-model="car_license_plate"
                    filterable
                    remote
                    allow-create
                    default-first-option
                    :debounce="2000"
                    :remote-method="getCarInfos"
                    placeholder="เลขที่เครื่องจักร"
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
            <label class="col-md-2 col-form-label required">กลุ่มเครื่องจักร</label>
            <div class="col-md-6">
                <el-select
                    v-model="car_group"
                    filterable
                    remote
                    :debounce="2000"
                    :remote-method="getCarType"
                    placeholder="กลุ่มเครื่องจักร"
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
            <label class="col-md-2 col-form-label required">ชนิดน้ำมันที่เติม</label>
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
            <label class="col-md-2 col-form-label required">หน่วยงานเจ้าของเครื่องจักร</label>
            <div class="col-md-6" v-loading="loadingInput.coaDeptCode">
                <el-select
                    v-model="default_dept_code"
                    filterable
                    remote
                    :debounce="2000"
                    :remote-method="getCOAs"
                    placeholder="หน่วยงานเจ้าของเครื่องจักร"
                    :loading="loadingInput.coaDeptCodes"
                    style="width: 100%"
                >
                    <el-option
                        v-for="(item, index) in coaDeptCodes"
                        :key="index"
                        :label="`${item.department_code} - ${item.description}`"
                        :value="item.department_code"
                    >
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-md-2 col-form-label required">รหัสบัญชี</label>
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
                    <label class="col-md-2 col-form-label required">ขอสิทธิ์จำนวน</label>
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
            carFuels: [],
            aLiasNames: [],
            form: [],
            coaDeptCodes: [],
            selectedCar: {},

            car_license_plate: this.carInfo?.car_license_plate || "",
            account_code: this.carInfo?.account_code || "",
            car_group: this.carInfo?.car_group || "",
            car_fuel: this.carInfo?.car_fuel || "",
            asset_number: "",
            asset_id: this.carInfo?.asset_id || "",
            quota_per_month: "",
            default_dept_code: this.carInfo?.default_dept_code || "",

            loadingInput: {
                carInfos: false,
                carTypes: false,
                carFuels: false,
                aliasName: false,
                coaDeptCodes: false,
            },
            
            loading: false,
        }
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

        if (this.carInfo.default_dept_code) {
            this.getCOAsWithDefault(this.carInfo.default_dept_code);
            this.default_dept_code = this.carInfo.default_dept_code;
        }
    },
    watch: {
        car_license_plate: function (val) {
            this.selectedCar = this.carInfos.find((c) => {
                return c.car_license_plate == this.car_license_plate
            });

            this.car_group = this.selectedCar?.car_group;
            this.car_fuel = this.selectedCar?.car_fuel;
            this.car_user = this.selectedCar?.car_user;
            this.account_code = this.selectedCar?.account_code;
            this.quota_per_month = this.selectedCar?.quota_per_month;
            this.getCOAsWithDefault(this.selectedCar.default_dept_code);
            this.default_dept_code = this.selectedCar?.default_dept_code;
        },

    },

    methods: {
        getMasterData() {
            this.getCarInfos();
            this.getCarType();
            this.getCarFuel();
            this.getAliasName();
            this.getCOAsWithDefault('');
        },
        getCarInfos(query) {
            this.loadingInput.carInfos = true;
            axios
                .get("/inv/ajax/car_info", { params: { text: query, source_data: 'NON_FA' } })
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
        getCOAsWithDefault(query) {
            this.loadingInput.coaDeptCodes = true;
            let getByQuery =   axios.get("/inv/ajax/coa_dept_code", { params: { text: query } })
            let getAll =   axios.get("/inv/ajax/coa_dept_code", { })

            axios
                .all([getByQuery, getAll])
                .then(responses => {
                    responses[0].data.map(i => {
                        this.coaDeptCodes.push(i)
                    })
                    responses[1].data.map(i => {
                        this.coaDeptCodes.push(i)
                    })
                })
                .then(() => {
                    this.loadingInput.coaDeptCodes = false;
                });
        },
        getCOAs(query) {
            axios
                .get("/inv/ajax/coa_dept_code", { params: { text: query, value_set_name: 'TOAT_GL_ACCT_CODE-DEPT_CODE' } })
                .then((response) => {
                    this.coaDeptCodes = response.data;
                })
                .then(() => {
                    this.loadingInput.coaDeptCodes = false;
                });
        },
        refresh() {
            window.location.reload();
        },
        confirm() {
            if ( confirm("ยืนยันการขอสิทธิ์เติมน้ำมัน ?")) {
                this.loading = true;
                axios
                    .get("/inv/disbursement_fuel/update-non-fa-interface", { 
                        params: {
                                car_license_plate: this.car_license_plate,
                                car_group: this.car_group,
                                car_fuel: this.car_fuel,
                                account_code: this.account_code,
                                quota_per_month: this.quota_per_month,
                                default_dept_code: this.default_dept_code,
                        }
                    })
                    .then((res) => {
                        this.$notify({
                            title: 'Success',
                            message: 'Update Successfully',
                            type: 'success'
                        });
                        window.location.replace("/inv/disbursement_fuel/show");
                    })
                    .catch((err) => {
                        this.loading = false;
                        if (err.response.status == 403) {
                            this.$notify.error({
                            title: 'Error',
                            message: err.response.data.msg,
                            duration: 4500,
                            });
                        }

                        let errorMessage = this.$formatErrorMessage(error);
                        this.$notify.error({
                            title: 'Error',
                            dangerouslyUseHTMLString: true,
                            message: errorMessage.outerHTML,
                            duration: 0,
                            });
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