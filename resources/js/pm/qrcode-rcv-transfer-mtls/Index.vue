<template>
    <div>
        <div class="ibox float-e-margins" >
            <div class="ibox-content">
                <div class="row">
                    <div class="form-group mb-0 col-lg-6 col-md-6 col-sm-12 col-xs-12 offset-md-3">
                        <h1 class="font-bold p-3 text-center" :title="step"> รับโอนวัตถุดิบ </h1>

                        <form v-on:submit.prevent="scanQr()" v-loading="loading" v-if="step == 1">
                            <div class="form-group  row" @mouseleave="validateInput('transfer_date')">
                                <div class="col-4 text-right col-form-label">
                                    <h3 class="font-bold no-margins">วันที่ทำรายการ:</h3>
                                </div>
                                <div class="col-sm-8">
                                    <datepicker-th
                                        style="width: 100%"
                                        class="form-control md:tw-mb-0 tw-mb-2"
                                        name="input_date"
                                        id="input_date"
                                        placeholder="โปรดเลือกวันที่"
                                        :value="input.transfer_date"
                                        :format="trans_date['js-format']"
                                        @blur="validateInput('transfer_date')"
                                        @dateWasSelected="setdate(...arguments, 'transfer_date')" />
                                    <!-- <input v-model="input.transfer_date"
                                        @blur="validateInput('transfer_date')"
                                        type="text" class="form-control"> -->
                                    <transition
                                        enter-active-class="animated fadeInUp"
                                        leave-active-class="animated fadeOutDown">
                                        <div  class="error_msg text-left" v-if="validate.transfer_date.msg">
                                            {{ validate.transfer_date.msg }}
                                        </div>
                                    </transition>
                                </div>
                            </div>

                            <div class="text-center">
                                <button
                                    type="button"
                                    class="btn btn-success btn-lg btn-block"
                                    @click.prevent="scanQr()"
                                    >
                                    <!-- @click.prevent="onScanRawMaterialClicked" -->
                                    <i class="fa fa-qrcode"></i>
                                    ตกลง
                                </button>
                            </div>
                        </form>

                        <form v-on:submit.prevent="scanQr()" v-loading="loading" v-if="step == 2 ">
                            <div v-html="process[step]['html']"></div>
                            <div class="hr-line-dashed"></div>
                            <div class="form-group  row">
                                <div class="col-sm-12">
                                    <input v-model="input.item" placeholder="สแกน QR Code วัตถุดิบ"
                                        @blur="validateInput('item')"
                                        type="text" class="form-control">
                                    <transition
                                        enter-active-class="animated fadeInUp"
                                        leave-active-class="animated fadeOutDown">
                                        <div  class="error_msg text-left" v-if="validate.item.msg">
                                            {{ validate.item.msg }}
                                        </div>
                                    </transition>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-success btn-lg btn-block"
                                    :disabled="items.length == 0" @click="summary"
                                    >
                                    <i class="fa fa-qrcode"></i>
                                    สรุปรายการโอน
                                </button>
                            </div>

                            <div class="text-center">
                                <!-- <button
                                    type="button"
                                    class="btn btn-danger btn-lg btn-block"
                                    @click="resetData()"
                                    >
                                    <i class="fa fa-times"></i> สร้างรายการใหม่
                                </button> -->
                                <button
                                    type="button"
                                    class="btn btn-warning btn-lg btn-blockr btn-lg btn-block"
                                    @click="resetData()"
                                    >
                                    <i class="fa fa-times"></i> กลับ
                                </button>
                            </div>
                        </form>

                        <form v-on:submit.prevent="scanQr()" v-loading="loading" v-if="step == 3">
                            <div v-html="process[step]['html']"></div>


                            <div class="hr-line-dashed"></div>
                            <div class="form-group row text-left mt-2 mb-2" v-if="process[step]['can_next_step']" >
                                <div class="col-3 text-right">
                                    <h3 class="font-bold no-margins">รหัสวัตถุดิบ:</h3>
                                </div>
                                <div class="col-9" v-if="itemDetail">
                                    <h4 class="text-muted no-margins">{{ itemDetail.item_number }}: {{ itemDetail.description }}</h4>
                                </div>
                            </div>

                            <div class="form-group  row" v-if="process[step]['can_next_step']">
                                <div class="col-lg-3 text-right">
                                    <h4 class="font-bold no-margins pt-2">จำนวนที่รับโอน:</h4>
                                </div>

                                <div class="col-lg-9">
                                    <div class="input-group m-b">
                                        <input placeholder="จำนวนที่รับโอน" v-model="input.tranfer_qty"
                                            @blur="validateInput('tranfer_qty')"
                                            step="any"
                                            type="number" class="form-control text-right">
                                        <div class="input-group-append">
                                            <span class="input-group-addon">
                                                <span v-if="itemDetail">
                                                    {{ itemDetail.unit_of_measure }}
                                                </span>
                                                <span v-else>-</span>
                                            </span>
                                        </div>
                                    </div>
                                    <transition
                                        enter-active-class="animated fadeInUp"
                                        leave-active-class="animated fadeOutDown">
                                        <div  class="error_msg text-left" v-if="validate.tranfer_qty.msg">
                                            {{ validate.tranfer_qty.msg }}
                                        </div>
                                    </transition>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="button" class="btn btn-success btn-lg btn-block"
                                    :disabled="items.length == 0" @click="summary"
                                    >
                                    <i class="fa fa-qrcode"></i>
                                    สรุปรายการโอน
                                </button>
                            </div>
                            <div class="text-center">
                                <button
                                    type="button"
                                    class="btn btn-warning btn-lg btn-block"
                                    @click="step = 2"
                                    >
                                    <i class="fa fa-times"></i> ยกเลิก
                                </button>
                            </div>
                        </form>

                        <form v-on:submit.prevent="scanQr()" v-loading="loading" v-if="step == 4">
                            <div v-html="process[step]['html']"></div>

                            <div class="hr-line-dashed"></div>
                            <table class="table table-bordered" style="font-size: 13px">
                                <thead>
                                    <tr>
                                        <th>วัตถุดิบ </th>
                                        <th class="text-right" width="15%"> จำนวน </th>
                                        <th class="text-center" width="3%"> <i class="fa fa-cog"></i> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="item in items" v-if="Object.keys(items).length">
                                        <tr>
                                            <td>
                                                <div>
                                                    <span class="text-muted">วัตถุดิบ: </span> {{ item.item_number }}
                                                </div>
                                                <div>
                                                    <span class="text-muted">รายละเอียด: </span> {{ item.description }}
                                                </div>
                                            </td>

                                            <td class="text-right">
                                                {{ item.tranfer_qty }}<br>
                                                {{ item.unit_of_measure }}
                                            </td>
                                            <td>
                                                <button class="btn btn-default btn-sm" style="color: red;" >
                                                    <i class="fa fa-trash" @click="deleteItemFunc(item.inventory_item_id)"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>

                                    <template v-else>
                                        <tr>
                                            <td colspan="4">
                                                <h4 align="center"> NO DATA FOUND </h4>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>

                            <div class="text-center">
                                <button
                                    :disabled="!Object.keys(items).length"
                                    type="button"
                                    class="btn btn-success btn-lg btn-block"
                                    @click="scanAssignee"
                                    >
                                    <i class="fa fa-check"></i> ยืนยัน
                                </button>
                            </div>

                            <div class="text-center">
                                <button
                                    type="button"
                                    class="btn btn-warning btn-lg btn-block"
                                    @click="step = 2"
                                    >
                                    <i class="fa fa-times"></i> กลับ
                                </button>
                            </div>
                        </form>

                        <form v-on:submit.prevent="store" v-loading="loading" v-if="step == 5 || step == 6">
                            <div v-html="process[step]['html']"></div>

                            <div class="hr-line-dashed"></div>

                            <div class="form-group  row" v-if="process[step]['can_next_step']">
                                <div class="col-sm-12">
                                    <input placeholder="สแกน QR Code ผู้รับโอน" v-model="input.assignee"
                                        @blur="validateInput('assignee')"
                                        type="text" class="form-control">
                                    <transition
                                        enter-active-class="animated fadeInUp"
                                        leave-active-class="animated fadeOutDown">
                                        <div  class="error_msg text-left" v-if="validate.assignee.msg">
                                            {{ validate.assignee.msg }}
                                        </div>
                                    </transition>
                                </div>
                            </div>


                            <div class="text-center">
                                <button
                                    type="button"
                                    class="btn btn-warning btn-lg btn-block"
                                    @click="step = 4"
                                    >
                                    <i class="fa fa-times"></i> กลับ
                                </button>
                            </div>

                            <!-- <div class="text-center">
                                <button
                                    type="button"
                                    class="btn btn-warning btn-lg btn-block"
                                    @click="step = 2"
                                    >
                                    <i class="fa fa-times"></i> กลับไปหน้าทำรายการ
                                </button>
                            </div> -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment";
export default {

    // components: {
    //     SearchItem
    // },
    props:[
        "data", 'oldIput', 'trans_date', "pRequest", "url", "trans_btn", "profile"
    ],
    computed: {
        secondaryUomList() {
        },
    },
    watch:{
        step(newValue, oldValue) {
            if (oldValue == 2 && newValue == 1) {
                this.input.transfer_date = '';
            }

            if (oldValue == 3 && newValue == 2) {
                this.input.item = '';
                this.input.machine_group = '';
            }

            if (oldValue == 4 && newValue == 3) {
                this.input.assignee = '';
                this.input.tranfer_qty = '';
            }

            if (oldValue == 4 && newValue == 1) {
                this.input.item = '';
                this.input.machine_group = '';
                this.input.assignee = '';
                this.input.tranfer_qty = '';
            }

            if (oldValue == 6 && newValue == 1) {
                this.input.item = '';
                this.input.machine_group = '';
                this.input.assignee = '';
                this.input.tranfer_qty = '';
            }
        }
    },
    data() {
        return {
            header: this.pHeader,
            user: this.profile,
            loading: false,
            itemDetail: false,
            items: [],
            deleteItem: '',
            input: {
                transfer_date: '',
                item: '',
                machine_group: '',
                assignee: '',
                tranfer_qty: '',
            },
            validate: {
                transfer_date: {
                    msg: false,
                },
                item: {
                    msg: false,
                },
                machine_group: {
                    msg: false,
                },
                assignee: {
                    msg: false,
                },
                tranfer_qty: {
                    msg: false,
                }
            },
            step: 1,
            newSession: false,
            process: {
                1: {
                    html: '',
                    can_next_step: false,
                },
                2: {
                    html: '',
                    can_next_step: false,
                },
                3: {
                    html: '',
                    can_next_step: false,
                },
                4: {
                    html: '',
                    can_next_step: false,
                },
                5: {
                    html: '',
                    can_next_step: false,
                },
                6: {
                    html: '',
                    can_next_step: false,
                },
                7: {
                    html: '',
                    can_next_step: false,
                }
            }
        }
    },
    mounted() {
        this.scanQr(1);
    },
    methods: {
        async summary() {
            this.step = 4
            this.scanQr()
        },
        async scanAssignee() {
            this.step = 5
            this.scanQr();
        },
        async store() {
            this.step = 6
            this.scanQr();
        },
        async deleteItemFunc(inventoryItemId) {
            this.step = 7
            this.deleteItem = inventoryItemId;
            this.scanQr();
        },
        async setdate(date, key) {
            let vm = this;
            vm.input[key] = await moment(date).format(vm.trans_date['js-format']);
        },
        validateInput(input) {
            let vm = this;
            switch(input) {
                case 'transfer_date':
                    vm.validate.transfer_date.msg = false;
                    if (vm.input.transfer_date == '') {
                        vm.validate.transfer_date.msg = 'กรุณาระบุ วันที่ทำรายการ';
                    }
                    break;
                case 'item':
                    vm.validate.item.msg = false;
                    if (vm.input.item == '') {
                        vm.validate.item.msg = 'กรุณาระบุ สแกน QR Code วัตถุดิบ';
                    }
                    break;
                case 'machine_group':
                    vm.validate.machine_group.msg = false;
                    if (vm.input.machine_group == '') {
                        vm.validate.machine_group.msg = 'กรุณาระบุ รหัสเครื่องจักร';
                    }
                    break;
                case 'assignee':
                    vm.validate.assignee.msg = false;
                    if (vm.input.assignee == '') {
                        vm.validate.assignee.msg = 'กรุณาระบุ สแกน QR Code ผู้รับโอน';
                    }
                    break;
                case 'tranfer_qty':
                    vm.validate.tranfer_qty.msg = false;
                    if (vm.input.tranfer_qty == '') {
                        vm.validate.tranfer_qty.msg = 'กรุณาระบุ จำนวนที่รับโอน';
                    }
                    break;
              default:
            }
        },
        async resetData() {
            this.newSession = true;
            this.scanQr();
        },
        async scanQr(firstLoad = 0) {
            let vm = this;

            vm.loading = true;

            await axios.get(vm.url.ajax_detail, {
                params: {
                    new_session: vm.newSession,
                    transfer_date: vm.input.transfer_date,
                    step: vm.step,
                    is_first_load: firstLoad,

                    item: vm.input.item,
                    machine_group: vm.input.machine_group,
                    assignee: vm.input.assignee,
                    tranfer_qty: vm.input.tranfer_qty,
                    delete_item_id: vm.deleteItem
                }
            })
            .then(res => {

                let data = res.data.data;
                if (data.status == 'S') {
                    if (vm.step == 1) {
                        if (data.transfer_date) {
                            vm.step = 2;
                        }
                    } else if (vm.step == 2) {
                        if (data.can_next_step) {
                            vm.step = 3;
                            vm.input.tranfer_qty = data.item_detail.plan_quantity;
                        } else {
                            vm.input.item = '';
                        }
                    } else if (vm.step == 3) {
                        vm.step = 2;
                        vm.input.tranfer_qty = '';
                    } else if (vm.step == 4) {
                    } else if (vm.step == 5) {
                    } else if (vm.step == 6) {
                        swal({
                            title: '<br>รับโอนวัตถุดิบสำเร็จ',
                            type: "success",
                            html: true
                        });
                        vm.newSession = true;
                    } else if (vm.step == 7) {
                        swal({
                            title: '<br>ลบ Item สำเร็จ',
                            type: "success",
                            html: true
                        });
                        vm.summary()
                    }

                    if (vm.newSession) {
                        vm.newSession = false;
                        vm.step = 1;
                    }

                    vm.process[vm.step]['can_next_step'] = data.can_next_step;
                    vm.process[vm.step]['html'] = data.html;
                    vm.itemDetail = data.item_detail;
                    vm.items = data.items;

                    if (!vm.input.transfer_date && data.def_transfer_date && vm.step == 1) {
                        vm.input.transfer_date = data.def_transfer_date;
                    }
                }
                if (res.data.data.status != 'S') {
                    swal({
                        title: "Error !",
                        text: res.data.data.msg,
                        type: "error",
                        showConfirmButton: true
                    });
                }
            })
            .catch(err => {
                let data = err.response.data;
                alert(data.message);
            })
            .then(() => {
                vm.loading = false;
                // swal.close();
            });

            return;
        }
    }
}
</script>
