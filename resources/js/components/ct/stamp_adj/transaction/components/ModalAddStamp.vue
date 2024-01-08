<template>
    <span>
        <button type="button" class="btn btn-inline-block btn-sm btn-primary tw-w-40"
            @click="addStampOther()">
            <i class="fa fa-plus tw-mr-1"></i> อัพเดตรายการ
        </button>

        <div class="modal fade" id="modal_stamp" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width:950px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 style="font-size:22px; font-weight:400;" class="modal-title text-left">
                            อัพเดตรายการบุหรี่ / ยาเส้น
                        </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click.prevent="cancel()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-left" v-loading="loading">
                        <form id="add-stamp-form">
                            <!-- table add item -->
                            <table class="table table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center"> ลำดับ </th>
                                        <th width="25%" class="text-center"> รหัสบุหรี่/ยาเส้น </th>
                                        <th width="35%" class="text-center"> รายละเอียด </th>
                                        <th width="15%" class="text-center"> ปริมาณจำหน่าย (มวน) </th>
                                        <th width="15%" class="text-center"> ราคาแสตมป์ต่อดวง </th>
                                        <th width="5%"> </th>
                                    </tr>
                                </thead>
                                <!-- <tbody> -->
                                <list-stamp
                                    v-for="(row, index) in stampLines"
                                    :key = "row.id"
                                    :attribute = "row"
                                    :index = "index"
                                    :list-stamp = "stamps"
                                    :listItemLines="stampLines"
                                    @removeRow = "removeLine"
                                ></list-stamp>
                                <!-- </tbody> -->
                            </table>
                            <button class="btn btn-sm btn-block btn-primary" type="button" @click="addStampLine">
                                <i class="fa fa-plus-square"></i>&nbsp; เพิ่มรายการ
                            </button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button v-if="!stampLines" type="button" :class="btnTrans.create.class + ' btn-lg tw-w-25'">
                            ตกลง
                        </button>
                        <button v-else type="button" @click.prevent="submit()" :class="btnTrans.create.class + ' btn-lg tw-w-25'">
                            ตกลง
                        </button>
                        <button type="button" class="btn btn-white btn-lg tw-w-25'" data-dismiss="modal" @click.prevent="cancel()"> ยกเลิก </button>
                    </div>
                </div>
            </div>
        </div>
    </span>
</template>
<script>
    import moment from "moment";
    import listStamp from './List.vue';
    import uuidv1 from 'uuid/v1';
    export default {
        components: { listStamp },
        props:['stamps', 'btnTrans', 'url', 'periodName', 'manualTemps'],
        data() {
            return {
                loading: false,
                stampLines: [],
                removeItemLines: [],
                errors:{
                    need_by_date: ''
                },
            }
        },
        mounted(){
            if (this.manualTemps.length) {
                this.manualTemps.filter(line => {
                    this.stampLines.push({
                        id: uuidv1(),
                        line_number: line.line_number,
                        item_code: line.item_code,
                        item_description: line.item_description,
                        item_quantity: line.order_quantity_carton,
                        item_price: line.unit_price,
                        enable: true
                    });
                });
            }
        },
        methods: {
            async addStampOther() {
                $('#modal_stamp').modal('show');
            },
            addStampLine() {
                this.stampLines.push({
                    id: uuidv1(),
                    line_number: '',
                    item_code: '',
                    item_description: '',
                    item_quantity: '',
                    item_price: '',
                    enable: false
                });
            },
            submit() {
                let vm = this;
                swal({
                    html: true,
                    title: '<div class="mt-4"> อัพเดตข้อมูลต้นทุนขายแยกแสตมป์และกองทุน </div>',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 16px"> ต้องการอัพเดตข้อมูลต้นทุนขายแยกแสตมป์และกองทุน ใช่หรือไม่ ? </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: vm.btnTrans.ok.text,
                    cancelButtonText: vm.btnTrans.cancel.text,
                    confirmButtonClass: vm.btnTrans.ok.class + ' btn-lg tw-w-25',
                    cancelButtonClass: vm.btnTrans.cancel.class + ' btn-lg tw-w-25',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                function(isConfirm){
                    if (isConfirm) {
                        vm.store();
                    }
                    vm.loading = false;
                });
            },
            store() {
                let vm = this;
                vm.loading = true;
                axios.post(vm.url.ajax_manaul_stamp, {
                    stampLines: vm.stampLines,
                    removeItemLines: vm.removeItemLines,
                    periodName: vm.periodName
                })
                .then(res => {
                    if(res.data.status == 'S'){
                        swal({
                            title: '<div class="mt-4"> อัพเดตข้อมูลต้นทุนขายแยกแสตมป์และกองทุน </div>',
                            text: '<span style="font-size: 15px; text-align: left;"> อัพเดตข้อมูลต้นทุนขายแยกแสตมป์และกองทุนเรียบร้อยแล้ว </span>',
                            type: "success",
                            html: true
                        });
                        $('#modal_stamp').modal('hide');
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
                        text: '<span style="font-size: 15px; text-align: left;">'+res.data.msg+'</span>',
                        type: "warning",
                        html: true
                    });
                })
                .then(() => {
                    vm.loading = false;
                });
            },
            setError(ref_name){
                let ref = this.$refs[ref_name].$refs.reference 
                        ? this.$refs[ref_name].$refs.reference.$refs.input 
                        : (this.$refs[ref_name].$refs.textarea 
                            ? this.$refs[ref_name].$refs.textarea 
                            : (this.$refs[ref_name].$refs.input.$refs 
                                ? this.$refs[ref_name].$refs.input.$refs.input 
                                : this.$refs[ref_name].$refs.input ));
                ref.style = "border: 1px solid red;";
            },
            resetError(ref_name){
                let ref = this.$refs[ref_name].$refs.reference 
                        ? this.$refs[ref_name].$refs.reference.$refs.input 
                        : (this.$refs[ref_name].$refs.textarea 
                            ? this.$refs[ref_name].$refs.textarea
                            : (this.$refs[ref_name].$refs.input.$refs 
                                ? this.$refs[ref_name].$refs.input.$refs.input 
                                : this.$refs[ref_name].$refs.input ));
                ref.style = "";
            },
            removeLine(itemLine) {
                console.log(itemLine);
                console.log(this.stampLines);
                this.stampLines = this.stampLines.filter( item => {
                    return item.id != itemLine.id
                });
                this.removeItemLines.push(itemLine);
            },
            async cancel(){
                this.stampLines = [];
                if (this.manualTemps.length) {
                    this.manualTemps.filter(line => {
                        this.stampLines.push({
                            id: uuidv1(),
                            line_number: line.line_number,
                            item_code: line.item_code,
                            item_description: line.item_description,
                            item_quantity: line.order_quantity_carton,
                            item_price: line.unit_price,
                            enable: true
                        });
                    });
                }
            },
        }
    }
</script>