
<template>
    <div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">
                        <small>
                            กลุ่มใบยา
                        </small>
                    </th>
                    <th class="text-center"><small>รหัสวัตถุดิบ</small></th>
                    <th class="text-center"><small>รายละเอียด</small></th>
                    <th class="text-center"><small>Lot No.</small></th>
                    <th class="text-center">
                        <small>ปริมาณที่ต้องใช้+สูญเสีย</small>
                    </th>
                    <th class="text-center"><small>หน่วยนับ</small></th>
                    <!-- <th class="text-center"><small>วันหมดอายุ</small></th> -->
                    <th class="text-center">
                        <small>ปริมาณคงคลังโซนผลิต</small>
                    </th>
                    <th class="text-center"><small>ปริมาณที่ใช้จริง</small></th>
                    <th class="text-center"><small>หน่วยนับ</small></th>
                </tr>
            </thead>
            <tbody v-for="(groupByFormula, line) in groupByFormulas"
                :key="line">
                <tr v-for="(formula, index) in groupByFormula" :key="index">
                    <td>
                        <small v-show="index == 0"
                            :class="
                                classTextRed(
                                        groupByFormulas[line][index],
                                        groupByFormulas[line],
                                        groupByFormulas[line][index].quantity_summary
                                        )
                                    ? 'tw-text-red-500'
                                    : ''
                            "
                        >
                            {{ groupByFormulas[line][index].leaf_formula }}
                        </small>
                        
                    </td>
                    <td>
                        <small v-show="index == 0"
                            :class="
                                classTextRed(
                                        groupByFormulas[line][index],
                                        groupByFormulas[line],
                                        groupByFormulas[line][index].quantity_summary
                                        )
                                    ? 'tw-text-red-500'
                                    : ''
                            "
                        >
                            {{ groupByFormulas[line][index].item_number }}
                        </small>
                    </td>

                    <td>
                        <small v-show="index == 0"
                            :class="
                                classTextRed(
                                        groupByFormulas[line][index],
                                        groupByFormulas[line],
                                        groupByFormulas[line][index].quantity_summary
                                        )
                                    ? 'tw-text-red-500'
                                    : ''
                            "
                            > {{ groupByFormulas[line][index].item_desc }} </small
                        >
                        <p class="m-0 p-0 tw-text-2xs tw-text-red-800">{{ formula.cost_validate_msg }}</p>
                        <p class="m-0 p-0 tw-text-2xs tw-text-red-800">{{ formula.msg_onhand_tax }}</p>
                        
                    </td>
                    <td class="pr-lg-5 text-nowrap">
                        <small >
                            <el-select
                                v-model="groupByFormulas[line][index].default_lot_no"
                                @input="onClickButton"
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
                                :disabled="
                                   disabledRow(groupByFormulas[line][index], groupByFormulas[line],groupByFormulas[line][index].quantity_summary) || groupByFormulas[line][index].reference_item_number !=  null
                                "
                                class="form-control-file"
                            >
                                <el-option
                                    v-for="item in groupByFormulas[line][index].onhand_lists"
                                    :key="item.lot_number+index"
                                    :label="item.lot_number"
                                    :value="item.lot_number"
                                    :disabled="item.flag == 'Y'"
                                >
                                        <span style="float: left">{{'lot: '+ item.lot_number+ ' ' }}</span>
                                        <span style="float: right" class="ml-4">{{' onhand: '+ numberFormat(item.onhand_quantity) }}</span>

                                </el-option>
                            </el-select>
                            <span
                                class="text-center mr-2"
                            >
                                <a v-if="groupByFormulas[line].length === index+1" @click.prevent="addRow(formula,line,index)">
                                    <i v-show="groupByFormulas[line][index].reference_item_number == null & pDisabledInput == false" class="fa fa-plus-square"></i>
                                </a>
                                <a v-if="index !== 0 " @click.prevent="delRow(formula)">
                                    <i v-show="groupByFormulas[line][index].reference_item_number == null & pDisabledInput == false" class="fa fa-minus-square"></i>
                                </a>
                            </span>
                        </small>
                    </td>
                    <td class="text-right">
                        <small v-show="index == 0"
                            :class="
                                classTextRed(
                                        groupByFormulas[line][index],
                                        groupByFormulas[line],
                                        groupByFormulas[line][index].quantity_summary
                                        )
                                    ? 'tw-text-red-500'
                                    : ''
                            "
                            >{{ numberFormat(groupByFormulas[line][index].quantity_summary) }}</small
                        >
                    </td>
                    <td class="text-center">
                        <small v-show="index == 0"
                            :class="
                                classTextRed(
                                        groupByFormulas[line][index],
                                        groupByFormulas[line],
                                        groupByFormulas[line][index].quantity_summary
                                        )
                                    ? 'tw-text-red-500'
                                    : ''
                            "
                            >{{ groupByFormulas[line][index].product_unit_of_measure }}</small
                        >
                    </td>

                    <td class="text-right">
                        <small
                            :class="
                                classTextRed(
                                        groupByFormulas[line][index],
                                        groupByFormulas[line],
                                        groupByFormulas[line][index].quantity_summary
                                        )
                                    ? 'tw-text-red-500'
                                    : ''
                            "
                            >{{ numberFormat(groupByFormulas[line][index].onhand_quantity_display) }}</small
                        >
                    </td>
                    <td>
                        <small>
                            <vue-numeric 
                                separator=","
                                size="mini"
                                class="form-control text-right"
                                v-bind:precision="2" 
                                v-bind:minus="false"
                                @input="onClickButton(groupByFormulas[line][index].group_line, index)"
                                :disabled="disabledRow(
                                        groupByFormulas[line][index],
                                        groupByFormulas[line],
                                        groupByFormulas[line][index].quantity_summary
                                        )
                                        || groupByFormulas[line][index].reference_item_number !=  null"
                                v-model="groupByFormulas[line][index].input_quantity_summary"
                                
                            ></vue-numeric>
                        </small>
                    </td>
                    <td class="text-center">
                        <small
                            :class="
                                classTextRed(
                                        groupByFormulas[line][index],
                                        groupByFormulas[line],
                                        groupByFormulas[line][index].quantity_summary
                                        )
                                    ? 'tw-text-red-500'
                                    : ''
                            "
                            >{{ groupByFormulas[line][index].product_unit_of_measure }}</small
                        >
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: ["formulas", "opt-quantity", "action", "p-disabled-input"],
    data() {
        return {
            form_lines:     [],
            onhand:         {},
            form:           [],
            lotOnHand:      [],
            uFormulas:      this.formulas,
            allFormulas:    this.formulas,
            deleteRaw:      [],
        };
    },
    methods: {

        onClickButton(groupLine,index) {
            if(!!this.groupByFormulas[groupLine+'-1']){
                this.groupByFormulas[groupLine+'-1'][index].input_quantity_summary = this.groupByFormulas[groupLine][index].input_quantity_summary;
            }
            
            this.$emit("input", this.allFormulas);
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
            this.onhand.item_desc = "";
            this.onhand.item_number = "";
            this.onhand.last_line = true;
            this.onhand.leaf_formula = "";
            this.onhand.line_disabled = false;
            this.onhand.onhand_lists = formula.onhand_lists;
            this.onhand.onhand_quantity = 0;
            this.onhand.product_detail_uom = formula.product_detail_uom;
            this.onhand.quantity_summary = 0;
            this.onhand.tobacco_ingrident_type = formula.tobacco_ingrident_type;
            this.onhand.id  = line+newIndex;
            this.onhand.casting_flavor_name = formula.casting_flavor_name;
            this.onhand.leaf_formula = formula.leaf_formula;
            this.onhand.group_line = formula.group_line;
            this.onhand.onhand_quantity_display =  0;
            this.onhand.reference_item_number =  formula.reference_item_number;
            this.onhand.line_id =  null;

            this.uFormulas.push(this.onhand);

            if(!!this.groupByFormulas[formula.group_line+'-1']){
                this.onhand = {};

                let newIndex = index+1;
                this.onhand.default_lot_no = 0;
                this.onhand.expiration_date = "";
                this.onhand.formulaline_id = formula.formulaline_id;
                this.onhand.from_location_code = "";
                this.onhand.from_subinventory = "";
                this.onhand.input_quantity_summary = 0;
                this.onhand.interface_status = null;
                this.onhand.item_desc = "";
                this.onhand.item_number = "";
                this.onhand.last_line = true;
                this.onhand.leaf_formula = "";
                this.onhand.line_disabled = false;
                this.onhand.onhand_lists = formula.onhand_lists;
                this.onhand.onhand_quantity = 0;
                this.onhand.product_detail_uom = formula.product_detail_uom;
                this.onhand.quantity_summary = 0;
                this.onhand.tobacco_ingrident_type = formula.tobacco_ingrident_type;
                this.onhand.id  = line+newIndex;
                this.onhand.casting_flavor_name = formula.casting_flavor_name;
                this.onhand.leaf_formula = formula.leaf_formula;
                this.onhand.group_line = formula.group_line+'-1';
                this.onhand.onhand_quantity_display =  0;
                this.onhand.reference_item_number =  formula.reference_item_number;
                this.onhand.line_id = null;

                this.uFormulas.push(this.onhand);
            }

        },

        delRow(formula) {
            this.deleteRaw.push(formula.line_id);
            this.uFormulas.splice(this.uFormulas.indexOf(formula), 1);

            if(formula.default_lot_no){
                let onhand = formula.onhand_lists.find(item => {
                    return item.lot_number === formula.default_lot_no;
                })
                onhand.flag = 'N';
            }

            this.uFormulas.push({});
            this.uFormulas.splice(this.uFormulas.indexOf({}), 1);

            this.$emit("input", this.allFormulas , this.deleteRaw);

        },
        selectOnhand(line,index, onhand, lot) {

            let onhandSelected = onhand.onhand_lists.find(item => {
                return item.lot_number == lot;
            });

            this.groupByFormulas[line][index].default_lot_no = onhandSelected.lot_number;
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
            this.groupByFormulas[line][index].onhand_quantity_display = onhandSelected.onhand_quantity;


            this.uFormulas.push({});
            this.uFormulas.splice(this.uFormulas.indexOf({}), 1);


            if(!!this.groupByFormulas[this.groupByFormulas[line][index].group_line+'-1']){
                this.groupByFormulas[this.groupByFormulas[line][index].group_line+'-1'][index].default_lot_no  = this.groupByFormulas[line][index].default_lot_no;
            }

        },

        fitterFromFormula(formula_id, formula) {
            const result = this.formulas.filter(formula => {
                return formula.formulaline_id == formula_id;
            });

            let id = [];
            let onhand_lists = formula.onhand_lists;

        },
        saveLot(formula) {

        },
        changeType(type, fromClick) {
            this.defaultType = type;

            const formulas = this.allFormulas.filter(item => {
                return item.tobacco_ingrident_type == type;
            });


            this.uFormulas = formulas;
        },

        lotSum(groupByFormula) {
            return groupByFormula.reduce((acc, item) => acc+ parseFloat(item.input_quantity_summary), 0)
        },

        disabledRow(formula,groupByFormula,qty){
            if(this.pDisabledInput != false ){return true}
            if(formula.interface_status != null){return true}
            if(formula.header_interface_status  == 'S'){{return true}}

            return false;
        },

        classTextRed(formula,groupByFormula,qty){
            if(formula.header_interface_status == "S") {
                return false
            }
            else if(formula.onhand_lists.length == 0){
                if(parseInt(formula.input_quantity_summary) > parseInt(formula.onhand_quantity)){
                    return true
                }else{
                    return false
                }
            }
            else {
                if(parseInt(formula.onhand_quantity) < parseInt(formula.input_quantity_summary)) {return true}
            }
        },

        lotLists(groupByFormulas,lots){
            // console.log('lotLists');
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

        numberFormat(amount){
            return  parseFloat(amount).toLocaleString(undefined, {minimumFractionDigits: 6});
            return parseFloat(amount).toFixed(2);
        }

    },
    computed: {
        orderByFormulas() {
            // return this.uFormulas;
            return _.orderBy(this.uFormulas, "leaf_formula");
        },

        groupByFormulas() {

            return _.groupBy(this.orderByFormulas, "group_line");

        },
    },
};
</script>
