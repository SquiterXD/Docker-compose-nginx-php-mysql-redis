<template>
    <div id="submitForm">
        <div class="row mt-2">
            <div class="col-md-2 text-right"><label class="mt-2 ">รายการบัญชี <span class="text-danger">*</span></label></div>
            <div class="form-group col-md-4">
                <el-select
                    style="width:100%;"
                    v-model="form.account_seq"
                    placeholder="รายการบัญชี"
                    :disabled="this.isEdit"
                    ref="account_seq"
                    filterable
                    clearable
                >
                    <el-option
                        v-for="(item, index) in option.account"
                        :key="index"
                        :label="item.seq + ' : ' + item.name"
                        :value="item.account_id"
                    >
                    </el-option>
                </el-select>
                <div id="el_explode_account_seq" class="error_msg text-left"></div>
            </div>
        </div>
        <hr>
        <div class="row mt-2">
            <div class="col-md-4">
                <label> รหัสบริษัท </label>
                <el-select
                    size="small"
                    style="width:100%;"
                    v-model="form.code_segment1"
                    placeholder="รหัสบริษัท"
                    filterable
                    clearable
                    remote
                    :remote-method="query => getDataListSegments(query, 'SEGMENT1')"
                    :loading="selectInput.SEGMENT1"
                >
                    <el-option
                        v-for="(item, index) in option.SEGMENT1"
                        :key="index"
                        :label="item.flex_value + ' : ' + item.description"
                        :value="item.flex_value"
                    >
                        <!-- <span>
                            {{
                                `${item.flex_value} - ${item.description}`
                            }}
                        </span> -->
                    </el-option>
                </el-select>
                <div id="el_explode_segment1" class="error_msg text-left"></div>
            </div>
            <div class="col-md-4">
                <label> EVM </label>
                <el-select
                    size="small"
                    style="width:100%;"
                    v-model="form.code_segment2"
                    placeholder="EVM"
                    filterable
                    clearable
                    remote
                    :remote-method="query => getDataListSegments(query, 'SEGMENT2')"
                    :loading="selectInput.SEGMENT2"
                >
                    <el-option
                        v-for="(item, index) in option.SEGMENT2"
                        :key="index"
                        :label="item.flex_value + ' : ' + item.description"
                        :value="item.flex_value"
                    >
                        <span>
                            {{
                                `${item.flex_value} - ${item.description}`
                            }}
                        </span>
                    </el-option>
                </el-select>
                <div id="el_explode_segment2" class="error_msg text-left"></div>
            </div>
            <div class="col-md-4">
                <label> หน่วยงาน </label>
                <el-select
                    size="small"
                    style="width:100%;"
                    v-model="form.code_segment3"
                    placeholder="หน่วยงาน"
                    filterable
                    clearable
                    :loading="selectInput.SEGMENT3"
                    remote
                    :remote-method="query => getDataListSegments(query, 'SEGMENT3')"
                    @change="getSegment4()"
                >
                    <el-option
                        v-for="(item, index) in option.SEGMENT3"
                        :key="index"
                        :label="item.flex_value + ' : ' + item.description"
                        :value="item.flex_value"
                    >
                        <span>
                            {{
                                `${item.flex_value} - ${item.description}`
                            }}
                        </span>
                    </el-option>
                </el-select>
                <div id="el_explode_segment3" class="error_msg text-left"></div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label> ศูนย์ต้นทุน </label>
                <el-select
                    size="small"
                    style="width:100%;"
                    v-model="form.code_segment4"
                    placeholder="ศูนย์ต้นทุน"
                    filterable
                    clearable
                    remote
                    :loading="selectInput.SEGMENT4"
                    :disabled="this.loadingSegment4"
                >
                    <el-option
                        v-for="(item, index) in segment4Lists"
                        :key="index"
                        :label="item.flex_value + ' : ' + item.description"
                        :value="item.flex_value"
                    >
                        <span>
                            {{
                                `${item.flex_value} - ${item.description}`
                            }}
                        </span>
                    </el-option>
                </el-select>
                <div id="el_explode_segment4" class="error_msg text-left"></div>
            </div>
            <div class="col-md-4">
                <label> BUDGET YEAR </label>
                <el-select
                    size="small"
                    style="width:100%;"
                    v-model="form.code_segment5"
                    placeholder="BUDGET YEAR"
                    filterable
                    clearable
                    remote
                    :remote-method="query => getDataListSegments(query, 'SEGMENT5')"
                    :loading="selectInput.SEGMENT1"
                >
                    <el-option
                        v-for="(item, index) in option.SEGMENT5"
                        :key="index"
                        :label="item.flex_value + ' : ' + item.description"
                        :value="item.flex_value"
                    >
                        <span>
                            {{
                                `${item.flex_value} - ${item.description}`
                            }}
                        </span>
                    </el-option>
                </el-select>
                <div id="el_explode_segment5" class="error_msg text-left"></div>
            </div>
            <div class="col-md-4">
                <label> รหัสงบ </label>
                <el-select
                    size="small"
                    style="width:100%;"
                    v-model="form.code_segment6"
                    placeholder="รหัสงบ"
                    filterable
                    clearable
                    remote
                    :remote-method="query => getDataListSegments(query, 'SEGMENT6')"
                    :loading="selectInput.SEGMENT6"
                    @change="getSegment7()"
                >
                    <el-option
                        v-for="(item, index) in option.SEGMENT6"
                        :key="index"
                        :label="item.flex_value + ' : ' + item.description"
                        :value="item.flex_value"
                    >
                        <span>
                            {{
                                `${item.flex_value} - ${item.description}`
                            }}
                        </span>
                    </el-option>
                </el-select>
                <div id="el_explode_segment6" class="error_msg text-left"></div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label> รายละเอียดงบ </label>
                <el-select
                    size="small"
                    style="width:100%;"
                    v-model="form.code_segment7"
                    placeholder="รายละเอียดงบ"
                    filterable
                    clearable
                    remote
                    :loading="selectInput.SEGMENT7"
                    :disabled="this.loadingSegment7"
                >
                    <el-option
                        v-for="(item, index) in segment7Lists"
                        :key="index"
                        :label="item.flex_value + ' : ' + item.description"
                        :value="item.flex_value"
                    >
                        <span>
                            {{
                                `${item.flex_value} - ${item.description}`
                            }}
                        </span>
                    </el-option>
                </el-select>
                <div id="el_explode_segment7" class="error_msg text-left"></div>
            </div>
            <div class="col-md-4">
                <label> เหตุผลงบ </label>
                <el-select
                        size="small"
                        style="width:100%;"
                        v-model="form.code_segment8"
                        placeholder="เหตุผลงบ"
                        filterable
                        clearable
                        :loading="selectInput.SEGMENT8"
                        remote
                        :remote-method="query => getDataListSegments(query, 'SEGMENT8')"
                    >
                        <el-option
                            v-for="(item, index) in option.SEGMENT8"
                            :key="index"
                            :label="item.flex_value + ' : ' + item.description"
                            :value="item.flex_value"
                        >
                        </el-option>
                    </el-select>
                <div id="el_explode_segment8" class="error_msg text-left"></div>
            </div>
            <div class="col-md-4">
                <label> รหัสบัญชี (9) </label>
                <el-select
                    size="small"
                    style="width:100%;"
                    v-model="form.code_segment9"
                    placeholder="รหัสบัญชี (9)"
                    filterable
                    clearable
                    remote
                    :remote-method="query => getDataListSegments(query, 'SEGMENT9')"
                    :loading="selectInput.SEGMENT9"
                    @change="getSegment10()"
                >
                    <el-option
                        v-for="(item, index) in option.SEGMENT9"
                        :key="index"
                        :label="item.flex_value + ' : ' + item.description"
                        :value="item.flex_value"
                    >
                        <span>
                            {{
                                `${item.flex_value} - ${item.description}`
                            }}
                        </span>
                    </el-option>
                </el-select>
                <div id="el_explode_segment9" class="error_msg text-left"></div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label> รหัสบัญชี (10) </label>
                <el-select
                    size="small"
                    style="width:100%;"
                    v-model="form.code_segment10"
                    filterable
                    clearable
                    remote
                    :loading="selectInput.SEGMENT10"
                    placeholder="รหัสบัญชี (10)"
                    :disabled="this.loadingSegment10"
                >
                    <!-- :remote-method="
                        data => searchSegment(data, 'SEGMENT10')
                    " -->
                    <el-option
                        v-for="(item,
                        index) in segment10Lists"
                        :key="index"
                        :label="item.flex_value + ' : ' + item.description"
                        :value="item.flex_value"
                    >
                    </el-option>
                </el-select>
                <div id="el_explode_segment10" class="error_msg text-left"></div>
            </div>
            <div class="col-md-4">
                <label> RESERVED1 </label>
                <el-select
                    size="small"
                    style="width:100%;"
                    v-model="form.code_segment11"
                    placeholder="RES1"
                    :loading="selectInput.SEGMENT11"
                    filterable
                    clearable
                    remote
                >
                    <el-option
                        v-for="(item, index) in option.SEGMENT11"
                        :key="index"
                        :label="item.description ? item.flex_value + ' : ' + item.description : item.flex_value"
                        :value="item.flex_value"
                    >
                    </el-option>
                </el-select>
                <div id="el_explode_segment11" class="error_msg text-left"></div>
            </div>
            <div class="col-md-4">
                <label> RESERVED2 </label>
                <el-select
                    size="small"
                    style="width:100%;"
                    v-model="form.code_segment12"
                    placeholder="RES2"
                    :loading="selectInput.SEGMENT12"
                    filterable
                    clearable
                    remote
                >
                    <el-option
                        v-for="(item, index) in option.SEGMENT12"
                        :key="index"
                        :label="item.description ? item.flex_value + ' : ' + item.description : item.flex_value"
                        :value="item.flex_value"
                    >
                    </el-option>
                </el-select>
                <div id="el_explode_segment12" class="error_msg text-left"></div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label> ORG. <span class="text-danger">*</span></label>
                <el-select
                    size="small"
                    style="width:100%;"
                    v-model="form.organization_id"
                    placeholder="ORG."
                    @change="getProductGroup()"
                    ref="organization_id"
                    filterable
                    clearable
                    remote
                >
                    <el-option
                        v-for="(item,
                        index) in option.organization"
                        :key="index"
                        :label="
                            `${item.organization_code} - ${item.organization_name}`
                        "
                        :value="item.organization_id"
                    >
                    </el-option>
                </el-select>
                <div id="el_explode_organization_id" class="error_msg text-left"></div>
            </div>
            <div class="col-md-4">
                <label> CAT. </label>
                <el-select
                    size="small"
                    style="width:100%;"
                    v-model="form.tobacco_group_code"
                    placeholder="CAT."
                    filterable
                    clearable
                >
                    <el-option
                        v-for="(item, index) in option.category"
                        :key="index"
                        :label="item.group_code + ' : ' + item.group_desc"
                        :value="item.group_code"
                    >
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-4">
                <label> กลุ่มผลิตภัณฑ์ </label>
                <el-select
                    size="small"
                    style="width:100%;"
                    v-model="form.product_group"
                    placeholder="กลุ่มผลิตภัณฑ์"
                    :loading="selectInput.product_group"
                    :disabled="this.loadingProductGoup"
                    filterable
                    clearable
                >
                    <el-option
                        v-for="(item,
                        index) in option.product_group"
                        :key="index"
                        :label="item.product_group + ' : ' + item.description"
                        :value="item.product_group"
                    >
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-4">
                <label> วันที่เริ่มต้น </label>
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
            </div>
            <div class="col-md-4">
                <label> วันที่สิ้นสุด </label>
                <el-date-picker 
                    size="small"
                    v-model="form.end_date"
                    style="width: 100%;"
                    type="date"
                    placeholder="วันที่เริ่มต้น"
                    name="end_date"
                    format="dd-MM-yyyy"
                    >
                </el-date-picker>
            </div>
            <div class="col-md-4">
                <label> Active </label>
                <div>
                    <input type="checkbox" name="enable_flag" v-model="form.enable_flag">
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12 text-right">
                <button class="btn btn-sm btn-primary" type="button" @click="handleSubmit()"> <i class="fa fa-save"></i> ยืนยัน </button>
                <button class="btn btn-sm btn-warning" type="button" @click="refresh()"><i class="fa fa-times"></i> ล้างข้อมูล </button>
                <!-- <el-button class="btn btn-primary btn-sm" @click="handleSubmit()" type="button"> ยืนยัน </el-button>
                <el-button class="text-refresh btn btn-sm btn-danger" type="button" @click.native.prevent="refresh()"> ล้างข้อมูล </el-button> -->
            </div>
        </div>

        <div class="row mt-2">
            <h3 class="ml-3">{{ form.code_segment1 + '.' + form.code_segment2 + '.' + form.code_segment3 + '.' + form.code_segment4 + '.' + form.code_segment5 + '.' + form.code_segment6 + '.' + form.code_segment7 + '.' + form.code_segment8 + '.' + form.code_segment9 + '.' + form.code_segment10 + '.' + form.code_segment11 + '.' + form.code_segment12 }}</h3>
        </div>
    </div>
</template>

<script>
export default {
    props: ["segment", "detail", "header", "organizations"],
    data() {
        return {
            loading: false,
            form_error: {},
            form: {
                account_seq:    this.header ? this.header.account_id     : '',
                code_segment1:  this.detail ? this.detail.code_segment1  : '',
                code_segment2:  this.detail ? this.detail.code_segment2  : '',
                code_segment3:  this.detail ? this.detail.code_segment3  : '',
                code_segment4:  this.detail ? this.detail.code_segment4  : '',
                code_segment5:  this.detail ? this.detail.code_segment5  : '',
                code_segment6:  this.detail ? this.detail.code_segment6  : '',
                code_segment7:  this.detail ? this.detail.code_segment7  : '',
                code_segment8:  this.detail ? this.detail.code_segment8  : '',
                code_segment9:  this.detail ? this.detail.code_segment9  : '',
                code_segment10: this.detail ? this.detail.code_segment10 : '',
                code_segment11: this.detail ? this.detail.code_segment11 : '',
                code_segment12: this.detail ? this.detail.code_segment12 : '',
                enable_flag:    this.detail ? this.detail.enable_flag == 'Y' ? true : false : true,

                organization_id: this.detail ? this.detail.organization_id : '',
                tobacco_group_code: this.detail ? this.detail.tobacco_group_code : '',
                product_group:      this.detail ? this.detail.product_group      : '',
                start_date: '',
                end_date: '',
                ac_ledger_detail_id: this.detail ? this.detail.ac_ledger_detail_id : '',
            },
            selectInput: {},
            option: {
                product_group: [],
                account: [],
                category: [],
                organization: [],
                // organization: this.organizations,
                cost_center: [],
                SEGMENT1: [],
                SEGMENT2: [],
                SEGMENT3: [],
                SEGMENT4: [],
                SEGMENT5: [],
                SEGMENT6: [],
                SEGMENT7: [],
                SEGMENT8: [],
                SEGMENT9: [],
                SEGMENT10: [],
                SEGMENT11: [],
                SEGMENT12: []
            },

            segment4Lists: [],
            segment7Lists: [],
            segment10Lists: [],

            loadingProductGoup: true,
            loadingSegment4: true,
            loadingSegment7: true,
            loadingSegment10: true,

            isEdit: this.detail ? true : false,

            errors: {
                account_seq: false,
                organization_id: false,
            },

            account_code: '',
        };
    },
    created() {
        this.getMasterData();
        this.form.start_date = new Date();

        if (this.form.code_segment3) {
            this.getSegment4();
        }
        if (this.form.code_segment6) {
            this.getSegment7();
        }
        if (this.form.code_segment9) {
            this.getSegment10();
        }      
        
        if (this.form.organization_id) {
            this.getProductGroup();
        }
    },
    methods: {
        checkOption(data) {
            if (data.length > 0) {
                return false;
            }
            return true;
        },
        async getMasterData() {
            this.loading = true;
            this.getAccount();
            this.getCategory();
            this.getOrganization();
            this.getCostCenter();
            // this.getProductGroup();
            const segment_arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12];
            for (const index of segment_arr) {
                const segment = `SEGMENT${index}`;
                this.setSegmentData(segment);
            }
            this.loading = false;            
        },
        getProductGroup() {
            this.loadingProductGoup = true;
            
            if (this.form.organization_id) {          
                axios.get("/ct/ajax/account_code_ledger/get-product-group", {
                    params: {
                        organization_id: this.form.organization_id,
                    }
                }).then(res => {
                    this.option.product_group = res.data;

                    if (this.option.product_group.length > 0) {
                        this.loadingProductGoup = false;
                    }
                });
            } else {
                tthis.form.product_group = '';
            }
        },
        getAccount() {
            axios.get("/ct/ajax/account").then(res => {
                // this.option.account = res.data;
                this.option.account = _.sortBy(res.data, function(o) { return Number(o.seq); });
            });
        },
        getCategory() {
            axios.get("/ct/ajax/account_code_ledger/get-category").then(res => {
                this.option.category = res.data;
            });
        },
        getOrganization() {
            axios.get("/ct/ajax/account_code_ledger/get-organizations").then(res => {
                this.option.organization = res.data;
            });
        },
        getCostCenter() {
            axios.get("/ct/ajax/cost_center").then(res => {
                this.option.cost_center = res.data;
            });
        },
        async searchSegment(query, segment) {
            console.log('searchSegment');
            this.selectInput[segment] = await true;
            let arr = await this.segment[segment].filter(
                item =>
                    item.description.includes(query) ||
                    item.flex_value.includes(query)
            );
            this.setSegmentData(segment, arr);
        },
        setSegmentData(segment, data = false) {
            data = data ? data : this.segment[segment];
            this.selectInput[segment] = true;
            if (data) {
                // if (data.length > 100) {
                //     let reduction = data;
                //     reduction.length = 100;
                //     this.option[segment] = reduction;
                // } else {
                    this.option[segment] = data;
                // }
                this.selectInput[segment] = false;
            }
        },
        getSegment(segment) {
            axios.get(`/ct/ajax/account_code_ledger/get-lov-list/${segment}`).then(res => {
                this.option[segment] = res.data;
            });
        },
        addRow(data, item = {}) {
            data.push(item);
        },
        deleteRow(index, data) {
            data.splice(index, 1);
        },
        handleSubmit() {
            this.loading = true;
            if (this.isEdit) {
                this.update();
            } else {
                this.store();
            }
        },
        getDataListSegments(query, segment) {
            axios.get("/ct/ajax/account_code_ledger/get-data-list-segments", {
                params: {
                    query:   query,
                    segment: segment,
                    detail: this.detail,
                }
            }).then(res => {
                this.option[segment] = res.data;
            });
        },
        errorMessage(err) {
            const { errors } = err;
            if (errors) {
                Object.keys(errors).forEach(item => {
                    this.form_error[item] = {};
                    this.form_error[item]["title"] = item;
                    this.form_error[item]["message"] = errors[item][0];
                });
                this.resetError();
            }
        },
        // resetError() {
        //     setTimeout(() => {
        //         this.form_error = {};
        //     }, 5000);
        // },
        setError(ref_name){
                let ref = this.$refs[ref_name].$refs.reference
                        ? this.$refs[ref_name].$refs.reference.$refs.input
                        : (this.$refs[ref_name].$refs.textarea
                            ? this.$refs[ref_name].$refs.textarea
                            : (this.$refs[ref_name].$refs.input.$refs
                                ? this.$refs[ref_name].$refs.input.$refs.input
                                : this.$refs[ref_name].$refs.input ));
                ref.style = "border: 1px solid red;";
        },
        resetError(ref_name){
            let ref = this.$refs[ref_name].$refs.reference
                    ? this.$refs[ref_name].$refs.reference.$refs.input
                    : (this.$refs[ref_name].$refs.textarea
                        ? this.$refs[ref_name].$refs.textarea
                        : (this.$refs[ref_name].$refs.input.$refs
                            ? this.$refs[ref_name].$refs.input.$refs.input
                            : this.$refs[ref_name].$refs.input ));
            ref.style = "";
        },
        errorRef(res){
            var vm = this;
            vm.errors.account_seq     = res.err.account_seq;
            vm.errors.organization_id = res.err.organization_id;
        },
        async store() {
            let errorMsg = '';

            this.errors.account_seq = false;
            this.errors.organization_id = false;

            $(submitForm).find("div[id='el_explode_organization_id']").html("");
            $(submitForm).find("div[id='el_explode_account_seq']").html("");
            
            if (!this.form.account_seq) {
                this.errors.account_seq = true;
                errorMsg = "กรุณาเลือก รายการบัญชี";
                $(submitForm).find("div[id='el_explode_account_seq']").html(errorMsg);
            }

            if (!this.form.organization_id) {
                this.errors.organization_id = true;
                errorMsg = "กรุณาเลือก ORG";
                $(submitForm).find("div[id='el_explode_organization_id']").html(errorMsg);
            }
            if (this.form.account_seq && this.form.organization_id) {
                await axios
                    .post("/ct/ajax/account_code_ledger", this.form)
                    .then(res => {
                        this.$message({
                            showClose: true,
                            message: "บันทึกสำเร็จ",
                            type: "success",
                            onClose: () => {
                                window.location.href = "/ct/account_code_ledger";
                            }
                        });
                    })
                    .catch(err => {
                        this.errorMessage(err.response.data);
                        this.$message({
                            showClose: true,
                            message: `ไม่สามารถบันทึกได้`,
                            type: "error"
                        });
                    })
                    .then(() => {
                        this.loading = false;
                    });
            }
        },
        async update() {
            let errorMsg = '';

            this.errors.account_seq = false;
            this.errors.organization_id = false;

            $(submitForm).find("div[id='el_explode_organization_id']").html("");
            $(submitForm).find("div[id='el_explode_account_seq']").html("");
            
            if (!this.form.account_seq) {
                this.errors.account_seq = true;
                errorMsg = "กรุณาเลือก รายการบัญชี";
                $(submitForm).find("div[id='el_explode_account_seq']").html(errorMsg);
            }

            if (!this.form.organization_id) {
                this.errors.organization_id = true;
                errorMsg = "กรุณาเลือก ORG";
                $(submitForm).find("div[id='el_explode_organization_id']").html(errorMsg);
            }

            if (this.form.account_seq && this.form.organization_id) {
                await axios
                .post("/ct/ajax/account_code_ledger/update", this.form)
                .then(res => {
                    this.$message({
                        showClose: true,
                        message: "บันทึกสำเร็จ",
                        type: "success",
                        onClose: () => {
                            window.location.href = "/ct/account_code_ledger";
                        }
                    });
                })
                .catch(err => {
                    this.errorMessage(err.response.data);
                    this.$message({
                        showClose: true,
                        message: `ไม่สามารถบันทึกได้`,
                        type: "error"
                    });
                })
                .then(() => {
                    this.loading = false;
                });
            }
        },
        refresh() {
            this.form = {};
        },
        getSegment4() {
            this.loadingSegment4 = true;
            

            if (this.form.code_segment3) {
            
                axios.get("/ct/ajax/account_code_ledger/get-data-list", {
                        params: {
                            parent: this.form.code_segment3,
                            segment: 'SEGMENT4',
                            segment_parent: 'SEGMENT3'
                        }
                    }).then(res => {
                    this.segment4Lists = res.data;
                    if (this.segment4Lists.length > 0) {
                        this.loadingSegment4 = false;
                    }
                });
            } else {
                this.form.code_segment4 = '';
            }
        },
        getSegment7() {
            this.loadingSegment7 = true;
            

            if (this.form.code_segment6) {
            
                axios.get("/ct/ajax/account_code_ledger/get-data-list", {
                        params: {
                            parent: this.form.code_segment6,
                            segment: 'SEGMENT7',
                            segment_parent: 'SEGMENT6'
                        }
                    }).then(res => {
                    this.segment7Lists = res.data;
                    if (this.segment7Lists.length > 0) {
                        this.loadingSegment7 = false;
                    }
                });
            } else {
                this.form.code_segment7 = '';
            }
        },
        getSegment10() {
            this.loadingSegment10 = true;

            if (this.form.code_segment9) {
            
                axios.get("/ct/ajax/account_code_ledger/get-data-list", {
                        params: {
                            parent: this.form.code_segment9,
                            segment: 'SEGMENT10',
                            segment_parent: 'SEGMENT9'
                        }
                    }).then(res => {
                    this.segment10Lists = res.data;
                    if (this.segment10Lists.length > 0) {
                        this.loadingSegment10 = false;
                    }
                });
            } else {
                this.form.code_segment10 = '';
            }
        },
    },
    watch:{
        errors: {
            handler(val){
                val.organization_id ? this.setError('organization_id') : this.resetError('organization_id');
            },
            deep: true,
        },
    },
};
</script>
<style lang="scss" scoped>
.box-card {
    padding: 20px;
}
.error-message {
    display: flex;
    color: #ec4958;
    margin-top: 5px;

    strong {
        margin-right: 5px;
    }
}
.mt-custom__10 {
    margin-top: 10px;
}
.text-title {
    font-size: 16px;
    font-weight: 600;
}
.btn-info {
    background-color: #02b0ef;
    border-color: #02b0ef;
}
.btn-success {
    background-color: #1ab394;
    border-color: #1ab394;
}
.btn-cancel {
    background-color: #ec4958;
    border-color: #ec4958;
    color: white;
}
.text-refresh {
    color: #ec4958;
}
</style>
