<template>
    <div class="">
        <form id="production-plan-form" action="">
            <div class="row">
                <div class="col-8 b-r">
                    <div class="row">
                        <div class="col-lg-6">
                            <dl class="row mb-1">
                                <div class="col-sm-4 pl-0 text-sm-right">
                                    <dt>ปีงบประมาณ:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="machineBiweekly">
                                            {{ machineBiweekly.pp_bi_weekly.thai_year }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-1">
                                <div class="col-sm-4 pl-0 text-sm-right">
                                    <dt>ปักษ์ที่:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="machineBiweekly">
                                            {{ machineBiweekly.pp_bi_weekly.biweekly }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-1">
                                <div class="col-sm-4 pl-0 text-sm-right">
                                    <dt>อ้างอิงแผนปักษ์ที่:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="productBiweeklyMain">
                                            {{ productBiweeklyMain.biweekly }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                            <!-- <dl class="row mb-1">
                                <div class="col-sm-4 pl-0 text-sm-right">
                                    <dt>ปรับข้อมูลครั้งที่:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="machineBiweekly">
                                            {{ machineBiweekly.adjust_no }}
                                        </div>
                                    </dd>
                                </div>
                            </dl> -->
                            <dl class="row mb-1">
                                <div class="col-sm-4 pl-0 text-sm-right">
                                    <dt>ประจำเดือน:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1 ">
                                        <div v-if="machineBiweekly">
                                            <div v-if="machineBiweekly.pt_bi_weekly">
                                                {{ machineBiweekly.pt_bi_weekly.pp_month }}
                                            </div>
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-1">
                                <div class="col-sm-4 pl-0 text-sm-right">
                                    <dt>ประจำวันที่:</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="machineBiweekly">
                                            {{ machineBiweekly.pp_bi_weekly.thai_combine_date }}
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
                            <dl class="row mb-1">
                                <div class="col-sm-6 text-sm-right">
                                    <dt>วันที่สร้าง:</dt>
                                </div>
                                <div class="col-sm-6 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="productDailyPlan">
                                            {{ productDailyPlan.creation_date_format }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-1">
                                <div class="col-sm-6 text-sm-right">
                                    <dt title="">วันที่แก้ไขล่าสุด:</dt>
                                </div>
                                <div class="col-sm-6 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="productDailyPlan">
                                            {{ productDailyPlan.plan_daily_t_last? productDailyPlan.plan_daily_t_last.updated_at_format :productDailyPlan.updated_at_format }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-1">
                                <div class="col-sm-6 text-sm-right">
                                    <dt>สถานะ:</dt>
                                </div>
                                <div class="col-sm-6 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="productDailyPlan">
                                            <span v-html="productDailyPlan.status_lable_html"></span>
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-1">
                                <div class="col-sm-6 text-sm-right">
                                    <dt>ผู้บันทึก:</dt>
                                </div>
                                <div class="col-sm-6 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="productDailyPlan">
                                            {{ (productDailyPlan && productDailyPlan.updated_by? productDailyPlan.updated_by.name: productDailyPlan.created_by)? productDailyPlan.created_by.name: null }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-1">
                                <div class="col-sm-6 text-sm-right">
                                    <dt>อนุมัติครั้งที่:</dt>
                                </div>
                                <div class="col-sm-6 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="productDailyPlan">
                                            <span v-html="productDailyPlan.approved_no? productDailyPlan.approved_no: '-'"></span>
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-1">
                                <div class="col-sm-6 text-sm-right">
                                    <dt>วันที่อนุมัติ:</dt>
                                </div>
                                <div class="col-sm-6 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="productDailyPlan">
                                            {{ productDailyPlan.approved_at_format ? productDailyPlan.approved_at_format: null }}
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
            "machineBiweekly", "productDailyPlan", "productBiweeklyMain"
        ],
    }
</script>