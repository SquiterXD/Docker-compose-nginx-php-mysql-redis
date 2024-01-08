<template>
    <div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center"><small>รหัสวัตถุดิบ</small></th>
                    <th class="text-center"><small>รายละเอียด</small></th>
                    <th class="text-center">
                        <small>ปริมาณที่ต้องใช้+สูญเสีย</small>
                    </th>
                    <th class="text-center"><small>Lot No. <span class="tw-text-red-500">*</span></small></th>
                    <th class="text-center">
                        <small>ปริมาณคงคลังโซนผลิต</small>
                    </th>
                    <th class="text-center"><small>ปริมาณที่ใช้จริง</small><span class="tw-text-red-500">*</span></small> </th>
                    <th class="text-center"><small>หน่วยนับ</small></th>
                </tr>
            </thead>
            <tbody v-for="(groupByFormula, line) in groupByFormulas"
                :key="line">
                <tr v-for="(formula, index) in groupByFormula" :key="index">
                    <td :class="
                                classTextRed(
                                        groupByFormulas[line][index],
                                        groupByFormulas[line],
                                        groupByFormulas[line][index].quantity_summary
                                        )
                                    ? 'tw-text-red-500 text-center'
                                    : ' text-center'
                            ">
                        <small v-show="index == 0"  :class="false ? 'tw-text-red-500' : '' ">
                            {{  groupByFormulas[line][index].item_number}}
                         </small>
                         {{ lotLists(groupByFormulas[line],groupByFormulas[line][index].onhand_lists) }}
                    </td>
                    <td :class="
                                classTextRed(
                                        groupByFormulas[line][index],
                                        groupByFormulas[line],
                                        groupByFormulas[line][index].quantity_summary
                                        )
                                    ? 'tw-text-red-500'
                                    : ''
                            ">
                        <small v-show="index ==0" :class="false ? 'tw-text-red-500' : '' ">{{  groupByFormulas[line][index].item_desc }}</small>
                    </td>
                    <td :class="
                                classTextRed(
                                        groupByFormulas[line][index],
                                        groupByFormulas[line],
                                        groupByFormulas[line][index].quantity_summary
                                        )
                                    ? 'tw-text-red-500 text-right'
                                    : ' text-right'
                            ">
                        <small v-show="index ==0" :class="false ? 'tw-text-red-500' : '' ">
                            {{ numberFormat(groupByFormulas[line][index].quantity_summary) }}
                        </small>
                    </td>
                    <td class="pr-lg-5 text-nowrap">
                        <small>

                            <el-select
                                @input="onClickButton"
                                v-model="groupByFormulas[line][index].default_lot_no"
                                @change="
                                    selectOnhand(
                                        line,
                                        index,
                                        groupByFormulas[line][index],
                                        groupByFormulas[line][index].default_lot_no
                                    )
                                "
                                placeholder="Select"
                                size="mini"
                                class="form-control-file"
                                :disabled="disabledInput(groupByFormulas[line][index])"
                            >
                                <el-option
                                    v-for="item in groupByFormulas[line][index].onhand_lists"
                                    :key="item.lot_number"
                                    :label="item.lot_number"
                                    :value="item.lot_number"

                                >
                                    <span style="float: left">{{'lot: '+ item.lot_number+ ' ' }}</span>
                                    <span style="float: right" class="ml-4">{{' onhand: '+ numberFormat(item.onhand_quantity) }}</span>
                                </el-option>
                            </el-select>
                            <span
                                class="text-right mr-2"
                                v-if="!disabledInput(groupByFormulas[line][index])"
                            >
                                 <a v-if="groupByFormulas[line].length === index+1" 
                                    @click="addRow(groupByFormulas[line][index])"
                                    @input="onClickButton"
                                >
                                    <i class="fa fa-plus-square"></i>
                                </a>

                                <a v-if="index !== 0" 
                                    @click.prevent="delRow(groupByFormulas[line][index])"
                                    >
                                    <i class="fa fa-minus-square"></i>
                                </a>
                            </span>
                        </small>
                    </td>
                    <td :class="
                                classTextRed(
                                        groupByFormulas[line][index],
                                        groupByFormulas[line],
                                        groupByFormulas[line][index].quantity_summary
                                        )
                                    ? 'tw-text-red-500 text-right'
                                    : ' text-right'
                            ">
                        <small :class="false ? 'tw-text-red-500' : '' ">

                            {{ numberFormat(groupByFormulas[line][index].onhand_quantity) }}
                        </small>
                    </td>
                    <td>
                        <small>
                            <vue-numeric 
                                separator=","
                                size="mini"
                                class="form-control text-right"
                                v-bind:precision="6" 
                                v-bind:minus="false"
                                @input="onClickButton"
                                :disabled="disabledInput(groupByFormulas[line][index])"
                                v-model="groupByFormulas[line][index].input_quantity_summary"
                                
                            ></vue-numeric>
                        </small>
                    </td>
                    <td :class="
                                classTextRed(
                                        groupByFormulas[line][index],
                                        groupByFormulas[line],
                                        groupByFormulas[line][index].quantity_summary
                                        )
                                    ? 'tw-text-red-500 text-center'
                                    : ' text-center'
                            ">
                        <small :class="false ? 'tw-text-red-500' : '' ">{{ groupByFormulas[line][index].product_unit_of_measure }}</small>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import moment from "moment";
export default {
    props: ["formulas", "opt-quantity", "action", "trans-date", "header-status", "pDisabledInput"],
    data() {
        return {
            form_lines: [],
            onhand: {},
            form: [],
            lotOnHand: [],
            uFormulas: this.formulas,
        };
    },
    mounted() {
        console.log(this.formulas);

    },
    methods: {
        updateFormLines(key, value) {
            console.log(key, value);
        },

        onClickButton(event) {
            console.log('emit')
            this.$emit("input", this.uFormulas);
            this.uFormulas.push({});
            this.uFormulas.splice(this.uFormulas.indexOf({}), 1);
        },

        changeInput(){
            this.uFormulas.push({});
            this.uFormulas.splice(this.uFormulas.indexOf({}), 1);
        },
        addRow(formula, line, index) {

            this.onhand = {};

            let newIndex = index+1;
            this.onhand.default_lot_no = 0;
            this.onhand.expiration_date = "";
            this.onhand.formulaline_id = formula.formulaline_id;
            this.onhand.from_location_code = "";
            this.onhand.from_subinventory = "";
            this.onhand.input_quantity_summary = 0;
            this.onhand.interface_status = null;
            this.onhand.item_desc = formula.item_desc;
            this.onhand.item_number = formula.item_number;
            this.onhand.last_line = true;
            this.onhand.leaf_formula = "";
            this.onhand.line_disabled = false;
            this.onhand.onhand_lists = formula.onhand_lists;
            this.onhand.onhand_quantity = 0;
            this.onhand.product_detail_uom = formula.product_detail_uom;
            this.onhand.quantity_summary = "";
            this.onhand.tobacco_ingrident_type = formula.tobacco_ingrident_type;
            this.onhand.id  = line+newIndex;
            this.onhand.casting_flavor_name = formula.casting_flavor_name;
            this.onhand.used_leaf_formula = formula.used_leaf_formula;

            this.uFormulas.push(this.onhand);
            this.$emit("input", this.uFormulas);
        },

        delRow(formula) {
            this.uFormulas.splice(this.uFormulas.indexOf(formula), 1);
            if(formula.default_lot_no){
                let onhand = formula.onhand_lists.find(item => {
                    return item.lot_number === formula.default_lot_no;
                })
                onhand.flag = 'N';
            }

            this.uFormulas.push({});
            this.uFormulas.splice(this.uFormulas.indexOf({}), 1);
        },
        selectOnhand(line,index, onhand, lot) {
            console.log(onhand);
            let onhandSelected = onhand.onhand_lists.find(item => {
                return item.lot_number == lot;
            });

            this.groupByFormulas[line][index].default_lot_no = onhandSelected.lot_number;
            this.groupByFormulas[line][index].input_quantity_summary = onhand.quantity_summary;
            this.groupByFormulas[line][index].onhand_quantity = onhandSelected.onhand_quantity;
            this.groupByFormulas[line][index].expiration_date = onhand.expiration_date;

            this.groupByFormulas[line][index].from_location_code = onhand.from_location_code;
            this.groupByFormulas[line][index].from_subinventory = onhand.from_subinventory;
            this.groupByFormulas[line][index].interface_status = onhand.interface_status;
            this.groupByFormulas[line][index].item_desc = onhand.item_desc;
            this.groupByFormulas[line][index].item_number = onhand.item_number;
            this.groupByFormulas[line][index].last_line = onhand.last_line;
            this.groupByFormulas[line][index].leaf_formula = onhand.leaf_formula;
            this.groupByFormulas[line][index].line_disabled = onhand.line_disabled;
            this.groupByFormulas[line][index].casting_flavor_name = onhand.casting_flavor_name;

            this.uFormulas.push({});
            this.uFormulas.splice(this.uFormulas.indexOf({}), 1);

        },

        fitterFromFormula(formula_id, formula) {
            const result = this.formulas.filter(formula => {
                return formula.formulaline_id == formula_id;
            });

            let id = [];
            let onhand_lists = formula.onhand_lists;
        },
        lotSum(groupByFormula) {
            return groupByFormula.reduce((acc, item) => acc+ parseFloat(item.input_quantity_summary), 0)
        },

        disabledRow(formula,groupByFormula,qty){
            if(formula.interface_status != null){return true}
            return false;
        },

        classTextRed(formula,groupByFormula,qty){
            if(formula.interface_status == "S") {
                return false
            }else {
                if ((parseInt(formula.onhand_quantity) < parseInt(formula.input_quantity_summary)) ){return true}
                
                if(formula.default_lot_no == ""){return true}
            }
        },



        dateExpire(formula){
            if(formula.expiration_date){
                return moment(formula.expiration_date).add(+543, "years").format(
                    this.transDate["js-format"]
                );
            }else{
                return ;
            }
        },

        lotLists(groupByFormulas,lots){

            lots.forEach((value,index ) => {
                const lot = groupByFormulas.find((element) => {
                    return element.default_lot_no == value.lot_number;
                });

                if(lot && lot.default_lot_no == value.lot_number){
                    value.flag = 'Y';
                }
            });

            const lotNoFlag =  lots.filter((lot) =>{
                return lot.flag != 'Y';
            })

            lotNoFlag.forEach(element => {
                element.flag = 'N';
            });

        },
        saveLot(formula){
            console.log(formula);
        },
        changeType(type){
            const formulas = this.formulas.filter(item => {
                return item.tobacco_ingrident_type == type
            });
            this.uFormulas = formulas;
        },

        numberFormat(amount){
            return  parseFloat(amount).toLocaleString(undefined, {minimumFractionDigits: 6});
        },

         disabledInput(formula) {
            if(this.pDisabledInput != false){
                return true;
            }
            if (this.pDisabledInput != '' && this.pDisabledInput != null && this.pDisabledInput != undefined && (this.pDisabledInput == true)) {
                return true;
            }

            if(this.headerStatus == 'ตัดใช้แล้ว' || this.headerStatus =='ยกเลิกตัดใช้'){
                return true;

            }
            
            if(formula.header_interface_status == 'S'){
                return true;
            }

            return false;
        },


    },
    computed: {
        orderByFormulas() {
            return _.orderBy(this.uFormulas, 'item_number')
        },
        groupByFormulas() {
            return _.groupBy(this.orderByFormulas, 'item_number')
        },


    }
};
</script>
