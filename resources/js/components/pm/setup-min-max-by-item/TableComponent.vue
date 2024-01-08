<template>
    <div>
        <div class="ibox">
            <div class="ibox-title">
                <h5> กำหนดค่าเฝ้าระวัง </h5>
            </div>
            <div class="ibox-content">
                <div class="text-right" style="padding-bottom: 15px;">
                    <button class="btn btn-sm btn-primary" 
                            @click.prevent="addLine" 
                            :disabled="isDisabledBtuAdd"> 
                        <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มรายการ 
                    </button>
                </div>
                <table class="table" id="setup-min-max-by-item-datatable-bk">
                    <thead>
                        <tr>
                            <th class="text-center" style="font-size: small;"  width="15%">
                                <div>รหัสวัตถุดิบ <span class="text-danger">*</span></div>
                            </th>
                            <th class="text-center" style="font-size: small;"  width="40%">
                                <div>รายละเอียด</div>
                            </th>
                            <th class="text-center" style="font-size: small;"  width="10%">
                                <div>หน่วย</div>
                            </th>
                            <th class="text-center" style="font-size: small;"  width="10%">
                                <div>ค่าเฝ้าระวังต่ำสุด <span class="text-danger">*</span></div>
                            </th>
                            <th class="text-center" style="font-size: small;"  width="10%">
                                <div>ค่าเฝ้าระวังสูงสุด <span class="text-danger">*</span></div>
                            </th>
                            <th class="text-center" style="font-size: small;"  width="20%">
                                <div>หมายเหตุ</div>
                            </th>
                            <th class="text-center" style="font-size: small;">
                            </th>
                        </tr>
                    </thead>

                    <tbody v-if="testList == 'NoSearchData'">
                        <tr>
                            <td class="text-center" colspan="8" v-if="isTextFlag">
                                <h2>{{'ไม่มีข้อมูล กำหนดค่าเฝ้าระวัง'}}</h2>
                            </td>
                        </tr>
                        <tr v-for="(row, index) in lines" :key="index" :row="row">
                            <td>
                                <input type="hidden" :name="'newDataGroup['+row.id+'][item_number]'" v-model="row.itemNumber" autocomplete="off">
                                <el-select  v-model="row.itemNumber"
                                            filterable
                                            remote  
                                            reserve-keyword
                                            class="w-100"
                                            placeholder="Select"
                                            v-loading="loading.itemNumber"
                                            @change="getUom(row.itemNumber, row, organization)">
                                    <el-option
                                        v-for="(itemNumber, index) in row.itemNumbersList"
                                        :key="index"
                                        :label="itemNumber.item_number + ' : ' + itemNumber.item_desc"
                                        :value="itemNumber.inventory_item_id">
                                    </el-option>
                                </el-select>
                            </td>
                            <td style="vertical-align:middle; padding-left: 10px;">
                                {{ row.itemNumberDes }} 
                            </td>
                            <td>
                                <el-input v-model="row.primaryUnitOfMeasure" v-loading="loading.primaryUnitOfMeasure" :disabled="true"></el-input>
                            </td>
                            <td>
                                <input type="hidden" :name="'newDataGroup['+row.id+'][min_qty]'" v-model="row.minQty" autocomplete="off">
                                <!-- <el-input placeholder="Please input" v-model="row.minQty" type="number"></el-input> -->
                                <vue-numeric 
                                    separator="," 
                                    v-bind:precision="2" 
                                    v-bind:minus="false"
                                    :class="'form-control text-right ' + (row.remarkImpossibleSmallValue ? 'is-invalid' : '')"
                                    v-model="row.minQty"
                                    @change="checkNumberSmallValue(row.minQty, row.maxQty, row)"
                                ></vue-numeric>
                            </td>
                            <td>
                                <input type="hidden" :name="'newDataGroup['+row.id+'][max_qty]'" v-model="row.maxQty" autocomplete="off">
                                <!-- <el-input placeholder="Please input" v-model="row.maxQty" type="number"></el-input> -->
                                <vue-numeric 
                                    separator="," 
                                    v-bind:precision="2" 
                                    v-bind:minus="false"
                                    :class="'form-control text-right ' + (row.remarkImpossibleHighValue ? 'is-invalid' : '')"
                                    v-model="row.maxQty"
                                    @change="checkNumberHighValue(row.minQty, row.maxQty, row)"
                                ></vue-numeric>
                            </td>
                            <td>
                                <input type="hidden" :name="'newDataGroup['+row.id+'][remark_msg]'" v-model="row.note" autocomplete="off">
                                <el-input
                                    type="textarea"
                                    :rows="1"
                                    placeholder="Please input"
                                    v-model="row.note">
                                </el-input>
                            </td>
                            <td>
                                <button @click.prevent="removeRow(index)" class="btn btn-sm btn-danger col text-center">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>

                    <tbody v-else-if="testList.length != 0">
                        <tr v-for="(test, row) in testList" :key="'showData'+ row" :row="row">
                            <input  type="hidden" 
                                    :name="'updateDataGroup['+row+'][setup_min_max_id]'" 
                                    v-model="test.setup_min_max_id" 
                                    autocomplete="off">
                            <td style="vertical-align:middle; padding-left: 10px;"> 
                                {{ test.item_number }}
                            </td>
                            <td style="vertical-align:middle; padding-left: 10px;">
                                {{ test.item_desc }}
                            </td>
                            <td style="vertical-align:middle; padding-left: 10px;">
                                {{ test.primary_unit_of_measure }}
                            </td>
                            <td>
                                <input  type="hidden" 
                                        :name="'updateDataGroup['+row+'][min_qty]'" 
                                        v-model="test.min_qty" 
                                        autocomplete="off">
                                <vue-numeric 
                                    separator="," 
                                    v-bind:precision="2" 
                                    v-bind:minus="false"
                                    :class="'form-control text-right ' + (test.remarkImpossibleSmallValue ? 'is-invalid' : '')"
                                    v-model="test.min_qty"
                                    @change="checkNumberSmallValue(test.min_qty, test.max_qty, test)"    
                                ></vue-numeric>        
                                <!-- <el-input v-model="test.min_qty"></el-input> -->
                            </td>
                            <td>
                                <input  type="hidden" 
                                        :name="'updateDataGroup['+row+'][max_qty]'" 
                                        v-model="test.max_qty" 
                                        autocomplete="off">
                                <vue-numeric 
                                    separator="," 
                                    v-bind:precision="2" 
                                    v-bind:minus="false"
                                    :class="'form-control text-right ' + (test.remarkImpossibleHighValue ? 'is-invalid' : '')" 
                                    v-model="test.max_qty"
                                    @change="checkNumberHighValue(test.min_qty, test.max_qty, test)"
                                ></vue-numeric>    
                                <!-- <el-input v-model="test.max_qty"></el-input> -->
                            </td>
                            <td>
                                <input  type="hidden" 
                                        :name="'updateDataGroup['+row+'][remark_msg]'" 
                                        v-model="test.remark_msg" 
                                        autocomplete="off">
                                <el-input   v-model="test.remark_msg" 
                                            type="textarea"
                                            :rows="1"
                                            placeholder=""></el-input>
                            </td>
                            <td>
                                <button @click.prevent="removeRowTableData(row, test.setup_min_max_id)" 
                                        class="btn btn-sm btn-danger" 
                                        :v-model="test.setup_min_max_id">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                        <tr v-for="(row, index) in lines" :key="index" :row="row">
                            <td>
                                <input type="hidden" :name="'newDataGroup['+row.id+'][item_number]'" v-model="row.itemNumber" autocomplete="off">
                                <el-select  v-model="row.itemNumber"
                                            filterable
                                            remote  
                                            reserve-keyword
                                            class="w-100"
                                            placeholder="Select"
                                            v-loading="loading.itemNumber"
                                            @input="checkInput"
                                            @change="getUom(row.itemNumber, row, organization)">
                                    <el-option
                                        v-for="(itemNumber, index) in row.itemNumbersList"
                                        :key="index"
                                        :label="itemNumber.item_number + ' : ' + itemNumber.item_desc"
                                        :value="itemNumber.inventory_item_id">
                                    </el-option>
                                </el-select>
                            </td>
                            <td style="vertical-align:middle; padding-left: 10px;"> 
                                {{ row.itemNumberDes }} 
                            </td>
                            <td>
                                <el-input v-model="row.primaryUnitOfMeasure" v-loading="loading.primaryUnitOfMeasure" :disabled="true"></el-input>
                            </td>
                            <td>
                                <input type="hidden" :name="'newDataGroup['+row.id+'][min_qty]'" v-model="row.minQty" autocomplete="off">
                                <!-- <el-input placeholder="" v-model="row.minQty" type="number" @input="checkInput"></el-input> -->
                                <vue-numeric 
                                    separator="," 
                                    v-bind:precision="2" 
                                    v-bind:minus="false"
                                    :class="'form-control text-right ' + (row.remarkImpossibleSmallValue ? 'is-invalid' : '')"
                                    v-model="row.minQty"
                                    @change="checkNumberSmallValue(row.minQty, row.maxQty, row)"                                    
                                ></vue-numeric>
                            </td>
                            <td>
                                <input type="hidden" :name="'newDataGroup['+row.id+'][max_qty]'" v-model="row.maxQty" autocomplete="off">
                                <!-- <el-input placeholder="" v-model="row.maxQty" type="number" @input="checkInput"></el-input> -->
                                <vue-numeric 
                                    separator="," 
                                    v-bind:precision="2" 
                                    v-bind:minus="false"
                                    :class="'form-control text-right ' + (row.remarkImpossibleHighValue ? 'is-invalid' : '')"
                                    v-model="row.maxQty"
                                    @change="checkNumberHighValue(row.minQty, row.maxQty, row)"
                                ></vue-numeric>
                            </td>
                            <td>
                                <input type="hidden" :name="'newDataGroup['+row.id+'][remark_msg]'" v-model="row.note" autocomplete="off">
                                <el-input
                                    type="textarea"
                                    :rows="1"
                                    placeholder=""
                                    v-model="row.note"
                                    @input="checkInput">
                                </el-input>
                            </td>
                            <td>
                                <button @click.prevent="removeRow(index)" class="btn btn-sm btn-danger col text-center">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>

                    <tbody v-else>
                        <tr>
                            <td class="text-center" colspan="8">
                                <h2>{{'โปรดทำการเลือก Organization คลังจัดเก็บ/สถานที่จัดเก็บ และรหัสวัตถุดิบ ก่อน'}}</h2>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="col-12 mt-3">
                    <div class="row clearfix text-right">
                        <div class="col" style="margin-top: 15px;">
                            <button :class="btnTrans.save.class" :disabled="isDisabledBtuAdd"> 
                                <i :class="btnTrans.save.icon" aria-hidden="true"></i> {{ btnTrans.save.text }} 
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import VueNumeric from 'vue-numeric'
import uuidv1 from 'uuid/v1';
export default {
    props: ['organizationSearch', 'listSetupMinMax', 'listSearchItemNumber', 'itemNumberSearch', 'btnTrans', 'searched'],

    watch: {
        listSetupMinMax: async function (value) {
            this.testList = value
        },
        organizationSearch: async function (value1) {
            this.organization = value1
        },
        itemNumberSearch: async function (value2) {
            this.itemNumber = value2
        },
    },

    components: {
        VueNumeric
    },

    data() {
        return {
            checkedEdit: '',
            itemNumber: '',
            primaryUnitOfMeasure: '',
            minQty: '',
            maxQty: '',
            note: '',
            checkedEditUpdate: '',
            organization: this.organizationSearch,
            itemNumberDes: '',
            statusDup: '',
            uomList: [],
            lines: [],
            isDisabledBtuAdd: true,
            testList: this.listSetupMinMax,
            loading: {
                location : false,
                itemNumber: false,
                primaryUnitOfMeasure: false,
                itemcat: false,
            },
            id: uuidv1(),
            isTextFlag: true,
        };
    },
    mounted() {
 
    },
    computed:{
        
    },
    methods: {
        checkNumberSmallValue(min, max, arrayData){
            if(max != 0 && min > max){
                arrayData.remarkImpossibleSmallValue = true;
                this.isDisabledBtuAdd = true;
                swal({
                    title: "เกิดข้อผิดพลาด !",
                    text: "ค่าเฝ้าระวังต่ำสุดมีค่ามากกว่าค่าเฝ้าระวังสูงสุด จะไม่สามารถบันทึกข้อมูลได้",
                    type: "error",
                    showConfirmButton: true
                });
            }else{
                arrayData.remarkImpossibleSmallValue = false;
                arrayData.remarkImpossibleHighValue = false;
                this.isDisabledBtuAdd = false;
            }
        },
        checkNumberHighValue(min, max, arrayData){
            if(max != 0 && min > max){
                arrayData.remarkImpossibleHighValue = true;
                this.isDisabledBtuAdd = true;
                swal({
                    title: "เกิดข้อผิดพลาด !",
                    text: "ค่าเฝ้าระวังสูงสุดมีค่าน้อยกว่าค่าเฝ้าระวังต่ำ จะไม่สามารถบันทึกข้อมูลได้",
                    type: "error",
                    showConfirmButton: true
                });
            }else{
                arrayData.remarkImpossibleHighValue = false;
                arrayData.remarkImpossibleSmallValue = false;
                this.isDisabledBtuAdd = false;
            }
        },
        checkInput(){
            this.lines.forEach(async (element,i) => {
                if(element.itemNumber && element.maxQty && element.minQty && element.note){
                    console.log('have data');
                    this.isDisabledBtuAdd = false;
                }else{
                    console.log('no data');
                    this.isDisabledBtuAdd = true;
                }
            });
        },
        async hasItem(itemNumber) {
            let vm = this;
            let checkItem = false;

            if(vm.listSetupMinMax != 'NoSearchData'){
                vm.listSetupMinMax.forEach(async (element,i) => {
                    if (element.item_number == itemNumber) {
                        checkItem = true;
                    }
                });
            }        
                
            vm.lines.forEach(async (element,i) => {
                if (element.itemNumber == itemNumber) {
                    checkItem = true;
                }
            });

            return checkItem;
        },
        async addLine() {
            let vm = this;
            let itemNumbersList = [];
            if(this.organizationSearch == '' || !this.searched) {
                this.$message({type:'error', message: 'ไม่สามารถทำรายการได้กรุณาเลือกข้อมูล ประเภทวัตถุดิบ'})
                return false;
            }
            vm.listSearchItemNumber.forEach(async (element,i) => {
                if (!await vm.hasItem(element.item_number)) {
                    itemNumbersList.push(element);
                }
            })
            console.log(itemNumbersList)
            
            this.lines.push({
                id              : uuidv1(),
                itemNumber      : '',
                itemNumberDes   : '',
                primaryUnitOfMeasure: '',
                minQty          : '',
                maxQty          : '',
                note            : '',
                itemNumbersList : itemNumbersList,
                remarkImpossibleSmallValue : false,
                remarkImpossibleHighValue : false,
            });

            this.isDisabledBtuAdd = true;
            this.isTextFlag = false;
        },
        removeRow: function(index) {    
            this.lines.splice(index, 1);
            this.isDisabledBtuAdd = false;
            if(this.lines.length == 0){
                this.isTextFlag = true;
            }else{
                this.isTextFlag = false;
            }
        },
        async getUom(value, row, organization) {
            row.itemNumbersList.forEach(element => {
                if(element.inventory_item_id == value){
                    row.itemNumber = element.item_number;
                    row.itemNumberDes = element.item_desc;  
                }
            }); 

            var params = {
                inventoryItemId: value,
                organization: organization
            };
            //this.loading.primaryUomCode = true;
            this.loading.primaryUnitOfMeasure = true;
            return await axios
                .get('/pm/ajax/setup-min-max-by-item/get-uom',{ params })
                .then(res => {
                    if(res.data.data.dataUom == ''){
                        row.primaryUnitOfMeasure = '';
                        this.loading.primaryUnitOfMeasure = false;
                    }else{
                        if(row.statusDup == 'Dup'){
                            this.loading.primaryUnitOfMeasure = false;
                            row.primaryUnitOfMeasure = '';
                            row.statusDup = '';
                        }else{
                            this.uomList = res.data.data.dataUom;
                            row.primaryUnitOfMeasure = this.uomList[0].primary_unit_of_measure; 
                            this.loading.primaryUnitOfMeasure = false;
                        }
                    }
                });
                
        },  
        removeRowTableData: function(row, setupMinMaxId){
            var params = {
                row : row,
                setupMinMaxId : setupMinMaxId
            };
            swal({
                    title: "คุณแน่ใจ?",
                    text: "คุณต้องการลบข้อมูลใช่หรือไม่",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-warning',
                    confirmButtonText: "ยืนยัน",
                    cancelButtonText: "ยกเลิก",
                    closeOnConfirm: false
                },                    
                function (isConfirm) {
                    if(isConfirm){
                        axios   .get('/pm/ajax/setup-min-max-by-item/destroy',{ params })
                                .then( res =>{ 
                                    swal({  title: "success !", 
                                            text: "ข้อมูลได้ทำการลบเรียบร้อยแล้ว", 
                                            type: "success",
                                            showConfirmButton: false
                                    });
                                    window.location.reload(false); 
                                });   
                    }
                });  
        },
    }
};
</script>
