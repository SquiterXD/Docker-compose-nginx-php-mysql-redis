<template>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h2>ปิดคำสั่งการผลิต</h2>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><B>แผนการผลิตประจำปีงบประมาณ</B></label>
                                <div class="col-lg-4">
                                    <!--                                    <select class="form-control m-b">-->
                                    <!--                                        <option value="0"> 2563</option>-->
                                    <!--                                        <option value="1"> 2564</option>-->
                                    <!--                                    </select>-->
                                    <el-select
                                        id="filter-thai-year"
                                        placeholder="ปี"
                                        value-key="thai_year"
                                        v-model="filter.year">
                                        <el-option
                                            v-for="item in thaiYears"
                                            :key="item.thai_year"
                                            :label="item.thai_year"
                                            :value="item">
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><B>ประจำเดือน</B></label>
                                <div class="col-lg-4">
                                    <!--                                    <select class="form-control m-b">-->
                                    <!--                                        <option value="0"> ธันวาคม</option>-->
                                    <!--                                        <option value="1"> พฤศจิกายน</option>-->
                                    <!--                                    </select>-->
                                    <el-select
                                        id="filter-thai-month"
                                        placeholder="เดือน"
                                        value-key="thai_month"
                                        v-model="filter.month"
                                        :disabled="filter.year === null">
                                        <el-option
                                            v-for="item in thaiMonths"
                                            :key="item.thai_month"
                                            :label="item.thai_month"
                                            :value="item">
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><B>ปักษ์ที่</B></label>
                                <div class="col-lg-4">
                                    <!--                                    <select class="form-control m-b">-->
                                    <!--                                        <option value="0"> 4</option>-->
                                    <!--                                        <option value="1"> 3</option>-->
                                    <!--                                    </select>-->
                                    <el-select
                                        id="filter-biweekly"
                                        placeholder="ปักษ์"
                                        value-key="biweekly"
                                        v-model="filter.biweekly"
                                        :disabled="filter.month === null"
                                        @change="onSelectBiweekly">
                                        <el-option
                                            v-for="item in biweeklys"
                                            :key="item.biweekly"
                                            :label="item.biweekly"
                                            :value="item">
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label"><B>วันที่</B></label>
                                <div class="col-lg-8">
                                    <input
                                        type="text"
                                        class="form-control"
                                        disabled="disabled"
                                        :value="selectedDate">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <table class="table table-bordered text-center">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Job Number</th>
                                <th>Blend No.</th>
                                <th>ปริมาณที่ต้องผลิต</th>
                                <th>หน่วยนับ</th>
                                <th>สถานะปิดคำสั่งการผลิต</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="batch in summaryBatches">
                                <td>
                                    <div class="form-check abc-checkbox text-center form-check-inline">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            v-model="batch.isSelected"
                                            :disabled="batch.batch_close_status_code != 0o2"/>
                                    </div>
                                </td>
                                <td class="col-readonly">{{ batch.batch_no }}</td>
                                <td class="col-readonly">{{ batch.blend_no }}</td>
                                <td>{{ batch.plan_qty }}</td>
                                <td class="col-readonly">{{ batch.dtl_um }}</td>
                                <td class="col-readonly view-detail-able"
                                    data-toggle="modal"
                                    @click="onSelectBatch(batch)">{{ batch.batch_close_status }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="col-12 text-center btn-md mt-2">
                            <button
                                class="btn btn-w-m btn-danger"
                                type="submit"
                                :disabled="summaryBatches.filter(row => row.isSelected).length === 0"
                                @click.prevent="closeBatches">
                                <i class="fa fa-times" aria-hidden="true"></i>
                                ปิดคำสั่งการผลิต
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="transferStampModal" ref="modal">
            <div class="modal-dialog">
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="ibox ">
                                <div class="ibox-title">
                                    <h2>ปิดคำสั่งการผลิต</h2>
                                </div>
                                <div class="ibox-content">
                                    <table class="table table-bordered text-center">
                                        <thead>
                                        <tr>
                                            <th>OPT</th>
                                            <th>Transaction</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="jobOptRelation in jobOptRelations">
                                            <td>{{ jobOptRelation.opt }}</td>
                                            <td>{{ jobOptRelation.opt_status }}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="lead" v-if="jobOptRelations.length === 0">
                                        ไม่มีข้อมูล
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>

import {warningBeforeUnload} from "../helpers";
import {
    showProgressWithUnsavedChangesWarningDialog,
    showLoadingDialog,
    showSaveFailureDialog,
    showSaveSuccessDialog,
    showGenericFailureDialog,
} from "../../commonDialogs";
import {instance as http} from "../httpClient";
import {DateTime} from 'luxon';
import {$route} from "../../router";
import _cloneDeep from 'lodash/cloneDeep';
import _isEqual from 'lodash/isEqual';
import _get from "lodash/get";

// import Swal from "sweetalert2";

function getJobOptRelations(batchId, organizationId) {
    return http.get($route('api.pm.close-product-order.job-opt-relations'), {
        params: {
            batchId, organizationId
        }
    })
}

function execCloseBatch(summaryBatches) {
    return http.post($route('api.pm.close-product-order.close-batch'), {summaryBatches})
}

function unique(arr) {
    return [...new Set(arr)]
}

export default {
    created() {
        //TODO
        if (this.start_date && this.end_date) {
            let startDate = new Date(this.start_date)
            let endDate = new Date(this.end_date)
            let month = startDate.getMonth() + 1
            let year = startDate.getFullYear()
            this.selectedDate = `${startDate.getDate()}-${endDate.getDate()} ${month} ${year}`
        }

        Vue.nextTick(() => {
            this.filter = {
                ...this.filter,
                year: this.init_filter.year,
                month: this.init_filter.month,
                biweekly: this.init_filter.biweekly,
            }
            if (this.filter.biweekly) {
                let item = this.getSelectedBiweekly()
                console.log('Vue.nextTick()', {...this.filter}, item)

                if (item.start_date && item.end_date) {
                    let startDate = new Date(`${item.start_date}`)
                    let endDate = new Date(`${item.end_date}`)
                    let month = item.thai_month
                    let year = item.thai_year
                    this.selectedDate = `${startDate.getDate()}-${endDate.getDate()} ${month} ${year}`
                }
            }
        })
    },
    data() {
        return {
            luxon: {
                DateTime: DateTime,
            },
            lodash: {
                get: _get,
                isEqual: _isEqual,
                cloneDeep: _cloneDeep,
            },

            summaryBatches: this.init_summary_batches.map(batch => {
                return {
                    ...batch,
                    isSelected: false,
                }
            }),

            filter: {
                year: this.init_filter.year,
                month: this.init_filter.month,
                biweekly: this.init_filter.biweekly,
                displayDateRange: null,
            },

            selectedDate: null,

            jobOptRelations: [],

            // use for detect and alert unsaved data
            dataStage: {},
        }
    },
    props: {
        user: {type: Object, default: {}},
        biweekly_list: {type: Array, default: [],},
        init_summary_batches: {type: Array, default: []},
        start_date: {type: String, default: null},
        end_date: {type: String, default: null},
        init_filter: {},
    },
    computed: {
        thaiYears() {
            let years = unique(
                this.biweekly_list
                    .map(row => row.thai_year)
            ).sort()

            years = years.reverse()
            return years
        },
        thaiMonths() {
            if (this.filter.year === null) return null
            return unique(
                this.biweekly_list
                    .filter(row => row.thai_year === this.filter.year)
                    .map(row => row.thai_month)
            )
        },
        biweeklys() {
            if (this.filter.year === null) return null
            if (this.filter.month === null) return null
            return unique(
                this.biweekly_list.filter(row => row.thai_year === this.filter.year && row.thai_month === this.filter.month)
                    .map(row => row.biweekly)
            )
        },
    },
    methods: {
        getSelectedBiweekly() {
            console.log('getSelectedBiweekly()', {...this.filter}, this.biweekly_list)

            let selectedBiweeklyItems = this.biweekly_list.filter(row => {
                return row.thai_year === this.filter.year &&
                    row.thai_month.trim() === this.filter.month.trim() &&
                    row.biweekly === this.filter.biweekly
            })

            if (selectedBiweeklyItems.length === 0) {
                console.error('getSelectedBiweekly => selectedBiweeklyItems not found', selectedBiweeklyItems)
                return
            }

            return selectedBiweeklyItems[0]
        },
        onSelectBiweekly() {
            let item = this.getSelectedBiweekly()
            console.log('onSelectBiweekly()', {...this.filter}, item)

            let startDate = this.luxon.DateTime.fromSQL(item.start_date, {setZone: false}).toJSDate();
            let endDate = this.luxon.DateTime.fromSQL(item.end_date, {setZone: false}).toJSDate();

            // let endDate = new Date(`${item.end_date}`)
            let month = item.thai_month
            let year = item.thai_year
            let biweekly = item.biweekly
            this.selectedDate = `${startDate.getDate()}-${endDate.getDate()} ${month} ${year}`

            function Ymd(date) {
                return date.toISOString().split('T')[0]
            }

            let params = {
                month,
                year,
                biweekly,
                startDate: this.luxon.DateTime.fromJSDate(startDate).toISODate(),
                endDate: this.luxon.DateTime.fromJSDate(endDate).toISODate(),
            }

            console.debug('test', params.startDate, params.endDate)
            window.location = $route('pm.close-product-order.index') + '?' + (new URLSearchParams(params).toString())
        },
        onSelectBatch(batch) {
            console.log({batch})
            showLoadingDialog()
            getJobOptRelations(batch.batch_id, batch.organization_id).then(({data}) => {
                swal.close()
                console.log(this.$refs['modal'])
                //this.$refs['modal'].click()
                $('#transferStampModal').modal('show')
                document.querySelector('#transferStampModal').dispatchEvent(new Event('click'))
                this.jobOptRelations = data.jobOptRelations
            }).catch(async (err) => {
                console.error(err)
                swal.close()
                await showGenericFailureDialog()
            })
        },
        closeBatches() {
            console.debug('closeBatches');

            let summaryBatches = this.summaryBatches
                .filter(row => row.isSelected)

            showLoadingDialog()
            execCloseBatch(summaryBatches)
                .then(({data}) => {
                    let res = data.res
                    //swal.close();
                    console.log({res}, res.length > 0 && res[0].v_status === 'E', res.length, res[0].v_status)
                    if (res.length > 0 && res[0].v_status === 'E') {
                        console.log(res[0], swal)
                        swal({
                            title: `ปิดคำสั่งไม่สำเร็จ`,
                            text: res[0].v_err_msg,
                            type: 'error',
                            showConfirmButton: true,
                            closeOnConfirm: true,
                            confirmButtonText: 'ปิด',
                        })
                    } else {
                        showSaveSuccessDialog()
                    }
                })
                .catch(err => {
                    console.error('err', err)
                    //swal.close();
                    return showSaveFailureDialog();
                });
        },
    },
}
</script>

<style scoped>
.view-detail-able {
    cursor: pointer;
}
</style>
