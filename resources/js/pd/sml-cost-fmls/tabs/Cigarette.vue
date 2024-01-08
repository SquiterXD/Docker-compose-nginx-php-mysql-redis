<template>
    <div v-loading="loading.page">
        <div class="row">
            <div class="col-12 text-right">
                <!-- <button  :class="transBtn.create.class + ' btn-sm tw-w-25  btn-outline'"
                    :disabled="!header.can.edit"
                    @click.prevent="addNewLine">
                    <i :class="transBtn.create.icon"></i>
                    เพิ่มรายการ
                </button> -->
            </div>
        </div>
        <div class="table-responsivex">
            <table  class="table" style="margin-bottom: 0px;">
                <thead>
                    <tr class="pdp0008-table-th-detail-color">
                        <!-- <th style="min-width: 15px !important; max-width: 15px !important;" class="text-center align-middle">
                            เปิดใช้งาน
                        </th> -->
                        <th width="200px;">
                            <div>ขั้นตอนการทำงาน</div>
                        </th>
                        <th width="" class="hidden-sm hidden-xs">
                            <div>รายละเอียด</div>
                        </th>
                        <!-- <th width="130px;" class="text-center">ต้นทุนวัตถุดิบที่ใช้ (บาท)</th>
                        <th width="130px;" class="text-center">ปรับราคา (%)</th>
                        <th width="130px;" class="text-center">ราคาปรับลด/เพื่ม (บาท)</th>
                        <th width="130px;" class="text-center">ต้นทุนหลังปรับราคา (บาท)</th> -->
                        <th width="250px;" class="text-right"></th>
                    </tr>
                </thead>
                <tbody id="accordion">
                    <template v-for="(line, i) in lines" v-if="lines.length" >
                    <transition
                        enter-active-class="animated fadeInUp"
                        leave-active-class="animated fadeOutDown">
                    <!-- <transition-group  tag="template" name="table-row"> -->
                        <tr style="background-color: rgb(252, 252, 252);" :data="i" v-if="!line.is_deleted" :key="i">
                            <!-- <td style="min-width: 15px !important; max-width: 15px !important;"  class="text-center align-middle">
                                <el-checkbox v-model="line.flavor_status"></el-checkbox>
                            </td> -->
                            <td style="min-width: 30px !important; max-width: 30px !important;">
                                    <!-- :disabled="!header.can.edit || !line.is_new_row" -->
                                <el-select
                                    v-model="line.wip_code"
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
                                </el-select>
                            </td>
                            <td>
                                {{ line.wip_desc }}
                            </td>
                            <td class="text-right align-middle" v-if="false">
                                <input class="form-control text-right" disabled :title="line.unit_cost"
                                :value="Number(line.unit_cost).toLocaleString(undefined, {minimumFractionDigits: 6,maximumFractionDigits: 6})">
                            </td>
                            <td class="text-right align-middle" v-if="false">
                                <!-- {{ line.price_adjus }} -->
                                <vue-numeric :disabled="!header.can.edit"
                                    separator=","
                                    v-bind:precision="2"
                                    v-bind:minus="true"
                                    class="form-control text-right font-weight-bold "
                                    v-model="line.price_adjus"
                                    @change="changePriceAdjus(line)"
                                    ></vue-numeric>
                            </td>
                            <td class="text-right align-middle" v-if="false">
                                <!-- {{ line.price_reduc_increase }} -->
                                <vue-numeric :disabled="!header.can.edit"
                                    separator=","
                                    v-bind:precision="6"
                                    v-bind:minus="true"
                                    class="form-control text-right font-weight-bold "
                                    v-model="line.price_reduc_increase"
                                    @change="(value)=>{
                                        line.price_adjus = 0;
                                        calCost(line)
                                    }"
                                    ></vue-numeric>
                            </td>
                            <td class="text-right align-middle" v-if="false">
                                <input class="form-control text-right" disabled :title="line.cost_after_price_adjus"
                                :value="Number(line.cost_after_price_adjus).toLocaleString(undefined, {minimumFractionDigits: 6,maximumFractionDigits: 6})">
                            </td>
                            <td class="text-right align-middle">

                                <button  :class="transBtn.create.class + ' btn-xs tw-w-25 mb-0 btn-outline'" v-if="line.is_collapse"
                                    :disabled="!header.can.edit"
                                    @click.prevent="addNewItem(line)">
                                    <i :class="transBtn.create.icon"></i>
                                    เพิ่มวัตถุดิบ
                                </button>

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
                        <tr v-if="line.is_collapse && line.wip_code && line.items.length && !line.is_deleted">
                            <!-- <td colspan="1"></td> -->
                            <td colspan="3" class="pl-5 pr-5">
                                <table class="table table table-bordered">
                                    <thead>
                                    <tr>
                                        <th width="50px;" class="text-center">
                                            <div>ลำดับ</div>
                                        </th>
                                        <th width="50px;" class="text-center">
                                            <div>ใช้งาน</div>
                                        </th>
                                        <th width="150px;">รหัสวัตถุดิบ</th>
                                        <th>รายละเอียดวัตถุดิบ</th>
                                        <th width="150px;" class="text-center">ปริมาณ (กก.)</th>
                                        <th width="70px;" class="text-center">สถานะ</th>
                                        <th class="text-center" width="150px;">
                                            <div>ราคาตั้งต้น</div>
                                        </th>
                                        <th class="text-center" width="150px;">
                                            <div>ปรับ (%)</div>
                                        </th>
                                        <th class="text-center" width="150px;">
                                            <div>ปรับ (มูลค่า)</div>
                                        </th>
                                        <th class="text-center" width="150px;">
                                            <div>ราคาหลังปรับ</div>
                                        </th>
                                        <th width="150px;" class="text-center">
                                            <div>ต้นทุน</div>
                                            <div>บาท/พันมวน</div>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tr v-for="(item, item_idx) in line.items">
                                        <td class="text-center">
                                            {{ item_idx + 1 }}
                                        </td>
                                        <td class="text-center">
                                            <input type="checkbox" :disabled="!header.can.edit"  v-model="item.enable_flag"  true-value="Y" false-value="N">
                                        </td>
                                        <td>
                                            <!-- {{ item.item_code }} -->
                                            <input type="text" class="form-control" v-if="!item.is_edit_item" :disabled="!header.can.edit"
                                                :value="item.item_code"
                                                @click="clickSelcetItem(line, item, i +''+ item_idx, 'ciga_item_list')" >
                                                <!-- @change="selectFlavor(line)" -->
                                            <el-select  v-if="item.is_edit_item" v-loading="item.loading"
                                                :ref="'ciga_item_list_'+ i +''+ item_idx"
                                                v-model="item.inventory_item_id"
                                                filterable
                                                remote
                                                placeholder=""
                                                :disabled="!header.can.edit"
                                                @change="selectItem(item)"
                                                :loading="item.loading"  >
                                                <el-option
                                                    v-for="(item, index) in item.ciga_item_list"
                                                    :key="item.value"
                                                    :label="item.label"
                                                    :value="String(item.value)"
                                                >
                                                    <span style="float: left">{{ item.label }}</span>
                                                </el-option>
                                            </el-select>
                                        </td>
                                        <td>{{ item.item_desc }}</td>
                                        <td class="text-right">
                                            <!-- {{ item.quantity_used | number3Digit }} -->
                                            <vue-numeric :disabled="!header.can.edit"
                                                separator=","
                                                v-bind:precision="6"
                                                v-bind:minus="true"
                                                class="form-control text-right font-weight-bold "
                                                v-model="item.quantity_used"
                                                @change="changePriceAdjus(item)"
                                                ></vue-numeric>
                                        </td>
                                        <td class="text-center">{{ item.status }}</td>

                                        <td class="text-right">
                                            <input class="form-control text-right" disabled :title="item.unit_cost"
                                                :value="Number(item.unit_cost).toLocaleString(undefined, {minimumFractionDigits: 6,maximumFractionDigits: 6})">
                                        </td>
                                        <td class="text-right">
                                            <vue-numeric :disabled="!header.can.edit"
                                                separator=","
                                                v-bind:precision="6"
                                                v-bind:minus="true"
                                                class="form-control text-right font-weight-bold "
                                                v-model="item.price_adjus"
                                                @change="changePriceAdjus(item)"
                                                ></vue-numeric>
                                        </td>
                                        <td class="text-right">
                                            <vue-numeric :disabled="!header.can.edit"
                                                separator=","
                                                v-bind:precision="6"
                                                v-bind:minus="true"
                                                class="form-control text-right font-weight-bold "
                                                v-model="item.price_reduc_increase"
                                               @change="(value)=>{
                                                    item.price_adjus = 0;
                                                    calCost(item)
                                                }"
                                                ></vue-numeric>
                                        </td>
                                        <td class="text-right">
                                            <input class="form-control text-right" disabled :title="item.cost_after_price_adjus"
                                                :value="Number(item.cost_after_price_adjus).toLocaleString(undefined, {minimumFractionDigits: 6,maximumFractionDigits: 6})">
                                        </td>
                                        <td>
                                            <input class="form-control text-right" disabled
                                                :title="item.cost_per_cgk_baht"
                                                :value="Number(item.cost_per_cgk_baht).toLocaleString(undefined, {minimumFractionDigits: 6,maximumFractionDigits: 6})">
                                        </td>
                                    </tr>
                                    <cigarette-item-total :items="line.items"></cigarette-item-total>
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
import CigaretteItemTotal from './CigaretteItemTotal.vue';

export default {
    components: {
        CigaretteItemTotal
    },
    props:[
        "header", 'url', 'transBtn', 'transDate', 'data', 'cigarettes', "tabs"
    ],
    computed: {
        totalUnitCost() {
            let vm = this;
            let total = 0;
            vm.lines.forEach((o, i) => {
                if (o.is_deleted == false) {
                    total = parseFloat(total) + parseFloat(o.unit_cost ? o.unit_cost : 0);
                }
            });

            return parseFloat(total);
        },
        totalCostAfterPriceAdjus() {
            let vm = this;
            let total = 0;
            vm.lines.forEach((o, i) => {
                if (o.is_deleted == false) {
                    total = parseFloat(total) + parseFloat(o.cost_after_price_adjus);
                }
            });

            return parseFloat(total);
        },
    },
    watch:{
        cigarettes : async function (value, oldValue) {
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
        console.log('Cigarette : Component mounted.')
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
        async calCost(line) {
            // let unitCost = parseFloat(line.unit_cost ? line.unit_cost : 0);
            // let priceReducIncrease = parseFloat(line.price_reduc_increase ? line.price_reduc_increase : 0);
            // line.cost_after_price_adjus = unitCost + priceReducIncrease;

            // let unitCost = parseFloat(line.unit_cost ? line.unit_cost : 0);
            // let quantityUsed = parseFloat(line.quantity_used ? line.quantity_used : 0);
            // let costMaterialsUsed = unitCost * quantityUsed;
            // let priceReducIncrease = parseFloat(line.price_reduc_increase ? line.price_reduc_increase : 0);

            // line.cost_after_price_adjus = costMaterialsUsed + priceReducIncrease;


            // line.cost_per_cgk_baht = line.cost_after_price_adjus * parseFloat(this.header.lld_qty ? this.header.lld_qty : 1)

            let unitCost = parseFloat(line.unit_cost ? line.unit_cost : 0);
            let quantityUsed = parseFloat(line.quantity_used ? line.quantity_used : 0);
            let priceReducIncrease = parseFloat(line.price_reduc_increase ? line.price_reduc_increase : 0);
            // let costMaterialsUsed = unitCost * quantityUsed;

            line.cost_after_price_adjus = unitCost + priceReducIncrease;


            line.cost_per_cgk_baht = quantityUsed * (unitCost + priceReducIncrease)
        },
        async changePriceAdjus(line) {
            let unitCost = parseFloat(line.unit_cost ? line.unit_cost : 0);
            let priceAdjus = parseFloat(line.price_adjus ? line.price_adjus : 0);

            if (!priceAdjus) {
                line.price_reduc_increase = 0;
            } else {
                line.price_reduc_increase = unitCost * (priceAdjus / 100);
            }
            this.calCost(line)
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
                vm.remoteMethod(' ', vm.lines[row], 'flavor_list');
            }
        },
        async addNewItem(line) {
            let vm = this;
            let row = line.items.length;
            let newItem = await _.clone(vm.data.new_ciga_item);
            vm.$set(line.items, row, newItem);
            vm.setHasChange();
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
            line.unit_cost = 0;

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
                line.unit_cost                  = flavor.unit_cost;
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
            this.changePriceAdjus(line)
        },
        async selectItem(item) {
            let itemData = item.ciga_item_list.findIndex(o => o.value == item.inventory_item_id);
                itemData =  item.ciga_item_list[itemData];

                item.product_item = itemData.product_item;
                item.blend_id = itemData.blend_id;
                item.fm_wc_id = itemData.fm_wc_id;
                item.line_no = itemData.line_no;
                item.wip_code = itemData.wip_code;
                item.wip_desc = itemData.wip_desc;
                item.organization_id = itemData.organization_id;
                item.item_code = itemData.item_code;
                item.item_desc = itemData.item_desc;
                item.unit_cost = itemData.unit_cost;
                item.price_adjus = itemData.price_adjus;
                item.price_reduc_increase = itemData.price_reduc_increase;
                item.cost_after_price_adjus = itemData.cost_after_price_adjus;
                item.quantity_used = itemData.quantity_used;
                item.uom = itemData.uom;
                item.uom_name = itemData.uom_name;
                item.cost_per_cgk_baht = itemData.cost_per_cgk_baht;
                item.attribute1 = itemData.attribute1;
        },
        async clickSelcetItem(line, item, i, type) {
            let vm = this;
            let remoteMethodRes = new Promise(async (resolve, reject) => {
                item.is_edit_item = true
                item.loading = true;
                // await vm.remoteMethod(' ', line, type)
                await vm.remoteItemMethod(' ', line, item, type)
                item.loading = false;
                vm.$nextTick(() => {
                    const input = vm.$refs[type + '_' + i][0];
                    input.focus();
                });
                resolve(true);
            });
            let resultRemoteMethod = await remoteMethodRes;
        },
        changeLeafProportion() {
            let vm = this;
            vm.setHasChange();
        },
        setHasChange() {
            let vm = this;
            vm.checkHasChange = true;
        },
        async remoteItemMethod(query, line, item, inputName) {
            item[inputName] = [];
            let vm = this;
            let lineData = _.clone(line);
                lineData.items = [];
            // let data = _.clone(item);
            //     data[inputName] = [];

            let lines = line.items.filter(o => {
                return o.is_deleted == false && item.inventory_item_id != o.inventory_item_id;
            });

            // let except  = [];
            let except  = [... new Set(lines.map(o => o.inventory_item_id)) ];
            // if (isNewLine) {
            //     except  = [... new Set(lines.map(o => o.flavor_id)) ];
            // }

            if (query !== "") {
                await this.getData({
                    number: query,
                    header: this.header,
                    line: lineData,
                    type: inputName,
                    except: except,
                }, item, inputName);
            }
        },
        async remoteMethod(query, row, inputName) {
            row[inputName] = [];
            let vm = this;
            let line = _.clone(row);
                line.flavor_list = [];

            let lines = vm.lines.filter(o => {
                    return o.is_deleted == false;
                });
            let except  = [... new Set(lines.map(o => o.flavor_id)) ];

            if (query !== "") {
                this.getData({
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