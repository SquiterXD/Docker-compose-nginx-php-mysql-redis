<template>
    <form id="submitForm" :action="urlSave" method="post" @submit.prevent="checkForm" onkeydown="return event.key != 'Enter';">
        <input type="hidden" name="_token" :value="csrf">
        <input type="hidden" name="_method" value="PUT" v-if="this.defaultValue">
        <div> 
            <div class="row">  
                <div class="col-md-4">
                    <div>
                        <b>คำอธิบายชุดการผลิต</b> <span class="text-danger">*</span><br>
                        <small class="text-danger">(ไม่สามารถใส่คำอธิบายซ้ำกับข้อมูลที่มีในระบบ)</small>
                    </div>
                    <el-input name="routing_description" v-model="routing_description" @input="checkUpdate()" :disabled="this.disableActive"></el-input>

                    <div v-if="this.disableActive">
                        <input type="hidden" name="routing_description"  :value="this.routing_description">
                    </div>
                </div>
                <div class="col-md-4">
                    <div>
                        <b>Organization</b> 
                        <span class="text-danger">*</span>
                        <br>
                        <br/>
                    </div>
                    <input type="hidden" name="organization_code"  :value="organization_code" autocomplete="off">
                    <el-select  v-model="organization_code"
                                    filterable
                                    remote
                                    reserve-keyword
                                    clearable
                                    class="w-100" 
                                    disabled>              
                        <el-option  v-for="organization in organizations"
                                    :key="organization.organization_code"
                                    :label="organization.organization_code + ' : ' + organization.organization_desc"
                                    :value="organization.organization_code">
                        </el-option>
                    </el-select>
                </div>
                <div class="col-md-2">
                    <div>
                        <b>สถานะการใช้งาน</b> 
                        <br>
                        <br/>
                    </div>
                    <div>
                        <input type="checkbox" name="active_flag" v-model="active_flag">
                    </div>
                </div>
            </div>
    <!-- ----------------------------------- -->
    <!-- ----------------------------------- -->      
    <!-- ----------------------------------- -->
            <hr>
            <div class="mt-3">
                <div class="text-right">
                    <button class="btn btn-sm btn-success" type="submit" @click.prevent="addLine" :disabled="this.disableActive"> <i class="fa fa-plus"></i> เพิ่ม </button>
                </div>
                <table class="table table-responsive-sm">
                    <thead>
                        <tr>
                            <th width="3%"> ลำดับ </th>
                            <th> ขั้นตอนการทำงาน <span class="text-danger">*</span> </th>
                            <th> ชื่อขั้นตอนการทำงาน <span class="text-danger">*</span></th>
                            <th width="20%"> หน่วยนับผลผลิต <span class="text-danger">*</span> </th>
                            <th>WIP ที่ใช้ตัดวัตถุดิบ</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(row, index) in lines">
                            <input type="hidden" :name="'listLine['+row.id+'][status]'"  :value="row.status" autocomplete="off">
                            <td class="text-center"> {{ index + 1 }} </td>
                            <td>
                                <input type="hidden" :name="'listLine['+row.id+'][wip_step]'"  :value="row.wip_step" autocomplete="off">
                                <el-select  v-model="row.wip_step"
                                                filterable
                                                remote
                                                reserve-keyword
                                                clearable
                                                class="w-100"
                                                @change="checkDup(row, index);"
                                                :disabled="row.status == 'update'"
                                            >    
                                        <el-option  v-for="option in openClass"
                                                    :key="option.oprn_class_desc"
                                                    :label="option.oprn_class_desc"
                                                    :value="option.oprn_class_desc">
                                        </el-option>
                                </el-select>
                            </td>
                            
                            <td>
                                <el-input :name="'listLine['+row.id+'][wip_step_desc]'" v-model="row.wip_step_desc" @input="checkUpdate()" :disabled="disableActive"> </el-input>
                            </td>
                            <td>
                                <input type="hidden" :name="'listLine['+row.id+'][uom_code]'" :value="row.uom_code" autocomplete="off">
                                <el-select  v-model="row.uom_code"
                                            filterable
                                            remote
                                            reserve-keyword
                                            clearable
                                            :disabled="disableActive"
                                            @change="checkUpdate()">              
                                    <el-option  v-for="uom in uoms"
                                                :key="uom.uom_code"
                                                :label="uom.unit_of_measure"
                                                :value="uom.uom_code">
                                    </el-option>
                                </el-select>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" :name="'listLine['+row.id+'][attribute4]'" v-model="row.attribute4" :disabled="disableActive">
                            </td>
                            <td>
                                <div v-if="!row.disabledRow">
                                    <div v-if="!disableActive">
                                        <button @click.prevent="removeRow(row, index)" class="btn btn-sm btn-danger">
                                        X
                                        </button>
                                    </div>
                                </div>
                            </td>
                            
                            <div v-if="disableActive">
                                <input type="hidden" :name="'listLine['+row.id+'][wip_step_desc]'"  :value="row.wip_step_desc" autocomplete="off">
                                <input type="hidden" :name="'listLine['+row.id+'][attribute4]'"  :value="row.attribute4" autocomplete="off">
                            </div>
                        </tr>


                        <!-- -------------------------------------delete line ------------------------------------- -->
        

                        <div v-for="(row, index) in lineDelete">
                            <input type="hidden" :name="'lineDelete['+row.id+'][status]'"  :value="row.status" autocomplete="off">
                            <input type="hidden" :name="'lineDelete['+row.id+'][wip_step]'"  :value="row.wip_step" autocomplete="off">
                            <input type="hidden" :name="'lineDelete['+row.id+'][wip_step_desc]'"  :value="row.wip_step_desc" autocomplete="off">
                            <input type="hidden" :name="'lineDelete['+row.id+'][uom_code]'" :value="row.uom_code" autocomplete="off">
                            <input type="hidden" :name="'lineDelete['+row.id+'][attribute4]'" :value="row.attribute4" autocomplete="off">
                        </div>
                    </tbody>
                </table>
            </div>
            <div class="col-12 mt-3">
                <hr>
                <div class="row clearfix m-t-lg text-right">
                    <div class="col-sm-12">
                        <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                        <a :href="this.urlReset" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-times"></i> ยกเลิก </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</template>

<script>
import moment from 'moment';
import uuidv1 from 'uuid/v1';
export default {
    props: ['departments', 'uoms', 'organizations', 'openClass', 'defaultValue', 'old', 'org', 'urlSave', 'urlReset'],
    data() {
        return { 
            organization_code:   this.defaultValue            ? this.defaultValue.organization_code              : this.org,
            routing_no:          this.old.routing_no          ? this.old.routing_no          : this.defaultValue ? this.defaultValue.routing_no         : '',
            routing_description: this.old.routing_description ? this.old.routing_description : this.defaultValue ? this.defaultValue.routing_description         : '',
            active_flag:         this.old.active_flag         ? this.old.active_flag         ? true : false : this.defaultValue ? this.defaultValue.active_flag == 'Y' ? true : false : true,
            disableEdit:         this.defaultValue            ? true                         : false,

            lines                  : [],
            lineDelete             : [],

            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

            check_update: false,
            disableActive: false,
        }
    },
    mounted() {
        if (this.defaultValue) {
            if (this.defaultValue.wip_steps) {
                
                _.orderBy(this.defaultValue.wip_steps, 'wip_step_id').forEach(list_line => {
                    if (list_line.web_status != 'DELETE') {
                        this.lines.push({
                            id            : list_line.routing_step_no,
                            // id            : uuidv1(),
                            wip_step      : list_line.wip_step,
                            wip_step_desc : list_line.wip_step_desc,
                            uom_code      : list_line.uom_code,
                            attribute4    : list_line.attribute4 == 'Y' ? true : false,
                            status        : 'update',
                        });
                    }
                    
                }); 
            }else {
                this.addLine();
            }
            if (this.defaultValue.active_flag == 'N') {
                this.disableActive = true;
            }
        }else {
            this.addLine();
        }

    },
    methods:{
        addLine() {
            var today = new Date();
            var time = moment(today).format('DDMMyyyy') + String(today.getHours()) + String(today.getMinutes()) +  String(today.getSeconds());

            this.lines.push({
                // id            : time,
                id            : uuidv1(),
                wip_step      : '',
                wip_step_desc : '',
                uom_code      : '',
                status        : 'new',
                attribute4    : true,
                // disabledRow   : false,
            });
        },
        removeRow: function (row, index) {

            var vm = this;
            swal({
                title: "Warning",
                text: "ต้องการลบขั้นตอนการทำงานหรือไม่?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    vm.lineDelete.push({
                        id            : row.id,
                        wip_step      : row.wip_step,
                        wip_step_desc : row.wip_step_desc,
                        uom_code      : row.uom_code,
                        attribute4    : row.attribute4,
                        status        : 'delete',

                    });

                    vm.lines.splice(index, 1);

                    vm.checkUpdate();

                    swal({
                        title: "Success",
                        text: '',
                        timer: 3000,
                        type: "success",
                        showCancelButton: false,
                        showConfirmButton: false
                    })
                }
            });
    
            // this.lineDelete.push({
            //     id            : row.id,
            //     wip_step      : row.wip_step,
            //     wip_step_desc : row.wip_step_desc,
            //     uom_code      : row.uom_code,
            //     status        : 'delete',

            // });

            // this.lines.splice(index, 1);
        },
        async checkForm (e) {

            var form  = $('#submitForm');
            let inputs = form.serialize();
            this.errors = [];

            if (this.defaultValue) {

                if (this.check_update) {
                    if (!this.active_flag) {
                        this.errors.push('ไม่สามารถแก้ไขข้อมูลได้ เนื่องจากขั้นตอนการทำงานปิดการใช้งาน');
                        swal({
                            title: "",
                            text: this.errors,
                            timer: 3000,
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    }
                }
                
            }
            

            if (!this.routing_description) {
                this.errors.push('คำอธิบายชุดการผลิต');
                swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: this.errors,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                });
            }

            if (!this.lines.length) {
                this.errors.push('ขั้นตอนการทำงาน, ชื่อขั้นตอนการทำงาน, หน่วยนับผลผลิต');
                console.log('check validate line <---> ' + this.lines.length);
                swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: this.errors,
                    timer: 3000,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: false
                });
            }

            if (this.lines.length > 0) {
                this.lines.forEach(line => {
                    if (!line.wip_step) {
                        this.errors.push('ขั้นตอนการทำงาน');
                        swal({
                            title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                            text: this.errors,
                            timer: 3000,
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    }

                    if (!line.wip_step_desc) {
                        this.errors.push('ชื่อขั้นตอนการทำงาน');
                        swal({
                            title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                            text: this.errors,
                            timer: 3000,
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    }

                    if (!line.uom_code) {
                        this.errors.push('หน่วยนับผลผลิต');
                        swal({
                            title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                            text: this.errors,
                            timer: 3000,
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                    }
                });
                
                
            }

            if (!this.errors.length) {
                form.submit();
            }

            e.preventDefault();
        },
        checkDup(row, index) {
            if (row.wip_step) {
                if (index > 0) {
                    var idx = this.lines.find(line => {
                        if (line.id != row.id) {
                            if (row.wip_step == line.wip_step) {
                                row.wip_step = '';
                                swal({
                                    title: "มีข้อผิดพลาด",
                                    text: 'ไม่สามารถเลือกขั้นตอนการทำงานซ้ำกันได้',
                                    type: "error",
                                    showCancelButton: false,
                                    showConfirmButton: true
                                });
                            }
                        }
                    });
                }
            }
        },

        checkUpdate() {
            this.check_update = true;
        }
    },
}
</script>