<template>
    <form id="submitForm" :action="urlSave" method="post" @submit.prevent="checkForm" onkeydown="return event.key != 'Enter';">
        <input type="hidden" name="_token" :value="csrf">
        <input type="hidden" name="_method" value="PUT">
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
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-4">
                    <label> รหัสสินค้า <span class="text-danger">*</span></label>
                    <input type="hidden" name="inventory_item_id"  :value="inventory_item_id" autocomplete="off">
                    <el-select  v-model="inventory_item_id"
                                    filterable
                                    placeholder=""
                                    remote
                                    reserve-keyword
                                    clearable
                                    class="w-100" 
                                    :remote-method="getItemHeaderList"
                                    @change="getVersion('inventory_item'); getItemHeaderList(); getUom();"
                                    :disabled="this.disabledEdit">              
                        <el-option  v-for="(item, key) in itemHeaderLists"
                                    :key="key"
                                    :label="item.item_number + ' : ' + item.item_desc"
                                    :value="item.inventory_item_id">

                        </el-option>
                    </el-select>
                </div>
                <div class="col-md-4">
                    <label> สถานะ </label>
                    <el-input name="status" :value="status" disabled></el-input>
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
                                    reserve-keyword
                                    placeholder=""
                                    clearable
                                    class="w-100" 
                                    @change="getVersion('folmula_type'); getWipStep();"
                                    :disabled="this.disabledEdit">              
                        <el-option  v-for="(folmulaType, key) in formulaTypes"
                                    :key="key"
                                    :label="folmulaType.description"
                                    :value="folmulaType.lookup_code">

                        </el-option>
                    </el-select>
                </div>
                <div class="col-md-4">
                    <label> Version </label>
                    <input type="hidden" name="version"  :value="version">
                    <el-input name="version" v-model="version" disabled></el-input>
                </div>
                <div class="col-md-4">
                    <label> ปีงบประมาณ<span class="text-danger">*</span> </label>
                    <input type="hidden" name="period_year"  :value="period_year" autocomplete="off">
                    <el-select  v-model="period_year"
                                    filterable
                                    remote
                                    reserve-keyword
                                    placeholder=""
                                    clearable
                                    class="w-100" 
                                    @change="getDate(); getVersion();"
                                    :disabled="loadingBudgetYear || this.disabledEdit">              
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
                                    placeholder=""
                                    reserve-keyword
                                    clearable
                                    class="w-100" 
                                    :disabled="this.disabledEdit">              
                                    <!-- @change="getWipStepList()">               -->
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
                            <el-input name="qty" v-model="qty"  @input="onlyNumeric" :disabled="this.disabledEdit"></el-input>
                        </div>
                        <div class="col-md-5">
                            <label> หน่วยนับ <span class="text-danger">*</span></label>
                            <input type="hidden" name="uom_code"  :value="uom_code" autocomplete="off">
                            <el-select  v-model="uom_code"
                                            filterable
                                            remote
                                    placeholder=""
                                            reserve-keyword
                                            clearable
                                            class="w-100" 
                                            :remote-method="getUom"
                                            :disabled="loadingUom || this.disabledEdit">              
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

                    <!-- ----------------------------------------------------------- -->

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
                            <el-radio v-model="multi_wip_step" :label="wipStepHeader.oprn_id" name="multi_wip_step">
                                {{ wipStepHeader.oprn_desc }}
                            </el-radio>
                        </div>
                            
                    </div>
                    <div v-else>
                        <input type="hidden" name="wip_step"  :value="wip_step" autocomplete="off">
                        <el-select  v-model="wip_step"
                                        filterable
                                        remote
                                    placeholder=""
                                        reserve-keyword
                                        clearable
                                        class="w-100" 
                                        :disabled="loadingWipStep || routing_desc == '' || this.disabledEdit"
                                        @change="getVersion('wip_step'); getMachineType(); testTest();">              
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
                                            remote
                                    placeholder=""
                                            reserve-keyword
                                            clearable
                                            class="w-100" 
                                            :disabled="loadingMachine || org_code == 'MPG' || this.disabledEdit || org_code == 'M06' || org_code == 'M12'"
                                            @change="getVersion('machine')">              
                                <el-option  v-for="machineList in machineLists"
                                            :key="machineList.lookup_code"
                                            :label="machineList.description"
                                            :value="machineList.lookup_code">

                                </el-option>
                            </el-select>
                        </div>
                        <div class="col-md-6">
                            <label> วันที่สิ้นสุดการใช้งาน </label>
                            <el-input name="budget_end_date" v-model="budget_end_date" disabled></el-input>
                        </div>
                    </div>
                    <div class="row" v-if="this.check_org_multi_wip">
                        <div class="col-md-12  mt-2"> 
                            <label> หมายเหตุ </label>
                            <div>
                                <el-input type="textarea" class="required" name="comments" v-model="comments" rows="1" maxlength="250" :disabled="this.disabledEdit" show-word-limit/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2" v-if="this.loadingWipStep && !this.check_org_multi_wip">
                <div class="col-md-4">
                    <div v-for="wipStepHeader in wipSteps[routing_desc]">
                        <el-radio v-model="multi_wip_step" :label="wipStepHeader.oprn_id" name="multi_wip_step">
                            {{ wipStepHeader.oprn_desc }}
                        </el-radio>
                    </div>
                </div>
                <div class="col-md-8"> 
                    <label> หมายเหตุ </label>
                    <div>
                        <el-input type="textarea" class="required" name="comments" v-model="comments" rows="1" maxlength="250" :disabled="this.disabledEdit" show-word-limit/>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-9"> </div>
                <div class="col-md-3 text-right"> 
                    กองบริหารต้นทุนนำไปใช้แล้ว <input type="checkbox" name="invoice_flag" v-model="invoice_flag" disabled>
                </div>
            </div>
        </div>
        <div v-if="this.orgMutiWip">
            <process 
                :routings="routings"
                :default-step="defaultIngredientStep"
                :default-items="defaultIngredientItems"
                :wip-steps="wipSteps[routing_desc]"
                :wip-step="this.multi_wip_step"
                :default-steps="ingredientSteps"
                :default-routing-id="routing_id"
                :org-id="org_id"
                :items="items"
                :routing-desc="this.routing_desc"
                :org-code="organizationCode"
                @lines="resLines"
            ></process>
        </div>
        <div v-else>
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
                    :items="items"
                    :routing-desc="this.routing_desc"
                    :org-code="organizationCode"
                    :folmula-type="this.folmula_type"
                    @lines="resLines"
                    :folmula-type-desc="this.folmula_type_desc"
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
                    :items="items"
                    :routing-desc="this.routing_desc"
                    :org-code="organizationCode"
                    @lines="resLines"
                ></process>
            </div>
        </div>
    </form>
</template>

<script>

import productionProcess from './ProductionProcess.vue'
import productionTest from './ProductTest.vue'
import process from './Process.vue'
import processMultiWip from './ProcessMultiWipComponent.vue'

import moment from 'moment';

import {isInRange, jsDateToString, toJSDate, toThDateString} from '../../../dateUtils'

export default {
    props:['users', 'machineTypes', 'routings', 'wipSteps', 'user', 'organizations', 'defaultValue', 'defaultIngredientStep', 
           'defaultIngredientItems', 'oprns', 'ingredientSteps', 'oprnClass', 'items', 'formulaStatus', 'wipStepHeaders', 'urlSave', 'urlReset', 
           'formulaTypes', 'years', 'organizationCode', 'orgMutiWip'],
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

            inventory_item_id: this.defaultValue     ?  this.defaultValue.inventory_item_id : '',
            org_id:            this.defaultValue     ?  this.defaultValue.org_id            : '',
            status:            this.defaultValue     ?  this.defaultValue.status            : '',
            folmula_type:      this.defaultValue     ?  this.defaultValue.folmula_type ? Number(this.defaultValue.folmula_type)  : ''  : '',
            // folmula_type:      this.defaultValue     ?  this.defaultValue.folmula_type      : '',
            version:           this.defaultValue     ?  this.defaultValue.version           : '',
            approved_by:       this.defaultValue     ?  this.defaultValue.approved_by       : '',
            machine:           this.defaultValue     ?  this.defaultValue.machine ? Number(this.defaultValue.machine)  : ''  : '',
            wip_step:          this.defaultValue     ?  this.defaultValue.wip     ? Number(this.defaultValue.wip)      : ''  : '',
            create_date:       this.defaultValue     ?  moment(String(this.defaultValue.creation_date)).format('DD-MM-yyyy') : '',
            qty:               this.defaultValue     ?  this.defaultValue.qty.replace(/\B(?=(\d{3})+(?!\d))/g, ",")          : '',
            start_date:        this.defaultValue     ?  this.defaultValue.start_date        : '',
            end_date:          this.defaultValue     ?  this.defaultValue.end_date          : '',
            routing_id:        this.defaultValue     ?  this.defaultValue.routing_id        : '',
            org_code:          '',

            wip_uom: '',
            uom_code:          this.defaultValue  ?  this.defaultValue.uom               : '',

            default_wip:               this.defaultValue  ?  this.defaultValue.wip     ? Number(this.defaultValue.wip)      : ''  : '',
            default_folmula_type:      this.defaultValue  ?  this.defaultValue.folmula_type : '',
            default_inventory_item_id: this.defaultValue  ?  this.defaultValue.inventory_item_id : '',
            default_machine:           this.defaultValue  ?  this.defaultValue.machine : '',

            loadingUom:        this.defaultValue  ?  this.defaultValue.inventory_item_id ? false : true  : true,
            loadingWipStep:    true,
            // loadingWipStep:    this.defaultValue  ?  this.defaultValue.wip ? false : true  : true,
            loadingMachine:    this.defaultValue  ?  this.defaultValue.machine ? false : true  : true,

            uomLists:         [],
            itemHeaderLists:  [],
            machineLists: [],

            headerId:             this.defaultValue  ? this.defaultValue.recipe_id      : '',
            creation_date_format: this.defaultValue  ?  this.defaultValue.creation_date_format  : '',
  
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
            routing_desc:       this.defaultValue  ? this.defaultValue.routing_desc      : '',

            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

            //ปีงบประมาณ
            period_year: this.defaultValue  ? this.defaultValue.period_year      : '',
            loadingBudgetYear: true,
            budget_start_date: '',
            budget_end_date: '',

            //ฝ่านต้นทุน
            invoice_flag: this.defaultValue  ? this.defaultValue.invoice_flag == 'Y' ? true : false : false,


            default_period_year: this.defaultValue  ? this.defaultValue.period_year      : '',
            default_budget_start_date: '',
            default_budget_end_date: '',

            disabledEdit: this.defaultValue ? true : false, 

            multi_wip_step: '',
            check_org_multi_wip: false,
            folmula_type_desc: '',
            comments: this.defaultValue  ? this.defaultValue.comments      : '',
        }
    },
    // watch: {
    //     routing_desc : async function () {
    //         if (this.routing_desc) {
    //             this.getWipStep();
    //         }           
    //     },
    // },
    mounted(){ 
        this.getItemHeaderList(this.inventory_item_id);
        

        if (this.inventory_item_id) {
            this.getUom();
        }
        this.orgCode();

        if (this.wip_step) {
            this.getMachineType();
        }

        // if (this.folmula_type == 'สูตรใช้จริง') {
        if (this.folmula_type) {

            this.selectedData = this.formulaTypes.find(data => {
                return data.lookup_code == this.folmula_type;
            });

            this.folmula_type_desc = this.selectedData.description;

            if (this.selectedData.description == 'สูตรมาตรฐาน') {
                this.loadingWipStep = true;
            }

            if (this.org_code == 'MG6' || this.org_code == 'MPG' || this.org_code == 'M05') {
                // this.loadingWipStep = false;
                this.loadingWipStep = true;
            }
        }

        if (this.status) {
            if (this.status == 'New') {
                this.status = 'สร้างใหม่';
            } else if (this.status == 'Approved for General Use') {
                this.status = 'อนุมัติ';
            } else if (this.status == 'Obsolete/Archived') {
                this.status = 'ยกเลิก';
            }
        }

        if (this.routing_id) {
            this.selectedData = this.wipSteps[this.routing_desc].find( i => {
                if (i.routing_id == this.routing_id) {
                    this.routing_desc = i.routing_desc;
                }
            });
        }


        if (this.start_date) {
            this.start_date = moment(String(this.start_date)).format('yyyy-MM-DD')
        }
        if (this.end_date) {
            this.end_date = moment(String(this.end_date)).format('yyyy-MM-DD')
        }


        if (this.folmula_type) {
            this.selectedData = this.formulaTypes.find(data => {
                return data.lookup_code == this.folmula_type;
            });

            if (this.selectedData.description == 'สูตรมาตรฐาน') {

                this.loadingBudgetYear = false;

                if (this.period_year) {
                    this.getDate();
                }

            } else {
                this.period_year       = '';
                this.loadingBudgetYear = true;

            }
        } else {
            this.loadingBudgetYear = true;
        }

        this.loadingWipStep = this.wip_step ? false : true;

        if (this.org_code == 'MPG' || this.org_code == 'M12' || this.org_code == 'M06') {
            this.check_org_multi_wip = true;
        }

        if (this.org_code == 'M06') {
            if (this.wip_step) {
                this.multi_wip_step = this.wip_step;
            } else {
                this.selectedData = this.wipSteps[this.routing_desc].find( i => {
                    if (i.routing_id == this.routing_id && i.routingstep_id == this.defaultValue.routingstep_id) {
                        this.multi_wip_step = i.oprn_id;
                    }
                }); 
            }
            
        } else {
            this.selectedData = this.wipSteps[this.routing_desc].find( i => {
                if (i.routing_id == this.routing_id && i.routingstep_id == this.defaultValue.routingstep_id) {
                    this.multi_wip_step = i.oprn_id;
                }
            }); 
        }

        // if (this.org_code == 'MPG' || this.org_code == 'M12' || this.org_code == 'M06' || this.loadingWipStep) {
        //     if (this.org_code == 'M06') {
        //         this.multi_wip_step = this.wip_step;
        //         // this.selectedData = this.wipSteps[this.routing_desc].find( i => {
        //         //     if (i.routing_id == this.routing_id && i.routingstep_id == this.defaultValue.routingstep_id) {
        //         //         // this.wip_step = i.oprn_id;
        //         //         this.multi_wip_step = i.oprn_id;
        //         //     }
        //         // }); 
        //     } else {
        //         this.selectedData = this.wipSteps[this.routing_desc].find( i => {
        //             if (i.routing_id == this.routing_id && i.routingstep_id == this.defaultValue.routingstep_id) {
        //                 // this.wip_step = i.oprn_id;
        //                 this.multi_wip_step = i.oprn_id;
        //             }
        //         }); 
        //     }
               
        // }
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
                
            })
            .catch(err => {
                console.log(err)
            });
        },
        async getUom(query) {
            
            this.loadingUom = true;

            if (this.inventory_item_id) {
                
                this.uomLists = [];

                axios.get("/pm/ajax/get-uom", {
                    params: {
                        inventory_item_id: this.inventory_item_id,
                        query:             query,
                        org_id:            this.org_id,
                        uom_code:          this.uom_code,
                    }
                })
                .then(res => {

                    this.uomLists   = res.data.data.uomLists;
                    this.uom_code   = res.data.data.uom;
                    this.loadingUom = false;
                
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
        async getVersion(code, query) {
            // console.log('code ---> ' + code);
            
            var vm = this;

            vm.default_period_year       = vm.period_year;
            vm.default_budget_start_date = vm.budget_start_date;
            vm.default_budget_end_date   = vm.budget_end_date;

            swal({
                title: "Warning",
                text: "ต้องการเปลี่ยน Version หรือไม่?",
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
                    });
                    axios.get("/pm/ajax/get-version", {
                        params: {
                            inventory_item_id: vm.inventory_item_id,
                            folmula_type:      vm.folmula_type,
                            wip_step:          vm.wip_step,
                            machine:           vm.machine,
                            header_id:         vm.headerId,
                            query: query,
                            // W. 11/07/22 -เพิ่มปีงบประมาณมาเช็ค version
                            period_year:       vm.period_year,
                        }
                    })
                    .then(res => {
                        if (vm.inventory_item_id || vm.folmula_type || vm.wip_step || vm.machine) {
                            vm.version = res.data;
                            // vm.default_version = vm.version;
                        } else {
                            vm.version = '';
                        }
                        
                    })
                    .catch(err => {
                        console.log(err)
                    });

                    
                } else {
                    console.log('code ---> ' + code);

                    if (code == 'inventory_item') {
                        vm.inventory_item_id = vm.default_inventory_item_id;

                    } else if (code == 'folmula_type') {
                        vm.folmula_type = Number(vm.default_folmula_type);

                        vm.period_year       = vm.default_period_year;
                        vm.budget_start_date = vm.default_budget_start_date;
                        vm.budget_end_date   = vm.default_budget_end_date;

                    } else if (code == 'wip_step') {
                        vm.wip_step = vm.default_wip;

                    } else if (code == 'machine') {
                        vm.machine = vm.default_machine;

                        console.log('machine ---> ' + vm.machine);
                        console.log('default_machine ---> ' + vm.default_machine);

                    }
                }
            });
        },
        async getMachineType(query) {
            if (!this.wip_step) {
                this.machine  = '';
            }

            if (this.folmula_type) {
                this.selectedData = this.formulaTypes.find(data => {
                    return data.lookup_code == this.folmula_type;
                });

                if (this.selectedData.description == 'สูตรใช้จริง') {

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
            this.loadingWipStep = true;

            //  เปิดขั้นตอนการทำงานสำหรับทุกประเภทสูตร
            if (this.folmula_type && this.routing_desc) {
                this.loadingWipStep = false;
            } else {
                this.loadingWipStep = true;
                this.wip_step = '';
            }

            this.getMachineType();

            //สำหรับเปิด-ปิดการใช้งานของปีงบประมาณ และ วันที่เริ่มต้น - วันที่สิ้นสุด
            if (this.folmula_type) {
                if (this.selectedData.description == 'สูตรมาตรฐาน') {

                    this.loadingBudgetYear = false;

                } else {
                    
                    this.loadingBudgetYear = true;
                    this.period_year       = '';
                    this.budget_start_date = '';
                    this.budget_end_date   = '';

                }
            } else {

                this.loadingBudgetYear = true;
                this.period_year       = '';
                this.budget_start_date = '';
                this.budget_end_date   = '';

            }

            // if (this.folmula_type == 1) {
            //     if (this.org_code == 'MG6' || this.org_code == 'MPG' || this.org_code == 'M05') {
            //         if (this.routing_desc) {
            //             this.loadingWipStep = false;
            //         } else {
            //             this.wip_step = '';
            //         }
                    
            //     } else {
            //         this.wip_step = '';
            //     }
            // } else {
            //     this.wip_step = '';
            // }
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
                // if (this.folmula_type == 'สูตรใช้จริง') {
                if (this.folmula_type == 1) {
                    if (this.org_code == 'MG6' || this.org_code == 'MPG' || this.org_code == 'M05') {
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

            if (!this.machine) {

                // if (this.folmula_type == 'สูตรใช้จริง') {
                if (this.folmula_type == 1) {
                    if (this.org_code == 'MG6' || this.org_code == 'M05') {
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

                    this.selectedData = this.formulaTypes.find(data => {
                        return data.lookup_code == this.folmula_type;
                    });

                    if (this.selectedData.description == 'สูตรมาตรฐาน') {
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
                form.submit();
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

            } else {
                this.budget_start_date = '';
                this.budget_end_date   = '';
            }
        },
    }
}
</script>