<template>
    <div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group row">
                            <label  class="col-sm-4 form-control-label text-right">Document Code <span style="color: red;"> * </span></label>
                            <div class="col-sm-8">
                                <!-- <el-input type="text" v-model="running_code" name="running_code" size="medium" autocomplete="off" :disabled="this.disabledData"></el-input> -->

                                <input type="hidden" name="running_code" :value="running_code" autocomplete="off">
                                <el-select  class="w-100"
                                            v-model="running_code"
                                            filterable
                                            remote
                                            reserve-keyword
                                            clearable
                                            @change="getModule()"
                                            :disabled="this.disabledData">              
                                    <el-option  v-for="document in numDocuments"
                                                :key="document.lookup_code"
                                                :label="document.meaning"
                                                :value="document.lookup_code">
                                    </el-option>
                                </el-select>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-sm-4 form-control-label text-right">คำอธิบาย</label>
                            <div class="col-sm-8">
                                <el-input type="text" v-model="description" name="description" size="medium" autocomplete="off" @input="checkDup()" :disabled="this.disabledData"></el-input>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-sm-4 form-control-label text-right">ระบบงาน<span style="color: red;"> * </span></label>
                            <div class="col-sm-8">
                                <el-input type="text" v-model="module_code" name="module_code" size="medium" autocomplete="off" disabled></el-input> 
                                <!-- <input type="hidden" name="systemModule" :value="systemModule" autocomplete="off">
                                <el-select  class="w-100"
                                            v-model="systemModule"
                                            filterable
                                            remote
                                            reserve-keyword
                                            clearable
                                            :disabled="this.disabledData">              
                                    <el-option  v-for="systemModule in modules"
                                                :key="systemModule.lookup_code"
                                                :label="systemModule.description"
                                                :value="systemModule.lookup_code">
                                    </el-option>
                                </el-select> -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-sm-4 form-control-label text-right">ชื่อเมนู<span style="color: red;"> * </span></label>
                            <div class="col-sm-8">
                                <input type="hidden" name="programs_code" :value="programs_code" autocomplete="off">
                                <el-select  class="w-100"
                                            v-model="programs_code"
                                            filterable
                                            remote
                                            reserve-keyword
                                            multiple
                                            :disabled="this.disabledData">              
                                    <el-option  v-for="program in programs"
                                                :key="program.program_code"
                                                :label="program.program_code + ' : ' + program.description"
                                                :value="program.program_code">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-sm-4 form-control-label text-right">วันที่เริ่มใช้งาน<span style="color: red;"> * </span></label>
                            <div class="col-sm-8">
                                <el-date-picker 
                                    v-model="start_date"
                                    style="width: 100%;"
                                    type="date"
                                    placeholder="วันที่เริ่มต้น"
                                    name="start_date"
                                    format="dd-MM-yyyy"
                                    :disabled="this.disabledData"
                                    >
                                </el-date-picker>
                                <!-- <datepicker-th
                                    style="width: 100%;"
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    name="start_date"
                                    placeholder="โปรดเลือกวันที่"
                                    v-model="start_date"
                                    format="DD-MM-YYYY"
                                    :disabled="this.disabledData"> -->
                                </datepicker-th>
                            </div>
                        </div>
                        <!-- <div class="form-group row">
                            <label  class="col-sm-4 form-control-label text-right">วันที่เริ่มใช้งาน<span style="color: red;"> * </span></label>
                            <div class="col-sm-8">
                                <datepicker-th
                                    style="width: 100%;"
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    name="test_date"
                                    placeholder="โปรดเลือกวันที่"
                                    v-model="test_date"
                                    format="DD-MM-YYYY">
                                </datepicker-th>
                            </div>
                        </div> -->
                        <div class="form-group row">
                            <label  class="col-sm-4 form-control-label text-right">วันที่สิ้นสุด</label>
                            <div class="col-sm-8">
                                <el-date-picker 
                                    v-model="end_date"
                                    style="width: 100%;"
                                    type="date"
                                    placeholder="วันที่สิ้นสุด"
                                    name="end_date"
                                    format="dd-MM-yyyy"
                                    @change="checkDate()"
                                    >
                                </el-date-picker>  

                                <!-- <datepicker-th
                                    style="width: 100%;"
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    name="end_date"
                                    placeholder="โปรดเลือกวันที่"
                                    v-model="end_date"
                                    format="DD-MM-YYYY"
                                    @change="checkDate()">
                                </datepicker-th> -->
                            </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-sm-4 form-control-label text-right">เริ่ม Running ใหม่<span style="color: red;"> * </span></label>
                            <div class="col-sm-8">
                                <input type="hidden" name="reset_at" :value="reset_at" autocomplete="off">
                                <el-select  class="w-100"
                                            v-model="reset_at"
                                            filterable
                                            remote
                                            reserve-keyword
                                            :disabled="this.disabledData">              
                                    <el-option  v-for="resetAt in resetAts"
                                                :key="resetAt.lookup_code"
                                                :label="resetAt.description"
                                                :value="resetAt.lookup_code">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-sm-4 form-control-label text-right">Active</label>
                            <div class="col-sm-8">
                                <input type="checkbox" name="active_flag" v-model="active_flag">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label  class="col-sm-4 form-control-label text-right">Running Number<span style="color: red;"> * </span></label>
                             <div class="col-sm-8">
                                <el-input type="text" v-model="number_digit" name="number_digit" style="width: 30%" autocomplete="off" :disabled="this.disabledData" @input="onlyNumeric"></el-input>
                                Digits เริ่มจาก
                                <el-input type="text" v-model="start_digit" name="start_digit" style="width: 30%" autocomplete="off" :disabled="this.disabledData" @input="onlyNumeric"></el-input>
                            </div>
                   
                        </div>
                        <div class="form-group row">
                            <label  class="col-sm-4 form-control-label text-right">ตัวอย่าง</label>
                             <div class="col-sm-8">
                                {{ expRunningNumber }}
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group row">
                            <label  class="col-sm-12 form-control-label"> <strong>เลือกตำแหน่งและรูปแบบ Format</strong> </label>
                            
                        </div>
                        <!-- <div class="text-right">
                            <button class="btn btn-sm btn-success" type="submit" @click.prevent="addLine"> <i class="fa fa-plus"></i> เพิ่ม </button>
                        </div> -->

                        
                        <div class="form-group row" v-for="(row, index) in lines">
                            <label  class="col-sm-3 form-control-label text-right">ลำดับที่ {{ index + 1 }}<span style="color: red;"> * </span></label>
                            <div class="col-sm-4">
                                <input type="hidden" :name="'dataGroup['+index+'][group_format]'"  :value="row.group_format" autocomplete="off">
                                <!-- <input type="hidden" name="group_format[]" :value="row.group_format" autocomplete="off"> -->
                                    <el-select  v-model="row.group_format"
                                                filterable
                                                remote
                                                reserve-keyword
                                                @change="checkFormat(row, index)"
                                                :disabled="row.disabledFormat"
                                                >              
                                        <el-option  v-for="groupFormat in groupFormats"
                                                    :key="groupFormat.lookup_code"
                                                    :label="groupFormat.description"
                                                    :value="groupFormat.lookup_code">
                                        </el-option>
                                </el-select>
                            </div>
                            <div class="col-sm-4" v-if="row.group_format == '$DATE_FORMAT'">
                                <div>
                                    <!-- <input type="hidden" :name="'dataGroup['+index+'][date_format]'"  :value="row.date_format" autocomplete="off"> -->
                                    <input type="hidden" name="date_format" :value="row.date_format" autocomplete="off">
                                        <el-select  v-model="row.date_format"
                                                    filterable
                                                    remote
                                                    reserve-keyword
                                                    :disabled="row.disabledFormat">              
                                            <el-option  v-for="dateFormat in dateFormats"
                                                        :key="dateFormat.lookup_code"
                                                        :label="dateFormat.description"
                                                        :value="dateFormat.lookup_code">
                                            </el-option>
                                    </el-select>
                                </div>
                                <div class="mt-2">
                                    <!-- <input type="hidden" :name="'dataGroup['+index+'][year_type]'"  :value="row.year_type" autocomplete="off"> -->
                                    <input type="hidden" name="year_type" :value="row.year_type" autocomplete="off">
                                        <el-select  v-model="row.year_type"
                                                    filterable
                                                    remote
                                                    reserve-keyword
                                                    :disabled="row.disabledFormat">              
                                            <el-option  v-for="yearType in yearTypes"
                                                        :key="yearType.lookup_code"
                                                        :label="yearType.description"
                                                        :value="yearType.lookup_code">
                                            </el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="col-sm-4" v-if="row.group_format == '$PREFIX'">
                                <el-input type="text" v-model="row.detail" :name="'dataGroup['+index+'][detail]'" size="medium" autocomplete="off" :disabled="row.disabledFormat"></el-input>
                                <!-- <el-input type="text" v-model="row.detail" name="detail[]" size="medium" autocomplete="off" :disabled="row.disabledFormat"></el-input> -->
                            </div>
                            <div class="col-sm-1" v-if="!disabledData">
                                <button @click.prevent="removeRow(index)" class="btn btn-sm btn-danger" >
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>

                        </div>

                        <div class="text-right" v-if="!disabledData">
                            <button class="btn btn-sm btn-success" type="submit" @click.prevent="addLine"> <i class="fa fa-plus"></i> เพิ่ม </button>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import uuidv1 from 'uuid/v1';
    import moment from 'moment';
    
    export default {
        props: ["programs", "modules", "groupFormats", "resetAts", "dateFormats", "yearTypes", 'getAssignments', 'numDocuments', 'headers', 'old', 'defaultFormValue'],
        data() {
            return {
                running_code   : this.old.running_code   ? this.old.running_code  : this.defaultFormValue   ? this.defaultFormValue.doc_seq_code        : '',
                description    : this.old.description    ? this.old.description   : this.defaultFormValue   ? this.defaultFormValue.doc_seq_description : '',
                programs_code  : this.old.programs_code  ? this.old.programs_code : this.getAssignments     ? this.getAssignments                       : [],
                start_date     : this.old.start_date     ? this.old.start_date    : this.defaultFormValue   ? this.defaultFormValue.start_date          : '',
                end_date       : this.old.end_date       ? this.old.end_date      : this.defaultFormValue   ? this.defaultFormValue.end_date            : '',
                reset_at       : this.old.reset_at       ? this.old.reset_at      : this.defaultFormValue   ? this.defaultFormValue.reset_every         : '',
                start_digit    : this.old.start_digit    ? this.old.start_digit   : this.defaultFormValue   ? this.defaultFormValue.start_with          : '',
                number_digit   : this.old.number_digit   ? this.old.number_digit  : this.defaultFormValue   ? this.defaultFormValue.prefix_number_digit : '',
                module_code    : this.old.module_code    ? this.old.module_code   : this.defaultFormValue   ? this.defaultFormValue.module_code         : '',
                lines          : [],
                disabledData   : this.defaultFormValue       ? true : false,
                active_flag    : this.old.active_flag == 'Y' ? true : this.defaultFormValue  ? this.defaultFormValue.active_flag == 'Y' ? true : '' : true,
                year_type      : '',
                date_format    : '',
                detail         : '',
// ----------------------------------------------------------------------------------------------------------------------

                // running_code   : this.defaultFormValue   ? this.defaultFormValue.doc_seq_code        : '',
                // description    : this.defaultFormValue   ? this.defaultFormValue.doc_seq_description : '',
                // systemModule   : this.defaultFormValue   ? this.defaultFormValue.module_code         : '',
                // programs_code  : this.getAssignments     ? this.getAssignments                       : [],
                // start_date     : this.defaultFormValue   ? this.defaultFormValue.start_date          : '',
                // end_date       : this.defaultFormValue   ? this.defaultFormValue.end_date            : '',
                // reset_at       : this.defaultFormValue   ? this.defaultFormValue.reset_every         : '',
                // active_flag    : this.defaultFormValue   ? this.defaultFormValue.active_flag         : true,
                // detail         : '',
                // start_digit    : this.defaultFormValue   ? this.defaultFormValue.start_with          : '',
                // year_type      : '',
                // date_format    : '',
                // number_digit   : this.defaultFormValue   ? this.defaultFormValue.prefix_number_digit : '',
                // lines          : [],
                // disabledData   : this.defaultFormValue   ?  true : false,
                // test_date      : this.defaultFormValue   ? this.defaultFormValue.start_date          : '',
                // module_code    : this.defaultFormValue   ? this.defaultFormValue.module_code         : '',

               

            };
        },
        mounted() {
            if (this.old.running_code) {
                this.getModule();
            }
            if (this.old.group_format) {
                this.old.group_format.forEach(element => {
                    this.lines.push({
                        id             : uuidv1(),
                        lineId         : '',
                        group_format   : element == '$DATE_FORMAT' ? element : '$PREFIX',
                        date_format    : this.old.date_format  ?? '',
                        year_type      : this.old.year_type    ?? '',
                        detail         : this.old.detail       ?? '',
                        disabledFormat : false,
                        
                    });
                });
                
            }
            
            // if (this.old.format1) {
            //     this.lines.push({
            //         id             : uuidv1(),
            //         lineId         : '',
            //         group_format   : this.old.format1 == '$DATE_FORMAT' ? this.old.format1 : '$PREFIX',
            //         date_format    : this.old.format_date  ?? '',
            //         year_type      : this.old.year_type    ?? '',
            //         detail         : this.old.format1      ?? '',

            //         disabledFormat : true,
                    
            //     });
            // }
            // if (this.old.format2) {
            //     this.lines.push({
            //         id             : uuidv1(),
            //         lineId         : '',
            //         group_format   : this.old.format2 == '$DATE_FORMAT' ? this.old.format2 : '$PREFIX',
            //         date_format    : this.old.format_date  ?? '',
            //         year_type      : this.old.year_type    ?? '',
            //         detail         : this.old.format2      ?? '',

            //         disabledFormat : true,
                    
            //     });
            // }
            // if (this.old.format3) {
            //     this.lines.push({
            //         id             : uuidv1(),
            //         lineId         : '',
            //         group_format   : this.old.format3 == '$DATE_FORMAT' ? this.old.format3 : '$PREFIX',
            //         date_format    : this.old.format_date  ?? '',
            //         year_type      : this.old.year_type    ?? '',
            //         detail         : this.old.format3      ?? '',

            //         disabledFormat : true,
                    
            //     });
            // }
            // if (this.old.format4) {
            //     this.lines.push({
            //         id             : uuidv1(),
            //         lineId         : '',
            //         group_format   : this.old.format4 == '$DATE_FORMAT' ? this.old.format4 : '$PREFIX',
            //         date_format    : this.old.format_date  ?? '',
            //         year_type      : this.old.year_type    ?? '',
            //         detail         : this.old.format4      ?? '',

            //         disabledFormat : true,
                    
            //     });
            // }
            // if (this.old.format5) {
            //     this.lines.push({
            //         id             : uuidv1(),
            //         lineId         : '',
            //         group_format   : this.old.format5 == '$DATE_FORMAT' ? this.old.format5 : '$PREFIX',
            //         date_format    : this.old.format_date  ?? '',
            //         year_type      : this.old.year_type    ?? '',
            //         detail         : this.old.format5      ?? '',

            //         disabledFormat : true,
                    
            //     });
            // }

            if (this.defaultFormValue) {
                // this.addLine();
                if (this.defaultFormValue.format1) {
                    this.lines.push({
                        id             : uuidv1(),
                        lineId         : '',
                        group_format   : this.defaultFormValue.format1 == '$DATE_FORMAT' ? this.defaultFormValue.format1 : '$PREFIX',
                        date_format    : this.defaultFormValue.format_date  ?? '',
                        year_type      : this.defaultFormValue.year_type    ?? '',
                        detail         : this.defaultFormValue.format1      ?? '',

                        disabledFormat : true,
                        
                    });
                }
                if (this.defaultFormValue.format2) {
                    this.lines.push({
                        id             : uuidv1(),
                        lineId         : '',
                        group_format   : this.defaultFormValue.format2 == '$DATE_FORMAT' ? this.defaultFormValue.format2 : '$PREFIX',
                        date_format    : this.defaultFormValue.format_date  ?? '',
                        year_type      : this.defaultFormValue.year_type    ?? '',
                        detail         : this.defaultFormValue.format2      ?? '',

                        disabledFormat : true,
                        
                    });
                }
                if (this.defaultFormValue.format3) {
                    this.lines.push({
                        id             : uuidv1(),
                        lineId         : '',
                        group_format   : this.defaultFormValue.format3 == '$DATE_FORMAT' ? this.defaultFormValue.format3 : '$PREFIX',
                        date_format    : this.defaultFormValue.format_date  ?? '',
                        year_type      : this.defaultFormValue.year_type    ?? '',
                        detail         : this.defaultFormValue.format3      ?? '',

                        disabledFormat : true,
                        
                    });
                }
                if (this.defaultFormValue.format4) {
                    this.lines.push({
                        id             : uuidv1(),
                        lineId         : '',
                        group_format   : this.defaultFormValue.format4 == '$DATE_FORMAT' ? this.defaultFormValue.format4 : '$PREFIX',
                        date_format    : this.defaultFormValue.format_date  ?? '',
                        year_type      : this.defaultFormValue.year_type    ?? '',
                        detail         : this.defaultFormValue.format4      ?? '',

                        disabledFormat : true,
                        
                    });
                }
                if (this.defaultFormValue.format5) {
                    this.lines.push({
                        id             : uuidv1(),
                        lineId         : '',
                        group_format   : this.defaultFormValue.format5 == '$DATE_FORMAT' ? this.defaultFormValue.format5 : '$PREFIX',
                        date_format    : this.defaultFormValue.format_date  ?? '',
                        year_type      : this.defaultFormValue.year_type    ?? '',
                        detail         : this.defaultFormValue.format5      ?? '',

                        disabledFormat : true,
                        
                    });
                }
            }
        },
        computed: {
            expRunningNumber(){
                var formatted = '';
                for (var i = 1; i < this.number_digit; i++) {
                    let a = '0';
                    formatted += a;                    
                }

                return formatted + this.start_digit;
                
            }
        },
        methods:{
            addLine() {
                this.lines.push({
                    id             : uuidv1(),
                    lineId         : '',
                    group_format   : '',
                    
                });
                
            },
            removeRow: function (index) {
                this.lines.splice(index, 1);
            },
            checkDup() {
                this.selectedData = this.headers.find( i => {
                    return i.doc_seq_description == this.description;
                });
                if (this.selectedData) {
                     this.$notify.error({
                          title: 'มีข้อผิดพลาด',
                          message: 'คำอธิบายซ้ำกับในระบบ',
                    });

                    this.description = '';

                }
            },
            checkDate() {
                if (this.start_date) {
                    if (moment(String(this.end_date)).format('yyyy-MM-DD') < moment(String(this.start_date)).format('yyyy-MM-DD')) {
                        this.$notify.error({
                            title: 'มีข้อผิดพลาด',
                            message: 'วันที่สิ้นสุดต้องไม่น้อยกว่าวันที่เริ่มต้น',
                        });

                        this.end_date = '';
                    }
                } 
            },
            async showDate() {
                if (this.start_date) {
                    console.log('start_date -->' + this.start_date);
                    console.log(moment(String(this.start_date)).format('yyyy-MM-DD'));
                    var date1 = await helperDate.parseToDateTh(this.start_date, 'yyyy-MM-DD');
                    this.start_date = date1;
                }
                if (this.end_date) {
                    console.log('end_date -->' + this.end_date);
                    var date2 = await helperDate.parseToDateTh(this.end_date, 'yyyy-MM-DD');
                    this.end_date = date2;
                }
            
                // var date2 = await helperDate.parseToDateTh(this.start_date, 'yyyy-MM-DD');
                //     console.log('date1 ', date1);
                //     console.log('date2 ', date2);
            },
            getModule() {
                this.module_code = '';

                this.selectedData = this.numDocuments.find( i => {
                    return i.lookup_code == this.running_code;
                });

                if (this.selectedData) {
                    this.module_code = this.selectedData.tag;
                }
                console.log('ระบบงาน  ---->  ' + this.module_code);
            },
            checkFormat(row, index) {
                if (index > 0) {
                    this.lines.find(line => {
                        if (line.id != row.id) {
                            console.log('group_format -->' + line.group_format);
                            if (line.group_format == '$DATE_FORMAT' && row.group_format == '$DATE_FORMAT') {
                                this.$notify.error({
                                    title: 'มีข้อผิดพลาด',
                                    message: 'ไม่สามารถเลือกรูปแบบวันที่ซ้ำกันภายใต้ Document ชุดเดียวกันได้',
                                });

                                row.group_format = '';
                            }
                        }
                    });
                }
            },
            onlyNumeric() {
                this.number_digit = this.number_digit.replace(/[^0-9 .]/g, '');
                this.start_digit = this.start_digit.replace(/[^0-9 .]/g, '');
            },
        }

    }
</script>