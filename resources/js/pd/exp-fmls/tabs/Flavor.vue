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
                    <tr class="pdp0008-table-th-detail-color">
                        <th style="min-width: 15px !important; max-width: 15px !important;" class="text-center align-middle">
                            เปิดใช้งาน
                        </th>
                        <th style="min-width: 30px !important; max-width: 30px !important;">
                            <div>Flavor No.</div>
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
                            <td style="min-width: 15px !important; max-width: 15px !important;"  class="text-center align-middle">
                                <!-- <input class="" type="checkbox" :value="line.flavor_status"> -->
                                <el-checkbox v-model="line.flavor_status"></el-checkbox>
                            </td>
                            <td style="min-width: 30px !important; max-width: 30px !important;">
                                    <!-- :disabled="!header.can.edit || !line.is_new_row" -->
                                <!-- <el-select
                                    v-model="line.flavor_id"
                                    filterable
                                    remote
                                    placeholder=""
                                    :remote-method="data => remoteMethod(data, line, 'flavor_list')"
                                    :disabled="!header.can.edit"
                                    @change="selectFlavor(line)"
                                    @click="data => remoteMethod(data, line, 'flavor_list')"
                                    :loading="line.loading"  >
                                    <el-option
                                        v-for="(flav, index) in line.flavor_list"
                                        :key="flav.value"
                                        :label="flav.flavor_no"
                                        :value="String(flav.value)"
                                    >
                                        <span style="float: left">{{ flav.label }}</span>
                                    </el-option>
                                </el-select> -->
                                <input type="text" class="form-control" v-if="!line.is_edit_item" :disabled="!header.can.edit"
                                    :value="line.flavor_no"
                                    @click="clickSelcet(line, i, 'flavor_list')" >
                                    <!-- @click="data => remoteMethod(data, line, 'flavor_list')" -->
                                    <!-- :remote-method="data => remoteMethod(data, line, 'flavor_list')" -->
                                <el-select  v-if="line.is_edit_item" v-loading="line.loading"
                                    :ref="'flavor_list_'+ i"
                                    v-model="line.flavor_id"
                                    filterable
                                    remote
                                    placeholder=""
                                    :disabled="!header.can.edit"
                                    @change="selectFlavor(line)"
                                    :loading="line.loading"  >
                                    <el-option
                                        v-for="(flav, index) in line.flavor_list"
                                        :key="flav.value"
                                        :label="flav.flavor_no"
                                        :value="String(flav.value)"
                                    >
                                        <span style="float: left">{{ flav.label }}</span>
                                    </el-option>
                                </el-select>
                            </td>
                            <td>
                                {{ line.flavor_desc }}
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
                        <tr v-if="line.is_collapse && line.flavor_items.length && !line.is_deleted">
                            <!-- <td colspan="1"></td> -->
                            <td colspan="4">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th width="15%">รหัสวัตถุดิบ</th>
                                        <th>รายละเอียดวัตถุดิบ</th>
                                        <th width="20%" class="text-right">ปริมาณที่ใช้</th>
                                        <th width="5%" class="text-right">หน่วย</th>
                                    </tr>
                                    </thead>
                                    <tr v-for="(item) in line.flavor_items">
                                        <td>{{ item.item_code }}</td>
                                        <td>{{ item.item_desc }}</td>
                                        <td class="text-right">{{ item.quantity_used | number3Digit }}</td>
                                        <!-- <td class="text-right">{{ item.calcula_flavor_quantity | number3Digit }}</td> -->
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
        "header", 'url', 'transBtn', 'transDate', 'data', 'flavors', "tabs"
    ],
    computed: {
        // totalProportion: function () {
        //     let total =  _.sumBy(this.lines, function(o) { return parseInt(o.leaf_proportion); });
        //     return parseFloat(total);
        // }
    },
    watch:{
        flavors : async function (value, oldValue) {
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
        console.log('Flavor: Component mounted.')
        // this.addNewLine();
        // this.getLeafFormulas();
        // if (this.itemId !== "") {
        //     this.getLeafFormulas({ inventory_item_id: this.itemId, header: this.pHeader });
        // } else {
        //     this.items = [];
        // }
    },
    methods: {
        async clickSelcet(line, i, type) {
            let vm = this;
            let remoteMethodRes = new Promise(async (resolve, reject) => {
                line.is_edit_item = true
                line.loading = true;
                await vm.remoteMethod(' ', line, type)
                line.loading = false;
                vm.$nextTick(() => {
                    const input = vm.$refs[type + '_' + i][0];
                    input.focus();
                });
                resolve(true);
            });
            let resultRemoteMethod = await remoteMethodRes;

        },
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
                // vm.remoteMethod(' ', vm.lines[row], 'flavor_list');
            }
        },
        // async selectLeaf(line) {
        //     let vm = this;
        //     let leaf = line.casing_leaf_formula_list.findIndex(o => o.value == line.leaf_formula);
        //         leaf = line.casing_leaf_formula_list[leaf];

        //     line.leaf_formula_desc = '';
        //     if (leaf) {
        //         line.leaf_formula_desc = leaf.leaf_formula_desc;
        //     }
        //     vm.setHasChange();
        // },
        async selectFlavor(line) {
            let vm = this;
            line.flavor_no              = '';
            line.flavor_desc            = '';
            line.flavor_items           = [];

            // checkDup
            let checkDup = vm.lines.filter(o => {
                return o.flavor_id == line.flavor_id && o.is_deleted == false;
            });

            if (checkDup.length > 1) {
                line.flavor_id = '';
                return;
            }


            let flavor = line.flavor_list.findIndex(o => o.value == line.flavor_id);
                flavor = line.flavor_list[flavor];

            if (flavor) {
                line.flavor_no                  = flavor.flavor_no;
                line.flavor_desc                = flavor.flavor_desc;
                line.flavor_items               = flavor.flavor_items;
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
            let vm = this;
            let line = _.clone(row);
                line.flavor_list = [];

            let lines = vm.lines.filter(o => {
                    return o.is_deleted == false && row.flavor_id != o.flavor_id;
                });
            let except  = [... new Set(lines.map(o => o.flavor_id)) ];

            if (query !== "") {
                await this.getData({
                    number: query,
                    header: this.header,
                    line: line,
                    type: inputName,
                    except: except,
                }, row, inputName);
            }
        },
        async getData(params, row, inputName) {
            let vm = this;
            row.loading = true;
            await axios.get(vm.url.ajax_get_data, { params }).then(res => {
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