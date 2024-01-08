<template>
    <div class="container" v-loading="loading">
        <button 
            data-toggle="modal" 
            :data-target="`#modalCancel`+webFuelOil.transaction_id"
            v-if="cancelled == false" 
            type="submit" 
            class="btn btn-sm btn-danger" 
            >
                <i class="fa fa-times"></i> ยกเลิก
        </button>

        <button 
            v-if="cancelled == true" 
            type="submit" 
            class="btn btn-sm btn-dark" 
            disabled
            >
                <i class="fa fa-times"></i> ยกเลิก
        </button>

        <div class="modal fade" :id="`modalCancel`+webFuelOil.transaction_id" tabindex="-1" role="dialog" aria-labelledby="modalCancelLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCancelLabel">Return Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label required">วันที่ยกเลิก</label>
                            <div class="col-md-6">
                                <datepicker-th
                                    :value="form.return_date"
                                    type="date"
                                    style="width: 100%"
                                    class="form-control md:tw-mb-0 tw-mb-2"
                                    placeholder="โปรดเลือกวันที่"
                                    format="DD/MM/YYYY"
                                    @dateWasSelected="(date)=>form.return_date = date" />
                            </div>
                        </div>
                        <div class="form-group mb-0">
                            <h4>กรุณาระบุสาเหตุการยกเลิกรายการเบิกจ่ายน้ำมัน</h4>
                            <div class="form-group row mt-3 mb-0">
                                <label class="col-md-4 col-form-label tw-text-xs required">รายละเอียดการยกเลิก</label>
                                <div class="col-md-8">
                                    <el-input
                                        v-model="form.reason_name"
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
                    <button type="button" class="btn btn-primary" data-dismiss="modal" @click="cancel">บันทึก</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    body.modal-open {
        overflow: scroll !important;
    }
    .modal-backdrop {
        z-index: 999 !important;
    }
    .modal {
        z-index: 1000 !important;
    }
    
</style>

<script>
import moment from 'moment'
import DatepickerTh from '../../DatepickerTh.vue';

export default {
  components: { DatepickerTh },

    props: ["webFuelOil", "cancelled"],
    data() {
        return {
            loading: false,

            form: {
                return_date: "",
                reason_name: "",
            },
        }
    },
    mounted() {
        this.showDate(moment(this.webFuelOil.gl_date), 'DD/MM/YYYY');
    },
    methods: {
        async showDate(date) {
            var dateTh = await helperDate.parseToDateTh(date, 'DD/MM/YYYY');
            this.form.return_date = dateTh;
        },
        cancel() {
            if (confirm('ยืนยันการลบรายการเบิกจ่ายน้ำมัน?')) {
                this.loading = true;
                this.form.return_date = moment(this.form.return_date).subtract(543, 'years').format("DD/MM/YYYY");
                axios
                    .post(
                        `/inv/disbursement_fuel/${this.webFuelOil.transaction_id}/cancel` , this.form
                    )
                    .then((res) => {
                        this.loading = true;
                            this.$notify({
                                title: 'Success',
                                message: 'Cancle Successfully',
                                type: 'success'
                            });
                        window.location.replace("/inv/disbursement_fuel/");
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

                        window.location.reload();
                    });
            }
        }
    },
    
}
</script>