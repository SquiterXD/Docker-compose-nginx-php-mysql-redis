<template>
    <div>
        <div class="row">
            <div class="col-xl-3 col-md-6 el_select padding_12">
                <el-select v-model="search.status"
                           placeholder="สถานะ"
                           filterable
                           :clearable="true">
                    <el-option v-for="(data, index) in statusList"
                               :key="index"
                               :label="data.status"
                               :value="data.status"/>
                </el-select>
            </div>
            <div class="col-xl-3 col-md-6 el_select padding_12">
                <el-select v-model="search.code_asset"
                           placeholder="รหัสทรัพย์สิน"
                           filterable
                           :clearable="true">
                    <el-option v-for="(data, index) in assetNumberList"
                               :key="index"
                               :label="data.asset_number"
                               :value="data.asset_number"/>
                </el-select>
            </div>
            <div class="col-xl-3 col-md-6 el_select padding_12">
                <el-select v-model="search.code_agency"
                           placeholder="รหัสสังกัด"
                           filterable
                           :clearable="true">
                    <el-option v-for="(data, index) in departmentList"
                               :key="index"
                               :label="data.label"
                               :value="data.value"/>
                </el-select>
            </div>
            <div class="col-xl-3 padding_12 margin_auto_btn_search">
                <button type="button" class="btn btn-default" @click="clickSearch()">
                    <i class="fa fa-search"></i> ค้นหา
                </button>
                <button type="button" class="btn btn-warning" @click="clickCancel()">
                    <i class="fa fa-repeat"></i> รีเซต
                </button>
                <button type="button"
                        class="btn btn-success"
                        @click="clickCreate"
                        :disabled="!complete || funcs.checkStatusInterface(headerRow.status) || searching || checkExpenseFlag">
                    <i class="fa fa-plus"></i> เพิ่ม
                </button>
            </div>
        </div>
        <edit-table-line :isNullOrUndefined="funcs.isNullOrUndefined"
                         :formatCurrency="funcs.formatCurrency"
                         :headerRow="headerRow"
                         :insurance_amount_master="insurance_amount_master"
                         :vat_amount_master="vat_amount_master"
                         :form="form"
                         :tableLineAll="tableLineAll"
                         ref="editEditTableLine"
                         @complete="getValueComplete"
                         :setFirstLetterUpperCase="funcs.setFirstLetterUpperCase"
                         :showYearBE="funcs.showYearBE"
                         :setYearCE="funcs.setYearCE"
                         :someInterfaceNotEmpty="someInterfaceNotEmpty"
                         :revision="revision"
                         :setLabelStatusAsset="funcs.setLabelStatusAsset"
                         :vars="vars"
                         :setLabelExpenseFlag="funcs.setLabelExpenseFlag"
                         :formatfloat="funcs.formatfloat"
                         :revenue_stamp="revenue_stamp"
                         @click-row="getDataRowShowTableTotal"
                         :checkExpenseFlag="checkExpenseFlag"
                         :perPage="per_page"
                         :last-row-id="lastRowId"/>
    </div>
</template>

<script>
    import * as scripts from '../scripts'
    import editTableLine from './editTableLine'
    import moment from 'moment'
    import uuid from 'uuid/v1';

    export default {
        name: 'ir-asset-increase-edit',
        data() {
            return {
                search: {
                    status: '',
                    code_asset: '',
                    code_agency: ''
                },
                result_array: {
                    status: [],
                    code_asset: [],
                    code_agency: []
                },
                funcs: scripts.funcs,
                headerRow: {
                    header_id: '',
                    document_number: '',
                    status: '',
                    year: '',
                    asset_status: '',
                    policy_set_header_id: '',
                    policy_set_description: '',
                    count_asset: '',
                    as_of_date: '',
                    insurance_start_date: '',
                    insurance_end_date: '',
                    total_adjustment_cost: '',
                    total_cover_amount: '',
                    total_insu_amount: '',
                    total_vat_amount: '',
                    total_net_amount: '',
                    total_rec_insu_amount: '',
                    revision: '',
                    start_calculate_date: '',
                    end_calculate_date: '',
                    start_addition_date: '',
                    end_addition_date: '',
                    days: '',
                    expense_flag: '',
                },
                complete: true,
                insurance_amount_master: 0,
                vat_amount_master: 0,
                tableLineAll: [],
                form: {
                    tableLine: []
                },
                someInterfaceNotEmpty: false,
                revision: '',
                rowsLength: 0,
                vars: scripts.vars,
                prepaid_insurance: 0,
                revenue_stamp: 0,
                old_manual_insu_amount: '',
                searching: false,
                per_page: 500,

                lastRowId: -1,
                showLoading: false,
            }
        },
        props: [
            'headerId'
        ],
        methods: {
            getDefault() {
                this.loading = true;
                axios.get(`/ir/ajax/asset/input-irp/` + this.headerId + '/IRP0004')
                    .then(({data}) => {
                        this.loading = false;
                        this.result_array = {
                            status: data.status,
                            code_asset: data.asset_numbers,
                            code_agency: data.department_codes
                        }
                    })
                    .catch((error) => {
                        swal("Error", error, "error");
                    })
            },
            clickSearch() {
                let filterSearch = this.tableLineAll.filter((row, index) => {
                    row.line_number = index + 1;
                    row.line_no = index + 1;
                    let status = row.status ? row.status.toUpperCase() : row.status;
                    if (status === this.search.status && row.asset_number === this.search.code_asset && row.department_code === this.search.code_agency) {
                        return row;
                    } else if (status === this.search.status && row.asset_number === this.search.code_asset && !this.search.code_agency) {
                        return row;
                    } else if (status === this.search.status && !this.search.code_asset && row.department_code === this.search.code_agency) {
                        return row;
                    } else if (!this.search.status && row.asset_number === this.search.code_asset && row.department_code === this.search.code_agency) {
                        return row;
                    } else if (status === this.search.status && !this.search.code_asset && !this.search.code_agency) {
                        return row;
                    } else if (!this.search.status && row.asset_number === this.search.code_asset && !this.search.code_agency) {
                        return row;
                    } else if (!this.search.status && !this.search.code_asset && row.department_code === this.search.code_agency) {
                        return row;
                    } else if (!this.search.status && !this.search.code_asset && !this.search.code_agency) {
                        return row;
                    }
                });
                this.form.tableLine = filterSearch;
                if(this.search.status != '' || this.search.code_asset != '' || this.search.code_agency){
                    this.searching = true;
                }else {
                    this.searching = false;
                }
                // this.form.tableLine = filterSearch;
                // if(this.search.status != '' || this.search.code_asset != '' || this.search.code_agency){
                //     this.searching = true;
                // }else {
                //     this.searching = false;
                // }
                // let params = {
                //     header_id: this.headerId,
                //     year: this.headerId ? '' : this.headerRow.year,
                //     status: this.headerId ? '' : this.headerRow.status ? this.headerRow.status.toUpperCase() : this.headerRow.status,
                //     policy_set_header_id: this.headerId ? '' : this.headerRow.policy_set_header_id,
                //     input_status: this.search.status,
                //     input_asset: this.search.code_asset,
                //     input_department: this.search.code_agency,
                // }
                // axios.get(`/ir/ajax/asset/asset-adjust/show`, {params})
                //     .then(({data}) => {
                //         this.form.tableLine = this.setProtertyTableLine(data.data)
                //         this.rowsLength = data.data.length
                //     })
                //     .catch((error) => {
                //         swal("Error", error, "error");
                //     })
            },
            clickCancel() {
                this.search = {
                    status: '',
                    code_asset: '',
                    code_agency: ''
                };
                let filterSearch = this.tableLineAll.filter((row, index) => {return row;});
                this.form.tableLine = filterSearch;
            },
            getDataRowShowTableTotal(dataRoww) {
                if (dataRoww.old_manual_insu_amount) {
                    this.old_manual_insu_amount = +dataRoww.old_manual_insu_amount
                }
                this.form.tableLineAll = dataRoww;
            },
            clickCreate() {
                this.showLoading = true;
                this.$refs.editEditTableLine.$refs.save_table_line.validate((valid) => {
                    if (valid) {
                        // this.rowsLength++
                        this.rowsLength = this.tableLineAll.length + 1;
                        this.lastRowId = uuid();
                        let row = {
                            rowId: this.lastRowId,
                            line_no: '',
                            line_number: this.rowsLength,
                            row_num: this.rowsLength,
                            status: 'NEW',
                            asset_status: 'Y',
                            department_location_code: '',
                            department_location_desc: '',
                            department_cost_code: '',
                            department_cost_desc: '',
                            account_code: '',
                            account_desc: '',
                            asset_number: '',
                            department_code: '',
                            department_name: '',
                            location_code: '',
                            location_name: '',
                            category_code: '',
                            category_id: '',
                            category_description: '',
                            quantity: 1,
                            current_cost: '',
                            coverage_amount: '',
                            insurance_amount: '',
                            vat_amount: '',
                            net_amount: '',
                            receivable_name: '',
                            line_type: 'MANUAL',
                            insurance_start_date: '',
                            insurance_end_date: '',
                            flag: 'add',
                            year: this.headerRow.year,
                            account_id: '',
                            asset_id: '',
                            location: '',
                            adjustment_source_type: 'ADJUSTMENT',
                            adjustment_date: moment(moment().add(543, 'years')).format(this.vars.formatDate),
                            adjustment_id: '',
                            adjustment_type: 'COST',
                            adjustment_quantity: '',
                            adjustment_cost: '',
                            adjustment_amount: '',
                            original_cost: '',
                            account: {
                                company: '',
                                branch: '',
                                department: '',
                                product: '',
                                source: '',
                                account: '',
                                subAccount: '',
                                projectActivity: '',
                                interCompany: '',
                                allocation: '',
                                futureUsed1: '',
                                futureUsed2: ''
                            },
                            policy_set_header_id: this.headerRow.policy_set_header_id,
                            policy_set_description: this.headerRow.policy_set_description,
                            revision: this.someInterfaceNotEmpty ? this.revision : this.headerRow.revision,
                            expense_flag: 'N',
                            type_cost: '',
                            duty_amount: '',
                            premium_rate: this.insurance_amount_master,
                            prepaid_insurance: this.prepaid_insurance,
                            revenue_stamp: this.revenue_stamp,
                            tax: this.vat_amount_master
                        }
                        this.form.tableLine.push(row);
                        this.tableLineAll.push(row);
                        this.$nextTick(() => {
                            this.$refs.editEditTableLine.current_page = Math.ceil(this.tableLineAll.length / this.per_page);
                            this.$nextTick(() => {
                            const el = this.$el.getElementsByClassName('newLine')[0];
                            if (el) {
                                el.scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
                            }
                            this.showLoading = false;
                            });
                        });
                    } else {
                        return false;
                    }
                })
            },
            getValueComplete(value) {
                this.complete = value
            },
            getTableHeader() {
                let params = {
                    year: '',
                    revision: '',
                    policy_id_from: '',
                    policy_id_to: '',
                    str_cal: '',
                    end_cal: '',
                    str_ad: '',
                    end_ad: '',
                    location_code: '',
                    asset_status: '',
                    status: ''
                }
                axios.get(`/ir/ajax/asset/asset-adjust`, {params})
                    .then(({data}) => {
                        let rows = this.setPropertyTableHeader(data.data)
                        this.headerRow = this.setHeaderRow(rows) === undefined ? this.headerRow : this.setHeaderRow(data.data);
                        this.getDataFromMaster()
                    })
                    .catch((error) => {
                        swal("Error", error, "error");
                    })
            },
            setHeaderRow(array) {
                let data = array.find((row) => {
                    return row.header_id == this.headerId
                })
                return data
            },
            setPropertyTableHeader(array) {
                array.filter((row) => {
                    row.days = ''
                    this.funcs.calculateDateMomentTable(row)
                    return row
                })
                return array
            },
            getDataFromMaster() {
                let params = {
                    policy_set_header_id: this.headerRow.policy_set_header_id,
                    date_from: this.headerRow.start_calculate_date,
                    date_to: this.headerRow.end_calculate_date,
                    year: this.headerRow.year
                }
                axios.get(`/ir/ajax/lov/premium-rate`, {params})
                    .then(({data}) => {
                        if (data.data === '' || data.data === null || data.data === undefined) {
                            this.insurance_amount_master = 0
                            this.vat_amount_master = 0
                        } else {
                            if (this.checkValueCal(data.data.premium_rate)) { // prepaid_insurance
                                this.insurance_amount_master = 0
                            } else {
                                this.insurance_amount_master = parseFloat(data.data.premium_rate) // prepaid_insurance
                            }
                            if (this.checkValueCal(data.data.tax)) {
                                this.vat_amount_master = 0
                            } else {
                                this.vat_amount_master = parseFloat(data.data.tax)
                            }
                            if (this.checkValueCal(data.data.prepaid_insurance)) {
                                this.prepaid_insurance = 0
                            } else {
                                this.prepaid_insurance = parseFloat(data.data.prepaid_insurance)
                            }
                            if (this.checkValueCal(data.data.revenue_stamp)) {
                                this.revenue_stamp = 0
                            } else {
                                this.revenue_stamp = parseFloat(data.data.revenue_stamp)
                            }
                        }
                        this.getTableLine()
                    })
                    .catch(error => {
                        swal("Error", error, "error");
                    })
            },
            getTableLine() {
                this.showLoading = true;
                let params = {
                    header_id: this.headerId,
                    year: this.headerId ? '' : this.headerRow.year,
                    status: this.headerId ? '' : this.headerRow.status ? this.headerRow.status.toUpperCase() : this.headerRow.status,
                    policy_set_header_id: this.headerId ? '' : this.headerRow.policy_set_header_id
                }
                axios.get(`/ir/ajax/asset/asset-adjust/show`, {params})
                    .then(({data}) => {
                        this.showLoading = false;
                        this.tableLineAll = this.setProtertyTableLine(data.data);
                        let filterSearch = this.tableLineAll.filter((row, index) => {return row;});
                        this.form.tableLine = filterSearch;
                        this.rowsLength = data.data.length
                    })
                    .catch((error) => {
                        this.showLoading = false;
                        swal("Error", error, "error");
                    })
            },
            setProtertyTableLine(array) {
                return array.filter((row, index) => {
                    // row.ap_interface_status = true
                    if (row.ap_interface_status || row.ar_interface_status || row.gl_interface_status || row.interface_status) {
                        this.someInterfaceNotEmpty = true
                        this.test = +this.headerRow.revision + 1
                    }
                    row.line_no = index + 1
                    // row.line_number = row.line_number === null ? index++ : row.line_number
                    row.line_number = index + 1
                    row.rowId = uuid()
                    row.flag = 'edit'
                    row.year = this.headerRow.year
                    row.revision = this.someInterfaceNotEmpty ? this.test : this.headerRow.revision
                    row.department_location_desc = row.department_location_name
                    row.department_cost_desc = row.department_cost_name
                    row.quantity = row.original_quantity
                    row.premium_rate = row.premium_rate === null ? 0 : row.premium_rate
                    row.prepaid_insurance = row.prepaid_insurance === null ? 0 : row.prepaid_insurance
                    row.revenue_stamp = row.revenue_stamp === null ? 0 : row.revenue_stamp
                    row.tax = row.tax === null ? 0 : row.tax
                    let coverage_amount = row.coverage_amount || row.coverage_amount === 0 && row.coverage_amount !== undefined && row.coverage_amount !== null ? row.coverage_amount : 0;
                    row.coverage_amount = coverage_amount
                    let days = !this.headerRow.days ? 0 : this.headerRow.days
                    let insurance_amount = coverage_amount || coverage_amount === 0 ? coverage_amount * row.premium_rate / 100 * days / 365 : ''; // this.qtyDay, this.insurance_amount_master
                    
                    //  ปิดส่วนด่านล่างเพราะว่าไม่ต้องทำควณใหม่ มีการเก็บข้อมูลส่วนนี้แล้ว  
                    // row.insurance_amount = insurance_amount;
                    // let duty = insurance_amount || insurance_amount === 0 ? insurance_amount * 1 / 100 : 0;
                    // row.duty_amount = this.revenue_stamp != 0 ? duty : 0;
                    // row.vat_amount = insurance_amount || insurance_amount === 0 ? (insurance_amount + row.duty_amount) * this.vat_amount_master / 100 : 0; // (insurance_amount + duty) * this.vat_amount_master / 100
                    // row.net_amount = insurance_amount || insurance_amount === 0 ? +insurance_amount + +(row.duty_amount).toFixed(2) + +(row.vat_amount).toFixed(2) : 0; // insurance_amount + row.vat_amount
                    
                    
                    // row.duty_amount = this.revenue_stamp != 0 ? duty : 0;
                    // this.getDesc(row, index);

                    return row
                })
            },
            checkValueCal(value) {
                if (value === '' || value === null || value === undefined) {
                    return true
                } else {
                    return false
                }
            },
            getDesc(row, index) {
                var coa = row.account_code.split('.');
                axios.get("/ir/ajax/asset/validate-account", {
                    params: {
                        segmentAlls: coa,
                    }
                }).then(res => {
                    this.tableLineAll[index].account_code_desc = res.data.desc;
                });
            }
        },
        components: {
            editTableLine
        },
        computed: {
            statusList (){
                const list = [...new Map(this.tableLineAll.filter(item => {
                    if (item.status === '') {
                        return false; // skip
                    }
                    return true;
                }).map(item => {
                    return { status: `${item.status}` };
                }).map(item =>
                    [item['status'], item])).values()
                ].sort(function(a, b) {
                    var nameA = a.status.toUpperCase(); // ignore upper and lowercase
                    var nameB = b.status.toUpperCase(); // ignore upper and lowercase
                    if (nameA < nameB) {
                    return -1;
                    }
                    if (nameA > nameB) {
                    return 1;
                    }

                    // names must be equal
                    return 0;
                });

                return list;
            },
            assetNumberList (){
                const list = [...new Map(this.tableLineAll.filter(item => {
                    if (item.asset_number === '') {
                        return false; // skip
                    }
                    return true;
                }).map(item => {
                    return { asset_number: `${item.asset_number}` };
                }).map(item =>
                    [item['asset_number'], item])).values()
                ].sort(function(a, b) {
                    var nameA = a.asset_number.toUpperCase(); // ignore upper and lowercase
                    var nameB = b.asset_number.toUpperCase(); // ignore upper and lowercase
                    if (nameA < nameB) {
                    return -1;
                    }
                    if (nameA > nameB) {
                    return 1;
                    }

                    // names must be equal
                    return 0;
                });

                return list;
            },
            departmentList (){
                const list = [...new Map(this.tableLineAll.filter(item => {
                    if (item.department_code === '' || item.department_name === '') {
                        return false; // skip
                    }
                    return true;
                }).map(item => {
                    return { label: `${item.department_code +' : '+ item.department_name}`, value: `${item.department_code}` };
                }).map(item =>
                    [item['value'], item])).values()
                ].sort(function(a, b) {
                    var nameA = a.value.toUpperCase(); // ignore upper and lowercase
                    var nameB = b.value.toUpperCase(); // ignore upper and lowercase
                    if (nameA < nameB) {
                    return -1;
                    }
                    if (nameA > nameB) {
                    return 1;
                    }

                    // names must be equal
                    return 0;
                });

                return list;
            },
            checkExpenseFlag (){
                return this.headerRow.expense_flag === 'Y';
            }
        },
        watch: {
            // 'form.tableLine'(newVal, oldVal) {
            //     newVal.filter((row, index) => {
            //         row.line_no = index + 1
            //         row.rowId = index
            //         return row
            //     })
            // },
            tableLineAll(newVal, oldVal) {
                newVal.filter((row, index) => {
                    row.line_no = index + 1;
                    return row;
                });
            },
        },
        created() {
            this.getTableHeader()
            // this.getDefault();
        }
    }
</script>
