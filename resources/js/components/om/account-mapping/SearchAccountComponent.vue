<template>
    <div class="row">
        <div class="col-sm-4" style="text-align:left;">
            <label>
                Account
            </label>
            <input type="hidden" name="account" :value="account">
            <el-select class="required" v-model="account" placeholder="Account" size="small" style="width: 100%;">
                <el-option
                    v-for="account in accounts"
                    :key="account.account_code"
                    :label="account.account_code +' : '+ account.description"
                    :value="account.account_code">
                </el-option>
            </el-select>
        </div>
        <div class="col-sm-4" style="text-align:left;">
            <label>
                Status
            </label>
            <input type="hidden" name="status" :value="status">
            <el-select class="required" v-model="status" placeholder="status" size="small" style="width: 100%;">
                <el-option
                    v-for="option in statusOptions"
                    :key="option.value"
                    :label="option.label"
                    :value="option.value">
                </el-option>
            </el-select>
        </div>
        <div class="col-sm-2">
            <label class=" tw-font-bold tw-uppercase mb-0" >&nbsp;</label>
            <div class="text-right">
                <button type="submit" class="btn btn-light btn-sm">
                    <i class="fa fa-search" aria-hidden="true"></i> ค้นหา
                </button>
                <a :href="this.actionUrl" class="btn btn-danger btn-sm">ล้าง</a>
            </div>
        </div>
    </div>

</template>
<script>
    export default {
        props: ['accounts', 'actionUrl'],
        data() {
            return {
                account: '',
                status:  '',
                statusOptions: [{
                    value: 'Y',
                    label: 'Active'
                }, {
                    value: 'N',
                    label: 'Inactive'
                    }
                ],
            }
        },
    }
</script>
