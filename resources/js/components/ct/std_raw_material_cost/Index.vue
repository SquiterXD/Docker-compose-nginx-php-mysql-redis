<template>
    <div v-loading="loading">
        <div class="m-2 ">
            <div class="form-group row">
                <h2 class="text-bold ml-1">
                    {{
                        is_create
                            ? "สร้างรายการต้นทุนวัตถุดิบมาตรฐาน"
                            : "ค้นหาข้อมูลต้นทุนวัตถุดิบมาตรฐาน"
                    }}
                </h2>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">ปีบัญชี</label>
                <div class="col-md-4 flex-wrap">
                    <el-select
                        style="width:100%;"
                        v-model="form.period_year"
                        placeholder="ปีบัญชีงบ"
                        @change="selectFiscalYear()"
                    >
                        <el-option
                            v-for="(item, index) in option.fiscal_year"
                            :key="index"
                            :label="item.label_year"
                            :value="item.period_year"
                        >
                        </el-option>
                    </el-select>
                    <div class="error-message" v-if="form_error.fiscal_year">
                        <strong class="font-bold">{{
                            form_error.fiscal_year.title
                        }}</strong>
                        <span class="block sm:inline">
                            {{ form_error.fiscal_year.message }}
                        </span>
                    </div>
                </div>

                <label class="col-md-2 col-form-label">วันที่เริ่มใช้</label>
                <div class="col-md-4 flex-wrap">
                    <!-- <el-input
                        type="text"
                        v-model="form.start_date_thai"
                        placeholder="วันที่เริ่มใช้"
                        :disabled="
                            form.approved_status == 'อนุมัติ' ||
                                tableDataHeader.length <= 0
                        "
                    ></el-input> -->
                    <div>
                        <ct-std-datepicker-th
                            :class="
                                `form-control ${
                                    form.approved_status == 'อนุมัติ' ||
                                    tableDataHeader.length <= 0
                                        ? 'input-disable'
                                        : ''
                                }`
                            "
                            :inputClass="
                                form.approved_status == 'อนุมัติ' ||
                                tableDataHeader.length <= 0
                                    ? 'input-disable'
                                    : ''
                            "
                            :disableDate="form.approved_status == 'อนุมัติ' ||
                            tableDataHeader.length <= 0"
                            placeholder="วันที่เริ่มใช้"
                            :value="form.start_date_thai"
                            @dateWasSelected="startDateSelected"
                        />
                    </div>

                    <div class="error-message" v-if="form_error.date_from">
                        <strong class="font-bold">{{
                            form_error.date_from.title
                        }}</strong>
                        <span class="block sm:inline">
                            {{ form_error.date_from.message }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label"
                    >แผนการผลิตครั้งที่</label
                >
                <div class="col-md-4 flex-wrap">
                    <el-input
                        v-if="is_create"
                        v-model="form.plan_version"
                        placeholder="แผนการผลิตครั้งที่"
                        type="text"
                    ></el-input>
                    <el-select
                        style="width:100%;"
                        placeholder="แผนการผลิตครั้งที่"
                        v-model="form.plan_version"
                        v-if="!is_create"
                    >
                        <el-option
                            v-for="(item, index) in option.plan_version_no"
                            :key="index"
                            :label="item.plan_version_no"
                            :value="item.plan_version_no"
                        >
                        </el-option>
                    </el-select>
                    <div
                        class="error-message"
                        v-if="form_error.plan_version_no"
                    >
                        <strong class="font-bold">{{
                            form_error.plan_version_no.title
                        }}</strong>
                        <span class="block sm:inline">
                            {{ form_error.plan_version_no.message }}
                        </span>
                    </div>
                </div>

                <label class="col-md-2 col-form-label">วันที่สิ้นสุด</label>
                <div class="col-md-4 flex-wrap">
                    <ct-std-datepicker-th
                        :class="
                            `form-control ${
                                form.approved_status == 'อนุมัติ' ||
                                tableDataHeader.length <= 0
                                    ? 'input-disable'
                                    : ''
                            }`
                        "
                        :inputClass="
                            form.approved_status == 'อนุมัติ' ||
                            tableDataHeader.length <= 0
                                ? 'input-disable'
                                : ''
                        "
                        :disableDate="form.approved_status == 'อนุมัติ' ||
                            tableDataHeader.length <= 0"
                        placeholder="วันที่สิ้นสุด"
                        :value="form.end_date_thai"
                        @dateWasSelected="endDateSelected"
                    />
                    <!-- <el-input
                        type="text"
                        v-model="form.end_date_thai"
                        placeholder="วันที่สิ้นสุด"
                        :disabled="
                            form.approved_status == 'อนุมัติ' ||
                                tableDataHeader.length <= 0
                        "
                    ></el-input> -->

                    <div class="error-message" v-if="form_error.date_to">
                        <strong class="font-bold">{{
                            form_error.date_to.title
                        }}</strong>
                        <span class="block sm:inline">
                            {{ form_error.date_to.message }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">ครั้งที่</label>
                <div class="col-md-4 flex-wrap">
                    <el-input
                        v-if="is_create"
                        v-model="form.version"
                        placeholder="ครั้งที่"
                        type="text"
                    ></el-input>
                    <el-select
                        style="width:100%;"
                        placeholder="ครั้งที่"
                        v-model="form.version"
                        v-if="!is_create"
                    >
                        <el-option
                            v-for="(item, index) in option.version"
                            :key="index"
                            :label="item.version_no"
                            :value="item.version_no"
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
                <label class="col-md-2 col-form-label">สถานะ</label>
                <div class="col-md-4 flex-wrap">
                    <el-input
                        class="w-100"
                        placeholder="สถานะ"
                        v-model="form.approved_status"
                        disabled
                    ></el-input>
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
                <label class="col-md-2 col-form-label">ศูนย์ต้นทุน</label>
                <div class="col-md-4 flex-wrap">
                    <el-select
                        style="width:100%;"
                        v-model="form.cost_code"
                        placeholder="ศูนย์ต้นทุน"
                        @change="selectCostCenter()"
                    >
                        <el-option
                            v-for="(item, index) in option.cost_center"
                            :key="index"
                            :label="`${item.cost_code} - ${item.description}`"
                            :value="item.cost_code"
                        >
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

            <div class="form-group row">
                <label class="col-md-2 col-form-label"
                    >หน่วยนับต่อศูนย์ต้นทุน</label
                >
                <div class="col-md-4 flex-wrap">
                    <el-input
                        placeholder="หน่วยนับต่อศูนย์ต้นทุน"
                        v-model="unitPerCostCenter"
                        disabled
                    ></el-input>
                    <div
                        class="error-message"
                        v-if="form_error.qty_per_cost_center"
                    >
                        <strong class="font-bold">{{
                            form_error.qty_per_cost_center.title
                        }}</strong>
                        <span class="block sm:inline">
                            {{ form_error.qty_per_cost_center.message }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 text-right mt-2">
                    <el-button
                        v-if="!is_create"
                        class="btn-info mr-2 "
                        type="primary"
                        size="small"
                        @click="search()"
                    >
                        ค้นหา
                    </el-button>
                    <el-button
                        v-if="status.tableDataLine"
                        class="btn-info mr-2"
                        type="primary"
                        size="small"
                        @click="queryDataTableLine"
                    >
                        EXPORT
                    </el-button>
                    <el-button
                        v-if="status.tableData && !status.tableDataLine"
                        class="btn-info mr-2"
                        type="primary"
                        size="small"
                        @click="queryTableDataHeader"
                    >
                        EXPORT
                    </el-button>
                    <el-button
                        :disabled="disableStore"
                        v-if="is_create"
                        class="btn-primary mr-2"
                        type="primary"
                        size="small"
                        @click="store()"
                    >
                        ดึงต้นทุนวัตถุดิบ
                    </el-button>
                    <el-button
                        v-if="
                            status.tableData &&
                                (old_data.start_date_thai !=
                                    form.start_date_thai ||
                                    old_data.end_date_thai !=
                                        form.end_date_thai)
                        "
                        class="btn-info mr-2"
                        type="primary"
                        size="small"
                        @click="updateDateThai"
                    >
                        อัพเดทวันที่เริ่มใช้ - วันที่สิ้นสุด
                    </el-button>
                    <el-button
                        v-if="status.tableData"
                        class="btn-success"
                        type="success"
                        size="small"
                        @click="approveHeaderData"
                    >
                        ยืนยันต้นทุนวัตถุดิบ
                    </el-button>
                </div>
            </div>
        </div>

        <div class="form-group row" v-if="status.tableData">
            <div class="col-md-12 mt-2 flex-wrap">

                <div v-show="!status.tableDataLine">

                    <div class="col-lg-12 mt-2">
                        <div style="background-color: #d9d9d9; color: black; font-weight: bold;padding:10px;margin:auto;">
                            <h4>
                                ผลิตภัณฑ์ที่ยังไม่อนุมัติต้นทุนวัตถุดิบ
                            </h4>
                        </div>
                        <el-table
                            border
                            :data="tableDataHeaderN"
                            style="width: 100%; font-size: 13px;"
                            @selection-change="handleSelectionChangeN"
                            ref="multipleTableN"
                        >
                            <el-table-column
                                label="ตรวจสอบทั้งหมด"
                                header-align="center"
                            >
                                <el-table-column
                                    type="selection"
                                    width="160"
                                    align="center"
                                >
                                </el-table-column>
                            </el-table-column>
                            <el-table-column
                                label="กลุ่มผลิตภัณฑ์"
                                header-align="center"
                                width="180"
                            >
                                <template slot-scope="scope">
                                    {{ scope.row.product_group }}
                                    {{ scope.row.product_group_name }}
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="product_item_number"
                                label="ผลิตภัณฑ์"
                                header-align="center"
                                width="130"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="product_item_desc"
                                label="ชื่อผลิตภัณฑ์"
                                header-align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="cost_raw_mate"
                                label="ต้นทุนวัตถุดิบรวม (บาท)"
                                align="right"
                                width="160"
                            >
                                <template slot-scope="scope">
                                    {{
                                        scope.row.cost_raw_mate != 0
                                            ? numberWithCommas(
                                                  parseFloat(
                                                      scope.row.cost_raw_mate
                                                  ).toFixed(9)
                                              )
                                            : scope.row.cost_raw_mate
                                    }}
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="unit_cost_raw_mate"
                                label="ต้นทุนวัตถุดิบต่อ 1 หน่วย"
                                align="right"
                                width="180"
                            >
                                <template slot-scope="scope">
                                    {{
                                        scope.row.unit_cost_raw_mate != 0
                                            ? numberWithCommas(
                                                  parseFloat(
                                                      scope.row
                                                          .unit_cost_raw_mate
                                                  ).toFixed(9)
                                              )
                                            : scope.row.unit_cost_raw_mate
                                    }}
                                </template>
                            </el-table-column>

                            <el-table-column
                                prop="recipe_status"
                                label="สถานะสูตรมาตราฐาน"
                                align="center"
                                header-align="center"
                            >
                            </el-table-column>

                            <!-- <el-table-column
                                prop="start_date"
                                label="วันที่เริ่มใช้"
                                align="center"
                                :formatter="DateFormat"
                                width="120"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="end_date"
                                align="center"
                                label="วันที่สิ้นสุด"
                                :formatter="DateFormat"
                                width="120"
                            >
                            </el-table-column> -->

                            <el-table-column
                                label="รายละเอียดวัตถุดิบ"
                                align="center"
                                width="140"
                            >
                                <template slot-scope="scope">
                                    <el-button
                                        class="btn btn-info"
                                        type="success"
                                        size="small"
                                        @click="getTableDataLine(scope.row)"
                                    >
                                        รายละเอียด
                                    </el-button>
                                </template>
                            </el-table-column>
                            <el-table-column
                                label="อนุมัติต้นทุนวัตถุดิบ"
                                align="center"
                                width="140"
                            >
                                <template slot-scope="scope">
                                    <el-button
                                        class="btn btn-success"
                                        type="success"
                                        size="small"
                                        @click="approveLineData(scope.row)"
                                    >
                                    อนุมัติต้นทุนวัตถุดิบ
                                    </el-button>
                                </template>
                            </el-table-column>
                        </el-table>
                    </div>

                    <div class="col-lg-12 mt-2">
                        <div class="mt-5" style="background-color: #d9d9d9; color: black; font-weight: bold;padding:10px;margin:auto;">
                            <h4 >
                                ผลิตภัณฑ์ที่อนุมัติต้นทุนวัตถุดิบแล้ว
                            </h4>
                        </div>
                        <el-table
                            border
                            :data="tableDataHeaderY"
                            style="width: 100%; font-size: 13px;"
                            @selection-change="handleSelectionChangeY"
                            ref="multipleTableY"
                        >
                            <el-table-column
                                label="ตรวจสอบทั้งหมด"
                                header-align="center"
                            >
                                <el-table-column
                                    type="selection"
                                    width="160"
                                    align="center"
                                >
                                </el-table-column>
                            </el-table-column>
                            <el-table-column
                                label="กลุ่มผลิตภัณฑ์"
                                header-align="center"
                                width="180"
                            >
                                <template slot-scope="scope">
                                    {{ scope.row.product_group }}
                                    {{ scope.row.product_group_name }}
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="product_item_number"
                                label="ผลิตภัณฑ์"
                                header-align="center"
                                width="130"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="product_item_desc"
                                label="ชื่อผลิตภัณฑ์"
                                header-align="center"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="cost_raw_mate"
                                label="ต้นทุนวัตถุดิบรวม (บาท)"
                                align="right"
                                width="160"
                            >
                                <template slot-scope="scope">
                                    {{
                                        scope.row.cost_raw_mate != 0
                                            ? numberWithCommas(
                                                  parseFloat(
                                                      scope.row.cost_raw_mate
                                                  ).toFixed(9)
                                              )
                                            : scope.row.cost_raw_mate
                                    }}
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="unit_cost_raw_mate"
                                label="ต้นทุนวัตถุดิบต่อ 1 หน่วย"
                                align="right"
                                width="180"
                            >
                                <template slot-scope="scope">
                                    {{
                                        scope.row.unit_cost_raw_mate != 0
                                            ? numberWithCommas(
                                                  parseFloat(
                                                      scope.row
                                                          .unit_cost_raw_mate
                                                  ).toFixed(9)
                                              )
                                            : scope.row.unit_cost_raw_mate
                                    }}
                                </template>
                            </el-table-column>

                            <el-table-column
                                prop="recipe_status"
                                label="สถานะสูตรมาตราฐาน"
                                align="center"
                                header-align="center"
                                width="160"
                            >
                            </el-table-column>

                            <!-- <el-table-column
                                prop="start_date"
                                label="วันที่เริ่มใช้"
                                align="center"
                                :formatter="DateFormat"
                                width="120"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="end_date"
                                align="center"
                                label="วันที่สิ้นสุด"
                                :formatter="DateFormat"
                                width="120"
                            >
                            </el-table-column> -->

                            <el-table-column
                                label="รายละเอียดวัตถุดิบ"
                                align="center"
                                width="140"
                            >
                                <template slot-scope="scope">
                                    <el-button
                                        class="btn btn-info"
                                        type="success"
                                        size="small"
                                        @click="getTableDataLine(scope.row)"
                                    >
                                        รายละเอียด
                                    </el-button>
                                </template>
                            </el-table-column>
                            <el-table-column
                                label="อนุมัติต้นทุนวัตถุดิบ"
                                align="center"
                                width="140"
                            >
                                <template slot-scope="scope">
                                    อนุมัติต้นทุนวัตถุดิบ
                                </template>
                            </el-table-column>
                        </el-table>
                    </div>
                </div>

                <div v-show="status.tableDataLine">
                    <div class="my-2">
                        <div>
                            <span class="font-bold">กลุ่มผลิตภัณฑ์ :</span>
                            {{ headLine.productGroup }}
                        </div>
                        <div>
                            <span class="font-bold">ผลิตภัณฑ์ :</span>
                            {{ headLine.productGroupDetail }}
                        </div>
                    </div>
                    <el-table
                        border
                        :data="tableDataLine"
                        style="width: 100%"
                        :summary-method="getSummaries"
                        show-summary
                    >
                        <el-table-column
                            prop="item_number"
                            label="รหัสวัตถุดิบ"
                            align="center"
                        >
                        </el-table-column>
                        <el-table-column
                            prop="item_desc"
                            label="ชื่อวัตถุดิบ"
                            align="left"
                            header-align="center"
                        >
                        </el-table-column>
                        <el-table-column
                            prop="wip_step"
                            label="ขั้นตอน"
                            align="center"
                        >
                        </el-table-column>
                        <el-table-column
                            prop="quantity_used"
                            label="จำนวนที่ใช้"
                            align="center"
                        >
                            <template slot-scope="scope">
                                {{
                                    scope.row.quantity_used != 0
                                        ? numberWithCommas(
                                              parseFloat(
                                                  scope.row.quantity_used
                                              ).toFixed(9)
                                          )
                                        : scope.row.quantity_used
                                }}
                            </template>
                        </el-table-column>
                        <el-table-column
                            prop="uom_code"
                            label="หน่วย"
                            align="center"
                        >
                        </el-table-column>
                        <el-table-column
                            prop="last_cost"
                            label="ราคาซื้อครั้งสุดท้าย"
                            align="center"
                        >
                            <template slot-scope="scope">
                                {{
                                    scope.row.last_cost != 0
                                        ? numberWithCommas(
                                              parseFloat(
                                                  scope.row.last_cost
                                              ).toFixed(9)
                                          )
                                        : scope.row.last_cost
                                }}
                            </template>
                        </el-table-column>
                        <el-table-column
                            prop="unit_std_cost"
                            label="ราคามาตรฐานต่อหน่วย"
                            align="center"
                        >
                            <template slot-scope="scope">
                                {{
                                    scope.row.unit_std_cost != 0
                                        ? numberWithCommas(
                                              parseFloat(
                                                  scope.row.unit_std_cost
                                              ).toFixed(9)
                                          )
                                        : scope.row.unit_std_cost
                                }}
                            </template>
                        </el-table-column>
                        <el-table-column
                            prop="cost_raw_mate"
                            label="ต้นทุนวัตถุดิบรวม"
                            align="center"
                        >
                            <template slot-scope="scope">
                                {{
                                    scope.row.cost_raw_mate != 0
                                        ? numberWithCommas(
                                              parseFloat(
                                                  scope.row.cost_raw_mate
                                              ).toFixed(9)
                                          )
                                        : scope.row.cost_raw_mate
                                }}
                            </template>
                        </el-table-column>
                    </el-table>
                    <div class="col-md-12 text-right mt-4 px-0">
                        <el-button
                            class="btn-danger"
                            @click.native.prevent="closeTableLine()"
                            type="danger"
                        >
                            ปิด
                        </el-button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import numeral from "numeral";
import XLSX from "xlsx";

export default {
    props: ["is_create"],
    data() {
        return {
            loadingInput: {},
            loading: false,
            form_error: {},
            form: {
                period_year: "",
                cost_code: "",
                uom_code: "",
                description: "",
                quantity: "",
                version: "",
                plan_version: "",
                start_date_thai: "",
                end_date_thai: "",
                shot_year_thai: "",
                approved_status: ""
            },
            date_form: {
                start_date: "",
                end_date: ""
            },
            old_data: {
                start_date_thai: "",
                end_date_thai: ""
            },
            status: {
                tableData: false,
                tableDataLine: false
            },
            option: {
                fiscal_year: [],
                cost_center: [],
                plan_version_no: [],
                version: []
            },
            enable_flag_select: [],
            enable_flag_selectY: [],
            enable_flag_selectN: [],
            multipleSelection: [],
            multipleSelectionY: [],
            multipleSelectionN: [],
            tableDataHeader: [],
            tableDataLine: [],
            headLine: {}
        };
    },
    computed: {
        unitPerCostCenter() {
            let rs = "";
            if (
                this.form.cost_code &&
                this.form.quantity &&
                this.form.uom_code
            ) {
                rs = `${this.form.quantity} ${this.form.uom_code}`;
            }
            return rs;
        },
        disableStore() {
            if (
                this.form.cost_code &&
                this.form.period_year &&
                this.form.version
            ) {
                return false;
            } else {
                return true;
            }
        }
    },
    created() {
        this.getMasterData();
    },
    methods: {
        startDateSelected(date) {
            this.form.start_date_thai = moment(date).format("DD/MM/YYYY");
        },
        endDateSelected(date) {
            this.form.end_date_thai = moment(date).format("DD/MM/YYYY");
        },
        updateDateThai() {
            const form = {
                start_date_thai: this.form.start_date_thai,
                end_date_thai: this.form.end_date_thai,
                cost_code: this.form.cost_code,
                period_year: this.form.period_year,
                version_no: this.form.version,
                plan_version: this.form.plan_version
            };
            axios
                .post("/ct/ajax/std_raw_material_cost/date", form)
                .then(res => {
                    if (res.data.status == 'E') {
                        this.$message({
                            showClose: true,
                            message: res.data.msg,
                            type: "error"
                        });
                    }else{
                        this.$message({
                            showClose: true,
                            message: "อัพเดทวันที่สำเร็จ",
                            type: "success"
                        });
                        this.old_data.start_date_thai = this.form.start_date_thai;
                        this.old_data.end_date_thai = this.form.end_date_thai;
                    }
                })
                .catch(err => {});
        },
        toggleSelection(rows) {
            if (rows) {
                rows.forEach(row => {
                    this.$refs.multipleTable.toggleRowSelection(row);
                });
            } else {
                this.$refs.multipleTable.clearSelection();
            }
        },
        toggleSelectionY(rows) {
            if (rows) {
                rows.forEach(row => {
                    this.$refs.multipleTableY.toggleRowSelection(row);
                });
            } else {
                this.$refs.multipleTableY.clearSelection();
            }
        },
        toggleSelectionN(rows) {
            if (rows) {
                rows.forEach(row => {
                    this.$refs.multipleTableN.toggleRowSelection(row);
                });
            } else {
                this.$refs.multipleTableN.clearSelection();
            }
        },
        async handleSelectionChange(val) {
            this.multipleSelection = val;
            let selection = [];

            val.forEach(item => {
                selection.push(item.product_item_number);
            });

            this.enable_flag_select = await selection;
            await this.enableFlagUpdate();
        },
        async handleSelectionChangeY(val) {
            let select_flag = [];
            this.tableDataHeaderN.forEach(item => {
                if(item.enable_flag == "Y"){
                    select_flag.push(item.product_item_number);
                                    }
            });
            val.forEach(item => {
                select_flag.push(item.product_item_number);
            });
            this.enable_flag_select = await select_flag;
            await this.enableFlagUpdate();
        },
        async handleSelectionChangeN(val) {
            let select_flag = [];
            this.tableDataHeaderY.forEach(item => {
                if(item.enable_flag == "Y"){
                    select_flag.push(item.product_item_number);
                                    }
            });
            val.forEach(item => {
                select_flag.push(item.product_item_number);
            });

            this.enable_flag_select = await select_flag;
            await this.enableFlagUpdate();
        },
        enableFlagUpdate: _.debounce(async function() {
            this.loading = await true;

            this.form.enable_flag = await [...new Set(this.enable_flag_select)];;
            axios
                .post(`/ct/ajax/std_raw_material_cost/enable_flag`, this.form)
                .then(res => {
                    console.log(res.data);
                    const { cost_code, period_year, version, plan_version } = this.form;
                    axios.get(`/ct/ajax/std_raw_material_cost?cost_code=${cost_code}&period_year=${period_year}&version_no=${version}&plan_version_no=${plan_version}`)
                    .then(res => {
                        this.tableDataHeader = res.data.data;
                        this.tableDataHeader.sort((a, b) => {
                            return (
                                a.product_item_number - b.product_item_number
                            );
                        });

                    })
                })
                .catch(err => {})
                .then(() => {
                    this.loading = false;
                });
        }, 1000),
        numberWithCommas(x) {
            return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
        },
        numberFormat(v, format = "0.0[000000000]") {
            let res = numeral(v).format(format);

            if (res == "NaN") {
                res = v;
            }
            return res;
        },
        async getMasterData() {
            this.loading = true;
            this.getPeriodYears();
            this.getCostCenters();
            this.loading = false;
        },
        getCostCenters() {
            this.loading = true;
            // if (this.is_create) {
            axios
                .get("/ct/ajax/cost_center/cost-center-view")
                .then(res => {
                    this.option.cost_center = res.data;
                })
                .then(() => {
                    this.loading = false;
                });
            // } else {
            // axios.get("/ct/ajax/std_raw_material_cost/get_cost_center", {
            //     params: {
            //         version_no: this.form.version,
            //     }
            // })
            // .then(res => {
            //     this.option.cost_center = res.data;
            // })
            // .then(() => {
            //     this.loading = false;
            // });
            // }
        },
        getPeriodYears() {
            this.loadingInput.fiscal_year = true;
            axios.get("/ct/ajax/product_plan_amount/years").then(res => {
                this.option.fiscal_year = res.data;
            });
            this.loadingInput.fiscal_year = false;
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
        selectFiscalYear() {
            const years = this.option.fiscal_year.find(
                item => item.period_year == this.form.period_year
            );
            // this.form.start_date_thai = years.start_date_thai;
            // this.form.end_date_thai = years.end_date_thai;
            this.form.shot_year_thai = years.shot_year_thai;

            this.getDropDownVersion();
            this.getDropDownPlanVersion();
            this.getPlanVersion();
            this.getVersion();
        },
        selectCostCenter() {
            const cost_center = this.option.cost_center.find(
                item => item.cost_code == this.form.cost_code
            );

            this.form.description = cost_center.description;
            this.form.uom_code = cost_center.uom_code;
            this.form.quantity = cost_center.quantity;
        },
        resetError() {
            setTimeout(() => {
                this.form_error = {};
            }, 5000);
        },
        getSummaries(param) {
            const { columns, data } = param;
            const sums = [];
            columns.forEach((column, index) => {
                if (index === 0) {
                    sums[index] = "รวม";
                    return;
                }
                const values = data.map(item => Number(item[column.property]));
                if (
                    column.property == "cost_raw_mate" &&
                    !values.every(value => isNaN(value))
                ) {
                    sums[index] =
                        this.headLine.summary_cost != 0
                            ? this.numberWithCommas(
                                  parseFloat(
                                      this.headLine.summary_cost
                                  ).toFixed(9)
                              )
                            : this.headLine.summary_cost;
                } else if (
                    column.property == "quantity_used" &&
                    !values.every(value => isNaN(value))
                ) {
                    const sum = _.sumBy(this.tableDataLine, function(item) {
                        return parseFloat(item.quantity_used);
                    });
                    sums[index] = this.numberWithCommas(
                        parseFloat(sum).toFixed(9)
                    );
                } else {
                    sums[index] = "";
                }
            });
            return sums;
        },
        async getTableDataLine(row) {
            this.loading = true;
            this.headLine.productGroup = `${row.product_group} ${row.product_group_name}`;
            this.headLine.productGroupDetail = `${row.product_item_number}-${row.product_item_desc}`;
            this.headLine.summary_cost = `${row.summary_cost}`;

            await axios
                .get(
                    `/ct/ajax/std_raw_material_cost/find?allocate_year_id=${row.allocate_year_id}&product_group=${row.product_group}&product_item_number=${row.product_item_number}`
                )
                .then(res => {
                    this.tableDataLine = res.data;
                    this.tableDataLine.sort((a, b) => {
                        return a.item_number - b.item_number;
                    });
                    this.status.tableDataLine = true;

                    this.$message({
                        showClose: true,
                        message: "ประมวลผลสำเร็จ",
                        type: "success"
                    });
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

        async getDropDownPlanVersion() {
            if (!this.is_create) {
                const { period_year, cost_code } = this.form;
                // if (period_year && cost_code) {
                await axios
                    .get(
                        `/ct/ajax/std_raw_material_cost/plan_version_cost_head?period_year=${period_year}&cost_code=${cost_code}`
                    )
                    .then(res => {
                        this.option.plan_version_no = res.data.plan_version_no;
                    })
                    .catch(err => {})
                    .then(() => {});
                // }
            }
        },

        async getDropDownVersion() {
            if (!this.is_create) {
                const { period_year, cost_code } = this.form;
                // if (period_year && cost_code) {
                await axios
                    .get(
                        `/ct/ajax/std_raw_material_cost/version?period_year=${period_year}&cost_code=${cost_code}`
                    )
                    .then(res => {
                        this.option.version = res.data.version;
                    })
                    .catch(err => {})
                    .then(() => {});
                // }
            }
        },
        async search() {
            this.loading = true;
            const { cost_code, period_year, version, plan_version } = this.form;
            await axios
                .get(
                    `/ct/ajax/std_raw_material_cost?cost_code=${cost_code}&period_year=${period_year}&version_no=${version}&plan_version_no=${plan_version}`
                )
                .then(res => {
                    if (res.data.data.length > 0 && res.data.std_cost_head) {
                        const { std_cost_head } = res.data;
                        this.tableDataHeader = res.data.data;
                        this.tableDataHeader.sort((a, b) => {
                            return (
                                a.product_item_number - b.product_item_number
                            );
                        });

                        this.tableDataHeaderY = this.tableDataHeader.filter(item => item.approved_flag == 'Y')
                        this.tableDataHeaderN = this.tableDataHeader.filter(item => item.approved_flag == 'N')

                        setTimeout(() => {
                            // const select_flag = _.filter(
                            //     this.tableDataHeader,
                            //     item => {
                            //         return item.enable_flag == "Y";
                            //     }
                            // );
                            const select_flagY = _.filter(
                                this.tableDataHeaderY,
                                item => {
                                    return item.enable_flag == "Y";
                                }
                            );
                            const select_flagN = _.filter(
                                this.tableDataHeaderN,
                                item => {
                                    return item.enable_flag == "Y";
                                }
                            );
                            // this.toggleSelection(select_flag);
                            this.toggleSelectionY(select_flagY);
                            this.toggleSelectionN(select_flagN);
                        }, 1000);




                        this.old_data.start_date_thai =
                            std_cost_head.start_date_thai;
                        this.form.start_date_thai =
                            std_cost_head.start_date_thai;

                        this.old_data.end_date_thai =
                            std_cost_head.end_date_thai;
                        this.form.end_date_thai = std_cost_head.end_date_thai;

                        this.form.approved_status = this.convertStatus(
                            std_cost_head.approved_status
                        );
                        this.status.tableData = true;

                        this.$message({
                            showClose: true,
                            message: "ประมวลผลสำเร็จ",
                            type: "success"
                        });
                    } else {
                        this.tableDataHeader = [];
                        this.form.approved_status = "";
                        this.status.tableData = false;
                        if (!res.data.std_cost_head) {
                            this.$message({
                                showClose: true,
                                message: `ไม่พบข้อมูล std_cost_heads`,
                                type: "error"
                            });
                        } else if (res.data.data.length <= 0) {
                            this.$message({
                                showClose: true,
                                message: `ไม่พบข้อมูลต้นทุนวัตถุดิบมาตรฐาน`,
                                type: "error"
                            });
                        } else {
                        }
                    }
                })
                .catch(err => {
                    this.tableDataHeader = [];
                    this.form.approved_status = "";
                    this.status.tableData = false;

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
        async store() {
            this.loading = await true;
            await axios
                .post(`/ct/ajax/std_raw_material_cost`, this.form)
                .then(res => {})
                .catch(err => {
                    console.log(err.response.data);
                });
            await this.search();
        },
        async approveHeaderData() {
            this.loading = await true;
            this.form.enable_flag = await this.enable_flag_select;
            await axios
                .post(`/ct/ajax/std_raw_material_cost/approve`, this.form)
                .then(res => {
                    console.log(res.data);
                    this.form.status = "ยืนยันแล้ว";
                    this.form.approved_status = this.convertStatus(
                        res.data.data
                    );

                    if (res.data.status == 'E') {
                        this.$message({
                            showClose: true,
                            message: res.data.msg,
                            type: "error"
                        });
                    }else{
                        this.$message({
                            showClose: true,
                            message: "ประมวลผลสำเร็จ",
                            type: "success"
                        });
                    }
                })
                .catch(err => {
                    let error = err.response.data.error
                        ? err.response.data.error
                        : "ไม่สามารถประมวลผลได้";

                    this.errorMessage(err.response);
                    this.$message({
                        showClose: true,
                        message: error,
                        type: "error"
                    });
                })
                .then(() => {
                    this.loading = false;
                });
        },
        async approveLineData(row) {
            this.loading = await true;
            // this.form.enable_flag = await this.enable_flag_select;
            let body = {
                product_item_number: row.product_item_number,
                cost_code: row.cost_code,
                allocate_year_id: row.allocate_year_id,
            };
            await axios
                .post(`/ct/ajax/std_raw_material_cost/approveLineData`, body)
                .then(res => { 
                    this.form.status = "ยืนยันแล้ว";
                    this.form.approved_status = this.convertStatus(
                        res.data.data
                    );
                    this.$message({
                        showClose: true,
                        message: "ประมวลผลสำเร็จ",
                        type: "success"
                    });
                })
                .catch(err => {
                    let error = err.response.data.error
                        ? err.response.data.error
                        : "ไม่สามารถประมวลผลได้";

                    this.errorMessage(err.response);
                    this.$message({
                        showClose: true,
                        message: error,
                        type: "error"
                    });
                })
                .then(() => {
                    this.loading = false;
                });
                await this.search();
        },
        saveTableLine() {
            // update table line then refresh tableHeader
            this.store();
            this.closeTableLine();
        },
        closeTableLine() {
            this.status.tableDataLine = false;
        },
        refresh() {
            this.form = {};
        },
        queryDataTableLine() {
            let json = [];
            this.tableDataLine.forEach(item => {
                let data = {
                    รหัสวัตถุดิบ: item.item_number || "",
                    ชื่อวัตถุดิบ: item.item_desc || "",
                    ขั้นตอน: item.wip_step || "",
                    จำนวนที่ใช้: item.quantity_used || "",
                    หน่วย: item.uom_code || "",
                    ราคาซื้อครั้งสุดท้าย:
                        this.numberWithCommas(
                            parseFloat(item.last_cost).toFixed(9)
                        ) || "",
                    ราคามาตรฐานต่อหน่วย:
                        this.numberWithCommas(
                            parseFloat(item.unit_std_cost).toFixed(9)
                        ) || "",
                    ต้นทุนวัตถุดิบรวม:
                        this.numberWithCommas(
                            parseFloat(item.cost_raw_mate).toFixed(9)
                        ) || ""
                };
                json.push(data);
            });

            this.exportJson(json);
        },
        async queryTableDataHeader() {
            let json = [];

            this.tableDataHeader.forEach(item => {
                let data = {
                    ศูนย์ต้นทุน: this.form.cost_code || "",
                    ปีงบประมาณ: this.form.period_year || "",
                    กลุ่มผลิตภัณฑ์:
                        item.product_group + item.product_group_name || "",
                    ผลิตภัณฑ์: item.product_item_number || "",
                    ชื่อผลิตภัณฑ์: item.product_item_desc || "",
                    "ต้นทุนวัตถุดิบรวม(บาท)":
                        this.numberWithCommas(
                            parseFloat(item.cost_raw_mate).toFixed(9)
                        ) || "",
                    "ต้นทุนวัตถุดิบมาตรฐานต่อ 1 หน่วย":
                        this.numberWithCommas(
                            parseFloat(item.unit_cost_raw_mate).toFixed(9)
                        ) || "",
                    วันที่เริ่มใช้: item.start_date || "",
                    วันที่สิ้นสุด: item.end_date || ""
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
            XLSX.utils.book_append_sheet(wb, ws, "ต้นทุนวัตถุดิบมาตรฐาน");

            /* generate an XLSX file */
            XLSX.writeFile(wb, "ต้นทุนวัตถุดิบมาตรฐาน.xlsx");
        },
        convertStatus(value) {
            switch (value) {
                case "Active":
                    return "อนุมัติ";
                    break;
                case "Inactive":
                    return "ไม่อนุมัติ";
                    break;
            }
        },
        async getVersion() {
            if (this.is_create) {
                axios
                    .get("/ct/ajax/std_raw_material_cost/get_version", {
                        params: {
                            period_year: this.form.period_year
                        }
                    })
                    .then(res => {
                        this.form.version = res.data;
                    })
                    .catch(err => {})
                    .then(() => {});
                //     }
            }
        },
        async getPlanVersion() {
            if (this.is_create) {
                //     const { period_year, cost_code } = this.form;
                //     if (period_year && cost_code) {
                // await axios
                //     .get(
                //         `/ct/ajax/std_raw_material_cost/version?period_year=${period_year}&cost_code=${cost_code}`
                //     )
                axios
                    .get("/ct/ajax/std_raw_material_cost/get_plan_version", {
                        params: {
                            period_year: this.form.period_year
                        }
                    })
                    .then(res => {
                        this.form.plan_version = res.data;
                    })
                    .catch(err => {})
                    .then(() => {});
                //     }
            }
        },
        selectVersion() {
            this.getCostCenters();
        },
        DateFormat: function(row, column) {
            var date = row[column.property];
            if (date == undefined) {
                return "";
            }
            return moment(date).format("DD-MM-YYYY");
        }
    }
};
</script>
<style lang="scss">
/* el-card__body css cannot scoped !!!!!*/
.box-card {
    .el-card__body {
        padding: 0 !important;
    }
}
</style>
<style lang="scss" scoped>
.el-card__body {
    padding: 0 !important;
}
.card_header {
    font-weight: bold;
    font-size: 18px;
}

.card_body {
    padding: 20px;
    &:not(:last-child) {
        border-bottom: 1px solid #ebeef4;
    }
}
.font-bold {
    font-weight: bold;
    // font-size: 1.1rem;
}

.text {
    font-size: 12px;
}

.item {
    margin-bottom: 18px;
}

.clearfix:before,
.clearfix:after {
    display: table;
    content: "";
}
.clearfix:after {
    clear: both;
}

.box-card {
    width: 100%;
    margin: 20px 0;
}
.w-100 {
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
.mx-datepicker {
    width: 100%;
}
.input-disable {
    background-color: #f5f7fa !important;
    border-color: #e4e7ed !important;
    color: #c0c4cc !important;
    cursor: not-allowed !important;
}

.input-disable > .mx-input-wrapper > input {
    background-color: #f5f7fa !important;
    border-color: #e4e7ed !important;
    color: #c0c4cc !important;
    cursor: not-allowed !important;
}
</style>
