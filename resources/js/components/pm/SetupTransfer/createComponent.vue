<template>
    <div>
        <!-- <div class="row justify-content-center">
            <div class="col-md-8"> -->

                <div class="row">
                    <div class="col" style="margin-right: 300px; margin-left: 300px; padding-top: 15px;">
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

                <div class="row">
                    <div class="col" style="margin-right: 300px; margin-left: 300px; padding-top: 15px;">
                        <input type="hidden" name="item_cat" v-model="itemCat">
                        <label>ประเภทวัตถุดิบ</label><span class="text-danger"> *</span>
                        <el-select  v-model="itemCat" 
                                    placeholder="โปรดเลือก ประเภทวัตถุดิบ"
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

                <div class="row">
                    <div class="col" style="margin-right: 300px; margin-left: 300px; padding-top: 15px;">
                        <input type="hidden" name="toOrganization" v-model="toOrganization">
                        <label>Organization รับวัตถุดิบ</label><span class="text-danger"> *</span>
                        <el-select  v-model="toOrganization" 
                                    placeholder="โปรดเลือก Organization รับวัตถุดิบ"
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
                        <input type="hidden" name="enableFlag" v-model="enableFlag">
                        <label>สถานะการใช้งาน</label>
                        <el-checkbox v-model="enableFlag" class="w-100"></el-checkbox>
                    </div>
                </div>

            <!-- </div>
        </div> -->
    </div>
</template>

<script>
    export default {
    props: ['itemCats', 'oldInput', 'requestTypes'],
    data() {
        return{
            itemCat: this.oldInput.length != 0 && this.oldInput.item_cat != null ? Number(this.oldInput.item_cat) : '',
            toOrganization: '',
            toSubinventory: '',
            toLocations: '',
            enableFlag: this.oldInput.length != 0 ? this.oldInput.enableFlag == 'true' ? true : false : true,
            requestType: this.oldInput.length != 0 && this.oldInput.request_type != null ? this.oldInput.request_type : '',
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
        };
    },
    mounted() {
        if(this.oldInput.length != 0 && this.oldInput.item_cat != null){
            this.getOrganization(this.oldInput.item_cat);
        }
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
                    this.toOrganization = this.oldInput.length != 0 ? this.oldInput.toOrganization : '';
                    this.isDisabledOrganization = false;
                    this.organizationList = res.data.organizationList;
                    this.loading.toOrganization = false;

                    this.toSubinventory = '';
                    this.isDisabledSubinventory = true;
                    this.loading.toSubinventory = false;

                    this.toLocations = '';
                    this.isDisabledToLocations = true;
                    this.loading.toLocations = false;

                    if(this.oldInput.length != 0){
                        this.getSubinventory(this.toOrganization);
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
                    if(res.data.subinventoryList == ''){
                        this.toSubinventory = '';
                        this.isDisabledSubinventory = true;
                        this.loading.toSubinventory = false;

                        this.toLocations = '';
                        this.isDisabledToLocations = true;
                        this.loading.toLocations = false;
                        swal({
                            title: "warning !",
                            text: "Organizationนี้ ไม่มีคลังจัดเก็บ และสถานที่จัดเก็บ",
                            type: "warning",
                            showConfirmButton: true
                        });
                    }else{
                        this.toSubinventory = this.oldInput.length != 0 ? this.oldInput.subinventory_code : '';
                        this.isDisabledSubinventory = false;
                        this.subinventoryList = res.data.subinventoryList;
                        this.loading.toSubinventory = false;

                        if(this.oldInput.length != 0){
                            this.getLocations(this.oldInput.subinventory_code, this.oldInput.toOrganization);
                        }

                        this.toLocations = '';
                        this.isDisabledToLocations = true;
                        this.loading.toLocations = false;
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
                    // console.log(res.data.locationsList);
                    if(res.data.locationsList == ''){
                        this.toLocations = '';
                        this.isDisabledToLocations = true;
                        this.loading.toLocations = false;
                        swal({
                            title: "warning !",
                            text: "คลังจัดเก็บนี้ ไม่มีสถานที่จัดเก็บ",
                            type: "warning",
                            showConfirmButton: true
                        });
                    }else{
                        this.toLocations = this.oldInput.length != 0 ? this.oldInput.inventory_location_id : '';
                        this.isDisabledToLocations = false;
                        this.locationsList = res.data.locationsList;
                        this.loading.toLocations = false;
                    }
                });
        },
    },
    };
</script>