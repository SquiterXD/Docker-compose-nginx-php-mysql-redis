<!--suppress ALL -->
<template>
    <form @submit.prevent="onSaveButtonClicked" ref="mainForm">
        <div>
            <!--            <div class="form-group row">-->
            <!--                  <pre class="col-lg-6" style="display: block">{{-->
            <!--                          JSON.stringify({-->
            <!--                              // stampUsageDate,-->
            <!--                              // stampUsageByBrandByMachine-->
            <!--                          }, null, 2)-->
            <!--                      }}</pre>-->

            <!--                <pre class="col-lg-6" style="display: block">{{-->
            <!--                        JSON.stringify({-->
            <!--                            stampUsageByBrand-->
            <!--                        }, null, 2)-->
            <!--                    }}</pre>-->
            <!--            </div>-->

            <div class="ibox">
                <div class="ibox-content">
                     <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group  row mb-1">
                                <label class="col-sm-3 mt-2 col-form-label text-right" for="stamp-using-date">
                                    วันที่ใช้แสตมป์&nbsp;<span style="color:red">*</span>&nbsp;&nbsp;
                                </label>
                                <div class="col-sm-6">
                                    <ct-datepicker
                                        id="stamp-using-date"
                                        class="my-1 col-sm-12 form-control"
                                        name="used_date"
                                        onkeydown="return event.key != 'Enter';"
                                        style="width: 100%;"
                                        placeholder="โปรดเลือกวันที่เริ่มต้น"
                                        :value="toJSDate(stampUsageDate, 'yyyy-MM-dd')"
                                        @change="(date) => {
                                            stampUsageDate = jsDateToString(date);
                                            onStampUsageDateChange();
                                        }"
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 text-right">
                            <button
                                class="btn btn-primary"
                                :disabled="!(canSave)"
                                @click.prevent="onSaveButtonClicked">
                                <i class="fa fa-plus"></i> บันทึก
                            </button>
                            <button
                                class="btn btn-primary"
                                :disabled="!(canSave)"
                                @click.prevent="onRecordStampUsageButtonClicked">
                                <i class="fa fa-plus"></i> ตัดใช้แสตมป์
                            </button>
                        </div>
                    </div>
                </div>

                <!--******************************-->
                <!--TABLE 1-->
                <!--******************************-->
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>รายการใช้แสตมป์ตามกลุ่มราคา</h5>
                    </div>
                    <div class="ibox-content">
                        <table
                            v-if="data.stampUsageByPriceGroup.length > 0"
                            class="table table-bordered col-lg-5 text-nowrap">
                            <thead>
                            <tr>
                                <th style="text-align: center;">
                                    รหัสแสตมป์
                                </th>
                                <th style="text-align: center;">
                                    กลุ่มราคา
                                </th>
                                <th style="text-align: center;">
                                    จำนวนใช้รวม (ดวง)
                                </th>
                                <th style="text-align: center;">
                                    ผลผลิตซอง(มวน)
                                </th>
                                <th style="text-align: center;">
                                    ผลผลิตหีบ (มวน)
                                </th>
                                <th style="text-align: center;">
                                    ผลผลิตหีบ (มวน) จากซีมีรัน
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(stamp, i) in data.stampUsageByPriceGroup"
                                v-bind:key='stamp.stamp_header_id'>

                                <!--รหัสแสตมป์-->
                                <td class="col-readonly">
                                    {{ stamp.item_code2 }}
                                </td>

                                <!--กลุ่มราคา-->
                                <td class="col-readonly">
                                    {{ stamp.description2 }}
                                </td>

                                <!--จำนวนใช้รวม (ดวง)-->
                                <td class="col-readonly text-right">
                                    {{ stamp.total_used | numberFormat }}
                                </td>

                                <!-- ผลผลิตซอง(มวน) -->
                                <td class="col-readonly text-right">
                                </td>

                                <!-- ผลผลิตหีบ (มวน) -->
                                <td class="col-readonly text-right">
                                </td>

                                <!-- ผลผลิตหีบ (มวน) จากซีมีรัน -->
                                <td class="col-readonly text-right">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div
                            class="text-center"
                            v-if="data.stampUsageByPriceGroup.length === 0">
                            <span class="lead">ไม่พบข้อมูล</span>
                        </div>
                    </div>
                </div>

                <!--******************************-->
                <!--TABLE 2-->
                <!--******************************-->
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>รายการใช้แสตมป์รายตรา</h5>
                    </div>
                    <div class="ibox-content">
                        <table
                            v-if="data.stampUsageByBrand.length > 0"
                            class="table table-bordered col-lg-6 text-nowrap">
                            <thead>
                            <tr>
                                <th style="text-align: center;">
                                    ตราบุหรี่
                                </th>
                                <th style="text-align: center;">
                                    รหัสแสตมป์
                                </th>
                                <th style="text-align: center;">
                                    กลุ่มราคา
                                </th>
                                <th style="text-align: center;">
                                    จำนวนใช้รวม (ดวง)
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(stamp, i) in data.stampUsageByBrand"
                                v-bind:key='stamp.stamp_header_id'>

                                <!--ตราบุหรี่-->
                                <td class="col-readonly">
                                    {{ stamp.description1 }}
                                </td>

                                <!--รหัสแสตมป์-->
                                <td class="col-readonly">
                                    {{ stamp.item_code2 }}
                                </td>

                                <!--กลุ่มราคา-->
                                <td class="col-readonly">
                                    {{ stamp.description2 }}
                                </td>

                                <!--จำนวนใช้รวม (ดวง)-->
                                <td class="col-readonly text-right">
                                    {{ stamp.total_used | numberFormat }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div
                            class="text-center"
                            v-if="data.stampUsageByBrand.length === 0">
                            <span class="lead">ไม่พบข้อมูล</span>
                        </div>
                    </div>
                </div>

                <!--******************************-->
                <!--TABLE 3-->
                <!--******************************-->
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>รายการใช้แสตมป์รายตรารายเครื่อง</h5>
                    </div>
                    <div class="ibox-content table-responsive">
                        <table
                            v-if="data.stampUsageByBrandByMachine.length > 0"
                            class="table table-bordered text-nowrap">
                            <thead>
                            <tr>
                                <th style="text-align: center;">
                                    ชุดเครื่องจักร
                                </th>
                                <th style="text-align: center;">
                                    ตราบุหรี่
                                </th>
                                <th style="text-align: center;">
                                    รหัสแสตมป์
                                </th>
                                <th style="text-align: center;">
                                    กลุ่มราคา
                                </th>
                                <th style="text-align: center; min-width: 160px;">
                                    จำนวนที่ใช้ (ดวง) <span class="text-danger">*</span>
                                </th>
                                <th style="text-align: center; min-width: 160px;">
                                    ผลผลิต (ซอง)
                                </th>
                                <th style="text-align: center; min-width: 120px;">
                                    ส่วนต่าง
                                </th>
                                <th style="text-align: center;">
                                    คืนแสตมป์ค้าง <span class="text-danger">*</span>
                                </th>
                                <th style="text-align: center;">
                                    ไม่คืนแสตมป์ค้าง <span class="text-danger">*</span>
                                </th>
                                <th style="text-align: center; min-width: 120px;">
                                    สูญเสียจริง
                                </th>
                                <th style="text-align: center; min-width: 100px;">
                                    ชำรุด <span class="text-danger">*</span>
                                </th>
                                <th style="text-align: center;">
                                    สูญหาย <span class="text-danger">*</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <template v-for="(stamp, i, key) in data.stampUsageByBrandByMachine"
                                >
                            <tr v-bind:key='stamp.stamp_header_id'>
                                <!--ชุดเครื่องจักร-->
                                <td class="col-readonly text-center">
                                    {{ stamp.machine_group }}
                                </td>

                                <!--ตราบุหรี่-->
                                <td class="col-readonly">
                                    {{ stamp.description1 }}
                                </td>

                                <!--รหัสแสตมป์-->
                                <td class="col-readonly">
                                    {{ stamp.item_code2 }}
                                </td>

                                <!--กลุ่มราคา-->
                                <td class="col-readonly">
                                    {{ stamp.description2 }}
                                </td>

                                <!--จำนวนที่ใช้ (ดวง)-->
                                <td class="col-readonly">
                                    <!-- <input id="input-stamp-total-used"
                                           :class="validate[stamp.stamp_header_id].total_used.input_class_name + ' text-right'"
                                           type="number"
                                           @change="inputReqClassAndValidate(stamp, 'total_used')"
                                           autocomplete="off"
                                           :disabled="isDisabled(stamp)"
                                           v-model="stamp.total_used"/> -->

                                    <input id="input-stamp-total-used"
                                       :class="validate[stamp.stamp_header_id].total_used.input_class_name + ' text-right'"
                                       type="text"
                                       readonly="true"
                                       :value="numberFormat(stamp.total_used)"
                                       @change="(event) => {
                                            stamp.total_used = stripNonNumber(event.target.value);
                                            inputReqClassAndValidate(stamp, 'total_used')
                                        }"
                                       autocomplete="off"
                                       :disabled="isDisabled(stamp)"
                                       />
                                </td>

                                <!--ผลผลิต (ซอง)-->
                                <td class="col-readonly">
                                    <!-- <input id="input-stamp-actual-used"
                                           class="form-control text-right"
                                           type="number"
                                           autocomplete="off"
                                           :disabled="isDisabled(stamp) || true"
                                           v-model="stamp.actual_used"/> -->
                                    <input id="input-stamp-actual-used"
                                           class="form-control text-right"
                                           type="text"
                                           autocomplete="off"
                                           :value="numberFormat(stamp.actual_used)"
                                           disabled
                                           />
                                </td>

                                <!--ส่วนต่าง-->
                                <td class="col-readonly">
                                    <!-- <input id="input-stamp-actual-used"
                                           class="form-control text-right"
                                           type="number"
                                           autocomplete="off"
                                           :disabled="isDisabled(stamp) || true"
                                           v-model="stamp.total_loss"/> -->

                                    <input id="input-stamp-actual-used"
                                           class="form-control text-right"
                                           type="text"
                                           autocomplete="off"
                                           :disabled="isDisabled(stamp) || true"
                                           :value="numberFormat(stamp.total_used - stamp.actual_used)"
                                           />
                                </td>

                                <!--คืนแสตมป์ค้าง-->
                                <td>
                                    <!-- <input id="input-stamp-actual-used"
                                            :class="validate[stamp.stamp_header_id].return_stamp.input_class_name + ' text-right'"
                                           type="number"
                                           autocomplete="off"
                                           @change="inputReqClassAndValidate(stamp, 'return_stamp')"
                                           :disabled="isDisabled(stamp)"
                                           v-model="stamp.return_stamp"/> -->
                                    <input id="input-stamp-actual-used"
                                            :class="validate[stamp.stamp_header_id].return_stamp.input_class_name + ' text-right'"
                                           type="text"
                                           autocomplete="off"
                                           readonly="true"
                                           :value="numberFormat(stamp.return_stamp || 0)"
                                           @change="(event) => {
                                                stamp.return_stamp = stripNonNumber(event.target.value);
                                                inputReqClassAndValidate(stamp, 'return_stamp')
                                            }"
                                           :disabled="isDisabled(stamp)"
                                           />
                                </td>

                                <!--ไม่คืนแสตมป์ค้าง -->
                                <td>
                                    <!-- <input id="input-stamp-actual-used"
                                            :class="validate[stamp.stamp_header_id].repair.input_class_name + ' text-right'"
                                           type="number"
                                           autocomplete="off"
                                           @change="inputReqClassAndValidate(stamp, 'repair')"
                                           :disabled="isDisabled(stamp)"
                                           v-model="stamp.repair"/> -->
                                    <input id="input-stamp-actual-used"
                                            :class="validate[stamp.stamp_header_id].repair.input_class_name + ' text-right'"
                                           type="text"
                                           autocomplete="off"
                                           :value="numberFormat(stamp.repair || 0)"
                                           @change="(event) => {
                                                stamp.repair = stripNonNumber(event.target.value || 0);
                                                inputReqClassAndValidate(stamp, 'repair')
                                            }"
                                           :disabled="isDisabled(stamp)"
                                           />
                                </td>

                                <!--สูญเสียจริง-->
                                <td>
                                    <!-- <input id="input-stamp-actual-used"
                                           class="form-control text-right"
                                           type="number"
                                           autocomplete="off"
                                           :disabled="isDisabled(stamp) || true"
                                           v-model="stamp.actual_loss"/> -->
                                    <input id="input-stamp-actual-used"
                                           class="form-control text-right"
                                           type="text"
                                           autocomplete="off"
                                           :value="numberFormat(stamp.actual_loss || ((stamp.total_used - stamp.actual_used) - stamp.return_stamp - stamp.repair))"
                                           :disabled="isDisabled(stamp) || true"
                                           />
                                </td>

                                <!--ชำรุด-->
                                <td>
                                    <!-- <input id="input-stamp-actual-used"
                                           :class="validate[stamp.stamp_header_id].broken.input_class_name + ' text-right'"
                                           type="number"
                                           autocomplete="off"
                                           @change="inputReqClassAndValidate(stamp, 'broken')"
                                           :disabled="isDisabled(stamp)"
                                           v-model="stamp.broken"/> -->
                                    <input id="input-stamp-actual-used"
                                           :class="validate[stamp.stamp_header_id].broken.input_class_name + ' text-right'"
                                           type="text"
                                           readonly="true"
                                           autocomplete="off"
                                           :value="numberFormat(stamp.broken || 0)"
                                           @change="(event) => {
                                                stamp.broken = stripNonNumber(event.target.value || 0);
                                                inputReqClassAndValidate(stamp, 'broken')
                                            }"
                                           :disabled="isDisabled(stamp)"
                                           />
                                </td>

                                <!--สูญหาย-->
                                <td>
                                    <!-- <input id="input-stamp-actual-used"
                                           :class="validate[stamp.stamp_header_id].loss.input_class_name + ' text-right'"
                                           type="number"
                                           autocomplete="off"
                                           @change="inputReqClassAndValidate(stamp, 'loss')"
                                           :disabled="isDisabled(stamp)"
                                           v-model="stamp.loss"/> -->
                                    <input id="input-stamp-actual-used"
                                           :class="validate[stamp.stamp_header_id].loss.input_class_name + ' text-right'"
                                           type="text"
                                           autocomplete="off"
                                           :value="numberFormat(stamp.loss || ((stamp.total_used - stamp.actual_used) - stamp.return_stamp - stamp.repair) - stamp.broken)"
                                           @change="(event) => {
                                                stamp.loss = stripNonNumber(event.target.value);
                                                inputReqClassAndValidate(stamp, 'loss')
                                            }"
                                           :disabled="isDisabled(stamp)"
                                           />
                                </td>
                            </tr>
                            <transition
                                enter-active-class="animated fadeInUp"
                                leave-active-class="animated fadeOutDown">
                                <tr v-if="
                                        !(validate[stamp.stamp_header_id].total_used.valid) ||
                                        !(validate[stamp.stamp_header_id].return_stamp.valid) ||
                                        !(validate[stamp.stamp_header_id].repair.valid) ||
                                        !(validate[stamp.stamp_header_id].broken.valid) ||
                                        !(validate[stamp.stamp_header_id].loss.valid)
                                    "
                                    class="text-danger">

                                    <!--จำนวนที่ใช้ (ดวง)-->
                                    <td colspan="5" class="text-right">
                                        {{ validate[stamp.stamp_header_id].total_used.err_msg }}
                                    </td>

                                    <td colspan="2"></td>
                                    <!-- คืนแสตมป์ค้าง -->
                                    <td>
                                        {{ validate[stamp.stamp_header_id].return_stamp.err_msg }}
                                    </td>

                                    <!-- คืนแสตมป์ซ่อม -->
                                    <td>
                                        {{ validate[stamp.stamp_header_id].repair.err_msg }}
                                    </td>

                                    <td></td>
                                    <!-- ชำรุด -->
                                    <td>
                                        {{ validate[stamp.stamp_header_id].broken.err_msg }}
                                    </td>
                                    <!-- สูญหาย -->
                                    <td>
                                        {{ validate[stamp.stamp_header_id].loss.err_msg }}
                                    </td>
                                </tr>
                            </transition>
                            </template>
                            </tbody>
                        </table>
                        <div
                            class="text-center"
                            v-if="data.stampUsageByBrandByMachine.length === 0">
                            <span class="lead">ไม่พบข้อมูล</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import {isInRange, jsDateToString, toJSDate, toThDateString} from '../../dateUtils'
import {warningBeforeUnload} from "../helpers";
import {
    showProgressWithUnsavedChangesWarningDialog,
    showLoadingDialog,
    showSaveFailureDialog,
    showSaveSuccessDialog,
} from "../../commonDialogs";
import {instance as http} from "../httpClient";
import {$route} from "../../router";
import _cloneDeep from 'lodash/cloneDeep';
import _isEqual from 'lodash/isEqual';
import _get from "lodash/get";

function gotoNewPage(stampUsageDate) {
    console.debug('gotoNewPage', stampUsageDate);
    window.location = $route('pm.confirm-stamp-using.index')
        + '?' + (new URLSearchParams({'date': stampUsageDate}).toString());
}


function updateStampUsage(stampUsageByBrandByMachine, stampUsageDate) {
    console.debug(stampUsageByBrandByMachine);
    return http.put($route('api.pm.confirm-stamp-using.update-stamp-usage'),
        {
            'date': stampUsageDate,
            'stampUsageByBrandByMachine': stampUsageByBrandByMachine,
        });
}

export default {
    created() {
        this.saveDataStage();
        console.log('!! created !!')
    },
    beforeMount() {
    },
    mounted() {
        this.setWarningBeforeUnload();
        console.log('!! mounted !!')
    },
    data() {
        return {
            isInRange,
            jsDateToString,
            toJSDate,
            toThDateString,
            firstLoad: true,
            validate: this.init_validate_stamp_usage_by_brand_by_machine,
            lodash: {
                isEqual: _isEqual,
                cloneDeep: _cloneDeep,
                _get,
            },

            stampUsageDate: _cloneDeep(this.init_stamp_usage_date),

            data: {
                stampUsageByPriceGroup: _cloneDeep(this.init_stamp_usage_by_price_group),
                stampUsageByBrand: _cloneDeep(this.init_stamp_usage_by_brand),
                stampUsageByBrandByMachine: _cloneDeep(this.init_stamp_usage_by_brand_by_machine),
            },

            // use for detect and alert unsaved data
            dataStage: {},
        }
    },
    props: {
        init_stamp_usage_date: {type: String},
        init_stamp_usage_by_price_group: {
            type: Array,
            default: [],
        },
        init_stamp_usage_by_brand: {
            type: Array,
            default: [],
        },
        init_stamp_usage_by_brand_by_machine: {
            type: Array,
            default: [],
        },
        init_validate_stamp_usage_by_brand_by_machine: {
            type: Object,
            default: {},
        },
    },
    computed: {
        canSave: function () {
            // this.validate.forEach(val => {
            //     if (
            //        ( val.total_used.valid == false) ||
            //        ( val.return_stamp.valid == false) ||
            //        ( val.repair.valid == false) ||
            //        ( val.broken.valid == false) ||
            //        ( val.loss.valid == false)
            //     ) {
            //         return false;
            //     }
            //     console.log(val);
            // });
            let valid = true
            _.forEach(this.validate, function(val, key) {
                console.log(val, key);
                if (
                   ( val.total_used.valid == false) ||
                   ( val.return_stamp.valid == false) ||
                   ( val.repair.valid == false) ||
                   ( val.broken.valid == false) ||
                   ( val.loss.valid == false)
                ) {
                    valid = false;
                    return false; // exit Loop
                }
            });

            console.log('computed : canSave', valid);
            return valid;
        }
    },
    methods: {
        stripNonNumber(text) {
            let charArr = [...text];
            let numArr = [];
            for (let i = 0; i < charArr.length; i++) {
                if (isNaN(charArr[i]) === false) {
                    numArr.push(charArr[i]);
                }
            }
            return Number(numArr.join(''));
        },
        numberFormat(n) {
            return `${n}`.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        async inputReqClassAndValidate(stamp, key) {
            let valid = true;
            let index = stamp.stamp_header_id;
            let errMsg = '';
            console.log(`inputReqClassAndValidate(stamp, ${key})`
                , stamp[key]
                , stamp
            );

            let className = 'form-control ';
            let validate = '';

            if (await this.isDisabled(stamp)) {
                className = 'form-control ';
            } else {
                errMsg = '';
                // reset value
                validate = {
                    valid: true,
                    input_class_name: 'form-control ',
                    err_msg: '',
                };
                this.setValidate(index, 'total_used', validate);
                this.setValidate(index, 'return_stamp', validate);
                this.setValidate(index, 'repair', validate);
                this.setValidate(index, 'broken', validate);
                this.setValidate(index, 'loss', validate);

                let values = {
                    total_used:     parseFloat(stamp.total_used) ? parseFloat(stamp.total_used) : 0,
                    actual_used:    parseFloat(stamp.actual_used) ? parseFloat(stamp.actual_used) : 0,
                    total_loss:     0,
                    return_stamp:   parseFloat(stamp.return_stamp) ? parseFloat(stamp.return_stamp) : 0,
                    repair:         parseFloat(stamp.repair) ? parseFloat(stamp.repair) : 0,
                    actual_loss:    0,
                    broken:         parseFloat(stamp.broken) ? parseFloat(stamp.broken) : 0,
                    loss:           parseFloat(stamp.loss) ? parseFloat(stamp.loss) : 0,
                    sum_loss:       0,
                }

                // สูญเสีย
                values.total_loss   = values.total_used - values.actual_used;
                // สูญเสียจริง
                values.actual_loss  = values.total_loss - values.return_stamp - values.repair;
                values.sum_loss     = values.broken + values.loss;

                // สูญเสีย
                stamp.total_loss = values.total_loss;
                // สูญเสียจริง
                stamp.actual_loss = values.actual_loss;

                if (parseFloat(values.sum_loss) > parseFloat(stamp.actual_loss)) {
                    validate = {
                        valid: false,
                        input_class_name: 'form-control err_validate ',
                        err_msg: 'ยอดรวมชำรุด และส่วนต่าง เกินจำนวนสูญเสียจริง',
                    };

                    this.setValidate(index, 'broken', validate);
                    this.setValidate(index, 'loss', validate);
                    this.setValidate(index, 'repair', validate);
                }

                // if (stamp[key] == '') {
                //     valid = false;
                //     className = 'form-control err_validate ';
                //     errMsg = 'โปรดระบุค่า ' + key;
                // }

                if (stamp.total_used == '') {
                    this.setValidate(index, 'total_used', {
                        valid: false,
                        input_class_name: 'form-control err_validate ',
                        err_msg: 'โปรดระบุค่า จำนวนที่ใช้ (ดวง)',
                    });
                }

                if (stamp.return_stamp == '') {
                    this.setValidate(index, 'return_stamp', {
                        valid: false,
                        input_class_name: 'form-control err_validate ',
                        err_msg: 'โปรดระบุค่า คืนแสตมป์ค้าง',
                    });
                }

                if (stamp.repair == '') {
                    this.setValidate(index, 'repair', {
                        valid: false,
                        input_class_name: 'form-control err_validate ',
                        err_msg: 'โปรดระบุค่า คืนแสตมป์ซ่อม',
                    });
                }

                if (stamp.broken == '') {
                    this.setValidate(index, 'broken', {
                        valid: false,
                        input_class_name: 'form-control err_validate ',
                        err_msg: 'โปรดระบุค่า ชำรุด',
                    });
                }

                if (stamp.loss == '') {
                    this.setValidate(index, 'loss', {
                        valid: false,
                        input_class_name: 'form-control err_validate ',
                        err_msg: 'โปรดระบุค่า สูญหาย',
                    });
                }

                return;
            }

        },
        async setValidate(index, key, validate) {
             this.$set(this.validate[index], key, validate);
        },
        isDisabled(stamp) {
            return stamp.transaction_flag !== null;
        },
        onStampUsageDateChange() {
            console.debug('onStampUsageDateChange');

            if (this.isDataStageChange()) {
                showProgressWithUnsavedChangesWarningDialog()
                    .then((isConfirmed) => {
                        this.clearWarningBeforeUnload();
                        if (isConfirmed) {
                            gotoNewPage(this.stampUsageDate);
                        }
                    });
            } else {
                gotoNewPage(this.stampUsageDate);
            }
        },
        async onSaveButtonClicked() {
            console.debug('onSaveButtonClicked');

            showLoadingDialog();
            await this.updateStampUsageAsync(this.data.stampUsageByBrandByMachine)
                .then(() => {
                    return showSaveSuccessDialog();
                })
                .catch(err => {
                    console.error(err)
                    return showSaveFailureDialog();
                });
        },
        onRecordStampUsageButtonClicked() {
            console.debug('onRecordStampUsageButtonClicked');

            showLoadingDialog();
            this.updateStampUsageAsync(this.data.stampUsageByBrandByMachine)
                .then(() => {
                    //TODO call store procedure here
                })
                .then(() => {
                    return showSaveSuccessDialog();
                })
                .catch(err => {
                    console.error(err)
                    return showSaveFailureDialog();
                });
        },
        async updateStampUsageAsync(stampUsageByBrandByMachine) {
            console.debug('update', stampUsageByBrandByMachine);

            return updateStampUsage(stampUsageByBrandByMachine, this.stampUsageDate)
                .then(({data}) => {
                    this.data = data;
                    this.saveDataStage();
                });
        },
        saveDataStage() {
            this.dataStage = this.lodash.cloneDeep(this.data);
        },
        isDataStageChange() {
            console.debug('isDataStageChange', this.dataStage, this.data);

            let isEqual = this.lodash.isEqual(this.dataStage, this.data);
            console.debug(isEqual);

            //warning user if there is unsaved data
            return !isEqual;
        },
        setWarningBeforeUnload() {
            warningBeforeUnload(() => {
                return this.isDataStageChange();
            });
        },
        clearWarningBeforeUnload() {
            window.onbeforeunload = null;
        },
    },
}
</script>

<style scoped>

table td {
    position: relative;
}

table td input {
    position: absolute;
    display: block;
    top: 0;
    left: 0;
    margin: 0;
    height: 100%;
    width: 100%;
    border: none;
    padding: 10px;
    box-sizing: border-box;
}

table td db-lookup {
    position: absolute;
    display: block;
    top: 0;
    left: 0;
    margin: 0;
    height: 100%;
    width: 100%;
    border: none;
    padding: 10px;
    box-sizing: border-box;
}


.ibox-title {
    padding: 15px 20px 15px 20px;
}

.el-select {
    width: 100%;
}


.err_validate {
    background-color: #fff5f5 !important;
    border: 1px solid #ffbcbc !important;
}

</style>
