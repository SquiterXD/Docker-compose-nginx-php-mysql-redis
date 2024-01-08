<template>
    <div>
        <div class="ibox">
            <div class="ibox-content">
                <div class="text-right">
                    <button type="button" @click="openModalCreate" :class="trans_btn.create.class" >
                        <i :class="trans_btn.create.icon"></i> สร้าง
                    </button>
                </div>
                <!-- Table -->
                <div class="table-responsive mt-3" style="max-height: 420px;">
                    <table class="table table-borderless table-hover mt-3" style="position: sticky;">
                        <thead>
                            <tr>
                                <th class="sticky-col">ลำดับ</th>
                                <th class="sticky-col">Type</th>
                                <th class="sticky-col">กองทุน</th>
                                <th class="sticky-col">เปอร์เซนต์</th>
                                <th class="sticky-col">Dr/Cr</th>
                                <th class="sticky-col">Company Code</th>
                                <th class="sticky-col">EVM</th>
                                <th class="sticky-col">Department Code</th>
                                <th class="sticky-col">Cost Center</th>
                                <th class="sticky-col">Budget Year</th>
                                <th class="sticky-col">Budget Type</th>
                                <th class="sticky-col">Budget Detail</th>
                                <th class="sticky-col">Budget Reason</th>
                                <th class="sticky-col">Main Account</th>
                                <th class="sticky-col">Sub Account</th>
                                <th class="sticky-col">Reserved1</th>
                                <th class="sticky-col">Reserved2</th>
                                <th class="sticky-col">Start Date</th>
                                <th class="sticky-col">End Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(stamp, index) in stampAdjs">
                                <td>{{ index }}</td>
                                <td>{{ stamp.stamp_type }}</td>
                                <td>{{ stamp.fund_location }}</td>
                                <td>{{ stamp.fund }}</td>
                                <td>{{ stamp.amount_type }}</td>
                                <td>{{ stamp.segment1 }}</td>
                                <td>{{ stamp.segment2 }}</td>
                                <td>{{ stamp.segment3 }}</td>
                                <td>{{ stamp.segment4 }}</td>
                                <td>{{ stamp.segment5 }}</td>
                                <td>{{ stamp.segment6 }}</td>
                                <td>{{ stamp.segment7 }}</td>
                                <td>{{ stamp.segment8 }}</td>
                                <td>{{ stamp.segment9 }}</td>
                                <td>{{ stamp.segment10 }}</td>
                                <td>{{ stamp.segment11 }}</td>
                                <td>{{ stamp.segment12 }}</td>
                                <td>{{ stamp.start_date }}</td>
                                <td>{{ stamp.end_date }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Modak Create -->
                <div class="row">
                    <div id="modal-create" class="modal fade" aria-hidden="true" data-backdrop="static" aria-labelledby="myModalLabel">
                        <div class="modal-dialog modal-lg" style="width: 90%; max-width:950px;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    
                                    <h3 class="text-left mb-3 tw-text-grey-darknes"> กำหนดการปันส่วนแสตมป์ </h3>
                                    <button type="button" class="close" data-dismiss="modal">
                                        <span aria-hidden="true">&times;</span>
                                        <span class="sr-only">Close</span>
                                    </button>
                                    <small class="font-bold">
                                        &nbsp;
                                    </small>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-4 text-right mt-2">COMPANY</div>
                                        <div class="col-md-5">
                                            <el-select
                                                size="small"
                                                style="width:100%;"
                                                v-model="form.segment1"
                                                placeholder="COMPANY"
                                                filterable
                                                clearable
                                                remote
                                                :remote-method="query => getDataListSegments(query, 'segment1')"
                                            >
                                                <el-option
                                                    v-for="(item, index) in option.segment1"
                                                    :key="index"
                                                    :label="item.meaning + ' : ' + item.description"
                                                    :value="item.code"
                                                >
                                                </el-option>
                                            </el-select>
                                            <div id="el_explode_segment1" class="error_msg text-left"></div>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4 text-right mt-2">EVM</div>
                                        <div class="col-md-5">
                                            <el-select
                                                size="small"
                                                style="width:100%;"
                                                v-model="form.segment2"
                                                placeholder="EVM"
                                                filterable
                                                clearable
                                                remote
                                                :remote-method="query => getDataListSegments(query, 'segment2')"
                                            >
                                                <el-option
                                                    v-for="(item, index) in option.segment2"
                                                    :key="index"
                                                    :label="item.meaning + ' : ' + item.description"
                                                    :value="item.code"
                                                >
                                                </el-option>
                                            </el-select>
                                            <div id="el_explode_segment2" class="error_msg text-left"></div>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4 text-right mt-2">Department Code</div>
                                        <div class="col-md-5">
                                            <el-select
                                                size="small"
                                                style="width:100%;"
                                                v-model="form.segment3"
                                                placeholder="Department Code"
                                                filterable
                                                clearable
                                                remote
                                                :remote-method="query => getDataListSegments(query, 'segment3')"
                                                @change="getDataListSegment4()"
                                            >
                                                <el-option
                                                    v-for="(item, index) in option.segment3"
                                                    :key="index"
                                                    :label="item.meaning + ' : ' + item.description"
                                                    :value="item.code"
                                                >
                                                </el-option>
                                            </el-select>
                                            <div id="el_explode_segment3" class="error_msg text-left"></div>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4 text-right mt-2">Cost Center</div>
                                        <div class="col-md-5">
                                            <el-select
                                                size="small"
                                                style="width:100%;"
                                                v-model="form.segment4"
                                                placeholder="Cost Center"
                                                filterable
                                                clearable
                                                remote
                                                :disabled="this.loadingSegment4"
                                                :remote-method="getDataListSegment4"
                                            >
                                                <el-option
                                                    v-for="(item, index) in segment4Lists"
                                                    :key="index"
                                                    :label="item.meaning + ' : ' + item.description"
                                                    :value="item.cost_center_code"
                                                >
                                                </el-option>
                                            </el-select>
                                            <div id="el_explode_segment4" class="error_msg text-left"></div>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4 text-right mt-2">Budget Year</div>
                                        <div class="col-md-5">
                                            <el-select
                                                size="small"
                                                style="width:100%;"
                                                v-model="form.segment5"
                                                placeholder="Budget Year"
                                                filterable
                                                clearable
                                                remote
                                                :remote-method="query => getDataListSegments(query, 'segment5')"
                                            >
                                                <el-option
                                                    v-for="(item, index) in option.segment5"
                                                    :key="index"
                                                    :label="item.meaning + ' : ' + item.description"
                                                    :value="item.code"
                                                >
                                                </el-option>
                                            </el-select>
                                            <div id="el_explode_segment5" class="error_msg text-left"></div>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4 text-right mt-2">Budget Type</div>
                                        <div class="col-md-5">
                                            <el-select
                                                size="small"
                                                style="width:100%;"
                                                v-model="form.segment6"
                                                placeholder="Budget Type"
                                                filterable
                                                clearable
                                                remote
                                                :remote-method="query => getDataListSegments(query, 'segment6')"
                                                @change="getDataListSegment7()"
                                            >
                                                <el-option
                                                    v-for="(item, index) in option.segment6"
                                                    :key="index"
                                                    :label="item.meaning + ' : ' + item.description"
                                                    :value="item.code"
                                                >
                                                </el-option>
                                            </el-select>
                                            <div id="el_explode_segment6" class="error_msg text-left"></div>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4 text-right mt-2">Budget Detail</div>
                                        <div class="col-md-5">
                                            <el-select
                                                size="small"
                                                style="width:100%;"
                                                v-model="form.segment7"
                                                placeholder="Budget Detail"
                                                filterable
                                                clearable
                                                remote
                                                :disabled="this.loadingSegment7"
                                                :remote-method="getDataListSegment7"
                                            >
                                                <el-option
                                                    v-for="(item, index) in segment7Lists"
                                                    :key="index"
                                                    :label="item.meaning + ' : ' + item.description"
                                                    :value="item.budget_detail"
                                                >
                                                </el-option>
                                            </el-select>
                                            <div id="el_explode_segment7" class="error_msg text-left"></div>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4 text-right mt-2">Budget Reason</div>
                                        <div class="col-md-5">
                                            <el-select
                                                size="small"
                                                style="width:100%;"
                                                v-model="form.segment8"
                                                placeholder="Budget Reason"
                                                filterable
                                                clearable
                                                remote
                                                :remote-method="query => getDataListSegments(query, 'segment8')"
                                            >
                                                <el-option
                                                    v-for="(item, index) in option.segment8"
                                                    :key="index"
                                                    :label="item.meaning + ' : ' + item.description"
                                                    :value="item.code"
                                                >
                                                </el-option>
                                            </el-select>
                                            <div id="el_explode_segment8" class="error_msg text-left"></div>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4 text-right mt-2">Main Account</div>
                                        <div class="col-md-5">
                                            <el-select
                                                size="small"
                                                style="width:100%;"
                                                v-model="form.segment9"
                                                placeholder="Main Account"
                                                filterable
                                                clearable
                                                remote
                                                :remote-method="query => getDataListSegments(query, 'segment9')"
                                                @change="getDataListSegment10()"
                                            >
                                                <el-option
                                                    v-for="(item, index) in option.segment9"
                                                    :key="index"
                                                    :label="item.meaning + ' : ' + item.description"
                                                    :value="item.code"
                                                >
                                                </el-option>
                                            </el-select>
                                            <div id="el_explode_segment9" class="error_msg text-left"></div>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4 text-right mt-2">Sub Account</div>
                                        <div class="col-md-5">
                                            <el-select
                                                size="small"
                                                style="width:100%;"
                                                v-model="form.segment10"
                                                placeholder="Sub Account"
                                                filterable
                                                clearable
                                                remote
                                                :disabled="this.loadingSegment10"
                                                :remote-method="getDataListSegment10"
                                            >
                                                <el-option
                                                    v-for="(item, index) in segment10Lists"
                                                    :key="index"
                                                    :label="item.meaning + ' : ' + item.description"
                                                    :value="item.sub_account"
                                                >
                                                </el-option>
                                            </el-select>
                                            <div id="el_explode_segment10" class="error_msg text-left"></div>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4 text-right mt-2">Reserved1</div>
                                        <div class="col-md-5">
                                            <el-select
                                                size="small"
                                                style="width:100%;"
                                                v-model="form.segment11"
                                                placeholder="Reserved1"
                                                filterable
                                                clearable
                                                remote
                                                :remote-method="query => getDataListSegments(query, 'segment11')"
                                            >
                                                <el-option
                                                    v-for="(item, index) in option.segment11"
                                                    :key="index"
                                                    :label="item.meaning + ' : ' + item.description"
                                                    :value="item.code"
                                                >
                                                </el-option>
                                            </el-select>
                                            <div id="el_explode_segment11" class="error_msg text-left"></div>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4 text-right mt-2">Reserved2</div>
                                        <div class="col-md-5">
                                            <el-select
                                                size="small"
                                                style="width:100%;"
                                                v-model="form.segment12"
                                                placeholder="Reserved2"
                                                filterable
                                                clearable
                                                remote
                                                :remote-method="query => getDataListSegments(query, 'segment12')"
                                            >
                                                <el-option
                                                    v-for="(item, index) in option.segment12"
                                                    :key="index"
                                                    :label="item.meaning + ' : ' + item.description"
                                                    :value="item.code"
                                                >
                                                </el-option>
                                            </el-select>
                                            <div id="el_explode_segment12" class="error_msg text-left"></div>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4 text-right mt-2">วันที่เริ่มต้น</div>
                                        <div class="col-md-5">
                                            <el-date-picker 
                                                size="small"
                                                v-model="form.start_date"
                                                style="width: 100%;"
                                                type="date"
                                                placeholder="วันที่เริ่มต้น"
                                                name="start_date"
                                                format="dd-MM-yyyy"
                                                >
                                            </el-date-picker>
                                            <div id="el_explode_start_date" class="error_msg text-left"></div>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-md-4 text-right mt-2">วันที่สิ้นสุด</div>
                                        <div class="col-md-5">
                                            <el-date-picker 
                                                size="small"
                                                v-model="form.end_date"
                                                style="width: 100%;"
                                                type="date"
                                                placeholder="วันที่สิ้นสุด"
                                                name="end_date"
                                                format="dd-MM-yyyy"
                                                >
                                            </el-date-picker>
                                            <div id="el_explode_end_date" class="error_msg text-left"></div>
                                        </div>
                                        <div class="col-md-2"></div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-sm btn-primary" @click="clickSave">
                                        <i class="fa fa-save"></i> บันทึก
                                    </button>
                                    <button type="button" class="btn btn-sm btn-warning" @click="closeModalCreate">
                                        ยกเลิก
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ['trans_btn', 'stampAdjs', 'defaultValueSetName', 'segmentData'],
    data() {
        return {
            option: {
                segment1:  [],
                segment2:  [],
                segment3:  [],
                segment4:  [],
                segment5:  [],
                segment6:  [],
                segment7:  [],
                segment8:  [],
                segment9:  [],
                segment10: [],
                segment11: [],
                segment12: []
            },

            form:{
                segment1:   '',
                segment2:   '',
                segment3:   '',
                segment4:   '',
                segment5:   '',
                segment6:   '',
                segment7:   '',
                segment8:   '',
                segment9:   '',
                segment10:  '',
                segment11:  '',
                segment12:  '',
                start_date: '',
                end_date:   '',
            },

            segment4Lists:  [],
            segment7Lists:  [],
            segment10Lists: [],

            loadingSegment4:  true,
            loadingSegment7:  true,
            loadingSegment10: true,
        }
    },
    created() {
        if (this.segmentData) {
            const segment_arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];

            segment_arr.forEach(element => {
                this.option['segment'+element] = this.segmentData['segment'+element];
            });
        }
    },
    methods: {
        openModalCreate() {
            $('#modal-create').modal('show');
        },
        closeModalCreate() {
            $('#modal-create').modal('hide');
        },
        clickSave(){
            console.log('clickSave clickSave clickSave');
            let params = {
                form: this.form,
            };
            axios.post("/ct/ajax/stamp_adj", params)
            .then(res => {
                swal({
                    title: "Success",
                    text: 'บันทึกข้อมูลเรียบร้อยแล้ว',
                    timer: 3000,
                    type: "success",
                    showCancelButton: false,
                    showConfirmButton: false
                });

                // location.reload();
            })
            .catch(err => {
                 swal({
                    title: "Warning",
                    text: "ไม่สามารถบันทึกข้อมูลได้ เนื่องจากมีข้อผิดพลาด",
                    type: "warning",
                    showCancelButton: false,
                });
            })
            .then(() => {
                this.loading = false;
            });
        },
        getDataListSegments(query, segment){
            this.option[segment] = [];

            axios.get("/ct/ajax/stamp_adj/get-setment", {
                params: {
                    query:   query,
                    flex_value_set_name: this.defaultValueSetName[segment],
                }
            }).then(res => {
                this.option[segment] = res.data;
            });
        },
        getDataListSegment4(query){
            if (this.form.segment3) {
                this.loadingSegment4 = true;
            
                axios.get("/ct/ajax/stamp_adj/get-data-list", {
                    params: {
                        query:               query,
                        flex_value_set_name: this.defaultValueSetName['segment4'],
                        parent:              this.form.segment3,
                    }
                }).then(res => {
                    this.segment4Lists = res.data;
                    if (this.segment4Lists.length > 0) {
                        this.loadingSegment4 = false;
                    }
                });
            }
        },
        getDataListSegment7(query){
            if (this.form.segment6) {
                this.loadingSegment7 = true;
            
                axios.get("/ct/ajax/stamp_adj/get-data-list", {
                    params: {
                        query:               query,
                        flex_value_set_name: this.defaultValueSetName['segment7'],
                        parent:              this.form.segment6,
                    }
                }).then(res => {
                    this.segment7Lists = res.data;
                    if (this.segment7Lists.length > 0) {
                        this.loadingSegment7 = false;
                    }
                });
            }
        },
        getDataListSegment10(query){
            if (this.form.segment9) {
                this.loadingSegment10 = true;
            
                axios.get("/ct/ajax/stamp_adj/get-data-list", {
                    params: {
                        query:               query,
                        flex_value_set_name: this.defaultValueSetName['segment10'],
                        parent:              this.form.segment9,
                    }
                }).then(res => {
                    this.segment10Lists = res.data;
                    if (this.segment10Lists.length > 0) {
                        this.loadingSegment10 = false;
                    }
                });
            }
        },
    }
}
</script>
<style type="text/css" scope>
    .el-select-dropdown{
        z-index: 9999 !important;
    }

    .sticky-col {
        position: sticky;
        background-color: #dcdfdb;
        z-index: 9999;
        top: 0;
    }

    .error-message {
        display: flex;
        color: #ec4958;
        margin-top: 5px;

        strong {
            margin-right: 5px;
        }
    }

    .el-date-picker {
        z-index: 9999 !important;
    }
</style>