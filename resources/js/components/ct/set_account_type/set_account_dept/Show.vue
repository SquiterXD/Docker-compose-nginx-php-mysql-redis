<template>
    <div class="container">
        <div v-if="!status.add_account_type_dept">
            <div class="row">
                <div
                    class="tw-flex tw-justify-between tw-items-center tw-mb-5 tw-w-full"
                >
                    <div>
                        <div class="title flex " v-if="tableData.length > 0">
                            <div>
                                {{ `รหัสบัญชี ${form.account_code_disp}` }}
                            </div>
                            <div class="ml-2">
                                {{ form.acc_desc }} {{ form.sub_acc_desc }}
                            </div>
                        </div>
                    </div>
                    <div class="tw-flex">
                        <a
                            :href="`/ct/set_account_type`"
                            class="btn btn-danger ml-2 btn-lg tw-w-24"
                        >
                            ย้อนกลับ
                        </a>
                        <button
                            class="btn btn-success btn-lg ml-2 tw-w-28 tw-ml-2"
                            type="button"
                            @click="addAccountTypeDept()"
                        >
                            เพิ่มหน่วยงาน
                        </button>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12">
                    <template>
                        <el-table :data="tableData" style="width: 100%">
                            <el-table-column
                                prop="dept_code"
                                label="รหัสหน่วยงาน"
                                width="180"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="dept_desc"
                                label="ชื่อหน่วยงาน"
                            >
                            </el-table-column>
                            <el-table-column
                                prop="account_type"
                                align="center"
                                label="ประเภทบัญชี"
                            >
                                <template slot-scope="scope">
                                    <el-select
                                        v-model="scope.row.account_type"
                                        filterable
                                        placeholder="หน่วยนับ"
                                        style="width: 100%"
                                        @change="updateDept(scope.row)"
                                    >
                                        <el-option
                                            v-for="(item, index) in accountType"
                                            :key="index"
                                            :label="item.label"
                                            :value="item.value"
                                        >
                                        </el-option>
                                    </el-select>
                                </template>
                            </el-table-column>
                            <el-table-column
                                align="center"
                                label="บัญชีรับโอน"
                                width="180"
                            >
                                <template slot-scope="scope">
                                    <el-checkbox
                                        :v-model="
                                            tableData[scope.$index]
                                                .transfer_account_flag
                                        "
                                        :checked="
                                            convertBoolean(
                                                tableData[scope.$index]
                                                    .transfer_account_flag
                                            )
                                        "
                                        @change="
                                            checkboxOnChange(
                                                $event,
                                                scope.row,
                                                'transfer_account_flag'
                                            )
                                        "
                                    >
                                    </el-checkbox>
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="enabled_flag"
                                align="center"
                                label="สถานะการใช้งาน"
                                width="180"
                            >
                                <template slot-scope="scope">
                                    <el-checkbox
                                        :v-model="
                                            tableData[scope.$index].enabled_flag
                                        "
                                        :checked="
                                            convertBoolean(
                                                tableData[scope.$index]
                                                    .enabled_flag
                                            )
                                        "
                                        @change="
                                            checkboxOnChange(
                                                $event,
                                                scope.row,
                                                'enabled_flag'
                                            )
                                        "
                                    >
                                    </el-checkbox>
                                </template>
                            </el-table-column>
                        </el-table>
                    </template>
                </div>
            </div>
        </div>
        <div v-else>
            <div>
                <el-table
                    border
                    :data="tableDataAddAccount"
                    style="width: 100%; font-size: 13px;"
                    @selection-change="handleSelectionChange"
                    ref="multipleTable"
                    height="500"
                >
                    <el-table-column
                        type="selection"
                        width="180"
                        align="center"
                    >
                    </el-table-column>
                    <el-table-column
                        label="รหัสหน่วยงาน"
                        header-align="center"
                        prop="dept_code"
                    >
                    </el-table-column>
                    <el-table-column
                        label="หน่วยงาน"
                        header-align="center"
                        prop="dept_desc"
                    >
                    </el-table-column>
                </el-table>
                <div class="tw-flex tw-justify-end tw-mt-5">
                    <button
                        class="btn btn-danger ml-2 btn-lg tw-w-24"
                        @click="status.add_account_type_dept = false"
                    >
                        ยกเลิก
                    </button>
                    <button
                        class="btn btn-success btn-lg ml-2 tw-w-28 tw-ml-2"
                        type="button"
                        @click="addDeptCode()"
                        :disabled="loading"
                    >
                        บันทึก
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["acc_code", "sub_acc_code"],
    data() {
        return {
            loading: false,
            form: {
                account_code_disp: "",
                acc_desc: "",
                sub_acc_desc: ""
            },
            tableData: [],
            tableDataAddAccount: [],
            ccGroups: [],
            accountType: [],
            selection_add_dept: [],
            status: {
                add_account_type_dept: false
            }
        };
    },

    created: function() {
        this.getDropdownAccountType();
    },
    mounted() {
        this.getMasterData();
    },
    methods: {
        addAccountTypeDept() {
            this.status.add_account_type_dept = true;
        },
        convertBoolean(value) {
            if (value == "Y") {
                return true;
            } else if (value == "N") {
                return false;
            }
        },
        checkboxOnChange(val, row, key) {
            // row.is_transfer = val;
            if (val) {
                row[key] = "Y";
            } else {
                row[key] = "N";
            }
            this.updateDept(row);
        },
        getMasterData() {
            this.findDept();
            this.getAddAccoutDept();
        },
        updateDept(row) {
            const form = {
                account_code_disp: this.form.account_code_disp,
                dept_code: row.dept_code,
                account_type: row.account_type,
                transfer_account_flag: row.transfer_account_flag,
                enabled_flag: row.enabled_flag
            };
            axios
                .post(`/ct/ajax/account_dept_v/update-dept`, form)
                .then(res => {
                    this.getMasterData();
                })
                .catch(err => {});
        },
        findDept() {
            axios
                .get(
                    `/ct/ajax/account_dept_v/find-dept?acc_code=${this.acc_code}&sub_acc_code=${this.sub_acc_code}`
                )
                .then(res => {
                    console.log(res.data.data[0].account_code_disp);
                    this.form.account_code_disp =
                        res.data.data[0].account_code_disp;
                    this.form.acc_desc = res.data.data[0].acc_desc;
                    this.form.sub_acc_desc = res.data.data[0].sub_acc_desc;
                    this.tableData = res.data.data;
                    // console.log(res.data.data);
                })
                .catch(err => {
                    console.log(err);
                });
        },
        getAddAccoutDept() {
            axios
                .get(
                    `/ct/ajax/account_dept_v/find-add-account?acc_code=${this.acc_code}&sub_acc_code=${this.sub_acc_code}`
                )
                .then(res => {
                    console.log("test", res.data);
                    this.tableDataAddAccount = res.data.data;
                });
        },
        async handleSelectionChange(val) {
            this.multipleSelection = val;
            console.log(val);
            let selection = [];

            val.forEach(item => {
                selection.push(item.dept_code);
            });

            this.selection_add_dept = await selection;
        },
        async addDeptCode() {
            this.loading = true;
            this.form.selection_add_dept = await this.selection_add_dept;
            axios
                .post(`/ct/ajax/account_dept_v/pkg_deptcode`, this.form)
                .then(res => {
                    console.log(res.data);
                    this.findDept();
                    this.getAddAccoutDept();
                    this.loading = false;
                    this.status.add_account_type_dept = false;
                })
                .catch(err => {})
                .then(() => {
                    this.loading = false;
                });
        },
        update(row) {
            axios
                .post("/ct/ajax/set_account_type_dept/update", {
                    acc_code: this.accCode,
                    depte_code: row.department_code,
                    acc_group: row.acc_group,
                    is_active: row.is_active
                })
                .then(response => {
                    this.$message({
                        showClose: true,
                        message: "บันทึกสำเร็จ",
                        type: "success"
                    });
                })
                .catch(function(error) {
                    this.$message({
                        showClose: true,
                        message: "ไม่สามารถบันทึกได้",
                        type: "error"
                    });
                });
        },
        getDropdownAccountType() {
            axios
                .get("/ct/ajax/account_type")
                .then(res => {
                    this.accountType = res.data;
                })
                .catch(err => {
                    console.log(err.response.data);
                });
        },
        getCcGroups() {
            let $this = this;

            axios
                .get("/ct/ajax/cc_group")
                .then(response => {
                    $this.ccGroups = response.data;
                })
                .catch(function(error) {
                    console.log("error: ", error);
                });
        }
    }
};
</script>
<style lang="scss">
.flex {
    display: flex;
}
.title {
    font-size: 18px;
    font-weight: bold;
}
</style>
