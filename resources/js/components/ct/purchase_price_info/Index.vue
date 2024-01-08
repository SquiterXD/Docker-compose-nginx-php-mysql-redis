<template>
    <div v-loading="loading">
        <template v-if="dialogVisible">
            <div class="el-dialog__wrapper" style="z-index: 2001;">
                <div
                    class="background-dialog__custom"
                    @click="closeDialog()"
                ></div>
                <div
                    id="dialog_custom"
                    role="dialog"
                    aria-modal="true"
                    aria-label="Tips"
                    class="el-dialog"
                    :style="`${styleDialog}`"
                >
                    <div class="el-dialog__header">
                        <span class="el-dialog__title">{{ dialog.name }}</span
                        ><button
                            type="button"
                            aria-label="Close"
                            class="el-dialog__headerbtn"
                            @click="closeDialog()"
                        >
                            <i
                                class="el-dialog__close el-icon el-icon-close"
                            ></i>
                        </button>
                    </div>
                    <div class="el-dialog__body">
                        <el-input
                            v-if="
                                dialog.type == 'number' || dialog.type == 'text'
                            "
                            :placeholder="dialog.name"
                            :type="dialog.type"
                            v-model="dialog.data"
                        ></el-input>
                        <div v-else-if="dialog.type === 'date'">
                            <el-date-picker
                                style="width:100%"
                                v-model="dialog.data"
                                type="date"
                                :placeholder="dialog.name"
                                format="dd/MM/yyyy"
                            >
                            </el-date-picker>
                        </div>
                        <el-select
                            v-else-if="dialog.type === 'status'"
                            style="width:100%;"
                            v-model="dialog.data"
                            placeholder="ปีบัญชีงบประมาณ"
                        >
                            <el-option
                                v-for="(item, index) in option.approve"
                                :key="index"
                                :label="item"
                                :value="item"
                            >
                            </el-option>
                        </el-select>
                        <div v-else-if="dialog.type === 'approve_price'">
                            คุณยืนยันที่จะยืนยันราคาวัตถุดิบใช่หรือไม่
                        </div>
                    </div>
                    <div class="el-dialog__footer">
                        <span class="dialog-footer"
                            ><button
                                @click="closeDialog()"
                                type="button"
                                class="el-button el-button--default"
                            >
                                <span>Cancel</span>
                            </button>
                            <button
                                @click="submitDialog()"
                                type="button"
                                class="el-button el-button--primary"
                            >
                                <span>Confirm</span>
                            </button></span
                        >
                    </div>
                </div>
            </div>
        </template>
        <div class="m-2 ">
            <div class="form-group row">
                <h2 class="text-bold ml-1">
                    {{
                        is_create
                            ? "สร้างรายการนำเข้าราคาซื้อ"
                            : "ค้นหาข้อมูลการนำเข้าราคาซื้อ"
                    }}
                </h2>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">ปีบัญชีงบประมาณ</label>
                <div class="col-md-4 flex-wrap">
                    <el-select
                        style="width:100%;"
                        v-model="form.period_year"
                        placeholder="ปีบัญชีงบประมาณ"
                        @change="getPeriodMonth"
                    >
                        <el-option
                            v-for="(item, index) in option.period_year"
                            :key="index"
                            :label="item.label_year"
                            :value="item.period_year"
                        >
                        </el-option>
                    </el-select>
                    <div class="error-message" v-if="form_error.period_year">
                        <strong class="font-bold">{{
                            form_error.period_year.title
                        }}</strong>
                        <span class="block sm:inline">
                            {{ form_error.period_year.message }}
                        </span>
                    </div>
                </div>

                <label class="col-md-2 col-form-label">วันที่ใช้</label>
                <div class="col-md-4 flex-wrap">
                    <el-input
                        v-model="used_date"
                        placeholder="วันที่เริ่มใช้ - วันที่สิ้นสุด"
                        disabled
                    ></el-input>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">Period</label>
                <div class="col-md-4 flex-wrap">
                    <el-select
                        style="width:100%;"
                        v-model="form.period_name"
                        placeholder="Period"
                        @change="getDropDownVersion"
                    >
                        <el-option
                            v-for="(item, index) in periodMonth"
                            :key="index"
                            :label="item.period_name"
                            :value="item.period_name"
                        >
                        </el-option>
                    </el-select>

                    <div class="error-message" v-if="form_error.used_date">
                        <strong class="font-bold">{{
                            form_error.used_date.title
                        }}</strong>
                        <span class="block sm:inline">
                            {{ form_error.used_date.message }}
                        </span>
                    </div>
                </div>
                <label class="col-md-2 col-form-label">สถานะ</label>
                <div class="col-md-4 flex-wrap">
                    <el-input
                        v-model="form.status"
                        placeholder="สถานะ"
                        disabled
                    >
                        <template slot-scope="scope">
                            <div
                                class="td-select"
                                @click="openDialog('status', 'สถานะ', scope)"
                            >
                                {{
                                    scope.status == "N"
                                        ? "ยังไม่ยืนยัน"
                                        : "ยืนยันแล้ว"
                                }}
                            </div>
                        </template>
                    </el-input>
                    <div class="error-message" v-if="form_error.status">
                        <strong class="font-bold">{{
                            form_error.status.title
                        }}</strong>
                        <span class="block sm:inline">
                            {{ form_error.status.message }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">Organization</label>
                <div class="col-md-4 flex-wrap">
                    <el-select
                        style="width:100%;"
                        v-model="form.organization_code"
                        placeholder="Organization"
                        @change="getDropDownVersion"
                    >
                        <el-option
                            v-for="(item, index) in option.organization"
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
                        v-if="form_error.organization_code"
                    >
                        <strong class="font-bold">{{
                            form_error.organization_code.title
                        }}</strong>
                        <span class="block sm:inline">
                            {{ form_error.organization_code.message }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">ครั้งที่</label>
                <div class="col-md-4 flex-wrap">
                    <el-select
                        :disabled="is_create"
                        style="width:100%;"
                        placeholder="ครั้งที่"
                        v-model="form.version"
                    >
                        <el-option
                            v-for="(item, index) in option.version"
                            :key="index"
                            :label="item.version"
                            :value="item.version"
                        >
                        </el-option>
                    </el-select>
                    <div class="error-message" v-if="form_error.version">
                        <strong class="font-bold">{{
                            form_error.version.title
                        }}</strong>
                        <span class="block sm:inline">
                            {{ form_error.version.message }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 text-right mt-2">
                    <el-button
                        class="btn-info mr-2"
                        type="primary"
                        v-if="!is_create"
                        @click="search()"
                    >
                        ค้นหา
                    </el-button>
                    <el-button
                        v-if="is_create"
                        class="btn-primary mr-2"
                        type="primary"
                        @click="store()"
                    >
                        ประมวลผลเพิ่มข้อมูลใหม่
                    </el-button>

                    <a
                        :href="
                            `/ct/purchase_price_info/import-xls?period_year=${form.period_year}&period_name=${form.period_name}&organization_code=${form.organization_code}&version=${form.version}`
                        "
                    >
                        <el-button
                            v-if="status.tableData"
                            class="btn-info mr-2"
                            type="primary"
                        >
                            IMPORT
                        </el-button>
                    </a>

                    <el-button
                        v-if="status.tableData"
                        class="btn-info mr-2"
                        type="primary"
                        @click="queryDataTable"
                    >
                        EXPORT
                    </el-button>

                    <el-button
                        v-if="status.tableData"
                        class="btn-danger mr-2"
                        type="danger"
                        @click="delAll()"
                    >
                        ลบทั้งหมด
                    </el-button>

                    <el-button
                        class="btn-success"
                        :disabled="tableError"
                        @click="
                            openDialog(
                                'approve_price',
                                'ยืนยันราคาวัตถุดิบ',
                                ''
                            )
                        "
                        type="success"
                    >
                        ยืนยันราคาวัตถุดิบ
                    </el-button>
                </div>
            </div>
        </div>

        <div class="form-group row" v-if="status.tableData">
            <div class="col-md-12 mt-2 flex-wrap">
                <el-table border :data="tableData" style="width: 100%">
                    <el-table-column
                        prop="item_number"
                        label="รหัสวัตถุดิบ"
                        align="center"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="lot_number"
                        label="LOT"
                        align="center"
                    >
                        <template slot-scope="scope">
                            <div
                                class="td-select"
                                @click="openDialog('lot_number', 'LOT', scope)"
                            >
                                {{ scope.row.lot_number || "ไม่มีข้อมูล" }}
                            </div>
                        </template>
                    </el-table-column>
                    <el-table-column
                        prop="item_descrtiption"
                        label="ชื่อวัตถุดิบ"
                        align="center"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="unit_cost"
                        label="ราคาซื้อ"
                        align="center"
                    >
                        <template slot-scope="scope">
                            <div
                                class="td-select"
                                @click="
                                    openDialog('unit_cost', 'ราคาซื้อ', scope)
                                "
                            >
                                {{
                                    scope.row.unit_cost
                                        ? numberWithCommas(
                                              toFixedDecimal(
                                                  scope.row.unit_cost,
                                                  9
                                              )
                                          )
                                        : "ไม่มีข้อมูล"
                                }}
                            </div>
                        </template>
                    </el-table-column>
                    <el-table-column
                        prop="freight_cost"
                        label="ค่าขนส่ง"
                        align="center"
                    >
                        <template slot-scope="scope">
                            <div
                                class="td-select"
                                @click="
                                    openDialog(
                                        'freight_cost',
                                        'ค่าขนส่ง',
                                        scope
                                    )
                                "
                            >
                                {{
                                    scope.row.freight_cost !== ""
                                        ? numberWithCommas(
                                              toFixedDecimal(
                                                  scope.row.freight_cost,
                                                  9
                                              )
                                          )
                                        : "ไม่มีข้อมูล"
                                }}
                            </div>
                        </template>
                    </el-table-column>
                    <el-table-column
                        prop="subtotal"
                        label="จำนวนเงิน"
                        align="center"
                    >
                        <template slot-scope="scope">
                            {{
                                numberWithCommas(
                                    toFixedDecimal(scope.row.subtotal, 9)
                                )
                            }}
                        </template>
                    </el-table-column>
                    <!-- <el-table-column
                        prop="material_percent"
                        label="%"
                        align="center"
                    >
                        <template slot-scope="scope">
                            <div
                                class="td-select"
                                @click="
                                    openDialog('material_percent', '%', scope)
                                "
                            >
                                {{
                                    scope.row.material_percent !== ""
                                        ? scope.row.material_percent
                                        : "ไม่มีข้อมูล"
                                }}
                            </div>
                        </template>
                    </el-table-column> -->
                    <el-table-column
                        prop="dm_std_unitcost"
                        label="จำนวนเงินรวม"
                        align="center"
                    >
                        <template slot-scope="scope">
                            {{
                                numberWithCommas(
                                    toFixedDecimal(scope.row.dm_std_unitcost, 9)
                                )
                            }}
                        </template>
                    </el-table-column>
                    <el-table-column
                        prop="date_from"
                        label="วันที่เริ่มใช้"
                        align="center"
                    >
                        <template slot-scope="scope">
                            <div
                                class="td-select"
                                @click="
                                    openDialog(
                                        'date_from',
                                        'วันที่เริ่มใช้',
                                        scope
                                    )
                                "
                            >
                                {{
                                    scope.row.date_from
                                        ? dateFormat(scope.row.date_from, true)
                                        : header_date_from
                                }}
                            </div>
                        </template>
                    </el-table-column>
                    <el-table-column
                        prop="date_to"
                        label="วันที่สิ้นสุด"
                        align="center"
                    >
                        <template slot-scope="scope">
                            <div
                                class="td-select"
                                @click="
                                    openDialog(
                                        'date_to',
                                        'วันที่สิ้นสุด',
                                        scope
                                    )
                                "
                            >
                                {{
                                    scope.row.date_to
                                        ? dateFormat(scope.row.date_to, true)
                                        : header_date_to
                                }}
                            </div>
                        </template>
                    </el-table-column>
                    <el-table-column prop="error" label="Error" align="center">
                        <template slot-scope="scope">
                            <div v-if="scope.row.error" class="text-danger">
                                {{ scope.row.error }}
                            </div>
                            <div v-else>
                                <svg
                                    width="30"
                                    version="1.1"
                                    id="Layer_1"
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    x="0px"
                                    y="0px"
                                    viewBox="0 0 330 330"
                                    style="enable-background:new 0 0 330 330;"
                                    xml:space="preserve"
                                >
                                    <g id="XMLID_92_">
                                        <path
                                            id="XMLID_93_"
                                            d="M165,0C74.019,0,0,74.019,0,165s74.019,165,165,165s165-74.019,165-165S255.981,0,165,0z M165,300
		c-74.439,0-135-60.561-135-135S90.561,30,165,30s135,60.561,135,135S239.439,300,165,300z"
                                        />
                                        <path
                                            id="XMLID_104_"
                                            d="M205.306,205.305c-22.226,22.224-58.386,22.225-80.611,0.001c-5.857-5.858-15.355-5.858-21.213,0
		c-5.858,5.858-5.858,15.355,0,21.213c16.963,16.963,39.236,25.441,61.519,25.441c22.276,0,44.56-8.482,61.519-25.441
		c5.858-5.857,5.858-15.355,0-21.213C220.661,199.447,211.163,199.448,205.306,205.305z"
                                        />
                                        <path
                                            id="XMLID_105_"
                                            d="M115.14,147.14c3.73-3.72,5.86-8.88,5.86-14.14c0-5.26-2.13-10.42-5.86-14.14
		c-3.72-3.72-8.88-5.86-14.14-5.86c-5.271,0-10.42,2.14-14.141,5.86C83.13,122.58,81,127.74,81,133c0,5.26,2.13,10.42,5.859,14.14
		C90.58,150.87,95.74,153,101,153S111.42,150.87,115.14,147.14z"
                                        />
                                        <path
                                            id="XMLID_106_"
                                            d="M229,113c-5.26,0-10.42,2.14-14.141,5.86C211.14,122.58,209,127.73,209,133c0,5.27,2.14,10.42,5.859,14.14
		C218.58,150.87,223.74,153,229,153s10.42-2.13,14.14-5.86c3.72-3.72,5.86-8.87,5.86-14.14c0-5.26-2.141-10.42-5.86-14.14
		C239.42,115.14,234.26,113,229,113z"
                                        />
                                    </g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                </svg>
                            </div>
                        </template>
                    </el-table-column>
                    <el-table-column align="center" width="140">
                        <template
                            slot-scope="scope"
                            v-loading="scope.row.loading"
                        >
                            <button
                                class="btn btn-danger btn-lg ml-2 tw-w-24"
                                type="button"
                                @click="delItem(scope.row)"
                            >
                                ลบ
                            </button>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
        </div>
    </div>
</template>

<script>
import XLSX from "xlsx";
import moment from "moment";

export default {
    props: ["is_create"],
    data() {
        return {
            test_date: "",
            loadingInput: {},
            loading: false,
            styleDialog: "",
            form_error: {},
            form: {
                used_date: [],
                version: "",
                period_name: ""
            },
            selectInput: {},
            status: {
                tableData: false
            },
            option: {
                period_year: [],
                approve: ["อนุมัติ", "ไม่อนุมัติ"],
                organization: [],
                version: []
            },
            tableData: [],
            dialogVisible: false,
            dialog: {
                data: "",
                name: "",
                prop: "",
                index: "",
                type: ""
            },
            periodMonth: []
        };
    },
    computed: {
        header_date_from() {
            return this.dateFormat(this.form.used_date[0], true);
        },
        header_date_to() {
            return this.dateFormat(this.form.used_date[1], true);
        },
        used_date() {
            let rs = "";
            if (this.form.used_date.length > 0) {
                let from_date = this.dateFormat(this.form.used_date[0], true);
                let to_date = this.dateFormat(this.form.used_date[1], true);
                rs = `${from_date} to ${to_date}`;
            }
            return rs;
        },
        tableError() {
            let rs = true;
            if (this.tableData.length > 0) {
                const table_error = _.filter(this.tableData, item => {
                    return item.error != null;
                });
                if (table_error.length == 0) {
                    rs = false;
                }
            }
            return rs;
        }
    },
    created() {
        this.getMasterData();
    },
    methods: {
        async getMasterData() {
            this.loading = true;
            this.getPeriodYears();
            this.getOrganzation();
            this.loading = false;
        },
        getOrganzation() {
            this.loadingInput.organization = true;
            axios.get("/ct/ajax/organization_source_item_cost").then(res => {
                this.option.organization = res.data;
            });
            this.loadingInput.organization = false;
        },
        getPeriodYears(query) {
            this.loadingInput.period_year = true;
            axios.get("/ct/ajax/product_plan_amount/years").then(res => {
                this.option.period_year = res.data;
            });
            this.loadingInput.period_year = false;
        },
        getPeriodMonth() {
            axios
                .get(
                    "/ct/ajax/product_plan_amount/period-month/" +
                        this.form.period_year
                )
                .then(res => {
                    this.periodMonth = res.data;
                });
        },
        async delItem(item) {
            let confirm = false;
            confirm = await helperAlert.showProgressConfirm(
                `กรุณายืนยันลบข้อมูล รหัสวัตถุดิบ ${item.item_number}`
            );
            if (confirm) {
                let url = `/ct/ajax/purchase_price_info/line/${item.std_line_id}`;
                axios
                    .delete(url)
                    .then(res => {
                        console.log(res.data);
                        this.search();
                    })
                    .catch(error => {});
            }
        },
        async delAll() {
            let confirm = false;
            confirm = await helperAlert.showProgressConfirm(
                "กรุณายืนยันลบข้อมูล"
            );
            if (confirm) {
                let url = `/ct/ajax/purchase_price_info/head/${this.form.std_head_id}`;
                axios
                    .delete(url)
                    .then(res => {
                        this.form = {
                            used_date: [],
                            version: "",
                            period_name: ""
                        };

                        this.status = {
                            tableData: false
                        };

                        this.$message({
                            showClose: true,
                            message: "ลบข้อมูลสำเร็จ",
                            type: "success"
                        });
                    })
                    .catch(error => {});
            }
        },
        isFloat(n) {
            return Number(n) === n && n % 1 !== 0;
        },
        toFixedDecimal(num, decimal) {
            return Number.parseFloat(num).toFixed(decimal);
        },
        numberWithCommas(x) {
            return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
        },
        async approvePrice() {
            this.loading = true;
            await axios
                .get(
                    `/ct/ajax/purchase_price_info/update_status/${this.form.std_head_id}`
                )
                .then(res => {
                    this.form.status =
                        res.data.data.status == "Y"
                            ? "ยืนยันแล้ว"
                            : "ยังไม่ยืนยัน";
                    this.$message({
                        showClose: true,
                        message: "ยืนยันราคาวัตถุดิบสำเร็จ",
                        type: "success"
                    });
                })
                .catch(err => {
                    this.$message({
                        showClose: true,
                        message: `ไม่สามารถยืนยันราคาได้`,
                        type: "error"
                    });
                })
                .then(() => {
                    this.loading = false;
                });
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
        setValueNull(val) {
            val = "";
        },
        resetError() {
            setTimeout(() => {
                this.form_error = {};
            }, 5000);
        },
        dateFormat(val, th = false) {
            let rs = new Date(val);
            if (th) {
                rs = moment(val)
                    .add(543, "year")
                    .format("DD/MM/YYYY");
            } else {
                rs = moment(val).format("DD/MM/YYYY");
            }
            return rs;
        },
        async getDropDownVersion() {
            if (!this.is_create) {
                const {
                    period_year,
                    period_name,
                    organization_code
                } = this.form;
                if (period_year && organization_code) {
                    await axios
                        .get(
                            `/ct/ajax/purchase_price_info/version?period_year=${period_year}&period_name=${period_name}&organization_code=${organization_code}`
                        )
                        .then(res => {
                            this.option.version = res.data.version;
                        })
                        .catch(err => {})
                        .then(() => {});
                }
            }
        },
        async search() {
            const {
                version,
                period_year,
                period_name,
                organization_code
            } = this.form;

            await axios
                .get(
                    `/ct/ajax/purchase_price_info?version=${version}&period_year=${period_year}&period_name=${period_name}&organization_code=${organization_code}`
                )
                .then(res => {
                    if (res.data) {
                        let header = res.data;
                        this.tableData = res.data.material_cost_lines;
                        this.tableData.sort((a, b) => {
                            return a.item_number - b.item_number;
                        });
                        this.form.used_date = [
                            header.date_from,
                            header.date_to
                        ];
                        this.form.version = header.version;
                        this.form.std_head_id = header.std_head_id;
                        this.form.status =
                            header.status == "Y"
                                ? "ยืนยันแล้ว"
                                : header.status == "N"
                                ? "ยังไม่ยืนยัน"
                                : "ไม่มีข้อมูล";
                        this.status.tableData = true;

                        this.$message({
                            showClose: true,
                            message: "ประมวลผลสำเร็จ",
                            type: "success"
                        });
                    } else {
                        this.$message({
                            showClose: true,
                            message: "ไม่พบข้อมูล",
                            type: "error"
                        });
                    }
                })
                .catch(err => {
                    this.errorMessage(err.response);
                    this.$message({
                        showClose: true,
                        message: `ไม่สามารถประมวลผลได้`,
                        type: "error"
                    });
                })
                .then(() => {
                    this.form.search = false;
                    this.loading = false;
                });
        },
        async store() {
            await axios
                .post("/ct/ajax/purchase_price_info", this.form)
                .then(res => {
                    if (res.data.data) {
                        let header = res.data.data;
                        this.tableData = res.data.data.material_cost_lines;
                        this.form.used_date = [
                            header.date_from,
                            header.date_to
                        ];
                        this.form.version = header.version;
                        this.form.std_head_id = header.std_head_id;
                        this.form.status =
                            header.status == "Y"
                                ? "ยืนยันแล้ว"
                                : header.status == "N"
                                ? "ยังไม่ยืนยัน"
                                : "ไม่มีข้อมูล";

                        this.option.version = res.data.version;
                        this.status.tableData = true;

                        this.$message({
                            showClose: true,
                            message: "ประมวลผลสำเร็จ",
                            type: "success"
                        });
                    } else {
                        this.$message({
                            showClose: true,
                            message: "ไม่พบข้อมูล",
                            type: "error"
                        });
                    }
                })
                .catch(err => {
                    this.errorMessage(err.response);
                    this.$message({
                        showClose: true,
                        message: `ไม่สามารถประมวลผลได้`,
                        type: "error"
                    });
                })
                .then(() => {
                    this.loading = false;
                });
        },
        refresh() {
            this.form = {};
        },
        queryDataTable() {
            let json = [];
            this.tableData.forEach(item => {
                let data = {
                    รหัสวัตถุดิบ: item.item_number || "",
                    LOT: item.lot_number || "",
                    ชื่อวัตถุดิบ: item.item_descrtiption || "",
                    ราคาซื้อ:
                        item.unit_cost != 0
                            ? 
                            // this.numberWithCommas(
                                  parseFloat(item.unit_cost).toFixed(9)
                            //   )
                            : 0,
                    ค่าขนส่ง:
                        item.freight_cost != 0
                            ? 
                            // this.numberWithCommas(
                                  parseFloat(item.freight_cost).toFixed(9)
                            //   )
                            : 0,
                    จำนวนเงิน:
                        Number(item.unit_cost) + Number(item.freight_cost) != 0
                            ? 
                            // this.numberWithCommas(
                                  parseFloat(
                                      Number(item.unit_cost) +
                                          Number(item.freight_cost)
                                  ).toFixed(9)
                            //   )
                            : 0,
                    เปอร์เซ็น: item.material_percent,
                    จำนวนเงินรวม:
                        Number(item.unit_cost) +
                            Number(item.freight_cost) +
                            Number(item.material_percent) / 100 !=
                        0
                            ? 
                            // this.numberWithCommas(
                                  parseFloat(
                                      Number(item.unit_cost) +
                                          Number(item.freight_cost) +
                                          Number(item.material_percent) / 100
                                  ).toFixed(9)
                            //   )
                            : 0,
                    วันที่เริ่มใช้: item.date_from,
                    วันที่สิ้นสุด: item.date_to,
                    Error: item.error ? item.error : ":)"
                };
                json.push(data);
            });

            this.exportJson(json);
        },
        exportJson(json) {
            let data = json;
            /* this line is only needed if you are not adding a script tag reference */
            // if (typeof XLSX == "undefined") XLSX = require("xlsx");

            /* make the worksheet */
            let ws = XLSX.utils.json_to_sheet(data);

            /* add to workbook */
            let wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "นำเข้าข้อมูลราคาซื้อ");

            /* generate an XLSX file */
            XLSX.writeFile(wb, "นำเข้าข้อมูลราคาซื้อ.xlsx");
        },
        openDialog(prop, name, data) {
            this.styleDialog = `width: 30%; z-index:200; margin-top:calc(${window.pageYOffset}px + 15vh)`;
            let body = document.getElementsByTagName("BODY")[0];
            body.style.overflow = "hidden";
            this.dialog.name = name;
            if (data) {
                this.dialog.data = data.row[prop];
                this.dialog.index = data.$index;
            }
            this.dialog.prop = prop;
            switch (prop) {
                case "status":
                    this.dialog.type = "status";
                    break;
                case "lot_number":
                    this.dialog.type = "text";
                    break;
                case "unit_cost":
                case "freight_cost":
                    this.dialog.data = this.toFixedDecimal(this.dialog.data, 9);
                case "material_percent":
                    this.dialog.type = "number";
                    break;
                case "date_from":
                case "date_to":
                    // this.dialog.data = this.dateFormat(this.dialog.data);
                    this.dialog.type = "date";
                    break;
                case "approve_price":
                    this.dialog.type = "approve_price";
                    break;
            }
            this.dialogVisible = true;
        },
        closeDialog() {
            let body = document.getElementsByTagName("BODY")[0];
            body.style = "";
            this.dialog = {
                data: "",
                name: "",
                prop: "",
                index: "",
                type: ""
            };
            this.dialogVisible = false;
        },
        submitDialog() {
            let { data, prop, index } = this.dialog;

            if (prop == "approve_price") {
                this.approvePrice();
            } else {
                if (prop == "unit_cost" || prop == "freight_cost") {
                    data = this.toFixedDecimal(data, 9);
                } else if (prop == "date_from" || prop == "date_to") {
                    data = `${moment(data).format("YYYY-MM-DD")} 00:00:00`;
                }
                this.tableData[index][prop] = data;
                this.updateRow(this.tableData[index], index, prop);
            }
            this.closeDialog();
        },
        updateRow(line_data, index, prop) {
            if (prop == "unit_cost" || prop == "freight_cost") {
                var total =
                    parseFloat(line_data.unit_cost) +
                    parseFloat(line_data.freight_cost);

                line_data.dm_std_unitcost = total;
                line_data.subtotal = total;
            }

            let url = `/ct/ajax/purchase_price_info/line/${line_data.std_line_id}`;
            axios
                .put(url, line_data)
                .then(res => {
                    const { data } = res.data;
                    this.tableData[index]["error"] = data.error;
                })
                .catch(error => {});
        }
    }
};
</script>
<style lang="scss" scoped>
.period-date {
    width: 100%;
}

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
.td-select {
    cursor: pointer;
    border: 2px solid #eee;
    border-radius: 5px;
    padding: 10px 0;
}
.background-dialog__custom {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 100;
    background: #f3f3f4;
    opacity: 0.7;
}
.flex_end {
    display: flex;
    justify-content: flex-end;
}
</style>
