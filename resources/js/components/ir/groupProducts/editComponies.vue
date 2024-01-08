<template>
    <div>

        <input type="hidden" name="group_product_id" v-model="groupProductEdit">

        <div class="row col-lg-10 col-md-6 align-items-center justify-content-center my-3" style="margin-left: 80px; margin-right: 80px;">
        <label class="col-lg-3 col-md-6 col-form-label text-right">
        <strong> กรมธรรม์ชุดที่ (Policy No.) </strong> <span class="text-danger">*</span>
        </label>
            <div class='col-lg-7 col-md-7 w-100'>
                <input type="hidden" name="policy_set_header_id" v-model="policySetHeaderEditSelected">
                <el-select  v-model="policySetHeaderEditSelected" clearable filterable 
                            placeholder="โปรดเลือกกลุ่มของทรัพย์สิน" 
                            class="w-100"
                            :disabled="true">
                    <el-option
                        v-for="policy in policySetHeaders"
                        :key="policy.policy_set_header_id"
                        :label="policy.policy_set_number + ' : ' + policy.policy_set_description"
                        :value="policy.policy_set_header_id">
                    </el-option>
                </el-select>
            </div>
        </div>

        <div class="row col-lg-10 col-md-6 align-items-center justify-content-center my-3" style="margin-left: 80px; margin-right: 80px;">
        <label class="col-lg-3 col-md-6 col-form-label text-right">
        <strong> กลุ่มของทรัพย์สิน </strong> <span class="text-danger">*</span>
        </label>
        <div class='col-lg-7 col-md-7 w-100'>
            <input type="hidden" name="asset_group_code" v-model="assetGroupsEditSelected">
            <el-select  v-model="assetGroupsEditSelected" clearable filterable 
                        placeholder="โปรดเลือกกลุ่มของทรัพย์สิน" 
                        class="w-100">
                <el-option
                    v-for="assetGroup in assetGroups"
                    :key="assetGroup.value"
                    :label="assetGroup.meaning + ' : ' + assetGroup.description"
                    :value="assetGroup.value">
                </el-option>
            </el-select>
        </div>
        </div>

        <div class="row col-lg-10 col-md-6 align-items-center justify-content-center my-3" style="margin-left: 80px; margin-right: 80px;">
            <label class="col-lg-3 col-md-6 col-form-label text-right">
            <strong> รายการ </strong> <span class="text-danger">*</span>
            </label>
            <div class='col-lg-7 col-md-7 w-100'>
                <el-input placeholder="โปรดกรอกรายการ" v-model="descriptionEdit" name="description"></el-input> 
            </div>
        </div>

        <div class="row col-lg-10 col-md-6 align-items-center justify-content-center my-3" style="margin-left: 80px; margin-right: 80px;">
            <label class="col-lg-3 col-md-6 col-form-label text-right">
            <strong> ประเภทค่าใช้จ่าย </strong> <span class="text-danger">*</span>
            </label>
            <div class='col-lg-7 col-md-7 w-100'>
                <input type="hidden" name="account_id" v-model="accountEditSelected">
                <el-select  v-model="accountEditSelected" clearable filterable 
                            placeholder="โปรดเลือกประเภทค่าใช้จ่าย"
                            class="w-100"
                            @change="getAccountCombine()">
                    <el-option
                        v-for="accountsMapping in accountsMappings"
                        :key="accountsMapping.account_id"
                        :label="accountsMapping.account_code + ' : ' + accountsMapping.description"
                        :value="accountsMapping.account_id">
                    </el-option>
                </el-select>
            </div>
        </div>

        <div class="row col-lg-10 col-md-6 align-items-center justify-content-center my-3" 
             style="margin-left: 80px; margin-right: 80px;">
            <label class="col-lg-3 col-md-6 col-form-label text-right">
            <strong> รหัสบัญชี </strong> <span class="text-danger">*</span>
            </label>
            <div class='col-lg-7 col-md-7 w-100'>
                <el-input   placeholder="รหัสบัญชี" 
                            v-model="accountCombine" 
                            class="w-100"
                            :disabled="true">
                </el-input>
            </div>
        </div>

        <div class="row col-lg-10 col-md-6 align-items-center justify-content-center my-3" style="margin-left: 80px; margin-right: 80px;">
        <label class="col-lg-3 col-md-6 col-form-label text-right">
        <strong> Active </strong> <span class="text-danger">*</span>
        </label>
            <div class='col-lg-7 col-md-7 w-100'>
                <input type="hidden" name="active_flag" :value="activeFlagEdit">
                <el-checkbox v-model="activeFlagEdit" size="medium" class="w-100"></el-checkbox>
            </div>
        </div>

        <!-- old_checker_value -->
        <input type="hidden" name="old_checker_policy_set_header_id" v-model="policySetHeaderChecker">
        <input type="hidden" name="old_checker_asset_group_code" v-model="assetGroupsChecker">
        <input type="hidden" name="old_checker_description" v-model="descriptionChecker">
        <input type="hidden" name="old_checker_account_id" v-model="accountChecker">
        <input type="hidden" name="old_checker_active_flag" v-model="activeFlagChecker">

    </div>
</template>
<script>
    export default {
    props: ["policySetHeaders", "accountsMappings", "assetGroups", "groupProducts", "oldInput"],
    data() {
        return{
            policySetHeaderEditSelected: this.groupProducts ? isNaN(parseInt(this.groupProducts.policy_set_header_id)) ? '' : parseInt(this.groupProducts.policy_set_header_id) : '',
            groupProductEdit: this.groupProducts ? this.groupProducts.group_product_id :'',
            assetGroupsEditSelected: this.groupProducts ? this.groupProducts.asset_group_code : '',
            descriptionEdit: this.groupProducts ? this.groupProducts.description : '',
            accountEditSelected: this.groupProducts ? parseInt(this.groupProducts.account_id) : '',
            accountCombine: this.groupProducts.mapping_acc ? this.groupProducts.mapping_acc.account_combine : '',
            activeFlagEdit: this.groupProducts ? this.groupProducts.active_flag === 'Y' ? true : false : '',

            policySetHeaderChecker: this.groupProducts ? isNaN(parseInt(this.groupProducts.policy_set_header_id)) ? '' : parseInt(this.groupProducts.policy_set_header_id) : '',
            assetGroupsChecker: this.groupProducts ? this.groupProducts.asset_group_code : '',
            descriptionChecker: this.groupProducts ? this.groupProducts.description : '',
            accountChecker: this.groupProducts ? parseInt(this.groupProducts.account_id) : '',
            activeFlagChecker: this.groupProducts ? this.groupProducts.active_flag === 'Y' ? true : false : '',
        };
    },
    computed: {
        
    },
    mounted() {
        // console.log(this.policySetHeaders)
    },
    methods: {
        getAccountCombine(){
            var accounts = this.accountsMappings.find(item => {
                return this.accountEditSelected == item.account_id
            });

            this.accountCombine = accounts.account_combine;
        },
    },
    };
</script>
