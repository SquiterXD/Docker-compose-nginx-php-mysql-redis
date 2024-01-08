<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                        <label>ชื่อจุดตรวจสอบ</label><span class="text-danger"> *</span>
                        <!-- <input type="hidden" name="location_desc" v-model="location_desc"> -->
                        <el-input placeholder="กรอกชื่อจุดตรวจสอบ" v-model="location_desc"></el-input>
                        <div
                            class="error-message"
                            v-if="this.validate.location_desc"
                        >
                            <strong class="font-bold text-danger">กรุณากรอก ชื่อจุดตรวจสอบ</strong>
                        </div>
                    </div>                        
                </div>

                <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                        <label>รายละเอียดจุดตรวจสอบ</label><span class="text-danger"> *</span>
                        <!-- <input type="hidden" name="locator_desc" v-model="locator_desc"> -->
                        <el-input placeholder="กรอกรายละเอียดจุดตรวจสอบ" v-model="locator_desc"></el-input>
                        <div
                            class="error-message"
                            v-if="this.validate.locator_desc"
                        >
                            <strong class="font-bold text-danger">กรุณากรอก รายละเอียดจุดตรวจสอบ</strong>
                        </div>
                    </div>                        
                </div>

                <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                        <label>กลุ่มงาน</label><span class="text-danger"> *</span>
                        <!-- <input type="hidden" name="group_code" v-model="group_code"> -->
                        <el-select  v-model="group_code" clearable filterable 
                                    placeholder="เลือกกลุ่มงาน" 
                                    class="w-100">
                            <el-option
                                v-for   ="(data, index) in workList"
                                :key    ="index"
                                :label  ="data.meaning"
                                :value  ="data.meaning">
                            </el-option>
                        </el-select>
                        <div
                            class="error-message"
                            v-if="this.validate.group_code"
                        >
                            <strong class="font-bold text-danger">กรุณาเลือก กลุ่มงาน</strong>
                        </div>
                    </div>                        
                </div>

                <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                        <label>สถานะการใช้งาน</label>
                        <!-- <input type="hidden" name="enable_flag" :value="enable_flag"> -->
                        <el-checkbox v-model="enable_flag" class="w-100"></el-checkbox>
                    </div>                        
                </div>

                <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;  padding-bottom: 15px;">
                        <label>รูปภาพประกอบ</label>
                        <el-upload
                            class="upload-demo"
                            action="http://web-service.test/qm/settings/check-points/store"
                            :on-preview="handlePreview"
                            :on-remove="handleRemove"
                            :before-remove="beforeRemove"
                            :auto-upload="false"
                            multiple
                            :on-change="onchange"
                            :limit="5"
                            :on-exceed="handleExceed"
                            :file-list="fileList">
                            <el-button size="small" type="primary">เพิ่มรูปภาพ</el-button>
                        </el-upload>
                    </div>                        
                </div>

            </div>
        </div>

        <div class="col-12 mt-3">
            <hr>
            <div class="row clearfix m-t-lg text-right">
                <div class="col-sm-12">
                    <button :class="btnTrans.save.class" 
                            type="submit"
                            @click="save">
                            <i :class="btnTrans.save.icon" aria-hidden="true"></i>  
                            {{ btnTrans.save.text }}
                    </button>
                    <a  href="/qm/settings/check-points-tobacco-leaf" 
                        type="button" 
                        :class="btnTrans.cancel.class"> 
                        <i :class="btnTrans.cancel.icon" aria-hidden="true"></i> 
                        {{ btnTrans.cancel.text }}
                    </a>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: ['workList', 'oldInput', 'btnTrans'],
        data() {
            return{
                location_desc   : this.oldInput.location_desc ? this.oldInput.location_desc : '',
                locator_desc    : this.oldInput.locator_desc ? this.oldInput.locator_desc : '',
                group_code      : this.oldInput.group_code ? this.oldInput.group_code : '',
                enable_flag     :   this.oldInput.enable_flag == "true" ? 
                                    this.oldInput.enable_flag == "true" ? true : false : true,
                fileList        : [],
                validate        : {
                    location_desc   : false,
                    locator_desc    : false,
                    group_code      : false,
                }
            };
        },
        mounted() {
            
        },
        methods: {
            handleRemove(file, fileList) {
                this.fileList.splice(file, 1);
            },
            handlePreview(file) {

            },
            handleExceed(files, fileList) {
                // this.$message.warning(`The limit is 3, you selected ${files.length} files this time, add up to ${files.length + fileList.length} totally`);
            },
            beforeRemove(file, fileList) {
                return this.$confirm(`ยกเลิกการอัปโหลดไฟล์รูปภาพ ${ file.name } ใช่หรือไม่ ?`);
            },
            onchange (file, fileList){
                this.fileList = fileList;
            },
            async save(){
                let vm = this;
                let formData = new FormData();
                
                if(!vm.location_desc){
                    vm.validate.location_desc = true;
                    return;
                }else{
                    vm.validate.location_desc = false;
                }

                if(!vm.locator_desc){
                    vm.validate.locator_desc = true;
                    return;
                }else{
                    vm.validate.locator_desc = false;
                }

                if(!vm.group_code){
                    vm.validate.group_code = true;
                    return;
                }else{
                    vm.validate.group_code = false;
                }

                formData.append('location_desc', vm.location_desc);
                formData.append('locator_desc', vm.locator_desc);
                formData.append('group_code', vm.group_code);
                formData.append('enable_flag', vm.enable_flag);

                vm.fileList.forEach((element,index) => {
                    formData.append('files[]', vm.fileList[index].raw);
                });

                return axios
                .post(  '/qm/settings/check-points-tobacco-leaf/store',formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                .then(res => {
                    console.log(res.data)
                    if(res.data.status == 'SUCCESS'){
                        swal({
                            title: "บันทึกสำเร็จ !",
                            text: 'ทำการเพิ่มรายการเรียบร้อยแล้ว',
                            type: "success",
                            showConfirmButton: true
                        });
                        setTimeout(() => {
                            window.location.href = '/qm/settings/check-points-tobacco-leaf'
                        }, 3000)
                    }else{
                        swal({
                            title: "เกิดข้อผิดพลาด !",
                            text: res.data.err_msg,
                            type: "error",
                            showConfirmButton: true
                        });
                    }

                    if(res.data.status == 'Duplicate'){
                        swal({
                            title: "เกิดข้อผิดพลาด !",
                            text: res.data.data,
                            type: "error",
                            showConfirmButton: true
                        });
                    }
                });
            }
        }
    };

</script>