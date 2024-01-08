<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <!-- <input type="hidden" name="organization_id" v-model="organization_id">
                <input type="hidden" name="subinventory_code" v-model="subinventory_code">
                <input type="hidden" name="warehouse_code" v-model="warehouse_code">
                <input type="hidden" name="location_code" v-model="location_code"> -->

                <div class="row">
                    <div class="col" style="margin-right: 125px; margin-left: 125px; padding-top: 15px;">
                        <label>ชื่อจุดตรวจสอบ</label><span class="text-danger"> *</span>
                        <!-- <input type="hidden" name="location_desc" v-model="location_desc"> -->
                        <el-input placeholder="กรอกชื่อจุดตรวจสอบ" v-model="location_desc" :disabled="true"></el-input>
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
                        <label>รายละเอียดจุดตรวจสอบ</label>
                        <!-- <input type="hidden" name="locator_desc" v-model="locator_desc"> -->
                        <el-input placeholder="กรอกชื่อจุดตรวจสอบ" v-model="locator_desc"></el-input>
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
                        <label>กลุ่มงาน</label>
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
                            accept="image/*"
                            action="http://web-service.test/qm/settings/check-points-tobacco-leaf/update"
                            :on-preview="handlePreview"
                            :on-remove="handleRemove"
                            :before-remove="beforeRemove"
                            :auto-upload="false"
                            :on-change="onChange"
                            :limit="limitImage"
                            :on-exceed="handleExceed"
                            :file-list="filesUploadList"
                            multiple>
                            <el-button size="small" type="primary">เพิ่มรูปภาพ</el-button>
                            <div slot="tip" class="el-upload__tip">สามารถเพิ่มได้อีก {{ limitImage }} รูป สูงสุดไม่เกิน 5 รูป</div>
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
        props: ['checkPoints', 'workList', 'btnTrans'],
        data() {
            return{
                location_desc       :this.checkPoints ? this.checkPoints[0].location_desc : '',
                locator_desc        :this.checkPoints ? this.checkPoints[0].locator_desc : '',
                group_code          :this.checkPoints ? this.checkPoints[0].qm_group : '',
                enable_flag         :this.checkPoints[0].enabled_flag == 'Y' ? true : false,
                filesUploadList     :[],
                organization_id     :this.checkPoints ? this.checkPoints[0].organization_id : '',
                subinventory_code   :this.checkPoints ? this.checkPoints[0].subinventory_code : '',
                warehouse_code      :this.checkPoints ? this.checkPoints[0].building_code : '',
                location_code       :this.checkPoints ? this.checkPoints[0].location_code : '',
                limitImage          :this.checkPoints ? this.checkPoints[0].limitImage : 0,
                validate            : {
                    location_desc   : false,
                    locator_desc    : false,
                    group_code      : false,
                }
            };
        },
        mounted() {
            // console.log(this.checkPoints);
        },
        methods: {
            handleRemove(file, fileList) {
                this.filesUploadList.splice(file, 1);
            },
            handlePreview(file) {

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
            onChange (file, fileList){
                this.filesUploadList = fileList;
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

                formData.append('organization_id', vm.organization_id);
                formData.append('subinventory_code', vm.subinventory_code);
                formData.append('warehouse_code', vm.warehouse_code);
                formData.append('location_code', vm.location_code);
                formData.append('location_desc', vm.location_desc);
                formData.append('locator_desc', vm.locator_desc);
                formData.append('group_code', vm.group_code);
                formData.append('enable_flag', vm.enable_flag);

                vm.filesUploadList.forEach((element,index) => {
                    formData.append('files[]', vm.filesUploadList[index].raw);
                });

                return axios
                .post(  '/qm/settings/check-points-tobacco-leaf/update',formData,
                        {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                .then(res => {
                    if(res.data.status == 'SUCCESS'){
                        swal({
                            title: "Success !",
                            text: 'ทำการเปลี่ยนข้อมูลเรียบร้อยแล้ว',
                            type: "success",
                            showConfirmButton: true
                        });
                        setTimeout(() => {
                            window.location.href = '/qm/settings/check-points-tobacco-leaf'
                        }, 3000)
                    }else{
                        swal({
                            title: "Error !",
                            text: res.data.err_msg,
                            type: "error",
                            showConfirmButton: true
                        });
                    }
                });
            }
        }
    };

</script>