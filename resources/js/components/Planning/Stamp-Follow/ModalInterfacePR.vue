<template>
    <span>
        <button type="button" @click="openModal" :class="btnTrans.interface_pr.class + ' btn-lg tw-w-25'" >
            <i :class="btnTrans.interface_pr.icon"></i>
            {{ btnTrans.interface_pr.text }}
        </button>

        <div class="modal fade" id="modal_interface" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width:950px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 style="font-size:22px; font-weight:400;" class="modal-title text-left">
                            ส่งข้อมูลเข้า PR
                        </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body text-left" v-loading="loading">
                        <form id="interface-form">
                            <div class="row col-12 m-0">
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1"> วันที่ส่งข้อมูล :</label>
                                    <div class="input-group ">
                                        <el-input type="text" placeholder="วันที่ส่งข้อมูล" v-model="head.current_date_format" readonly></el-input>
                                    </div>
                                </div>

                                <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1"> วันที่ที่ต้องการจัดซื้อ :</label>
                                    <div class="input-group">
                                        <datepicker-th
                                            :style="'width: 100%; ' + (errors.need_by_date? 'border: 1px solid red;' : '')"
                                            class="form-control md:tw-mb-0 tw-mb-2"
                                            name="need_by_date"
                                            id="need_by_date"
                                            placeholder="โปรดเลือกวันที่"
                                            :value="needByDate"
                                            v-model="needByDate"
                                            format="DD-MMM-YYYY"
                                            @dateWasSelected="dateWasSelected"
                                        />
                                            <!-- :disabled-date-to="checkDate.curr_date" -->
                                    </div>
                                    <div id="el_explode_need_by_date" class="error_msg text-left"></div>
                                </div>
                            </div>
                            <div class="row col-12 m-0">
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1"> ผู้ตรวจสอบ :</label>
                                    <div class="input-group">
                                        <el-select style="'width: 100%;'" v-model="approver1" size="large" placeholder="ผู้ตรวจสอบ" clearable filterable :popper-append-to-body="false" ref="approver1">
                                            <el-option
                                                v-for="(user, index) in users"
                                                :key="user.username"
                                                :label="user.name"
                                                :value="user.username"
                                            >
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <div id="el_explode_approver1" class="error_msg text-left"></div>
                                </div>

                                <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-2 col-sm-6 col-xs-6 mt-2">
                                    <label class="text-left tw-font-bold tw-uppercase mb-1"> ผู้อนุมัติ :</label>
                                    <div class="input-group">
                                        <el-select style="'width: 100%;'" v-model="approver2" size="large" placeholder="ผู้อนุมัติ" clearable filterable :popper-append-to-body="false" ref="approver2">
                                            <el-option
                                                v-for="(user, index) in users"
                                                :key="user.username"
                                                :label="user.name"
                                                :value="user.username"
                                            >
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <div id="el_explode_approver2" class="error_msg text-left"></div>
                                </div>
                            </div>
                            <div v-if="html" class="form-group pl-2 pr-2 mb-0 col-lg-12 col-md-12 col-sm-6 col-xs-6 mt-2">
                                <hr>
                                <div class="table-responsive" v-html="html"></div>
                            </div>
                            <div class="form-group pl-2 pr-2 mb-0 col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label class=" tw-font-bold tw-uppercase mt-1">&nbsp;<br></label>
                                <div class="text-right">
                                    <button type="button"
                                        @click.prevent="submitPR()"
                                        :class="btnTrans.create.class + ' btn-md tw-w-25'"
                                        :disabled="!interfaceFlag"
                                    >
                                        <i :class="btnTrans.interface_pr.icon"></i> ส่งข้อมูล
                                    </button>
                                    <button type="button" class="btn btn-white btn-md tw-w-25" data-dismiss="modal"> ยกเลิก </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>
<script>
    import moment from "moment";
    export default {
        props:["btnTrans", "url", "header", "stampMain", "users"],
        data() {
            return {
                head: this.header,
                loading: false,
                needByDate: '',
                interfaceFlag: false,
                approver1: '',
                approver2: '',
                html: '',
                checkDate: {
                    curr_date: ''
                    , date_from: ''
                    , date_to: ''
                    , need_by_date: ''
                },
                errors:{
                    need_by_date: ''
                    , approver1: ''
                    , approver2: ''
                },
            }
        },
        watch:{
            errors: {
                handler(val){
                    val.approver1? this.setError('approver1') : this.resetError('approver1');
                    val.approver2? this.setError('approver2') : this.resetError('approver2');
                },
                deep: true,
            },
        },
        methods: {
            async openModal() {
                this.getDetail();
                this.approver1 = '';
                this.approver2 = '';
                this.html = '';
                $('#modal_interface').modal('show');
            },
            async getDetail() {
                let vm = this;
                vm.loading = true;
                vm.html
                await axios
                .get(vm.url.ajax_get_period)
                .then(res => {
                    let currDate = moment().format('YYYY-MM-DD');
                    let dateFrom = moment(res.data.period.start_date).format('YYYY-MM-DD');
                    let dateTo = moment(res.data.period.end_date).format('YYYY-MM-DD');
                    // values
                    vm.checkDate.date_from = dateFrom;
                    vm.checkDate.date_to = dateTo;
                    this.convertDate();
                })
                .catch(err => {
                    let msg = err;
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: msg.message,
                        type: "error",
                    });
                })
                .then(() => {
                    vm.loading = false;
                });
            },
            async convertDate(){
                let currDate = moment().format('YYYY-MM-DD');
                let currentDate = await helperDate.parseToDateTh(currDate, 'YYYY-MM-DD');
                this.needByDate = moment(currentDate).format('DD-MMM-YYYY');
                this.checkDate.curr_date = moment(currentDate).format('DD-MMM-YYYY');
                let need_by_date = moment(currentDate).format('YYYY-MM-DD');
                need_by_date = this.changeThToEn(need_by_date);
                this.checkDate.need_by_date = need_by_date;
            },
            dateWasSelected(date){
                let form = $('#form-interface');
                this.errors.need_by_date = false;
                $(form).find("div[id='el_explode_need_by_date']").html("");
                this.needByDate = date? moment(date).format('DD-MMM-YYYY'): '';

                let need_by_date = moment(date).format('YYYY-MM-DD');
                need_by_date = this.changeThToEn(need_by_date);
                this.checkDate.need_by_date = need_by_date;
                this.getSummaryPR();
            },
            changeThToEn(dateTh){
                // เปลี่ยน Format และ เปลี่ยน พศ -> คศ
                const vm = this;
                let date= moment(dateTh, 'YYYY-MM-DD');
                date.subtract(543, 'years');
                return date.format('YYYY-MM-DD');
            },
            errorRef(res){
                var vm = this;
                vm.errors.need_by_date = res.err.need_by_date;
            },
            async getSummaryPR(){
                let vm = this;
                vm.loading = true;
                await axios
                .post(vm.url.ajax_get_summary_interface_pr, {
                    needByDate: vm.checkDate.need_by_date,
                })
                .then(res => {
                    vm.html = res.data.html;
                    vm.interfaceFlag = res.data.interfaceFlag;
                })
                .catch(err => {
                    let msg = err;
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: msg.message,
                        type: "error",
                    });
                })
                .then(() => {
                    vm.loading = false;
                });
            },
            submitPR() {
                let vm = this;
                let form = $('#interface-form');
                var valid = true;
                var msg = '';
                vm.errors.approver1 = false;
                vm.errors.approver2 = false;
                $(form).find("div[id='el_explode_approver1']").html("");
                $(form).find("div[id='el_explode_approver2']").html("");
                // Validate input
                if (vm.approver1 == '') {
                    vm.errors.approver1 = true;
                    valid = false;
                    msg = "กรุณาระบุผู้ตรวจสอบ";
                    $(form).find("div[id='el_explode_approver1']").html(msg);
                }
                if (vm.approver2 == '') {
                    vm.errors.approver2 = true;
                    valid = false;
                    msg = "กรุณาระบุผู้อนุมัติ";
                    $(form).find("div[id='el_explode_approver2']").html(msg);
                }
                if (!valid) {
                    return;
                }

                swal({
                    html: true,
                    title: '<div class="mt-4">  ส่งข้อมูลแสตมป์เข้าระบบ PR </div>',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> ต้องการส่งข้อมูลแสตมป์เข้าระบบ PR ใช่หรือไม่ ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: vm.btnTrans.ok.text,
                    cancelButtonText: vm.btnTrans.cancel.text,
                    confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                    cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        vm.interface();
                    }
                    vm.loading = false;
                });
            },
            interface() {
                let vm = this;
                vm.loading = true;
                axios.post(vm.url.ajax_interface_pr, {
                    needByDate: vm.checkDate.need_by_date,
                    approver1: vm.approver1,
                    approver2: vm.approver2,
                })
                .then(res => {
                    if(res.data.status == 'S'){
                        vm.$emit("updateStampHeader", 
                            { header: res.data.header, interfaceTemps: res.data.interfaceTemps, poLists: res.data.poLists}
                        );
                        swal({
                            title: '<div class="mt-4">  ส่งข้อมูลแสตมป์เข้าระบบ PR </div>',
                            text: '<span style="font-size: 15px; text-align: left;">'+res.data.msg+'</span>',
                            type: "success",
                            html: true
                        });
                    }else{
                        swal({
                            title: 'มีข้อผิดพลาด',
                            text: '<span style="font-size: 15px; text-align: left;">'+res.data.msg+'</span>',
                            type: "warning",
                            html: true
                        });
                    }
                })
                .catch(err => {
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 15px; text-align: left;">'+res.data.msg+'</span>',
                        type: "warning",
                        html: true
                    });
                })
                .then(() => {
                    $('#modal_interface').modal('hide');
                    vm.loading = false;
                });
            },
            setError(ref_name){
                let ref = this.$refs[ref_name].$refs.reference 
                        ? this.$refs[ref_name].$refs.reference.$refs.input 
                        : (this.$refs[ref_name].$refs.textarea 
                            ? this.$refs[ref_name].$refs.textarea 
                            : (this.$refs[ref_name].$refs.input.$refs 
                                ? this.$refs[ref_name].$refs.input.$refs.input 
                                : this.$refs[ref_name].$refs.input ));
                ref.style = "border: 1px solid red;";
            },
            resetError(ref_name){
                let ref = this.$refs[ref_name].$refs.reference 
                        ? this.$refs[ref_name].$refs.reference.$refs.input 
                        : (this.$refs[ref_name].$refs.textarea 
                            ? this.$refs[ref_name].$refs.textarea
                            : (this.$refs[ref_name].$refs.input.$refs 
                                ? this.$refs[ref_name].$refs.input.$refs.input 
                                : this.$refs[ref_name].$refs.input ));
                ref.style = "";
            },
            errorRef(res){
                var vm = this;
                vm.errors.approver1 = res.err.approver1;
                vm.errors.approver2 = res.err.approver2;
            }
        }
    }
</script>