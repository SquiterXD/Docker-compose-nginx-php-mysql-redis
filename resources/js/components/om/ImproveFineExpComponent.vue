<script>
export default {
    props: ['customers', 'customer', 'invoices', 'orderNumbers', 'saNumbers', 'piNumbers', 'dataSearch'],
    data() {
        return {
            total_fine_due: '',
            order_number:   this.dataSearch ? this.dataSearch.order_number         : '',
            sa_number:      this.dataSearch ? this.dataSearch.sa_number            : '',
            due_date:       this.dataSearch ? this.dataSearch.due_date             : '',
            pi_number:      this.dataSearch ? this.dataSearch.pi_number            : '',
            fine_flag:      this.dataSearch ? this.dataSearch.fine_flag            : '',
            invoice_no:     this.dataSearch ? this.dataSearch.invoice_no           : '',
            customer_id:    this.dataSearch ? this.dataSearch.customer_id          ? Number(this.dataSearch.customer_id) : '' : '',
            country_name:   '',

            checkCustomer:  this.customer ? true : false,
            check_search:   true,

            saNumberList:    [],
            orderNumberList: [],
        }
    },
    mounted() {

        this.total_fine_due = new Date();

        if (this.customer_id) {
            this.selectedData = this.customers.find( i => {
                return i.customer_id == this.customer_id;
            });

            if (this.selectedData) {
                // ประเทศ
                this.country_name = this.selectedData.country_name;
            }
        }

    },
    methods: {
        sortArrays(arrays) {
            return _.orderBy(arrays, 'value', 'asc');
        },
        
        async getDataFilter(){
            this.saNumberList = [];
            this.orderNumberList = [];

            if (this.customer_id) {
                this.selectedData = this.customers.find( i => {
                    return i.customer_id == this.customer_id;
                });

                let saFilter = this.saNumbers.filter(data => {
                    return data.customer_number == this.selectedData.customer_number;
                });
                this.saNumberList = saFilter;

                let orderFilter = this.orderNumbers.filter(data => {
                    return data.customer_number == this.selectedData.customer_number;
                });
                this.orderNumberList = orderFilter;
            }
            
        },
        async getCustomerDetail(){
            
            this.country_name = '';
            this.invoice_no   = '';
            this.order_number = '',
            this.sa_number    = '',
            this.pi_number    = '',

            this.selectedData = this.customers.find( i => {
                return i.customer_id == this.customer_id;
            });

            if (this.selectedData) {
                // ประเทศ
                this.country_name = this.selectedData.country_name;

                // // เลข invoice
                // this.selectedInvoice = this.invoices.find( data => {
                //     return data.customer_number == this.selectedData.customer_number;
                // });
                // if (this.selectedInvoice) {
                //     this.invoice_no = this.selectedInvoice.value;
                // }

                // // เลขที่ใบสั่งซื้อ
                // this.selectedOrderNumber = this.orderNumbers.find( data => {
                //     return data.customer_number == this.selectedData.customer_number;
                // });
                // if (this.selectedOrderNumber) {
                //     this.order_number = this.selectedOrderNumber.value;
                // }

                // // เลขที่ใบ SA
                // this.selecteSA = this.saNumbers.find( data => {
                //     return data.customer_number == this.selectedData.customer_number;
                // });
                // if (this.selecteSA) {
                //     this.sa_number = this.selecteSA.value;
                // }

                // // เลขที่ใบ PI
                // this.selectePI = this.piNumbers.find( data => {
                //     return data.customer_number == this.selectedData.customer_number;
                // });
                // if (this.selectePI) {
                //     this.pi_number = this.selectePI.value;
                // }
            }
        },
        
    },
}
</script>