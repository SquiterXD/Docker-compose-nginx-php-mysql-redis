<template>
    <span>
        <!-- <button v-if="isDisableReduceBtn" class="btn btn-warning btn-md" style="padding-left: 7px;" data-toggle="modal" data-target="#modal-downtime-machine" data-backdrop="static" data-keyboard="false"> <i class="fa fa-minus-circle"></i> ปรับลดกำลังการผลิต </button> -->
        <button v-if="isDisableReduceBtn" class="btn btn-warning btn-md" style="padding-left: 7px;" @click="openModal">
            <i class="fa fa-minus-circle"></i> ปรับลดกำลังการผลิต
        </button>
        <div id="modal-downtime-machine" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg" style="width: 90%; max-width:980px;">
                <div class="modal-content" v-loading="loading">
                    <div class="modal-header">
                        <h3 style="font-size:24px; font-weight:400;" class="modal-title text-left">
                            แผนการลดกำลังการผลิต
                        </h3>
                        <button type="button" class="close" data-dismiss="modal" @click.prevent="cancel()"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    </div>
                    <div class="modal-body text-left">
                        <form id="machine-downtime-form">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th width="2%" class="text-center"> ลำดับ </th>
                                            <th width="20%" class="text-center"> ขอบเขตเครื่องจักร </th>
                                            <th width="30%" class="text-center"> รายละเอียดเครื่องจักร </th>
                                            <th width="20%" class="text-center"> วันที่เริ่มต้น </th>
                                            <th width="20%" class="text-center"> วันที่สิ้นสุด </th>
                                            <th width="2%"> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <MachineList
                                            v-for="(row, index) in machineLines"
                                            :key = "row.id"
                                            :attribute = "row"
                                            :index = "index"
                                            :header = "header"
                                            :pp-monthly = "ppMonthly"
                                            :machine-groups = "machineGroups"
                                            :machine-desc = "machineDesc"
                                            :date-format = "dateFormat"
                                            :list-machine-lines = "machineLines"
                                            @removeRow = "removeLine"
                                        />
                                    </tbody>
                                </table>
                                <button class="btn btn-sm btn-block btn-primary" type="button" @click="addMachineLine">
                                    <i class="fa fa-plus-square"></i>&nbsp; เพิ่มรายการ
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button v-if="!machineLines" type="button" :class="btnTrans.create.class + ' btn-lg tw-w-25'">
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
    import uuidv1 from 'uuid/v1';
    import MachineList from './MachineList.vue';
    export default {
        components: {
            MachineList
        },
        props:['header', 'machineGroups', 'machineDesc', 'btnTrans', 'dateFormat', 'url', 'machineDtLines', 'ppMonthly', 'validAction'],
        data() {
            return {
                loading: false,
                isDisableReduceBtn: false,
                machineLines: [],
                // แสดงวันที่ msg
                msgDate: {
                    current_date: '',
                    start_date: '',
                    end_date: '',
                },
                // วันที่ condition
                checkDate: {
                    current_date: '',
                    start_date: '',
                    end_date: '',
                },
                removeMachineDt: [],
            }
        },
        mounted() {
            this.getDateByYearly();
            if (this.machineDtLines) {
                this.filterMachineLine();
            }
        },
        methods: {
            // Machine Downtime 28072021
            openModal() {
                if(this.validAction){
                    swal({
                        title: 'บันทึกหรือยกเลิกการเปลี่ยนแปลงข้อมูล',
                        text: '<span style="font-size: 16px; text-align: left;"> กรุณาทำการบันทึกหรือยกเลิกการเปลี่ยนแปลงให้เรียบร้อย </span>',
                        type: "warning",
                        html: true
                    })
                    return;
                }
                $('#modal-downtime-machine').modal('show');
            },
            addMachineLine() {
                this.machineLines.push({
                    id: uuidv1(),
                    line_no: '',
                    machine_group: '',
                    machine_desc: '',
                    start_date: '',
                    end_date: '',
                    is_enable: false
                });
            },
            filterMachineLine() {
                this.machineDtLines.filter(line => {
                    this.machineLines.push({
                        id: uuidv1(),
                        line_no: line.line_no,
                        machine_group: line.machine_group,
                        machine_desc: line.machine_description,
                        start_date: line.start_date,
                        end_date: line.end_date,
                        is_enable: true
                        // start_date: moment(line.start_date).format('DD-MM-YYYY'),
                        // end_date: moment(line.end_date).format('DD-MM-YYYY'),
                    });
                });
            },
            removeLine(machineLine) {
                this.machineLines = this.machineLines.filter( item => {
                    return item.id != machineLine.id
                });
                this.removeMachineDt.push(machineLine);
            },
            async cancel(){
                this.machineLines = [];
                if (this.machineDtLines) {
                    this.filterMachineLine();
                }
            },
            async submit(){
                let vm = this;
                let form = $('#machine-downtime-form');
                var valid = true;
                var msg = '';
                vm.loading = true;
                // Validate
                if (vm.machineLines.length > 0) {
                    vm.machineLines.filter((item, index) => {
                        var line_no = index+1;
                        var start_date = vm.changeTh(moment(item.start_date).format('YYYY-MM-DD'));
                        var end_date = vm.changeTh(moment(item.end_date).format('YYYY-MM-DD'));
                        if (item.machine_group == '' || item.machine_group == null){
                            valid = false;
                            vm.loading = false;
                            msg = "กรุณาเลือกขอบเขตเครื่องจักร ของรายการที่ "+line_no;
                            swal({
                                title: 'มีข้อผิดพลาด',
                                text: '<span style="font-size: 16px; text-align: left;">'+msg+'</span>',
                                type: "error",
                                html: true
                            });
                        }
                        else if (item.machine_desc == '' || item.machine_desc == null){
                            valid = false;
                            vm.loading = false;
                            msg = "กรุณาเลือกรายละเอียดเครื่องจักร ของรายการที่ "+line_no;
                            swal({
                                title: 'มีข้อผิดพลาด',
                                text: '<span style="font-size: 16px; text-align: left;">'+msg+'</span>',
                                type: "error",
                                html: true
                            });
                        }
                        else if (item.start_date == '' || item.start_date == null){
                            valid = false;
                            vm.loading = false;
                            msg = "กรุณาเลือกวันที่เริ่ม ของรายการที่ "+line_no;
                            swal({
                                title: 'มีข้อผิดพลาด',
                                text: '<span style="font-size: 16px; text-align: left;">'+msg+'</span>',
                                type: "error",
                                html: true
                            });
                        }
                        else if (item.end_date == '' || item.end_date == null){
                            valid = false;
                            vm.loading = false;
                            msg = "กรุณาเลือกวันที่สิ้นสุด ของรายการที่ "+line_no;
                            swal({
                                title: 'มีข้อผิดพลาด',
                                text: '<span style="font-size: 16px; text-align: left;">'+msg+'</span>',
                                type: "error",
                                html: true
                            });
                        }
                        else if (start_date < vm.checkDate.start_date
                            || start_date > vm.checkDate.end_date
                            || end_date < vm.checkDate.start_date
                            || end_date > vm.checkDate.end_date){
                            msg = 'รายการที่ '+line_no+' ช่วงวันที่ที่เลือกไม่อยู่ในช่วงวันที่ของปักษ์ <br> ควรระบุในช่วงวันที่ '+vm.msgDate.start_date+' ถึง '+vm.msgDate.end_date;
                            valid = false;
                            vm.loading = false;
                            swal({
                                title: 'มีข้อผิดพลาด',
                                text: '<span style="font-size: 16px; text-align: left;">'+msg+'</span>',
                                type: "error",
                                html: true
                            });
                        }
                        else if (start_date < vm.checkDate.current_date || end_date < vm.checkDate.current_date){
                            msg = 'รายการที่ '+line_no+' ไม่สามารถเลือกช่วงวันที่ย้อนหลังได้ <br> ควรระบุในช่วงวันที่ '+vm.msgDate.current_date+' ถึง '+vm.msgDate.end_date;
                            valid = false;
                            vm.loading = false;
                            swal({
                                title: 'มีข้อผิดพลาด',
                                text: '<span style="font-size: 16px; text-align: left;">'+msg+'</span>',
                                type: "error",
                                html: true
                            });
                        }
                    });
                }
                if (!valid) {
                    return;
                }

                let res = await this.create();
                // console.log(res);
                // vm.loading = false;
                if(res.status == 'S'){
                    swal({
                        title: 'ปรับลดกำลังการผลิต',
                        text: '<span style="font-size: 16px; text-align: left;"> ทำการปรับลดกำลังการผลิตเรียบร้อยแล้ว </span>',
                        type: "success",
                        html: true
                    });
                    //redirect
                    window.setTimeout(function() {
                        window.location.href = res.redirect_show_page;
                    }, 500);
                }else{
                    swal({
                        title: 'มีข้อผิดพลาด',
                        text: '<span style="font-size: 16px; text-align: left;">'+res.msg+'</span>',
                        type: "error",
                        html: true
                    });
                }
            },
            async create() {
                let vm = this;
                let data = {
                    status: '',
                    msg: ''
                };
                let params = {
                    header: vm.header,
                    machineLines: vm.machineLines,
                    removeMachineDt: vm.removeMachineDt
                };
                await axios
                .post(vm.url.machine_downtime, params)
                .then(res => {
                    data.status = res.data.status;
                    data.msg = res.data.msg;
                    data.redirect_show_page = res.data.redirect_show_page;
                })
                .catch(err => {
                    let msg = err.response.data.data;
                    data.status = 'E'
                    data.msg = msg;
                })
                .then(() => {
                    vm.loading = false;
                });
                return data;
            },
            async getDateByYearly() {
                var vm = this;
                let date_from = vm.ppMonthly.start_date;
                let date_to = vm.ppMonthly.end_date;
                let curr_date = moment().format('YYYY-MM-DD');
                var currentDate = await helperDate.parseToDateTh(curr_date, 'YYYY-MM-DD');
                var startDate = await helperDate.parseToDateTh(date_from, 'YYYY-MM-DD');
                var endDate = await helperDate.parseToDateTh(date_to, 'YYYY-MM-DD');
                // วันที่ที่ใช้แสดง MSG
                vm.msgDate.current_date = moment(currentDate).format(vm.dateFormat);
                vm.msgDate.start_date = moment(startDate).format(vm.dateFormat);
                vm.msgDate.end_date = moment(endDate).format(vm.dateFormat);
                // วันที่ที่ใช้ในการเช็คเงื่อนไข
                vm.checkDate.current_date = curr_date;
                vm.checkDate.start_date = moment(date_from).format('YYYY-MM-DD');
                vm.checkDate.end_date = moment(date_to).format('YYYY-MM-DD');
                //check การแสดงปุ่มลดการผลิต
                if((vm.checkDate.current_date <= vm.checkDate.start_date || vm.checkDate.current_date >= vm.checkDate.start_date)
                    && vm.checkDate.current_date <= vm.checkDate.end_date){
                    vm.isDisableReduceBtn = true;
                }
            },
            changeTh(dateTh){
                // เปลี่ยน Format และ เปลี่ยน พศ -> คศ
                let date = moment(dateTh, 'YYYY-MM-DD');
                if (date.isValid()) {
                    date.subtract(543, 'years');
                    console.log(date.format('YYYY-MM-DD'));
                    return date.format('YYYY-MM-DD');
                }
            }
        }
    }
</script>