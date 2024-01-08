<template>
    <div class="list-product-groups">
        <div class="form-group row">
            <div class="col-lg-12">
                <el-select
                    filterable
                    v-model="search.period_year"
                    placeholder="ปีบัญชีงบประมาณ"
                    @change="getCodeCostCenter()"
                >
                    <el-option
                        v-for="(item, index) in ddYears"
                        :key="index"
                        :label="item.label_year"
                        :value="item.fiscal_year"
                    >
                    </el-option>
                </el-select>

                <!-- <el-select
                    filterable
                    v-model="search.code"
                    placeholder="ศูนย์ต้นทุน"
                >
                    <el-option
                        v-for="(item, index) in ddCodes"
                        :key="index"
                        :label="item.name"
                        :value="item.code"
                    >
                        <span>{{`${item.code} - ${item.name}`}}</span>
                    </el-option>
                </el-select> -->

                <el-input
                    style="width:200px"
                    placeholder="แผนผลิตภัณฑ์"
                    v-model="form.plan_version_no"
                >
                </el-input>
                <el-button
                    class="btn-success ml-2"
                    type="success"
                    @click="create()"
                >
                    ดึงข้อมูล
                </el-button>
            </div>
        </div>
        <div v-if="status.product_group">
            <div>
                <hr />
                <div class="text-title m-2 justify_between">
                    <div>
                        กลุ่มผลิตภัณฑ์
                    </div>
                    <el-button class="btn-success" type="success" @click="submit()">
                        บันทึก
                    </el-button>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">
                        กลุ่มผลิตภัณฑ์
                    </label>
                    <div class="col-md-6 flex-wrap">
                        <el-select
                            style="width: 100%"
                            filterable
                            v-model="form.product_group_id"
                            placeholder="กลุ่มผลิตภัณฑ์"
                            @change="selectProdcutGroup"
                        >
                            <el-option
                                v-for="(item, index) in option.product_group"
                                :key="index"
                                :label="item.name"
                                :value="item.product_group_id"
                            >
                                <span>{{ `${item.code} - ${item.name}` }}</span>
                            </el-option>
                        </el-select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">
                        ความกว้าง (ซม.)
                    </label>
                    <div class="col-md-6 flex-wrap">
                        <el-input-number
                            style="width:100%;text-align:left;"
                            :min="0"
                            :controls="false"
                            :precision="2"
                            placeholder="ความกว้าง (ซม.)"
                            v-model="form.width"
                        >
                        </el-input-number>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">
                        ความยาว (ซม.)
                    </label>
                    <div class="col-md-6 flex-wrap">
                        <el-input-number
                            style="width:100%;text-align:left;"
                            :min="0"
                            :controls="false"
                            :precision="2"
                            placeholder="ความยาว (ซม.)"
                            v-model="form.long"
                        >
                        </el-input-number>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">
                        พื้นที่ของการทำงาน (ซม.)
                    </label>
                    <div class="col-md-6 flex-wrap">
                        <el-input-number
                            style="width:100%;text-align:left;"
                            :min="0"
                            :controls="false"
                            :precision="2"
                            placeholder="พื้นที่ของการทำงาน"
                            v-model="form.area"
                        >
                        </el-input-number>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">
                        จำนวนรอบ
                    </label>
                    <div class="col-md-6 flex-wrap">
                        <el-input-number
                            style="width:100%"
                            :min="0"
                            :controls="false"
                            :precision="2"
                            placeholder="จำนวนรอบ"
                            v-model="form.around"
                        >
                        </el-input-number>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="status.product">
            <hr />
            <div class="text-title m-2">
                ผลิตภัณฑ์
            </div>
            <el-table
                border
                :data="tableData"
                style="width: 100%"
                :summary-method="getSummaries"
                show-summary
            >
                <el-table-column
                    prop="code"
                    label="ผลิตภัณฑ์"
                    align="center"
                    width="400"
                >
                </el-table-column>
                <el-table-column
                    prop="name"
                    label="ชื่อผลิตภัณฑ์"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="qty_productivity"
                    label="ปริมาณผลผลิตตามแผน (ชิ้น/กิโลกรัม)"
                    align="center"
                >
                    <template slot-scope="scope">
                        <el-input
                            style="width:100%"
                            :controls="false"
                            placeholder="ปริมาณผลผลิตตามแผน (ชิ้น/กิโลกรัม)"
                            v-model="scope.row.qty_productivity"
                        >
                        </el-input>
                    </template>
                </el-table-column>
            </el-table>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                width: "",
                long: "",
                area: "",
                around: ""
            },
            ddYears: [],
            ddCodes: [],

            search: {
                fiscal_year: "",
                code: ""
            },
            option: {
                product_group: []
            },
            status: {
                product_group: false,
                product: false
            },
            tableData: []
        };
    },
    mounted() {
        this.getMasterData();
    },
    methods: {
        getMasterData() {
            axios.get("/ct/ajax/cost_center/years").then(res => {
                this.ddYears = res.data;
            });
            this.getCodeCostCenter();            
            this.getProductGroup();
        },
        getCodeCostCenter(){
            this.search.code = ""
            let fiscal_year = ''
            if (this.search.period_year) {
                fiscal_year = `?fiscal_year=${this.search.period_year}`
            }
            axios.get(`/ct/ajax/cost_center/codes${fiscal_year}`).then(res => {
                this.ddCodes = res.data;
            });
        },
        getProductGroup() {
            axios.get("/ct/ajax/product_group").then(res => {
                this.option.product_group = res.data;
            });
        },
        create() {
            axios
                .post(`/ct/ajax/product-group-plan`, {
                    period_year: this.search.period_year,
                    plan_version_no: this.form.plan_version_no,
                })
                .then(res => {
                    console.log(res.data)
                    this.$message({
                        showClose: true,
                        message: "บันทึกสำเร็จ",
                        type: "success"
                    });
                })
                .catch(err => {
                    this.loading = false;
                    this.errorMessage(err.response.data);
                    this.$message({
                        showClose: true,
                        message: `ไม่สามารถบันทึกได้`,
                        type: "error"
                    });
                });

            this.status.product_group = true;
        },
        submit() {
            axios
                .post(`/ct/ajax/product_plan_amount/update`, {
                    data: this.tableData,
                    pg: this.form,
                    pg_detail: this.tableData
                })
                .then(res => {
                    this.$message({
                        showClose: true,
                        message: "บันทึกสำเร็จ",
                        type: "success"
                    });
                })
                .catch(err => {
                    this.loading = false;
                    this.errorMessage(err.response.data);
                    this.$message({
                        showClose: true,
                        message: `ไม่สามารถบันทึกได้`,
                        type: "error"
                    });
                });
        },
        selectProdcutGroup() {
            const productGroup = this.option.product_group.find(
                element =>
                    element.product_group_id == this.form.product_group_id
            );

            this.form.width = productGroup.width;
            this.form.long = productGroup.long;
            this.form.area = productGroup.area;

            axios
                .get(
                    `/ct/ajax/product_group_detail/find_pg/${this.form.product_group_id}`
                )
                .then(res => {
                    this.tableData = res.data;
                    this.status.product = true;
                });
        },
        getSummaries(param) {
            const { columns, data } = param;
            const sums = [];
            columns.forEach((column, index) => {
                if (index === 0) {
                    sums[index] = "รวม";
                    return;
                }
                const values = data.map(item => Number(item[column.property]));
                if (!values.every(value => isNaN(value))) {
                    sums[index] = values.reduce((prev, curr) => {
                        const value = Number(curr);
                        if (!isNaN(value)) {
                            return prev + curr;
                        } else {
                            return prev;
                        }
                    }, 0);
                } else {
                    sums[index] = "";
                }
            });
            return sums;
        }
    }
};
</script>
<style lang="scss" scoped>
.el-table .warning-row {
    background-color: oldlace !important;
}
.el-input-number .el-input__inner {
    text-align: left !important;
}
.justify_between {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.side_list {
    height: 500px;
    border-radius: 5px;
    padding: 20px;
    border: 2px solid #eee;
    .title {
        font-size: 14px;
        font-weight: bold;
        color: #909399;
    }
    .show_list {
        max-height: 400px;
        overflow: scroll;
        &-item {
            width: 100%;
            justify-content: space-between;
        }
    }
}
.m-px__5 {
    margin: 5px;
}
.flex {
    display: flex;
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
.show_list {
    display: flex;
    flex-wrap: wrap;
    &-item {
        cursor: pointer;
        display: flex;
        margin: 5px;
        background-color: #f4f4f5;
        padding: 3px 10px;
        color: #909399;
        border-color: #e9e9eb;
        border-radius: 3px;
        text-align: left;
        align-items: center;
        &:hover {
            background-color: #ededf0;
        }
        &__close {
            margin-left: 10px;
        }
    }
}
</style>
