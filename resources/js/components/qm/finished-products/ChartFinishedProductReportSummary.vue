<template>

    <div>

        <div class="text-right tw-mb-4">
            <button type="button" class="btn btn-sm btn-primary" @click="exportPdf">
                <i class="fa fa fa-file-pdf-o tw-mr-1"></i> Export PDF
            </button>
        </div>

        <div id="finished_product_report_chart_summary_content">

            <div id="report_summary" class="row tw-py-2" style="min-width: 1200px; max-width: 1300px; justify-content: center; margin: auto;">

                <div class="col-md-5 tw-pr-0">

                    <div class="">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="30%" class="text-center"> รายการข้อบกพร่อง </th>
                                    <th width="30%" class="text-center"> 
                                        <div> กระบวนการ </div>
                                        <div> ตรวจคุณภาพ </div> 
                                    </th>
                                    <!-- <th width="15%" class="text-right" style="max-width: 80px; white-space: nowrap; overflow: scroll; text-overflow: clip;"> จำนวนครั้งที่พบข้อบกพร่อง </th>
                                    <th width="15%" class="text-right" style="max-width: 80px; white-space: nowrap; overflow: scroll; text-overflow: clip;"> ร้อยละจำนวนข้อบกพร่อง </th> -->
                                    <th width="20%" class="text-center"> 
                                       <div> จำนวนครั้ง </div>
                                       <div> ที่พบ </div>
                                       <div> ข้อบกพร่อง </div>
                                    </th>
                                    <th width="20%" class="text-center"> 
                                       <div> ร้อยละ </div>
                                       <div> จำนวน </div>
                                       <div> ข้อบกพร่อง </div>
                                    </th>
                                    
                                </tr>
                            </thead>
                            <tbody v-if="reportQmProcessCheckLists.length > 0">
                                <template v-for="(reportQmProcessCheckList, index) in reportQmProcessCheckLists">
                                    <tr :key="index" clsss="">
                                        <td class="text-left"> {{ reportQmProcessCheckList.check_list }} </td>
                                        <td class="text-left"> {{ reportQmProcessCheckList.qm_process }} </td>
                                        <td class="text-right"> {{ reportQmProcessCheckList.total_count_result_value }} </td>
                                        <td class="text-right"> {{ reportQmProcessCheckList.percent_count_result_value ? reportQmProcessCheckList.percent_count_result_value.toFixed(2) : "0.00" }}% </td>
                                    </tr>
                                </template>
                                <tr>
                                    <td colspan="2" class="text-left tw-font-bold"> TOTAL </td>
                                    <td class="text-right tw-font-bold"> {{ reportItems.total_count_result_value }} </td>
                                    <td class="text-right tw-font-bold"> 100.00% </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="5">
                                        <h2 class="p-5 text-center text-muted"> ไม่พบข้อมูล </h2>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="col-md-7">
                    <div class="text-center">
                        <h3 class="text-center"> แผนภูมิการตรวจพบข้อบกพร่องในกระบวนการผลิตบุหรี่สำเร็จรูป </h3>
                    </div>
                    <div style="width: 720px; height: 440px; margin: auto;">
                        <bar-chart
                            :chart-data="chartData"
                            :options="chartBarOptions"
                            :styles="chartBarStyles"
                            :width="680"
                            :height="420"
                        ></bar-chart>
                    </div>
                </div>
                
            </div>

        </div>

        <div id="pdf"></div>
        
        <loading :active.sync="isLoading" :is-full-page="true"></loading>

    </div>
</template>

<script>

// Import loading-overlay component
import moment from "moment";
import Loading from "vue-loading-overlay";
import html2canvas from 'html2canvas'
import { jsPDF } from "jspdf";
import BarChart from "../BarChart.vue";

export default {

    props: [ 
        "reportItems", 
        "reportQmProcesses", 
        "reportQmProcessCheckLists",
        "sampleDateFrom",
        "sampleDateTo",
    ],
    components: { BarChart, Loading },
    data() {
        return {

            chartData: this.fillData(this.reportQmProcessCheckLists),
            chartBarOptions: {
                plugins: {
                    datalabels: {
                        color: "black",
                        display: false,
                    }
                },
                // title: {
                //     display: true,
                //     text: 'แผนภูมิการตรวจพบข้อบกพร่องในกระบวนการผลิตบุหรี่สำเร็จรูป'
                // },
                scales: {
                    yAxes: [{
                        id: 'TOTAL',
                        type: 'linear',
                        position: 'left',
                        gridLines: { color: "rgba(150, 150, 150, 0.1)" },
                        ticks: { 
                            max: Math.ceil(Math.max(...(this.reportQmProcessCheckLists.map(item => (item.total_count_result_value ? parseFloat(item.total_count_result_value) + (parseFloat(item.total_count_result_value) * 0.3) : 0))))), 
                            min: 0
                        }
                    },{
                        id: 'PERCENT',
                        type: 'linear',
                        position: 'right',
                        gridLines: { display: false },
                        ticks: { 
                            max: Math.ceil(Math.max(...(this.reportQmProcessCheckLists.map(item => (item.percent_count_result_value ? parseFloat(item.percent_count_result_value) + (parseFloat(item.percent_count_result_value) * 0.1) : 0))))), 
                            min: 0,
                            callback: function(value, index, ticks) {
                                return value + '.00%';
                            } 
                        }
                    }],
                    xAxes: [{
                        gridLines: { display: false }
                    }]
                }
            },
            chartBarStyles: {
                height: "580px",
                position: "relative"
            },
            isLoading: false

        };
    },
    methods: {

        genChartData(items) {

            const sortedItems = items.sort((a, b) => {
                return a.check_list - b.check_list;
            });

            const result = {
                "labels": sortedItems.map(item => item.check_list),
                "total_count_result_value": sortedItems.map(item => (item.total_count_result_value ? parseFloat(item.total_count_result_value) : 0)),
                "percent_count_result_value": sortedItems.map(item => (item.percent_count_result_value ? parseFloat(item.percent_count_result_value) : 0))
            };

            return result;

        },

        fillData(items) {

            const chartData = this.genChartData(items);
            return {
                labels: chartData.labels,
                datasets: [
                    {
                        type: 'line',
                        label: "ร้อยละจำนวนข้อบกพร่อง",
                        yAxisID: 'PERCENT',
                        borderColor: "#fd7e14",
                        backgroundColor: "#fd7e14",
                        fill: false,
                        data: chartData.percent_count_result_value
                    },
                    {
                        label: "จำนวนครั้งที่พบข้อบกพร่อง",
                        yAxisID: 'TOTAL',
                        borderColor: "#1879f9",
                        backgroundColor: "#1879f9",
                        fill: false,
                        data: chartData.total_count_result_value
                    }
                ]
            };
        },

        getRandomInt() {
            return Math.floor(Math.random() * (50 - 5 + 1)) + 5;
        },

        async exportPdf() {

            // SHOW LOADING
            this.isLoading = true;

            window.scrollTo(0,0);

            const imgData = await html2canvas(document.querySelector(`#report_summary`), {
                imageTimeout: 5000, 
                useCORS: true
            }).then(canvasData => {
                const imgData = canvasData.toDataURL('image/png');
                return imgData;
            });

            const reqData = new FormData();
            reqData.append(`report_img_data`, imgData);
            reqData.append(`sample_date_from`, this.sampleDateFrom);
            reqData.append(`sample_date_to`, this.sampleDateTo);

            await axios.post(`/qm/ajax/finished-products/export-pdf/report-chart-summary`, reqData)
            .then((res) => {
                const resData = res.data.data;
                const resMsg = resData.message;
                if(resData.status == "error") {
                    // HIDE LOADING
                    this.isLoading = false;
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถ export pdf | ${resMsg}`, "error");
                } else {
                    // HIDE LOADING
                    this.isLoading = false;
                    window.open(`/pm/files/download/qm/finished-products/report-chart-summary/pdf/${resData.file_name}`, '_blank');
                }
                return resData;
            })
            .catch((error) => {
                console.log(error);
            });

            // HIDE LOADING
            this.isLoading = false;

        }
    }
};
</script>

<style>
.small {
    width: 800px;
    height: 480px;
    margin: auto;
}
</style>
