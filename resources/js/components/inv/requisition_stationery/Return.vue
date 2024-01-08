<template>
    <div v-if="defaultIssueHeader.issue_status == 'APPROVED' && allowed_status == 'Y'">
        <div class="col-md-12 text-right mt-2 p-0" v-loading="loading">
            <button class="btn btn-danger" data-toggle="modal" data-target="#returnRequest">
                Return
            </button>
        </div>

        <div class="modal fade" id="returnRequest" tabindex="-1" role="dialog" aria-labelledby="returnRequestLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title" id="returnRequestLabel">
                            <h3>Return Request</h3>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body text-left">
                        <form>
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label required">วันที่ยกเลิก</label>
                                <div class="col-md-4">
                                    <el-date-picker
                                        v-model="return_date"
                                        type="date"
                                        format="dd/MM/yyyy"
                                        size="small"
                                        placeholder="Pick a day"
                                    >
                                    </el-date-picker>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <h4>กรุณาระบุสาเหตุการยกเลิกรายการเบิกจ่ายเครื่องเขียน</h4>
                                <div class="form-group row mt-3 mb-0">
                                    <label class="col-md-4 col-form-label tw-text-xs required">รายละเอียดการยกเลิก</label>
                                    <div class="col-md-8">
                                        <el-input
                                            v-model="reason"
                                            :autosize="{ minRows: 3, maxRows: 3 }"
                                            type="textarea">
                                        </el-input>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        <button type="button" class="btn btn-primary" @click="returnIssue()" data-dismiss="modal">ตกลง</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["defaultIssueHeader", "lookupValues", "user"],

    data() {
        return {
            reason: "",
            allowed_status: 'N',

            username: this.user?.username || "",
            return_date: this.defaultIssueHeader?.gl_date || "",

            loading: false,
        }
    },

    created: function() {

    },

    mounted() {
        let allowedUser = this.lookupValues.find((user) => {
            return user.meaning == this.username
        })
        if (allowedUser) {
            this.allowed_status = 'Y'
        }
    },

    methods: {
        returnIssue() {
            this.loading = true;
            axios
            .post("/inv/issue_return", {
                reason: this.reason,
                issue_header_id: this.defaultIssueHeader.issue_header_id,
                gl_date: this.return_date,
            })
            .then((res) => {
                this.loading = false;
                this.$notify({
                    title: 'Success',
                    message: 'Return Successfully',
                    type: 'success'
                });
                window.location.replace("/inv/requisition_stationery/")
            })
            .catch((err) => {
                this.loading = false;
                if (err.response.status == 403) {
                    this.$notify.error({
                        title: 'Error',
                        message: err.response.data.msg,
                        duration: 4500,
                    });
                }
                let errorMessage = this.$formatErrorMessage(err);
                var items = errorMessage.getElementsByTagName("li");
                for(var i = 0, size = items.length; i< size; i++){
                    this.$notify.error({
                    title: 'Error',
                    message: items[i].innerHTML,
                    duration: 4500,
                    });
                }
            })
        }
    }
   
    
}
</script>