<script>
    import moment from 'moment';
    export default {
        props: ['search', 'defaultValueSetName', 'defaultValue', 'urlSave', 'urlReset'],
        data() {
            return {
                loading: false,
                value: '',
                detail : '',

                account_code: this.defaultValue ? this.defaultValue.account_code  : '',
                description:  this.defaultValue ? this.defaultValue.description   : '',
                segment1:     this.defaultValue ? this.defaultValue.segment_1     : '',
                segment2:     this.defaultValue ? this.defaultValue.segment_2     : '',
                segment3:     this.defaultValue ? this.defaultValue.segment_3     : '',
                segment4:     this.defaultValue ? this.defaultValue.segment_4     : '',
                segment5:     this.defaultValue ? this.defaultValue.segment_5     : '',
                segment6:     this.defaultValue ? this.defaultValue.segment_6     : '',
                segment7:     this.defaultValue ? this.defaultValue.segment_7     : '',
                segment8:     this.defaultValue ? this.defaultValue.segment_8     : '',
                segment9:     this.defaultValue ? this.defaultValue.segment_9     : '',
                segment10:    this.defaultValue ? this.defaultValue.segment_10    : '',
                segment11:    this.defaultValue ? this.defaultValue.segment_11    : '',
                segment12:    this.defaultValue ? this.defaultValue.segment_12    : '',
                active_flag:  this.defaultValue ? this.defaultValue.active_flag == 'Y' ? true : false : true,
                start_date:   this.defaultValue ? this.defaultValue.start_date    : '',
                end_date:     this.defaultValue ? this.defaultValue.end_date      : '',
                disableEdit:  this.defaultValue ? this.defaultValue.account_code ? true : false : false,

                // Option[]
                option1: [], option2: [], option3: [], option4: [], option5: [], option6: [],
                option7: [], option8: [], option9: [], option10: [], option11: [], option12: [],
                coaEnter: this.search? this.search.account_from: '', //user กรอก segment acc เอง

                encumbrances: [],
                errors: {
                    period: false,
                    segmentOverride: false,

                    account_code: false,
                    description: false,

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
                get_data_flag: false,
                sel_concate_segment: '',

                check_duplicate_code: '',
                check_duplicate_description: '',

                //check validate form
                errorForms: [],
                successForm: false,
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

                account_id: this.defaultValue ? this.defaultValue.account_id  : '',
            }
        },
        watch:{
            errors: {
                handler(val){
                    val.segmentOverride? this.setError('segmentOverride') : this.resetError('segmentOverride');

                    val.account_code    ? this.setError('account_code')    : this.resetError('account_code');
                    val.description     ? this.setError('description')     : this.resetError('description');

                    // val.segment1  ? this.setError('segment1')  : this.resetError('segment1');
                    // val.segment2  ? this.setError('segment2')  : this.resetError('segment2');
                    // val.segment3  ? this.setError('segment3')  : this.resetError('segment3');
                    // val.segment4  ? this.setError('segment4')  : this.resetError('segment4');
                    // val.segment5  ? this.setError('segment5')  : this.resetError('segment5');
                    // val.segment6  ? this.setError('segment6')  : this.resetError('segment6');
                    // val.segment7  ? this.setError('segment7')  : this.resetError('segment7');
                    // val.segment8  ? this.setError('segment8')  : this.resetError('segment8');
                    // val.segment9  ? this.setError('segment9')  : this.resetError('segment9');
                    // val.segment10 ? this.setError('segment10') : this.resetError('segment10');
                    // val.segment11 ? this.setError('segment11') : this.resetError('segment11');
                    // val.segment12 ? this.setError('segment12') : this.resetError('segment12');
                },
                deep: true,
            },
            successForm : async function () {
                if (this.successForm) {
                    if (!this.errorForms.length) {
                        submitForm.submit();
                    }
                }           
            },
        },
        methods: {
        async checkDuplicateCode() {
            this.check_duplicate_code = '';

            axios.get("/ir/ajax/validate-account-mapping", {
                params: {
                    type: 'code',
                    account_code:      this.account_code,
                }
            })
            .then(res => {
                    this.check_duplicate_code = res.data;
                    if (this.check_duplicate_code) {
                        swal({
                            title: "มีข้อผิดพลาด",
                            text: 'Code ซ้ำกับในระบบ',
                            timer: 5000,
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: false
                        });

                        this.account_code = '';
                    } 
                
            })
            .catch(err => {
            });
        },
        async checkDuplicateDscription() {
            this.check_duplicate_description = '';

            axios.get("/ir/ajax/validate-account-mapping", {
                params: {
                    type: 'description',
                    description:       this.description,
                }
            })
            .then(res => {
                    this.check_duplicate_description = res.data;

                    if (this.check_duplicate_description) {
                        swal({
                            title: "มีข้อผิดพลาด",
                            text: 'description ซ้ำกับในระบบ',
                            timer: 5000,
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: false
                        });

                        this.description = '';
                    } 
                    // else {
                        
                    // }

                
            })
            .catch(err => {
            });
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
                this.segment4 = '';
                this.option3 = res.options;
            }
            if (res.name == this.defaultValueSetName.segment4) {
                this.segment4 = res.segment4;
                this.option4 = res.options;
            }
            if (res.name == this.defaultValueSetName.segment5) {
                this.segment5 = res.segment5;
                this.option5 = res.options;
            }
            if (res.name == this.defaultValueSetName.segment6) {
                this.segment6 = res.segment6;
                this.segment7 = '';
                this.option6 = res.options;
            }
            if (res.name == this.defaultValueSetName.segment7) {
                this.segment7 = res.segment7;
                this.option7 = res.options;
            }
            if (res.name == this.defaultValueSetName.segment8) {
                this.segment8 = res.segment8;
                this.option8 = res.options;
            }
            if (res.name == this.defaultValueSetName.segment9) {
                this.segment9 = res.segment9;
                this.segment10 = '';
                this.option9 = res.options;
            }
            if (res.name == this.defaultValueSetName.segment10) {
                    this.segment10 = res.segment10;
                this.option10 = res.options;
            }
            if (res.name == this.defaultValueSetName.segment11) {
                this.segment11 = res.segment11;
                this.option11 = res.options;
            }
            if (res.name == this.defaultValueSetName.segment12) {
                this.segment12 = res.segment12;
                this.option12 = res.options;
            }
        },
        enterAccSegment(){
            var form  = $('#modal-flexfield');
            let valid = true;
            let errorMsg;
            this.errors.segmentOverride = false;
            $(form).find("div[id='el_explode_segment']").html("");

            var coa = this.coaEnter.split('.');

            if (coa.length != 12) {
                swal({
                    title: "Warning",
                    text: 'กรอกชุดบัญชีไม่ครบ กรุณาตรวจสอบ',
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                });
                this.errors.segmentOverride = true;
                valid = false;
                errorMsg = "กรอกชุดบัญชีไม่ครบ กรุณาตรวจสอบ";
                $(form).find("div[id='el_explode_segment']").html(errorMsg);
                
                this.segment1  = '';
                this.segment2  = '';
                this.segment3  = '';
                this.segment4  = '';
                this.segment5  = '';
                this.segment6  = '';
                this.segment7  = '';
                this.segment8  = '';
                this.segment9  = '';
                this.segment10 = '';
                this.segment11 = '';
                this.segment12 = '';
                
                return;
            }
            
            if (coa[0] == '' || coa[1] == '' || coa[2] == '' || coa[3] == '' || coa[4] == '' || coa[5] == '' || coa[6] == '' || coa[7] == '' || coa[8] == '' || coa[9] == '' || coa[10] == '' || coa[11] == '') {
                swal({
                    title: "Warning",
                    text: 'กรอกชุดบัญชีไม่ครบ กรุณาตรวจสอบ',
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                });
                this.errors.segmentOverride = true;
                valid = false;
                errorMsg = "กรอกชุดบัญชีไม่ครบ กรุณาตรวจสอบ";
                $(form).find("div[id='el_explode_segment']").html(errorMsg);

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
            } 
            else {
                axios
                .get("/ir/ajax/validate-combination", {
                    params: {
                        segmentAlls: coa,
                        account_code: this.coaEnter,
                    }
                }).then(res => {
                        
                    if (res.data['status'] == 'E') {
                        swal({
                            title: "Warning",
                            text: res.data['error_msg'],
                            type: "warning",
                        });

                        this.errors.segmentOverride = true;
                        valid = false;
                        errorMsg = "กรอกชุดบัญชีไม่ครบ กรุณาตรวจสอบ";
                        $(form).find("div[id='el_explode_segment']").html(errorMsg);
                        
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

                    } else if (res.data['status']  == 'S') {

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

                        return;
                    }
                });
            }
        },
        clearAccSegment(){
            var form  = $('#modal-flexfield');
            let valid = true;
            let errorMsg;
            this.errors.segmentOverride = false;
            $(form).find("div[id='el_explode_segment']").html("");
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
            vm.errors.account_code = res.err.account_code;
            vm.errors.description  = res.err.description;
            vm.errors.segment1     = res.err.segment1;
            vm.errors.segment2     = res.err.segment2;
            vm.errors.segment3     = res.err.segment3;
            vm.errors.segment4     = res.err.segment4;
            vm.errors.segment5     = res.err.segment5;
            vm.errors.segment6     = res.err.segment6;
            vm.errors.segment7     = res.err.segment7;
            vm.errors.segment8     = res.err.segment8;
            vm.errors.segment9     = res.err.segment9;
            vm.errors.segment10    = res.err.segment10;
            vm.errors.segment11    = res.err.segment11;
            vm.errors.segment12    = res.err.segment12;
        },
        
        submit(){
            console.log('submit func');
            var account_code = this.segment1 + '.' + this.segment2 + '.' + this.segment3 + '.' + this.segment4 + '.' + this.segment5 + '.' + this.segment6
                               + '.' + this.segment7 + '.' + this.segment8 + '.' + this.segment9 + '.' + this.segment10 + '.' + this.segment11 + '.' + this.segment12;
            var coa = account_code.split('.');

            axios
                .get("/ir/ajax/validate-combination", {
                    params: {
                        segmentAlls: coa,
                        account_code: account_code,
                    }
                }).then(res => {
                    if (res.data['status'] == 'E') {
                        swal({
                            title: "Warning",
                            text: res.data['error_msg'],
                            type: "warning",
                        });
                        
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

                    } else if (res.data['status']  == 'S') {

                        this.checkForm();
                    }
                });
        },

        async checkForm (e) {
            let vm = this;

            var submitForm  = $('#submitForm');
            let inputs = submitForm.serialize();
            vm.errorForms = [];  

            let valid = true;
            let errorMsg = '';

            vm.errors.account_code = false;
            vm.errors.description  = false;
            vm.errors.segment1     = false;
            vm.errors.segment2     = false;
            vm.errors.segment3     = false;
            vm.errors.segment4     = false;
            vm.errors.segment5     = false;
            vm.errors.segment6     = false;
            vm.errors.segment7     = false;
            vm.errors.segment8     = false;
            vm.errors.segment9     = false;
            vm.errors.segment10    = false;
            vm.errors.segment11    = false;
            vm.errors.segment12    = false;

            $(submitForm).find("div[id='el_explode_account_code']").html("");
            $(submitForm).find("div[id='el_explode_description']").html("");
            $(submitForm).find("div[id='el_explode_segment1']").html("");
            $(submitForm).find("div[id='el_explode_segment2']").html("");
            $(submitForm).find("div[id='el_explode_segment3']").html("");
            $(submitForm).find("div[id='el_explode_segment4']").html("");
            $(submitForm).find("div[id='el_explode_segment5']").html("");
            $(submitForm).find("div[id='el_explode_segment6']").html("");
            $(submitForm).find("div[id='el_explode_segment7']").html("");
            $(submitForm).find("div[id='el_explode_segment8']").html("");
            $(submitForm).find("div[id='el_explode_segment9']").html("");
            $(submitForm).find("div[id='el_explode_segment10']").html("");
            $(submitForm).find("div[id='el_explode_segment11']").html("");
            $(submitForm).find("div[id='el_explode_segment12']").html("");

            if (!vm.account_code) {
                vm.errorForms.push('Code');
                swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                });

                vm.errors.account_code = true;
                valid = false;
                errorMsg = "กรุณาระบุ Code";
                $(submitForm).find("div[id='el_explode_account_code']").html(errorMsg);

            }else {
                if (!vm.disableEdit) {
                    vm.check_duplicate_code = '';

                    axios.get("/ir/ajax/validate-account-mapping", {
                        params: {
                            type: 'code',
                            account_code:      vm.account_code,
                        }
                    })
                    .then(res => {
                        vm.check_duplicate_code = res.data;
                        
                        if (vm.check_duplicate_code) {
                            swal({
                                title: "มีข้อผิดพลาด",
                                text: 'Code ซ้ำกับในระบบ',
                                timer: 5000,
                                type: "error",
                                showCancelButton: false,
                                showConfirmButton: false
                            });
                        } else {
                            vm.successForm = true;
                        }                             
                    })
                    .catch(err => {
                    });
                }
            }

            if (!vm.description) {
                vm.errorForms.push('Description');
                swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                });

                vm.errors.description = true;
                    valid = false;
                    errorMsg = "กรุณาระบุ Description";
                    $(submitForm).find("div[id='el_explode_description']").html(errorMsg);

            }else {
                vm.check_duplicate_description = '';

                axios.get("/ir/ajax/validate-account-mapping", {
                    params: {
                        type: 'description',
                        description:  vm.description,
                        account_id:   vm.account_id,
                    }
                })
                .then(res => {
                    vm.check_duplicate_description = res.data;

                    if (vm.check_duplicate_description) {
                        vm.errorForms.push('description ซ้ำกับในระบบ');
                        swal({
                            title: "มีข้อผิดพลาด",
                            text: vm.errorForms,
                            timer: 5000,
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    } else {
                        vm.successForm = true;
                    }  
                    
                })
                .catch(err => {
                });
            }

            if (!vm.segment1) {
                    vm.errorForms.push('COMPANY');
                    swal({
                        title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                        text: vm.errorForms,
                        timer: 3000,
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: false
                    });

                    vm.errors.segment1 = true;
                    valid = false;
                    errorMsg = "กรุณาเลือก COMPANY";
                    $(submitForm).find("div[id='el_explode_segment1']").html(errorMsg);
            }
            if (!vm.segment2) {
                vm.errorForms.push('EVM');
                swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                });

                vm.errors.segment2 = true;
                valid = false;
                errorMsg = "กรุณาเลือก EVM";
                $(submitForm).find("div[id='el_explode_segment2']").html(errorMsg);
            }
            if (!vm.segment3) {
                vm.errorForms.push('DEPARTMENT');
                swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                });

                vm.errors.segment3 = true;
                valid = false;
                errorMsg = "กรุณาเลือก DEPARTMENT";
                $(submitForm).find("div[id='el_explode_segment3']").html(errorMsg);
            }
            if (!vm.segment4) {
                vm.errorForms.push('COST CENTER');
                swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                });

                vm.errors.segment4 = true;
                valid = false;
                errorMsg = "กรุณาเลือก COST CENTER";
                $(submitForm).find("div[id='el_explode_segment4']").html(errorMsg);
            }
            if (!vm.segment5) {
                vm.errorForms.push('BUDGET YEAR');
                swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                });

                vm.errors.segment5 = true;
                valid = false;
                errorMsg = "กรุณาเลือก BUDGET YEAR";
                $(submitForm).find("div[id='el_explode_segment5']").html(errorMsg);
            }
            if (!vm.segment6) {
                vm.errorForms.push('BUDGET TYPE');
                swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                });

                vm.errors.segment6 = true;
                valid = false;
                errorMsg = "กรุณาเลือก BUDGET TYPE";
                $(submitForm).find("div[id='el_explode_segment6']").html(errorMsg);
            }
            if (!vm.segment7) {
                vm.errorForms.push('BUDGET DETAIL');
                swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                });

                vm.errors.segment7 = true;
                valid = false;
                errorMsg = "กรุณาเลือก BUDGET DETAIL";
                $(submitForm).find("div[id='el_explode_segment7']").html(errorMsg);
            }
            if (!vm.segment8) {
                vm.errorForms.push('BUDGET REASON');
                swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                });

                vm.errors.segment8 = true;
                valid = false;
                errorMsg = "กรุณาเลือก BUDGET REASON";
                $(submitForm).find("div[id='el_explode_segment8']").html(errorMsg);
            }
            if (!vm.segment9) {
                vm.errorForms.push('MAIN ACCOUNT');
                swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                });

                vm.errors.segment9 = true;
                valid = false;
                errorMsg = "กรุณาเลือก MAIN ACCOUNT";
                $(submitForm).find("div[id='el_explode_segment9']").html(errorMsg);
            }
            if (!vm.segment10) {
                vm.errorForms.push('SUB ACCOUNT');
                swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                });

                vm.errors.segment10 = true;
                valid = false;
                errorMsg = "กรุณาเลือก SUB ACCOUNT";
                $(submitForm).find("div[id='el_explode_segment10']").html(errorMsg);
            }
            if (!vm.segment11) {
                vm.errorForms.push('RESERVED1');
                swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                });

                vm.errors.segment11 = true;
                valid = false;
                errorMsg = "กรุณาเลือก RESERVED1";
                $(submitForm).find("div[id='el_explode_segment11']").html(errorMsg);
            }
            if (!vm.segment12) {
                vm.errorForms.push('RESERVED2');
                swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: vm.errorForms,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                });

                vm.errors.segment12 = true;
                valid = false;
                errorMsg = "กรุณาเลือก RESERVED2";
                $(submitForm).find("div[id='el_explode_segment12']").html(errorMsg);
            }
                
            if (vm.successForm) {
                if (!vm.errorForms.length) {
                    submitForm.submit();
                }
            }
            if (!vm.errorForms.length) {
                if (vm.successForm) {
                    submitForm.submit();
                }
                
            }

            e.preventDefault();
        },
        }
    };
</script>

<style scope>
    .mx-datepicker {
        height: 32px;
        /*padding-top: 1px;*/
    }
</style>