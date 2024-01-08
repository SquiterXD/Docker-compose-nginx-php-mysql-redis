<template>
    <div>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="text-center"><small>กลุ่มใบยา</small></th>
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
            <tbody>
                <tr v-for="(formula, index) in orderByFormulas" :key="index">
                    <td
                        :class="
                            formula.quantity_summary >
                            parseFloat(formula.onhand_quantity)
                                ? 'tw-text-red-500'
                                : ''
                        "
                    >

                        <small>{{ formula.leaf_formula }}</small>
                    </td>
                    <td
                        :class="
                            parseFloat(formula.quantity_summary) >
                            parseFloat(formula.onhand_quantity)
                                ? 'tw-text-red-500'
                                : ''
                        "
                    >
                        <small>{{ formula.item_number }}</small>
                    </td>
                    <td
                        :class="
                            parseFloat(formula.quantity_summary) >
                            parseFloat(formula.onhand_quantity)
                                ? 'tw-text-red-500'
                                : ''
                        "
                    >
                        <small>{{ formula.item_desc }}</small>
                        <p class="m-0 p-0 tw-text-2xs tw-text-red-800">{{ formula.cost_validate_msg }}</p>
                    </td>
                    <td
                        :class="
                            parseFloat(formula.quantity_summary) >
                            parseFloat(formula.onhand_quantity)
                                ? 'tw-text-red-500'
                                : ''
                        "
                    >
                        <small>{{ formula.default_lot_no }}</small>
                    </td>
                    <td
                        :class="parseFloat(formula.quantity_summary) >
                            parseFloat(formula.onhand_quantity)
                                ? 'tw-text-red-500  text-right'
                                : ''
                        + ' text-right'"
                    >
                        <small>{{
                            numberFormat(formula.quantity_summary.toString().replace(',', ""))
                        }}</small>
                    </td>
                    <td
                        :class="
                            parseFloat(formula.quantity_summary) >
                            parseFloat(formula.onhand_quantity)
                                ? 'tw-text-red-500'
                                : ''
                        + ' text-center'"
                    >
                        <small>{{ formula.unit_of_measure }}</small>
                    </td>
                    <!-- <td
                        :class="
                            parseFloat(formula.quantity_summary) >
                            parseFloat(formula.onhand_quantity)
                                ? 'tw-text-red-500'
                                : ''
                        "
                    >
                        <small>{{ formula.expiration_date }}</small>
                    </td> -->
                    <td
                        :class="
                            parseFloat(formula.quantity_summary) >
                            parseFloat(formula.onhand_quantity)
                                ? 'tw-text-red-500  text-right'
                                : ''
                        + ' text-right'"
                    >
                        <small>{{
                            numberFormat(formula.onhand_quantity)

                        }}</small>
                    </td>
                    <td>
                        <small>
                            <!-- <el-input
                                @input="onClickButton"
                                size="mini"
                                class="w-auto"
                                :disabled="
                                    disabledRow(formula)
                                "
                                v-model="formula.input_quantity_summary"
                            >
                            </el-input> -->

                            <vue-numeric 
                                separator=","
                                size="mini"
                                class="form-control text-right"
                                v-bind:precision="2" 
                                v-bind:minus="false"
                                :disabled="
                                    disabledRow(formula)
                                "
                                v-model="formula.input_quantity_summary"
                            ></vue-numeric>
                        </small>
                    </td>
                    <td  class="text-center">
                        <small>{{ formula.unit_of_measure }}</small>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    props: ["formulas", "opt-quantity", "action"],
    data() {
        return {
            form_lines: []
        };
    },
    mounted() {},
    methods: {
        updateFormLines(key, value) {
            console.log(key, value);
        },

        onClickButton(event) {
            this.$emit("input", this.formulas);
        },
        disabledRow(formula){
        if(formula.interface_status != null){return true}
            // if(this.lotSum(groupByFormula) < parseFloat(formula.quantity_summary)){return true}
            return false;

        },

        numberFormat(amount){
            return  parseFloat(amount).toLocaleString(undefined, {minimumFractionDigits: 2});

        }
    },

    computed: {
        orderByFormulas() {
            return _.orderBy(this.formulas, "leaf_formula");
        },
    }
};
</script>
