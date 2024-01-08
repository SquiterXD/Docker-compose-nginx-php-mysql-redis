<template>
    <div>
        <el-checkbox    v-model="active_flag"
                        :checked="active_flag"
                        @change="changeActive(active_flag)">
        </el-checkbox>
    </div>
</template>
<script>
export default {
    props: ['activeFlag', 'accountId'],

    data() {
        return {
            active_flag: this.activeFlag == 'Y' ? true : false,
        }
    },
     methods: {
            async changeActive(flag){
                // console.log('active_flag <---> ', this.active_flag);
                // console.log('flag <---> ', flag);
                var params = {
                    account_id: this.accountId,
                    active_flag: flag ? 'Y' : 'N' || flag ? 'N' : 'Y'
                };
                return await axios
                    .get('/ir/ajax/account-mapping-update-flag',{ params })
                    .then(res => {
                        if(res.data.status == 'success'){
                            swal({
                                title: "Success !",
                                text: "บันทึกสำเร็จ",
                                type: "success",
                                showConfirmButton: true
                            });
                        }
                        else{
                            swal({
                                title: "Error !",
                                text: "ทำรายการไม่สำเร็จ",
                                type: "error",
                                showConfirmButton: true
                            });
                            this.active_flag = true;
                        }
                    });
            }
        },
}
</script>