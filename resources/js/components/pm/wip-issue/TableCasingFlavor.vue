
<template>
    <div>
        <button class="btn btn-primary" @click="changeType('CASING', true)">
            สารปรุง
        </button>
        <button class="btn btn-info" @click="changeType('FLAVOR', true)">
            สารหอม
        </button>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">
                        <small
                            >{{
                                defaultType == "CASING"
                                    ? "กลุ่มใบยา"
                                    : "Flavor No."
                            }}
                        </small>
                    </th>
                    <th v-if="defaultType == 'CASING'" class="text-center">
                        <small>Casing No.</small>
                    </th>
                    <th class="text-center"><small>รหัสวัตถุดิบ</small></th>
                    <th class="text-center"><small>รายละเอียด</small></th>
                    <th class="text-center"><small>Lot No.</small></th>
                    <th class="text-center">
                        <small>ปริมาณที่ต้องใช้+สูญเสีย</small>
                    </th>
                    <th class="text-center"><small>หน่วยนับ</small></th>
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
                        <small v-show="index ==0"
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
                            {{
                                defaultType == "CASING"
                                    ? groupByFormulas[line][index].used_leaf_formula
                                    : groupByFormulas[line][index].casting_flavor_name
                            }}
                            {{ lotLists(groupByFormulas[line],groupByFormulas[line][index].onhand_lists) }}
                        </small
                        >
                    </td>
                    <td v-if="defaultType == 'CASING'">
                        <small v-show="index ==0"
                        :class="
                                classTextRed(
                                        groupByFormulas[line][index],
                                        groupByFormulas[line],
                                        groupByFormulas[line][index].quantity_summary
                                        )
                                    ? 'tw-text-red-500'
                                    : ''
                            "
                        >{{  groupByFormulas[line][index].casting_flavor_name }}</small>
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
                            >{{ groupByFormulas[line][index].item_desc }}</small
                        >
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
                                   disabledRow(
                                        groupByFormulas[line][index],
                                        groupByFormulas[line],
                                        groupByFormulas[line][index].quantity_summary
                                        )
                                "
                                class="form-control-file"
                            >
                                <el-option
                                    v-for="item in groupByFormulas[line][index].onhand_lists"
                                    :key="item.lot_number+index"
                                    :label="item.lot_number"
                                    :value="item.lot_number"
                                    :disabled="item.flag == 'Y0'"
                                >
                                        <span style="float: left">{{'lot: '+ item.lot_number+ ' ' }}</span>
                                        <span style="float: right" class="ml-4">{{' onhand: '+ numberFormat(item.onhand_quantity) }}</span>

                                </el-option>
                            </el-select>
                            <span
                                class="text-center mr-2"
                            >
                                <a v-if="groupByFormulas[line].length === index+1" @click.prevent="addRow(formula,line,index)">
                                    <i class="fa fa-plus-square"></i>
                                </a>
                                <a v-if="index !== 0" @click.prevent="delRow(formula)">
                                    <i class="fa fa-minus-square"></i>
                                </a>
                            </span>
                        </small>
                    </td>
                    <td class="text-right">
                        <small v-show="index ==0"
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
                        <small v-show="index ==0"
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
                                v-bind:precision="6" 
                                v-bind:minus="false"
                                @input="onClickButton"
                                :disabled="disabledRow(
                                        groupByFormulas[line][index],
                                        groupByFormulas[line],
                                        groupByFormulas[line][index].quantity_summary
                                        )"
                                v-model="groupByFormulas[line][index].input_quantity_summary"
                                
                            ></vue-numeric>
                            <p v-show="alertInputDef(
                                groupByFormulas[line][index],
                                        groupByFormulas[line],
                                        groupByFormulas[line][index].quantity_summary)"
                                class="m-0 p-0 tw-text-2xs tw-text-red-800"
                                >
                                ยอดปริมาณที่ใช้จริงไม่ตรงกับช่องที่คำนวนจากสูตร 
                            </p>
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
            form_lines: [],
            onhand: {},
            form: [],
            lotOnHand: [],
            uFormulas: this.formulas,
            allFormulas: this.formulas,
            defaultType: "CASING",
            mapLines:[],
        };
    },
    mounted() {
        this.changeType("CASING", false);
    },
    created() {
        this.changeType("CASING", false);
    },
    methods: {
        updateFormLines(key, value) {
            console.log(key, value);
        },

        onClickButton(event) {
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
            this.onhand.group_line = formula.group_line;


            this.allFormulas.push(this.onhand);
            this.uFormulas.push(this.onhand);



        },

        delRow(formula) {
            this.uFormulas.splice(this.uFormulas.indexOf(formula), 1);
            this.allFormulas.splice(this.allFormulas.indexOf(formula), 1);

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


            this.lotLists(this.groupByFormulas[line],this.groupByFormulas[line][index].onhand_lists);
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
        saveLot(formula) {
        },
        changeType(type, fromClick) {
            this.defaultType = type;
            const formulas = this.allFormulas.filter(item => {
                return item.tobacco_ingrident_type == type;
            });

            setTimeout(() => { 
                const orderByDepartment = (a,b) =>  a.item_number - b.item_number;
                console.log(orderByDepartment);
            }, 1000);

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
            if(formula.interface_status == "S") {
                return false
            }else {
                if (parseInt(formula.onhand_quantity) < parseInt(formula.input_quantity_summary)){return true}

                if(formula.default_lot_no == ""){return true}
            }
        },

        alertInputDef(formula,groupByFormula,qty){
            const totalInput =  groupByFormula.reduce((acc, item) => acc+ parseInt(this.numberFormat(item.input_quantity_summary)), 0);
            if (parseInt(this.numberFormat(this.groupByFormulas[formula.group_line][0].quantity_summary)) != totalInput ){return true}
            
            return false;

        },

        lotLists(groupByFormulas,lots){
            console.log(lots);
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
            if(this.defaultType == 'FLAVOR'){
                return _.orderBy(this.uFormulas, "group_line");
            } else {
                return _.orderBy(this.uFormulas, "group_line");
            }

        },

        groupByFormulas() {

            if(this.defaultType == 'FLAVOR'){
                return _.groupBy(this.orderByFormulas, "group_line");
            } 
            return _.groupBy(this.orderByFormulas, "group_line");
        },
    },
};
</script>
