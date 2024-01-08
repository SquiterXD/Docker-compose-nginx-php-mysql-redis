<template>
    <div>
        <div class="row" style="padding-bottom: 15px;">
            <div class="col-12 text-right">
                <button class="btn btn-primary" 
                        style="margin-right: 10px;" 
                        @click.prevent="addLine"> 
                    <i class="fa fa-plus" aria-hidden="true"></i> เพิ่มรายการ 
                </button>

                <button 
                    :class="btnTrans.save.class"> 
                    <i :class="btnTrans.save.icon" aria-hidden="true"></i> 
                    {{ btnTrans.save.text }} 
                </button>
            </div>
        </div>

        <div style="overflow-x:scroll; white-space: nowrap;">
            <table class="table program_info_tb tablePrintConversion">
                <thead>
                    <tr>
                        <th class="text-center" 
                            style="font-size: small;">
                            <div>สถานะการใช้งาน</div>
                        </th>
                        <th class="text-center" 
                            style="font-size: small;">
                            <div>ระบบการพิมพ์</div>
                        </th>
                        <th class="text-center" 
                            style="font-size: small;">
                            <div>ประเภทสิ่งพิมพ์</div>
                        </th>
                        <th class="text-center" 
                            style="font-size: small;">
                            <div>ขนาดบุหรี่</div>
                        </th>
                        <th class="text-center" 
                            style="font-size: small;"
                            v-if="search.printItemCat == printTypeCode.offset">
                            <div>Layout แม่พิมพ์</div>
                        </th>
                        <th class="text-center" 
                            style="font-size: small;"
                            v-if="search.printItemCat == printTypeCode.offset">
                            <div>Layout กระดาษใหญ่</div>
                        </th>
                        <th class="text-right" 
                            style="font-size: small;"
                            v-if="search.printItemCat == printTypeCode.gravure">
                            <div>จำนวนชิ้น/Bobbin</div>
                        </th>
                        <th class="text-right" 
                            style="font-size: small;"
                            v-if="search.printItemCat == printTypeCode.gravure">
                            <div>Bobbin/ROL</div>
                        </th>
                        <th class="text-right" 
                            style="font-size: small;"
                            v-if="search.printItemCat == printTypeCode.gravure">
                            <div>จำนวนชิ้น/ROL</div>
                        </th>
                        <th class="text-right" 
                            style="font-size: small;"
                            v-if="search.printItemCat == printTypeCode.gravure">
                            <div>จำนวนชิ้น/หีบ</div>
                        </th>
                        <th class="text-right" 
                            style="font-size: small;"
                            v-if="search.printItemCat == printTypeCode.gravure">
                            <div>จำนวนหีบ/ROL</div>
                        </th>
                        <th class="text-right" 
                            style="font-size: small;"
                            v-if="search.printItemCat == printTypeCode.gravure">
                            <div>มวน/ซอง</div>
                        </th>
                        <th class="text-right" 
                            style="font-size: small;"
                            v-if="search.printItemCat == printTypeCode.contract_manuf">
                            <div>จำนวนเมตร/ROL</div>
                        </th>
                        <th class="text-right" 
                            style="font-size: small;"
                            v-if="search.printItemCat == printTypeCode.contract_manuf">
                            <div>จำนวนเดวง/แผ่น</div>
                        </th>
                        <th class="text-right" 
                            style="font-size: small;"
                            v-if="search.printItemCat == printTypeCode.contract_manuf">
                            <div>Bobbin/ROL</div>
                        </th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="(data, index) in listData" :key="index" :row="index">
                        <input  type="hidden" 
                                :name="'updateDataGroup['+index+'][id]'" 
                                v-model="data.id" 
                                autocomplete="off">
                        <td style="text-align: center; vertical-align:middle;" :data-sort="data.enableFlag">
                            <input  type="hidden" 
                                    :name="'updateDataGroup['+index+'][enable_flag]'" 
                                    v-model="data.enableFlag" 
                                    autocomplete="off">
                            <el-checkbox :disabled="data.is_select" v-model="data.enableFlag" ></el-checkbox>
                        </td>
                        <td>
                            <input  type="hidden" 
                                    :name="'updateDataGroup['+index+'][cost_category_segment1]'" 
                                    v-model="data.cost_category_segment1" 
                                    autocomplete="off">
                            <el-input
                                v-model="data.cost_category_set_name"
                                :disabled="true">
                            </el-input>
                        </td>
                        <td :data-sort="data.category_set_name">
                            <input  type="hidden" 
                                    :name="'updateDataGroup['+index+'][category_segment1]'" 
                                    v-model="data.category_segment1" 
                                    autocomplete="off">
                            <input  type="hidden" 
                                    :name="'updateDataGroup['+index+'][category_segment2]'" 
                                    v-model="data.category_segment2" 
                                    autocomplete="off">
                            <el-input
                                v-model="data.category_set_name"
                                :disabled="true">
                            </el-input>
                        </td>
                        <td v-if="data.lookup_values.length != 0">
                            <input  type="hidden" 
                                    :name="'updateDataGroup['+index+'][tobacco_size]'" 
                                    v-model="data.tobacco_size" 
                                    autocomplete="off">
                            <el-input  
                                v-model="data.tobacco_size"
                                :disabled="true">
                            </el-input>
                        </td>
                        <td v-else>
                            <el-input  
                                v-model="data.tobacco_size"
                                :disabled="true">
                            </el-input>
                        </td>
                        <td v-if="search.printItemCat == printTypeCode.gravure">
                            <input  type="hidden" 
                                    :name="'updateDataGroup['+index+'][e00_to_bobbin]'" 
                                    v-model="data.e00_to_bobbin" 
                                    autocomplete="off">
                            <vue-numeric 
                                separator="," 
                                v-bind:precision="2" 
                                v-bind:minus="false"
                                class="form-control text-right" 
                                v-model="data.e00_to_bobbin"
                                :disabled="data.is_select"
                            ></vue-numeric>
                        </td>
                        <td v-if="search.printItemCat == printTypeCode.gravure">
                            <input  type="hidden" 
                                    :name="'updateDataGroup['+index+'][bobbin_to_rol]'" 
                                    v-model="data.bobbin_to_rol" 
                                    autocomplete="off">
                            <vue-numeric 
                                separator="," 
                                v-bind:precision="2" 
                                v-bind:minus="false"
                                class="form-control text-right" 
                                v-model="data.bobbin_to_rol"
                                :disabled="data.is_select"
                            ></vue-numeric>
                        </td>
                        <td v-if="search.printItemCat == printTypeCode.gravure">
                            <input  type="hidden" 
                                    :name="'updateDataGroup['+index+'][e00_to_rol]'" 
                                    v-model="data.e00_to_rol" 
                                    autocomplete="off">
                            <vue-numeric 
                                separator="," 
                                v-bind:precision="2" 
                                v-bind:minus="false"
                                class="form-control text-right" 
                                v-model="data.e00_to_rol"
                                :disabled="data.is_select"
                            ></vue-numeric>
                        </td>
                        <td v-if="search.printItemCat == printTypeCode.gravure">
                            <input  type="hidden" 
                                    :name="'updateDataGroup['+index+'][e00_to_ca1]'" 
                                    v-model="data.e00_to_ca1" 
                                    autocomplete="off">
                            <vue-numeric 
                                separator="," 
                                v-bind:precision="2" 
                                v-bind:minus="false"
                                class="form-control text-right" 
                                v-model="data.e00_to_ca1"
                                :disabled="data.is_select"
                            ></vue-numeric>
                        </td>
                        <td v-if="search.printItemCat == printTypeCode.gravure">
                            <input  type="hidden" 
                                    :name="'updateDataGroup['+index+'][ca1_to_rol]'" 
                                    v-model="data.ca1_to_rol" 
                                    autocomplete="off">
                            <vue-numeric 
                                separator="," 
                                v-bind:precision="2" 
                                v-bind:minus="false"
                                class="form-control text-right" 
                                v-model="data.ca1_to_rol"
                                :disabled="data.is_select"
                            ></vue-numeric>
                        </td>
                        <td v-if="search.printItemCat == printTypeCode.gravure">
                            <input  type="hidden" 
                                    :name="'updateDataGroup['+index+'][cg_to_e18]'" 
                                    v-model="data.cg_to_e18" 
                                    autocomplete="off">
                            <vue-numeric 
                                separator="," 
                                v-bind:precision="2" 
                                v-bind:minus="false"
                                class="form-control text-right" 
                                v-model="data.cg_to_e18"
                                :disabled="data.is_select"
                            ></vue-numeric>
                        </td>
                        <td v-if="search.printItemCat == printTypeCode.offset">
                            <input  type="hidden" 
                                    :name="'updateDataGroup['+index+'][molding_layout]'" 
                                    v-model="data.molding_layout" 
                                    autocomplete="off">
                            <vue-numeric 
                                separator="," 
                                v-bind:precision="0" 
                                v-bind:minus="false"
                                class="form-control text-right" 
                                v-model="data.molding_layout"
                                :disabled="data.is_select"
                            ></vue-numeric>
                        </td>
                        <td v-if="search.printItemCat == printTypeCode.offset">
                            <input  type="hidden" 
                                    :name="'updateDataGroup['+index+'][paper_layout]'" 
                                    v-model="data.paper_layout" 
                                    autocomplete="off">
                            <vue-numeric 
                                separator="," 
                                v-bind:precision="0" 
                                v-bind:minus="false"
                                class="form-control text-right" 
                                v-model="data.paper_layout"
                                :disabled="data.is_select"
                            ></vue-numeric>
                        </td>
                        <td v-if="search.printItemCat == printTypeCode.contract_manuf">
                            <input  type="hidden" 
                                    :name="'updateDataGroup['+index+'][meter_to_rol]'" 
                                    v-model="data.meter_to_rol" 
                                    autocomplete="off">
                            <vue-numeric 
                                separator="," 
                                v-bind:precision="2" 
                                v-bind:minus="false"
                                class="form-control text-right" 
                                v-model="data.meter_to_rol"
                                :disabled="data.is_select"
                            ></vue-numeric>
                        </td>
                        <td v-if="search.printItemCat == printTypeCode.contract_manuf">
                            <input  type="hidden" 
                                    :name="'updateDataGroup['+index+'][st_to_pg]'" 
                                    v-model="data.st_to_pg" 
                                    autocomplete="off">
                            <vue-numeric 
                                separator="," 
                                v-bind:precision="2" 
                                v-bind:minus="false"
                                class="form-control text-right" 
                                v-model="data.st_to_pg"
                                :disabled="data.is_select"
                            ></vue-numeric>
                        </td>
                        <td v-if="search.printItemCat == printTypeCode.contract_manuf">
                            <input  type="hidden" 
                                    :name="'updateDataGroup['+index+'][bobbin_to_rol]'" 
                                    v-model="data.bobbin_to_rol" 
                                    autocomplete="off">
                            <vue-numeric 
                                separator="," 
                                v-bind:precision="2" 
                                v-bind:minus="false"
                                class="form-control text-right" 
                                v-model="data.bobbin_to_rol"
                                :disabled="data.is_select"
                            ></vue-numeric>
                        </td>
                        <td style="text-align: center; vertical-align:middle;">
                            <el-checkbox v-model="data.checkedEditUpdate" @change="checkEdit(data.checkedEditUpdate, data)"></el-checkbox>
                        </td>
                        <!-- <td>
                            <button @click.prevent="removeRowTableData(data.category_segment1, data.category_segment2, data.tobacco_size)" 
                                    :class="btnTrans.delete.class">
                                <i :class="btnTrans.delete.icon" aria-hidden="true"></i>
                            </button>
                        </td> -->     
                    </tr>
                    <tr v-for="(line, index) in lines" :key="'inputData'+ index" :row="index">
                        <td style="text-align: center; vertical-align:middle;">
                            <input  type="hidden" 
                                    :name="'newDataGroup['+index+'][enable_flag]'" 
                                    v-model="line.enableFlag" 
                                    autocomplete="off">
                            <el-checkbox v-model="line.enableFlag" ></el-checkbox>
                        </td>
                        <td>
                            <input  type="hidden" 
                                    :name="'newDataGroup['+index+'][printItemCat]'" 
                                    v-model="line.printItemCat" 
                                    autocomplete="off">
                            <el-select  v-model="line.printItemCat" 
                                        placeholder="โปรดเลือกระบบการพิมพ์"
                                        class="w-100"
                                        clearable 
                                        filterable
                                        remote 
                                        reserve-keyword
                                        @change="getPrintType(line.printItemCat, line)">
                                <el-option
                                    v-for="(itemcat,index) in printItemCatList"
                                    :key="index"
                                    :label="itemcat.cost_description"
                                    :value="itemcat.cost_segment1">
                                </el-option>
                            </el-select>
                        </td>
                        <td>
                            <input  type="hidden" 
                                    :name="'newDataGroup['+index+'][category]'" 
                                    v-model="line.category" 
                                    autocomplete="off">
                            <el-select  class="w-100"
                                        v-model="line.category" 
                                        placeholder="เลือกประเภทสิ่งพิมพ์"
                                        clearable
                                        v-loading="line.loading.category"
                                        :disabled="line.disabled.category">
                                <el-option
                                    v-for="(category,index) in line.categoryList"
                                    :key="index"
                                    :label="category.toat_description"
                                    :value="category.toat_segment1 + '.' + category.toat_segment2">
                                </el-option>
                            </el-select>
                        </td>
                        <td>
                            <input  type="hidden" 
                                    :name="'newDataGroup['+index+'][lookupValues]'" 
                                    v-model="line.lookupValues" 
                                    autocomplete="off">
                            <el-select  class="w-100"
                                        v-model="line.lookupValues" 
                                        placeholder="เลือกขนาดบุหรี่"
                                        clearable
                                        :disabled="!line.category">
                                <el-option
                                    v-for="(lookupValue,index) in lookupValues"
                                    :key="index"
                                    :label="lookupValue.meaning"
                                    :value="lookupValue.lookup_code">
                                </el-option>
                            </el-select>
                        </td>
                        <td v-if="search.printItemCat == printTypeCode.gravure">
                            <input  type="hidden" 
                                    :name="'newDataGroup['+index+'][e00_to_bobbin]'" 
                                    v-model="line.e00_to_bobbin" 
                                    autocomplete="off">
                            <vue-numeric 
                                separator="," 
                                v-bind:precision="2" 
                                v-bind:minus="false"
                                class="form-control text-right" 
                                v-model="line.e00_to_bobbin"
                                :disabled="!line.category"
                            ></vue-numeric>
                        </td>
                        <td v-if="search.printItemCat == printTypeCode.gravure">
                            <input  type="hidden" 
                                    :name="'newDataGroup['+index+'][bobbin_to_rol]'" 
                                    v-model="line.bobbin_to_rol" 
                                    autocomplete="off">
                            <vue-numeric 
                                separator="," 
                                v-bind:precision="2" 
                                v-bind:minus="false"
                                class="form-control text-right" 
                                v-model="line.bobbin_to_rol"
                                :disabled="!line.category"
                            ></vue-numeric>
                        </td>
                        <td v-if="search.printItemCat == printTypeCode.gravure">
                            <input  type="hidden" 
                                    :name="'newDataGroup['+index+'][e00_to_rol]'" 
                                    v-model="line.e00_to_rol" 
                                    autocomplete="off">
                            <vue-numeric 
                                separator="," 
                                v-bind:precision="2" 
                                v-bind:minus="false"
                                class="form-control text-right" 
                                v-model="line.e00_to_rol"
                                :disabled="!line.category"
                            ></vue-numeric>
                        </td>
                        <td v-if="search.printItemCat == printTypeCode.gravure">
                            <input  type="hidden" 
                                    :name="'newDataGroup['+index+'][e00_to_ca1]'" 
                                    v-model="line.e00_to_ca1" 
                                    autocomplete="off">
                            <vue-numeric 
                                separator="," 
                                v-bind:precision="2" 
                                v-bind:minus="false"
                                class="form-control text-right" 
                                v-model="line.e00_to_ca1"
                                :disabled="!line.category"
                            ></vue-numeric>
                        </td>
                        <td v-if="search.printItemCat == printTypeCode.gravure">
                            <input  type="hidden" 
                                    :name="'newDataGroup['+index+'][ca1_to_rol]'" 
                                    v-model="line.ca1_to_rol" 
                                    autocomplete="off">
                            <vue-numeric 
                                separator="," 
                                v-bind:precision="2" 
                                v-bind:minus="false"
                                class="form-control text-right" 
                                v-model="line.ca1_to_rol"
                                :disabled="!line.category"
                            ></vue-numeric>
                        </td>
                        <td v-if="search.printItemCat == printTypeCode.gravure">
                            <input  type="hidden" 
                                    :name="'newDataGroup['+index+'][cg_to_e18]'" 
                                    v-model="line.cg_to_e18" 
                                    autocomplete="off">
                            <vue-numeric 
                                separator="," 
                                v-bind:precision="2" 
                                v-bind:minus="false"
                                class="form-control text-right" 
                                v-model="line.cg_to_e18"
                                :disabled="!line.category"
                            ></vue-numeric>
                        </td>                       
                        <td v-if="search.printItemCat == printTypeCode.offset">
                            <input  type="hidden" 
                                    :name="'newDataGroup['+index+'][molding_layout]'" 
                                    v-model="line.molding_layout" 
                                    autocomplete="off">
                            <vue-numeric 
                                separator="," 
                                v-bind:precision="0" 
                                v-bind:minus="false"
                                class="form-control text-right" 
                                v-model="line.molding_layout"
                            ></vue-numeric>
                        </td>
                        <td v-if="search.printItemCat == printTypeCode.offset">
                            <input  type="hidden" 
                                    :name="'newDataGroup['+index+'][paper_layout]'" 
                                    v-model="line.paper_layout" 
                                    autocomplete="off">
                            <vue-numeric 
                                separator="," 
                                v-bind:precision="0" 
                                v-bind:minus="false"
                                class="form-control text-right" 
                                v-model="line.paper_layout"
                            ></vue-numeric>
                        </td>
                        <td v-if="search.printItemCat == printTypeCode.contract_manuf">
                            <input  type="hidden" 
                                    :name="'newDataGroup['+index+'][meter_to_rol]'" 
                                    v-model="line.meter_to_rol" 
                                    autocomplete="off">
                            <vue-numeric 
                                separator="," 
                                v-bind:precision="2" 
                                v-bind:minus="false"
                                class="form-control text-right" 
                                v-model="line.meter_to_rol"
                                :disabled="!line.category"
                            ></vue-numeric>
                        </td>
                        <td v-if="search.printItemCat == printTypeCode.contract_manuf">
                            <input  type="hidden" 
                                    :name="'newDataGroup['+index+'][st_to_pg]'" 
                                    v-model="line.st_to_pg" 
                                    autocomplete="off">
                            <vue-numeric 
                                separator="," 
                                v-bind:precision="2" 
                                v-bind:minus="false"
                                class="form-control text-right" 
                                v-model="line.st_to_pg"
                                :disabled="!line.category"
                            ></vue-numeric>
                        </td>
                        <td v-if="search.printItemCat == printTypeCode.contract_manuf">
                            <input  type="hidden" 
                                    :name="'newDataGroup['+index+'][bobbin_to_rol]'" 
                                    v-model="line.bobbin_to_rol" 
                                    autocomplete="off">
                            <vue-numeric 
                                separator="," 
                                v-bind:precision="2" 
                                v-bind:minus="false"
                                class="form-control text-right" 
                                v-model="line.bobbin_to_rol"
                                :disabled="!line.category"
                            ></vue-numeric>
                        </td>
                        <td>
                            <button @click.prevent="removeRow(index)" 
                                :class="btnTrans.delete.class">
                                <i :class="btnTrans.delete.icon" aria-hidden="true"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import VueNumeric from 'vue-numeric'
export default {
    props: ['listConversion', 'lookupValues', 'btnTrans', 'printItemCatList', 'search', 'printTypeCode'],
    components: {
        VueNumeric
    },
    data() {
        return {
            listData: this.listConversion.data,
            lines: [],
        }
    }, 
    mounted(){
        $('.tablePrintConversion').dataTable( {
            "searching": false,
            "bInfo": false
        });
        // if(this.search.printItemCat == this.printTypeCode.gravure){
        //     $('.tablePrintConversion').dataTable( {
        //         "searching": false,
        //         "bInfo": false,
        //         columnDefs: [
        //             { orderable: false, targets: 3 },
        //             { orderable: false, targets: 4 },
        //             { orderable: false, targets: 5 },
        //             { orderable: false, targets: 6 },
        //             { orderable: false, targets: 7 },
        //             { orderable: false, targets: 8 }
        //         ]
        //     });
        // } 
    },
    methods: {
        checkEdit(checkedEditUpdate, data) {
            if(checkedEditUpdate){
                data.is_select = false;
            }else{
                data.is_select = true;
            }
        },
        addLine() {
            if(this.search.printItemCat == this.printTypeCode.gravure){
                this.lines.push({
                    category_set_name   : '',
                    tobacco_size        : this.search ? this.search.tobaccoSize : '',
                    e00_to_bobbin       : 0,
                    bobbin_to_rol       : 0,
                    e00_to_rol          : 0,
                    e00_to_ca1          : 0,
                    ca1_to_rol          : 0,
                    meter_to_rol        : 0,
                    cg_to_e18           : 0,
                    enableFlag          : true,
                    category            : '',
                    printItemCat        : this.search ? this.search.printItemCat : '',
                    loading:{
                        category        : false
                    },
                    disabled: {
                        category        : true
                    },
                    categoryList        : [],
                });
            }else if(this.search.printItemCat == this.printTypeCode.contract_manuf){
                this.lines.push({
                    category_set_name   : '',
                    tobacco_size        : this.search ? this.search.tobaccoSize : '',
                    meter_to_rol        : 0,
                    st_to_pg            : 0,
                    bobbin_to_rol       : 0,
                    enableFlag          : true,
                    category            : '',
                    printItemCat        : this.search ? this.search.printItemCat : '',
                    molding_layout      : '',
                    paper_layout        : '',
                    loading:{
                        category        : false
                    },
                    disabled: {
                        category        : true
                    },
                    categoryList        : [],
                });
            }else{
                this.lines.push({
                    category_set_name   : '',
                    tobacco_size        : this.search ? this.search.tobaccoSize : '',
                    enableFlag          : true,
                    category            : '',
                    printItemCat        : this.search ? this.search.printItemCat : '',
                    molding_layout      : '',
                    paper_layout        : '',
                    loading:{
                        category        : false
                    },
                    disabled: {
                        category        : true
                    },
                    categoryList        : [],
                });
            }            

            if(this.lines.length != 0){
                $('.tablePrintConversion').find(".dataTables_empty").parents('tbody').empty();
            }

            if(this.search && this.search.printItemCat){
                this.getPrintType(this.search.printItemCat, this.lines[this.lines.length-1])
            }
        },
        removeRow: function(row) {    
            this.lines.splice(row, 1);
        },
        async getPrintType(printItemCat, line) {
            let vm = this;
            if(vm.search && vm.search.category){
                line.category = vm.search.category;
            }else{
                line.category = '';
            }
            line.loading.category = true;
            var params = {
                printItemCat: printItemCat,
            };
            return await axios
                .get('/pm/ajax/print-conversion/get-printType',{ params })
                .then(res => {                    
                    if(res.data.printTypeList.length != 0){
                        line.categoryList = res.data.printTypeList;
                        line.loading.category = false;
                        line.disabled.category = false;
                    }else{
                        line.categoryList = [];
                        line.loading.category = false;
                        line.disabled.category = true;
                    }
                });                
        }, 
        // removeRowTableData: function(segment1, segment2, tobaccoSize){
        //     var params = {
        //         segment1 : segment1,
        //         segment2 : segment2,
        //         tobaccoSize : tobaccoSize
        //     };
        //     swal({
        //             title: "Are you sure?",
        //             text: "You will not be able to recover this data!",
        //             type: "warning",
        //             showCancelButton: true,
        //             confirmButtonClass: 'btn btn-warning',
        //             confirmButtonText: "Confirm",
        //             closeOnConfirm: false
        //         },                    
        //         function (isConfirm) {
        //             if(isConfirm){
        //                 axios   .get('/pm/ajax/print-conversion/destroy',{ params })
        //                         .then( res =>{ 
        //                             swal({  title: "success !", 
        //                                     text: "ข้อมูลได้ทำการลบเรียบร้อยแล้ว", 
        //                                     type: "success",
        //                                     showConfirmButton: false
        //                             });
        //                             window.location.reload(false); 
        //                         });   
        //             }
        //         });  
        // },
    },

}
</script>