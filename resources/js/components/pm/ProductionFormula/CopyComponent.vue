<template>
    <div>
        <div>
            <h5>ต้นแบบ</h5>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-7">
                    <label> รหัสสินค้า </label>
                    <div class="row">
                        <div class="col-md-5">
                            <el-select  v-model="default_inventory_item_id"
                                            filterable
                                            remote
                                            reserve-keyword
                                            clearable
                                            class="w-100" 
                                            disabled
                                            placeholder="">              
                                <el-option  v-for="item in items"
                                            :key="item.inventory_item_id"
                                            :label="item.item_number"
                                            :value="item.inventory_item_id">

                                </el-option>
                            </el-select>
                        </div>
                        <div class="col-md-7">
                            <el-input v-model="default_item_desc" disabled></el-input>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <label> ประเภทสูตร </label>
                    <el-select  v-model="default_folmula_type"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                disabled
                                placeholder="">              
                        <el-option  v-for="folmulaType in formulaTypes"
                                    :key="folmulaType.lookup_code"
                                    :label="folmulaType.description"
                                    :value="folmulaType.lookup_code">

                        </el-option>
                    </el-select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-1"></div>
                <div class="col-md-7">
                    <label> จำนวนผลผลิต </label>
                    <div class="row">
                        <div class="col-md-5">
                            <el-input v-model="default_qty" disabled></el-input>
                            
                        </div>
                        <div class="col-md-4">
                            <el-input v-model="uom_desc" disabled></el-input>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <label> Version </label>
                    <el-input v-model="default_version" disabled></el-input>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-1"></div>
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-5">
                            <label> ขั้นตอนการทำงาน </label>
                            <!-- <el-input v-model="default_wip_step" disabled></el-input> -->
                            <!-- ปิด select เนื่องจาก ใช้แสดงอย่างเดียว -->
                            <!-- <input type="hidden" name="default_wip_step"  :value="default_wip_step" autocomplete="off">
                            <el-select  v-model="default_wip_step"
                                            filterable
                                            remote
                                            reserve-keyword
                                            clearable
                                            class="w-100" 
                                            disabled
                                            placeholder="">              
                                <el-option  v-for="wipStep in wipSteps"
                                            :key="wipStep.oprn_id"
                                            :label="wipStep.oprn_class_desc + ' : ' + wipStep.oprn_desc"
                                            :value="wipStep.oprn_id">

                                </el-option>
                            </el-select> -->
                            <el-input v-model="wip_step_desc" disabled></el-input>
                        </div>
                        <div class="col-md-4">
                            <label> ปีงบประมาณ </label>
                            <input type="hidden" name="default_period_year"  :value="default_period_year" autocomplete="off">
                            <el-select  v-model="default_period_year"
                                            filterable
                                            remote
                                            reserve-keyword
                                            clearable
                                            class="w-100" 
                                            disabled
                                            placeholder="">              
                                <el-option  v-for="(periodYear, key) in periodYears"
                                            :key="key"
                                            :label="periodYear.year_thai"
                                            :value="periodYear.year_thai">

                                </el-option>
                            </el-select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <label> ประเภทเครื่องจักร </label>
                    <el-select  v-model="default_machine"
                                :disabled="disableInput.default_machine"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                disabled
                                placeholder="">              
                        <el-option  v-for="machineType in machineTypes"
                                    :key="machineType.lookup_code"
                                    :label="machineType.description"
                                    :value="machineType.lookup_code">

                        </el-option>
                    </el-select>
                </div>
            </div>
        </div>
        <hr>
        <div>
            <h5>คัดลอก</h5>
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-7">
                    <label> รหัสสินค้า </label>
                    <div class="row">
                        <div class="col-md-5">
                            <input type="hidden" name="inventory_item_id"  :value="inventory_item_id" autocomplete="off">
                            <el-select v-model="inventory_item_id"
                                            filterable
                                            ref="inventory_item_id"
                                            remote
                                            reserve-keyword
                                            clearable
                                            class="w-100" 
                                            @change="getItemDesc(); getVersion(); handleItemChange()"
                                            placeholder="">        
                                <el-option  v-for="item in items"
                                            :key="item.inventory_item_id"
                                            :label="item.item_number + ' : ' + item.item_desc"
                                            :value="item.inventory_item_id">

                                </el-option>
                            </el-select>
                        </div>
                        <div class="col-md-7">
                            <el-input v-model="item_desc" disabled></el-input>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <label> ประเภทสูตร </label>
                    <input type="hidden" name="folmula_type"  :value="folmula_type" autocomplete="off">
                    <!-- ถ้าสูตาใช้จริงจะคัดลองเป็นประเภทอื่นไม่ได้ -->
                    <el-select  v-model="folmula_type"
                                filterable
                                remote
                                :disabled="defaultValue.folmula_type == 1 || this.organization_code == 'MG6' || this.organization_code == 'M05'"
                                reserve-keyword
                                clearable
                                class="w-100" 
                                @change="getVersion(); getWipStep();"
                                placeholder="">              
                                
                                <!-- :disabled="this.organization_code == 'MG6'" -->
                        <el-option  v-for="folmulaType in formulaTypes"
                                    :key="folmulaType.lookup_code"
                                    :label="folmulaType.description"
                                    :value="folmulaType.lookup_code">

                        </el-option>
                    </el-select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-1"></div>
                <div class="col-md-7">
                    <label> จำนวนผลผลิต </label>
                    <div class="row">
                        <div class="col-md-5">
                            <el-input v-model="qty" disabled></el-input>
                            
                        </div>
                        <div class="col-md-4">
                            <el-input v-model="uom_desc" disabled></el-input>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <label> Version </label>
                    <input type="hidden" name="version"  :value="version" autocomplete="off">
                    <el-input v-model="version" disabled></el-input>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-1"></div>
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-5">
                            
                            <label> ขั้นตอนการทำงาน </label>
                            <!-- <el-input v-model="wip_step" disabled></el-input> -->
                            <input type="hidden" name="wip_step"  :value="wip_step" autocomplete="off">
                            <!-- <el-select  v-model="wip_step"
                                            filterable
                                            remote
                                            reserve-keyword
                                            clearable
                                            class="w-100" 
                                            :disabled="loadingWipStep || disableInput.wip_step"
                                            @change="getVersion(); getMachineType();">              
                                <el-option  v-for="wipStep in wipSteps"
                                            :key="wipStep.oprn_id"
                                            :label="wipStep.oprn_class_desc + ' : ' + wipStep.oprn_desc"
                                            :value="wipStep.oprn_id">

                                </el-option>
                            </el-select> -->
                            <!-- ปิด select เนื่องจาก ใช้แสดงอย่างเดียว -->
                            <!-- <el-select  v-model="wip_step"
                                            filterable
                                            remote
                                            reserve-keyword
                                            clearable
                                            class="w-100" 
                                            disabled>              
                                <el-option  v-for="wipStep in wipSteps"
                                            :key="wipStep.oprn_id"
                                            :label="wipStep.oprn_class_desc + ' : ' + wipStep.oprn_desc"
                                            :value="wipStep.oprn_id">

                                </el-option>
                            </el-select> -->
                            <el-input v-model="wip_step_desc" disabled></el-input>
                        </div>
                        <div class="col-md-4">
                            <label> ปีงบประมาณ </label>
                            <input type="hidden" name="period_year"  :value="period_year" autocomplete="off">
                            <el-select  v-model="period_year"
                                            filterable
                                            remote
                                            reserve-keyword
                                            clearable
                                            class="w-100"
                                            :disabled="loadingBudgetYear"
                                            placeholder=""
                                            @change="checkInvoiceFlag()">  
                                            <!-- getVersion();             -->
                                <el-option  v-for="(periodYear, key) in periodYears"
                                            :key="key"
                                            :label="periodYear.year_thai"
                                            :value="periodYear.year_thai">

                                </el-option>
                            </el-select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <input type="hidden" name="machine"  :value="machine" autocomplete="off">
                    <label> ประเภทเครื่องจักร </label>
                    <!-- <el-select  v-model="machine"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                @change="getVersion()"
                                :disabled="machineDisabled">              
                        <el-option  v-for="machineType in machineTypes"
                                    :key="machineType.lookup_code"
                                    :label="machineType.description"
                                    :value="machineType.lookup_code">

                        </el-option>
                    </el-select> -->
                    <input type="hidden" name="machine"  :value="machine" autocomplete="off">
                    <el-select  v-model="machine"
                                    filterable
                                    remote
                                    reserve-keyword
                                    clearable
                                    class="w-100" 
                                    :disabled="loadingMachine || disableInput.machine || organization_code == 'M06'"
                                    @change="getVersion()"
                                    placeholder="">              
                        <el-option  v-for="machineList in machineLists"
                                    :key="machineList.lookup_code"
                                    :label="machineList.description"
                                    :value="machineList.lookup_code">

                        </el-option>
                    </el-select>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props:['items', 'oprns', 'machineTypes', 'defaultValue', 'users', 'routings', 'wipSteps', 'user', 'ingredientSteps', 'formulaTypes', 'wipStepHeaders', 'periodYears'],

        data(){
            return {
                //ต้นฉบับ
                default_inventory_item_id: this.defaultValue.inventory_item_id ? this.defaultValue.inventory_item_id : '',
                default_item_desc:         '',
                default_folmula_type:      this.defaultValue.folmula_type  ?  Number(this.defaultValue.folmula_type) : '',
                // default_folmula_type:      this.defaultValue.folmula_type  ? this.defaultValue.folmula_type      : '',
                default_qty:               this.defaultValue.qty           ? this.numberWithCommas(this.defaultValue.qty)               : '',
                default_uom:               this.defaultValue.uom           ? this.defaultValue.uom               : '',
                default_version:           this.defaultValue.version       ? this.defaultValue.version           : '',
                default_wip_step:          this.defaultValue.wip           ? Number(this.defaultValue.wip)       : '',
                default_machine:           this.defaultValue.machine       ? Number(this.defaultValue.machine)   : '',
                default_period_year:       this.defaultValue.period_year   ? this.defaultValue.period_year       : '',

                //คัดลอก
                inventory_item_id: this.defaultValue.inventory_item_id ? this.defaultValue.inventory_item_id : '',
                item_desc:         '',
                folmula_type:      this.defaultValue.folmula_type      ?  Number(this.defaultValue.folmula_type) : '',
                // folmula_type:      this.defaultValue.folmula_type      ? this.defaultValue.folmula_type      : '',
                qty:               this.defaultValue.qty               ? this.numberWithCommas(this.defaultValue.qty)               : '',
                uom:               this.defaultValue.uom               ? this.defaultValue.uom               : '',
                version:           this.defaultValue.version           ? this.defaultValue.version           : '',
                wip_step:          this.defaultValue.wip               ? Number(this.defaultValue.wip)       : '',
                machine:           this.defaultValue.machine           ? Number(this.defaultValue.machine)   : '',
                period_year:       '',
                
                organization_code: this.defaultValue.organization      ? this.defaultValue.organization.organization_code   : '',

                machineDisabled:   true,
                // machineDisabled:   this.defaultValue.folmula_type == 'สูตรใช้จริง' ? false : true,
                loadingWipStep:    this.defaultValue  ?  this.defaultValue.wip ? false : true  : true,
                loadingMachine:    this.defaultValue  ?  this.defaultValue.machine ? false : true  : true,
                machineLists: [],
                loadingBudgetYear: true,
                wip_step_desc: this.defaultValue.wip_step_desc ? this.defaultValue.wip_step_desc  : '',
                uom_desc:      this.defaultValue.uom_desc      ? this.defaultValue.uom_desc       : '',
            
        // ----------------------------------------------------------------------------------------

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
                disableInput: {
                    wip_step: false,
                    machine: false,
                }
            }
        },
        watch:{
            folmula_type(newValue) {
                this.disableInputFunc();
            }
        },
        mounted() {
            if (this.default_inventory_item_id) {
                this.selectedData = this.items.find( i => {
                    if (i.inventory_item_id == this.default_inventory_item_id) {
                        this.default_item_desc    = i.item_desc;
                        this.item_desc            = i.item_desc;
                    }
                });
            }
            setTimeout(() => {
                   $(this.$refs.inventory_item_id.$el).find('input').val($(this.$refs.inventory_item_id.$el).find('input').val().split(' : ')[0])
                }, 100);
            // if (this.defaultValue.wip) {
            //     this.selectedData = this.wipSteps.find( i => {
            //         if (i.oprn_id == this.defaultValue.wip) {
            //             this.default_wip_step  = i.oprn_class_desc;
            //             this.wip_step          = i.oprn_class_desc;
            //             // this.getUom();
            //         }
            //     });
            // }

            if (this.defaultValue.folmula_type) {
                this.selectedData = this.formulaTypes.find(data => {
                    return data.lookup_code == this.folmula_type;
                });

                if (this.selectedData.description == 'สูตรใช้จริง') {
                    this.machineDisabled = false;
                }

                if (this.selectedData.description == 'สูตรมาตรฐาน') {
                    this.loadingBudgetYear = false;
                    this.period_year       = this.defaultValue.creation_year;
                }
                
            }
            if (this.folmula_type == 1) {
                if (this.org_code == 'MG6' || this.org_code == 'MPG' || this.org_code == 'M05') {
                    this.loadingWipStep = false;
                }
            }
            if (this.wip_step) {
                this.getMachineType();
            }

            this.getVersion();
        },
        methods: {
           numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            },

            handleItemChange() {
                setTimeout(() => {
                   $(this.$refs.inventory_item_id.$el).find('input').val($(this.$refs.inventory_item_id.$el).find('input').val().split(' : ')[0])
                }, 100);
            },

            getItemDesc() {
                if (this.inventory_item_id) {
                    this.selectedData = this.items.find( i => {
                        if (i.inventory_item_id == this.inventory_item_id) {
                            this.item_desc = i.item_desc;
                        }
                    });
                } 
                else {
                    this.item_desc = '';
                }
            },

            async getVersion() {
                this.version = '',
                // console.log('xxxx');
                axios.get("/pm/ajax/get-version", {
                    params: {
                        inventory_item_id: this.inventory_item_id,
                        folmula_type:      this.folmula_type,
                        wip_step:          this.wip_step,
                        machine:           this.machine,
                        // W. 11/07/22 -เพิ่มปีงบประมาณมาเช็ค version
                        period_year:       this.period_year,
                    }
                })
                .then(res => {
                    if (this.inventory_item_id || this.folmula_type || this.defaultValue.wip || this.machine) {
                        this.version = res.data;
                    } else {
                        this.version = '';
                    }
                    
                })
                .catch(err => {
                    console.log(err)
                });
            },
            
            async getMachineType(query) {
                if (!this.wip_step) {
                    this.machine  = '';
                }

                this.selectedData = this.formulaTypes.find(data => {
                    return data.lookup_code == this.folmula_type;
                });

                if (this.selectedData.description == 'สูตรใช้จริง') {

                    axios.get("/pm/ajax/get-machine-type", {
                        params: {
                            wip_step:   this.wip_step,
                            org_code:   this.organization_code,
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
            },
            async disableInputFunc() {
                let vm = this;
                if (vm.folmula_type == 1) { // ใช้จริง
                    // vm.loadingWipStep = false;
                    vm.disableInput.wip_step = false;
                    vm.disableInput.machine = false;
                    vm.getWipStep()
                } else {
                    vm.disableInput.wip_step = true;
                    vm.disableInput.machine = true;
                    vm.wip_step = '';
                    vm.machine = '';
                }
            },
            async getWipStep() {
                this.loadingWipStep = true;

                // if (this.folmula_type == 'สูตรใช้จริง') {
                if (this.folmula_type == 1) {
                    if (this.organization_code == 'MG6' || this.organization_code == 'MPG' || this.organization_code == 'M05') {
                        this.loadingWipStep = false;
                    }
                } else {
                    this.wip_step = '';
                }

                if (this.folmula_type) {
                    this.selectedData = this.formulaTypes.find(data => {
                        return data.lookup_code == this.folmula_type;
                    });

                    if (this.selectedData.description == 'สูตรมาตรฐาน') {

                        this.loadingBudgetYear = false;
                        this.period_year       = this.defaultValue.creation_year;

                    } else {
                        
                        this.loadingBudgetYear = true;
                        this.period_year       = '';
                        this.budget_start_date = '';
                        this.budget_end_date   = '';

                    }
                }

                this.getMachineType();
            },
            async checkInvoiceFlag() {
                // axios.get("/pm/ajax/get-invoice-flag", {
                //     params: {
                //         inventory_item_id: this.inventory_item_id,
                //         folmula_type:      this.folmula_type,
                //         period_year:       this.period_year,
                //     }
                // })
                // .then(res => {
                //     if (res.data == 'Y') {
                //         this.period_year = '';
                //         swal('Warning', 'กรุณาเลือกปีงบประมาณใหม่ เนื่องจากปีงบประมาณนี้ กองบริหารต้นทุนนำไปใช้แล้ว', 'warning');
                //     }

                    this.getVersion();
                    
                // })
                // .catch(err => {
                //     console.log(err)
                // });
            }
        },
    }
</script>
<style type="text/css">
    .el-select-dropdown{
        z-index: 9999 !important;
    }
</style>