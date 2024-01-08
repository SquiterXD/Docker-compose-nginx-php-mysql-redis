<template>
    <div v-loading="loading.page">
        <!-- <pre>{{ lines }}</pre> -->
        <div class="row">
            <div class="col-12 text-right">
                <button  :class="transBtn.create.class + ' btn-sm tw-w-25  btn-outline'"
                    :disabled="!header.can.edit"
                    @click.prevent="addNewLine">
                    <i :class="transBtn.create.icon"></i>
                    เพิ่มรายการ
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table  class="table" style="margin-bottom: 0px;">
                <thead>
                    <tr class="pdp0008-table-th-detail-color">
                        <th width="20px"></th>
                        <!-- <th class="text-center" style="min-width: 15px !important; max-width: 15px !important;"> -->
                        <th class="text-center" width="240px">
                            <div>Leaf Formula</div>
                        </th>
                        <th width="" class="hidden-sm hidden-xs">
                            <div>รายละเอียด</div>
                        </th>
                        <th width="80px" class="text-right">
                            &nbsp;
                        </th>
                        <th width="100px" class="text-right">
                            &nbsp;
                        </th>
                        <th width="80px" class="text-right">
                            <div>สัดส่วน %</div>
                        </th>
                        <th width="60px" class="text-right"></th>
                    </tr>
                </thead>
                <tbody id="accordion">
                    <template v-for="(line, i) in lines" v-if="lines.length">
                    <transition
                        enter-active-class="animated fadeInUp"
                        leave-active-class="animated fadeOutDown">
                    <tr style="background-color: rgb(252, 252, 252);" v-if="!line.is_deleted">
                        <td class="text-right align-middle">
                            <template v-if="line.leaf_formula">
                                <a data-toggle="collapse" @click="line.is_collapse = !line.is_collapse"
                                    data-parent="#accordion" :href="'#collapse_' + i">
                                    <i class="fa fa-caret-down" style="font-size: 20px;" v-if="line.is_collapse"></i>
                                    <i class="fa fa-caret-right" style="font-size: 20px;" v-else></i>
                                </a>
                            </template>
                        </td>
                        <td  style="min-width: 15px !important; max-width: 15px !important;">
                                <!-- @change="itemWasSelected" -->
                            <!-- <el-select style="width:100%;"
                                class="text-center"
                                v-model="line.leaf_formula"
                                filterable
                                remote
                                placeholder="Leaf Formula"
                                :remote-method="data => remoteMethod(data, line)"
                                @change="selectLeaf(line)"
                                :disabled="!header.can.edit"
                                :loading="loading.leaf_formula"
                            >
                                <el-option
                                    v-for="(leaf, index) in line.leaf_list"
                                    :key="leaf.value"
                                    :label="leaf.value"
                                    :value="String(leaf.value)">
                                    <span style="float: left">{{ leaf.label }}</span>
                                </el-option>
                            </el-select> -->

                            <input type="text" class="form-control" v-if="!line.is_edit_item" :disabled="!header.can.edit"
                                :value="line.leaf_formula"
                                @click="clickSelcet(line, i)" >
                                <!-- :remote-method="data => remoteMethod(data, line)" -->
                            <el-select style="width:100%;" v-else v-loading="line.loading"
                                class="text-center"
                                v-model="line.leaf_formula"
                                filterable
                                :ref="'leaf_'+ i"
                                remote
                                placeholder="Leaf Formula"
                                @change="selectLeaf(line)"
                                :disabled="!header.can.edit"
                                :loading="loading.leaf_formula"
                            >
                                <el-option
                                    v-for="(leaf, index) in line.leaf_list"
                                    :key="leaf.value"
                                    :label="leaf.value"
                                    :value="String(leaf.value)">
                                    <span style="float: left">{{ leaf.label }}</span>
                                </el-option>
                            </el-select>
                        </td>
                        <td colspan="3">
                            {{ line.leaf_formula_desc }}
                        </td>
                        <td class="font-weight-bold text-success tw-text-base text-right">
                            <!-- <input class="form-control text-right" type="number"
                                @change="changeLeafProportion"
                                v-model.number="line.leaf_proportion"
                            /> -->
                                <!-- @input="v => { line.leaf_proportion = v.toFixed(2) }" -->
                            <!-- <input class="form-control text-right" type="number"
                                :value="parseFloat(line.leaf_proportion).toFixed(2)"
                                @change="(event) => {
                                    if (parseFloat(event.target.value) < 0) {
                                        line.leaf_proportion = parseFloat(0)
                                    } else {
                                        line.leaf_proportion = parseFloat(event.target.value).toFixed(2);
                                    }
                                    changeLeafProportion()
                                }"
                            /> -->
                            <!-- {{ line.leaf_proportion ? (line.leaf_proportion ? Number(line.leaf_proportion).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : "0") : "0" }} -->
                            {{ Number(parseFloat(line.leaf_proportion ? line.leaf_proportion : 0) ).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }}
                        </td>
                        <td class="text-center align-middle">
                            <button  :class="transBtn.delete.class + ' btn-xs mb-0 btn-outline'"
                                :disabled="!header.can.edit"
                                @click.prevent="deleteline(line)"
                                >
                                <!-- @click.prevent="line.is_deleted = true" -->
                                <i :class="transBtn.delete.icon"></i>
                            </button>
                        </td>
                    </tr>
                    </transition>
                   <!--  <transition
                        enter-active-class="animated fadeInUp"
                        leave-active-class="animated fadeOutDown"> -->
                        <tr v-show="line.is_collapse" v-if="!line.is_deleted">
                            <td  colspan="7">
                                <div class="collapse" :id="'collapse_'+ i">
                                    <leaf-ingredient
                                        :leaf="line"
                                        :url="url"
                                        :leafProportion="line.leaf_proportion"
                                        :transBtn="transBtn"
                                        :transDate="transDate"
                                        :data="data"
                                        :header="header"
                                        @syncIngredients="syncIngredients(...arguments, line, i)"
                                    />
                                        <!-- :pRefresh="tabs.leaf_formula.refreshCount" -->
                                </div>
                            </td>
                        </tr>
                    <!-- </transition> -->
                    </template>
                </tbody>
                <tfoot v-if="lines.length">
                    <tr style="">
                        <th colspan="3" class="text-right align-bottom font-weight-bold tw-text-sm pt-4">
                            <!-- <div>ปริมาณที่ขาด</div> -->
                        </th>
                        <th  class="font-weight-bold align-bottom text-danger tw-text-lg text-right pt-4">
                            <!-- {{ missingQty  | number2Digit }} -->
                        </th>
                        <th class="text-right align-bottom font-weight-bold tw-text-sm pt-4">
                            <div>รวมสัดส่วน</div>
                        </th>
                        <th class="font-weight-bold align-bottom text-success tw-text-lg text-right pt-4">
                            {{ totalProportion  | number2Digit }}
                        </th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
            <div class="text-center" v-if="lines.length === 0">
                <span class="lead">No Data.</span>
            </div>
        </div>
    </div>
</template>

<script>

import LeafIngredient from './LeafIngredient.vue';
import {
    showLoadingDialog,
    showProgressWithUnsavedChangesWarningDialog,
    showValidationFailedDialog,
} from "../../../commonDialogs"

export default {
    components: {
        LeafIngredient
    },
    props:[
        "header", 'url', 'transBtn', 'transDate', 'pRefresh', 'data', 'leafFormulas', "tabs"
    ],
    computed: {
        totalProportion: function () {
            let total =  _.sumBy(this.lines, function(o) {
                if (o.is_deleted == false) {
                    return parseFloat(o.leaf_proportion);
                }
            });
            return parseFloat(total ? total : 0).toFixed(2) * 1;
        },
        missingQty: function () {
            let sumQuantityUsed =  _.sumBy(this.lines, function(ingredient) {
                // console.log('missingQty ', ingredient, ingredient.leaf_dtl);
                if (ingredient.is_deleted == false) {
                    return _.sumBy( ingredient.leaf_dtl, function(o) {
                        if (o.is_deleted == false) {
                            return  parseFloat(o.quantity_used ? o.quantity_used : 0);
                        }
                    });
                }
            });
            sumQuantityUsed = parseFloat(sumQuantityUsed ? sumQuantityUsed : 0);
            return parseFloat(this.header.quantity ? this.header.quantity : 0) - sumQuantityUsed;
        }
    },
    watch:{
        pRefresh : async function (value, oldValue) {
            // console.log('refresh')
        },
        leafFormulas : async function (value, oldValue) {
            // console.log("watch: Leaf", value);
            this.lines = value;
        },
        // lines:  async function (val, oldVal) {
        //     this.$emit("syncLines", val);
        // }
    },
    data() {
        return {
            // itemId: (this.inventoryItemId != undefined && this.inventoryItemId != '') ? parseInt(this.inventoryItemId) : '',
            loading: {
                page: false,
                leaf_formula: false,
            },
            lines: [],
            tab: this.tabs
        }
    },
    mounted() {
        console.log('Leaf Formula: Component mounted.');
        // this.addNewLine();
        // this.addNewLine();
        // this.addNewLine();
        // this.getLeafFormulas();
        // if (this.itemId !== "") {
        //     this.getLeafFormulas({ inventory_item_id: this.itemId, header: this.pHeader });
        // } else {
        //     this.items = [];
        // }
    },
    methods: {
        async clickSelcet(line, i) {
            let vm = this;
            let remoteMethodRes = new Promise(async (resolve, reject) => {
                line.is_edit_item = true
                line.loading = true;
                await vm.remoteMethod(' ', line)
                line.loading = false;
                vm.$nextTick(() => {
                    const input = vm.$refs['leaf_' + i][0];
                    input.focus();
                });
                resolve(true);
            });
            let resultRemoteMethod = await remoteMethodRes;
        },
        syncIngredients(ingredients, line, lineIdx) {
            let vm = this;
            let leafProportion = 0;
            // console.log('Leaf Formula: syncIngredients', ingredients, line, lineIdx)
            line.input_ingredients = ingredients;

            if (parseFloat(vm.header.quantity) > 0) {
                ingredients.forEach((o, i) => {
                    if (o.is_deleted == false) {
                        leafProportion = parseFloat(leafProportion) + parseFloat(o.quantity_used);
                    }
                });
                leafProportion = ( parseFloat(leafProportion) / parseFloat(vm.header.quantity) ) * 100;
            }

            line.leaf_proportion = parseFloat(leafProportion).toFixed(2) * 1;
            // let vm = this;
            // vm.$set(vm.lines, lineIdx, ingredients);
            this.checkHasChange = true;
        },
        async addNewLine() {
            let vm = this;
            let row = vm.lines.length;
            // let newLine = await _.clone(vm.data.leaf_new_line);
            let newLine = JSON.parse(JSON.stringify(vm.data.leaf_new_line));
            vm.$set(vm.lines, row, newLine);
            // vm.$set(vm.lines2, row, newLine);

            // vm.$set(vm.lines[0], 'xxx',  false);


            vm.setHasChange();

            vm.$set(vm.tab.leaf_formula_line, 'has_change', vm.lines.length);

            if (vm.header.can.edit) {
                vm.remoteMethod(' ', vm.lines[row]);
            }
        },
        async selectLeaf(line) {
            let vm = this;

            // checkDup
            let checkDup = vm.lines.filter(o => {
                return o.leaf_formula == line.leaf_formula && o.is_deleted == false;
            });

            if (checkDup.length > 1) {
                line.leaf_formula = '';
                line.formulaline_id = '';
                line.line_no = '';
                line.leaf_formula_desc = '';
                return;
            }

            // let leaf = line.leaf_list.findIndex(o => o.value == line.leaf_formula);
            let leaf = line.leaf_list.findIndex(o => o.value == line.leaf_formula);
                leaf = line.leaf_list[leaf];

            line.formulaline_id = '';
            line.line_no = '';
            line.leaf_formula_desc = '';
            if (leaf) {
                line.leaf_formula_desc = leaf.leaf_formula_desc;
                line.formulaline_id = leaf.formulaline_id;
                line.line_no = leaf.line_no;
            }
            vm.setHasChange();
        },
        changeLeafProportion() {
            let vm = this;
            vm.setHasChange();
        },
        setHasChange() {
            let vm = this;
            vm.checkHasChange = true;
        },
        async remoteMethod(query, line) {
            let vm = this;
            if (query !== "") {

                let lines = vm.lines.filter(o => {
                    return o.is_deleted == false;
                });
                let except  = [... new Set(lines.map(o => o.leaf_formula)) ];

                await this.getLeafInput({
                    number: query,
                    header: this.header,
                    type: 'leaf_formula',
                    except: except,
                }, line);
            } else {
                line.leaf_list = [];
            }
        },
        async getLeafInput(params, line) {
            let vm = this;
            vm.loading.leaf_formula = true;
            line.leaf_list = [];
            await axios.get(vm.url.ajax_get_data, { params }).then(res => {
                let response = res.data.data
                vm.loading.leaf_formula = false;
                line.leaf_list = response.leaf_list;
            });
        },
        async getLeafFormulas() {
            let vm = this;
            let params = {
                header: this.header,
                type: 'leaf_formula_line'
            }
            vm.loading.page = true;
            axios.get(vm.url.ajax_get_data, { params }).then(res => {
                let response = res.data.data
                // vm.leafFormulas = response.leaf_formula_lines
                // vm.$set(vm, 'leafFormulas', response.leaf_formula_lines);
                vm.$set(vm, 'lines', response.leaf_formula_lines);
                vm.loading.page = false;
            });
        },
        async deleteline(line) {
            let vm = this;
            if (!line.is_new_row) {
                let casings = [];
                let params = {
                    header: vm.header,
                    type: 'casings',
                    leaf_formula: line.leaf_formula
                }

                axios.get(vm.url.ajax_get_data, { params }).then(async res => {
                    let response = res.data.data;
                        casings = response.casings
                    if (casings.length) {
                        confirm = await helperAlert.showProgressConfirm('ต้องการลบข้อมูล Casing ที่ผูกกับ Leaf Formula: ' + line.leaf_formula + ' หรือไม่ ?');
                        if (confirm) {
                            line.is_deleted = true;
                        }
                    } else {
                        line.is_deleted = true;
                    }
                });
            } else {
                line.is_deleted = true;
            }
        }
    }
}
</script>