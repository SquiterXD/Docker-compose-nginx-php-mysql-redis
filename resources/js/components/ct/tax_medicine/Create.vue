<template>
    <div v-loading="loading">
        <div class="m-2">
            <div class="form-group row">
                <label class="col-md-2 col-form-label">รหัสวัตถุดิบ</label>
                <div class="col-md-4 flex-wrap">
                    <el-select
                        style="width:100%;"
                        clearable
                        v-model="form.item_number"
                        placeholder="รหัสวัตถุดิบ"
                        @change="selMaterial">
                        <el-option
                            v-for="(item, index) in option.material"
                            :key="index"
                            :label="item.item_number+' - '+item.item_desc"
                            :value="item.item_number">
                            <!-- <span>
                                {{ `${item.item_number} - ${item.item_desc}` }}
                            </span> -->
                        </el-option>
                    </el-select>
                    <div class="error-message" v-if="form_error.item_number">
                        <strong class="font-bold">{{
                            form_error.item_number.title
                        }}</strong>
                        <span class="block sm:inline">
                            {{ form_error.item_number.message }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label" > รหัสวัตถุดิบ(ภาษี) </label>
                <div class="col-md-4 flex-wrap">
                    <el-select
                        style="width:100%;"
                        clearable
                        v-model="form.tax_item_number"
                        placeholder="รหัสวัตถุดิบ(ภาษี)">
                        <el-option
                            v-for="(item, index) in option.materialTax"
                            :key="index"
                            :label="item.item_number+' - '+item.item_desc"
                            :value="item.item_number">
                            <!-- <span>
                                {{ `${item.item_number} - ${item.item_desc}` }}
                            </span> -->
                        </el-option>
                    </el-select>
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
                @click.native.prevent="refresh()">
                ล้างข้อมูล
            </el-button>
        </div>
    </div>
</template>

<script>
export default {
    props: ["isEdit", "taxMedicine"],
    data() {
        return {
            loading: false,
            mtrloading: false,
            form_error: {},
            form: {},
            option: {
                material: [],
                materialTax: []
            }
        };
    },
    created() {
        this.getMasterData();
    },
    methods: {
        async getMasterData() {
            this.loading = true;
            this.getRawMaterail();
            this.loading = false;
        },
        getRawMaterail() {
            axios.get("/ct/ajax/get_raw_material").then(res => {
                this.option.material = res.data;
            });
        },
        selMaterial() {
            // เมื่อมีการเลือก Raw Materail แลัวระบบจะ list data tax ให้ 18082022
            let vm = this;
            vm.form.tax_item_number = '';
            axios.get("/ct/ajax/get_raw_material_tax?item="+vm.form.item_number).then(res => {
                if (res.data.status == 'S') {
                    vm.option.materialTax = res.data.materialTax;
                    vm.form.tax_item_number = res.data.defaultMaterialTax.item_number;
                }else{
                    this.$message({
                        showClose: true,
                        message: res.data.msg,
                        type: "error"
                    });
                }
            });
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
                this.resetError();
            }
        },
        resetError() {
            setTimeout(() => {
                this.form_error = {};
            }, 5000);
        },
        async update() {
            const { item_number } = this.taxMedicine;
            await axios
                .put(`/ct/ajax/tax_medicine/${item_number}`, this.form)
                .then(res => {
                    this.$message({
                        showClose: true,
                        message: "บันทึกสำเร็จ",
                        type: "success",
                        onClose: () => {
                            window.location.href = "/ct/tax_medicine";
                        }
                    });
                })
                .catch(err => {
                    this.loading = false;
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
            this.loading = true;
            await axios
                .post("/ct/ajax/tax_medicine", this.form)
                .then(res => {
                    this.$message({
                        showClose: true,
                        message: "บันทึกสำเร็จ",
                        type: "success",
                        onClose: () => {
                            window.location.href = "/ct/tax_medicine";
                        }
                    });
                })
                .catch(err => {
                    this.loading = false;
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
        refresh() {
            this.form = {};
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
</style>
