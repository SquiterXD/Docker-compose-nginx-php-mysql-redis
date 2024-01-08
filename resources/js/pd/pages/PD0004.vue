<!--suppress HtmlUnknownTag -->
<template>
    <div id="PD0004">
        <div class="container-fluid">
            <!-- Button-->
            <div class="row d-flex justify-content-end mb-3">
                <div class="col-lg-10">
                    <div class="float-right">
                        <!--Create-->
                        <button type="button"
                                :class="btn_trans.create.class"
                                @click.prevent="onCreateButtonClicked">
                            <i :class="btn_trans.create.icon"></i>
                            {{ btn_trans.create.text }}
                        </button>
                        <!--Search-->
                        <button type="button"
                                :class="btn_trans.search.class"
                                data-toggle="modal"
                                data-target="#rawMaterialSearchModal"><i
                            :class="btn_trans.search.icon"></i>
                            {{ btn_trans.search.text }}
                        </button>
                        <!--Save-->
                        <button type="button"
                                :class="btn_trans.save.class"
                                @click.prevent="onSaveButtonClicked">
                            <i :class="btn_trans.save.icon"></i>
                            {{ btn_trans.save.text }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <div class="row align-items-center">
                                <div class="col-sm-12 col-lg-2 align-middle">
                                    <h5>สร้างรหัสวัตถุดิบ - ยาเส้น</h5>
                                </div>
                            </div>
                        </div>
                        <!-- Main form -->
                        <div class="ibox-content">
                            <div class="form-group row">
                                <label
                                    class="col-md-2 col-form-label">
                                    ประเภทวัตถุดิบ <span style="color: red;">*</span>
                                </label>
                                <div class="col-md-3">
                                    <!--ประเภทวัตถุดิบ-->
                                    <el-select
                                        id="raw_material_type"
                                        placeholder="กรุณาเลือกประเภทวัตถุดิบ"
                                        value-key="description"
                                        :value="this.form.raw_material_type"
                                        :disabled="!isCreateNew"
                                        filterable
                                        @change="(item)=>{
                                        console.debug(item, item.description)
                                            this.hasDataChange = true
                                            preventUnload()

                                            this.form.raw_material_type_code = item.flex_value_meaning
                                            this.form.raw_material_type = item.description
                                        }">
                                        <el-option
                                            v-for="item in rawMaterialTypeList"
                                            :key="item.flex_value_meaning"
                                            :label="item.description"
                                            :value="item">
                                        </el-option>
                                    </el-select>
                                </div>
                                <div class="col-md-1"></div>
                                <label
                                    class="col-md-2 col-form-label">
                                    Blend No. <span style="color: red;">*</span>
                                </label>
                                <div class="col-md-3">
                                    <!--Blend No.-->
                                    <input
                                        id="input-blend-no"
                                        type="text"
                                        class="form-control"
                                        :value="this.form.blend_no"
                                        :maxlength="maxBlendNoDigit"
                                        :disabled="!isCreateNew"
                                        @input="(event) => {
                                                    form.blend_no = event.target.value
                                                    this.form = {...form}
                                                }"
                                        @change="() => {
                                            preventUnload()
                                            this.hasDataChange = true
                                        }"
                                    />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    class="col-md-2 col-form-label">
                                    รหัสสินค้า
                                </label>
                                <div class="col-md-3">
                                    <!--รหัสสินค้า-->
                                    <input
                                        id="input-inv-item-code"
                                        type="text"
                                        class="form-control"
                                        :disabled="true"
                                        @change="() => {
                                            preventUnload()
                                            this.hasDataChange = true
                                        }"
                                        v-model="this.form.inventory_item_code"
                                        @input="(event) => {
                                                    this.hasDataChange = true
                                                    preventUnload()
                                                }"
                                    />
                                </div>
                            </div>
                            <div class="form-group row">
                                <label
                                    class="col-md-2 col-form-label">
                                    รายละเอียด
                                </label>
                                <div class="col-md-3">
                                    <!--รายละเอียด-->
                                    <input
                                        id="input-inv-item-description"
                                        type="text"
                                        class="form-control"
                                        :value="this.form.description"
                                        @change="() => {
                                            preventUnload()
                                            this.hasDataChange = true
                                        }"
                                        @input="(event) => {
                                                    form.description = event.target.value
                                                    this.form = {...form}
                                                    this.hasDataChange = true
                                                    preventUnload()
                                                }"/>

                                </div>
                            </div>
                            <div class="form-group row">
                            </div>
                            <div class="form-group row">
                                <!--                            <label-->
                                <!--                                class="col-sm-2 col-form-label"-->
                                <!--                                for="input-product-description">-->
                                <!--                                รายละเอียด&nbsp;<span style="color:red">*</span>-->
                                <!--                            </label>-->
                                <!--                            <div class="col-sm-10">-->
                                <!--                                <input-->
                                <!--                                    id="input-product-description"-->
                                <!--                                    type="text"-->
                                <!--                                    class="form-group"-->
                                <!--                                    v-model="exampleCigaretteModel.description"-->
                                <!--                                />-->
                                <!--                            </div>-->
                            </div>
                        </div>

                        <!-- search modal-->
                        <div>
                            <div
                                id="rawMaterialSearchModal"
                                ref="rawMaterialSearchModalRef"
                                class="modal fade">
                                <div
                                    class="modal-dialog"
                                    role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">ค้นหา</h5>
                                            <button
                                                type="button"
                                                class="close"
                                                data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form>
                                                <div class="form-group row">
                                                    <label
                                                        class="col-md-3 col-form-label">
                                                        ประเภทวัตถุดิบ
                                                    </label>

                                                    <div class="col-md-9">
                                                        <el-select
                                                            id="search_raw_material_type"
                                                            placeholder="กรุณาเลือกประเภทวัตถุดิบ"
                                                            class="col-md-12"
                                                            value-key="description"
                                                            :value="searchModel.rawMaterialType"
                                                            filterable
                                                            @change="(item)=>{
                                                                console.debug(item, item.description)
                                                                this.searchModel.rawMaterialTypeCode = item.flex_value_meaning
                                                                this.searchModel.rawMaterialType = item.description
                                                            onSelectedRawMaterialType()
                                                            }">
                                                            <el-option
                                                                v-for="item in rawMaterialTypeList"
                                                                :key="item.flex_value_meaning"
                                                                :label="item.description"
                                                                :value="item">
                                                            </el-option>

                                                        </el-select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label
                                                        class="col-md-3 col-form-label">
                                                        รหัสสินค้า
                                                    </label>
                                                    <div class="col-md-9">
                                                        <el-select
                                                            class="col-md-12"
                                                            v-model="searchModel.inventoryItemCode"
                                                            clearable
                                                            filterable
                                                            placeholder="เลือกรหัสสินค้า"
                                                            :loading="loading">
                                                            <el-option
                                                                v-for="item in this.inventoryItemCodeList"
                                                                :key="item.inventory_item_code"
                                                                :label="item.inventory_item_code"
                                                                :value="item.inventory_item_code"></el-option>
                                                        </el-select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">

                                                    <label
                                                        class="col-md-3 col-form-label">
                                                        รายละเอียด
                                                    </label>
                                                    <div class="col-md-9">
                                                        <el-select
                                                            class="col-md-12"
                                                            v-model="searchModel.description"
                                                            clearable
                                                            filterable
                                                            placeholder="เลือกรายละเอียด"
                                                            :loading="loading">
                                                            <el-option
                                                                v-for="item in this.descList"
                                                                :key="item.description"
                                                                :label="item.description"
                                                                :value="item.description"></el-option>
                                                        </el-select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-12">
                                                        <div class="float-right pr-3">
                                                            <!--ปุ่มล้างค่า-->
                                                            <button type="button"
                                                                    :class="btn_trans.reset.class"
                                                                    @click.prevent="resetSearchForm()">
                                                                <i :class="btn_trans.reset.icon"></i>
                                                                {{ btn_trans.reset.text }}
                                                            </button>
                                                            <!--ปุ่มค้นหา-->
                                                            <button type="button"
                                                                    :class="btn_trans.search.class"
                                                                    @click.prevent="submitSearchForm()">
                                                                <i :class="btn_trans.search.icon"></i>
                                                                {{ btn_trans.search.text }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="sk-spinner sk-spinner-wave mb-4"
                                                     v-if="isSearching">
                                                    <div class="sk-rect1"></div>
                                                    <div class="sk-rect2"></div>
                                                    <div class="sk-rect3"></div>
                                                    <div class="sk-rect4"></div>
                                                    <div class="sk-rect5"></div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="col-lg-12">
                                                        <div>
                                                            <div class="ibox-content">
                                                                <div style="height: 300px; overflow-y: scroll;">
                                                                    <table class="table">
                                                                        <thead>
                                                                        <tr>
                                                                            <th>รหัสสินค้า</th>
                                                                            <th>รายละเอียด</th>
                                                                            <th>ประเภทวัตถุดิบ</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr v-for="item in searchResultItems"
                                                                            :key="item.raw_material_id"
                                                                            style="cursor: pointer"
                                                                            @click="onClickItem(item.inventory_item_id)">
                                                                            <td>{{ item.inventory_item_code }}</td>
                                                                            <td>{{ item.description }}</td>
                                                                            <td>{{ item.raw_material_type }}</td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--End Modal-->
                        </div>

                    </div>
                </div>
            </div>
            <!--            <div class="form-group row">-->
            <!--                <pre class="col-lg-4" style="display: block">{{-->
            <!--                        JSON.stringify({-->
            <!--                            isCreateNew,-->
            <!--                            hasDataChange,-->
            <!--                            form,-->
            <!--                            itemCatCode,-->
            <!--                            existedItemsOnSelectedType,-->
            <!--                        }, null, 2)-->
            <!--                    }}-->
            <!--                </pre>-->
            <!--                <pre class="col-lg-4" style="display: block">{{-->
            <!--                        JSON.stringify({-->
            <!--                            searchModel,-->
            <!--                            searchResultItems,-->
            <!--                            rawMaterialTypeList,-->
            <!--                            descList,-->
            <!--                        }, null, 2)-->
            <!--                    }}-->
            <!--                </pre>-->

            <!--                <pre class="col-lg-4" style="display: block">{{-->
            <!--                        JSON.stringify({-->
            <!--                            inventoryItemCodeList,-->
            <!--                            existedItems,-->
            <!--                        }, null, 2)-->
            <!--                    }}-->
            <!--                </pre>-->
            <!--            </div>-->
        </div>
    </div>
</template>

<!--suppress JSUnresolvedVariable -->
<script>
import {instance as http} from "../httpClient";
import _get from 'lodash/get';
import _isEqual from 'lodash/isEqual';
import _cloneDeep from 'lodash/cloneDeep';
import {
    showSimpleConfirmationDialog,
    showLoadingDialog,
    showSaveSuccessDialog,
    showValidationFailedDialog,
    showGenericFailureDialog,
} from "../../commonDialogs";
import {preventUnload, cancelPreventUnload} from '../../utils'
import {
    $route,
    pd_invMaterialItems_index,
    pd_invMaterialItems_show,
    api_pd_invMaterialItem_store,
    api_pd_invMaterialItem_update,

} from "../../router";

function goToIndex() {
    console.debug('goToIndex');
    window.location = $route(pd_invMaterialItems_index);
}

function redirectTo(inventoryItemId) {
    window.location = $route(pd_invMaterialItems_show, {
        inventoryItemId: inventoryItemId,
    });
}

function createRawMaterialItem(createRawMaterialItem) {
    console.debug('createRawMaterialItem', createRawMaterialItem);

    return http.post($route(api_pd_invMaterialItem_store),
        {
            'inv_material_item': createRawMaterialItem,
        });
}

function updateRawMaterialItem(updateRawMaterialItem) {
    console.debug('updateRawMaterialItem', updateRawMaterialItem);

    // noinspection JSUnresolvedVariable
    return http.put($route(api_pd_invMaterialItem_update,
        {
            rawMaterialId: updateRawMaterialItem.raw_material_id,
        }),
        {
            'inv_material_item': updateRawMaterialItem,
        });
}

function searchRawMaterialItem(inventoryItemCode, description, rawMaterialTypeCode) {
    console.debug('searchRawMaterialItem', inventoryItemCode, description, rawMaterialTypeCode);
    let searchParams = {};
    if (inventoryItemCode) {
        searchParams.inventory_item_code = inventoryItemCode;
    }
    if (description) {
        searchParams.description = description;
    }
    if (rawMaterialTypeCode) {
        searchParams.raw_material_type_code = rawMaterialTypeCode;
    }

    let route = $route(api_pd_invMaterialItem_search) + '?' +
        (new URLSearchParams(searchParams).toString());

    return http.get(route);
}

// noinspection ES6MissingAwait
export default {
    props: {
        existed_items: {type: Array},
        existed_items_in_oracle: {type: Array},
        inv_material_item: {type: Object,},
        raw_material_type_list: {type: Array},
        is_create_new: {
            type: Boolean,
            default: false,
        },
        btn_trans: {type: Object},
    },
    data() {
        return {
            console,
            lodash: {
                get: _get,
                isEqual: _isEqual,
                cloneDeep: _cloneDeep,
            },
            preventUnload,

            invMaterialItemModel: _cloneDeep(this.inv_material_item),
            rawMaterialTypeList: _cloneDeep(this.raw_material_type_list),

            isSearching: false,
            searchModel: {
                rawMaterialTypeCode: '',
                rawMaterialType: '',
                inventoryItemCode: '',
                description: '',
            },
            searchResults: [],
            itemCatCode: '',

            form: {
                raw_material_id: _get(this.inv_material_item, 'raw_material_id'),
                inventory_item_code: _get(this.inv_material_item, 'inventory_item_code'),
                raw_material_type_code: _get(this.inv_material_item, 'raw_material_type_code'),
                raw_material_type: _get(this.inv_material_item, 'raw_material_type'),
                blend_no: _get(this.inv_material_item, 'blend_no'),
                description: _get(this.inv_material_item, 'description'),
            },

            existedItems: this.existed_items,
            existedItemsOnSelectedType: [],
            existedItemsInOracle: [],
            searchResultItems: this.existed_items,
            dataInventoryItemCodeList: [],
            dataDescList: [],
            inventoryItemCodeList: [],
            descList: [],

            isCreateNew: _cloneDeep(this.is_create_new),
            loading: false,
            hasDataChange: false,

            maxBlendNoDigit: 5,
        }
    },
    mounted() {
        this.existedItemsInOracle = this.existed_items_in_oracle

        this.existedItems.forEach(existedItem => {
            let isExistsInventoryItemCodeList = this.dataInventoryItemCodeList.some(item => item.inventory_item_code === existedItem.inventory_item_code)
            if (!isExistsInventoryItemCodeList) {
                this.dataInventoryItemCodeList.push({
                    raw_material_type_code: existedItem.raw_material_type_code,
                    inventory_item_code: existedItem.inventory_item_code,
                })
            }

            let isExistsDescList = this.dataDescList.some(item => item.description === existedItem.description)
            if (!isExistsDescList) {
                this.dataDescList.push({
                    raw_material_type_code: existedItem.raw_material_type_code,
                    description: existedItem.description,
                })
            }
        })
        this.inventoryItemCodeList = this.dataInventoryItemCodeList.sort()
        this.descList = this.dataDescList.sort()
    },
    watch: {
        'form.raw_material_type_code': function (val) {
            console.log('val', val)
            this.itemCatCode = '10' + val;
            this.existedItemsOnSelectedType = this.existedItems.filter(existedItem => existedItem.raw_material_type_code === val)

            this.form.inventory_item_code = ""
            if (this.form.blend_no !== null) {
                this.form.inventory_item_code += "10" + val + this.form.blend_no
            }
        },
        'form.blend_no': function (val) {
            console.log('val', val)

            this.form.inventory_item_code = ""

            if (this.form.raw_material_type_code !== null) {
                this.form.inventory_item_code += "10" + this.form.raw_material_type_code + val
            }
        },
    },
    computed: {},
    methods: {
        onSelectedRawMaterialType() {
            let selectedRawMaterialTypeCode = this.searchModel.rawMaterialTypeCode
            this.inventoryItemCodeList = this.dataInventoryItemCodeList
            this.descList = this.dataDescList

            //filter inventory item code list in search modal
            this.inventoryItemCodeList =
                this.inventoryItemCodeList.filter(item => item.raw_material_type_code === selectedRawMaterialTypeCode)
            //filter description list in search modal
            this.descList =
                this.descList.filter(item => item.raw_material_type_code === selectedRawMaterialTypeCode)
        },
        resetSearchForm() {
            this.searchModel.rawMaterialTypeCode = ''
            this.searchModel.rawMaterialType = ''
            this.searchModel.inventoryItemCode = ''
            this.searchModel.description = ''
            this.existedItems = this.existed_items
            this.searchResultItems = this.existedItems
            this.inventoryItemCodeList = this.dataInventoryItemCodeList
            this.descList = this.dataDescList
        },
        submitSearchForm() {
            console.log('submitSearchForm', this.searchModel)

            this.searchResultItems = this.filterByRawMaterialTypeCode(this.filterByInventoryItemCode(this.filterByDescription((this.existedItems))))

            console.log('searchResultItemAfter', this.searchResultItems)
        },
        filterByRawMaterialTypeCode(existedItems) {
            console.log('filterByTypeCode', this.searchModel.rawMaterialTypeCode)

            if (!this.searchModel.rawMaterialTypeCode && this.searchModel.rawMaterialTypeCode === '') return existedItems
            return existedItems.filter(item => item.raw_material_type_code === this.searchModel.rawMaterialTypeCode.toString())
        },
        filterByInventoryItemCode(existedItems) {
            if (!this.searchModel.inventoryItemCode && this.searchModel.inventoryItemCode === '') return existedItems
            return existedItems.filter(item => item.inventory_item_code === this.searchModel.inventoryItemCode)
        },
        filterByDescription(existedItems) {
            if (!this.searchModel.description && this.searchModel.description === '') return existedItems
            return existedItems.filter(item => item.description === this.searchModel.description)
        },
        async onClickItem(rawMaterialId) {
            if (this.hasDataChange && !await showSimpleConfirmationDialog('มีการเปลี่ยนแปลงข้อมูลโดยที่ยังไม่ได้บันทึก ต้องการออกจากหน้านี้?')) return

            showLoadingDialog()
            cancelPreventUnload()

            redirectTo(rawMaterialId);
        },
        async onCreateButtonClicked() {
            console.debug('onCreateButtonClicked');
            if (this.hasDataChange && !await showSimpleConfirmationDialog('มีการเปลี่ยนแปลงข้อมูลโดยที่ยังไม่ได้บันทึก ต้องการออกจากหน้านี้?')) return

            cancelPreventUnload()
            goToIndex();
        },
        async onSaveButtonClicked() {
            console.debug('onSaveButtonClicked');

            if (!this.validate()) {
                return;
            }

            showLoadingDialog();

            if (!this.isCreateNew) {
                // update existing data
                console.log('updated', this.form)

                updateRawMaterialItem(this.form)
                    .then(({data}) => {
                        console.debug('updateRawMaterialItem(update) success', data);
                        this.setNewData(data)
                        this.hasDataChange = false
                        cancelPreventUnload()
                    })
                    .then(() => {
                        return showSaveSuccessDialog();
                    })
                    .catch(err => {
                        console.debug('updateRawMaterialItem(update) error', err);
                        return showGenericFailureDialog(err.toString());
                    });

            } else {
                console.log('created', this.form)
                createRawMaterialItem(this.form)
                    .then(({data}) => {
                        console.debug('createRawMaterialItem(create) success', data);
                        this.hasDataChange = false
                        cancelPreventUnload()

                        showSaveSuccessDialog()
                            .then(() => {
                                let inventoryItemId = _get(data, 'inv_material_item.inventory_item_id', null);

                                console.log('success_with_inventory_item_id', inventoryItemId)

                                if (inventoryItemId !== null && inventoryItemId !== "") {

                                    console.log('redirect_to_inventory_item_id')

                                    redirectTo(inventoryItemId);
                                } else {
                                    console.log('goToIndex')

                                }
                            })
                    })
                    .catch((err) => {
                        console.debug('createRawMaterialItem(create) error', err);
                        showGenericFailureDialog(_get(err, 'response.data.v_err_msg', null));
                    });
            }
        },
        validate() {
            let errors = []

            if (!this.form.raw_material_type_code) {
                errors.push('ประเภทวัตถุดิบ')
            }

            if (!this.form.blend_no) {
                errors.push('Blend No.')
            } else {
                let items = this.existedItemsOnSelectedType.filter(item => item.blend_no === this.form.blend_no)
                let itemsInOracle = this.existed_items_in_oracle.filter(item => item.item_number === this.form.inventory_item_code)

                if (this.form.raw_material_id === null && (items.length > 0 || itemsInOracle.length > 0)) {
                    errors.push('ไม่สามารถบันทึกข้อมูลได้ เนื่องจาก Blend No. ซ้ำ')
                }
            }

            if (errors.length > 0) {
                showValidationFailedDialog(errors)
                return false
            }
            return true
        },
        setNewData(newData) {
            if (newData.existed_items) {
                this.existedItems = newData.existed_items
                this.searchResultItems = newData.existed_items
            }
            if (newData.inv_material_item) {
                this.invMaterialItemModel = newData.inv_material_item;
            }

            this.dataDescList = [];
            this.descList = [];

            this.existedItems.forEach(existedItem => {

                let isExistsDescList = this.dataDescList.some(item => item.description === existedItem.description)
                if (!isExistsDescList) {
                    this.dataDescList.push({
                        raw_material_type_code: existedItem.raw_material_type_code,
                        description: existedItem.description,
                    })
                }
            })
            this.descList = this.dataDescList.sort();
        }
    }
}
</script>

<style>
.el-autocomplete-suggestion {
    z-index: 3000 !important;
}

#PD0004 .el-select {
    width: 100%;
}


</style>
