<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                        <label>อาคาร</label><span class="text-danger"> *</span>
                        <input type="hidden" name="build_name" v-model="build_name">
                        <el-input placeholder="กรอกชื่ออาคาร" v-model="build_name"></el-input>
                        <div
                            class="error-message"
                            v-if="this.validate.build_name"
                        >
                            <strong class="font-bold text-danger">กรุณากรอก ชื่ออาคาร</strong>
                        </div>
                    </div>                        
                </div>

                <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                        <label>หน่วยงาน</label><span class="text-danger"> *</span>
                        <input type="hidden" name="department_name" v-model="department_name">
                        <el-input placeholder="กรอกชื่อหน่วยงาน" v-model="department_name"></el-input>
                        <div
                            class="error-message"
                            v-if="this.validate.department_name"
                        >
                            <strong class="font-bold text-danger">กรุณากรอก หน่วยงาน</strong>
                        </div>
                    </div>                        
                </div>

                <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                        <label>ชื่อจุดตรวจสอบ</label><span class="text-danger"> *</span>
                        <input type="hidden" name="location_desc" v-model="location_desc">
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
                        <input type="hidden" name="locator_desc" v-model="locator_desc">
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
                        <label>สถานะการใช้งาน</label>
                        <input type="hidden" name="enable_flag" :value="enable_flag">
                        <el-checkbox v-model="enable_flag" class="w-100"></el-checkbox>
                    </div>                        
                </div>

                <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;  padding-bottom: 15px;">
                        <label>รูปภาพประกอบ</label>
                        <el-upload
                            class="upload-demo"
                            action="http://web-service.test/qm/settings/check-points-tobacco-beetle/create"
                            :on-preview="handlePreview"
                            :on-remove="handleRemove"
                            :before-remove="beforeRemove"
                            :auto-upload="false"
                            :on-change="handleChange"
                            name="files[]"
                            multiple
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
                            <i class="btnTrans.save.icon" aria-hidden="true"></i>  
                            {{ btnTrans.save.text }}
                    </button>
                    <a  href="/qm/settings/check-points-tobacco-beetle" 
                        type="button" 
                        :class="btnTrans.cancel.class"> 
                        <i :class="btnTrans.cancel.icon" aria-hidden="true"></i> 
                        {{btnTrans.cancel.text}}
                    </a>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: ['btnTrans'],
        data() {
            return{
                build_name          : '',
                department_name     : '',
                location_desc       :'',
                locator_desc        :'',
                building_code       : '',
                enable_flag         :true,
                fileList            :[],
                validate            : {
                    build_name      : false,
                    department_name : false,
                    location_desc   : false,
                    locator_desc    : false,
                    building_code   : false,                  
                }
            };
        },
        methods: {
            handleRemove(file, fileList) {
                console.log(file, fileList);
            },
            handlePreview(file) {
                console.log(file);
            },
            handleExceed(files, fileList) {
                swal({
                    title: "คำเตือน !",
                    text: 'ไม่สามารถอัปโหลดรูปภาพเนื่องจากเกินจำนวนของรูปภาพสูงสุดของรูปภาพ',
                    type: "warning",
                    showConfirmButton: true
                });
            },
            beforeRemove(file, fileList) {
                return this.$confirm(`ยกเลิกการอัปโหลดไฟล์รูปภาพ ${ file.name } ใช่หรือไม่ ?`);
            },
            handleChange(file, fileList) {
                this.fileList = fileList;
            },
            async save(){
                let vm = this;
                let formData = new FormData();

                if(!vm.build_name){
                    vm.validate.build_name = true;
                    return;
                }else{
                    vm.validate.build_name = false;
                }

                if(!vm.department_name){
                    vm.validate.department_name = true;
                    return;
                }else{
                    vm.validate.department_name = false;
                }

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

                formData.append('location_desc', vm.location_desc);
                formData.append('locator_desc', vm.locator_desc);
                formData.append('enable_flag', vm.enable_flag);
                formData.append('build_name', vm.build_name);
                formData.append('department_name', vm.department_name);

                vm.fileList.forEach((element,index) => {
                    formData.append('files[]', vm.fileList[index].raw);
                });

                return axios
                .post(  '/qm/settings/check-points-tobacco-beetle/store',formData,
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
                            window.location.href = '/qm/settings/check-points-tobacco-beetle'
                        }, 3000)
                    }else{
                        swal({
                            title: "Error !",
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