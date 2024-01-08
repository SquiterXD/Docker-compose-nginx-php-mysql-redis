<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                    
                <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                        <label>กลุ่มชุดเครื่องจักร</label><span class="text-danger"> *</span>
                        <input type="hidden" name="machine" v-model="machineSelected">
                        <el-select  v-model="machineSelected" clearable filterable 
                                    placeholder="เลือกกลุ่มชุดเครื่องจักร" 
                                    class="w-100">
                            <el-option
                                v-for   ="machineGroup in machineGroups"
                                :key    ="machineGroup.lookup_code"
                                :label  ="machineGroup.description"
                                :value  ="machineGroup.lookup_code">
                            </el-option>
                        </el-select>
                    </div>
                </div>

                <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                        <label>หัวจ่าย</label><span class="text-danger"> *</span>
                        <input type="hidden" name="feeder" v-model="feederSelected">
                        <el-select  v-model="feederSelected" clearable filterable 
                                    placeholder="เลือกหัวจ่าย" 
                                    class="w-100">
                            <el-option
                                v-for   ="feederGroup in feederGroups"
                                :key    ="feederGroup.lookup_code"
                                :label  ="feederGroup.meaning"
                                :value  ="feederGroup.lookup_code">
                            </el-option>
                        </el-select>
                    </div>                        
                </div>

                <div class="row" style=" margin-left: 110px; margin-right: 110px; padding-top: 15px; padding-bottom: 15px;">
                    <div class="col">
                        <label>เปิดการใช้งาน</label>
                        <input type="hidden" name="enabled_flag" v-model="enabled_flag">
                        <el-checkbox    v-model="enabled_flag" 
                                        class="w-100"></el-checkbox>
                    </div>                                          
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import moment from "moment";
    export default {
    props: ["machineGroups", "feederGroups"],
    data() {
        return{
            machineSelected : '',
            feederSelected  : '',
            enabled_flag    : true,
        };
    },
    mounted() {
    },
    methods: {
 
    },
    };
</script>