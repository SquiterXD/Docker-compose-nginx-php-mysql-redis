<template>
    <div>
        <div class="row form-group justify-content-center clearfix tw-my-6 text-center">
            <div class="col-lg-6 col-md-6">
                <button class="btn btn-lg btn-white tw-w-32 tw-ml-4" 
                        @click="submitSearch" type="button">
                        <i class="fa fa-search"></i> ค้นหา
                </button>
                <a type="button" :href="url.qm_settings_specifications_index"
                    class="btn btn-lg tw-bg-gray-100 tw-bg-opacity-60 btn-white tw-w-32 tw-ml-4">
                    <i class="fa fa-times"></i> ล้าง
                </a>
            </div>
        </div>

        <hr class="tw-my-10" />

        <div class="table-responsive">
            <table class="table text-nowrap table-hover table-bordered" v-loading="loading">
                <thead>
                    <tr>
                        <!-- <th  class="text-center align-middle" rowspan="2">ลำดับ<br>การตรวจสอบ</th> -->
                        <th class="text-center align-middle" rowspan="2">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            ชื่อการทดสอบ/ความผิดปกติ*
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        </th>
                        <th class="text-center align-middle" 
                            rowspan="2"
                            v-if="this.pRequest.test_type != 1 && this.pRequest.test_type != 5">
                            Optimal
                        </th>
                        <th class="text-center align-middle" 
                            rowspan="2"
                            v-if="this.pRequest.test_type == 1 || this.pRequest.test_type == 5">
                            เกณฑ์พิจารณาผล
                        </th>
                        <th class="text-center align-middle" colspan="2">ค่าควบคุม</th>
                        <th class="text-center align-middle" rowspan="2">หน่วย<br>การทดสอบ*</th>
                        <th class="text-center align-middle" rowspan="2">รายละเอียดหน่วย<br>การทดสอบ*</th>
                        <th v-if="this.pRequest.test_type == 2"
                            class="text-center align-middle" 
                            rowspan="2">รายการตรวจสอบคุณภาพบุหรี่ *</th>
                        <th v-if="this.pRequest.test_type != 2 && this.pRequest.test_type != 4" 
                            class="text-center align-middle" 
                            :colspan="pResultSeverityCode.length">ระดับความรุนแรง (Lower Level) *</th>
                        <th class="text-center align-middle" :colspan="pResultSeverityCode.length">ระดับความรุนแรง (Upper Level) *</th>
                        <th class="text-center align-middle" rowspan="2">Optional</th>
                    </tr>
                    <tr>
                        <th class="text-center" style="min-width: 120px; max-width: 120px">
                            Min*
                        </th>
                        <th class="text-center" style="min-width: 120px; max-width: 120px">
                            Max*
                        </th>
                        <template   v-if="pRequest.test_type != 2 && pRequest.test_type != 4" 
                                    v-for="(resSevCode, index) in pResultSeverityCode">
                            <th class="text-center">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ resSevCode.meaning }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </th>
                        </template>
                        <template v-for="(resSevCode, index) in pResultSeverityCode">
                            <th class="text-center">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ resSevCode.meaning }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </th>
                        </template>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="specifications.length > 0" v-for="(specification, index) in specifications" :data="index">
                        <!-- <td class="text-center align-middle" :data="index">{{ specification.seq }}</td> -->
                        <!-- <td>{{ specification.test_code }}: {{ specification.test_desc }}</td> -->
                        <td class="align-middle" >
                            <!-- @change="setUser" -->
                            <div style="display: flex;">
                                <div style="width: 100%;">

                                <el-tooltip class="item" effect="dark" :content="specification.test_desc" placement="top-start">
                                    <el-select
                                      style="width: 100%"
                                      v-model="specification.test_code"
                                      filterable
                                      clearable
                                      :disabled="specification.seq != null"
                                      placeholder=""
                                      @change="changeTest(specification, index)"
                                    >
                                    <el-option v-if="specification.spec_id"
                                        :label="specification.test_desc"
                                        :value="specification.test_code"
                                      ></el-option>
                                      <el-option
                                        v-for="(testData, index) in pTestList"
                                        :key="index"
                                        :label="testData.test_desc"
                                        :value="testData.test_code"
                                      ></el-option>
                                    </el-select>
                                </el-tooltip>
                                </div>

                                <!-- @click.prevent="saveTab2AvgChange()" -->
                                <button type="button" @click.prevent="delLine(specification, index)" class="btn btn-outline btn-danger ml-2" title="ลบรายการ"  >
                                    <i :class="btnTrans.delete.icon"></i>
                                </button>
                            </div>
                            <div v-if="specification.is_duplicate_test_id">
                                <span class="form-text m-b-none text-danger">
                                    ชื่อการทดสอบ/ความผิดปกติซ้ำ
                                </span>
                            </div>
                        </td>
                        <td style="min-width: 100px;" 
                            v-if="pRequest.test_type != 1 && pRequest.test_type != 5">
                            <input  type="number" class="form-control text-right" v-model="specification.optimal_value">
                        </td>
                        <td style="min-width: 100px;" 
                            v-if="pRequest.test_type == 1 || pRequest.test_type == 5"
                            class="text-center align-middle">
                            <el-checkbox    v-model="specification.evaluation_flag" 
                                            :checked="specification.evaluation_flag == 'Y' ? true : false " 
                                            size="large" />
                        </td>
                        <td>
                            <input :disabled="specification.data_type == 'ตัวอักษร'" 
                                    type="number" 
                                    class="form-control text-right" 
                                    v-model="specification.min_value" >
                            <template v-if="(specification.data_type != 'ตัวอักษร')">
                                <span v-if="parseFloat(specification.min_value) > parseFloat(specification.max_value)"
                                    class=" m-b-none text-danger small" >
                                    ค่า Min มากกว่า ค่า Max
                                </span>
                            </template>
                        </td>
                        <td>
                            <input  :disabled="specification.data_type == 'ตัวอักษร'" 
                                    type="number" 
                                    class="form-control text-right" 
                                    v-model="specification.max_value" 
                                    @change="checkMinMaxVal(specification, 'max_value')">
                            <template v-if="!(specification.data_type == 'ตัวอักษร')">
                                <span v-if="parseFloat(specification.max_value) < parseFloat(specification.min_value)"
                                    class=" m-b-none text-danger small" >
                                    ค่า Max น้อยกว่า ค่า Min
                                </span>
                            </template>
                        </td>
                        <td class="text-center align-middle">{{ specification.test_unit }}</td>
                        <td class="text-center align-middle">{{ specification.test_unit_desc }}</td>
                        <td v-if="pRequest.test_type == 2" 
                            class="text-center align-middle">
                            <el-input v-model="specification.check_list" disabled placeholder="ไม่มีข้อมูล" />
                        </td>
                        <template   v-if="pRequest.test_type != 2 && pRequest.test_type != 4" 
                                    v-for="(resSevCode, index) in pResultSeverityCode">
                            <td>
                                <input type="number"
                                    :style="'border-color: '+ resSevCode.tag"
                                    class="form-control text-right"
                                    v-model="specification['low_level_' + resSevCode.meaning.toLowerCase()]" >
                            </td>
                        </template>
                        <template v-for="(resSevCode, index) in pResultSeverityCode">
                            <td>
                                <input type="number"
                                    :style="'border-color: '+ resSevCode.tag"
                                    class="form-control text-right"
                                    v-model="specification['high_level_' + resSevCode.meaning.toLowerCase()]" >
                            </td>
                        </template>
                        <td class="text-center align-middle">
                            <input type="checkbox" value="Y" v-model="specification.optional_ind">
                        </td>
                    </tr>
                    <tr v-if="specifications.length == 0" class="text-center w-100">
                        <td colspan="13">ไม่มีข้อมูล</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row form-group justify-content-center clearfix tw-my-6 text-center">
            <div class="col-lg-6 col-md-6">
                <button class="btn btn-lg btn-primary tw-w-32" @click="addLine" type="button">
                    <i class="fa fa-plus"></i> เพิ่มรายการ
                </button>

                <button :disabled="!canSave"
                        class="btn btn-lg btn-primary tw-w-32" 
                        @click="save" type="button">
                    <i  class="fa fa-plus"></i> บันทึก
                </button>

                <a type="button" :href="url.qm_settings_specifications_index"
                    class="btn btn-lg tw-bg-gray-100 tw-bg-opacity-60 btn-white tw-w-32">
                    <i class="fa fa-times"></i> ยกเลิก
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            "url", 'btnTrans',
            "pTestType", "pTestList", "pRequest",
            "pSpecifications", 'pResultSeverityCode'
        ],
        data() {
            return {
                specifications: (this.pSpecifications != undefined && this.pSpecifications != '') ? this.pSpecifications : [],
                loading: false,
                delTestIdArr: [],
            };
        },
        watch: {
            specifications : async function (value) {
                // console.log('watch: specifications', value)
                // // check dup test_id

            }
        },
        mounted() {
            this.setOptionalInd();
            this.setDuplicateTestId();
        },
        methods: {
            checkMinMaxVal(specification, inputName) {
                // min_value
                // max_value
                // if (inputName == 'min_value') {
                //     if (parseFloat(specification.min_value) > parseFloat(specification.max_value)) {
                //         specification.min_value = parseFloat(specification.max_value)
                //     }
                // }
                // if (inputName == 'max_value') {
                //     if (parseFloat(specification.max_value) < parseFloat(specification.min_value)) {
                //         specification.min_value = parseFloat(specification.max_value)
                //     }
                // }
            },
            setOptionalInd() {
                this.specifications.forEach(spec => {
                    if (spec.optional_ind == 'Y') {
                        spec.optional_ind = true;
                    } else {
                        spec.optional_ind = false;
                    }
                });
            },
            setDuplicateTestId() {
                this.specifications.forEach(spec => {
                    spec.is_duplicate_test_id = false;
                });
            },
            addLine() {
                // let row = Object.keys(this.specifications).length + 1;
                let row = Object.keys(this.specifications).length;

                this.$set(this.specifications, row, {
                    seq: null,
                    test_code: null,
                    test_id: null,
                    test_unit: null,
                    min_value: null,
                    max_value: null,
                    optional_ind: null,
                    is_duplicate_test_id: false,
                    test_unit_desc: null,
                });
            },
            delLine(specification, index) {
                let vm = this;
                if (specification.seq != '') {
                    vm.delTestIdArr.push( specification.test_id );
                }
                vm.$delete(vm.specifications, index);
            },
            async changeTest(specification, index) {
                specification.is_duplicate_test_id = false;
                let test = this.pTestList.filter(o => {
                    return o.test_code == specification.test_code;
                });
                specification.test_unit = test[0].test_unit_code;
                specification.test_id = test[0].test_id;
                specification.test_unit_desc = test[0].test_unit
                specification.test_desc = test[0].test_desc



                let checkDup = this.specifications.filter(o => {
                    return o.test_id == test[0].test_id;
                });

                if (checkDup.length > 1) {
                    specification.is_duplicate_test_id = true;
                }

                // console.log('checkDup ', checkDup);

                // specifications.forEach(spec => {
                //     spec.is_duplicate_test_id = false;
                // });
            },
            submitSearch() {
                let vm = this;
                if(vm.pRequest.test_type == 5){
                    $('#fromSearch').append('<input type="hidden" name="search_flag " value="true" />');
                }
                $("#fromSearch").submit();
            },
            save() {
                let vm = this;
                swal({
                    html: true,
                    title: 'Save Trasaction ?',
                    text: '<h2 class="m-t-sm m-b-lg"><span style="font-size: 18px"> ต้องการบันทึกรายการหรือไม่ </span></h2>',
                    showCancelButton: true,
                    confirmButtonText: 'บันทึก',
                    cancelButtonText: 'ยกเลิก',
                    confirmButtonClass: 'btn btn-primary',
                    cancelButtonClass: 'btn btn-white',
                    closeOnConfirm: false,
                    closeOnCancel: true,
                    showLoaderOnConfirm: true
                },
                async function(isConfirm){
                    if (isConfirm) {
                        vm.loading = true;
                        axios.post(vm.url.qm_api_settings_specifications_store, {
                            specifications: vm.specifications,
                            test_type: vm.pTestType,
                            search_request: vm.pRequest,
                            del_test_id_arr: vm.delTestIdArr,
                        })
                        .then(function (response) {

                            if (response.data.data.status == 'S') {
                                swal({
                                    title: 'บันทึกรายการสำเร็จ',
                                    text: '<span style="font-size: 16px; text-align: left;"> ทำการบันทึกรายการเรียบร้อย </span>',
                                    type: "success",
                                    html: true
                                });
                                location.reload();
                            }

                            if (response.data.data.status == 'E') {
                                // console.log('xxxx');
                                swal({
                                    title: 'มีข้อผิดพลาด',
                                    text: '<span style="font-size: 16px; text-align: left;">'+response.data.data.msg+'</span>',
                                    type: "warning",
                                    html: true
                                });
                            }

                        }.bind(this))
                        .catch(function (error) {
                            // console.log(error);
                            // this.showErrorAlerNew(error);
                        }.bind(this))
                        .then(function () {
                            // always executed
                            // console.log('done');
                            vm.loading = false;
                        }.bind(this));
                    } else {
                        return;
                    }
                });
            }
        },
        computed: {
            canSave(){
                let canSubmit = true;
                this.specifications.forEach(async (o, i) => {
                    // console.log('canSave', o, i);
                    if (o.data_type != 'ตัวอักษร') {
                        if (parseFloat(o.min_value) > parseFloat(o.max_value)) {
                            canSubmit = false;
                        }

                        if (parseFloat(o.max_value) < parseFloat(o.min_value)) {
                            canSubmit = false;
                        }
                    }
                });

                return canSubmit;
            },
        },
    }
</script>
<style scope>

    tr.duplicate_test_id > td {
        border: 4px solid #ED5565 !important;
    }

</style>