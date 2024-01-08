<script>
export default {
    data() {
        return {
            cost_center: "",
            org: "",
            options: {
                cost_center: [],
                org: []
            },
            tableData: [],
            addTableData: []
        };
    },
    mounted() {
        this.getMasterData();
    },
    methods: {
        getMasterData() {
            this.getCostCenters();
            this.invOrg();
        },
        getCostCenters() {
            axios.get("/ct/ajax/cost_center/cost-center-view").then(res => {
                this.options.cost_center = res.data;
            });
        },
        selectCostCenter() {
            this.queryCostRm();
        },
        queryCostRm() {
            axios
                .get(`/ct/ajax/cost_rm?cost_code=${this.cost_center}`)
                .then(res => {
                    const { data } = res.data;
                    this.tableData = data;
                });
        },
        invOrg() {
            axios.get("/ct/ajax/cost_center/inv_org").then(res => {
                const { data } = res.data;
                this.options.org = data;
            });
        },
        confirmDelete(index, data) {
            this.$confirm(
                "เมื่อกดยืนยันข้อมูลนี้จะถูกลบ",
                "ต้องการลบข้อมูลนี้ใช่หรือไม่",
                {
                    confirmButtonText: "ยืนยัน",
                    cancelButtonText: "ยกเลิก"
                }
            )
                .then(() => {
                    console.log("test");
                    this.deleteOrg(index);
                })
                .catch(() => {
                    console.log("cancel");
                });
        },
        addOrgToTable() {
            const item = this.options.org.find(
                item => item.organization_code == this.org
            );
            const checkDuplicate = this.addTableData.find(
                element => item.organization_code == element.organization_code
            );
            if (!checkDuplicate) {
                this.addTableData.push(item);
            }
            this.org = "";
        },
        deleteRow(index, data) {
            data.splice(index, 1);
        },
        deleteOrg(index) {
            const item = this.tableData[index];
            console.log(item);
            axios
                .delete(
                    `/ct/ajax/cost_rm?cost_code=${this.cost_center}&org_code=${item.org_ingredient}&org_name=${item.org_ingredient}`
                )
                .then(res => {
                    swal({
                        title: "&nbsp;",
                        text: "ลบข้อมูลสำเร็จ",
                        type: "success",
                        html: true
                    });
                    this.selectCostCenter();
                    // this.addTableData = [];
                });
        },
        submitOrg() {
            if (this.cost_center && this.addTableData.length > 0) {
                // this.addTableData = [];
                const form = {
                    cost_code: this.cost_center,
                    data: this.addTableData
                };
                axios.post("/ct/ajax/cost_rm", form).then(res => {
                    swal({
                        title: "&nbsp;",
                        text: "บันทึกข้อมูลสำเร็จ",
                        type: "success",
                        html: true
                    });
                    this.selectCostCenter();
                    this.addTableData = [];
                });
            } else {
                swal(
                    "Error",
                    `กรุณาเลือกศูนย์ต้นทุนก่อนก่อนเพิ่ม ORG วัตถุดิบ`,
                    "error"
                );
            }
        }
    }
};
</script>
<template>
    <div>
        <div class="row">
            <div class="col-lg-6 col-md-12 mt-4 p-4">
                <div class="card-custom">
                    <div class="text-center">
                        <h2>
                            ข้อมูล ORG วัตถุดิบ
                        </h2>
                    </div>
                    <div class="form-group text-center">
                        <label for="" class="mr-2">ศูนย์ต้นทุน</label>
                        <el-select
                            v-model="cost_center"
                            placeholder="เลือกศูนย์ต้นทุน"
                            @change="selectCostCenter"
                        >
                            <el-option
                                v-for="item in options.cost_center"
                                :key="item.cost_code"
                                :label="`${item.cost_code}-${item.description}`"
                                :value="item.cost_code"
                            >
                            </el-option>
                        </el-select>
                    </div>
                    <el-table border :data="tableData" style="width: 100%">
                        <el-table-column
                            prop="org_ingredient"
                            label="ORG วัตถุดิบ"
                            align="center"
                        >
                        </el-table-column>
                        <el-table-column
                            prop="org_description"
                            label="รายละเอียด"
                            align="center"
                        >
                        </el-table-column>
                        <el-table-column width="120">
                            <template slot-scope="scope">
                                <div class="text-center">
                                    <el-button
                                        size="mini"
                                        type="danger"
                                        @click.native.prevent="
                                            confirmDelete(
                                                scope.$index,
                                                tableData
                                            )
                                        "
                                        ><i class="el-icon-delete"></i>ลบ
                                    </el-button>
                                </div>
                            </template>
                        </el-table-column>
                    </el-table>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 mt-4 p-4">
                <div class="card-custom">
                    <div class="text-center">
                        <h2>
                            เพิ่มข้อมูลวัตถุดิบ
                        </h2>
                    </div>
                    <div style="display: flex;justify-content: center;">
                        <div class="form-group text-center">
                            <el-select
                                v-model="org"
                                placeholder="เลือก ORG วัตถุดิบ"
                            >
                                <el-option
                                    v-for="item in options.org"
                                    :key="item.organization_code"
                                    :label="
                                        `${item.organization_code} - ${item.organization_name}`
                                    "
                                    :value="item.organization_code"
                                >
                                </el-option>
                            </el-select>
                            <el-button
                                class="btn-success mr-2 btn-p__tr"
                                style="background-color: #40c8b2; border:none;"
                                id="add_cost_center"
                                type="success"
                                @click="addOrgToTable"
                            >
                                เพิ่ม
                            </el-button>
                        </div>
                    </div>
                    <el-table border :data="addTableData" style="width: 100%">
                        <el-table-column
                            prop="organization_code"
                            label="ORG วัตถุดิบ"
                            align="center"
                        >
                        </el-table-column>
                        <el-table-column
                            prop="organization_name"
                            label="รายละเอียด"
                            align="center"
                        >
                        </el-table-column>
                        <el-table-column width="120">
                            <template slot-scope="scope">
                                <div class="text-center">
                                    <el-button
                                        size="mini"
                                        type="danger"
                                        @click.native.prevent="
                                            deleteRow(
                                                scope.$index,
                                                addTableData
                                            )
                                        "
                                        ><i class="el-icon-delete"></i>ลบ
                                    </el-button>
                                </div>
                            </template>
                        </el-table-column>
                    </el-table>
                    <div class="text-right mt-2">
                        <el-button
                            class="btn-success mr-2 btn-p__tr"
                            style="background-color: #40c8b2; border:none;"
                            id="add_cost_center"
                            type="success"
                            @click="submitOrg"
                        >
                            บันทึกการเพิ่มวัตถุดิบ
                        </el-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style lang="scss" scoped>
.flex {
    display: flex;
}
.items-center {
    align-items: center;
}
.el-select {
    width: 300px;
}
.card-custom {
    background: white;
    border-radius: 10px;
    padding: 20px !important;
}
</style>
