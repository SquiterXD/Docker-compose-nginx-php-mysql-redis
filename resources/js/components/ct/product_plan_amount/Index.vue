<template>
    <div class="list-product-groups">
        <div class="form-group row">
            <div class="col-lg-12">
                <el-select
                    filterable
                    v-model="form.period_year"
                    placeholder="ปีบัญชีงบประมาณ"
                     @change="selectPeriodYear"
                >
                    <el-option
                        v-for="(item, index) in periodYears"
                        :key="index"
                        :label="item.period_year_thai"
                        :value="item.period_year"
                    >
                    </el-option>
                </el-select>

                <el-select
                    filterable
                    v-model="form.plan_version_no"
                    placeholder="แผนผลิตภัณฑ์"
                >
                    <el-option
                        v-for="(item, index) in planVesion"
                        :key="index"
                        :label="item.plan_version_no"
                        :value="item.plan_version_no"
                    >
                    </el-option>
                </el-select>
                <el-button
                    class="btn-info ml-2"
                    type="primary"
                    @click="search()"
                >
                    ค้นหา
                </el-button>
                <el-button
                    class="btn-success ml-2"
                    type="success"
                    @click="create()"
                >
                    สร้าง
                </el-button>
            </div>
        </div>

        <div class="my-2">
            <div>
                <span class="font-bold">ปีบัญชีงบประมาณ :</span>
                {{ items.productGroupPlan.period_year_thai }}
            </div>
            <div>
                <span class="font-bold">แผนผลิตภัณฑ์ :</span>
                {{ items.productGroupPlan.plan_version_no }}
            </div>
        </div>

        <el-card class="box-card my-2" v-loading="loading">
            <div slot="header" class="clearfix">
                <el-select
                    filterable
                    v-model="selectCostCenter"
                    placeholder="ศูนย์ต้นทุน"
                    @change="findByCostCenter"
                >
                    <el-option
                        v-for="(item, index) in costCenters"
                        :key="index"
                        :label="item.name"
                        :value="item.cost_code"
                    >
                    </el-option>
                </el-select>

                <el-button
                    class="btn-info ml-2 pull-right"
                    type="primary"
                    @click="submitUpdate()"
                >
                    บันทึกการแก้ไข
                </el-button>
            </div>

            <div class="text item">
                <div class="table-responsive px-4 pt-4">
                    <table class="table table-bordered tw-text-xs">
                        <thead>
                            <tr>
                                <th>กลุ่มผลิตภัณฑ์</th>
                                <th class="text-center" style="width: 15%;">
                                    อัตราส่วน
                                </th>
                                <th class="text-center" style="width: 15%;">
                                    ปริมาณ
                                </th>
                                <th class="text-center" style="width: 15%;">
                                    หน่วยนับ
                                </th>
                                <th class="text-center" style="width: 10%;">
                                    พื้นที่ทำงาน ตร.ซม.
                                </th>
                                <th class="text-center" style="width: 10%;">
                                    จำนวนรอบ
                                </th>
                                <th class="text-center" style="width: 10%;">
                                    ความกว้าง ซม.
                                </th>
                                <th class="text-center" style="width: 10%;">
                                    ความยาว ซม.
                                </th>
                                <th class="text-center" style="width: 15%;">
                                    รวมปริมาณผลผลิต
                                </th>
                                <th class="text-center">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template
                                v-for="(children, index) in items
                                    .productGroupItems.children"
                            >
                                <tr clsss="tw-text-xs" :key="`${index}-1`">
                                    <td>{{ children.name }}</td>
                                    <td class="text-right">
                                        <input
                                            type="text"
                                            class="form-control text-right"
                                            v-model="
                                                items.productGroupItems
                                                    .children[index].ratio
                                            "
                                        />
                                    </td>
                                    <td>
                                      <input
                                            type="text"
                                            class="form-control text-right"
                                            v-model="
                                                items.productGroupItems
                                                    .children[index].quantity_prd
                                            "
                                        />
                                    </td>
                                    <td>
                                      <el-select
                                          filterable
                                          v-model="items.productGroupItems.children[index].uom_code_prd"
                                          placeholder="หน่วยนับ"
                                      >
                                          <el-option
                                              v-for="(item, index) in uom"
                                              :key="index"
                                              :label="item.unit_of_measure"
                                              :value="item.uom_code"
                                          >
                                          </el-option>
                                      </el-select>
                                       <!-- <input
                                            type="text"
                                            class="form-control text-right"
                                            v-model="
                                                items.productGroupItems
                                                    .children[index].uom_code
                                            "
                                        /> -->
                                    </td>
                                    <td class="text-right">
                                        <input
                                            type="text"
                                            class="form-control text-right"
                                            v-model="
                                                items.productGroupItems
                                                    .children[index].area
                                            "
                                        />
                                    </td>
                                    <td class="text-right">
                                        <input
                                            type="text"
                                            class="form-control text-right"
                                            v-model="
                                                items.productGroupItems
                                                    .children[index].around
                                            "
                                        />
                                    </td>
                                    <td class="text-right">
                                        <input
                                            type="text"
                                            class="form-control text-right"
                                            v-model="
                                                items.productGroupItems
                                                    .children[index].width
                                            "
                                        />
                                    </td>
                                    <td class="text-right">
                                        <input
                                            type="text"
                                            class="form-control text-right"
                                            v-model="
                                                items.productGroupItems
                                                    .children[index].length
                                            "
                                        />
                                    </td>
                                    <td class="text-right">
                                        <div class="form-control">
                                            {{
                                                items.productGroupItems
                                                    .children[index]
                                                    .prd_productivity_qty
                                            }}
                                            <!-- {{ prdProductivityQty(children) }} -->
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <el-button
                                            class="btn-info ml-2"
                                            size="small"
                                            type="primary"
                                            @click="
                                                viewProduct(children.pg_code)
                                            "
                                        >
                                            ดูผลิตภัณฑ์
                                        </el-button>
                                    </td>
                                </tr>

                                <tr
                                    clsss="tw-text-xs"
                                    :key="`${index}-2`"
                                    :class="
                                        keyViewProduct == children.pg_code
                                            ? ''
                                            : 'd-none'
                                    "
                                >
                                    <td colspan="7">
                                        <table
                                            class="table table-bordered tw-text-xs"
                                        >
                                            <thead>
                                                <tr>
                                                    <th class="text-center">
                                                        ผลิตภัณฑ์
                                                    </th>
                                                    <th
                                                        class="text-center"
                                                        width="200px;"
                                                    >
                                                        ปริมาณผลผลิตตามแผน
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <template
                                                    v-for="(subChildren,
                                                    subChildrenIndex) in children.children"
                                                >
                                                    <tr
                                                        :key="subChildrenIndex"
                                                        clsss="tw-text-xs"
                                                    >
                                                        <td>
                                                            {{
                                                                subChildren.name
                                                            }}
                                                        </td>
                                                        <td class="text-right">
                                                            <input
                                                                type="text"
                                                                class="form-control text-right"
                                                                :value="
                                                                    subChildren.qty
                                                                        | number2Digit
                                                                "
                                                                @change="
                                                                    event => {
                                                                        subChildren.qty = stripNonNumber(
                                                                            event
                                                                                .target
                                                                                .value
                                                                        );
                                                                        if (
                                                                            subChildren.qty <
                                                                            0
                                                                        ) {
                                                                            subChildren.qty = 0;
                                                                        }
                                                                        editForm(
                                                                            children.pg_code,
                                                                            subChildrenIndex,
                                                                            subChildren
                                                                        );
                                                                    }
                                                                "
                                                            />
                                                        </td>
                                                    </tr>
                                                </template>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </template>

                            <tr
                                v-if="
                                    items.productGroupItems.children.length == 0
                                "
                            >
                                <td colspan="10" class="text-center">
                                    ไม่พบข้อมูล
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </el-card>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                period_year: "",
                plan_version_no: ""
                // period_year: 2022,
                // plan_version_no: 1
            },
            loading: false,
            periodYears: [],
            costCenters: [],
            planVesion: [],
            uom: [],
            selectCostCenter: "",
            items: {
                productGroupItems: {
                    name: "",
                    children: []
                },
                productGroupPlan: {}
            },
            storage: {
                productGroupPlan: {
                    productGroupItems: []
                }
            },
            keyViewProduct: "",
            changeForm: {},
            edit: {
                productGroups: []
            }
        };
    },
    mounted() {
        this.getMasterData();
        // this.search();
    },
    methods: {
      async selectPeriodYear(clear=true) {
        axios.get(`/ct/ajax/product-group-plan/plan-version?period_year=${this.form.period_year}`)
        .then(res => {
          this.planVesion = res.data.data
          if (clear) {
            this.form.plan_version_no = ""
          }
        })
      },
        viewProduct(key) {
            if (this.keyViewProduct != key) {
                this.keyViewProduct = key;
            } else {
                this.keyViewProduct = "";
            }
        },
        findByCostCenter() {
            this.items.productGroupItems = this.storage.productGroupItems[
                this.selectCostCenter
            ];
        },
        getMasterData() {
            axios.get("/ct/ajax/year-view").then(res => {
                this.periodYears = res.data;
            });
            this.getUom();
        },
        getUom() {
          axios.get("/ct/ajax/product-group-plan/uom").then(res => {
            this.uom = res.data.data
          })
        },
        async create() {
          if (!this.form.plan_version_no) {
            this.form.plan_version_no = await this.planVesion.length + 1
          }
            await axios
                .post(`/ct/ajax/product-group-plan`, {
                    period_year: this.form.period_year,
                    plan_version_no: this.form.plan_version_no
                })
                .then(res => {
                    this.setData(res.data);
                    this.$message({
                        showClose: true,
                        message: "บันทึกสำเร็จ",
                        type: "success"
                    });
                })
                .catch(err => {
                  this.selectPeriodYear(false);
                  this.search();
                    // this.loading = false;
                    // this.resetData();

                    // this.$message({
                    //     showClose: true,
                    //     message: err.response.data.error
                    //         ? err.response.data.error
                    //         : `ไม่สามารถบันทึกได้`,
                    //     type: "error"
                    // });
                });
        },
        prdProductivityQty(item) {
            let rs = this.storage.prdGrpPlanGroupV.find(
                element =>
                    element.cost_code == this.selectCostCenter &&
                    element.product_group == item.pg_code
            );
            return rs.prd_productivity_qty;
        },
        async search(defSelCostCenter = false) {
            let vm = this;
            vm.loading = true;
            console.log('search ---------->', defSelCostCenter);
            await axios
                .get(`/ct/ajax/product-group-plan`, {
                    params: {
                        period_year: vm.form.period_year,
                        plan_version_no: vm.form.plan_version_no
                    }
                })
                .then(res => {
                    vm.setData(res.data, defSelCostCenter);
                    console.log(res.data)
                    vm.loading = false;
                })
                .catch(err => {
                    console.log(err.response.data);

                    vm.loading = false;
                    vm.resetData();

                    this.$message({
                        showClose: true,
                        message: `ไม่พบข้อมูล`,
                        type: "error"
                    });
                });
        },
        async setData(data, defCostCode = false) {
            // let productGroupItems = data.productGroupItems;
            // let productGroupItem = productGroupItems[Object.keys(productGroupItems)[0]];
            // this.costCenters = data.costCenters;
            // this.selectCostCenter = productGroupItem.cost_code;

            // this.items.productGroupPlan = data.productGroupPlan;
            // this.items.productGroupItems = productGroupItem;

            // this.storage = data;

            // defCostCode = 51;
            let productGroupItems = data.productGroupItems;
            
            this.storage = data;
            let productGroupItem = productGroupItems[Object.keys(productGroupItems)[0]];
            let costCode = productGroupItem.cost_code;
            if (defCostCode) {
                productGroupItem = productGroupItems[defCostCode.toString()];
                costCode = defCostCode;
            } else {
            }

            this.storage = data;
            this.costCenters = data.costCenters;
            // this.selectCostCenter = productGroupItem.cost_code;
            this.selectCostCenter = costCode;

            this.items.productGroupPlan = data.productGroupPlan;
            this.items.productGroupItems = productGroupItem;
            // this.storage = data;

            // ----------------------------------------------------------
            // let productGroupItems = data.productGroupItems;

            // if (defCostCode) {
            //     let index = await this.productGroupItems.findIndex(o => o.cost_code == defCostCode);
            //     // let productGroupItem = productGroupItems[Object.keys(productGroupItems)[index]];
            //     let productGroupItem = productGroupItems[Object.keys(productGroupItems)[index]];
            //     console.log('1 setData ->', productGroupItem)
            // } else {
            //     let productGroupItem = productGroupItems[Object.keys(productGroupItems)[0]];
            //     console.log('2 setData ->', productGroupItem)
            // }
            //     console.log('3 setData ->', productGroupItem)

            // this.costCenters = data.costCenters;
            // this.selectCostCenter = productGroupItem.cost_code;

            // this.items.productGroupPlan = data.productGroupPlan;
            // this.items.productGroupItems = productGroupItem;

            // this.storage = data;
            // --------------------------------------------------------

            // console.log('setData  11111 ---------->', defCostCode);

            // let productGroupItems = data.productGroupItems;

            // this.costCenters = data.costCenters;
            // if (defCostCode) {
            //     let index = this.productGroupItems.findIndex(o => o.cost_code == defCostCode);
            //     let productGroupItem = productGroupItems[Object.keys(productGroupItems)[index]];
            //     console.log('-> 1', productGroupItem)
            //     this.selectCostCenter = defCostCode;
            // } else {
            //     let productGroupItem = productGroupItems[Object.keys(productGroupItems)[0]];
            //     console.log('-> 2', productGroupItem)
            //     this.selectCostCenter = productGroupItem.cost_code;
            // }
            // console.log('-> 3', productGroupItem)


            // // let productGroupItem =
            // //         productGroupItems[Object.keys(productGroupItems)[0]];
            // //         console.log('--------------------------------------', productGroupItem);
            // //     this.selectCostCenter = productGroupItem.cost_code;

            // this.items.productGroupPlan = data.productGroupPlan;
            // this.items.productGroupItems = productGroupItem;

            // this.storage = data;
        },
        resetData() {
            this.items.productGroupPlan = {};
            this.items.productGroupItems = {
                name: "",
                children: []
            };
            this.selectCostCenter = "";
        },
        async editForm(productGroup, itemNo, subChildren) {
            let vm = this;
            let confirm = true;
            let data = JSON.parse(JSON.stringify(subChildren));
            data.product_item_number = itemNo;
            data.product_group = productGroup;

            vm.$set(
                vm.changeForm,
                "productGroup-" + productGroup + "-item-" + itemNo,
                data
            );
        },
        stripNonNumber(text) {
            return parseFloat(text.replace(/,/g, ""));
        },
        numberFormat(n) {
            return `${n}`
                .replace(/\D/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        },
        async submitUpdate() {
            let defSelCostCenter = JSON.parse(JSON.stringify(this.selectCostCenter));
            await this.updateProductGroup();
            await this.updateProduct();
            await this.search(defSelCostCenter);
        },
        updateProductGroup() {
            axios
                .post(`/ct/ajax/product_group/update`, {
                    product_groups: this.items.productGroupItems
                })
                .then(res => {
                    if (res.data.status == "C") {
                        this.$message({
                            showClose: true,
                            message: "บันทึกสำเร็จ",
                            type: "success"
                        });
                    } else {
                        this.$message({
                            showClose: true,
                            message: res.data.msg,
                            type: "error"
                        });
                    }
                })
                .catch(err => {
                    console.log(err.response.data);
                });
        },
        updateProduct() {
            let vm = this;
            let form = JSON.parse(JSON.stringify(vm.form));
            let selectCostCenter = JSON.parse(
                JSON.stringify(vm.selectCostCenter)
            );

            axios
                .post(`/ct/ajax/product-group-plan/update-item`, {
                    period_year: vm.form.period_year,
                    plan_version_no: vm.form.plan_version_no,
                    cost_code: vm.selectCostCenter,
                    data: vm.changeForm
                })
                .then(res => {
                    if (res.data.status == "C") {
                        this.$message({
                            showClose: true,
                            message: "บันทึกสำเร็จ",
                            type: "success"
                        });
                    } else {
                        this.$message({
                            showClose: true,
                            message: res.data.msg,
                            type: "error"
                        });
                    }
                })
                .catch(err => {
                    console.log(err.response.data);
                });
            vm.changeForm = {};
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
