<template>
    <div v-loading="loading.page">
        <div class="ibox">
            <div class="ibox-content">
                <div class="text-right">
                    <div class="text-right" style="padding-top: 5px;">
                        <button class="btn btn-light" @click.prevent="search(organization, itemCatSeg1, itemCatSeg2, itemNumber)" :disabled="!organization || !itemCatSeg1 || !itemCatSeg2">
                            <i class="fa fa-search" aria-hidden="true"></i> แสดงข้อมูล 
                        </button>
                        <a type="button" :href="'/pd/settings/ohhand-tobacco-forewarn'" class="btn btn-danger">
                            ล้างค่า
                        </a>
                    </div>
                </div>
                
                <div class="row" style="padding-top: 20px;">
                    <!-- <input type="hidden" name="itemCatSeg1" v-model="itemCatSeg1Selected"> -->
                    <!-- <div class="col-md-3">
                        <label>Organization</label><span class="text-danger"> *</span>
                        <el-select  v-model="organization" filterable 
                                    placeholder="เลือก Organizations" 
                                    class="w-100"
                                    @change="getTobaccoItemcatSeg1(organization)">
                            <el-option
                                v-for   ="(org,index) in organizations"
                                :key    ="index"
                                :label  ="org.organization_code + ' : ' + org.organization_name"
                                :value  ="org.organization_id">
                            </el-option>
                        </el-select>
                    </div> -->

                    <div class="col-md-4">
                        <label>ประเภทวัตถุดิบ</label><span class="text-danger"> *</span>
                        <el-select  v-model="itemCatSeg1" filterable 
                                    placeholder="เลือก ประเภทวัตถุดิบ" 
                                    class="w-100"
                                    @change="getTobaccoItemcatSeg2(organization, itemCatSeg1)"
                                    v-loading="loading.itemCatSeg1">
                            <el-option
                                v-for   ="(itemSeg1,index) in itemCatSeg1List"
                                :key    ="index"
                                :label  ="itemSeg1.flex_value_meaning1 + ': ' + itemSeg1.description1"
                                :value  ="itemSeg1.flex_value_meaning1">
                            </el-option>
                        </el-select>
                    </div>

                    <div class="col-md-4">
                        <label>กลุ่มใบยา</label><span class="text-danger"> *</span>
                        <el-select  v-model="itemCatSeg2" filterable
                                    placeholder="เลือก กลุ่มใบยา" 
                                    class="w-100"
                                    @change="getItemNumber(organization, itemCatSeg1, itemCatSeg2)"
                                    v-loading="loading.itemCatSeg2"
                                    :disabled="isDisabled.itemCatSeg2">
                            <el-option
                                v-for   ="(itemSeg2,index) in itemCatSeg2List"
                                :key    ="index"
                                :label  ="itemSeg2.flex_value_meaning2 + ': ' + itemSeg2.description2"
                                :value  ="itemSeg2.flex_value_meaning2">
                            </el-option>
                        </el-select>
                    </div>

                    <div class="col-md-4">
                        <label>รหัสวัตถุดิบ</label>
                            <el-select
                                class="w-100"
                                v-model="itemNumber"
                                filterable
                                remote
                                reserve-keyword
                                placeholder="เลือก รหัสวัตถุดิบ"
                                v-loading="loading.itemNumber"
                                :remote-method="remoteMethod"
                                :loading="loading.itemNumber"
                                :disabled="isDisabled.itemNumber">
                                <el-option
                                    v-for   ="(itemNumber,index) in itemNumberList"
                                    :key    ="index"
                                    :label  ="itemNumber.item_number + ': ' + itemNumber.item_desc"
                                    :value  ="itemNumber.inventory_item_id">
                                </el-option>
                            </el-select>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="this.table">
            <ohhandTobaccoForewarnTable :tobaccoForewarnList = "tobaccoForewarnList"
                                        :itemNumbersUpdateList = "itemNumbersUpdateList"
                                        :itemNumberShowAllList = "itemNumberShowAllList">
            </ohhandTobaccoForewarnTable>
        </div>
    </div>
</template>

<script>
    import ohhandTobaccoForewarnTable from './TableComponent.vue'
    export default {
        components: { ohhandTobaccoForewarnTable },
        props: ["organizations", "org", "itemCatSeg1List"],
        data() {
            return{
                organization: this.org ? parseFloat(this.org.organization_id) : '',
                itemCatSeg1: '',
                itemCatSeg2: '',
                itemCatSeg2List: [],
                itemNumber: '',
                itemNumberList: [],
                itemNumberBaseList: [],
                itemNumbersUpdateList: [],
                tobaccoForewarnList: [],
                table: false,
                loading: {
                    // itemCatSeg1: false,
                    itemCatSeg2: false,
                    itemNumber: false,
                    page: false
                },
                isDisabled: {
                    itemCatSeg2: true,
                    itemNumber: true,
                }
            };
        },
        mounted() {

        },
        methods: {
            async getTobaccoItemcatSeg2(value, value1) {
                this.loading.itemCatSeg2 = true;
                this.loading.itemNumber = true;
                this.itemCatSeg2 = ''
                this.itemNumber = ''
                var params = {
                    organization: value,
                    itemCatSeg1: value1
                };
                return await axios
                    .get('/pd/ajax/ohhand-tobacco-forewarn/get-tobacco-itemcat-seg-2',{ params })
                    .then(res => {
                        this.itemCatSeg2List = res.data.itemCatSeg2List;

                        this.loading.itemCatSeg2 = false;
                        this.loading.itemNumber = false;

                        this.isDisabled.itemCatSeg2 = false;
                        this.isDisabled.itemNumber = true;
                    });
            },
            async getItemNumber(value, value1, value2) {
                this.loading.itemNumber = true;
                this.itemNumber = ''
                var params = {
                    organization: value,
                    itemCatSeg1: value1,
                    itemCatSeg2: value2
                };
                return await axios
                    .get('/pd/ajax/ohhand-tobacco-forewarn/get-item-number',{ params })
                    .then(res => {
                        this.itemNumberList = res.data.itemNumberList;
                        this.itemNumberBaseList = res.data.itemNumberList;                       
                        this.loading.itemNumber = false;
                        
                        this.isDisabled.itemNumber = false;
                    });
            },
            async search(organization, itemCatSeg1, itemCatSeg2, itemNumber) {
                this.loading.page = true;
                var params = {
                    organization: organization,
                    itemCatSeg1: itemCatSeg1,
                    itemCatSeg2: itemCatSeg2,
                    itemNumber: itemNumber
                };
                return await axios
                    .get('/pd/ajax/ohhand-tobacco-forewarn/search',{ params })
                    .then(res => {
                        this.table = true;
                        this.loading.page = false;
                        this.tobaccoForewarnList = res.data.tobaccoForewarnList;
                        this.itemNumbersUpdateList = res.data.itemNumbersUpdateList;
                        this.itemNumberShowAllList = res.data.itemNumberShowAllList;
                    });
            },
            remoteMethod(query) {
                if (query !== '') {
                    let vm = this;
                    this.loading.itemNumber = true;
                    var params = {
                        query: query,
                        itemCatSeg1: vm.itemCatSeg1,
                        itemCatSeg2: vm.itemCatSeg2,
                    };
                    return axios
                        .get('/pd/ajax/ohhand-tobacco-forewarn/get-search-item-number',{ params })
                        .then(res => {
                            this.itemNumberList = res.data.itemNumberList;
                            this.loading.itemNumber = false;
                        });
                } 
                else{
                    this.itemNumberList = this.itemNumberBaseList;
                }
            }
        },
    };
</script>
