<template>
    <div>
<!--        <div class="form-group row">-->
<!--            <pre class="col-lg-6" style="display: block">{{-->
<!--                    JSON.stringify({-->
<!--                        summaryJobGrouping,-->
<!--                    }, null, 2)-->
<!--                }}-->
<!--            </pre>-->

<!--            <pre class="col-lg-6" style="display: block">{{-->
<!--                    JSON.stringify({-->
<!--                        init_max_wip_steps,-->
<!--                    }, null, 2)-->
<!--                }}-->
<!--            </pre>-->
<!--        </div>-->

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h3>รายงานผลผลิตในกระบวนการผลิต (WIP)</h3>
                    </div>
                    <div style="text-align: center">
                        <table class="table table-bordered">
                            <thead>
                            <tr style="text-align: center">
                                <th rowspan=2>เลขที่คำสั่งการผลิต</th>
                                <th rowspan=2>Blend no.</th>
                                <th rowspan=2>รหัสสินค้าสำเร็จรูป</th>
                                <th rowspan=2>รายการ</th>
                                <th rowspan=2>หน่วยนับ</th>
                                <th
                                    :colspan=init_max_wip_steps>
                                    ผลผลิตที่ได้
                                </th>
                                <th rowspan=2></th>
                            </tr>

                            <tr style="text-align: center">
                                <th
                                    v-for="index in init_max_wip_steps"
                                    :key="index">
                                    WIP0{{ index }}
                                </th>
                            </tr>

                            </thead>
                            <tbody>

                            <tr v-for="(job) in summaryJobGrouping"
                                v-bind:key='job.batch_no'>

                                <!--เลขที่คำสั่งการผลิต-->
                                <td>{{ job.batch_no }}</td>

                                <!--Blend no.-->
                                <td>{{ job.blend_no }}</td>

                                <!--รหัสสินค้าสำเร็จรูป-->
                                <td>{{ job.item_number }}</td>

                                <!--รายการ-->
                                <td>{{ job.item_desc }}</td>

                                <!--หน่วยนับ-->
                                <td>KG</td>

                                <!--ผลผลิตที่ได้-->
                                <td v-for="(wip) in job.wip_steps">
                                    {{ wip.wip_qty }}
                                </td>

                                <td>
                                    <button
                                        class="btn btn-w-m btn-default"
                                        @click.prevent="onViewDescriptionClicked(job)">
                                        <i class="fa fa-file-text-o"></i>

                                        รายละเอียด
                                    </button>
                                </td>
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

import _isEqual from "lodash/isEqual";
import _cloneDeep from "lodash/cloneDeep";
import _get from "lodash/get";
import {instance as http} from "../httpClient";
import {$route} from "../../router";
import {showGenericFailureDialog, showLoadingDialog} from "../../commonDialogs";
import _isNil from "lodash/isNil";

function importMesData(batchNo) {
    return http.post(
        $route('api.pm.report-product-in-process.importMesData', {
            id: batchNo,
        })
    );
}

function goToJobLines(batchNo) {
    window.location = $route('pm.report-product-in-process.jobs', {
        batchNo: batchNo,
    })
}

export default {
    created() {
    },
    mounted() {
    },
    data() {
        return {
            lodash: {
                get: _get,
                isEqual: _isEqual,
                cloneDeep: _cloneDeep,
                isNil: _isNil,
            },

            summaryJobGrouping: _cloneDeep(this.init_summary_job_grouping),
        }
    },
    props: {
        init_max_wip_steps: {
            type: Number,
            default: 0,
        },
        init_summary_job_grouping: {
            type: Array,
            default: [],
        },
    },
    methods: {
        onViewDescriptionClicked(job) {
            console.debug('onViewDescriptionClicked', job);

            let batchNo = job.batch_no;
            showLoadingDialog();
            importMesData(batchNo)
                .then((result) => {
                    console.debug(result);
                    swal.close();
                    goToJobLines(batchNo);
                })
                .catch((err) => {
                    console.debug(err.response);

                    let errorMessage = this.lodash.get(err, 'response.data.errorMessage', null);
                    if (!this.lodash.isNil(errorMessage)) {
                        showGenericFailureDialog(errorMessage);
                    } else {
                        showGenericFailureDialog();
                    }
                });
        }
    },
}

</script>

<style>
th,
td {
    vertical-align: middle !important;
}

</style>
