<template>
    <div class="table-responsive">
        <div class="text-right" style="padding-bottom: 15px;padding-top: 15px;padding-right: 15px;">
            <button class="btn btn-sm btn-primary" @click.prevent="addLine"> 
                <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มรายการ 
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="font-size: small;">
                            <div>สถานะการใช้งาน</div>
                        </th>
                        <th class="text-center" style="font-size: small;">
                            <div>รายการตรวจสอบคุณภาพบุหรี่ <span class="text-danger">*</span></div>
                        </th>
                        <th class="text-center" style="font-size: small;">
                            <div>รายละเอียดการตรวจสอบคุณภาพบุหรี่ <span class="text-danger">*</span></div>
                        </th>
                        <th>

                        </th>
                    </tr>
                </thead>
                <tbody v-if="showqualityAssuranceLines.length != 0" v-loading="is_loading">
                    <tr v-for="(value, index) in showqualityAssuranceLines" :key="'showData'+ index">
                        <td class="text-center" style="vertical-align:middle;">
                           <el-checkbox v-model="value.enabledFlagShowWeb"></el-checkbox>
                        </td>
                        <td style="vertical-align:middle;">
                            <el-input placeholder="รายการตรวจสอบคุณภาพบุหรี่" v-model="value.tobacco_qty_checklist"></el-input>
                        </td>
                        <td style="vertical-align:middle;">
                            <el-input placeholder="รายละเอียดการตรวจสอบคุณภาพบุหรี่" v-model="value.description"></el-input>
                        </td>
                        <td class="text-center" style="vertical-align:middle;">
                            
                        </td>
                    </tr>
                    <tr v-for="(dataLine, index) in lines" :key="index">
                        <td class="text-center" style="vertical-align:middle;">
                           <el-checkbox v-model="dataLine.enabledFlag"></el-checkbox>
                        </td>
                        <td style="vertical-align:middle;">
                            <el-input placeholder="รายการตรวจสอบคุณภาพบุหรี่" v-model="dataLine.tobaccoQTYchecklist"></el-input>
                        </td>
                        <td style="vertical-align:middle;">
                            <el-input placeholder="รายละเอียดการตรวจสอบคุณภาพบุหรี่" v-model="dataLine.description"></el-input>
                        </td>
                        <td class="text-center" style="vertical-align:middle;">
                            <button @click.prevent="removeRow(index)" class="btn btn-sm btn-danger">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div
                                class="row justify-content-center clearfix tw-my-4"
                            >
                                <div class="col text-center">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-success"
                                        v-on:click="saveDataToTable()"
                                        :disabled="isBtnSave"
                                    >
                                        <i class="fa fa-plus"></i> บันทึก
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
                <tbody v-else v-loading="is_loading">
                    <tr v-if="checkKeyWord">
                        <td colspan="4" class="text-center" style="vertical-align: middle; width: 100%;">
                            <h2> ไม่มีข้อมูลในระบบ </h2>
                        </td>
                    </tr>
                    <tr v-for="(dataLine, index) in lines" :key="index">
                        <td class="text-center" style="vertical-align:middle;">
                           <el-checkbox v-model="dataLine.enabledFlag"></el-checkbox>
                        </td>
                        <td style="vertical-align:middle;">
                            <el-input placeholder="รายการตรวจสอบคุณภาพบุหรี่" v-model="dataLine.tobaccoQTYchecklist"></el-input>
                        </td>
                        <td style="vertical-align:middle;">
                            <el-input placeholder="รายละเอียดการตรวจสอบคุณภาพบุหรี่" v-model="dataLine.description"></el-input>
                        </td>
                        <td class="text-center" style="vertical-align:middle;">
                            <button @click.prevent="removeRow(index)" class="btn btn-sm btn-danger">
                                <i class="fa fa-times" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div
                                class="row justify-content-center clearfix tw-my-4"
                            >
                                <div class="col text-center">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-success"
                                        v-on:click="saveDataToTable()"
                                        :disabled="isBtnSave"
                                    >
                                        <i class="fa fa-plus"></i> บันทึก
                                    </button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import uuidv1 from 'uuid/v1';
export default {
    props: ['showqualityAssuranceLineList', 'showqualityAssuranceList', 'qualityAssuranceId'],
    data() {
        return {
            lines: [],
            showqualityAssuranceLines: this.showqualityAssuranceLineList,
            is_loading: false,
            isBtnSave: false,
            checkKeyWord: true
        };
    },
    mounted() { 
        
    },
    methods: {
        addLine() {
            this.lines.push({
                id : uuidv1(),
                enabledFlag : true,
                tobaccoQTYchecklist : '',
                description : '',
            });
            this.checkKeyWord = false
        },  
        removeRow: function(index) {    
            this.lines.splice(index, 1);
            if(this.lines.length == 0){
                this.checkKeyWord = true;
            } 
        },  
        saveDataToTable() {
            var newLines = {...this.lines};
            var headers = this.showqualityAssuranceList;
            var lines = this.showqualityAssuranceLines;
            var id = this.qualityAssuranceId;
            this.is_loading = true;
            if(Object.keys(newLines).length !== 0){
                if(newLines[0].description != [] && newLines[0].tobaccoQTYchecklist != []){
                    return axios
                        .post('/qm/ajax/quality-assurance/update',{ newLines,headers,lines,id })
                        .then(res => {
                            console.log(res.data.status);
                            if(res.data == "succeed"){
                                swal({
                                    title: "Success !",
                                    text: "บันทึกสำเร็จ",
                                    type: "success",
                                    showConfirmButton: true
                                });
                                this.is_loading = false;
                                setTimeout(() => {
                                    window.location.reload(false); 
                                }, 3000)
                            }
                            if(res.data.status = "ERROR"){
                                swal({
                                    title: "เกิดข้อผิดพลาก !",
                                    text: "เนื่องจาก " + res.data.err_msg,
                                    type: "error",
                                    showConfirmButton: true
                                });
                                this.is_loading = false;
                            }
                        });
                }else{
                    swal({
                        title: "คำเตือน !",
                        text: "ไม่สามารถบันทึกข้อมูลระดับ Line ได้เนื่องจากกรอกข้อมูลระดับ Line ยังไม่ครบถ้วน",
                        type: "warning",
                        showConfirmButton: true
                    });
                }
            }else{
                return axios
                        .post('/qm/ajax/quality-assurance/update',{ newLines,headers,lines,id })
                        .then(res => {
                            if(res.data == "succeed"){
                                swal({
                                    title: "Success !",
                                    text: "บันทึกสำเร็จ",
                                    type: "success",
                                    showConfirmButton: true
                                });
                                this.is_loading = false;
                                setTimeout(() => {
                                    window.location.reload(false); 
                                }, 3000)
                            }
                            if(res.data.status = "ERROR"){
                                swal({
                                    title: "เกิดข้อผิดพลาก !",
                                    text: "เนื่องจาก " + res.data.err_msg,
                                    type: "error",
                                    showConfirmButton: true
                                });
                                this.is_loading = false;
                            }
                        });
            }  
        },  
    }
};
</script>
