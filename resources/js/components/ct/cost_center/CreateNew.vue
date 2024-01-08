<template>
    <div v-loading="loading">
        <div class="container">
            <div class="text-title m-2">
                ศูนย์ต้นทุน
            </div>
            <div class="">
                <div class="">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label"
                            >รหัสศูนย์ต้นทุน</label
                        >
                        <div class="col-md-6 flex-wrap">
                            <el-input
                                :disabled="isEdit"
                                placeholder="รหัสศูนย์ต้นทุน"
                                v-model="form.code"
                            ></el-input>
                            <div class="error-message" v-if="form_error.code">
                                <strong class="font-bold">{{
                                    form_error.code.title
                                }}</strong>
                                <span class="block sm:inline">
                                    {{ form_error.code.message }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label"
                            >ชื่อศูนย์ต้นทุน</label
                        >
                        <div class="col-md-6 flex-wrap">
                            <el-input
                                placeholder="ชื่อศูนย์ต้นทุน"
                                v-model="form.name"
                            ></el-input>
                            <div class="error-message" v-if="form_error.name">
                                <strong class="font-bold">{{
                                    form_error.name.title
                                }}</strong>
                                <span class="block sm:inline">
                                    {{ form_error.name.message }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">
                            ประเภทศูนย์ต้นทุน
                        </label>
                        <div class="col-md-6 flex-wrap">
                            <el-select
                                v-model="form.cost_group_code"
                                filterable
                                placeholder="ประเภทศูนย์ต้นทุน"
                                style="width: 100%"
                            >
                                <el-option
                                    v-for="(item, index) in cost_center_group_v"
                                    :key="index"
                                    :label="item.description"
                                    :value="item.cost_group_code"
                                >
                                </el-option>
                            </el-select>
                            <div
                                class="error-message"
                                v-if="form_error.cost_group_code"
                            >
                                <strong class="font-bold">{{
                                    form_error.cost_group_code.title
                                }}</strong>
                                <span class="block sm:inline">
                                    {{ form_error.cost_group_code.message }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">
                            INV.Org
                        </label>
                        <div class="col-md-6 flex-wrap">
                            <el-select
                                v-model="form.organization_code"
                                filterable
                                placeholder="INV Org"
                                style="width: 100%"
                            >
                                <el-option
                                    v-for="(item, index) in inv_org"
                                    :key="index"
                                    :label="
                                        `${item.organization_code} - ${item.organization_name}`
                                    "
                                    :value="item.organization_code"
                                >
                                </el-option>
                            </el-select>
                            <div
                                class="error-message"
                                v-if="form_error.inv_org"
                            >
                                <strong class="font-bold">{{
                                    form_error.inv_org.title
                                }}</strong>
                                <span class="block sm:inline">
                                    {{ form_error.inv_org.message }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">ปริมาณ</label>
                        <div class="col-md-6 flex-wrap">
                            <el-input
                                type="number"
                                placeholder="ปริมาณ"
                                v-model="form.qty"
                                min="0"
                            ></el-input>
                            <div class="error-message" v-if="form_error.qty">
                                <strong class="font-bold">{{
                                    form_error.qty.title
                                }}</strong>
                                <span class="block sm:inline">
                                    {{ form_error.qty.message }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">หน่วยนับ</label>
                        <div class="col-md-6 flex-wrap">
                            <el-select
                                v-model="form.uom_code"
                                filterable
                                placeholder="หน่วยนับ"
                                style="width: 100%"
                            >
                                <el-option
                                    v-for="(item, index) in uom"
                                    :key="index"
                                    :label="item.unit_of_measure"
                                    :value="item.uom_code"
                                >
                                </el-option>
                            </el-select>
                            <div
                                class="error-message"
                                v-if="form_error.unit_id"
                            >
                                <strong class="font-bold">{{
                                    form_error.unit_id.title
                                }}</strong>
                                <span class="block sm:inline">
                                    {{ form_error.unit_id.message }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 text-right mt-4 px-0">
            <el-button
                class="btn-success"
                @click="handleSubmit()"
                type="success"
            >
                ยืนยัน
            </el-button>
            <el-button
                class="text-refresh"
                type="text"
                @click.native.prevent="refresh()"
            >
                ล้างข้อมูล
            </el-button>
        </div>
    </div>
</template>

<script>
export default {
    props: ["isEdit", "costCenter"],
    data() {
        return {
            isCopy: false,
            loading: false,
            form_copy: {
                code: ""
            },
            form_error: {},
            form: {},
            product_code: [],
            years: [],
            to_years: [],
            inv_org_select: "",
            org_material_select: "",
            uom: [],
            inv_org: [],
            org_material: [],
            cost_center_group_v: [],
            loadingInput: {
                years: false,
                cost_center_group_v: false,
                type: false,
                uom: false,
                org_material: false,
                inv_org: false
            }
        };
    },
    created() {
        this.getMasterData();
    },
    methods: {
        getMasterData() {
            this.loading = true;
            this.getUomCode();
            this.getInvOrg();
            this.getCostCenterGroupV();
            this.getYears();
            this.getCode();
            this.getDataEdit();
            this.loading = false;
        },
        getDataEdit() {
            if (this.isEdit) {
                console.log(this.costCenter);
                this.setForm(this.costCenter);
                // const { fiscal_year } = this.costCenter;

                // this.form = {
                //     fiscal_year,
                //     ...this.form
                // };
                // this.setInvOrg(this.costCenterOrg);
                // this.setProductGroup(this.productGroup);
            }
        },
        handleSubmit() {
            this.loading = true;
            if (this.isEdit) {
                this.update();
            } else {
                this.store();
            }
        },
        errorMessage(err) {
            const { errors } = err;
            if (errors) {
                Object.keys(errors).forEach(item => {
                    this.form_error[item] = {};
                    this.form_error[item]["title"] = item;
                    this.form_error[item]["message"] = errors[item][0];
                });

                let check_table = Object.keys(this.form_error);
                check_table.some(element => {
                    if (element.split(".").length > 0) {
                        this.form_error.group_production_table = {};
                        this.form_error.group_production_table["title"] =
                            "กลุ่มผลิตภัณฑ์";
                        this.form_error.group_production_table["message"] =
                            "กรุณากรอกข้อมูลในกลุ่มผลิตภัณฑ์ให้ถูกต้อง";
                        return true;
                    }
                });
                this.resetError();
            }
        },
        resetError() {
            setTimeout(() => {
                this.form_error = {};
            }, 4000);
        },
        async update() {
            const url = "/ct/ajax/cost_center/package";
            this.form.type = "UPDATE";
            await axios
                .post(url, this.form)
                .then(res => {
                    this.$message({
                        showClose: true,
                        message: "บันทึกสำเร็จ",
                        type: "success",
                        onClose: () => {
                            // window.location.href = "/ct/cost_center";
                        }
                    });
                })
                .catch(err => {
                    this.errorMessage(err.response.data);
                    this.$message({
                        showClose: true,
                        message: `ไม่สามารถบันทึกได้`,
                        type: "error"
                    });
                })
                .then(() => {
                    this.loading = false;
                });
        },
        async store() {
            const url = "/ct/ajax/cost_center/package";
            await axios
                .post(url, this.form)
                .then(res => {
                    this.$message({
                        showClose: true,
                        message: "บันทึกสำเร็จ",
                        type: "success",
                        onClose: () => {
                            // window.location.href = "/ct/cost_center";
                        }
                    });
                })
                .catch(err => {
                    this.errorMessage(err.response.data);
                    this.$message({
                        showClose: true,
                        message: `ไม่สามารถบันทึกได้`,
                        type: "error"
                    });
                })
                .then(() => {
                    this.loading = false;
                });
        },
        clearCopy() {
            this.isCopy = false;
            this.form_copy = {
                code: ""
            };
        },
        setForm(cost_center) {
            const {
                cost_code,
                description,
                cost_group_code,
                organization_code,
                quantity,
                uom_code
            } = cost_center;

            this.form = {
                code: cost_code,
                name: description,
                cost_group_code,
                organization_code,
                qty: quantity,
                uom_code,
                ...this.form
            };
        },
        setProductGroup(product_group) {
            product_group.forEach(item => {
                const product = {
                    id: item.product_group_id,
                    code: item.code,
                    name: item.name,
                    unit_group: item.unit_group_code,
                    ratio: item.ratio,
                    unit_cost_center: item.unit_cost_center_code,
                    width: item.width,
                    long: item.long,
                    around: item.around,
                    area: item.area
                };
                this.form.group_production.push(product);
            });
        },

        refresh() {
            this.form = {};
            this.clearCopy();
        },
        getToYear() {
            const from_year = parseInt(this.form_copy.from_year);
            const to_year = from_year + 10;
            let rs = [];
            for (let index = from_year; index < to_year; index++) {
                rs.push({
                    label_year: index + 543,
                    year: index
                });
            }

            this.to_years = rs;
        },
        getCode(query) {
            const { from_year, to_year } = this.form_copy;
            axios
                .get("/ct/ajax/cost_center/codes", {
                    params: {
                        text: query,
                        from_year: from_year,
                        to_year: to_year
                    }
                })
                .then(res => {
                    this.product_code = res.data;
                });
        },
        getYears(query) {
            this.loadingInput.year = true;
            axios
                .get("/ct/ajax/cost_center/years", {
                    params: { text: query }
                })
                .then(res => {
                    this.years = res.data;
                });
            this.loadingInput.year = false;
        },
        getCostCenterGroupV(query) {
            this.loadingInput.cost_center_group_v = true;
            axios
                .get("/ct/ajax/cost_center_group_v", {
                    params: { text: query }
                })
                .then(res => {
                    const { data } = res.data;
                    this.cost_center_group_v = data;
                });
            this.loadingInput.cost_center_group_v = false;
        },
        getInvOrg(query) {
            this.loadingInput.inv_org = true;
            axios
                .get("/ct/ajax/cost_center/inv_org", {
                    params: { text: query }
                })
                .then(res => {
                    const { data } = res.data;
                    this.inv_org = data;
                });
            this.loadingInput.inv_org = false;
        },
        getUomCode(query) {
            this.loadingInput.uom = true;
            axios
                .get("/ct/ajax/cost_center/uom_v", { params: { text: query } })
                .then(res => {
                    const { data } = res.data;
                    this.uom = data;
                });
            this.loadingInput.uom = false;
        }
    }
};
</script>
<style lang="scss" scoped>
.error-message {
    display: flex;
    color: #ec4958;
    margin-top: 5px;

    strong {
        margin-right: 5px;
    }
}
.mt-custom__10 {
    margin-top: 10px;
}
.text-title {
    font-size: 16px;
    font-weight: 600;
}
.btn-info {
    background-color: #02b0ef;
    border-color: #02b0ef;
}
.btn-success {
    background-color: #1ab394;
    border-color: #1ab394;
}
.btn-cancel {
    background-color: #ec4958;
    border-color: #ec4958;
    color: white;
}
.text-refresh {
    color: #ec4958;
}
.org_list {
    display: flex;
    flex-wrap: wrap;
    &-item {
        cursor: pointer;
        display: flex;
        margin: 5px;
        background: #1ab394;
        padding: 3px 10px;
        color: #fff;
        border-radius: 3px;
        &__close {
            margin-left: 10px;
        }
    }
}
</style>
