<template>
    <div>
        <el-form-item prop="account_number">
              <div style="padding-top: 3px;">
                <el-input placeholder="รหัสบัญชี" 
                        v-model="account"
                        size="small"
                        name="account_number" >
                  <el-button slot="append"
                            data-toggle="modal"
                            :data-target="`#modal_account${index}`">
                    <i class="fa fa-search"></i>
                  </el-button>
                </el-input>
               </div> 
            </el-form-item>
        <div :id="`modal_account${index}`" class="modal inmodal fade" aria-hidden="true" data-backdrop="static" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" @click="clickAgree()">
                            <span aria-hidden="true">&times;</span>
                            <span class="sr-only">Close</span>
                        </button>
                        <p class="modal-title text-left">ข้อมูลรหัสบัญชี (Account Mapping)</p>
                    </div>
                    <div class="modal-body pb-0" style="">
                        <div class="row mt-2">
                            <label class="col-md-4 col-form-label lable_align"> ประเภทค่าใช้จ่าย </label>
                            <div class="col-md-8 el_field">
                                <lov-type-cost v-model="type_cost_id"
                                            placeholder="ประเภทค่าใช้จ่าย"
                                            :popperBody="false"
                                            :name="`type_cost`"
                                            :disabled="disabled || selectedTypeCostdisabled"
                                            @split-account="getValueAccount"
                                        />
                                <div id="el_explode_type_cost" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <label class="col-md-4 col-form-label lable_align"> COMPANY <span class="text-danger">*</span> </label>
                            <div class="col-md-8 el_field">
                                <coa-component
                                    @coa="updateCoa"
                                    :set-name="defaultValueSetName.segment1"
                                    :set-data="segment1"
                                    placeholder="Company"
                                    ref="segment1"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment1"
                                    :disabled='disabled || selectedTypeCostdisabled'
                                >
                                </coa-component>
                                <div id="el_explode_acc_1" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <label class="col-md-4 col-form-label lable_align"> EVM <span class="text-danger">*</span> </label>
                            <div class="col-md-8 el_field">
                                <coa-component
                                    @coa="updateCoa" 
                                    :set-name="defaultValueSetName.segment2"
                                    :set-data="segment2"
                                    placeholder="EVM"
                                    ref="segment2"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment2"
                                    :disabled='disabled || selectedTypeCostdisabled'
                                >
                                </coa-component>
                                <div id="el_explode_acc_2" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <label class="col-md-4 col-form-label lable_align"> DEPARTMENT <span class="text-danger">*</span> </label>
                            <div class="col-md-8 el_field">
                                <coa-component
                                    @coa="updateCoa"
                                    :set-name="defaultValueSetName.segment3"
                                    :set-data="segment3"
                                    placeholder="Department"
                                    ref="segment3"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment3"
                                    :disabled='disabled || selectedTypeCostdisabled'
                                >
                                </coa-component>
                                <div id="el_explode_acc_3" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <label class="col-md-4 col-form-label lable_align"> COST CENTER <span class="text-danger">*</span> </label>
                            <div class="col-md-8 el_field">
                                <coa-component
                                    @coa="updateCoa"
                                    :set-name="defaultValueSetName.segment4"
                                    :set-data="segment4"
                                    :set-parent="segment3"
                                    placeholder="Cost Center"
                                    :default-value-set-name="defaultValueSetName"
                                    ref="segment4"
                                    :error="errors.segment4"
                                    :disabled='disabled || selectedTypeCostdisabled'
                                >
                                </coa-component>
                                <div id="el_explode_acc_4" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <label class="col-md-4 col-form-label lable_align"> BUDGET YEAR <span class="text-danger">*</span> </label>
                            <div class="col-md-8 el_field">
                                <coa-component 
                                    @coa="updateCoa"
                                    :set-name="defaultValueSetName.segment5"
                                    :set-data="segment5"
                                    placeholder="BUDGET YEAR"
                                    ref="segment5"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment5"
                                    :disabled='disabled || selectedTypeCostdisabled'
                                >
                                </coa-component>
                                <div id="el_explode_acc_5" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <label class="col-md-4 col-form-label lable_align"> BUDGET TYPE <span class="text-danger">*</span> </label>
                            <div class="col-md-8 el_field">
                                <coa-component 
                                    @coa="updateCoa"
                                    :set-name="defaultValueSetName.segment6"
                                    :set-data="segment6"
                                    placeholder="BUDGET TYPE"
                                    ref="segment6"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment6"
                                    :disabled='disabled || selectedTypeCostdisabled'
                                >
                                </coa-component>
                                <div id="el_explode_acc_6" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <label class="col-md-4 col-form-label lable_align"> BUDGET DETAIL <span class="text-danger">*</span> </label>
                            <div class="col-md-8 el_field">
                                <coa-component
                                    @coa="updateCoa"
                                    :set-name="defaultValueSetName.segment7"
                                    :set-data="segment7"
                                    :set-parent="segment6"
                                    placeholder="BUDGET DETAIL"
                                    :default-value-set-name="defaultValueSetName"
                                    ref="segment7"
                                    :error="errors.segment7"
                                    :disabled='disabled || selectedTypeCostdisabled'
                                >
                                </coa-component>
                                <div id="el_explode_acc_7" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <label class="col-md-4 col-form-label lable_align"> BUDGET REASON <span class="text-danger">*</span> </label>
                            <div class="col-md-8 el_field">
                                <coa-component 
                                    @coa="updateCoa"
                                    :set-name="defaultValueSetName.segment8"
                                    :set-data="segment8"
                                    placeholder="BUDGET REASON"
                                    ref="segment8"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment8"
                                    :disabled='disabled || selectedTypeCostdisabled'
                                >
                                </coa-component>
                                <div id="el_explode_acc_8" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <label class="col-md-4 col-form-label lable_align"> MAIN ACCOUNT <span class="text-danger">*</span> </label>
                            <div class="col-md-8 el_field">
                                <coa-component 
                                    @coa="updateCoa"
                                    :set-name="defaultValueSetName.segment9"
                                    :set-data="segment9"
                                    placeholder="MAIN ACCOUNT"
                                    ref="segment9"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment9"
                                    :disabled='disabled || selectedTypeCostdisabled'
                                >
                                </coa-component>
                                <div id="el_explode_acc_9" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <label class="col-md-4 col-form-label lable_align"> SUB ACCOUNT <span class="text-danger">*</span> </label>
                            <div class="col-md-8 el_field">
                                <coa-component
                                    @coa="updateCoa"
                                    :set-name="defaultValueSetName.segment10"
                                    :set-data="segment10"
                                    :set-parent="segment9"
                                    placeholder="SUB ACCOUNT"
                                    :default-value-set-name="defaultValueSetName"
                                    ref="segment10"
                                    :error="errors.segment10"
                                    :disabled='disabled || selectedTypeCostdisabled'
                                >
                                </coa-component>
                                <div id="el_explode_acc_10" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <label class="col-md-4 col-form-label lable_align"> RESERVED1 <span class="text-danger">*</span> </label>
                            <div class="col-md-8 el_field">
                                <coa-component 
                                    @coa="updateCoa"
                                    :set-name="defaultValueSetName.segment11"
                                    :set-data="segment11"
                                    placeholder="RESERVED 1"
                                    ref="segment11"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment11"
                                    :disabled='disabled || selectedTypeCostdisabled'
                                >
                                </coa-component>
                                <div id="el_explode_acc_11" class="error_msg text-left"></div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <label class="col-md-4 col-form-label lable_align"> RESERVED2 <span class="text-danger">*</span> </label>
                            <div class="col-md-8 el_field">
                                <coa-component 
                                    @coa="updateCoa"
                                    :set-name="defaultValueSetName.segment12"
                                    :set-data="segment12"
                                    placeholder="RESERVED 2"
                                    ref="segment12"
                                    :default-value-set-name="defaultValueSetName"
                                    :error="errors.segment12"
                                    :disabled='disabled || selectedTypeCostdisabled'
                                >
                                </coa-component>
                                <div id="el_explode_acc_12" class="error_msg text-left"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-primary btn-sm" @click.private="accountConfirm">
                            <i class="fa fa-check"></i> ตกลง
                        </button>
                         <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-times"></i> ยกเลิก
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    import coaComponent from './InputCOAComponent.vue';
    import lovTypeCost from '../components/lov/typeCost'
    export default {
        components: {
            coaComponent, lovTypeCost
        },
        props: ['coa', 'typeCost', 'defaultValueSetName', 'disabled', 'index'],
        data() {
            return {
                loading: false,
                // Segment
                segment1: '',
                segment2: '',
                segment3: '',
                segment4: '',
                segment5: '',
                segment6: '',
                segment7: '',
                segment8: '',
                segment9: '',
                segment10: '',
                segment11: '',
                segment12: '',
                account: '',
                description : '',
                description_disply : '',
                coaEnter: '', //user กรอก segment acc เอง
                errors: {
                    segmentOverride: false,
                    segment1: false,
                    segment2: false,
                    segment3: false,
                    segment4: false,
                    segment5: false,
                    segment6: false,
                    segment7: false,
                    segment8: false,
                    segment9: false,
                    segment10: false,
                    segment11: false,
                    segment12: false
                },
                type_cost: this.typeCost,
                type_cost_id: '',
                selectedTypeCostdisabled: false,
            }
        },
        computed: {
            coaVehicle(){
                this.account = this.account? this.account: this.coa;
                this.getCoaVehicle();
            }
        },
        watch:{
            errors: {
                handler(val){
                    val.segmentOverride? this.setError('segmentOverride') : this.resetError('segmentOverride');
                },
                deep: true,
            },
            coaVehicle(newValue){
                return newValue;
            },
        },
        methods: {
            async clickAgree() {
                var vm = this;
                var form2 = $(`#modal_account${vm.index}`);
                let errorMsg;
                let valid = true;
                vm.errors.segment1 = false;
                vm.errors.segment2 = false;
                vm.errors.segment3 = false;
                vm.errors.segment4 = false;
                vm.errors.segment5 = false;
                vm.errors.segment6 = false;
                vm.errors.segment7 = false;
                vm.errors.segment8 = false;
                vm.errors.segment9 = false;
                vm.errors.segment10 = false;
                vm.errors.segment11 = false;
                vm.errors.segment12 = false;
                vm.errors.segmentOverride = false;
                $(form2).find("div[id='el_explode_acc_1']").html("");
                $(form2).find("div[id='el_explode_acc_2']").html("");
                $(form2).find("div[id='el_explode_acc_3']").html("");
                $(form2).find("div[id='el_explode_acc_4']").html("");
                $(form2).find("div[id='el_explode_acc_5']").html("");
                $(form2).find("div[id='el_explode_acc_6']").html("");
                $(form2).find("div[id='el_explode_acc_7']").html("");
                $(form2).find("div[id='el_explode_acc_8']").html("");
                $(form2).find("div[id='el_explode_acc_9']").html("");
                $(form2).find("div[id='el_explode_acc_10']").html("");
                $(form2).find("div[id='el_explode_acc_11']").html("");
                $(form2).find("div[id='el_explode_acc_12']").html("");
                $(form2).find("div[id='el_explode_segment']").html("");

                if(vm.segment1 == '' || vm.segment1 == undefined){
                    vm.errors.segment1 = true;
                    valid = false;
                    errorMsg = "กรุณาระบุ Company";
                    $(form2).find("div[id='el_explode_acc_1']").html(errorMsg);
                }
                if(vm.segment2 == '' || vm.segment2 == undefined){
                    vm.errors.segment2 = true;
                    valid = false;
                    errorMsg = "กรุณาระบุ EVM";
                    $(form2).find("div[id='el_explode_acc_2']").html(errorMsg);
                }
                if(vm.segment3 == '' || vm.segment3 == undefined){
                    vm.errors.segment3 = true;
                    valid = false;
                    errorMsg = "กรุณาระบุ Department";
                    $(form2).find("div[id='el_explode_acc_3']").html(errorMsg);
                }
                if(vm.segment4 == '' || vm.segment4 == undefined){
                    vm.errors.segment4 = true;
                    valid = false;
                    errorMsg = "กรุณาระบุ Cost Center";
                    $(form2).find("div[id='el_explode_acc_4']").html(errorMsg);
                }
                if(vm.segment5 == '' || vm.segment5 == undefined){
                    vm.errors.segment5 = true;
                    valid = false;
                    errorMsg = "กรุณาระบุ Budget Year";
                    $(form2).find("div[id='el_explode_acc_5']").html(errorMsg);
                }
                if(vm.segment6 == '' || vm.segment6 == undefined){
                    vm.errors.segment6 = true;
                    valid = false;
                    errorMsg = "กรุณาระบุ Budget Type";
                    $(form2).find("div[id='el_explode_acc_6']").html(errorMsg);
                }
                if(vm.segment7 == '' || vm.segment7 == undefined){
                    vm.errors.segment7 = true;
                    valid = false;
                    errorMsg = "กรุณาระบุ Budget Detail";
                    $(form2).find("div[id='el_explode_acc_7']").html(errorMsg);
                }
                if(vm.segment8 == '' || vm.segment8 == undefined){
                    vm.errors.segment8 = true;
                    valid = false;
                    errorMsg = "กรุณาระบุ Budget Reason";
                    $(form2).find("div[id='el_explode_acc_8']").html(errorMsg);
                }
                if(vm.segment9 == '' || vm.segment9 == undefined){
                    vm.errors.segment9 = true;
                    valid = false;
                    errorMsg = "กรุณาระบุ Main Account";
                    $(form2).find("div[id='el_explode_acc_9']").html(errorMsg);
                }
                if(vm.segment10 == '' || vm.segment10 == undefined){
                    vm.errors.segment10 = true;
                    valid = false;
                    errorMsg = "กรุณาระบุ Sub Account";
                    $(form2).find("div[id='el_explode_acc_10']").html(errorMsg);
                }
                if(vm.segment11 == '' || vm.segment11 == undefined){
                    vm.errors.segment11 = true;
                    valid = false;
                    errorMsg = "กรุณาระบุ Reserved1";
                    $(form2).find("div[id='el_explode_acc_11']").html(errorMsg);
                }
                if(vm.segment12 == '' || vm.segment12 == undefined){
                    vm.errors.segment12 = true;
                    valid = false;
                    errorMsg = "กรุณาระบุ Reserved2";
                    $(form2).find("div[id='el_explode_acc_12']").html(errorMsg);
                }
                if (!valid) {
                    return;
                }

                // return
                if ((vm.segment1 == '' || vm.segment1 == undefined)
                    && (vm.segment2 == '' || vm.segment2 == undefined)
                    && (vm.segment3 == '' || vm.segment3 == undefined)
                    && (vm.segment4 == '' || vm.segment4 == undefined)
                    && (vm.segment5 == '' || vm.segment5 == undefined)
                    && (vm.segment6 == '' || vm.segment6 == undefined)
                    && (vm.segment7 == '' || vm.segment7 == undefined)
                    && (vm.segment8 == '' || vm.segment8 == undefined)
                    && (vm.segment9 == '' || vm.segment9 == undefined)
                    && (vm.segment10 == '' || vm.segment10 == undefined)
                    && (vm.segment11 == '' || vm.segment11 == undefined)
                    && (vm.segment12 == '' || vm.segment12 == undefined)) {
                    vm.account = '';
                }else{
                    vm.account = vm.segment1+'.'+vm.segment2+'.'+vm.segment3+'.'+vm.segment4+'.'+vm.segment5+'.'+vm.segment6+'.'+vm.segment7+'.'+vm.segment8+'.'+vm.segment9+'.'+vm.segment10+'.'+vm.segment11+'.'+vm.segment12;
                }
                // get coa description
                await axios.get("/ir/ajax/vehicles/get-coa-desc", {
                    params: {coa: vm.account}
                })
                .then(res => {
                    vm.description = res.data.desc;
                    vm.description_disply = res.data.desc_disply;
                })
                .catch(err => {
                });

                vm.$emit('resCoa',{type_cost_id: vm.type_cost_id, code_combine: vm.account, description: vm.description, index: vm.index, desc_disply: vm.description_disply});
                $(`#modal_account${vm.index}`).modal('hide');
            },
            decimal(number) {
                return Number(number).toLocaleString(undefined, { minimumFractionDigits: 2 });
            },
            getCoaVehicle(){
                let vm = this;
                if (vm.account) {
                    let coa = vm.account.split(".");
                    vm.segment1 = coa[0];
                    vm.segment2 = coa[1];
                    vm.segment3 = coa[2];
                    vm.segment4 = coa[3];
                    vm.segment5 = coa[4];
                    vm.segment6 = coa[5];
                    vm.segment7 = coa[6];
                    vm.segment8 = coa[7];
                    vm.segment9 = coa[8];
                    vm.segment10 = coa[9];
                    vm.segment11 = coa[10];
                    vm.segment12 = coa[11];
                    return;
                }
            },
            updateCoa(res){
                if (res.name == this.defaultValueSetName.segment1) { 
                    this.segment1 = res.segment1;
                }
                if (res.name == this.defaultValueSetName.segment2) {
                    this.segment2 = res.segment2; 
                }
                if (res.name == this.defaultValueSetName.segment3) {
                    this.segment3 = res.segment3;
                }
                if (res.name == this.defaultValueSetName.segment4) {
                    this.segment4 = res.segment4;
                }
                if (res.name == this.defaultValueSetName.segment5) {
                    this.segment5 = res.segment5;
                }
                if (res.name == this.defaultValueSetName.segment6) {
                    this.segment6 = res.segment6; 
                }
                if (res.name == this.defaultValueSetName.segment7) {
                    this.segment7 = res.segment7;
                }
                if (res.name == this.defaultValueSetName.segment8) {
                    this.segment8 = res.segment8;
                }
                if (res.name == this.defaultValueSetName.segment9) {
                    this.segment9 = res.segment9;
                }
                if (res.name == this.defaultValueSetName.segment10) {
                    this.segment10 = res.segment10;
                }
                if (res.name == this.defaultValueSetName.segment11) {
                    this.segment11 = res.segment11;
                }
                if (res.name == this.defaultValueSetName.segment12) {
                    this.segment12 = res.segment12;
                }
            },
            async accountConfirm(){
                var vm = this;
                var form = $('#tb-segment-override');
                var form2 = $(`#modal_account${vm.index}`);
                let errorMsg;
                let valid = true;
                vm.errors.segment1 = false;
                vm.errors.segment2 = false;
                vm.errors.segment3 = false;
                vm.errors.segment4 = false;
                vm.errors.segment5 = false;
                vm.errors.segment6 = false;
                vm.errors.segment7 = false;
                vm.errors.segment8 = false;
                vm.errors.segment9 = false;
                vm.errors.segment10 = false;
                vm.errors.segment11 = false;
                vm.errors.segment12 = false;
                vm.errors.segmentOverride = false;
                $(form2).find("div[id='el_explode_acc_1']").html("");
                $(form2).find("div[id='el_explode_acc_2']").html("");
                $(form2).find("div[id='el_explode_acc_3']").html("");
                $(form2).find("div[id='el_explode_acc_4']").html("");
                $(form2).find("div[id='el_explode_acc_5']").html("");
                $(form2).find("div[id='el_explode_acc_6']").html("");
                $(form2).find("div[id='el_explode_acc_7']").html("");
                $(form2).find("div[id='el_explode_acc_8']").html("");
                $(form2).find("div[id='el_explode_acc_9']").html("");
                $(form2).find("div[id='el_explode_acc_10']").html("");
                $(form2).find("div[id='el_explode_acc_11']").html("");
                $(form2).find("div[id='el_explode_acc_12']").html("");
                $(form2).find("div[id='el_explode_segment']").html("");

                if(vm.segment1 == '' || vm.segment1 == undefined){
                    vm.errors.segment1 = true;
                    valid = false;
                    errorMsg = "กรุณาระบุ Company";
                    $(form2).find("div[id='el_explode_acc_1']").html(errorMsg);
                }
                if(vm.segment2 == '' || vm.segment2 == undefined){
                    vm.errors.segment2 = true;
                    valid = false;
                    errorMsg = "กรุณาระบุ EVM";
                    $(form2).find("div[id='el_explode_acc_2']").html(errorMsg);
                }
                if(vm.segment3 == '' || vm.segment3 == undefined){
                    vm.errors.segment3 = true;
                    valid = false;
                    errorMsg = "กรุณาระบุ Department";
                    $(form2).find("div[id='el_explode_acc_3']").html(errorMsg);
                }
                if(vm.segment4 == '' || vm.segment4 == undefined){
                    vm.errors.segment4 = true;
                    valid = false;
                    errorMsg = "กรุณาระบุ Cost Center";
                    $(form2).find("div[id='el_explode_acc_4']").html(errorMsg);
                }
                if(vm.segment5 == '' || vm.segment5 == undefined){
                    vm.errors.segment5 = true;
                    valid = false;
                    errorMsg = "กรุณาระบุ Budget Year";
                    $(form2).find("div[id='el_explode_acc_5']").html(errorMsg);
                }
                if(vm.segment6 == '' || vm.segment6 == undefined){
                    vm.errors.segment6 = true;
                    valid = false;
                    errorMsg = "กรุณาระบุ Budget Type";
                    $(form2).find("div[id='el_explode_acc_6']").html(errorMsg);
                }
                if(vm.segment7 == '' || vm.segment7 == undefined){
                    vm.errors.segment7 = true;
                    valid = false;
                    errorMsg = "กรุณาระบุ Budget Detail";
                    $(form2).find("div[id='el_explode_acc_7']").html(errorMsg);
                }
                if(vm.segment8 == '' || vm.segment8 == undefined){
                    vm.errors.segment8 = true;
                    valid = false;
                    errorMsg = "กรุณาระบุ Budget Reason";
                    $(form2).find("div[id='el_explode_acc_8']").html(errorMsg);
                }
                if(vm.segment9 == '' || vm.segment9 == undefined){
                    vm.errors.segment9 = true;
                    valid = false;
                    errorMsg = "กรุณาระบุ Main Account";
                    $(form2).find("div[id='el_explode_acc_9']").html(errorMsg);
                }
                if(vm.segment10 == '' || vm.segment10 == undefined){
                    vm.errors.segment10 = true;
                    valid = false;
                    errorMsg = "กรุณาระบุ Sub Account";
                    $(form2).find("div[id='el_explode_acc_10']").html(errorMsg);
                }
                if(vm.segment11 == '' || vm.segment11 == undefined){
                    vm.errors.segment11 = true;
                    valid = false;
                    errorMsg = "กรุณาระบุ Reserved1";
                    $(form2).find("div[id='el_explode_acc_11']").html(errorMsg);
                }
                if(vm.segment12 == '' || vm.segment12 == undefined){
                    vm.errors.segment12 = true;
                    valid = false;
                    errorMsg = "กรุณาระบุ Reserved2";
                    $(form2).find("div[id='el_explode_acc_12']").html(errorMsg);
                }
                if (!valid) {
                    return;
                }
                // return
                if ((vm.segment1 == '' || vm.segment1 == undefined)
                    && (vm.segment2 == '' || vm.segment2 == undefined)
                    && (vm.segment3 == '' || vm.segment3 == undefined)
                    && (vm.segment4 == '' || vm.segment4 == undefined)
                    && (vm.segment5 == '' || vm.segment5 == undefined)
                    && (vm.segment6 == '' || vm.segment6 == undefined)
                    && (vm.segment7 == '' || vm.segment7 == undefined)
                    && (vm.segment8 == '' || vm.segment8 == undefined)
                    && (vm.segment9 == '' || vm.segment9 == undefined)
                    && (vm.segment10 == '' || vm.segment10 == undefined)
                    && (vm.segment11 == '' || vm.segment11 == undefined)
                    && (vm.segment12 == '' || vm.segment12 == undefined)) {
                    vm.account = '';
                }else{
                    vm.account = vm.segment1+'.'+vm.segment2+'.'+vm.segment3+'.'+vm.segment4+'.'+vm.segment5+'.'+vm.segment6+'.'+vm.segment7+'.'+vm.segment8+'.'+vm.segment9+'.'+vm.segment10+'.'+vm.segment11+'.'+vm.segment12;
                }
                // get coa description
                await axios.get("/ir/ajax/vehicles/get-coa-desc", {
                    params: {coa: vm.account}
                })
                .then(res => {
                    vm.description = res.data.desc;
                    vm.description_disply = res.data.desc_disply;
                })
                .catch(err => {
                });

                vm.$emit('resCoa',{type_cost_id: vm.type_cost_id, code_combine: vm.account, description: vm.description, index: vm.index, desc_disply: vm.description_disply});
                $(`#modal_account${vm.index}`).modal('hide');
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
            enterAccSegment(){
                var form  = $(`#modal_account${vm.index}`);
                let valid = true;
                let errorMsg;
                this.errors.segmentOverride = false;
                $(form).find("div[id='el_explode_segment']").html("");
                if (!valid) {
                    return;
                }
                // var defaultCoa = this.account;
                this.account = this.coaEnter;
                if (this.coaEnter) {
                    var coa = this.coaEnter.split('.');
                    this.segment1 = coa[0];
                    this.segment2 = coa[1];
                    this.segment3 = coa[2];
                    this.segment4 = coa[3];
                    this.segment5 = coa[4];
                    this.segment6 = coa[5];
                    this.segment7 = coa[6];
                    this.segment8 = coa[7];
                    this.segment9 = coa[8];
                    this.segment10 = coa[9];
                    this.segment11 = coa[10];
                    this.segment12 = coa[11];
                }
                return;
            },
            clearAccSegment(){
                var form  = $(`#modal_account${vm.index}`);
                let valid = true;
                let errorMsg;
                this.errors.segmentOverride = false;
                $(form).find("div[id='el_explode_segment']").html("");
                this.account_ = '';
                this.account_to = '';
                this.coaEnter = '';
                this.segment1 = '';
                this.segment2 = '';
                this.segment3 = '';
                this.segment4 = '';
                this.segment5 = '';
                this.segment6 = '';
                this.segment7 = '';
                this.segment8 = '';
                this.segment9 = '';
                this.segment10 = '';
                this.segment11 = '';
                this.segment12 = '';
                return;
            },
            getValueAccount (res) {
                this.account = res.account;
                this.description = res.description;
                this.type_cost = res.type_cost;
                this.type_cost_id = res.type_cost_id;
                if (res.type_cost_id) { this.selectedTypeCostdisabled = true; }
                this.getCoaVehicle();
            },
        }
    };
</script>