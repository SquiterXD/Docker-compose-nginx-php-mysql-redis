<template>
    <div>
        <div class="row" v-if="lines">
            <div class="col-md-4 offset-md-8 text-right">
                <button v-if="!edit_flag && !interfaceFlag" :class="btnTrans.edit.class + ' btn-sm tw-w-25'" @click="editProcess(edit_flag = !edit_flag)">
                    <i :class="btnTrans.edit.icon"></i> {{ btnTrans.edit.text }}
                </button>
                <button v-if="edit_flag" :class="btnTrans.save.class + ' btn-sm tw-w-25'" @click.prevent="updateChangeInput()">
                    <i :class="btnTrans.save.icon"></i> {{ btnTrans.save.text }}
                </button>
                <button v-if="edit_flag" :class="btnTrans.cancel.class + ' btn-sm tw-w-25'" @click="editProcess(edit_flag = !edit_flag)">
                    <i :class="btnTrans.cancel.icon"></i> {{ btnTrans.cancel.text }}
                </button>
            </div>
            <div class="hr-line-dashed"></div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center firCT05-col" style="vertical-align: middle;">
                           <div> รหัสบุหรี่ </div> 
                        </th>
                        <th class="text-center seCT05-col" style="vertical-align: middle;">
                           <div> ตราบุหรี่ </div>
                        </th>
                        <th class="text-center thCT05-col" style="vertical-align: middle;">
                            <div> ปริมาณจำหน่าย <br> (มวน) </div>
                        </th>
                        <th class="text-center foCT05-col" style="vertical-align: middle;">
                            <div> ปริมาณแสตมป์ <br> (ดวง) </div>
                        </th>
                        <th class="text-center fiCT05-col" style="vertical-align: middle;">
                            <div> ราคาแสตมป์ต่อดวง </div>
                        </th>
                        <template v-for="setup in setupStamps">
                            <th v-if="setup.fund_location == 'total'" class="text-center" style="vertical-align: middle;">
                                <div> {{ setup.percent }}% <br> แสตมป์รวมกองทุน </div>
                            </th>
                            <th v-else class="text-center" style="vertical-align: middle;">
                                <div> {{ setup.percent }}% <br> {{ setup.fund_location }} </div>
                            </th>
                        </template>
                        <th class="text-center" style="vertical-align: middle;">
                            <div> รวมกองทุน </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="lines.length <= 0">
                        <tr>
                            <td colspan="17" class="text-center" style="vertical-align: middle;">
                                <h2> ไม่พบข้อมูลที่ค้นหาในระบบ </h2>
                            </td>
                        </tr>
                    </template>
                    <template v-else>
                        <template v-for="(line, index) in lines">
                            <tr>
                                <td class="text-center firCT05-col">
                                    <div style="width: 100px;"> {{ line.item_code }} </div>
                                </td>
                                <td class="text-left seCT05-col">
                                    <div style="width: 200px;"> {{ line.item_description }} </div>
                                </td>
                                <td class="text-right thCT05-col">
                                   <div style="width: 150px;">
                                        <stamp-carton
                                            style="width: 150px;"
                                            :line="line"
                                            :edit-flag="edit_flag"
                                            :can-edit="canEdit"
                                            :line-stamp-edit="lineStampEdit"
                                        />
                                    </div>
                                </td>
                                <td class="text-right foCT05-col">
                                    <div style="width: 150px;"> {{ line.stamp_quantity | number0Digit }} </div>
                                </td>
                                <td class="text-right fiCT05-col">
                                    <div style="width: 150px;">
                                        <unit-price
                                            style="width: 150px;"
                                            :line="line"
                                            :edit-flag="edit_flag"
                                            :can-edit="canEdit"
                                            :line-price-edit="linePriceEdit"
                                        />
                                    </div>
                                </td>
                                <template v-for="setup in setupStamps">
                                    <td class="text-right">
                                        <div style="width: 150px;"> {{ percent[setup.stamp_adj_id][line.item_code] | number2Digit }} </div>
                                    </td>
                                </template>
                                <td class="text-right">
                                    <template v-for="totalStamp in totalStampAdjByCigarets">
                                        <template v-if="line.item_code == totalStamp.item_code">
                                            <div style="width: 150px;"> {{ totalStamp.total | number2Digit }} </div>
                                        </template>
                                    </template>
                                </td>
                            </tr>
                        </template>
                        <tr>
                            <td class="text-right to-col" colspan="2" style="vertical-align: middle;">
                                <strong> รวม </strong>
                            </td>
                            <td class="text-right to1-col" style="vertical-align: middle; background-color: #70d200;">
                                <div class="tw-font-bold text-right" style="width: 100%;">
                                    {{ totalStampCarton | number2Digit }}
                                </div>
                            </td>
                            <td class="text-right to2-col" style="vertical-align: middle; background-color: #70d200;">
                                <div class="tw-font-bold text-right" style="width: 100%;">
                                    {{ totalStampQuantity | number0Digit }}
                                </div>
                            </td>
                            <td class="text-right to3-col" style="vertical-align: middle; background-color: #70d200;">
                                <div class="tw-font-bold text-right" style="width: 100%;"> - </div>
                            </td>
                            <template v-for="setup in setupStamps">
                                <td class="text-right" style="vertical-align: middle; background-color: #70d200;">
                                    <template v-for="stampPercent in totalStampAmountPercent">
                                        <template v-if="stampPercent.stamp_adj_id == setup.stamp_adj_id">
                                            <div class="tw-font-bold text-right" style="width: 100%;">
                                                {{ stampPercent.total | number2Digit }}
                                            </div>
                                        </template>
                                    </template>
                                </td>
                            </template>
                            <td class="text-right" style="vertical-align: middle; background-color: #70d200;">
                                <div class="tw-font-bold text-right" style="width: 100%;">
                                    {{ totalStampAdjAll | number2Digit }}
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import StampCarton from './StampCarton.vue';
    import UnitPrice from './UnitPrice.vue';
    import moment from "moment";
    export default {
        components: {
            StampCarton, UnitPrice
        },
        props:[
            'stampCigarets', 'percentCigarets', 'setupStamps', 'url', 'btnTrans', 'interfaceFlag'
        ],
        data() {
            return {
                canEdit: false,
                edit_flag: false,
                isLoading: false,
                valid: false,
                lines: this.stampCigarets,
                percent: this.percentCigarets,
                lineStampEdit: {},
                linePriceEdit: {},
                // Summary
                totalStampAdjByCigarets: [],
                totalStampAdjAll: 0,
                totalStampCarton: 0,
                totalStampQuantity: 0,
                totalStampAmountPercent: 0,
            }
        },
        mounted() {
            //
        },
        computed: {
            // calStampAdjust(){
            //     var vm = this;
            //     vm.lines.filter(function(line) {
            //         let carton = Number(line.order_quantity_carton) / 20;
            //         line.stamp_quantity = carton;
            //         let amount = carton * line.unit_price;
            //         line.stamp_amount = amount.toFixed(2);

            //         vm.setupStamps.filter(function(setup) {
            //             let v_fund = vm.setupStamps[0].percent;
            //             if (setup.stamp_adj_id == -1) {
            //                 vm.percent[setup.stamp_adj_id][line.item_code] = line.stamp_amount;
            //             }else{
            //                 vm.percent[setup.stamp_adj_id][line.item_code] = (line.stamp_amount * setup.percent) / v_fund;
            //             }
            //         });
            //     });
            // },
            summaryStampCigarets(){
                var vm = this;
                var result = [];
                vm.lines.reduce(function(res, line) {
                    vm.setupStamps.filter(function(setup) {
                        if (!res[line.item_code]) {
                            res[line.item_code] = { item_code: line.item_code, total: 0 };
                            result.push(res[line.item_code]);
                        }

                        if (setup.stamp_adj_id != -1 && setup.stamp_adj_id != 1) {
                            res[line.item_code].total += Number(vm.percent[setup.stamp_adj_id][line.item_code]);
                        }
                    });
                    return res;
                }, {});
                vm.totalStampAdjByCigarets = result;
            },
            summaryTotalAll(){
                var vm = this;
                var total = 0;
                vm.totalStampAdjByCigarets.filter(function(line) {
                    total += Number(line.total);
                });
                vm.totalStampAdjAll = total;
            },
            // Sum by feild
            summaryStampCarton(){
                var vm = this;
                var total = 0;
                vm.lines.filter(function(line) {
                    total += Number(line.order_quantity_carton);
                });
                vm.totalStampCarton = total;
            },
            summaryStampQuantity(){
                var vm = this;
                var total = 0;
                vm.lines.filter(function(line) {
                    total += Number(line.stamp_quantity);
                });
                vm.totalStampQuantity = total;
            },
            summaryStampAmountPercent(){
                var vm = this;
                var result = [];
                vm.lines.reduce(function(res, line) {
                    vm.setupStamps.filter(function(setup) {
                        if (!res[setup.stamp_adj_id]) {
                            res[setup.stamp_adj_id] = { stamp_adj_id: setup.stamp_adj_id, total: 0 };
                            result.push(res[setup.stamp_adj_id]);
                        }
                        res[setup.stamp_adj_id].total += Number(vm.percent[setup.stamp_adj_id][line.item_code]);
                    });
                    return res;
                }, {});
                vm.totalStampAmountPercent = result;
            },
        },
        watch: {
            'edit_flag': function(newValue) {
                if (newValue == false) {
                    this.lineStampEdit = {};
                    this.linePriceEdit = {};
                }
            },
            // calStampAdjust(newValue){
            //     return newValue;
            // },
            summaryStampCigarets(newValue){
                return newValue;
            },
            summaryTotalAll(newValue){
                return newValue;
            },
            summaryStampCarton(newValue){
                return newValue;
            },
            summaryStampQuantity(newValue){
                return newValue;
            },
            summaryStampAmountPercent(newValue){
                return newValue;
            },

        },
        methods: {
            async updateChangeInput() {
                let vm = this;
                let urlUpdate = vm.url.update_stamp_adjust;
                if (Object.keys(vm.lineStampEdit).length == 0 && Object.keys(vm.linePriceEdit).length == 0) {
                    swal({
                        title: 'อัพเดทต้นทุนขายแยกแสตมป์และกองทุน',
                        text: '<span style="font-size: 16px; text-align: left;"> ไม่พบข้อมูลการอัพเดทต้นทุนขายแยกแสตมป์และกองทุน </span>',
                        type: "warning",
                        html: true
                    });
                    return;
                }
                let swalConfirm = swal({
                    html: true,
                    title: 'อัพเดทต้นทุนขายแยกแสตมป์และกองทุน',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> คุณต้องการอัพเดทต้นทุนขายแยกแสตมป์และกองทุน ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: vm.btnTrans.ok.text,
                    cancelButtonText: vm.btnTrans.cancel.text,
                    confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                    cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                async function(isConfirm){
                    if (isConfirm) {
                        await axios
                        .patch(urlUpdate, {
                            lineStampEdit: vm.lineStampEdit,
                            linePriceEdit: vm.linePriceEdit,
                        })
                        .then(res => {
                            if (res.data.status == 'S') {
                                vm.lineStampEdit = {};
                                vm.linePriceEdit = {};
                                swal({
                                    title: 'อัพเดทต้นทุนขายแยกแสตมป์และกองทุน',
                                    text: '<span style="font-size: 16px; text-align: left;"> ทำการอัพเดตข้อมูลต้นทุนขายแยกแสตมป์และกองทุนเรียบร้อยแล้ว </span>',
                                    type: "success",
                                    html: true
                                });
                                window.setTimeout(function() {
                                    window.location.reload();
                                }, 1000);
                            }else{
                                swal({
                                    title: 'มีข้อผิดพลาด',
                                    text: '<span style="font-size: 15px; text-align: left;">'+res.data.msg+'</span>',
                                    type: "warning",
                                    html: true
                                });
                            }
                        })
                        .catch(err => {
                            swal({
                                title: 'มีข้อผิดพลาด',
                                text: '<span style="font-size: 15px; text-align: left;">'+err.response+'</span>',
                                type: "warning",
                                html: true
                            });
                        })
                        .then(() => {
                            vm.isLoading = true;
                        });
                    }
                });
            },
            // checkCanEdit(){
            //     let follow_date = moment(this.lines[this.lines.length -1].follow_date).format('YYYY-MM-DD');
            //     let curr_date = moment().format('YYYY-MM-DD');
            //     if (follow_date > curr_date) {
            //         this.canEdit = true;
            //     }
            // },
            editProcess(editFlag){
                var vm = this;
                vm.valid = editFlag;
                this.$emit("checkStampWorking", {flag: editFlag, tab: 'tab1'});
            },
        },
    }
</script>
<style scope>
    .firCT05-col {
        position: sticky;
        background-color: #ededed;
        z-index: 2040;
        width: 100px;
        min-width: 90px;
        max-width: 100px;
        left: 0px;
    }

    .seCT05-col {
        position: sticky;
        background-color: #ededed;
        z-index: 2040;
        width: 220px;
        min-width: 120px;
        max-width: 220px;
        left: 98px;
    }

    .thCT05-col {
        position: sticky;
        background-color: #ededed;
        z-index: 2040;
        width: 250px;
        min-width: 120px;
        max-width: 250px;
        left: 314px;
    }

    .foCT05-col {
        position: sticky;
        background-color: #ededed;
        z-index: 2040;
        width: 200px;
        min-width: 100px;
        max-width: 200px;
        left: 479px;
    }

    .fiCT05-col {
        position: sticky;
        background-color: #ededed;
        z-index: 2040;
        width: 200px;
        min-width: 100px;
        max-width: 200px;
        left: 645px;
    }

    .to-col {
        position: sticky;
        background-color: #f7f7f7;
        z-index: 2040;
        width: 100px;
        min-width: 100px;
        max-width: 250px;
        left: 0px;
    }
    .to1-col {
        position: sticky;
        background-color: #f7f7f7;
        z-index: 2040;
        width: 250px;
        min-width: 120px;
        max-width: 250px;
        left: 316px;
    }
    .to2-col {
        position: sticky;
        background-color: #f7f7f7;
        z-index: 2040;
        width: 200px;
        min-width: 100px;
        max-width: 200px;
        left: 481px;
    }
    .to3-col {
        position: sticky;
        background-color: #f7f7f7;
        z-index: 2040;
        width: 200px;
        min-width: 100px;
        max-width: 200px;
        left: 647px;
    }
</style>