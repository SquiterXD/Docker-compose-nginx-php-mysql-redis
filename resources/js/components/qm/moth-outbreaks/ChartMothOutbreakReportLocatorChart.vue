<template>

    <div>

        <div class="text-right tw-mb-4">
            <button type="button" class="btn btn-sm btn-success" @click="exportPDF">
                <i class="fa fa fa-file-pdf-o tw-mr-1"></i> Export PDF
            </button>
        </div>

        <template v-for="(reportBuildNamePerMonthChartDataItem, indexBN) in reportBuildNamePerMonthChartDataItems">

            <div :key="indexBN" class="tw-py-6">

                <h2 class="text-center"> รายงานการระบาดของมอดยาสูบ อาคาร {{ reportBuildNamePerMonthChartDataItem.build_name }} เดือน {{ reportBuildNamePerMonthChartDataItem.thai_month }}  </h2>
                <h3 class="text-center tw-mb-4"> ประจำวันที่ {{ reportBuildNamePerMonthChartDataItem.first_thai_date }} ถึงวันที่ {{ reportBuildNamePerMonthChartDataItem.last_thai_date }} </h3>

                <div :id="`report_locator_chart_${indexBN}`" style="height: 600px; width: 1200px; justify-content: center; margin: auto;">

                    <bar-chart
                        :chart-data="reportBuildNamePerMonthChartDataItem.chartBarData"
                        :options="reportBuildNamePerMonthChartDataItem.chartBarData.options"
                        :styles="chartBarStyles"
                    ></bar-chart>

                </div>

                <hr class="tw-mt-10">

            </div>

        </template>

        <!-- <div id="preview"></div> -->

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

    </div>

</template>

<script>

// Import loading-overlay component
import Loading from "vue-loading-overlay";
import html2canvas from 'html2canvas'
import BarChart from '../BarChart.vue'
import 'chartjs-plugin-datalabels'

export default {
    props: ["reportItems", "reportDates", "reportBuildNamePerMonthItems"],
    components: { Loading, BarChart },
    data() {

        return {

            isLoading: false,

            reportImageData: [],

            reportBuildNamePerMonthChartDataItems: this.reportBuildNamePerMonthItems.map(item => {
                return {
                    ...item,
                    chartBarData: {
                        labels: ["รวม"].concat(item.results.map(rlitem => rlitem.department_name)),
                        datasets: [
                            {
                                label: `อาคาร ${item.build_name} เฉลี่ย`,
                                borderColor: ["#1ce426"].concat(item.results.map(rlitem => "#1c84c6")),
                                // pointBackgroundColor: "black",
                                // borderWidth: 1,
                                // pointBorderColor: "black",
                                backgroundColor: ["#1ce426"].concat(item.results.map(rlitem => "#1c84c6")),
                                data: [item.avg_result_value].concat(item.results.map(rditem => rditem.avg_result_value)),
                                datalabels: {
                                    display: true,
                                    color: 'black'
                                },
                            },
                        ],
                        options: {

                            plugins: {
                                datalabels: {
                                    color: "black",
                                    display: true,
                                    formatter: (value, ctx) => {
                                        return value;
                                    },
                                    font: { weight: "bold", size: "12" },
                                    anchor: 'end',
                                    align: 'end',
                                    labels: {
                                        value: {
                                            color: 'black'
                                        }
                                    }
                                }
                            },

                            // Core options
                            aspectRatio: 5 / 3,
                            // layout: {
                            //     padding: {
                            //         top: 30,
                            //         right: 16,
                            //         bottom: 0,
                            //         left: 8
                            //     }
                            // },
                            title: {
                                display: true,
                                text: 'ค่าเฉลี่ยจำนวนมอดที่ดักจับได้(ตัว)'
                            },
                            responsive: true,
                            maintainAspectRatio: false,
                            // legend: {
                            //     display: true,
                            // },
                            scales: {
                                xAxes: [{
                                    display: true,
                                    ticks: { 
                                        beginAtZero: true
                                    },
                                }],
                                yAxes: [{
                                    id: "yAxis",
                                    display: true,
                                    ticks: { 
                                        beginAtZero: true,
                                        max: Math.round(item.max_avg_result_value) + Math.round(item.max_avg_result_value/5) + 1 // maximum value
                                    },
                                }],
                            }
                        },
                    }
                }
            }),
            chartBarStyles: {
                height: "580px",
                position: "relative",
            },
        };
    },

    methods: {

        async exportPDF() {

            window.scrollTo(0,0);

            // SHOW LOADING
            this.isLoading = true;

            this.reportImageData = await Promise.all(this.reportBuildNamePerMonthItems.map(async (item, index) => {

                const resImgData = await html2canvas(document.querySelector(`#report_locator_chart_${index}`), {
                    imageTimeout: 5000, 
                    useCORS: true
                }).then(canvasData => {
                    const imgData = canvasData.toDataURL('image/png');
                    return imgData;
                });

                return {
                    ...item,
                    image: resImgData
                }

            }));

            const reqData = new FormData();
            reqData.append(`report_build_name_per_month_items`, JSON.stringify(this.reportImageData));

            await axios.post(`/qm/ajax/moth-outbreaks/export-pdf/report-locator-chart`, reqData)
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
                    window.open(`/pm/files/download/qm/moth-outbreaks/report-locator-chart/pdf/${resData.file_name}`, '_blank');
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
