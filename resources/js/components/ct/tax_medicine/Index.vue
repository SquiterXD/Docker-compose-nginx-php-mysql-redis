<template>
    <div class="from-group" v-loading="loading">
        <div class="col-md-12 mt-4 p-0">
                <el-table
                    border
                    :data="tableData.ptct_item_tax_v"
                    style="width: 100%"
                >
                    <el-table-column
                        prop="item_number"
                        label="รหัสวัตถุดิบ"
                        width="180"
                        align="center"
                    >
                    </el-table-column>
                    <el-table-column
                        label="ชื่อวัตถุดิบ"
                        align="center"
                    >
                        <template slot-scope="scope">
                            {{`${scope.row.item_description}`}}
                        </template>
                    </el-table-column>
                    <el-table-column
                        prop="tax_item_number"
                        label="รหัสวัตถุดิบ(ภาษี)"
                        width="180"
                        align="center"
                    >
                    </el-table-column>
                    <el-table-column
                        label="ชื่อวัตถุดิบ(ภาษี)"
                        align="center"
                    >
                        <template slot-scope="scope">
                            {{`${scope.row.tax_item_description}`}}
                        </template>
                    </el-table-column>
                    <el-table-column
                        label="Action"
                        align="center"
                        width="100"
                    >
                        <template slot-scope="scope">
                            <el-button
                                class="btn-danger"
                                @click="handleDestroy(scope.row.item_number)"
                                type="danger">
                                ลบ
                            </el-button>
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
            tableData: {
                ptct_item_tax_v: [],
                determine: [],
                not_determine: []
            },
            loading: false,
            activeName: "determine"
        };
    },
    mounted() {
        this.getMasterData();
    },
    methods: {
        handleClick() {},
        getMasterData() {
            this.loading = true;
            this.getPtctItemTaxV();
            // this.getDetermine();
            // this.getNotDetermine();
            this.loading = false;
        },
        getDetermine() {
            axios.get("/ct/ajax/tax_medicine/determine").then(res => {
                this.tableData.determine = res.data;
            });
        },
        getPtctItemTaxV(){
            axios.get("/ct/ajax/tax_medicine").then(res => {
                this.tableData.ptct_item_tax_v = res.data
                console.log(res.data)
            })
        },
        getNotDetermine() {
            axios.get("/ct/ajax/tax_medicine/not_determine").then(res => {
                this.tableData.not_determine = res.data;
            });
        },
        async handleDestroy(item_number) {
            this.loading = true;
            await axios
                .post("/ct/ajax/tax_medicine/delete/"+item_number)
                .then(res => {
                    this.$message({
                        showClose: true,
                        message: "ลบวัตถุดิบสำเร็จ",
                        type: "success",
                        onClose: () => {
                            window.location.href = "/ct/tax_medicine";
                        }
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
                })
                .then(() => {
                    this.loading = false;
                });
        },
    }
};
</script>
<style lang="scss" scoped></style>
