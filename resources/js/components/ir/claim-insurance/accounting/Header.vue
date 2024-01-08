<template>
    <div id="index">
        <form id="claim-heder-form" class="row col-lg-12" onkeydown="return event.key != 'Enter';">
            <div class="form-group pl-12 pr-2 mb-0 col-lg-3 col-md-3 col-sm-3 col-xs-3 mt-2">
                <div class="control-label mb-2"><strong> กลุ่มกรมธรรม์ <span class="text-danger"> * </span> </strong> </div>
                <div class="input-group">
                    <el-select v-model="policyList.policy_group"
                        placeholder="กลุ่มกรมธรรม์"
                        :loading="loading"
                        remote
                        clearable
                        filterable
                        @change="selPolicyGroup"
                        style="width: 100%"
                        size="small"
                        ref="policy_group"
                        :disabled="disableFlag || validPolicy">
                        <el-option v-for="(data, index) in policyGroups"
                                :key="index"
                                :label="data.group_code + ': ' + data.group_description"
                                :value="data.group_header_id">
                        </el-option>
                    </el-select>
                </div>
                <div :id="'el_explode_policy_group'+index" class="error_msg text-left"></div>
            </div>
            <div class="form-group pl-12 pr-2 mb-0 col-lg-3 col-md-3 col-sm-3 col-xs-3 mt-2">
                <div class="input-group">
                    <div class="control-label mb-2"><strong> ชุดกรมธรรม์ <span class="text-danger"> * </span> </strong> </div>
                    <el-select v-model="policyList.policy_set"
                        placeholder="ชุดกรมธรรม์"
                        :loading="loading"
                        remote
                        clearable
                        filterable
                        @change="selPolicySet()"
                        style="width: 100%"
                        size="small"
                        ref="policy_set"
                        :disabled="disableFlag || validPolicy">
                        <el-option v-for="(data, index) in policySetLists"
                                :key="index"
                                :label="data.policy_set_header_id + ': ' + data.policy_set_description"
                                :value="data.policy_set_header_id">
                        </el-option>
                    </el-select>
                </div>
                <div :id="'el_explode_policy_set'+index" class="error_msg text-left"></div>
            </div>
            <div class="form-group pl-12 pr-2 mb-0 col-lg-3 col-md-3 col-sm-3 col-xs-3 mt-2">
                <div class="input-group">
                    <div class="control-label mb-2"><strong> จำนวนเงินเรียกชดใช้ <span class="text-danger"> * </span> </strong> </div>
                    <vue-numeric :style="'width: 80%; ' + (errors.claim_amount? 'border: 1px solid red;' : '')"
                        name="claim_amount"
                        separator="," 
                        v-bind:precision="2" 
                        v-bind:minus="false"
                        :min="0"
                        :max="999999999"
                        class="form-control input-sm text-right"
                        v-model="policyList.claim_amount"
                        :disabled="disableFlag"
                        autocomplete="off"
                        v-on:keypress.native="validateInput()"
                    ></vue-numeric>
                </div>
                <div :id="'el_explode_claim_amount'+index" class="error_msg text-left"></div>
            </div>
            <div class="form-group pl-12 pr-2 mb-0 col-lg-3 col-md-3 col-sm-3 col-xs-3 mt-2">
                <div class="control-label mb-4"></div>
                <button class="btn btn-md btn-danger" @click.prevent="removeHeader(policyList)" :disabled="disableFlag">
                    <i class="fa fa-trash-o"></i> ลบรายการกลุ่มกรมธรรม์
                </button>
            </div>
            <!-- Line -->
            <template v-if="company.length">
                <table class="table table-bordered table-responsive-sm mt-3">
                    <thead>
                        <tr>
                            <th rowspan="3" width="5%" class="text-center" style="vertical-align: middle;"> ลำดับ </th>
                            <th rowspan="3" width="12%" class="text-center" style="vertical-align: middle;"> รายละเอียดความเสียหาย <span class="text-danger">*</span> </th>
                            <th rowspan="3" width="7%" class="text-center" style="vertical-align: middle;"> จำนวนเงิน <span class="text-danger">*</span> </th>
                            <th :colspan="company.length" width="15%" class="text-center" style="vertical-align: middle;"> บริษัทประกันภัย </th>
                            <th rowspan="3" width="3%" class="text-center" style="vertical-align: middle;"> Action </th>
                        </tr>
                        <tr>
                            <!-- <th colspan="3"> </th> -->
                            <template v-for="comp in company">
                                <th width="7%" class="text-center" style="font-size: 12px;"> {{ comp.company_name }} </th>
                            </template>
                        </tr>
                        <tr>
                            <!-- <th colspan="3"> </th> -->
                            <template v-for="comp in company">
                                <th width="7%" class="text-center" style="font-size: 12px;"> {{ comp.company_percent }}% </th>
                            </template>
                        </tr>
                    </thead>
                    <ListItem
                        v-for="(row, index) in itemLists"
                        :key="row.uid"
                        :attribute="row"
                        :index="index"
                        :policyList="policyList"
                        :companies="company"
                        :disable="disableFlag"
                        :btnTrans="btnTrans"
                        :url="url"
                        ref="listItem"
                        @validate="validateEnterAmount"
                        @removeLine="removeLine"
                        @validateInput="validateInput"
                    ></ListItem>
                    <tr>
                        <th colspan="3" style="padding: 5px;"> </th>
                        <template v-for="(comp, index) in company">
                            <th class="text-center" style="vertical-align: middle; padding: 5px;">
                                <ModalDetail
                                    :header="header"
                                    :btnTrans="btnTrans"
                                    :index="index"
                                    :company="comp"
                                    :policyList="policyList"
                                    :detailLists="detailLists"
                                />
                            </th>
                        </template>
                        <th> </th>
                    </tr>
                </table>
                <button class="btn btn-sm btn-block btn-primary" type="button" @click.prevent="addInsuraceList" :disabled="disableFlag">
                    <i class="fa fa-plus-square"></i>&nbsp; เพิ่มรายการ
                </button>
            </template>
            <hr>
        </form>
    </div>
</template>

<script>
import uuidv1 from 'uuid/v1';
import ListItem from './List.vue'
import ModalDetail from './ModalDetail.vue'
import moment from "moment";
export default {
    props: ["index", "attribute", 'header', 'insuranceLists', 'claimApplyDetail', 'claimApplyComp', 'policyGroups', 'policyGroupSets', 'companies', 'btnTrans', 'disable', 'policyLists', 'url'],
    components: {
        ListItem, ModalDetail
    },
    data() {
        return {
            loading: false,
            valid: true,
            errors: {
                policy_group: false,
                policy_set: false,
                claim_amount: false,
            },
            policyList: this.attribute,
            policySetLists: [],
            company: [],
            itemLists: this.insuranceLists,
            removeInsurance: [],
            detailLists: [],
            disableFlag: this.disable,
            validPolicy: false,
        };
    },
    mounted() {
        this.loopitemList();
    },
    computed:{
        countPolicyLines(){
            var row_no = 0;
            this.itemLists.filter(i => {
                if (i.policy == this.policyList.policy_group+'|'+this.policyList.policy_set) {
                    row_no += 1;
                }
            });

            if (row_no >= 1) {
                this.validPolicy = true;
            }else{
                this.validPolicy = false;
            }
        },
    },
    watch: {
        errors: {
            handler(val){
                val.policy_group? this.setError('policy_group') : this.resetError('policy_group');
                val.policy_set? this.setError('policy_set') : this.resetError('policy_set');
                // val.claim_amount? this.setError('claim_amount') : this.resetError('claim_amount');
            },
            deep: true,
        },
        'insuranceLists': function(newValue) {
            return this.itemLists = this.insuranceLists;
        },
        disable: function(newValue) {
            this.disableFlag = newValue;
        },
        countPolicyLines(newValue){
            return newValue;
        },
    },
    methods: {
        addInsuraceList() {
            let vm = this;
            var form  = $('#claim-form');
            let formData = new FormData();
            let valid = true;
            let errorMsg = '';
            //-- ERROR
            vm.errors.policy_group = false;
            vm.errors.policy_set = false;
            vm.errors.claim_amount = false;
            //-- MSG
            $(form).find("div[id=el_explode_policy_group"+vm.index+"]").html("");
            $(form).find("div[id=el_explode_policy_set"+vm.index+"]").html("");
            $(form).find("div[id=el_explode_claim_amount"+vm.index+"]").html("");

            if (vm.policyList.policy_group == ''){
                vm.errors.policy_group = true;
                valid = false;
                errorMsg = "กรุณาระบุกลุ่มกรมธรรม์";
                $(form).find("div[id=el_explode_policy_group"+vm.index+"]").html(errorMsg);
            }
            if (vm.policyList.policy_set == ''){
                vm.errors.policy_set = true;
                valid = false;
                errorMsg = "กรุณาระบุชุดกรมธรรม์";
                $(form).find("div[id=el_explode_policy_set"+vm.index+"]").html(errorMsg);
            }
            if (vm.policyList.claim_amount == '' || vm.policyList.claim_amount <= 0){
                vm.errors.claim_amount = true;
                valid = false;
                errorMsg = "กรุณาระบุจำนวนเงินเรียกชดใช้";
                $(form).find("div[id=el_explode_claim_amount"+vm.index+"]").html(errorMsg);
            }
            // Check data line is null 16062022
            if (this.itemLists.length >= 1) {
                this.itemLists.filter((item, index) => {
                    this.$refs.listItem[index].checkListErrors();
                    if (item.item == '' || item.amount == '') { valid = false; }
                });
            }
            if (!valid) {
                return;
            }

            // loog get seq
            var row_no = 1;
            if (this.itemLists.length > 0) {
                this.itemLists.filter(i => {
                    if (i.policy == this.policyList.policy_group+'|'+this.policyList.policy_set) {
                        row_no += 1;
                    }
                });
            }

            this.itemLists.push({
                uid: uuidv1(),
                id: '',
                line_number: row_no,
                policy: this.policyList.policy_group+'|'+this.policyList.policy_set,
                accident_desc: '',
                amount: 0,
            });
            this.$emit("validateInput", true); //--เมื่อเพิ่มกลุ่มกรมธรรม์จะซ่อน ปุ่มยืนยัน
        },
        loopitemList() {
            let vm = this;
            vm.selPolicyGroup();
            vm.claimApplyDetail.filter(item => {
                if (item.claim_policy_group.group_header_id+'|'+item.claim_policy_group.policy_set_header_id == vm.policyList.policy_group+'|'+vm.policyList.policy_set) {
                    vm.itemLists.push({
                        uid: uuidv1(),
                        id: item.claim_detail_id,
                        line_number: item.line_number,
                        policy: item.claim_policy_group.group_header_id+'|'+item.claim_policy_group.policy_set_header_id,
                        accident_desc: item.line_description,
                        amount: item.line_amount,
                    });
                }
            })
        },
        selPolicyGroup(){
            let vm = this;
            vm.policySetLists = vm.policyGroupSets.filter(item => {
                            return item.group_header_id == vm.policyList.policy_group;
                        });
            vm.company = vm.companies.filter(item => {
                            return item.group_header_id == vm.policyList.policy_group;
                        });

            vm.company.filter((company, index) => {
                 
                if (company.group_header_id == vm.policyList.policy_group) {
                    if (vm.claimApplyComp.length) {
                        vm.claimApplyComp.filter((applyComp, index) => {
                            Object.values(applyComp.claim_policy_detail.claim_apply_company).filter((line, index) => { 
                                if (vm.policyList.id == line.claim_group_id
                                        && company.company_id == line.company_id
                                        && company.policy_number == line.policy_number) {
                                    var invDate = line.invoice_date? line.invoice_date: '';
                                    var glDate = line.gl_date? line.gl_date: '';
                                    var recDate = line.ar_receipt_date? line.ar_receipt_date: '';
                                    vm.detailLists.push({
                                        uid: uuidv1(),
                                        policy_group: vm.policyList.policy_group,
                                        policy_set: vm.policyList.policy_set,
                                        company: company.company_code,
                                        insurance_date: vm.header.insurance_date,
                                        invoice_date: vm.changeToTh(invDate),
                                        gl_date: vm.changeToTh(glDate),
                                        ref_ar_number: line.reference_document_number,
                                        policy_number: line.policy_number? line.policy_number: company.policy_number,
                                        receipt_date: vm.changeToTh(recDate),
                                        receipt_number: line.ar_receipt_number,
                                        receipt_amount: line.ar_received_amount? line.ar_received_amount: 0
                                    });
                                }
                            });
                        });
                    }
                }
            });
            vm.getDetail();
        },
        selPolicySet(){
            let vm = this;

            vm.company.filter((company, index) => {
                vm.detailLists.push({
                    uid: uuidv1(),
                    policy_group: vm.policyList.policy_group,
                    policy_set: vm.policyList.policy_set,
                    company: company.company_code,
                    insurance_date: vm.header.insurance_date,
                    invoice_date: '',
                    gl_date: '',
                    ref_ar_number: '',
                    policy_number: company.policy_number,
                    receipt_date: '',
                    receipt_number: '',
                    receipt_amount: 0
                });
            });

            vm.policyLists.filter((item, poliIndex) => {
                if (vm.policyList.policy_set != '' || item.policy_set != '') {
                    if (item.policy_group+'|'+item.policy_set == vm.policyList.policy_group+'|'+vm.policyList.policy_set && poliIndex != vm.index ) {
                        swal({
                            title: 'มีข้อผิดพลาด',
                            text: '<span style="font-size: 16px; text-align: left;"> ชุดกรมธรรม์นี้มีระบุไว้แล้ว กรุณาตรวจสอบ</span>',
                            type: "warning",
                            html: true
                        });
                        vm.policyList.policy_set = '';
                        vm.detailLists = [];
                    }
                }
            });
            vm.getDetail();
        },
        removeHeader(policy) {
            let vm = this;
            swal({
                html: true,
                title: '<div class="mt-4"> ลบรายการกลุ่มกรมธรรม์ </div>',
                text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการลบรายการกลุ่มกรมธรรม์ ? </span></h2>',
                showCancelButton: true,
                confirmButtonText: vm.btnTrans.ok.text,
                cancelButtonText: vm.btnTrans.cancel.text,
                confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                closeOnConfirm: false,
                closeOnCancel: true,
                showLoaderOnConfirm: policy.id == ''? false: true
            },
            function(isConfirm){
                if (isConfirm) {
                    vm.comfirmRemove(policy);
                }
            });
        },
        async comfirmRemove(policy){
            let vm = this;
            let params = { policy: policy };
            if (policy.id == '') {
                vm.$emit("removeHeader", policy);
                swal({
                    title: '<div class="mt-4"> ลบรายการกลุ่มกรมธรรม์ </div>',
                    text: '<span style="font-size: 16px; text-align: left;"> ทำการลบรายการกลุ่มกรมธรรม์เรียบร้อยแล้ว </span>',
                    type: "success",
                    html: true
                });
            }else{
                await axios
                .post(vm.url.ajax_delete_claim_policy_irp0011, {params})
                .then(res => {
                    if(res.data.status == 'S'){
                        vm.loading = false;
                        vm.$emit("removeHeader", policy);
                        swal({
                            title: '<div class="mt-4"> ลบรายการกลุ่มกรมธรรม์ </div>',
                            text: '<span style="font-size: 16px; text-align: left;"> ทำการลบรายการกลุ่มกรมธรรม์เรียบร้อยแล้ว </span>',
                            type: "success",
                            html: true
                        });
                    }else{
                        swal({
                            title: '<div class="mt-4"> มีข้อผิดพลาด </div>',
                            text: '<span style="font-size: 16px; text-align: left;">'+res.data.msg+'</span>',
                            type: "warning",
                            html: true
                        });
                    }
                })
                .catch(err => {
                    let msg = err;
                    swal({
                        title: '<div class="mt-4"> มีข้อผิดพลาด </div>',
                        text: msg.message,
                        type: "error",
                        html: true
                    });
                })
            }
        },
        removeLine(itemLine) {
            this.itemLists = this.itemLists.filter( item => {
                return item.uid != itemLine.uid;
            });

            let row_no = 0;
            let items = this.itemLists;
            if (this.itemLists.length > 0) {
                this.itemLists = [];
                items.filter(i => {
                    if (i.policy == this.policyList.policy_group+'|'+this.policyList.policy_set) {
                        row_no += 1;
                        this.itemLists.push({
                            uid: i.uid,
                            id: i.id,
                            line_number: row_no,
                            policy: i.policy,
                            accident_desc: i.accident_desc,
                            amount: i.amount
                        });
                    }else{
                        this.itemLists.push({
                            uid: i.uid,
                            id: i.id,
                            line_number: i.line_number,
                            policy: i.policy,
                            accident_desc: i.accident_desc,
                            amount: i.amount
                        });
                    }
                });
            }
            // this.itemLists = items;
            this.$emit("removeLine", {itemLines: this.itemLists, removeLine: itemLine });
        },
        getDetail(){
            this.$emit("detailLists", this.detailLists);
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
        validateEnterAmount(res){
            let vm = this;
            let total = 0;
            vm.itemLists.filter(function(line) {
                if (res.policy == line.policy) {
                    total += line.amount;
                }
            });

            if (total > vm.policyList.claim_amount) {
                vm.itemLists[res.index].amount = 0;
                swal({
                    title: 'มีข้อผิดพลาด',
                    text: '<span style="font-size: 16px; text-align: left;"> จำนวนเงินที่ระบุ มากกว่า จำนวนเงินเรียกชดใช้ กรุณาตรวจสอบ </span>',
                    type: "warning",
                    html: true
                });
            }
        },
        changeToTh(date){
            // เปลี่ยน Format และ เปลี่ยน คศ -> พศ
            var vm = this;
            var dateTh = '';
            if (date) {
                dateTh = moment(date).add(543, 'year').format('DD-MM-YYYY');
            }
            return dateTh;
        },
        checkListErrors(){
            let vm = this;
            let errorMsg = '';
            //-- ERROR
            vm.errors.policy_group = false;
            vm.errors.policy_set = false;
            vm.errors.claim_amount = false;
            //-- MSG
            $("div[id=el_explode_policy_group"+vm.index+"]").html("");
            $("div[id=el_explode_policy_set"+vm.index+"]").html("");
            $("div[id=el_explode_claim_amount"+vm.index+"]").html("");

            if (vm.policyList.policy_group == ''){
                vm.errors.policy_group = true;
                errorMsg = "กรุณาระบุกลุ่มกรมธรรม์";
                $("div[id=el_explode_policy_group"+vm.index+"]").html(errorMsg);
            }
            if (vm.policyList.policy_set == ''){
                vm.errors.policy_set = true;
                errorMsg = "กรุณาระบุชุดกรมธรรม์";
                $("div[id=el_explode_policy_set"+vm.index+"]").html(errorMsg);
            }
            if (vm.policyList.claim_amount == '' || vm.policyList.claim_amount == 0){
                vm.errors.claim_amount = true;
                errorMsg = "กรุณาระบุจำนวนเงินเรียกชดใช้";
                $("div[id=el_explode_claim_amount"+vm.index+"]").html(errorMsg);
            }
        },
        validateInput(){
            this.$emit("validateInput", true);
        }
    },
}
</script>
<style type="text/css" media="screen">
    div.el-dialog__body{
        padding-left: 50px;
        padding-right: 50px;
        padding-top: 5px;
        padding-bottom: 5px;
        color: #000;
        font-size: 15px;
    }
</style>
