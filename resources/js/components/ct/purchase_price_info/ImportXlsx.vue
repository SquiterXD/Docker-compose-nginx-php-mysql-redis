<template>
    <div v-loading="loading">
        <input
            type="file"
            id="myfile"
            name="myfile"
            ref="file"
            hidden
            @change="handleFileUpload()"
        />
        <div class="row">
            <div class="col-md-12 text-right mt-2">
                <a href="/ct/purchase_price_info" :disabled="loading_progress">
                    <el-button class="btn-danger mr-2" type="danger">
                        ย้อนกลับ
                    </el-button>
                </a>
                <el-button
                    class="btn-info mr-2"
                    type="primary"
                    :disabled="loading_progress"
                    @click="uploadFile()"
                >
                    IMPORT FILE
                </el-button>
                <el-button
                    @click="updateImport()"
                    :class="`${tableError ? 'btn-disable' : 'btn-success'}`"
                    v-if="status.tableData"
                    :disabled="tableError || loading_progress"
                    type="success"
                >
                    บันทึก
                </el-button>
            </div>
        </div>
        <div class="loading-progress" v-if="interval">
            <el-progress
                :text-inside="true"
                :stroke-width="26"
                :percentage="progress"
            ></el-progress>
        </div>
        <div
            class="form-group row mt-5"
            v-if="status.tableData && !loading_progress"
        >
            <div class="col-md-12 mt-2 flex-wrap">
                <el-table border :data="tableData" style="width: 100%">
                    <el-table-column
                        prop="item_number"
                        label="รหัสวัตถุดิบ"
                        align="center"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="lot_number"
                        label="LOT"
                        align="center"
                    >
                        <template slot-scope="scope">
                            {{ scope.row.lot_number }}
                        </template>
                    </el-table-column>
                    <el-table-column
                        prop="item_descrtiption"
                        label="ชื่อวัตถุดิบ"
                        align="center"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="unit_cost"
                        label="ราคาซื้อ"
                        align="center"
                    >
                        <template slot-scope="scope">
                            {{
                                scope.row.unit_cost
                                    ? numberWithCommas(
                                          toFixedDecimal(scope.row.unit_cost, 9)
                                      )
                                    : 0
                            }}
                        </template>
                    </el-table-column>
                    <el-table-column
                        prop="freight_cost"
                        label="ค่าขนส่ง"
                        align="center"
                    >
                        <template slot-scope="scope">
                            {{
                                scope.row.freight_cost !== ""
                                    ? numberWithCommas(
                                          toFixedDecimal(
                                              scope.row.freight_cost,
                                              9
                                          )
                                      )
                                    : 0
                            }}
                        </template>
                    </el-table-column>
                    <el-table-column
                        prop="subtotal"
                        label="จำนวนเงิน"
                        align="center"
                    >
                        <template slot-scope="scope">
                            {{
                                numberWithCommas(
                                    toFixedDecimal(scope.row.subtotal, 9)
                                )
                            }}
                        </template>
                    </el-table-column>
                    <!-- <el-table-column
                        prop="material_percent"
                        label="%"
                        align="center"
                    >
                        <template slot-scope="scope">
                            {{
                                scope.row.material_percent !== ""
                                    ? scope.row.material_percent
                                    : 0
                            }}
                        </template>
                    </el-table-column> -->
                    <el-table-column
                        prop="dm_std_unitcost"
                        label="จำนวนเงินรวม"
                        align="center"
                    >
                        <template slot-scope="scope">
                            {{
                                numberWithCommas(
                                    toFixedDecimal(scope.row.dm_std_unitcost, 9)
                                )
                            }}
                        </template>
                    </el-table-column>
                    <el-table-column
                        width="200px"
                        prop="validate"
                        label="สถานะ"
                        align="center"
                    >
                        <template slot-scope="scope">
                            <div
                                class="text-red"
                                v-for="(item_valid, index_valid) in scope.row
                                    .validate"
                                :key="index_valid"
                            >
                                {{ item_valid }}
                            </div>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
        </div>
    </div>
</template>
<script>
import XLSX from "xlsx";
import moment from "moment";
export default {
    data() {
        return {
            interval: null,
            loading_progress: false,
            progress: 0,
            loading: false,
            file: {},
            status: {
                tableData: false
            },
            form: {},
            tableData: []
        };
    },
    computed: {
        tableError() {
            let rs = true;
            if (this.tableData.length > 0 && this.status.tableData) {
                const table_error = _.filter(this.tableData, item => {
                    return item?.validate.length > 0;
                });
                if (table_error.length == 0) {
                    rs = false;
                }
            }
            return rs;
        }
    },
    methods: {
        uploadFile() {
            this.$refs.file.click();
        },
        getQuery() {
            const urlSearchParams = new URLSearchParams(window.location.search);
            const params = Object.fromEntries(urlSearchParams.entries());
            return params;
        },
        async search() {
            const {
                version,
                period_year,
                period_name,
                organization_code
            } = this.getQuery();
            await axios
                .get(
                    `/ct/ajax/purchase_price_info?version=${version}&period_year=${period_year}&period_name=${period_name}&organization_code=${organization_code}`
                )
                .then(res => {
                    if (res.data) {
                        let header = res.data;

                        res.data.material_cost_lines.forEach(element => {
                            element.validate = [];
                        });
                        this.tableData = res.data.material_cost_lines;
                        this.form.used_date = [
                            header.date_from,
                            header.date_to
                        ];
                        this.form.version = header.version;
                        this.form.std_head_id = header.std_head_id;
                        this.form.status =
                            header.status == "Y"
                                ? "ยืนยันแล้ว"
                                : header.status == "N"
                                ? "ยังไม่ยืนยัน"
                                : "ไม่มีข้อมูล";
                        this.status.tableData = true;
                    } else {
                        this.$message({
                            showClose: true,
                            message: "ไม่พบข้อมูล",
                            type: "error"
                        });
                    }
                })
                .catch(err => {
                    this.errorMessage(err.response);
                    this.$message({
                        showClose: true,
                        message: `ไม่สามารถประมวลผลได้`,
                        type: "error"
                    });
                })
                .then(() => {
                    this.form.search = false;
                });
        },
        updateImport() {
            let lines = this.tableData;
            this.loadingProgress();
            axios
                .post("/ct/ajax/purchase_price_info/update_import", {
                    lines: lines
                })
                .then(res => {
                    this.$message({
                        showClose: true,
                        message: "บันทึกสำเร็จ",
                        type: "success"
                    });
                })
                .then(() => {
                    this.loading_progress = false;
                });
        },
        checkItemNumber(itemNumber) {
            const form = {
                itemNumber: itemNumber
            };
            const desc = axios
                .post(`/ct/ajax/purchase_price_info/check_item_number`, form)
                .then(res => {
                    return {
                        status: true,
                        msg: res.data.data.description
                    };
                })
                .catch(err => {
                    return {
                        status: false,
                        msg: "item_number not found"
                    };
                });
            return desc;
        },
        getMasterData() {
            this.search();
        },
        isInt(n) {
            return Number(n) === n && n % 1 === 0;
        },

        isFloat(n) {
            return Number(n) === n && n % 1 !== 0;
        },
        loadingProgress() {
            this.loading_progress = true;
            this.progress = 0;

            this.interval = setInterval(() => {
                if (!this.loading_progress) {
                    this.progress = 100;
                    setTimeout(() => {
                        clearInterval(this.interval);
                        this.interval = null;
                    }, 1000);
                } else if (this.progress <= 60) {
                    this.progress += 5;
                } else if (this.progress >= 60 && this.progress < 99) {
                    this.progress += 1;
                }
            }, 500);
        },
        checkNumberKey(data) {
            let result = [];
            for (const [key, value] of Object.entries(data)) {
                if (!this.isInt(value) && !this.isFloat(value) && value != 0) {
                    result.push(`${key} is not number`);
                }
            }
            return result;
        },
        async importToTable(data) {
            await data.forEach(async element => {
                this.loading = await true;
                let data_import = await {
                    std_line_id: null,
                    std_head_id: this.form.std_head_id,
                    item_number: element["รหัสวัตถุดิบ"],
                    lot_number: element["LOT"],
                    item_descrtiption: element["ชื่อวัตถุดิบ"],
                    unit_cost: parseFloat(element["ราคาซื้อ"])
                        ? parseFloat(element["ราคาซื้อ"])
                        : element["ราคาซื้อ"],
                    freight_cost: parseFloat(element["ค่าขนส่ง"])
                        ? parseFloat(element["ค่าขนส่ง"])
                        : element["ค่าขนส่ง"],
                    subtotal: parseFloat(element["จำนวนเงิน"])
                        ? parseFloat(element["จำนวนเงิน"])
                        : element["จำนวนเงิน"],
                    material_percent: parseFloat(element["เปอร์เซ็น"])
                        ? parseFloat(element["เปอร์เซ็น"])
                        : element["เปอร์เซ็น"],
                    dm_std_unitcost: parseFloat(element["จำนวนเงินรวม"])
                        ? parseFloat(element["จำนวนเงินรวม"])
                        : element["จำนวนเงินรวม"],
                    date_from: `${moment(element["วันที่เริ่มใช้"]).format(
                        "YYYY-MM-DD"
                    )} 00:00:00`,
                    date_to: `${moment(element["วันที่สิ้นสุด"]).format(
                        "YYYY-MM-DD"
                    )} 00:00:00`,
                    validate: []
                };
                const desc = await this.checkItemNumber(
                    data_import.item_number
                );
                if (desc.status) {
                    data_import.item_descrtiption = desc.msg;
                } else if (!desc.status) {
                    data_import["validate"].push(desc.msg);
                }
                const {
                    item_number,
                    lot_number,
                    item_descrtiption,
                    std_line_id,
                    std_head_id,
                    validate,
                    date_from,
                    date_to,
                    ...number_key
                } = data_import;

                data_import["validate"].push(
                    ...this.checkNumberKey(number_key)
                );

                data_import.lot_number =
                    data_import.lot_number == 0 || !data_import.lot_number
                        ? null
                        : data_import.lot_number;

                let old_data = this.tableData.filter(element => {
                    element.lot_number =
                        element.lot_number == 0 || !element.lot_number
                            ? null
                            : element.lot_number;
                    return (
                        element.item_number == data_import.item_number &&
                        element.lot_number == data_import.lot_number
                    );
                });
                let line_id;
                if (old_data.length >= 1) {
                    line_id = old_data[0].std_line_id;
                }

                let d = this.tableData.filter(element => {
                    element.lot_number =
                        element.lot_number == 0 || !element.lot_number
                            ? null
                            : element.lot_number;
                    return !(
                        element.item_number == data_import.item_number &&
                        element.lot_number == data_import.lot_number
                    );
                });
                this.tableData = d;

                data_import["std_line_id"] = line_id;

                await this.tableData.push(data_import);
                await this.tableData.sort((a, b) => {
                    return a.item_number - b.item_number;
                });
                this.loading = await false;
            });
        },
        async handleFileUpload() {
            this.file = this.$refs.file.files[0];
            const file_extension = this.file.name?.split(".").pop();
            if (file_extension == "csv" || file_extension == "xlsx") {
                var reader = new FileReader();
                reader.onload = () => {
                    var fileData = reader.result;
                    var wb = XLSX.read(fileData, { type: "binary" });

                    wb.SheetNames.forEach(async sheetName => {
                        var rowObj = XLSX.utils.sheet_to_row_object_array(
                            wb.Sheets[sheetName]
                        );
                        var jsonObj = JSON.stringify(rowObj);
                        await this.search();
                        await this.importToTable(JSON.parse(jsonObj));
                    });
                };
                reader.readAsBinaryString(this.file);
            } else {
                this.file = "";
                this.$refs.file.value = "";
                this.$message({
                    showClose: true,
                    message: `ไม่สามารถอัพโหลดได้ กรุณาอัพโหลดไฟล์ xlsx หรือ csv`,
                    type: "error"
                });
            }
        },
        numberWithCommas(x) {
            return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
        },
        toFixedDecimal(num, decimal) {
            num = parseFloat(num);
            let result;
            if (this.isFloat(num)) {
                result = Number.parseFloat(num).toFixed(decimal);
            } else {
                result = num;
            }
            return result;
        }
    }
};
</script>
<style lang="scss" scoped>
.loading-progress {
    height: 100%;
    width: 100%;
    margin-top: 40px;
}
.text-red {
    color: red;
}
.period-date {
    width: 100%;
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
.td-select {
    cursor: pointer;
    border: 2px solid #eee;
    border-radius: 5px;
    padding: 10px 0;
}
.background-dialog__custom {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 100;
    background: #f3f3f4;
    opacity: 0.7;
}
.flex_end {
    display: flex;
    justify-content: flex-end;
}
.btn-disable {
    color: #fff;
    background-color: #b3e19d;
    border-color: #b3e19d;
}
.is-disabled {
    color: #fff;
    background-color: #b3e19d;
    border-color: #b3e19d;
}
</style>
