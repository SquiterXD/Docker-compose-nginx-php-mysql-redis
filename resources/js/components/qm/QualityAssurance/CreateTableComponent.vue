<template>
    <div>
        <table class="table program_info_tb">
            <thead>
                <tr>
                    <th class="text-center">
                        <label>สถานะการใช้งาน</label>
                    </th>
                    <th class="text-center">
                        <label>กระบวนการตรวจคุณภาพบุหรี่ <span class="text-danger">*</span></label>
                    </th>
                    <th class="text-center">
                        <label>รายละเอียดกระบวนการตรวจคุณภาพบุหรี่ <span class="text-danger">*</span></label>
                    </th>
                    <th class="text-center">
                        <label>จำนวนตัวอย่างการตรวจสอบ <span class="text-danger">*</span></label>
                    </th>
                    <th class="text-center">
                        <label>หน่วยการตรวจสอบ <span class="text-danger">*</span></label>
                    </th>
                    <th class="text-center">

                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center" style="vertical-align:middle;">
                        <input type="hidden" name="headers[enabledFlag]" v-model="headers.enabledFlag" autocomplete="off">
                        <el-checkbox v-model="headers.enabledFlag"></el-checkbox>
                    </td>
                    <td class="text-center" style="vertical-align:middle;">
                        <input type="hidden" name="headers[tobaccoQTYProcess]" v-model="headers.tobaccoQTYProcess" autocomplete="off">
                        <el-input   placeholder="กระบวนการตรวจคุณภาพบุหรี่" 
                                    v-model="headers.tobaccoQTYProcess"></el-input>
                    </td>
                    <td class="text-center" style="vertical-align:middle;">
                        <input type="hidden" name="headers[description]" v-model="headers.description" autocomplete="off">
                        <el-input   placeholder="รายละเอียดกระบวนการตรวจคุณภาพบุหรี่" 
                                    v-model="headers.description"></el-input>
                    </td>
                    <td class="text-center" style="vertical-align:middle;">
                        <input type="hidden" name="headers[numberProcessSamples]" v-model="headers.numberProcessSamples" autocomplete="off">
                        <el-input   placeholder="จำนวนตัวอย่างการตรวจสอบ" 
                                    v-model="headers.numberProcessSamples"></el-input>
                    </td>
                    <td class="text-center" style="vertical-align:middle;">
                        <input type="hidden" name="headers[UOMprocess]" v-model="headers.UOMprocess" autocomplete="off">
                        <el-input   placeholder="หน่วยการตรวจสอบ" 
                                    v-model="headers.UOMprocess"></el-input>
                    </td>
                    <td class="text-center" style="vertical-align:middle;">
                        <button class="btn btn-default"
                                @click.prevent="getTableResults()">
                            <i class="fa fa-edit"></i>
                            {{ this.addNewLine }}
                        </button>
                    </td>
                </tr>
                <tr v-if="headers.tobaccoQTYProcess_showed">
                    <td colspan="6">
                        <quality-assurance-create-table-results>
                        </quality-assurance-create-table-results>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>    
</template>

<script>
    export default {
        props: [ ],
        data() {
            return{
                headers: {
                    enabledFlag: true,
                    tobaccoQTYProcess: '',
                    description: '',
                    numberProcessSamples: '',
                    UOMprocess: '',
                    tobaccoQTYProcess_showed: false,
                },
                addNewLine: 'เพิ่มระดับ Line',
            };
        },
        
        mounted(){
             
        },
        methods: {
            getTableResults() {
                let vm = this;
                console.log(this)
                if(vm.headers.UOMprocess && vm.headers.description && vm.headers.numberProcessSamples && vm.headers.tobaccoQTYProcess){
                    vm.headers.tobaccoQTYProcess_showed = true;
                }else{
                    vm.headers.tobaccoQTYProcess_showed = false;
                    swal({
                        title: "คำเตือน !",
                        text: "ไม่สามารถเพิ่มข้อมูลระดับ Line ได้เนื่องจากกรอกข้อมูลระดับ header ยังไม่ครบถ้วน",
                        type: "warning",
                        showConfirmButton: true
                    });
                }
            },  
        }
    };

</script>