<template>

    <div class="ibox">

        <div class="ibox-content" style="min-height: 600px;">

            <div class="tw-mb-4">

                <div class="text-right tw-mb-2">
                    <button class="btn btn-inline-block btn-sm btn-info tw-w-40"
                        @click="onGenerateMachineRequests"
                        :disabled="!requestDate || !objectiveRequest || !inventoryItemId || machineRequests.length > 0"
                    > 
                        <i class="fa fa-calculator tw-mr-1"></i> เรียกข้อมูลจากแผน 
                    </button>

                    <button class="btn btn-inline-block btn-sm btn-white tw-w-40"
                        @click="$modal.show('modal-search')">
                        <i class="fa fa-search tw-mr-1"></i> ค้นหา 
                    </button>

                    <!-- <button class="btn btn-inline-block btn-sm hover:tw-text-white tw-text-white tw-bg-purple-500 tw-border-purple-500 tw-w-40"
                        @click="onAddMachineRequest"
                        :disabled="!requestDate || machineRequests.length == 0"
                    > 
                        <i class="fa fa-plus tw-mr-1"></i> เพิ่มรายการ 
                    </button> -->
                    
                </div>
                
                <div class="text-right">
                    
                    <button class="btn btn-inline-block btn-sm btn-primary tw-w-40"
                        @click="onSaveMachineRequests"
                        :disabled="!requestDate || machineRequests.length == 0"
                    > 
                        <i class="fa fa-save tw-mr-1"></i> บันทึก 
                    </button>

                    <button class="btn btn-inline-block btn-sm btn-warning tw-w-40"
                        @click="onSubmitMachineRequests"
                        :disabled="machineRequests.length == 0 || isNewlyCreate"
                    > 
                        <i class="fa fa-check-square tw-mr-1"></i> ยืนยันส่งข้อมูลไป WMS 
                    </button>

                    <button class="btn btn-inline-block btn-sm btn-primary tw-w-40"
                        @click="onExportPdf"
                        :disabled="machineRequests.length == 0"
                    > 
                        <i class="fa fa-print tw-mr-1"></i> พิมพ์รายงาน 
                    </button>
                    
                </div>

            </div>

            <hr>

            <div>

                <div class="row">

                    <div class="col-md-6">

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> วันที่ </label>

                            <div class="col-md-8">

                                <datepicker-th
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    name="request_date"
                                    id="input_request_date"
                                    placeholder="โปรดเลือกวันที่"
                                    format="DD/MM/YYYY"
                                    :value="requestDate"
                                    @dateWasSelected="requestDateWasSelected"
                                />

                            </div>

                        </div>

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> วัตถุประสงค์ในการเบิก </label>

                            <div class="col-md-8">
                                
                                <pm-el-select name="objective_request" id="objective_request" 
                                    :select-options="objectiveRequests"
                                    option-key="objective_request_value"
                                    option-value="objective_request_value" 
                                    option-label="objective_request_label"
                                    :value="objectiveRequest"
                                    :filterable="true"
                                    @onSelected="onObjectiveRequestWasSelected"
                                />

                            </div>

                        </div>

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> เลขที่ใบเบิก </label>

                            <div class="col-md-8">
                                <p v-if="machineRequests.length == 0" class="col-form-label"> - </p>
                                <p v-if="machineRequests.length > 0" class="col-form-label"> {{ machineRequests[0].request_number }} </p>
                            </div>

                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> สินค้าที่จะผลิต </label>

                            <div class="col-md-8">
                                
                                <pm-el-select name="inventory_item_id" id="inventory_item_id" 
                                    :select-options="invItems"
                                    option-key="inventory_item_id"
                                    option-value="inventory_item_id" 
                                    option-label="inv_item_fulldesc"
                                    :value="inventoryItemId"
                                    :filterable="true"
                                    @onSelected="onInventoryItemIdWasSelected"
                                />

                            </div>

                        </div>

                        <div class="row form-group">

                            <label class="col-md-4 col-form-label tw-font-bold"> เครื่องจักร </label>

                            <div class="col-md-8">
                                <p class="col-form-label"> {{ machineName ? machineName : "-" }} </p>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <hr>

            <div v-if="machineRequests.length > 0">

                <div class="row">

                    <div class="col-12">

                        <table-machine-requests 
                            :machine-requests="machineRequests" 
                            :uom-codes="uomCodes"
                            :item-options="itemOptions"
                            @onMachineRequestChanged="onMachineRequestChanged"
                        />

                    </div>

                </div>

            </div>
            
        </div>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

        <!-- MODAL SEARCH PLAN -->
        <modal-search 
            modal-name="modal-search" 
            modal-width="720" 
            modal-height="auto"
            :plan-date-value="requestDate"
            @onSelectedSearchMachineRequest="onSelectedSearchMachineRequest"
        />

    </div>

</template>

<script>

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

import TableMachineRequests from "./TableMachineRequests";
import ModalSearch from "./ModalSearch";
import DatepickerTh from "../../DatepickerTh";

export default {
    
    components: { Loading, TableMachineRequests, ModalSearch, DatepickerTh },

    props: [ "requestNumberValue", "requestDateValue", "objectiveRequestValue", "inventoryItemIdValue", "machineNameValue", "itemOptions", "uomCodes", "objectiveRequests" ],

    mounted() {

        if(this.requestNumberValue) {
            this.getMachineRequests(this.requestNumberValue);
        }

        if(this.requestDateValue) {
            const requestDate =  moment(this.requestDateValue, "DD/MM/YYYY").toDate();
            this.getInvItems(requestDate);
            if(this.inventoryItemIdValue) {
                this.getItemMachineName(requestDate, this.inventoryItemIdValue);
            }
        }

    },

    data() {
        return {
            requestNumber: this.requestNumberValue,
            requestDate: this.requestDateValue ? moment(this.requestDateValue, "DD/MM/YYYY").toDate() : null,
            requestDateFormatted: this.requestDateValue,
            objectiveRequest: this.objectiveRequestValue,
            inventoryItemId: this.inventoryItemIdValue,
            machineName: this.machineNameValue,
            invItems: [],
            machineRequests: [],
            isNewlyCreate: false,
            isLoading: false
        }
    },

    computed: {

    },

    methods: {

        setUrlParams() {

            var queryParams = new URLSearchParams(window.location.search);
            queryParams.set("request_number", this.requestNumber ? this.requestNumber : '');
            queryParams.set("request_date", this.requestDateFormatted ? this.requestDateFormatted : '');
            queryParams.set("objective_request", this.objectiveRequest ? this.objectiveRequest : '');
            queryParams.set("inventory_item_id", this.inventoryItemId ? this.inventoryItemId : '');
            queryParams.set("machine_name", this.machineName ? this.machineName : '');
            window.history.replaceState(null, null, "?"+queryParams.toString());

        },

        async requestDateWasSelected(value) {

            // CLEAR DATA 
            this.inventoryItemId = null;
            this.machineName = null;
            this.invItems = [];
            this.requestNumber = null;
            this.machineRequests = [];
            
            this.requestDate = value;
            this.requestDateFormatted = this.getRequestDateFormatted(this.requestDate);

            await this.getInvItems(this.requestDate);

            this.setUrlParams();

        },

        async onObjectiveRequestWasSelected(value) {

            // CLEAR DATA 
            this.requestNumber = null;
            this.machineRequests = [];
            
            this.objectiveRequest = value;
            this.setUrlParams();

        },

        async onInventoryItemIdWasSelected(value) {

            // CLEAR DATA 
            this.inventoryItemId = null;
            this.machineName = null;
            this.requestNumber = null;
            this.machineRequests = [];
            
            this.inventoryItemId = value;
            await this.getItemMachineName(this.requestDate, this.inventoryItemId)

            this.setUrlParams();

        },

        async onSelectedSearchMachineRequest(data) {
            
            this.requestNumber = data.request_number;
            this.requestDateFormatted = data.request_date;
            this.requestDate =  moment(this.requestDateFormatted, "DD/MM/YYYY").toDate();
            await this.getInvItems(this.requestDate);

            if(this.requestNumber) {
                await this.getMachineRequests(this.requestNumber);
            }

            this.setUrlParams();

        },

        getRequestDateFormatted(requestDate) {
            return moment(requestDate).format("DD/MM/YYYY");
        },

        getPeriodNameLabel(periodNames, periodName) {
            const foundPeriodName = periodNames.find(item => item.period_name_value == periodName);
            return foundPeriodName ? foundPeriodName.period_name_label : "";
        },

        async getInvItems(requestDate) {

            // show loading
            this.isLoading = true;

            // REFRESH DATA
            this.invItems = [];

            const requestDateFormatted = moment(requestDate).format("DD/MM/YYYY");
            
            var params = { 
                request_date: requestDateFormatted,
            };

            await axios.get("/ajax/pm/products/machine-requests/get-items", { params })
            .then(res => {
                const resData = res.data.data;
                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ข้อมูลเบิกวัตถุดิบหข้าหน้าเครื่องจักร ${requestDateFormatted} ไม่ถูกต้อง | ${resData.message}`, "error");
                } else {
                    this.invItems = resData.inv_items ? JSON.parse(resData.inv_items) : [];
                }
                return resData;
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ข้อมูลเบิกวัตถุดิบหข้าหน้าเครื่องจักร ${requestDateFormatted} ไม่ถูกต้อง | ${error.message}`, "error");
                return ;
            });
            
            // hide loading
            this.isLoading = false;

        },

        async getItemMachineName(requestDate, inventoryItemId) {

            // show loading
            this.isLoading = true;

            // REFRESH DATA
            this.machineName = "";

            const requestDateFormatted = moment(requestDate).format("DD/MM/YYYY");
            
            var params = { 
                request_date: requestDateFormatted,
                inventory_item_id: inventoryItemId
            };

            await axios.get("/ajax/pm/products/machine-requests/get-item-machine-name", { params })
            .then(res => {
                const resData = res.data.data;
                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ข้อมูลเบิกวัตถุดิบหข้าหน้าเครื่องจักร ${requestDateFormatted} ไม่ถูกต้อง | ${resData.message}`, "error");
                } else {
                    this.machineName = resData.machine_name;
                }
                return resData;
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ข้อมูลเบิกวัตถุดิบหข้าหน้าเครื่องจักร ${requestDateFormatted} ไม่ถูกต้อง | ${error.message}`, "error");
                return ;
            });
            
            // hide loading
            this.isLoading = false;

        },

        async getMachineRequests(requestNumber) {

            // show loading
            this.isLoading = true;

            // REFRESH DATA
            this.machineRequests = [];
            
            var params = { 
                request_number: requestNumber,
            };

            await axios.get("/ajax/pm/products/machine-requests/get-requests", { params })
            .then(res => {
                const resData = res.data.data;
                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ข้อมูลเบิกวัตถุดิบหข้าหน้าเครื่องจักร ${requestNumber} ไม่ถูกต้อง | ${resData.message}`, "error");
                } else {
                    this.machineRequests = resData.machine_requests ? JSON.parse(resData.machine_requests) : [];
                    if(this.machineRequests.length > 0) {
                        this.machineName = this.machineRequests[0].machine_name;
                        this.inventoryItemId = this.machineRequests[0].inventory_item_id;
                        if(this.machineRequests[0].objective_request) {
                            this.objectiveRequest = this.machineRequests[0].objective_request;
                        }
                    }
                }
                return resData;
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ข้อมูลเบิกวัตถุดิบหข้าหน้าเครื่องจักร ${requestNumber} ไม่ถูกต้อง | ${error.message}`, "error");
                return ;
            });
            
            // hide loading
            this.isLoading = false;

        },

        async onGenerateMachineRequests() {

            // show loading
            this.isLoading = true;

            var reqBody = { 
                request_date: this.requestDateFormatted,
                objective_request: this.objectiveRequest,
                machine_name: this.machineName,
                inventory_item_id: this.inventoryItemId,
            };
            await axios.post(`/ajax/pm/products/machine-requests/generate-requests`, reqBody)
            .then(res => {

                const resData = res.data.data;

                if(resData.status == "success") {

                    this.machineRequests = resData.machine_requests ? JSON.parse(resData.machine_requests) : [];
                    if(this.machineRequests.length <= 0) {
                        swal("ไม่พบข้อมูล", `ไม่พบข้อมูลจากแผน วันที่ : ${this.requestDateFormatted}`, "error");                    
                    }
                    this.isNewlyCreate = resData.is_newly_create;

                } else {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถเรียกข้อมูลจากแผน วันที่ : ${this.requestDateFormatted} | ${resData.message}`, "error");                    
                }

                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถเรียกข้อมูลจากแผน วันที่ : ${this.requestDateFormatted} | ${error.message}`, "error");
            });

            // hide loading
            this.isLoading = false;

        },

        onMachineRequestChanged(data) {
            this.machineRequests = data.machineRequestItems;
        },

        validateBeforeSave(machineRequests) {

            const result = {
                valid: true,
                message: "",
            };

            // IF NEW LINE ISN'T COMPLETED
            const incompletedLines = machineRequests.filter(item => {
                return item.is_new_line && (
                    !item.inventory_item_id ||
                    !item.request_qty
                ) && item.marked_as_deleted == false;
            });

            if(incompletedLines.length > 0) {
                result.valid = false;
                result.message = `กรอกข้อมูลเบิกวัตถุดิบหข้าหน้าเครื่องจักรไม่ครบถ้วน กรุณาตรวจสอบ`
            }

            return result;

        },

        onAddMachineRequest() {

            const cloneLastMachineRequestItem = {
                ...(this.machineRequests.find((item, index) => {
                    return index == (this.machineRequests.length - 1);
                }))
            }
            Object.keys(cloneLastMachineRequestItem).forEach(k => {
                if(k != "request_number" || 
                k != "creation_date" ||
                k != "request_date" ||
                k != "organization_id") {
                    cloneLastMachineRequestItem[k] = null;
                }
            })

            this.machineRequests = [
                ...this.machineRequests,
                {
                    ...cloneLastMachineRequestItem,
                    request_qty: 0,
                    is_new_line: true,
                    marked_as_deleted: false,
                }
            ];

        },

        async onSaveMachineRequests() {

            const reqBody = {
                request_date: this.requestDateFormatted,
                machine_requests: JSON.stringify(this.machineRequests)
            };

            // show loading
            this.isLoading = true;

            const resValidate = this.validateBeforeSave(this.machineRequests);

            if(resValidate.valid) {

                // call store sample result
                await axios.post(`/ajax/pm/products/machine-requests/store-requests`, reqBody)
                .then(res => {

                    const resData = res.data.data;
                    const resMsg = resData.message;

                    if(resData.status == "success") {
                        this.isNewlyCreate = false;
                        swal("Success", `บันทึกข้อมูลเบิกวัตถุดิบหข้าหน้าเครื่องจักร : ${this.requestDateFormatted} )`, "success");
                    }

                    if(resData.status == "error") {
                        swal("เกิดข้อผิดพลาด", `บันทึกข้อมูลเบิกวัตถุดิบหข้าหน้าเครื่องจักร : วันที่ : ${this.requestDateFormatted} | ${resMsg}`, "error");
                    }
                    
                    return resData;

                }).catch((error) => {
                    console.log(error);
                    swal("เกิดข้อผิดพลาด", `บันทึกข้อมูลเบิกวัตถุดิบหข้าหน้าเครื่องจักร : วันที่ : ${this.requestDateFormatted} | ${error.message}`, "error");
                });

            } else {
                swal("เกิดข้อผิดพลาด", `บันทึกข้อมูลเบิกวัตถุดิบหข้าหน้าเครื่องจักร : วันที่ : ${this.requestDateFormatted} | ${resValidate.message}`, "error");
            }

            // hide loading
            this.isLoading = false;

        },

        async onSubmitMachineRequests() {

            const reqBody = {
                request_date: this.requestDateFormatted,
                machine_requests: JSON.stringify(this.machineRequests)
            };

            // show loading
            this.isLoading = true;

            // CALL SAVE BEFORE SUBMIT APPROVAL
            await axios.post(`/ajax/pm/products/machine-requests/store-requests`, reqBody)
            .then(res => {
                const resData = res.data.data;
                if(resData.status == "error") {
                    console.log(resData.message);
                }
                return resData;
            }).catch((error) => {
                console.log(error);
            });

            // CALL SUBMIT APPROVAL
            await axios.post(`/ajax/pm/products/machine-requests/submit-requests`, reqBody)
            .then(res => {

                const resData = res.data.data;
                const resMsg = resData.message;

                if(resData.status == "success") {
                    swal("Success", `ยืนยันส่งข้อมูลไป WMS (วันที่ : ${this.requestDateFormatted})`, "success");
                }

                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ยืนยันส่งข้อมูลไป WMS (วันที่ : ${this.requestDateFormatted}) | ${resMsg}`, "error");
                }
                
                return resData;

            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ยืนยันส่งข้อมูลไป WMS (วันที่ : ${this.requestDateFormatted}) | ${error.message}`, "error");
            });

            // hide loading
            this.isLoading = false;

        },

        async onExportPdf() {

            const reqBody = {
                request_date: this.requestDateFormatted,
                machine_requests: JSON.stringify(this.machineRequests)
            };

            // show loading
            this.isLoading = true;

            // CALL SAVE BEFORE SUBMIT APPROVAL
            await axios.post(`/ajax/pm/products/machine-requests/export-pdf`, reqBody)
            .then(res => {
                const resData = res.data.data;
                if(resData.status == "error") {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถพิมพ์รายงาน (วันที่ : ${this.requestDateFormatted}) | ${resMsg}`, "error");
                } else {
                    window.open(`/pm/files/download/pm/products/machine-requests/pdf/${resData.file_name}`, '_blank');
                }
                return resData;
            }).catch((error) => {
                console.log(error);
            });

            // hide loading
            this.isLoading = false;

        },

    }

}

</script>