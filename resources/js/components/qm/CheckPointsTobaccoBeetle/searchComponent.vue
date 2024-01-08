<template>
    <div>
        <div class="row">
            <div class="col-sm-3" style="text-align:left;">
                <label class="control-label">
                    อาคาร
                </label>
                <input type="hidden" name="search[build_name]" v-model="buildName" autocomplete="off">
                <el-select  v-model="buildName"
                            filterable
                            remote
                            clearable 
                            reserve-keyword
                            style="width: 100%;"
                            placeholder="เลือก อาคาร">
                    <el-option  v-for="searchBuildName in listSearchBuildName"
                                :key="searchBuildName.build_name"
                                :label="searchBuildName.build_name"
                                :value="searchBuildName.build_name">
                    </el-option>
                </el-select>
            </div>
            <div class="col-sm-3" style="text-align:left;">
                <label class="control-label">
                    โซน
                </label>
                <input type="hidden" name="search[department_name]" v-model="departmentName" autocomplete="off">
                <el-select  v-model="departmentName"
                            filterable
                            remote
                            clearable 
                            reserve-keyword
                            style="width: 100%;"
                            placeholder="เลือก โซน">
                    <el-option  v-for="searchDepartmentName in listSearchDepartmentName"
                                :key="searchDepartmentName.department_name"
                                :label="searchDepartmentName.department_name"
                                :value="searchDepartmentName.department_name">
                    </el-option>
                </el-select>
            </div>
            <div class="col-sm-3" style="text-align:left;">
                <label class="control-label">
                    ชื่อการตรวจสอบ 
                </label>
                <input type="hidden" name="search[location_desc]" v-model="LocationDesc" autocomplete="off">
                <el-select  v-model="LocationDesc"
                            filterable
                            remote
                            clearable 
                            reserve-keyword
                            style="width: 100%;"
                            placeholder="เลือก ชื่อการตรวจสอบ">
                    <el-option  v-for="searchLocationDesc in listSearchLocationDesc"
                                :key="searchLocationDesc.location_desc"
                                :label="searchLocationDesc.location_desc"
                                :value="searchLocationDesc.location_desc">
                    </el-option>
                </el-select>
            </div>  
            <div class="col-sm-3" style="text-align:left;">
                <label class="control-label">
                    รายละเอียดจุดตรวจสอบ
                </label>
                <input type="hidden" name="search[locator_desc]" v-model="locatorDesc" autocomplete="off">
                <el-select  v-model="locatorDesc"
                            filterable
                            remote
                            clearable 
                            reserve-keyword
                            style="width: 100%;"
                            placeholder="เลือก รายละเอียดจุดตรวจสอบ">
                    <el-option  v-for="searchLocatorDesc in listSearchLocatorDesc"
                                :key="searchLocatorDesc.locator_desc"
                                :label="searchLocatorDesc.locator_desc"
                                :value="searchLocatorDesc.locator_desc">
                    </el-option>
                </el-select>
            </div>          
        </div>
        <div class="row" style="text-align: left;padding-top: 15px;">
            <div class="col-sm-3" style="text-align:left;">
                <label class="control-label">
                    สถานะการใช้งาน
                </label>
                <input type="hidden" name="search[status]" v-model="status" autocomplete="off">
                <el-select  v-model="status"
                            filterable
                            remote
                            clearable 
                            reserve-keyword
                            style="width: 100%;"
                            placeholder="เลือก สถานะการใช้งาน">
                    <el-option  v-for="option in options"
                                :key="option.value"
                                :label="option.label"
                                :value="option.value">
                    </el-option>
                </el-select>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['search', 'listSearchBuildName', 'listSearchDepartmentName', 'listSearchLocatorDesc', 'listSearchLocationDesc'],
    data() {
        return {
            options: [{
                value: 'Y',
                label: 'Active'
            },{
                value: 'N',
                label: 'Inactive'
            }],

            buildName: '',
            departmentName: '',
            locatorDesc: '',
            LocationDesc: '',
            status: this.search ? this.search.status :  '',

        };
    },
    mounted() {
        console.log(this.search);
    },
    computed:{
      
    },
    methods: {
      
    }
};
</script>