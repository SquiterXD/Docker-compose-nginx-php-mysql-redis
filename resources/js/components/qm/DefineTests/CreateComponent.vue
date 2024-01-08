<template>
    <div>   
        <div class="text-right" style="padding-bottom: 20px;">
            <button class="btn btn-sm btn-primary" type="submit" @click.prevent="addLine"> 
                <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มรายการ 
            </button>
        </div>
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
                        <label>รายละเอียด หน่วยการทดสอบ</label>
                    </th>
                    <th class="text-center">
                        <label>ประเภทข้อมูล <span class="text-danger"> *</span></label>
                    </th>
                    <th class="text-center">
                        <label>สามารถติดลบได้</label>
                    </th>
                    <th class="text-center">
                        <label>ทศนิยม <span class="text-danger"> *</span>
                        </label>
                    </th>
                    <th class="text-center">
                        <label>ระดับความรุนแรงของข้อบกพร่อง <span class="text-danger"> *</span></label>
                    </th>
                    <!-- <th class="text-center" v-if="this.testTypeCode == '2'">
                        <label >รายการตรวจสอบคุณภาพบุหรี่ <span class="text-danger"> *</span></label>
                    </th> -->
                    <!-- <th class="text-center" v-if="this.testTypeCode == '2'">
                        <label >กระบวนการตรวจคุณภาพบุหรี่ <span class="text-danger"> *</span></label>
                    </th> -->
                    <th class="text-center">
                        <label>รูปภาพประกอบ</label>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody v-if="lines.length">
                <tr v-for="(row, index) in lines" :key="index" :row="row">
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
                        <el-input
                            v-model="row.qcunit_desc"
                            :disabled="true"
                            >
                        </el-input>
                    </td>
                    <td style="vertical-align:middle;">
                        <input type="hidden" :name="'dataGroup['+index+'][data_type_code]'" v-model="row.data_type_code">
                        <el-select  v-model="row.data_type_code" 
                                    placeholder="เลือก"
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
                    <td class="text-center" style="vertical-align:middle;">
                        <input type="hidden" :name="'dataGroup['+index+'][negative_flag]'" v-model="row.negative_flag">
                        <el-checkbox    v-model="row.negative_flag" 
                                        :disabled="row.isNegativeFlag"
                                        ></el-checkbox>
                    </td>
                    <td style="vertical-align:middle;">
                        <input type="hidden" :name="'dataGroup['+index+'][decimals]'" v-model="row.decimals">
                        <!-- <el-input   placeholder="ทศนิยม" 
                                        v-model="row.decimals" 
                                        :disabled="row.isDecimals"
                                        style="width: 80px;"
                                    >
                        </el-input> -->
                        <vue-numeric 
                            separator="," 
                            v-bind:precision="0" 
                            v-bind:minus="false"
                            :class="'form-control text-right' + (row.decimals_valid ? ' is-invalid' : '')"
                            v-model="row.decimals"
                            style="width: 80px;"
                            :disabled="row.isDecimals"
                            @input="getCheckNum(row, row.decimals)"
                        ></vue-numeric>
                    </td>
                    <td style="vertical-align:middle;">
                        <input type="hidden" :name="'dataGroup['+index+'][resultSeverity]'" v-model="row.resultSeverity">
                        <el-select  v-model="row.resultSeverity" 
                                    placeholder="เลือก" 
                                    clearable                                     
                                    reserve-keyword>
                            <el-option
                                v-for="(data,index) in resultSeverites"
                                :key="index"
                                :label="data.meaning"
                                :value="data.meaning">
                            </el-option>
                        </el-select>
                    </td>
                    <!-- <td style="vertical-align:middle;" v-if="row.testTypeCode == '2'">
                        <input type="hidden" :name="'dataGroup['+index+'][entity]'" v-model="row.entity">
                        <el-select  v-model="row.entity" 
                                    placeholder="เลือก" 
                                    clearable                                     
                                    reserve-keyword
                                    @change="showData(index)">
                            <el-option
                                v-for="(data,index) in row.entityTestSearchList"
                                :key="index"
                                :label="data.entity_meaning"
                                :value="data.entity_code">
                            </el-option>
                        </el-select>
                    </td> -->
                    <!-- <td style="vertical-align:middle;" v-if="row.testTypeCode == '2'">
                        <input type="hidden" :name="'dataGroup['+index+'][process]'" v-model="row.process">
                        <el-select  v-model="row.process" 
                                    placeholder="เลือก" 
                                    clearable                                     
                                    reserve-keyword
                                    @change="showData(index)">
                            <el-option
                                v-for="(data,index) in row.processTestSearchList"
                                :key="index"
                                :label="data.process_meaning"
                                :value="data.process_code">
                            </el-option>
                        </el-select>
                    </td> -->
                    <td class="text-center" style="vertical-align:middle;">
                        <el-upload
                            class="upload-demo"
                            action="http://web-service.test/qm/settings/define-tests-tobacco-leaf/store"
                            :on-preview="handlePreview"
                            :on-remove="handleRemove"
                            :before-remove="beforeRemove"
                            :auto-upload="false"
                            :name="'dataGroup['+index+'][files][]'"
                            multiple
                            :limit="5"
                            :on-exceed="handleExceed"
                            :file-list="fileList">
                            <el-button size="small" type="primary">เพิ่มรูปภาพ</el-button>
                            <div slot="tip" class="el-upload__tip">สามารถอัปโหลดรูปภาพสูงสุด 5 รูปภาพ</div>
                        </el-upload> 
                    </td>
                    <td style="vertical-align:middle;">
                        <button @click.prevent="removeRow(index)" 
                                class="btn btn-sm btn-danger">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                    </td>  
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="11" class="text-center" style="vertical-align: middle; width: 100%; vertical-align:middle;">
                        <h2> ยังไม่มีข้อมูลที่จะสร้างใหม่ในตอนนี้ กรุณา "กด เพิ่มรายการ" </h2>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
</template>

<script>
    import VueNumeric from 'vue-numeric'
    export default {
        props: ["units", "dataTypes", "resultSeverites", "processTestList", 
                "entityTestList", "processDistinctTestList", "testTypeCode",
                "oldInput"],
        components: {
            VueNumeric
        },
        data() {
            return{
                test_desc       : '',
                qcunit_code     : '',
                data_type_code  : '',
                negative_flag   : false,
                decimals        : '',
                enable_flag     : true,
                qcunit_desc     : '',
                lines           : [],
                fileList        : [],
                isNegativeFlag  : false,
                isDecimals      : false,
            };
        },
        mounted(){
            if(typeof this.oldInput !== 'undefined'){
                if(this.oldInput.length != 0){
                    this.oldInput.dataGroup.forEach((element,index) => {
                        this.lines.push({
                            test_desc       : element.test_desc,
                            qcunit_code     : element.qcunit_code,
                            data_type_code  : element.data_type_code,
                            negative_flag   : element.negative_flag == "false" ? false : true,
                            decimals        : element.data_type_code == 'U' ? '' : Number(element.decimals),
                            enable_flag     : true,   
                            qcunit_desc     : element.qcunit_code, 
                            fileList        : [],
                            resultSeverity  : element.resultSeverity,
                            testTypeCode    : this.testTypeCode,
                            isNegativeFlag  : element.data_type_code == 'U' ? true : false,
                            isDecimals      : element.data_type_code == 'U' ? true : false,
                            decimals_valid  : false,
                        });
                    });  
                }
            }else{
                this.addLine();  
            }
        },
        methods: {
            addLine() {
                this.lines.push({
                    test_desc       : '',
                    qcunit_code     : '',
                    data_type_code  : '',
                    negative_flag   : false,
                    decimals        : Number(0),
                    enable_flag     : true,   
                    qcunit_desc     : '', 
                    fileList        : [],
                    resultSeverity  : '',
                    // entity          : '',
                    // process         : '',
                    // entityTestSearchList : this.entityTestList != [] ? this.entityTestList : [],
                    // processTestSearchList : this.processDistinctTestList != [] ? this.processDistinctTestList : [],
                    testTypeCode    : this.testTypeCode,
                    decimals_valid  : false
                });

                // this.showData();
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
                    document.getElementById("btnSaveCreate").disabled = true;
                    arr.decimals_valid = true;
                }else{
                    arr.decimals_valid = false;
                }
                
                let flagValid = vm.lines.filter(row => {
                    return row.decimals_valid == true;
                });

                if(flagValid.length == 0){
                    document.getElementById("btnSaveCreate").disabled = false;
                }else{
                    document.getElementById("btnSaveCreate").disabled = true;
                }
            },

            getQcunitDesc(row, qcunit_code){
                var qcunitDesc = this.units.find(item => {
                    return qcunit_code == item.qcunit_code;
                });
                row.qcunit_desc = qcunitDesc.qcunit_desc;
            },

            getCheckDataType(index, row, data_type_code){
                if(index == index){
                    if(data_type_code == "U"){
                        row.isNegativeFlag = true;
                        row.isDecimals = true;
                        row.decimals = '';
                    }else{
                        row.isNegativeFlag = false;
                        row.isDecimals = false;
                    }
                }
            },

            removeRow: function (index) {
                this.lines.splice(index, 1);
            },

            handleRemove(file, fileList) {
                // console.log(file, fileList);
            },
            handlePreview(file) {
                // console.log(file);
            },
            handleExceed(files, fileList) {
                // this.$message.warning(`The limit is 5, you selected ${files.length} files this time, add up to ${files.length + fileList.length} totally`);
                swal({
                    title: "คำเตือน !",
                    text: "สามารถเลือกไฟล์รูปภาพได้สูงสุด 5 ไฟล์",
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

            // async showData(index) {
            //     let vm = this;
            //     if(typeof index != 'undefined'){
            //         if (vm.lines[index].entity == '' || vm.lines[index].entity == undefined) {
            //             vm.lines[index].entityTestSearchList = (vm.entityTestList != undefined && vm.entityTestList) ? vm.entityTestList : [];
            //         }

            //         if (vm.lines[index].process == '' || vm.lines[index].process == undefined) {
            //             vm.lines[index].processTestSearchList = (vm.processTestList != undefined && vm.processTestList) ? vm.processDistinctTestList : [];
            //         }

            //         if (vm.lines[index].entity) {
            //             let selEntity = vm.entityTestList.filter(o => {
            //                 return o.entity_code == vm.lines[index].entity;
            //             });
                        
            //             if (selEntity.length > 0) {
            //                 selEntity = selEntity[0];
            //                 vm.lines[index].processTestSearchList = vm.processTestList.filter(o => {
            //                     return o.entity_code == selEntity.entity_code;
            //                 })
            //             }
            //         }

            //         if (vm.lines[index].process) {
            //             let selProcess = vm.processTestList.filter(o => {
            //                 return o.process_code == vm.lines[index].process;
            //             });

            //             if (selProcess.length > 0) {
            //                 selProcess = selProcess[0];
            //                 vm.lines[index].entityTestSearchList = vm.entityTestList.filter(o => {
            //                     return o.process_code == selProcess.process_code;
            //                 })
            //             }
            //         }
            //     }             
            // },

        }
    };

</script>