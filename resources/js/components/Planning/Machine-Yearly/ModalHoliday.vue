<template>
    <span>
        <button class="btn btn-info btn-md" style="padding-left: 7px;" @click="openModal">
            <i class="fa fa-eye"></i> วันหยุดประจำปีงบประมาณ
        </button>
        <div id="modal-holiday" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width:980px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 style="font-size:24px; font-weight:400;" class="modal-title text-left">
                            วันหยุดประจำปีงบประมาณ
                        </h3>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
                    <div class="modal-body text-left" v-loading="loading">
                        <template v-if="holHtml">
                            <div class="row col-12" style="font-size: 15px;">
                                <div class="form-group pl-2 pr-2 mb-0 col-lg-4 col-md-4 col-sm-6 col-xs-6 mt-3 text-center">
                                    <label class=" tw-font-bold tw-uppercase mb-1"> อัพเดตข้อมูลล่าสุดวันที่ : </label>
                                    <span> {{ lastDate }} </span>
                                </div>

                                <div class="form-group pr-2 mb-0 col-lg-3 col-md-4 col-sm-6 col-xs-6 mt-2">
                                    <button type="button" class="btn btn-white btn-md" @click.prevent="refreshHoliday"> <i class="fa fa-undo"></i> รีเฟรชข้อมูล </button>
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                        </template>
                        <span v-html="holHtml"></span>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>

<script>

    export default {
        props:[
            'holidaysHtml', 'lastUpdate', 'budgetYear', 'url'
        ],
        data() {
            return {
                loading: false,
                holHtml: this.holidaysHtml,
                lastDate: this.lastUpdate,
            }
        },
        mounted() {
            //
        },
        methods: {
            openModal() {
                $('#modal-holiday').modal('show');
            },
            async refreshHoliday(){
                let vm = this;
                vm.loading = true;
                let params = {
                    budget_year: vm.budgetYear,
                };
                await axios
                .post(vm.url.refresh_holiday, {params})
                .then(res => {
                    vm.loading = false;
                    if (res.data.status == 'S') {
                        vm.holHtml = [];
                        vm.holHtml = res.data.holidaysHtml;
                    }else{
                        swal({
                            title: '<span class="mt-2"> มีข้อผิดพลาด </span>',
                            text: '<span style="font-size: 16px; text-align: left;">'+res.data.msg+'</span>',
                            type: "warning",
                            html: true
                        });
                    }
                });
            }
        },
    }
</script>