<template>
    <div>
        <el-form :model="form" ref="save_data" label-width="120px" class="demo-dynamic form_table_line">
            <button type="button" @click="openModalCreate()" :class="btnTrans.create.class + ' btn-md tw-w-25'">
                <i :class="btnTrans.create.icon"></i> {{ btnTrans.create.text }}
            </button>

            <div class="row">
                <div class="modal fade" id="modal-create" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog modal-lg" style="width: 90%; max-width:950px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title m-0"> สร้างต้นทุนขายแยกแสตมป์และกองทุน </h2>
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                                </button>
                            </div>
                            <div class="modal-body mt-3" v-loading="isLoading">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label class="col-md-5 col-form-label tw-font-bold tw-pt-0 required mt-2 text-right"> ปีบัญชี </label>
                                            <div class="col-md-6">
                                                <el-form-item :prop="'period_year'" :rules="rules.period_year">
                                                    <el-select v-model="form.period_year"
                                                                placeholder="ปีบัญชี"
                                                                clearable
                                                                filterable
                                                                remote
                                                                @change="getMonth">
                                                        <el-option
                                                        v-for="(data, index) in periodYears"
                                                            :key="index"
                                                            :label="data.period_year_thai"
                                                            :value="data.period_year"
                                                        >
                                                        </el-option>
                                                    </el-select>
                                                </el-form-item>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <label class="col-md-3 col-form-label tw-font-bold tw-pt-0 required mt-2 text-right"> งวดบัญชี </label>
                                            <div class="col-md-6">
                                                <el-form-item :prop="'period_no'" :rules="rules.period_no">
                                                    <el-select v-model="form.period_no"
                                                                placeholder="งวดบัญชี"
                                                                clearable
                                                                filterable
                                                                remote
                                                                :disabled="monthList < 1">
                                                        <el-option
                                                        v-for="(data, index) in monthList"
                                                            :key="index"
                                                            :label="data.month_thai"
                                                            :value="data.period_no"
                                                        >
                                                        </el-option>
                                                    </el-select>
                                                </el-form-item>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" @click.prevent="clickSave()" :class="btnTrans.create.class + ' btn-md tw-w-25'" >
                                    <i :class="btnTrans.create.icon"></i>
                                    {{ btnTrans.create.text }}
                                </button>
                                <button type="button" :class="btnTrans.cancel.class + ' btn-md tw-w-25'" @click="closeModalCreate()">
                                    <i :class="btnTrans.cancel.icon"></i> {{ btnTrans.cancel.text }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </el-form>
    </div>
</template>
<script>
export default {
    props:[ "btnTrans", "periodYears" ],
    data() {
        return {
            monthList: [],
            isLoading: false,
            form:{
                period_year: '',
                period_no: '',
            },
            rules: {
                period_year: [
                    { required: true, message: 'กรุณาเลือก ปีบัญชี', trigger: "change"}
                ],
                period_no: [
                    { required: true, message: 'กรุณาเลือก งวดบัญชี', trigger: "change"}
                ],
            }
        }
    },
    methods: {
        openModalCreate(){
            $('#modal-create').modal('show');
        },
        closeModalCreate(type) {
            $('#modal-create').modal('hide');
        },
        clickSave(){
            console.log('save');
            let vm = this;
            vm.isLoading = true;
            this.$refs.save_data.validate((valid) => {
                if (valid) {
                    let params = {
                        form: vm.form,
                    };
                    axios.post("/ct/ajax/stamp-adjust/store-process", params)
                    .then(res => {
                        if (res.data.status == 'S') {
                            swal({
                                title: 'สร้างต้นทุนขายแยกแสตมป์และกองทุน',
                                text: '<span style="font-size: 16px; text-align: left;"> ทำการสร้างข้อมูลต้นทุนขายแยกแสตมป์และกองทุนเรียบร้อยแล้ว </span>',
                                type: "success",
                                html: true
                            },
                            function(isConfirm) {
                                if (isConfirm) {
                                    vm.setUrlParams();
                                } 
                            });
                        } else {
                            swal({
                                title: 'สร้างต้นทุนขายแยกแสตมป์และกองทุน',
                                text: '<span style="font-size: 16px; text-align: left;">'+res.data.msg+'</span>',
                                type: "warning",
                                html: true
                            });
                        }
                    })
                    .catch(err => {
                        swal({
                            title: 'สร้างต้นทุนขายแยกแสตมป์และกองทุน',
                            text: '<span style="font-size: 16px; text-align: left;"> ไม่สามารถสร้างข้อมูลต้นทุนขายแยกแสตมป์และกองทุนได้ </span>',
                            type: "warning",
                            html: true
                        });
                    })
                    .then(() => {
                        vm.isLoading = false;
                    });
                }
            });
        },
        getMonth(query) {
            this.monthList = [];
            this.isLoading = true;
            axios.get("/ct/ajax/stamp_adj/get-list-month", {
                params: {
                    period_year: this.form.period_year,
                }
            }).then(res => {
                this.monthList = res.data;
                this.isLoading = false;
            });
        },
        setUrlParams() {
            var period = this.monthList.find(item => item.period_no == this.form.period_no);
            var queryParams = new URLSearchParams(window.location.search);
                queryParams.set("period_year", this.form.period_year);
                queryParams.set("period_name", period.period_name);

            window.history.replaceState(null, null, "?"+queryParams.toString());
            this.closeModalCreate();
            location.reload();
        }
    }
}
</script>
<style scope>
    .el-select-dropdown{
        z-index: 9999 !important;
    }

    .sticky-col {
        position: sticky;
        background-color: #dcdfdb;
        z-index: 9999;
        top: 0;
    }

    .error-message {
        display: flex;
        color: #ec4958;
        margin-top: 5px;

        strong {
            margin-right: 5px;
        }
    }

    .el-date-picker {
        z-index: 9999 !important;
    }
</style>
<style>
  .el-form-item__content{
    line-height: 40px;
    position: relative;
    font-size: 14px;
    margin-left: 0px !important;
  }
  .el-form-item__error {
    color: #F56C6C;
    font-size: 12px;
    line-height: 1;
    padding-top: 4px;
    position: relative;
    top: 100%;
    left: 0;
  }
</style>