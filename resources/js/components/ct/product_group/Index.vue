<template>
    <div class="list-product-groups">
        <transition
            enter-active-class="animated fadeIn"
            leave-active-class="animated fadeOut"
        >
            <div
                class="col-lg-12 mt-2 mb-5 "
                v-if="form.show"
                v-loading="form.loading"
            >
                <div class="row">
                    <div
                        class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-4 col-sm-6 col-xs-6 mt-2"
                    >
                        <label class="text-muted tw-font-bold tw-uppercase mb-0"
                            >ศูนย์ต้นทุน :</label
                        >
                        <div class="input-group ">
                            <el-select
                                v-model="form.cost_code"
                                filterable
                                clearable
                                placeholder=""
                                style="width: 100%;"
                            >
                                <el-option
                                    v-for="item in form.cost_code_list"
                                    :key="item.value"
                                    :label="item.label"
                                    :value="item.value"
                                >
                                </el-option>
                            </el-select>
                        </div>
                    </div>
                    <div
                        class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-4 col-sm-6 col-xs-6 mt-2"
                    >
                        <label class="text-muted tw-font-bold tw-uppercase mb-0"
                            >กลุ่มผลิตภัณฑ์ :</label
                        >
                        <div class="input-group ">
                            <el-input
                                type="text"
                                placeholder=""
                                v-model="form.product_group"
                                maxlength="50"
                                show-word-limit
                            />
                        </div>
                    </div>
                    <div
                        class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-4 col-sm-6 col-xs-6 mt-2"
                    >
                        <label class="text-muted tw-font-bold tw-uppercase mb-0"
                            >รายละเอียด :</label
                        >
                        <div class="input-group ">
                            <el-input
                                type="text"
                                placeholder=""
                                v-model="form.description"
                                maxlength="50"
                                show-word-limit
                            />
                        </div>
                    </div>

                    <div
                        class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-4 col-sm-6 col-xs-6 mt-2"
                    >
                        <label class="text-muted tw-font-bold tw-uppercase mb-0"
                            >&nbsp;</label
                        >
                        <div class="input-group ">
                            <button
                                class="btn btn-white btn-lg"
                                type="button"
                                @click="form.show = false"
                            >
                                ยกเลิก
                            </button>
                            <button
                                class="btn btn-success btn-lg ml-2"
                                type="button"
                                @click="save()"
                            >
                                บันทึก
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </transition>

        <transition
            enter-active-class="animated fadeIn"
            leave-active-class="animated fadeOut"
        >
            <div v-if="!form.show" class="col-lg-12 mt-2 text-right">
                <el-button
                    class="btn btn-success m-px__5"
                    type="success"
                    @click="form.show = true"
                >
                    เพิ่มกลุ่มผลิตภัณฑ์ใหม่
                </el-button>
            </div>
        </transition>

        <div class="col-lg-12 mt-2" v-loading="form.fetch_data">
            <el-table border :data="tableData" style="width: 100%">
                <el-table-column
                    prop="cost_code"
                    label="ศูนย์ต้นทุน"
                    align="center"
                    width="110"
                >
                </el-table-column>
                <el-table-column
                    prop="cost_description"
                    label="รายละเอียด"
                ></el-table-column>
                <el-table-column
                    prop="product_group"
                    label="กลุ่มผลิตภัณฑ์"
                    align="center"
                    width="150"
                >
                    <template slot-scope="scope">
                        <div v-if="scope.row.show_edit_form">
                            <!-- <el-input
                        type="text"
                        placeholder=""
                        v-model="scope.row.product_group"
                        maxlength="50"
                        show-word-limit
                    /> -->
                            {{ scope.row.product_group }}
                        </div>
                        <div v-else>
                            {{ scope.row.product_group }}
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                    prop="description"
                    label="รายละเอียด"
                    header-align="center"
                >
                    <template slot-scope="scope">
                        <div v-if="scope.row.show_edit_form">
                            <el-input
                                type="text"
                                placeholder=""
                                v-model="scope.row.description"
                                maxlength="50"
                                show-word-limit
                            />
                        </div>
                        <div v-else>
                            {{ scope.row.description }}
                        </div>
                    </template>
                </el-table-column>
                <el-table-column align="center" width="350">
                    <template slot-scope="scope" v-loading="scope.row.loading">
                        <!-- <a :href="`/ct/product_group/${scope.row.product_group}?cost_code=${scope.row.cost_code}`">
                <el-button
                    class="btn btn-success m-px__5"
                    type="success"
                >
                    ผลิตภัณฑ์
                </el-button>
              </a> -->

                        <button
                            class="btn btn-warning btn-lg tw-w-24"
                            v-if="!scope.row.show_edit_form"
                            @click="scope.row.show_edit_form = true"
                            type="button"
                        >
                            แก้ไข
                        </button>
                        <button
                            class="btn btn-success btn-lg tw-w-24"
                            v-if="scope.row.show_edit_form"
                            @click="update(scope.row)"
                            type="button"
                        >
                            บันทึก
                        </button>
                        <button
                            class="btn btn-danger btn-lg ml-2 tw-w-24"
                            type="button"
                            @click="del(scope.row)"
                        >
                            ลบ
                        </button>
                        <a
                            :href="
                                `/ct/product_group/${scope.row.product_group}?cost_code=${scope.row.cost_code}`
                            "
                            class="btn btn-primary btn-lg tw-w-24"
                        >
                            ผลิตภัณฑ์
                        </a>
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
            tableData: [],
            form: {
                show: false,
                loading: false,
                fetch_data: false,
                cost_code_list: [],
                cost_code: "",
                product_group: "",
                description: ""
            }
        };
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            this.form.fetch_data = true;
            axios.get(`/ct/ajax/product_group/get-data-from-view`).then(res => {
                this.tableData = res.data.product_groups;
                this.form.cost_code_list = res.data.cost_code_list;

                this.form.fetch_data = false;
            });
        },
        async save() {
            let vm = this;
            let input = JSON.parse(JSON.stringify(vm.form));
            input.cost_code_list = [];

            vm.form.loading = true;
            axios
                .post(`/ct/ajax/product_group/cost-code`, { input: input })
                .then(res => {
                    let data = res.data;
                    if (data.status == "S") {
                        swal({
                            title: "&nbsp;",
                            text: "บันทึกข้อมูลสำเร็จ",
                            type: "success",
                            html: true
                        });

                        vm.form.cost_code = "";
                        vm.form.product_group = "";
                        vm.form.description = "";
                        vm.fetchData();
                    }

                    if (data.status != "S") {
                        swal({
                            title: "Error !",
                            text: data.message,
                            type: "error",
                            showConfirmButton: true
                        });
                    }
                    vm.form.loading = false;
                });
        },
        async update(line) {
            let vm = this;
            let input = {
                cost_code: line.cost_code,
                product_group: line.product_group,
                description: line.description
            };
            line.loading = true;
            axios
                .post(`/ct/ajax/product_group/update-cost-code`, {
                    input: input
                })
                .then(res => {
                    let data = res.data;
                    if (data.status == "S") {
                        swal({
                            title: "&nbsp;",
                            text: "บันทึกข้อมูลสำเร็จ",
                            type: "success",
                            html: true
                        });
                        line.loading = false;
                        line.show_edit_form = false;
                    }

                    if (data.status != "S") {
                        swal({
                            title: "Error !",
                            text: data.message,
                            type: "error",
                            showConfirmButton: true
                        });
                    }
                    line.loading = false;
                });
        },
        async del(line) {
            let vm = this;
            let confirm = false;
            let input = {
                cost_code: line.cost_code,
                product_group: line.product_group,
                description: line.description
            };

            confirm = await helperAlert.showProgressConfirm(
                "กรุณายืนยันลบข้อมูล"
            );
            if (confirm) {
                line.loading = true;
                axios
                    .post(`/ct/ajax/product_group/del-cost-code`, {
                        input: input
                    })
                    .then(res => {
                        let data = res.data;
                        if (data.status == "S") {
                            swal({
                                title: "&nbsp;",
                                text: "บันทึกข้อมูลสำเร็จ",
                                type: "success",
                                html: true
                            });
                            line.loading = false;
                            vm.fetchData();
                        }

                        if (data.status != "S") {
                            swal({
                                title: "Error !",
                                text: data.message,
                                type: "error",
                                showConfirmButton: true
                            });
                        }
                        line.loading = false;
                    });
            }
        }
    }
};
</script>
<style lang="scss" scoped>
.el-table .warning-row {
    background-color: oldlace !important;
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
