<template>
    <div>
        <div class="row">
            <div class="col-md-5">
                <label> Code <span class="text-danger">*</span></label>
                <el-input type="text" name="account_code" v-model="account_code" autocomplete="off" size="small" :disabled="disableEdit"></el-input>
            </div>
            <div class="col-md-5">
                <label> Description <span class="text-danger">*</span></label>
                <el-input type="text" name="description" v-model="description" autocomplete="off" size="small"></el-input>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-5">
                <label> รหัสบัญชี (Account Code) <span class="text-danger">*</span></label>
                <el-input type="text" name="account_combine" v-model="account_combine" autocomplete="off" size="small" :disabled="disableEdit"></el-input>
            </div>
            <div class="col-md-5">
                <label> Active </label>
                <div>
                    <input type="checkbox" class="i-checks" name="active_flag" checked>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props:['defaultValue'],
    data() {
        return { 
            account_code: this.defaultValue ? this.defaultValue.account_code : '',
            description:  this.defaultValue ? this.defaultValue.description  : '',
            segment1:     this.defaultValue ? this.defaultValue.segment_1     : '',
            segment2:     this.defaultValue ? this.defaultValue.segment_2     : '',
            segment3:     this.defaultValue ? this.defaultValue.segment_3     : '',
            segment4:     this.defaultValue ? this.defaultValue.segment_4     : '',
            segment5:     this.defaultValue ? this.defaultValue.segment_5     : '',
            segment6:     this.defaultValue ? this.defaultValue.segment_6     : '',
            segment7:     this.defaultValue ? this.defaultValue.segment_7     : '',
            segment8:     this.defaultValue ? this.defaultValue.segment_8     : '',
            segment9:     this.defaultValue ? this.defaultValue.segment_9     : '',
            segment10:    this.defaultValue ? this.defaultValue.segment_10    : '',
            segment11:    this.defaultValue ? this.defaultValue.segment_11    : '',
            segment12:    this.defaultValue ? this.defaultValue.segment_12    : '',
            account_combine:    this.defaultValue ? this.defaultValue.account_combine    : '',
            disableEdit: this.defaultValue ? true : false,
            active_flag: this.defaultValue ? this.defaultValue.active_flag == 'Y' ? true : false : true,
        }
    },
}
</script>
