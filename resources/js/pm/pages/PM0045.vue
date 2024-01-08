<template>
    <div>
        <div class="row d-flex justify-content-end mb-3">
            <div class="col-lg-10">
                <div class="float-right">
                    <button type="button" :class="btn_trans.search.class" data-toggle="modal"
                            data-target="#searchModal"><i :class="btn_trans.search.icon"></i>
                        {{ btn_trans.search.text }}
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
                                <h4>ลงผลตรวจสอบหลังผลิต</h4>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>คำสั่งผลิต</th>
                                    <th style="min-width: 150px;">รหัสสินค้าสำเร็จรูป</th>
                                    <th style="min-width: 250px;">รายละเอียด</th>
                                    <th>จำนวน</th>
                                    <th>หน่วย</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="col-readonly">{{ row.request_number }}</td>
                                    <td class="col-readonly">{{ row.item_code }}</td>
                                    <td class="col-readonly">{{ row.item_description }}</td>
                                    <td class="col-readonly">{{ row.product_qty }}</td>
                                    <td class="col-readonly">{{ row.request_uom }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <div class="form-group row pl-3">
                                    <label class="col-lg-1 col-sm-4 col-form-label">วันที่ผลิต:</label>
                                    <div class="col-lg-2 pl-0">
                                        <!-- <input type="date" class="form-control" v-model="row.creation_date" :disabled="true"> -->

                                        <input
                                            class="form-control"
                                            type="text"
                                            :value="(()=>{
                                                return toThDateString(toJSDate(row.creation_date,'yyyy-MM-dd'))
                                            })()"
                                            readonly
                                            disabled>

                                    </div>
                                    <label class="col-lg-1 col-sm-4 col-form-label">วันหมดอายุ:</label>
                                    <div class="col-lg-2 pl-0">
                                        <!-- <input type="date" class="form-control" v-model="exp" :disabled="isDisable"> -->


                                        <ct-datepicker
                                            v-if="!IsDisableExpDate"
                                            class="form-control my-1"
                                            placeholder="โปรดระบุวันหมดอายุใหม่"
                                            :enableDate="date => isInRange(date, toJSDate(row.creation_date), null, true)"
                                            :value="toJSDate(exp, 'yyyy-MM-dd')"
                                            @change="(date) => {
                                                    if(date){
                                                        this.exp = jsDateToString(date)
                                                        this.checkRequest.new_expire_date = this.exp
                                                    }
                                                }"
                                        />

                                        <!--suppress HtmlFormInputWithoutLabel -->
                                        <input
                                            v-else
                                            class="form-control"
                                            type="text"
                                            :value="(()=>{
                                                    return toThDateString(luxon.DateTime.fromSQL(row.expire_date).toJSDate())


                                                })()"
                                            readonly
                                            disabled>

                                    </div>
                                </div>
                                <div class="row d-flex align-items-center mt-4">
                                    <div class="col-lg-12">
                                        <div class="btn-center">
                                            <button type="button" @click="cancelRequest"
                                                    :class="btn_trans.cancelExamined.class"
                                                    :disabled="isDisableCancelBtn">
                                                <i :class="btn_trans.cancelExamined.icon"></i>
                                                {{ btn_trans.cancelExamined.text }}
                                            </button>
                                            <button type="button" @click="approveRequest" :class="btn_trans.pass.class"
                                                    :disabled="isDisablePassNotPassBtn">
                                                <i :class="btn_trans.pass.icon"></i>
                                                {{ btn_trans.pass.text }}
                                            </button>
                                            <button type="button" @click="rejectRequest"
                                                    :class="btn_trans.notpass.class"
                                                    :disabled="isDisablePassNotPassBtn">
                                                <i :class="btn_trans.notpass.icon"></i>
                                                {{ btn_trans.notpass.text }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- modal search-->
        <div class="modal fade" id="searchModal" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ค้นหา</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-header" style="display:none;">
                        <h5 class="modal-title"></h5>
                        <button ref="closeModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">เลขที่คำสั่งผลิต</label>
                                <div class="col-md-2" style="margin-left: -50px;">
                                    <el-select
                                        v-model="qRequestNumber"
                                        clearable
                                        filterable
                                        remote
                                        placeholder="เลือกเลขที่คำสั่งผลิต"
                                        :loading="false"
                                        style="width: 100%;">
                                        <el-option
                                            v-for="requestNumber in requestNumbers"
                                            :key="requestNumber"
                                            :label="requestNumber"
                                            :value="requestNumber">
                                        </el-option>
                                    </el-select>
                                </div>
                                <label class="col-md-2 pl-5 col-form-label">สินค้าที่ผลิต</label>
                                <div class="col-md-2" style="margin-left: -50px;">
                                    <el-select
                                        v-model="qItemCode"
                                        clearable
                                        filterable
                                        :filter-method="filterMethod"
                                        placeholder="เลือกสินค้าที่ผลิต"
                                        style="width: 100%;">
                                        <el-option
                                            v-for="option in options"
                                            :key="option.item_code"
                                            :label="option.item_code"
                                            :value="option.item_code">
                                            <span>{{ option.item_code }}</span> :
                                            <span>{{ option.item_description }}</span>
                                        </el-option>
                                    </el-select>
                                </div>


                                <label class="col-md-2 pl-5 col-form-label">สถานะ</label>
                                <div class="col-md-3" style="margin-left: -50px;">
                                    <el-select
                                        placeholder="กรุณาเลือกสถานะ"
                                        class="m-b"
                                        name="status"
                                        v-model="qStatus"
                                        style="width: 100%;">

                                        <el-option
                                            key="status-view-all"
                                            value=""
                                            label="ทั้งหมด"/>

                                        <el-option
                                            key="status-examined"
                                            value="examined"
                                            label="ลงผลตรวตสอบหลังผลิตแล้ว"/>

                                        <el-option
                                            key="status-notExamined"
                                            value="notExamined"
                                            label="ยังไม่ลงผลตรวจสอบหลังผลิต"/>
                                    </el-select>
                                </div>


                            </div>


                            <div class="form-group row">
                                <label class="col-md-2 col-form-label">วันที่เริ่มผลิต</label>
                                <div class="col-md-2" style="margin-left: -50px;">
                                    <!-- <input type="date" class="form-control" v-model="qDateFrom"> -->
                                    <!-- <ct-datepicker
                                        placeholder="โปรดเลือกวันที่"
                                        @open="datePickerCustom.onUiFrameChange"
                                        @calendar-change="datePickerCustom.onUiFrameChange"
                                        @panel-change="datePickerCustom.onUiFrameChange"
                                        :formatter="datePickerCustom.formatter"
                                        :lang="datePickerCustom.lang"
                                        v-model="qDateFrom"/> -->
                                    <ct-datepicker
                                        class="form-control"
                                        placeholder="โปรดเลือกวันที่"
                                        :value="toJSDate(qDateFrom, 'yyyy-MM-dd')"
                                        @change="(date) => {
                                                        if(date){
                                                            qDateFrom = jsDateToString(date)
                                                        }else{
                                                            qDateFrom = null
                                                        }
                                                    }"
                                        style="width: 100%;"/>
                                </div>
                                <label class="col-md-2 pl-5 col-form-label">ถึง</label>
                                <div class="col-md-2" style="margin-left: -50px;">
                                    <!-- <input type="date" class="form-control" v-model="qDateTo" :min="qDateFrom"> -->
                                    <ct-datepicker
                                        class="form-control"
                                        placeholder="โปรดเลือกวันที่"
                                        :value="toJSDate(qDateTo, 'yyyy-MM-dd')"
                                        :enableDate="date => isInRange(date, toJSDate(qDateFrom), null, true)"
                                        @change="(date) => {
                                                    if(date){
                                                        qDateTo = jsDateToString(date)
                                                    }else{
                                                        qDateTo = null
                                                    }
                                                }"
                                        style="width: 100%;"/>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-end mb-3">
                                <div class="col-lg-12">
                                    <div class="float-right">
                                        <button type="button" :class="btn_trans.reset.class"
                                                @click.prevent="clearSearchForm">
                                            <i :class="btn_trans.reset.icon"></i>
                                            {{ btn_trans.reset.text }}
                                        </button>
                                        <button type="button" :class="btn_trans.search.class"
                                                @click.prevent="submitSearchForm">
                                            <i :class="btn_trans.search.icon"></i>
                                            {{ btn_trans.search.text }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <hr>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">เลขที่คำสั่งผลิต</th>
                                <th scope="col">สินค้าที่ผลิต</th>
                                <th scope="col">รายละเอียด</th>
                                <th scope="col">จำนวนที่ผลิต</th>
                                <th scope="col">หน่วยนับ</th>
                                <th scope="col">วันที่เริ่มผลิต</th>
                                <th scope="col">สถานะ</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(result,index) in results" :key="index" @click="getReqData(index)"
                                ref="closeModal" data-dismiss="modal" aria-label="Close">
                                <td>{{ result.request_number }}</td>
                                <td>{{ result.item_code }}</td>
                                <td>{{ result.item_description }}</td>
                                <td>{{ result.product_qty }}</td>
                                <td>{{ result.request_uom }}</td>
                                <td>
                                    <input
                                        type="text"
                                        class="form-control-plaintext"
                                        :disabled="true"
                                        :value="toThDateString(toJSDate(result.creation_date, 'yyyy-MM-dd'))"/>
                                </td>
                                <td>{{ getStatus(result.check_flag) }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
<!--        <div class="form-group row">-->
<!--                    <pre class="col-lg-4" style="display: block">{{-->
<!--                            JSON.stringify({-->
<!--                                qDateFrom,-->
<!--                                row,-->
<!--                            }, null, 2)-->
<!--                        }}-->
<!--                     </pre>-->

<!--            <pre class="col-lg-4" style="display: block">{{-->
<!--                    JSON.stringify({-->
<!--                        qDateTo,-->
<!--                        checkRequest-->
<!--                    }, null, 2)-->
<!--                }}-->
<!--                                </pre>-->

<!--            <pre class="col-lg-4" style="display: block">{{-->
<!--                    JSON.stringify({-->
<!--                        qStatus,-->
<!--                        exp,-->
<!--                        requests-->

<!--                    }, null, 2)-->
<!--                }}-->
<!--                                </pre>-->
<!--        </div>-->
    </div>

</template>
<script>
import DatePicker from 'vue2-datepicker'
import {isInRange, jsDateToString, toJSDate, toThDateString} from '../../dateUtils'
import {DateTime} from 'luxon'
import {instance as http} from "../httpClient";
import {
    showLoadingDialog,
    showSimpleConfirmationDialog,
    showValidationFailedDialog,
    showSaveSuccessDialog,
    showGenericFailureDialog,
    showRemoveLineConfirmationDialog,
    showSaveFailureDialog,
} from "../../commonDialogs"

import {
    $route,
    api_pm_examineAfterManufactured_approveRequest,
    api_pm_examineAfterManufactured_cancelRequest,
} from "../../router"

function UpdateApproveRequest(checkedRequest) {

    return http.put($route('api.pm.examine-after-manufactured.approveRequest'),
        {
            checked_request: checkedRequest,
        }
    );
}

function UpdateCancelRequest(checkedRequest) {

    return http.put($route('api.pm.examine-after-manufactured.cancelRequest'),
        {
            checked_request: checkedRequest,
        }
    );
}

export default {
    props: {
        btn_trans: {type: Object},
        requests: {type: Array},
    },
    components: {'ct-datepicker-th': DatePicker,},
    data() {
        return {
            luxon: {DateTime},
            isInRange,
            jsDateToString,
            toJSDate,
            toThDateString,
            row: [],
            checkRequest: [],
            exp: '',
            qRequestNumber: '',
            qItemCode: '',
            qStatus: 'notExamined',
            qDateFrom: '',
            qDateTo: '',
            items: [],
            results: [],
            options: this.requests,
        }
    },
    computed: {
        isDisable() {
            return this.row.length == 0
        },
        isDisableCancelBtn() {
            if (this.row.length != 0 && this.row.check_flag == 1) {
                return false
            }
            return true
        },
        isDisablePassNotPassBtn() {
            if (this.row.length != 0 && this.row.check_flag == 0) {
                return false
            }
            return true
        },
        IsDisableExpDate() {

            if (this.row.length != 0 && this.row.check_flag == 0) {
                return false
            }
            return true
        },
        requestNumbers() {
            let requestNumbers = []
            if (this.qItemCode) {
                let reqs = this.requests.filter(request => request.item_code == this.qItemCode)
                requestNumbers = [...new Set(reqs.map(request => request.request_number))]
            } else {
                requestNumbers = [...new Set(this.requests.map(request => request.request_number))]
            }
            return requestNumbers.sort()
        },
    },
    methods: {
        // labelDecorator(...args){
        //     customSelectDropDownLabelDecorator.apply(this, args)
        // },
        filterMethod(query) {
            if (query !== '') {
                this.options = this.requests.filter(request => {
                    return request.item_code.toLowerCase().indexOf(query.toLowerCase()) > -1 || request.item_description.toLowerCase().indexOf(query.toLowerCase()) > -1
                })
            } else {
                this.options = this.requests
            }
        },
        clearSearchForm() {
            this.qRequestNumber = ''
            this.qItemCode = ''
            this.qDateFrom = null
            this.qDateTo = null
            this.qStatus = 'notExamined'
        },
        submitSearchForm() {
            this.results = []
            this.results = this.filterByStatus(this.filterByReqNo(this.filterByItemCd(this.filterByDateFrom(this.filterByDateTo(this.requests)))))
        },
        filterByReqNo(requests) {
            if (!this.qRequestNumber) return requests
            return requests.filter(request => request.request_number == this.qRequestNumber)
        },
        filterByItemCd(requests) {
            if (!this.qItemCode) return requests
            return requests.filter(request => request.item_code == this.qItemCode)
        },
        filterByDateFrom(requests) {
            if (!this.qDateFrom) return requests
            return requests.filter(request => new Date(request.creation_date).getTime() >= new Date(this.qDateFrom).getTime())
        },
        filterByDateTo(requests) {
            if (!this.qDateTo) return requests
            return requests.filter(request => new Date(request.creation_date).getTime() <= new Date(this.qDateTo).getTime())
        },
        filterByStatus(requests) {
            if (!this.qStatus) return requests
            if (this.qStatus == "examined") {
                return requests.filter(request => request.check_flag == 1)
            }

            if (this.qStatus == "notExamined") {
                return requests.filter(request => request.check_flag == 0)
            }

            return requests
        },
        getReqData(idx) {
            // $('#searchModal').close()
            this.row = this.results[idx]
            this.checkRequest = this.row

            let creationDate = new Date(this.row.creation_date)
            let y = creationDate.getFullYear() + 1
            let d = this.row.creation_date.split('-')

            if (this.row.expire_date) {
                this.exp = this.row.expire_date
            } else {
                this.exp = y + '-' + d[1] + '-' + d[2]
            }

            this.checkRequest['new_expire_date'] = this.exp;

        },
        getStatus(check_flag) {
            if (check_flag == 0) {
                return "ยังไม่ลงผลตรวจสอบหลังผลิต"
            }
            return "ลงผลตรวจสอบหลังผลิตแล้ว"
        },
        async saveRequest() {

            let pass = await showSimpleConfirmationDialog('ยืนยันการทำรายการ')
            if (pass) {
                showLoadingDialog()

                axios.put('/api/pm/0045/' + this.row.request_process_id, {
                    exp: this.exp
                }).then(response => {
                    if (response.status == 200) {
                        console.log(response)
                        showSaveSuccessDialog().then(isOk => {
                            if (isOk) {
                                window.location.reload()
                            }
                        })
                    }
                }).catch(error => {
                    console.log(error)
                })
            }
        },
        async approveRequest() {

            let pass = await showSimpleConfirmationDialog('ยืนยันการทำรายการ')
            if (pass) {
                //showLoadingDialog()
                // axios.put('/api/pm/0045/' + this.row.request_process_id, {
                //     exp: this.exp
                // }).then(response => {
                //     if (response.status == 200) {
                //         console.log(response)
                //         showSaveSuccessDialog().then(isOk => {
                //             if (isOk) {
                //                 window.location.reload()
                //             }
                //         })
                //     }
                // }).catch(error => {
                //     console.log(error)
                // })
                ///

                setTimeout(() => {
                    //workaround for bootstrap sweetalert
                    showLoadingDialog();
                }, 100);

                UpdateApproveRequest(this.checkRequest)
                    .then(response => {
                        console.log('UpdateApproveRequest Success', response)
                        if (response.status === 200) {
                            showSaveSuccessDialog()

                            console.log('before_updated_row', this.row)
                            console.log('before_updated_row', this.requests)

                            this.row = response.data.updated_row[0]
                            // this.row.expire_date = response.data.updated_row[0].expire_date
                            // this.row.check_flag = response.data.updated_row[0].check_flag
                            this.requests = response.data.updated_requests
                            this.results = []

                            console.log('updated_row', response.data.updated_row)
                            console.log('updated_row', response.data.updated_requests)

                        }
                    }).catch(error => {
                    console.log('UpdateApproveRequest Error', error)
                    return showSaveFailureDialog();
                })
            }
        },
        async cancelRequest() {

            let pass = await showSimpleConfirmationDialog('ยืนยันการทำรายการ')
            if (pass) {

                setTimeout(() => {
                    //workaround for bootstrap sweetalert
                    showLoadingDialog();
                }, 100);

                UpdateCancelRequest(this.checkRequest)
                    .then(response => {
                        console.log('UpdateCancelRequest Success', response)
                        if (response.status === 200) {
                            showSaveSuccessDialog()

                            console.log('before_updated_row', this.row)
                            console.log('before_updated_row', this.requests)

                            this.row = response.data.updated_row[0]
                            this.requests = response.data.updated_requests
                            this.results = []

                            console.log('updated_row', response.data.updated_row)
                            console.log('updated_row', response.data.updated_requests)

                        }
                    }).catch(error => {
                    console.log('UpdateCancelRequest Error', error)
                    return showSaveFailureDialog();
                })
            }
        },
        async rejectRequest() {
            let notPass = await showSimpleConfirmationDialog('ยืนยันการทำรายการ')
            if (notPass) {
                window.location.reload()
            }
        },
    }
}
</script>

<style scoped>
.mx-datepicker {
    width: inherit !important;
}

th {
    text-align: center;
}

.col-readonly {
    background: #e9ecef42 !important;
}

label.col-lg-1.col-form-label {
    padding: 7px;
}

.btn-center {
    text-align: center;
}

label.col-lg-2.col-sm-6.col-form-label {
    padding: 7px;
}
</style>
