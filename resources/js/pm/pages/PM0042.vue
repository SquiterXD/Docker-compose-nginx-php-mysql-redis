<template>
    <div id="pm0042">
        <div class="row d-flex justify-content-end mb-3">
            <div class="col-lg-10">
                <div class="float-right">
                    <button
                        type="button"
                        :class="btn_trans.reset.class"
                        @click.prevent="clearSearchForm">
                        <i :class="btn_trans.reset.icon"></i>
                        {{ btn_trans.reset.text }}
                    </button>
                    <button
                        value="ค้นหา"
                        type="submit"
                        :disabled="!canSearch"
                        :class="btn_trans.search.class"
                        @click.prevent="submitSearchForm">
                        <i :class="btn_trans.search.icon"></i>
                        {{ btn_trans.search.text }}
                    </button>
                    <button type="button" :class="btn_trans.approve.class"
                            :disabled="checkedRequests.length === 0"
                            data-toggle="modal"
                            data-target="#detailApproveModal">
                        <i :class="btn_trans.approve.icon"></i>
                        {{ btn_trans.approve.text }}
                    </button>
                    <button type="button" :class="btn_trans.reject.class"
                            :disabled="checkedRequests.length === 0"
                            data-toggle="modal"
                            data-target="#detailRejectModal">
                        <i
                            :class="btn_trans.reject.icon"
                        ></i>
                        {{ btn_trans.reject.text }}
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <h5>อนุมัติการขอเปลี่ยนแปลงวันหมดอายุสารปรุง</h5>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">


                        <div class="row">
                            <div class="col-sm-12">

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">รหัสสินค้าสำเร็จรูป:</label>
                                    <div class="col-md-3">
                                        <el-select
                                            v-model="qItemCode"
                                            clearable
                                            filterable
                                            :filter-method="filterMethod"
                                            placeholder="กรุณาเลือกรหัสสินค้า"
                                            style="width: 100%;"
                                            @change="onChgItemCode">
                                            <el-option
                                                v-for="item in itemLst"
                                                :key="item.item_code"
                                                :label="item.item_code"
                                                :value="item.item_code">
                                                <span>{{ item.item_code }}</span> : <span>{{ item.item_desc }}</span>
                                            </el-option>
                                        </el-select>
                                    </div>

                                    <div class="col-md-1"></div>
                                    <label class="col-md-1 col-form-label">รายละเอียด:</label>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" v-model="qItemDesc" disabled>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Lot No.</label>
                                    <div class="col-md-3">
                                        <el-select
                                            v-model="qLotNo"
                                            clearable
                                            filterable
                                            :disabled="qItemCode === '' || qItemCode === null"
                                            :filter-method="filterLotMethod"
                                            placeholder="กรุณาเลือก Lot No.">
                                            <el-option
                                                v-for="item in lotLst"
                                                :key="item.lot_number"
                                                :label="item.lot_number"
                                                :value="item.lot_number">
                                                <span>{{ item.lot_number }}</span>
                                            </el-option>
                                        </el-select>
                                    </div>

                                    <div class="col-md-1"></div>
                                    <label class="col-md-1 col-form-label">วันที่ผลิต:</label>
                                    <div class="col-md-2">
                                        <ct-datepicker
                                            class="form-control"
                                            placeholder="โปรดเลือกวันที่"
                                            :value="toJSDate(qOriginateDateFrom, 'yyyy-MM-dd')"
                                            @change="(date) => {
                                                        if(date){
                                                            qOriginateDateFrom = jsDateToString(date)
                                                        }else{
                                                            qOriginateDateFrom = null
                                                        }
                                                    }"/>
                                    </div>

                                    <label class="col-md-1 col-form-label text-center">ถึง:</label>
                                    <div class="col-md-2">
                                        <ct-datepicker
                                            class="form-control"
                                            placeholder="โปรดเลือกวันที่"
                                            :value="toJSDate(qOriginateDateTo, 'yyyy-MM-dd')"
                                            :enableDate="date => isInRange(date, toJSDate(qOriginateDateFrom), null, true)"
                                            @change="(date) => {
                                                    if(date){
                                                        qOriginateDateTo = jsDateToString(date)
                                                    }else{
                                                        qOriginateDateTo = null
                                                    }
                                                }"/>
                                    </div>
                                </div>

                                <div class="form-group row">

                                    <label class="col-md-2 col-form-label">สถานะอนุมัติ:</label>
                                    <div class="col-md-3">

                                        <el-select
                                            placeholder="กรุณาเลือกสถานะ"
                                            v-model="qStatus"
                                            class="m-b"
                                            name="status"
                                            @change="(value) => {

                                            }">

                                            <el-option
                                                key="status-examine-view-all"
                                                value=""
                                                label="ทั้งหมด"/>

                                            <el-option
                                                key="status-examine-pending"
                                                value="รออนุมัติ"
                                                label="รออนุมัติ"/>

                                            <el-option
                                                key="status-examine-accept"
                                                value="ผ่าน"
                                                label="อนุมัติแล้ว"/>

                                            <el-option
                                                key="status-examine-accept"
                                                value="ไม่ผ่าน"
                                                label="ไม่อนุมัติ"/>
                                        </el-select>


                                    </div>

                                    <div class="col-md-1"></div>
                                    <label class="col-md-1 col-form-label">วันหมดอายุ(เก่า):</label>
                                    <div class="col-md-2">
                                        <ct-datepicker
                                            class="form-control"
                                            placeholder="โปรดเลือกวันที่"
                                            :value="toJSDate(qExpiredDateFrom, 'yyyy-MM-dd')"
                                            @change="(date) => {
                                                        if(date){
                                                            qExpiredDateFrom = jsDateToString(date)
                                                        }else{
                                                            qExpiredDateFrom = null
                                                        }
                                                    }"/>
                                    </div>
                                    <label class="col-md-1 col-form-label text-center">ถึง:</label>
                                    <div class="col-md-2">
                                        <ct-datepicker
                                            class="form-control"
                                            placeholder="โปรดเลือกวันที่"
                                            :value="toJSDate(qExpiredDateTo, 'yyyy-MM-dd')"
                                            :enableDate="date => isInRange(date, toJSDate(qExpiredDateFrom), null, true)"
                                            @change="(date) => {
                                                    if(date){
                                                        qExpiredDateTo = jsDateToString(date)
                                                    }else{
                                                        qExpiredDateTo = null
                                                    }
                                                }"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox-title">
                    <div class="text-right">
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th></th>
                                <th class="header">รหัสสินค้าสำเร็จรูป</th>
                                <th class="header" style="min-width: 150px;">รายละเอียด</th>
                                <th class="header">Lot No.</th>
                                <th class="header">ปริมาณ</th>
                                <th class="header">หน่วยนับ</th>
                                <th class="header">ผู้ขออนุมัติ</th>
                                <th class="header th-date">วันผลิต</th>
                                <th class="header th-date">วันหมดอายุ(เก่า)</th>
                                <th class="header th-date">วันหมดอายุ(ใหม่)</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="req in reqs" :key="req.expiration_id">
                                <th class="checkbox-line">
                                    <div class="check-center">
                                        <label class="label-input">
                                            <input
                                                class="align-middle"
                                                type="checkbox"
                                                :disabled="(req.expire_date_status === 'ผ่าน' || req.expire_date_status === 'ไม่ผ่าน')"
                                                v-model="checkedRequests"
                                                :value="req">
                                        </label>
                                    </div>
                                </th>
                                <td class="col-readonly">{{ req.item_code }}</td>
                                <td class="col-readonly">{{ req.item_description }}</td>
                                <td class="col-readonly">{{ req.lot_number }}</td>
                                <td class="col-readonly text-right">{{ numberFormat(req.qty) }}</td>
                                <td class="col-readonly text-right">{{ req.uom }}</td>
                                <td class="col-readonly text-center">{{ req.username }}</td>
                                <td class="col-readonly text-center">{{ toThDateString(req.origination_date) }}</td>
                                <td class="col-readonly text-center">{{ toThDateString(req.expire_date) }}</td>
                                <td class="p-0">
                                    <ct-datepicker
                                        v-if="(() => {
                                                return req.expire_date_status === 'รออนุมัติ'
                                            })()"
                                        class=""
                                        placeholder="โปรดระบุวันหมดอายุใหม่"
                                        :enableDate="date => isInRange(date, null, null, true)"
                                        :value="toJSDate(req.expire_date_new, 'yyyy-MM-dd')"
                                        @change="(date) => {
                                                    if(date){
                                                        req.expire_date_new = jsDateToString(date)
                                                    }else{
                                                        req.expire_date_new = req.expire_date_new
                                                    }}"
                                    />
                                    <!--suppress HtmlFormInputWithoutLabel -->
                                    <input
                                        v-else
                                        class="form-control input-field"
                                        :disabled="true"
                                        :value="toThDateString(luxon.DateTime.fromSQL(req.expire_date_new).toJSDate())"
                                    />
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div
            id="detailApproveModal"
            ref="detailApproveModalRef"
            class="modal bd-example-modal-xl fade">
            <div
                class="modal-dialog modal-lg"
                role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title w-100 text-center">ยืนยันอนุมัติ</h2>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>รหัสสินค้า</th>
                                <th>รายละเอียด</th>
                                <th>จำนวน</th>
                                <th>หน่วยนับ</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(checkedRequest) in checkedRequests">
                                <td>{{ checkedRequest.item_code }}</td>
                                <td>{{ checkedRequest.item_description }}</td>
                                <td>{{ numberFormat(checkedRequest.qty) }}</td>
                                <td>{{ checkedRequest.uom }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <hr>
                        <div class="text-center">
                            <button
                                type="button"
                                :class="btn_trans.cancel.class"
                                @click.prevent="CancelApproveRequest">
                                <i :class="btn_trans.cancel.icon"></i>
                                {{ btn_trans.cancel.text }}
                            </button>
                            <button
                                type="button"
                                :class="btn_trans.confirm.class"
                                @click.prevent="ConfirmApproveRequest">
                                <i :class="btn_trans.confirm.icon"></i>
                                {{ btn_trans.confirm.text }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            id="detailRejectModal"
            ref="detailRejectModalRef"
            class="modal bd-example-modal-xl fade">
            <div
                class="modal-dialog modal-lg"
                role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title w-100 text-center">ยืนยันไม่อนุมัติ</h2>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>รหัสสินค้า</th>
                                <th>รายละเอียด</th>
                                <th>จำนวน</th>
                                <th>หน่วยนับ</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(checkedRequest) in checkedRequests">
                                <td>{{ checkedRequest.item_code }}</td>
                                <td>{{ checkedRequest.item_description }}</td>
                                <td>{{ numberFormat(checkedRequest.qty) }}</td>
                                <td>{{ checkedRequest.uom }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <hr>
                        <div class="text-center">
                            <button
                                type="button"
                                :class="btn_trans.cancel.class"
                                @click.prevent="CancelRejectRequest">
                                <i :class="btn_trans.cancel.icon"></i>
                                {{ btn_trans.cancel.text }}
                            </button>
                            <button
                                type="button"

                                :class="btn_trans.confirm.class"
                                @click.prevent="ConfirmRejectRequest">
                                <i :class="btn_trans.confirm.icon"></i>
                                {{ btn_trans.confirm.text }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!--                <div class="form-group row">-->
<!--                    <pre class="col-lg-4" style="display: block">{{-->
<!--                            JSON.stringify({-->
<!--                                qStatus,-->
<!--                                checkedRequests,-->
<!--                            }, null, 2)-->
<!--                        }}-->
<!--                     </pre>-->

<!--                    <pre class="col-lg-4" style="display: block">{{-->
<!--                            JSON.stringify({-->
<!--                                reqs,-->
<!--                            }, null, 2)-->
<!--                        }}-->
<!--                                </pre>-->

<!--                    <pre class="col-lg-4" style="display: block">{{-->
<!--                            JSON.stringify({-->
<!--                                lotLst,-->
<!--                                allReqs-->
<!--                            }, null, 2)-->
<!--                        }}-->
<!--                                </pre>-->
<!--                </div>-->
    </div>
</template>

<script>
import {
    $route,
    pm_approvalCasingNewExpiryDate_index,
    api_pm_0042_approveRequest,
    api_pm_0042_rejectRequest
} from "../../router"

import _cloneDeep from "lodash/cloneDeep"
import _get from "lodash/get"
import {DateTime} from 'luxon';
import {toJSDate, jsDateToString, toThDateString, isInRange} from '../../dateUtils'
import {instance as http} from "../httpClient";
import {
    showLoadingDialog,
    showSaveFailureDialog,
    showSaveSuccessDialog,
    showSimpleConfirmationDialog
} from "../../commonDialogs";

function UpdateApproveRequest(checkedRequests) {
    //console.debug('checkedRequests', checkedRequests);

    return http.put($route(api_pm_0042_approveRequest),
        {
            checked_requests: checkedRequests,
        }
    );
}

function UpdateRejectRequest(checkedRequests) {
    //console.debug('checkedRequests', checkedRequests);

    return http.put($route(api_pm_0042_rejectRequest),
        {
            checked_requests: checkedRequests,
        }
    );
}

export default {
    props: ['btn_trans', 'default_data', 'data_reqs'],
    computed: {
        canSearch() {
            return true
        },
    },
    data() {
        return {
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
                cloneDeep: _cloneDeep,
            },
            item_desc: '',
            qItemCode: '',
            qItemDesc: '',
            qOriginateDateFrom: '',
            qOriginateDateTo: '',
            qExpiredDateFrom: '',
            qExpiredDateTo: '',
            reqs: this.data_reqs,
            checkedRequests: [],
            checkedRequestsItems: [],
            dataItemLst: [],
            itemLst: [],

            dataLotLst: [],
            lotLst: [],
            qLotNo: '',
            qStatus: 'รออนุมัติ',
            allReqs: this.data_reqs,

        }
    },
    mounted() {
        this.data_reqs.forEach(data_req => {
            let isExists = this.dataItemLst.some(item => item.item_code === data_req.item_code)
            if (!isExists) {
                this.dataItemLst.push({
                    item_code: data_req.item_code,
                    item_desc: data_req.item_description,
                })
            }
        })
        this.itemLst = this.dataItemLst

        this.data_reqs.forEach(data_req => {
            let isExists = this.dataLotLst.some(item => item.lot_number === data_req.lot_number)
            if (!isExists) {
                this.dataLotLst.push({
                    lot_number: data_req.lot_number,
                    item_code: data_req.item_code,
                })
            }
        })
        this.lotLst = this.dataLotLst

        this.reqs = this.filterByStatus(this.allReqs)

    },
    methods: {
        filterMethod(query) {
            if (query !== '') {
                this.itemLst = this.dataItemLst.filter(dataItem => {
                    return dataItem.item_code.toLowerCase().indexOf(query.toLowerCase()) > -1 || dataItem.item_desc.toLowerCase().indexOf(query.toLowerCase()) > -1
                })
            } else {
                this.itemLst = this.dataItemLst
            }
        },
        filterLotMethod(query) {
            if (query !== '') {
                this.lotLst = this.dataLotLst.filter(dataItem => {
                    return dataItem.lot_number.toLowerCase().indexOf(query.toLowerCase()) > -1
                })
            } else {
                this.lotLst = this.dataLotLst
            }
        },
        clearSearchForm() {
            this.qItemCode = ''
            this.qItemDesc = ''
            this.qOriginateDateFrom = ''
            this.qOriginateDateTo = ''
            this.qExpiredDateFrom = ''
            this.qExpiredDateTo = ''

            this.qLotNo = ''
            this.qStatus = 'รออนุมัติ'
            this.lotLst = this.dataLotLst

            this.reqs = this.filterByStatus(this.allReqs)
        },
        submitSearchForm() {

            this.reqs = this.filterByStatus(this.filterByLot(this.filterByExpiredDateFrom(this.filterByExpiredDateTo(this.filterByOriginationDateFrom(this.filterByOriginationDateTo(this.filterReqByItemCode(this.allReqs)))))))
        },
        filterReqByItemCode(reqs) {
            if (!this.qItemCode) return reqs
            return reqs.filter(req => req.item_code === this.qItemCode)
        },
        filterByOriginationDateFrom(reqs) {
            console.log('originationDateFrom', this.qOriginateDateFrom)
            if (!this.qOriginateDateFrom) return reqs
            return reqs.filter(req => new Date(req.origination_date).getTime() >= new Date(this.qOriginateDateFrom).getTime())
        },
        filterByOriginationDateTo(reqs) {
            console.log('originationDateTo', this.qOriginateDateTo)
            if (!this.qOriginateDateTo) return reqs
            return reqs.filter(req => new Date(req.origination_date).getTime() <= new Date(this.qOriginateDateTo).getTime())
        },
        filterByExpiredDateFrom(reqs) {

            if (!this.qExpiredDateFrom) return reqs
            return reqs.filter(req => new Date(req.expire_date).getTime() >= new Date(this.qExpiredDateFrom).getTime())
        },
        filterByExpiredDateTo(reqs) {

            if (!this.qExpiredDateTo) return reqs
            return reqs.filter(req => new Date(req.expire_date).getTime() <= new Date(this.qExpiredDateTo).getTime())
        },
        filterByLot(reqs) {
            if (!this.qLotNo) return reqs
            return reqs.filter(req => req.lot_number === this.qLotNo)
        },
        filterByStatus(reqs) {
            if (!this.qStatus) return reqs
            return reqs.filter(req => req.expire_date_status === this.qStatus)
        },
        onChgItemCode() {
            if (!this.qItemCode) {
                this.qItemDesc = ''
                return
            }
            let item = this.itemLst.filter(item => item.item_code === this.qItemCode)[0]
            this.qItemDesc = item.item_desc

            this.qLotNo = ''
            this.lotLst = this.dataLotLst
            let filteredLot = this.lotLst.filter(item => item.item_code === this.qItemCode)
            this.lotLst = filteredLot
        },
        ConfirmApproveRequest() {
            $('#detailApproveModal').modal('hide');

            showLoadingDialog();

            UpdateApproveRequest(this.checkedRequests)
                .then((result) => {
                    console.debug('processUpdateApproveRequestStatus success', result);
                    return showSaveSuccessDialog();
                })
                .then(() => {
                    window.location = $route(pm_approvalCasingNewExpiryDate_index);
                })
                .catch((err) => {
                    console.debug('processUpdateApproveRequestStatus error', err);
                    return showSaveFailureDialog();
                });
        },
        CancelApproveRequest() {
            $('#detailApproveModal').modal('hide');
        },
        ConfirmRejectRequest() {
            console.debug('checkList', this.checkedRequests);

            $('#detailRejectModal').modal('hide');

            showLoadingDialog();

            UpdateRejectRequest(this.checkedRequests)
                .then((result) => {
                    console.debug('processUpdateRejectRequestStatus success', result);
                    return showSaveSuccessDialog();
                })
                .then(() => {
                    window.location = $route(pm_approvalCasingNewExpiryDate_index);
                })
                .catch((err) => {
                    console.debug('processUpdateApproveRequestStatus error', err);
                    return showSaveFailureDialog();
                });
        },
        CancelRejectRequest() {
            $('#detailRejectModal').modal('hide');
        },
        numberFormat(n) {
            return `${n}`.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
    },
}
</script>
<style>
#pm0042 .col-readonly {
    background: #e9ecef42 !important;
}

#pm0042 .check-center {
    text-align: center;
}

#pm0042 th.header {
    text-align: center;
}

#pm0042 th.checkbox-line {
    width: 20px;
}

#pm0042 .ibox-title {
    padding: 20px;
}

/*date picker in table*/


#pm0042 .mx-datepicker {
    width: 100%
}

#pm0042 .el-select {
    width: 100%
}

#pm0042 td .mx-datepicker {
    padding-top: 0px;
    height: 50px;
}

#pm0042 td .mx-datepicker .mx-input-wrapper input {
    height: 50px;
    text-align: center;
    padding-right: 10px;
    font-size: unset;
}

#pm0042 th.th-date {
    width: 170px;
}

#pm0042 td .mx-datepicker .mx-input-wrapper .mx-icon-calendar {
    padding-right: 8px;
}

#pm0042 td .mx-datepicker .mx-input-wrapper:hover .mx-icon-clear {
    padding-right: 8px;
}

#pm0042 .el-select {
    widht: 100%
}

/*disable input in table*/

#pm0042 .col-input-readonly {
    background: #e9ecef42;
    padding: 0px;
}

#pm0042 input.form-control.input-field {
    border: 0;
    height: 50px;
    text-align: center;
    font-size: unset;
}

#pm0042 .form-control:disabled, .form-control[readonly] {
    background: #e9ecef42;
}

/************************/

/*date picker in table*/

#pm0042 td .mx-datepicker {
    padding-top: 0px;
    height: 50px;
    width: 100%;
}

#pm0042 td .mx-datepicker .mx-input-wrapper input {
    height: 50px;
    text-align: center;
    padding-right: 10px;
    font-size: unset;
}

#pm0042 td .mx-datepicker .mx-input-wrapper .mx-icon-calendar {
    padding-right: 8px;
}

#pm0042 td .mx-datepicker .mx-input-wrapper:hover .mx-icon-clear {
    padding-right: 8px;
}

/************************/

</style>
