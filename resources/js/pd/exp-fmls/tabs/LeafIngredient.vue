<template>
    <div>
        <div>
            <h3 class="text-navy">
                รายการวัตถุดิบทั้งหมด: {{ ingredientsCount }}

                <button  :class="transBtn.delete.class + ' btn-sm tw-w-25 pull-right  btn-outline'"
                    :disabled="!header.can.edit"
                    @click.prevent="deleteAll">
                    <i :class="transBtn.delete.icon"></i>
                    ลบทั้งหมด
                </button>
                <button  :class="transBtn.create.class + ' btn-sm tw-w-25 pull-right mr-2  btn-outline'"
                    :disabled="!header.can.edit"
                    @click.prevent="addNewLine">
                    <i :class="transBtn.create.icon"></i>
                    เพิ่มรายการ
                </button>
            </h3>
        </div>

        <table  class="table mb-5 table-hover table-bordered">
            <thead>
                <tr>
                    <th width="230px;">
                        รหัสวัตถุดิบ
                    </th>
                    <th width="" class="hidden-sm hidden-xs">
                        เกรดใบยา
                    </th>
                    <template v-if="header.can.leaf_formulas.ingredient.add_lot_number">
                        <th width="200px;" class="text-center">
                            <div>Lot</div>
                        </th>
                    </template>
                    <th width="130px;" class="text-center">
                        <div>สัดส่วน %</div>
                    </th>
                    <th width="130px;" class="text-center">
                        <div>ปริมาณที่ใช้ (กก.)</div>
                    </th>
                    <th width="50px;"></th>
                </tr>
                <!-- v-for="(line, i) in lines" v-if="lines.length" -->
            </thead>
            <tbody>
                <template v-for="(ingredient, i) in ingredients" v-if="ingredients.length">
                <transition
                    enter-active-class="animated fadeInUp"
                    leave-active-class="animated fadeOutDown">
                    <tr v-if="!ingredient.is_deleted">
                        <td>
                            <template v-if="true">
                                <!-- <el-select
                                    style="width:100%"
                                    v-model="ingredient.inventory_item_id"
                                    filterable
                                    remote
                                    placeholder="รหัสวัตถุดิบ"
                                    :remote-method="data => remoteMethod(data, ingredient, 'item_list')"
                                    @change="selectInventoryItemId(ingredient)"
                                    :disabled="!header.can.edit"
                                    :loading="loading"
                                >
                                    <el-option
                                        v-for="(item, index) in ingredient.item_list"
                                        :key="item.value"
                                        :label="item.item_number"
                                        :value="String(item.value)"
                                    >
                                        <span style="float: left">{{ item.label }}</span>
                                    </el-option>
                                </el-select> -->
                                <input type="text" class="form-control" v-if="!ingredient.is_edit_item" :disabled="!header.can.edit"
                                    :value="ingredient.item_code"
                                    @click="clickSelcet(ingredient, i, 'item_list')" >
                                    <!-- :remote-method="data => remoteMethod(data, ingredient, 'item_list')" -->
                                <el-select v-loading="ingredient.loading" v-if="ingredient.is_edit_item"
                                    style="width:100%"
                                    v-model="ingredient.inventory_item_id"
                                    filterable
                                    remote
                                    :ref="'item_list_'+ i"
                                    placeholder="รหัสวัตถุดิบ"
                                    @change="selectInventoryItemId(ingredient)"
                                    :disabled="!header.can.edit"
                                    :loading="loading"
                                >
                                    <el-option
                                        v-for="(item, index) in ingredient.item_list"
                                        :key="item.value"
                                        :label="item.item_number"
                                        :value="String(item.value)"
                                    >
                                        <span style="float: left" >{{ item.label }}</span>
                                    </el-option>
                                </el-select>
                            </template>
                            <template v-else>
                                <div style="display: flex;">

                                    <template v-if="!line.is_edit_item || !header.can.edit">
                                        <el-input
                                          placeholder="Please input"
                                          :value="line.item_number"
                                          :disabled="true">
                                        </el-input>

                                        <button v-if="header.can.edit && line.transfer_line_id"
                                            type="button"
                                            @click.prevent="line.is_edit_item = true"
                                            class="btn btn-outline btn-xs mb-0"
                                            title="แก้ไข">
                                                <i :class="transBtn.edit.icon"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <search-item
                                            :pHeader="header"
                                            :inventoryItemId="line.inventory_item_id"
                                            @itemWasSelected="itemWasSelected(...arguments, line)"
                                            :url="url" />
                                        <button v-if="header.can.edit && line.request_line_id"
                                            type="button"
                                            @click.prevent="line.is_edit_item = false"
                                            class="btn btn-outline btn-xs mb-0"
                                            title="ยกเลิกแก้ไข" >
                                                <i class="fa fa-refresh"></i>
                                        </button>
                                    </template>
                                </div>
                            </template>
                        </td>
                        <td>
                            {{ ingredient.item_desc  }}
                        </td>
                        <template v-if="header.can.leaf_formulas.ingredient.add_lot_number">
                        <td>
                            <el-select
                                style="width:100%"
                                v-model="ingredient.lot_number"
                                clearable
                                filterable
                                :disabled="!ingredient.inventory_item_id || !header.can.edit"
                                remote
                                @change="selectLotNumber(ingredient, i)"
                                placeholder="Lot Number"
                                :remote-method="data => remoteMethod(data, ingredient, 'lot_list')"
                                :loading="loading"
                            >
                                <el-option
                                    v-for="(lot, index) in ingredient.lot_list"
                                    :key="lot.value"
                                    :label="lot.label"
                                    :value="String(lot.value)"
                                ></el-option>
                            </el-select>
                        </td>
                        </template>
                        <td>
                            <!-- <input class="form-control text-right" type="number"
                                :disabled="!ingredient.inventory_item_id || !leaf.leaf_proportion || !header.can.edit"
                                @change="(event) => {
                                    if (parseFloat(event.target.value) < 0) {
                                        ingredient.quantity_used = parseFloat(0)
                                    }
                                    changeIngredientProportions(ingredient, false)
                                }"
                                v-model.number="ingredient.ingredient_proportions"/> -->
                            <!-- <vue-numeric :title="ingredient.ingredient_proportions" :disabled="true"
                                separator=","
                                v-bind:precision="2"
                                class="form-control text-right"
                                v-model.number="ingredient.ingredient_proportions"
                                @change="(event) => {
                                    if (parseFloat(event.target.value) < 0) {
                                        ingredient.quantity_used = parseFloat(0)
                                    }
                                    changeIngredientProportions(ingredient, false)
                                }"
                                ></vue-numeric> -->
                                <input class="form-control text-right" disabled
                                    :title="ingredient.ingredient_proportions"
                                    :value="Number(ingredient.ingredient_proportions).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2})">
                                <!-- {{ Number(transferInvItemLine.transaction_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) }} -->
                        </td>
                        <td :title="ingredient.uom" class="text-right">
                            <!-- <input class="form-control text-right" type="number"
                                @change="changeQuantityUsed(ingredient, i)"
                                v-model.number="ingredient.quantity_used"/> -->
                            <vue-numeric :disabled="!ingredient.inventory_item_id || !header.can.edit"
                                separator=","
                                v-bind:precision="3"
                                v-bind:minus="false"
                                class="form-control text-right font-weight-bold text-navy"
                                v-model="ingredient.quantity_used"
                                @change="changeQuantityUsed(ingredient, i)"
                                ></vue-numeric>
                        </td>
                        <td class="text-center align-middle">
                            <button  :class="transBtn.delete.class + ' btn-xs mb-0 btn-outline'"
                                :disabled="!header.can.edit"
                                @click.prevent="ingredient.is_deleted = true">
                                <i :class="transBtn.delete.icon"></i>
                            </button>
                        </td>
                    </tr>
                </transition>
                </template>
                <tr>
                    <th :colspan="header.can.leaf_formulas.ingredient.add_lot_number ?  3 : 2" class="text-right">
                        รวม
                    </th>
                    <th class="text-right">{{ totalIngredientProp | number2Digit}}</th>
                    <th class="text-right font-weight-bold tw-text-base text-navy">{{ totalQuantityUsed | number2Digit}}</th>
                    <th></th>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>

import VueNumeric from 'vue-numeric'

export default {
    props:[
        "header", "leaf", "leafProportion", 'url', 'transBtn', 'transDate', 'pRefresh', 'data'
    ],
    computed: {
        ingredientsCount() {
            if (this.ingredients && this.ingredients.length) {
                let total = this.ingredients.filter(o => o.is_deleted == false);
                return parseFloat(total.length);
            }
            return 0;
        },
        totalIngredientProp() {
            let vm = this;
            let total = 0;
            vm.ingredients.forEach((o, i) => {
                if (o.is_deleted == false) {
                    total = parseFloat(total) + parseFloat(o.ingredient_proportions);
                }
            });

            return parseFloat(total);
        },
        totalQuantityUsed() {
            let vm = this;
            let total = 0;
            vm.ingredients.forEach((o, i) => {
                if (o.is_deleted == false) {
                    total = parseFloat(total) + parseFloat(o.quantity_used);
                }
            });
            vm.totalQuantityUsedValue = parseFloat(total);

            return vm.totalQuantityUsedValue;
        }
    },
    watch:{
        leafProportion: async function (newVal, oldVal) {
            if (this.ingredients && this.ingredients.length) {
                // this.changeIngredientProportions([]);
            }
        },
        ingredients:  async function (val, oldVal) {
            console.log('watch ingredients:  emit => syncIngredients')
            this.$emit("syncIngredients", val);
        },
        'header.quantity': function (val) {
            // console.log('watch header.quantity', val)
            this.reCalIngredientProportion();
        },
        'header.can.leaf_formulas.ingredient.add_lot_number': function (val) {
            let vm = this;
            if (!val) {
                vm.ingredients.forEach((o, i) => {
                    if (o.is_deleted == false) {
                        o.lot_number = ''
                    }
                });
            }
        },
    },
    data() {
        return {
            loading: false,
            leafFormulaProportion: this.leaf.leaf_proportion,
            ingredients: this.leaf.leaf_dtl,
            totalQuantityUsedValue: 0,
        }
    },
    mounted() {
        console.log('LeafIngredient: Component mounted.')
        // this.addNewLine();
    },
    methods: {
        async clickSelcet(ingredient, i, type) {
            let vm = this;
            let remoteMethodRes = new Promise(async (resolve, reject) => {
                ingredient.is_edit_item = true
                ingredient.loading = true;
                await vm.remoteMethod(' ', ingredient, type)
                ingredient.loading = false;
                vm.$nextTick(() => {
                    const input = vm.$refs[type + '_' + i][0];
                    input.focus();
                });
                resolve(true);
            });
            let resultRemoteMethod = await remoteMethodRes;

        },
        async addNewLine() {
            let vm = this;
            let row = vm.ingredients.length;
            let newLine = await _.clone(vm.data.ingredient_new_line);
            vm.$set(vm.ingredients, row, newLine);

            // vm.remoteMethod(' ', newLine, 'item_list')
            vm.changeIngredientProportions(newLine, false)
        },
        async deleteAll() {
            let vm = this;
            vm.ingredients.forEach(async function(ingredient, index) {
                ingredient.is_deleted = true;
            })
        },
        async selectInventoryItemId(ingredient) {
            let item = ingredient.item_list.findIndex(o => o.value == ingredient.inventory_item_id);
                item =  ingredient.item_list[item];
                ingredient.item_code = item.item_number
                ingredient.item_desc = item.item_desc
                ingredient.validate_lot = item.validate_lot
                ingredient.lot_number = '';

                this.remoteMethod(' ', ingredient, 'lot_list');
        },
        async selectLotNumber(ingredient, index) {
            let vm = this;
            vm.ingredients.forEach(async (o, i) => {
                if (o.is_deleted == false && index != i) {
                    if (o.inventory_item_id == ingredient.inventory_item_id &&
                        o.lot_number == ingredient.lot_number) {
                        ingredient.lot_number = '';
                    }
                }
            })
        },
        async changeIngredientProportions(ingredient, resetData = true) {
            let vm = this;
            if (resetData) {
                if (vm.ingredients.length) {
                    vm.ingredients.forEach(async function(ingredient, index) {
                        await vm.changeIngredientProportions(ingredient, false);
                    })
                }
            } else {
                let val = 0
                let leafFormulaProportion = parseFloat(vm.leafProportion);
                let ingredientProportions = parseFloat(ingredient.ingredient_proportions);

                // console.log('xxx', leafFormulaProportion, '--', ingredientProportions)
                if (parseFloat(leafFormulaProportion) && parseFloat(ingredientProportions)) {
                    val = (100 * (leafFormulaProportion / 100) * (ingredientProportions / 100) )
                    val = parseFloat(val);
                }
                console.log('else', ingredient);
                ingredient.quantity_used = val;
            }
        },
        async changeQuantityUsed(ingredient, i) {
            let vm = this;
            let val = parseFloat(ingredient.quantity_used ? ingredient.quantity_used : 0);
                val = (val < 0) ? 0 : val;

            ingredient.quantity_used = val;
            // ingredient.ingredient_proportions = await vm.calIngredientProportion(ingredient);
            vm.reCalIngredientProportion();
        },
        async reCalIngredientProportion() {
            console.log('reCalIngredientProportion');
            let vm = this;
            vm.ingredients.forEach(async function(ingredient, index) {
                if (ingredient.is_deleted == false) {
                    ingredient.ingredient_proportions = await vm.calIngredientProportion(ingredient);
                }
            })
            this.$emit("syncIngredients", vm.ingredients);
        },
        async calIngredientProportion(ingredient) {
            let vm = this;
            let value = (ingredient.quantity_used / vm.totalQuantityUsedValue) * 100;

            // console.log('calIngredientProportion'
            //     , 'totalQuantityUsedValue ->', vm.totalQuantityUsedValue
            //     , 'quantity_used ->', ingredient.quantity_used
            //     , value
            // );
            return parseFloat(value ? value : 0 ).toFixed(5) * 1;
        },
        async remoteMethod(query, ingredient, inputName) {
            ingredient[inputName] = [];
            let vm = this;

            let line = _.clone(ingredient);
                line.item_list = [];
            if (query !== "") {
                await this.getData({
                    header: vm.header,
                    number: query,
                    line: line,
                    type: inputName
                }, ingredient, inputName);
            }
        },
        async getData(params, ingredient, inputName) {
            let vm = this;
            vm.loading = true;
            await axios.get(vm.url.ajax_get_data, { params }).then(res => {
                let response = res.data.data
                vm.loading = false;
                ingredient[inputName] = response[inputName];
            });
        }
    }
}
</script>