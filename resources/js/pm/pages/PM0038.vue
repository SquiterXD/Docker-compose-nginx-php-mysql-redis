<template>
    <div id="pm0038">

        <div class="row">
            <div class="col-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <h5>ตรวจสอบสถานะเพื่อปิดคำสั่งผลิต</h5>
                            </div>
                            <div class="col-lg-6">
                                <div class="float-right">
                                    <button :class="btn_trans.reset.class" @click.prevent="clearSearchForm">
                                        <i :class="btn_trans.reset.icon"></i>
                                        {{ btn_trans.reset.text }}
                                    </button>
                                    <!-- <button :class="btn_trans.search.class" @click.prevent="submitSearchForm"><i
                                        :class="btn_trans.search.icon"></i>
                                        {{ btn_trans.search.text }}
                                    </button> -->
                                    <button :class="btn_trans.closeJob.class" @click.prevent="closeJob"
                                            :disabled="checkedRequests.length === 0"><i
                                        :class="btn_trans.closeJob.icon"></i>
                                        {{ btn_trans.closeJob.text }}
                                    </button>
                                    <button :class="btn_trans.cancelCloseStatus.class" @click.prevent="cancelCloseStatus"
                                            :disabled="checkedRequests.length === 0"><i
                                        :class="btn_trans.cancelCloseStatus.icon"></i>
                                        {{ btn_trans.cancelCloseStatus.text }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-12" v-loading="loadingData">
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">วันที่:</label>
                                    <div class="col-md-3 pl-0">
                                        <ct-datepicker
                                            class="form-control"
                                            style="width: 100%;"
                                            placeholder="โปรดเลือกวันที่"
                                            :clearable="false"
                                            :enableDate="date => isInRange(date, null, toJSDate(qEndDate), true)"
                                            :value="toJSDate(qStartDate, 'yyyy-MM-dd')"
                                            @change="(date) => {
                                                if(date){
                                                        qStartDate = jsDateToString(date)
                                                        onChgStartDate()
                                                    }else{
                                                        qStartDate = null
                                                    }
                                                this.initData()
                                            }"/>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <label class="col-md-2 col-form-label">เลขที่คำสั่งการผลิต:</label>
                                    <div class="col-md-3">
                                        <el-select v-model="qReqNo"
                                                   clearable
                                                   filterable
                                                   placeholder="กรุณาเลือกเลขที่คำสั่งผลิต"
                                                   @change="onChgReqNo">
                                            <el-option v-for="item in lovRequestNumber"
                                                       :key="item.request_number + item.item_code"
                                                       :label="item.request_number"
                                                       :value="item.request_number">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">ถึง:</label>
                                    <div class="col-md-3  pl-0">
                                        <ct-datepicker
                                            class="form-control"
                                            style="width: 100%;"
                                            placeholder="โปรดเลือกวันที่"
                                            :clearable="false"
                                            :enableDate="date => isInRange(date, toJSDate(qStartDate), null, true)"
                                            :value="toJSDate(qEndDate, 'yyyy-MM-dd')"
                                            @change="(date) => {
                                                if(date){
                                                        qEndDate = jsDateToString(date)
                                                    }else{
                                                        qEndDate = null
                                                    }
                                                this.initData()
                                            }"/>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <label class="col-md-2 col-form-label">รหัสสินค้าสำเร็จรูป:</label>
                                    <div class="col-md-3">
                                        <el-select
                                            placeholder="กรุณาเลือกรหัสสินค้า"
                                            filterable
                                            clearable
                                            v-model="qItemCode"
                                            @change="onChgItemCode">
                                            <el-option
                                                v-for="item in lovItem"
                                                :key="JSON.stringify(item)"
                                                :label="`${item.item_code}: ${item.item_description}`"
                                                :value="item.item_code">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Blend No:</label>
                                    <div class="col-md-3 pl-0">
                                        <input type="text" class="form-control" v-model="qBlendNo" disabled>

                                    </div>
                                    <div class="col-md-1"></div>
                                    <label class="col-md-2 col-form-label">รายละเอียด:</label>
                                    <div class="col-md-3">

                                        <input type="text" class="form-control" v-model="qItemDesc" disabled>

                                    </div>
                                </div>
                                <div class="form-group row">
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">สถานะคำสั่งผลิต:</label>
                                    <div class="col-md-2 pl-0"
                                         v-for="item in lovManufactureStatus"
                                         :key="item.description">
                                        <label class="col-md-12 col-form-label b-r-sm text-dark"
                                               :class="getBatchStatusClass(item.lookup_code)">
                                            <input type="checkbox" v-model="qBatchStatus"
                                                   :id="item.description"
                                                   :value="item.description" :disabled="isDisableStatusCheckBox">
                                            {{ item.description }}
                                        </label>
                                    </div>
                                    <div class="col-md-2  pl-0">
                                        <label class="col-md-12 col-form-label b-r-sm bg-grey text-dark">
                                            <input type="checkbox" v-model="isSelectAllBatchStatus"
                                                   @change="selectAllBatchStatus" :disabled="isDisableStatusCheckBox">
                                            เลือกทั้งหมด
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">สถานะการดำเนินงาน:</label>
                                    <div class="col-md-2  pl-0">
                                        <label class="col-md-12 col-form-label b-r-sm bg-brown">
                                            <input
                                                type="checkbox"
                                                v-model="qProcessStatus.status1"
                                                @change="onChgProcessStatus"
                                                :disabled="isDisableStatusCheckBox || isDisableProcessStatusCheckBox">
                                            บันทึกผลผลิต
                                        </label>
                                    </div>
                                    <div :class="getDivClass()">
                                        <label class="col-md-12 col-form-label b-r-sm bg-brown">
                                            <input
                                                type="checkbox"
                                                v-model="qProcessStatus.status2"
                                                @change="onChgProcessStatus"
                                                :disabled="isDisableStatusCheckBox || isDisableProcessStatusCheckBox">
                                            ตรวจสอบหลังผลิต
                                        </label>
                                    </div>
                                    <div class="col-md-2 pl-0">
                                        <label class="col-md-12 col-form-label b-r-sm bg-brown">
                                            <input
                                                type="checkbox"
                                                v-model="qProcessStatus.status3"
                                                @change="onChgProcessStatus"
                                                :disabled="isDisableStatusCheckBox || isDisableProcessStatusCheckBox">
                                            ตัดใช้วัตถุดิบ
                                        </label>
                                    </div>
                                    <div class="col-md-2 pl-0">
                                        <label class="col-md-12 col-form-label b-r-sm bg-brown">
                                            <input
                                                type="checkbox"
                                                v-model="qProcessStatus.status4"
                                                @change="onChgProcessStatus"
                                                :disabled="isDisableStatusCheckBox || isDisableProcessStatusCheckBox">
                                            รับเข้าคลัง
                                        </label>
                                    </div>
                                    <div class="col-md-2 pl-0">
                                        <label class="col-md-12 col-form-label b-r-sm bg-grey">
                                            <input type="checkbox"
                                                   v-model="isSelectAllProcessStatus"
                                                   :disabled="isDisableStatusCheckBox || isDisableProcessStatusCheckBox"
                                                   @change="selectAllProcessStatus">
                                            เลือกทั้งหมด
                                        </label>
                                    </div>
                                </div>

                                <div class=" row">
                                    <div class="col-2  pl-0 offset-10 text-right">
                                        <button :class="btn_trans.search.class" @click.prevent="submitSearchForm"><i
                                            :class="btn_trans.search.icon"></i>
                                            แสดงข้อมูล
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="header" rowspan="2">
                                        <!--                                        <div class="form-check abc-checkbox form-check-inline m-l-md">เลือก</div>-->
                                        <input type="checkbox" @change="checkedAll" v-model="isCheckAllRequests"
                                               :disabled="this.isDisableCheckAll"
                                        >
                                    </th>
                                    <th rowspan="2" class="header" style="min-width: 150px;">เลขที่คำสั่งการผลิต</th>
                                    <th rowspan="2" class="header" style="min-width: 150px;">รหัสสินค้าสำเร็จรูป</th>
                                    <th rowspan="2" class="header" style="min-width: 250px;">รายละเอียด</th>
                                    <th rowspan="2" class="header" style="min-width: 130px;">จำนวนที่สั่งผลิต</th>
                                    <th rowspan="2" class="header" style="min-width: 80px;">หน่วย</th>
                                    <th rowspan="2" class="header" style="min-width: 130px;">ผลผลิตที่ได้</th>
                                    <th rowspan="2" class="header" style="min-width: 150px;">สถานะคำสั่งผลิต</th>
                                    <th :colspan=colSpanNo class="header text-center">สถานะการดำเนินงาน</th>
                                </tr>
                                <tr>
                                    <th class="header" style="min-width: 100px;">บันทึกผลผลิต</th>
                                    <th :class="getColClass()" class="header" style="min-width: 100px;">ตรวจสอบหลังผลิต
                                    </th>
                                    <th class="header" style="min-width: 100px;">ตัดใช้วัตถุดิบ</th>
                                    <th class="header" style="min-width: 100px;">รับผลผลิตเข้าคลัง</th>
                                </tr>
                                </thead>
                                <tbody v-if="reqs.length">
                                <!-- <tr v-for="req in reqs" :key="req.organization_id + req.batch_id + req.request_number"> -->
                                <tr v-for="(req, key, idx) in reqs" :key="idx">
                                    <td>
                                        <div class="check-center">
                                            <label class="label-input">
                                                <input
                                                    class="align-middle"
                                                    type="checkbox"
                                                    v-model="checkedRequests"
                                                    :value="req.batch_id"
                                                    :disabled="isDisableCheckBox(req)">
                                            </label>
                                        </div>
                                    </td>
                                    <td>{{ req.request_number }}</td>
                                    <td>{{ req.item_code }}</td>
                                    <td>{{ req.item_description }}</td>
                                    <td class="text-right">
                                        <!-- {{ numberFormat(req.request_quantity) }} xx -->
                                        {{ req.request_quantity | number4Digit }}

                                    </td>
                                    <td class="text-left">{{ req.th_uom }}</td>
                                    <td class="text-right">
                                        <!-- {{ numberFormat(req.product_qty) }} -->
                                        {{ req.product_qty | number4Digit }}
                                    </td>
                                    <td class="text-center">
                                        <label class="col-12 col-form-label b-r-sm text-dark"
                                               :class="getBatchStatusClass(req.request_status)">
                                            {{ req.request_status }}
                                        </label>
                                    </td>
                                    <td>
                                        <div class="check-center">
                                            <!-- <label class="label-input">
                                                <input class="align-middle" type="checkbox" :checked="req.wip_flag == 1"
                                                       disabled>
                                            </label> -->
                                            <button class="btn btn-white btn-sm " disabled >
                                                <input class="align-middle" type="checkbox"
                                                    :checked="req.wip_flag == 1" disabled>
                                            </button>

                                            <button class="btn btn-white btn-sm"
                                                @click="showProductLineModal(req, 'wip_flag')"
                                                :title="btn_trans.detail.text">
                                                <i :class="btn_trans.detail.icon"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td :class="getColClass()">
                                        <div class="check-center">
                                            <label class="label-input">
                                                <input class="align-middle" type="checkbox"
                                                       :checked="req.check_flag == 1"
                                                       disabled>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="check-center">
                                            <!-- <label class="label-input">
                                                <input class="align-middle" type="checkbox"
                                                       :checked="req.issue_flag == 1"
                                                       disabled>
                                            </label> -->
                                            <button class="btn btn-white btn-sm " disabled >
                                                <input class="align-middle" type="checkbox"
                                                    :checked="req.issue_flag == 1" disabled>
                                            </button>

                                            <button class="btn btn-white btn-sm"
                                                @click="showProductLineModal(req, 'issue_flag')"
                                                :title="btn_trans.detail.text">
                                                <i :class="btn_trans.detail.icon"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="check-center">
                                            <!-- <label class="label-input">
                                                <input class="align-middle" type="checkbox"
                                                       :checked="req.complete_flag == 1"
                                                       disabled>
                                            </label> -->
                                            <button class="btn btn-white btn-sm " disabled >
                                                <input class="align-middle" type="checkbox"
                                                    :checked="req.complete_flag == 1" disabled>
                                            </button>

                                            <button class="btn btn-white btn-sm"
                                                @click="showProductLineModal(req, 'complete_flag')"
                                                :title="btn_trans.detail.text">
                                                <i :class="btn_trans.detail.icon"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                                <tbody v-else>
                                <tr>
                                    <td colspan="15">ไม่พบข้อมูล</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="productLineModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="display:none;">
                        <h5 class="modal-title"></h5>
                        <button ref="closeModal" type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div v-if="productLineSearching" class="lead text-center">
                            กำลังค้นหา
                            <div class="sk-spinner sk-spinner-wave">
                                <div class="sk-rect1"></div>
                                <div class="sk-rect2"></div>
                                <div class="sk-rect3"></div>
                                <div class="sk-rect4"></div>
                                <div class="sk-rect5"></div>
                            </div>
                        </div>
                        <div v-if="!productLineSearching">
                            <table class="table table-borderedx table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">วันที่</th>
                                    <th width="10%" class="text-center">สถานะ</th>
                                </tr>
                                </thead>
                                <tbody v-if="productLineDetails.length">
                                    <template v-for="line in productLineDetails">
                                        <tr>
                                            <td class="text-center">{{ line.product_date_format }}</td>
                                            <td class="text-center" :title="line.wip_step">
                                                <input class="align-middle"type="checkbox"
                                                    :checked="line.is_checked" disabled>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                                <tbody v-else>
                                <tr>
                                    <td colspan="15">ไม่พบข้อมูล</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


<!--        <div class="form-group row">-->
<!--                    <pre class="col-lg-4" style="display: block">{{-->
<!--                            JSON.stringify({-->
<!--                                checkedRequests,-->
<!--                                initStartDate,-->
<!--                                default_data,-->
<!--                                organization,-->
<!--                                lovItem,-->
<!--                                isSelectAllBatchStatus,-->
<!--                                qBatchStatus,-->
<!--                                lovManufactureStatus,-->
<!--                                batch_status_list,-->
<!--                                data_reqs,-->
<!--                            }, null, 2)-->
<!--                        }}-->
<!--                    </pre>-->

<!--            <pre class="col-lg-4" style="display: block">{{-->
<!--                    JSON.stringify({-->
<!--                        isCheckAllRequests,-->
<!--                        isSelectAllBatchStatus,-->
<!--                        isSelectAllProcessStatus,-->
<!--                        qReqNo,-->
<!--                        qItemCode,-->
<!--                        qItemDesc,-->
<!--                        qBlendNo,-->
<!--                        qStartDate,-->
<!--                        qEndDate,-->
<!--                        qProcessStatus,-->
<!--                        qBatchStatus,-->
<!--                        isDisableStatusCheckBox,-->
<!--                    }, null, 2)-->
<!--                }}-->
<!--                    </pre>-->

<!--            <pre class="col-lg-4" style="display: block">{{-->
<!--                    JSON.stringify({-->
<!--                        reqs-->
<!--                    }, null, 2)-->
<!--                }}-->
<!--                    </pre>-->
<!--        </div>-->
    </div>
</template>
<script>

import {
    isInRange,
    jsDateToString,
    toJSDate,
    toThDateString
} from '../../dateUtils'
import {DateTime} from 'luxon';

import {
    showLoadingDialog,
    showSaveSuccessDialog,
    showSaveFailureDialog,
} from "../../commonDialogs"
import _get from 'lodash/get'
import _isEmpty from 'lodash/isEmpty'

const STATUS_1 = 'แก้ไขข้อมูล/ปรับปรุง'
const STATUS_2 = 'กำลังผลิต'
const STATUS_3 = 'ยกเลิกคำสั่งผลิต'
const STATUS_5 = 'ปิดคำสั่งการผลิต'
const ORG_M12 = 'M12-NOTUSE' // ใฟ้ M12 เช็เหมือนๆ Org อื่นๆ

const BATCH_CLOSED_STATUS = 'Closed'

import {
    $route,
    api_pm_0038_productDetail,
    api_pm_0038_cancelCloseJob,
} from "../../router"

function toDateFormatString(d) {
    let month = `${d.getMonth() + 1}`
    let date = `${d.getDate()}`
    return `${d.getFullYear()}-${month.padStart(2, '0')}-${date.padStart(2, '0')}`
}

export default {
    props: {
        btn_trans: {type: Object},
        default_data: {type: Object},
        // data_reqs: {type: Array},
        batch_status_list: {type: Array},
        init_filter: {},
        lov_manufacture_status: {type: Array},
        lov_request_number: {type: Array},
        lov_item: {type: Array},
        item_code: {type: String},
        item_desc: {type: String},
        blend_no: {type: String},
        index_url: {type: String},
    },
    data() {
        return {
            DateTime,
            console,
            isInRange,
            jsDateToString,
            toJSDate,
            toThDateString,
            luxon: {
                DateTime,
            },
            lodash: {
                get: _get,
                isEmpty: _isEmpty,
            },
            toDateFormatString,

            organization: this.default_data.organization_code,
            loadingData: false,

            // reqs: this.data_reqs,
            data_reqs: [],
            reqs: [],
            checkedRequests: [],
            isCheckAllRequests: false,

            // filter date
            currentDate: DateTime.now().toISODate(),
            initStartDate: this.init_filter.biweekly[0]['start_date'],
            initEndDate: this.init_filter.biweekly[0]['end_date'],

            // lov
            // lovManufactureStatus: this.lov_manufacture_status,
            // lovRequestNumberLst: this.lov_request_number,
            // lovRequestNumber: this.lov_request_number,
            // lovItemLst: this.lov_item,
            // lovItem: this.lov_item,
            lovManufactureStatus: this.lov_manufacture_status,
            lovRequestNumberLst: [],
            lovRequestNumber: [],
            lovItemLst: [],
            lovItem: [],

            // query params
            qReqNo: '',
            qItemCode: '',
            qItemDesc: '',
            qBlendNo: '',
            qStartDate: this.initStartDate,
            qEndDate: this.initEndDate,
            qProcessStatus: {
                status1: false,
                status2: false,
                status3: false,
                status4: false,
            },
            qBatchStatus: [],
            isSelectAllProcessStatus: false,
            isSelectAllBatchStatus: false,
            isDisableStatusCheckBox: false,
            isDisableProcessStatusCheckBox: false,
            listOfCheckProcessStatus: [],
            isDisableCheckAll: true,

            productLineSearching: false,
            productLineDetails: [],
        }
    },
    mounted() {
        this.qStartDate = toDateFormatString(new Date(this.initStartDate))
        this.qEndDate = toDateFormatString(new Date(this.initEndDate))
        // this.reqs = this.filterEndDate(this.filterStartDate(this.data_reqs))
        // this.initFilter()
        this.initData();
    },
    computed: {
        colSpanNo() {
            if (this.organization !== ORG_M12) {
                return 3
            } else {
                return 4
            }
        }
    },
    watch: {
        reqs: function () {

            if (this.reqs === null || this.reqs.length === 0) {
                this.isDisableCheckAll = true
                return
            }

            let currentReqs = this.reqs
            let ableToCloseJob = []
            let ableToCancelCloseJob = []

            if (this.organization === ORG_M12) {
                ableToCloseJob.push(currentReqs.filter(item => item.request_status === STATUS_2 &&
                    item.wip_flag === '1' &&
                    item.check_flag === '1' &&
                    item.issue_flag === '1' &&
                    item.complete_flag === '1'))
            } else {
                ableToCloseJob.push(currentReqs.filter(item => item.request_status === STATUS_2 &&
                    item.wip_flag === '1' &&
                    item.issue_flag === '1' &&
                    item.complete_flag === '1'))
            }

            ableToCancelCloseJob.push(currentReqs.filter(item => item.batch_status === BATCH_CLOSED_STATUS));

            // console.log('ableToCloseJob', ableToCloseJob, ableToCancelCloseJob)

            this.isDisableCheckAll = (ableToCloseJob[0].length === 0 ? true : false) && (ableToCancelCloseJob[0].length === 0 ? true : false)

            return

        },
        qReqNo: function () {
            if (this.qReqNo === '') {
                this.initFilter()
                this.isDisableStatusCheckBox = false
                if (this.qItemCode !== '') {
                    let filterQreqNo = this.lovRequestNumber.filter(item => item.item_code === this.qItemCode)
                    this.lovRequestNumber = filterQreqNo
                }
            }
        },
        qItemCode: function () {
            if (this.qItemCode === '' || this.qItemCode === null) {
                this.qItemDesc = ''
                this.qBlendNo = ''
                this.qReqNo = ''
                this.initFilter()
            }
        },
        qBatchStatus: function () {
            if ((this.qBatchStatus.length === 1 && this.qBatchStatus.some(item => item === STATUS_2)) ||
                ((this.qBatchStatus.length === 0))) {
                this.isDisableProcessStatusCheckBox = false
            } else {
                this.isDisableProcessStatusCheckBox = true
                this.isSelectAllProcessStatus = false
                this.selectAllProcessStatus()
            }

            if (this.qBatchStatus.length == 4) {
                this.isSelectAllBatchStatus = true
                this.isDisableProcessStatusCheckBox = true
                this.isSelectAllProcessStatus = false
                this.selectAllProcessStatus()
            } else {
                this.isSelectAllBatchStatus = false
            }
        },
    },
    methods: {
        async initData() {
            let vm = this;
            let data = new Promise(async (resolve, reject) => {
                vm.loadingData = true;
                let params = {
                    action: 'search',
                    request_number: this.qReqNo,
                    item_code: this.qItemCode,
                    start_creation_date: this.qStartDate,
                    end_creation_date: this.qEndDate
                }
                await axios.get(this.index_url, { params }).then(res => {
                    // console.log('=================', res.data);
                    // vm.lovRequestNumber = res.data.lov_request_number;
                    // vm.lovItem = res.data.lov_item;

                    // reqs: this.data_reqs;
                    vm.data_reqs = res.data.data_reqs;
                    // vm.lovManufactureStatus = res.data.lov_manufacture_status;
                    vm.lovRequestNumberLst = res.data.lov_request_number;
                    vm.lovItemLst = res.data.lov_item;

                });

                vm.reqs = await this.filterEndDate(this.filterStartDate(this.data_reqs))
                await vm.initFilter();
                vm.loadingData = false;
                resolve(true)
            })
            // console.log('s', this.reqs);
            await data;
            // console.log('e', this.reqs);
        },
        initFilter() {
            this.reqs = this.filterEndDate(this.filterStartDate(this.data_reqs))

            // filtered batch no list by start date and end date
            this.lovRequestNumber = this.lovRequestNumberLst
            let filterRequestNumber = this.lovRequestNumber.filter(item =>
                Date.parse(toDateFormatString(new Date(item.creation_date))) >= Date.parse(this.qStartDate)
                && Date.parse(toDateFormatString(new Date(item.creation_date))) <= Date.parse(this.qEndDate))
            this.lovRequestNumber = filterRequestNumber

            // filtered item code list by batch no list
            let filterItemCodes = [];
            this.lovRequestNumber.forEach(item => filterItemCodes.push(item.item_code))
            this.lovItem = this.lovItemLst
            let tempLovItem = this.lovItem.filter(item => filterItemCodes.includes(item.item_code))
            this.lovItem = tempLovItem
        },
        submitSearchForm() {
            this.isDisableStatusCheckBox = false
            this.reqs = this.data_reqs
            // console.log('beforeSearch', this.reqs)

            this.reqs = this.filterEndDate(this.filterStartDate(this.data_reqs))

            this.reqs = this.filterReqByBatchStatus(this.filterReqByProcessStatus(this.filterReqByItemCode(this.filterReqByNo(this.filterEndDate(this.filterStartDate(this.reqs))))))

            // console.log('afterSearch', this.reqs)
        },
        filterStartDate(reqs) {
            if (!this.qStartDate) return reqs

            // console.log('qStartDate', this.qStartDate)

            let start_date = (Date.parse(this.qStartDate));
            return reqs.filter(req => Date.parse(toDateFormatString(new Date(req.creation_date))) >= start_date)
        }
        ,
        filterEndDate(reqs) {
            if (!this.qEndDate) return reqs

            // console.log('qEndDate', this.qEndDate)

            let end_date = (Date.parse(this.qEndDate));
            return reqs.filter(req => Date.parse(toDateFormatString(new Date(req.creation_date))) <= end_date)
        }
        ,
        filterReqByNo(reqs) {
            if (!this.qReqNo) return reqs
            return reqs.filter(req => req.request_number === this.qReqNo)
        }
        ,
        filterReqByItemCode(reqs) {
            if (!this.qItemCode) return reqs
            return reqs.filter(req => req.item_code === this.qItemCode)
        }
        ,
        filterReqByBatchStatus(reqs) {
            if (!this.qBatchStatus || this.qBatchStatus.length === 0) return reqs
            let selectedBatchStatus = this.qBatchStatus
            let filteredReqs = reqs.filter(req => selectedBatchStatus.includes(req.request_status))
            reqs = filteredReqs
            return reqs
        }
        ,
        filterReqByProcessStatus(reqs) {
            if (!this.qProcessStatus) return reqs

            let wip_flag = this.qProcessStatus.status1 ? '1' : '0'
            let check_flag = this.qProcessStatus.status2 ? '1' : '0'
            let issue_flag = this.qProcessStatus.status3 ? '1' : '0'
            let complete_flag = this.qProcessStatus.status4 ? '1' : '0'


            if (this.organization === ORG_M12) {

                if (!this.qProcessStatus.status1 &&
                    !this.qProcessStatus.status2 &&
                    !this.qProcessStatus.status3 &&
                    !this.qProcessStatus.status4) {

                    return reqs
                }

                return reqs.filter(function (item) {
                    let valid = true;
                    if (wip_flag == 1) {
                        valid = valid && item.wip_flag == wip_flag
                    }

                    if (issue_flag == 1) {
                        valid = valid && item.issue_flag == issue_flag
                    }

                    if (check_flag == 1) {
                        valid = valid && item.check_flag == check_flag
                    }

                    if (complete_flag == 1) {
                        valid = valid && item.complete_flag == complete_flag
                    }
                    return valid;
                });

                return reqs.filter(item =>
                    item.wip_flag == wip_flag &&
                    item.check_flag == check_flag &&
                    item.issue_flag == issue_flag &&
                    item.complete_flag == complete_flag)

            } else {

                if (!this.qProcessStatus.status1 &&
                    !this.qProcessStatus.status3 &&
                    !this.qProcessStatus.status4) {

                    return reqs
                }

                return reqs.filter(function (item) {
                    let valid = true;
                    if (wip_flag == 1) {
                        valid = valid && item.wip_flag == wip_flag
                    }

                    if (issue_flag == 1) {
                        valid = valid && item.issue_flag == issue_flag
                    }

                    if (complete_flag == 1) {
                        valid = valid && item.complete_flag == complete_flag
                    }
                    return valid;
                });


                return reqs.filter(item =>
                    item.wip_flag === wip_flag &&
                    item.issue_flag === issue_flag &&
                    item.complete_flag === complete_flag)
            }
        }
        ,
        clearSearchForm() {
            this.qReqNo = ''
            this.qItemCode = ''
            this.qItemDesc = ''
            this.qBlendNo = ''
            this.qReqBatchStatus = ''
            this.qReqBatchStatusCode = ''
            this.isSelectAllProcessStatus = false
            this.isSelectAllBatchStatus = false
            this.qBatchStatus = []
            this.qProcessStatus.status1 = false
            this.qProcessStatus.status2 = false
            this.qProcessStatus.status3 = false
            this.qProcessStatus.status4 = false
            this.qStartDate = toDateFormatString(new Date(this.initStartDate))
            this.qEndDate = toDateFormatString(new Date(this.initEndDate))
            this.reqs = this.filterEndDate(this.filterStartDate(this.data_reqs))
            this.initFilter()
        }
        ,
        onChgReqNo() {
            if (this.qReqNo !== null && this.qReqNo !== '') {
                this.isDisableStatusCheckBox = true
                this.qBatchStatus = []
                this.qProcessStatus.status1 = false
                this.qProcessStatus.status2 = false
                this.qProcessStatus.status3 = false
                this.qProcessStatus.status4 = false
            }

            this.reqs = this.filterEndDate(this.filterStartDate(this.data_reqs))
            let req = this.reqs.filter(req => req.request_number === this.qReqNo)[0]
            this.qItemCode = req.item_code
            this.qItemDesc = req.item_description
            this.qBlendNo = req.blend_no
            this.lovItem = this.lovItemLst


            let filterLovItem = this.lovItem.filter(item => item.item_code === this.qItemCode)
            this.lovItem = filterLovItem
        }
        ,
        onChgItemCode() {
            if (this.qItemCode === '' || this.qItemCode === null) {
                this.qItemDesc = ''
                this.qBlendNo = ''
                this.qReqNo = ''
                this.initFilter()
            }
            this.reqs = this.filterEndDate(this.filterStartDate(this.data_reqs))
            let req = this.reqs.filter(req => req.item_code === this.qItemCode)[0]
            this.qItemCode = req.item_code
            this.qItemDesc = req.item_description
            this.qBlendNo = req.blend_no

            // console.log('item', req)
            this.qItemDesc = req.item_description
            this.qBlendNo = req.blend_no

            this.initFilter()

            let filterRequestNumberLst = this.lovRequestNumber.filter(item => item.item_code === this.qItemCode)
            this.lovRequestNumber = filterRequestNumberLst
        }
        ,
        onChgStartDate() {
            if (!this.qStartDate || !this.qEndDate) {
                return
            }

            this.lovRequestNumber = this.lovRequestNumberLst
            this.lovItem = this.lovItemLst

            this.qReqNo = ''
            this.qItemCode = ''
            this.qItemDesc = ''
            this.qBlendNo = ''

            this.initFilter()
        }
        ,
        onChgEndDate() {
            this.lovRequestNumber = this.lovRequestNumberLst
            this.lovItem = this.lovItemLst

            if (!this.qStartDate || !this.qEndDate) {
                return
            }

            this.qReqNo = ''
            this.qItemCode = ''
            this.qItemDesc = ''
            this.qBlendNo = ''
            this.initFilter()
        },
        onChgProcessStatus() {
            this.listOfCheckProcessStatus = []

            if (this.organization === ORG_M12) {
                if (this.qProcessStatus.status1) {
                    this.listOfCheckProcessStatus.push(true)
                }
                if (this.qProcessStatus.status2) {
                    this.listOfCheckProcessStatus.push(true)
                }
                if (this.qProcessStatus.status3) {
                    this.listOfCheckProcessStatus.push(true)
                }
                if (this.qProcessStatus.status4) {
                    this.listOfCheckProcessStatus.push(true)
                }

                if (this.listOfCheckProcessStatus.length == 4) {
                    this.isSelectAllProcessStatus = true
                } else {
                    this.isSelectAllProcessStatus = false
                }
            } else {
                if (this.qProcessStatus.status1) {
                    this.listOfCheckProcessStatus.push(true)
                }
                if (this.qProcessStatus.status3) {
                    this.listOfCheckProcessStatus.push(true)
                }
                if (this.qProcessStatus.status4) {
                    this.listOfCheckProcessStatus.push(true)
                }

                if (this.listOfCheckProcessStatus.length == 3) {
                    this.isSelectAllProcessStatus = true
                } else {
                    this.isSelectAllProcessStatus = false
                }
            }
        },
        getTrClass(req) {

            if (req.request_status == 'ยกเลิกคำสั่งผลิต' || req.request_status == 'ปิดคำสั่งการผลิต') {
                return 'cancel-close-order'
            } else if (req.wip_flag == 1 && req.check_flag == 1 && req.issue_flag == 1 && complete_flag.s4 == 1 && req.request_status == 'ผลิตเสร็จ') {
                return 'close-order'
            } else {
                return 'not-close-order'
            }
        }
        ,
        getColClass() {
            if (this.organization !== ORG_M12) {
                return 'hide-column'
            }
        },
        getDivClass() {
            if (this.organization !== ORG_M12) {
                return 'hide-div'
            } else {
                return 'col-md-2 pl-0'
            }
        },
        numberFormat(n) {
            // console.log('aa', n);
            if (!n) {
                return '';
            }
            return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return `${n}`.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return `${n}`.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        getBatchStatusClass(batchStatus) {

            if (batchStatus == 1 || batchStatus == STATUS_1) {
                return "bg-warning"
            }

            if (batchStatus == 2 || batchStatus == STATUS_2) {
                return "bg-success"
            }

            if (batchStatus == 3 || batchStatus == STATUS_3) {
                return "bg-danger"
            }

            if (batchStatus == 5 || batchStatus == STATUS_5) {
                return "bg-primary"
            }

            return "bg-default"
        },
        selectAllBatchStatus() {
            this.qBatchStatus = [];
            if (this.isSelectAllBatchStatus) {
                let qBatchStatusArray = []
                this.lovManufactureStatus.forEach(item => qBatchStatusArray.push(item.description))
                this.qBatchStatus = qBatchStatusArray
                return
            }
            return
        }
        ,
        selectAllProcessStatus() {
            if (this.isSelectAllProcessStatus) {
                this.qProcessStatus.status1 = true
                this.qProcessStatus.status2 = true
                this.qProcessStatus.status3 = true
                this.qProcessStatus.status4 = true
            } else {
                this.qProcessStatus.status1 = false
                this.qProcessStatus.status2 = false
                this.qProcessStatus.status3 = false
                this.qProcessStatus.status4 = false
            }
            return
        },
        isDisableCheckBox(req) {
            if (req.batch_status === BATCH_CLOSED_STATUS) {
                return false;
            }
            if (this.organization === ORG_M12 && req.request_status === 'กำลังผลิต' &&
                req.wip_flag === '1' &&
                req.check_flag === '1' &&
                req.issue_flag === '1' &&
                req.complete_flag === '1') {
                return false
            } else if (this.organization !== ORG_M12 && req.request_status === 'กำลังผลิต' &&
                req.wip_flag === '1' &&
                req.issue_flag === '1' &&
                req.complete_flag === '1') {
                return false
            } else {
                return true
            }
        },
        async checkedAll() {
            this.checkedRequests = []
            let currentReqs = this.reqs

            if (!this.isCheckAllRequests) {

                return
            }

            // ALL ORG batch ที่สามารถยกเลิก Closed
            let ableToCancelCloseJob = await currentReqs.filter(item => item.batch_status === BATCH_CLOSED_STATUS);
            // console.log('ableToCancelCloseJob', BATCH_CLOSED_STATUS);
                ableToCancelCloseJob.forEach(item => this.checkedRequests.push(item.batch_id))

            if (this.organization === ORG_M12) {
                let ableToCloseJob = await currentReqs.filter(item => item.request_status === STATUS_2 &&
                    item.wip_flag === '1' &&
                    item.check_flag === '1' &&
                    item.issue_flag === '1' &&
                    item.complete_flag === '1')

                ableToCloseJob.forEach(item => this.checkedRequests.push(item.batch_id))

                return
            } else {
                let ableToCloseJob = await currentReqs.filter(item => item.request_status === STATUS_2 &&
                    item.wip_flag === '1' &&
                    item.issue_flag === '1' &&
                    item.complete_flag === '1')

                ableToCloseJob.forEach(item => this.checkedRequests.push(item.batch_id))

                return
            }
        },
        closeJob() {
            showLoadingDialog()
            axios.put('/api/pm/0038/close-job', {
                checked_requests: this.checkedRequests
            }).then(({data}) => {

                // console.log('result data.res[0] >>', data.res[0])

                if (data.res[0].v_status === 'E') {
                    swal({
                        title: `ปิดคำสั่งไม่สำเร็จ`,
                        text: data.res[0].v_err_msg,
                        type: 'error',
                        showConfirmButton: true,
                        closeOnConfirm: true,
                        confirmButtonText: 'ปิด',
                    })
                } else {
                    showSaveSuccessDialog().then(isOk => {
                        if (isOk) {
                            window.location.reload()
                        }
                    })
                }
            }).catch(err => {
                // console.log('err', err)

                return showSaveFailureDialog();
            });
        },
        cancelCloseStatus() {
            showLoadingDialog()
            axios.put($route(api_pm_0038_cancelCloseJob), {
                checked_requests: this.checkedRequests
            }).then(({data}) => {

                // console.log('result data.res[0] >>', data.res[0])
                let vStatus = 'S';
                let vErrSsg = '';

                data.res.forEach(item => {
                    if (item.v_status === 'E') {
                        vStatus = 'E'
                        vErrSsg = vErrSsg + '\n' + item.v_err_msg;
                    }
                });

                if (vStatus === 'E') {
                    swal({
                        title: `ยกเลิกปิดคำสั่งไม่สำเร็จ`,
                        text: vErrSsg,
                        type: 'error',
                        showConfirmButton: true,
                        closeOnConfirm: true,
                        confirmButtonText: 'ปิด',
                    })
                } else {
                    showSaveSuccessDialog().then(isOk => {
                        if (isOk) {
                            window.location.reload()
                        }
                    })
                }
            }).catch(err => {
                // console.log('err', err)

                return showSaveFailureDialog();
            });
        },
        showProductLineModal(req, flagType) {
            // console.log('showProductLineModal', $route(api_pm_0038_productDetail) )
            let vm = this;
            vm.productLineSearching = true;
            vm.productLineDetails = [];
            axios.get($route(api_pm_0038_productDetail), {
                params: {
                    request_summary: req,
                    flag_type: flagType
                }
            }).then(res => {
                let data = res.data.data;
                vm.productLineDetails = data.mes_lines;
                if (vm.productLineDetails.length) {
                    $('#productLineModal .modal-body').slimscroll({
                        height: '350',
                    });
                }

            }).catch(err => {
                // console.log('err', err)

                // return showSaveFailureDialog();
            }).then(() => {
                vm.productLineSearching = false;
            });
            $('#productLineModal').modal('show');
        }
    },
}
</script>
<style>
#pm0038 th, td {
    vertical-align: middle !important;
}

#pm0038 .ibox-title {
    padding: 15px 15px 8px 15px;
}

#pm0038 .check-center {
    text-align: center;
}

#pm0038 label.hide-label {
    display: none;
}

#pm0038 th.header {
    ext-align: center;
}

#pm0038 th.hide-column {
    display: none;
}

#pm0038 td.hide-column {
    display: none;
}

#pm0038 tr.close-order td {
    background: #4ec8af;
}

#pm0038 tr.not-close-order td {
    background: #fdd790;
}

#pm0038 tr.cancel-close-order td {
    background: #e9ecef42;
}

#pm0038 #close-order {
    background: #4ec8af;
    width: 80px;
}

#pm0038 #not-close-order {
    background: #fdd790;
    width: 80px;
}

#pm0038 #cancel-close-order {
    background: #e9ecef42;
    width: 80px;
}

#pm0038 .modal-content {
    padding: 15px;
}

#pm0038 .el-select {
    display: unset;
}

#pm0038 .bg-grey {
    color: #ffffff;
    background-color: darkgrey;
}

#pm0038 .bg-brown {
    color: #ffffff;
    background-color: #A87255;
}

#pm0038 .hide-div {
    display: none;
}

#pm0038 .text-dark {
    color: #000000 !important;
}
</style>
