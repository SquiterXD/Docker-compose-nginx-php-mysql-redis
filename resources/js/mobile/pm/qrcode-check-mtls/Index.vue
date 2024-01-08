<template>
    <div>
        <div class="ibox float-e-margins" >
            <div class="ibox-content">
                <div class="row">
                    <div class="form-group mb-0 col-12">
                        <h1 class="font-bold p-3 text-center"> ตรวจสอบวัตถุดิบ </h1>


                        <form v-on:submit.prevent="scanMaterial" v-loading="loading" v-if="step == 1">
                            <div class="form-group  row" >
                                <div class="col-5 text-right mt-2 pr-0">
                                    <h3 class="font-bold no-margins">วันที่ในเอกสาร:</h3>
                                </div>
                                <div class="col-7"  >
                                    <mb-datepicker autofocus
                                        ref="transfer_date"
                                        class="my-1 col-sm-12 form-control"
                                        name="used_date"
                                        onkeydown="return event.key != 'Enter';"
                                        style="width: 100%;"
                                        placeholder="โปรดเลือกวันที่เริ่มต้น"
                                        :value="toJSDate(input.transfer_date, 'yyyy-MM-dd')"
                                        @change="(date) => {
                                            input.transfer_date = jsDateToString(date);
                                            validateInput('transfer_date');
                                            if (date) {
                                                this.$nextTick(() => {
                                                    const input = this.$refs.item;
                                                    input.focus();
                                                });
                                            }
                                        }"
                                    />

                                    <transition
                                        enter-active-class="animated fadeInUp"
                                        leave-active-class="animated fadeOutDown">
                                        <div  class="error_msg text-left" v-if="validate.transfer_date.msg">
                                            {{ validate.transfer_date.msg }}
                                        </div>
                                    </transition>
                                </div>
                            </div>


                            <div class="form-group  row">
                                <!-- <label class="col-sm-2 col-form-label">Normal</label> -->
                                <!-- <div class="col-sm-12">
                                    <input v-model="input.item"
                                        @blur="validateInput('item')"
                                        type="text" class="form-control">
                                    <transition
                                        enter-active-class="animated fadeInUp"
                                        leave-active-class="animated fadeOutDown">
                                        <div  class="error_msg text-left" v-if="validate.item.msg">
                                            {{ validate.item.msg }}
                                        </div>
                                    </transition>
                                </div> -->

                                <div class="col-5 text-right mt-2 pr-0">
                                    <h3 class="font-bold no-margins">รหัสวัตถุดิบ:</h3>
                                </div>
                                <div class="col-7" >
                                    <!-- placeholder="สแกน QR Code ที่เอกสาร" -->
                                    <input ref="item" v-model="input.item" placeholder="สแกน QR Code ในรายงาน"
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

                            <table class="" border="0" width="100%">
                                <tr>
                                    <td>
                                        <button
                                            type="submit"
                                            class="qr-btn btn btn-success btn-lg btn-block"
                                            @click.prevent="scanMaterial"
                                            >
                                            ตกลง
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </form>

                        <form v-on:submit.prevent="scanMaterial" v-loading="loading" v-if="step == 2">
                            <div v-html="process[step]['html']"></div>

                            <div class="hr-line-dashed"></div>
                            <div class="form-group  row">
                                <div class="col-sm-12">
                                    <input ref="compare_item" placeholder="สแกน QR Code ที่ชั้นวางของ" v-model="input.compare_item"
                                        @blur="validateInput('compare_item')"
                                        type="text" class="form-control">
                                    <transition
                                        enter-active-class="animated fadeInUp"
                                        leave-active-class="animated fadeOutDown">
                                        <div  class="error_msg text-left" v-if="validate.compare_item.msg">
                                            {{ validate.compare_item.msg }}
                                        </div>
                                    </transition>
                                </div>
                            </div>

                            <table class="" border="0" width="100%">
                                <tr>
                                    <td>
                                        <button
                                            type="button"
                                            class="qr-btn btn btn-danger btn-lg btn-block"
                                            @click="step = 1"
                                            >
                                            <i class="fa fa-times"></i> กลับ
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </form>


                        <form v-on:submit.prevent="scanMaterial" v-loading="loading" v-if="step == 3">
                            <div v-html="process[step]['html']"></div>

                            <div class="hr-line-dashed"></div>


                            <table class="" border="0" width="100%">
                                <tr>
                                    <td width="50%">
                                        <button v-if="process[step]['can_next_step']"
                                            :disabled="!process[step]['can_next_step']"
                                            type="button"
                                            class="qr-btn btn btn-success btn-lg btn-block"
                                            @click="scanMaterial"
                                            >
                                            <i class="fa fa-check"></i> ยืนยัน
                                        </button>
                                    </td>
                                    <td width="50%">
                                        <button
                                            type="button"
                                            class="qr-btn btn btn-danger btn-lg btn-block"
                                            @click="step = 2"
                                            >
                                            <i class="fa fa-times"></i> ยกเลิก
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment";
import {
    isInRange, jsDateToString, toJSDate, toThDateString
} from '../../dateUtils'
export default {

    // components: {
    //     SearchItem
    // },
    props:[
        "data", 'oldIput', 'transDate', "pRequest", "url", "transBtn", "profile"
    ],
    computed: {
        secondaryUomList() {
        },
    },
    watch:{
        step(newValue, oldValue) {
            if (oldValue == 2 && newValue == 1) {
                this.input.item = '';
                this.input.compare_item = '';
            }

            if (oldValue == 3 && newValue == 2) {
                this.input.compare_item = '';
            }

            if (oldValue == 3 && newValue == 1) {
                this.input.item = '';
                this.input.compare_item = '';
            }

            if (newValue === 2) {
                this.$nextTick(() => {
                    const input = this.$refs.compare_item;
                    input.focus();
                });
            }
        }
    },
    data() {
        return {
            isInRange, jsDateToString, toJSDate, toThDateString,

            header: this.pHeader,
            user: this.profile,
            loading: false,
            input: {
                item: '',
                compare_item: '',
                transfer_date: '',
            },
            validate: {
                item: {
                    msg: false,
                },
                compare_item: {
                    msg: false,
                },
                transfer_date: {
                    msg: false,
                }
            },
            step: 1,
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
                }
            }
        }
    },
    mounted() {
    },
    methods: {
        async setdate(date, key) {
            let vm = this;
            vm.input[key] = await moment(date).format(vm.transDate['js-format']);
        },
        validateInput(input) {
            let vm = this;
            switch(input) {
                case 'transfer_date':
                    vm.validate.transfer_date.msg = false;
                    if (vm.input.transfer_date == null || vm.input.transfer_date == '' || vm.input.transfer_date == 'Invalid date') {
                        vm.validate.transfer_date.msg = 'กรุณาระบุ วันที่';
                    }
                    break;
                case 'item':
                    vm.validate.item.msg = false;
                    if (vm.input.item == null || vm.input.item == '') {
                        vm.validate.item.msg = 'กรุณาระบุ รหัสวัตถุดิบ';
                    }
                    break;
                case 'compare_item':
                    vm.validate.compare_item.msg = false;
                    if (vm.input.compare_item == null || vm.input.compare_item == '') {
                        vm.validate.compare_item.msg = 'กรุณาระบุ สแกน QR Code ที่ชั้นวางของ';
                    }
                    break;
              default:
            }
        },
        async scanMaterial() {
            let vm = this;
            if (vm.step == 1) {
                if (!vm.input.transfer_date || !vm.input.item) {
                    return;
                }
            }

            vm.loading = true;
                await axios.get(vm.url.ajax_qrcode_check_materials_detail, {
                    params: {
                        item: vm.input.item,
                        transfer_date: vm.input.transfer_date,
                        compare_item: vm.input.compare_item,
                        step: vm.step,
                    }
                })
                .then(res => {
                    let data = res.data.data;
                    if (data.status == 'S') {
                        if (vm.step == 1) {
                            vm.step = 2;
                        } else if (vm.step == 2) {
                            if (data.can_next_step) {
                                vm.step = 3;
                                // vm.scanMaterial();
                            }
                        } else if (vm.step == 3) {
                            swal({
                                title: '<br>ตรวจสอบวัตถุดิบสำเร็จ',
                                type: "success",
                                html: true
                            });
                            vm.step = 1;
                        }

                        vm.process[vm.step]['can_next_step'] = data.can_next_step;
                        vm.process[vm.step]['html'] = data.html;
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
