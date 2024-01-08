<template>
    <tr v-loading="loading" v-if="policyList.policy_group+'|'+policyList.policy_set == itemLine.policy" >
        <td class="text-center" style="vertical-align: middle;"> {{ itemLine.line_number }} </td>
        <td width="100px" style="padding-bottom: 2px;">
            <el-input name="accident_desc"
                placeholder="รายละเอียดความเสียหาย"
                v-model="itemLine.accident_desc"
                size="medium"
                autocomplete="off"
                ref="accident_desc"
                maxlength="240"
                show-word-limit
                :disabled="disableFlag"
                v-on:keypress.native="validateInput(true)"
            >
            </el-input>
            <div :id="'el_explode_accident_desc'+index" class="error_msg text-left"></div>
        </td>
        <td class="text-right">
            <div class="input-group">
                <vue-numeric :style="'width: 70%; ' + (errors.amount? 'border: 1px solid red;' : '')"
                    name="claim_amount"
                    separator="," 
                    v-bind:precision="2" 
                    v-bind:minus="false"
                    :min="0"
                    :max="999999999"
                    class="form-control input-sm text-right"
                    v-model="itemLine.amount"
                    :disabled="disableFlag"
                    autocomplete="off"
                    @change="validateAmountWithPolicy()"
                    v-on:keypress.native="validateInput()"
                ></vue-numeric>
            </div>
            <div :id="'el_explode_amount'+index" class="error_msg text-left"></div>
        </td>
        <template v-for="company in companies">
            <td>
                <InsurancePercent
                    :amount="itemLine.amount"
                    :company="company"
                />
            </td>
        </template>
        <td style="text-align: center;">
            <button class="btn btn-md btn-danger" @click.prevent="remove(itemLine)" :disabled="disableFlag">
                <i class="fa fa-trash-o"></i>
            </button>
        </td>
    </tr>
</template>

<script>
import uuidv1 from 'uuid/v1';
import InsurancePercent from './insurancePercentAmount.vue'

export default {
    props: ['index', 'attribute', 'policyList', 'companies', 'disable', 'btnTrans', 'url'],
    components: {
        InsurancePercent
    },
    data() {
        return {
            loading: false,
            valid: true,
            errors: {
                accident_desc: false,
                amount: false
            },
            itemLine: this.attribute,
            disableFlag: this.disable,
        };
    },
    watch: {
        errors: {
            handler(val){
                val.accident_desc? this.setError('accident_desc') : this.resetError('accident_desc');
            },
            deep: true,
        },
        disable: function(newValue) {
            this.disableFlag = newValue;
        },
        attribute: function(newValue) {
            this.itemLine = newValue;
        },
    },
    methods: {
        checkListErrors(){
            let vm = this;
            let errorMsg = '';
            //-- ERROR
            vm.errors.accident_desc = false;
            vm.errors.amount = false;
            $("div[id=el_explode_accident_desc"+vm.index+"]").html("");
            $("div[id=el_explode_amount"+vm.index+"]").html("");

            if (vm.itemLine.accident_desc == ''){
                vm.errors.accident_desc = true;
                errorMsg = "กรุณาระบุรายละเอียดความเสียหาย";
                $("div[id=el_explode_accident_desc"+vm.index+"]").html(errorMsg);
            }
            if (vm.itemLine.amount == 0 || vm.itemLine.amount == ''){
                vm.errors.amount = true;
                errorMsg = "กรุณาระบุจำนวนเงิน";
                $("div[id=el_explode_amount"+vm.index+"]").html(errorMsg);
            }
        },
        validateAmountWithPolicy() {
            this.$emit("validate", {policy: this.itemLine.policy, index: this.index});
        },
        remove(itemLine) {
            let vm = this;
            swal({
                html: true,
                title: '<div class="mt-4"> ลบรายการรายละเอียดความเสียหาย </div>',
                text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการลบรายการรายละเอียดความเสียหาย ? </span></h2>',
                showCancelButton: true,
                confirmButtonText: vm.btnTrans.ok.text,
                cancelButtonText: vm.btnTrans.cancel.text,
                confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                closeOnConfirm: false,
                closeOnCancel: true,
                showLoaderOnConfirm: itemLine.id == ''? false: true
            },
            function(isConfirm){
                if (isConfirm) {
                    vm.comfirmRemove(itemLine);
                }
            });
        },
        async comfirmRemove(itemLine){
            let vm = this;
            let params = { line: itemLine };
            if (itemLine.id == '') {
                vm.$emit("removeLine", itemLine);
                swal({
                    title: '<div class="mt-4"> ลบรายการรายละเอียดความเสียหาย </div>',
                    text: '<span style="font-size: 16px; text-align: left;"> ทำการลบรายการรายละเอียดความเสียหายเรียบร้อยแล้ว </span>',
                    type: "success",
                    html: true
                });
            }else{
                await axios
                .post(vm.url.ajax_delete_claim_detail_irp0011, {params})
                .then(res => {
                    if(res.data.status == 'S'){
                        vm.loading = false;
                        vm.$emit("removeLine", itemLine);
                        swal({
                            title: '<div class="mt-4"> ลบรายการรายละเอียดความเสียหาย </div>',
                            text: '<span style="font-size: 16px; text-align: left;"> ทำการลบรายการรายละเอียดความเสียหายเรียบร้อยแล้ว </span>',
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
        validateInput(){
            this.$emit("validateInput", true);
        },

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
