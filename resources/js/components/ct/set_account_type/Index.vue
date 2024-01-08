<template>
    <div class="container" v-loading="loading">
         <div class=" row">
            <div class="col-md-4 flex-wrap form-group">
                <label class="col-form-label">ปีงบประมาณ</label>
                <el-select
                    style="width:100%;"
                    v-model="period_year"
                    placeholder="ปีงบประมาณ"
                    @change="selectPeriodYear()"
                >
                    <el-option label="ทั้งหมด" value="all"></el-option>
                    <el-option
                        v-for="(item, index) in option.fiscal_year"
                        :key="index"
                        :label="item.year_thai"
                        :value="item.period_year"
                    >
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <template>
                    <el-table
                        :data="tableData"
                        style="width: 100%"
                    >
                        <el-table-column
                            prop="acc_code"
                            label="รหัสบัญชี"
                            width="180"
                        >
                        </el-table-column>
                         <el-table-column
                            prop="sub_acc_code"
                            label="รหัสบัญชีย่อย"
                            width="180"
                        >
                        </el-table-column>
                        <el-table-column
                            label="ชื่อบัญชี"
                            width="180">
                            <template slot-scope="scope">
                                <div>
                                    {{`${scope.row.acc_desc} ${scope.row.sub_acc_desc || ''}`}}
                                </div>
                            </template>
                        </el-table-column>
                        <el-table-column
                            prop="account_type_desc"
                            label="ประเภทบัญชี"
                            align="center"
                        >
                            <template slot-scope="scope">
                                <el-select filterable v-model="tableData[scope.$index].account_type" placeholder="Select" @change="updateAccountType(scope.row)">
                                    <el-option
                                        v-for="item in accountType"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value">
                                    </el-option>
                                </el-select>
                            </template>
                        </el-table-column>
                        <el-table-column
                            prop="transfer_account_flag"
                            label="บัญชีรับโอน"
                            align="center">

                            <template slot-scope="scope">
                                <el-checkbox :v-model="tableData[scope.$index].transfer_account_flag" :checked="convertBoolean(tableData[scope.$index].transfer_account_flag)" 
                                @change="checkboxOnChange($event, scope.row)"></el-checkbox>
                            </template>
                        </el-table-column>
                        
                        <el-table-column
                            prop="address"
                            label="กำหนดหน่วยงาน"
                            align="center"
                        >
                            <template slot-scope="scope">
                                <a :href="`/ct/set_account_type_dept/${scope.row.acc_code}?sub_acc_code=${scope.row.sub_acc_code}`">
                                    <el-button
                                        type="primary"
                                    >หน่วยงาน
                                    </el-button>
                                </a>

                            </template>
                        </el-table-column>
                        
                    </el-table>
                </template>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
          return {
            period_year: 'all',
            tableData: [],
            ccGroups: [],
            accountType: [],
            checked: 1,
            value: "",
            loading: false,
             option: {
                fiscal_year: [],
            },
            loadingInput: {},
          }
        },
        mounted() {
            this.getAccountDeptV();
            this.getDropdownAccountType();
            this.getPeriodYears();
        },
        methods: {
            updateAccountType(row){
                axios
                    .post("/ct/ajax/account_dept_v", row)
                    .then(res => {
                        this.$message({
                            showClose: true,
                            message: 'อัพเดตสำเร็จ',
                            type: 'success'
                        });
                    })
                    .catch(err => {
                        console.log(err.response.data);
                        this.$message({
                            showClose: true,
                            message: 'อัพเดตไม่สำเร็จ',
                            type: 'error'
                        });
                    });
            },
            selectPeriodYear(){
                const period_year = this.period_year
                if (period_year == 'all') {
                    this.getAccountDeptV()
                }else {
                    let query = `?period_year=${period_year}`
                    this.getAccountDeptV(query)
                }
            },
            getPeriodYears(query) {
                this.loadingInput.fiscal_year = true;
                axios
                    .get("/ct/ajax/year-view", {
                        params: { text: query }
                    })
                    .then(res => {
                        this.option.fiscal_year = res.data;
                    });
                this.loadingInput.fiscal_year = false;
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
            getAccountDeptV(query = ''){
                this.loading = true
                axios.get(`/ct/ajax/account_dept_v${query}`)
                .then((res) => {
                    this.tableData = res.data.data
                }).catch(err =>{
                    console.log(err.response.data)
                }).then(()=>{
                    this.loading = false
                })
            },
            getListSetAccountType() {
                let $this = this;

                axios.get('/ct/ajax/set_account_type')
                .then((response) => {
                    $this.tableData = response.data;
                })
                .catch(function (error) {
                    console.log('error: ',  error);
                });
            },
            getCcGroups() {
                let $this = this;

                axios.get('/ct/ajax/cc_group')
                .then((response) => {
                    $this.ccGroups = response.data;
                })
                .catch(function (error) {
                    console.log('error: ',  error);
                });
            },
            convertBoolean(value) {
                if (value == 'Y') {
                    return true;
                }
                else if (value == 'N') {
                    return false;
                }
            },
            checkboxOnChange(val, row) {
                // row.is_transfer = val;
                if (val) {
                    row.transfer_account_flag = 'Y'
                }else{
                    row.transfer_account_flag = 'N'
                }
                this.updateAccountType(row);
            },
            update(row) {
                axios.post('/ct/ajax/set_account_type/update', {
                    acc_code: row.acc_code,
                    acc_group: row.acc_group,
                    is_transfer: row.is_transfer,
                })
                .then((response) => {
                    this.$message({
                        showClose: true,
                        message: 'บันทึกสำเร็จ',
                        type: 'success'
                    });
                })
                .catch(function (error) {
                    this.$message({
                        showClose: true,
                        message: 'ไม่สามารถบันทึกได้',
                        type: 'error'
                    });
                });

            }
        }
    }
</script>
