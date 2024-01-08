<template>
    <div>
        <div class="row">
            <div class="col-md-1">
            </div>
            <div class="col-md-5">
                    <label> ประเภทการขาย <span class="text-danger">*</span></label>
                    <input type="hidden" name="sales_type"  :value="sales_type" autocomplete="off">
                    <el-select  v-model="sales_type"
                                    filterable
                                    remote
                                    reserve-keyword
                                    clearable
                                    class="w-100" @change="getSelectesalesType()"
                                    :disabled="this.disabledEdit">              
                        <el-option  v-for="type in salesTypes"
                                    :key="type.value"
                                    :label="type.description"
                                    :value="type.value">
                        </el-option>
                    </el-select>
            </div>
            <div class="col-md-5">
                <label> Item Category (ประเภท) <span class="text-danger">*</span></label>
                <input type="hidden" name="item_category"  :value="item_category" autocomplete="off">
                <el-select  v-model="item_category"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                @change="changeCategory()"
                                :disabled="this.disabledEdit || this.disabledData"
                                >              
                    <el-option  v-for="category in itemCategories"
                                :key="category.categorys"
                                :label="category.categorys + ' : ' + category.description"
                                :value="category.categorys">
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1">
            </div>
            <div class="col-md-5" v-loading="itemGroupLoading">
               <label> Item Category (กลุ่ม) <span class="text-danger">*</span></label>
                <input type="hidden" name="item_group"  :value="item_group" autocomplete="off">
                <el-select  v-model="item_group"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                @change="changeGroup()"
                                :disabled="this.disabledEdit || this.itemGroups.length < 1 || this.disabledData"
                                >              
                    <el-option  v-for="itemGroup in itemGroups"
                                :key="itemGroup.groups"
                                :label="itemGroup.groups + ' : ' + itemGroup.description"
                                :value="itemGroup.groups">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-5">
                <label> ตราผลิตภัณฑ์ <span class="text-danger">*</span></label>
                <input type="hidden" name="item_id"  :value="item_id" autocomplete="off">
                <el-select  v-model="item_id"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" 
                                :remote-method="getItems"
                                @change="getSelectedItem();"
                                :disabled="this.disabledEdit || this.disabledData">              
                    <el-option  v-for="(item, index) in itemLists"
                                :key="index"
                                :label="item.item_code + ' : ' + item.item_description"
                                :value="item.inventory_item_id">
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1">
            </div>
            <div class="col-md-5">
                <label> ชื่อตราผลิตภัณฑ์ </label>            
                <el-input name="item_description" v-model="item_description" disabled> {{ item_description }} </el-input>
            </div>
            <div class="col-md-5">
                <label> ชื่อที่ปรากฏในหน้าจอ E-Commerce <span class="text-danger">*</span></label>            
                <el-input name="ecom_item_description" v-model="ecom_item_description" :disabled="this.disabledData"> {{ ecom_item_description }} </el-input>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1">
            </div>
            <div class="col-md-5">
                <label> ชื่อที่ปรากฏในรายงาน <span class="text-danger">*</span></label>            
                <el-input name="report_item_display" v-model="report_item_display" :disabled="this.disabledData"> {{ report_item_display }} </el-input>
            </div>
            <div class="col-md-5">
                <label> ชนิดผลิตภัณฑ์ <span class="text-danger">*</span></label>
                <input type="hidden" name="product_type"  :value="product_type" autocomplete="off">
                <el-select  v-model="product_type"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100" :disabled="this.productTypeLoading || this.disabledData">              
                    <el-option  v-for="(productType, index) in productTypes"
                                :key="index"
                                :label="productType.description"
                                :value="productType.lookup_code">
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <label> ลำดับหน้าจอ </label>
                <el-input name="screen_number" v-model="screen_number" @input="onlyNumeric" :disabled="this.disabledData"></el-input>
            </div>
            <div class="col-md-5">
                <label> รสชาติ </label>
                <input type="hidden" name="taste_code"  :value="taste_code" autocomplete="off">
                <el-select  v-model="taste_code"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100"
                                :disabled="this.disabledData">              
                    <el-option  v-for="taste in tastes"
                                :key="taste.value"
                                :label="taste.description"
                                :value="taste.value">
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <label> ก้นกรอง <span class="text-danger">*</span></label>
                <input type="radio" name="filter_flag" value="Y" class="ml-3" v-model="filter_flag" :disabled="this.disabledData"> มี
                <input type="radio" name="filter_flag" value="N" class="ml-3" v-model="filter_flag" :disabled="this.disabledData"> ไม่มี
            </div>
            <div class="col-md-5">
                
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <label> รหัสบัญชีหลัก <span class="text-danger">(สำหรับกองรายได้และภาษี)</span> </label>
                <input type="hidden" name="main_account"  :value="main_account" autocomplete="off">
                <el-select  v-model="main_account"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100"
                                @change="getSubAccounts"
                                :disabled="this.disabledData">              
                    <el-option  v-for="mainAccount in mainAccounts"
                                :key="mainAccount.main_account"
                                :label="mainAccount.main_account + ' : ' + mainAccount.description"
                                :value="mainAccount.main_account">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-5" v-loading="this.subLoading">
                <label> รหัสบัญชีย่อย <span class="text-danger">(สำหรับกองรายได้และภาษี)</span> </label>
                <input type="hidden" name="sub_account"  :value="sub_account" autocomplete="off">
                <el-select  v-model="sub_account"
                                filterable
                                remote
                                reserve-keyword
                                clearable
                                class="w-100"
                                :disabled="this.subAccounts.length < 1 || this.disabledData">              
                    <el-option  v-for="subAccount in subAccounts"
                                :key="subAccount.meaning"
                                :label="subAccount.meaning + ' : ' + subAccount.description"
                                :value="subAccount.meaning">
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <label> วันที่เริ่มต้น</label>
                <!-- <el-date-picker 
                    v-model="start_date"
                    style="width: 100%;"
                    type="date"
                    placeholder="วันที่เริ่มต้น"
                    name="start_date"
                    format="dd-MM-yyyy"
                    >
                </el-date-picker>   -->
                <ct-datepicker
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
                    :disabled="this.disabledData"
                />
                <input type="hidden" name="start_date" :value="start_date">
            </div>
            <div class="col-md-5">
                <label> วันที่สิ้นสุด</label>
                <!-- <el-date-picker 
                    v-model="end_date"
                    style="width: 100%;"
                    type="date"
                    placeholder="วันที่สิ้นสุด"
                    name="end_date"
                    format="dd-MM-yyyy"
                    >
                </el-date-picker>   -->

                <ct-datepicker
                  class="my-1 col-sm-12 form-control"
                  onkeydown="return event.key != 'Enter';"
                  style="width: 100%;"
                  placeholder="โปรดเลือกวันที่สิ้นสุด"
                  :enableDate="date => isInRange(date, toJSDate(start_date), null, true)"
                  :value="toJSDate(end_date, 'yyyy-MM-dd')"
                  @change="(date) => {
                      end_date = jsDateToString(date)
                  }"
                  :disabled="this.disabledData"
                />
                <input type="hidden" name="end_date" :value="end_date">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-1"></div>
            <div class="col-md-5">
                <label> สี </label>
                <div>
                    <input type="color" name="color_code" class="w-100" v-model="color_code"> 
                </div>
            </div>
            <div class="col-md-5">
                <label> สินค้าหมด </label>
                <input type="checkbox" name="out_of_stock" class="ml-3" v-model="out_of_stock" :disabled="this.disabledData">
            </div>
        </div>
    </div>
</template>

<script>

import moment from 'moment';
import {isInRange, jsDateToString, toJSDate, toThDateString} from '../../dateUtils'

export default {
    props: ['itemCategories', 'salesTypes', 'tastes', 'productTypeDomestics', 'productTypeExports', 'mainAccounts', 'defaultValue', 'old', 'setName', 'items'],
    data(){
        return {
            item_category          : this.old.item_category         ? this.old.item_category         : this.defaultValue ? this.defaultValue.item_category         : '' ,
            item_group             : this.old.item_group            ? this.old.item_group            : this.defaultValue ? this.defaultValue.item_group            : '' ,
            item_id                : this.old.item_id               ? Number(this.old.item_id)       : this.defaultValue ? Number(this.defaultValue.item_id)       : '' ,
            item_description       : this.old.item_description      ? this.old.item_description      : this.defaultValue ? this.defaultValue.item_description      : '',
            ecom_item_description  : this.old.ecom_item_description ? this.old.ecom_item_description : this.defaultValue ? this.defaultValue.ecom_item_description : '',
            report_item_display    : this.old.report_item_display   ? this.old.report_item_display   : this.defaultValue ? this.defaultValue.report_item_display   : '',
            sales_type             : this.old.sales_type            ? this.old.sales_type            : this.defaultValue ? this.defaultValue.sale_type_code        : '',
            productTypes           : [],
            // product_type           : this.defaultValue ? this.defaultValue.product_type_code     : '',
            product_type           : '',
            screen_number          : this.old.screen_number        ? this.old.screen_number         : this.defaultValue ? this.defaultValue.screen_number         : '',
            taste_code             : this.old.taste_code           ? this.old.taste_code            : this.defaultValue ? this.defaultValue.taste_code            : '',
            main_account           : this.old.main_account         ? this.old.main_account          : this.defaultValue ? this.defaultValue.main_account_code     : '',
            sub_account            : this.old.sub_account          ? this.old.sub_account           : this.defaultValue ? this.defaultValue.sub_account_code      : '',
            filter_flag            : this.old.filter_flag          ? this.old.filter_flag           : this.defaultValue ? this.defaultValue.filter_flag           : '',
            disabledData           : true,
            disabledEdit           : this.defaultValue ? true  : false,
            start_date             : this.old.start_date           ? this.old.start_date            : this.defaultValue ? this.defaultValue.start_date : '',
            end_date               : this.old.end_date             ? this.old.end_date              : this.defaultValue ? this.defaultValue.end_date   : '',
            // main_account: '',
            // sub_account: '',
            subAccounts: [],
            subLoading        : false,
            productTypeLoading: true,

            itemGroupLoading: false,
            itemLoading: true,


            itemGroups: [],
            itemLists:  [],

            out_of_stock: this.old.out_of_stock ? true : this.defaultValue ? this.defaultValue.attribute1 == 'Y' ? true : false : false,

            color_code: this.old.color_code ? this.old.color_code : this.defaultValue ? this.defaultValue.color_code : '',

            toJSDate,
            jsDateToString,
            isInRange,
            toThDateString,
        }
    },
    mounted(){
        this.itemLists = this.items;
        // console.log('setName <---> ' + this.setName);

        if (this.sales_type) {
            this.getSelectesalesType();
        }

        if (this.main_account) {
            this.getSubAccounts();
            // console.log('zzzz  ---->  ' + this.subAccounts);

            // if (this.subAccounts) {
            //     this.getSelectedSubAccount();
            // }
        }
        if (this.item_category) {
            // console.log('item_category ---> ' + this.item_category);

            this.getItemGroups();

            if (this.item_group) {

                this.getItems(this.item_id);
                        
                // if (this.item_id) {
                //     this.getSelectedItem();
                // }
            }
        }

        if (this.defaultValue) {
            this.start_date = this.defaultValue.start_date ? moment(this.defaultValue.start_date).format("yyyy-MM-DD") : '';
            this.end_date   = this.defaultValue.end_date   ? moment(this.defaultValue.end_date).format("yyyy-MM-DD") : '';
        }
    },
  
    methods: {
        
        async getItemGroups(){
            // this.item_group        = '';
            // this.item_id           = '';
            // this.item_description  = '';
            // this.ecom_item_description = '';
            // this.report_item_display   = '';

            if (this.item_category) {
                this.itemGroupLoading = true;

                this.itemGroups = [];
                this.itemLists = [];

                await axios.get("/om/ajax/get-item-cate", {
                    params: {
                        item_category: this.item_category,
                    }
                })
                .then(res => {
                    this.itemGroupLoading = false;
                    this.itemGroups = res.data;
                })
                .catch(err => {
                    console.log(err)
                });
            }else {
                this.itemGroups = [];
                this.itemLists  = [];
                this.item_group        = '';
                this.item_id           = '';
                this.item_description  = '';
                this.ecom_item_description = '';
                this.report_item_display   = '';
            }
        },
        async getItems(query){
            console.log('getItems');

            // if (this.item_group) {

                this.itemLoading = false;
                this.itemLists = [];

                await axios.get("/om/ajax/get-item", {
                    params: {
                        item_category: this.item_category,
                        item_group:    this.item_group,
                        query:         query,
                    }
                })
                .then(res => {
                    // this.itemLoading = false;
                    this.itemLists = res.data;


                    this.selectedItem = this.itemLists.find( i => {
                        return i.inventory_item_id == this.item_id;
                    });

                    // //Default ชนิดผลิตภัณฑ์
                    // this.selected = this.itemGroups.find(i => {
                    //     return i.groups == this.item_group;
                    // });
                    // let group_desc = this.selected ? this.selected.description : '';
                    // console.log('getItems group_desc',  group_desc);
                    // if (group_desc) {
                    //     this.selectedData = this.productTypes.find( i => {
                    //         return i.description == group_desc;
                    //     });
                    //     this.product_type  = this.selectedData ? this.selectedData.lookup_code : '';
                    // }
                    
                    // if (this.item_id) {
                    //     // console.log('getItems <------> has item_id');
                    //     this.item_description      = this.defaultValue ? this.defaultValue.item_description      : this.selectedItem ? this.selectedItem.item_description : '';
                    //     this.ecom_item_description = this.defaultValue ? this.defaultValue.ecom_item_description : this.selectedItem ? this.selectedItem.item_description : '';
                    //     this.report_item_display   = this.defaultValue ? this.defaultValue.report_item_display   : this.selectedItem ? this.selectedItem.item_description : '';

                    //     //Default รสชาติ
                    //     let taste_name = this.selectedItem ? this.selectedItem.taste_name : '';
                    //     this.selectedData = this.tastes.find( i => {
                    //         return i.description == taste_name;
                    //     });
                    //     this.taste_code  = this.selectedData ? this.selectedData.value : '';

                    // } else {
                    //     this.item_description      = '';
                    //     this.ecom_item_description = '';
                    //     this.report_item_display   = '';
                    // }
                })
                .catch(err => {
                    console.log(err)
                });
            // }else {
                
            //     this.itemLoading = true;

            //     this.item_id           = '';
            //     this.item_description  = '';
            //     this.ecom_item_description = '';
            //     this.report_item_display   = '';
            // }
        },
        async getSelectedItem() {
            this.selectedItem = this.itemLists.find( i => {
                return i.inventory_item_id == this.item_id;
            });
            // console.log('selectedItem <---> ' + this.selectedItem);

            //Default ชนิดผลิตภัณฑ์
            this.selected = this.itemGroups.find(i => {
                return i.groups == this.item_group;
            });
            let group_desc = this.selected ? this.selected.description : '';
            console.log('getItems group_desc',  group_desc);
            if (group_desc) {
                this.selectedData = this.productTypes.find( i => {
                    return i.description == group_desc;
                });
                this.product_type  = this.selectedData ? this.selectedData.lookup_code : '';
            }

            // console.log('selectedItem item <---> ' + this.selectedItem.item_description);
            if (this.item_id) {
                
                this.item_description      = this.defaultValue ? this.defaultValue.item_description      : this.selectedItem ? this.selectedItem.item_description : '';
                this.ecom_item_description = this.defaultValue ? this.defaultValue.ecom_item_description : this.selectedItem ? this.selectedItem.item_description : '';
                this.report_item_display   = this.defaultValue ? this.defaultValue.report_item_display   : this.selectedItem ? this.selectedItem.item_description : '';

                //Default รสชาติ
                let taste_name = this.selectedItem ? this.selectedItem.taste_name : '';
                this.selectedData = this.tastes.find( i => {
                    return i.description == taste_name;
                });
                this.taste_code  = this.selectedData ? this.selectedData.value : '';

                // สามารถเลือก item ก่อนได้
                if (!this.item_category || !this.item_group) {
                    this.item_category   = this.selectedItem ? this.selectedItem.categorys : '';
                    this.item_group      = this.selectedItem ? this.selectedItem.groups : '';

                    if (this.item_category) {
                        this.itemGroupLoading = true;
                        this.itemGroups = [];

                        await axios.get("/om/ajax/get-item-cate", {
                            params: {
                                item_category: this.item_category,
                            }
                        })
                        .then(res => {
                            this.itemGroupLoading = false;
                            this.itemGroups = res.data;

                            //Default ชนิดผลิตภัณฑ์
                            this.selected = this.itemGroups.find(i => {
                                return i.groups == this.item_group;
                            });
                            let group_desc = this.selected ? this.selected.description : '';
                            console.log('getItems group_desc',  group_desc);
                            if (group_desc) {
                                this.selectedData = this.productTypes.find( i => {
                                    return i.meaning == group_desc;
                                });
                                this.product_type  = this.selectedData ? this.selectedData.lookup_code : '';
                            }
                        })
                        .catch(err => {
                            console.log(err)
                        });
                    }
                    
                }
                
            } else {
                this.item_description      = '';
                this.ecom_item_description = '';
                this.report_item_display   = '';
                this.getItems();
            }
        },
        getSelectesalesType() {
            this.productTypeLoading = true;
            this.product_type = '';
            if (this.sales_type) {
                if (this.sales_type == 'DOMESTIC') {
                    this.productTypes = this.productTypeDomestics;

                    //Default ชนิดผลิตภัณฑ์
                    if (this.item_group) {
                        this.selected = this.itemGroups.find(i => {
                            return i.groups == this.item_group;
                        });
                        let group_desc = this.selected ? this.selected.description : '';

                        if (group_desc) {
                            this.selectedData = this.productTypes.find( i => {
                                return i.meaning == group_desc;
                            });
                            this.product_type  = this.selectedData ? this.selectedData.lookup_code : '';
                        }
                    }

                    if (this.old.product_type) {
                        this.selectedData = this.productTypes.find( i => {
                            return i.lookup_code == this.old.product_type;
                        });
                        this.product_type  = this.selectedData ? this.selectedData.lookup_code : '';
                    }
                    else if (this.defaultValue) {
                        this.selectedData = this.productTypes.find( i => {
                            return i.lookup_code == this.defaultValue.product_type_code;
                        });
                        this.product_type  = this.selectedData ? this.selectedData.lookup_code : '';
                    } 
                } else {
                    this.productTypes = this.productTypeExports;
                    
                    //Default ชนิดผลิตภัณฑ์
                    if (this.item_group) {
                        this.selected = this.itemGroups.find(i => {
                            return i.groups == this.item_group;
                        });
                        let group_desc = this.selected ? this.selected.description : '';

                        if (group_desc) {
                            this.selectedData = this.productTypes.find( i => {
                                return i.meaning == group_desc;
                            });
                            this.product_type  = this.selectedData ? this.selectedData.lookup_code : '';
                        }
                    }
                    
                    if (this.old.product_type) {
                        this.selectedData = this.productTypes.find( i => {
                            return i.lookup_code == this.old.product_type;
                        });
                        this.product_type  = this.selectedData ? this.selectedData.lookup_code : '';
                    }
                    else if (this.defaultValue) {
                        this.selectedData = this.productTypes.find( i => {
                            return i.lookup_code == this.defaultValue.product_type_code;
                        });
                        this.product_type  = this.selectedData ? this.selectedData.lookup_code : '';
                    } 
                    // this.disabledData = false;
                }
                
                this.productTypeLoading = false;
                this.disabledData = false;
            }  else {
                this.item_category         = '';
                this.item_group            = '';
                this.item_id               = '';
                this.item_description      = '';
                this.ecom_item_description = '';
                this.report_item_display   = '';
                // this.sales_type = '';
                this.product_type          = '';
                this.screen_number         = '';
                this.taste_code            = '';
                this.main_account          = '';
                this.sub_account           = '';
                this.start_date            = '';
                this.end_date              = '';
                this.filter_flag           = '';
                this.out_of_stock          = '';
                // this.product_type = "";
                this.disabledData          = true;
            }

            
        },
        async getSubAccounts() {
            if (!this.main_account) {
                this.subLoading = true;
                this.sub_account = "";
                this.subAccounts = [];
            }
            console.log('getSubAccounts setName -- ' + this.setName);

            axios
                .get("/om/ajax/sub-accounts", {
                    params: {
                        main_account_id: this.main_account,
                        set_name:        this.setName,
                    }
                })
                .then(res => {
                    this.subLoading = false;
                    
                    this.subAccounts = res.data;

                    // console.log(this.subAccounts);

                    // if (this.subAccounts) {
                    //     if (this.old.sub_account) {
                    //         console.log('old   --->  ' + this.old.sub_account);
                    //         this.selectedData = this.subAccounts.find( i => {
                    //             return i.meaning == this.old.sub_account;
                    //         });
                    //         this.sub_account  = this.selectedData.meaning;
                    //     }
                    //     else if (this.defaultValue) {
                    //         console.log('defaultValue --->  ' + this.defaultValue.sub_account);
                    //         this.selectedData = this.subAccounts.find( i => {
                    //             return i.meaning == this.defaultValue.sub_account;
                    //         });
                    //         this.sub_account  = this.selectedData.meaning;
                    //     }
                    // }
                });
        },
        changeGroup(){
            this.item_id = '';
            this.item_description = '';
            this.ecom_item_description = '';
            this.report_item_display = '';
            // this.sales_type = '';
            this.product_type = '';
            this.screen_number = '';
            this.taste_code = '';
            this.main_account = '';
            this.sub_account = '';
            this.start_date = '';
            this.end_date = '';
            this.filter_flag = '';
            this.out_of_stock = '';

            this.getItems();
        },
        changeCategory(){
            this.item_group            = '',
            this.item_id               = '';
            this.item_description      = '';
            this.ecom_item_description = '';
            this.report_item_display   = '';
            // this.sales_type            = '';
            this.product_type          = '';
            this.screen_number         = '';
            this.taste_code            = '';
            this.main_account          = '';
            this.sub_account           = '';
            this.start_date            = '';
            this.end_date              = '';
            this.filter_flag           = '';
            this.out_of_stock          = '';

            this.getItemGroups();
        },
        onlyNumeric() {
            this.screen_number = this.screen_number.replace(/[^0-9 .]/g, '');
        },
    },
    
}
</script>