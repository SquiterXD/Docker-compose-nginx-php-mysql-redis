<!--suppress JSUnresolvedVariable -->
<template>
    <div>
<!--        <div class="form-group row">-->
<!--            <pre class="col-lg-6" style="display: block">{{-->
<!--                    JSON.stringify({-->
<!--                        init_jobs, init_job_summary, selectedJob, productDate,-->
<!--                    }, null, 2)-->
<!--                }}-->
<!--            </pre>-->

<!--            <pre class="col-lg-6" style="display: block">{{-->
<!--                    JSON.stringify({-->
<!--                        init_opts, selectedOpt, selectedWip, jobHeaderLines,-->
<!--                    }, null, 2)-->
<!--                }}-->
<!--            </pre>-->
<!--        </div>-->

        <!--detail-->
        <div class="row">
            <div class="col">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label
                                        for="input-production-order-no"
                                        class="col-lg-2 col-form-label">
                                        เลขที่คำสั่งผลิต
                                    </label>

                                    <div class="col-lg-6">
                                        <input
                                            id="input-production-order-no"
                                            type="text"
                                            class="form-control"
                                            disabled="disabled"
                                            v-model="selectedJob.batch_no"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label
                                        class="col-lg-2 col-form-label"
                                        for="input-finished-product-code">
                                        รหัสสินค้าสำเร็จรูป
                                    </label>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <input
                                                    id="input-finished-product-code"
                                                    type="text"
                                                    class="form-control"
                                                    disabled="disabled"
                                                    v-model="init_job_summary.item_number"/>
                                            </div>
                                            <div class="col-lg-6">
                                                <!--suppress HtmlFormInputWithoutLabel -->
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    disabled="disabled"
                                                    v-model="init_job_summary.item_desc"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label
                                        class="col-lg-2 col-form-label"
                                        for="input-blend-no">
                                        Blend No.
                                    </label>
                                    <div class="col-lg-6">
                                        <input
                                            id="input-blend-no"
                                            type="text"
                                            class="form-control"
                                            disabled="disabled"
                                            v-model="init_job_summary.blend_no"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label
                                        class="col-lg-2 col-form-label"
                                        for="input-finished-good-produced-date">
                                        วันที่ได้ผลผลิต <span style="color:red">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <input
                                            id="input-finished-good-produced-date"
                                            class="form-control"
                                            type="date"
                                            @change="onProductDateChanged($event)"
                                            v-model="productDate"
                                            :max="currentDate"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label
                                        class="col-lg-2 col-form-label">
                                        OPT<span style="color:red">*</span>
                                    </label>
                                    <div class="col-lg-6">
                                        <!--suppress RequiredAttributes -->
                                        <el-select
                                            id="select-opt"
                                            v-model="selectedOpt"
                                            @change="onOptChanged($event)">

                                            <el-option
                                                v-for="opt in init_opts"
                                                :key="opt"
                                                :label="opt"
                                                :value="opt">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label
                                        class="col-lg-2 col-form-label"
                                        for="input-production-quantity">
                                        จำนวนที่ผลิต
                                    </label>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <input
                                                    id="input-production-quantity"
                                                    type="text"
                                                    class="form-control"
                                                    disabled="disabled"
                                                    v-model="selectedJob.opt_plan_qty"/>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group row">
                                                    <label
                                                        for="input-unit"
                                                        class="col-lg-5 col-form-label">
                                                        หน่วยนับ
                                                        สถานะ </label>
                                                    <div class="col-lg-7">
                                                        <input
                                                            id="input-unit"
                                                            type="text"
                                                            class="form-control"
                                                            disabled="disabled"
                                                            v-model="selectedJob.opt_plan_uom"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label class=" col-lg-3 col-form-label">
                                        <b>
                                            ขั้นตอนการทำงาน/WIP<span style="color:red">*</span>
                                        </b>
                                    </label>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <el-select
                                                id="select-wip"
                                                value-key="oprn_class_desc"
                                                v-model="selectedWip"
                                                @change="onWipChanged($event)">

                                                <el-option
                                                    v-for="wip in selectedJob.wip_steps"
                                                    :key="wip.oprn_class_desc"
                                                    :label="wip.oprn_class_desc"
                                                    :value="wip">
                                                </el-option>
                                            </el-select>
                                        </div>
                                        <div class="col-lg-8">
                                            <!--suppress HtmlFormInputWithoutLabel -->
                                            <input
                                                type="text"
                                                class="form-control"
                                                disabled="disabled"
                                                v-model="selectedWip.oprn_desc"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table
                            class="table table-bordered"
                            v-if="!isLoading && lodash.size(jobLines) > 0">
                            <thead>
                            <tr style="text-align: center">
                                <th>วันที่ได้ผลผลิต</th>
                                <th>คงคลังเช้า</th>
                                <th>ผลผลิตที่ได้</th>
                                <th>ยืนยันยอดผลผลิต</th>
                                <th v-if="(departmentCode === DEPARTMENT_TOBACCO && selectedWip.oprn_class_desc === 'WIP01') ||
                                (departmentCode === DEPARTMENT_EXPANDED_TOBACCO && (selectedWip.oprn_class_desc === 'WIP01' || selectedWip.oprn_class_desc === 'WIP02'))">
                                    สถานะ
                                </th>
                                <th>สูญเสีย</th>
                                <th>จ่ายออก</th>
                                <th>คงคลังเย็น</th>
                                <th>หน่วยนับ</th>
                            </tr>
                            </thead>


                            <!--TODO-->
                            <tbody>
                            <tr
                                v-for="(jobLine, i) in jobLines"
                                style="text-align: center">

                                <!--วันที่ได้ผลผลิต-->
                                <td class="col-readonly">
                                    <span v-if="!lodash.isNil(jobLine.transaction_date)">
                                        {{ luxon.DateTime.fromISO(jobLine.transaction_date).toFormat('dd/MM/yyyy') }}
                                    </span>
                                </td>

                                <!--คงคลังเช้า-->
                                <td class="col-readonly">
                                    <span v-if="!lodash.isNil(jobLine.beginning_qty)">
                                        {{ jobLine.beginning_qty }}
                                    </span>
                                </td>

                                <!--ผลผลิตที่ได้-->
                                <td class="col-readonly">
                                    <span v-if="!lodash.isNil(jobLine.mes_qty)">
                                        {{ jobLine.mes_qty }}
                                    </span>
                                </td>

                                <!--ยืนยันยอดผลผลิต-->
                                <td>
                                    <!--Only first row can has value-->
                                    <span>
                                        <!--suppress HtmlFormInputWithoutLabel -->
                                        <input
                                            v-if="(i === 0 && jobLine.wip_step === 'WIP01' && departmentCode === DEPARTMENT_TOBACCO) ||
                                            (i === 0 && (jobLine.wip_step === 'WIP01' || jobLine.wip_step === 'WIP02') &&  departmentCode === DEPARTMENT_EXPANDED_TOBACCO)"
                                            id="input-confirm-quantity"
                                            ref="input-confirm-quantity-ref"
                                            class="form-control"
                                            type="number"
                                            min="0"
                                            autocomplete="off"
                                            v-model="jobLine.confirm_qty"
                                            :disabled="!isEditing"/>
                                    </span>

                                    <span v-if="!lodash.isNil(jobLine.confirm_qty) &&
                                        (departmentCode === DEPARTMENT_TOBACCO && jobLine.wip_step === 'WIP02') ||
                                        (departmentCode === DEPARTMENT_EXPANDED_TOBACCO && jobLine.wip_step === 'WIP03')">
                                        {{ jobLine.confirm_qty }}
                                    </span>
                                </td>

                                <!--สถานะ-->
                                <td v-if="
                                (departmentCode === DEPARTMENT_TOBACCO && jobLine.wip_step === 'WIP01') ||
                                (departmentCode === DEPARTMENT_EXPANDED_TOBACCO && (jobLine.wip_step === 'WIP01' || jobLine.wip_step === 'WIP02'))">
                                    <span v-if="i === 0">
                                        <span
                                            style="color:darkgreen"
                                            v-if="jobLine.metaData.isConfirmed">
                                            ยืนยันแล้ว
                                        </span>

                                        <span
                                            style="color:red"
                                            v-if="!jobLine.metaData.isConfirmed">
                                            ยังไม่ยืนยัน
                                        </span>
                                    </span>
                                </td>

                                <!--สูญเสีย-->
                                <td class="col-readonly">
                                    <span v-if="!lodash.isNil(jobLine.lose_qty)">
                                        {{ jobLine.lose_qty }}
                                    </span>
                                </td>

                                <!--จ่ายออก-->
                                <td class="col-readonly">
                                    <!--suppress HtmlFormInputWithoutLabel -->
                                    <input
                                        v-if="(departmentCode === DEPARTMENT_EXPANDED_TOBACCO && jobLine.wip_step === 'WIP01')"
                                        id="input-issue-quantity"
                                        ref="input-issue-quantity-ref"
                                        class="form-control"
                                        type="number"
                                        min="0"
                                        autocomplete="off"
                                        v-model="jobLine.mes_issue_qty"
                                        :disabled="!isEditing"/>

                                    <span v-else-if="!lodash.isNil(jobLine.mes_issue_qty)">
                                        {{ jobLine.mes_issue_qty }}
                                    </span>
                                </td>

                                <!--คงคลังเย็น-->
                                <td class="col-readonly">
                                    <span v-if="!lodash.isNil(jobLine.ending_qty)">
                                        {{ jobLine.ending_qty }}
                                    </span>
                                </td>

                                <!--หน่วยนับ-->
                                <td class="col-readonly">
                                    <span v-if="!lodash.isNil(jobLine.uom_code)">
                                        {{ jobLine.uom_code }}
                                    </span>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                        <div
                            class="row text-center"
                            v-if="!isLoading && lodash.size(jobLines) === 0">

                            <h2 style="color: red">ไม่พบข้อมูล</h2>
                        </div>

                        <!--loading indicator-->
                        <div class="row text-center" v-if="isLoading">
                            <div class="col-lg-12">
                                <div class="sk-spinner sk-spinner-wave mb-4">
                                    <div class="sk-rect1"></div>
                                    <div class="sk-rect2"></div>
                                    <div class="sk-rect3"></div>
                                    <div class="sk-rect4"></div>
                                    <div class="sk-rect5"></div>
                                </div>
                            </div>
                        </div>

                        <!--Buttons-->
                        <div class="row text-center">
                            <div class="col-lg-12">
                                <button
                                    type="button"
                                    class="btn btn-w-m btn-warning"
                                    @click.prevent="onEditButtonClicked"
                                    :disabled="(departmentCode === DEPARTMENT_TOBACCO && selectedWip.oprn_class_desc !== 'WIP01') ||
                                    (departmentCode === DEPARTMENT_EXPANDED_TOBACCO && selectedWip.oprn_class_desc === 'WIP03')">
                                    <i class="fa fa-pencil-square-o"/>&nbsp;
                                    แก้ไข
                                </button>

                                <button
                                    type="button"
                                    class="btn btn-w-m btn-primary"
                                    @click.prevent="onSaveButtonClicked">
                                    <i class="fa fa-save (alias)"/>&nbsp;
                                    บันทึก
                                </button>

                                <button
                                    type="button"
                                    class="btn btn-w-m btn-danger"
                                    @click.prevent="onCloseButtonClicked">
                                    <i class="fa fa-times"/>&nbsp;
                                    ปิด
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import {instance as http} from "../httpClient";
import _isNil from "lodash/isNil";
import _isEqual from "lodash/isEqual";
import _cloneDeep from "lodash/cloneDeep";
import _size from "lodash/size";
import _get from "lodash/get";
import {DateTime} from 'luxon';
import {$route} from "../../router";
import {showLoadingDialog, showSaveFailureDialog} from "../../commonDialogs";
import Vue from "vue";
import {warningBeforeUnload} from "../helpers";

function gotoSelectJobs() {
    window.location = $route('pm.report-product-in-process.index');
}

function getJobLines(reviewHeaderId) {

    let queryString = {};
    queryString['reviewHeaderId'] = reviewHeaderId;

    return http.get($route('api.pm.report-product-in-process.jobLines.show'),
        {
            params: {
                'reviewHeaderId': reviewHeaderId,
            }
        });
}

function updateJobLines(jobHeaderLines) {
    return http.put($route('api.pm.report-product-in-process.jobLines.update'),
        {
            ...jobHeaderLines,
        })
}

export default {
    created() {
        //TODO save data stage
        // this.saveDataStage();

        Vue.nextTick(() => {
            this.setDefaultValue();
        });
    },
    mounted() {
        // this.setWarningBeforeUnload();
    },
    data() {
        return {
            DEPARTMENT_TOBACCO: '61000200',
            DEPARTMENT_EXPANDED_TOBACCO: '61000300',

            lodash: {
                get: _get,
                isEqual: _isEqual,
                cloneDeep: _cloneDeep,
                isNil: _isNil,
                size: _size,
            },
            luxon: {
                DateTime: DateTime,
            },

            departmentCode: this.init_job_summary.department_code,

            currentDate: DateTime.now().toFormat('yyyy-MM-dd'),
            productDate: DateTime.now().toFormat('yyyy-MM-dd'),
            isProductDateSet: false,

            selectedJob: {},
            selectedOpt: {},
            selectedWip: {},

            isLoading: true,
            isEditing: false,

            jobHeaderLines: {},
            jobLines: {},

            // use for detect and alert unsaved data todo
            dataStage: {},
        }
    },
    props: {
        init_job_summary: {
            type: Object,
            default: {},
        },
        init_jobs: {
            type: Array,
            default: [],
        },
        init_opts: {
            type: Array,
            default: [],
        },
    },
    methods: {
        saveDataStage() {
            this.dataStage.jobHeaderLines = this.lodash.cloneDeep(this.jobHeaderLines);
            //TODO
            // this.dataStage.ingredientRequest = this.lodash.cloneDeep(this.ingredientRequest);
            // this.dataStage.lines = this.lodash.cloneDeep(this.lines);
        },
        isDataStageChange() {
            console.debug('isDataStageChange', this.dataStage.lines, this.lines);
            //TODO
            // let isHeadEqual = this.lodash.isEqual(this.dataStage.ingredientRequest, this.ingredientRequest);
            // let isLinesEqual = this.lodash.isEqual(this.dataStage.lines, this.lines);
            // console.debug(isHeadEqual, isLinesEqual);
            //
            // //warning user if there is unsaved data
            // return !isHeadEqual || !isLinesEqual;
        },
        retrieveJobLines(reviewHeaderId) {
            console.debug('retrieveJobLines', reviewHeaderId);

            this.isLoading = true;
            getJobLines(reviewHeaderId)
                .then((result) => {
                    console.debug(result, result.data);
                    this.isLoading = false;

                    this.jobHeaderLines = result.data;
                    this.jobLines = this.jobHeaderLines.jobWipLines[this.selectedWip.oprn_class_desc];

                    if (!this.isProductDateSet) {
                        this.isProductDateSet = true;

                        if (!this.lodash.isNil(this.jobHeaderLines.jobHeader.product_date)) {
                            this.productDate =
                                this.luxon.DateTime.fromSQL(this.jobHeaderLines.jobHeader.product_date).toISODate();
                        } else {
                            this.productDate = this.currentDate;
                        }
                    }
                })
                .catch((err) => {
                    console.debug(err);
                    this.isLoading = false;

                    //TODO
                    // if (err.response.status === 404) {
                    //     showGenericFailureDialog('ไม่พบข้อมูลวัตถุดิบ กรุณาลองใหม่อีกครั้ง');
                    // } else {
                    //     showGenericFail
                    //     reDialog();
                    // }
                });
        },
        setDefaultValue() {
            console.debug('setDefaultValue');
            this.changeSelectedJob(this.init_opts[0]);
        },
        changeSelectedJob(opt) {
            console.debug('changeSelectedJob', opt);
            this.selectedJob = this.init_jobs.find(job => {
                return job.opt === opt;
            });

            this.selectedOpt = opt;
            this.selectedWip = this.selectedJob.wip_steps[0];

            let reviewHeaderId = this.selectedJob.review_header_id;
            this.retrieveJobLines(reviewHeaderId);
        },
        onOptChanged() {
            console.debug('onOptChanged', this.selectedOpt);
            this.changeSelectedJob(this.selectedOpt);
        },
        onWipChanged(wip) {
            console.debug('onWipChanged', wip);

            this.jobLines = this.jobHeaderLines.jobWipLines[wip.oprn_class_desc];
        },
        onProductDateChanged(event) {
            let productDate = event.target.value;
            console.debug('onProductDateChanged', productDate);

            //only applicable for expanded tobacco department
            if (this.departmentCode === this.DEPARTMENT_EXPANDED_TOBACCO) {
                let firstLine = this.jobHeaderLines.jobWipLines['WIP01'][0]

                //save is final no further edit allowed
                if (firstLine.metaData.isConfirmed === false) {
                    firstLine.transaction_date = productDate
                }
            }
        },
        onEditButtonClicked() {
            console.debug('onEditButtonClicked');
            this.isEditing = true;

            Vue.nextTick(() => {
                this.$refs['input-confirm-quantity-ref'][0].focus();
            });
        },
        onSaveButtonClicked() {
            console.debug('onSaveButtonClicked');

            showLoadingDialog();

            //update product date
            this.jobHeaderLines.jobHeader = this.lodash.cloneDeep(this.selectedJob);
            this.jobHeaderLines.jobHeader.product_date = this.productDate;

            updateJobLines(this.jobHeaderLines)
                .then((result) => {
                    console.debug(result, result.data);
                    swal.close();
                    this.isEditing = false;

                    this.jobHeaderLines = result.data;
                    this.jobLines = this.jobHeaderLines.jobWipLines[this.selectedWip.oprn_class_desc];
                })
                .catch((err) => {
                    console.debug(err);
                    swal.close();
                    this.isEditing = false;

                    showSaveFailureDialog();
                });
        },
        onCloseButtonClicked() {
            gotoSelectJobs();
        },
        setWarningBeforeUnload() {
            warningBeforeUnload(() => {
                if (this.isCreateNew) {
                    return false;
                }
                return this.isDataStageChange();
            });
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
