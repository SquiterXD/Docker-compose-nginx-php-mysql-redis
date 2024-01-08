<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h3>บันทึกผลผลิตประจำวัน</h3>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group row">
                                    <label class="col-lg-2 font-weight-bold col-form-label text-right">วันที่ได้ผลผลิต:</label>
                                    <div class="col-lg-3">
                                        <ct-datepicker
                                            class="form-control my-1"
                                            style="width: 250px;"
                                            placeholder="โปรดเลือกวันที่"
                                            :enableDate="date => isInRange(date, null, toJSDate(search.to_date), true)"
                                            :value="toJSDate(search.from_date, 'yyyy-MM-dd')"
                                            @change="(date) => {
                                                search.from_date = jsDateToString(date)
                                                search = {...search}
                                            }"
                                        />
                                    </div>
                                    <label class="my-1 m-3 text-right" style="width: 25px;">ถึง:</label>
                                    <div class="col-lg-3">
                                        <ct-datepicker
                                            class="form-control my-1"
                                            style="width: 250px;"
                                            placeholder="โปรดเลือกวันที่"
                                            :enableDate="date => isInRange(date, toJSDate(search.from_date), null, true)"
                                            :value="toJSDate(search.to_date, 'yyyy-MM-dd')"
                                            @change="(date) => {
                                                search.to_date = jsDateToString(date)
                                                search = {...search}
                                            }"
                                        />
                                    </div>
                                    <div class="col-lg-2">
                                        <button 
                                            :disabled="searching"
                                            type="button" 
                                            :class="transBtn.search.class"
                                            @click.prevent="searchData()">
                                            <i :class="transBtn.search.icon"></i>
                                            {{ transBtn.search.text }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="text-align: center">

                            <hr v-if="searching">
                            <div class="lead text-center" v-if="searching">
                                กำลังค้นหา
                                <div class="sk-spinner sk-spinner-wave">
                                    <div class="sk-rect1"></div>
                                    <div class="sk-rect2"></div>
                                    <div class="sk-rect3"></div>
                                    <div class="sk-rect4"></div>
                                    <div class="sk-rect5"></div>
                                </div>
                            </div>

                            <table class="table table-bordered" v-if="!searching">
                                <thead>
                                <tr style="text-align: center">
                                    <th rowspan=2>เลขที่คำสั่งการผลิต</th>
                                    <th v-if="pOrgId != 183" rowspan=2>Blend no.</th> <!-- 183 = M03 // ยาเส้นพอง -->
                                    <th rowspan=2>รหัสสินค้าสำเร็จรูป</th>
                                    <th rowspan=2>รายการ</th>
                                    <th rowspan=2>หน่วยนับ</th>
                                    <th rowspan=2></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(header) in jobHeaders"
                                    v-bind:key='header[0].batch_no+header[0].opt' v-if="!searching">

                                    <!--เลขที่คำสั่งการผลิต-->
                                    <td>{{ header[0].batch_no }}</td>

                                    <!--Blend no.-->
                                    <td v-if="pOrgId != 183">{{ header[0].blend_no }}</td> <!-- 183 = M03 // ยาเส้นพอง -->

                                    <!--รหัสสินค้าสำเร็จรูป-->
                                    <td>{{ header[0].item_number }}</td>

                                    <!--รายการ-->
                                    <td>
                                        <span v-if="header[0].item_data">
                                            {{ header[0].item_data.item_desc }}
                                        </span>
                                    </td>

                                    <!--หน่วยนับ-->
                                    <td>
                                        <span v-if="header[0].item_data">
                                            {{ header[0].item_data.primary_unit_of_measure }}
                                        </span>
                                    </td>

                                    <td>
                                        <button
                                            class="btn btn-w-m btn-default"
                                            @click.prevent="onViewDescriptionClicked(header)">
                                            <i class="fa fa-file-text-o"></i>
                                            ยืนยันยอดผลผลิต
                                        </button>
                                    </td>
                                </tr>

                                <tr class="text-center" v-if="Object.keys(jobHeaders).length === 0">
                                    <td v-if="pOrgId == 183" colspan="5"><div style="color: red"><h3>ไม่พบข้อมูล</h3></div></td> <!-- 183 = M03 // ยาเส้นพอง -->
                                    <td v-else colspan="6"><div style="color: red"><h3>ไม่พบข้อมูล</h3></div></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- <pre>{{ jobHeaders }}</pre> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import _isEqual from "lodash/isEqual";
import _cloneDeep from "lodash/cloneDeep";
import _get from "lodash/get";
import {instance as http} from "../httpClient";
import {$route} from "../router";
import {showGenericFailureDialog, showLoadingDialog, showValidationFailedDialog} from "../../commonDialogs";
import _isNil from "lodash/isNil";
import moment from "moment";
import {isInRange, jsDateToString, toJSDate, toThDateString} from '../../dateUtils';

export default {
    props:[
        "pJobHeaders", "pFromDate", "pToDate", 'transDate', "transBtn", "url", "pOrgId"
    ],
    created() {
        Vue.nextTick(() => {
            this.setDefaultValue();
        });
    },
    mounted() {
    },
    data() {
        return {
            lodash: {
                get: _get,
                isEqual: _isEqual,
                cloneDeep: _cloneDeep,
                isNil: _isNil,
            },
            jobHeaders: _.groupBy(this.pJobHeaders, 'batch_no'),

            isInRange,
            jsDateToString,
            toJSDate,
            toThDateString,

            search: {
                from_date: null,
                to_date: null,
            },
            searching: false,

            fdate: null,
            ldate: null,
        }
    },
    methods: {
        setDefaultValue() {
            this.search.from_date = this.pFromDate;
            this.search.to_date = this.pToDate;
        },
        onViewDescriptionClicked(header) {
            console.debug('onViewDescriptionClicked', header[0].batch_no, header);

            // let joblines = header[0].job_lines;
            // if (joblines) {
            //     joblines.map((jobline, i) => {
            //         if(i == 0) {
            //             console.debug('first...', jobline.transaction_date, jobline);
            //             this.fdate = jobline.transaction_date;
            //         }
            //         if(i == joblines.length - 1) {
            //             console.debug('last...', jobline.transaction_date, jobline);
            //             this.ldate = jobline.transaction_date;
            //         }
            //     });
            // }

            let errors = [];
            if (!this.search.from_date) {
                errors.push('กรุณากรอกวันที่ได้ผลผลิตเริ่มต้น.');
            }
            if (!this.search.to_date) {
                errors.push('กรุณากรอกวันที่ได้ผลผลิตสิ้นสุด.');
            }
            if (errors.length > 0) {
                return showValidationFailedDialog(errors)
            }

            let batchNo = header[0].batch_no;
            let from_date = this.search.from_date;
            let to_date = this.search.to_date;
            // let from_date = this.search.from_date ?? this.fdate;
            // let to_date = this.search.to_date ?? this.ldate;
            // let url = this.url.wip_confirm_import_mes_data;
            // if (batchNo != '' && batchNo != undefined) {
            //     this.url.wip_confirm_import_mes_data = this.url.wip_confirm_import_mes_data.replace("-1", batchNo)
            // }

            console.debug('wip_confirm_import_mes_data', this.url.wip_confirm_import_mes_data);
            console.debug('url', this.url.wip_confirm_jobs);
            console.debug('batchNo', batchNo);
            console.debug('from_date', from_date);
            console.debug('to_date', to_date);

            showLoadingDialog();

            axios.post(this.url.wip_confirm_import_mes_data, {
                    id: batchNo,
                })
                .then((result) => {
                    console.debug('result.................');
                    console.debug(result);
                    // swal.close();

                    location.href = this.url.wip_confirm_jobs +
                        "?batch_no=" +
                        batchNo +
                        "&from_date=" +
                        from_date +
                        "&to_date=" +
                        to_date;
                })
                .catch((err) => {
                    console.debug(err.response);

                    let errorMessage = this.lodash.get(err, 'response.data.errorMessage', null);
                    if (!this.lodash.isNil(errorMessage)) {
                        showGenericFailureDialog(errorMessage);
                    } else {
                        showGenericFailureDialog();
                    }
                });
        },
        searchData() {
            let vm = this;
            let action = 'search';

            let errors = [];
            if (!vm.search.from_date) {
                errors.push('กรุณากรอกวันที่ได้ผลผลิตเริ่มต้น.');
            }
            if (!vm.search.to_date) {
                errors.push('กรุณากรอกวันที่ได้ผลผลิตสิ้นสุด.');
            }
            if (errors.length > 0) {
                return showValidationFailedDialog(errors)
            }

            this.searching = true;
            axios.get(vm.url.wip_confirm_search, {
                    params: {
                        start_date: vm.search.from_date,
                        to_date: vm.search.to_date,
                        action: action
                    }
                })
                .then(res => {
                    this.searching = false;
                    let data = res.data.data;
                    console.debug('xx', data);
                    vm.jobHeaders = _.groupBy(data.jobHeaders, 'batch_no');
                })
                .catch(err => {
                    // let data = err.response.data;
                    // alert(data.message);
                })
        },
        indexView() {
            window.location = this.url.wip_confirm_index;
        },
    },
}

</script>

<style>
th,
td {
    vertical-align: middle !important;
}

</style>
