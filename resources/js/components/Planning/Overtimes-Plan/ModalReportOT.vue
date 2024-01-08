<template>
    <span>
        <button :class="btnTrans.print.class + ' btn-lg tw-w-25'" style="padding-left: 7px;" @click="openModal">
            <i :class="btnTrans.print.icon"></i> พิมพ์
        </button>
        <!-- data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target="#modal-downtime-machine"-->
        <div id="modal-ot-report" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width:980px;">
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <h3 style="font-size:24px; font-weight:400;" class="modal-title text-left">
                            รายงานประมาณการค่าใช้จ่ายล่วงเวลาประจำปักษ์
                        </h3>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
                    <div class="modal-body text-left">
                        <form id="machine-downtime-form">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="12%" class="text-center"> หน่วยงาน </th>
                                            <th width="12%" class="text-center"> ประเภทพนักงาน </th>
                                            <th width="13%" class="text-center"> 
                                                กรอบงบประมาณค่าล่วงเวลา <br/> ที่ผ่านการกลั่นกรองปีงบประมาณ {{ search.budget_year }} <br/> (บาท)
                                            </th>
                                            <th width="13%" class="text-center">
                                                <template v-if="search.bi_weekly == 1">
                                                    ประมาณการใช้งบประมาณ <br/> ปักษ์ที่ 1 <br/> (บาท)
                                                </template>
                                                <template v-else>
                                                    ประมาณการใช้งบประมาณ <br/> ปักษ์ที่ 1 - {{ search.bi_weekly - 1 }} <br/> (บาท)
                                                </template>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template v-for="(department, name) in departments">
                                            <tr>
                                                <td class="text-center" :rowspan="department.length+1">
                                                    {{ name }}
                                                </td>
                                                <tr v-for="dept in department">
                                                    <td class="text-center">
                                                        {{ dept.employee_type_name }}
                                                    </td>
                                                    <td class="text-center">
                                                        <inputBudget
                                                            :department="dept"
                                                            :pBudgetBiWeekly="budgetBiWeekly"
                                                        />
                                                    </td>
                                                    <td class="text-center">
                                                        <inputBudgetBiWeekly
                                                            :department="dept"
                                                            :pBudgetBiWeekly="budgetBiWeekly"
                                                        />
                                                    </td>
                                                </tr>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click.prevent="submit()" :class="btnTrans.print.class + ' btn-lg tw-w-25'">
                            <i :class="btnTrans.print.icon"></i> {{ btnTrans.print.text }}
                        </button>
                        <button type="button" class="btn btn-white btn-lg tw-w-25'" data-dismiss="modal"> ยกเลิก </button>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>

<script>
    import moment from "moment";
    import uuidv1 from 'uuid/v1';
    import inputBudget from './Report/InputBudget.vue';
    import inputBudgetBiWeekly from './Report/InputBudgetBiWeekly.vue';
    export default {
        components: {
            inputBudget, inputBudgetBiWeekly
        },
        props:['departments', 'search', 'btnTrans', 'url', 'selDepartment'],
        data() {
            return {
                loading: false,
                budgetBiWeekly: {},
            }
        },
        mounted() {
            //
        },
        methods: {
            openModal() {
                $('#modal-ot-report').modal('show');
            },
            async submit(){
                let vm = this;
                vm.loading = true;
                let params = {
                    budgetBiWeekly: vm.budgetBiWeekly
                };
                await axios
                .post(vm.url.ajax_submit_budget_ot_plan, params)
                .then(res => {
                    if(res.data.status == 'S'){
                        //redirect
                        let url_export = vm.url.ajax_report_ot_plan+'?department='+vm.selDepartment;
                        window.open(url_export, '_blank');
                    }else{
                        swal({
                            title: 'มีข้อผิดพลาด',
                            text: '<span style="font-size: 16px; text-align: left;">'+res.data.msg+'</span>',
                            type: "error",
                            html: true
                        });
                    }
                })
                .catch(err => {
                    let msg = err.response.data.data;
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+msg+'</span>',
                        type: "error",
                        html: true
                    });
                })
                .then(() => {
                    vm.loading = false;
                });
            },
        }
    }
</script>