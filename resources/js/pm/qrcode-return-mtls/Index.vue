<template>
    <div>
        <div class="ibox float-e-margins" >
            <div class="ibox-content">
                <div class="row">
                    <div class="form-group mb-0 col-lg-6 col-md-6 col-sm-12 col-xs-12 offset-md-3">
                        <h1 class="font-bold p-3 text-center" :title="step"> {{ title }} </h1>

                        <!-- เลือกวันที่่ -->
                        <form v-on:submit.prevent="scanQr()" v-loading="loading" v-if="step == 1">
                            <div class="form-group  row" @mouseleave="validateInput('return_date')">
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
                                        :value="input.return_date"
                                        :format="trans_date['js-format']"
                                        @blur="validateInput('return_date')"
                                        @dateWasSelected="setdate(...arguments, 'return_date')" />
                                    <!-- <input v-model="input.return_date"
                                        @blur="validateInput('return_date')"
                                        type="text" class="form-control"> -->
                                    <transition
                                        enter-active-class="animated fadeInUp"
                                        leave-active-class="animated fadeOutDown">
                                        <div  class="error_msg text-left" v-if="validate.return_date.msg">
                                            {{ validate.return_date.msg }}
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
                                    ต่อไป
                                </button>
                            </div>
                        </form>

                        <!-- เลือกเครื่องจัตร -->
                        <form v-on:submit.prevent="scanQr()" v-loading="loading" v-if="step == 2">
                            <div v-html="process[step]['html']"></div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group  row">
                                <div class="col-sm-12">
                                    <input placeholder="สแกน QR Code เครื่องจักร" v-model="input.machine_set"
                                        @blur="validateInput('machine_set')"
                                        type="text" class="form-control">
                                    <transition
                                        enter-active-class="animated fadeInUp"
                                        leave-active-class="animated fadeOutDown">
                                        <div  class="error_msg text-left" v-if="validate.machine_set.msg">
                                            {{ validate.machine_set.msg }}
                                        </div>
                                    </transition>
                                </div>
                            </div>


                            <div class="text-center">
                                <button
                                    type="button"
                                    class="btn btn-danger btn-lg btn-block"
                                    @click="step = 1"
                                    >
                                    <i class="fa fa-times"></i> กลับ
                                </button>
                            </div>
                        </form>

                        <!-- แสกน item -->
                        <form v-on:submit.prevent="scanQr()" v-loading="loading" v-if="step == 3">
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
                                    สรุปรายการคืน
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

                            <!-- <div class="text-center">
                                <button
                                    type="button"
                                    class="btn btn-danger btn-lg btn-block"
                                    @click="resetData()"
                                    >
                                    <i class="fa fa-times"></i> สร้างรายการใหม่
                                </button>
                            </div> -->
                        </form>

                        <!-- ระบุจำนวน -->
                        <form v-on:submit.prevent="scanQr()" v-loading="loading" v-if="step == 4">
                            <div v-html="process[step]['html']"></div>


                            <div class="hr-line-dashed"></div>
                            <div class="form-group row text-left mt-2 mb-2" v-if="process[step]['can_next_step']" >
                                <div class="col-3 text-right">
                                    <h3 class="font-bold no-margins">รหัสวัตถุดิบ:</h3>
                                </div>
                                <div class="col-9" v-if="itemDetail">
                                    <h4 class="text-muted no-margins">{{ itemDetail.item_number }}: {{ itemDetail.item_desc }}</h4>
                                </div>
                            </div>

                            <div class="form-group  row" v-if="process[step]['can_next_step']">
                                <div class="col-lg-3 text-right">
                                    <h4 class="font-bold no-margins pt-2">จำนวนที่คืน:</h4>
                                </div>

                                <div class="col-lg-9">
                                    <div class="input-group m-b">
                                        <input placeholder="จำนวนที่คืน" v-model="input.tranfer_qty"
                                            @blur="validateInput('tranfer_qty')"
                                            step="any"
                                            type="number" class="form-control text-right">
                                        <div class="input-group-append">
                                            <span class="input-group-addon">
                                                <span v-if="itemDetail">
                                                    {{ itemDetail.uom.unit_of_measure }}
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

                            <!-- <div class="text-center">
                                <button type="button" class="btn btn-success btn-lg btn-block"
                                    :disabled="items.length == 0" @click="summary"
                                    >
                                    <i class="fa fa-qrcode"></i>
                                    สรุปรายการคืน
                                </button>
                            </div> -->
                            <div class="text-center">
                                <button
                                    type="button"
                                    class="btn btn-warning btn-lg btn-block"
                                    @click="step = 3"
                                    >
                                    <i class="fa fa-times"></i> กลับ
                                </button>
                            </div>
                        </form>

                        <!-- รายการที่ scan -->
                        <form v-on:submit.prevent="scanQr()" v-loading="loading" v-if="step == 5">
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
                                                {{ item.uom.unit_of_measure }}
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
                                    @click="step = 3"
                                    >
                                    <i class="fa fa-times"></i> กลับ
                                </button>
                            </div>
                        </form>

                        <!-- scan ผู้รับโอน -->
                        <form v-on:submit.prevent="store" v-loading="loading" v-if="step == 6 || step == 7">
                            <div v-html="process[step]['html']"></div>

                            <div class="hr-line-dashed"></div>

                            <div class="form-group  row" v-if="process[step]['can_next_step']">
                                <div class="col-sm-12">
                                    <input placeholder="สแกน QR Code ผู้คืน" v-model="input.assignee"
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
                                    @click="step = 5"
                                    >
                                    <i class="fa fa-times"></i> กลับ
                                </button>
                            </div>

                            <!-- <div class="text-center">
                                <button
                                    type="button"
                                    class="btn btn-warning btn-lg btn-block"
                                    @click="step = 3"
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
        "data", 'oldIput', 'trans_date', "pRequest", "url", "trans_btn", "profile", "title"
    ],
    computed: {
        secondaryUomList() {
        },
    },
    watch:{
        step(newValue, oldValue) {
            if (oldValue == 2 && newValue == 1) {
                this.input.machine_set = '';
            }

            if (oldValue == 3 && newValue == 2) {
                if (this.organizationCode == 'M05') {
                    this.step = 1;
                    this.resetData();
                }
            }

            if (oldValue == 4 && newValue == 3) {
                this.input.item = '';
                this.input.machine_set = '';
            }

            if (oldValue == 5 && newValue == 4) {
                this.input.assignee = '';
                this.input.tranfer_qty = '';
            }

            if (oldValue == 5 && newValue == 2) {
                this.input.item = '';
                this.input.machine_set = '';
                this.input.assignee = '';
                this.input.tranfer_qty = '';
            }

            if (oldValue == 7 && newValue == 1) {
                this.input.item = '';
                this.input.machine_set = '';
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
            organizationCode: '',
            input: {
                return_date: '',
                item: '',
                machine_set: '',
                assignee: '',
                tranfer_qty: '',
            },
            validate: {
                return_date: {
                    msg: false,
                },
                item: {
                    msg: false,
                },
                machine_set: {
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
                },
                8: {
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
            this.step = 5
            this.scanQr()
        },
        async scanAssignee() {
            this.step = 6
            this.scanQr();
        },
        async store() {
            this.step = 7
            this.scanQr();
        },
        async deleteItemFunc(inventoryItemId) {
            this.step = 8
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
                case 'return_date':
                    vm.validate.return_date.msg = false;
                    if (vm.input.return_date == '') {
                        vm.validate.return_date.msg = 'กรุณาระบุ วันที่ทำรายการ';
                    }
                    break;
                case 'item':
                    vm.validate.item.msg = false;
                    if (vm.input.item == '') {
                        vm.validate.item.msg = 'กรุณาระบุ วัตถุดิบ';
                    }
                    break;
                case 'machine_set':
                    vm.validate.machine_set.msg = false;
                    if (vm.input.machine_set == '') {
                        vm.validate.machine_set.msg = 'กรุณาระบุ เครื่องจักร';
                    }
                    break;
                case 'assignee':
                    vm.validate.assignee.msg = false;
                    if (vm.input.assignee == '') {
                        vm.validate.assignee.msg = 'กรุณาระบุ ผู้คืน';
                    }
                    break;
                case 'tranfer_qty':
                    vm.validate.tranfer_qty.msg = false;
                    if (vm.input.tranfer_qty == '') {
                        vm.validate.tranfer_qty.msg = 'กรุณาระบุ จำนวนที่คืน';
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
                    return_date: vm.input.return_date,
                    step: vm.step,
                    is_first_load: firstLoad,

                    item: vm.input.item,
                    machine_set: vm.input.machine_set,
                    assignee: vm.input.assignee,
                    tranfer_qty: vm.input.tranfer_qty,
                    delete_item_id: vm.deleteItem
                }
            })
            .then(res => {

                let data = res.data.data;
                if (data.status == 'S') {

                    vm.organizationCode = data.organization_code;

                    if (vm.step == 1) {
                        if (vm.organizationCode == 'M05' && data.return_date) {
                            vm.step = 3;
                        } else {
                            if (data.machine) {
                                vm.step = 3;
                            } else if (data.return_date) {
                                vm.step = 2;
                            }
                        }
                    } else if (vm.step == 2) {
                        if (vm.organizationCode == 'M05') {
                            vm.step = 3;
                        } else {
                            if (data.machine) {
                                vm.step = 3;
                            } else if (data.return_date) {
                                vm.step = 2;
                            }
                        }
                    } else if (vm.step == 3) {
                        if (data.can_next_step) {
                            vm.step = 4;
                            // vm.input.tranfer_qty = data.item_detail.plan_quantity;
                        } else {
                            vm.input.item = '';
                        }
                    } else if (vm.step == 4) {
                        vm.step = 3;
                        vm.input.tranfer_qty = '';
                    } else if (vm.step == 5) {
                    } else if (vm.step == 6) {
                    } else if (vm.step == 7) {
                        swal({
                            title: '<br>รับโอนวัตถุดิบสำเร็จ',
                            type: "success",
                            html: true
                        });
                        vm.newSession = true;
                    } else if (vm.step == 8) {
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

                    if (!vm.input.return_date && data.def_return_date && vm.step == 1) {
                        vm.input.return_date = data.def_return_date;
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
