<template>
    <div v-loading="loading">
        <el-select
            v-model="agency"
            placeholder="หน่วยงานฝ่าย"
            @change="selectSetAccountTypeDept"
        >
            <el-option
                v-for="(item, index) in agency_data"
                :key="index"
                :label="item.name"
                :value="item.code"
            >
            </el-option>
        </el-select>
        <div v-if="agency" class="mt-4">
            <el-tabs type="card" v-model="activeName" @tab-click="handleClick">
                <el-tab-pane label="กองภายใต้ส่วน" name="under_part">
                    <div class="mt-4">
                        <label>
                            หน่วยงานส่วน
                        </label>
                        <el-table
                            border
                            :data="tableData.tab_under_part.agency_part"
                            style="width: 100%"
                        >
                            <el-table-column
                                prop="agency_code"
                                label="หน่วยงานส่วน"
                                align="center"
                            >
                                <template slot-scope="scope">
                                    <el-input
                                        type="text"
                                        style="width:100%"
                                        :controls="false"
                                        placeholder="หน่วยงานส่วน"
                                        v-model="scope.row.agency_code"
                                    >
                                    </el-input>
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="agency_name"
                                label="ชื่อหน่วยงาน"
                                align="center"
                            >
                                <template slot-scope="scope">
                                    <el-input
                                        type="text"
                                        style="width:100%"
                                        :controls="false"
                                        placeholder="หน่วยงานส่วน"
                                        v-model="scope.row.agency_name"
                                    >
                                    </el-input>
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="agency"
                                label="หน่วยงาน"
                                align="center"
                            >
                                <template slot-scope="scope">
                                    <el-select
                                        v-model="scope.row.agency"
                                        filterable
                                        placeholder="หน่วยงาน"
                                        style="width: 100%"
                                        multiple
                                    >
                                        <el-option
                                            v-for="(item,
                                            index) in agency_options"
                                            :key="index"
                                            :label="item.name"
                                            :value="item.code"
                                        >
                                        </el-option>
                                    </el-select>
                                </template>
                            </el-table-column>
                        </el-table>
                    </div>
                    <div class="mt-4">
                        <label>
                            หน่วยงานกอง
                        </label>
                        <el-table
                            border
                            :data="tableData.tab_under_part.division"
                            style="width: 100%"
                        >
                            <el-table-column
                                prop="agency_code"
                                label="หน่วยงานกอง"
                                align="center"
                            >
                                <template slot-scope="scope">
                                    <el-input
                                        type="text"
                                        style="width:100%"
                                        :controls="false"
                                        placeholder="หน่วยงานส่วน"
                                        v-model="scope.row.agency_code"
                                    >
                                    </el-input>
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="agency_name"
                                label="ชื่อหน่วยงาน"
                                align="center"
                            >
                                <template slot-scope="scope">
                                    <el-input
                                        type="text"
                                        style="width:100%"
                                        :controls="false"
                                        placeholder="ชื่อหน่วยงาน"
                                        v-model="scope.row.agency_name"
                                    >
                                    </el-input>
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="agency"
                                label="หน่วยงาน"
                                align="center"
                            >
                                <template slot-scope="scope">
                                    <el-select
                                        v-model="scope.row.agency"
                                        filterable
                                        placeholder="หน่วยงาน"
                                        style="width: 100%"
                                        multiple
                                    >
                                        <el-option
                                            v-for="(item,
                                            index) in agency_options"
                                            :key="index"
                                            :label="item.name"
                                            :value="item.code"
                                        >
                                        </el-option>
                                    </el-select>
                                </template>
                            </el-table-column>
                        </el-table>
                    </div>
                </el-tab-pane>
                <el-tab-pane label="กองภายใต้ผ่าย" name="under_side">
                    <div class="mt-4">
                        <label>
                            หน่วยงานกอง
                        </label>
                        <el-table
                            border
                            :data="tableData.tab_under_side.division"
                            style="width: 100%"
                        >
                            <el-table-column
                                prop="agency_code"
                                label="หน่วยงานกอง"
                                align="center"
                            >
                                <template slot-scope="scope">
                                    <el-input
                                        type="text"
                                        style="width:100%"
                                        :controls="false"
                                        placeholder="หน่วยงานส่วน"
                                        v-model="scope.row.agency_code"
                                    >
                                    </el-input>
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="agency_name"
                                label="ชื่อหน่วยงาน"
                                align="center"
                            >
                                <template slot-scope="scope">
                                    <el-input
                                        type="text"
                                        style="width:100%"
                                        :controls="false"
                                        placeholder="ชื่อหน่วยงาน"
                                        v-model="scope.row.agency_name"
                                    >
                                    </el-input>
                                </template>
                            </el-table-column>
                            <el-table-column
                                prop="agency"
                                label="หน่วยงาน"
                                align="center"
                            >
                                <template slot-scope="scope">
                                    <el-select
                                        v-model="scope.row.agency"
                                        filterable
                                        placeholder="หน่วยงาน"
                                        style="width: 100%"
                                        multiple
                                    >
                                        <el-option
                                            v-for="(item,
                                            index) in agency_options"
                                            :key="index"
                                            :label="item.name"
                                            :value="item.code"
                                        >
                                        </el-option>
                                    </el-select>
                                </template>
                            </el-table-column>
                        </el-table>
                    </div>
                </el-tab-pane>
            </el-tabs>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            loading: false,
            agency: "",
            agency_data: [],
            activeName: "under_part",
            agency_options: [
                {
                    code: "11990000",
                    name: "สำนักงานโครงการย้ายโรงงานผลิตยาสูบ"
                },
                {
                    code: "12000100",
                    name: "ศูนย์ป้องบุหรี่ปลอมแปลงและบุหรีลักลอบ"
                },
                {
                    code: "12000101",
                    name: "งานด้านแผนงานและวิชาการ"
                },
                {
                    code: "12000102",
                    name: "งานด้านปฏิบัติการ"
                },
                {
                    code: "12000200",
                    name: "สำนักคุณภาพความปลอดภัยและสิ่งแวดล้อม"
                },
                {
                    code: "12000300",
                    name: "หน่วยธุรการ สำนักงานโครงการย้ายโรงงานผลิตยาสูบ"
                },
                {
                    code: "12010000",
                    name: "สำนักงบประมาณ"
                }
            ],
            tableData: {
                tab_under_part: {
                    agency_part: [
                        {
                            agency_code: "32030000",
                            agency_name: "โรงยานยาสูบ 3"
                        },
                        {
                            agency_code: "32040000",
                            agency_name: "โรงยานยาสูบ 4"
                        },
                        {
                            agency_code: "32050000",
                            agency_name: "โรงยานยาสูบ 5"
                        }
                    ],
                    division: [
                        {
                            agency_code: "32050100",
                            agency_name: "งานธุรการ โรงงานผลิตยาสูบ 4"
                        },
                        {
                            agency_code: "32050200",
                            agency_name: "กองการใบยา รยส.5"
                        },
                        {
                            agency_code: "32050300",
                            agency_name: "กองการมวนและบรรจุ รยส.5"
                        },
                        {
                            agency_code: "32050300",
                            agency_name: "กองซ่อมบำรุง รยส.5"
                        }
                    ]
                },
                tab_under_side: {
                    division: [
                        {
                            agency_code: "32000300",
                            agency_name: "กองการยาเส้นพอง"
                        },
                        {
                            agency_code: "32000100",
                            agency_name: "กองธุรการ สำนักงานฝ่าย ฝ่ายผลิต"
                        },
                        {
                            agency_code: "32000200",
                            agency_name: "กองการวางแผนและควบคุมการผลิต"
                        }
                    ]
                }
            }
        };
    },
    created() {
        this.getMasterData();
    },
    methods: {
        getMasterData() {
            this.loading = true;
            this.getSetAccountTypeDeptData();
            this.loading = false;
        },
        getSetAccountTypeDeptData() {
            this.agency_data = [
                {
                    code: "01",
                    name: "ผ่ายผลิต"
                }
            ];
        },
        selectSetAccountTypeDept() {},
        handleClick(tab, event) {
            console.log(tab, event);
        }
    }
};
</script>
<style lang="scss" scoped></style>
