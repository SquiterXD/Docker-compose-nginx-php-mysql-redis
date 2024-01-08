<template>
    <div>
        <div class="ibox">
            <div class="ibox-content">
                <div class="text-right">
                    <div class="text-right" style="padding-top: 5px;">
                        <button class="btn btn-light" 
                            @click.prevent="search(medicinalLeafH, medicinalLeafL, medicinalItem)">
                            <i class="fa fa-search" aria-hidden="true"></i> ค้นหา 
                        </button>
                        <a type="button" :href="'/pd/history-instead-grades'" class="btn btn-danger">
                            ล้างค่า
                        </a>
                    </div>
                </div>
                
                <div class="row" style="padding-top: 20px;">
                    <div class="col-md-4">
                        <label>ประเภทใบยา</label><span class="text-danger"> *</span>
                        <el-select 
                            v-model="medicinalLeafH" 
                            placeholder="เลือกประเภทใบยา"
                            class="w-100"
                            clearable
                            filterable
                            reserve-keyword
                            @change="getMedicinalLeafTypesL(medicinalLeafH)">
                            <el-option
                                v-for="(item,index) in medicinalLeafTypesH"
                                :key="index"
                                :label="item.category_code_1 + ' : ' + item.category_desc_1"
                                :value="item.category_code_1 + '.' + item.category_desc_1">
                            </el-option>
                        </el-select>
                        <div v-if="this.isValidate.medicinalLeafH">
                            <span class="form-text m-b-none text-danger">
                                {{ 'กรุณาเลือกประเภทใบยา' }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label>ชนิดใบยา</label><span class="text-danger"> *</span>
                        <el-select 
                            v-model="medicinalLeafL" 
                            placeholder="เลือกชนิดใบยา"
                            class="w-100"
                            @change="getMedicinalLeafItemV(medicinalLeafH, medicinalLeafL)"
                            v-loading="loading.medicinalLeafL"
                            clearable
                            filterable
                            reserve-keyword
                            :disabled="isDisabled.medicinalLeafL">
                            <el-option
                                v-for="(item,index) in medicinalLeafTypesL"
                                :key="index"
                                :label="item.category_code_2 + ' : ' + item.category_desc_2"
                                :value="item.category_code_2 + '.' + item.category_desc_2">
                            </el-option>
                        </el-select>
                        <div v-if="this.isValidate.medicinalLeafL">
                            <span class="form-text m-b-none text-danger">
                                {{ 'กรุณาเลือกชนิดใบยา' }}
                            </span>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label>กลุ่มใบยา</label><span class="text-danger"> *</span>
                        <el-select 
                            v-model="medicinalItem" 
                            placeholder="เลือกกลุ่มใบยา"
                            class="w-100"
                            v-loading="loading.medicinalItem"
                            clearable
                            filterable
                            reserve-keyword
                            :disabled="isDisabled.medicinalItem"
                            @change="getMedicinalItem(medicinalLeafH, medicinalLeafL, medicinalItem)">
                            <el-option
                                v-for="(item,index) in medicinalLeafItems"
                                :key="index"
                                :label="item.medicinal_leaf_group"
                                :value="item.medicinal_leaf_group">
                            </el-option>
                        </el-select>    
                        <div v-if="this.isValidate.medicinalItem">
                            <span class="form-text m-b-none text-danger">
                                {{ 'กรุณาเลือกกลุ่มใบยา' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-loading="loading.table">
            <history-instead-grades-table   :transDate              = "transDate"
                                            :historyList            = "historyList"
                                            :transBtn               = "transBtn"
                                            :lastNumberSeq          = "lastNumberSeq"
                                            :currentDateTH          = "currentDateTH"
                                            :historyGroupByList     = "historyGroupByList">
                
            </history-instead-grades-table>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['medicinalLeafTypesH', 'transDate', 'transBtn', 'currentDateTH'],
        data() {
            return{
                medicinalLeafH          : '',
                medicinalLeafHOld       : '',
                medicinalLeafL          : '',
                medicinalLeafLOld       : '',
                medicinalItem           : '',
                medicinalLeafTypesL     : [],
                medicinalLeafItems      : [],
                historyList             : [],
                historyGroupByList      : [],
                loading: {
                    medicinalLeafL      : false,
                    medicinalItem       : false,
                    table               : false,
                },
                isDisabled:{
                    medicinalLeafL      : true,
                    medicinalItem       : true,
                    // btnAddLine: true,
                },
                isValidate:{
                    medicinalLeafH      : false,
                    medicinalLeafL      : false,
                    medicinalItem       : false
                },
                lastNumberSeq           : ''
            };
        },
        mounted() {
            // this.setDataTable();
        },
        methods: {
            async getMedicinalLeafTypesL(value) {
                this.loading.medicinalLeafL = true;
                this.loading.medicinalItem = true;
                // $(".table-data").DataTable().destroy();
                // this.setDataTable();
                var params = {
                    medicinalLeafTypesH: value,
                };
                return await axios
                    .get('/pd/ajax/history-instead-grades/get-medicinal-leaf-types-l',{ params })
                    .then(res => {
                        this.medicinalLeafTypesL = res.data.medicinalLeafTypesL;
                        
                        if(this.medicinalLeafHOld != value){
                            this.medicinalLeafL = '';
                            this.medicinalItem = '';
                        }

                        if(this.medicinalLeafTypesL.length != 0){
                            this.medicinalLeafHOld = value;
                            // ชนิดใบยา
                            this.medicinalLeafL = this.medicinalLeafL ? this.medicinalLeafL : ''
                            this.loading.medicinalLeafL = false;
                            this.isDisabled.medicinalLeafL = false;

                            //รหัสใบยา
                            this.medicinalItem = this.medicinalItem ? 
                                                 this.medicinalLeafL == this.medicinalLeafLOld ? 
                                                 this.medicinalItem : '' : '';
                            this.loading.medicinalItem              = false;
                            this.isDisabled.medicinalItem           = this.medicinalItem ? false : true;
                            this.$children[3].isDisabledBtnAddLine  = true;
                            this.$children[3].isDisabledBtnSave     = true;
                        }else{
                            // ชนิดใบยา
                            this.medicinalLeafL             = '';
                            this.loading.medicinalLeafL     = false;
                            this.isDisabled.medicinalLeafL  = true;

                            //รหัสใบยา 
                            this.medicinalItem                      = '';
                            this.loading.medicinalItem              = false;
                            this.isDisabled.medicinalItem           = true;
                            this.$children[3].isDisabledBtnAddLine  = true;
                            this.$children[3].isDisabledBtnSave     = true;
                        }
                    });
            },

            async getMedicinalLeafItemV(medicinalLeafH, medicinalLeafL) {
                // $(".table-data").DataTable().destroy();
                // this.setDataTable();
                this.loading.medicinalItem = true;
                var params = {
                    medicinalLeafTypesH: medicinalLeafH,
                    medicinalLeafTypesL: medicinalLeafL,
                };
                return await axios
                    .get('/pd/ajax/history-instead-grades/get-medicinal-leaf-item-v',{ params })
                    .then(res => {
                        this.medicinalLeafItems = res.data.medicinalLeafItemV;
                        if(this.medicinalLeafItems.length != 0){
                            this.medicinalItem              = this.medicinalItem ? 
                                                              this.medicinalLeafL == this.medicinalLeafLOld ? 
                                                              this.medicinalItem : '' : '';
                            this.loading.medicinalItem      = false;
                            this.isDisabled.medicinalItem   = false;
                            this.medicinalLeafLOld          = this.medicinalLeafL;

                            this.$children[3].isDisabledBtnAddLine  = true;
                            this.$children[3].isDisabledBtnSave     = true;
                        }else{
                            this.medicinalItem              = '';
                            this.loading.medicinalItem      = false;
                            this.isDisabled.medicinalItem   = true;

                            this.$children[3].isDisabledBtnAddLine  = true;
                            this.$children[3].isDisabledBtnSave     = true;
                        }
                    });
            },

            async getMedicinalItem(medicinalLeafH, medicinalLeafL, medicinalItem) {
                // $(".table-data").DataTable().destroy();
                // this.setDataTable();

                if(medicinalItem == ''){
                    this.$children[3].isDisabledBtnAddLine  = true;
                    this.$children[3].isDisabledBtnSave     = true;
                    this.historyList                        = [];
                }
            },

            async search(medicinalLeafH, medicinalLeafL, medicinalItem) {
                let vm = this;
                
                if(!vm.medicinalLeafH){
                    vm.isValidate.medicinalLeafH = true;
                    return;
                }else{
                    vm.isValidate.medicinalLeafH = false;
                }

                if(!vm.medicinalLeafL && vm.isDisabled.medicinalLeafL == false){
                    vm.isValidate.medicinalLeafL = true;
                    return;
                }else{
                    vm.isValidate.medicinalLeafL = false;
                }

                if(!vm.medicinalItem && vm.isDisabled.medicinalItem == false){
                    vm.isValidate.medicinalItem = true;
                    return;
                }else{
                    vm.isValidate.medicinalItem = false;
                }

                //Check Validate MedicinalLeafH and MedicinalLeafL
                if(this.isValidate.medicinalLeafH == true && this.isValidate.medicinalLeafL == true){
                    return;
                }
                var params = {
                    medicinalLeafH: medicinalLeafH,
                    medicinalLeafL: medicinalLeafL,
                    medicinalItem: medicinalItem,
                };

                this.medicinalItem = this.medicinalItem ? this.medicinalItem : '';
                
                this.loading.table = true;
                // $(".table-data").DataTable().destroy();
                await axios
                    .get('/pd/ajax/history-instead-grades/search',{ params })
                    .then(res => {
                        this.historyList                        = res.data.historyList; 
                        this.historyGroupByList                 = res.data.historyGroupByList;
                        this.lastNumberSeq                      = res.data.lastNumberSeq;
                        this.loading.table                      = false;
                        this.$children[3].isDisabledBtnAddLine  = false;
                        this.$children[3].isDisabledBtnSave     = false;
                    });
            },
        },
    };
</script>
