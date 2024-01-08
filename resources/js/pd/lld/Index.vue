<template>
    <transition
    enter-active-class="animated fadeIn"
    leave-active-class="animated fadeOut">
    <div v-if="data">
        <div class="ibox float-e-margins" >
            <div class="ibox-content" >
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-6 mb-2 mt-3">
                                <div class="form-group mb-2 row">
                                    <label class="col-6 pl-0 pr-0 font-weight-bold col-form-label text-right">
                                        ปีงบประมาณ
                                    </label>
                                    <div class="col-6">
                                        <el-select
                                              style="width: 100%"
                                              v-model="header.lld_year"
                                              placeholder="โปรดเลือก ปีงบประมาณ"
                                              :popper-append-to-body="false"
                                              filterable
                                            >
                                          <el-option
                                            v-for="item in data.year_list"
                                            :key="item.value"
                                            :label="item.label"
                                            :value="item.value"
                                          ></el-option>
                                        </el-select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 mb-2 mt-3">
                                <modal-create v-if="data" @selectRow="showDraft"
                                    class="pr-2"
                                    :btnTrans="transBtn"
                                    :menu="data.menu"
                                    :url="url"
                                    :createInput="data.create_input"
                                 />

                                <button type="button" @click="show(header.lld_year)" :class="transBtn.search.class + ' btn-lg tw-w-25'" >
                                    <i :class="transBtn.search.icon"></i>
                                    {{ transBtn.search.text }}
                                </button>
                                <button :class="transBtn.search.class + ' btn-lg tw-w-25 mr-2'"
                                    @click.prevent="resetData()" >
                                    ล้างค่า
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 text-right  mt-3">
                        <button type="button"  :class="transBtn.add.class + ' btn-lg tw-w-25'" v-if="header.lld_id"
                                @click.prevent="addLine()">
                            <i :class="transBtn.add.icon"></i>
                            {{ transBtn.add.text }}
                        </button>
                        <button type="button"  :class="transBtn.save.class + ' btn-lg tw-w-25'" v-if="header.lld_id"
                                @click.prevent="save()">
                            <i :class="transBtn.save.icon"></i>
                            {{ transBtn.save.text }}
                        </button>
                    </div>

                    <div class="col-10 offset-1" v-if="header.lld_year && lines.length && (showLldYear == header.lld_year) ">
                        <div class="table-responsive m-t">
                            <table class="table text-nowrap table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th  class="text-center" style="width: 150px;"> Blend No. </th>
                                        <th  class="text-left" style="width: 150px;"> รหัสบุหรี่ </th>
                                        <th  class="text-left"> ตราบุหรี่ </th>
                                        <th  class="text-center" style="width: 150px;"> LLD (กก./พันมวน) </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-for="(line, i) in lines">
                                        <tr>
                                            <td class="text-center">{{ line.blend_no }}</td>
                                            <td>{{ line.item_code }}</td>
                                            <td>{{ line.item_code_desc }}</td>
                                            <td class="text-right">
                                                <vue-numeric v-if="header.lld_id"
                                                    separator=","
                                                    v-bind:precision="6"
                                                    v-bind:minus="false"
                                                    class="form-control input-sm text-right"
                                                    v-model="line.lld_qty"
                                                    ></vue-numeric>
                                                <div v-else>
                                                    {{ Number(line.lld_qty).toLocaleString(undefined, {minimumFractionDigits: 6,maximumFractionDigits: 6}) }}
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                    <template>
                                        <tr v-for="(data, k) in linesAdd" :key="k">
                                            <td>
                                                <el-select  v-model="data.blend_no" 
                                                            class="m-2" 
                                                            placeholder="Select" 
                                                            size="large"
                                                            @change="findItemCode(data.blend_no)">
                                                    <el-option
                                                        v-for="(item, index) in listBlendNo"
                                                        :key="index"
                                                        :label="item.blend_no"
                                                        :value="item.blend_no"
                                                    />
                                                </el-select>
                                            </td>
                                            <td>
                                                <el-select  v-model="data.cigar_item_id" 
                                                            class="m-2" 
                                                            placeholder="Select" 
                                                            size="large"
                                                            clearable
                                                            filterabl
                                                            :disabled="disabled.itemCode"
                                                            :loading="loading.itemCode"
                                                            @change="findItemDesc(data.cigar_item_id, k)">
                                                    <el-option
                                                        v-for="(item, index) in listCigar"
                                                        :key="index"
                                                        :label="item.cigar_item_code"
                                                        :value="item.cigar_item_id + '.' + item.cigar_item_code"
                                                    />
                                                </el-select>
                                            </td>
                                            <td>
                                                {{ data.item_code_desc }}
                                            </td>
                                            <td class="text-right">
                                                <vue-numeric
                                                    separator=","
                                                    v-bind:precision="6"
                                                    v-bind:minus="false"
                                                    :class="'form-control input-sm text-right ' + (data.validateRemark.lld_qty ? 'is-invalid' : '')"
                                                    v-model="data.lld_qty"
                                                    >
                                                </vue-numeric>
                                            </td>
                                            <td>
                                                <button @click.prevent="removeRow(k)" class="btn btn-sm btn-danger" >
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>      
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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

import modalSearch from './ModalSearch.vue';
import {isInRange, jsDateToString, toJSDate, toThDateString} from '../../dateUtils'

import modalCreate from './ModalCreate.vue';
import ElSelectComponentVue from '../../components/pm/save-publication-layout/ElSelectComponent.vue';
export default {

    components: {
        modalSearch, modalCreate
    },
    props:["pUrl", "pMenu"],
    computed: {
    },
    watch:{
        // selTabName : async function (val, oldVal) {
        //     console.log('selTabName', val, oldVal);

        //     this.changeTab(val, oldVal);
    },
    data() {
        return {
            config: {},
            isInRange, jsDateToString, toJSDate, toThDateString,
            url:            this.pUrl,
            menu:           this.pMenu,
            data:           false,
            header:         false,
            lines:          [],
            profile:        false,
            transBtn:       {},
            transDate:      {},
            countOpenModal: 0,
            listBlendNo:    [],
            listCigar:      [],
            linesAdd:       [],

            loading: {
                page:           false,
                before_mount:   false,
                itemCode:       false
            },
            disabled: {
                itemCode: true
            },

            firstLoad:      true,
            showLldYear:    '',
        }
    },
    beforeMount() {
        console.log('beforeMount');
        this.getInfo();
    },
    mounted() {
        console.log('Component mounted.')
    },
    methods: {
        async getInfo() {
            let vm = this;
            let params = {};
            vm.lines = [];

            let response = false;
            vm.loading.page = true;
            vm.loading.before_mount = true;
            await axios.get(vm.url.index, { params }).then(res => {
                response = res.data.data
                if (response.status == 'S') {
                    response = response.info
                }
                vm.loading.page = false;
            });

            if (response) {
                vm.data         = response.data;
                vm.header       = response.header;
                vm.profile      = response.profile;
                vm.transBtn     = response.transBtn;
                vm.transDate    = response.transDate;
                vm.url          = response.url;
            }

            vm.loading.before_mount = false;

        },
        async showDraft(res) {
            this.lines = [];
            this.show(res.lld_year, res.lld_id);
        },
        async show(lldYear, lldId = '') {
            if (!lldYear) {
                return;
            }
            this.loading.before_mount = false;
            this.showLldYear = lldYear;
            let vm = this;
            let params = {
                lld_year: lldYear,
                lld_id: lldId,
            };
            vm.lines = [];

            let response = false;
            vm.loading.page = true;
            vm.loading.before_mount = true;
            await axios.get(vm.url.index, { params }).then(res => {
                response = res.data.data
                if (response.status == 'S') {
                    response = response.info
                }
                vm.loading.page = false;
            });

            if (response) {
                vm.header = response.header;
                vm.lines = response.header.lines;
            }

            vm.loading.before_mount = false;
        },
        async save(isShowNoti = true) {
            let vm      = this;
            let confirm = true;
            let valid   = false;
            let message = 'กรุณายืนยันกำหนด LLD';
            if (vm.header.has_confirm) {
                message = "มีข้อมูลปีงบประมาณ "+ vm.header.lld_year +" แล้ว กรุณายืนยันกำหนด LLD อีกครั้ง";
            }

            confirm = await helperAlert.showProgressConfirm(message);

            if (confirm) {
                vm.linesAdd.forEach((element, index) => {
                    if(!element.lld_qty){
                        vm.linesAdd[index].validateRemark.lld_qty = true;
                    
                        if(!element.cigar_item_id || !element.blend_no){
                            alert('เกิดข้อผิดพลาด! กรอกข้อมูลให้ครบถ้วน');
                        }

                        valid = true;
                        return valid ;
                    }else{
                        vm.linesAdd[index].validateRemark.lld_qty = false;
                    }
                });

                if(valid){
                    valid = false;
                }else{
                    valid           = false;
                    vm.lines        = [];
                    vm.loading.page = true;
                    await axios.post(vm.url.ajax_update, {
                            header: vm.header,
                            manualLine: vm.linesAdd
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
                                vm.linesAdd = [];
                                setTimeout(async function(){ await vm.show(vm.header.lld_year); }, 500);
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

                
            }
        },
        async resetData() {
            let vm = this;
            vm.header.lld_year = '';
            vm.lines = [];
        },
        async addLine(){
            let vm = this;
            await   axios.post(vm.url.ajax_findDataLov)
                        .then(res => {
                            vm.listBlendNo      = res.data.listBlendNo;
                        })
                        .catch(err => {
                            
                        })

            this.linesAdd.push({
                blend_no            : '',
                cigar_item_id       : '',
                item_code_desc      : '',
                lld_qty             : '',
                lld_id              : vm.header.lld_id,
                lld_year            : vm.header.lld_year,
                validateRemark:{
                    lld_qty: false
                }
            });
        },
        findItemCode(blend_no){
            let vm = this;
            let availableData = [];
            vm.loading.itemCode = true;
            vm.linesAdd.cigar_item_id = '';
            vm.linesAdd.item_code_desc = '';
            vm.header.lines.forEach(element => {
                if(element.blend_no == blend_no){
                    availableData.push({ 
                        inventory_item_id:  element.inventory_item_id,
                        item_code:          element.item_code,
                        item_code_desc:     element.item_code_desc,
                    });
                }
            });
            axios.post(vm.url.ajax_findItemCode, {
                        availableData: availableData
                    })
                .then(res => {
                    vm.listCigar = res.data.listCigar;
                    vm.loading.itemCode = false;
                    vm.disabled.itemCode = false;
                })
                .catch(err => {
                    let data = err.response.data;
                    swal({
                        title: "Error !",
                        text: data.message,
                        type: "error",
                        showConfirmButton: true
                    });
                })
        },
        findItemDesc(inventory_item_id, index){
            let vm = this;
            if(inventory_item_id){
                let myarr = inventory_item_id.split(".");
                vm.listCigar.forEach(element => {
                    if(element.cigar_item_id == myarr[0]){
                        vm.linesAdd[index].item_code_desc = element.cigar_item_desc;
                    }
                });
            }else{
                vm.linesAdd[index].item_code_desc = '';
            }
        },
        removeRow: function (index) {
            this.linesAdd.splice(index, 1);
        },
    }
}
</script>
