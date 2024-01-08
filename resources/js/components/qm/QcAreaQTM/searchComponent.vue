<template>
    <div>
        <div class="row">
            <div class="col-sm-3" style="text-align:left;">
                <label class="control-label">
                    กลุ่มเครื่องจักร
                </label>
                <input type="hidden" name="search[step_description]" v-model="stepDescription" autocomplete="off">
                <el-select  v-model="stepDescription"
                            filterable
                            remote
                            clearable 
                            reserve-keyword
                            style="width: 100%;"
                            placeholder="กลุ่มเครื่องจักร">
                    <el-option  v-for="searchStepDescription in listSearchStepDescription"
                                :key="searchStepDescription.step_description"
                                :label="searchStepDescription.step_description"
                                :value="searchStepDescription.step_description">
                    </el-option>
                </el-select>
            </div>
            <div class="col-sm-3" style="text-align:left;">
                <label class="control-label">
                    ประเภทเครื่องจักร
                </label>
                <input type="hidden" name="search[machine_description]" v-model="machineDescription" autocomplete="off">
                <el-select  v-model="machineDescription"
                            filterable
                            remote
                            clearable 
                            reserve-keyword
                            style="width: 100%;"
                            placeholder="หน่วยงาน">
                    <el-option  v-for="searchMachineDescription in listSearchMachineDescription"
                                :key="searchMachineDescription.machine_description"
                                :label="searchMachineDescription.machine_description"
                                :value="searchMachineDescription.machine_description">
                    </el-option>
                </el-select>
            </div>
            <div class="col-sm-3" style="text-align:left;">
                <label class="control-label">
                    หมายเลขเครื่อง
                </label>
                <input type="hidden" name="search[machine_set]" v-model="machineSet" autocomplete="off">
                <el-select  v-model="machineSet"
                            filterable
                            remote
                            clearable 
                            reserve-keyword
                            style="width: 100%;"
                            placeholder="กลุ่มงาน">
                    <el-option  v-for="searchMachineSet in listSearchMachineSet"
                                :key="searchMachineSet.machine_set"
                                :label="searchMachineSet.machine_set"
                                :value="searchMachineSet.machine_set">
                    </el-option>
                </el-select>
            </div>
            <div class="col-sm-3" style="text-align:left;">
                <label class="control-label">
                    เขตการตรวจคุณภาพ
                </label>
                <input type="hidden" name="search[qc_area_qtm]" v-model="qcArea" autocomplete="off">
                <el-select  v-model="qcArea"
                            filterable
                            remote
                            clearable 
                            reserve-keyword
                            style="width: 100%;"
                            placeholder="ชื่อจุดตรวจสอบ">
                    <el-option  v-for="searchQcArea in listSearchQcArea"
                                :key="searchQcArea.qc_area_qtm"
                                :label="searchQcArea.qc_area_qtm"
                                :value="searchQcArea.qc_area_qtm">
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
    props: ['search', 'listSearchStepDescription', 'listSearchMachineDescription', 'listSearchMachineSet', 'listSearchQcArea',
            'oldSearch'],
    data() {
        return {
            options: [{
                value: 'Y',
                label: 'Active'
            },{
                value: 'N',
                label: 'Inactive'
            }],

            stepDescription: this.search ? this.search.step_description :'',
            machineDescription: this.search ? this.search.machine_description :'',
            machineSet: this.search ? this.search.machine_set : '',
            qcArea: this.search ? this.search.qc_area : '',
            status: this.search ? this.search.status :  '',

        };
    },
    mounted() {
        
    },
    computed:{
      
    },
    methods: {
      
    }
};
</script>
