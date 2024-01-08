<template>
    <div>
        <div v-if="!add_product_status && !add_lot_status">
            <div class="list-product-groups" v-if="!showCopy">
                <div class="col-lg-12">
                    <el-select
                        filterable
                        v-model="search.fiscal_year"
                        placeholder="ปีบัญชีงบประมาณ"
                    >
                        <el-option
                            v-for="(item, index) in ddYears"
                            :key="index"
                            :label="item.label_year"
                            :value="item.fiscal_year"
                        >
                        </el-option>
                    </el-select>

                    <el-select
                        filterable
                        v-model="search.cost_center_code"
                        placeholder="ศูนย์ต้นทุน"
                    >
                        <el-option
                            v-for="(item, index) in ddCodes"
                            :key="index"
                            :label="item.name"
                            :value="item.code"
                        >
                        </el-option>
                    </el-select>

                    <el-button
                        class="btn-success ml-2"
                        type="success"
                        @click="searchData()"
                    >
                        ค้นหา
                    </el-button>

                    <el-button
                        class="btn-info"
                        type="info"
                        @click="btnCopyOnClick()"
                    >
                        <i class="fa fa-copy"></i>
                        คัดลอกข้อมูล
                    </el-button>
                </div>

                <div class="col-lg-12 mt-2">
                    <el-table border :data="tableData" style="width: 100%">
                        <el-table-column
                            prop="code"
                            label="กลุ่มผลิตภัณฑ์"
                            align="center"
                            width="110"
                        >
                        </el-table-column>
                        <el-table-column
                            prop="name"
                            label="รายละเอียด"
                            align="center"
                        >
                        </el-table-column>

                        <el-table-column label="ผลิตภัณฑ์" align="center">
                            <template slot-scope="scope">
                                <div class="flex flex-wrap">
                                    <div class="flex-wrap">
                                        <div class="show_list">
                                            <div
                                                class="show_list-item"
                                                v-for="(item,
                                                index) in convertValuePgDetails(
                                                    scope.row.value_pg_details
                                                )"
                                                :key="index"
                                                @click="
                                                    confirmDelete(
                                                        index,
                                                        scope.row
                                                            .value_pg_details
                                                    )
                                                "
                                            >
                                                <div>
                                                    {{ item.item_desc }}
                                                </div>
                                                <span
                                                    class="show_list-item__close"
                                                    >X</span
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </el-table-column>
                        <el-table-column label="LOT" align="center">
                            <template slot-scope="scope">
                                <div class="flex flex-wrap">
                                    <div class="flex-wrap">
                                        <div class="show_list">
                                            <div
                                                class="show_list-item"
                                                v-for="(item,
                                                index) in convertValuePgLot(
                                                    scope.row.value_pg_lots
                                                )"
                                                :key="index"
                                                @click="
                                                    confirmDelete(
                                                        index,
                                                        scope.row.value_pg_lots
                                                    )
                                                "
                                            >
                                                <div>
                                                    {{ `${item.lookup_code}` }}
                                                </div>
                                                <span
                                                    class="show_list-item__close"
                                                    >X</span
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </el-table-column>
                        <el-table-column label="ACTION" align="center">
                            <template slot-scope="scope">
                                <el-button
                                    class="btn btn-info m-px__5"
                                    type="success"
                                    @click="
                                        addProductOpen(
                                            scope.row.value_pg_details,
                                            scope.$index
                                        )
                                    "
                                >
                                    เพิ่มผลิตภัณฑ์
                                </el-button>
                                <el-button
                                    class="btn btn-info m-px__5"
                                    type="success"
                                    @click="
                                        addLotOpen(
                                            scope.row.value_pg_lots,
                                            scope.$index
                                        )
                                    "
                                >
                                    เพิ่ม Lot
                                </el-button>
                            </template>
                        </el-table-column>
                    </el-table>
                </div>

                <!-- <div class="col-12 text-right mt-4">
                    <el-button
                        class="btn-success"
                        type="success"
                        @click="submit()"
                        >บันทึก
                    </el-button>
                </div> -->
            </div>

            <div class="copy" v-if="showCopy">
                <div class="col-lg-12">
                    <div class="card mt-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group row">
                                        <label class="col-md-2 col-form-label">
                                            ศูนย์ต้นทุน
                                        </label>
                                        <div class="col-md-10">
                                            <el-select
                                                filterable
                                                v-model="
                                                    formCopy.cost_center_code
                                                "
                                                placeholder="ศูนย์ต้นทุน"
                                                style="width: 100%"
                                                @change="costCenterOnChange"
                                            >
                                                <el-option
                                                    v-for="(item,
                                                    index) in ddCodes"
                                                    :key="index"
                                                    :label="item.name"
                                                    :value="item.code"
                                                >
                                                    <span>
                                                        {{
                                                            `${item.code} - ${item.name}`
                                                        }}
                                                    </span>
                                                </el-option>
                                            </el-select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label">
                                            จากปีบัญชีงบประมาณ
                                        </label>
                                        <div class="col-md-8">
                                            <el-select
                                                filterable
                                                v-model="
                                                    formCopy.fiscal_year_from
                                                "
                                                placeholder="จากปีบัญชีงบประมาณ"
                                                style="width: 100%"
                                                @change="
                                                    fiscalYearFormOnChange(
                                                        formCopy.fiscal_year_from,
                                                        'start_year_product_group'
                                                    )
                                                "
                                            >
                                                <el-option
                                                    v-for="(item,
                                                    index) in ddYearInFromCopy"
                                                    :key="index"
                                                    :label="item.label_year"
                                                    :value="item.fiscal_year"
                                                >
                                                </el-option>
                                            </el-select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label">
                                            กลุ่มผลิตภัณฑ์
                                        </label>
                                        <div class="col-md-8">
                                            <el-select
                                                style="width: 100%"
                                                filterable
                                                v-model="
                                                    formCopy.from_product_group_id
                                                "
                                                placeholder="กลุ่มผลิตภัณฑ์"
                                            >
                                                <el-option
                                                    v-for="item in option.start_year_product_group"
                                                    :key="item.product_group_id"
                                                    :label="item.name"
                                                    :value="
                                                        item.product_group_id
                                                    "
                                                >
                                                    <span>
                                                        {{
                                                            `${item.code} - ${item.name}`
                                                        }}
                                                    </span>
                                                </el-option>
                                            </el-select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label">
                                            ไปปีบัญชีงบประมาณ
                                        </label>
                                        <div class="col-md-8">
                                            <el-select
                                                filterable
                                                v-model="
                                                    formCopy.fiscal_year_to
                                                "
                                                placeholder="ไปปีบัญชีงบประมาณ"
                                                style="width: 100%"
                                                @change="
                                                    fiscalYearFormOnChange(
                                                        formCopy.fiscal_year_to,
                                                        'end_year_product_group'
                                                    )
                                                "
                                            >
                                                <el-option
                                                    v-for="(item,
                                                    index) in ddYearInFromCopy"
                                                    :key="index"
                                                    :label="item.label_year"
                                                    :value="item.fiscal_year"
                                                >
                                                </el-option>
                                            </el-select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-group row">
                                        <label class="col-md-4 col-form-label">
                                            กลุ่มผลิตภัณฑ์
                                        </label>
                                        <div class="col-md-8">
                                            <el-select
                                                style="width: 100%"
                                                filterable
                                                v-model="
                                                    formCopy.to_product_group_id
                                                "
                                                placeholder="กลุ่มผลิตภัณฑ์"
                                            >
                                                <el-option
                                                    v-for="item in option.end_year_product_group"
                                                    :key="item.product_group_id"
                                                    :label="item.name"
                                                    :value="
                                                        item.product_group_id
                                                    "
                                                >
                                                    <span>
                                                        {{
                                                            `${item.code} - ${item.name}`
                                                        }}
                                                    </span>
                                                </el-option>
                                            </el-select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-right mt-4">
                        <el-button
                            class="btn-success"
                            type="success"
                            @click="submitCopy()"
                            >บันทึก
                        </el-button>

                        <el-button
                            class="btn-danger"
                            type="danger"
                            @click="cancalCopyOnClick()"
                        >
                            ยกเลิก
                        </el-button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mt-2" v-else-if="add_product_status">
            <div class="col-md-12 mb-2">
                <label>รายการ</label>
            </div>
            <div class="col-md-4 mb-2">
                <el-input
                    type="text"
                    placeholder="ค้นหาผลิตภัณฑ์"
                    v-model="search_dd"
                ></el-input>
            </div>
            <div class="row">
                <div class="col-md-9 mb-2">
                    <el-table
                        ref="multipleTable"
                        :data="
                            ddPtpmItems.filter(
                                data =>
                                    !search_dd ||
                                    data.item_desc
                                        .toLowerCase()
                                        .includes(search_dd.toLowerCase()) ||
                                    data.item_number
                                        .toLowerCase()
                                        .includes(search_dd.toLowerCase())
                            )
                        "
                        :row-class-name="tableRowClassName"
                        max-height="500"
                        style="width: 100%"
                    >
                        <el-table-column width="80">
                            <template slot-scope="scope">
                                <el-button
                                    class="btn-success"
                                    type="success"
                                    style="width: 100%"
                                    @click.native.prevent="addToList(scope.row)"
                                >
                                    +
                                </el-button>
                            </template>
                        </el-table-column>
                        <el-table-column label="ผลิตภัณฑ์" prop="item_number">
                        </el-table-column>
                        <el-table-column label="รายละเอียด" prop="item_desc">
                        </el-table-column>
                    </el-table>
                </div>
                <div class="col-md-3">
                    <div class="flex flex-wrap side_list" style>
                        <div class="flex-wrap">
                            <label class="title">รายการ</label>
                            <div class="show_list">
                                <div
                                    class="show_list-item"
                                    v-for="(item, index) in add_product_list"
                                    :key="index"
                                    @click="deleteRow(index, add_product_list)"
                                >
                                    <div>
                                        {{ item.item_desc }}
                                    </div>
                                    <span class="show_list-item__close">X</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group row mt-4">
                <div class="col-md-2">
                    <el-button
                        class="btn-success"
                        type="success"
                        style="width: 100%"
                        @click.native.prevent="addProduct()"
                    >
                        ตกลง
                    </el-button>
                </div>
                <div class="col-md-2">
                    <el-button
                        class="btn-cancel"
                        type="cancel"
                        style="width: 100%"
                        @click.native.prevent="cancelAddProduct()"
                    >
                        ยกเลิก
                    </el-button>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mt-2" v-else-if="add_lot_status">
            <div class="col-md-12 mb-2">
                <label>รายการ</label>
            </div>
            <div class="col-md-4 mb-2">
                <el-input
                    type="text"
                    placeholder="ค้นหาผลิตภัณฑ์"
                    v-model="search_dd"
                ></el-input>
            </div>
            <div class="row">
                <div class="col-md-9 mb-2">
                    <el-table
                        ref="multipleTable"
                        :data="
                            fndLookupValuesVl.filter(
                                data =>
                                    !search_dd ||
                                    data.lookup_type
                                        .toLowerCase()
                                        .includes(search_dd.toLowerCase()) ||
                                    data.lookup_code
                                        .toLowerCase()
                                        .includes(search_dd.toLowerCase()) ||
                                    data.meaning
                                        .toLowerCase()
                                        .includes(search_dd.toLowerCase()) ||
                                    data.description
                                        .toLowerCase()
                                        .includes(search_dd.toLowerCase())
                            )
                        "
                        :row-class-name="tableRowClassName"
                        max-height="500"
                        style="width: 100%"
                    >
                        <el-table-column width="80">
                            <template slot-scope="scope">
                                <el-button
                                    class="btn-success"
                                    type="success"
                                    style="width: 100%"
                                    @click.native.prevent="
                                        addLotList(scope.row)
                                    "
                                >
                                    +
                                </el-button>
                            </template>
                        </el-table-column>
                        <el-table-column label="รหัส" prop="lookup_code">
                        </el-table-column>
                        <el-table-column label="ประเภท" prop="lookup_type">
                        </el-table-column>
                        <el-table-column label="ปี" prop="meaning">
                        </el-table-column>
                        <el-table-column label="ปีไทย" prop="description">
                        </el-table-column>
                    </el-table>
                </div>
                <div class="col-md-3">
                    <div class="flex flex-wrap side_list" style>
                        <div class="flex-wrap">
                            <label class="title">รายการ</label>
                            <div class="show_list">
                                <div
                                    class="show_list-item"
                                    v-for="(item, index) in add_lot_list"
                                    :key="index"
                                    @click="deleteRow(index, add_lot_list)"
                                >
                                    <div>
                                        {{
                                            ` ${item.lookup_code} - ${item.lookup_type}`
                                        }}
                                    </div>
                                    <span class="show_list-item__close">X</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row mt-4">
                <div class="col-md-2">
                    <el-button
                        class="btn-success"
                        type="success"
                        style="width: 100%"
                        @click.native.prevent="addLot()"
                    >
                        ตกลง
                    </el-button>
                </div>
                <div class="col-md-2">
                    <el-button
                        class="btn-cancel"
                        type="cancel"
                        style="width: 100%"
                        @click.native.prevent="cancelAddLot()"
                    >
                        ยกเลิก
                    </el-button>
                </div>
            </div>
        </div>
    </div>
</template>
<style lang="scss" scoped>
.el-table .warning-row {
    background-color: oldlace !important;
}
.side_list {
    height: 500px;
    border-radius: 5px;
    padding: 20px;
    border: 2px solid #eee;
    .title {
        font-size: 14px;
        font-weight: bold;
        color: #909399;
    }
    .show_list {
        max-height: 400px;
        overflow: scroll;
        &-item {
            width: 100%;
            justify-content: space-between;
        }
    }
}
.m-px__5 {
    margin: 5px;
}
.flex {
    display: flex;
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
.show_list {
    display: flex;
    flex-wrap: wrap;
    &-item {
        cursor: pointer;
        display: flex;
        margin: 5px;
        background-color: #f4f4f5;
        padding: 3px 10px;
        color: #909399;
        border-color: #e9e9eb;
        border-radius: 3px;
        text-align: left;
        align-items: center;
        &:hover {
            background-color: #ededf0;
        }
        &__close {
            margin-left: 10px;
        }
    }
}
</style>
<script>
export default {
    data() {
        return {
            add_product_index: "",
            add_product_list: [],
            add_product_status: false,

            add_lot_status: false,
            add_lot_index: "",
            add_lot_list: [],

            search_dd: "",
            multipleSelection: [],
            showCopy: false,
            ddCostCenters: [],
            ddYears: [],
            ddCodes: [],
            ddPtpmItems: [],
            fndLookupValuesVl: [],

            ddYearInFromCopy: [],
            ddCodeInFormCopy: [],
            ddProductGroups: [],
            ddProductGroupsCostCenterId: [],
            option: {
                start_year_product_group: [],
                end_year_product_group: []
            },
            search: {
                fiscal_year: "",
                cost_center_code: ""
            },
            formCopy: {
                cost_center_code: "",
                fiscal_year_from: "",
                fiscal_year_to: "",
                from_product_group_id: "",
                to_product_group_id: ""
            },
            tableData: []
        };
    },
    mounted() {
        this.getMasterData();
    },
    methods: {
        getMasterData() {
            axios.get("/ct/ajax/cost_center/years").then(res => {
                this.ddYears = res.data;
            });

            axios.get("/ct/ajax/cost_center/codes").then(res => {
                this.ddCodes = res.data;
            });

            axios.get("/ct/ajax/cost_center/ptpm_items").then(res => {
                this.ddPtpmItems = res.data;
                console.log('ptpm_items:', this.ptpm_items)
            });

            axios.get("/ct/ajax/product_group_detail/lot").then(res => {
                this.fndLookupValuesVl = res.data;
            });
        },
        searchData() {
            axios
                .get(
                    `/ct/ajax/cost_center/find?code=${this.search.cost_center_code}&year=${this.search.fiscal_year}`
                )
                .then(res => {
                    let productGroups = res.data.product_groups;

                    if (productGroups) {
                        productGroups.forEach(product_group => {
                            product_group.value_pg_details = [];
                            product_group.value_pg_lots = [];

                            if (
                                product_group.product_group_details &&
                                product_group.product_group_details.length > 0
                            ) {
                                product_group.product_group_details.forEach(
                                    product_group_detail => {
                                        if (product_group_detail.code)
                                            product_group.value_pg_details.push(
                                                product_group_detail.code
                                            );
                                    }
                                );
                            }

                            if (
                                product_group.product_group_lots &&
                                product_group.product_group_lots.length > 0
                            ) {
                                product_group.product_group_lots.forEach(
                                    product_group_lot => {
                                        if (product_group_lot.lot)
                                            product_group.value_pg_lots.push(
                                                product_group_lot.lot
                                            );
                                    }
                                );
                            }
                        });

                        this.tableData = productGroups;
                    }
                });
        },
        submit() {
            axios
                .post("/ct/ajax/product_group_detail/update", {
                    data: this.tableData
                })
                .then(res => {
                    this.$message({
                        showClose: true,
                        message: "บันทึกสำเร็จ",
                        type: "success"
                    });
                })
                .catch(err => {
                    this.$message({
                        showClose: true,
                        message: `ไม่สามารถบันทึกได้ | ${err.response.data.error}`,
                        type: "error"
                    });
                });
        },
        convertValuePgDetails(item_arr) {
            this.ddPtpmItems;
            const item_convert = item_arr.map(element => {
                return {
                    item_number: element
                };
            });
            const rs = _.intersectionBy(
                this.ddPtpmItems,
                item_convert,
                "item_number"
            );
            return rs;
        },
        convertValuePgLot(item_arr) {
            this.fndLookupValuesVl;
            const item_convert = item_arr.map(element => {
                return {
                    lookup_code: element
                };
            });

            const rs = _.intersectionBy(
                this.fndLookupValuesVl,
                item_convert,
                "lookup_code"
            );
            return rs;
        },
        deleteRow(index, data) {
            data.splice(index, 1);
        },
        confirmDelete(index, data) {
            this.$confirm(
                "เมื่อกดยืนยันข้อมูลนี้จะถูกลบ",
                "ต้องการลบข้อมูลนี้ใช่หรือไม่",
                {
                    confirmButtonText: "ยืนยัน",
                    cancelButtonText: "ยกเลิก"
                }
            )
                .then(() => {
                    data.splice(index, 1);
                    this.submit();
                })
                .catch(() => {});
        },
        handleSelectionChange(val) {
            this.multipleSelection = val;
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
        tableRowClassName({ row, rowIndex }) {
            const check_duplicate = _.filter(this.add_product_list, item => {
                return (
                    item.item_desc == row.item_desc &&
                    item.item_number == row.item_number
                );
            });
            if (check_duplicate.length > 0) {
                return "warning-row";
            }
            return "";
        },
        async addProductOpen(item, index) {
            this.add_product_status = await true;
            this.add_product_index = index;
            const item_convert = await this.convertValuePgDetails(item);
            this.add_product_list = item_convert;
            await this.toggleSelection(item_convert);
        },
        async addLotOpen(item, index) {
            this.add_lot_status = await true;
            this.add_lot_index = index;
            const item_convert = await this.convertValuePgLot(item);
            this.add_lot_list = item_convert;
            await this.toggleSelection(item_convert);
        },
        addToList(row) {
            const check_duplicate = _.filter(this.add_product_list, item => {
                return (
                    item.item_desc == row.item_desc &&
                    item.item_number == row.item_number
                );
            });
            if (check_duplicate.length <= 0) {
                this.add_product_list.push(row);
            }
        },
        addLotList(row) {
            const check_duplicate = _.filter(this.add_lot_list, item => {
                return (
                    item.lookup_code == row.lookup_code &&
                    item.meaning == row.meaning
                );
            });
            if (check_duplicate.length <= 0) {
                this.add_lot_list.push(row);
            }
        },
        async addProduct() {
            let rs = [];
            this.add_product_list.forEach(item => {
                rs.push(item.item_number);
            });
            this.tableData[this.add_product_index]["value_pg_details"] = rs;
            this.cancelAddProduct();
            await this.submit();
        },
        cancelAddProduct() {
            this.multipleSelection = [];
            this.add_product_list = [];
            this.search_dd = "";
            this.add_product_index = "";
            this.add_product_status = false;
        },
        async addLot() {
            let rs = [];
            this.add_lot_list.forEach(item => {
                rs.push(item.lookup_code);
            });
            this.tableData[this.add_lot_index]["value_pg_lots"] = rs;
            await this.cancelAddLot();
            await this.submit();
        },
        cancelAddLot() {
            this.multipleSelection = [];
            this.add_lot_list = [];
            this.search_dd = "";
            this.add_lot_index = "";
            this.add_lot_status = false;
        },
        btnCopyOnClick() {
            this.showCopy = true;
        },
        cancalCopyOnClick() {
            this.showCopy = false;
        },
        submitCopy() {
            axios
                .post("/ct/ajax/product_group/copy", this.formCopy)
                .then(res => {
                    this.$message({
                        showClose: true,
                        message: "บันทึกสำเร็จ",
                        type: "success"
                    });

                    this.showCopy = false;
                })
                .catch(err => {
                    this.$message({
                        showClose: true,
                        message: `ไม่สามารถบันทึกได้ | ${err.response.data.error}`,
                        type: "error"
                    });
                });
        },
        costCenterOnChange() {
            axios
                .get(
                    `/ct/ajax/cost_center/years?cost_center_code=${this.formCopy.cost_center_code}`
                )
                .then(res => {
                    this.ddYearInFromCopy = res.data;
                    this.formCopy.fiscal_year_from = "";
                    this.formCopy.fiscal_year_to = "";
                    this.formCopy.from_product_group_id = "";
                    this.formCopy.to_product_group_id = "";
                });
        },
        async fiscalYearFormOnChange(year, key) {
            if (key == "start_year_product_group") {
                this.formCopy.from_product_group_id = await "";
            } else if (key == "end_year_product_group") {
                this.formCopy.to_product_group_id = await "";
            }
            await axios
                .get(
                    `/ct/ajax/product_group/find?fiscal_year=${year}&cost_center_code=${this.formCopy.cost_center_code}`
                )
                .then(res => {
                    this.option[key] = res.data;
                });
        }
    }
};
</script>
