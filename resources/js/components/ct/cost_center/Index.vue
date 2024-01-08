<template>
    <div class="from-group" v-loading="loading">
        <div class="col-md-12 mt-4 p-0">
            <el-table border :data="tableData" style="width: 100%">
                <el-table-column
                    prop="cost_code"
                    label="รหัสศูนย์ต้นทุน"
                    align="center"
                    width="130"
                >
                </el-table-column>
                <el-table-column
                    prop="description"
                    label="ศูนย์ต้นทุน"
                    width="180"
                    header-align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="cost_group_desc"
                    label="ประเภท"
                    header-align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="organization_code"
                    label="INV.Org"
                    width="130"
                    align="center"
                >
                </el-table-column>
                <!-- <el-table-column
                    prop="cost_group_desc"
                    label="กลุ่มผลิตภัณฑ์"
                    width="180"
                    header-align="center"
                >
                </el-table-column> -->
                <el-table-column
                    label="ต้นทุนมาตรฐาน"
                    header-align="center"
                    width="350"
                >
                    <el-table-column
                        prop="quantity"
                        label="ปริมาณ"
                        align="center"
                        width="150"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="uom_code"
                        label="หน่วยนับ"
                        align="center"
                        width="150"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="uom_thai"
                        label="หน่วยนับ (ภาษาไทย)"
                        align="center"
                        width="150"
                    >
                    </el-table-column>
                </el-table-column>
                <el-table-column label="" align="center">
                    <template slot-scope="scope">
                        <a :href="`/ct/cost_center/${scope.row.cost_code}`">
                            <button
                                class="btn btn-warning btn-lg tw-w-24"
                                type="button"
                            >
                                แก้ไข
                            </button>
                        </a>
                        <button
                            class="btn btn-danger btn-lg ml-2 tw-w-24"
                            type="button"
                            @click="confirmDelete(scope.row)"
                        >
                            ลบ
                        </button>
                        <!-- <el-checkbox
                            :v-model="tableData[scope.$index].is_active"
                            :checked="
                                convertBoolean(
                                    tableData[scope.$index].is_active
                                )
                            "
                            @change="checkboxOnChange($event, scope.row)"
                        ></el-checkbox> -->
                    </template>
                </el-table-column>
            </el-table>
        </div>
    </div>
</template>
<script>
import moment from "moment";
export default {
    data() {
        return {
            form: {
                year: moment().format("yyyy")
            },
            tableData: [],
            loading: false,
            option: {
                year: []
            }
        };
    },
    mounted() {
        this.getMasterData();
        this.getCostCenterView();
    },
    // created() {
    //   this.onClickId();
    // },
    methods: {
        getMasterData() {
            this.getCostCenterView();
        },
        confirmDelete(row) {
            this.$confirm("กรุณายืนยันลบข้อมูล", "คุณแน่ใจไหม ?", {
                confirmButtonText: "ดำเนินการต่อ",
                cancelButtonText: "ยกเลิก"
            })
                .then(() => {
                    console.log("test");
                    this.del(row);
                })
                .catch(() => {
                    console.log("cancel");
                });
        },
        async del(row) {
            const url = "/ct/ajax/cost_center/package";
            let form = await {
                code: row.cost_code,
                name: row.description,
                cost_group_code: row.cost_group_code,
                qty: row.quantity,
                uom_code: row.uom_code,
                organization_code: row.organization_code,
                cost_group_code: row.cost_group_code,
                type: "DELETE",
                ...row
            };

            await axios
                .post(url, form)
                .then(res => {
                    this.getMasterData();
                    if (res.data.status == false) {
                        this.$message({
                            showClose: true,
                            message: `ศูนย์ต้นทุนมีการ assign item แล้ว ไม่สามารถลบได้`,
                            type: "error"
                        });
                    } else {
                        this.$message({
                            showClose: true,
                            message: "บันทึกสำเร็จ",
                            type: "success",
                            onClose: () => {
                                // window.location.href = "/ct/cost_center";
                            }
                        });
                    }
                })
                .catch(err => {
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
        // onClickId(){
        //   const isOnId = (path,id) => path.some(element => element.id === id);
        //   document.addEventListener('click',(e) => {
        //       if(isOnId(e.path,'add_cost_center')) {
        //         this.addCostCenter()
        //       } else {
        //         //you clicked on something else
        //       }
        //   });
        // },
        addCostCenter() {
            axios.post("/ct/ajax/cost_center/package", {}).then(res => {
                this.$message({
                    showClose: true,
                    message: "ประมวลผลสำเร็จ",
                    type: "success"
                });
            });
        },
        getYears(query) {
            axios
                .get("/ct/ajax/cost_center/years", {
                    params: { text: query }
                })
                .then(res => {
                    this.option.year.push(...res.data);
                });
        },
        arrayToString(data, obj) {
            let rs = data.map(function(item) {
                return item[obj];
            });
            rs = rs.toString();
            return rs;
        },
        getCostCenterView() {
            this.loading = true;
            axios.get("/ct/ajax/cost_center/cost-center-view").then(res => {
                this.tableData = res.data;
                this.loading = false;
            });
        },
        convertBoolean(value) {
            if (value == "1") {
                return true;
            } else if (value == "0") {
                return false;
            }
        },
        checkboxOnChange(val, row) {
            row.is_active = val;
            this.update(row);
        },
        update(row) {
            axios
                .post("/ct/ajax/cost_center/update_active", {
                    cost_center_id: row.cost_center_id,
                    is_active: row.is_active
                })
                .then(res => {
                    this.$message({
                        showClose: true,
                        message: "บันทึกสำเร็จ",
                        type: "success"
                    });
                });
        }
    }
};
</script>
<style lang="scss" scoped>
.btn-p__tr {
    background-color: green;
}
</style>
