<!--suppress JSUnresolvedVariable -->
<template>
    <div id="pm0041">
        <div class="row d-flex justify-content-end mb-3">
            <div class="col-lg-10">
                <div class="float-right">
                    <button :class="btn_trans.reset.class" @click.prevent="clearSearchForm">
                        <i :class="btn_trans.reset.icon"></i>
                        {{ btn_trans.reset.text }}
                    </button>
                    <button :class="btn_trans.displayInfo.class" @click.prevent="submitSearchForm"><i
                        :class="btn_trans.displayInfo.icon"></i>
                        {{ btn_trans.displayInfo.text }}
                    </button>
                    <button type="button"
                            :class="btn_trans.auditCasing.class"
                            :disabled="!isRecordExamineCasingButtonEnabled"
                            data-toggle="modal"
                            data-target="#auditCasing-modal"
                    @click="onClickAuditCasingBtn()"
                    >

                        <i :class="btn_trans.auditCasing.icon"></i>
                        {{ btn_trans.auditCasing.text }}
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-sm-12 col-lg-4 align-middle">
                                <h4>ลงผลตรวจสอบสารปรุงหลังหมดอายุ</h4>
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
                                            :filter-method="filterItemMethod"
                                            placeholder="กรุณาเลือกรหัสสินค้า"
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

                                    <label class="col-md-2 col-form-label">รายละเอียด:</label>
                                    <div class="col-md-3">

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
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">สถานะตรวจสอบสารปรุง:</label>
                                    <div class="col-md-3">
                                        <el-select v-model="qExamineStatus"
                                                   placeholder="กรุณาเลือกสถานะ"
                                                   @change="onChgStatus">
                                            <el-option
                                                v-for="item in lovStatus"
                                                :key="item.status"
                                                :label="item.status"
                                                :value="item.status">
                                            </el-option>
                                        </el-select>
                                    </div>

                                    <div class="col-md-1"></div>

                                    <label class="col-md-2 col-form-label">สถานะอนุมัติวันหมดอายุใหม่:</label>
                                    <div class="col-md-3">
                                        <el-select v-model="qNewExpireStatus"
                                                   placeholder="กรุณาเลือกสถานะ">
                                            <el-option
                                                v-for="item in lovExpireDateStatus"
                                                :key="item.expire_date_status"
                                                :label="item.expire_date_status"
                                                :value="item.expire_date_status"
                                                :disabled="!isStatusOptionSelectable(qExamineStatus) && item.expire_date_status != 'แสดงทั้งหมด'">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th class="header" style="min-width: 150px;">รหัสสินค้าสำเร็จรูป</th>
                                    <th class="header" style="min-width: 250px;">รายละเอียด</th>
                                    <th class="header" style="min-width: 180px;">Lot No.</th>
                                    <th class="header" style="min-width: 120px;">ปริมาณ</th>
                                    <th class="header" style="min-width: 70px;">หน่วยนับ</th>
                                    <th class="header" style=" min-width: 120px;">วันผลิต</th>
                                    <th class="header" style=" min-width: 120px;">วันหมดอายุ</th>
                                    <th class="header" style="min-width: 120px;">สถานะตรวจสอบสารปรุง</th>
                                    <th class="header" style=" min-width: 120px;">วันหมดอายุใหม่</th>
                                    <th class="header" style="min-width: 120px;">สถานะอนุมัติวันหมดอายุใหม่</th>
                                    <th class="header" style="min-width: 120px;">วันที่อนุมัติ</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr v-for="expiredItem in expiredItemsModel">
                                    <th>
                                        <div class="check-center">
                                            <label class="label-input">
                                                <input
                                                    class="align-middle"
                                                    type="checkbox"
                                                    :disabled="(expiredItem.status === 'ผ่าน' && expiredItem.expire_date_status === 'ผ่าน') ||
                                                                (expiredItem.status === 'ผ่าน' && expiredItem.expire_date_status === 'ไม่ผ่าน') ||
                                                                (expiredItem.status === 'ผ่าน' && expiredItem.expire_date_status === 'รออนุมัติ')"
                                                    v-model="expiredItem.extra.isChecked">
                                            </label>
                                        </div>
                                    </th>
                                    <td class="col-readonly">
                                        {{ expiredItem.item_code }}
                                    </td>

                                    <td class="col-readonly">
                                        {{ expiredItem.item_description }}
                                    </td>

                                    <td class="col-readonly">
                                        {{ expiredItem.lot_number }}
                                    </td>

                                    <td class="col-readonly text-right">
                                        {{ numberFormat(expiredItem.qty) }}
                                    </td>

                                    <td class="col-readonly text-center">
                                        {{ expiredItem.unit_of_measure }}
                                    </td>

                                    <td class="col-readonly text-center">
                                        {{ toThDateString(DateTime.fromSQL(expiredItem.origination_date).toJSDate()) }}
                                    </td>

                                    <td class="col-readonly text-center">
                                        {{ toThDateString(DateTime.fromSQL(expiredItem.expire_date).toJSDate()) }}
                                    </td>

                                    <td :class="{
                                        'col-readonly': expiredItem.status !== 'ผ่าน' && expiredItem.status !== 'รอลงผล' && expiredItem.status !== 'ไม่ผ่าน',
                                        'status-active': expiredItem.status === 'ผ่าน',
                                        'status-pending': expiredItem.status === 'รอลงผล',
                                        'status-reject': expiredItem.status === 'ไม่ผ่าน',
                                        'text-center': true,
                                    }">
                                        {{ expiredItem.status }}
                                    </td>

                                    <td class="col-input-readonly text-center">
                                        <ct-datepicker
                                            v-if="(() => {
                                                return expiredItem.status === 'ผ่าน' &&
                                                    lodash._isNil(expiredItem.expire_date_status)

                                            })()"
                                            class="date-table input-field text-center"
                                            placeholder="โปรดเลือกวันที่"
                                            :value="DateTime.fromSQL(expiredItem.expire_date_new).toJSDate()"
                                            @change="(date) => {
                                                expiredItem.expire_date_new = DateTime.fromJSDate(date).toISODate()
                                            }"
                                        />
                                        <!--suppress HtmlFormInputWithoutLabel -->
                                        <input
                                            v-else
                                            class="form-control input-field"
                                            :disabled="true"
                                            :value="toThDateString(DateTime.fromSQL(expiredItem.expire_date_new).toJSDate())"
                                        />
                                    </td>

                                    <td :class="{
                                        'col-readonly': expiredItem.expire_date_status === null,
                                        'status-active': expiredItem.expire_date_status === 'ผ่าน',
                                        'status-pending': expiredItem.expire_date_status === 'รออนุมัติ',
                                        'status-reject': expiredItem.expire_date_status === 'ไม่ผ่าน',
                                        'text-center': true,
                                    }">
                                        {{ expiredItem.expire_date_status }}
                                    </td>
                                    <td class="col-readonly text-center">
                                        {{ toThDateString(DateTime.fromSQL(expiredItem.approved_date).toJSDate()) }}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->

        <div class="modal fade" id="auditCasing-modal" ref="auditCasing-modal" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title w-100 text-center">ลงผลตรวจสอบสารปรุง</h2>
                        <button ref="closeModal" type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">รหัสสินค้า</th>
                                <th scope="col">รายละเอียด</th>
                                <th scope="col">Lot No.</th>
                                <th scope="col">จำนวน</th>
                                <th scope="col">หน่วยนับ</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="checkedItem in getCheckedItems()">
                                <td> {{ checkedItem.item_code }}</td>
                                <td> {{ checkedItem.item_description }}</td>
                                <td> {{ checkedItem.lot_number }}</td>
                                <td> {{ checkedItem.qty }}</td>
                                <td> {{ checkedItem.unit_of_measure }}</td>

                            </tr>
                            </tbody>
                        </table>
                        <hr>
                        <div class="form-group row col-md-12" style="justify-content: center">
                            <label class="col-md-2 col-form-label">ระบุวันหมดอายุใหม่:</label>
                        <ct-datepicker
                            class="input-field form-control"
                            placeholder="โปรดเลือกวันที่"
                            :enableDate="date => isInRange(date, DateTime.now(), null, true)"
                            :value="toJSDate(newExpiredDate, 'yyyy-MM-dd')"
                            @change="(date) => {
                                                this.newExpiredDate = DateTime.fromJSDate(date).toISODate()
                                                console.log(newExpiredDate)
                                            }"
                        />
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button
                            type="button"
                            :class="btn_trans.notpass.class"
                            @click.prevent="onExamineRejectButtonClicked">

                            <i :class="btn_trans.notpass.icon"></i>
                            {{ btn_trans.notpass.text }}
                        </button>

                        <button
                            type="button"
                            :class="btn_trans.passAndApprove.class"
                            :disabled="this.newExpiredDate == null || this.newExpiredDate == ''"
                            @click.prevent="onExamineAcceptButtonClicked">

                            <i :class="btn_trans.passAndApprove.icon"></i>
                            {{ btn_trans.passAndApprove.text }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
<!--        <div class="form-group row">-->
<!--                    <pre class="col-lg-4" style="display: block">{{-->
<!--                            JSON.stringify({-->
<!--                                newExpiredDate,-->
<!--                                qExamineStatus,-->
<!--                                qNewExpireStatus,-->
<!--                                expiredItemsModel,-->
<!--                            }, null, 2)-->
<!--                        }}-->
<!--                    </pre>-->

<!--            <pre class="col-lg-4" style="display: block">{{-->
<!--                    JSON.stringify({expired_items}, null, 2)-->
<!--                }}-->
<!--                    </pre>-->

<!--            <pre class="col-lg-4" style="display: block">{{-->
<!--                    JSON.stringify({-->
<!--                        lovExpireDateStatus,-->
<!--                        lovStatus,-->
<!--                        qLotNo,-->
<!--                        lotLst,-->
<!--                    }, null, 2)-->
<!--                }}-->
<!--                    </pre>-->
<!--        </div>-->
    </div>
</template>
<script>

import _cloneDeep from "lodash/cloneDeep";
import _every from "lodash/every";
import _filter from "lodash/filter";
import _find from "lodash/find";
import _findIndex from "lodash/findIndex";
import _get from "lodash/get";
import _isNil from "lodash/isNil";
import _some from "lodash/some";

import {
    isInRange,
    jsDateToString,
    toJSDate,
    toThDateString
} from '../../dateUtils'
import {DateTime} from 'luxon';
import {
    $route,
    api_pm_examineCasingAfterExpiryDate_updateExamineCasing,
    api_pm_examineCasingAfterExpiryDate_updateExpirationDate,
} from "../../router";

import {instance as http} from "../httpClient";
import {
    showLoadingDialog,
    showSaveFailureDialog,
    showSaveSuccessDialog,
    showSimpleConfirmationDialog
} from "../../commonDialogs";

function updateStatus(expiredItems, isAccepted, newExpiredDate) {
    console.debug('updateStatus', expiredItems);
    console.debug('newExpiredDate', newExpiredDate);

    return http.put($route(api_pm_examineCasingAfterExpiryDate_updateExamineCasing),
        {
            is_accepted: isAccepted,
            expired_items: expiredItems,
            new_expired_date: newExpiredDate
        }
    );
}

function updateExpirationDate(expiredItems) {
    console.debug('updateExpirationDate', expiredItems);

    return http.put($route(api_pm_examineCasingAfterExpiryDate_updateExpirationDate),
        {
            expired_items: expiredItems,
        }
    );
}

function mapLine(line) {
    return {
        extra: {
            ..._get(line, 'extra', {}),
            isChecked: false,
        },
        ...line,
    }
}

export default {
    props: {
        expired_items: {
            type: Array,
            default: [],
        },
        btn_trans: {
            type: Object,
        },
        lov_status : {
            type: Array
        },
        lov_expire_date_status : {
            type: Array
        },
    },
    data() {
        return {
            console,

            //luxon
            DateTime,

            //thai date
            isInRange,
            jsDateToString,
            toJSDate,
            toThDateString,

            //lodash
            lodash: {
                _every,
                _findIndex,
                _get,
                _isNil,
                _some,
            },

            lovStatus : this.lov_status,
            lovExpireDateStatus : this.lov_expire_date_status,
            newExpiredDate: '',

            expiredItemsModel: _cloneDeep(this.expired_items).map(mapLine),
            allExpiredItemsModel: _cloneDeep(this.expired_items).map(mapLine),

            qNewExpireStatus: "แสดงทั้งหมด",
            qExamineStatus: "รอลงผล",
            qLotNo: '',
            qItemCode: '',
            dataItemLst: [],
            itemLst: [],
            dataLotLst: [],
            lotLst: [],
            qItemDesc: '',
            item_desc: '',

        }
    },
    mounted() {
        this.expired_items.forEach(expired_item => {
            let isExists = this.dataItemLst.some(item => item.item_code === expired_item.item_code)
            if (!isExists) {
                this.dataItemLst.push({
                    item_code: expired_item.item_code,
                    item_desc: expired_item.item_description,
                })
            }
        })
        this.itemLst = this.dataItemLst

        this.expired_items.forEach(expired_item => {
            let isExists = this.dataLotLst.some(item => item.lot_number === expired_item.lot_number)
            if (!isExists) {
                this.dataLotLst.push({
                    lot_number: expired_item.lot_number,
                    item_code: expired_item.item_code,
                })
            }
        })
        this.lotLst = this.dataLotLst

        if (this.qItemCode === ''){
            this.qItemDesc = ''
        }

        this.expiredItemsModel = this.filterReqByExamineStatus(this.expiredItemsModel)
    },
    watch: {
        qItemCode: function () {
            if (this.qItemCode === ''){
                this.qItemDesc = ''
                this.qLotNo = ''
                this.lotLst = this.dataLotLst
                return
            }

            this.qExamineStatus = 'แสดงทั้งหมด'
            return
        },
        qExamineStatus: function () {
            if (this.qExamineStatus === 'รอลงผล' || this.qExamineStatus === 'ไม่ผ่าน'){
                this.qNewExpireStatus = 'แสดงทั้งหมด'
            }
        },
    },
    methods: {
        onClickAuditCasingBtn(){
            this.newExpiredDate = ''
        },
        onChgStatus(){

        },
        getTdStatusClass() {

        },
        getCheckedItems() {
            return _filter(this.expiredItemsModel,
                (item) => {
                    return _get(item, 'extra.isChecked', false);
                });
        },
        onExamineAcceptButtonClicked() {
            console.debug('onExamineAcceptButtonClicked', this.$refs['auditCasing-modal']);
            // noinspection JSUnresolvedFunction
            $('#auditCasing-modal').modal('hide');

            this.processUpdateStatus(updateStatus(this.getCheckedItems(), true, this.newExpiredDate));
        },
        onExamineRejectButtonClicked() {
            console.debug('onExamineRejectButtonClicked');
            // noinspection JSUnresolvedFunction
            $('#auditCasing-modal').modal('hide');

            this.processUpdateStatus(updateStatus(this.getCheckedItems(), false, this.newExpiredDate));
        },
        async onConfirmNewExpirationDateButtonClicked() {
            console.debug('onConfirmNewExpirationDateButtonClicked');

            let isConfirm = await showSimpleConfirmationDialog('คุณต้องการยืนยันวันหมดอายุใหม่ใช่หรือไม่')
            if (!isConfirm) {
                return;
            }
            setTimeout(() => {
                showLoadingDialog();
            }, 100);

            return updateExpirationDate(this.getCheckedItems())
                .then((result) => {
                    console.debug('updateExpirationDate success', result);

                    let updatedItems = result.data.expired_items.map(mapLine);
                    this.expiredItemsModel = this.replaceItems(this.expiredItemsModel, updatedItems);
                    this.expiredItemsModel = [...this.expiredItemsModel];

                     this.allExpiredItemsModel = this.replaceItems(this.allExpiredItemsModel, updatedItems);
                     this.allExpiredItemsModel = [...this.allExpiredItemsModel];

                    this.expiredItemsModel = this.filterReqByExamineStatus(this.filterReqByNewExpireStatus(this.allExpiredItemsModel))

                    return showSaveSuccessDialog();
                })
                .catch((err) => {
                    console.debug('updateExpirationDate error', err);
                    return showSaveFailureDialog();
                });
        },
        processUpdateStatus(updateStatusRequest) {
            console.debug('processUpdateStatus', updateStatusRequest);

            showLoadingDialog();
            updateStatusRequest
                .then((result) => {
                    console.debug('processUpdateStatus success', result);
                    let updatedItems = result.data.expired_items.map(mapLine);
                    this.expiredItemsModel = this.replaceItems(this.expiredItemsModel, updatedItems);
                    this.expiredItemsModel = [...this.expiredItemsModel];

                     this.allExpiredItemsModel = this.replaceItems(this.allExpiredItemsModel, updatedItems);
                     this.allExpiredItemsModel = [...this.allExpiredItemsModel];

                    this.expiredItemsModel = this.filterReqByExamineStatus(this.allExpiredItemsModel)

                    return showSaveSuccessDialog();
                })
                .catch((err) => {
                    console.debug('processUpdateStatus error', err);
                    return showSaveFailureDialog();
                });
        },
        replaceItems(existingItems, updatedItems) {
            console.debug('replaceItems', updatedItems);
            return existingItems.map((item) => {
                let matchedItem = _find(updatedItems, (updatedItem) => {
                    return +updatedItem.expiration_id === +item.expiration_id;
                });

                if (_isNil(matchedItem)) {
                    console.debug('replaceItems existing');
                    return item;
                } else {
                    console.debug('replaceItems updated');
                    return matchedItem;
                }
            });
        },
        isStatusOptionSelectable(status) {
            let isEnabled = false

            if (this.qExamineStatus == 'แสดงทั้งหมด' || this.qExamineStatus == 'ผ่าน') {
                isEnabled = true
            }

            return isEnabled
        },
        clearSearchForm() {

            this.expired_items.forEach(expired_item => {
                let isExists = this.dataItemLst.some(item => item.item_code === expired_item.item_code)
                if (!isExists) {
                    this.dataItemLst.push({
                        item_code: expired_item.item_code,
                        item_desc: expired_item.item_description,
                    })
                }
            })
            this.itemLst = this.dataItemLst

            this.expired_items.forEach(expired_item => {
                let isExists = this.dataLotLst.some(item => item.lot_number === expired_item.lot_number)
                if (!isExists) {
                    this.dataLotLst.push({
                        lot_number: expired_item.lot_number,
                        item_code: expired_item.item_code,
                    })
                }
            })
            this.lotLst = this.dataLotLst


            this.qNewExpireStatus = ''
            this.qExamineStatus = "รอลงผล"
            this.qNewExpireStatus = "แสดงทั้งหมด"
            this.qItemCode = ''
            this.qItemDesc = ''
            this.qLotNo = ''
            this.lotLst = this.dataLotLst
            this.expiredItemsModel = this.filterReqByExamineStatus(this.allExpiredItemsModel)
        },
        submitSearchForm() {
            this.expiredItemsModel = this.filterReqByLot(this.filterReqByItemCode(this.filterReqByNewExpireStatus(this.filterReqByExamineStatus(this.allExpiredItemsModel))))
        },
        filterReqByExamineStatus(reqs) {
            if (!this.qExamineStatus || this.qExamineStatus === 'แสดงทั้งหมด') return reqs
            return reqs.filter(req => req.status === this.qExamineStatus)
        },
        filterReqByNewExpireStatus(reqs) {
            if (!this.qNewExpireStatus || this.qNewExpireStatus === 'แสดงทั้งหมด') return reqs
            return reqs.filter(req => req.expire_date_status === this.qNewExpireStatus)
        },
        filterReqByItemCode(reqs) {
            if (!this.qItemCode) return reqs
            return reqs.filter(req => req.item_code === this.qItemCode)
        },
        filterReqByLot(reqs) {
            if (!this.qLotNo) return reqs
            return reqs.filter(req => req.lot_number === this.qLotNo)
        },
        onChgItemCode() {
            let item = this.itemLst.filter(item => item.item_code === this.qItemCode)[0]
            this.qItemDesc = item.item_desc

            this.qLotNo = ''
            this.lotLst = this.dataLotLst
            let filteredLot = this.lotLst.filter(item => item.item_code === this.qItemCode)
            this.lotLst = filteredLot
        },
        filterItemMethod(query) {
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
        numberFormat(n) {
            return `${n}`.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
    },
    computed: {
        isRecordExamineCasingButtonEnabled() {
            let checkedItems = this.getCheckedItems();
            if (checkedItems.length === 0) {
                return false;
            }

            return _every(checkedItems, (item) => {
                return _isNil(item.status) || item.status === 'รอลงผล' || item.status === 'ไม่ผ่าน';
            });
        },
        isConfirmNewExpirationDateButtonEnabled() {
            let checkedItems = this.getCheckedItems();
            if (checkedItems.length === 0) {
                return false;
            }

            return _every(checkedItems, (item) => {
                return item.status === 'ผ่าน' &&
                    item.expire_date_status !== 'รออนุมัติ' &&
                    !_isNil(item.expire_date_new);
            });
        },
    },
}
</script>

<style>
#pm0041 .el-select {
    width: 100%
}pm

#pm0041 .check-center {
    text-align: center;
}

#pm0041 th.header {
    text-align: center;
}

#pm0041 .col-readonly {
    background: #e9ecef42;
}

#pm0041 td.status-active {
    background: #81c784;
}

#pm0041 td.status-pending {
    background: #ffd54f;
}

#pm0041 td.status-reject {
    background: #e57373;
}

#pm0041 input.form-control.input-field:focus {
    outline: 1px solid #1ab394;
}

#pm0041 .col-lg-4.modal-audit-casing {
    padding: 0;
}

#pm0041 .modal-dialog {
    padding-top: 0;
}

/*disable input in table*/

#pm0041 .col-input-readonly {
    background: #e9ecef42;
    padding: 0px;
}

#pm0041 input.form-control.input-field {
    border: 0;
    height: 50px;
    text-align: center;
    font-size: unset;
}

#pm0041 .form-control:disabled, .form-control[readonly] {
    background: #e9ecef42;
}

/************************/


/*date picker in table*/

#pm0041 .date-table .mx-datepicker {
    padding-top: 0px;
    height: 50px;
    width: 150px;
}

#pm0041 .date-table .mx-datepicker .mx-input-wrapper input {
    height: 50px;
    text-align: center;
    padding-right: 10px;
    font-size: unset;
}

#pm0041 .date-table .mx-datepicker .mx-input-wrapper .mx-icon-calendar {
    padding-right: 8px;
}

#pm0041 .date-table .mx-datepicker .mx-input-wrapper:hover .mx-icon-clear {
    padding-right: 8px;
}

/************************/

</style>




