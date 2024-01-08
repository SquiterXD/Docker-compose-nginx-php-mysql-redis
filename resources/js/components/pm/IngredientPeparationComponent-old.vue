<script>

import moment from "moment";
import QrcodeVue from "qrcode.vue";

export default {
    props: [],
    data() {
        return {
            dateSelected: '',
            currentDate: '',
            isLoading: false,
            DataLists: [],
            isDetailsLoading: true,
            currentDetail: '',
            currentDetailPlanDate: '',
            currentItemNumber: '',
            currentItemDescription: '',
            detailLines: [],
            isCurrentDetailsLoading: true,
            currentDetailItemId: '',
            currentQRCode: null,

            currentPlanDate: '',

            currentItem: {
                item_id: null,
            }
        }
    },
    mounted() {
        this.dateSelected = new Date();

        this.showDate();
        // this.dateSelected = moment(String(this.dateSelected)).format('DD-MM-yyyy')

        if (this.dateSelected) {
            this.getTableData();
        }
    },
    methods: {
        async showDate() {
            if (this.dateSelected) {
                var date1 = await helperDate.parseToDateTh(this.dateSelected, 'yyyy-MM-DD');
                this.dateSelected = date1;
            }
        },

        async getTableData(){
            this.currentDate = moment(String(this.dateSelected)).format('DD-MM-yyyy');

            this.isLoading = true;
            await axios.get("/pm/ajax/ingredient-preparation-qrcode", {
                params: {
                    date_selected: this.dateSelected,
                }
            })
            .then(res => {
                this.DataLists = res.data;
                this.isLoading = false;
            });

            
        },
        
        async onShowDetailClicked(list) {
            this.isDetailsLoading = true;

            if (list.plan_date) {
                var date1 = await helperDate.parseToDateTh(list.plan_date, 'yyyy-MM-DD');
                this.currentPlanDate = moment(String(date1)).format('DD/MM/yyyy');
            }

            this.currentDetailPlanDate = moment(String(list.plan_date)).format('DD-MM-yyyy');
            // this.currentItemDesc1 = list.item_desc1;
            this.currentDetailItemId = list.inventory_item_id;
            this.currentItemNumber = list.item_number;
            this.currentItemDescription = list.description;
            // this.currentQRCode = 'sa21ff322';

            this.currentItem.item_id = this.currentDetailItemId;

            this.currentQRCode = JSON.stringify(this.currentItem);

            console.log('currentQRCode  <-----> ' + this.currentQRCode);
            console.log('json_encode  <-----> ' + JSON.stringify(this.currentQRCode));

            // test = array(['' => ]);
            // {"item_id":10937}
            // this.currentQRCode = array("Peter"=>35, "Ben"=>37, "Joe"=>43);

            this.isCurrentDetailsLoading = false;

            await axios.get("/pm/ajax/ingredient-preparation-detail", {
                params: {
                    item_id:   list.inventory_item_id,
                    org_id:    list.organization_id,
                    plan_date: list.plan_date,
                }
            })
            .then(res => {
                this.detailLines = res.data;
                this.isDetailsLoading = false;
            });

            // --------------------------------------------------------

            // this.currentDetailPlanDate = moment(String(list.plan_date)).format('DD-MM-yyyy');
            // this.currentItemDesc1 = list.item_desc1;
            // this.currentItemNumber = list.item_number;
            // this.currentItemDescription = list.description;

            // if (list) {
            //     this.currentDetail = list;
            //     this.isDetailsLoading = false;
            // }
            // this.isDetailsLoading = true;
            // console.log('list  -----> ' + list.biweekly);
        },
        async printReport(list) {
            
            // router.go('/pm/ingredient-preparation/print-pdf');

            console.log('printReport');
            // this.isDetailsLoading = true;

            this.currentDetailPlanDate = moment(String(list.plan_date)).format('DD-MM-yyyy');
            // this.currentItemDesc1 = list.item_desc1;
            this.currentDetailItemId = list.inventory_item_id;
            this.currentItemNumber = list.item_number;
            this.currentItemDescription = list.description;

            // this.isCurrentDetailsLoading = false;

            await axios.get("/pm/ingredient-preparation/print-pdf", {
                params: {
                    item_id:   list.inventory_item_id,
                    org_id:    list.organization_id,
                    plan_date: list.plan_date,
                }
            })
            .then(res => {
                this.detailLines = res.data;
                this.isDetailsLoading = false;
            });

            // --------------------------------------------------------

            // this.currentDetailPlanDate = moment(String(list.plan_date)).format('DD-MM-yyyy');
            // this.currentItemDesc1 = list.item_desc1;
            // this.currentItemNumber = list.item_number;
            // this.currentItemDescription = list.description;

            // if (list) {
            //     this.currentDetail = list;
            //     this.isDetailsLoading = false;
            // }
            // this.isDetailsLoading = true;
            // console.log('list  -----> ' + list.biweekly);
        },
        getTransactionGL(period, coa){
                // $('#modal_transaction').modal('show');
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

    },
}
</script>