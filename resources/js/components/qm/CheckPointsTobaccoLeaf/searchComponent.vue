<template>
    <div>
        <div class="row">
            <div class="col-sm-3" style="text-align:left;">
                <label class="control-label">
                    ชื่อจุดตรวจสอบ
                </label>
                <input type="hidden" name="search[location_desc]" v-model="locationDesc" autocomplete="off">
                <el-select  v-model="locationDesc"
                            filterable
                            remote
                            clearable 
                            reserve-keyword
                            style="width: 100%;"
                            placeholder="ชื่อจุดตรวจสอบ">
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
                            placeholder="รายละเอียดจุดตรวจสอบ">
                    <el-option  v-for="searchLocatorDesc in listSearchLocatorDesc"
                                :key="searchLocatorDesc.locator_desc"
                                :label="searchLocatorDesc.locator_desc"
                                :value="searchLocatorDesc.locator_desc">
                    </el-option>
                </el-select>
            </div>
            <div class="col-sm-3" style="text-align:left;">
                <label class="control-label">
                    กลุ่มงาน
                </label>
                <input type="hidden" name="search[qm_group]" v-model="qmGroup" autocomplete="off">
                <el-select  v-model="qmGroup"
                            filterable
                            remote
                            clearable 
                            reserve-keyword
                            style="width: 100%;"
                            placeholder="กลุ่มงาน">
                    <el-option  v-for="searchQmGroup in listSearchQmGroup"
                                :key="searchQmGroup.qm_group"
                                :label="searchQmGroup.qm_group"
                                :value="searchQmGroup.qm_group">
                    </el-option>
                </el-select>
            </div>
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
                            placeholder="สถานะ">
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
    props: ['search', 'listSearchLocationDesc', 'listSearchLocatorDesc', 'listSearchQmGroup'],
    data() {
        return {
            options: [{
                value: 'Y',
                label: 'Active'
            },{
                value: 'N',
                label: 'Inactive'
            }],

            locationDesc: this.search ? this.search.location_desc : '',
            locatorDesc: this.search ? this.search.locator_desc : '',
            qmGroup: this.search ? this.search.qm_group : '',
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
