<template>
    <div class="table-responsive">   
        <table class="table program_info_tb text-nowrap">
            <thead>
                <tr>
                    <th class="text-center">
                        <label>ลำดับที่</label>
                    </th>
                    <th class="text-center">
                        <label>สถานะ<br>การใช้งาน</label>
                    </th>
                    <th class="text-center" style="min-width: 300px;">
                        <label>รายละเอียด การทดสอบ <span class="text-danger"> *</span></label>
                    </th>
                    <th class="text-center">
                        <label>หน่วยการทดสอบ <span class="text-danger"> *</span></label>
                    </th>
                    <th class="text-center">
                        <label>รายละเอียด<br>หน่วยการทดสอบ</label>
                    </th>
                    <th class="text-center">
                        <label>ประเภทข้อมูล <span class="text-danger"> *</span></label>
                    </th>
                    <th class="text-center">
                        <label>สามารถติดลบได้</label>
                    </th>
                    <th class="text-center">
                        <label>ทศนิยม <span class="text-danger"> *</span></label>
                    </th>
                    <th class="text-center" v-if="this.test_type_code == '2'">
                        <label >ระดับความรุนแรง<br>ของข้อบกพร่อง</label>
                    </th>
                    <th class="text-center" v-else>
                        <label >ระดับความรุนแรง<br>ของความผิดปกติ (อาการ)</label>
                    </th>
                    <th class="text-center" v-if="this.test_type_code == '2'">
                        <label >รายการตรวจสอบคุณภาพบุหรี่</label>
                    </th>
                    <th class="text-center" v-if="this.test_type_code == '2'" style="min-width: 220px;">
                        <label >กระบวนการตรวจคุณภาพบุหรี่ </label>
                    </th>
                    <th class="text-center">
                        <label>อัปโหลดรูปภาพประกอบ</label>
                    </th>
                    <th class="text-center">
                        <label>รูปภาพประกอบ</label>
                    </th>
                    <th> </th>
                </tr>
            </thead>
            <tbody v-if="lines.length">
                <tr v-for="(row, index) in lines" :key="index" :row="row">
                    <input type="hidden" :name="'dataGroup['+index+'][test_code]'" v-model="row.test_code">

                    <td class="text-center" style="vertical-align:middle;">{{ index + 1 }}</td>
                    <td class="text-center" style="vertical-align:middle;">
                        <input type="hidden" :name="'dataGroup['+index+'][enable_flag]'" v-model="row.enable_flag">
                        <el-checkbox v-model="row.enable_flag"></el-checkbox>
                    </td>
                    <td style="vertical-align:middle;">
                        <input type="hidden" :name="'dataGroup['+index+'][test_desc]'" v-model="row.test_desc">
                        <el-input   placeholder="กรอกลายละเอียด" 
                                    v-model="row.test_desc"
                                    type="textarea"></el-input>
                    </td>
                    <td style="vertical-align:middle;">
                        <input type="hidden" :name="'dataGroup['+index+'][qcunit_code]'" v-model="row.qcunit_code">
                        <el-select  v-model="row.qcunit_code" 
                                    placeholder="เลือก" 
                                    reserve-keyword
                                    filterable
                                    @change="getQcunitDesc(row, row.qcunit_code)"
                                    >
                            <el-option
                                v-for="(unit,index) in units"
                                :key="index"
                                :label="unit.qcunit_code"
                                :value="unit.qcunit_code">
                            </el-option>
                        </el-select>
                    </td>
                    <td style="vertical-align:middle;">
                        <input type="hidden" :name="'dataGroup['+index+'][qcunit_desc]'" v-model="row.qcunit_desc">
                        <el-input
                            v-model="row.qcunit_desc"
                            :disabled="true">
                        </el-input>
                    </td>
                    <td style="vertical-align:middle;">
                        <input type="hidden" :name="'dataGroup['+index+'][data_type]'" v-model="row.data_type_code">
                        <!-- <el-input
                            v-model="row.data_type"
                            :disabled="row.disabledEdit">
                        </el-input> -->
                        <el-select  v-model="row.data_type_code" 
                                    placeholder="เลือก"
                                    :disabled="true"
                                    style="width: 100px;"
                                    @change="getCheckDataType(index, row, row.data_type_code)">
                            <el-option
                                v-for="(dataType,index) in dataTypes"
                                :key="index"
                                :label="dataType.data_type"
                                :value="dataType.data_type_code">
                            </el-option>
                        </el-select>
                    </td>
                    <td class="text-center" style="padding-top: 30px;">
                        <input type="hidden" :name="'dataGroup['+index+'][negative_flag]'" v-model="row.negative_flag">
                        <el-checkbox    v-model="row.negative_flag" 
                                        :disabled="row.disabledEdit || row.isNegativeFlag"></el-checkbox>
                    </td>
                    <td style="vertical-align:middle;">
                        <input type="hidden" :name="'dataGroup['+index+'][decimals]'" v-model="row.decimals">
                        <!-- <el-input
                            v-model="row.decimals"
                            :disabled="row.disabledEdit || row.isDecimals"
                            placeholder="ทศนิยม"
                            style="width: 80px;">
                        </el-input> -->
                        <vue-numeric 
                            separator="," 
                            v-bind:precision="0" 
                            v-bind:minus="false"
                            :class="'form-control text-right' + (row.decimals_valid ? ' is-invalid' : '')"
                            v-model="row.decimals"
                            style="width: 80px;"
                            :disabled="row.disabledEdit || row.isDecimals"
                            @input="getCheckNum(row, row.decimals)"
                        ></vue-numeric>
                    </td>
                    <td style="vertical-align:middle;">
                        <input type="hidden" :name="'dataGroup['+index+'][resultSeverity]'" v-model="row.resultSeverity">
                        <el-select  v-model="row.resultSeverity" 
                                    placeholder="เลือก"     
                                    :disabled="row.disabledEdit"                                
                                    reserve-keyword
                                    clearable>
                            <el-option
                                v-for="(data,index) in resultSeverites"
                                :key="index"
                                :label="data.meaning"
                                :value="data.meaning">
                            </el-option>
                        </el-select>
                    </td>
                    <td v-if="row.test_type_code == '2'" style="vertical-align:middle;">
                        <!-- <input type="hidden" :name="'dataGroup['+index+'][entity]'" v-model="row.entity"> -->
                        <el-select  v-model="row.entity" 
                                    placeholder="ไม่มีข้อมูล"
                                    class="w-100"
                                    clearable 
                                    filterable
                                    remote 
                                    reserve-keyword
                                    disabled 
                                    @change="showData(index)">
                            <el-option
                                v-for="(data, index) in row.entityTestSearchList"
                                :key="index"
                                :label="data.entity_meaning"
                                :value="data.entity_code">
                            </el-option>
                        </el-select>
                    </td>
                    <td v-if="row.test_type_code == '2'" style="vertical-align:middle;">
                        <!-- <input type="hidden" :name="'dataGroup['+index+'][process]'" v-model="row.process"> -->
                        <el-select  v-model="row.process" 
                                    placeholder="ไม่มีข้อมูล"
                                    clearable 
                                    filterable
                                    remote 
                                    reserve-keyword
                                    disabled 
                                    class="w-100"
                                    @change="showData(index)">
                            <el-option
                                v-for="(data, index) in row.processTestSearchList"
                                :key="index"
                                :label="data.process_meaning"
                                :value="data.process_code">
                            </el-option>
                        </el-select>
                    </td>
                    <td style="vertical-align:middle;">
                        <el-upload
                            class="upload-demo"
                            action="http://web-service.test/qm/settings/define-tests-tobacco-leaf/update"
                            :on-preview="handlePreview"
                            :on-remove="handleRemove"
                            :before-remove="beforeRemove"
                            :auto-upload="false"
                            :name="'dataGroup['+index+'][files][]'"
                            multiple
                            :limit="row.limitImage"
                            :on-exceed="handleExceed"
                            :disabled="row.isUploadFlag"
                            :file-list="fileList">
                            <el-button size="small" type="primary" :disabled="row.isUploadFlag">เพิ่มรูปภาพ</el-button>
                            <div slot="tip" class="el-upload__tip">สามารถเพิ่มได้อีก {{ row.limitImage }} รูป สูงสุดไม่เกิน 5 รูป</div>
                        </el-upload>
                    </td>
                    <td class="text-center" style="vertical-align:middle;">
                        <!-- Button trigger modal -->
                        <button type="button" 
                                class="btn btn-primary" 
                                data-toggle="modal" 
                                :data-target="'#exampleModalScrollable'+row.test_id"
                                :disabled="row.isAttachments">
                            <i class="fa fa-file-image-o" aria-hidden="true"></i> ดูรูปภาพ
                        </button>

                        <!-- Modal -->
                        <div    class="modal fade" 
                                :id="'exampleModalScrollable'+row.test_id" 
                                tabindex="-1" 
                                role="dialog" 
                                :aria-labelledby="'exampleModalScrollableTitle'+row.test_id" 
                                aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalScrollableTitle">ดูแนบรูปภาพ</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <ul>
                                        <li
                                            v-for="attach in row.attachments"
                                            :key="attach.attachment_id"
                                            style="text-align: left;"
                                        >
                                            <a  :target="hrefTarget" 
                                                :href="'attachments/'+ attach.attachment_id + '/' + test_type_code +'/imageDefineTests'"
                                            >
                                                {{ attach.file_name }}
                                            </a>
                                            <a @click="removeFile(attach.attachment_id)">
                                                <i class="fa fa-close" style="color: red; text-align: right;"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="11" class="text-center" style="vertical-align: middle; width: 100%;">
                        <h2> ไม่มีข้อมูลในระบบ </h2>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import VueNumeric from 'vue-numeric'
    export default {
        props: ["tests", "resultSeverites", "units", "dataTypes", 
                'processTestList', 'entityTestList', 'processDistinctTestList'],
        data() {
            return{
                lines           : [],
                fileList        : [],
                test_type_code  : '',
                hrefTarget      : '_blank',
                entityTestSearchList: [],
                processTestSearchList: []
            };
        },
        components: {
            VueNumeric
        },
        mounted(){
            this.tests.data.forEach((element, index) => {
                this.getCheckDataType(index, element, element.data_type_code)
                this.lines.push({
                    test_id         : element.test_id,
                    test_code       : element.test_code,
                    test_desc       : element.test_desc,
                    qcunit_code     : element.test_unit_code,
                    data_type       : element.data_type,
                    data_type_code  : element.data_type_code,
                    negative_flag   : element.negative_flag === "Y" ? true : false,
                    decimals        : element.data_type_code == 'U' ? 0 : Number(element.decimals),
                    enable_flag     : element.enable_flag === "Y" ? true : false,
                    qcunit_desc     : element.test_unit,
                    attachment_id   : element.attachment_id,
                    resultSeverity  : (element.serverity_code) ? (element.serverity_code) : '',
                    disabledEdit    : element.editable ? true : false,
                    isNegativeFlag  : element.isNegativeFlag,
                    isDecimals      : element.isDecimals,
                    attachments     : element.attachments,
                    isAttachments   : element.isAttachments,
                    limitImage      : element.limitImage,
                    isUploadFlag    : element.isUploadFlag,
                    entity          : element.check_list_code,
                    process         : element.qm_process_code,
                    entityTestSearchList    : this.entityTestList,
                    processTestSearchList   : this.processDistinctTestList,
                    test_type_code  : element.test_type_code,
                    decimals_valid  : false,
                });  
                this.test_type_code = element.test_type_code
                this.showData(index);
            });             
        },
        methods: {
            getCheckDataType(index, row, data_type_code){
                if(index == index){
                    if(data_type_code == "U" || data_type_code == "T"){
                        row.isNegativeFlag = true;
                        row.isDecimals = true;
                    }else{
                        row.isNegativeFlag = false;
                        row.isDecimals = false;
                    }
                }
            },
            getQcunitDesc(row, qcunit_code){
                var qcunitDesc = this.units.find(item => {
                    return qcunit_code == item.qcunit_code;
                });
                row.qcunit_desc = qcunitDesc.qcunit_desc;
            },
            handleRemove(file, fileList) {
                // console.log(file, fileList);
            },
            handlePreview(file) {
                console.log(file);
            },
            handleExceed(files, fileList) {
                swal({
                    title: "คำเตือน !",
                    text: 'ไม่สามารถอัปโหลดรูปภาพเนื่องจากเกินจำนวนของรูปภาพ',
                    type: "warning",
                    showConfirmButton: true
                });
            },
            beforeRemove(file, fileList) {
                return this.$confirm(`Cancel the transfert of ${ file.name } ?`);
            },
            handleChange(file, fileList) {
                // this.fileList = fileList;
            },
            removeFile(id){
                let testTypeCode = '';
                let vm = this;
                testTypeCode = vm.test_type_code;
                swal({
                    title: "คุณแน่ใจ?",
                    text: "คุณที่จะต้องการลบรูปภาพนี้ใช่ไหม ?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-warning',
                    confirmButtonText: "ยืนยัน",
                    cancelButtonText: "ยกเลิก",
                    closeOnConfirm: false
                },                    
                function (isConfirm) {
                    if(isConfirm){
                        return axios
                        .get('/qm/ajax/attachments/'+ id +'/'+ testTypeCode +'/deleteByPKGDefineTests')
                        .then(res => {
                            console.log(res.data.message);
                            if(res.data.message == "Success"){
                                swal({
                                    title: "success !",
                                    text: "ลบรูปภาพสำเร็จ !",
                                    type: "success",
                                    showConfirmButton: true
                                });
                                setTimeout(() => {
                                    window.location.reload(false); 
                                }, 3000)
                            } 
                        });
                    }
                });
            },

            async showData(index) {
                let vm = this;
                if(typeof index != 'undefined'){
                    if (vm.lines[index].entity == '' || vm.lines[index].entity == undefined) {
                        vm.lines[index].entityTestSearchList = (vm.entityTestList != undefined && vm.entityTestList) ? vm.entityTestList : [];
                    }

                    if (vm.lines[index].process == '' || vm.lines[index].process == undefined) {
                        vm.lines[index].processTestSearchList = (vm.processTestList != undefined && vm.processTestList) ? vm.processDistinctTestList : [];
                    }

                    if (vm.lines[index].entity) {
                        let selEntity = vm.entityTestList.filter(o => {
                            return o.entity_code == vm.lines[index].entity;
                        });
                        
                        if (selEntity.length > 0) {
                            selEntity = selEntity[0];
                            vm.lines[index].processTestSearchList = vm.processTestList.filter(o => {
                                return o.entity_code == selEntity.entity_code;
                            })
                        }
                    }

                    if (vm.lines[index].process) {
                        let selProcess = vm.processTestList.filter(o => {
                            return o.process_code == vm.lines[index].process;
                        });

                        if (selProcess.length > 0) {
                            selProcess = selProcess[0];
                            vm.lines[index].entityTestSearchList = vm.entityTestList.filter(o => {
                                return o.process_code == selProcess.process_code;
                            })
                        }
                    }
                }             
            },

            getCheckNum(arr, num){
                let vm = this
                if(num > 9){
                    swal({
                        title: "Warning",
                        text: "ไม่สามารถกรอกตัวเลขจำนวนเต็ม " + num + " ได้ ต้องเป็นตัวเลขจำนวนเต็ม ระหว่าง 0 ถึง 9 เท่านั้น!",
                        type: "warning",
                        showCancelButton: true,
                        closeOnConfirm: false
                    });
                    document.getElementById("btnSaveIndex").disabled = true;
                    arr.decimals_valid = true;
                }else{
                    arr.decimals_valid = false;
                }
                
                let flagValid = vm.lines.filter(row => {
                    return row.decimals_valid == true;
                });

                if(flagValid.length == 0){
                    document.getElementById("btnSaveIndex").disabled = false;
                }else{
                    document.getElementById("btnSaveIndex").disabled = true;
                }
            },

        }
    };

</script>