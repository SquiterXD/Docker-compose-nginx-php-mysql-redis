<template>
    <div>
        <!-- <el-checkbox    v-model="active_flag"
                        :checked="active_flag == 'Y' ? true : false"
                        @change="changeActive(active_flag)">
        </el-checkbox> -->
        <input type="checkbox" name="active_flag" v-model="active_flag" @change="changeActive()">
    </div>
</template>
<script>
export default {
    props: ['activeFlag', 'emailId'],

    data() {
        return {
            active_flag: this.activeFlag == 'Y' ? true : false,
            old_flag: this.activeFlag,
        }
    },
    methods: {
            async changeActive(){
                 
                
                var active = this.active_flag ? 'Y' : 'N' || this.active_flag ? 'N' : 'Y';

                 
                
                var params = {
                    email_id: this.emailId,
                    active_flag: active
                };
                return await axios
                    .get('/ir/ajax/email-update-flag',{ params })
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
                            this.active_flag = this.old_flag == 'Y' ? true : false;
                        }
                    });
            }
        },
}
</script>