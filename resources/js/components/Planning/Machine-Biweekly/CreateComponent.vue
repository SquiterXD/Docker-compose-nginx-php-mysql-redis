<script>
    import moment from "moment";
    import VueNumeric from 'vue-numeric';
    export default {
        props:['productTypes', 'budgetYears', 'defaultInput', 'searchInput', 'search', 'lines', 'workingHour'],
        components: {
            VueNumeric
        },
        data() {
            return {
                budget_year: this.defaultInput.current_year,
                month:  '',
                bi_weekly: '',
                efficiency_machine: '',
                efficiency_product: this.defaultInput.efficiency_product,
                working_hour: this.defaultInput.working_hour,
                product_type: this.defaultInput.product_type,
                month_lists: [],
                bi_weekly_lists: [],
                loading: false,
                m_loading: false,
                b_loading: false,
                errors: {
                    budget_year: false,
                    month: false,
                    bi_weekly: false,
                    efficiency_product: false
                },
            }
        },
        mounted() {
            if (this.budget_year) {
                this.getMonth();
            }
        },
        computed: {
            monthLists: function () {
                return this.month_lists;
            },
            biWeeklyLists: function () {
                return this.bi_weekly_lists;
            },
            efficiencyMachine: function () {
                return this.efficiency_machine;
            },
            efficiencyProduct: function () {
                return this.efficiency_product;
            }
        },
        watch:{
            errors: {
                handler(val){
                    val.budget_year? this.setError('budget_year') : this.resetError('budget_year');
                    val.month? this.setError('month') : this.resetError('month');
                    val.bi_weekly? this.setError('bi_weekly') : this.resetError('bi_weekly');
                    val.efficiency_product? this.setError('efficiency_product') : this.resetError('efficiency_product');
                },
                deep: true,
            },
        },
        methods: {
            getMonth(){
                if (!this.search) {
                    this.month = '';
                    this.bi_weekly = '';
                }
                var curr_val = '';
                var curr_period = moment().format('MMM-YY');
                // get current period num
                // this.searchInput.months.filter(item => {
                //     if (item.period_name == curr_period) {
                //         return curr_val = item.period_num;
                //     }
                // });
                this.month_lists = this.searchInput.months;
                // this.month_lists = this.searchInput.months.filter(item => {
                //     return item.thai_year == this.budget_year && Number(item.period_num) >= Number(curr_val);
                // });

                // this.month_lists = this.searchInput.months.filter(item => {
                //     return item.thai_year.indexOf(this.budget_year) > -1;
                // });
            },
            getBiWeeklySeq(){
                this.bi_weekly = '';
                // this.bi_weekly_lists = this.searchInput.bi_weekly.filter(item => {
                //     return item.period_num == this.month && item.thai_year.indexOf(this.budget_year) > -1;
                // });
                this.bi_weekly_lists = this.searchInput.bi_weekly.filter(item => {
                    return item.period_num == this.month;
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
            async submit(){
                var form  = $('#machine-create-form');
                let inputs = form.serialize();
                let valid = true;
                let errorMsg = '';
                this.errors.budget_year = false;
                this.errors.month = false;
                this.errors.bi_weekly = false;
                this.errors.efficiency_machine = false;
                this.errors.efficiency_product = false;
                // this.errors.product_type = false;
                $(form).find("div[id='budget_year']").html("");
                $(form).find("div[id='el_explode_month']").html("");
                $(form).find("div[id='el_explode_bi_weekly']").html("");
                $(form).find("div[id='el_explode_efficiency_machine']").html("");
                $(form).find("div[id='el_explode_efficiency_product']").html("");
                // $(form).find("div[id='el_explode_product_type']").html("");

                if (this.budget_year == ''){
                    this.errors.budget_year = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกปีงบประมาณ";
                    $(form).find("div[id='el_explode_budget_year']").html(errorMsg);
                }
                if (this.month == ''){
                    this.errors.month = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกเดือน";
                    $(form).find("div[id='el_explode_month']").html(errorMsg);
                }
                if (this.bi_weekly == ''){
                    this.errors.bi_weekly = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกปักษ์";
                    $(form).find("div[id='el_explode_bi_weekly']").html(errorMsg);
                }
                // if (this.efficiency_machine == ''){
                //     this.errors.efficiency_machine = true;
                //     valid = false;
                //     errorMsg = "กรุณากรอกเปอร์เซ็นต์ประสิทธิภาพเครื่องจักร";
                //     $(form).find("div[id='el_explode_efficiency_machine']").html(errorMsg);
                // }
                if (this.efficiency_product == ''){
                    this.errors.efficiency_product = true;
                    valid = false;
                    errorMsg = "กรุณากรอกเปอร์เซ็นต์สั่งผลิต";
                    $(form).find("div[id='el_explode_efficiency_product']").html(errorMsg);
                }
                if (!valid) {
                    return;
                }
                this.loading = true;
                let res = await this.createMachineTransactions(inputs);
                if(res.status == 'S'){
                    swal({
                        title: 'สร้างประมาณการผลิตประจำปักษ์',
                        text: '<span style="font-size: 16px; text-align: left;"> ทำการสร้างข้อมูลประมาณการผลิตประจำปักษ์เรียบร้อยแล้ว </span>',
                        type: "success",
                        html: true
                    });
                    //redirect
                    window.setTimeout(function() {
                        window.location.href = `/planning/machine-biweekly?search[budget_year]=`+res.param['budget_year']+`&search[month]=`+res.param['month']+`&search[bi_weekly]=`+res.param['bi_weekly']+`&search[product_type]=`+res.product_type;
                    }, 2000);
                }else{
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+res.msg+'</span>',
                        type: "warning",
                        html: true
                    });
                }
            },
            async createMachineTransactions(inputs) {
                let data = [];
                await axios
                    .post(`/planning/machine-biweekly`, inputs)
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
                        this.loading = false;
                    });

                return data;
            },
        }
    }
</script>