<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">

                <!-- <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                        <label>หน่วยงาน</label><span class="text-danger"> *</span>
                        <input type="hidden" name="department_code" v-model="deprtmentSelected">
                        <el-select  v-model="deprtmentSelected" clearable filterable 
                                    placeholder="เลือกหน่วยงาน" 
                                    class="w-100">
                            <el-option
                                v-for   ="deprtment in deprtments"
                                :key    ="deprtment.department_code"
                                :label  ="deprtment.meaning + ' : ' + deprtment.description"
                                :value  ="deprtment.department_code" >
                            </el-option>
                        </el-select>
                    </div>     
                </div>   -->

                <div class="row">
                    <div class="col" style="padding-top: 15px;">
                        <label>คลังสำหรับทำรายการ</label><span class="text-danger"> *</span>
                        <input type="hidden" name="wip_transaction_type_id" v-model="wipTransactionSelected">
                        <el-select  v-model="wipTransactionSelected" clearable filterable 
                                    placeholder="เลือกคลังเพื่อทำรายการ" 
                                    class="w-100">
                            <el-option
                                v-for   ="itemWipTransaction  in wipTransaction"
                                :key    ="itemWipTransaction.transaction_type_id"
                                :label  ="itemWipTransaction.attribute3"
                                :value  ="itemWipTransaction.transaction_type_id" >
                            </el-option>
                        </el-select>
                    </div>     
                </div>   

                <div class="row">
                    <div class="col" style="padding-top: 15px;">
                        <label>ประเภท Item</label><span class="text-danger"> *</span>
                        <input type="hidden" name="item_type" v-model="tobaccoItemcatSelected">
                        <el-select  v-model="tobaccoItemcatSelected" clearable filterable 
                                    placeholder="เลือกประเภท Item" 
                                    class="w-100">
                            <el-option
                                v-for   ="tobaccoItemcat in tobaccoItemcats"
                                :key    ="tobaccoItemcat.group_code"
                                :label  ="tobaccoItemcat.meaning + ' : ' + tobaccoItemcat.group_desc"
                                :value  ="tobaccoItemcat.group_code" >
                            </el-option>
                        </el-select>
                    </div>     
                </div>     

                <div class="row">
                    <div class="col-5" style="padding-top: 15px;">
                        <label>คลังต้นทาง</label><span class="text-danger"> *</span>
                        <input type="hidden" name="from_organization_id" v-model="organizationFromSelected">
                        <el-select  v-model="organizationFromSelected" clearable filterable 
                                    placeholder="Organization" 
                                    class="w-100"
                                    @change="getLocationsFrom(organizationFromSelected)">
                            <el-option
                                v-for   ="parameter in parameters"
                                :key    ="parameter.organization_id"
                                :label  ="parameter.organization_code + ' : ' + parameter.hr_all_organization_units.name"
                                :value  ="parameter.organization_id" >
                            </el-option>
                        </el-select>
                    </div>   

                    <div class="col-7" style="padding-top: 43px;">
                        <input  type="hidden" name="from_locator_id" v-model="inventoryFromSelected">
                        <el-select  v-model="inventoryFromSelected" clearable filterable 
                                    :disabled="!organizationFromSelected" 
                                    v-loading="loading.inventoryLocationFrome"
                                    class="w-100"
                                    placeholder="สถานที่จัดเก็บ">
                            <el-option
                                v-for   ="locationFromList in locationFromLists"
                                :key    ="locationFromList.inventory_location_id"
                                :label  ="locationFromList.concatenated_segments + ' : ' + locationFromList.description"
                                :value  ="locationFromList.inventory_location_id">
                            </el-option>
                        </el-select>
                    </div>   
                </div>  

                <div class="row">
                    <div class="col-5" style="padding-top: 15px;">
                        <label>คลังปลายทาง</label><span class="text-danger"> *</span>
                        <input type="hidden" name="to_organization_id" v-model="organizationToSelected">
                        <el-select  v-model="organizationToSelected" clearable filterable 
                                    placeholder="Organization" 
                                    class="w-100"
                                    @change="getLocationsTo(organizationToSelected)">
                            <el-option
                                v-for   ="parameter in parameters"
                                :key    ="parameter.organization_id"
                                :label  ="parameter.organization_code + ' : ' + parameter.hr_all_organization_units.name"
                                :value  ="parameter.organization_id" >
                            </el-option>
                        </el-select>
                    </div>   

                    <div class="col-7" style="padding-top: 43px;">
                        <input  type="hidden" name="to_locator_id" v-model="inventoryToSelected">
                        <el-select  v-model="inventoryToSelected" clearable filterable 
                                    :disabled="!organizationToSelected" 
                                    v-loading="loading.inventoryLocationTo"
                                    class="w-100"
                                    placeholder="สถานที่จัดเก็บ">
                            <el-option
                                v-for   ="locationToList in locationToLists"
                                :key    ="locationToList.inventory_location_id"
                                :label  ="locationToList.concatenated_segments + ' : ' + locationToList.description"
                                :value  ="locationToList.inventory_location_id" >
                            </el-option>
                        </el-select>
                    </div>   
                </div>

                <div class="row">
                    <div class="col" style="padding-top: 15px;">
                        <!-- <label>ประเภทการทำรายการ</label><span class="text-danger" v-if="organizationId != this.orgM12.organization_id"> *</span> -->
                        <label>ประเภทการทำรายการ</label><span class="text-danger"> *</span>
                        <input type="hidden" name="transaction_type_id" v-model="transactionSelected">
                        <!-- <el-select  v-model="transactionSelected" clearable filterable 
                                    :disabled="isDisabledTransaction" 
                                    placeholder="ประเภทการทำรายการ" 
                                    class="w-100">
                            <el-option
                                v-for   ="transactionType in transactionTypes"
                                :key    ="transactionType.transaction_type_id"
                                :label  ="transactionType.transaction_type_name"
                                :value  ="transactionType.transaction_type_id" >
                            </el-option>
                        </el-select> -->
                        <el-select
                            v-model="transactionSelected"
                            clearable 
                            filterable
                            remote
                            reserve-keyword
                            placeholder="ประเภทการทำรายการ"
                            :remote-method="remoteMethod"
                            :loading="loading.transactionTypes"
                            class="w-100">
                            <el-option
                                v-for   ="transactionType in transactionTypesList"
                                :key    ="transactionType.transaction_type_id"
                                :label  ="transactionType.transaction_type_name"
                                :value  ="transactionType.transaction_type_id"      >
                            </el-option>
                        </el-select>
                    </div>     
                </div>   

                <div class="row">
                    <div class="col" style="padding-top: 15px;">
                        <!-- <label>ประเภทวัตถุดิบ</label><span class="text-danger" v-if="organizationId == this.orgM12.organization_id"> *</span> -->
                        <label>ประเภทวัตถุดิบ</label><span class="text-danger"> *</span>
                        <input type="hidden" name="inv_item_type" v-model="itemType">
                        <el-select  v-model="itemType" clearable filterable 
                                    placeholder="ประเภทวัตถุดิบ" 
                                    class="w-100">
                            <el-option
                                v-for   ="(data,index) in dataItemTypes"
                                :key    ="index"
                                :label  ="data.attribute11"
                                :value  ="data.lookup_code" >
                            </el-option>
                        </el-select>
                    </div>     
                </div>   
                
                <div class="row">
                    <div class="col" style="padding-top: 15px; padding-bottom: 15px;">
                        <label>สถานะการใช้งาน</label>
                        <input type="hidden" name="enable_flag" v-model="checked">
                        <el-checkbox class="w-100" v-model="checked"></el-checkbox>
                    </div>     
                </div>   

            </div>
        </div>
    </div>
</template>

<script>
    import "vue2-datepicker/index.css";
    import moment from "moment";
    export default {
        // props: ['deprtments','tobaccoItemcats', 'transactionTypes', 'parameters', 'wipTransaction', 'organizationId', 'dataItemTypes', 'orgM12'],
        props: ['deprtments','tobaccoItemcats', 'transactionTypes', 'parameters', 'wipTransaction', 'organizationId', 'dataItemTypes'],
        data() {
            return{
                deprtmentSelected:'',
                tobaccoItemcatSelected:'',
                transactionSelected:'',
                itemType:'',
                organizationFromSelected:'',
                inventoryFromSelected:'',
                organizationToSelected:'',
                inventoryToSelected:'',
                wipTransactionSelected:'',
                locationFromLists: [],
                locationToLists: [],
                checked: true,
                transactionTypesList: this.transactionTypes,
                loading:{
                    inventoryLocationFrome: false,
                    inventoryLocationTo: false,
                    transactionTypes: false,
                },
                start_date : this.value ? moment(this.value, "DD/MM/YYYY").toDate() : moment().add(543, 'years').toDate(),
                end_date : '',
                // isDisabledTransaction: this.organizationId == this.orgM12.organization_id ? true : false,
            };
        },
        methods: {
            async getLocationsTo(value) {
                var params = {
                    organization : value
                };
                this.loading.inventoryLocationTo = true;
                return await axios
                    .get('/pm/ajax/org-tranfer/get_locations_to',{ params })
                    .then(res => {
                        this.locationToLists = res.data.itemLocationsTo;
                        this.loading.inventoryLocationTo = false;
                        this.inventoryToSelected = '';
                    });
            },
            async getLocationsFrom(value) {
                var params = {
                    organization : value
                };
                this.loading.inventoryLocationFrome = true;
                return await axios
                    .get('/pm/ajax/org-tranfer/get_locations_from',{ params })
                    .then(res => {
                        // console.log(res.data.itemLocationsFrom);
                        this.locationFromLists = res.data.itemLocationsFrom;
                        this.loading.inventoryLocationFrome = false;
                        this.inventoryFromSelected = '';
                    });
            }, 
            remoteMethod(query) {
                let vm = this;
                if (query !== '') {
                    var params = query
                    this.loading.transactionTypes = true;
                    return axios
                    .get('/pm/ajax/org-tranfer/get_transaction_types',{ params })
                    .then(res => {
                        vm.transactionTypesList = res.data.transactionTypes;
                        vm.loading.transactionTypes = false;
                        vm.transactionSelected = '';
                    });
                } else {
                    vm.transactionTypesList = this.transactionTypes;
                }
            }       
        }
    };
</script>