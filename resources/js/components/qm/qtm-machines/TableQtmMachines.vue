<template>

    <div class="table-responsive" style="max-height: 800px;">

        <table class="table table-bordered table-sticky mb-0" style="min-width: 2300px;">

            <thead>
                <tr>
                    <th rowspan="2" class="freeze-col" style="min-width: 270px;"> 
                        <div class="freeze-col-content">
                            <div class="text-center tw-text-xs tw-inline-block tw-align-top tw-py-6" style="min-width: 45px; max-width: 45px;">
                                ลำดับที่
                            </div>
                            <div class="text-center tw-text-xs tw-inline-block tw-align-top tw-py-6" style="min-height: 50px; min-width: 190px; max-width: 190px; border-left: 1px solid #ddd;">
                                เลขที่การตรวจสอบ
                            </div>
                        </div>
                    </th>
                    <th rowspan="2" width="7%" class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                        หมายเลขเครื่อง QTM
                    </th>
                    <th rowspan="2" width="7%" class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                        ประเภทของเครื่อง QTM
                    </th>
                    <th rowspan="2" width="10%" style="min-width: 160px;" class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                        Brand
                    </th>
                    <th rowspan="2" width="7%" class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                        Maker
                    </th>
                    <th rowspan="2" width="10%" class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                        วันที่เก็บตัวอย่าง
                    </th>
                    <th rowspan="2" width="9%" class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                        เวลาที่เก็บตัวอย่าง
                    </th>
                    <th rowspan="2" width="9%" class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                        เวลาที่วัด
                    </th>
                    <th rowspan="2" width="10%" class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                        สถานะการลงผล
                    </th>
                    <th rowspan="2" width="10%" class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                        สถานะผลการทดสอบ
                    </th>
                    <th rowspan="2" width="10%" class="text-center tw-text-xs md:tw-table-cell tw-hidden">
                        สถานะการยืนยันข้อมูล
                    </th>
                    <th rowspan="2" width="18%" class="text-center tw-text-xs md:tw-table-cell tw-hidden" style="min-width: 150px;">
                        สถานะการอนุมัติ
                    </th>
                    <th colspan="3" width="9%" class="tw-text-xs text-center md:tw-table-cell tw-hidden"> 
                        ระดับความรุนแรงของความผิดปกติ (จำนวน)
                    </th>
                    <th colspan="3" width="9%" class="tw-text-xs text-center md:tw-table-cell tw-hidden"> 
                        ระดับความรุนแรงของความผิดปกติ (อาการ)
                    </th>
                    <th rowspan="2" width="12%" class="text-center md:tw-table-cell tw-hidden">
                        ชื่อไฟล์
                    </th>
                    <th rowspan="2" width="8%" style="min-width: 120px;" class="text-center md:tw-table-cell tw-hidden"> 
                        <div v-if="showType == 'result'">
                            สามารถแก้ไขผลการตรวจสอบได้ 
                        </div>
                        <div v-else>
                            <div> ยืนยันการรับทราบความผิดปกติ </div>
                            <div class="tw-text-2xs tw-text-gray-400"> (จากหน่วยงานต้นทาง) </div>
                        </div>
                    </th>
                    <th rowspan="2" width="10%" class="freeze-col-right" style="min-width: 100px;"> 
                        <div class="freeze-col-content">
                            <div class="tw-py-4" v-if="(approvalRole.level_code == '2' || approvalRole.level_code == '3') && sampleItems.length > 0"> 
                                <button class="btn btn-success tw-w-32" 
                                    @click="onApproveAllSampleClicked(approvalRole, $event)">
                                    <i class="fa fa-check-square-o "></i> Approve All
                                </button>
                            </div>
                            <div v-else> &nbsp; </div>
                        </div>
                    </th>
                </tr>
                <tr>
                    <th width="5%" style="top: 3.2rem;" class="tw-text-xs text-center md:tw-table-cell tw-hidden"> Minor </th>
                    <th width="5%" style="top: 3.2rem;" class="tw-text-xs text-center md:tw-table-cell tw-hidden"> Major </th>
                    <th width="5%" style="top: 3.2rem;" class="tw-text-xs text-center md:tw-table-cell tw-hidden"> Critical </th>
                    <th width="5%" style="top: 3.2rem;" class="tw-text-xs text-center md:tw-table-cell tw-hidden"> Minor </th>
                    <th width="5%" style="top: 3.2rem;" class="tw-text-xs text-center md:tw-table-cell tw-hidden"> Major </th>
                    <th width="5%" style="top: 3.2rem;" class="tw-text-xs text-center md:tw-table-cell tw-hidden"> Critical </th>
                </tr>
            </thead>
            <tbody v-if="sampleItems.length > 0">
                <template v-for="(sampleItem, index) in sampleItems">
                    <tr :key="sampleItem.sample_no">
                        <td class="freeze-col" style="min-width: 270px;">
                            <div class="freeze-col-content">
                                <div class="tw-inline-block tw-align-top tw-pr-2 tw-py-2" style="min-width: 45px; max-width: 45px;">
                                    <div class="text-center">
                                        {{ index + 1 }}
                                    </div>    
                                </div>
                                <div class="tw-inline-block tw-align-top tw-pl-4 tw-py-2" style="min-height: 100px; min-width: 190px; max-width: 190px; border-left: 1px solid #ddd;">
                                    {{ sampleItem.sample_no }}
                                </div>
                            </div>
                        </td>
                        <td class="text-center md:tw-table-cell tw-hidden">
                            {{ sampleItem.machine_full_name }}
                        </td>
                        <td class="text-center md:tw-table-cell tw-hidden">
                            {{ sampleItem.equipment_type ? `QTM ${sampleItem.equipment_type}` : "" }}
                        </td>
                        <td class="text-center md:tw-table-cell tw-hidden">
                            {{ sampleItem.brand }}
                        </td>
                        <td class="text-center md:tw-table-cell tw-hidden">
                            {{ sampleItem.maker }}
                        </td>
                        <td class="text-center md:tw-table-cell tw-hidden">
                            {{ sampleItem.date_drawn_show }}
                        </td>
                        <td class="text-center md:tw-table-cell tw-hidden">
                            <div v-if="showType == 'result' && sampleItem.file_name && isAllowEdit(sampleItem, approvalRole)">
                                <qm-timepicker 
                                    :id="`input_time_drawn_formatted_${index}`"
                                    :name="`time_drawn_formatted_${index}`"
                                    :value="sampleItem.time_drawn_formatted" 
                                    :clearable="false"
                                    @close="onSampleTimeDrawnClosed($event, sampleItem)"
                                    @change="onSampleTimeDrawnChanged($event, sampleItem)"
                                />
                            </div>
                            <div v-else>
                                {{ sampleItem.time_drawn_formatted }}
                            </div>
                        </td>
                        <td class="text-center md:tw-table-cell tw-hidden">
                            {{ sampleItem.test_time }}
                        </td>
                        <td class="text-center md:tw-table-cell tw-hidden">
                            <div v-if="sampleItem.sample_operation_status == 'PD'" class="tw-text-gray-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold">
                                <span class="tw-text-xs"> {{ sampleItem.sample_operation_status_desc }} </span>
                            </div>
                            <div v-else-if="sampleItem.sample_operation_status == 'IP'" class="tw-text-gray-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold">
                                <span class="tw-text-xs"> {{ sampleItem.sample_operation_status_desc }} </span>
                            </div>
                            <div v-else-if="sampleItem.sample_operation_status == 'CP'" class="tw-text-green-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold">
                                <span class="tw-text-xs"> {{ sampleItem.sample_operation_status_desc }} </span>
                            </div>
                            <div v-else-if="sampleItem.sample_operation_status == 'RJ'" class="tw-text-yellow-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold">
                                <span class="tw-text-xs"> {{ sampleItem.sample_operation_status_desc }} </span>
                            </div>
                        </td>
                        <td class="text-center md:tw-table-cell tw-hidden">
                            <div v-if="sampleItem.sample_result_status == 'PD'" class="tw-text-gray-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold">
                                <span class="tw-text-xs"> {{ sampleItem.sample_result_status_desc }} </span>
                            </div>
                            <div v-else-if="sampleItem.sample_result_status == 'CF'" class="tw-text-green-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold">
                                <span class="tw-text-xs"> {{ sampleItem.sample_result_status_desc }} </span>
                            </div>
                            <div v-else-if="sampleItem.sample_result_status == 'NC'" class="tw-text-red-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold">
                                <span class="tw-text-xs"> {{ sampleItem.sample_result_status_desc }} </span>
                            </div>
                            <div v-else-if="sampleItem.sample_result_status == 'RJ'" class="tw-text-yellow-600 tw-rounded tw-p-1 tw-leading-3 tw-font-semibold">
                                <span class="tw-text-xs"> {{ sampleItem.sample_result_status_desc }} </span>
                            </div>
                        </td>
                        <td class="text-center md:tw-table-cell tw-hidden">
                            <span v-if="sampleItem.confirm_code == '2'" class="tw-font-semibold tw-text-green-500"> {{ sampleItem.confirm_status ? sampleItem.confirm_status : "" }} </span>
                            <span v-else-if="sampleItem.confirm_code == '3'" class="tw-font-semibold tw-text-red-500"> {{ sampleItem.confirm_status ? sampleItem.confirm_status : "" }} </span>
                            <span v-else class="tw-font-semibold tw-text-gray-400"> {{ sampleItem.confirm_status ? sampleItem.confirm_status : "" }} </span>
                        </td>
                        <td class="text-left md:tw-table-cell tw-hidden">
                            <div class="tw-pb-1" style="border-bottom: 1px solid #eee;">
                                <span class="tw-font-semibold"> O : </span>
                                <span v-if="sampleItem.operator_approval_status.status_color == 'yellow'" class="tw-text-yellow-600 tw-text-xs tw-font-semibold"> {{ sampleItem.operator_approval_status.status_desc }} </span>
                                <span v-else-if="sampleItem.operator_approval_status.status_color == 'green'" class="tw-text-green-600 tw-text-xs tw-font-semibold"> {{ sampleItem.operator_approval_status.status_desc }} </span>
                                <span v-else-if="sampleItem.operator_approval_status.status_color == 'red'" class="tw-text-red-600 tw-text-xs tw-font-semibold"> {{ sampleItem.operator_approval_status.status_desc }} </span>
                                <span v-else class="tw-text-gray-600 tw-text-xs tw-font-semibold"> {{ sampleItem.operator_approval_status.status_desc }} </span>
                            </div>
                            <div class="tw-py-1" style="border-bottom: 1px solid #eee;">
                                <span class="tw-font-semibold"> S : </span>
                                <span v-if="sampleItem.supervisor_approval_status.status_color == 'yellow'" class="tw-text-yellow-600 tw-text-xs tw-font-semibold"> {{ sampleItem.supervisor_approval_status.status_desc }} </span>
                                <span v-else-if="sampleItem.supervisor_approval_status.status_color == 'green'" class="tw-text-green-600 tw-text-xs tw-font-semibold"> {{ sampleItem.supervisor_approval_status.status_desc }} </span>
                                <span v-else-if="sampleItem.supervisor_approval_status.status_color == 'red'" class="tw-text-red-600 tw-text-xs tw-font-semibold"> {{ sampleItem.supervisor_approval_status.status_desc }} </span>
                                <span v-else class="tw-text-gray-600 tw-text-xs tw-font-semibold"> {{ sampleItem.supervisor_approval_status.status_desc }} </span>
                            </div>
                            <div class="tw-pt-1">
                                <span class="tw-font-semibold"> L : </span>
                                <span v-if="sampleItem.leader_approval_status.status_color == 'yellow'" class="tw-text-yellow-600 tw-text-xs tw-font-semibold"> {{ sampleItem.leader_approval_status.status_desc }} </span>
                                <span v-else-if="sampleItem.leader_approval_status.status_color == 'green'" class="tw-text-green-600 tw-text-xs tw-font-semibold"> {{ sampleItem.leader_approval_status.status_desc }} </span>
                                <span v-else-if="sampleItem.leader_approval_status.status_color == 'red'" class="tw-text-red-600 tw-text-xs tw-font-semibold"> {{ sampleItem.leader_approval_status.status_desc }} </span>
                                <span v-else class="tw-text-gray-600 tw-text-xs tw-font-semibold"> {{ sampleItem.leader_approval_status.status_desc }} </span>
                            </div>
                        </td>
                        <td class="text-center md:tw-table-cell tw-hidden">
                            <span v-if="sampleItem.severity_level_minor == 'true'" class="fa fa-2x fa-check tw-text-blue-500"></span>
                        </td>
                        <td class="text-center md:tw-table-cell tw-hidden">
                            <span v-if="sampleItem.severity_level_major == 'true'" class="fa fa-2x fa-check tw-text-yellow-500"></span>
                        </td>
                        <td class="text-center md:tw-table-cell tw-hidden">
                            <span v-if="sampleItem.severity_level_critical == 'true'" class="fa fa-2x fa-check tw-text-red-500"></span>
                        </td>
                        <td class="text-center md:tw-table-cell tw-hidden">
                            <span v-if="sampleItem.test_serverity_code_minor == 'true'" class="fa fa-2x fa-check tw-text-blue-500"></span>
                        </td>
                        <td class="text-center md:tw-table-cell tw-hidden">
                            <span v-if="sampleItem.test_serverity_code_major == 'true'" class="fa fa-2x fa-check tw-text-yellow-500"></span>
                        </td>
                        <td class="text-center md:tw-table-cell tw-hidden">
                            <span v-if="sampleItem.test_serverity_code_critical == 'true'" class="fa fa-2x fa-check tw-text-red-500"></span>
                        </td>
                        <td class="text-left md:tw-table-cell tw-hidden">
                            {{ sampleItem.file_name }}
                        </td>
                        <td class="text-center">
                            <div v-if="showType == 'result'">
                                -
                            </div>
                            <div v-if="showType == 'track'">
                                -
                            </div>
                        </td>
                        <td class="freeze-col-right text-center text-nowrap" style="min-width: 100px;">
                            <div class="freeze-col-content">
                                <div class="tw-pb-2">
                                    <button class="btn btn-sm btn-default tw-text-xs tw-w-20" 
                                        @click="onResultButtonClicked(sampleItem.sample_no, sampleItem.organization_id, sampleItem.inventory_item_id, $event)">
                                        <i class="fa fa-edit"></i> Result
                                    </button>
                                </div>
                                <div v-if="(showType == 'result' || showType == 'approval') && isAllowApproval(sampleItem, approvalRole)" class="tw-pt-2" style="border-top: 1px solid #eee;">
                                    <button class="btn btn-sm btn-success tw-text-xs tw-w-20" 
                                        @click="onApproveSampleClicked(sampleItem, approvalRole, $event)">
                                        <i class="fa fa-check-square-o "></i> Approve
                                    </button>
                                </div>
                                <div v-if="(showType == 'result' || showType == 'approval') && isAllowRejectApproval(sampleItem, approvalRole)" class="tw-pt-2">
                                    <button class="btn btn-sm btn-danger tw-text-xs tw-w-20" 
                                        @click="onRejectSampleClicked(sampleItem, approvalRole, $event)">
                                        <i class="fa fa-times"></i> Reject
                                    </button>
                                </div>
                                <div v-if="(showType == 'result' || showType == 'approval') && isAllowReturnApproval(sampleItem, approvalRole)" class="tw-pt-2">
                                    <button class="btn btn-sm tw-bg-purple-600 hover:tw-bg-purple-800 tw-text-white hover:tw-text-white tw-text-xs tw-w-20" 
                                        @click="onReturnSampleClicked(sampleItem, approvalRole, $event)">
                                        <i class="fa fa-reply "></i> Return
                                    </button>
                                </div>
                                <div v-if="(showType == 'result' || showType == 'approval') && isAllowUnapproveApproval(sampleItem, approvalRole)" class="tw-pt-2" style="border-top: 1px solid #eee;">
                                    <button class="btn btn-sm tw-bg-purple-600 hover:tw-bg-purple-800 tw-text-white hover:tw-text-white tw-text-xs tw-w-24" 
                                        @click="onUnapproveSampleClicked(sampleItem, approvalRole, $event)">
                                        <i class="fa fa-times "></i> Unapprove
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr :key="`${sampleItem.sample_no}_line`" v-if="sampleItem.specification_showed">
                        <td colspan="18" style="border-right: 0;">
                            <qm-table-qtm-machine-results
                                :auth-user="authUser"
                                :show-type="showType"
                                :search-inputs="searchInputs"
                                :sample="sampleItem"
                                :items="sampleItem.specifications"
                                :list-brands="listBrands"
                                :list-makers="listMakers"
                                :approval-data="approvalData"
                                :approval-role="approvalRole"
                                :result-items="sampleItem.results"
                                @onSampleResultSubmitted="onSampleResultSubmitted"
                                @onConfirmSampleResult="onConfirmSampleResult"
                                @onRejectSampleResult="onRejectSampleResult"
                                @onCancelSampleResult="onCancelSampleResult"
                            >
                            </qm-table-qtm-machine-results>
                        </td>
                        <td colspan="3" style="border-left: 0;">
                        </td>
                    </tr>
                </template>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="21">
                        <h2 class="p-5 text-center text-muted">ไม่พบข้อมูล</h2>
                    </td>
                </tr>
            </tbody>

        </table>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

    </div>

</template>

<script>
// Import loading-overlay component
import Loading from "vue-loading-overlay";
// Import loading-overlay stylesheet
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

export default {
    props: ["authUser", "showType", "items", "total", "page", "perPage", "searchInputs", "machines", "listBrands", "listMakers", "confirmStatuses", "approvalData", "approvalRole"],

    components: {
        Loading
    },

    data() {
        return {
            sampleItems: JSON.parse(this.items).map(item => {
                return {
                    ...item,
                    confirm_code: item.gmd_sample.attribute12 ? item.gmd_sample.attribute12 : "1",
                    confirm_status: this.getConfirmStatus(this.confirmStatuses, (item.gmd_sample.attribute12 ? item.gmd_sample.attribute12 : "1")),
                    reject_reason: item.gmd_sample.attribute16 ? item.gmd_sample.attribute16 : "",
                    approval_status_code: item.gmd_sample.attribute13 ? item.gmd_sample.attribute13 : "10",
                    operator_approval_status: this.getOperatorApprovalStatus(this.approvalData, item.gmd_sample.attribute13),
                    supervisor_approval_status: this.getSupervisorApprovalStatus(this.approvalData, item.gmd_sample.attribute13),
                    leader_approval_status: this.getLeaderApprovalStatus(this.approvalData, item.gmd_sample.attribute13),
                    machine_full_name: this.getMachineFullname(item.machine_name),
                    // machine_description: this.getMachineDesc(this.machines, item.qc_area, item.machine_set),
                    date_drawn_show: item.date_drawn_formatted ? moment(item.date_drawn_formatted).add(543, 'years').format('DD/MM/YYYY') : "",
                    specification_showed: false,
                    specifications: [],
                    results: []
                };
            }),
            // .sort((a, b) => {
            //     var aDate = moment(a.date_drawn_formatted, 'YYYY-MM-DD').format("X");
            //     var bDate = moment(b.date_drawn_formatted, 'YYYY-MM-DD').format("X");
            //     var aDateTime = moment(a.date_drawn, 'YYYY-MM-DD HH:mm:ss').format("X");
            //     var bDateTime = moment(b.date_drawn, 'YYYY-MM-DD HH:mm:ss').format("X");
            //     if(aDate == bDate) {
            //         return (aDateTime < bDateTime) ? -1 : (aDateTime > bDateTime) ? 1 : 0;
            //     } else {
            //         return (aDate > bDate) ? -1 : 1;
            //     }
            // }),
            isLoading: false
        };
    },

    methods: {

        getConfirmStatus(confirmStatuses, confirmCode) {
            let result = "";
            const foundConfirmStatus = confirmStatuses.find(item => (item.confirm_code == confirmCode));
            if(foundConfirmStatus){
                result = foundConfirmStatus.confirm_status;
            }
            return result;
        },
        
        isAllowEdit(sample, approvalRole) {
            
            let allowed = false;
            if(approvalRole) {
                const approvalLevelCode = approvalRole.level_code;
                if(approvalLevelCode == "1") { // Operator
                    if(sample.approval_status_code == "10") { // Pending : Operator Approval 
                        allowed = true;
                    }
                }
            }
            return allowed;
            
        },

        isAllowApproval(sample, approvalRole) {
            
            let allowed = false;

            if(sample.sample_operation_status == 'CP') {
            
                if(approvalRole) {
                    const approvalLevelCode = approvalRole.level_code;
                    if(approvalLevelCode == "1") { // Operator
                        if(sample.approval_status_code == "10") { // Pending : Operator Approval 
                            allowed = true;
                        }
                    }else if(approvalLevelCode == "2") { // Supervisor
                        if(sample.approval_status_code == "11") { // Pending : Supervisor Approval (Operator Approved)
                            allowed = true;
                        }
                    }else if(approvalLevelCode == "3") { // Leader
                        if(sample.approval_status_code == "21") { // Pending : Leader Approval (Supervisor Approved)
                            allowed = true;
                        }
                    }
                }

            }

            return allowed;
            
        },

        isAllowRejectApproval(sample, approvalRole) {
            
            let allowed = false;

            if(approvalRole) {
                const approvalLevelCode = approvalRole.level_code;
                if(approvalLevelCode == "1") { // Operator
                    if(sample.approval_status_code == "10") { // Pending : Operator Approval 
                        allowed = true;
                    }
                }else if(approvalLevelCode == "2") { // Supervisor
                    if(sample.approval_status_code == "11") { // Pending : Supervisor Approval (Operator Approved)
                        allowed = true;
                    }
                }else if(approvalLevelCode == "3") { // Leader
                    if(sample.approval_status_code == "21") { // Pending : Leader Approval (Supervisor Approved)
                        allowed = true;
                    }
                }
            }

            return allowed;
            
        },

        isAllowReturnApproval(sample, approvalRole) {
            
            let allowed = false;
            if(approvalRole) {
                const approvalLevelCode = approvalRole.level_code;
                if(approvalLevelCode == "2") { // Supervisor
                    if(sample.approval_status_code == "11") { // Pending : Supervisor Approval (Operator Approved)
                        allowed = true;
                    }
                }else if(approvalLevelCode == "3") { // Leader
                    if(sample.approval_status_code == "21") { // Pending : Leader Approval (Supervisor Approved)
                        allowed = true;
                    }
                }
            }

            return allowed;
            
        },

        isAllowUnapproveApproval(sample, approvalRole) {
            
            let allowed = false;
            if(approvalRole) {
                const approvalLevelCode = approvalRole.level_code;
                if(approvalLevelCode == "3") { // Leader
                    if(sample.approval_status_code == "31") { // Leader Approved
                        allowed = true;
                    }
                }
            }

            return allowed;
            
        },

        getOperatorApprovalStatus(approvalData, statusCode) {
            const levelCode = 1;
            const foundApprovalData = approvalData.find(item => item.level_code == levelCode);
            let statusDesc = "";
            let statusColor = "";
            if(!statusCode || statusCode == "10") {
                statusDesc = foundApprovalData.pending_status;
                statusColor = "yellow";
            } else if(statusCode == "12") {
                statusDesc = foundApprovalData.reject_status;
                statusColor = "red";
            } else if(statusCode == "11" || statusCode == "21" || statusCode == "22" || statusCode == "31" || statusCode == "32") {
                statusDesc = foundApprovalData.approved_status;
                statusColor = "green";
            }
            return {
                status_desc: statusDesc,
                status_color: statusColor
            };
        },

        getSupervisorApprovalStatus(approvalData, statusCode) {
            const levelCode = 2;
            const foundApprovalData = approvalData.find(item => item.level_code == levelCode);
            let statusDesc = "";
            let statusColor = "";
            if(statusCode == "11") {
                statusDesc = foundApprovalData.pending_status;
                statusColor = "yellow";
            } else if(statusCode == "22") {
                statusDesc = foundApprovalData.reject_status;
                statusColor = "red";
            } else if(statusCode == "21" || statusCode == "31" || statusCode == "32") {
                statusDesc = foundApprovalData.approved_status;
                statusColor = "green";
            }
            return {
                status_desc: statusDesc,
                status_color: statusColor
            };
        },

        getLeaderApprovalStatus(approvalData, statusCode) {
            const levelCode = 3;
            const foundApprovalData = approvalData.find(item => item.level_code == levelCode);
            let statusDesc = "";
            let statusColor = "";
            if(statusCode == "21") {
                statusDesc = foundApprovalData.pending_status;
                statusColor = "yellow";
            } else if(statusCode == "32") {
                statusDesc = foundApprovalData.reject_status;
                statusColor = "red";
            } else if(statusCode == "31") {
                statusDesc = foundApprovalData.approved_status;
                statusColor = "green";
            }
            return {
                status_desc: statusDesc,
                status_color: statusColor
            };
        },

        getMachineFullname(machineName) {
            let result = "";
            if(machineName) {
                result = `QTM${machineName}`
            }
            return result;
        },

        // getMachineDesc(machines, qcArea, machineSet) {
        //     let result = "";
        //     const foundMachineWithQcArea = machines.find(item => (item.machine_set == machineSet && item.qc_area == qcArea));
        //     if(foundMachineWithQcArea){
        //         result = foundMachineWithQcArea.machine_description;
        //     }else{
        //         const foundMachine = machines.find(item => (item.machine_set == machineSet));
        //         if(foundMachine){
        //             result = foundMachine.machine_description;
        //         }
        //     }
        //     return result;
        // },

        onResultButtonClicked(sampleNo, organizationId, inventoryItemId, e) {
            this.sampleItems.forEach(async (element, i) => {
                if (element.sample_no === sampleNo) {
                    if (!this.sampleItems[i].specification_showed) {
                        this.isLoading = true;
                        const resGetSampleSpecifications = await this.getSampleSpecifications(
                            sampleNo,
                            organizationId,
                            inventoryItemId,
                        );
                        this.sampleItems[i].specifications = resGetSampleSpecifications.specifications;
                        this.sampleItems[i].results = resGetSampleSpecifications.results;
                        this.isLoading = false;
                    }
                    this.sampleItems[i].specification_showed = !this
                        .sampleItems[i].specification_showed;
                } else {
                    this.sampleItems[i].specification_showed = false;
                }
            });
        },

        getSampleSpecifications(sampleNo, organizationId, inventoryItemId) {
            var params = {
                sample_no: sampleNo,
                organization_id: organizationId,
                inventory_item_id: inventoryItemId
            };
            return axios
                .get("/qm/ajax/qtm-machines/get-sample-specifications", {
                    params
                })
                .then(res => {
                    return {
                        specifications: JSON.parse(res.data.data.specifications),
                        results: JSON.parse(res.data.data.results),
                    };
                });
        },

        onSampleTimeDrawnChanged(value, sampleItem){
            sampleItem.time_drawn_formatted = value;
        },

        onSampleTimeDrawnClosed(value, sampleItem){

            // SHOW LOADING
            this.isLoading = true;

            if(!moment(sampleItem.time_drawn_formatted, "HH:mm", true).isValid()) {
                swal("Error", `ข้อมูล "เวลาที่เก็บตัวอย่าง" ไม่ถูกต้อง กรุณาตรวจสอบ`, "error");
                this.isLoading = false;
            } else {
                const reqBody = {
                    organization_code: sampleItem.organization_code,
                    oracle_sample_id: sampleItem.oracle_sample_id,
                    sample_no: sampleItem.sample_no,
                    time_drawn_formatted: sampleItem.time_drawn_formatted,
                };

                axios.post(`/qm/ajax/qtm-machines/update-time-drawn`, reqBody)
                .then((res) => {

                    const resData = res.data.data;
                    const resMsg = resData.message;

                    // HIDE LOADING
                    this.isLoading = false;

                    if(resData.status == "success") {
                        // swal("Success", `แก้ไขข้อมูลเวลาที่เก็บตัวอย่าง (เลขที่การตรวจสอบ : ${sampleItem.sample_no} )`, "success");
                    }

                    if(resData.status == "error") {
                        swal("Error", `ไม่สามารถแก้ไขข้อมูลเวลาที่เก็บตัวอย่าง (เลขที่การตรวจสอบ : ${sampleItem.sample_no}) | ${resMsg}`, "error");
                    }

                })
                .catch((error) => {
                    console.log(error);
                    // HIDE LOADING
                    this.isLoading = false;
                    swal("Error", `ไม่สามารถแก้ไขข้อมูลเวลาที่เก็บตัวอย่าง (เลขที่การตรวจสอบ : ${sampleItem.sample_no})  | ${error.message}`, "error");
                });
            }

        },

        onSampleResultSubmitted(data) {

            if(data.status == "success") {

                const resSampleNo = data.sample_no;
                const resSampleDisposition = data.sample_disposition;
                const resSampleDispositionDesc = data.sample_disposition_desc;
                const resSampleOperationStatus = data.sample_operation_status;
                const resSampleOperationStatusDesc = data.sample_operation_status_desc;
                const resSampleResultStatus = data.sample_result_status;
                const resSampleResultStatusDesc = data.sample_result_status_desc;
                const resSampleSeverityLevelMinor = data.severity_level_minor; 
                const resSampleSeverityLevelMajor = data.severity_level_major; 
                const resSampleSeverityLevelCritical = data.severity_level_critical; 
                // const resSampleMachineDescription = data.machine_description;
                const resSampleResultTestTime = data.test_time;
                const resSampleResultBrand = data.brand;
                const resSampleResultMaker = data.maker;
                this.sampleItems.forEach((element, i) => {
                    // this.sampleItems[i].specification_showed = false;
                    if(this.sampleItems[i].sample_no == resSampleNo){
                        this.sampleItems[i].sample_disposition = resSampleDisposition;
                        this.sampleItems[i].sample_disposition_desc = resSampleDispositionDesc;
                        this.sampleItems[i].sample_operation_status = resSampleOperationStatus;
                        this.sampleItems[i].sample_operation_status_desc = resSampleOperationStatusDesc;
                        this.sampleItems[i].sample_result_status = resSampleResultStatus;
                        this.sampleItems[i].sample_result_status_desc = resSampleResultStatusDesc;
                        this.sampleItems[i].severity_level_minor = resSampleSeverityLevelMinor;
                        this.sampleItems[i].severity_level_major = resSampleSeverityLevelMajor;
                        this.sampleItems[i].severity_level_critical = resSampleSeverityLevelCritical;
                        // this.sampleItems[i].machine_description = resSampleMachineDescription;
                        this.sampleItems[i].brand = resSampleResultBrand;
                        this.sampleItems[i].maker = resSampleResultMaker;
                        this.sampleItems[i].test_time = resSampleResultTestTime;
                    }
                });

            }

        },

        onConfirmSampleResult(data) {
            console.log(data);
            const resSampleNo = data.sample_no;
            const resConfirmCode = data.confirm_code;
            const resRejectReason = "";
            this.sampleItems.forEach((element, i) => {
                this.sampleItems[i].specification_showed = false;
                if(this.sampleItems[i].sample_no == resSampleNo){
                    this.sampleItems[i].confirm_code = resConfirmCode;
                    this.sampleItems[i].confirm_status = this.getConfirmStatus(this.confirmStatuses, (resConfirmCode ? resConfirmCode : "1"));
                    this.sampleItems[i].reject_reason = resRejectReason;
                    this.sampleItems[i].sample_operation_status = data.sample_operation_status;
                    this.sampleItems[i].sample_operation_status_desc = data.sample_operation_status_desc;
                    this.sampleItems[i].sample_result_status = data.sample_result_status;
                    this.sampleItems[i].sample_result_status_desc = data.sample_result_status_desc;
                }
            });
        },

        onRejectSampleResult(data) {
            console.log(data);
            const resSampleNo = data.sample_no;
            const resConfirmCode = data.confirm_code;
            const resRejectReason = data.reject_reason;
            this.sampleItems.forEach((element, i) => {
                this.sampleItems[i].specification_showed = false;
                if(this.sampleItems[i].sample_no == resSampleNo){
                    this.sampleItems[i].confirm_code = resConfirmCode;
                    this.sampleItems[i].confirm_status = this.getConfirmStatus(this.confirmStatuses, (resConfirmCode ? resConfirmCode : "1"));
                    this.sampleItems[i].reject_reason = resRejectReason;
                    this.sampleItems[i].sample_operation_status = data.sample_operation_status;
                    this.sampleItems[i].sample_operation_status_desc = data.sample_operation_status_desc;
                    this.sampleItems[i].sample_result_status = data.sample_result_status;
                    this.sampleItems[i].sample_result_status_desc = data.sample_result_status_desc;
                }
            });
        },

        onCancelSampleResult(e) {
            this.sampleItems.forEach((element, i) => {
                this.sampleItems[i].specification_showed = false;
            });
        },

        onApproveSampleClicked(sampleData, approvalRole, event){

            let approvalProcessLabel = "";
            const approvalLevelCode = approvalRole.level_code;
            if(approvalLevelCode == "1"){
                approvalProcessLabel = "ส่งอนุมัติ";
            }else if(approvalLevelCode == "2" || approvalLevelCode == "3") {
                approvalProcessLabel = "อนุมัติผลการตรวจสอบ";
            }

            const sampleDispositionDesc = sampleData.sample_disposition_desc;
            const alertText = `ต้องการ ${approvalProcessLabel} (เลขที่การตรวจสอบ : ${sampleData.sample_no} | สถานะ : ${sampleDispositionDesc} ) ?`;

            swal({
                title: "",
                text: alertText,
                showCancelButton: true,
                confirmButtonClass: "btn-primary",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ปิด",
                closeOnConfirm: false
            }, (isConfirm) => {
                if (isConfirm) {
                    this.approveSample(sampleData, approvalRole, approvalProcessLabel);
                }
            });
        },

        onApproveAllSampleClicked(approvalRole, event){

            let approvalProcessLabel = "";
            const approvalLevelCode = approvalRole.level_code;
            if(approvalLevelCode == "1"){
                approvalProcessLabel = "ส่งอนุมัติ";
            }else if(approvalLevelCode == "2" || approvalLevelCode == "3") {
                approvalProcessLabel = "อนุมัติผลการตรวจสอบ";
            }

            const approvingSampleNos = this.sampleItems.filter(sample => {
                return this.isAllowApproval(sample, approvalRole);
            }).map(item => item.sample_no);

            console.log("Approving SampleNos : ");
            console.log(approvingSampleNos);

            if(approvingSampleNos.length <= 0) {
                swal("Error", `ไม่พบเลขที่การตรวจสอบ ที่สามารถ${approvalProcessLabel}ได้ `, "error");
            } else {

                const alertText = `ต้องการ ${approvalProcessLabel} ทั้งหมด ${approvingSampleNos.length} รายการ ) ?`;
                swal({
                    title: "",
                    text: alertText,
                    showCancelButton: true,
                    confirmButtonClass: "btn-primary",
                    confirmButtonText: "ยืนยัน",
                    cancelButtonText: "ปิด",
                    closeOnConfirm: false
                }, (isConfirm) => {
                    if (isConfirm) {
                        this.approveAllSamples(approvingSampleNos, approvalRole, approvalProcessLabel);
                    }
                });
                
            }

        },

        onRejectSampleClicked(sampleData, approvalRole, event) {

            let approvalProcessLabel = "";
            const approvalLevelCode = approvalRole.level_code;
            if(approvalLevelCode == "1"){
                approvalProcessLabel = "ยกเลิกผลการทดสอบ";
            }else if(approvalLevelCode == "2" || approvalLevelCode == "3") {
                approvalProcessLabel = "ไม่อนุมัติผลการตรวจสอบ";
            }

            const sampleDispositionDesc = sampleData.sample_disposition_desc;
            const alertText = `ต้องการ ${approvalProcessLabel} (เลขที่การตรวจสอบ : ${sampleData.sample_no} | สถานะ : ${sampleDispositionDesc} ) ?`;

            swal({
                title: "",
                text: alertText,
                showCancelButton: true,
                confirmButtonClass: "btn-primary",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ปิด",
                closeOnConfirm: false
            }, (isConfirm) => {
                if (isConfirm) {
                    this.rejectSample(sampleData, approvalRole, approvalProcessLabel);
                }
            });
        },

        onReturnSampleClicked(sampleData, approvalRole, event){

            let approvalProcessLabel = "ส่งกลับการอนุมัติ";
            swal({
                title: "",
                text: `ต้องการ ${approvalProcessLabel} (เลขที่การตรวจสอบ : ${sampleData.sample_no} ) ?`,
                showCancelButton: true,
                confirmButtonClass: "btn-primary",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ปิด",
                closeOnConfirm: false
            }, (isConfirm) => {
                if (isConfirm) {
                    this.returnSample(sampleData, approvalRole, approvalProcessLabel);
                }
            });
        },

        onUnapproveSampleClicked(sampleData, approvalRole, event){

            let approvalProcessLabel = "ยกเลิกการอนุมัติ";
            swal({
                title: "",
                text: `ต้องการ ${approvalProcessLabel} (เลขที่การตรวจสอบ : ${sampleData.sample_no} ) ?`,
                showCancelButton: true,
                confirmButtonClass: "btn-primary",
                confirmButtonText: "ยืนยัน",
                cancelButtonText: "ปิด",
                closeOnConfirm: false
            }, (isConfirm) => {
                if (isConfirm) {
                    this.unapproveSample(sampleData, approvalRole, approvalProcessLabel);
                }
            });
        },

        async approveSample(sampleData, approvalRole, approvalProcessLabel) {

            const reqBody = {
                organization_code: sampleData.organization_code,
                oracle_sample_id: sampleData.oracle_sample_id,
                sample_no: sampleData.sample_no,
                approval_level_code: approvalRole.level_code,
            };

            // SHOW LOADING
            this.isLoading = true;

            await axios.post(`/qm/ajax/qtm-machines/approval/approve`, reqBody)
            .then((res) => {

                const resData = res.data.data;
                const resMsg = resData.message;
                const resSample = resData.sample ? JSON.parse(resData.sample) : null;
                const resApprovalStatusCode = resData.approval_status_code ? resData.approval_status_code : "10";
                
                if(resData.status == "success") {
                    swal("Success", `${approvalProcessLabel} (เลขที่การตรวจสอบ : ${sampleData.sample_no} )`, "success");
                    sampleData.gmd_sample.attribute13 = resApprovalStatusCode;
                    sampleData.approval_status_code = resApprovalStatusCode;
                    sampleData.operator_approval_status = this.getOperatorApprovalStatus(this.approvalData, resApprovalStatusCode);
                    sampleData.supervisor_approval_status = this.getSupervisorApprovalStatus(this.approvalData, resApprovalStatusCode);
                    sampleData.leader_approval_status = this.getLeaderApprovalStatus(this.approvalData, resApprovalStatusCode);
                }

                if(resData.status == "error") {
                    swal("Error", `ไม่สามารถ ${approvalProcessLabel} (เลขที่การตรวจสอบ : ${sampleData.sample_no}) | ${resMsg}`, "error");
                }
                
                return resData;

            })
            .catch((error) => {
                console.log(error);
                resStoreSampleResultStatus = "error";
                swal("Error", `${approvalProcessLabel} (เลขที่การตรวจสอบ : ${sampleData.sample_no}) | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        async approveAllSamples(sampleNos, approvalRole, approvalProcessLabel) {

            const reqBody = {
                sample_nos: JSON.stringify(sampleNos),
                approval_level_code: approvalRole.level_code,
            };

            // SHOW LOADING
            this.isLoading = true;

            await axios.post(`/qm/ajax/qtm-machines/approval/approve-all`, reqBody)
            .then((res) => {

                const resData = res.data.data;
                const resMsg = resData.message;
                
                if(resData.status == "success") {
                    swal("Success", `${approvalProcessLabel} ( เลขที่การตรวจสอบ : ${sampleNos.length} รายการ } )`, "success");
                    location.reload();
                }

                if(resData.status == "error") {
                    swal("Error", `ไม่สามารถ ${approvalProcessLabel} (เลขที่การตรวจสอบ : ${sampleNos.length} รายการ }) | ${resMsg}`, "error");
                }
                
                return resData;

            })
            .catch((error) => {
                console.log(error);
                resStoreSampleResultStatus = "error";
                swal("Error", `${approvalProcessLabel} (เลขที่การตรวจสอบ : ${sampleNos.length} รายการ }) | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        async rejectSample(sampleData, approvalRole, approvalProcessLabel) {

            const reqBody = {
                organization_code: sampleData.organization_code,
                oracle_sample_id: sampleData.oracle_sample_id,
                sample_no: sampleData.sample_no,
                approval_level_code: approvalRole.level_code,
            };

            // SHOW LOADING
            this.isLoading = true;

            await axios.post(`/qm/ajax/qtm-machines/approval/reject`, reqBody)
            .then((res) => {

                const resData = res.data.data;
                const resMsg = resData.message;
                const resSample = resData.sample ? JSON.parse(resData.sample) : null;
                const resApprovalStatusCode = resData.approval_status_code ? resData.approval_status_code : "10";
                
                if(resData.status == "success") {
                    swal("Success", `${approvalProcessLabel} (เลขที่การตรวจสอบ : ${sampleData.sample_no} )`, "success");
                    sampleData.gmd_sample.attribute13 = resApprovalStatusCode;
                    sampleData.approval_status_code = resApprovalStatusCode;
                    sampleData.operator_approval_status = this.getOperatorApprovalStatus(this.approvalData, resApprovalStatusCode);
                    sampleData.supervisor_approval_status = this.getSupervisorApprovalStatus(this.approvalData, resApprovalStatusCode);
                    sampleData.leader_approval_status = this.getLeaderApprovalStatus(this.approvalData, resApprovalStatusCode);
                    if(resSample) {
                        sampleData.sample_operation_status = resSample.sample_operation_status;
                        sampleData.sample_operation_status_desc = resSample.sample_operation_status_desc;
                        sampleData.sample_result_status = resSample.sample_result_status;
                        sampleData.sample_result_status_desc = resSample.sample_result_status_desc;
                    }
                }

                if(resData.status == "error") {
                    swal("Error", `ไม่สามารถ ${approvalProcessLabel} (เลขที่การตรวจสอบ : ${sampleData.sample_no}) | ${resMsg}`, "error");
                }
                
                return resData;

            })
            .catch((error) => {
                console.log(error);
                resStoreSampleResultStatus = "error";
                swal("Error", `${approvalProcessLabel} (เลขที่การตรวจสอบ : ${sampleData.sample_no}) | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        async returnSample(sampleData, approvalRole, approvalProcessLabel) {

            const reqBody = {
                organization_code: sampleData.organization_code,
                oracle_sample_id: sampleData.oracle_sample_id,
                sample_no: sampleData.sample_no,
                approval_level_code: approvalRole.level_code,
            };

            // SHOW LOADING
            this.isLoading = true;

            await axios.post(`/qm/ajax/qtm-machines/approval/return`, reqBody)
            .then((res) => {

                const resData = res.data.data;
                const resMsg = resData.message;
                const resSample = resData.sample ? JSON.parse(resData.sample) : null;
                const resApprovalStatusCode = resData.approval_status_code ? resData.approval_status_code : "10";
                
                if(resData.status == "success") {
                    swal("Success", `${approvalProcessLabel} (เลขที่การตรวจสอบ : ${sampleData.sample_no} )`, "success");
                    sampleData.gmd_sample.attribute13 = resApprovalStatusCode;
                    sampleData.approval_status_code = resApprovalStatusCode;
                    sampleData.operator_approval_status = this.getOperatorApprovalStatus(this.approvalData, resApprovalStatusCode);
                    sampleData.supervisor_approval_status = this.getSupervisorApprovalStatus(this.approvalData, resApprovalStatusCode);
                    sampleData.leader_approval_status = this.getLeaderApprovalStatus(this.approvalData, resApprovalStatusCode);
                }

                if(resData.status == "error") {
                    swal("Error", `ไม่สามารถ ${approvalProcessLabel} (เลขที่การตรวจสอบ : ${sampleData.sample_no}) | ${resMsg}`, "error");
                }
                
                return resData;

            })
            .catch((error) => {
                console.log(error);
                resStoreSampleResultStatus = "error";
                swal("Error", `${approvalProcessLabel} (เลขที่การตรวจสอบ : ${sampleData.sample_no}) | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

        async unapproveSample(sampleData, approvalRole, approvalProcessLabel) {

            const reqBody = {
                organization_code: sampleData.organization_code,
                oracle_sample_id: sampleData.oracle_sample_id,
                sample_no: sampleData.sample_no,
                approval_level_code: approvalRole.level_code,
            };

            // SHOW LOADING
            this.isLoading = true;

            await axios.post(`/qm/ajax/qtm-machines/approval/unapprove`, reqBody)
            .then((res) => {

                const resData = res.data.data;
                const resMsg = resData.message;
                const resSample = resData.sample ? JSON.parse(resData.sample) : null;
                const resApprovalStatusCode = resData.approval_status_code ? resData.approval_status_code : "10";
                
                if(resData.status == "success") {
                    swal("Success", `${approvalProcessLabel} (เลขที่การตรวจสอบ : ${sampleData.sample_no} )`, "success");
                    sampleData.gmd_sample.attribute13 = resApprovalStatusCode;
                    sampleData.approval_status_code = resApprovalStatusCode;
                    sampleData.operator_approval_status = this.getOperatorApprovalStatus(this.approvalData, resApprovalStatusCode);
                    sampleData.supervisor_approval_status = this.getSupervisorApprovalStatus(this.approvalData, resApprovalStatusCode);
                    sampleData.leader_approval_status = this.getLeaderApprovalStatus(this.approvalData, resApprovalStatusCode);
                }

                if(resData.status == "error") {
                    swal("Error", `ไม่สามารถ ${approvalProcessLabel} (เลขที่การตรวจสอบ : ${sampleData.sample_no}) | ${resMsg}`, "error");
                }
                
                return resData;

            })
            .catch((error) => {
                console.log(error);
                resStoreSampleResultStatus = "error";
                swal("Error", `${approvalProcessLabel} (เลขที่การตรวจสอบ : ${sampleData.sample_no}) | ${error.message}`, "error");
            });

            // HIDE LOADING
            this.isLoading = false;

        },

    }
};
</script>
