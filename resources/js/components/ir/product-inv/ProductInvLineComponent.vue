<template>
    <div>
        <div v-loading="isLoading">
            <div class="row col-lg-10 col-md-4">
                <label class="col-lg-3 col-md-6 col-form-label text-left" style="padding-left: 5px; padding-top: 20px; vertical-align:middle;">
                <strong> กรมธรรม์ชุดที่ (Policy No.) : </strong>
                </label>
                    <div    class='col-lg-7 col-md-7 w-100' style="padding-top: 6px; padding-top: 20px;"
                            v-if="policy_set_header.policy_set_number !== undefined">
                        {{ this.policy_set_header.policy_set_number + " : " + this.policy_set_header.policy_set_description}} 
                    </div>
            </div>

            <div class="row col-lg-10 col-md-4">
                <label class="col-lg-3 col-md-6 col-form-label text-left" style="padding-left: 5px; padding-top: 20px; vertical-align:middle;">
                <strong> กลุ่มของทรัพย์สิน : </strong>
                </label>
                    <div class='col-lg-7 col-md-7 w-100' style="padding-top: 6px; padding-top: 20px;">
                        {{ this.asset_group_code }} 
                    </div>
            </div>

            <div class="row col-lg-10 col-md-4">
                <label class="col-lg-3 col-md-6 col-form-label text-left" style="padding-left: 5px; padding-top: 20px; vertical-align:middle;">
                <strong> รายการ : </strong>
                </label>
                    <div class='col-lg-7 col-md-7 w-100' style="padding-top: 6px; padding-top: 20px;">
                        {{ this.product.description }} 
                    </div>
            </div>

            <div class="row col-lg-10 col-md-4">
                <label class="col-lg-3 col-md-6 col-form-label text-left" style="padding-left: 5px; padding-top: 20px; vertical-align:middle;">
                <strong> ประเภทค่าใช้จ่าย : </strong>
                </label>
                    <div    class='col-lg-7 col-md-7 w-100' style="padding-top: 6px; padding-top: 20px;"
                            v-if="accounts_mapping.account_code !== undefined">
                        {{ this.accounts_mapping.account_code + " : " + this.accounts_mapping.description }} 
                    </div>
            </div>

            <div class="row col-lg-10 col-md-4">
                <label class="col-lg-3 col-md-6 col-form-label text-left" style="padding-left: 5px; padding-top: 20px; vertical-align:middle;">
                <strong> รหัสบัญชี : </strong>
                </label>
                    <div class='col-lg-7 col-md-7 w-100' style="padding-top: 6px; padding-top: 20px;">
                        {{ this.account_combine }} 
                    </div>
            </div>
        </div>

        <div class="row" style="padding-left: 15px; padding-top: 10px;">
            <div>
                <label  class="col-lg-12 col-md-6 col-form-label text-feft" style="width: 80px;padding-left: 5px;padding-right: 0px; padding-top: 20px;">
                    รหัสหน่วยงาน
                </label><span class="text-danger"> *</span>
            </div>
            <div class="col-sm-4 el_select padding_12" style="margin-left: 20px;">
                <input type="hidden" name="department_code" v-model="department_code" autocomplete="off">
                <el-select  v-model="department_code"
                            filterable
                            remote
                            clearable 
                            reserve-keyword
                            >
                    <el-option  v-for="department in departments"
                                :key="department.department_code"
                                :label="department.department_code + ' : ' + department.description"
                                :value="department.department_code + ',' + department.description">
                    </el-option>
                </el-select>
            </div>
        </div> 
        <div class="row" style="padding-left: 15px; padding-top: 10px;">
            <div>
                <label  class="col-lg-12 col-md-6 col-form-label text-feft" style="width: 80px;padding-left: 5px;padding-right: 0px; padding-top: 20px;">
                    รหัสคลังสินค้า
                </label><span class="text-danger"> *</span>
            </div>
            <div class="col-sm-4 el_select padding_12" style="margin-left: 20px;">
                <input type="hidden" name="subinventory_code" v-model="subinventory_code" autocomplete="off">
                <el-select  v-model="subinventory_code"
                            filterable
                            remote
                            clearable
                            reserve-keyword
                            @change="getLocator(subinventory_code)">
                    <el-option  v-for="(subInventory, index) in subInventories"
                                :key="index"
                                :label="subInventory.subinventory_code + ' : ' + subInventory.subinventory_desc"
                                :value="subInventory.subinventory_code + ',' + subInventory.subinventory_desc">
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="row" style="padding-left: 15px; padding-top: 10px;">
            <div>
                <label  class="col-lg-12 col-md-6 col-form-label text-feft" style="width: 85px;padding-left: 5px;padding-right: 0px; padding-top: 20px;">
                    กลุ่มสินค้าย่อย
                </label><span class="text-danger"> *</span>
            </div>
            <div class="col-sm-4 el_select padding_12" style="margin-left: 20px; margin-left: 15px;">
                <input type="hidden" name="sub_group_code" v-model="subGroup" autocomplete="off">
                <el-select  v-model="subGroup"
                            filterable
                            remote
                            clearable 
                            reserve-keyword
                            >
                    <el-option  v-for="(subGroup,index) in subGroups"
                                :key="index"
                                :label="subGroup.sub_group_code + ' : ' + subGroup.sub_group_description"
                                :value="subGroup.sub_group_code + ',' + subGroup.sub_group_description">
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="mt-2">
            <hr>
            <div class="text-right">
                <button :class="btnTrans.add.class + ' btn-sm'" 
                        type="submit" 
                        @click.prevent="addLine"> 
                    <i :class="btnTrans.add.icon" aria-hidden="true"></i> 
                    {{ btnTrans.add.text }} 
                </button>
            </div>
            <div class="table-responsive">
                <table class="table-sm" style="display: block; overflow: auto; max-height: 400px; position: sticky;">
                    <thead>
                        <tr>
                            <th width="1%" class="sticky-col th-row"> </th>
                            <th width="50%" class="sticky-col th-row"> รหัสประเภท (Category Code)<span class="text-danger"> *</span></th>
                            <th width="30%" class="sticky-col th-row"> Locator </th>
                            <th width="1%" class="sticky-col th-row"> </th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(row, index) in lines" :key="index" :row="row" v-bind:class="[index == lines.length - 1 ? 'endTable' : '']">
                        <td style="vertical-align:middle;"> {{ index + 1 }} </td>
                        <td>
                            <input type="hidden" name="cate_codes[]" v-model="row.cate_code" autocomplete="off">
                            <el-select  v-model="row.cate_code"
                                        filterable
                                        remote
                                        clearable 
                                        reserve-keyword
                                        class="w-100"
                                        @change="checkDuplicateCategory(index)"
                                        >
                                <el-option  v-for="(itemCategory,index) in itemCategories"
                                            :key="index"
                                            :label="itemCategory.lookup_code + ' : ' + itemCategory.description"
                                            :value="itemCategory.lookup_code">
                                </el-option>
                            </el-select>
                        </td>
                        <td>
                            <input type="hidden" name="locators[]" v-model="row.locator" autocomplete="off">
                            <el-select  v-model="row.locator"
                                        filterable
                                        remote
                                        clearable  
                                        reserve-keyword
                                        class="w-100"
                                        v-loading="loading.locator"
                                        :remote-method="searchFunction"
                                        :disabled="isDisabled"
                                        @change="checkDuplicateLocators(index)">
                                <el-option  v-for="(itemLocatorsList,index) in itemLocatorsLists"
                                            :key="index"
                                            :label="itemLocatorsList.meaning + ' : ' + itemLocatorsList.description"
                                            :value="itemLocatorsList.flex_value">
                                </el-option>
                            </el-select>
                        </td>
                        <td style="vertical-align:middle;">
                            <button @click.prevent="removeRow(index)" class="btn btn-sm btn-danger">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row" style="padding-left: 20px; padding-top: 10px;">
            <label>Active</label><span class="text-danger"> *</span>
            <input type="hidden" name="activeFlag" :value="activeFlag">
            <el-checkbox v-model="activeFlag" size="medium" style="margin-left: 45px;"></el-checkbox>
        </div>

        <div class="row clearfix text-right">
            <div class="col" style="margin-top: 15px;">
                <button :class="btnTrans.save.class + ' btn-sm'" 
                        type="submit" 
                        :disabled="isDisabledBtu"> 
                    <i :class="btnTrans.save.icon" aria-hidden="true"></i> 
                    {{ btnTrans.save.text }} 
                </button>
                <a :href="backUrl" 
                    type="button" 
                    :class="btnTrans.cancel.class + ' btn-sm'">
                    <i :class="btnTrans.cancel.icon" aria-hidden="true"></i> 
                    {{ btnTrans.cancel.text }}
                </a>
            </div>
        </div>

    </div>
</template>
<script>
    import uuidv1 from 'uuid/v1';
    export default {
        props:['groupCode', 'backUrl', 'oldInput', 'btnTrans'],
        data() {
            return {
                product             : '',
                department_code     : this.oldInput.length != 0 ? this.oldInput.department_code : '',
                subinventory_code   : this.oldInput.length != 0 ? this.oldInput.subinventory_code : '',
                subGroup            : this.oldInput.length != 0 ? this.oldInput.sub_group_code : '',
                departments         : [],
                subInventories      : [],
                subGroups           : [],
                itemCategories      : [],
                policy_set_header   : '',
                itemLocatorsLists   : [],
                account_combine     : '',
                asset_group_code    : '',
                accounts_mapping    : '',
                account_code        : '',
                isDisabled          : true,
                isLoading           : false,
                isDisabledBtu       : false,

                lines               : [],
                id                  : uuidv1(),
                lineId              : '',
                cate_code           : '',
                loading: {
                    locator         : false,
                },
                lineList            : false,
                activeFlag          : true,
                value               : '',
            }
        },

        mounted(){
            if(this.oldInput.length != 0){
                this.addLine();
            }else{
                this.addLine();
            }

            if (this.groupCode) {
                this.ProductH();
            }   
        },

        watch: {
            groupCode: function() {
                 
                this.ProductH();
            }
        },
        
        methods: {
            ProductH(){
                this.isLoading              = true;
                this.product                = '';
                this.departments            = [];
                this.subInventories         = [];
                this.subGroups              = [];
                this.itemCategories         = [];
                this.policy_set_header      = '';
                this.account_combine        = '';
                this.accounts_mapping       = '';
                this.asset_group_code       = '';
                this.account_code           = '';
                
                if (this.groupCode) {
                    axios.get(`/ir/ajax/product-group`, {
                        params: {
                            groupCode: this.groupCode,
                        }
                    }).then(res => {
                        let dt = res.data.data;
                        this.product           = dt.groupProduct;
                        this.departments       = dt.departments;
                        this.subInventories    = dt.subInventories;
                        this.subGroups         = dt.subGroups;
                        this.itemCategories    = dt.itemCategories;
                        this.policy_set_header = dt.groupProduct ? dt.groupProduct.policy_set_header : '';
                        this.accounts_mapping  = dt.groupProduct ? dt.groupProduct.accounts_mapping : '';
                        this.account_combine   = dt.groupProduct ? dt.groupProduct.accounts_mapping.account_combine : '';
                        this.asset_group_code  = dt.groupProduct ? dt.groupProduct.asset_group.description : '';
                        this.isLoading         = false;
                    });
                }
            },
            
            async getLocator(value) {
                var params = {
                    subinventory_code : value
                };
                this.loading.locator = true;
                return axios
                    .get('/ir/ajax/get-locator',{ params })
                    .then(res => {
                        if(res.data.status == 'e'){
                            swal({
                                title: "warning !",
                                text: "รหัสคลังสินค้านี้ ไม่มีLocator",
                                type: "warning",
                                showConfirmButton: true
                            });
                            this.itemLocatorsLists = [];
                            this.loading.locator = false;
                            this.locator = '';
                            this.isDisabled = true;
                        }else if(res.data.status == 'clearData'){
                            this.itemLocatorsLists = [];
                            this.loading.locator = false;
                            this.locator = '';
                            this.isDisabled = true;
                        }
                        else{
                            this.itemLocatorsLists = res.data.itemLocators
                            this.loading.locator = false;
                            this.locator = '';
                            this.isDisabled = false;
                        }
                    });
            },

            addLine() {
                if(this.oldInput.length != 0){
                    this.oldInput.cate_codes.forEach((element, index) => {
                        this.getLocator(this.oldInput.subinventory_code);
                        this.lines.push({   
                            id               :  uuidv1(),
                            cate_code        :  element === null ? '' : Number(element),
                            locator          :  element === null ? '' : this.oldInput.locators[index],
                        });
                    });          
                    return this.oldInput = [];           
                }else{
                    this.lines.push({    
                        id               : uuidv1(),
                        cate_code        : '',
                        locator          : this.locator ? this.locator : '',
                    });
                }

                this.$nextTick(() => {
                    const el = this.$el.getElementsByClassName('endTable')[0];
                    if (el) {
                        el.scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
                    }
                });

            },

            removeRow: function (index) {
                this.lines.splice(index, 1);
            },

            checkDuplicateCategory(index) {
                this.lines.forEach((element,i) => {
                    if(i != index){
                        if(this.lines[index].cate_code == element.cate_code && this.lines[index].locator == element.locator){
                            this.showAlert();
                        }
                    }
                });
            },

            checkDuplicateLocators(index){
                this.lines.forEach((element,i) => {
                    if(i != index){
                        if(this.lines[index].locator == element.locator && this.lines[index].cate_code == element.cate_code){
                            this.showAlert();
                        }
                    }
                });

                if(this.lines.locator != ''){
                    this.searchFunction();
                }   
            },

            showAlert(){
                swal({
                    title: "Error !",
                    text: "ไม่สามารถเลือกชุดข้อมูลนี้ได้ เนื่องจากมีชุดข้อมูลซ้ำ",
                    type: "error",
                    showConfirmButton: true
                });
            },

            async searchFunction(query){
                this.loading.locator = true;
                await axios.get('/ir/ajax/get-value-set', { 
                    params: {
                        subinventory_code : this.subinventory_code,
                        query: query,
                    }
                })
                .then(res => {
                    this.itemLocatorsLists = res.data.data;
                })
                .catch(err => {
                     
                })
                .then( () => {
                    this.loading.locator = false;
                });

            },

        },
    }
</script>

<style scope>
    .sticky-col {
        position: sticky;
        background-color: #f7f7f7;
        z-index: 9999;
    }

    .first-col {
        width: 150px;
        min-width: 100px;
        max-width: 150px;
        left: 0px;
    }

    .second-col {
        width: 150px;
        min-width: 150px;
        max-width: 150px;
        left: 116px;
    }

    .th-row {
        top: 0;
    }

    .fo-col {
        width: 200px;
        min-width: 150px;
        max-width: 200px;
        left: 416px;
    }

    .fi-col {
        width: 200px;
        min-width: 150px;
        max-width: 200px;
        left: 566px;
    }

    .t1-col {
        width: 200px;
        min-width: 150px;
        max-width: 200px;
        left: 0px;
    }

    .t2-col {
        width: 200px;
        min-width: 150px;
        max-width: 200px;
        left: 566px;
    }
</style>