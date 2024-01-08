
<script>

import moment from "moment";

export default {
    props: ['customers', 'invoices', 'customerSearch', 'dueDateSearch', 'invoiceNoSearch', 'fineFlagSearch', 'totalFineDueSearch', 'invoiceDateSearch'],

    data() {
        return {
            total_fine_due:      '',
            due_date:            this.dueDateSearch     ? this.dueDateSearch          : '',
            fine_flag:           this.fineFlagSearch    ? this.fineFlagSearch == 'Y'  ? true : false : true,
            invoice_no:          this.invoiceNoSearch   ? this.invoiceNoSearch        : '',
            invoice_date:        this.invoiceDateSearch ? this.invoiceDateSearch      : '',
            customer_id:         this.customerSearch    ? Number(this.customerSearch) : '',
            province_name:       '',
            cancel_flag:         '',

            checkCustomer:       this.customer ? true : false,
            invoiceDateDisabled: false,

            // fine_flag: true,

            lists: [],
            invoiceLists:  this.invoices,
            customerLists: this.customers,
        }
    },

    mounted() {
        // if (this.due_date) {
        //     this.due_date = this.showDate(this.due_date);
        // }

        // if (this.totalFineDueSearch) {
        //     console.log('Date Search');
        //     this.total_fine_due = this.showDate(this.totalFineDueSearch);
        // } else {
        //     console.log('Date');
        //     this.total_fine_due = this.showDate(new Date());
        // }   
        
        this.showDate();

        if (this.customer_id) {
            this.getCustomerDetail();
        }

        if (this.invoice_no) {
            this.getInvoiceDetail();
        }
    },

    methods: {
        sortArrays(arrays) {
            return _.orderBy(arrays, 'invoice_no', 'asc');
        },
        async showDate() {
            // console.log('showDate <---> ' + date);
            // let data = await helperDate.parseToDateTh(date, 'yyyy-MM-DD');

            // console.log('data <---> ' + data);

            // return data;
            if (this.due_date) {
                var date1 = await helperDate.parseToDateTh(this.due_date, 'yyyy/MM/DD');
                this.due_date = date1;
            }
            
            if (this.totalFineDueSearch) {
                let date = await helperDate.parseToDateTh(this.totalFineDueSearch, 'yyyy/MM/DD');
                this.total_fine_due = date;
            } else {
                let date = await helperDate.parseToDateTh(new Date(), 'yyyy/MM/DD');
                this.total_fine_due = date;
            }

            if (this.invoice_date) {
                var date1 = await helperDate.parseToDateTh(this.invoice_date, 'yyyy/MM/DD');
                this.invoice_date = date1;
            }
            
        },
        async getCustomerDetail(){
            
            this.province_name = '';

            this.selectedData = this.customerLists.find( i => {
                return i.customer_id == this.customer_id;
            });

            if (this.selectedData) {
                this.province_name = this.selectedData.province_name;
            }
        },

        async getInvoiceDetail(){
            console.log('getInvoiceDetail <-> ', this.invoice_no);
            if (this.invoice_no) {
                this.invoiceDateDisabled = true;

                this.selectedData = this.invoiceLists.find( data => {
                    return data.invoice_no == this.invoice_no;
                });

                if (this.selectedData) {
                    if (this.selectedData.invoice_date) {
                        let pick_date = await helperDate.parseToDateTh(this.selectedData.invoice_date, 'yyyy/MM/DD');
                        this.invoice_date = pick_date;
                    }
                }
            } else {
                this.invoiceDateDisabled = false;
                this.invoice_date = '';
            }

        },

        async onShowDetailClicked(){
            console.log('คำนวณค่าปรับ');

            this.lists = [],

            axios.get("/om/ajax/get-fine-list", {
                params: {
                    total_fine_due:  this.total_fine_due,
                    due_date:        this.due_date,
                    fine_flag:       this.fine_flag,
                    invoice_no:      this.invoice_no,
                    invoice_date:    this.invoice_date,
                    customer_id:     this.customer_id,
                }
            })
            .then(res => {
                this.lists = res.data;
            });
        },

        async getInvoiceList(query){
            // console.log('getInvoiceList');

            this.invoiceLists = [];

            axios.get("/om/ajax/get-invoice-list", {
                params: {
                    query:  query,
                }
            })
            .then(res => {
                this.invoiceLists = res.data;
            });
        },
        async getCustomerList(query){
            console.log('getCustomerList');

            this.customerLists = [];

            axios.get("/om/ajax/get-customer-list", {
                params: {
                    query:  query,
                }
            })
            .then(res => {
                this.customerLists = res.data;
            });
        },
    },
}
</script>