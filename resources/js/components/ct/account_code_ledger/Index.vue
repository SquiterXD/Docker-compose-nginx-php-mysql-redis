<template>
    <div>
        <div class="ibox">
            <div class="ibox-content">
                <form :action="search_data.search_url" id="searchForm" v-loading="loading">
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">รายการบัญชี</label>
                        <div class="col-md-4 flex-wrap">
                            <el-select
                                style="width: 100%"
                                placeholder="รายการบัญชี"
                                clearable
                                filterable
                                v-model="ac_ledger_id"
                                @change="getTableData()">
                                <el-option
                                    v-for="list in acLedgerLists"
                                    :key="list.value"
                                    :label="list.label"
                                    :value="list.value">
                                </el-option>
                            </el-select>
                        </div>
                    </div>

                    <input type="hidden" name="ac_ledger_id" :value="ac_ledger_id">

                    <!-- เพิ่มค้นหารหัสบัญชีและหน่วยงานได้ -->
                     <!-- v-if="ac_ledger_id" -->
                    <div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">รหัสบัญชี</label>
                            <div class="col-md-4 flex-wrap">
                                <el-select
                                    style="width: 100%"
                                    placeholder="รหัสบัญชี"
                                    clearable
                                    filterable
                                    v-model="account_code"
                                    @change="getTableData()">
                                    <el-option
                                        v-for="list in accountLists"
                                        :key="list.value"
                                        :label="list.value + ' : ' + list.label"
                                        :value="list.value">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">หน่วยงาน</label>
                            <div class="col-md-4 flex-wrap">
                                <el-select
                                    style="width: 100%"
                                    placeholder="หน่วยงาน"
                                    clearable
                                    filterable
                                    v-model="department_code"
                                    @change="getTableData()">
                                    <el-option
                                        v-for="list in departmentLists"
                                        :key="list.value"
                                        :label="list.value + ' : ' + list.label"
                                        :value="list.value">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">ศูนย์ต้นทุน</label>
                            <div class="col-md-4 flex-wrap">
                                <el-select
                                    style="width: 100%"
                                    placeholder="ศูนย์ต้นทุน"
                                    clearable
                                    filterable
                                    v-model="cost_center"
                                    @change="getTableData()">
                                    <el-option
                                        v-for="list in costCenterLists"
                                        :key="list.value"
                                        :label="list.value + ' : ' + list.label"
                                        :value="list.value">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        
            <div v-if="isLoading">
                <div class="sk-spinner sk-spinner-wave">
                    <div class="sk-rect1"></div>
                    <div class="sk-rect2"></div>
                    <div class="sk-rect3"></div>
                    <div class="sk-rect4"></div>
                    <div class="sk-rect5"></div>
                </div>
            </div>
            <div class="ibox-content mt-3" v-if="!isLoading">

                <div class="table-responsive" style="max-height: 420px;">
                    <table class="table text-nowrap table-bordered  table-hover" style="position: sticky;">
                        <thead>
                            <tr>
                                <th class="sticky-col th-row">รายการบัญชี</th>
                                <!-- <th class="sticky-col th-row">หน่วยงาน</th> -->
                                <th class="sticky-col th-row">ศูนย์ต้นทุน</th>
                                <th class="sticky-col th-row">ORG.</th>
                                <th class="sticky-col th-row">CAT.</th>
                                <th class="sticky-col th-row">กลุ่มผลิตภัณฑ์</th>
                                <th class="sticky-col th-row">รหัสบัญชี</th>
                                <th class="sticky-col th-row">รหัสบริษัท</th>
                                <th class="sticky-col th-row">EVM</th>
                                <th class="sticky-col th-row">หน่วยงาน</th>
                                <th class="sticky-col th-row">รายละเอียดงบ</th>
                                <th class="sticky-col th-row">เหตุผลงบ</th>
                                <th class="sticky-col th-row">RES1</th>
                                <th class="sticky-col th-row">RES2</th>
                                <th class="sticky-col th-row">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="line in DataLists" @click="getDataAccount(line)">
                                <td>{{ line.ac_ledger.seq + ' : ' + line.ac_ledger.name }}</td>
                                <!-- <td>{{ line.department_code ? line.department_code :'' }}</td> -->
                                <td>{{ line.code_segment4 ? line.code_segment4 + ' : ' + line.segment4_desc : '' }}</td>
                                <td>{{ line.organization_code ? line.organization_code : '' }}</td>
                                <td>{{ line.tobacco_group_code ? line.tobacco_group_code + ' : ' + line.tobacco_group : '' }}</td>
                                <td>{{ line.product_group ? line.product_group + ' : ' + line.product_group_desc : '' }}</td>
                                <td>{{ line.code_segment9 ? line.code_segment9 + ' : ' + line.segment9_desc : '' }}</td>
                                <td>{{ line.code_segment1 ? line.code_segment1 + ' : ' + line.segment1_desc : '' }}</td>
                                <td>{{ line.code_segment2 ? line.code_segment2 + ' : ' + line.segment2_desc : '' }}</td>
                                <td>{{ line.code_segment3 ? line.code_segment3 + ' : ' + line.segment3_desc : '' }}</td>
                                <td>{{ line.code_segment7 ? line.code_segment7 + ' : ' + line.segment7_desc : '' }}</td>
                                <td>{{ line.code_segment8 ? line.code_segment8 + ' : ' + line.segment8_desc : '' }}</td>
                                <td>{{ line.code_segment11 ? line.code_segment11 + ' : ' + line.segment11_desc : '' }}</td>
                                <td>{{ line.code_segment12 ? line.code_segment12 + ' : ' + line.segment12_desc : '' }}</td>
                                <td>
                                    <a  type="button" :href="`/ct/account_code_ledger/${line.ac_ledger_detail_id}/edit`" class="btn btn-warning btn-xs">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i> แก้ไข
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="row mt-2" v-if="real_account_code">
                    <div class="col-md-4">
                        <h4 class="ml-4">{{ real_account_code }}</h4>
                    </div>
                    <div class="col-md-8">
                        <h4>{{ real_account_desc }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    props:['search_data', 'headers', 'trans_btn', 'lines', 'accounts', 'alls'],
    data() {
        return {
            loading: false,
            isLoading: false,
            
            ac_ledger_id: this.search_data.ac_ledger_id ? Number(this.search_data.ac_ledger_id) : '',
            DataLists: [],

            // เพิ่มค้นหารหัสบัญชีและหน่วยงานได้
            acLedgerLists: [],
            accountLists: [],
            departmentLists: [],
            costCenterLists: [],

            account_code:    this.search_data.account_code    ? this.search_data.account_code    : '',
            department_code: this.search_data.department_code ? this.search_data.department_code : '',
            cost_center:     this.search_data.cost_center     ? this.search_data.cost_center : '',

            real_account_code: '',
            real_account_desc: '',
        }
    },
    mounted() {
        this.getTableData();
    },
    methods: {
        async searchForm() {
            $( "#searchForm" ).submit();
        },

        async getTableData() {
            this.isLoading = true;
            this.DataLists = [];

            // if (!this.ac_ledger_id) {
            //     this.account_code    = '';
            //     this.department_code = '';
            // }
            this.real_account_code = '';
            this.real_account_desc = '';

            await axios.get("/ct/ajax/account_code_ledger/get-detail", {
                params: {
                    ac_ledger_id: this.ac_ledger_id,
                    
                    // W. 11/07/22 -เพิ่มค้นหารหัสบัญชีและหน่วยงานได้
                    account_code:    this.account_code,
                    department_code: this.department_code,
                    cost_center:     this.cost_center,
                }
            })
            .then(res => {
                // W. 11/07/22 -เพิ่มค้นหารหัสบัญชีและหน่วยงานได้
                this.DataLists        = res.data.data;
                this.accountLists     = res.data.accounts;
                this.departmentLists  = res.data.departments;
                this.acLedgerLists    = res.data.acLedgers;
                this.costCenterLists  = res.data.costCenters;
                this.isLoading        = false;
            });
        },

        async getDataAccount(line) {
            this.real_account_code = line.code_segment1 + '.' + line.code_segment2 + '.' + line.code_segment3 + '.' + line.code_segment4 + '.' + line.code_segment5 + '.' + line.code_segment6 + '.' + line.code_segment7 + '.' + line.code_segment8 + '.' + line.code_segment9 + '.' + line.code_segment10 + '.' + line.code_segment11 + '.' + line.code_segment12;
            this.real_account_desc = line.segment9_desc + '.' + line.segment10_desc; 
        }
    },
}
</script>
<style scope>
    .sticky-col {
        position: sticky;
        background-color: #f7f7f7;
        z-index: 9999;
    }

    .first-col {
        width: 150px;
        min-width: 100px;
        max-width: 150px;
        left: 0px;
    }

    .second-col {
        width: 150px;
        min-width: 150px;
        max-width: 150px;
        left: 116px;
        /*left: 150px;*/
    }

    .th-row {
        /* width: 250px;
        min-width: 150px;
        max-width: 250px; */
        top: 0;
        /* left: 0px; */
        /*left: 250px;*/
    }

    .fo-col {
        width: 200px;
        min-width: 150px;
        max-width: 200px;
        left: 416px;
        /*left: 400px;*/
    }

    .fi-col {
        width: 200px;
        min-width: 150px;
        max-width: 200px;
        left: 566px;
        /*left: 550px;*/
    }

    .t1-col {
        width: 200px;
        min-width: 150px;
        max-width: 200px;
        left: 0px;
    }

    .t2-col {
        width: 200px;
        min-width: 150px;
        max-width: 200px;
        left: 566px;
    }
</style>