<template>
    <div class="">
        <form id="stamp-follow-form">
            <div class="row">
                <div class="col-8 b-r">
                    <div class="row">
                        <div class="col-lg-3">
                            <dl class="row mb-0">
                                <div class="col-sm-7 pl-0 text-sm-right pl-0 pr-0">
                                    <dt>ปีงบประมาณ:</dt>
                                </div>
                                <div class="col-sm-5 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="header && header.pp_period">
                                            {{ header.pp_period.thai_year }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div class="col-lg-3">
                            <dl class="row mb-0">
                                <div class="col-sm-5 pl-0 text-sm-right pl-0 pr-0">
                                    <dt>ประจำเดือน:</dt>
                                </div>
                                <div class="col-sm-7 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="header && header.pp_period">
                                            {{ header.pp_period.thai_month }}
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
                                    <dt>วันที่ปัจจุบัน:</dt>
                                </div>
                                <div class="col-sm-6 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="header">
                                            {{ header.current_date_format }}
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
                                        <div v-if="header">
                                            {{ header.last_update_date_format }}
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
                                        <div v-if="header">
                                            {{ header.updated_by ? header.updated_by.name : '' }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>

                            <dl class="row mb-1">
                                <div class="col-sm-6 text-sm-right">
                                    <dt>นำข้อมูลเข้าล่าสุด:</dt>
                                </div>
                                <div class="col-sm-6 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="header">
                                            {{ header.interface_pr_date_format ? header.interface_pr_date_format : '' }}
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
            "header"
        ],
        data() {
            return {
                //
            }
        },
        methods: {
            //
        },
        watch:{
        },
        computed: {
        }
    }
</script>