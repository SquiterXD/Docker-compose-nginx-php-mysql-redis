<template>
    <!-- <div class="container"> -->
        <div class="row">
            <div class="col-3 text-left">
                <label>ระบุชุดกรมธรรม์</label>
                    <input type="hidden" name="search[policy]" v-model="policySearchSelected">
                    <el-select  v-model="policySearchSelected" clearable filterable 
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
            <div class="col-3 text-left">
                <label>ระบุกลุ่มของทรัพย์สิน</label>
                    <input type="hidden" name="search[assetGroup]" v-model="assetSearchSelected">
                    <el-select  v-model="assetSearchSelected" clearable filterable 
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
            <div class="col-3 text-left">
                <label>ระบุรายการ</label>
                    <input type="hidden" name="search[description]" v-model="descriptionSelected">
                    <el-select  v-model="descriptionSelected" clearable filterable 
                                    placeholder="โปรดเลือกการระบุรายการ" 
                                    class="w-100">
                            <el-option
                                v-for="(descFieldSearch, index) in descFieldSearches"
                                :key="index"
                                :label="index"
                                :value="index">
                            </el-option>
                    </el-select>
            </div>
            <div class="col-3 text-left">
                <label>สถานะ</label>
                    <input type="hidden" name="search[status]" v-model="statusSelected">
                    <el-select  v-model="statusSelected" clearable filterable 
                                    placeholder="โปรดเลือกสถานะ" 
                                    class="w-100">
                            <el-option
                                v-for="option in options"
                                :key="option.value"
                                :label="option.label"
                                :value="option.value">
                            </el-option>
                    </el-select>
            </div>
        </div>
    <!-- </div> -->
</template>

<script>
    export default {
    props: ['policySetHeaders', 'assetGroups', 'search', 'groupProducts', 'descFieldSearches'],
    data() {
        return{
            policySearchSelected: this.search ? isNaN(parseInt(this.search.policy)) ? '' : this.search.policy : '',
            assetSearchSelected: this.search ? this.search.assetGroup : '',
            descriptionSelected: this.search  ? this.search.description : '',
            statusSelected: this.search ? this.search.status : '',
            
            options: [{
                value: 'Y',
                label: 'Active'
            },{
                value: 'N',
                label: 'Inactive'
            }],


        };
    },
    mounted() {
    //     
    },
    methods: {

    },
    };
</script>
