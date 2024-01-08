<template>
    <div>
        <div class="ibox">
            <div class="row">
                <div class="col-md-6">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>จัดกลุ่มบัญชีค่าใช้จ่ายตามหน่วยงาน</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="button" @click="openModalCreate('expense')" :class="trans_btn.create.class + ' btn-xs'" >
                                    เพิ่มหน่วยงาน
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive" style="max-height: 420px;">
                            <table class="table table-borderless table-hover mt-3" style="position: sticky;">
                                <thead>
                                    <tr>
                                        <th class="sticky-col">รหัสหน่วยงาน</th>
                                        <th class="sticky-col">ชื่อหน่วยงาน</th>
                                        <th class="sticky-col" width="120px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(expense, index) in groupingExpenses">
                                        <td>{{ expense.dept_code }}</td>
                                        <td>{{ expense.description }}</td>
                                        <td>
                                            <a  type="button" :href="`/ct/grouping_expense/${expense.group_exp_head_id}/edit?type=expense`" :class="trans_btn.create.class + ' btn-xs'">
                                                จัดกลุ่มบัญชี
                                            </a>
                                            <button type="button" @click="remove('expense', expense)" :class="trans_btn.delete.class + ' btn-xs'">
                                                ลบ
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>จัดกลุ่มบัญชีงบประมาณตามหน่วยงาน</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="button" @click="openModalCreate('budget')" :class="trans_btn.create.class + ' btn-xs'" >
                                    เพิ่มหน่วยงาน
                                </button>
                            </div>
                        </div>
                        
                        <div class="table-responsive" style="max-height: 420px;">
                            <table class="table table-borderless table-hover mt-3" style="position: sticky;">
                                <thead>
                                    <tr>
                                        <th class="sticky-col">รหัสหน่วยงาน</th>
                                        <th class="sticky-col">ชื่อหน่วยงาน</th>
                                        <th class="sticky-col" width="120px;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(budget, index) in groupingBudgets">
                                        <td>{{ budget.dept_code }}</td>
                                        <td>{{ budget.description }}</td>
                                        <td>
                                            <a  type="button" :href="`/ct/grouping_expense/${budget.group_budget_head_id}/edit?type=budget`" :class="trans_btn.create.class + ' btn-xs'">
                                                จัดกลุ่มบัญชี
                                            </a>
                                            <button type="button" @click="remove('budget', budget)" :class="trans_btn.delete.class + ' btn-xs'">
                                                ลบ
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- สร้าง กลุ่มบัญชีค่าใช้จ่ายตามหน่วยงาน  Header -->
                <div class="modal inmodal fade" id="modal-createExpense" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog modal-lg" style="width: 90%; max-width:950px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h6 class="modal-title">กลุ่มบัญชีค่าใช้จ่ายตามหน่วยงาน</h6>
                                <small class="font-bold">
                                    &nbsp;
                                </small>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4 mt-2 text-right"><strong>หน่วยงาน</strong></div>
                                    <div class="col-md-6">
                                        <input type="hidden" name="expense_department_code"  :value="expense_department_code" autocomplete="off">
                                        <el-select  v-model="expense_department_code"
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
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-primary" @click="clickSave('expense')">
                                    <i class="fa fa-save"></i> บันทึก
                                </button>
                                <button type="button" class="btn btn-sm btn-warning" @click="closeModalCreate('expense')">
                                    ยกเลิก
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- สร้าง กลุ่มบัญชีงบประมาณตามหน่วยงาน  Header -->
                <div class="modal inmodal fade" id="modal-createBudget" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog modal-lg" style="width: 90%; max-width:950px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">
                                    <span aria-hidden="true">&times;</span>
                                    <span class="sr-only">Close</span>
                                </button>
                                <h6 class="modal-title">กลุ่มบัญชีงบประมาณตามหน่วยงาน</h6>
                                <small class="font-bold">
                                    &nbsp;
                                </small>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4 mt-2 text-right"><strong>หน่วยงาน</strong></div>
                                    <div class="col-md-6">
                                        <input type="hidden" name="budget_department_code"  :value="budget_department_code" autocomplete="off">
                                        <el-select  v-model="budget_department_code"
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
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-sm btn-primary" @click="clickSave('budget')">
                                    <i class="fa fa-save"></i> บันทึก
                                </button>
                                <button type="button" class="btn btn-sm btn-warning" @click="closeModalCreate('budget')">
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
    props: ['trans_btn', 'groupingExpenses', 'groupingBudgets', 'departments'],
    data() {
        return {
            expense_department_code: '',
            budget_department_code: '',
            detail: [],
        }
    },
    methods: {
        openModalCreate(type) {
            if (type == 'expense') {
                $('#modal-createExpense').modal('show');
            }
            if (type == 'budget') {
                $('#modal-createBudget').modal('show');
            }
            
        },
        closeModalCreate(type) {
            if (type == 'expense') {
                $('#modal-createExpense').modal('hide');
            }
            if (type == 'budget') {
                $('#modal-createBudget').modal('hide');
            }
        },
        clickSave(type){
            let params = {
                type:                    type,
                expense_department_code: this.expense_department_code,
                budget_department_code:  this.budget_department_code,
            };
            axios.post("/ct/ajax/grouping_expense", params)
            .then(res => {
                swal({
                    title: "Success",
                    text: 'บันทึกข้อมูลเรียบร้อยแล้ว',
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
                    text: "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากมีข้อผิดพลาด",
                    type: "warning",
                    showCancelButton: false,
                });
            })
            .then(() => {
                this.loading = false;
            });
        },
        remove(type, data){
            console.log('remove type <-> ', type);
            console.log('remove data <-> ', data);

            if (type == 'expense') {
                var headerId = data.group_exp_head_id;
            }
            if (type == 'budget') {
                var headerId = data.group_budget_head_id;
            }
            console.log('remove data <-> ', headerId);
            let params = {
                header_id: headerId,
                type:      type,
            };

            axios.get(`/ct/ajax/grouping_expense/check-detail`, { params })
            .then(({data}) => {
                console.log('check remove', data);
                if (data.length > 0) {
                    swal({
                        title: "Warning",
                        text: 'ไม่สามารถลบข้อมูลได้ เนื่องจากมีข้อมูลกลุ่มบัญชี',
                        type: "warning",
                        showCancelButton: false,
                    });
                } else {
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
                            axios.post(`/ct/ajax/grouping_expense/delete/${headerId}`, params)
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
                                    text: "ไม่สามารถลบข้อมูลได้",
                                    type: "warning",
                                    showCancelButton: false,
                                });
                            })
                            .then(() => {
                                this.loading = false;
                            });
                        } 
                    });
                }
            
            })
            .catch((error) => {
                swal({
                    title: "Warning",
                    text: "ไม่สามารถลบข้อมูลได้ เนื่องจากมีข้อผิดพลาด",
                    type: "warning",
                    showCancelButton: false,
                });
            })
        }
    }
}
</script>
<style type="text/css" scope>
    .el-select-dropdown{
        z-index: 9999 !important;
    }

    .sticky-col {
        position: sticky;
        background-color: #dcdfdb;
        z-index: 9999;
        top: 0;
    }
</style>