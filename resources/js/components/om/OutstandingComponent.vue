<script>

import moment from "moment";

export default {
    props: ['customers', 'customer', 'customerTypes', 'days', 'dataSearch', 'creditGroups'],
    data() {
        return {
            customer_id:   this.customer ? Number(this.customer.customer_id) : this.dataSearch.customer_id ? Number(this.dataSearch.customer_id) : '',
            customer_name: '',
            date_selected:  '',

            DataLists:     [],

            isLoading:     false,

            disabledDateTo: this.date_selected ? this.date_selected : null,

            test: '',
            // customer: this.customer ? this.customer : '',
            checkCustomer: this.customer ? true : false,

            currentDate: '',

            customer_type:       this.dataSearch.customer_type       ? this.dataSearch.customer_type       : '',
            weekly_delivery_day: this.dataSearch.weekly_delivery_day ? this.dataSearch.weekly_delivery_day : '',

            check_search: this.dataSearch.check_search ? true : false,
            credit_group_code: this.dataSearch.credit_group_code ? this.dataSearch.credit_group_code : '',
        }
    },
    mounted() {
        if (this.check_search) {
            if (this.dataSearch.date_selected) {
                this.date_selected = this.dataSearch.date_selected;
                this.showDate();
            }
        } else {
            this.date_selected = new Date();
            this.showDate();
        }
        
    },
    methods: {
        async showDate() {
            // if (this.date_selected) {
                var date1 = await helperDate.parseToDateTh(this.date_selected, 'yyyy/MM/DD');
                this.date_selected = date1;
            // }

            console.log('date1 <--> ' + date1);

            console.log('this.date_selected <--> ' + this.date_selected);
        },
        async getCustomerName(){
            
            this.customer_name = '';

            this.selectedData = this.customers.find( i => {
                return i.customer_id == this.customer_id;
            });

            if (this.selectedData) {
                this.customer_name = this.selectedData.customer_name;
            }
        },

        async getData(){
            this.isLoading = true;

            await axios.get("/om/outstanding-list", {
                params: {
                    customer_id:   this.customer_id,
                    date_selected: this.date_selected,
                }
            })
            .then(res => {
                this.DataLists = res.data;
                this.isLoading = false;
            });

        },
        getYear(value) {
            // console.log('order_date <---> ' + value.order_date);
            // console.log('outstanding_debt <---> ' + value.outstanding_debt);

            // this.isLoading = true;

            var momentDate = moment(value.order_date).format("YYYY-MM-DD");
            var date       = momentDate.split("-");

            var Calyear       = '';

            axios.get("/om/outstanding-year", {
                params: {
                    year: date[0],
                }
            })
            .then(res => {
                console.log('test diff from controller <---> ' + res.data);

                Calyear = res.data;

                console.log('Calyear <---> ' + Calyear);
                return Calyear;

                // this.isLoading = false;

                // return year;
            });

            

        },
        fromDateWasSelected(date) {
            // console.log('date -----> ' + date);
            // change disabled_date_to of to_date = from_date
            this.disabledDateTo = moment(date).format("DD/MM/YYYY");
            this.date_selected = date;
        },

        formatPrice(value) {
            let val = (value/1).toFixed(2)
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },

        // async formatHelperDate(value) {

        //     this.currentDate = await helperDate.parseToDateTh(value, 'YYYY-MM-DD');
        //     // console.log('value <---> ' + value);
        //     // console.log('currentDate <---> ' + currentDate);

        //     // var val = moment(currentDate).format("DD/MM/YYYY");

        //     // console.log('val <---> ' + val);
        //     // return this.currentDate;
        // },

        formatDate(value) {
            if (value) {
                return moment(value).format("DD/MM/YYYY");
            }


            // console.log('parseToDateTh <---> ' + helperDate.parseToDateTh(value, 'DD/MM/YYYY'));

            // var date = this.formatHelperDate(value);
            
            // console.log('formatHelperDate <---> ' + this.formatHelperDate(value));

            // console.log('currentDate <---> ' + moment(this.currentDate).format("DD/MM/YYYY"));

            
        },

        fine(value) {

           var outstanding_debt = value;

           var cal = outstanding_debt * 15 / 100;

           var total = cal / 365;

           return total.toFixed(2);
        },

    },
    
}
</script>