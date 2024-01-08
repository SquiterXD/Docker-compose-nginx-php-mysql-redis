<template>

    <div>

        <div class="text-left tw-mb-2">
            
            <button type="input" class="btn btn-inline-block btn-sm btn-primary tw-w-40"
                :disabled="workorderProcessItems.length <= 0"
                @click="onSaveProcess"
            > 
                <i class="fa fa-save tw-mr-1"></i> บันทึก 
            </button>

        </div>

        <div class="table-responsive" style="max-height: 400px;">

            <el-table
                :data="workorderProcessItems"
                :default-sort = "{prop: 'complete_date_ts', order: 'descending'}"
                style="width: 100%"
                height="400">

                <el-table-column label="" width="55" >
                    <template #header>
                        <input type="checkbox" name="all_selected" v-model="selectAll" @change="onSelectAll($event)"> 
                    </template>
                    <template #default="scope"> 
                        <input type="checkbox" name="selected" v-model="scope.row.selected" @change="onSelect($event, scope.row)" :disabled="isSelectionDisabled(scope.row)">
                    </template>
                </el-table-column>

                <el-table-column
                    prop="complete_date_thai"
                    label="วันที่บันทึกผลผลิต"
                    sortable
                    align="center"
                    :sort-method="sortCompleteDateThai"
                    width="160">
                </el-table-column>

                <el-table-column
                    prop="batch_no"
                    label="เลขที่คำสั่งผลิต"
                    sortable
                    align="center"
                    width="160">
                </el-table-column>

                <el-table-column
                    prop="batch_status"
                    label="สถานะ Batch"
                    sortable
                    align="center"
                    width="150">
                </el-table-column>

                <el-table-column
                    prop="product_item_number"
                    label="รหัสผลิตภัณฑ์"
                    sortable
                    align="center"
                    width="150">
                </el-table-column>

                <el-table-column
                    prop="item_desc"
                    label="ผลิตภัณฑ์"
                    sortable
                    align="left"
                    width="250">
                </el-table-column>

                <el-table-column
                    prop="complete_qty"
                    label="จำนวนที่ผลิตได้"
                    sortable
                    align="right"
                    width="250"
                    :sort-method="sortCompleteQty"
                    :formatter="numberFormatter">
                </el-table-column>

                <el-table-column
                    prop="remain_quantity"
                    label="รวมจำนวนคงค้างในขั้นตอน"
                    sortable
                    align="right"
                    width="250"
                    :sort-method="sortRemainQuantity"
                    :formatter="numberFormatter">
                </el-table-column>

                <el-table-column
                    prop="uom_code_desc"
                    label="หน่วยนับ"
                    sortable
                    align="center"
                    width="100">
                </el-table-column>

                <el-table-column
                    prop="closed_date_thai"
                    label="วันที่ปิดคำสั่งผลิต"
                    sortable
                    align="center"
                    :sort-method="sortClosedDateThai"
                    width="150">
                </el-table-column>

            </el-table>
            
        </div>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

    </div>
                    
</template>

<script>

import moment from "moment";
import VueNumeric from 'vue-numeric'
import Loading from "vue-loading-overlay";

export default {
    
    props: [
        "paramIdValue",
        "paramHeader", 
        "workorderProcesses", 
        "uomCodes"
    ],

    components: {
        Loading,
        VueNumeric
    },

    watch: {

        paramIdValue: function (data) {
            this.paramId = data;
        },
        paramHeader: function (data) {
            this.paramHeaderData = data;
        },
        workorderProcesses: function (data) {
            this.workorderProcessItems = data ? data.map(item => {
                return {
                    ...item,
                    selected: item.freeze_flag == 'Y' ? true : false,
                    uom_code_desc: this.getUomCodeDescription(this.uomCodes, item.uom_code),
                    complete_date_ts: item.complete_date ? moment(item.complete_date) : null,
                    complete_date_thai: item.complete_date ? moment(item.complete_date).add(543, "year").format("DD/MM/YYYY") : "-",
                    closed_date_thai: item.closed_date ? moment(item.closed_date).add(543, "year").format("DD/MM/YYYY") : "-",
                };
            }) : [];
        },
    },

    data() {

        return {
            selectAll: false,
            paramId: this.paramIdValue,
            paramHeaderData: this.paramHeader,
            workorderProcessItems: this.workorderProcesses.map(item => {
                return {
                    ...item,
                    selected: item.freeze_flag == 'Y' ? true : false,
                    uom_code_desc: this.getUomCodeDescription(this.uomCodes, item.uom_code),
                    complete_date_ts: item.complete_date ? moment(item.complete_date) : null,
                    complete_date_thai: item.complete_date ? moment(item.complete_date).add(543, "year").format("DD/MM/YYYY") : "-",
                    closed_date_thai: item.closed_date ? moment(item.closed_date).add(543, "year").format("DD/MM/YYYY") : "-",
                }
            }),
            isLoading: false,
        }

    },

    mounted() {

        // this.emitWorkorderProcessChanged();

    },

    computed: {

    },
    methods: {

        async onSaveProcess() {
            
            console.log('workorderProcessItems : ', this.workorderProcessItems)

            // show loading
            this.isLoading = true;

            // GENERATE TRANSACTIONS
            const reqBody = {
                param_id: this.paramId,
                param_header: JSON.stringify(this.paramHeader),
                workorder_processes: JSON.stringify(this.workorderProcessItems),
            };

            await axios.post(`/ajax/ct/workorders/processes/store-processes`, reqBody)
            .then(res => {

                const resData = res.data.data;
                if(resData.status == "success") {
                    swal("Success", `บันทึกสำเร็จ`, "success");
                    this.emitWorkorderProcessSaved();
                } else {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถบันทึก | ${resData.message}`, "error");                    
                }

                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถบันทึก | ${error.message}`, "error");
            });

            // hide loading
            this.isLoading = false;

        },

        formatter(row, column) {
            return row.address;
        },

        numberFormatter(row, column, cellValue) {
            const result = cellValue ? Number(cellValue).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "-";
            return result;
        },

        sortCompleteQty(a, b) {
            return a.complete_qty - b.complete_qty;
        },

        sortRemainQuantity(a, b) {
            return a.remain_quantity - b.remain_quantity;
        },

        sortCompleteDateThai(a, b) {
            return moment(a.complete_date) - moment(b.complete_date);
        },

        sortClosedDateThai(a, b) {
            return moment(a.closed_date) - moment(b.closed_date);
        },

        emitWorkorderProcessSaved() {
            this.$emit("onWorkorderProcessSaved", {
                param_id: this.paramId,
                param_header: this.paramHeader,
                workorder_processes: this.workorderProcessItems
            });
        },

        formatNumber(value) {
            let result = value.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return result;
        },

        isNumber: function(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();;
            } else {
                return true;
            }
        },

        getUomCodeDescription(uomCodes, uomCode) {
            const foundUomCode = uomCodes.find(item => item.uom_code == uomCode);
            return foundUomCode ? foundUomCode.unit_of_measure : "";
        },

        onSelect(e, data) {
            const countAll = this.workorderProcessItems.length;
            const countSelected = this.workorderProcessItems.filter(item => item.selected == true).length;
            this.selectAll = countAll == countSelected;
        },

        isSelectionDisabled(data) {
            let disabled = false;
            // if(data.batch_status == "ส่งเข้า GL แล้ว" && data.selected == true ) {
            if((data.ct_status == 3 || data.ct_status == 4) && data.selected == true ) {
                disabled = true;
            }
            return disabled;
        },

        onSelectAll(e) {

            this.$nextTick(() => {

                const selectAllValue = this.selectAll;

                this.workorderProcessItems = this.workorderProcessItems.map(item => {
                    let selectedValue = selectAllValue;
                    // if(item.batch_status == "ส่งเข้า GL แล้ว") {
                    if(item.ct_status == 3 || item.ct_status == 4) {
                        if(selectAllValue == false && item.selected == true) {
                            selectedValue = true;
                        }
                    }
                    return {
                        ...item,
                        selected: selectedValue
                    }
                });
                
            });

        },

    }

}

</script>