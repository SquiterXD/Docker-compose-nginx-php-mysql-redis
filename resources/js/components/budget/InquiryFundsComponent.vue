<script>
    // import dayjs from 'dayjs'
    // import 'dayjs/locale/th'
    // dayjs.locale('en')
    import moment from 'moment';
    export default {
        props: ['ledgers', 'budgetLists', 'amountLists', 'encumbranceLists', 'accountLevelLists', 'inquiryFunds', 'search', 'defaultInput', 'defaultValueSetName'],
        data() {
            return {
                aliLoad: false,
                loading: false,
                get_data_loading: false,
                value: '',
                period: this.search.period? this.search.period: moment().format('MMM-YY'),
                ledger: this.search.ledger? this.search.ledger: this.defaultInput.ledger, 
                budget: this.search.budget? this.search.budget: '1000',
                amountType: this.search.amount_type? this.search.amount_type: 'YTDE',
                encumType: this.search.encum_type? this.search.encum_type: 'ALL',
                accLevel: this.search.account_level? this.search.account_level: 'A',
                detail : '',
                // Segment From
                segment1From: '', segment2From: '', segment3From: '', segment4From: '', segment5From: '', segment6From: '',
                segment7From: '', segment8From: '', segment9From: '', segment10From: '', segment11From: '', segment12From: '',
                // Segment To
                segment1To: '', segment2To: '', segment3To: '', segment4To: '', segment5To: '', segment6To: '',
                segment7To: '', segment8To: '', segment9To: '', segment10To: '', segment11To: '', segment12To: '',
                // Option[]
                option1: [], option2: [], option3: [], option4: [], option5: [], option6: [],
                option7: [], option8: [], option9: [], option10: [], option11: [], option12: [],
                account_from: this.search? this.search.account_from: '',
                account_to:this.search? this.search.account_to: '',
                coaEnter: this.search? this.search.account_from: '', //user กรอก segment acc เอง
                alias: '', aliasLists: '',
                funds: this.inquiryFunds,
                periodBalances: [],
                reqEncumbranceAmount: '',
                poEncumbranceAmount: '',
                otherEncumbranceAmount: '',
                encumbrances: [],
                errors: {
                    period: false,
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
                get_data_flag: false,
                sel_concate_segment: '',
                // Add by requirment
                adj_flag: this.search.adj_flag && this.search.adj_flag == 'true'? true: false,
                adj_period: this.search.adj_period? this.search.adj_period: moment().format('YYYY'),
                //Add new requirement 18072021
                // is_summary: 'N',
                sel_fund: '',
                sel_period: '',
                // Paginate Boostrap vue
                currentPage: 1,
                perPage: 10,
                // New require 17012022
                defaultPeriodYear: '',
            }
        },
        mounted() {
            this.getValueSetList();
            this.enterAccSegment();
            this.getPeriodYear();
        },
        computed: {
            budgetTotal() {
                return this.periodBalances.reduce((accumulator, line) => {
                    return accumulator + parseFloat(line.budget);
                }, 0);
            },
            // ดึง Encumbrance จาก Period
            encumbrancePeriodTotal() {
                return this.periodBalances.reduce((accumulator, line) => {
                    return accumulator + parseFloat(line.encumbrance);
                }, 0);
            },
            // ดึง Encumbrance จาก BC
            encumbranceBcTotal() {
                return this.encumbrances.reduce((accumulator, line) => {
                    return accumulator + parseFloat(line.encumbrance_amount);
                }, 0);
            },
            actualTotal() {
                return this.periodBalances.reduce((accumulator, line) => {
                    return accumulator + parseFloat(line.actual);
                }, 0);
            },
            availableTotal() {
                return this.periodBalances.reduce((accumulator, line) => {
                    return accumulator + parseFloat(line.available);
                }, 0);
            },
            rows() {
                return this.inquiryFunds.length;
            },
            itemsForList() {
                return this.funds.slice(
                    (this.currentPage - 1) * this.perPage,
                    this.currentPage * this.perPage,
                );
            }
        },
        watch:{
            errors: {
                handler(val){
                    val.period? this.setError('period') : this.resetError('period');
                    val.segmentOverride? this.setError('segmentOverride') : this.resetError('segmentOverride');
                },
                deep: true,
            },
        },
        methods: {
            decimal(number) {
                return Number(number).toLocaleString(undefined, { minimumFractionDigits: 2 });
            },
            calEncumbrance(encumbranceAmount, period) {
                var amt = 0;
                if (this.encumbrances.length > 0) {
                    this.encumbrances.filter(item => {
                        if (item.period_name == period) {
                            amt = item.encumbrance_amount;
                        }
                    });
                }
                var enc_amt = Number(encumbranceAmount) + Number(amt);
                return Number(enc_amt).toLocaleString(undefined, { minimumFractionDigits: 2 });
            },
            calAvaliable(avaliableAmount, period) {
                var amt = 0;
                if (this.encumbrances.length > 0) {
                    this.encumbrances.filter(item => {
                        if (item.period_name == period) {
                            amt = item.encumbrance_amount;
                        }
                    });
                }
                var avaliable_amt = Number(avaliableAmount) - Number(amt);
                return Number(avaliable_amt).toLocaleString(undefined, { minimumFractionDigits: 2 });
            },
            encumbranceTotal(encumbranceAmount, encumbranceBcAmount) {
                var enc_total = Number(encumbranceAmount) + Number(encumbranceBcAmount);
                return Number(enc_total).toLocaleString(undefined, { minimumFractionDigits: 2 });
            },
            avaliableTotal(avaliableAmount, encumbranceBcAmount) {
                var avaliable_total = Number(avaliableAmount) - Number(encumbranceBcAmount);
                return Number(avaliable_total).toLocaleString(undefined, { minimumFractionDigits: 2 });
            },
            changeAdjPeriod(){
                this.adj_period = moment(this.adj_period).format('YYYY');
            },
            selAdjPeriod(){
                if (this.adj_flag == false) {
                    this.period = moment().format('MMM-YY');
                }
            },
            updateCoaFrom(res){
                if (res.name == this.defaultValueSetName.segment1) { 
                    this.segment1From = res.segment1From;
                    this.segment1To = res.segment1To;
                    this.option1 = res.options;
                }
                if (res.name == this.defaultValueSetName.segment2) {
                    this.segment2From = res.segment2From; 
                    this.segment2To = res.segment2To;
                    this.option2 = res.options;
                }
                if (res.name == this.defaultValueSetName.segment3) {
                    this.segment3From = res.segment3From;
                    this.segment3To = res.segment3To;
                    // this.segment4From = '';
                    this.option3 = res.options;
                }
                if (res.name == this.defaultValueSetName.segment4) {
                    this.segment4From = res.segment4From;
                    this.segment4To = res.segment4To;
                    this.option4 = res.options;
                }
                if (res.name == this.defaultValueSetName.segment5) {
                    this.segment5From = res.segment5From;
                    this.segment5To = res.segment5To;
                    this.option5 = res.options;
                }
                if (res.name == this.defaultValueSetName.segment6) {
                    this.segment6From = res.segment6From; 
                    this.segment6To = res.segment6To;
                    // this.segment7From = '';
                    this.option6 = res.options;
                }
                if (res.name == this.defaultValueSetName.segment7) {
                    this.segment7From = res.segment7From;
                    this.segment7To = res.segment7To;
                    this.option7 = res.options;
                }
                if (res.name == this.defaultValueSetName.segment8) {
                    this.segment8From = res.segment8From;
                    this.segment8To = res.segment8To;
                    this.option8 = res.options;
                }
                if (res.name == this.defaultValueSetName.segment9) {
                    this.segment9From = res.segment9From;
                    this.segment9To = res.segment9To;
                    // this.segment10From = '';
                    this.option9 = res.options;
                }
                if (res.name == this.defaultValueSetName.segment10) {
                    this.segment10From = res.segment10From;
                    this.segment10To = res.segment10To;
                    this.option10 = res.options;
                }
                if (res.name == this.defaultValueSetName.segment11) {
                    this.segment11From = res.segment11From;
                    this.segment11To = res.segment11To;
                    this.option11 = res.options;
                }
                if (res.name == this.defaultValueSetName.segment12) {
                    this.segment12From = res.segment12From;
                    this.segment12To = res.segment12To;
                    this.option12 = res.options;
                }
            },
            updateCoaTo(res){
                if (res.name == this.defaultValueSetName.segment1) {
                    this.segment1To = res.segment1To;
                    this.option1 = res.options;
                }
                if (res.name == this.defaultValueSetName.segment2) {
                    this.segment2To = res.segment2To;
                    this.option2 = res.options;
                }
                if (res.name == this.defaultValueSetName.segment3) {
                    this.segment3To = res.segment3To;
                    // this.segment4To = '';
                    this.option3 = res.options;
                }
                if (res.name == this.defaultValueSetName.segment4) {
                    this.segment4To = res.segment4To;
                    this.option4 = res.options;
                }
                if (res.name == this.defaultValueSetName.segment5) {
                    this.segment5To = res.segment5To;
                    this.option5 = res.options;
                }
                if (res.name == this.defaultValueSetName.segment6) {
                    this.segment6To = res.segment6To;
                    // this.segment7To = '';
                    this.option6 = res.options;
                }
                if (res.name == this.defaultValueSetName.segment7) {
                    this.segment7To = res.segment7To;
                    this.option7 = res.options;
                }
                if (res.name == this.defaultValueSetName.segment8) {
                    this.segment8To = res.segment8To;
                    this.option8 = res.options;
                }
                if (res.name == this.defaultValueSetName.segment9) {
                    this.segment9To = res.segment9To;
                    // this.segment10To = '';
                    this.option9 = res.options;
                }
                if (res.name == this.defaultValueSetName.segment10) {
                    this.segment10To = res.segment10To;
                    this.option10 = res.options;
                }
                if (res.name == this.defaultValueSetName.segment11) {
                    this.segment11To = res.segment11To;
                    this.option11 = res.options;
                }
                if (res.name == this.defaultValueSetName.segment12) {
                    this.segment12To = res.segment12To;
                    this.option12 = res.options;
                }
            },
            accountConfirm(){
                var vm = this;
                var form = $('#tb-segment-override');
                var form2 = $('#modal-flexfield');
                let errorMsg;
                let valid = true;
                vm.errors.segment1From = false;
                vm.errors.segment2From = false;
                vm.errors.segment3From = false;
                vm.errors.segment4From = false;
                vm.errors.segment5From = false;
                vm.errors.segment6From = false;
                vm.errors.segment7From = false;
                vm.errors.segment8From = false;
                vm.errors.segment9From = false;
                vm.errors.segment10From = false;
                vm.errors.segment11From = false;
                vm.errors.segment12From = false;
                vm.errors.segmentOverride = false;
                $(form).find("div[id='el_explode_acc_1']").html("");
                $(form).find("div[id='el_explode_acc_2']").html("");
                $(form).find("div[id='el_explode_acc_3']").html("");
                $(form).find("div[id='el_explode_acc_4']").html("");
                $(form).find("div[id='el_explode_acc_5']").html("");
                $(form).find("div[id='el_explode_acc_6']").html("");
                $(form).find("div[id='el_explode_acc_7']").html("");
                $(form).find("div[id='el_explode_acc_8']").html("");
                $(form).find("div[id='el_explode_acc_9']").html("");
                $(form).find("div[id='el_explode_acc_10']").html("");
                $(form).find("div[id='el_explode_acc_11']").html("");
                $(form).find("div[id='el_explode_acc_12']").html("");
                $(form).find("div[id='el_explode_segment']").html("");

                // if (vm.segment1 == '') {
                //     vm.errors.segment1 = true; 
                //     valid = false;
                //     errorMsg = "Company is required.";
                //     $(form).find("div[id='el_explode_acc_1']").html(errorMsg);
                // }
                // if (vm.segment2 == '') {
                //     vm.errors.segment2 = true; 
                //     valid = false;
                //     errorMsg = "EVM is required.";
                //     $(form).find("div[id='el_explode_acc_2']").html(errorMsg);
                // }
                // if (vm.segment3 == '') {
                //     vm.errors.segment3 = true; 
                //     valid = false;
                //     errorMsg = "Department is required.";
                //     $(form).find("div[id='el_explode_acc_3']").html(errorMsg);
                // }
                // if (vm.segment4 == '') {
                //     vm.errors.segment4 = true; 
                //     valid = false;
                //     errorMsg = "Cost Center is required.";
                //     $(form).find("div[id='el_explode_acc_4']").html(errorMsg);
                // }
                // if (vm.segment5 == '') {
                //     vm.errors.segment5 = true; 
                //     valid = false;
                //     errorMsg = "Budget Year is required.";
                //     $(form).find("div[id='el_explode_acc_5']").html(errorMsg);
                // }
                // if (vm.segment6 == '') {
                //     vm.errors.segment6 = true; 
                //     valid = false;
                //     errorMsg = "Budget Type is required.";
                //     $(form).find("div[id='el_explode_acc_6']").html(errorMsg);
                // }
                // if (vm.segment7 == '') {
                //     vm.errors.segment7 = true; 
                //     valid = false;
                //     errorMsg = "Budget Detail is required.";
                //     $(form).find("div[id='el_explode_acc_7']").html(errorMsg);
                // }if (vm.segment8 == '') {
                //     vm.errors.segment8 = true; 
                //     valid = false;
                //     errorMsg = "Budget Reason is required.";
                //     $(form).find("div[id='el_explode_acc_8']").html(errorMsg);
                // }if (vm.segment9 == '') {
                //     vm.errors.segment9 = true; 
                //     valid = false;
                //     errorMsg = "Main Account is required.";
                //     $(form).find("div[id='el_explode_acc_9']").html(errorMsg);
                // }if (vm.segment10 == '') {
                //     vm.errors.segment10 = true;
                //     valid = false;
                //     errorMsg = "Sub Account is required.";
                //     $(form).find("div[id='el_explode_acc_10']").html(errorMsg);
                // }if (vm.segment11 == '') {
                //     vm.errors.segment11 = true;
                //     valid = false;
                //     errorMsg = "Reserved1 is required.";
                //     $(form).find("div[id='el_explode_acc_11']").html(errorMsg);
                // }if (vm.segment12 == '') {
                //     vm.errors.segment12 = true;
                //     valid = false;
                //     errorMsg = "Reserved2 is required.";
                //     $(form).find("div[id='el_explode_acc_12']").html(errorMsg);
                // }
                if (vm.segment1From == '' && vm.segment2From == '' && vm.segment3From == '' && vm.segment4From == '' && vm.segment5From == '' && vm.segment6From == '' && vm.segment7From == '' && vm.segment8From == '' && vm.segment9From == '' && vm.segment10From == '' && vm.segment11From == '' && vm.segment12From == '') {
                    vm.errors.segmentOverride = true;
                    valid = false;
                    errorMsg = "ยังไม่มีการกรอกชุดบัญชี กรุณาตรวจสอบ";
                    $(form2).find("div[id='el_explode_segment']").html(errorMsg);
                }
                if (!valid) {
                    return;
                }
                vm.account_from = vm.segment1From+'.'+vm.segment2From+'.'+vm.segment3From+'.'+vm.segment4From+'.'+vm.segment5From+'.'+vm.segment6From+'.'+vm.segment7From+'.'+vm.segment8From+'.'+vm.segment9From+'.'+vm.segment10From+'.'+vm.segment11From+'.'+vm.segment12From;
                vm.account_to = vm.segment1To+'.'+vm.segment2To+'.'+vm.segment3To+'.'+vm.segment4To+'.'+vm.segment5To+'.'+vm.segment6To+'.'+vm.segment7To+'.'+vm.segment8To+'.'+vm.segment9To+'.'+vm.segment10To+'.'+vm.segment11To+'.'+vm.segment12To;
                vm.coaEnter = vm.account_from
                var form = $('#fund-form');
                $(form).find("div[id='el_explode_segment']").html("");
                $('#modal-flexfield').modal('hide');
            },
            async findFund(){
                console.log('#fund-form');
                var form  = $('#fund-form');
                let inputs = form.serialize();
                let valid = true;
                let errorMsg;
                this.errors.period = false;
                this.errors.segmentOverride = false;
                $(form).find("div[id='el_explode_period']").html("");
                $(form).find("div[id='el_explode_segment']").html("");

                if (this.period == '' || this.period == null){
                    this.errors.period = true;
                    valid = false;
                    errorMsg = "กรุณากรอกงวดบัญชี";
                    $(form).find("div[id='el_explode_period']").html(errorMsg);
                }

                // if (this.segment1From == '' || this.segment2From == '' || this.segment3From == '' || this.segment4From == '' || this.segment5From == '' || this.segment6From == '' || this.segment7From == '' || this.segment8From == '' || this.segment9From == '' || this.segment10From == '' || this.segment11From == '' || this.segment12From == '') {
                //     this.errors.segmentOverride = true;
                //     valid = false;
                //     errorMsg = "กรอกชุดบัญชีไม่ครบ กรุณาตรวจสอบ";
                //     $(form).find("div[id='el_explode_segment']").html(errorMsg);
                // }
                if (!valid) {
                    return;
                }

                this.loading = true;
                // this.funds = [];
                let res = await this.getFundBySegment(inputs);
                if(res.status == 'S'){
                    // this.funds.push({
                    //     budget_amount: res.fund['budget_amount'],
                    //     encumbrance_amount: res.fund['encumbrance_amount'],
                    //     actual_amount: res.fund['actual_amount'],
                    //     funds_available_amount: res.fund['funds_available_amount'],
                    //     description: res.description_account
                    // });
                    // this.reqEncumbranceAmount = res.fund['req_encumbrance_amount'];
                    // this.poEncumbranceAmount = res.fund['po_encumbrance_amount'];
                    // this.otherEncumbranceAmount = res.fund['other_encumbrance_amount'];
                    // this.periodBalances = res.period_balance;

                    //redirect
                    window.setTimeout(function() {
                        window.location.href = res.redirect_show_page;
                    }, 500);
                }else{
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+res.msg+'</span>',
                        type: "error",
                        html: true
                    });
                }
            },
            async getFundBySegment(input) {
                let data = [];
                await axios
                    .post(`/inquiry-funds`, input)
                    .then(res => {
                        data = res.data;
                    })
                    .catch(err => {
                        let msg = err.response.data;
                        swal({
                            title: 'มีข้อผิดพลาด',
                            text: msg.message,
                            type: "error",
                        });
                    })
                    .then(() => {
                        this.loading = true;
                    });

                return data;
            },
            async getValueSetList(query) {
                this.aliLoad = true;
                axios.get("/ajax/inquiry-funds", {
                    params: {
                        flex_value_set_name: this.defaultValueSetName.alias,
                        flex_value_set_data: this.alias,
                        query: query,
                    }
                })
                .then(res => {
                    this.aliasLists = res.data;
                })
                .catch(err => {
                    console.log(err)
                })
                .then( () => {
                    this.aliLoad = false;
                });
            },
            chooseAlias(){
                var vm = this;
                var form = $('#tb-segment-override');
                vm.errors.segment1From = false;
                vm.errors.segment2From = false;
                vm.errors.segment3From = false;
                vm.errors.segment4From = false;
                vm.errors.segment5From = false;
                vm.errors.segment6From = false;
                vm.errors.segment7From = false;
                vm.errors.segment8From = false;
                vm.errors.segment9From = false;
                vm.errors.segment10From = false;
                vm.errors.segment11From = false;
                vm.errors.segment12From = false;
                $(form).find("div[id='el_explode_acc_1']").html("");
                $(form).find("div[id='el_explode_acc_2']").html("");
                $(form).find("div[id='el_explode_acc_3']").html("");
                $(form).find("div[id='el_explode_acc_4']").html("");
                $(form).find("div[id='el_explode_acc_5']").html("");
                $(form).find("div[id='el_explode_acc_6']").html("");
                $(form).find("div[id='el_explode_acc_7']").html("");
                $(form).find("div[id='el_explode_acc_8']").html("");
                $(form).find("div[id='el_explode_acc_9']").html("");
                $(form).find("div[id='el_explode_acc_10']").html("");
                $(form).find("div[id='el_explode_acc_11']").html("");
                $(form).find("div[id='el_explode_acc_12']").html("");

                if (vm.alias) {
                    let coa = vm.alias.split(".");
                    if (vm.alias) {
                        vm.segment1From = coa[0];
                        vm.segment2From = coa[1];
                        vm.segment3From = coa[2];
                        vm.segment4From = coa[3];
                        vm.segment5From = vm.defaultPeriodYear; //coa[4]
                        vm.segment6From = coa[5];
                        vm.segment7From = coa[6];
                        vm.segment8From = coa[7];
                        vm.segment9From = coa[8];
                        vm.segment10From = coa[9];
                        vm.segment11From = coa[10];
                        vm.segment12From = coa[11];

                        vm.segment1To = coa[0];
                        vm.segment2To = coa[1];
                        vm.segment3To = coa[2];
                        vm.segment4To = coa[3];
                        vm.segment5To = vm.defaultPeriodYear; //coa[4]
                        vm.segment6To = coa[5];
                        vm.segment7To = coa[6];
                        vm.segment8To = coa[7];
                        vm.segment9To = coa[8];
                        vm.segment10To = coa[9];
                        vm.segment11To = coa[10];
                        vm.segment12To = coa[11];
                        vm.account_from = vm.segment1From+'.'+vm.segment2From+'.'+vm.segment3From+'.'+vm.segment4From+'.'+vm.segment5From+'.'+vm.segment6From+'.'+vm.segment7From+'.'+vm.segment8From+'.'+vm.segment9From+'.'+vm.segment10From+'.'+vm.segment11From+'.'+vm.segment12From;
                        vm.account_to = vm.segment1To+'.'+vm.segment2To+'.'+vm.segment3To+'.'+vm.segment4To+'.'+vm.segment5To+'.'+vm.segment6To+'.'+vm.segment7To+'.'+vm.segment8To+'.'+vm.segment9To+'.'+vm.segment10To+'.'+vm.segment11To+'.'+vm.segment12To;
                        vm.coaEnter = vm.account_from
                        return;
                    }
                }
                vm.account_from = '';
                vm.account_to = '';
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
            getTransactionGL(period, coa){
                // $('#modal_transaction').modal('show');
                this.sel_period = period;
                $.ajax({
                    url: "/ajax/inquiry-funds/transaction",
                    type: 'GET',
                    data: { period : period, coa : coa },
                    beforeSend: function( xhr ) {
                        $("#_content_transaction").html('\
                            <div class="m-t-lg m-b-lg">\
                                <div class="text-center sk-spinner sk-spinner-wave">\
                                    <div class="sk-rect1"></div>\
                                    <div class="sk-rect2"></div>\
                                    <div class="sk-rect3"></div>\
                                    <div class="sk-rect4"></div>\
                                    <div class="sk-rect5"></div>\
                                </div>\
                            </div>'
                        );
                    }
                })
                .done(function(result) {
                    $("#_content_transaction").html(result.data.html);
                    $('.transactions_tb').DataTable({pageLength: 25, searching: false, lengthChange: false, bPaginate: false,
                        bInfo: false,
                        responsive: true,
                        aaSorting: [],
                        dom: '<"html5buttons"B>lTfgitp',
                        buttons: [
                            {
                                extend: 'csv', 
                                title: "Transaction_CSV_"+moment().format('YYYYMMDD'),
                            },
                            {
                                extend: 'excel', 
                                title: "Transaction_EXCEL_"+moment().format('YYYYMMDD'),
                            },
                        ],
                    });
                });
            },
            periodWasSelected(res){
                this.period = res;
            },
            enterAccSegment(){
                var form  = $('#modal-flexfield');
                let valid = true;
                let errorMsg;
                this.errors.segmentOverride = false;
                $(form).find("div[id='el_explode_segment']").html("");

                // if (this.coaEnter != null || this.coaEnter != '') {
                    // var coa = this.coaEnter.split('.');
                    
                    // if (coa[0] == '' || coa[1] == '' || coa[2] == '' || coa[3] == '' || coa[4] == '' || coa[5] == '' || coa[6] == '' || coa[7] == '' || coa[8] == '' || coa[9] == '' || coa[10] == '' || coa[11] == '') {
                    //     this.errors.segmentOverride = true;
                    //     valid = false;
                    //     errorMsg = "กรอกชุดบัญชีไม่ครบ กรุณาตรวจสอบ";
                    //     $(form).find("div[id='el_explode_segment']").html(errorMsg);
                    // }
                // }
                if (!valid) {
                    return;
                }
                var defaultCoa = this.account_from;
                this.account_from = this.coaEnter;
                this.account_to = this.account_to ?? this.coaEnter;
                if (this.coaEnter) {
                    var coa = this.coaEnter.split('.');
                    this.segment1From = coa[0];
                    this.segment2From = coa[1];
                    this.segment3From = coa[2];
                    this.segment4From = coa[3];
                    this.segment5From = coa[4];
                    this.segment6From = coa[5];
                    this.segment7From = coa[6];
                    this.segment8From = coa[7];
                    this.segment9From = coa[8];
                    this.segment10From = coa[9];
                    this.segment11From = coa[10];
                    this.segment12From = coa[11];
                }

                if (this.account_to && defaultCoa == this.coaEnter) {
                    var last_coa = this.account_to.split('.');
                    this.segment1To = last_coa[0];
                    this.segment2To = last_coa[1];
                    this.segment3To = last_coa[2];
                    this.segment4To = last_coa[3];
                    this.segment5To = last_coa[4];
                    this.segment6To = last_coa[5];
                    this.segment7To = last_coa[6];
                    this.segment8To = last_coa[7];
                    this.segment9To = last_coa[8];
                    this.segment10To = last_coa[9];
                    this.segment11To = last_coa[10];
                    this.segment12To = last_coa[11];
                }else if(this.coaEnter){
                    this.segment1To = coa[0];
                    this.segment2To = coa[1];
                    this.segment3To = coa[2];
                    this.segment4To = coa[3];
                    this.segment5To = coa[4];
                    this.segment6To = coa[5];
                    this.segment7To = coa[6];
                    this.segment8To = coa[7];
                    this.segment9To = coa[8];
                    this.segment10To = coa[9];
                    this.segment11To = coa[10];
                    this.segment12To = coa[11];
                }
                return;
            },
            clearAccSegment(){
                var form  = $('#modal-flexfield');
                let valid = true;
                let errorMsg;
                this.errors.segmentOverride = false;
                $(form).find("div[id='el_explode_segment']").html("");
                this.account_from = '';
                this.account_to = '';
                this.coaEnter = '';
                this.segment1From = '';
                this.segment2From = '';
                this.segment3From = '';
                this.segment4From = '';
                this.segment5From = '';
                this.segment6From = '';
                this.segment7From = '';
                this.segment8From = '';
                this.segment9From = '';
                this.segment10From = '';
                this.segment11From = '';
                this.segment12From = '';

                this.segment1To = '';
                this.segment2To = '';
                this.segment3To = '';
                this.segment4To = '';
                this.segment5To = '';
                this.segment6To = '';
                this.segment7To = '';
                this.segment8To = '';
                this.segment9To = '';
                this.segment10To = '';
                this.segment11To = '';
                this.segment12To = '';
                return;
            },
            async getDataFund(ccid, concate_segment, summary_flag){
                var vm = this;
                if (summary_flag == 'Y') { return }
                // get data by ccid
                vm.get_data_loading = true;
                vm.get_data_flag = false;
                vm.sel_concate_segment = concate_segment;
                // vm.is_summary = summary_flag;
                vm. sel_fund = ccid;
                let form = $('#transaction-form');
                $(form).find("div[id='_content_transaction']").html("");
                let params = {
                    ccid: ccid,
                    account_from: vm.account_from,
                    account_to: vm.account_to,
                    period_name: vm.period,
                    adj_flag: vm.adj_flag,
                    adj_period: vm.adj_period
                };
                let res = await vm.getData(params);
                if(res.status == 'S'){
                    vm.get_data_flag = true;
                    vm.reqEncumbranceAmount = res.fund.req_encumbrance_amount;
                    vm.poEncumbranceAmount = res.fund.po_encumbrance_amount;
                    vm.otherEncumbranceAmount = res.fund.other_encumbrance_amount;
                    vm.periodBalances = res.period_balance;
                    vm.encumbrances = res.encumbrances;
                    $(document).ready(function() {
                        $('.period_tb').DataTable({
                            pageLength: 25,
                            searching: false,
                            lengthChange: false,
                            bPaginate: false,
                            bInfo: false,
                            responsive: true,
                            aaSorting: [],
                            dom: '<"html5buttons"B>lTfgitp',
                            buttons: [
                                {
                                    extend: 'csv', 
                                    title: "Period_Balance_CSV_"+moment().format('YYYYMMDD'),
                                },
                                {
                                    extend: 'excel', 
                                    title: "Period_Balance_EXCEL_"+moment().format('YYYYMMDD'),
                                },
                            ],
                        });
                    });
                }else{
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+res.msg+'</span>',
                        type: "error",
                        html: true
                    });
                }
            },
            async getData(params) {
                let data = [];
                console.log(params);
                await axios
                    .post(`ajax/inquiry-funds/period-balance`, params)
                    .then(res => {
                        data = res.data;
                    })
                    .catch(err => {
                        let msg = err.response.data;
                        swal({
                            title: 'มีข้อผิดพลาด',
                            text: msg.message,
                            type: "error",
                        });
                    })
                    .then(() => {
                        this.get_data_loading = false;
                    });

                return data;
            },
            async getPeriodYear() {
                // this.defaultPeriodYear = '';
                let params = {
                    period: this.period
                };
                await axios
                    .post(`ajax/inquiry-funds/period-year`, params)
                    .then(res => {
                        this.segment5From = this.segment5To = this.defaultPeriodYear = res.data.periodYear;
                        if (this.alias) { this.accountConfirm(); }
                    })
                    .catch(err => {
                        console.log(err.response);
                        let msg = err.response;
                        swal({
                            title: 'มีข้อผิดพลาด',
                            text: msg.message,
                            type: "error",
                        });
                    })
                    .then(() => {
                        // this.accountConfirm();
                    });
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