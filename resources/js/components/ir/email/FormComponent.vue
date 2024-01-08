<template>
    <form id="submitForm" :action="urlSave" method="post" @submit.prevent="checkForm" onkeydown="return event.key != 'Enter';">
        <input type="hidden" name="_token" :value="csrf">
        <input type="hidden" name="_method" value="PUT" v-if="this.isEdit">
        <div v-loading="loading">
            <div class="row">
                <label class="col-md-4 col-form-label lable_align"><strong>ประเภทรายการ <span class="text-danger">*</span></strong></label>
                <div class="col-xl-4 col-lg-5 col-md-6 el_field">
                    <el-radio v-model="type" label="บริษัทประกันภัย" name="type" @change="getDataType('บริษัทประกันภัย')">บริษัทประกันภัย</el-radio>
                    <el-radio v-model="type" label="พนักงาน" name="type" @change="getDataType('พนักงาน')">พนักงาน</el-radio>
                    <el-radio v-model="type" label="หน่วยงาน" name="type" @change="getDataType('หน่วยงาน')">หน่วยงาน</el-radio>
                </div>
            </div>
            <div class="row mt-2" v-if="type == 'บริษัทประกันภัย'">
                <label class="col-md-4 col-form-label lable_align"><strong>ชื่อ <span class="text-danger">*</span></strong></label>
                <div class="col-xl-4 col-lg-5 col-md-6 el_field">
                    <el-input type="text" name="company_name" ref="company_name" v-model="company_name" placeholder="บริษัทประกันภัย" autocomplete="off"></el-input>
                    <!-- <input type="hidden" name="company_number" :value="company_number">
                    <el-select  v-model="company_number"
                                placeholder="บริษัทประกันภัย"
                                remote
                                clearable
                                filterable
                                ref="company_number"
                                @change="getBranchName()">
                        <el-option  v-for="(data, index) in companies"
                                    :key="index"
                                    :label="data.company_number + ' : ' + data.company_name"
                                    :value="data.company_number">
                        </el-option>
                    </el-select> -->
                    <div id="el_explode_company_name" class="error_msg text-left"></div>
                </div>
            </div>
            <!-- <div class="row mt-2" v-if="type == 'บริษัทประกันภัย'">
                <label class="col-md-4 col-form-label lable_align"><strong>รหัสสาขา</strong></label>
                <div class="col-xl-4 col-lg-5 col-md-6 el_field">
                    <el-input type="text" name="branch_name" v-model="branch_name" placeholder="รหัสสาขา" autocomplete="off" disabled></el-input>
                </div>
            </div> -->
            <div class="row mt-2" v-if="type == 'พนักงาน'">
                <label class="col-md-4 col-form-label lable_align"><strong>ชื่อ <span class="text-danger">*</span></strong></label>
                <div class="col-xl-4 col-lg-5 col-md-6 el_field">
                    <input type="hidden" name="employee_number" :value="employee_number">
                    <el-select  v-model="employee_number"
                                placeholder="พนักงาน"
                                remote
                                clearable
                                filterable
                                :remote-method="getEmployeeList"
                                :loading="loading"
                                ref="employee_number">
                        <el-option  v-for="(data, index) in employeeList"
                                    :key="index"
                                    :label="data.username + ' : ' + data.first_name + ' ' + data.last_name"
                                    :value="data.username">
                        </el-option>
                    </el-select>
                    <div id="el_explode_employee_number" class="error_msg text-left"></div>
                </div>
            </div>
            <div class="row mt-2" v-if="type == 'หน่วยงาน' || type == ''">
                <label class="col-md-4 col-form-label lable_align">
                    <strong>ชื่อ <span class="text-danger">*</span></strong>
                </label>
                <div class="col-xl-4 col-lg-5 col-md-6 el_field">
                    <el-input type="text" name="department_name" ref="department_name" v-model="department_name" placeholder="หน่วยงาน" autocomplete="off" :disabled="this.type == ''"></el-input>
                </div>
            </div>
            <div class="row mt-2">
                <label class="col-md-4 col-form-label lable_align">
                    <strong>Email <span class="text-danger">*</span></strong>
                </label>
                <div class="col-xl-4 col-lg-5 col-md-6 el_field">
                    <el-input type="text" name="email" ref="email" v-model="email" placeholder="Email" autocomplete="off"></el-input>
                    <div id="el_explode_email" class="error_msg text-left"></div>
                    <span class="text-danger">*กรณีระบุมากกว่า 1 ห้ามเว้นวรรคและต้องคั่นด้วยเครื่องหมาย ,</span>
                </div>
            </div>
            <div class="row mt-2" v-if="type == 'บริษัทประกันภัย' || type == ''">
                <label class="col-md-4 col-form-label lable_align"><strong>จัดกลุ่มหน่วยงานผู้ส่ง</strong></label>
                <div class="col-xl-4 col-lg-5 col-md-6 el_field">
                    <el-input type="text" name="input_disable" v-model="input_disable" placeholder="จัดกลุ่มหน่วยงานผู้ส่ง" autocomplete="off" disabled></el-input>
                </div>
            </div>
            <div class="row mt-2" v-if="type == 'พนักงาน' || type == 'หน่วยงาน' ">
                <label class="col-md-4 col-form-label lable_align"><strong>จัดกลุ่มหน่วยงานผู้ส่ง</strong></label>
                <div class="col-xl-4 col-lg-5 col-md-6 el_field">
                    <input type="hidden" name="department_group_code" :value="department_group_code">
                    <el-select  v-model="department_group_code"
                                placeholder="กลุ่มหน่วยงานผู้ส่ง"
                                remote
                                clearable
                                filterable
                                multiple
                                :remote-method="getDepartmentList"
                                :loading="loading"
                                @change="getDepartmentList()">
                        <el-option  v-for="(data, index) in departmentList"
                                    :key="index"
                                    :label="data.department_code + ': ' + data.description"
                                    :value="data.department_code">
                        </el-option>
                    </el-select>
                </div>
            </div>
            <div class="row mt-2">
                <label class="col-md-4 col-form-label lable_align"><strong>ผู้รับ</strong></label>
                <div class="col-xl-4 col-lg-5 col-md-6 el_field mt-2">
                    <input type="checkbox" name="to_flag" v-model="to_flag" size="small" :disabled="this.to_disable">
                </div>
            </div>
            <div class="row mt-2">
                <label class="col-md-4 col-form-label lable_align">
                <strong>สำเนา</strong>
                </label>
                <div class="col-xl-4 col-lg-5 col-md-6 el_field mt-2">
                    <input type="checkbox" name="cc_flag" v-model="cc_flag" size="small" :disabled="this.cc_disable">
                </div>
            </div>
            <div class="row mt-2">
                <label class="col-md-4 col-form-label lable_align">
                <strong>ผู้ส่ง</strong>
                </label>
                <div class="col-xl-4 col-lg-5 col-md-6 el_field mt-2">
                    <input type="checkbox" name="sender_flag" v-model="sender_flag" size="small" :disabled="this.sender_disable">
                </div>
            </div>
            <div class="row mt-2">
                <label class="col-md-4 col-form-label lable_align">
                <strong>Active</strong>
                </label>
                <div class="col-xl-4 col-lg-5 col-md-6 el_field mt-2">
                    <input type="checkbox" name="active_flag" v-model="active_flag" size="small">
                </div>
            </div>
            <div class="row">
                <div class="col-12 text-right">
                    <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                    <a :href="this.urlReset" type="button" class="btn btn-sm btn-danger"> <i class="fa fa-times"></i> ยกเลิก </a>
                </div>
            </div>
        </div>
    </form>
</template>
<script>
export default {
    props:['companies', 'departments', 'employees', 'departmentGroups', 'urlSave', 'urlReset', 'defaultValue'],
    data() {
        return { 
            type: '',
            company_name: '',
            employee_number: '',
            email: '',
            department_group_code: [],
            department_name: '',
            to_flag: false,
            cc_flag: false,
            sender_flag: false,
            active_flag: true,

            isEdit: this.defaultValue ? true : false,
            id: '',
            errors: {
                company_name: false,
                employee_number: false,
                department_name: false,
                email: false,
            },
            error: [],

            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

            loading: false,
            employeeList: this.employees,
            branch_name: '',
            to_disable: false,
            cc_disable: false,
            sender_disable: false,
            departmentList: this.departments,
            input_disable: '',
        }
    },
    mounted() {
        if (this.defaultValue) {
            if (this.defaultValue.company_flag == 'Y') {
                this.type = 'บริษัทประกันภัย';
            } else if (this.defaultValue.employee_flag == 'Y') {
                this.type = 'พนักงาน';
            } else if (this.defaultValue.department_flag == 'Y') {
                this.type = 'หน่วยงาน';
            }
            this.company_name          = this.defaultValue.company_name          ? this.defaultValue.company_name: '';
            this.employee_number       = this.defaultValue.employee_number       ? this.defaultValue.employee_number : '';
            this.email                 = this.defaultValue.email                 ? this.defaultValue.email : '';
            this.department_group_code = this.departmentGroups                   ? this.departmentGroups   : [];
            this.department_name       = this.defaultValue.department_name       ? this.defaultValue.department_name : '';
            this.to_flag               = this.defaultValue.to_flag == 'Y'  ? true : false;
            this.cc_flag               = this.defaultValue.cc_flag == 'Y'  ? true : false;
            this.sender_flag           = this.defaultValue.sender_flag == 'Y' ? true : false;
            this.active_flag           = this.defaultValue.active_flag == 'Y' ? true : false;

            this.id = this.defaultValue.email_id;

            // this.getBranchName();
        }
        if (this.type == 'บริษัทประกันภัย') {
            this.sender_disable = true;
        }
        if (this.type == 'หน่วยงาน') {
            this.to_disable = true;
            this.cc_disable = true;
        }
        if (this.type == 'พนักงาน') {
            this.cc_flag    = true;
            this.to_disable = true;
        }
        
    },
    watch:{
        errors: {
            handler(val){
                val.email           ? this.setError('email')           : this.resetError('email');

                if (this.type == 'บริษัทประกันภัย') {
                    val.company_name    ? this.setError('company_name')  : this.resetError('company_name');
                }
                if (this.type == 'พนักงาน') {
                    val.employee_number    ? this.setError('employee_number')  : this.resetError('employee_number');
                }
                if (this.type == 'หน่วยงาน') {
                    val.department_name    ? this.setError('department_name')  : this.resetError('department_name');
                }
            },
            deep: true,
        },
    },
    methods: {
        async checkForm (e) {
            var form  = $('#submitForm');
            let inputs = form.serialize();

            this.error = [];
            let errorMsg  = '';
            this.errors.company_name   = false;
            this.errors.employee_number  = false;
            this.errors.email            = false;
            this.errors.department_name  = false;

            $(submitForm).find("div[id='el_explode_company_name']").html("");
            $(submitForm).find("div[id='el_explode_employee_number']").html("");
            $(submitForm).find("div[id='el_explode_email']").html("");
            $(submitForm).find("div[id='el_explode_department_name']").html("");

            if (!this.type) {
                this.error.push('ประเภทรายการ');
                swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: this.error,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: true
                });

            } else{
                if (this.type == 'บริษัทประกันภัย') {
                    if (!this.company_name) {
                        this.errors.company_name = true;
                        errorMsg = "กรุณาเลือก บริษัทประกันภัย";
                        $(submitForm).find("div[id='el_explode_company_name']").html(errorMsg);

                        this.error.push('บริษัทประกันภัย');
                        swal({
                            title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                            text: this.error,
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                    }
                    
                } else if (this.type == 'พนักงาน') {
                    if (!this.employee_number) {
                        this.errors.employee_number = true;
                        errorMsg = "กรุณาระบุ ชื่อพนักงาน";
                        $(submitForm).find("div[id='el_explode_employee_number']").html(errorMsg);

                        this.error.push('ชื่อพนักงาน');
                        swal({
                            title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                            text: this.error,
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                    }
                } else if (this.type == 'หน่วยงาน') {
                    if (!this.department_name) {
                        this.errors.department_name = true;
                        errorMsg = "กรุณาระบุ ชื่อหน่วยงาน";
                        $(submitForm).find("div[id='el_explode_department_name']").html(errorMsg);

                        this.error.push('ชื่อหน่วยงาน');
                        swal({
                            title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                            text: this.error,
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                    }
                }
            }
            if (!this.email) {
                this.error.push('Email');
                swal({
                    title: "มีข้อผิดพลาด โปรดระบุข้อมูลดังนี้",
                    text: this.error,
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: true
                });

                this.errors.email = true;
                errorMsg = "กรุณาระบุ Email";
                $(submitForm).find("div[id='el_explode_email']").html(errorMsg);   

            }

            if (!this.error.length) {
                // เช็ครูปแบบ Email
                let myarr = this.email.split(",");
                myarr.forEach(element => {
                    let test = element.includes('@');

                    if (!test) {
                        this.error.push('Email');
                        swal({
                            title: "มีข้อผิดพลาด",
                            text: 'กรุณาระบุรูปแบบ Email ให้ถูกต้อง',
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                    }
                });

                if (!this.error.length) {
                    this.loading = true;
                    axios.get("/ir/ajax/email-check-duplicate", {
                        params: {
                            company_name:  this.company_name,
                            employee_number: this.employee_number,
                            email:           this.email,
                            department_name: this.department_name,
                            to_flag:         this.to_flag ? 'Y' : 'N',
                            cc_flag:         this.cc_flag ? 'Y' : 'N',
                            sender_flag:     this.sender_flag ? 'Y' : 'N',
                            id:              this.id,
                        }
                    })
                    .then(res => {
                        if (res.data.status == 'E') {
                            swal({
                                title: "มีข้อผิดพลาด",
                                text: res.data.msg,
                                type: "error",
                                showCancelButton: false,
                                showConfirmButton: true
                            });

                            this.loading = false;
                        }else {
                            form.submit();
                        } 
                    })
                    .catch(err => {
                         
                    });
                }
            }

            e.preventDefault();

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
        errorRef(res){
            var vm = this;
            vm.errors.company_name  = res.err.company_name;
            vm.errors.employee_number = res.err.employee_number;
            vm.errors.department_name = res.err.department_name;
            vm.errors.email           = res.err.email;
        },
        async getEmployeeList(query) {
            // this.loading = true;
            this.employeeList = [];
            await axios.get("/ir/ajax/email-get-employee", {
                params: {
                    query:  query,
                }
            })
            .then(res => {
                this.employeeList = res.data;
                // this.loading = false;
            })
            .catch(err => {
                 
            });
        },
        // getBranchName() {
        //     this.branch_name = '';

        //     if (this.company_name) {

        //         let select = this.companies.find(element => {
        //             return element.company_name == this.company_name;
        //         });

        //         this.branch_name = select.vendor_branch ? select.vendor_branch.vendor_site_code : '';
        //     }
        // },
        getDataType(data){
            this.to_flag        = false;
            this.sender_flag    = false;
            this.to_disable     = false;
            this.cc_disable     = false;
            this.sender_disable = false;
            this.cc_flag        = false;

            this.company_name        = '';
            this.employee_number       = '';
            this.email                 = '';
            this.department_group_code = '';
            this.department_name       = '';
            this.branch_name           = '';

            if (data == 'บริษัทประกันภัย') {
                this.to_flag = true;
                this.sender_disable = true;
            }
            if (data == 'หน่วยงาน') {
                this.sender_flag = true;
                this.to_disable = true;
                this.cc_disable = true;
            }
            if (data == 'พนักงาน') {
                this.cc_flag        = true;
                this.to_disable     = true;
                this.sender_disable = true;
            }
        },
        async getDepartmentList(query) {
            this.departmentList = [];
            await axios.get("/ir/ajax/email-get-department", {
                params: {
                    query:  query,
                }
            })
            .then(res => {
                this.departmentList = res.data;
            })
            .catch(err => {
                 
            });
        },
    },
}
</script>
<style lang="scss" scoped>
.error-message {
    display: flex;
    color: #ec4958;
    margin-top: 5px;

    strong {
        margin-right: 5px;
    }
}
</style>