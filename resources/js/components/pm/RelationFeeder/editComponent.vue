<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                    
                <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                        <label>กลุ่มชุดเครื่องจักร</label><span class="text-danger"> *</span>
                        <input type="hidden" name="machnie_group" v-model="machnieGroup">
                        <el-input
                            v-model     ="machineDes"
                            :disabled   ="true">
                        </el-input>
                    </div>
                </div>

                <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                        <label>หัวจ่าย</label><span class="text-danger"> *</span>
                        <input type="hidden" name="feederOldValue" v-model="feederOldValue">
                        <input type="hidden" name="feeder_code" v-model="feederSelected">
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
    export default {
    props: ["relationFeeders", "feederGroups"],
    data() {
        return{
            machineDes      : this.relationFeeders ? this.relationFeeders.machine_group_s.description : '',
            machnieGroup    : this.relationFeeders ? this.relationFeeders.machnie_group : '',
            feederSelected  : this.relationFeeders ? this.relationFeeders.feeder_code : '',
            feederOldValue  : this.relationFeeders.feeder_code,
            enabled_flag    : this.relationFeeders ? this.relationFeeders.enabled_flag == "Y" ? true : false : '',
        };
    },
    mounted() {
        // this.showDate();
    },
    methods: {
        // async showDate() {
        //         if (this.start_date) {
        //             // console.log('start_date -->' + this.start_date);
        //             // console.log(moment(String(this.start_date)).format('yyyy-MM-DD'));
        //             var date1 = await helperDate.parseToDateTh(this.start_date, 'yyyy-MM-DD');
        //             this.start_date = date1;
        //         }
        //         if (this.end_date) {
        //             // console.log('end_date -->' + this.end_date);
        //             var date2 = await helperDate.parseToDateTh(this.end_date, 'yyyy-MM-DD');
        //             this.end_date = date2;
        //         }
        // },
    },
    };
</script>