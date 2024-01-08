<template>
    <div>
        <div class="ibox" style="padding-top: 50px;">
            <div class="ibox-title">
                <h5>บันทึกประวัติแทนเกรดใบยา</h5>
            </div>
            <div class="ibox-content">
                <div class="text-right" style="padding-bottom: 15px;">
                    <button class="btn btn-success" 
                            type="submit" 
                            :disabled="isDisabledBtnSave"
                            @click.prevent="save()"
                            style="margin-right: 5px;"> 
                        <i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก 
                    </button>

                    <button class="btn btn-primary" 
                            @click.prevent="addLine" 
                            :disabled="isDisabledBtnAddLine"
                            id="addLine"> 
                        <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มรายการ 
                    </button>
                </div>
                <div>
                    <table class="table table-bordered table-data" id="tableHistoryInsteadGrades">
                        <thead>
                            <tr>
                                <th class="text-center" style="vertical-align:middle;">
                                    <div>ลำดับ</div> 
                                </th>
                                <th class="text-center" style="vertical-align:middle;">
                                    <div>วันที่อนุมัติ</div>
                                </th>
                                <th class="text-center" style="vertical-align:middle;">
                                    <div>วันที่แทนเกรด</div>
                                </th>
                                <th class="text-center" style="vertical-align:middle;">
                                    <div>รหัสใบยา <span class="text-danger"> *</span></div>
                                </th>
                                <th class="text-center" style="vertical-align:middle;">
                                    <div>รายละเอียดใบยา <span class="text-danger"> *</span></div>
                                </th>
                                <th class="text-center" style="vertical-align:middle;">
                                    <div>Lot</div>
                                </th>
                                <th class="text-center" style="vertical-align:middle;">
                                    <div>ปริมาณ (%) <span class="text-danger"> *</span></div>
                                </th>
                                <th>

                                </th>
                            </tr>
                        </thead>
                        <tbody v-if="lines.length != 0 || historyList.length != 0">
                            <!-- st add line -->
                            <tr v-for="(line, index) in lines" :key="index" :row="index">
                                <td  class="text-center" style="min-width: inherit; vertical-align:middle;">                                    
                                    <!-- {{ line.seqNumber = Number(lastNumberSeq)+(index+1) }} -->
                                    {{ line.seqNumber }}
                                </td>
                                <td class="text-center" style="vertical-align:middle;">
                                    <datepicker-th
                                        style="width: 100%"
                                        class="form-control md:tw-mb-0 tw-mb-2"
                                        v-model="line.approved_date"
                                        placeholder="โปรดเลือกวันที่"
                                        :format="transDate['js-format']"
                                        :disabled="line.approvedDateDisabled"
                                        @dateWasSelected='dateApprovedDateSelected(...arguments, line, index)'
                                    />
                                </td>
                                <td class="text-center" style="min-width: inherit; vertical-align:middle;">
                                    <datepicker-th
                                        style="width: 100%"
                                        class="form-control md:tw-mb-0 tw-mb-2"
                                        v-model="line.date_instead_grades"
                                        placeholder="โปรดเลือกวันที่"
                                        :format="transDate['js-format']"  
                                        :disabled="line.dateInsteadGradeseDisabled"
                                        @dateWasSelected='dateInsteadGradesSelected(...arguments, line, index)'
                                    />
                                </td>
                                <td style="min-width: inherit; vertical-align:middle;">
                                    <el-select 
                                        v-model="line.medicinal_leaf_no" 
                                        placeholder="เลือกรหัสใบยา"
                                        class="w-100"
                                        clearable
                                        filterable
                                        reserve-keyword
                                        @change="getDescItem(line.medicinal_leaf_no, line)">
                                        <el-option
                                            v-for="(item,index) in medicinalLeafItems"
                                            :key="index"
                                            :label="item.item_code + ' : ' + item.item_desc"
                                            :value="item.item_id">
                                        </el-option>
                                    </el-select>  
                                    <span v-if="line.isValidate.medicinal_leaf_no">
                                        <span class="form-text m-b-none text-danger" style="vertical-align:middle;">
                                            {{ 'กรุณาเลือกรหัสใบยา' }}
                                        </span>
                                    </span>  
                                </td>
                                <td>
                                    <el-input
                                        style="vertical-align:middle;"
                                        placeholder=""
                                        class="w-100"
                                        v-model="line.medicinal_leaf_description"
                                        :disabled="true">
                                    </el-input> 
                                </td>
                                <td style="min-width: inherit; vertical-align:middle;">
                                    <el-select 
                                        v-model="line.lot_number" 
                                        placeholder="เลือก Lot"
                                        class="w-100"
                                        v-loading="line.loading.lot_number"
                                        :disabled="line.isDisabled.lot_number">
                                        <el-option
                                            v-for="(item,index) in line.lotNumberList"
                                            :key="index"
                                            :label="item.lot_number"
                                            :value="item.lot_number">
                                        </el-option>
                                    </el-select>
                                </td>
                                <td style="min-width: inherit; vertical-align:middle;">
                                    <vue-numeric 
                                        placeholder="ระบุจำนวนปริมาณ (%)"
                                        separator="," 
                                        v-bind:precision="2" 
                                        v-bind:minus="false"
                                        :class="'form-control w-100 text-right '+ (line.validateRemarkLimitPercent ? 'is-invalid' : '')"
                                        v-model="line.quantity_percent"
                                        @change="checkValue(line.quantity_percent, line)"
                                    ></vue-numeric>
                                    <div v-if="line.isValidate.quantity_percent">
                                        <span class="form-text m-b-none text-danger">
                                            {{ 'กรุณากรอกปริมาณ' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="text-center" style="min-width: inherit; vertical-align:middle;">
                                    <button @click.prevent="removeRow(index)" 
                                        :class="transBtn.delete.class">
                                    <i  :class="transBtn.delete.icon" aria-hidden="true"></i>
                                    </button>
                                </td> 
                            </tr>  
                            <!-- ed add line -->
                            <!-- st show data -->
                            <tr v-for="(data, row) in historyList" :key="'line'+row" :row="row">
                                <td class="text-center" style="min-width: inherit; vertical-align:middle; width : 25px;">
                                    {{ data.version_no }}
                                </td>
                                <td class="text-center" style="vertical-align:middle;">
                                    <datepicker-th
                                        style="width: 100%"
                                        class="form-control md:tw-mb-0 tw-mb-2"
                                        v-model="data.approved_date"
                                        placeholder="โปรดเลือกวันที่"
                                        :format="transDate['js-format']"
                                        disabled 
                                    />
                                </td>
                                <td class="text-center" style="min-width: inherit; vertical-align:middle;">
                                    <datepicker-th
                                        style="width: 100%"
                                        class="form-control md:tw-mb-0 tw-mb-2"
                                        v-model="data.date_instead_grades"
                                        placeholder="โปรดเลือกวันที่"
                                        :format="transDate['js-format']"  
                                        disabled 
                                    />
                                </td>
                                <td style="min-width: inherit; vertical-align:middle;">
                                    <!-- <div v-for="(sub, row) in data.history_instead_grades_d" 
                                        :key="'sub'+row" 
                                        :row="'sub'+row"
                                        style="padding-bottom: 10px;">
                                        <el-input
                                            placeholder="เลือกรหัสใบยา"
                                            v-model="sub.l_medicinal_leaf_no"
                                            :disabled="true"
                                            style="width: 100%">
                                        </el-input>
                                    </div> -->
                                    <el-input
                                        placeholder="เลือกรหัสใบยา"
                                        v-model="data.l_medicinal_leaf_no"
                                        :disabled="true"
                                        style="width: 100%">
                                    </el-input>
                                </td>
                                <td style="min-width: inherit; vertical-align:middle;">
                                    <!-- <div    v-for="(sub, row) in data.history_instead_grades_d" 
                                            :key="'sub'+row" 
                                            :row="'sub'+row"
                                            style="padding-bottom: 10px;">
                                        <div v-if="sub.medicinal_leaf_description != ''">
                                            <el-input
                                                style="vertical-align:middle;"
                                                placeholder=""
                                                class="w-100"
                                                v-model="sub.medicinal_leaf_description"
                                                :disabled="true">
                                            </el-input> 
                                        </div>
                                        <div v-else style="vertical-align:middle;">
                                            {{ '' }}
                                        </div>
                                    </div> -->
                                    <el-input
                                        placeholder="เลือกรหัสใบยา"
                                        v-model="data.medicinal_leaf_description"
                                        :disabled="true"
                                        style="width: 100%">
                                    </el-input>
                                </td>
                                <td style="min-width: inherit; vertical-align:middle;">
                                    <!-- <div    v-for="(sub, row) in data.history_instead_grades_d" 
                                            :key="'sub'+row" 
                                            :row="'sub'+row"
                                            style="padding-bottom: 10px;">
                                        <el-input
                                            style="vertical-align:middle;"
                                            placeholder="เลือก Lot"
                                            class="w-100"
                                            v-model="sub.lot_number"
                                            :disabled="true">
                                        </el-input>                                             
                                    </div> -->
                                    <el-input
                                        style="vertical-align:middle;"
                                        placeholder="เลือก Lot"
                                        class="w-100"
                                        v-model="data.lot_number"
                                        :disabled="true">
                                    </el-input>    
                                </td>
                                <td style="min-width: inherit; vertical-align:middle;">
                                    <!-- <div    v-for="(sub, row) in data.history_instead_grades_d" 
                                            :key="'sub'+row" 
                                            :row="'sub'+row" 
                                            style="padding-bottom: 14px;">
                                        <vue-numeric 
                                            placeholder="ระบุจำนวนปริมาณ (%)"
                                            separator="," 
                                            v-bind:precision="2" 
                                            v-bind:minus="false"
                                            :class="'form-control w-100 text-right'"
                                            v-model="sub.quantity_percent"
                                            :disabled="true"
                                        ></vue-numeric>                                            
                                    </div> -->
                                    <vue-numeric 
                                        placeholder="ระบุจำนวนปริมาณ (%)"
                                        separator="," 
                                        v-bind:precision="2" 
                                        v-bind:minus="false"
                                        :class="'form-control w-100 text-right'"
                                        v-model="data.quantity_percent"
                                        :disabled="true"
                                    ></vue-numeric>       
                                </td>
                                <td class="text-center" style="min-width: inherit; vertical-align:middle;">
                                    <button @click.prevent="removeRowTableData(data.history_dis_id)" 
                                        :class="transBtn.delete.class"
                                        style="vertical-align:middle;">
                                    <i  :class="transBtn.delete.icon" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>                                
                            <!-- ed show data -->
                        </tbody>  
                        <tbody v-else>
                            <tr>
                                <td colspan="8" class="text-center" style="vertical-align:middle;">
                                    ไม่มีข้อมูลในระบบ
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>                
            </div>  
        </div>
    </div>
</template>

<script>
    import moment from "moment";
    import uuidv1 from 'uuid/v1';
    import VueNumeric from 'vue-numeric';
    import DatepickerTh from '../../DatepickerTh.vue';

    export default {
    props: ['transDate', 
            'historyList', 'transBtn', 'lastNumberSeq',
            'currentDateTH', 'historyGroupByList'],
        data() {
            return {
                lines                   : [],
                arrayDataUpdate         : [],
                subLine                 : [],
                medicinalLeafItems      : [],
                isDisabledBtnAddLine    : true,
                isDisabledBtnSave       : true
            };
        },
        components: {
            VueNumeric,
            DatepickerTh
        },
        mounted() {
                   
        },
        methods: {
            addLine() {
                let vm = this;

                var params = {
                    medicinalLeafTypesH: vm.$parent.medicinalLeafH,
                    medicinalLeafTypesL: vm.$parent.medicinalLeafL,
                    medicinalItem: vm.$parent.medicinalItem
                };

                axios
                    .get('/pd/ajax/history-instead-grades/get-medicinal-leaf-item-l',{ params })
                    .then(res => {
                        vm.medicinalLeafItems = res.data.medicinalLeafItemLineList;
                    });
                
                let linelength = this.lines.length;
                this.lines.push({
                    id                          : uuidv1(),
                    seqNumber                   : Number(this.lastNumberSeq) == 0 ? 1 : Number(this.lastNumberSeq)+1+linelength,
                    // seqNumber                   : '',
                    approved_date               : (linelength) ? this.lines[0].approved_date : vm.currentDateTH,
                    date_instead_grades         : (linelength) ? this.lines[0].date_instead_grades : vm.currentDateTH,

                    approvedDateDisabled        : (linelength == 0) ? false : true,
                    dateInsteadGradeseDisabled  : (linelength == 0) ? false : true,

                    lot_number                  : '',
                    medicinal_leaf_no           : '',
                    quantity_percent            : '',
                    medicinal_leaf_description  : '',
                    medicinal_leaf_group        : '',
                    medicinalLeafItems          : vm.medicinalLeafItems,
                    lotNumberList               : [],     
                    isValidate                  : {
                        medicinal_leaf_no       : false,
                        quantity_percent        : false,
                        lot_number              : false,
                    },   
                    isDisabled:{
                        lot_number              : true,
                    },       
                    loading: {
                        lot_number              : false,
                    },
                    disabledDateTo              : '', 
                    validateRemarkLimitPercent  : false,
                    subLine                     : [],
                });   
            },

            checkValue(quantity_percent, line){
                if(quantity_percent > 100){
                    swal({
                        title: "เกิดข้อผิดพลาด !",
                        text: "ไม่สามารถกรอกตัวเลขจำนวนเกิน 100 % ได้",
                        type: "error",
                        showConfirmButton: true
                    });

                    line.validateRemarkLimitPercent = true;
                }else{
                    line.validateRemarkLimitPercent = false;
                }
            },

            dateApprovedDateSelected(date, line, index){
                line.approved_date = moment(date).format(this.transDate['oracle-format']);
                if(line.history_id){
                    line.status = 'update';
                }

                this.lines.forEach(function(element, indexForEach) {
                    if (indexForEach != index) {
                        element.approved_date = line.approved_date;
                    }
                });
            },

            dateInsteadGradesSelected(date, line, index){
                line.date_instead_grades = moment(date).format(this.transDate['oracle-format']);
                if(line.history_id){
                    line.status = 'update';
                }

                this.lines.forEach(function(element, indexForEach) {
                    if (indexForEach != index) {
                        element.date_instead_grades = line.date_instead_grades;
                    }
                });
            },

            async getDescItem(value, line){
                line.loading.lot_number = true;
                if(value){
                    this.medicinalLeafItems.forEach(element => {
                        if(element.item_id == value){
                            line.medicinal_leaf_no = element.item_code
                            line.medicinal_leaf_description = element.item_desc
                            line.medicinal_leaf_group = element.medicinal_leaf_group
                        }
                    });

                    var params = {
                        item_id: value,
                    };

                    return await axios
                        .get('/pd/ajax/history-instead-grades/get-Lot',{ params })
                        .then(res => {
                            line.lotNumberList = res.data.lotNumberList;
                            line.isDisabled.lot_number = false;
                            line.loading.lot_number = false;
                        });
                }else{
                    line.medicinal_leaf_no = '';
                    line.medicinal_leaf_description = '';
                    line.medicinal_leaf_group = '';

                    line.isDisabled.lot_number = true;
                    line.loading.lot_number = false;
                }
            },

            // changeStatus(data){
            //     if(data.history_id){
            //         data.status = 'update';
            //     }

            //     if(data.quantity_percent > 100){
            //         swal({
            //             title: "เกิดข้อผิดพลาด !",
            //             text: "ไม่สามารถกรอกตัวเลขจำนวนเกิน 100 % ได้",
            //             type: "error",
            //             showConfirmButton: true
            //         });

            //         data.validateRemarkLimitPercent = true;
            //     }else{
            //         data.validateRemarkLimitPercent = false;
            //     }
            // },

            removeRow: function(row){    
                this.lines.splice(row, 1);
            },

            async removeRowTableData(id){  
                let vm = this;  
                vm.$parent.loading.table = true;
                var params = {
                    id : id
                };

                swal({
                    title: "แน่ใจ?",
                    text: "คุณแน่ใจที่ต้องการจะลบข้อมูลชุดนี้ ?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-warning',
                    confirmButtonText: "ยืนยัน",
                    closeOnConfirm: false
                },                    
                function (isConfirm) {
                    if(isConfirm){
                        axios   .get('/pd/ajax/history-instead-grades/destroy',{ params })
                                .then( res =>{ 
                                    if(res.data.status == "SUCCESS"){
                                        swal({
                                            title: "Success !",
                                            text: "ลบข้อมูลสำเร็จ",
                                            type: "success",
                                            showConfirmButton: true
                                        });

                                        vm.$parent.loading.table = false;
                                        this.lines = [];
                                        vm.$parent.getMedicinalLeafTypesL(vm.$parent.medicinalLeafH);
                                        vm.$parent.getMedicinalLeafItemV(vm.$parent.medicinalLeafH, vm.$parent.medicinalLeafL);
                                        // vm.$parent.getMedicinalItem(vm.$parent.medicinalLeafH, vm.$parent.medicinalLeafL, vm.$parent.medicinalItem);
                                        vm.$parent.search(vm.$parent.medicinalLeafH, vm.$parent.medicinalLeafL, vm.$parent.medicinalItem);
                                        vm.isDisabledBtnAddLine  = false;
                                        vm.isDisabledBtnSave     = false;
                                    }else{
                                        swal({
                                            title: "Error !",
                                            text: "บันทึกไม่สำเร็จ เนื่องจาก "+res.err_msg,
                                            type: "error",
                                            showConfirmButton: true
                                        });

                                        vm.$parent.loading.table = false;
                                        this.lines = [];                                      
                                    }
                                });   
                    }else{
                        vm.$parent.loading.table = false;
                    }
                });  
            },

            save(){
                let canBeSaved = false;
                let vm = this;
                this.lines.forEach(element => {

                    if(element.quantity_percent > 100){
                        swal({
                            title: "เกิดข้อผิดพลาด !",
                            text: "ไม่สามารถกรอกตัวเลขจำนวนเกิน 100 % ได้",
                            type: "error",
                            showConfirmButton: true
                        });
                        return;
                    }                    
                    
                    if( element.medicinal_leaf_no && 
                        element.quantity_percent ){

                        element.isValidate.medicinal_leaf_no = false;
                        element.isValidate.quantity_percent = false;
                        canBeSaved = true;

                    }else{
                        if(!element.medicinal_leaf_no && !element.quantity_percent){
                            element.isValidate.medicinal_leaf_no = true;
                            element.isValidate.quantity_percent = true;
                            canBeSaved = false;
                            return;
                        }

                        if(!element.medicinal_leaf_no){
                            element.isValidate.medicinal_leaf_no = true;
                            canBeSaved = false;
                            return;
                        }else{
                            element.isValidate.medicinal_leaf_no = false;
                        }

                        if(!element.quantity_percent){
                            element.isValidate.quantity_percent = true;
                            canBeSaved = false;
                            return;
                        }else{
                            element.isValidate.quantity_percent = false;
                        }

                        return;
                    }

                });

                if(vm.historyList.length != 0){
                    this.arrayDataUpdate = vm.historyList.filter((row) => {
                        if(row.status == "update"){
                            return row;
                        }
                    })
                }

                if(canBeSaved || this.arrayDataUpdate.length != 0){
                    let vm = this;
                    var params = {...this.lines};
                    var params1 = vm.$parent.medicinalLeafH;
                    var params2 = vm.$parent.medicinalLeafL;
                    var params3 = this.arrayDataUpdate;
                    var params4 = vm.$parent.medicinalItem;

                    params3.forEach((element,index) => {
                        if(!element.quantity_percent > 100){
                            swal({
                                title: "เกิดข้อผิดพลาด !",
                                text: "ไม่สามารถกรอกตัวเลขจำนวนเกิน 100 % ได้",
                                type: "error",
                                showConfirmButton: true
                            });
                            return;
                        }
                    });

                    vm.$parent.loading.table = true;

                    axios
                    .post('/pd/ajax/history-instead-grades/store',{ params, params1, params2, params3, params4 })
                    .then(res => {
                        if(res.data.status == "SUCCESS"){
                            swal({
                                title: "Success !",
                                text: "บันทึกสำเร็จ",
                                type: "success",
                                showConfirmButton: true
                            });

                            vm.$parent.loading.table = false;
                            this.lines = [];
                            vm.$parent.getMedicinalLeafTypesL(vm.$parent.medicinalLeafH);
                            vm.$parent.getMedicinalLeafItemV(vm.$parent.medicinalLeafH, vm.$parent.medicinalLeafL);
                            // vm.$parent.getMedicinalItem(vm.$parent.medicinalLeafH, vm.$parent.medicinalLeafL, vm.$parent.medicinalItem);
                            vm.$parent.search(vm.$parent.medicinalLeafH, vm.$parent.medicinalLeafL, vm.$parent.medicinalItem);
                        }else{
                            swal({
                                title: "เกิดข้อผิดพลาด !",
                                text: "บันทึกไม่สำเร็จ เนื่องจาก "+res.err_msg,
                                type: "error",
                                showConfirmButton: true
                            });

                            vm.$parent.loading.table = false;
                        }
                    });
                }
            },

        }
    };
</script>
