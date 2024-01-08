<template>
    <div v-loading="loading">
        <div class="m-2">
            <div class="form-group row">
                <label class="col-md-2 col-form-label">รายการบัญชี</label>
                <div class="col-md-4 flex-wrap">
                    <el-select
                        style="width:100%;"
                        v-model="form.account_seq"
                        placeholder="รายการบัญชี"
                    >
                        <el-option
                            v-for="(item, index) in option.account"
                            :key="index"
                            :label="item.name"
                            :value="item.name"
                        >
                        </el-option>
                    </el-select>
                    <div class="error-message" v-if="form_error.account_seq">
                        <strong class="font-bold">{{
                            form_error.account_seq.title
                        }}</strong>
                        <span class="block sm:inline">
                            {{ form_error.account_seq.message }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">เหตุผลงบ</label>
                <div class="col-md-4 flex-wrap">
                    <el-select
                        style="width:100%;"
                        v-model="form.remark_reason"
                        placeholder="เหตุผลงบ"
                        filterable
                        :loading="selectInput.SEGMENT8"
                        remote
                        :remote-method="data => searchSegment(data, 'SEGMENT8')"
                    >
                        <el-option
                            v-for="(item, index) in option.SEGMENT8"
                            :key="index"
                            :label="item.description"
                            :value="item.description"
                        >
                        </el-option>
                    </el-select>
                    <div class="error-message" v-if="form_error.remark_reason">
                        <strong class="font-bold">{{
                            form_error.remark_reason.title
                        }}</strong>
                        <span class="block sm:inline">
                            {{ form_error.remark_reason.message }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">RES1</label>
                <div class="col-md-4 flex-wrap">
                    <el-select
                        style="width:100%;"
                        v-model="form.res1"
                        placeholder="RES1"
                        :loading="selectInput.SEGMENT11"
                        filterable
                        remote
                        :remote-method="
                            data => searchSegment(data, 'SEGMENT11')
                        "
                    >
                        <el-option
                            v-for="(item, index) in option.SEGMENT11"
                            :key="index"
                            :label="item.description"
                            :value="item.description"
                        >
                        </el-option>
                    </el-select>
                    <div class="error-message" v-if="form_error.res1">
                        <strong class="font-bold">{{
                            form_error.res1.title
                        }}</strong>
                        <span class="block sm:inline">
                            {{ form_error.res1.message }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">RES2</label>
                <div class="col-md-4 flex-wrap">
                    <el-select
                        style="width:100%;"
                        v-model="form.res2"
                        placeholder="RES2"
                        :loading="selectInput.SEGMENT12"
                        filterable
                        remote
                        :remote-method="
                            data => searchSegment(data, 'SEGMENT12')
                        "
                    >
                        <el-option
                            v-for="(item, index) in option.SEGMENT12"
                            :key="index"
                            :label="item.description"
                            :value="item.description"
                        >
                        </el-option>
                    </el-select>
                    <div class="error-message" v-if="form_error.res2">
                        <strong class="font-bold">{{
                            form_error.res2.title
                        }}</strong>
                        <span class="block sm:inline">
                            {{ form_error.res2.message }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="m-2">
            <div class="form-group row flex-wrap">
                <div class="col-md-12 m-2 ">
                    <el-card
                        class="box-card my-4"
                        v-for="(item, index) in form.ledger_details"
                        :key="index"
                    >
                        <div class="row justify-content-end">
                            <div class="col-md-2 ">
                                <el-button
                                    style="width: 100%"
                                    type="danger"
                                    :disabled="form.ledger_details.length <= 1"
                                    @click.native.prevent="
                                        deleteRow(index, form.ledger_details)
                                    "
                                    ><i class="el-icon-delete"></i>
                                    ลบ
                                </el-button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 flex-wrap my-2">
                                <label>
                                    หน่วยงาน
                                </label>
                                <el-select
                                    style="width:100%;"
                                    v-model="item.code_segment3"
                                    placeholder="หน่วยงาน"
                                    filterable
                                    :loading="selectInput.SEGMENT3"
                                    remote
                                    :remote-method="
                                        data => searchSegment(data, 'SEGMENT3')
                                    "
                                >
                                    <el-option
                                        v-for="(item, index) in option.SEGMENT3"
                                        :key="index"
                                        :label="item.description"
                                        :value="item.flex_value"
                                    >
                                        <span>
                                            {{
                                                `${item.flex_value} - ${item.description}`
                                            }}
                                        </span>
                                    </el-option>
                                </el-select>
                            </div>

                            <div class="col-md-3 flex-wrap my-2">
                                <label>
                                    ศูนย์ต้นทุน
                                </label>
                                <el-select
                                    style="width:100%;"
                                    v-model="item.code_segment4"
                                    placeholder="ศูนย์ต้นทุน"
                                    filterable
                                    remote
                                    :remote-method="
                                        data => searchSegment(data, 'SEGMENT4')
                                    "
                                    :loading="selectInput.SEGMENT4"
                                >
                                    <el-option
                                        v-for="(item, index) in option.SEGMENT4"
                                        :key="index"
                                        :label="item.description"
                                        :value="item.flex_value"
                                    >
                                        <span>
                                            {{
                                                `${item.flex_value} - ${item.description}`
                                            }}
                                        </span>
                                    </el-option>
                                </el-select>
                            </div>

                            <div class="col-md-3 flex-wrap my-2">
                                <label>
                                    ORG.
                                </label>
                                <el-select
                                    style="width:100%;"
                                    v-model="item.organization_code"
                                    placeholder="ORG."
                                >
                                    <el-option
                                        v-for="(item,
                                        index) in option.organization"
                                        :key="index"
                                        :label="
                                            `${item.organization_code} - ${item.organization_name}`
                                        "
                                        :value="item.organization_code"
                                    >
                                    </el-option>
                                </el-select>
                            </div>

                            <div class="col-md-3 flex-wrap my-2">
                                <label>
                                    CAT.
                                </label>
                                <el-select
                                    style="width:100%;"
                                    v-model="item.item_cat_code"
                                    placeholder="CAT."
                                >
                                    <el-option
                                        v-for="(item, index) in option.category"
                                        :key="index"
                                        :label="item.item_cat_desc"
                                        :value="item.item_cat_code"
                                    >
                                    </el-option>
                                </el-select>
                            </div>

                            <div class="col-md-3 flex-wrap my-2">
                                <label>
                                    กลุ่มผลิตภัณฑ์
                                </label>
                                <el-select
                                    style="width:100%;"
                                    v-model="item.product_group_id"
                                    placeholder="กลุ่มผลิตภัณฑ์"
                                    :loading="selectInput.product_group"
                                >
                                    <el-option
                                        v-for="(item,
                                        index) in option.product_group"
                                        :key="index"
                                        :label="item.name"
                                        :value="item.product_group_id"
                                    >
                                        <span>{{
                                            `${item.code} - ${item.name}`
                                        }}</span>
                                    </el-option>
                                </el-select>
                            </div>

                            <div class="col-md-3 flex-wrap my-2">
                                <label>
                                    รหัสบัญชี (9)
                                </label>
                                <el-select
                                    style="width:100%;"
                                    v-model="item.code_segment9"
                                    placeholder="รหัสบัญชี (9)"
                                    filterable
                                    remote
                                    :remote-method="
                                        data => searchSegment(data, 'SEGMENT9')
                                    "
                                    :loading="selectInput.SEGMENT9"
                                >
                                    <el-option
                                        v-for="(item, index) in option.SEGMENT9"
                                        :key="index"
                                        :label="item.description"
                                        :value="item.flex_value"
                                    >
                                        <span>
                                            {{
                                                `${item.flex_value} - ${item.description}`
                                            }}
                                        </span>
                                    </el-option>
                                </el-select>
                            </div>

                            <div class="col-md-3 flex-wrap my-2">
                                <label>
                                    รหัสบัญชี (10)
                                </label>
                                <el-select
                                    style="width:100%;"
                                    v-model="item.code_segment10"
                                    filterable
                                    remote
                                    :remote-method="
                                        data => searchSegment(data, 'SEGMENT10')
                                    "
                                    :loading="selectInput.SEGMENT10"
                                    placeholder="รหัสบัญชี (10)"
                                >
                                    <el-option
                                        v-for="(item,
                                        index) in option.SEGMENT10"
                                        :key="index"
                                        :label="item.description"
                                        :value="item.flex_value"
                                    >
                                        <span>
                                            {{
                                                `${item.flex_value} - ${item.description}`
                                            }}
                                        </span>
                                    </el-option>
                                </el-select>
                            </div>

                            <div class="col-md-3 flex-wrap my-2">
                                <label>
                                    รหัสบริษัท
                                </label>
                                <el-select
                                    style="width:100%;"
                                    v-model="item.code_segment1"
                                    placeholder="รหัสบริษัท"
                                    filterable
                                    remote
                                    :remote-method="
                                        data => searchSegment(data, 'SEGMENT1')
                                    "
                                    :loading="selectInput.SEGMENT1"
                                >
                                    <el-option
                                        v-for="(item, index) in option.SEGMENT1"
                                        :key="index"
                                        :label="item.description"
                                        :value="item.flex_value"
                                    >
                                        <span>
                                            {{
                                                `${item.flex_value} - ${item.description}`
                                            }}
                                        </span>
                                    </el-option>
                                </el-select>
                            </div>

                            <div class="col-md-3 flex-wrap my-2">
                                <label>
                                    EVM
                                </label>
                                <el-select
                                    style="width:100%;"
                                    v-model="item.code_segment2"
                                    placeholder="EVM"
                                    filterable
                                    remote
                                    :remote-method="
                                        data => searchSegment(data, 'SEGMENT2')
                                    "
                                    :loading="selectInput.SEGMENT2"
                                >
                                    <el-option
                                        v-for="(item, index) in option.SEGMENT2"
                                        :key="index"
                                        :label="item.description"
                                        :value="item.flex_value"
                                    >
                                        <span>
                                            {{
                                                `${item.flex_value} - ${item.description}`
                                            }}
                                        </span>
                                    </el-option>
                                </el-select>
                            </div>

                            <!-- <div class="col-md-3 flex-wrap my-2">
                                <label>
                                    หน่วยงานงบ
                                </label>
                                <el-select
                                    style="width:100%;"
                                    v-model="item.code_budget_segment3"
                                    placeholder="หน่วยงานงบ"
                                    :loading="selectInput.SEGMENT3"
                                >
                                    <el-option
                                        v-for="(item, index) in option.SEGMENT3"
                                        :key="index"
                                        :label="item.description"
                                        :value="item.flex_value"
                                    >
                                        <span>
                                            {{
                                                `${item.flex_value} - ${item.description}`
                                            }}
                                        </span>
                                    </el-option>
                                </el-select>
                            </div> -->

                            <div class="col-md-3 flex-wrap my-2">
                                <label>
                                    รหัสงบ
                                </label>
                                <el-select
                                    style="width:100%;"
                                    v-model="item.code_segment6"
                                    placeholder="รหัสงบ"
                                    filterable
                                    remote
                                    :remote-method="
                                        data => searchSegment(data, 'SEGMENT6')
                                    "
                                    :loading="selectInput.SEGMENT6"
                                >
                                    <el-option
                                        v-for="(item, index) in option.SEGMENT6"
                                        :key="index"
                                        :label="item.description"
                                        :value="item.flex_value"
                                    >
                                        <span>
                                            {{
                                                `${item.flex_value} - ${item.description}`
                                            }}
                                        </span>
                                    </el-option>
                                </el-select>
                            </div>

                            <div class="col-md-3 flex-wrap my-2">
                                <label>
                                    รายละเอียดงบ
                                </label>
                                <el-select
                                    style="width:100%;"
                                    v-model="item.code_segment7"
                                    placeholder="รายละเอียดงบ"
                                    filterable
                                    remote
                                    :remote-method="
                                        data => searchSegment(data, 'SEGMENT7')
                                    "
                                    :loading="selectInput.SEGMENT7"
                                >
                                    <el-option
                                        v-for="(item, index) in option.SEGMENT7"
                                        :key="index"
                                        :label="item.description"
                                        :value="item.flex_value"
                                    >
                                        <span>
                                            {{
                                                `${item.flex_value} - ${item.description}`
                                            }}
                                        </span>
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                    </el-card>
                </div>
                <div class="col-md-12 m-2">
                    <el-button
                        class="btn-success"
                        type="success"
                        style="width: 100%"
                        @click.native.prevent="addRow(form.ledger_details)"
                    >
                        สร้างระบบบัญชีแยกประเภททั่วไปใหม่
                    </el-button>
                </div>
            </div>
        </div>
        <div class="col-md-12 text-right mt-4 px-0">
            <el-button
                class="btn-success"
                @click="handleSubmit()"
                type="success"
            >
                ยืนยัน
            </el-button>
            <el-button
                class="text-refresh"
                type="text"
                @click.native.prevent="refresh()"
            >
                ล้างข้อมูล
            </el-button>
        </div>
    </div>
</template>

<script>
export default {
    props: ["segment"],
    data() {
        return {
            loading: false,
            form_error: {},
            form: {
                ledger_details: [{}]
            },
            selectInput: {},
            option: {
                product_group: [],
                account: [],
                category: [],
                organization: [],
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
            }
        };
    },
    created() {
        this.getMasterData();
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
            this.getProductGroup();
            const segment_arr = [1, 2, 3, 4, 6, 7, 8, 9, 10, 11, 12];
            for (const index of segment_arr) {
                const segment = `SEGMENT${index}`;
                this.setSegmentData(segment);
            }
            this.loading = false;
        },
        getProductGroup() {
            axios.get("/ct/ajax/product_group").then(res => {
                this.option.product_group = res.data;
            });
        },
        getAccount() {
            axios.get("/ct/ajax/account").then(res => {
                this.option.account = res.data;
            });
        },
        getCategory() {
            axios.get("/ct/ajax/get_category").then(res => {
                this.option.category = res.data;
            });
        },
        getOrganization() {
            axios.get("/ct/ajax/get_organizations").then(res => {
                this.option.organization = res.data;
            });
        },
        getCostCenter() {
            axios.get("/ct/ajax/cost_center").then(res => {
                this.option.cost_center = res.data;
            });
        },
        async searchSegment(query, segment) {
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
                if (data.length > 100) {
                    let reduction = data;
                    reduction.length = 100;
                    this.option[segment] = reduction;
                } else {
                    this.option[segment] = data;
                }
                this.selectInput[segment] = false;
            }
        },
        getSegment(segment) {
            axios.get(`/ct/ajax/get_data_by_segment/${segment}`).then(res => {
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
            this.store();
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
        resetError() {
            setTimeout(() => {
                this.form_error = {};
            }, 5000);
        },
        async store() {
            await axios
                .post("/ct/ajax/account_code_ledger", this.form)
                .then(res => {
                    this.$message({
                        showClose: true,
                        message: "บันทึกสำเร็จ",
                        type: "success"
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
        },
        refresh() {
            this.form = {};
        }
    }
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
