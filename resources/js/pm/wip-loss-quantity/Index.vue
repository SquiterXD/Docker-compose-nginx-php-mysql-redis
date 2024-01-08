<template>
    <div>
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="row">
                    <div class="col-3">
                        <h3 class="no-margins"> บันทึกสูญเสีย </h3>
                    </div>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group row">
                            <label class="col-lg-2 font-weight-bold col-form-label text-right" for="lb-1">วันที่บันทึกสูญเสีย<span style="color:red">*</span>: </label>
                            <div class="col-lg-3">
                                <datepicker-th
                                    style="width: 100%"
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    name="transaction_date"
                                    id="transaction_date"
                                    placeholder="โปรดเลือกวันที่"
                                    :not-after-date="notAfterDate"
                                    :value="transactionDate"
                                    :format="transDate['js-format']"
                                    @dateWasSelected="setdate(...arguments, 'transaction_date'),onDateChanged($event)"
                                    />
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right" for="lb-2">Blend no<span style="color:red">*</span>: </label>
                            <div class="col-lg-6">
                                <el-select
                                    style="width: 100%"
                                    placeholder=""
                                    filterable
                                    clearable
                                    v-model="selectedBlendNo"
                                    @change="onBlendNoChanged($event)">
                                    <el-option
                                        v-for="headerBlendNumber in headerBlendNumbers"
                                        :key="headerBlendNumber.blend_no"
                                        :label="headerBlendNumber.blend_no"
                                        :value="headerBlendNumber.blend_no">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right" for="lb-3">เลขที่คำสั่งผลิต: </label>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" autocomplete="off" disabled="disabled" :value="batchNo">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right">จำนวนที่สูญเสีย:</label>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-6 pr-0">
                                        <input type="text" class="form-control pr-0" autocomplete="off" disabled="disabled" :value="Number(lossQty).toLocaleString()">
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="text" class="form-control" autocomplete="off" disabled="disabled" :value="uom">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right" for="lb-2">OPT.<span style="color:red">*</span>: </label>
                            <div class="col-lg-6">
                                <el-select
                                    style="width: 100%"
                                    placeholder=""
                                    filterable
                                    clearable
                                    v-model="selectedOpt"
                                    @change="onOptChanged($event)">
                                    <el-option
                                        v-for="headerOpt in headerOpts"
                                        :key="headerOpt.opt"
                                        :label="headerOpt.opt"
                                        :value="headerOpt.opt">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right" for="lb-2">รหัสวัตถุดิบ: </label>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control pr-0" autocomplete="off" disabled="disabled" :value="itemNumber">
                                    </div>
                                    <div class="col-lg-7 pl-0">
                                        <input type="text" class="form-control pr-0" autocomplete="off" disabled="disabled" :value="itemDesc">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-4 font-weight-bold col-form-label text-right" for="lb-2">ขั้นตอนการทำงาน: </label>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control pr-0" autocomplete="off" disabled="disabled" :value="wipStep">
                                    </div>
                                    <div class="col-lg-7 pl-0">
                                        <input type="text" class="form-control pr-0" autocomplete="off" disabled="disabled" :value="wipStepDesc">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table text-nowrap table-bordered"
                            v-if="isShowLines && Object.keys(jobLines).length > 0">
                        <thead>
                            <tr>
                                <th class="text-center">รายการสูญเสีย</th>
                                <th class="text-center">จำนวนสูญเสีย</th>
                                <th class="text-center">หน่วยนับ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(jobLine, i) in jobLines"
                                style="text-align: center">
                                <!--รายการสูญเสีย-->
                                <td class="col-readonly">
                                    <span v-if="isOpenFlag">
                                        <span v-if="jobLine.loss_data">
                                            {{ jobLine.loss_data.meaning }}
                                        </span>
                                        <span v-else>-</span>
                                        <!-- {{ jobLine.loss_code }} -->
                                    </span>
                                    <span v-if="!isOpenFlag && jobLine.meaning">
                                        {{ jobLine.meaning }}
                                    </span>
                                </td>
                                <!--จำนวนสูญเสีย-->
                                <td>
                                    <span v-if="isOpenFlag">
                                        <input
                                            id="input-confirm-quantity"
                                            ref="input-confirm-quantity-ref"
                                            class="form-control"
                                            type="number"
                                            min="0"
                                            autocomplete="off"
                                            v-model="jobLine.loss_qty"
                                            :disabled="!isEditing"/>
                                    </span>
                                    <span v-if="!isOpenFlag">
                                       <input
                                            id="input-confirm-quantity"
                                            ref="input-confirm-quantity-ref"
                                            class="form-control"
                                            type="number"
                                            min="0"
                                            autocomplete="off"
                                            v-model="jobLine.attribute1"
                                            />
                                    </span>
                                </td>
                                <!--หน่วยนับ-->
                                <td class="col-readonly">
                                    <span v-if="uom">
                                        {{ uom }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- <div class="text-center mb-5" v-if="!isLoading && Object.keys(jobLines).length == 0"> -->
                <div class="text-center mb-5" v-if="!isShowLines">
                    <h2 style="color: red">ไม่พบข้อมูล</h2>
                </div>

                <div class="text-center m-t" v-if="isShowLines && Object.keys(jobLines).length > 0">
                    <button
                        type="button"
                        class="btn btn-w-m btn-warning"
                        @click.prevent="onEditButtonClicked">
                        <i class="fa fa-pencil-square-o"/>&nbsp;
                        แก้ไข
                    </button>

                    <button
                        type="button"
                        class="btn btn-w-m btn-primary"
                        @click.prevent="onSaveButtonClicked"
                        :disabled="!isEditing">
                        <i class="fa fa-save (alias)"/>&nbsp;
                        บันทึก
                    </button>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

import {
    showLoadingDialog,
    showSaveFailureDialog,
    showSaveSuccessDialog,
} from "../../commonDialogs"
import _cloneDeep from "lodash/cloneDeep";
import moment from "moment";

Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(moment(String(value)).add(543, 'years').toDate()).format('DD/MM/YYYY');
    }
})

export default {
    created() {
        Vue.nextTick(() => {
            this.setDefaultValue();
        });
    },
    props:[
        "pHeaders", "url", "transBtn", "transDate"
    ],
    data() {
        return {
            lodash: {
                cloneDeep: _cloneDeep,
            },
            headers: this.pHeaders,
            headerBlendNumbers: {},
            headerOpts: {},
            selectedBlendNo: {},
            selectedOpt: {},
            selectedJob: {},
            jobHeaderLines: {},
            jobLines: {},
            lossQty: null,
            batchNo: null,
            itemNumber: null,
            itemDesc: null,
            uom: null,
            wipStep: null,
            wipStepDesc: null,
            isLoading: false,
            isEditing: false,
            isShowLines: false,
            isOpenFlag: false,
            transactionDate: moment().add(543, 'years').toDate(),
            notAfterDate: moment(moment().add(543, 'years').toDate()).format(this.transDate['js-format']),
            transactDate: null,
        }
    },
    mounted() {
        console.log('Component mounted.')
    },
    methods: {
        indexPage() {
            location.href = this.url.wip_loss_quantity_index;
        },
        async setdate(date, key) {
            let vm = this;
            vm.transactionDate = date;
        },
        setDefaultValue() {
            this.transactDate = moment(moment(this.transactionDate).subtract(543, 'years').toDate()).format('YYYY-MM-D');
            if (this.transactDate) {
                this.filterBlendNumbers(this.transactDate);
            }
        },
        onDateChanged() {
            if (this.transactionDate) {
                this.transactDate = moment(moment(this.transactionDate).subtract(543, 'years').toDate()).format('YYYY-MM-DD');
                this.filterBlendNumbers(this.transactDate);
            } else {
                this.emptyBlendNoAndOpt();
            }
        },
        filterBlendNumbers(transactDate) {
            this.headerBlendNumbers = this.headers.filter(header => {
                return header.transaction_date == transactDate;
            });
            console.debug('count.......', Object.keys(this.headerBlendNumbers).length);
            if (Object.keys(this.headerBlendNumbers).length > 0) {
                this.headerBlendNumbers = _.orderBy(this.headerBlendNumbers, 'blend_no', 'asc');
                this.selectedBlendNo = this.headerBlendNumbers[0].['blend_no'];
                if (this.selectedBlendNo) {
                    this.filterOpts(this.selectedBlendNo);
                }
            } else {
                this.emptyBlendNoAndOpt();
            }
        },
        onBlendNoChanged() {
            console.debug('onBlendNoChanged', this.selectedBlendNo);
            if (this.selectedBlendNo) {
                this.filterOpts(this.selectedBlendNo);
            } else {
                this.emptyOpt();
            }
        },
        filterOpts(blendNo) {
            console.debug('filterOpts(blendNo)', blendNo);

            this.headerOpts = this.headers.filter(header => {
                return header.blend_no == blendNo;
            });

            if (this.headerOpts) {
                this.headerOpts = _.orderBy(this.headerOpts, 'opt', 'asc');
                this.selectedOpt = this.headerOpts[0].['opt'];

                if (this.selectedOpt) {
                    this.changeSelectedJob(this.selectedOpt);
                }
            }
        },
        onOptChanged() {
            console.debug('onOptChanged', this.selectedOpt);
            if (this.selectedOpt) {
                this.changeSelectedJob(this.selectedOpt);
            } else {
                this.emptyDatas();
            }
        },
        changeSelectedJob(opt) {
            console.debug('changeSelectedJob', opt);
            this.selectedOpt = opt;
            this.selectedJob = this.headers.find(header => {
                return header.opt === opt;
            });

            if (Object.keys(this.selectedJob).length > 0) {
                this.batchNo = this.selectedJob.batch_no;
                this.lossQty = this.selectedJob.loss_qty;
                // this.itemNumber = this.selectedJob.item_data ?? this.selectedJob.item_data.item_number;
                // this.itemDesc = this.selectedJob.item_data ?? this.selectedJob.item_data.item_desc;
                // this.uom = this.selectedJob.item_data ?? this.selectedJob.item_data.primary_unit_of_measure;
                // this.wipStep = this.selectedJob.wip_steps ?? this.selectedJob.wip_steps[0].oprn_class_desc;
                // this.wipStepDesc = this.selectedJob.wip_steps ?? this.selectedJob.wip_steps[0].oprn_desc;
                this.itemNumber = this.selectedJob.item_data.item_number;
                this.itemDesc = this.selectedJob.item_data.item_desc;
                this.uom = this.selectedJob.item_data.primary_unit_of_measure;
                this.wipStep = this.selectedJob.wip_steps[0].oprn_class_desc;
                this.wipStepDesc = this.selectedJob.wip_steps[0].oprn_desc;
                this.isShowLines = true;
                this.jobLines = this.selectedJob.jobLines;
                this.isOpenFlag = this.selectedJob.open_flag == 'Y' ? true : false;
            } else {
                this.emptyDatas();
            }
        },
        emptyOpt() {
            this.headerOpts = {};
            this.selectedBlendNo = null;
            this.selectedOpt = null;
            this.selectedJob = null;
            this. emptyDatas();
        },
        emptyBlendNoAndOpt() {
            this.headerBlendNumbers = {};
            this.headerOpts = {};
            this.selectedBlendNo = null;
            this.selectedOpt = null;
            this.selectedJob = null;
            this. emptyDatas();
        },
        emptyDatas() {
            this.batchNo = null;
            this.lossQty = null;
            this.itemNumber = null;
            this.itemDesc = null;
            this.uom = null;
            this.wipStep = null;
            this.wipStepDesc = null;
            this.isShowLines = false;
            this.jobLines = {};
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

            this.jobHeaderLines.jobHeader = this.lodash.cloneDeep(this.selectedJob);
            console.debug('cloneDeep this.jobHeaderLines', this.jobHeaderLines);
            // alert('isOpenFlag..'+ this.isOpenFlag);
            // alert(this.isOpenFlag);

            let lines = this.jobHeaderLines.jobHeader.jobLines;
            let totalLossQtyFromInput = 0;
            lines.forEach(line => {
                if (this.isOpenFlag) {
                    totalLossQtyFromInput += parseInt(line.loss_qty === null ? 0 : line.loss_qty);
                } else {
                    totalLossQtyFromInput += parseInt(line.attribute1 === null ? 0 : line.attribute1);
                }
            });

            if (totalLossQtyFromInput > this.lossQty) {
                // alert('YOU COULD NOT SAVE BECAUSE SUM OF LOSSQTY IS GREATER THEN TOTAL LOSSQTY!!!!!');
                swal({
                    title: `\nมีข้อผิดพลาด`,// new line is a workaround for icon cover text
                    text: 'รายการที่ระบุไม่สามารถบันทึกเกินจำนวนสูญเสียได้',
                    type: 'error',
                    showConfirmButton: true,
                    closeOnConfirm: true,
                    confirmButtonText: 'ปิด',
                });
            } else {
                // alert('YOU COULD SAVE!!!!!');
                showLoadingDialog();

                axios.put(this.url.ajax_store, {
                        isOpenFlag: this.isOpenFlag,
                        jobHeaderLines: this.jobHeaderLines,
                    })
                    .then(result => {
                        console.debug(result, result.data);
                        this.isShowLines = true;
                        this.isEditing = false;
                        this.jobHeaderLines = result.data;
                        this.jobLines = this.jobHeaderLines.jobLines;
                        // this.jobLines = _.orderBy(this.jobHeaderLines.jobLines, 'lookup_code', 'asc');

                        showSaveSuccessDialog();
                    })
                    .catch(err => {
                        console.debug(err);
                        swal.close();
                        this.isEditing = false;

                        showSaveFailureDialog();
                    });
            }
        }

    }
}
</script>
