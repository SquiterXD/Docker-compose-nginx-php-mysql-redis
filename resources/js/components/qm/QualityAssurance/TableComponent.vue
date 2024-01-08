<template>
    <table class="table program_info_tb">
        <thead>
            <tr>
                <th class="text-center">
                    <label>สถานะการใช้งาน</label>
                </th>
                <th class="text-center">
                    <label>กระบวนการตรวจคุณภาพบุหรี่</label>
                </th>
                <th class="text-center">
                    <label>รายละเอียด กระบวนการตรวจคุณภาพบุหรี่</label>
                </th>
                <th class="text-center">
                    <label>จำนวนตัวอย่างการตรวจสอบ</label>
                </th>
                <th class="text-center">
                    <label>หน่วยการตรวจสอบ</label>
                </th>
                <th class="text-center">
                    
                </th>
            </tr>
        </thead>
        <tbody v-loading="is_loading" v-for="(data, index) in showqualityAssuranceList" :key="index">
            <tr>
                <td class="text-center" style="vertical-align:middle;">
                    <el-checkbox v-model="data.enabledFlagShowWeb"></el-checkbox>
                </td>
                <td class="text-center" style="vertical-align:middle;">
                    <el-input   placeholder="กระบวนการตรวจคุณภาพบุหรี่" 
                                v-model="data.tobacco_qty_process"></el-input>
                </td>
                <td class="text-center" style="vertical-align:middle;">
                    <el-input   placeholder="รายละเอียดกระบวนการตรวจคุณภาพบุหรี่" 
                                v-model="data.description"></el-input>
                </td>
                <td class="text-center" style="vertical-align:middle;">
                    <el-input   placeholder="จำนวนตัวอย่างการตรวจสอบ" 
                                v-model="data.number_process_samples"></el-input>
                </td>
                <td class="text-center" style="vertical-align:middle;">
                    <el-input   placeholder="หน่วยการตรวจสอบ" 
                                v-model="data.uom_process"></el-input>
                </td>
                <td class="text-center" style="vertical-align:middle;">
                    <button class="btn btn-default"
                            @click.prevent="getTableResults(data.quality_assurance_id)">
                        <i class="fa fa-edit"></i> แสดงรายละเอียด
                    </button>
                </td>
            </tr>
            <tr v-if="data.qualityAssurance_showed">
                <td colspan="6">
                    <quality-assurance-table-results    :showqualityAssuranceLineList = "showqualityAssuranceLineList"
                                                        :showqualityAssuranceList = "showqualityAssuranceList"
                                                        :qualityAssuranceId = "qualityAssuranceId">
                    </quality-assurance-table-results>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
    export default {
        props: ['qualityAssuranceList'],
        data() {
            return{
                is_loading: false,
                showqualityAssuranceList : this.qualityAssuranceList.data,
                showqualityAssuranceLineList : [],
                qualityAssuranceId: ''
            };
        },
        
        mounted(){
             
        },
        methods: {
            getTableResults(value) {
                this.showqualityAssuranceList.forEach(async (element, i)  => {
                    if(element.quality_assurance_id == value){
                        if (!this.showqualityAssuranceList[i].qualityAssurance_showed) {
                            this.is_loading = true;
                            return axios
                            .post('/qm/ajax/quality-assurance/get-table-results',{ id: value })
                            .then(res => {
                                this.showqualityAssuranceLineList = res.data.qualityAssuranceLineList;
                                this.is_loading = false;
                                this.qualityAssuranceId = value;
                                this.showqualityAssuranceList[i].qualityAssurance_showed = true;
                            });
                        }
                    }else{
                        this.showqualityAssuranceList[i].qualityAssurance_showed = false;
                    }
                });
            },  
        }
    };

</script>