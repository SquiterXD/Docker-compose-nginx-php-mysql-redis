<template>
    <div class="ibox">
        <div class="ibox-content">
            <div class="row">
                <div class="col-md-6">
                    <h4>{{group_type == 'expense' ? 'จัดกลุ่มบัญชีค่าใช้จ่ายตามหน่วยงาน' : 'จัดกลุ่มบัญชีงบประมาณตามหน่วยงาน' }} {{ header.dept_code }} : {{ header.description }}</h4>
                </div>
                <div class="col-md-6 text-right">
                    <button type="button" @click="openModalCreate('expense')" :class="trans_btn.create.class" >
                        เพิ่ม
                    </button>
                </div>
            </div>
            <table class="table table-borderless table-hover mt-3">
                <thead>
                    <tr style="background-color: #dcdfdb;">
                        <th>หน่วยงานที่ปั่น</th>
                        <th>จากศูนย์ต้นทุน</th>
                        <th>ถึงศูนย์ต้นทุน</th>
                        <th width="155px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(detail, index) in details">
                        <td>{{ detail.allocate_dept_code + ' : ' + detail.allocate_description }}</td>
                        <td>{{ detail.cost_code_from     + ' : ' + detail.cost_code_from_desc  }}</td>
                        <td>{{ detail.cost_code_to       + ' : ' + detail.cost_code_to_desc    }}</td>
                        <td>
                            <button type="button" :class="trans_btn.delete.class" @click="clickDelete(detail)">
                                ลบ
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="row" v-loading="loading">
                <div class="modal inmodal fade" id="modal-create" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog modal-lg" style="width: 90%; max-width:950px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h6 class="modal-title">กำหนดหน่วยงาน และศูนย์ต้นทุน</h6>
                                <small class="font-bold">
                                    &nbsp;
                                </small>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4 mt-2 text-right"><strong>หน่วยงานที่ปัน</strong></div>
                                    <div class="col-md-6">
                                        <input type="hidden" name="department_code"  :value="department_code" autocomplete="off">
                                        <el-select  v-model="department_code"
                                                        filterable
                                                        remote
                                                        reserve-keyword
                                                        clearable
                                                        class="w-100" 
                                                        placeholder="หน่วยงาน">              
                                            <el-option  v-for="(item, key) in departments"
                                                        :key="key"
                                                        :label="item.dept_code + ' : ' + item.dept_desc"
                                                        :value="item.dept_code">

                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-4 mt-2 text-right"><strong>จากศูนย์ต้นทุน</strong></div>
                                    <div class="col-md-6">
                                        <input type="hidden" name="cost_code_from"  :value="cost_code_from" autocomplete="off">
                                        <el-select  v-model="cost_code_from"
                                                        filterable
                                                        remote
                                                        reserve-keyword
                                                        clearable
                                                        class="w-100" 
                                                        placeholder="จากศูนย์ต้นทุน">              
                                            <el-option  v-for="(item, key) in allocates"
                                                        :key="key"
                                                        :label="item.cost_code + ' : ' + item.cost_code_desc"
                                                        :value="item.cost_code">

                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-4 mt-2 text-right"><strong>ถึงศูนย์ต้นทุน</strong></div>
                                    <div class="col-md-6">
                                        <input type="hidden" name="cost_code_to"  :value="cost_code_to" autocomplete="off">
                                        <el-select  v-model="cost_code_to"
                                                        filterable
                                                        remote
                                                        reserve-keyword
                                                        clearable
                                                        class="w-100" 
                                                        placeholder="ถึงศูนย์ต้นทุน">              
                                            <el-option  v-for="(item, key) in allocates"
                                                        :key="key"
                                                        :label="item.cost_code + ' : ' + item.cost_code_desc"
                                                        :value="item.cost_code">

                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-primary" @click="clickSave">
                                    <i class="fa fa-save"></i> บันทึก
                                </button>
                                <button type="button" class="btn btn-sm btn-warning" @click="closeModalCreate">
                                    ยกเลิก
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['trans_btn', 'header', 'details', 'departments', 'allocates', 'group_type', 'headerId'],
    data() {
        return {
            department_code: '',
            cost_code_from:  '',
            cost_code_to:    '',
            type:            this.group_type,
            loading: false,
        }
    },
    methods: {
        openModalCreate() {
            $('#modal-create').modal('show');
        },
        closeModalCreate() {
            $('#modal-create').modal('hide');
        },
        clickSave(){
            this.loading = true;
            let params = {
                header_id:       this.headerId,
                type:            this.group_type,
                department_code: this.department_code,
                cost_code_from:  this.cost_code_from,
                cost_code_to:    this.cost_code_to,
            };
            axios.post("/ct/ajax/grouping_expense/detail", params)
            .then(res => {
                location.reload();
                swal({
                    title: "Success",
                    text: 'บันทึกสำเร็จ',
                    timer: 3000,
                    type: "success",
                    showCancelButton: false,
                    showConfirmButton: false
                });
            })
            .catch(err => {
                swal({
                    title: "Warning",
                    text: "ไม่สามารถบันทึกได้ เนื่องจากมีข้อผิดพลาด",
                    type: "warning",
                    showCancelButton: false,
                });
            })
            .then(() => {
                this.loading = false;
            });
        },
        clickDelete(detail){
            if (this.group_type == 'expense') {
                var line_id = detail.group_exp_line_id;
            }
            if (this.group_type == 'budget') {
                var line_id = detail.group_budget_line_id;
            }
            this.loading = true;
            let params = {
                type: this.group_type,
            };
            swal({
                title: "Warning",
                text: "ยืนยันการลบข้อมูลหรือไม่?",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                closeOnCancel: true,
                showLoaderOnConfirm: true
            },
            function(isConfirm) {
                if (isConfirm) {
                    axios.post(`/ct/ajax/grouping_expense/delete-detail/${line_id}`, params)
                    .then(res => {
                        swal({
                            title: "Success",
                            text: 'ลบข้อมูลเรียบร้อยแล้ว',
                            timer: 3000,
                            type: "success",
                            showCancelButton: false,
                            showConfirmButton: false
                        });
                        location.reload();
                    })
                    .catch(err => {
                        swal({
                            title: "Warning",
                            text: "ไม่สามารถลบข้อมูลได้ เนื่องจากมีข้อผิดพลาด",
                            type: "warning",
                            showCancelButton: false,
                        });
                    })
                    .then(() => {
                        this.loading = false;
                    });
                } 
            });
            this.loading = false;
            
        }
    }
}
</script>
<style type="text/css" scope>
    .el-select-dropdown{
        z-index: 9999 !important;
    }
</style>