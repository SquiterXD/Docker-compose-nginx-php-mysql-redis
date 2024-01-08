<script>

import moment from "moment";
import QrcodeVue from "qrcode.vue";
import {isInRange, jsDateToString, toJSDate, toThDateString} from '../../dateUtils';

export default {
    props: [],
    data() {
        return {
            toJSDate,
            jsDateToString,
            isInRange,
            toThDateString,

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
            },

            M05DataLists: [],
            hasM05Data: false,
            bM05: '',
            calM05: '',
        }
    },
    computed: {
        totalUsedQty() {
            let sum = 0;
            return this.detailLines.reduce((sum, item) => sum += Number(item.used_qty), 0);
        },
        totalMchineQty() {
            let sum = 0;
            return this.detailLines.reduce((sum, item) => sum += Number(item.machine_qty), 0);
        },
        totalMaxMachine() {
            let sum = 0;
            return this.detailLines.reduce((sum, item) => sum += Number(item.max_machine), 0);
        },
        totalRemainingQty() {
            let sum = 0;
            return this.detailLines.reduce((sum, item) => sum += Number(item.remaining_qty), 0);
        },
    },
    mounted() {
        this.dateSelected = new Date();

        // this.showDate();
        // this.dateSelected = moment(String(this.dateSelected)).format('DD-MM-yyyy')

        // if (this.dateSelected) {
        //     this.getTableData();
        // }
    },
    methods: {
        async showDate() {
            if (this.dateSelected) {
                var date1 = await helperDate.parseToDateTh(this.dateSelected, 'yyyy-MM-DD');
                this.dateSelected = date1;
            }
        },

        async getTableData(){
            this.hasM05Data = false;
            if (!this.dateSelected) {
                swal({
                    title: "มีข้อผิดพลาด",
                    text: 'กรุณาระบุวันที่ ที่ต้องการสร้างใบจัดเตรียมวัตถุดิบ',
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                });
                this.DataLists = [];
                this.M05DataLists = [];
                this.currentDate = '';
            }else{
                this.currentDate = moment(String(this.dateSelected)).format('DD-MM-yyyy');

                this.isLoading = true;
                await axios.get("/pm/ajax/ingredient-preparation-qrcode", {
                    params: {
                        date_selected: this.dateSelected,
                    }
                })
                .then(res => {
                    this.DataLists    = res.data.data.data;
                    this.M05DataLists = res.data.data.dataM05;
                    this.isLoading    = false;

                    if (this.M05DataLists.length > 0) {
                        this.hasM05Data = true;
                    }
                });
            }            
        },
        
        async onShowDetailClicked(list) {
            this.isDetailsLoading = true;
            this.bM05   = 0;
            this.calM05 = 0;

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

            // this.currentQRCode = JSON.stringify(this.currentItem);
            this.currentQRCode = list.item_number;

            console.log('currentQRCode  <-----> ' + this.currentQRCode);
            console.log('json_encode  <-----> ' + JSON.stringify(this.currentQRCode));

            // test = array(['' => ]);
            // {"item_id":10937}
            // this.currentQRCode = array("Peter"=>35, "Ben"=>37, "Joe"=>43);

            this.isCurrentDetailsLoading = false;

            // this.xxM05 = list.;

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

                this.bM05 = list.b_m05;
                this.calM05 = list.b_m05 / this.detailLines.length;
                // if (list.b_m05 > 0) {
                //     this.xxM05 = list.b_m05 / this.detailLines.length;
                // }

                // console.log('this.detailLines length<---> ' + this.detailLines.length);
                // console.log('list.b_m05 <---> ' + list.b_m05);
                // console.log('//// <---> ' + list.b_m05 / this.detailLines.length);
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
        getCurrentDate(){
            if (this.dateSelected) {
                this.currentDate = moment(String(this.dateSelected)).format('DD-MM-yyyy');
            } else {
                this.currentDate = '';
            }
        }
    },
}
</script>