<template>
    <div>
        <div class="row">
            <div class="col-sm-3" style="text-align:left;">
                <label class="control-label">
                        ระบุชุดกรมธรรม์
                </label>
                <input type="hidden" name="search[policy_set_header_id]" v-model="policySelect" autocomplete="off">
                <el-select  v-model="policySelect"
                            filterable
                            remote
                            clearable 
                            reserve-keyword
                            style="width: 100%;"
                            @change="getSubGroup(policySelect)"
                            placeholder="ระบุชุดกรมธรรม์">
                    <el-option  v-for="policySetHeader in policySetHeaders"
                                :key="policySetHeader.policy_set_header_id"
                                :label="policySetHeader.policy_set_number + ' : ' + policySetHeader.policy_set_description"
                                :value="policySetHeader.policy_set_header_id">
                    </el-option>
                </el-select>
            </div>
            <div class="col-sm-3" style="text-align:left;">
                <label class="control-label">
                        ระบุกลุ่มของทรัพย์สิน
                </label>
                <input type="hidden" name="search[asset_group]" v-model="assetGroupSelect" autocomplete="off">
                <el-select  v-model="assetGroupSelect"
                            filterable
                            remote
                            clearable 
                            reserve-keyword
                            style="width: 100%;"
                            placeholder="ระบุกลุ่มของทรัพย์สิน">
                    <el-option  v-for="assetGroup in assetGroups"
                                :key="assetGroup.value"
                                :label="assetGroup.meaning + ' : '+ assetGroup.description"
                                :value="assetGroup.value">
                    </el-option>
                </el-select>
            </div>
            <div class="col-sm-3" style="text-align:left;">
                <label class="control-label">
                        ระบุรายการ
                </label>
                <input type="hidden" name="search[group_products]" v-model="groupProductsSelect" autocomplete="off">
                <el-select  v-model="groupProductsSelect"
                            filterable
                            remote
                            clearable 
                            reserve-keyword
                            style="width: 100%;"
                            placeholder="ระบุรายการ">
                    <el-option  v-for="groupProduct in groupProducts"
                                :key="groupProduct.group_product_id"
                                :label="groupProduct.description"
                                :value="groupProduct.group_product_id">
                    </el-option>
                </el-select>
            </div>
            <div class="col-sm-3" style="text-align:left;">
                <label class="control-label">
                        สถานะ
                </label>
                <input type="hidden" name="search[status]" v-model="statusSelect" autocomplete="off">
                <el-select  v-model="statusSelect"
                            filterable
                            remote
                            clearable 
                            reserve-keyword
                            style="width: 100%;"
                            placeholder="สถานะ">
                    <el-option  v-for="option in options"
                                :key="option.value"
                                :label="option.label"
                                :value="option.value">
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="row" style="padding-top: 15px;">
            <div class="col-sm-3" style="text-align:left;">
                <label class="control-label">
                        ระบุรหัสหน่วยงาน
                </label>
                <input type="hidden" name="search[department_code]" v-model="departmentSelect" autocomplete="off">
                <el-select  v-model="departmentSelect"
                            filterable
                            remote
                            clearable 
                            reserve-keyword
                            style="width: 100%;"
                            placeholder="ระบุรหัสหน่วยงาน">
                    <el-option  v-for="department in departments"
                                :key="department.department_code"
                                :label="department.meaning + ' : ' + department.description"
                                :value="department.department_code">
                    </el-option>
                </el-select>
            </div>
            <div class="col-sm-3" style="text-align:left;">
                <label class="control-label">
                        ระบุรหัสคลังสินค้า
                </label>
                <input type="hidden" name="search[subinventory_code]" v-model="subinventorySelect" autocomplete="off">
                <el-select  v-model="subinventorySelect"
                            filterable
                            remote
                            clearable 
                            reserve-keyword
                            style="width: 100%;"
                            placeholder="ระบุรหัสคลังสินค้า">
                    <el-option  v-for="(subInventory, index) in subInventories"
                                :key="index"
                                :label="subInventory.subinventory_code + ' : ' + subInventory.subinventory_desc"
                                :value="subInventory.subinventory_code + ',' + subInventory.subinventory_desc">
                    </el-option>
                </el-select>
            </div>
            <div class="col-sm-3" style="text-align:left;">
                <label class="control-label">
                        ระบุกลุ่มสินค้าย่อย
                </label>
                <input type="hidden" name="search[sub_group_code]" v-model="subGroupSelect" autocomplete="off">
                <el-select  v-model="subGroupSelect"
                            filterable
                            remote
                            clearable 
                            reserve-keyword
                            style="width: 100%;"
                            :disabled="!getSubGroupOrderBy.length"
                            placeholder="ระบุกลุ่มสินค้าย่อย">
                    <el-option  v-for="(subGroup, index) in getSubGroupOrderBy"
                                :key="index"
                                :label="subGroup.sub_group_code + ' : ' + subGroup.sub_group_description"
                                :value="subGroup.sub_group_code + ' : ' + subGroup.sub_group_description">
                    </el-option>
                </el-select>
            </div>            
        </div>
    </div>
</template>

<script>
export default {
    props: ["policySetHeaders", "assetGroups", "departments", "subInventories", "subGroups", "groupProducts" , 'search'],
    data() {
        return {
            options: [{
                value: 'Y',
                label: 'Active'
            },{
                value: 'N',
                label: 'Inactive'
            }],

            subGroupLists : [],

            policySelect: this.search ? isNaN(parseInt(this.search.policy_set_header_id)) ? '' : this.search.policy_set_header_id : '', 
            assetGroupSelect: this.search ? this.search.asset_group : '',
            statusSelect: this.search ? this.search.status : '',
            departmentSelect: this.search ? this.search.department_code : '',
            subGroupSelect: this.search ? this.search.sub_group_code : '',
            groupProductsSelect: this.search ? isNaN(parseInt(this.search.group_products)) ? '' : parseInt(this.search.group_products) : '',
            subinventorySelect: this.search ? this.search.subinventory_code : '',
        };
    },
    mounted() {
        this.getSubGroup();
    },
    computed:{
        getSubGroupOrderBy: function(){
            return _.orderBy(this.subGroupLists, 'sub_group_code')
        }
    },
    methods: {
        getSubGroup(){
             
            this.subGroupLists = this.subGroups.filter(subGroups =>{
                return subGroups.policy_set_header_id == this.policySelect;
            });
        }
    }
};
</script>