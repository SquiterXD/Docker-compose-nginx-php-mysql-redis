<template>
    <div class="">
        <form id="production-plan-form" action="">
            <div class="row">
                <div class="col-8 b-r">
                    <div class="row">
                        <div class="col-lg-6">
                            <dl class="row mb-0">
                                <div class="col-sm-4 pl-0 text-sm-right">
                                    <dt>ปีงบประมาณ:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1">
                                        <!-- {{ prodBiweeklyMain.pp_bi_weekly.biweekly }} -->
                                        <div v-if="prodBiweeklyMain">
                                            {{ prodBiweeklyMain.pp_bi_weekly.period_year_thai }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 pl-0 text-sm-right">
                                    <dt>ปักษ์ที่:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="prodBiweeklyMain">
                                            {{ prodBiweeklyMain.pp_bi_weekly.biweekly }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 pl-0 text-sm-right">
                                    <dt>ครั้งที่:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="prodBiweeklyMain">
                                            {{ prodBiweeklyMain.version_no }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                            <!-- <dl class="row mb-0">
                                <div class="col-sm-4 pl-0 text-sm-right">
                                    <dt>ส่งข้อมูลครั้งที่:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1 text-danger">
                                        <div v-if="prodBiweeklyMain">
                                            
                                        </div>
                                    </dd>
                                </div>
                            </dl> -->
                            <dl class="row mb-0">
                                <div class="col-sm-4 pl-0 text-sm-right">
                                    <dt>ประจำเดือน:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1 ">
                                        <div v-if="prodBiweeklyMain">
                                            <div v-if="prodBiweeklyMain.pt_biweekly">
                                                {{ prodBiweeklyMain.pt_biweekly.pp_month }}
                                            </div>
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 pl-0 text-sm-right">
                                    <dt>ประจำวันที่:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="prodBiweeklyMain">
                                            {{ prodBiweeklyMain.pp_bi_weekly.thai_combine_date }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>

                        </div>
                        <div class="col-lg-6" id="cluster_info">
                            <dl class="row mb-0">
                                <div class="col-sm-8  pl-0 text-sm-right">
                                    <dt>
                                        อ้างอิงประมาณการจำหน่ายรายปักษ์ที่:
                                    </dt>
                                </div>
                                <div class="col-sm-4 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="prodBiweeklyMain">
                                            {{ prodBiweeklyMain.om_bi_weekly.biweekly_no }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>

                            <dl class="row mb-0">
                                <div class="col-sm-8 pl-0  text-sm-right">
                                    <dt>ครั้งที่:</dt>
                                </div>
                                <div class="col-sm-4 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="prodBiweeklyMain">
                                            {{ prodBiweeklyMain.first_sales_forecast.version }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>

                            <dl class="row mb-0">
                                <div class="col-sm-8 pl-0  text-sm-right">
                                    <dt>วันที่อนุมัติแผนขาย:</dt>
                                </div>
                                <div class="col-sm-4 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="prodBiweeklyMain">
                                            {{ prodBiweeklyMain.first_sales_forecast.approve_date_format }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>

                        </div>
                    </div>
                </div>

                <div class="col-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <dl class="row mb-0">
                                <div class="col-sm-6 text-sm-right">
                                    <dt>วันที่สร้าง:</dt>
                                </div>
                                <div class="col-sm-6 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="prodBiweeklyMain">
                                            {{ prodBiweeklyMain.creation_date_format }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>

                            <!-- <dl class="row mb-0">
                                <div class="col-sm-6 text-sm-right">
                                    <dt title="as_of_date">วันที่สร้างแผน :</dt>
                                </div>
                                <div class="col-sm-6 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="prodBiweeklyMain">
                                            {{ prodBiweeklyMain.as_of_date_format }}
                                        </div>
                                    </dd>
                                </div>
                            </dl> -->

                            <dl class="row mb-0">
                                <div class="col-sm-6 text-sm-right">
                                    <dt title="">วันที่แก้ไขล่าสุด:</dt>
                                </div>
                                <div class="col-sm-6 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="prodBiweeklyMain">
                                            {{ lastUpdateDateFormat }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>

                            <dl class="row mb-0">
                                <div class="col-sm-6 text-sm-right">
                                    <dt>สถานะ:</dt>
                                </div>
                                <div class="col-sm-6 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="prodBiweeklyMain">
                                            <span v-html="prodBiweeklyMain.status_lable_html"></span>
                                        </div>
                                    </dd>
                                </div>
                            </dl>

                            <dl class="row mb-0">
                                <div class="col-sm-6 text-sm-right">
                                    <dt>ผู้บันทึก:</dt>
                                </div>
                                <div class="col-sm-6 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="prodBiweeklyMain">
                                            {{ prodBiweeklyMain.updated_by ? prodBiweeklyMain.updated_by.name : '-' }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-6 text-sm-right">
                                    <dt>วันที่อนุมัติ:</dt>
                                </div>
                                <div class="col-sm-6 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="prodBiweeklyMain">
                                            {{ prodBiweeklyMain.approved_at_format }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>

                            <dl class="row mb-0">
                                <div class="col-sm-6 text-sm-right">
                                    <dt>ครั้งที่อนุมัติ:</dt>
                                </div>
                                <div class="col-sm-6 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="prodBiweeklyMain">
                                            
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        props:[
            "prodBiweeklyMain", 'lastUpdateDateFormat'
        ],
        data() {
            return {
                statusLists: [{
                        value: 'Active',
                        label: 'Active'
                    }, {
                        value: 'Inactive',
                        label: 'Inactive'
                    }],
            }
        }
    }
</script>