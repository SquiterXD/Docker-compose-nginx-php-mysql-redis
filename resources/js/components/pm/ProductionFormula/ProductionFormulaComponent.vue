<template>
<form id="submitForm" :action="urlSave" method="post" @submit.prevent="checkForm" onkeydown="return event.key != 'Enter';">
    <input type="hidden" name="_token" :value="csrf">
        <div class="ibox-title">
            <div class="row">
                <div class="col-3">
                    <h3 class="no-margins"> กำหนดสูตรผลิตภัณฑ์ </h3>
                </div>
                <div class="col-9 text-right">
                    <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                    <a :href="this.urlReset" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-times"></i> ยกเลิก </a>
                    <a :href="this.urlReset" type="button" class="btn btn-sm btn-danger"> ย้อนกลับ </a>
                </div>
            </div>
        </div>
        <!-- <div class="row clearfix m-t-lg text-right">
            <div class="col-sm-12">
                <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                <a :href="this.urlReset" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-times"></i> ยกเลิก </a>
            </div>
        </div> -->
    <!-- <div> -->
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-4">
                    <label> รหัสสินค้า <span class="text-danger">*</span></label>
                    <input type="hidden" name="inventory_item_id"  :value="inventory_item_id" autocomplete="off">
                    <el-select  v-model="inventory_item_id"
                                    filterable
                                    remote
                                    reserve-keyword
                                    clearable
                                    placeholder=""
                                    class="w-100" 
                                    :remote-method="getItemHeaderList"
                                    @change="getVersion(); getItemHeaderList();">              
                        <el-option  v-for="item in itemHeaderLists"
                                    :key="item.inventory_item_id"
                                    :label="item.item_number + ' : ' + item.item_desc"
                                    :value="item.inventory_item_id">

                        </el-option>
                    </el-select>
                </div>
                <div class="col-md-4">
                    <label> สถานะ </label>
                    <el-input name="status" value="สร้างใหม่" disabled></el-input>
                    <!-- <input type="hidden" name="status"  :value="status" autocomplete="off">
                    <el-select  v-model="status"
                                    filterable
                                    remote
                                    reserve-keyword
                                    clearable
                                    class="w-100" 
                                    disabled>              
                        <el-option  v-for="status in formulaStatus"
                                    :key="status.description"
                                    :label="status.description"
                                    :value="status.description">

                        </el-option>
                    </el-select> -->
                
                </div>
                <div class="col-md-4">
                    <label> ผู้อนุมัติ </label>
                    <el-input name="approved_by" :value="user.name" disabled></el-input>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <label> ประเภทสูตร <span class="text-danger">*</span></label>
                    <input type="hidden" name="folmula_type"  :value="folmula_type" autocomplete="off">
                    <el-select  v-model="folmula_type"
                                    filterable
                                    remote
                                    placeholder=""
                                    reserve-keyword
                                    clearable
                                    class="w-100" 
                                    @change="getVersion(); getFolmulaTypeDesc(); getWipStep();">              
                        <el-option  v-for="folmulaType in formulaTypes"
                                    :key="folmulaType.lookup_code"
                                    :label="folmulaType.description"
                                    :value="folmulaType.lookup_code">

                        </el-option>
                    </el-select>
                </div>
                <div class="col-md-4">
                    <label> Version </label>
                    <el-input name="version" v-model="version" disabled></el-input>
                </div>
                <div class="col-md-4">
                    <label> ปีงบประมาณ <span class="text-danger">*</span> </label>
                    <input type="hidden" name="period_year"  :value="period_year" autocomplete="off">
                    <el-select  v-model="period_year"
                                    filterable
                                    remote
                                    placeholder=""
                                    reserve-keyword
                                    clearable
                                    class="w-100" 
                                    @change="getDate(); getVersion();"
                                    :disabled="loadingBudgetYear">              
                        <el-option  v-for="(year, key) in years"
                                    :key="key"
                                    :label="year.year_thai"
                                    :value="year.year_thai">

                        </el-option>
                    </el-select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <label> ประเภทสิ่งผลิต <span class="text-danger">*</span></label>
                    <input type="hidden" name="routing_desc"  :value="routing_desc" autocomplete="off">
                    <el-select  v-model="routing_desc"
                                    filterable
                                    remote
                                    reserve-keyword
                                    placeholder=""
                                    clearable
                                    class="w-100" 
                                    @change="getWipStep(); getVersion();">              
                        <el-option  v-for="(routing, index) in routings"
                                    :key="index"
                                    :label="index"
                                    :value="index">

                        </el-option>
                    </el-select>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-7">
                            <label> จำนวนผลผลิต <span class="text-danger">*</span></label>
                            <el-input name="qty" v-model="qty" @input="onlyNumeric"></el-input>
                        </div>
                        <div class="col-md-5">
                            <label> หน่วยนับ <span class="text-danger">*</span></label>
                            <input type="hidden" name="uom_code"  :value="uom_code" autocomplete="off">
                            <el-select  v-model="uom_code"
                                            filterable
                                            remote
                                            reserve-keyword
                                    placeholder=""
                                            clearable
                                            class="w-100" 
                                            :remote-method="getUom"
                                            :disabled="loadingUom">              
                                <el-option  v-for="(uomList, i) in uomLists"
                                            :key="i"
                                            :label="uomList.from_uom_code + ' : ' + uomList.from_unit_of_measure"
                                            :value="uomList.from_uom_code">

                                </el-option>
                            </el-select>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <label> วันที่เริ่มใช้งาน </label>
                    <!-- <el-date-picker 
                        onkeydown="return event.key != 'Enter';"
                        v-model="start_date"
                        style="width: 100%;"
                        type="date"
                        placeholder="วันที่เริ่มต้น"
                        name="start_date"
                        format="dd-MM-yyyy"
                        >
                    </el-date-picker>  -->

                    <el-input name="budget_start_date" v-model="budget_start_date" disabled></el-input>
                    <!-- ----------------------------------------------------------- -->

                   <!-- <ct-datepicker
                        class="my-1 col-sm-12 form-control"
                        name="start_date"
                        onkeydown="return event.key != 'Enter';"
                        style="width: 100%;"
                        placeholder="โปรดเลือกวันที่เริ่มต้น"
                        :enableDate="date => isInRange(date, null, toJSDate(end_date), true)"
                        :value="toJSDate(start_date, 'yyyy-MM-dd')"
                        @change="(date) => {
                            start_date = jsDateToString(date)
                        }"
                    />
                    <input type="hidden" name="start_date" :value="start_date"> -->
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <label> ขั้นตอนการทำงาน <span class="text-danger">*</span></label>
                    <div v-if="this.check_org_multi_wip">
                        <div v-for="wipStepHeader in wipSteps[routing_desc]">
                            <el-radio v-model="multi_wip_step" :label="wipStepHeader.oprn_id"  name="multi_wip_step">
                                {{ wipStepHeader.oprn_desc }}
                            </el-radio>
                        </div>
                        
                    </div>
                    <div v-else>
                        <input type="hidden" name="wip_step"  :value="wip_step" autocomplete="off">
                        <el-select  v-model="wip_step"
                                        filterable
                                        remote
                                        reserve-keyword
                                    placeholder=""
                                        clearable
                                        class="w-100" 
                                        :disabled="loadingWipStep || routing_desc == ''"
                                        @change="getVersion(); getMachineType();">              
                            <el-option  v-for="wipStepHeader in wipSteps[routing_desc]"
                                        :key="wipStepHeader.oprn_id"
                                        :label="wipStepHeader.oprn_class_desc + ' : ' + wipStepHeader.oprn_desc"
                                        :value="wipStepHeader.oprn_id">

                            </el-option>
                        </el-select>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <label> ประเภทเครื่องจักร <span class="text-danger">*</span></label>
                            <input type="hidden" name="machine"  :value="machine" autocomplete="off">
                            <el-select  v-model="machine"
                                            filterable
                                    placeholder=""
                                            remote
                                            reserve-keyword
                                            clearable
                                            class="w-100" 
                                            :disabled="loadingMachine || org_code == 'MPG' || org_code == 'M06' || org_code == 'M12'"
                                            @change="getVersion()">              
                                <el-option  v-for="machineList in machineLists"
                                            :key="machineList.lookup_code"
                                            :label="machineList.description"
                                            :value="machineList.lookup_code">

                                </el-option>
                            </el-select>
                        </div>
                        <div class="col-md-6">
                            <!-- <label> วันที่สร้าง </label> -->
                            <!-- <el-input name="create_date" v-model="create_date" disabled></el-input> -->
                            <!-- <el-input name="create_date" v-model="creation_date_format" disabled></el-input> -->
                            <label> วันที่สิ้นสุดการใช้งาน </label>
                            <!-- <el-date-picker 
                                onkeydown="return event.key != 'Enter';"
                                v-model="end_date"
                                style="width: 100%;"
                                type="date"
                                placeholder="วันที่เริ่มต้น"
                                name="end_date"
                                format="dd-MM-yyyy"
                                >
                            </el-date-picker>  -->

                            <el-input name="budget_end_date" v-model="budget_end_date" disabled></el-input>
                            <!-- ----------------------------------------------------------- -->
                            <!-- <ct-datepicker
                                class="my-1 col-sm-12 form-control"
                                onkeydown="return event.key != 'Enter';"
                                style="width: 100%;"
                                placeholder="โปรดเลือกวันที่เริ่มต้น"
                                :enableDate="date => isInRange(date, toJSDate(start_date), null, true)"
                                :value="toJSDate(end_date, 'yyyy-MM-dd')"
                                @change="(date) => {
                                    end_date = jsDateToString(date)
                                }"
                            />
                            <input type="hidden" name="end_date" :value="end_date"> -->
                        </div>
                    </div>
                    <div class="row" v-if="this.check_org_multi_wip">
                        <div class="col-md-12  mt-2"> 
                            <label> หมายเหตุ </label>
                            <div>
                                <el-input type="textarea" class="required" name="comments" v-model="comments" rows="1" maxlength="250" show-word-limit/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  

            <div class="row mt-2" v-if="this.loadingWipStep && !this.check_org_multi_wip">
                <div class="col-md-4">
                    <template v-for="wipStepHeader in wipSteps[routing_desc]">
                        <el-radio v-model="multi_wip_step" :label="wipStepHeader.oprn_id" name="multi_wip_step">
                            {{ wipStepHeader.oprn_desc }}
                        </el-radio>
                    </template>
                </div>
                <div class="col-md-8">
                    <label> หมายเหตุ </label>
                    <div>
                        <el-input type="textarea" class="required" name="comments" v-model="comments" maxlength="250" row="1" show-word-limit/>
                    </div>
                </div>
            </div>
        </div> 
        <div v-if="this.check_org_multi_wip && this.org_code != 'M06'">
            <process 
                :routings="routings"
                :default-step="defaultIngredientStep"
                :default-items="defaultIngredientItems"
                :wip-steps="wipSteps[routing_desc]"
                :wip-step="this.multi_wip_step"
                :default-steps="ingredientSteps"
                :default-routing-id="routing_id"
                :org-id="org_id"
                :routing-desc="this.routing_desc"
                :org-code="organizationCode"
                @lines="resLines"
            ></process>
        </div>
        <div v-if="!this.check_org_multi_wip">
            <div v-if="this.loadingWipStep">
                <processMultiWip 
                    :routings="routings"
                    :default-step="defaultIngredientStep"
                    :default-items="defaultIngredientItems"
                    :wip-steps="wipSteps[routing_desc]"
                    :wip-step="this.multi_wip_step"
                    :default-steps="ingredientSteps"
                    :default-routing-id="routing_id"
                    :org-id="org_id"
                    :routing-desc="this.routing_desc"
                    :org-code="organizationCode"
                    :folmula-type-desc="this.folmula_type_desc"
                    @lines="resLines"
                ></processMultiWip>
            </div>    
            <div class="mt-3" v-else>
                <process 
                    :routings="routings"
                    :default-step="defaultIngredientStep"
                    :default-items="defaultIngredientItems"
                    :wip-steps="wipSteps[routing_desc]"
                    :wip-step="this.wip_step"
                    :default-steps="ingredientSteps"
                    :default-routing-id="routing_id"
                    :org-id="org_id"
                    :routing-desc="this.routing_desc"
                    :org-code="organizationCode"
                    @lines="resLines"
                ></process>
            </div>
        </div> 
        <div class="mt-3" v-if="this.org_code == 'M06'">
            <process 
                :routings="routings"
                :default-step="defaultIngredientStep"
                :default-items="defaultIngredientItems"
                :wip-steps="wipSteps[routing_desc]"
                :wip-step="this.multi_wip_step"
                :default-steps="ingredientSteps"
                :default-routing-id="routing_id"
                :org-id="org_id"
                :routing-desc="this.routing_desc"
                :org-code="organizationCode"
                @lines="resLines"
            ></process>
        </div>    
</form>
</template>

<script>

import productionProcess from './ProductionProcess.vue'
import productionTest from './ProductTest.vue'
import process from './Process.vue'
import processMultiWip from './ProcessMultiWipComponent.vue'

import {isInRange, jsDateToString, toJSDate, toThDateString} from '../../../dateUtils'
import moment from 'moment';


export default {
    props:['organizationCode', 'users', 'machineTypes', 'routings', 'wipSteps', 'user', 'organizations', 'defaultValue', 'defaultIngredientStep', 
           'defaultIngredientItems', 'oprns', 'ingredientSteps', 'oprnClass', 'formulaStatus', 'wipStepHeaders', 'urlSave', 'urlReset', 
           'formulaTypes', 'transDate', 'years'
        ],
    components: {
        productionProcess,
        productionTest,
        process,
        processMultiWip,
    },
    data() {
        return {
            toJSDate,
            jsDateToString,
            isInRange,
            toThDateString,

            inventory_item_id: this.defaultValue  ?  this.defaultValue.inventory_item_id : '',
            org_id:            this.defaultValue  ?  this.defaultValue.org_id            : '',
            // org_code:          this.defaultValue  ?  this.organizationCode               : '',
            status:            this.defaultValue  ?  this.defaultValue.status            : 'สร้างใหม่',
            folmula_type:      this.defaultValue  ?  this.defaultValue.folmula_type      : '',
            version:           this.defaultValue  ?  this.defaultValue.version           : '',
            approved_by:       this.defaultValue  ?  this.defaultValue.approved_by       : '',
            // wip_step:          this.defaultValue  ?  this.defaultValue.wip     ? Number(this.defaultValue.wip)      : ''  : '',
            machine:           this.defaultValue  ?  this.defaultValue.machine ? Number(this.defaultValue.machine)  : ''  : '',
            wip_step:          this.defaultValue  ?  this.defaultValue.wip     : '',
            // machine:           this.defaultValue.machine  ? Number(this.defaultValue.machine)   : '',
            create_date:       this.defaultValue  ?  moment(String(this.defaultValue.created_at)).format('DD-MM-yyyy') : moment(String(Date())).format('DD-MM-yyyy'),
            qty:               this.defaultValue  ?  this.defaultValue.qty               : '',
            start_date:        this.defaultValue  ?  this.defaultValue.start_date        :new Date('yyyy-MM-dd'),
            end_date:          this.defaultValue  ?  this.defaultValue.end_date          : '',
            routing_id:        this.defaultValue  ?  this.defaultValue.routing_id        : '',
            org_code:          '',
            wip_uom:           '',
            uom_code:          this.defaultValue  ?  this.defaultValue.uom               : '',

            default_wip:       this.defaultValue  ?  this.defaultValue.wip     ? Number(this.defaultValue.wip)      : ''  : '',
            loadingUom:        this.defaultValue  ?  this.defaultValue.inventory_item_id ? false : true  : true,
            loadingWipStep:    this.defaultValue  ?  this.defaultValue.folmula_type ? false : true  : true,
            loadingMachine:    this.defaultValue  ?  this.defaultValue.wip ? false : true  : true,

            uomLists: [],
            itemHeaderLists: [],
            machineLists: [],
            creation_date_format: this.defaultValue  ?  this.defaultValue.creation_date_format               : '',
            period_year: '',
            loadingBudgetYear: true,
  
            statusOptions: [
                {
                    value: 'New',
                    label: 'New'
                },
                {
                    value: 'Pending',
                    label: 'Pending'
                },
                {
                    value: 'Active',
                    label: 'Active'
                },
                {
                    value: 'Inactive',
                    label: 'Inactive'
                },
                {
                    value: 'Rejected',
                    label: 'Rejected'
                },
            ],
            folmulaTypeOptions : [
                {
                    value: 'สูตรใช้จริง',
                    label: 'สูตรใช้จริง'
                },
                {
                    value: 'สูตรมาตรฐาน',
                    label: 'สูตรมาตรฐาน'
                },
                {
                    value: 'สูตรทดลอง',
                    label: 'สูตรทดลอง'
                },
            ],

            errors: [],

            lines: [],

            routing_desc: '',
            
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

            budget_start_date: '',
            budget_end_date: '',
            defaule_qty: 1000000,

            multi_wip_step: '',
            folmula_type_desc: '',

            check_org_multi_wip: false,
            comments: '',
            
        }
    },
    watch: {
        // loadingBudgetYear : async function () {
        //     if (this.loadingBudgetYear) {
        //         this.period_year = ;
        //     }           
        // },
        // picked_oprn : async function () {
        //     this.$emit('lines', this.picked_oprn)           
        // },
    },
    mounted(){ 
        this.getItemHeaderList();
        // this.getUom();
        this.orgCode();

        // console.log(moment(String(Date())).format('DD-MM-yyyy'));
        // this.updateValue();

        if (this.organizationCode == 'MG6' || this.organizationCode == 'M05') {
            // var defaule_qty = ;
            this.qty = '1,000,000';
        }

        if (this.org_code == 'MPG' || this.org_code == 'M12' || this.org_code == 'M06') {
            this.check_org_multi_wip = true;
        }
    },
    methods: {
        resLines(res){
            this.lines = res;
            // console.log(res);
        },

        // resRoutingDesc(res){
        //     this.routing_desc = res;
        //     // console.log(res);
        // },
  
        async getItemHeaderList(query) {
            if (!this.inventory_item_id) {
                this.loadingUom = true;
                this.uom_code = '';
            }

            this.itemHeaderLists = [],

            axios.get("/pm/ajax/get-item-header", {
                params: {
                    org_id:   this.org_id,
                    org_code: this.org_code,
                    query:    query,
                }
            })
            .then(res => {
                this.itemHeaderLists = res.data;

                if (this.inventory_item_id) {
                    this.selectedItem = this.itemHeaderLists.find( i => {
                        return i.inventory_item_id == this.inventory_item_id;
                    });
                    
                    this.getUom();
                    // this.uom_code = this.selectedItem ? this.selectedItem.primary_uom_code : '';
                }
                
            })
            .catch(err => {
                console.log(err)
            });
        },
        async getVersion(query) {

            this.version = '',

            axios.get("/pm/ajax/get-version", {
                params: {
                    inventory_item_id: this.inventory_item_id,
                    folmula_type:      this.folmula_type,
                    wip_step:          this.wip_step,
                    machine:           this.machine,
                    organization_code: this.organizationCode,
                    query: query,
                    multi_wip_step:    this.multi_wip_step,
                    // W. 11/07/22 -เพิ่มปีงบประมาณมาเช็ค version
                    period_year:       this.period_year,
                }
            })
            .then(res => {
                if (this.inventory_item_id || this.folmula_type || this.wip_step || this.machine) {
                    this.version = res.data;

                    if (this.version > 1) {
                        var vm = this;
                        swal({
                            title: "Warning",
                            text: "มีสูตรนี้อยู่ในระบบแล้ว ต้องการสร้าง Version ใหม่หรือไม่?",
                            type: "warning",
                            showCancelButton: true,
                            closeOnConfirm: false
                        },
                        function(isConfirm) {
                            if (isConfirm) {

                                swal({
                                    title: "Success",
                                    text: '',
                                    timer: 3000,
                                    type: "success",
                                    showCancelButton: false,
                                    showConfirmButton: false
                                })
                                // vm.loading = false;
                            } else {
                                console.log('xxx');
                                window.location.reload();

                                swal({
                                    title: "มีข้อผิดพลาด",
                                    text: '',
                                    timer: 3000,
                                    type: "success",
                                    showCancelButton: false,
                                    showConfirmButton: false
                                });
                            }
                        });
                    } 

                } else {
                    this.version = '';
                }
                
            })
            .catch(err => {
                console.log(err)
            });
        },
        async getUom(query) {
            console.log('getUom');
            // this.loadingUom = true;

            if (this.inventory_item_id) {
                this.loadingUom = false;
                this.uomLists = [];

                axios.get("/pm/ajax/get-uom", {
                    params: {
                        inventory_item_id: this.inventory_item_id,
                        query:             query,
                        org_id:            this.org_id,
                        // uom_code:          this.uom_code,
                    }
                })
                .then(res => {
                    this.uomLists  = res.data.data.uomLists;
                    this.uom_code  = res.data.data.uom;
                    // if (!this.uom_code) {
                    //     this.uom_code  = res.data.data.uom;
                    // } 
                    // this.loadingUom = false;
                    // console.log('res --> ' + res.data.data.code);
                    // if (this.wip_step) {
                    //     this.uomLists  = res.data.data.uomLists;
                    //     this.wip_uom   = res.data.data.code;
                    //     if (this.defaultValue) {
                    //         if (!this.defaultValue.uom) {
                    //             this.uom_code  = res.data.data.code;
                    //         }
                    //     } else {
                    //         this.uom_code  = res.data.data.code;
                    //     }
                        
                    // } 
                    // else {
                        // this.uomLists  = res.data;
                        // this.wip_uom  = '';
                        // this.uom_code = '';
                        // this.uomLists = [];
                    // }
                
                })
                .catch(err => {
                    console.log(err)
                });
            } else {
                this.uom_code  = '';
            }
        },
        async orgCode() {
            if (this.org_id) {
                this.selectedData = this.organizations.find(organization => {
                    return organization.organization_id == this.org_id;
                });

                this.org_code = this.selectedData.organization_code;
            } else {
                this.selectedData = this.organizations.find(organization => {
                    return organization.organization_id == this.user.organization_id;
                });

                this.org_code = this.selectedData.organization_code;
            }
        },
        async getMachineType(query) {
            console.log('getMachineType <--->');
            if (!this.wip_step) {
                this.machine  = '';
            }

            if (this.folmula_type) {

                // this.selectedData = this.formulaTypes.find(data => {
                //     return data.lookup_code == this.folmula_type;
                // });

                if (this.folmula_type_desc == 'สูตรใช้จริง') {
                    axios.get("/pm/ajax/get-machine-type", {
                        params: {
                            wip_step:   this.wip_step,
                            org_code:   this.org_code,
                            query:      query,
                        }
                    })
                    .then(res => {
                        this.machineLists = res.data;
                        this.loadingMachine = false;
                        
                    })
                    .catch(err => {
                        console.log(err)
                    });

                } else{
                    this.loadingMachine = true;
                    this.machine  = '';
                }
            }
            
        },

        async getWipStep() {
            this.loadingWipStep    = true;

            if (this.routing_desc) {
                if (this.wipSteps[this.routing_desc]) {
                    let checkWipFirst = this.wipSteps[this.routing_desc][0];
                    if (checkWipFirst) {
                        this.multi_wip_step = checkWipFirst.oprn_id;    
                    }
                }
            }

            this.getMachineType();
            
            // if (this.selectedData) {
            //     if (this.selectedData.description == 'สูตรใช้จริง') {
            //         if (this.org_code == 'MG6' || this.org_code == 'M05') {
            //             if (this.routing_desc) {
            //                 this.loadingWipStep = false;
            //             }else {
            //                 this.wip_step = '';
            //             }
            //         }
                    
            //     } else {
            //         this.wip_step = '';
            //     }
            // } else {
            //     this.wip_step = '';
            // }

            //สำหรับเปิด-ปิดการใช้งานของปีงบประมาณ และ วันที่เริ่มต้น - วันที่สิ้นสุด
            if (this.folmula_type) {
                console.log('getWipStep getWipStep getWipStep');
                // this.selectedData = this.formulaTypes.find(data => {
                //     return data.lookup_code == this.folmula_type;
                // });

                // this.folmula_type_desc = this.selectedData.description;

                if (this.folmula_type_desc == 'สูตรมาตรฐาน') {
                    console.log('getWipStep getWipStep getWipStep folmula_type_desc', this.folmula_type_desc);
                    this.loadingWipStep = true;

                    // this.loadingWipStep = false;
                    this.wip_step = '';

                     this.loadingBudgetYear = false;
                     this.getDate();
                } else {
                    //  เปิดขั้นตอนการทำงานสำหรับทุกประเภทสูตร
                    if (this.folmula_type && this.routing_desc) {
                        this.loadingWipStep = false;
                    } else {
                        this.loadingWipStep = true;
                        this.wip_step = '';
                    }

                    this.loadingBudgetYear = true;
                    this.period_year       = '';
                    this.budget_start_date = '';
                    this.budget_end_date   = '';
                }

                // if (this.folmula_type_desc == 'สูตรมาตรฐาน') {

                //     this.loadingBudgetYear = false;
                //     // this.period_year       = this.defaultValue.creation_year;

                //     // if (this.period_year) {
                //         this.getDate();
                //     // }

                // } else {
                    
                //     this.loadingBudgetYear = true;
                //     this.period_year       = '';
                //     this.budget_start_date = '';
                //     this.budget_end_date   = '';

                // }
            } else {

                this.loadingBudgetYear = true;
                this.period_year       = '';
                this.budget_start_date = '';
                this.budget_end_date   = '';

            }

            // axios.get("/pm/ajax/get-machine-type", {
            //     params: {
            //         wip_step:   this.wip_step,
            //         org_code:   this.org_code,
            //         query:      query,
            //     }
            // })
            // .then(res => {
            //     this.machineLists = res.data;
            //     this.loadingMachine = false;
                
            // })
            // .catch(err => {
            //     console.log(err)
            // });
        },

        onlyNumeric() {
            if (this.qty) {
                this.qty = this.qty.replace(/[^0-9 .]/g, '');
                this.qty = this.qty.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            } 
        },

        async testTest() {
            
            var vm = this;
            swal({
                title: "Warning",
                text: "ต้องการเปลี่ยนขั้นตอนการทำงานหรือไม่?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false
            },
            function(isConfirm) {
                if (isConfirm) {

                    swal({
                        title: "Success",
                        text: '',
                        timer: 3000,
                        type: "success",
                        showCancelButton: false,
                        showConfirmButton: false
                    })
                } else {
                    console.log('xxx');
                    vm.wip_step = vm.default_wip;

                    swal({
                        title: "มีข้อผิดพลาด",
                        text: '',
                        timer: 3000,
                        type: "success",
                        showCancelButton: false,
                        showConfirmButton: false
                    });
                }
            });
        },
        async checkForm (e) {

            var form  = $('#submitForm');
            let inputs = form.serialize();
            this.errors = [];

            let params = {
                inventory_item_id: this.inventory_item_id,
                folmula_type:      this.folmula_type,
                machine:           this.machine,
                wip_step:          this.wip_step,
                qty:               this.qty,
                routing_id:        this.routing_id,
                uom_code:          this.uom_code,
                lines:             this.lines,
            }

            if (!this.inventory_item_id) {
                this.errors.push('รหัสสินค้า');
                swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: this.errors,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                });
            }

            if (!this.folmula_type) {
                this.errors.push('ประเภทสูตร');
                swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: this.errors,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                });
            }

            if (!this.wip_step) {
                if (this.folmula_type) {
                    if (this.org_code == 'MG6' || this.org_code == 'M05') {

                        // this.selectedData = this.formulaTypes.find(data => {
                        //     return data.lookup_code == this.folmula_type;
                        // });

                        if (this.folmula_type_desc == 'สูตรใช้จริง') {

                            this.errors.push('ขั้นตอนการทำงาน');
                            swal({
                                title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                                text: this.errors,
                                timer: 3000,
                                type: "error",
                                showCancelButton: false,
                                showConfirmButton: false
                            });

                        }
                        
                    }
                }
                
            }

            if (!this.machine) {

                if (this.folmula_type) {

                    if (this.org_code == 'MG6' || this.org_code == 'M05') {
                    
                        // this.selectedData = this.formulaTypes.find(data => {
                        //     return data.lookup_code == this.folmula_type;
                        // });

                        if (this.folmula_type_desc == 'สูตรใช้จริง') {
                            this.errors.push('ประเภทเครื่องจักร');
                            swal({
                                title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                                text: this.errors,
                                timer: 3000,
                                type: "error",
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                        }
                    }
                }
            }

            if (!this.qty) {
                this.errors.push('จำนวนผลผลิต');
                swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: this.errors,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                });
            }

            if (!this.uom_code) {
                this.errors.push('หน่วยนับ');
                swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: this.errors,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                });
            }

            if (!this.period_year) {

                if (this.folmula_type) {

                    // this.selectedData = this.formulaTypes.find(data => {
                    //     return data.lookup_code == this.folmula_type;
                    // });

                    if (this.folmula_type_desc == 'สูตรมาตรฐาน') {
                        this.errors.push('ปีงบประมาณ');
                        swal({
                            title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                            text: this.errors,
                            timer: 3000,
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    }
                }
                
            }

            if (!this.lines.length) {
                this.errors.push('รหัสวัตถุดิบ, จำนวนตามสูตร');
                console.log('check validate line <---> ' + this.lines.length);
                swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: this.errors,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                });
            }

            if (this.lines.length > 0) {
                this.lines.forEach(line => {
                    if (!line.ingredient_item_id) {
                        this.errors.push('รหัสวัตถุดิบ');
                        swal({
                            title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                            text: this.errors,
                            timer: 3000,
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    }

                    if (line.ingredient_folmula_qty === '') {
                        this.errors.push('จำนวนตามสูตร');
                        swal({
                            title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                            text: this.errors,
                            timer: 3000,
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    }
                });
                
                
            }

            if (!this.errors.length) {
                // form.submit();

                // var vm = this;
                swal({
                    title: "Warning",
                    text: "เมื่อบันทึกแล้วจะสามารถแก้ไขได้ เฉพาะข้อมูลวัตถุดิบเท่านั้น ยืนยันการบันทึกหรือไม่?",
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function(isConfirm) {
                    if (isConfirm) {
                        form.submit();

                        // swal({
                        //     title: "Success",
                        //     text: '',
                        //     timer: 3000,
                        //     type: "success",
                        //     showCancelButton: false,
                        //     showConfirmButton: false
                        // });

                        // axios.post(`/pm/settings/production-formula`, params)
                        // .then(res => {
                        //     console.log('ฉันมาทำอะไรที่นี่ !!!');
                        //     // if (res.data.data.status == 'S') {
                        //     //     location.href = this.pRoleRoute;
                        //     // }
                        // });
                    } else {
                        console.log('ยกเลิกการบันทึก');

                        swal({
                            title: "มีข้อผิดพลาด",
                            text: '',
                            timer: 3000,
                            type: "success",
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    }
                });
            }

            e.preventDefault();
        },

        async getDate() {
            if (this.period_year) {
                
                this.selectedData = this.years.find(list => {
                    return list.year_thai == this.period_year;
                });

                this.budget_start_date = this.selectedData.start_date_thai;
                this.budget_end_date   = this.selectedData.end_date_thai;

                // console.log('budget_start_date <--> ' + this.budget_start_date);
                // console.log('budget_end_date <--> '   + this.budget_end_date);


            } else {
                this.budget_start_date = '';
                this.budget_end_date   = '';
            }
        },

        getFolmulaTypeDesc() {
            if (this.folmula_type) {
                this.selectedData = this.formulaTypes.find(data => {
                    return data.lookup_code == this.folmula_type;
                });
                this.folmula_type_desc = this.selectedData.description;
            } else {
                this.folmula_type_desc = '';
            }
        },
    }
}
</script>