<script>
    // import dayjs from 'dayjs'
    // import 'dayjs/locale/th'
    // dayjs.locale('en')
    import moment from 'moment';
    export default {
        // props: [],
        props:[
            "url-return",
        ],
        data() {
            return {
                budget_year: '',

                // -------------------------------------------------------------

                loading: false,
                periodLists: [],
            }
        },
        methods: {
            onlyNumeric() {
                this.budget_year = this.budget_year.replace(/[^0-9 .]/g, '');
            },
            fromDateWasSelected(date) {
                // change disabled_date_to of to_date = from_date
                this.budget_year = moment(date).format("DD/MM/YYYY");
            },
            getValueStYear (date) {
                // moment(date).format(formatYear);
                console.log('getValueStYear ---- ' + date);
                this.budget_year = date;
            },


            async findPeriod(query) {
                var form  = $('#fund-form');
                
                $(form).find("div[id='el_explode_period']").html("");
                $(form).find("div[id='el_explode_segment']").html("");

                this.loading = true;
                this.periodLists = [];

                if (this.budget_year) {
                    await axios
                        .get("/om/ajax/get-order", {
                            params: {
                                budget_year: this.budget_year,
                                query: query,
                            }
                        })
                        .then(res => {
                            if (res.data.message) {
                                let msg = res.data;
                                swal({
                                    title: 'มีข้อผิดพลาด',
                                    text: msg.message,
                                    type: "error",
                                });
                            } else {
                                this.periodLists = res.data;
                            }
                            

                            console.log(res);
                        })
                        .catch(err => {
                            this.periodLists = [];
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
                }else {
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: 'โปรดใส่ปีงบประมาณ',
                        type: "error",
                    });
                    this.loading = false;
                }
            },
            // sortArrays(arrays) {
            //     return _.orderBy(arrays, 'period_no', 'asc');
            // },

            save() {
                console.log('xxxxxxx');
                this.loading = true;
                axios
                    .post("/om/settings/order-period", {
                        budget_year : this.budget_year,
                        periodLists : this.periodLists,
                    })
                    .then(res => {
                        alert('complete');
                    })
                    .then(res => {
                        window.location.href = this.urlReturn;
                    })
                    .catch(error => {
                        alert(error);
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
