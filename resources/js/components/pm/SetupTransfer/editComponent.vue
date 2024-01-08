<template>
    <div>
        <!-- <div class="row justify-content-center">
            <div class="col-md-8"> -->
                <div class="row">
                    <div class="col" style="margin-right: 300px; margin-left: 300px; padding-top: 15px;">
                        <input type="hidden" name="oldRequestType" v-model="oldRequestType">
                        <input type="hidden" name="request_type" v-model="requestType">
                        <label>ประเภทการเบิก</label><span class="text-danger"> *</span>
                        <el-select  v-model="requestType" 
                                    placeholder="โปรดเลือก ประเภทการเบิก"
                                    class="w-100"
                                    reserve-keyword
                                    filterable>
                            <el-option
                                v-for="(Type, index) in requestTypes"
                                :key="index"
                                :label="Type.description"
                                :value="Type.lookup_code">
                            </el-option>
                        </el-select>
                    </div>
                </div>

                <input type="hidden" name="setup_trans_id" v-model="setupTransId">
                <div class="row">
                    <div class="col" style="margin-right: 300px; margin-left: 300px; padding-top: 15px;">
                        <label>Organization</label><span class="text-danger"> *</span>
                        <el-input
                            v-model     ="fromOrganization"
                            :disabled   ="true">
                        </el-input>
                    </div>
                </div>

                <div class="row">
                    <div class="col" style="margin-right: 300px; margin-left: 300px; padding-top: 15px;">
                        <input type="hidden" name="old_item_cat" v-model="oldItemCat">
                        <input type="hidden" name="item_cat" v-model="itemCat">
                        <label>ประเภทวัตถุดิบ</label><span class="text-danger"> *</span>
                        <el-select  v-model="itemCat" 
                                    placeholder="Select"
                                    class="w-100"
                                    reserve-keyword
                                    filterable
                                    @change="getOrganization(itemCat)">
                            <el-option
                                v-for="(itemCat, index) in itemCats"
                                :key="index"
                                :label="itemCat.meaning + ' : ' + itemCat.description"
                                :value="itemCat.lookup_code">
                            </el-option>
                        </el-select>
                    </div>
                </div>

                <input type="hidden" name="toOrganization" v-model="toOrganization">
                <div class="row">
                    <div class="col" style="margin-right: 300px; margin-left: 300px; padding-top: 15px;">
                        <input type="hidden" name="oldToOrganization" v-model="oldToOrganization">
                        <input type="hidden" name="toOrganization" v-model="toOrganization">
                        <label>Organization รับวัตถุดิบ</label><span class="text-danger"> *</span>
                        <el-select  v-model="toOrganization" 
                                    placeholder="Select"
                                    class="w-100"
                                    :disabled="isDisabledOrganization"
                                    v-loading="loading.toOrganization"
                                    reserve-keyword
                                    filterable
                                    @change="getSubinventory(toOrganization)">
                            <el-option
                                v-for="(org, index) in organizationList"
                                :key="index"
                                :label="org.organization ? org.organization.organization_code + ' : ' + org.organization.organization_name : org.parameter.organization_code"
                                :value="org.organization_id">
                            </el-option>
                        </el-select>
                    </div>
                </div>

                <div class="row">
                    <div class="col" style="margin-right: 300px; margin-left: 300px; padding-top: 15px;">
                        <input type="hidden" name="oldSubinventoryCode" v-model="oldSubinventoryCode">
                        <input type="hidden" name="subinventory_code" v-model="toSubinventory">
                        <label>คลังจัดเก็บ</label><span class="text-danger"> *</span>
                        <el-select  v-model="toSubinventory" 
                                    placeholder="โปรดเลือก คลังจัดเก็บ"
                                    class="w-100"
                                    :disabled="isDisabledSubinventory"
                                    v-loading="loading.toSubinventory"
                                    reserve-keyword
                                    filterable
                                    @change="getLocations(toSubinventory, toOrganization)">
                            <el-option
                                v-for="(subinventory, index) in subinventoryList"
                                :key="index"
                                :label="subinventory.subinventory_code + ' : ' + subinventory.subinventory_desc"
                                :value="subinventory.subinventory_code">
                            </el-option>
                        </el-select>
                    </div>
                </div>

                <div class="row">
                    <div class="col" style="margin-right: 300px; margin-left: 300px; padding-top: 15px;">
                        <input type="hidden" name="oldInventoryLocationId" v-model="oldInventoryLocationId">
                        <input type="hidden" name="inventory_location_id" v-model="toLocations">
                        <label>สถานที่จัดเก็บ</label><span class="text-danger"> *</span>
                        <el-select  v-model="toLocations" 
                                    placeholder="โปรดเลือก สถานที่จัดเก็บ"
                                    class="w-100"
                                    v-loading="loading.toLocations"
                                    :disabled="isDisabledToLocations"
                                    reserve-keyword
                                    filterable>
                            <el-option
                                v-for="(locations, index) in locationsList"
                                :key="index"
                                :label="locations.segment2 + ' : ' + locations.description"
                                :value="locations.inventory_location_id">
                            </el-option>
                        </el-select>
                    </div>
                </div>

                <div class="row">
                    <div class="col" style="margin-right: 300px; margin-left: 300px; padding-top: 15px;">
                        <input type="hidden" name="oldEnableFlag" v-model="oldEnableFlag">
                        <input type="hidden" name="newEnableFlag" v-model="newEnableFlag">
                        <label>สถานะการใช้งาน</label>
                        <el-checkbox v-model="newEnableFlag" class="w-100"></el-checkbox>
                    </div>
                </div>
            <!-- </div>
        </div> -->
    </div>
</template>

<script>
    export default {
    props: ['transfers', 'itemCats', 'requestTypes'],
    data() {
        return{
            setupTransId: this.transfers ? this.transfers.setup_trans_id : '',
            fromOrganization: this.transfers ? this.transfers.organization_code + ' : '+ this.transfers.organization_name : '',
            oldItemCat: this.transfers ? Number(this.transfers.item_cat_code) : '',
            itemCat: this.transfers ? Number(this.transfers.item_cat_code) : '',
            oldEnableFlag: this.transfers ? this.transfers.enable_flag == 'Y' ? true : false : false,
            newEnableFlag: this.transfers ? this.transfers.enable_flag == 'Y' ? true : false : false,
            oldToOrganization: this.transfers ? this.transfers.to_organization_id : '',
            toOrganization: '',
            oldSubinventoryCode: this.transfers ? this.transfers.to_subinventory_code : '',
            toSubinventory: '',
            oldInventoryLocationId: this.transfers ? this.transfers.to_locator_id : '',
            toLocations: this.transfers ? this.transfers.to_locator_id : '',
            toOrganizationId: this.transfers ? this.transfers.to_organization_id : '',
            itemCatId: this.transfers ? this.transfers.item_cat_code : '',
            oldRequestType: this.transfers ? this.transfers.request_type_code : '',
            requestType: this.transfers ? this.transfers.request_type_code : '',
            locationsList: [],
            subinventoryList: [],
            organizationList: [],
            isDisabledToLocations: true,
            isDisabledSubinventory: true,
            isDisabledOrganization: true,
            loading: {
                toOrganization: false,
                toLocations: false,
                toSubinventory: false
            },
            firstLoad: true,
        };
    },
    mounted() {
        // console.log(this.transfers)
        this.getOrganization(this.transfers ? this.transfers.item_cat_code : '');
        // this.getSubinventory(this.transfers ? this.transfers.to_organization_id : '');
        // this.getLocations(this.transfers ? this.transfers.to_subinventory_code : '', this.transfers ? this.transfers.to_organization_id : '');
    },
    methods: {
        async getOrganization(value) {
            var params = {
                itemCat: value
            };
            this.loading.toOrganization = true;
            this.loading.toSubinventory = true;
            this.loading.toLocations = true;
            return await axios
                .get('/pm/ajax/setup-transfer/get-organization',{ params })
                .then(res => {
                    // console.log(res.data.organizationList);
                    if(this.itemCat == this.itemCatId){
                            this.toOrganization = this.transfers ? this.transfers.to_organization_id : '';
                            this.isDisabledOrganization = false;
                            this.organizationList = res.data.organizationList;
                            this.loading.toOrganization = false;

                            this.getSubinventory(this.transfers ? this.transfers.to_organization_id : '');
                            this.getLocations(this.transfers ? this.transfers.to_subinventory_code : '', this.transfers ? this.transfers.to_organization_id : '');
                    }else{
                        this.toOrganization = '';
                        this.isDisabledOrganization = false;
                        this.organizationList = res.data.organizationList;
                        this.loading.toOrganization = false;

                        this.toSubinventory = '';
                        this.isDisabledSubinventory = true;
                        this.subinventoryList = res.data.subinventoryList;
                        this.loading.toSubinventory = false;

                        this.toLocations = '';
                        this.isDisabledToLocations = true;
                        this.loading.toLocations = false;
                    }
                });
        },
        async getSubinventory(value) {
            var params = {
                toOrganization: value
            };
            this.loading.toSubinventory = true;
            this.loading.toLocations = true;
            return await axios
                .get('/pm/ajax/setup-transfer/get-subinventory',{ params })
                .then(res => {
                    // console.log(res.data.subinventoryList);
                    if(res.data.subinventoryList == ''){
                        this.toSubinventory = '';
                        this.isDisabledSubinventory = true;
                        this.loading.toSubinventory = false;

                        this.toLocations = '';
                        this.isDisabledToLocations = true;
                        this.loading.toLocations = false;
                        swal({
                            title: "warning !",
                            text: "Organizationนี้ ยังไม่มีคลังจัดเก็บ",
                            type: "warning",
                            showConfirmButton: true
                        });
                    }else{
                        if(this.toOrganization == this.toOrganizationId){
                            this.toSubinventory = this.transfers ? this.transfers.to_subinventory_code : '';
                            
                            this.isDisabledSubinventory = false;
                            this.subinventoryList = res.data.subinventoryList;
                            this.loading.toSubinventory = false;

                        }else{
                            this.toSubinventory = '';
                            this.isDisabledSubinventory = false;
                            this.subinventoryList = res.data.subinventoryList;
                            this.loading.toSubinventory = false;

                            this.toLocations = '';
                            this.isDisabledToLocations = true;
                            this.loading.toLocations = false;
                        }
                    }          
                });
        },
        
        async getLocations(value, value1) {
            var params = {
                subinventory: value,
                toOrganizationId: value1
            };
            this.loading.toLocations = true;
            return await axios
                .get('/pm/ajax/setup-transfer/get-locations',{ params })
                .then(res => {
                    // console.log(res.data.ListLocations);
                    if(res.data.locationsList == ''){
                        this.toLocations = '';
                        this.isDisabledToLocations = true;
                        this.loading.toLocations = false;
                        swal({
                            title: "warning !",
                            text: "คลังจัดเก็บนี้ ยังไม่มีสถานที่จัดเก็บ",
                            type: "warning",
                            showConfirmButton: true
                        });
                    }else{
                        // if(this.toOrganization == this.toOrganizationId){
                        //     this.toLocations = this.transfers ? this.transfers.to_locator_id : '';

                        //     this.isDisabledToLocations = false;
                        //     this.locationsList = res.data.locationsList;
                        //     this.loading.toLocations = false;
                        // }else{
                        //     this.toLocations = '';
                        //     this.isDisabledToLocations = false;
                        //     this.locationsList = res.data.locationsList;
                        //     this.loading.toLocations = false;
                        // }
                        if (this.firstLoad) {
                            this.toLocations = this.transfers ? this.transfers.to_locator_id : '';
                            this.isDisabledToLocations = false;
                            this.locationsList = res.data.locationsList;
                            this.loading.toLocations = false;
                            this.firstLoad = false;
                        } else {
                            this.toLocations = '';
                            this.isDisabledToLocations = false;
                            this.locationsList = res.data.locationsList;
                            this.loading.toLocations = false;
                        }

                    }
                });
        },
    },
    };
</script>