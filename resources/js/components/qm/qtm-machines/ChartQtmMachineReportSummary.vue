<template>

    <div>

        <div class="text-right tw-mb-4">
            <button type="button" class="btn btn-sm btn-primary" @click="exportPdf">
                <i class="fa fa fa-file-pdf-o tw-mr-1"></i> Export PDF
            </button>
        </div>

        <div id="qtm_machine_report_summary_content" style="padding: 10px 40px 40px; width: 1300px; justify-content: center; margin: auto;">

            <hr>
            <div class="row tw-py-2">
                <div class="col-md-4">
                    <h3 class="text-right"> Record count </h3>
                    <h2 class="text-right"> {{ recordCount }} </h2>
                </div>
            </div>

            <hr>
            <div id="report_summary_cigatette_weight" class="row tw-py-2">
                <div class="col-md-4">
                    <h3> ค่ามาตรฐานของน้ำหนักบุหรี่ <small>(คิดจากบุหรี่ 1 มวน)</small> </h3>
                    <h3>
                        = {{ minWeight }} - {{ maxWeight }} g
                    </h3>
                    <div class="tw-flex tw-flex-row tw-w-full tw-my-4">
                        <div class="tw-flex tw-w-2/12 tw-flex-col">
                            <div class="tw-p-2 tw-flex-1 tw-text-xs">ค่าสูงสุด</div>
                            <div class="tw-p-2 tw-flex-1 tw-text-xs">ค่าต่ำสุด</div>
                        </div>
                        <div class="tw-flex tw-w-3/12 tw-flex-col">
                            <div
                                class="tw-p-2 tw-border tw-border-gray-200 tw-border-solid text-center"
                            >
                                {{ maxSummaryWeight ? maxSummaryWeight.toFixed(4) : "-" }}
                            </div>
                            <div
                                class="tw-p-2 tw-border tw-border-gray-200 tw-border-solid text-center"
                            >
                                {{ minSummaryWeight ? minSummaryWeight.toFixed(4) : "-" }}
                            </div>
                        </div>
                        <div
                            class="tw-flex tw-w-7/12 tw-flex-row tw-border tw-border-gray-200 tw-border-solid tw-pt-2"
                        >
                            <div
                                class="tw-p-2 tw-w-4/12 text-center tw-leading-10"
                                style=""
                            >
                                ค่าเฉลี่ย
                            </div>
                            <div class="tw-flex tw-flex-col tw-w-8/12">
                                <div
                                    class="tw-px-2 tw-pt-1 tw-pb-0 tw-text-xs tw-text-gray-400"
                                >
                                    น้ำหนักบุหรี่ (g)
                                </div>
                                <div class="tw-px-2 tw-text-lg"> {{ avgSummaryWeight ? avgSummaryWeight.toFixed(4) : "-" }} </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="small">
                        <line-chart
                            :chart-data="chartDataWeight"
                            :width="680"
                            :height="400"
                            :show-data-label="true"
                            :min-line-at="minWeight"
                            :max-line-at="maxWeight"
                            :y-axes-tick-min="minSummaryWeight"
                            :y-axes-tick-max="maxSummaryWeight"
                        ></line-chart>
                    </div>
                </div>
            </div>

            <hr>
            <div id="report_summary_cigatette_sizel" class="row tw-py-2">
                <div class="col-md-4">
                    <h3> ค่ามาตรฐานเส้นรอบวง </h3>
                    <h3> = {{ minSizel }} - {{ maxSizel }} mm </h3>
                    <div class="tw-flex tw-flex-row tw-w-full tw-my-4">
                        <div class="tw-flex tw-w-2/12 tw-flex-col">
                            <div class="tw-p-2 tw-flex-1 tw-text-xs">ค่าสูงสุด</div>
                            <div class="tw-p-2 tw-flex-1 tw-text-xs">ค่าต่ำสุด</div>
                        </div>
                        <div class="tw-flex tw-w-3/12 tw-flex-col">
                            <div
                                class="tw-p-2 tw-border tw-border-gray-200 tw-border-solid text-center"
                            >
                                {{ maxSummarySizel ? maxSummarySizel.toFixed(2) : "-" }}
                            </div>
                            <div
                                class="tw-p-2 tw-border tw-border-gray-200 tw-border-solid text-center"
                            >
                                {{ minSummarySizel ? minSummarySizel.toFixed(2) : "-" }}
                            </div>
                        </div>
                        <div
                            class="tw-flex tw-w-7/12 tw-flex-row tw-border tw-border-gray-200 tw-border-solid tw-pt-2"
                        >
                            <div
                                class="tw-p-2 tw-w-4/12 text-center tw-leading-10"
                                style=""
                            >
                                ค่าเฉลี่ย
                            </div>
                            <div class="tw-flex tw-flex-col tw-w-8/12">
                                <div
                                    class="tw-px-2 tw-pt-1 tw-pb-0 tw-text-xs tw-text-gray-400"
                                >
                                    เส้นรอบวงบุหรี่ (mm)
                                </div>
                                <div class="tw-px-2 tw-text-lg"> {{ avgSummarySizel ? avgSummarySizel.toFixed(2) : "-" }} </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="small">
                        <line-chart
                            :chart-data="chartDataSizel"
                            :width="680"
                            :height="400"
                            :show-data-label="true"
                            :min-line-at="minSizel"
                            :max-line-at="maxSizel"
                            :y-axes-tick-min="minSummarySizel"
                            :y-axes-tick-max="maxSummarySizel"
                        ></line-chart>
                    </div>
                </div>
            </div>

            <hr>
            <div id="report_summary_pd_open" class="row tw-py-2">
                <div class="col-md-4">
                    <h3> ค่ามาตรฐานของ PD Open </h3>
                    <h3> = {{ minPdOpen }} - {{ maxPdOpen }} mmWg </h3>
                    <div class="tw-flex tw-flex-row tw-w-full tw-my-4">
                        <div class="tw-flex tw-w-2/12 tw-flex-col">
                            <div class="tw-p-2 tw-flex-1 tw-text-xs">ค่าสูงสุด</div>
                            <div class="tw-p-2 tw-flex-1 tw-text-xs">ค่าต่ำสุด</div>
                        </div>
                        <div class="tw-flex tw-w-3/12 tw-flex-col">
                            <div
                                class="tw-p-2 tw-border tw-border-gray-200 tw-border-solid text-center"
                            >
                                {{ maxSummaryPdOpen ? maxSummaryPdOpen.toFixed(2) : "-" }}
                            </div>
                            <div
                                class="tw-p-2 tw-border tw-border-gray-200 tw-border-solid text-center"
                            >
                                {{ minSummaryPdOpen ? minSummaryPdOpen.toFixed(2) : "-" }}
                            </div>
                        </div>
                        <div
                            class="tw-flex tw-w-7/12 tw-flex-row tw-border tw-border-gray-200 tw-border-solid tw-pt-2"
                        >
                            <div
                                class="tw-p-2 tw-w-4/12 text-center tw-leading-10"
                                style=""
                            >
                                ค่าเฉลี่ย
                            </div>
                            <div class="tw-flex tw-flex-col tw-w-8/12">
                                <div
                                    class="tw-px-2 tw-pt-1 tw-pb-0 tw-text-xs tw-text-gray-400"
                                >
                                    PD Open (mmWg)
                                </div>
                                <div class="tw-px-2 tw-text-lg"> {{ avgSummaryPdOpen ? avgSummaryPdOpen.toFixed(2) : "-" }} </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="small">
                        <line-chart
                            :chart-data="chartDataPdOpen"
                            :width="680"
                            :height="400"
                            :show-data-label="true"
                            :min-line-at="minPdOpen"
                            :max-line-at="maxPdOpen"
                            :y-axes-tick-min="minSummaryPdOpen"
                            :y-axes-tick-max="maxSummaryPdOpen"
                        ></line-chart>
                    </div>
                </div>
            </div>

            <hr>
            <div id="report_summary_tip_vent" class="row tw-py-2">
                <div class="col-md-4">
                    <h3> ค่ามาตรฐานของ Tip Vent </h3>
                    <h3> = {{ minTipVent }} - {{ maxTipVent }} % </h3>
                    <div class="tw-flex tw-flex-row tw-w-full tw-my-4">
                        <div class="tw-flex tw-w-2/12 tw-flex-col">
                            <div class="tw-p-2 tw-flex-1 tw-text-xs">ค่าสูงสุด</div>
                            <div class="tw-p-2 tw-flex-1 tw-text-xs">ค่าต่ำสุด</div>
                        </div>
                        <div class="tw-flex tw-w-3/12 tw-flex-col">
                            <div
                                class="tw-p-2 tw-border tw-border-gray-200 tw-border-solid text-center"
                            >
                                {{ maxSummaryTipVent ? maxSummaryTipVent.toFixed(2) : "-" }}   
                            </div>
                            <div
                                class="tw-p-2 tw-border tw-border-gray-200 tw-border-solid text-center"
                            >
                                {{ minSummaryTipVent ? minSummaryTipVent.toFixed(2) : "-" }}
                            </div>
                        </div>
                        <div
                            class="tw-flex tw-w-7/12 tw-flex-row tw-border tw-border-gray-200 tw-border-solid tw-pt-2"
                        >
                            <div
                                class="tw-p-2 tw-w-4/12 text-center tw-leading-10"
                                style=""
                            >
                                ค่าเฉลี่ย
                            </div>
                            <div class="tw-flex tw-flex-col tw-w-8/12">
                                <div
                                    class="tw-px-2 tw-pt-1 tw-pb-0 tw-text-xs tw-text-gray-400"
                                >
                                    Tip Vent (%)
                                </div>
                                <div class="tw-px-2 tw-text-lg"> {{ avgSummaryTipVent ? avgSummaryTipVent.toFixed(2) : "-" }} </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="small">
                        <line-chart
                            :chart-data="chartDataTipVent"
                            :width="680"
                            :height="400"
                            :show-data-label="true"
                            :min-line-at="minTipVent"
                            :max-line-at="maxTipVent"
                            :y-axes-tick-min="minSummaryTipVent"
                            :y-axes-tick-max="maxSummaryTipVent"
                        ></line-chart>
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

export default {

    props: [ 
        "sampleDateFrom",
        "sampleDateTo",
        "recordCount",
        "dataWeightDetails",
        "dataWeightSummary",
        "dataSizelDetails",
        "dataSizelSummary",
        "dataPdOpenDetails",
        "dataPdOpenSummary",
        "dataTipVentDetails",
        "dataTipVentSummary",
    ],
    components: { LineChart, Loading },
    data() {
        return {

            chartDataWeight: this.fillWeight(this.dataWeightDetails),
            minWeight: this.dataWeightSummary ? parseFloat(this.dataWeightSummary.min_value) : null,
            maxWeight: this.dataWeightSummary ? parseFloat(this.dataWeightSummary.max_value) : null,
            minSummaryWeight: this.dataWeightSummary ? parseFloat(this.dataWeightSummary.min_summary_result_value) : null,
            maxSummaryWeight: this.dataWeightSummary ? parseFloat(this.dataWeightSummary.max_summary_result_value) : null,
            avgSummaryWeight: this.dataWeightSummary ? parseFloat(this.dataWeightSummary.avg_summary_result_value) : null,

            chartDataSizel: this.fillSizel(this.dataSizelDetails),
            minSizel: this.dataSizelSummary ? parseFloat(this.dataSizelSummary.min_value) : null,
            maxSizel: this.dataSizelSummary ? parseFloat(this.dataSizelSummary.max_value) : null,
            minSummarySizel: this.dataSizelSummary ? parseFloat(this.dataSizelSummary.min_summary_result_value) : null,
            maxSummarySizel: this.dataSizelSummary ? parseFloat(this.dataSizelSummary.max_summary_result_value) : null,
            avgSummarySizel: this.dataSizelSummary ? parseFloat(this.dataSizelSummary.avg_summary_result_value) : null,

            chartDataPdOpen: this.fillPdOpen(this.dataPdOpenDetails),
            minPdOpen: this.dataPdOpenSummary ? parseFloat(this.dataPdOpenSummary.min_value) : null,
            maxPdOpen: this.dataPdOpenSummary ? parseFloat(this.dataPdOpenSummary.max_value) : null,
            minSummaryPdOpen: this.dataPdOpenSummary ? parseFloat(this.dataPdOpenSummary.min_summary_result_value) : null,
            maxSummaryPdOpen: this.dataPdOpenSummary ? parseFloat(this.dataPdOpenSummary.max_summary_result_value) : null,
            avgSummaryPdOpen: this.dataPdOpenSummary ? parseFloat(this.dataPdOpenSummary.avg_summary_result_value) : null,

            chartDataTipVent: this.fillTipVent(this.dataTipVentDetails),
            minTipVent: this.dataTipVentSummary ? parseFloat(this.dataTipVentSummary.min_value) : null,
            maxTipVent: this.dataTipVentSummary ? parseFloat(this.dataTipVentSummary.max_value) : null,
            minSummaryTipVent: this.dataTipVentSummary ? parseFloat(this.dataTipVentSummary.min_summary_result_value) : null,
            maxSummaryTipVent: this.dataTipVentSummary ? parseFloat(this.dataTipVentSummary.max_summary_result_value) : null,
            avgSummaryTipVent: this.dataTipVentSummary ? parseFloat(this.dataTipVentSummary.avg_summary_result_value) : null,

            isLoading: false

        };
    },
    methods: {

        genChartData(items, type) {

            const sortedItems = items.sort((a, b) => {
                return parseInt(a.machine_set) - parseInt(b.machine_set);
            });
            
            let result = {
                "labels": sortedItems.map(item => item.maker),
                "data": sortedItems.map(item => (item.avg_result_value ? parseFloat(item.avg_result_value).toFixed(2) : null))
            };

            if(type == "WEIGHT") {
                result = {
                    "labels": sortedItems.map(item => item.maker),
                    "data": sortedItems.map(item => (item.avg_result_value ? parseFloat(item.avg_result_value).toFixed(4) : null))
                };
            }

            return result;

        },

        fillWeight(items) {

            const chartData = this.genChartData(items, "WEIGHT");
            return {
                labels: chartData.labels,
                datasets: [
                    {
                        label: "น้ำหนักบุหรี่ (g)",
                        borderColor: "#1879f9",
                        backgroundColor: "#1879f9",
                        fill: false,
                        data: chartData.data
                    }
                ]
            };
        },

        fillSizel(items) {

            const chartData = this.genChartData(items, "SIZEL");
            return {
                labels: chartData.labels,
                datasets: [
                    {
                        label: "เส้นรอบวงบุหรี่ (mm)",
                        borderColor: "#8e44ad",
                        backgroundColor: "#8e44ad",
                        fill: false,
                        data: chartData.data
                    }
                ]
            };
        },

        fillPdOpen(items) {

            const chartData = this.genChartData(items, "PD_OPEN");
            return {
                labels: chartData.labels,
                datasets: [
                    {
                        label: "PD Open (mmWg)",
                        borderColor: "#FC427B",
                        backgroundColor: "#FC427B",
                        fill: false,
                        data: chartData.data
                    }
                ]
            };
        },

        fillTipVent(items) {

            const chartData = this.genChartData(items, "TIP_VENT");
            return {
                labels: chartData.labels,
                datasets: [
                    {
                        label: "Tip Vent (%)",
                        borderColor: "#0c3481",
                        backgroundColor: "#0c3481",
                        fill: false,
                        data: chartData.data
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

            const imgDataWeight = await html2canvas(document.querySelector(`#report_summary_cigatette_weight`), {
                imageTimeout: 5000, 
                useCORS: true
            }).then(canvasData => {
                const imgData = canvasData.toDataURL('image/png');
                return imgData;
            });
            const imgDataSizel = await html2canvas(document.querySelector(`#report_summary_cigatette_sizel`), {
                imageTimeout: 5000, 
                useCORS: true
            }).then(canvasData => {
                const imgData = canvasData.toDataURL('image/png');
                return imgData;
            });
            const imgDataPdOpen = await html2canvas(document.querySelector(`#report_summary_pd_open`), {
                imageTimeout: 5000, 
                useCORS: true
            }).then(canvasData => {
                const imgData = canvasData.toDataURL('image/png');
                return imgData;
            });
            const imgDataTipVent = await html2canvas(document.querySelector(`#report_summary_tip_vent`), {
                imageTimeout: 5000, 
                useCORS: true
            }).then(canvasData => {
                const imgData = canvasData.toDataURL('image/png');
                return imgData;
            });

            const reqData = new FormData();
            reqData.append(`report_weight`, JSON.stringify(imgDataWeight));
            reqData.append(`report_sizel`, JSON.stringify(imgDataSizel));
            reqData.append(`report_pd_open`, JSON.stringify(imgDataPdOpen));
            reqData.append(`report_tip_vent`, JSON.stringify(imgDataTipVent));
            reqData.append(`sample_date_from`, this.sampleDateFrom);
            reqData.append(`sample_date_to`, this.sampleDateTo);

            await axios.post(`/qm/ajax/qtm-machines/export-pdf/report-summary`, reqData)
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
                    window.open(`/pm/files/download/qm/qtm-machines/report-summary/pdf/${resData.file_name}`, '_blank');
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

<style scoped>
.small {
    width: 760px;
    height: 480px;
    margin: auto;
}
</style>
