<script>
    import VueNumeric from 'vue-numeric';
    export default {
        props:['productTypes', 'budgetYears', 'defaultInput', 'searchInput', 'search', 'workingHour'],
        components: {
            VueNumeric
        },
        data() {
            return {
                budget_year: this.defaultInput.current_year,
                month:  '',
                efficiency_machine: '',
                efficiency_product: this.defaultInput.efficiency_product,
                product_type: '',
                month_lists: [],
                loading: false,
                m_loading: false,
                errors: {
                    budget_year: false,
                    // month: false,
                    efficiency_product: false
                },
                working_hour: this.defaultInput.working_hour,
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
                    // val.month? this.setError('month') : this.resetError('month');
                    val.efficiency_product? this.setError('efficiency_product') : this.resetError('efficiency_product');
                },
                deep: true,
            },
        },
        methods: {
            getMonth(){
                if (!this.search) {
                    this.month = '';
                }
                // this.month_lists = this.searchInput.months.filter(item => {
                //     return item.thai_year.indexOf(this.budget_year) > -1;
                // });
                // this.m_loading = true;
                // axios.post('/planning/ajax/get-month-machine', {
                //     year: this.budget_year
                // })
                // .then((response) => {
                //     this.month_lists = response.data;
                // })
                // .catch( error => {
                //     this.$notify.error({
                //         title: 'มีข้อผิดพลาด',
                //         message: error.message,
                //     });
                // })
                // .then( () => {
                //     this.m_loading = false;
                // })
            },
            checkInputNumber(value) {
                let newValue = parseFloat(value.replace(/[^\d\.]/g, ""));
                if (isNaN(newValue)) {
                    newValue = 0;
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
            async submit(){
                var form  = $('#machine-create-form');
                let inputs = form.serialize();
                let valid = true;
                let errorMsg = '';
                this.errors.budget_year = false;
                // this.errors.month = false;
                // this.errors.efficiency_machine = false;
                this.errors.efficiency_product = false;
                // this.errors.product_type = false;
                $(form).find("div[id='el_explode_budget_year']").html("");
                // $(form).find("div[id='el_explode_month']").html("");
                // $(form).find("div[id='el_explode_efficiency_machine']").html("");
                $(form).find("div[id='el_explode_efficiency_product']").html("");
                // $(form).find("div[id='el_explode_product_type']").html("");

                if (this.budget_year == ''){
                    this.errors.budget_year = true;
                    valid = false;
                    errorMsg = "กรุณาเลือกปีงบประมาณ";
                    $(form).find("div[id='el_explode_budget_year']").html(errorMsg);
                }
                // if (this.month == ''){
                //     this.errors.month = true;
                //     valid = false;
                //     errorMsg = "กรุณาเลือกเดือน";
                //     $(form).find("div[id='el_explode_month']").html(errorMsg);
                // }
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
                    this.loading = false;
                    swal({
                        title: 'สร้างประมาณการผลิตประจำปี',
                        text: '<span style="font-size: 16px; text-align: left;"> ทำการสร้างข้อมูลประมาณการผลิตประจำปีเรียบร้อยแล้ว </span>',
                        type: "success",
                        html: true
                    });
                    //redirect
                    window.setTimeout(function() {
                        // window.location.href = `/planning/machine-yearly?search[budget_year]=`+res.param['budget_year']+`&search[product_type]=71`;
                        window.location.href = res.redirect_show_page;
                    }, 2000);
                }else{
                    // swal({
                    //     title: 'มีข้อผิดพลาด',
                    //     text: '<span style="font-size: 16px; text-align: left;">'+res.msg+'</span>',
                    //     type: "warning",
                    //     html: true
                    // });
                    swal({
                        title: 'สร้างประมาณการผลิตประจำปี',
                        text: '<span style="font-size: 16px; text-align: left;"> ทำการสร้างข้อมูลประมาณการผลิตประจำปีเรียบร้อยแล้ว </span>',
                        type: "success",
                        html: true
                    });
                    window.setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                }
            },
            async createMachineTransactions(inputs) {
                let data = [];
                await axios
                    .post(`/planning/machine-yearly`, inputs)
                    .then(res => {
                        data = res.data;
                    })
                    .catch(err => {
                        let msg = err.response.data;
                        // swal({
                        //     title: 'มีข้อผิดพลาด',
                        //     text: msg.message,
                        //     type: "error",
                        // });
                        swal({
                            title: 'สร้างประมาณการผลิตประจำปี',
                            text: '<span style="font-size: 16px; text-align: left;"> ทำการสร้างข้อมูลประมาณการผลิตประจำปีเรียบร้อยแล้ว </span>',
                            type: "success",
                            html: true
                        });
                        window.setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    })
                    .then(() => {
                        this.loading = false;
                    });

                return data;
            },
        }
    }
</script>