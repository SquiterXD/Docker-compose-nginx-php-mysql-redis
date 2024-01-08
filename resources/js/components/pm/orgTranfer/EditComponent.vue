<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <input type="hidden" name="id" v-model="id">
                <div class="row">
                    <div class="col" style="padding-top: 15px;">
                        <label>คลังสำหรับทำรายการ</label><span class="text-danger"> *</span>
                        <input type="hidden" name="wip_transaction_type_id" v-model="wip">
                        <el-select  v-model="wip" clearable filterable 
                                    placeholder="เลือกคลังเพื่อทำรายการ" 
                                    class="w-100">
                            <el-option
                                v-for   ="(item,index)  in wipTransaction"
                                :key    ="index"
                                :label  ="item.attribute3"
                                :value  ="item.transaction_type_id" >
                            </el-option>
                        </el-select>
                    </div>     
                </div>   

                <div class="row">
                    <div class="col" style="padding-top: 15px;">
                        <label>ประเภท Item</label><span class="text-danger"> *</span>
                        <input type="hidden" name="tobacco_group_code" v-model="tobaccoItemcat">
                        <el-select  v-model="tobaccoItemcat" clearable filterable 
                                    placeholder="เลือกประเภท Item" 
                                    class="w-100">
                            <el-option
                                v-for   ="itemcat in tobaccoItemcats"
                                :key    ="itemcat.group_code"
                                :label  ="itemcat.meaning + ' : ' + itemcat.group_desc"
                                :value  ="itemcat.group_code" >
                            </el-option>
                        </el-select>
                    </div>     
                </div>     

                <div class="row">
                    <div class="col-5" style="padding-top: 15px;">
                        <label>คลังต้นทาง</label><span class="text-danger"> *</span>
                        <input type="hidden" name="from_organization_id" v-model="organizationFrom">
                        <el-select  v-model="organizationFrom" filterable 
                                    placeholder="Organization" 
                                    class="w-100"
                                    @change="getLocationsFrom(organizationFrom)">
                            <el-option
                                v-for   ="parameter in parameters"
                                :key    ="parameter.organization_id"
                                :label  ="parameter.organization_code + ' : ' + parameter.hr_all_organization_units.name"
                                :value  ="parameter.organization_id" >
                            </el-option>
                        </el-select>
                    </div>   

                    <div class="col-7" style="padding-top: 43px;">
                        <input  type="hidden" name="from_locator_id" v-model="inventoryFrom">
                        <el-select  v-model="inventoryFrom" clearable filterable 
                                    :disabled="isDisabledLocationFrome" 
                                    v-loading="loading.inventoryLocationFrome"
                                    class="w-100"
                                    placeholder="เลือกสถานที่">
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
                        <input type="hidden" name="to_organization_id" v-model="organizationTo">
                        <el-select  v-model="organizationTo" filterable 
                                    placeholder="Organization" 
                                    class="w-100"
                                    @change="getLocationsTo(organizationTo)">
                            <el-option
                                v-for   ="parameter in parameters"
                                :key    ="parameter.organization_id"
                                :label  ="parameter.organization_code + ' : ' + parameter.hr_all_organization_units.name"
                                :value  ="parameter.organization_id" >
                            </el-option>
                        </el-select>
                    </div>   

                    <div class="col-7" style="padding-top: 43px;">
                        <input  type="hidden" name="to_locator_id" v-model="inventoryTo">
                        <el-select  v-model="inventoryTo" clearable filterable 
                                    :disabled="isDisabledLocationTo" 
                                    v-loading="loading.inventoryLocationTo"
                                    class="w-100"
                                    placeholder="เลือกสถานที่">
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
                        <input type="hidden" name="transaction_type_id" v-model="transaction">
                        <!-- <el-select  v-model="transaction" clearable filterable 
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
                            v-model="transaction"
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
                        <input type="hidden" name="old_inv_item_type" v-model="olditemType">
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
                        <input type="hidden" name="old_enable_flag" v-model="oldchecked">
                        <el-checkbox class="w-100" v-model="checked"></el-checkbox>
                    </div>     
                </div>   
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        // props: ['dataSetup', 'wipTransaction', 'tobaccoItemcats', 'transactionTypes', 'parameters', 'organizationId', 'dataItemTypes', 'orgM12'],
        props: ['dataSetup', 'wipTransaction', 'tobaccoItemcats', 'transactionTypes', 'parameters', 'organizationId', 'dataItemTypes'],
        data() {
            return{
                wip                     :this.dataSetup ? this.dataSetup.wip_transaction_type_id : '',
                tobaccoItemcat          :this.dataSetup ? this.dataSetup.tobacco_group_code : '',
                transaction             :this.dataSetup ? this.dataSetup.transaction_type_id : '',
                id                      :this.dataSetup ? this.dataSetup.id : '',
                itemType                :this.dataSetup ? this.dataSetup.inv_item_type : '',
                olditemType             :this.dataSetup ? this.dataSetup.inv_item_type : '',
                organizationFrom        :this.dataSetup ? this.dataSetup.from_organization_id : '',
                inventoryFrom           :this.dataSetup ? this.dataSetup.from_locator_id : '',
                organizationTo          :this.dataSetup ? this.dataSetup.to_organization_id : '',
                inventoryTo             :this.dataSetup ? this.dataSetup.to_locator_id : '',
                oldValueLocationsFrom   :this.dataSetup ? this.dataSetup.from_organization_id : '',
                oldValueLocationTo      :this.dataSetup ? this.dataSetup.to_organization_id : '',
                locationFromLists: [],
                locationToLists: [],
                checked: this.dataSetup ? (this.dataSetup.enable_flag == 'Y' ? true : false) : '',
                oldchecked : this.dataSetup ? (this.dataSetup.enable_flag == 'Y' ? true : false) : '',
                loading:{
                    inventoryLocationFrome: false,
                    inventoryLocationTo: false,
                    transactionTypes: false,
                },
                isDisabledLocationFrome: true,
                isDisabledLocationTo: true,
                // isDisabledTransaction: this.organizationId == this.orgM12.organization_id ? true : false,
                transactionTypesList: this.transactionTypes,
            };
        },
        mounted() {
            this.getLocationsFrom(this.dataSetup ? this.dataSetup.from_organization_id : '')
            this.getLocationsTo(this.dataSetup ? this.dataSetup.to_organization_id : '')
        },
        methods: {
            async getLocationsFrom(value) {
                if(this.oldValueLocationsFrom != value){
                    this.inventoryFrom = '';
                }
                var params = {
                    organization : value,
                };
                this.loading.inventoryLocationFrome = true;
                return await axios
                    .get('/pm/ajax/org-tranfer/get_locations_from',{ params })
                    .then(res => {
                        if(res.data.itemLocationsFrom.length == 0){
                            swal({
                                title: "warning !",
                                text: "organizationนี้ ไม่มีสถานที่จัดเก็บ",
                                type: "warning",
                                showConfirmButton: true
                            });
                            this.locationFromLists = '';
                            this.inventoryFrom = '';
                            this.isDisabledLocationFrome = true;
                            this.loading.inventoryLocationFrome = false;
                        }else{
                            this.locationFromLists = res.data.itemLocationsFrom;
                            this.loading.inventoryLocationFrome = false;
                            this.isDisabledLocationFrome = false;
                            // this.inventoryFrom = '';
                        }
                    });
            },        
            async getLocationsTo(value) {
                if(this.oldValueLocationTo != value){
                    this.inventoryTo = '';
                }
                var params = {
                    organization : value
                };
                this.loading.inventoryLocationTo = true;
                return await axios
                    .get('/pm/ajax/org-tranfer/get_locations_to',{ params })
                    .then(res => {
                        if(res.data.itemLocationsTo.length == 0){
                            swal({
                                title: "warning !",
                                text: "organizationนี้ ไม่มีสถานที่จัดเก็บ",
                                type: "warning",
                                showConfirmButton: true
                            });
                            this.locationToLists = '';
                            this.inventoryTo = '';
                            this.isDisabledLocationTo = true;
                            this.loading.inventoryLocationTo = false;
                        }else{
                            this.locationToLists = res.data.itemLocationsTo;
                            this.loading.inventoryLocationTo = false;
                            this.isDisabledLocationTo = false;
                        }
                    });
            },

            remoteMethod(query) {
            if (query !== '') {
                var params = query
                this.loading.transactionTypes = true;
                return axios
                .get('/pm/ajax/org-tranfer/get_transaction_types',{ params })
                .then(res => {
                    this.transactionTypesList = res.data.transactionTypes;
                    this.loading.transactionTypes = false;
                });
            } else {
                this.transactionTypesList = this.transactionTypes;
            }
        }       
        }
    };
</script>