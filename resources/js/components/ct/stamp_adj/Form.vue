<template>
    <div id="submitForm">
        <el-form :model="form"
                 ref="save_data"
                 label-width="120px"
                 class="demo-dynamic form_table_line">
            <div class="row">
                <div class="col-md-4 text-right mt-2">Type<span class="text-danger">*</span></div>
                <div class="col-md-4">
                    <el-form-item :prop="'stamp_type'" :rules="rules.stamp_type">
                        <el-select
                            style="width:100%;"
                            v-model="form.stamp_type"
                            placeholder="Type"
                            filterable
                            clearable
                            remote
                            size="medium">
                            <el-option
                                v-for="(item, index) in stampTypes"
                                :key="index"
                                :label="item.description"
                                :value="item.lookup_code"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 text-right mt-2">กองทุน<span class="text-danger">*</span></div>
                <div class="col-md-4">
                    <el-form-item :prop="'fund_location'" :rules="rules.fund_location">
                        <el-input placeholder="กองทุน" v-model="form.fund_location" name="fund_location" size="medium"></el-input>
                    </el-form-item>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 text-right mt-2">% การปันส่วน<span class="text-danger">*</span></div>
                <div class="col-md-4">
                    <el-form-item :prop="'fund'" :rules="rules.fund">
                        <el-input placeholder="% การปันส่วน" v-model="form.fund" name="fund"  @input="onlyNumeric" size="medium"></el-input>
                    </el-form-item>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 text-right mt-2">DR/CR<span class="text-danger">*</span></div>
                <div class="col-md-4">
                    <el-form-item :prop="'amount_type'" :rules="rules.amount_type">
                        <el-select
                            style="width:100%;"
                            v-model="form.amount_type"
                            placeholder="DR/CR"
                            filterable
                            clearable
                            remote
                            size="medium">
                            <el-option
                                v-for="(item, index) in amountTypes"
                                :key="index"
                                :label="item.label"
                                :value="item.value"
                            >
                            </el-option>
                        </el-select>
                    </el-form-item>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 text-right mt-2">Segment<span class="text-danger">*</span></div>
                <div class="col-md-4">
                    <el-form-item :prop="'segment_code'" :rules="rules.segment_code">
                        <el-input name="segment_code" placeholder="Segments" v-model="form.segment_code" 
                            autocomplete="off"
                            style="width: 100%"
                            readonly
                            data-toggle="modal" 
                            :data-target="'#modal-create'"
                            data-backdrop="static"
                            data-keyboard="false"
                            ref="segmentOverride"
                            size="medium"
                        > </el-input>
                    </el-form-item>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 text-right mt-2">Start Date</div>
                <div class="col-md-4">
                    <el-form-item>
                        <el-date-picker 
                            v-model="form.start_date"
                            style="width: 100%;"
                            type="date"
                            placeholder="Start Date"
                            name="start_date"
                            format="dd-MM-yyyy"
                            size="medium">
                        </el-date-picker>
                    </el-form-item>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 text-right mt-2">End Date</div>
                <div class="col-md-4">
                    <el-form-item>
                        <el-date-picker 
                            v-model="form.end_date"
                            style="width: 100%;"
                            type="date"
                            placeholder="End Date"
                            name="end_date"
                            format="dd-MM-yyyy"
                            size="medium">
                        </el-date-picker>
                    </el-form-item>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-sm btn-primary" @click="clickSave">
                        <i class="fa fa-save"></i> บันทึก
                    </button>
                    <button type="button" class="btn btn-sm btn-warning" @click="closeModalCreate">
                        ยกเลิก
                    </button>
                </div>
            </div>

            <!-- Modak Create -->
            <div class="row">
                <div id="modal-create" class="modal fade" aria-hidden="true" data-backdrop="static" aria-labelledby="myModalLabel">
                    <div class="modal-dialog modal-md" style="width: 100%;">
                        <div class="modal-content">
                            <div class="modal-header">
                                
                                <h3 class="text-left mb-3 tw-text-grey-darknes"> กำหนดการปันส่วนแสตมป์ </h3>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <small class="font-bold">
                                    &nbsp;
                                </small>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4 text-right mt-2">COMPANY<span class="text-danger">*</span></div>
                                    <div class="col-md-8">
                                        <el-form-item :prop="'segment1'" :rules="rules.segment1">
                                            <el-select
                                                size="medium"
                                                style="width:100%;"
                                                v-model="form.segment1"
                                                placeholder="COMPANY"
                                                filterable
                                                clearable
                                                remote
                                                :remote-method="query => getDataListSegments(query, 'segment1')"
                                            >
                                                <el-option
                                                    v-for="(item, index) in option.segment1"
                                                    :key="index"
                                                    :label="item.meaning + ' : ' + item.description"
                                                    :value="item.code"
                                                >
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </div>
                                    <!-- <div class="col-md-2"></div> -->
                                </div>
                                <div class="row">
                                    <div class="col-md-4 text-right mt-2">EVM<span class="text-danger">*</span></div>
                                    <div class="col-md-8">
                                        <el-form-item :prop="'segment2'" :rules="rules.segment2">
                                            <el-select
                                                size="medium"
                                                style="width:100%;"
                                                v-model="form.segment2"
                                                placeholder="EVM"
                                                filterable
                                                clearable
                                                remote
                                                :remote-method="query => getDataListSegments(query, 'segment2')"
                                            >
                                                <el-option
                                                    v-for="(item, index) in option.segment2"
                                                    :key="index"
                                                    :label="item.meaning + ' : ' + item.description"
                                                    :value="item.code"
                                                >
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </div>
                                    <!-- <div class="col-md-2"></div> -->
                                </div>
                                <div class="row">
                                    <div class="col-md-4 text-right mt-2">Department Code<span class="text-danger">*</span></div>
                                    <div class="col-md-8">
                                        <el-form-item :prop="'segment3'" :rules="rules.segment3">
                                            <el-select
                                                size="medium"
                                                style="width:100%;"
                                                v-model="form.segment3"
                                                placeholder="Department Code"
                                                filterable
                                                clearable
                                                remote
                                                :remote-method="query => getDataListSegments(query, 'segment3')"
                                                @change="getDataListSegment4()"
                                            >
                                                <el-option
                                                    v-for="(item, index) in option.segment3"
                                                    :key="index"
                                                    :label="item.meaning + ' : ' + item.description"
                                                    :value="item.code"
                                                >
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </div>
                                    <!-- <div class="col-md-2"></div> -->
                                </div>
                                <div class="row">
                                    <div class="col-md-4 text-right mt-2">Cost Center<span class="text-danger">*</span></div>
                                    <div class="col-md-8">
                                        <el-form-item :prop="'segment4'" :rules="rules.segment4">
                                            <el-select
                                                size="medium"
                                                style="width:100%;"
                                                v-model="form.segment4"
                                                placeholder="Cost Center"
                                                filterable
                                                clearable
                                                remote
                                                :disabled="this.loadingSegment4"
                                                :remote-method="getDataListSegment4"
                                            >
                                                <el-option
                                                    v-for="(item, index) in segment4Lists"
                                                    :key="index"
                                                    :label="item.meaning + ' : ' + item.description"
                                                    :value="item.code"
                                                >
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </div>
                                    <!-- <div class="col-md-2"></div> -->
                                </div>
                                <div class="row">
                                    <div class="col-md-4 text-right mt-2">Budget Year<span class="text-danger">*</span></div>
                                    <div class="col-md-8">
                                        <el-form-item :prop="'segment5'" :rules="rules.segment5">
                                        <el-select
                                            size="medium"
                                            style="width:100%;"
                                            v-model="form.segment5"
                                            placeholder="Budget Year"
                                            filterable
                                            clearable
                                            remote
                                            :remote-method="query => getDataListSegments(query, 'segment5')"
                                        >
                                            <el-option
                                                v-for="(item, index) in option.segment5"
                                                :key="index"
                                                :label="item.meaning + ' : ' + item.description"
                                                :value="item.code"
                                            >
                                            </el-option>
                                        </el-select>
                                        </el-form-item>
                                    </div>
                                    <!-- <div class="col-md-2"></div> -->
                                </div>
                                <div class="row">
                                    <div class="col-md-4 text-right mt-2">Budget Type<span class="text-danger">*</span></div>
                                    <div class="col-md-8">
                                        <el-form-item :prop="'segment6'" :rules="rules.segment6">
                                            <el-select
                                                size="medium"
                                                style="width:100%;"
                                                v-model="form.segment6"
                                                placeholder="Budget Type"
                                                filterable
                                                clearable
                                                remote
                                                :remote-method="query => getDataListSegments(query, 'segment6')"
                                                @change="getDataListSegment7()"
                                            >
                                                <el-option
                                                    v-for="(item, index) in option.segment6"
                                                    :key="index"
                                                    :label="item.meaning + ' : ' + item.description"
                                                    :value="item.code"
                                                >
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </div>
                                    <!-- <div class="col-md-2"></div> -->
                                </div>
                                <div class="row">
                                    <div class="col-md-4 text-right mt-2">Budget Detail<span class="text-danger">*</span></div>
                                    <div class="col-md-8">
                                        <el-form-item :prop="'segment7'" :rules="rules.segment7">
                                            <el-select
                                                size="medium"
                                                style="width:100%;"
                                                v-model="form.segment7"
                                                placeholder="Budget Detail"
                                                filterable
                                                clearable
                                                remote
                                                :disabled="this.loadingSegment7"
                                                :remote-method="getDataListSegment7"
                                            >
                                                <el-option
                                                    v-for="(item, index) in segment7Lists"
                                                    :key="index"
                                                    :label="item.meaning + ' : ' + item.description"
                                                    :value="item.code"
                                                >
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </div>
                                    <!-- <div class="col-md-2"></div> -->
                                </div>
                                <div class="row">
                                    <div class="col-md-4 text-right mt-2">Budget Reason<span class="text-danger">*</span></div>
                                    <div class="col-md-8">
                                        <el-form-item :prop="'segment8'" :rules="rules.segment8">
                                            <el-select
                                                size="medium"
                                                style="width:100%;"
                                                v-model="form.segment8"
                                                placeholder="Budget Reason"
                                                filterable
                                                clearable
                                                remote
                                                :remote-method="query => getDataListSegments(query, 'segment8')"
                                            >
                                                <el-option
                                                    v-for="(item, index) in option.segment8"
                                                    :key="index"
                                                    :label="item.meaning + ' : ' + item.description"
                                                    :value="item.code"
                                                >
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </div>
                                    <!-- <div class="col-md-2"></div> -->
                                </div>
                                <div class="row">
                                    <div class="col-md-4 text-right mt-2">Main Account<span class="text-danger">*</span></div>
                                    <div class="col-md-8">
                                        <el-form-item :prop="'segment9'" :rules="rules.segment9">
                                        <el-select
                                                size="medium"
                                                style="width:100%;"
                                                v-model="form.segment9"
                                                placeholder="Main Account"
                                                filterable
                                                clearable
                                                remote
                                                :remote-method="query => getDataListSegments(query, 'segment9')"
                                                @change="getDataListSegment10()"
                                            >
                                                <el-option
                                                    v-for="(item, index) in option.segment9"
                                                    :key="index"
                                                    :label="item.meaning + ' : ' + item.description"
                                                    :value="item.code"
                                                >
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </div>
                                    <!-- <div class="col-md-2"></div> -->
                                </div>
                                <div class="row">
                                    <div class="col-md-4 text-right mt-2">Sub Account<span class="text-danger">*</span></div>
                                    <div class="col-md-8">
                                        <el-form-item :prop="'segment10'" :rules="rules.segment10">
                                            <el-select
                                                size="medium"
                                                style="width:100%;"
                                                v-model="form.segment10"
                                                placeholder="Sub Account"
                                                filterable
                                                clearable
                                                remote
                                                :disabled="this.loadingSegment10"
                                                :remote-method="getDataListSegment10"
                                            >
                                                <el-option
                                                    v-for="(item, index) in segment10Lists"
                                                    :key="index"
                                                    :label="item.meaning + ' : ' + item.description"
                                                    :value="item.code"
                                                >
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </div>
                                    <!-- <div class="col-md-2"></div> -->
                                </div>
                                <div class="row">
                                    <div class="col-md-4 text-right mt-2">Reserved1<span class="text-danger">*</span></div>
                                    <div class="col-md-8">
                                        <el-form-item :prop="'segment11'" :rules="rules.segment11">
                                            <el-select
                                                size="medium"
                                                style="width:100%;"
                                                v-model="form.segment11"
                                                placeholder="Reserved1"
                                                filterable
                                                clearable
                                                remote
                                                :remote-method="query => getDataListSegments(query, 'segment11')"
                                            >
                                                <el-option
                                                    v-for="(item, index) in option.segment11"
                                                    :key="index"
                                                    :label="item.meaning + ' : ' + item.description"
                                                    :value="item.code"
                                                >
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </div>
                                    <!-- <div class="col-md-2"></div> -->
                                </div>
                                <div class="row">
                                    <div class="col-md-4 text-right mt-2">Reserved2<span class="text-danger">*</span></div>
                                    <div class="col-md-8">
                                        <el-form-item :prop="'segment12'" :rules="rules.segment12">
                                            <el-select
                                                size="medium"
                                                style="width:100%;"
                                                v-model="form.segment12"
                                                placeholder="Reserved2"
                                                filterable
                                                clearable
                                                remote
                                                :remote-method="query => getDataListSegments(query, 'segment12')"
                                            >
                                                <el-option
                                                    v-for="(item, index) in option.segment12"
                                                    :key="index"
                                                    :label="item.meaning + ' : ' + item.description"
                                                    :value="item.code"
                                                >
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </div>
                                    <!-- <div class="col-md-2"></div> -->
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-primary" @click="accountConfirm">
                                    <i class="fa fa-save"></i> บันทึก
                                </button>
                                <button type="button" class="btn btn-sm btn-warning" @click="closeModalCreate">
                                    ยกเลิก
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </el-form>
    </div>
</template>
<script>
    import currencyInput from "../helper/CurrencyInput";
    export default {
        components: {
            currencyInput,
        },
        props: ['trans_btn', 'stampAdjs', 'defaultValueSetName', 'segmentData', 'stampTypes', 'defaultValue'],
        data() {
            return {
                option: {
                    segment1:  [],
                    segment2:  [],
                    segment3:  [],
                    segment4:  [],
                    segment5:  [],
                    segment6:  [],
                    segment7:  [],
                    segment8:  [],
                    segment9:  [],
                    segment10: [],
                    segment11: [],
                    segment12: []
                },

                form:{
                    id:            this.defaultValue ? this.defaultValue.stamp_adj_id  : '',
                    stamp_type:    this.defaultValue ? this.defaultValue.stamp_type    : '',
                    fund_location: this.defaultValue ? this.defaultValue.fund_location : '',
                    fund:          this.defaultValue ? this.defaultValue.fund          : '',
                    amount_type:   this.defaultValue ? this.defaultValue.amount_type   : '',
                    segment_code:  '',
                    segment1:      this.defaultValue ? this.defaultValue.segment1      : '',
                    segment2:      this.defaultValue ? this.defaultValue.segment2      : '',
                    segment3:      this.defaultValue ? this.defaultValue.segment3      : '',
                    segment4:      this.defaultValue ? this.defaultValue.segment4      : '',
                    segment5:      this.defaultValue ? this.defaultValue.segment5      : '',
                    segment6:      this.defaultValue ? this.defaultValue.segment6      : '',
                    segment7:      this.defaultValue ? this.defaultValue.segment7      : '',
                    segment8:      this.defaultValue ? this.defaultValue.segment8      : '',
                    segment9:      this.defaultValue ? this.defaultValue.segment9      : '',
                    segment10:     this.defaultValue ? this.defaultValue.segment10     : '',
                    segment11:     this.defaultValue ? this.defaultValue.segment11     : '',
                    segment12:     this.defaultValue ? this.defaultValue.segment12     : '',
                    start_date:    this.defaultValue ? this.defaultValue.start_date    : '',
                    end_date:      this.defaultValue ? this.defaultValue.end_date      : '',
                },

                segment4Lists:  [],
                segment7Lists:  [],
                segment10Lists: [],

                loadingSegment4:  true,
                loadingSegment7:  true,
                loadingSegment10: true,

                amountTypes: [{
                    value: 'DR',
                    label: 'DR'
                },{
                    value: 'CR',
                    label: 'CR'
                }],

                rules: {
                    stamp_type: [
                        { required: true, message: 'กรุณาเลือก Type', trigger: "change"}
                    ],
                    fund_location: [
                        { required: true, message: 'กรุณาระบุ กองทุน', trigger: "blur"}
                    ],
                    fund: [
                        { required: true, message: 'กรุณาระบุ % การปันส่วน', trigger: "blur"}
                    ],
                    amount_type: [
                        { required: true, message: 'กรุณาเลือก DR/CR', trigger: "change"}
                    ],
                    segment_code: [
                        { required: true, message: 'กรุณาระบุ Segment', trigger: "change"}
                    ],
                    segment1: [
                        { required: true, message: 'กรุณาเลือก COMPANY', trigger: "change"}
                    ],
                    segment2: [
                        { required: true, message: 'กรุณาเลือก EVM', trigger: "change"}
                    ],
                    segment3: [
                        { required: true, message: 'กรุณาเลือก Department Code', trigger: "change"}
                    ],
                    segment4: [
                        { required: true, message: 'กรุณาเลือก Cost Center', trigger: "change"}
                    ],
                    segment5: [
                        { required: true, message: 'กรุณาเลือก Budget Year', trigger: "change"}
                    ],
                    segment6: [
                        { required: true, message: 'กรุณาเลือก Budget Type', trigger: "change"}
                    ],
                    segment7: [
                        { required: true, message: 'กรุณาเลือก Budget Detail', trigger: "change"}
                    ],
                    segment8: [
                        { required: true, message: 'กรุณาเลือก Budget Reason', trigger: "change"}
                    ],
                    segment9: [
                        { required: true, message: 'กรุณาเลือก Main Account', trigger: "change"}
                    ],
                    segment10: [
                        { required: true, message: 'กรุณาเลือก Sub Account', trigger: "change"}
                    ],
                    segment11: [
                        { required: true, message: 'กรุณาเลือก Reserved1', trigger: "change"}
                    ],
                    segment12: [
                        { required: true, message: 'กรุณาเลือก Reserved2', trigger: "change"}
                    ],
                },
            }
        },
        created() {
            if (this.segmentData) {
                const segment_arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

                segment_arr.forEach(element => {
                    this.option['segment'+element] = this.segmentData['segment'+element];
                });
            }
            if (this.form.segment3) {
                this.getDataListSegment4();
            }
            if (this.form.segment6) {
                this.getDataListSegment7();
            }
            if (this.form.segment9) {
                this.getDataListSegment10();
            }

            if (this.defaultValue) {
                this.form.segment_code = this.defaultValue.segment1  + '.' + this.defaultValue.segment2  + '.' + this.defaultValue.segment3
                                         + '.' + this.defaultValue.segment4  + '.' + this.defaultValue.segment5  + '.' + this.defaultValue.segment6 
                                         + '.' + this.defaultValue.segment7  + '.' + this.defaultValue.segment8  + '.' + this.defaultValue.segment9
                                         + '.' + this.defaultValue.segment10 + '.' + this.defaultValue.segment11 + '.' + this.defaultValue.segment12;
            }
        },
        methods: {
            openModalCreate() {
                $('#modal-create').modal('show');
            },
            closeModalCreate() {
                $('#modal-create').modal('hide');
            },
            clickSave(){
                if (this.form.id) {
                    this.clickUpdate();
                }else {
                    this.clickCreate();
                }
            },
            clickCreate(){
                let vm = this;

                this.$refs.save_data.validate((valid) => {
                    if (valid) {

                        console.log('clickSave clickSave clickSave');
                        let params = {
                            form: vm.form,
                        };
                        axios.post("/ct/ajax/stamp_adj", params)
                        .then(res => {
                            // swal("Success", 'บันทึกข้อมูลเรียบร้อยแล้ว', "success");
                            swal({
                                title: "Success",
                                text: 'บันทึกข้อมูลเรียบร้อยแล้ว',
                                timer: 3000,
                                type: "success",
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            window.location.href = '/ct/stamp_adj';
                        })
                        .catch(err => {
                            swal({
                                title: "Warning",
                                text: "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากมีข้อผิดพลาด",
                                type: "warning",
                                showCancelButton: false,
                            });
                        })
                        .then(() => {
                            vm.loading = false;
                        });
                    }
                })
            },
            clickUpdate(){
                let vm = this;

                this.$refs.save_data.validate((valid) => {
                    if (valid) {
                        let params = {
                            form: vm.form,
                        };
                        let id = vm.form.id;
                        axios.post(`/ct/ajax/stamp_adj/${id}`, params)
                        .then(res => {
                            // swal("Success", 'บันทึกข้อมูลเรียบร้อยแล้ว', "success");
                            swal({
                                title: "Success",
                                text: 'บันทึกข้อมูลเรียบร้อยแล้ว',
                                timer: 3000,
                                type: "success",
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                            window.location.href = '/ct/stamp_adj';
                        })
                        .catch(err => {
                            swal({
                                title: "Warning",
                                text: "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากมีข้อผิดพลาด",
                                type: "warning",
                                showCancelButton: false,
                            });
                        })
                        .then(() => {
                            vm.loading = false;
                        });
                    }
                })
            },
            getDataListSegments(query, segment){
                this.option[segment] = [];

                axios.get("/ct/ajax/stamp_adj/get-setment", {
                    params: {
                        query:   query,
                        flex_value_set_name: this.defaultValueSetName[segment],
                    }
                }).then(res => {
                    this.option[segment] = res.data;
                });
            },
            getDataListSegment4(query){
                if (this.form.segment3) {
                    this.loadingSegment4 = true;
                
                    axios.get("/ct/ajax/stamp_adj/get-data-list", {
                        params: {
                            query:               query,
                            flex_value_set_name: this.defaultValueSetName['segment4'],
                            parent:              this.form.segment3,
                        }
                    }).then(res => {
                        this.segment4Lists = res.data;
                        if (this.segment4Lists.length > 0) {
                            this.loadingSegment4 = false;
                        }
                    });
                }
            },
            getDataListSegment7(query){
                if (this.form.segment6) {
                    this.loadingSegment7 = true;
                
                    axios.get("/ct/ajax/stamp_adj/get-data-list", {
                        params: {
                            query:               query,
                            flex_value_set_name: this.defaultValueSetName['segment7'],
                            parent:              this.form.segment6,
                        }
                    }).then(res => {
                        this.segment7Lists = res.data;
                        if (this.segment7Lists.length > 0) {
                            this.loadingSegment7 = false;
                        }
                    });
                }
            },
            getDataListSegment10(query){
                if (this.form.segment9) {
                    this.loadingSegment10 = true;
                
                    axios.get("/ct/ajax/stamp_adj/get-data-list", {
                        params: {
                            query:               query,
                            flex_value_set_name: this.defaultValueSetName['segment10'],
                            parent:              this.form.segment9,
                        }
                    }).then(res => {
                        this.segment10Lists = res.data;
                        if (this.segment10Lists.length > 0) {
                            this.loadingSegment10 = false;
                        }
                    });
                }
            },
            accountConfirm(){
                this.form.segment_code = this.form.segment1  + '.' + this.form.segment2  + '.' + this.form.segment3
                                    + '.' + this.form.segment4  + '.' + this.form.segment5  + '.' + this.form.segment6 
                                    + '.' + this.form.segment7  + '.' + this.form.segment8  + '.' + this.form.segment9
                                    + '.' + this.form.segment10 + '.' + this.form.segment11 + '.' + this.form.segment12;

                this.$refs.save_data.validate((valid) => {
                    if (valid) {
                
                        this.closeModalCreate();

                    }
                })
            },
            onlyNumeric() {
                this.form.fund = this.form.fund.replace(/[^0-9 .]/g, '');
            },
        },
    }
</script>
<style scope>
    .el-select-dropdown{
        z-index: 9999 !important;
    }

    .sticky-col {
        position: sticky;
        background-color: #dcdfdb;
        z-index: 9999;
        top: 0;
    }

    .error-message {
        display: flex;
        color: #ec4958;
        margin-top: 5px;

        strong {
            margin-right: 5px;
        }
    }

    .el-date-picker {
        z-index: 9999 !important;
    }

    /* .el-form-item{
        margin-bottom: 0px;
    } */
</style>
<style>
  .el-form-item__content{
    line-height: 40px;
    position: relative;
    font-size: 14px;
    margin-left: 0px !important;
  }
  .el-form-item__error {
    color: #F56C6C;
    font-size: 12px;
    line-height: 1;
    padding-top: 4px;
    position: relative;
    top: 100%;
    left: 0;
  }
</style>