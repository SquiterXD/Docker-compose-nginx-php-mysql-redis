<template>
    <div>
        <el-select
            v-model="cost_center"
            placeholder="เลือกศูนย์ต้นทุน"
            @change="selectCostCenter"
        >
            <el-option
                v-for="item in options"
                :key="item.cost_code"
                :label="`${item.cost_code}-${item.description}`"
                :value="item.cost_code"
            >
            </el-option>
        </el-select>
        <div v-if="cost_center">
            <div class="mt-4">
                <el-table border :data="tableData" style="width: 100%">
                    <el-table-column
                        prop="wip_step"
                        label="รหัสขั้นตอน"
                        align="center"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="wip_step_desc"
                        label="ขั้นตอนการผลิต"
                        width="180"
                        align="center"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="dl_absorption_rate"
                        label="%เทียบสำเร็จค่าแรง"
                        align="center"
                    >
                        <template slot-scope="scope">
                            <el-input-number
                                v-if="scope.row.disable"
                                :value="sum_dl_absorption_rate"
                                placeholder="%เทียบสำเร็จค่าแรง"
                                :disabled="scope.row.disable"
                                :controls="false"
                                style="width:100%;"
                                :precision="2"
                            >
                            </el-input-number>
                            <el-input-number
                                v-else
                                style="width:100%"
                                :min="0"
                                :controls="false"
                                :precision="2"
                                placeholder="%เทียบสำเร็จค่าแรง"
                                v-model="scope.row.dl_absorption_rate"
                                :disabled="scope.row.disable"
                            >
                            </el-input-number>
                        </template>
                    </el-table-column>
                    <el-table-column
                        prop="voh_absorption_rate"
                        label="%เทียบสำเร็จค่าใช้จ่ายผันแปร"
                        align="center"
                    >
                        <template slot-scope="scope">
                            <el-input-number
                                v-if="scope.row.disable"
                                placeholder="%เทียบสำเร็จค่าใช้จ่ายผันแปร"
                                :value="sum_voh_absorption_rate"
                                :disabled="scope.row.disable"
                                :controls="false"
                                style="width:100%;"
                                :precision="2"
                            >
                            </el-input-number>
                            <el-input-number
                                v-else
                                style="width:100%"
                                :min="0"
                                :controls="false"
                                :precision="2"
                                placeholder="%เทียบสำเร็จค่าใช้จ่ายผันแปร"
                                v-model="scope.row.voh_absorption_rate"
                            >
                            </el-input-number>
                        </template>
                    </el-table-column>
                    <el-table-column
                        label="%เทียบสำเร็จค่าใช้จ่ายคงที่"
                        align="center"
                        prop="foh_absorption_rate"
                    >
                        <template slot-scope="scope">
                            <el-input-number
                                v-if="scope.row.disable"
                                placeholder="%เทียบสำเร็จค่าใช้จ่ายคงที่"
                                :value="sum_foh_absorption_rate"
                                :disabled="scope.row.disable"
                                :controls="false"
                                style="width:100%;"
                                :precision="2"
                            >
                            </el-input-number>
                            <el-input-number
                                v-else
                                style="width:100%;"
                                :min="0"
                                :controls="false"
                                :precision="2"
                                placeholder="%เทียบสำเร็จค่าใช้จ่ายคงที่"
                                v-model="scope.row.foh_absorption_rate"
                            >
                            </el-input-number>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
            <div class="mt-4 text-right">
                <el-button
                    class="btn-success"
                    type="success"
                    @click="submitForm()"
                    >บันทึก
                </el-button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            tableData: [],
            options: [],
            cost_center: ""
        };
    },
    computed: {
        sum_dl_absorption_rate() {
            let result = 0;
            const data = _.filter(this.tableData, item => {
                return !item.disable;
            });
            result = _.sumBy(data, function(item) {
                return parseFloat(item.dl_absorption_rate) || 0;
            });
            return result;
        },

        sum_voh_absorption_rate() {
            let result = 0;

            const data = _.filter(this.tableData, item => {
                return !item.disable;
            });
            result = _.sumBy(data, function(item) {
                return parseFloat(item.voh_absorption_rate) || 0;
            });
            return result;
        },

        sum_foh_absorption_rate() {
            let result = 0;

            const data = _.filter(this.tableData, item => {
                return !item.disable;
            });
            result = _.sumBy(data, function(item) {
                return parseFloat(item.foh_absorption_rate) || 0;
            });
            return result;

        }
    },
    mounted() {
        this.getCostCenters();
    },
    methods: {
        getCostCenters() {
            axios.get("/ct/ajax/cost_center/cost-center-view").then(res => {
                this.options = res.data;
            });
        },
        sumTableData() {
            _.sumBy(this.data_test, function(o) {
                return o.percen_of_wage;
            });
            const data = {
                code: "",
                name: "รวม",
                percen_of_wage: 0,
                percen_of_cp_vc: 0,
                percen_of_cp_fe: 0,
                disable: true
            };
            return data;
        },
        async selectCostCenter() {
            axios
                .get(`/ct/ajax/product_processes/${this.cost_center}`)
                .then(res => {
                    console.log('selectCostCenter: ', res.data)
                    this.tableData = res.data;
                    this.tableData.push(this.sumTableData());
                });
        },
        submitForm() {
            const data = _.filter(this.tableData, item => {
                return !item.disable;
            });
            // const data = this.tableData;
            let form_input = [];
            data.forEach(item => {
                form_input.push({
                    // id: item.cc_production_process_id,
                    oprn_id: item.oprn_id,
                    routing_id: item.routing_id,
                    cost_code: item.cost_code,
                    percen_of_wage: item.dl_absorption_rate,
                    percen_of_cp_vc: item.voh_absorption_rate,
                    percen_of_cp_fe: item.foh_absorption_rate
                });
            });
            console.log({data, form_input});

            axios
                .put(`/ct/ajax/product_processes/`, form_input)
                .then(res => {
                    swal("Success", `บันทึกสำเร็จ`, "success");
                })
                .catch(err => {
                    swal(
                        "Error",
                        `ไม่สามารถบันทึกได้ | ${err.response.data.error}`,
                        "error"
                    );
                });
        }
    }
};
</script>
<style lang="scss" scoped></style>
