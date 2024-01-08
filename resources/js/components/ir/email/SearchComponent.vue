<template>
    <div class="row">
        <div class="col-sm-4" style="text-align:left;">
            <label>
                ชื่อบริษัท
            </label>
            <input type="hidden" name="company_name" :value="company_name">
            <el-select class="required" v-model="company_name" placeholder="ชื่อบริษัท" size="small" style="width: 100%;"  
                    filterable
                    remote
                    reserve-keyword
                    clearable
                    >
                <el-option
                    v-for="(company, index) in companies"
                    :key="index"
                    :label="company.label"
                    :value="company.value">
                </el-option>
            </el-select>
        </div>
        <div class="col-sm-4" style="text-align:left;">
            <label>
                ชื่อพนักงาน / หน่วยงาน
            </label>
            <input type="hidden" name="employee_name" :value="employee_name">
            <el-select class="required" v-model="employee_name" placeholder="ชื่อพนักงาน" size="small" style="width: 100%;"  
                    filterable
                    remote
                    reserve-keyword
                    clearable
                    >
                <el-option
                    v-for="(dataList, index) in sortArrays(dataLists)"
                    :key="index"
                    :label="dataList.label"
                    :value="dataList.value">
                </el-option>
            </el-select>
        </div>
        <div class="col-sm-2" style="text-align:left;">
            <label>
                Status
            </label>
            <input type="hidden" name="status" :value="status">
            <el-select class="required" v-model="status" placeholder="status" size="small" style="width: 100%;"
                    filterable
                    remote
                    reserve-keyword
                    clearable
                    >
                <el-option
                    v-for="option in statusOptions"
                    :key="option.value"
                    :label="option.label"
                    :value="option.value">
                </el-option>
            </el-select>
        </div>
        <div class="col-sm-2">
            <label class=" tw-font-bold tw-uppercase mb-0" >&nbsp;</label>
            <div class="text-right">
                <button type="submit" class="btn btn-light btn-sm">
                    <i class="fa fa-search" aria-hidden="true"></i> ค้นหา
                </button>
                <a :href="this.actionUrl" class="btn btn-warning btn-sm"><i class="fa fa-undo"></i> รีเซต</a>
            </div>
        </div>
    </div>

</template>
<script>
    export default {
        props: ['emails', 'companies', 'employees', 'dataSearch', 'actionUrl', 'dataLists'],
        data() {
            return {
                company_name:   this.dataSearch ? this.dataSearch.company_name   : '',
                employee_name:  this.dataSearch ? this.dataSearch.employee_name  : '',
                status:         this.dataSearch ? this.dataSearch.status         : '',
                statusOptions: [{
                    value: 'Y',
                    label: 'Active'
                }, {
                    value: 'N',
                    label: 'Inactive'
                    }
                ],
            }
        },
        methods: {
            sortArrays(arrays) {
                return _.orderBy(arrays, 'label', 'asc');
            },
        },
    }
</script>
