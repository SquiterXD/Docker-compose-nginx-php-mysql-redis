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
                        <label class="col-md-2 col-form-label"
                            >ประเภทศูนย์ต้นทุน</label
                        >
                        <div class="col-md-6 flex-wrap">
                            <el-select
                                v-model="form.cost_center_category_id"
                                filterable
                                placeholder="ประเภทศูนย์ต้นทุน"
                                style="width: 100%"
                            >
                                <el-option
                                    v-for="(item,
                                    index) in cost_center_category"
                                    :key="index"
                                    :label="item.name"
                                    :value="item.cost_center_category_id"
                                >
                                </el-option>
                            </el-select>
                            <div
                                class="error-message"
                                v-if="form_error.cost_center_category_id"
                            >
                                <strong class="font-bold">{{
                                    form_error.cost_center_category_id.title
                                }}</strong>
                                <span class="block sm:inline">
                                    {{
                                        form_error.cost_center_category_id
                                            .message
                                    }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">
                            เพิ่มรายการ INV org
                        </label>
                        <div class="col-md-6 flex-wrap">
                            <el-select
                                v-model="inv_org_select"
                                filterable
                                placeholder="เพิ่มรายการ INV Org"
                                style="width: 100%"
                                @change="addInvOrg()"
                            >
                                <el-option
                                    v-for="(item, index) in inv_org"
                                    :key="index"
                                    :label="item.organization_name"
                                    :value="item"
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
                    <div class="form-group row" v-if="form.inv_org.length > 0">
                        <label class="col-md-2 col-form-label">
                            รายการ INV org
                        </label>
                        <div class="col-md-6 flex-wrap">
                            <div class="org_list">
                                <div
                                    class="org_list-item"
                                    v-for="(item, index) in form.inv_org"
                                    :key="index"
                                    @click="deleteRow(index, form.inv_org)"
                                >
                                    <div>
                                        {{ item.organization_name }}
                                    </div>
                                    <span class="org_list-item__close">X</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">
                            เพิ่มรายการ org วัตถุดิบ
                        </label>
                        <div class="col-md-6 flex-wrap">
                            <el-select
                                v-model="org_material_select"
                                filterable
                                placeholder="เพิ่มรายการ org วัตถุดิบ"
                                style="width: 100%"
                                @change="addOrgMaterial()"
                            >
                                <el-option
                                    v-for="(item, index) in org_material"
                                    :key="index"
                                    :label="item.organization_name"
                                    :value="item"
                                >
                                </el-option>
                            </el-select>
                            <div
                                class="error-message"
                                v-if="form_error.org_material"
                            >
                                <strong class="font-bold">{{
                                    form_error.org_material.title
                                }}</strong>
                                <span class="block sm:inline">
                                    {{ form_error.org_material.message }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div
                        class="form-group row"
                        v-if="form.org_material.length > 0"
                    >
                        <label class="col-md-2 col-form-label">
                            รายการ org วัตถุดิบ
                        </label>
                        <div class="col-md-6 flex-wrap">
                            <div class="org_list">
                                <div
                                    class="org_list-item"
                                    v-for="(item, index) in form.org_material"
                                    :key="index"
                                    @click="deleteRow(index, form.org_material)"
                                >
                                    <div>
                                        {{ item.organization_name }}
                                    </div>
                                    <span class="org_list-item__close">X</span>
                                </div>
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
                                v-model="form.unit_id"
                                filterable
                                placeholder="หน่วยนับ"
                                style="width: 100%"
                            >
                                <el-option
                                    v-for="(item, index) in unit_measure"
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
        <hr />
        <div class="container mt-custom__10">
            <div class=" text-title m-2">
                กลุ่มผลิตภัณฑ์
            </div>
        </div>
        <div class="">
            <div class="">
                <div class="container">
                    <template v-if="!isCopy">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">
                                ปีบัญชีงบประมาณ
                            </label>
                            <div class="col-md-6 tw-flex-wrap">
                                <el-select
                                    v-model="form.fiscal_year"
                                    filterable
                                    placeholder="เลือกปีบัญชีงบประมาณ"
                                    style="width: 100%"
                                >
                                    <el-option
                                        v-for="(item, index) in period_year"
                                        :key="index"
                                        :label="item.label_year"
                                        :value="item.period_year"
                                    >
                                    </el-option>
                                </el-select>
                                <div
                                    class="error-message"
                                    v-if="form_error.fiscal_year"
                                >
                                    <strong class="font-bold">{{
                                        form_error.fiscal_year.title
                                    }}</strong>
                                    <span class="block sm:inline">
                                        {{ form_error.fiscal_year.message }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <el-button
                                    class="btn-success"
                                    type="success"
                                    style="width: 100%"
                                    @click.native.prevent="addRow()"
                                >
                                    สร้างกลุ่มผลิตภัณฑ์ใหม่
                                </el-button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">
                                รหัสศูนย์ต้นทุน
                            </label>
                            <div class="col-md-3">
                                <el-input
                                    placeholder="รหัสศูนย์ต้นทุน"
                                    v-model="form.code"
                                    disabled
                                ></el-input>
                            </div>
                            <div class="col-md-3">
                                <el-input
                                    placeholder="ชื่อศูนย์ต้นทุน"
                                    v-model="form.name"
                                    disabled
                                ></el-input>
                            </div>
                            <div class="col-md-3" v-if="!isEdit">
                                <el-button
                                    class="btn btn-info"
                                    type="success"
                                    style="width: 100%"
                                    @click.native.prevent="copyData()"
                                >
                                    <i class="fa fa-copy"></i>
                                    คัดลอกข้อมูล
                                </el-button>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">
                                จากปีบัญชีงบประมาณ
                            </label>
                            <div class="col-md-6">
                                <el-select
                                    v-model="form_copy.from_year"
                                    filterable
                                    placeholder="จากปีบัญชีงบประมาณ"
                                    style="width: 100%"
                                    @change="getToYear"
                                >
                                    <el-option
                                        v-for="(item, index) in years"
                                        :key="index"
                                        :label="item.label_year"
                                        :value="item.fiscal_year"
                                    >
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">
                                ไปปีบัญชีงบประมาณ
                            </label>
                            <div class="col-md-6">
                                <el-select
                                    v-model="form_copy.to_year"
                                    filterable
                                    placeholder="ไปปีบัญชีงบประมาณ"
                                    style="width: 100%"
                                    :disabled="!form_copy.from_year"
                                    @change="getCode"
                                >
                                    <el-option
                                        v-for="(item, index) in to_years"
                                        :key="index"
                                        :label="item.label_year"
                                        :value="item.year"
                                    >
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">
                                รหัสศูนย์ต้นทุน
                            </label>
                            <div class="col-md-6">
                                <el-select
                                    v-model="form_copy.code"
                                    filterable
                                    remote
                                    :debounce="2000"
                                    :remote-method="getCode"
                                    :loading="loadingInput.product_code"
                                    placeholder="ศูนย์ต้นทุน"
                                    style="width: 100%"
                                >
                                    <el-option
                                        v-for="(item, index) in product_code"
                                        :key="index"
                                        :label="item.name"
                                        :value="item.code"
                                    >
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-2">
                                <el-button
                                    class="btn-success"
                                    type="success"
                                    style="width: 100%"
                                    @click.native.prevent="submitCopy()"
                                >
                                    ตกลง
                                </el-button>
                            </div>
                            <div class="col-md-2">
                                <el-button
                                    class="btn-cancel"
                                    type="cancel"
                                    style="width: 100%"
                                    @click.native.prevent="clearCopy()"
                                >
                                    ยกเลืก
                                </el-button>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="form-group row mt-custom__10">
                    <div class="col-md-12 flex-wrap">
                        <!-- group_production -->
                        <div
                            class="error-message"
                            v-if="form_error.group_production"
                        >
                            <strong class="font-bold">{{
                                form_error.group_production.title
                            }}</strong>
                            <span class="block sm:inline">
                                {{ form_error.group_production.message }}
                            </span>
                        </div>
                        <div
                            class="error-message"
                            v-if="form_error.group_production_table"
                        >
                            <strong class="font-bold">{{
                                form_error.group_production_table.title
                            }}</strong>
                            <span class="block sm:inline">
                                {{ form_error.group_production_table.message }}
                            </span>
                        </div>
                        <el-table
                            border
                            :data="form.group_production"
                            style="width: 100%"
                        >
                            <el-table-column
                                align="center"
                                label="กลุ่มผลิตภัณฑ์"
                                width="120"
                            >
                                <template slot-scope="scope">
                                    <el-input
                                        style="width:100%"
                                        :controls="false"
                                        placeholder="รหัส"
                                        v-model="scope.row.code"
                                    >
                                    </el-input>
                                </template>
                            </el-table-column>
                            <el-table-column align="center" label="รายละเอียด">
                                <template slot-scope="scope">
                                    <el-input
                                        style="width:100%"
                                        :controls="false"
                                        placeholder="รายละเอียด"
                                        v-model="scope.row.name"
                                    >
                                    </el-input>
                                </template>
                            </el-table-column>
                            <el-table-column
                                align="center"
                                label="หน่วยนับ (กลุ่ม)"
                            >
                                <template slot-scope="scope">
                                    <el-select
                                        v-model="scope.row.unit_group"
                                        filterable
                                        placeholder="หน่วยนับ"
                                        style="width: 100%"
                                    >
                                        <el-option
                                            v-for="(item,
                                            index) in unit_measure"
                                            :key="index"
                                            :label="item.unit_of_measure"
                                            :value="item.uom_code"
                                        >
                                        </el-option>
                                    </el-select>
                                </template>
                            </el-table-column>
                            <el-table-column align="center" label="อัตราส่วน">
                                <template slot-scope="scope">
                                    <el-input
                                        type="number"
                                        style="width:100%"
                                        :controls="false"
                                        placeholder="อัตราส่วน"
                                        v-model="scope.row.ratio"
                                    >
                                    </el-input>
                                </template>
                            </el-table-column>
                            <el-table-column
                                align="center"
                                label="หน่วยนับ (ศูนย์)"
                            >
                                <template slot-scope="scope">
                                    <el-select
                                        v-model="scope.row.unit_cost_center"
                                        filterable
                                        placeholder="หน่วยนับ"
                                        :loading="loadingInput.unit_measure"
                                        style="width: 100%"
                                    >
                                        <el-option
                                            v-for="(item,
                                            index) in unit_measure"
                                            :key="index"
                                            :label="item.unit_of_measure"
                                            :value="item.uom_code"
                                        >
                                        </el-option>
                                    </el-select>
                                </template>
                            </el-table-column>
                            <el-table-column
                                align="center"
                                label="ความกว้าง (ซม.)"
                            >
                                <template slot-scope="scope">
                                    <el-input
                                        type="number"
                                        style="width:100%"
                                        :controls="false"
                                        placeholder="ความกว้าง (ซม.)"
                                        v-model="scope.row.width"
                                    >
                                    </el-input>
                                </template>
                            </el-table-column>
                            <el-table-column
                                align="center"
                                label="ความยาว (ซม.)"
                            >
                                <template slot-scope="scope">
                                    <el-input
                                        type="number"
                                        style="width:100%"
                                        :controls="false"
                                        placeholder="ความยาว (ซม.)"
                                        v-model="scope.row.long"
                                    >
                                    </el-input>
                                </template>
                            </el-table-column>
                            <el-table-column
                                align="center"
                                label="จำนวนรอบ (รอบ)"
                            >
                                <template slot-scope="scope">
                                    <el-input
                                        type="number"
                                        style="width:100%"
                                        :controls="false"
                                        placeholder="จำนวนรอบ (รอบ)"
                                        v-model="scope.row.around"
                                    >
                                    </el-input>
                                </template>
                            </el-table-column>
                            <el-table-column
                                align="center"
                                label="พื้นที่ทำงาน"
                            >
                                <template slot-scope="scope">
                                    <el-input
                                        type="number"
                                        style="width:100%"
                                        :controls="false"
                                        placeholder="พื้นที่ (ตร.ซม.)"
                                        v-model="scope.row.area"
                                    >
                                    </el-input>
                                </template>
                            </el-table-column>
                            <el-table-column align="center" label="Action">
                                <template slot-scope="scope">
                                    <el-button
                                        size="mini"
                                        type="danger"
                                        @click.native.prevent="
                                            confirmDelete(
                                                scope.$index,
                                                'form.group_production'
                                            )
                                        "
                                        ><i class="el-icon-delete"></i
                                        >ลบ</el-button
                                    >
                                </template>
                            </el-table-column>
                        </el-table>
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
    props: ["isEdit", "costCenter", "costCenterOrg", "productGroup"],
    data() {
        return {
            isCopy: false,
            loading: false,
            form_copy: {
                code: ""
            },
            form_error: {},
            form: {
                inv_org: [],
                org_material: [],
                group_production: []
            },
            product_code: [],
            years: [],
            to_years: [],
            period_year: [],
            inv_org_select: "",
            org_material_select: "",
            unit_measure: [],
            inv_org: [],
            org_material: [],
            cost_center_category: [],
            loadingInput: {
                period_year: false,
                years: false,
                cost_center_category: false,
                type: false,
                unit_measure: false,
                org_material: false,
                inv_org: false
            }
        };
    },
    created() {
        this.getMasterData();
    },
    methods: {
        addInvOrg() {
            const {
                organization_code,
                organization_name
            } = this.inv_org_select;
            let check = _.find(this.form.inv_org, function(n) {
                if (n.organization_code == organization_code) {
                    return true;
                }
            });
            if (!check) {
                this.form.inv_org.push({
                    organization_code,
                    organization_name
                });
            }
            this.inv_org_select = "";
        },
        addOrgMaterial() {
            const {
                organization_code,
                organization_name
            } = this.org_material_select;
            let check = _.find(this.form.org_material, function(n) {
                if (n.organization_code == organization_code) {
                    return true;
                }
            });
            if (!check) {
                this.form.org_material.push({
                    organization_code,
                    organization_name
                });
            }
            this.org_material_select = "";
        },
        getMasterData() {
            this.loading = true;
            this.getUnitMeasure();
            this.getOrgInv();
            this.getOrgMaterial();
            this.getCostCenterCategory();
            this.getPeriodYears();
            this.getYears();
            this.getCode();
            this.getDataEdit();
            this.loading = false;
        },
        checkTable() {
            const rs = _.filter(this.form.group_production, item => {
                return (
                    item.name == this.form.name && item.code == this.form.code
                );
            });
            this.form.group_production = rs;
        },
        copyData() {
            this.isCopy = true;
        },
        addRow() {
            this.form.group_production.push({
                code: "",
                name: "",
                unit_group: "",
                ratio: "",
                unit_cost_center: "",
                id: ""
            });
        },
        confirmDelete(index, data) {
            data = eval(`this.${data}`);
            let id = data[index].id;
            this.$confirm(
                "เมื่อกดยืนยันข้อมูลนี้จะถูกลบ",
                "ต้องการลบข้อมูลนี้ใช่หรือไม่",
                {
                    confirmButtonText: "ยืนยัน",
                    cancelButtonText: "ยกเลิก"
                }
            )
                .then(() => {
                    if (this.isEdit && id) {
                        this.deleteProductGroup(id, index);
                    } else {
                        data.splice(index, 1);
                        this.$message({
                            type: "success",
                            message: "ลบสำเร็จ"
                        });
                    }
                })
                .catch(() => {});
        },
        deleteProductGroup(id, index) {
            axios
                .delete(`/ct/ajax/product_group/${id}`)
                .then(res => {
                    this.form.group_production.splice(index, 1);
                    this.$message({
                        type: "success",
                        message: "ลบสำเร็จ"
                    });
                })
                .catch(err => {
                    this.$message({
                        type: "error",
                        message: err.response.data.msg
                    });
                });
        },
        deleteRow(index, data) {
            data.splice(index, 1);
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
            await axios
                .post("/ct/ajax/cost_center/update_ct", this.form)
                .then(res => {
                    this.$message({
                        showClose: true,
                        message: "บันทึกสำเร็จ",
                        type: "success",
                        onClose: () => {
                            window.location.href = "/ct/cost_center";
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
            await axios
                .post("/ct/ajax/cost_center", this.form)
                .then(res => {
                    this.$message({
                        showClose: true,
                        message: "บันทึกสำเร็จ",
                        type: "success",
                        onClose: () => {
                            window.location.href = "/ct/cost_center";
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
                cost_center_id,
                code,
                name,
                cost_center_category_id,
                qty,
                unit_id
            } = cost_center;

            this.form = {
                cost_center_id,
                code,
                name,
                cost_center_category_id: parseInt(cost_center_category_id),
                qty,
                unit_id,
                ...this.form
            };
        },
        setInvOrg(cost_center_org) {
            cost_center_org.forEach(item => {
                if (item.type == "INV_ORG") {
                    this.inv_org_select = {
                        organization_code: item.org_code,
                        organization_name: item.description
                    };
                    this.addInvOrg();
                } else if (item.type == "ORG") {
                    this.org_material_select = {
                        organization_code: item.org_code,
                        organization_name: item.description
                    };
                    this.addOrgMaterial();
                }
            });
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
        submitCopy() {
            this.loading = true;
            const { code } = this.form_copy;
            if (code) {
                axios
                    .get(`/ct/ajax/product_group/copy/${code}`)
                    .then(res => {
                        const {
                            cost_center,
                            cost_center_org,
                            product_group
                        } = res.data;
                        this.setForm(cost_center);
                        this.setInvOrg(cost_center_org);
                        this.setProductGroup(product_group);
                    })
                    .catch(err => {})
                    .then(() => {
                        this.clearCopy();
                        this.loading = false;
                    });
            } else {
                this.$message({
                    showClose: true,
                    message: `กรุณากรอกข้อมูลให้ครบถ้วน`,
                    type: "error"
                });
            }
        },
        refresh() {
            this.form = {
                inv_org: [],
                group_production: []
            };
            this.clearCopy();
        },
        getDataEdit() {
            if (this.isEdit) {
                this.setForm(this.costCenter);
                const { fiscal_year } = this.costCenter;

                this.form = {
                    fiscal_year,
                    ...this.form
                };
                this.setInvOrg(this.costCenterOrg);
                this.setProductGroup(this.productGroup);
            }
        },
        getPeriodYears(query) {
            this.loadingInput.period_year = true;
            axios
                .get("/ct/ajax/cost_center/period_years", {
                    params: { text: query }
                })
                .then(res => {
                    this.period_year = res.data;
                });
            this.loadingInput.period_year = false;
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
        getCostCenterCategory(query) {
            this.loadingInput.cost_center_category = true;
            axios
                .get("/ct/ajax/cost_center_category", {
                    params: { text: query }
                })
                .then(res => {
                    this.cost_center_category = res.data;
                });
            this.loadingInput.cost_center_category = false;
        },
        getOrgInv(query) {
            this.loadingInput.inv_org = true;
            axios
                .get("/ct/ajax/inv_org", { params: { text: query } })
                .then(res => {
                    this.inv_org = res.data;
                });
            this.loadingInput.inv_org = false;
        },
        getOrgMaterial() {
            this.loadingInput.org_material = true;
            axios.get("/ct/ajax/org_material").then(res => {
                this.org_material = res.data;
            });
            this.loadingInput.org_material = false;
        },
        getUnitMeasure(query) {
            this.loadingInput.unit_measure = true;
            axios
                .get("/ct/ajax/measure", { params: { text: query } })
                .then(res => {
                    this.unit_measure = res.data;
                });
            this.loadingInput.unit_measure = false;
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
