<template>
    <div v-loading="loading.page">
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
        <div class="table-responsivex">
            <table  class="table" style="margin-bottom: 0px;">
                <thead>
                    <tr>
                        <th width="15%">
                            <div>Leaf Formula</div>
                        </th>
                        <th width="10%" class="hidden-sm hidden-xs">
                            <div>รายละเอียด</div>
                        </th>
                        <th width="15%">
                            <div>Casing No.</div>
                        </th>
                        <th width="" class="hidden-sm hidden-xs">
                            <div>รายละเอียด</div>
                        </th>
                        <th width="15%" class="text-right"></th>
                    </tr>
                </thead>
                <tbody id="accordion">
                    <template v-for="(line, i) in lines" v-if="lines.length" >
                    <transition
                        enter-active-class="animated fadeInUp"
                        leave-active-class="animated fadeOutDown">
                    <!-- <transition-group  tag="template" name="table-row"> -->
                        <tr style="background-color: rgb(252, 252, 252);" :data="i" v-if="!line.is_deleted" :key="i">
                            <td>
                                <el-select
                                    v-model="line.leaf_formula"
                                    filterable
                                    remote
                                    placeholder="Leaf Formula"
                                    :remote-method="data => remoteMethod(data, line, 'casing_leaf_formula_list')"
                                    @change="selectLeaf(line)"
                                    :disabled="!header.can.edit || !line.is_new_row"
                                    :loading="line.loading"  >
                                    <el-option
                                        v-for="(leaf, index) in line.casing_leaf_formula_list"
                                        :key="leaf.value"
                                        :label="leaf.label"
                                        :value="String(leaf.value)"
                                    ></el-option>
                                </el-select>
                            </td>
                            <td>
                                {{ line.leaf_formula_desc }}
                            </td>
                            <td>
                                <el-select
                                    v-model="line.casing_id"
                                    filterable
                                    remote
                                    placeholder=""
                                    :remote-method="data => remoteMethod(data, line, 'casing_list')"
                                    @change="selectCasing(line)"
                                    :disabled="!header.can.edit || !line.is_new_row"
                                    :loading="line.loading"  >
                                    <el-option
                                        v-for="(leaf, index) in line.casing_list"
                                        :key="leaf.value"
                                        :label="leaf.label"
                                        :value="String(leaf.value)"
                                    ></el-option>
                                </el-select>
                            </td>
                            <td>
                                {{ line.casing_desc }}
                            </td>
                            <td class="text-right align-middle">

                                <button  :class="transBtn.detail.class + ' btn-xs mb-0'"
                                    @click.prevent="line.is_collapse = !line.is_collapse">
                                    <i :class="transBtn.detail.icon"></i>
                                    {{ transBtn.detail.text }}
                                </button>

                                <button  :class="transBtn.delete.class + ' btn-xs mb-0 btn-outline'"
                                    :disabled="!header.can.edit"
                                    @click.prevent="line.is_deleted = true">
                                    <i :class="transBtn.delete.icon"></i>
                                </button>
                            </td>
                        </tr>
                    </transition>
                    <transition
                        enter-active-class="animated fadeInUp"
                        leave-active-class="animated fadeOutDown">
                        <tr v-if="line.is_collapse && line.casing_items.length && !line.is_deleted">
                            <td colspan="2"></td>
                            <td colspan="3">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th width="15%">รหัสวัตถุดิบ</th>
                                        <th>รายละเอียดวัตถุดิบ</th>
                                        <th width="20%" class="text-right">ปริมาณที่ใช้</th>
                                        <th width="5%" class="text-right">หน่วย</th>
                                    </tr>
                                    </thead>
                                    <tr v-for="(item) in line.casing_items">
                                        <td>{{ item.item_code }}</td>
                                        <td>{{ item.item_desc }}</td>
                                        <td class="text-right">{{ item.quantity_used | number3Digit }}</td>
                                        <td class="text-right">{{ item.uom_name }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </transition>
                    <!-- </transition-group> -->
                    </template>
                </tbody>
            </table>
            <div class="text-center" v-if="lines.length === 0">
                <span class="lead">No Data.</span>
            </div>
        </div>
    </div>
</template>

<script>


export default {
    // components: {
    //     LeafIngredient
    // },
    props:[
        "header", 'url', 'transBtn', 'transDate', 'data', 'casings', "tabs"
    ],
    computed: {
        // totalProportion: function () {
        //     let total =  _.sumBy(this.lines, function(o) { return parseInt(o.leaf_proportion); });
        //     return parseFloat(total);
        // }
    },
    watch:{
        casings : async function (value, oldValue) {
            let vm = this;
            vm.lines = value;
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
            // vm.$set(vm.lines[0], 'xxx',  false);

        }
    },
    mounted() {
        console.log('Casings: Component mounted.')
        // this.addNewLine();
        // this.getLeafFormulas();
        // if (this.itemId !== "") {
        //     this.getLeafFormulas({ inventory_item_id: this.itemId, header: this.pHeader });
        // } else {
        //     this.items = [];
        // }
    },
    methods: {
        syncIngredients(ingredients, line) {
            line.input_ingredients = ingredients;
            this.checkHasChange = true;
        },
        async addNewLine() {
            let vm = this;
            let row = vm.lines.length;
            let newLine = await _.clone(vm.data.new_line);
            vm.$set(vm.lines, row, newLine);
            // vm.$set(vm.lines2, row, newLine);


            vm.setHasChange();

            vm.$set(vm.tab.casings, 'has_change', vm.lines.length);

            if (vm.header.can.edit) {
                vm.remoteMethod(' ', vm.lines[row], 'casing_leaf_formula_list')
                vm.remoteMethod(' ', vm.lines[row], 'casing_list')
            }
        },
        async avalidateDup(line) {
            if (line.leaf_formula && line.casing_id) {

            }
        },
        async selectLeaf(line) {
            let vm = this;
            line.leaf_formula_desc = '';

            // checkDup
            let checkDup = vm.lines.filter(o => {
                if (line.casing_id) {
                    return o.leaf_formula == line.leaf_formula && o.is_deleted == false;
                }
            });

            if (checkDup.length > 1) {
                line.leaf_formula = '';
                return;
            }


            let leaf = line.casing_leaf_formula_list.findIndex(o => o.value == line.leaf_formula);
                leaf = line.casing_leaf_formula_list[leaf];

            if (leaf) {
                line.leaf_formula_desc = leaf.leaf_formula_desc;
            }
            vm.setHasChange();
            // vm.validateDup(line);
        },
        async selectCasing(line) {
            let vm = this;
            line.casing_no              = '';
            line.casing_desc            = '';
            line.casing_items           = [];

            // checkDup
            let checkDup = vm.lines.filter(o => {
                if (line.leaf_formula) {
                    return o.casing_id == line.casing_id && o.is_deleted == false;
                }
            });

            if (checkDup.length > 1) {
                line.casing_id = '';
                return;
            }

            let casing = line.casing_list.findIndex(o => o.value == line.casing_id);
                casing = line.casing_list[casing];


            if (casing) {
                line.casing_no                  = casing.casing_no;
                line.casing_desc                = casing.casing_desc;
                line.casing_items               = casing.casing_items;
                // line.line_type                = casing.line_type;
                // line.line_no                  = casing.line_no;
                // line.organization_id          = casing.organization_id;
                // line.inventory_item_id        = casing.inventory_item_id;
                // line.item_code                = casing.item_code;
                // line.item_desc                = casing.item_desc;
                // line.quantity_used            = casing.quantity_used;
                // line.uom                      = casing.uom;
            }
            vm.setHasChange();
            // vm.validateDup(line);
        },
        changeLeafProportion() {
            let vm = this;
            vm.setHasChange();
        },
        setHasChange() {
            let vm = this;
            vm.checkHasChange = true;
        },
        async remoteMethod(query, row, inputName) {
            row[inputName] = [];

            let line = _.clone(row);
                line.casing_leaf_formula_list = [];
                line.casing_list = [];
            if (query !== "") {
                this.getData({
                    number: query,
                    header: this.header,
                    line: line,
                    type: inputName
                }, row, inputName);
            }
        },
        async getData(params, row, inputName) {
            let vm = this;
            row.loading = true;
            axios.get(vm.url.ajax_get_data, { params }).then(res => {
                let response = res.data.data
                row.loading = false;
                row[inputName] = response[inputName];
            });
        }
    }
}
</script>

<style scoped>

.fruit-table-move {
  transition: transform 1s;
}
</style>