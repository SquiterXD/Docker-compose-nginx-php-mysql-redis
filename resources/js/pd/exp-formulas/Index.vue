<template>
    <transition
    enter-active-class="animated fadeIn"
    leave-active-class="animated fadeOut">
    <div v-if="!loading.before_mount">
        <modal-search @selectRow="show" :transDate="transDate"
            :header="header"
            :transBtn="transBtn" :url="url"
            :countOpen="countOpenModal" />


        <div class="ibox float-e-margins" >
            <div class="ibox-content pb-1" style="border-bottom: 0px;">
                <div class="row">
                    <div class="col-3">
                        <!-- <h3 class="no-margins"> การขอเบิกวัตถุดิบนอกแผน </h3> -->
                    </div>
                    <div class="col-9 text-right">
                        <button :class="transBtn.create.class + ' btn-lg tw-w-25'"
                            @click.prevent="getInfo()" >
                            <i :class="transBtn.create.icon"></i>
                            {{ transBtn.create.text }}
                        </button>

                        <button :class="transBtn.search.class + ' btn-lg tw-w-25 mr-2'"
                            @click.prevent="countOpenModal += 1" >
                            <i :class="transBtn.search.icon"></i>
                            {{ transBtn.search.text }}
                        </button>

                        <button  type="button" :class="transBtn.save.class + ' btn-lg tw-w-25'" @click.prevent="save()">
                            <i :class="transBtn.save.icon"></i>
                            {{ transBtn.save.text }}
                        </button>

                        <button  type="button" :class="transBtn.copy.class + ' btn-lg tw-w-25'" >
                            <i :class="transBtn.copy.icon"></i>
                            {{ transBtn.copy.text }}สูตร
                        </button>
                        <button class="btn btn-default" data-toggle="modal" data-target="#historyModal"><i class="fa fa-file-text-o"></i> ประวัติแก้ไข</button>

                        <!-- <button :class="transBtn.save.class + ' btn-lg tw-w-25'"
                            :disabled="!header.can.save"
                            @click.prevent="save">
                            <i :class="transBtn.save.icon"></i>
                            {{ transBtn.save.text }}
                        </button>


                        <button
                            class="btn btn-primary btn-lg"
                            :disabled="!header.can.transfer"
                            @click.prevent="setStatus('confirmTransfer')">
                            <strong>ยืนยันขอโอนวัตถุดิบ</strong>
                        </button>
                        <button
                            class="btn btn-w-m btn-danger btn-lg"
                            :disabled="!header.can.cancel_transfer"
                            @click.prevent="setStatus('cancelTransfer')">
                            <i class="fa fa-times"></i> ยกเลิกการขอโอนวัตถุดิบ
                        </button> -->
                    </div>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-8 b-r">
                        <dl class="row mb-0">
                            <div class="col-sm-3 text-sm-right">
                                <dt>ผู้บันทึก:</dt>
                            </div>
                            <div class="col-sm-4 text-sm-left">
                                <dd class="mb-1">
                                    {{ header.user_name }}
                                </dd>
                            </div>
                        </dl>
                        <dl class="row mb-1">
                            <div class="col-sm-3 text-sm-right">
                                <dt>วันที่สร้าง:</dt>
                            </div>
                            <div class="col-sm-4 text-sm-left">
                                <dd class="mb-1">
                                    {{ header.formula_creation_date_format }}
                                </dd>
                            </div>

                            <div class="col-sm-2 text-sm-right">
                                <dt>วันที่แก้ไขล่าสุด:</dt>
                            </div>
                            <div class="col-sm-3 text-sm-left">
                                <dd class="mb-1">
                                    {{ header.formula_last_update_date_format }}
                                </dd>
                            </div>
                        </dl>

                        <div class="hr-line-dashed m-t-sm m-b-sm hidden-sm hidden-xs"></div>

                        <div class="form-group mb-2 mt-3 row">
                            <label class="col-lg-3 font-weight-bold col-form-label required text-right">
                                ยาเส้นปรุง Blend No.
                            </label>
                            <div class="col-lg-4">
                                <el-select
                                    class="required"
                                    style="width: 100%"
                                    placeholder=""
                                    value-key="blend_no"
                                    v-model="header.blend_no"
                                    :disabled="header.formula_id != ''"
                                    @change="selectBlendNo('blend_no')"
                                    clearable
                                    filterable
                                    >
                                    <el-option
                                        v-for="item in data.blend_no_list"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="String(item.value)">
                                    </el-option>
                                </el-select>

                                <!-- <el-form-item label="Activity name" prop="name">
                                    <el-input v-model="ruleForm.name"></el-input>
                                </el-form-item> -->
                            </div>


                            <label class="col-lg-2 font-weight-bold col-form-label text-right ">
                                ประเภทสูตร
                            </label>
                            <div class="col-lg-3">
                                <el-select
                                    style="width: 100%"
                                    placeholder=""
                                    value-key="formula_type_code"
                                    v-model="header.formula_type_code"
                                    :disabled="header.formula_id != ''"
                                    >
                                    <el-option
                                        v-for="(fmlType, index) in data.formula_type"
                                        :key="String(fmlType.lookup_code)"
                                        :label="fmlType.description"
                                        :value="String(fmlType.lookup_code)">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>

                        <div class="form-group mb-2 row">
                            <label class="col-lg-3 font-weight-bold col-form-label text-right required">
                                รสชาติ
                            </label>
                            <div class="col-lg-4">
                                <el-select
                                    style="width: 100%"
                                    placeholder=""
                                    value-key="flavour_code"
                                    v-model="header.flavour_code"
                                    @change="selectFlavour()"
                                    :disabled="!header.can.edit"
                                    clearable
                                    filterable
                                    >
                                    <el-option
                                        v-for="item in data.flavour_list"
                                        :key="String(item.value)"
                                        :label="item.label"
                                        :value="String(item.value)">
                                    </el-option>
                                </el-select>
                            </div>

                            <label class="col-lg-2 font-weight-bold col-form-label text-right required">
                                ปริมาณ
                            </label>
                            <div class="col-lg-3">
                                <div class="input-group ">
                                    <input class="form-control text-right " type="number"
                                        :disabled="!header.can.edit"
                                        v-model.number="header.quantity"
                                    />
                                    <div class="input-group-append" :title="header.uom">
                                        <span class="input-group-addon" >
                                            {{ uomDesc }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-2 row">
                            <label class="col-lg-3 font-weight-bold col-form-label text-right">
                                รายละเอียด
                            </label>
                            <div class="col-lg-4">
                                <el-input type="textarea" name="note"
                                    :disabled="!header.can.edit"
                                    v-model="header.description" rows="2" maxlength="240" show-word-limit />
                            </div>

                            <label class="col-lg-2 font-weight-bold col-form-label text-right">
                                หมายเหตุ
                            </label>
                            <div class="col-lg-3">
                                <el-input type="textarea" name="note"
                                    :disabled="!header.can.edit"
                                    v-model="header.comments" rows="2" maxlength="240" show-word-limit />
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">

                        <dl class="row mb-2">
                            <div class="col-sm-4 text-sm-right">
                                <dt title="">สถานะ</dt>
                            </div>
                            <div class="col-sm-7 text-sm-left">
                                <dd class="mb-1">
                                    <el-select
                                        style="width: 100%"
                                        placeholder=""
                                        value-key="formula_status"
                                        v-model="header.formula_status"
                                        @change="changeStatus"
                                        >
                                        <el-option
                                            v-for="(item, index) in data.status_list"
                                            :key="index"
                                            :label="item"
                                            :value="index">
                                        </el-option>
                                    </el-select>
                                </dd>
                            </div>
                        </dl>
                        <dl class="row mb-2">
                            <div class="col-sm-4 pt-2 text-sm-right">
                                <dt title="">วันที่อนุมัติ</dt>
                            </div>
                            <div class="col-sm-7 text-sm-left">
                                <dd class="mb-1">
                                    <div v-if="true">
                                        <datepicker-th
                                            style="width: 100%"
                                            class="form-control md:tw-mb-0 tw-mb-2"
                                            placeholder="โปรดเลือกวันที่"
                                            :disabled="!header.can.edit"
                                            :value="header.formula_approval_date_format"
                                            :format="transDate['js-format']"
                                            @dateWasSelected="setdate(...arguments, 'formula_approval_date_format')"
                                            />
                                    </div>
                                </dd>
                            </div>
                        </dl>

                        <dl class="row mb-2">
                            <div class="col-sm-4 pt-2 text-sm-right">
                                <dt title="">วันที่เริ่มใช้</dt>
                            </div>
                            <div class="col-sm-7 text-sm-left">
                                <dd class="mb-1">
                                    <div v-if="true">
                                        <datepicker-th
                                            style="width: 100%"
                                            class="form-control md:tw-mb-0 tw-mb-2"
                                            placeholder="โปรดเลือกวันที่"
                                            :disabled="!header.can.edit"
                                            :value="header.formula_start_date_format"
                                            :format="transDate['js-format']"
                                            @dateWasSelected="setdate(...arguments, 'formula_start_date_format')"
                                            />
                                    </div>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <transition
            enter-active-class="animated fadeInUp"
            leave-active-class="animated fadeOutDown">
        <div class="ibox float-e-margins" v-if="header.blend_no">
            <div class="ibox-content">
                <!-- <pre>{{ leafFormulas }}</pre> -->
                <!-- <pre>{{ casings }}</pre> -->
                <!-- <pre>{{ selTabName }}</pre> -->
                <!-- <pre>{{ tabs }}</pre> -->
                <div class="tabs-container">
                    <ul class="nav nav-tabs" role="tablist">
                        <li>
                            <a :class="(selTabName == 'tab1')? 'nav-link active' : 'nav-link'"  @click="changeTab('tab1', selTabName)">
                                Leaf Formula
                            </a>
                        </li>
                        <li>
                            <a :class="(selTabName == 'tab2')? 'nav-link active' : 'nav-link'"
                                v-if="header.formula_id || true"
                                @click="changeTab('tab2', selTabName)">
                                Casing
                            </a>
                        </li>
                        <li>
                            <a :class="(selTabName == 'tab3')? 'nav-link active' : 'nav-link'"
                                v-if="header.formula_id || true"
                                @click="changeTab('tab3', selTabName)">
                                Flavor
                            </a>
                        </li>
                        <li>
                            <a :class="(selTabName == 'tab4')? 'nav-link active' : 'nav-link'"
                                v-if="header.formula_id || true"
                                @click="changeTab('tab4', selTabName)">
                                บุหรี่
                            </a>
                        </li>
                        <li>
                            <a :class="(selTabName == 'tab5')? 'nav-link active' : 'nav-link'"
                                v-if="header.formula_id || true"
                                @click="changeTab('tab5', selTabName)">
                                ทั้งหมด
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" :class="(selTabName == 'tab1')? 'tab-pane active' : 'tab-pane'">
                            <div class="panel-body pt-3 " v-loading="tabs.leaf_formula_line.loading" >
                                <tab-leaf-formula
                                    v-if="selTabName == 'tab1'"
                                    :header="header"
                                    :url="url"
                                    :transBtn="transBtn"
                                    :transDate="transDate"
                                    :data="data.tabs.leaf_formula_line"
                                    :leafFormulas="leafFormulas"
                                    :pRefresh="tabs.leaf_formula_line.refreshCount"
                                    :tabs="tabs"
                                />
                            </div>
                        </div>
                        <div role="tabpanel" :class="(selTabName == 'tab2')? 'tab-pane active' : 'tab-pane'">
                            <div class="panel-body pt-3" v-loading="tabs.casings.loading">
                                <casing
                                    v-if="selTabName == 'tab2' && header.formula_id"
                                    :header="header"
                                    :url="url"
                                    :transBtn="transBtn"
                                    :transDate="transDate"
                                    :data="data.tabs.casings"
                                    :casings="casings"
                                    :tabs="tabs"
                                />
                            </div>
                        </div>
                        <div role="tabpanel" :class="(selTabName == 'tab3')? 'tab-pane active' : 'tab-pane'">
                            <div class="panel-body pt-3" v-loading="tabs.flavors.loading">
                                <flavor
                                    v-if="selTabName == 'tab3' && header "
                                    :header="header"
                                    :url="url"
                                    :transBtn="transBtn"
                                    :transDate="transDate"
                                    :data="data.tabs.flavors"
                                    :flavors="flavors"
                                    :tabs="tabs"
                                />
                            </div>
                        </div>
                        <div role="tabpanel" :class="(selTabName == 'tab4')? 'tab-pane active' : 'tab-pane'">
                            <div class="panel-body pt-3" v-loading="tabs.cigarettes.loading">
                                <cigarette
                                    v-if="selTabName == 'tab4' && header && header.formula_id"
                                    :header="header"
                                    :url="url"
                                    :transBtn="transBtn"
                                    :transDate="transDate"
                                    :data="data.tabs.cigarettes"
                                    :cigarettes="cigarettes"
                                    :cigarDtl="cigarDtl"
                                    :tabs="tabs"
                                />
                            </div>
                        </div>
                        <div role="tabpanel" :class="(selTabName == 'tab5')? 'tab-pane active' : 'tab-pane'">
                            <div class="panel-body pt-3" v-loading="tabs.cigarette_all.loading">
                                <cigarette-all
                                    v-if="selTabName == 'tab5' && header && header.formula_id"
                                    :transBtn="transBtn"
                                    :transDate="transDate"
                                    :cigaretteAll="cigaretteAll"
                                    :tabs="tabs"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </transition>
    </div>
    </transition>
</template>
<!-- url -->
<script>

import {
    showLoadingDialog,
    showProgressWithUnsavedChangesWarningDialog,
    showValidationFailedDialog,
} from "../../commonDialogs"

import moment from "moment";
import SearchItem from './SearchItem';
import TabLeafFormula from './tabs/LeafFormula';
import Casing from './tabs/Casing';
import Flavor from './tabs/Flavor';
import Cigarette from './tabs/Cigarette';
import CigaretteAll from './tabs/CigaretteAll';
import modalSearch from './ModalSearch.vue';


export default {

    components: {
        SearchItem, TabLeafFormula, Casing, Flavor, Cigarette, CigaretteAll, modalSearch
    },
    props:["pUrl"],
    computed: {
        // ingredient_group() {
        //     return this.header.ingredient_group;
        // },
    },
    watch:{
        // selTabName : async function (val, oldVal) {
        //     console.log('selTabName', val, oldVal);

        //     this.changeTab(val, oldVal);

    },
    data() {
        return {
            url: this.pUrl,
            data: false,
            header: false,
            profile: false,
            uomDesc: '',
            transBtn: {},
            transDate: {},
            isActive: false,
            lines: [],

            originalData: [],
            originalDtlData: [],
            leafFormulas: [],
            casings: [],
            flavors: [],
            cigarettes: [],
            cigarDtl: [],
            cigaretteAll: [],

            leafFormulaHasChange: false,

            loading: {
                page: false,
                before_mount: false,
            },
            firstLoad: true,
            countOpenModal: 0,
            selTabName: 'tab1',
            tabs: {
                leaf_formula_line: {
                    loading: false,
                    refreshCount: 1,
                    has_change: false,
                },
                casings: {
                    loading: false,
                    refreshCount: 1,
                    has_change: false,
                },
                flavors: {
                    loading: false,
                    refreshCount: 1,
                    has_change: false,
                },
                cigarettes: {
                    loading: false,
                    refreshCount: 1,
                    has_change: false,
                },
                cigarette_all: {
                    loading: false,
                    refreshCount: 1,
                    has_change: false,
                },
            },
            rules: {
              name: [
                { required: true, message: 'Please input Activity name', trigger: 'blur' },
                { min: 3, max: 5, message: 'Length should be 3 to 5', trigger: 'blur' }
              ],
            },
            ruleForm: {
              name: '',
            },
        }
    },
    beforeMount() {
        console.log('beforeMount');
        this.getInfo();
    },
    mounted() {
        console.log('Component mounted.')
        // this.setData();
    },
    methods: {
        async show(header) {
            console.log('show header', header);
            this.loading.before_mount = false;
            this.getInfo(header.formula_id);
        },
        async setdate(date, key) {
            let vm = this;
            vm.header[key] = await moment(date).format(vm.transDate['js-format']);
            vm.getLines();
        },
        async changeStatus() {
            if (this.header.formula_status.toUpperCase() == 'INACTIVE') {
                this.isActive = true;
            } else {
                this.isActive = false;
            }

            this.header.can.edit = (this.isActive == true);
            this.header.can.edit = true;
        },
        async getInfo(formulaId = '') {
            let vm = this;
            // let param = window.location.search;
            // let param = '';

            // if (formulaId) {
            //     if (param == '' || true) {
            //         param = '?formula_id='+ formulaId;
            //     } else {
            //         param = param + '&formula_id='+ formulaId;
            //     }
            // }
            // let param = '?formula_id='+ formulaId;
            let params = {
                lookup_code: vm.header.lookup_code,
                formula_id: formulaId,
            };

            let response = false;
            vm.loading.page = true;
            vm.loading.before_mount = true;
            // vm.selTabName = 'tab1';
            await axios.get(vm.url.index, { params }).then(res => {
                response = res.data.data
                if (response.status == 'S') {
                    response = response.info
                }
                vm.loading.page = false;
            });

            if (response) {
                vm.data = response.data;
                vm.header = response.header;
                vm.profile = response.profile;
                vm.transBtn = response.transBtn;
                vm.transDate = response.transDate;
                vm.url = response.url;
                // vm.header.blend_no = '369'

                if (vm.header.formula_id) {
                    vm.uomDesc = vm.header.uom_name;
                }
                await vm.resetData();
            }

            vm.loading.before_mount = false;
            console.log('info success');
            // vm.getLines(false, 'show');

            if (vm.header.formula_id) {
                vm.changeTab(vm.selTabName, vm.selTabName, false);
            }
            vm.changeStatus();
        },
        async getLines(isShowNoti = true, action = 'search') {
            return;
            let vm = this;
            let confirm = true;

            if (isShowNoti) {
                confirm = await helperAlert.showProgressConfirm('กรุณายืนยันการค้นหารายการเบิก');
            }
        },
        async changeTab(toTab, FromTab, isShowNoti = true) {
            let vm = this;
            let confirm = true;


            // alert(FromTab  +' > '+ toTab);

            // if (toTab != FromTab || !vm.header.formula_id) {
            //     confirm = await helperAlert.showProgressConfirm(FromTab  +' > '+ toTab);
            // }


            // return;

            // if (confirm) {

            //     // vm.selTabName = toTab;
            // } else {
            //     vm.selTabName = FromTab;
            // }
            let type = '';
            if (toTab == 'tab1') {
                type = 'leaf_formula_line'
            } else if(toTab == 'tab2') {
                type = 'casings'
            } else if(toTab == 'tab3') {
                type = 'flavors'
            } else if(toTab == 'tab4') {
                type = 'cigarettes'
            } else if(toTab == 'tab5') {
                type = 'cigarette_all'
            }

            let mustBeConfirmed = false
            if ((toTab != FromTab && FromTab != 'tab5' && isShowNoti) || !vm.header.formula_id) {
                let isEqual = await vm.compareData(FromTab);

                if (!isEqual) {
                    confirm = await helperAlert.showProgressConfirm('ต้องการบันทึกข้อมูลที่แก้ไขหรือไม่ ?');
                    if (confirm) {
                        await vm.save(false);
                    }
                }
            }




            vm.selTabName = toTab;
            await vm.resetData();
            let params = {
                header: vm.header,
                type: type
            }

            vm.tabs[type].loading = true;
            vm.tabs[type].has_change = false;

            axios.get(vm.url.ajax_get_data, { params }).then(res => {
                let response = res.data.data;

                if (type == 'leaf_formula_line') {
                    vm.originalData = JSON.parse(JSON.stringify(response.leaf_formula_lines));
                    vm.leafFormulas = response.leaf_formula_lines;
                }

                if (type == 'casings') {
                    vm.originalData = JSON.parse(JSON.stringify(response.casings));
                    vm.casings = response.casings
                }

                if (type == 'flavors') {
                    vm.originalData = JSON.parse(JSON.stringify(response.flavors));
                    vm.flavors = response.flavors
                }

                if (type == 'cigarettes') {
                    vm.originalData = JSON.parse(JSON.stringify(response.cigarettes));
                    vm.originalDtlData = JSON.parse(JSON.stringify(response.cigar_dtl));
                    vm.cigarettes = response.cigarettes;
                    vm.cigarDtl = response.cigar_dtl;
                }

                if (type == 'cigarette_all') {
                    vm.cigaretteAll = response[type];
                }
                vm.tabs[type].loading = false;
            });
        },
        async resetData() {
            let vm = this;
            vm.originalData = [];
            vm.originalDtlData = [];
            vm.leafFormulas = [];
            vm.casings = [];
            vm.flavors = [];
            vm.cigarettes = [];
            vm.cigarDtl = [];
            vm.cigaretteAll = [];
        },
        async compareData(fromTab) {
            let vm = this;
            let isEqual = false;


            let type = '';
            if (fromTab == 'tab1') {
                type = 'leaf_formula_line'
            } else if(fromTab == 'tab2') {
                type = 'casings'
            } else if(fromTab == 'tab3') {
                type = 'flavors'
            } else if(fromTab == 'tab4') {
                type = 'cigarettes'
            } else if(fromTab == 'tab5') {
                type = 'cigarette_all'
            }

            await axios.post(vm.url.ajax_compare_data,
                {
                    header: vm.header,
                    original_data: vm.originalData,
                    original_dtl_data: vm.originalDtlData,
                    type: type,
                    leaf_formulas: vm.leafFormulas,
                    casings: vm.casings,
                    flavors: vm.flavors,
                    cigarettes: vm.cigarettes,
                    cigar_dtl: vm.cigarDtl,
                })
                .then(res => {
                    let data = res.data.data;


                    isEqual = data.is_equal;
                    // if (data.status == 'S') {
                    //     vm.hasChange = false;
                    //     vm.header = data.header;
                    //     swal({
                    //         title: 'บันทึกข้อมูลสำเร็จ',
                    //         type: "success",
                    //         html: true
                    //     });

                    //     setTimeout(async function(){ await vm.getInfo(header.formula_id); }, 500);
                    // }

                    // if (data.status != 'S') {
                    //     swal({
                    //         title: "Error !",
                    //         text: data.msg,
                    //         type: "error",
                    //         showConfirmButton: true
                    //     });
                    // }
                })
                .catch(err => {
                    let data = err.response.data;
                    // alert(data.message);
                    swal({
                        title: "Error !",
                        text: data.message,
                        type: "error",
                        showConfirmButton: true
                    });
                })
                .then(() => {
                    vm.loading.page = false;
                    // swal.close();
                });
            return isEqual;
        },
        async save(isShowNoti = true) {
            let vm = this;
            let confirm = true;
            let valid = true;
            let message = '';

            if (vm.header.formula_status.toUpperCase() == 'ACTIVE' && vm.selTabName == "tab1") {
                let totalLeafProp = 0;
                vm.leafFormulas.forEach(async (o, i) => {
                    if (o.is_deleted == false) {
                        totalLeafProp = parseFloat(o.leaf_proportion) + parseFloat(totalLeafProp);
                    }
                });
                if (parseFloat(totalLeafProp) != 100) {
                    // console.log('ยอดรวมสัดส่วน x11')
                    message = 'Leaf Formula: ยอดรวมสัดส่วน % มากกว่าหรือน้อยกว่า 100';
                    helperAlert.showGenericFailureDialog(message);
                    valid = false;
                }


                vm.leafFormulas.forEach(async (o, i) => {
                    if (o.is_deleted == false) {
                        let total = 0;
                        o.leaf_dtl.forEach((leafDtl) => {
                            total = parseFloat(total) + parseFloat(leafDtl.ingredient_proportions);
                        });

                        if (parseFloat(total) != 100) {
                            // console.log('ยอดรวมสัดส่วน x11')
                            message = 'ยอดรวมสัดส่วน % ของวัตถุดิบ มากกว่าหรือน้อยกว่า 100';
                            helperAlert.showGenericFailureDialog(message);
                            valid = false;
                        }
                    }
                });
                if (!valid) {
                    // await helperAlert.showGenericFailureDialog(message);
                    return;
                }
            }


            if (isShowNoti) {
                if (!vm.header.blend_no) {
                    helperAlert.showGenericFailureDialog('โปรดระบุยาเส้นปรุง Blend No.');
                    return;
                }

                if (!vm.header.flavour_code) {
                    helperAlert.showGenericFailureDialog('โปรดระบุรสชาติ');
                    return;
                }

                if (!vm.header.quantity) {
                    helperAlert.showGenericFailureDialog('โปรดระบุปริมาณ');
                    return;
                }

                confirm = await helperAlert.showProgressConfirm('กรุณายืนยัน บันทึกสูตรผลิต');
            }
             // && vm.hasChange

            if (confirm) {
                vm.loading.page = true;
                // let lines =  vm.lines;
                // let lines =  vm.lines.filter(o => o.is_selected == true);
                await axios.post(vm.url.ajax_store, {
                        header: vm.header,
                        leaf_formulas: vm.leafFormulas,
                        casings: vm.casings,
                        flavors: vm.flavors,
                        cigarettes: vm.cigarettes,
                        cigar_dtl: vm.cigarDtl,
                    })
                    .then(res => {
                        let data = res.data.data;
                        if (data.status == 'S') {
                            vm.hasChange = false;
                            // vm.header = data.header;
                            swal({
                                title: '&nbsp;',
                                text: 'บันทึกข้อมูลสำเร็จ',
                                type: "success",
                                html: true
                            });

                            setTimeout(async function(){ await vm.getInfo(data.header.formula_id); }, 500);
                        }

                        if (data.status != 'S') {
                            swal({
                                title: "Error !",
                                text: data.msg,
                                type: "error",
                                showConfirmButton: true
                            });
                        }
                })
                .catch(err => {
                    let data = err.response.data;
                    // alert(data.message);
                    swal({
                        title: "Error !",
                        text: data.message,
                        type: "error",
                        showConfirmButton: true
                    });
                })
                .then(() => {
                    vm.loading.page = false;
                    // swal.close();
                });

            }
        },
        async selectBlendNo(inputName) {
            let vm = this;
            vm.uomDesc = '';
            vm.header.description = '';
            vm.header.formula_no = '';
            vm.header.product_item_code = '';
            vm.header.uom = '';

            let blendNo = vm.data.blend_no_list.findIndex(o => o.value == vm.header.blend_no);
                blendNo = vm.data.blend_no_list[blendNo];
            if (blendNo) {
                vm.header.description = blendNo.description;
                vm.header.formula_no = blendNo.formula_no;
                vm.header.product_item_code = blendNo.product_item_code;
                vm.header.uom = blendNo.uom;
                // vm.uomDesc = blendNo.uom_detail.unit_of_measure;
                vm.uomDesc = blendNo.uom_name;

                if (!vm.header.formula_id) {
                    vm.header.quantity = 100;
                }
            } else {
                if (!vm.header.formula_id) {
                    vm.header.quantity = '';
                }
            }

            if (vm.header.blend_no) {
                vm.changeTab('tab1', 'tab1', false);
            }
        },
        async selectFlavour() {
            let vm = this;
            // vm.header.flavour

            vm.header.flavour = '';
            vm.header.formula_organization_code = '';
            vm.header.organization_code = '';
            vm.header.department = '';

            let flavour = vm.data.flavour_list.findIndex(o => o.value == vm.header.flavour_code);
                flavour = vm.data.flavour_list[flavour];

            if (flavour) {
                vm.header.flavour = flavour.flavour;
                vm.header.formula_organization_code = flavour.formula_organization_code;
                vm.header.organization_code = flavour.organization_code;
                vm.header.department = flavour.department;
            }
        }

    }
}
</script>
