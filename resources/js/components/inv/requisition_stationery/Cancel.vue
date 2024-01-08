<template>
    <div>
        <div class="col-md-12 text-right mt-2 p-0" v-loading="loading">
            <el-button
                class="btn-danger"
                size="small"
                type="danger"
                @click="cancel"
                >Cancel
            </el-button>
        </div>
    </div>
</template>

<script>
export default {
    props: ["defaultIssueHeader"],
    data() {
        return {
            loading: false,
        }
    },
    created: function() {

    },
    methods: {
        cancel() {
            if (confirm("ยืนยันการยกเลิกรายการเบิกจ่ายเครื่องเขียน ?")) {
                axios
                    .patch(
                        `/inv/requisition_stationery/${this.defaultIssueHeader.issue_header_id}/cancel`
                    )
                    .then((res) => {
                        this.loading = true;
                            this.$notify({
                                title: 'Success',
                                message: 'Cancle Successfully',
                                type: 'success'
                            });
                        window.location.replace("/inv/requisition_stationery/");
                    })
                    .catch((err) => {
                        this.loading = false;
                        let errorMessage = this.$formatErrorMessage(error);
                        alert(errorMessage);
                    });
            }
        }
    }
}
</script>