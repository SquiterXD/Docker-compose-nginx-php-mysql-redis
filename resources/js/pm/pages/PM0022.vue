<template>
    <div>
        <!--        <div class="form-group row">-->
        <!--                        <pre class="col-lg-6" style="display: block">{{-->
        <!--                                JSON.stringify({-->
        <!--                                    dailyRawMaterials,-->
        <!--                                }, null, 2)-->
        <!--                            }}</pre>-->

        <!--            <pre class="col-lg-6" style="display: block">{{-->
        <!--                    JSON.stringify({-->
        <!--                        reportDate, currentReport,-->
        <!--                    }, null, 2)-->
        <!--                }}</pre>-->
        <!--        </div>-->

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="text-right">
                            <button type="button" class="btn btn-w-m btn-info"><i class="fa fa-print"></i>
                                พิมพ์รายงาน
                            </button>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-lg-2 col-sm-4 col-form-label">วันที่</label>
                                    <div class="col-lg-10">
                                        <input
                                            type="date"
                                            class="form-control"
                                            v-model="reportDate"
                                            @change="onRequestDateChanged($event)">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox">
                    <div class="ibox-content">
                        <div v-if="isLoading">
                            <div class="sk-spinner sk-spinner-wave">
                                <div class="sk-rect1"></div>
                                <div class="sk-rect2"></div>
                                <div class="sk-rect3"></div>
                                <div class="sk-rect4"></div>
                                <div class="sk-rect5"></div>
                            </div>
                        </div>
                        <div
                            v-if="!isLoading"
                            class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>ลำดับที่</th>
                                    <th>พัสดุห่อมวน(Item Category)</th>
                                    <th>รหัสวัตถุดิบ</th>
                                    <th style="width: 400px;">รายละเอียด</th>
                                    <th>จำนวนต่อวัน</th>
                                    <th>จำนวนที่จ่ายไปแล้ว</th>
                                    <th>หน่วย</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <fragment v-for="dailyRawMaterial in dailyRawMaterials"
                                          :key="dailyRawMaterial.report_id">

                                    <tr>
                                        <td colspan="9">{{ dailyRawMaterial.itemGroup }}</td>
                                    </tr>
                                    <tr v-for="(report, i) in dailyRawMaterial.reports">
                                        <td>{{ (i + 1) }}</td>
                                        <td>{{ report.item_desc1 }}</td>
                                        <td>{{ report.item_code }}</td>
                                        <td>{{ report.item_desc2 }}</td>
                                        <td>{{ report.daily_qty }}</td>
                                        <td>{{ report.out_qty }}</td>
                                        <td>{{ report.uom }}</td>
                                        <td>
                                            <button
                                                type="button"
                                                class="btn btn-w-m btn-default"
                                                data-toggle="modal"
                                                data-target="#detailReportModal"
                                                @click.prevent="onShowDetailClicked(report)"
                                            >
                                                รายละเอียด
                                            </button>
                                        </td>
                                    </tr>
                                </fragment>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div
            id="detailReportModal"
            ref="detailReportModalRef"
            class="modal bd-example-modal-xl fade">
            <div
                class="modal-dialog modal-lg"
                role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-9 col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-sm-4 col-form-label">วันที่</label>
                                        <div class="col-lg-4">
                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="reportDate"
                                                disabled="disabled"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right col-lg-3">
                                    <button type="button" class="btn btn-w-m btn-info"><i
                                        class="fa fa-print"></i>
                                        พิมพ์รายงาน
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <div class="form-group row">
                                        <label class="col-lg-6 col-sm-4 col-form-label">รายการพัสดุ</label>
                                        <div class="col-lg-6">
                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="currentItemDesc1"
                                                disabled="disabled"/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-lg-6">
                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="currentItemCode"
                                                disabled="disabled"/>
                                        </div>
                                        <div class="col-lg-6">
                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="currentItemDesc2"
                                                disabled="disabled"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12">
                                    <div class="col-lg-4 ml-auto">
                                        <qrcode-vue v-model="currentQRCode" :size="100" level="H"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="isReportDetailsLoading">
                            <div class="sk-spinner sk-spinner-wave">
                                <div class="sk-rect1"></div>
                                <div class="sk-rect2"></div>
                                <div class="sk-rect3"></div>
                                <div class="sk-rect4"></div>
                                <div class="sk-rect5"></div>
                            </div>
                        </div>
                        <table
                            v-if="!isReportDetailsLoading"
                            class="table table-bordered">
                            <thead>
                            <tr>
                                <th>เครื่องจักร</th>
                                <th>ปริมาณที่ต้องใช้ตั้งต้น</th>
                                <th>คงคลังหน้าเครื่องเช้า</th>
                                <th>ปริมาณที่ต้องใช้</th>
                                <th>จ่ายไปแล้ว</th>
                                <th>วางหน้าเครื่องสูงสุด</th>
                                <th>ปริมาณที่สามารถเบิกได้</th>
                                <th>หน่วยนับ</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(reportDetail) in reportDetails">
                                <td>{{ reportDetail.machine_name }}</td>
                                <td>{{ reportDetail.origin_qty }}</td>
                                <td>{{ reportDetail.start_qty }}</td>
                                <td>{{ reportDetail.used_qty }}</td>
                                <td>{{ reportDetail.paid_qty }}</td>
                                <td>{{ reportDetail.machine_qty }}</td>
                                <td>{{ reportDetail.req_qty }}</td>
                                <td>{{ currentReport.uom }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
import {instance as http} from "../httpClient";
import axios, {CancelToken} from 'axios';
import _cloneDeep from "lodash/cloneDeep";
import _isNil from "lodash/isNil";
import {
    $route,
    api_pm_ingredientPreparationList_index, api_pm_ingredientPreparationList_reports
} from "../../router";

function getDailyReports(date) {
    console.debug('getDailyReports');
    return http.get($route(api_pm_ingredientPreparationList_index),
        {
            params: {
                'date': date,
            },
        },
    )
}

function getDailyReportDetails(reportId, token) {
    console.debug('getDailyReportDetails');

    return http.get($route(api_pm_ingredientPreparationList_reports, {
            id: reportId,
        }),
        {
            cancelToken: token
        });
}

export default {
    data() {
        return {
            lodash: {
                cloneDeep: _cloneDeep,
                isNil: _isNil,
            },
            dailyRawMaterials: _cloneDeep(this.daily_raw_materials),
            reportDate: this.date,
            isLoading: false,
            isReportDetailsLoading: false,
            currentReport: null,
            reportDetails: null,
            currentRequestSource: null,
            currentItemDesc1: null,
            currentItemCode: null,
            currentItemDesc2: null,
            currentQRCode: null,
        }
    },
    props: {
        daily_raw_materials: {
            type: Array,
            default: null,
        },
        date: {
            type: String,
            default: null,
        }
    },
    methods: {
        onRequestDateChanged(event) {
            console.debug('onRequestDateChanged', event);

            let newRequestDate = event.target.value;
            this.isLoading = true;
            getDailyReports(newRequestDate)
                .then((result) => {
                    console.debug(result);
                    this.isLoading = false;
                    this.dailyRawMaterials = result.data.dailyRawMaterials;
                })
                .catch((err) => {
                    console.debug(err);
                    this.isLoading = false;
                });
        },
        onShowDetailClicked(report) {
            console.debug('report', report, this.currentRequestSource);

            this.reportDetails = null;
            this.currentReport = report;
            this.currentItemDesc1 = report.item_desc1;
            this.currentItemDesc2 = report.item_desc2;
            this.currentItemCode = report.item_code;
            this.currentQRCode = report.qr_code;

            if (this.currentRequestSource) {
                this.currentRequestSource.cancel('CancelRequest');
            }

            this.currentRequestSource = axios.CancelToken.source();

            this.isReportDetailsLoading = true;
            getDailyReportDetails(report.report_id, this.currentRequestSource.token)
                .then((result) => {
                    console.debug(result);
                    this.isReportDetailsLoading = false;
                    this.reportDetails = result.data.reportDetails;
                })
                .catch((err) => {
                    console.debug(err, axios.isCancel(err));
                    if (!axios.isCancel(err)) {
                        this.isReportDetailsLoading = false;
                    }
                });

        },
    },
}
</script>
<style scoped>
th,
td {
    vertical-align: middle !important;
    text-align: center;

}

</style>
