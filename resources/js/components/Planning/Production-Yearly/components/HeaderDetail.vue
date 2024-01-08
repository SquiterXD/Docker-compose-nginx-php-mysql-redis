<template>
    <div class="">
        <form id="production-yearly-form" action="">
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
                                        <div v-if="prodYearlyMain">
                                            {{ prodYearlyMain.budget_year }}
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
                                        <div v-if="prodYearlyMain">
                                            {{ prodYearlyMain.version_no }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                        <div class="col-lg-6" id="cluster_info">
                            <dl class="row mb-0">
                                <div class="col-sm-8  pl-0 text-sm-right">
                                    <dt>
                                        อ้างอิงประมาณการจำหน่ายปีงบประมาณ:
                                    </dt>
                                </div>
                                <div class="col-sm-4 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="prodYearlyMain">
                                            {{ prodYearlyMain? prodYearlyMain.budget_year: '-' }}
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
                                        <div v-if="prodYearlyMain">
                                            {{ prodYearlyMain.first_sales_forecast.version }}
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
                                        <div v-if="prodYearlyMain">
                                            {{ prodYearlyMain.first_sales_forecast.approve_date_format }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>

                        </div>
                    </div>
                    <div class="row">
                    <div class="form-group pl-2 pr-2 mb-0 col-lg-10 col-md-10 col-sm-6 col-xs-6 mt-2">
                        <label class=" tw-font-bold tw-uppercase mb-1" > ประมาณกำลังการผลิต </label>
                        <div>
                            <el-radio-group v-model="defaultInput.product_type" size="small"> 
                                <template v-for="(product, index) in productTypes">
                                    <el-radio :label="product.lookup_code" class="mr-1 mb-1" border>
                                        {{ product.meaning }}
                                    </el-radio>
                                </template>
                            </el-radio-group>
                        </div>
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
                                        <div v-if="prodYearlyMain">
                                            {{ prodYearlyMain.creation_date_format }}
                                        </div>
                                    </dd>
                                </div>
                            </dl>

                            <dl class="row mb-0">
                                <div class="col-sm-6 text-sm-right">
                                    <dt title="">วันที่แก้ไขล่าสุด:</dt>
                                </div>
                                <div class="col-sm-6 text-sm-left">
                                    <dd class="mb-1">
                                        <div v-if="prodYearlyMain">
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
                                        <!-- <div v-if="prodYearlyMain">
                                            <span v-html="prodYearlyMain.status_lable_html"></span>
                                        </div> -->
                                        <div v-if="headerP02">
                                            <span v-if="!statusFlag" v-html="headerP02.status_lable_html"></span>
                                            <template v-if="canApprove">
                                                <button v-if="!statusFlag" type="button" class="btn btn-xs btn-primary" @click="editStatus()">
                                                    <i class="fa fa-pencil-square"></i>
                                                </button>

                                                <el-select v-if="statusFlag" v-model="headerP02.approved_status" size="small" placeholder="สถานะ" filterable>
                                                    <el-option
                                                       v-for="status in statusLists"
                                                        :key="status.label"
                                                        :label="status.label"
                                                        :value="status.value"
                                                    >
                                                    </el-option>
                                                </el-select>
                                                <div class="text-right mt-2">
                                                    <button v-if="statusFlag" type="button" class="btn btn-xs btn-success" @click="saveStatus()">
                                                        <i class="fa fa-check-square"></i>
                                                    </button>
                                                    <button v-if="statusFlag" type="button" class="btn btn-xs btn-danger" @click="cancleStatus()">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                            </template>
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
                                        <div v-if="prodYearlyMain">
                                            {{ prodYearlyMain.updated_by ? prodYearlyMain.updated_by.name : '-' }}
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
                                        <div v-if="headerP02">
                                            <span v-if="!statusFlag"> {{ headerP02.approved_at_format }} </span>
                                            <datepicker-th v-if="statusFlag"
                                                style="width: 100%"
                                                class="form-control md:tw-mb-0 tw-mb-2 approve_date"
                                                id="approved_at"
                                                placeholder="โปรดเลือกวันที่"
                                                :value=" headerP02.approved_at_format"
                                                v-model=" headerP02.approved_at_format"
                                                format="DD/MM/YYYY"
                                                @dateWasSelected="dateOrderFrom"
                                            />
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
    import moment from "moment";
    export default {
        props:[
            "prodYearlyMain", 'lastUpdateDateFormat', 'productTypes', 'defaultInput', 'url'
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
                headerP02: this.prodYearlyMain,
                canApprove: this.prodYearlyMain.can.approve,
                statusFlag: false,
            }
        },
        watch: {
            'prodYearlyMain': function(newValue) {
                this.canApprove = newValue.can.approve;
                this.headerP02 = newValue;
            },
        },
        methods: {
            dateOrderFrom(date){
                this.headerP02.approved_date = date? moment(date).format('DD-MM-YYYY'): '';
            },
            editStatus(){
                this.statusFlag = true;
            },
            cancleStatus(){
                this.statusFlag = false;
            },
            async saveStatus(){
                let vm = this;
                vm.loading = true;
                await axios.post(vm.url.ajax_update_status,{
                    header: vm.headerP02
                })
                .then(res => {
                    if (res.data.data.status == 'S') {
                        swal({
                            title: 'อัพเดทประมาณการผลิตบุหรี่และก้นกรองประจำปี',
                            text: '<span style="font-size: 16px; text-align: left;"> อัพเดทประมาณการผลิตบุหรี่และก้นกรองประจำปีเรียบร้อย </span>',
                            type: "success",
                            html: true
                        });
                        vm.headerP02 = res.data.data.header;
                        vm.statusFlag = false;
                        vm.canApprove = vm.headerP02.can.approve;
                    } else {
                        swal({
                            title: "มีข้อผิดพลาด",
                            text: res.data.data.msg,
                            type: "error",
                            showConfirmButton: true
                        });
                    }
                })
                .catch(err => {
                    let data = err.response.data;
                    swal({
                            title: "มีข้อผิดพลาด",
                            text: data.message,
                            type: "error",
                            showConfirmButton: true
                        });
                })
                .then(() => {
                    vm.loading = false;
                });
            },
        }
    }
</script>