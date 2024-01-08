<template>
    <div class="container-fluid">
        <!-- Button-->
        <div class="row d-flex justify-content-end mb-3">
            <div class="col-lg-10">
                <div class="float-right">

                    <button type="button"
                            :class="btn_trans.create.class"
                            @click.prevent="onCreateButtonClicked">
                        <i :class="btn_trans.create.icon"></i>
                        {{ btn_trans.create.text }}
                    </button>
                    <button type="button"
                            :class="btn_trans.search.class"
                            data-toggle="modal"
                            data-target="#exampleCigaretteSearchModal"><i
                        :class="btn_trans.search.icon"></i>
                        {{ btn_trans.search.text }}
                    </button>
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
                                <h5>สร้างรหัสบุหรี่ทดลอง</h5>
                            </div>
                        </div>
                    </div>


                    <!-- Main form -->
                    <div class="ibox-content">
                        <div class="form-group row">
                            <label
                                class="col-sm-2 col-form-label"
                                for="input-product-id">
                                รหัสสินค้า
                            </label>
                            <div class="col-sm-10">
                                <input
                                    id="input-product-id"
                                    type="text"
                                    class="form-group"
                                    :disabled="true"
                                    :value="lodash.get(exampleCigaretteModel, 'inventory_item_code')"
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label
                                class="col-sm-2 col-form-label"
                                for="input-product-description">
                                รายละเอียด&nbsp;<span style="color:red">*</span>
                            </label>
                            <div class="col-sm-10">
                                <input
                                    id="input-product-description"
                                    type="text"
                                    class="form-group"
                                    v-model="exampleCigaretteModel.description"
                                />
                            </div>
                        </div>
                    </div>

                    <!--Modal-->
                    <div
                        id="exampleCigaretteSearchModal"
                        ref="exampleCigaretteSearchModalRef"
                        class="modal fade">
                        <div
                            class="modal-dialog"
                            role="document">
                            <div class="modal-content">
                                <div class="modal-header">
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

                                            <div class="col-sm-3">
                                                <label
                                                    class="col-sm col-form-label"
                                                    for="input-product-description">
                                                    รหัสสินค้า
                                                </label>
                                            </div>
                                            <div class="col-sm-9">
                                                <!--suppress HtmlFormInputWithoutLabel -->
                                                <el-autocomplete
                                                    class="inline-input col-sm-12"
                                                    v-model="searchModel.inventoryItemCode"
                                                    placeholder="กรุณาใส่รหัสสินค้า"
                                                    :fetch-suggestions="autoCompleteInventoryItemCode"
                                                    :trigger-on-focus="false"
                                                    @select="(value)=>{
                                                    console.debug('autocomplete', value)
                                                }"
                                                />
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-3">
                                                <label
                                                    class="col-sm col-form-label"
                                                    for="input-product-description">
                                                    รายละเอียด
                                                </label>
                                            </div>
                                            <div class="col-sm-9">
                                                <el-autocomplete
                                                    class="inline-input col-sm-12"
                                                    v-model="searchModel.description"
                                                    placeholder="กรุณาใส่รายละเอียด"
                                                    :fetch-suggestions="autoCompleteDescription"
                                                    :trigger-on-focus="false"/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-12">
                                                <div class="float-right pr-3">
                                                    <!--ปุ่มล้างค่า-->
                                                    <button type="button"
                                                            :class="btn_trans.reset.class"
                                                            @click.prevent="onClearTextClicked()">
                                                        <i :class="btn_trans.reset.icon"></i>
                                                        {{ btn_trans.reset.text }}
                                                    </button>
                                                    <!--ปุ่มค้นหา-->
                                                    <button type="button"
                                                            :class="btn_trans.search.class"
                                                            @click.prevent="onSearchButtonClicked()">
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
                                                <div
                                                    v-if="searchResults.length > 0 && !isSearching"
                                                    class="ibox">

                                                    <div class="ibox-content">
                                                        <table
                                                            class="table table-bordered text-center"
                                                            id="DataTables">
                                                            <thead>
                                                            <tr>
                                                                <td><strong>รหัสสินค้า</strong></td>
                                                                <td><strong>รายละเอียด</strong></td>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <!--suppress JSUnresolvedVariable -->
                                                            <tr v-for="exampleCigarette in searchResults"
                                                                v-bind:key="exampleCigarette.raw_material_id"
                                                                class="highlightable-tr"
                                                                @click="onSearchResultClicked(exampleCigarette)">

                                                                <!--suppress JSUnresolvedVariable -->
                                                                <td>{{ exampleCigarette.inventory_item_code }}</td>
                                                                <td>{{ exampleCigarette.description }}</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
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
<!--                            exampleCigaretteModel,-->
<!--                        }, null, 2)-->
<!--                    }}-->
<!--                </pre>-->

<!--                <pre class="col-lg-4" style="display: block">{{-->
<!--                        JSON.stringify({-->
<!--                            searchModel,-->

<!--                        }, null, 2)-->
<!--                    }}-->
<!--                </pre>-->

<!--                <pre class="col-lg-4" style="display: block">{{-->
<!--                        JSON.stringify({-->
<!--                            searchResults,-->
<!--                        }, null, 2)-->
<!--                    }}-->
<!--                </pre>-->
<!--            </div>-->

</template>

<!--suppress JSUnresolvedVariable -->
<script>
import {instance as http} from "../httpClient";
import _get from 'lodash/get';
import _isEqual from 'lodash/isEqual';
import _cloneDeep from 'lodash/cloneDeep';
import {
    showProgressWithUnsavedChangesWarningDialog,
    showLoadingDialog,
    showSaveSuccessDialog,
    showValidationFailedDialog,
    showGenericFailureDialog,
} from "../../commonDialogs";
import {warningBeforeUnload} from "../../pm/helpers";
import {buildValidatingEntry, validateDataAgainstRules} from "../../validatorUtils";
import {
    $route,
    pd_exampleCigarettes_index,
    pd_exampleCigarettes_show,
    api_pd_exampleCigarettes_store,
    api_pd_exampleCigarettes_update,
    api_pd_exampleCigarettes_search,

} from "../../router";

function goToIndex() {
    console.debug('goToIndex');
    window.location = $route(pd_exampleCigarettes_index);
}

function redirectTo(inventoryItemCode) {
    console.debug('redirectTo', inventoryItemCode);
    window.location = $route(pd_exampleCigarettes_show, {
        inventoryItemCode: inventoryItemCode,
    });
}

function createExampleCigarette(exampleCigarette) {
    console.debug('createExampleCigarette', exampleCigarette);

    return http.post($route(api_pd_exampleCigarettes_store),
        {
            'exampleCigarette': exampleCigarette,
        });
}

function updateExampleCigarette(exampleCigarette) {
    console.debug('updateExampleCigarette', exampleCigarette);

    // noinspection JSUnresolvedVariable
    return http.put($route(api_pd_exampleCigarettes_update,
        {
            rawMaterialId: exampleCigarette.raw_material_id,
        }),
        {
            'example_cigarette': exampleCigarette,
        });
}

function searchExampleCigarette(inventoryItemCode, description) {
    console.debug('searchExampleCigarette', inventoryItemCode, description);
    let searchParams = {};
    if (inventoryItemCode) {
        searchParams.inventory_item_code = inventoryItemCode;
    }
    if (description) {
        searchParams.description = description;
    }

    let route = $route(api_pd_exampleCigarettes_search) + '?' +
        (new URLSearchParams(searchParams).toString());

    return http.get(route);
}

// noinspection ES6MissingAwait
export default {
    created() {
        this.saveDataStage();
    },
    mounted() {
        this.setWarningBeforeUnload();
    },
    data() {
        return {
            console,

            lodash: {
                get: _get,
                isEqual: _isEqual,
                cloneDeep: _cloneDeep,
            },

            exampleCigaretteModel: _cloneDeep(this.example_cigarette),

            isSearching: false,
            searchModel: {
                inventoryItemCode: '',
                description: '',
            },
            searchResults: [],

            // use for detect and alert unsaved data
            dataStage: {},
        }
    },
    props: {
        example_cigarette: {
            type: Object,
        },
        is_create_new: {
            type: Boolean,
            default: false,
        },
        btn_trans: {type: Object},
    },
    methods: {
        autoCompleteInventoryItemCode(query, callback) {
            console.debug('autoCompleteInventoryItemCode', query);
            searchExampleCigarette(query, null)
                .then(({data}) => {
                    let inventoryItemCodes = data.example_cigarettes.map((exampleCigarette) => {
                        return {value: exampleCigarette.inventory_item_code};
                    })
                    callback(inventoryItemCodes);
                })
                .catch(() => {
                    callback([]);
                });
        },
        autoCompleteDescription(query, callback) {
            console.debug('autoCompleteDescription', query);
            searchExampleCigarette(null, query)
                .then(({data}) => {
                    let descriptions = data.example_cigarettes.map((exampleCigarette) => {
                        return {value: exampleCigarette.description};
                    })
                    callback(descriptions);
                })
                .catch(() => {
                    callback([]);
                });
        },
        onCreateButtonClicked() {
            console.debug('onCreateButtonClicked');

            if (this.isDataStageChange()) {
                showProgressWithUnsavedChangesWarningDialog()
                    .then((isConfirmed) => {
                        this.clearWarningBeforeUnload();
                        if (isConfirmed) {
                            goToIndex();
                        }
                    });
            } else {
                goToIndex();
            }
        },
        async onSaveButtonClicked() {
            console.debug('onSaveButtonClicked');

            let validatingResult = await this.validate(this.exampleCigaretteModel)
            if (!validatingResult) {
                return;
            }

            showLoadingDialog();
            if (this.is_create_new) {
                createExampleCigarette(this.exampleCigaretteModel)
                    .then(({data}) => {
                        console.debug('createExampleCigarette(create) success', data);

                        showSaveSuccessDialog()
                            .then(() => {
                                let inventoryItemCode = _get(data, 'example_cigarette.inventory_item_code', null);
                                if (inventoryItemCode) {
                                    redirectTo(inventoryItemCode);
                                } else {
                                    goToIndex();
                                }
                            })
                    })
                    .catch((err) => {
                        console.debug('createExampleCigarette(create) error', err);
                        showGenericFailureDialog(_get(err, 'response.data.v_err_msg', null));
                    });

            } else {
                updateExampleCigarette(this.exampleCigaretteModel)
                    .then(({data}) => {
                        console.debug('createExampleCigarette(update) success', data);

                        this.exampleCigaretteModel = data.example_cigarette;
                        this.saveDataStage();
                    })
                    .then(() => {
                        return showSaveSuccessDialog();
                    })
                    .catch(err => {
                        console.debug('createExampleCigarette(update) error', err);
                        return showGenericFailureDialog(err.toString());
                    });
            }
        },
        onSearchButtonClicked() {
            console.debug('onSearchButtonClicked', this.searchModel);

            this.isSearching = true;
            searchExampleCigarette(this.searchModel.inventoryItemCode, this.searchModel.description)
                .then(({data}) => {
                    console.debug('onSearchButtonClicked success', data);

                    this.isSearching = false;
                    this.searchResults = data.example_cigarettes;
                })
                .catch((err) => {
                    console.debug('onSearchButtonClicked error', err);

                    this.isSearching = false;
                    showGenericFailureDialog();
                });
        },
        onClearTextClicked() {
            this.searchModel = {}
        },
        onSearchResultClicked(exampleCigarette) {
            this.$refs['exampleCigaretteSearchModalRef'].click();
            redirectTo(exampleCigarette.inventory_item_code);
        },
        async validate(exampleCigarette) {
            let rules = {
                description: 'required',
            }
            let lineAttributesNames = {
                description: 'รายละเอียด',
            };

            let validatingEntries = [];
            validatingEntries.push(buildValidatingEntry(exampleCigarette, rules, lineAttributesNames));
            let validatingResult = validateDataAgainstRules(validatingEntries);
            if (validatingResult.status) {
                return true;
            }

            // noinspection ES6MissingAwait
            showValidationFailedDialog(validatingResult.errorMessages);
            return false;
        },
        saveDataStage() {
            this.dataStage = this.lodash.cloneDeep(this.exCigarette);
        },
        isDataStageChange() {
            console.debug('isDataStageChange', this.dataStage, this.exCigarette);

            let isEqual = this.lodash.isEqual(this.dataStage, this.exCigarette);
            console.debug(isEqual);

            //warning user if there is unsaved data
            return !isEqual;
        },
        setWarningBeforeUnload() {
            warningBeforeUnload(() => {
                return this.isDataStageChange();
            });
        },
        clearWarningBeforeUnload() {
            window.onbeforeunload = null;
        },
    }
}
</script>

<style>
.el-autocomplete-suggestion {
    z-index: 3000 !important;
}
</style>
