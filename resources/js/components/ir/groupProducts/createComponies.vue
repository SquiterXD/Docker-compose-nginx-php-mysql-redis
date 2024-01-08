<template>
    <div>
        <div class="row col-lg-10 col-md-6 align-items-center justify-content-center my-3" style="margin-left: 80px; margin-right: 80px;">
        <label class="col-lg-3 col-md-6 col-form-label text-right">
        <strong> กรมธรรม์ชุดที่ (Policy No.) </strong> <span class="text-danger">*</span>
        </label>
            <div class='col-lg-7 col-md-7 w-100'>
                <input type="hidden" name="policy_set_header_id" v-model="policySelected">
                <el-select  v-model="policySelected" clearable filterable 
                            placeholder="โปรดเลือกกรมธรรม์" 
                            class="w-100">
                    <el-option
                        v-for="policySetHeader in policySetHeaders"
                        :key="policySetHeader.policy_set_header_id"
                        :label="policySetHeader.policy_set_number + ' : ' + policySetHeader.policy_set_description"
                        :value="policySetHeader.policy_set_header_id">
                    </el-option>
                </el-select>
            </div>
        </div>

        <div class="row col-lg-10 col-md-6 align-items-center justify-content-center my-3" style="margin-left: 80px; margin-right: 80px;">
        <label class="col-lg-3 col-md-6 col-form-label text-right">
        <strong> กลุ่มของทรัพย์สิน </strong> <span class="text-danger">*</span>
        </label>
            <div class='col-lg-7 col-md-7 w-100'>
                <input type="hidden" name="asset_group_code" v-model="assetGroupsSelected">
                <el-select  v-model="assetGroupsSelected" clearable filterable 
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
        <strong> รายการ </strong><span class="text-danger">*</span>
        </label>
            <div class='col-lg-7 col-md-7 w-100'>
                <el-input placeholder="โปรดกรอกรายการ" v-model="description" name="description"></el-input>
            </div>
        </div>

        <div class="row col-lg-10 col-md-6 align-items-center justify-content-center my-3" style="margin-left: 80px; margin-right: 80px;">
        <label class="col-lg-3 col-md-6 col-form-label text-right">
        <strong> ประเภทค่าใช้จ่าย </strong> <span class="text-danger">*</span>
        </label>
            <div class='col-lg-7 col-md-7 w-100'>
                <input type="hidden" name="account_id" v-model="accountSelected">
                <el-select  v-model="accountSelected" clearable filterable 
                            placeholder="โปรดเลือก"
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

        <div class="row col-lg-10 col-md-6 align-items-center justify-content-center my-3" style="margin-left: 80px; margin-right: 80px;">
        <label class="col-lg-3 col-md-6 col-form-label text-right">
        <strong> รหัสบัญชี </strong>
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
                <input type="hidden" name="active_flag" :value="activeFlag">
                <el-checkbox v-model="activeFlag" size="medium" class="w-100"></el-checkbox>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
    props: ["policySetHeaders", "accountsMappings", "assetGroups", 'oldInput'],
    data() {
        return{
           policySelected           :   this.oldInput.length != 0 ? parseInt(this.oldInput.policy_set_header_id) : '',
           assetGroupsSelected      :   this.oldInput.length != 0 ? this.oldInput.asset_group_code : '',
           activeFlag               :   true,
           accountSelected          :   this.oldInput.length != 0 
                                        ? isNaN(parseInt(this.oldInput.account_id)) 
                                        ? ''
                                        : parseInt(this.oldInput.account_id) 
                                        : '',
           description              :   this.oldInput.length != 0 ? this.oldInput.description : '',
           accountCombine           :   '',
        };
    },
    computed: {

    },
    mounted() {
        if(this.oldInput.length != 0){
            this.getAccountCombine();
        } 
    },
    methods: {
        getAccountCombine(){
            var accounts = this.accountsMappings.find(item => {
                return this.accountSelected == item.account_id
            });
            this.accountCombine = accounts.account_combine;
        }

    },
    };
</script>
