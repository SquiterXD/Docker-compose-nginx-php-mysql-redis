<script>
    // import dayjs from 'dayjs'
    // import 'dayjs/locale/th'
    // dayjs.locale('en')
    import moment from 'moment';
    export default {
        props: ['headers'],
        data() {
            return {
                budget_year: '',
                loading: false,
                periodLists: [],
                html: '',
                budgetYearList: [],
            }
        },
        mounted(){
            if (this.headers.length > 0) {

                this.headers.forEach(data => {
                    
                    this.budgetYearList.push({
                        value: data.budget_year,
                        label: Number(data.budget_year) + 543,
                    });
                });
            }
            
        },
        methods: {
            onlyNumeric() {
                this.budget_year = this.budget_year.replace(/[^0-9 .]/g, '');
            },
            // async findFund(){
            //     var form  = $('#fund-form');
            //     let inputs = form.serialize();
            //     let valid = true;
            //     let errorMsg;
            //     this.errors.period = false;
            //     this.errors.segmentOverride = false;
            //     $(form).find("div[id='el_explode_period']").html("");
            //     $(form).find("div[id='el_explode_segment']").html("");

    

            //     this.loading = true;
            //     this.funds = [];
            //     let res = await this.getFundBySegmet(inputs);
            //     if(res.status == 'S'){
            //         this.funds.push({
            //             budget_amount: res.fund['budget_amount'],
            //             encumbrance_amount: res.fund['encumbrance_amount'],
            //             actual_amount: res.fund['actual_amount'],
            //             funds_available_amount: res.fund['funds_available_amount'],
            //             description: res.description_account
            //         });
            //         this.reqEncumbranceAmount = res.fund['req_encumbrance_amount'];
            //         this.poEncumbranceAmount = res.fund['po_encumbrance_amount'];
            //         this.otherEncumbranceAmount = res.fund['other_encumbrance_amount'];
            //         this.periodBalances = res.period_balance;
            //     }else{
            //         swal({
            //             title: 'มีข้อผิดพลาด',
            //             text: '<span style="font-size: 16px; text-align: left;">'+res.msg+'</span>',
            //             type: "error",
            //             html: true
            //         });
            //     }
            // },

            async findPeriod(query) {
                let vm = this;
                var form  = $('#fund-form');
                

                vm.loading = true;
                vm.periodLists = [];

                await axios
                    .get("/om/ajax/search-order", {
                        params: {
                            budget_year: vm.budget_year,
                            query: query,
                        }
                    })
                    .then(res => {
                        // console.log('data   <----> ' + res.data.orderPeriod);
                        // console.log('res   <----> ' + res);
                        vm.periodLists = res.data.orderPeriod;
                        
                        vm.html = res.data.html;
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
                        vm.loading = false;
                    });
            },
            // sortArrays(arrays) {
            //     return _.orderBy(arrays, 'period_no', 'asc');
            // },
            // async contest(date) {
            //     // return _.orderBy(arrays, 'period_no', 'asc');
            //     return await helperDate.parseToDateTh(date, 'DD-MM-yyyy');
            // },

        }
    };
</script>

<style scope>
    .mx-datepicker {
        height: 32px;
        /*padding-top: 1px;*/
    }
</style>
