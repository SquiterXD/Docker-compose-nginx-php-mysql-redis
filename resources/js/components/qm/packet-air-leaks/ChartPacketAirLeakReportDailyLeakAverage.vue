<template>

    <div>

        <div class="text-right tw-mb-4">
            <button type="button" class="btn btn-sm btn-primary" @click="exportPdf">
                <i class="fa fa fa-file-pdf-o tw-mr-1"></i> Export PDF
            </button>
        </div>

        <div id="finished_product_report_chart_summary_content">

            <div id="report_daily_leak_average" class="row tw-py-2" style="min-width: 1200px; max-width: 1400px; justify-content: center; margin: auto;">

                <div class="col-md-5">

                    <div class="">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="30%" class="text-left"> วัน เดือน ปี </th>
                                    <th width="70%" class="text-right"> อัตรารั่ว (ml/Min) </th>
                                </tr>
                            </thead>
                            <tbody v-if="reportByDateItems.length > 0">
                                <template v-for="(reportByDateItem, index) in reportByDateItems">
                                    <tr :key="index" clsss="">
                                        <td class="text-left"> {{ reportByDateItem.thai_date }} </td>
                                        <td class="text-right" v-bind:style="{ backgroundColor: reportByDateItem.average_result_status == 'FAILED' ? '#FFAAAA' : '' }"> {{ reportByDateItem.average_result_value }} </td>
                                    </tr>
                                </template>
                                <tr>
                                    <td class="text-left tw-font-bold"> รวมทั้งหมด </td>
                                    <td class="text-right tw-font-bold"> {{ summarizedReportItem.average_result_value }} </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="2">
                                        <h2 class="p-5 text-center text-muted"> ไม่พบข้อมูล </h2>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="col-md-7">

                    <div>

                        <!-- LINE CHART -->

                        <div style="width: 740px; height: 340px; margin: auto;">
                            <line-chart
                                :chart-data="chartByDateData"
                                :width="720"
                                :height="300"
                                :min-line-at="0"
                                :max-line-at="summarizedReportItem.max_value"
                                min-line-color="#fdfdfd"
                                max-line-color="#ff5e57"
                                :y-axes-tick-max="yAxesTickMax"
                            ></line-chart>
                        </div>

                    </div>

                    <div>

                        <!-- PIE CHART -->

                        <div style="width: 740px; height: 340px; margin: auto;">
                            <doughnut-chart
                                :chart-data="chartByPositionData"
                                :options="chartByPositionOptions"
                                :width="720"
                                :height="300"
                            ></doughnut-chart>
                        </div>

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
import LineChart from "../LineChart.js";
import DoughnutChart from "../DoughnutChart.js";
import 'chartjs-plugin-datalabels'

export default {

    props: [ 
        "sampleDateFrom",
        "sampleDateTo",
        "reportItems",
        "reportByDateItems",
        "reportByPositionItems",
        "summarizedReportItem",
    ],
    components: { LineChart, DoughnutChart, Loading },
    data() {
        return {

            yAxesTickMax: this.summarizedReportItem.max_average_result_value > 300 ? this.summarizedReportItem.max_average_result_value : 300,
            chartByDateData: this.fillReportByDateData(this.reportByDateItems),
            chartByPositionData: this.fillReportByPositionData(this.reportByPositionItems),
            chartByPositionOptions: {
                plugins: {
                    datalabels: {
                        color: "black",
                        display: true,
                        formatter: (value, ctx) => {
                            return value + " %";
                        },
                        font: { weight: "bold", size: "12" },
                        labels: {
                            value: {
                                color: 'black'
                            }
                        }
                    }
                },
            },
            isLoading: false

        };
    },
    methods: {

        genChartByDateData(items) {

            const result = {
                "labels": items.map(item => item.thai_date),
                "average_result_value": items.map(item => (item.average_result_value ? parseFloat(item.average_result_value) : 0))
            };

            return result;

        },

        fillReportByDateData(items) {

            const chartByDateData = this.genChartByDateData(items);
            return {
                labels: chartByDateData.labels,
                datasets: [
                    {
                        type: 'line',
                        label: "อัตรารั่ว (ml/Min)",
                        borderColor: "#5d6dff",
                        backgroundColor: "#5d6dff",
                        fill: false,
                        data: chartByDateData.average_result_value
                    },
                ]
            };
        },

        genChartByPositionData(items) {

            const result = {
                "labels": items.map(item => item.position_label),
                "total_count": items.map(item => (item.total_count ? parseFloat(item.total_count) : 0)),
                "percent_total_count": items.map(item => (item.percent_total_count ? parseFloat(item.percent_total_count).toFixed(2) : 0))
            };

            return result;

        },

        fillReportByPositionData(items) {

            const chartByPositionData = this.genChartByPositionData(items);
            return {
                labels: chartByPositionData.labels,
                datasets: [
                    {
                        label: "อัตรารั่ว (ml/Min)",
                        backgroundColor: ["#66FFAA", "#FF9971", "#44A8FF", "#8D9DFF"],
                        data: chartByPositionData.percent_total_count
                    },
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

            const imgData = await html2canvas(document.querySelector(`#report_daily_leak_average`), {
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

            await axios.post(`/qm/ajax/packet-air-leaks/export-pdf/report-daily-leak-average`, reqData)
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
                    window.open(`/pm/files/download/qm/packet-air-leaks/report-daily-leak-average/pdf/${resData.file_name}`, '_blank');
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
