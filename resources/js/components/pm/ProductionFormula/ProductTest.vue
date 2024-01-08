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
                                    class="w-100" 
                                    :remote-method="getItemHeaderList"
                                    @change="getVersion(); getItemHeaderList(); getUom();">              
                        <el-option  v-for="item in itemHeaderLists"
                                    :key="item.inventory_item_id"
                                    :label="item.item_number + ' : ' + item.item_desc"
                                    :value="item.inventory_item_id">

                        </el-option>
                    </el-select>
                </div>
                <div class="col-md-4">
                    <label> สถานะ </label>
                    <input type="hidden" name="status"  :value="status" autocomplete="off">
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
                    </el-select>
                
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
                                    clearable
                                    class="w-100" 
                                    @change="getVersion(); getWipStep();">              
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
                    <label> วันที่เริ่มใช้งาน </label>
                    <el-date-picker 
                        onkeydown="return event.key != 'Enter';"
                        v-model="start_date"
                        style="width: 100%;"
                        type="date"
                        placeholder="วันที่เริ่มต้น"
                        name="start_date"
                        format="dd-MM-yyyy"
                        >
                    </el-date-picker> 
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
                                    clearable
                                    class="w-100" 
                                    @change="getWipStep()">              
                        <el-option  v-for="(routing, index) in routings"
                                    :key="index"
                                    :label="index"
                                    :value="index">

                        </el-option>
                    </el-select>
                    <!-- <label> ขั้นตอนการทำงาน <span class="text-danger">*</span></label>
                    <input type="hidden" name="wip_step"  :value="wip_step" autocomplete="off">
                    <el-select  v-model="wip_step"
                                    filterable
                                    remote
                                    reserve-keyword
                                    clearable
                                    class="w-100" 
                                    :disabled="loadingWipStep"
                                    @change="getVersion(); getMachineType();">              
                        <el-option  v-for="wipStepHeader in wipSteps"
                                    :key="wipStepHeader.oprn_id"
                                    :label="wipStepHeader.oprn_class_desc + ' : ' + wipStepHeader.oprn_desc"
                                    :value="wipStepHeader.oprn_id">

                        </el-option>
                    </el-select> -->
                </div>
                <div class="col-md-4">
                    <label> ประเภทเครื่องจักร <span class="text-danger">*</span></label>
                    <input type="hidden" name="machine"  :value="machine" autocomplete="off">
                    <el-select  v-model="machine"
                                    filterable
                                    remote
                                    reserve-keyword
                                    clearable
                                    class="w-100" 
                                    :disabled="loadingMachine"
                                    @change="getVersion()">              
                        <el-option  v-for="machineList in machineLists"
                                    :key="machineList.lookup_code"
                                    :label="machineList.description"
                                    :value="machineList.lookup_code">

                        </el-option>
                    </el-select>
                </div>
                
                <div class="col-md-4">
                    <label> วันที่สิ้นสุดการใช้งาน </label>
                    <el-date-picker 
                        onkeydown="return event.key != 'Enter';"
                        v-model="end_date"
                        style="width: 100%;"
                        type="date"
                        placeholder="วันที่เริ่มต้น"
                        name="end_date"
                        format="dd-MM-yyyy"
                        >
                    </el-date-picker> 
                </div>
            </div>
            <div class="row mt-2">
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
                    <label> วันที่สร้าง </label>
                    <el-input name="create_date" v-model="create_date" disabled></el-input>
                </div>
                <div class="col-md-4">
                    <!-- <label> Orgranization </label>
                    <el-input name="org_code" v-model="org_code" disabled></el-input> -->
                </div>
            </div>  
        </div>
        <div class="mt-3">
            <!-- <process 
                :routings="routings"
                :default-step="defaultIngredientStep"
                :default-items="defaultIngredientItems"
                :wip-steps="wipSteps"
                :wip-step="this.wip_step"
                :default-steps="ingredientSteps"
                :default-routing-id="routing_id"
                :org-id="org_id"
                :routing-desc="this.routing_desc"
                @lines="resLines"
            ></process> -->

            <productionProcess 
                :routings="routings"
                :default-step="defaultIngredientStep"
                :default-items="defaultIngredientItems"
                :wip-steps="wipSteps"
                :wip-step="this.wip_step"
                :default-steps="ingredientSteps"
                :default-routing-id="routing_id"
                :org-id="org_id"
                :routing-desc="this.routing_desc"
                @lines="resLines"
            ></productionProcess>
        </div>           

        
    <!-- </div> -->
</form>
</template>

<script>

import productionProcess from './ProductionProcess.vue'
// import productionTest from './ProductTest.vue'
import process from './Process.vue'

import moment from 'moment';

export default {
    props:['organizationCode', 'users', 'machineTypes', 'routings', 'wipSteps', 'user', 'organizations', 'defaultValue', 'defaultIngredientStep', 
           'defaultIngredientItems', 'oprns', 'ingredientSteps', 'oprnClass', 'formulaStatus', 'wipStepHeaders', 'urlSave', 'urlReset', 'formulaTypes'],
    components: {
        productionProcess,
        // productionTest,
        process,
    },
    data() {
        return {
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
            start_date:        this.defaultValue  ?  this.defaultValue.start_date        : Date(),
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
        this.getItemHeaderList();
        // this.getUom();
        this.orgCode();

        // console.log(moment(String(Date())).format('DD-MM-yyyy'));
        // this.updateValue();
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
        async getVersion(query) {

            this.version = '',

            axios.get("/pm/ajax/get-version", {
                params: {
                    inventory_item_id: this.inventory_item_id,
                    folmula_type:      this.folmula_type,
                    wip_step:          this.wip_step,
                    machine:           this.machine,
                    query: query,
                }
            })
            .then(res => {
                if (this.inventory_item_id || this.folmula_type || this.wip_step || this.machine) {
                    this.version = res.data;
                } else {
                    this.version = '';
                }
                
            })
            .catch(err => {
                console.log(err)
            });
        },
        async getUom(query) {

            if (!this.inventory_item_id) {
                this.uom_code  = '';
            } 

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
                this.uomLists  = res.data.data.uomLists;
                this.uom_code  = res.data.data.uom;
                
                this.loadingUom = false;
               
            })
            .catch(err => {
                console.log(err)
            });
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
            if (!this.wip_step) {
                this.machine  = '';
            }

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
        },

        async getWipStep() {
            this.loadingWipStep = true;

            
            this.selectedData = this.formulaTypes.find(data => {
                return data.lookup_code == this.folmula_type;
            });
            
            if (this.selectedData.description == 'สูตรใช้จริง') {
                if (this.org_code == 'MG6' || this.org_code == 'M05') {
                    if (this.routing_desc) {
                        this.loadingWipStep = false;
                    }
                }
            } else {
                this.wip_step = '';
            }

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
                if (this.folmula_type == 'สูตรใช้จริง') {
                    if (this.org_code == 'MG6' || this.org_code == 'M05') {
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

                if (this.folmula_type == 'สูตรใช้จริง') {
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

                    if (!line.ingredient_folmula_qty) {
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
    }
}
</script>