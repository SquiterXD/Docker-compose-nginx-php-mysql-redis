<template>
    <div class="row">
        <div class="col-sm-4" style="text-align:left;">
            <label>
                กรมธรรม์
            </label>
            <input type="hidden" name="policy_set_header_id" :value="policy_set_header_id">
            <el-select class="required" v-model="policy_set_header_id" placeholder="กรมธรรม์" size="medium" style="width: 100%;"  
                    filterable
                    remote
                    reserve-keyword
                    clearable
                    >
                <el-option
                    v-for="(policy, index) in policyLists"
                    :key="index"
                    :label="policy.policy_set_number + ' : ' + policy.policy_set_description"
                    :value="policy.policy_set_header_id">
                </el-option>
            </el-select>
        </div>
        <div class="col-sm-4" style="text-align:left;">
            <label>
                รหัสทรัพย์สิน
            </label>
            <input type="hidden" name="asset_id" :value="asset_id">
            <el-select class="required" v-model="asset_id" placeholder="รหัสทรัพย์สิน" size="medium" style="width: 100%;"  
                    filterable
                    remote
                    reserve-keyword
                    clearable
                    >
                <el-option
                    v-for="(asset, index) in assetLists"
                    :key="index"
                    :label="asset.asset_number + ' : ' + asset.description"
                    :value="asset.asset_id">
                </el-option>
            </el-select>
        </div>
        <div class="col-sm-2">
            <label class=" tw-font-bold tw-uppercase mb-0" >&nbsp;</label>
            <div class="text-right">
                <button type="submit" class="btn btn-light btn-sm">
                    <i class="fa fa-search" aria-hidden="true"></i> ค้นหา
                </button>
                <a :href="this.actionUrl" class="btn btn-warning btn-sm"><i class="fa fa-undo"></i> รีเซต</a>
            </div>
        </div>
    </div>

</template>
<script>
export default {
    props: ['policyLists', 'assetLists', 'dataSearch', 'actionUrl'],
    data() {
        return {
            policy_set_header_id: this.dataSearch ? this.dataSearch.policy_set_header_id ? Number(this.dataSearch.policy_set_header_id) : '' : '',
            asset_id:             this.dataSearch ? this.dataSearch.asset_id             ? Number(this.dataSearch.asset_id)             : '' : '',
        }
    },
}
</script>