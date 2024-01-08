<template>
    <div class="row">
        <div class="col text-left">
            <label> กรมธรรม์ชุดที่ (Policy No.) </label>
            <input type="hidden" name="search[policy_set_header_id]" v-model="policySelected">
            <el-select v-model="policySelected" clearable filterable 
                    placeholder="เลือกกลุ่มกรมธรรม์" 
                    class="w-100">
                <el-option
                    v-for   ="policySetHeader in policySetHeaders"
                    :key    ="policySetHeader.policy_set_header_id"
                    :label  ="policySetHeader.policy_set_number + ' : ' + policySetHeader.policy_set_description"
                    :value  ="policySetHeader.policy_set_header_id">
                </el-option>
            </el-select>
        </div>
    </div>
</template>

<script>
    export default {
        props: ["policySetHeaders", 'search'],
        data() {
            return{
                policySelected: this.search? Number(this.search.policy_set_header_id): '',
            };
        }
    };
</script>