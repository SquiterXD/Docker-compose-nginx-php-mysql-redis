<template>
    <div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="3%"></th>
                    <th class="text-center"><small>รหัสสินค้า</small></th>
                    <th class="text-center"><small>รายละเอียด</small></th>
                    <th class="text-center"><small>ประมาณการจำหน่าย</small></th>
                    <th class="text-center">
                        <small>หน่วยนับ</small>
                    </th>
                    <th class="text-center"><small>จำนวนซอง</small></th>
                    <th class="text-center"><small>หน่วยนับ</small></th>
                    <th class="text-center">
                        <small>จำนวนที่ต้องผลิต</small>
                    </th>
                    <th class="text-center"><small>หน่วยนับ</small></th>
                    <th class="text-center">
                        <small>เลขที่คำสั่งการผลิต</small>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(productPlanLine, index) in lines" :key="index">
                    <td class="text-center">
                        <el-checkbox
                            v-model="productPlanLine.attribute15"
                            :disabled="productPlanLine.request_number != null ? true : false"
                            @input="onClickButton"
                            :checked="productPlanLine.attribute15 == true || productPlanLine.request_number !== null ? true : false"
                            size="small"
                        ></el-checkbox>
                    </td>
                    <td class="text-center">
                        <small>{{ productPlanLine.item_number_v.item_number }}</small>
                    </td>
                    <td class="text-center">
                        <small>{{ productPlanLine.item_number_v.item_desc }}</small>
                    </td>
                    <td class="text-center">
                        <small>{{ productPlanLine.product_qty }}</small>
                    </td>
                    <td class="text-center">
                        <small>{{ productPlanLine.mtl_uom.unit_of_measure }}</small>
                    </td>
                    <td class="text-center">
                        <small>{{ productPlanLine.period_name_request }}</small>
                    </td>
                    <td class="text-center">
                        <small>{{ productPlanLine.uom_ptn.unit_of_measure }}</small>
                    </td>
                    <td class="text-right">
                        <el-input
                            size="mini"
                            class="w-auto text-right"
                            @input="onClickButton"
                            v-model="productPlanLine.input"
                        >
                        </el-input>
                    </td>
                    <td class="text-right">
                        <el-input
                            size="mini"
                            class="w-auto text-right"
                            v-model="productPlanLine.uom_kg.unit_of_measure"
                            readonly
                        >
                        </el-input>
                    </td>
                    <td class="text-center">
                        <small>{{ productPlanLine.request_number }}</small>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    props: ["product-plan-lines"],
    data() {
        return {
            form_lines: [],
            lines: this.productPlanLines,
            checked: false,
        };
    },
    mounted() {
        this.setData();
    },
    methods: {
        // updateFormLines(key, value) {
        //     console.log(key, value);
        // },
        setData(){
            this.lines.forEach(line => {

                if(line.uom !== 'PTN'){
                    line.period_name_request = line.product_qty * 120;
                }
                if(line.uom2 !== 'KG'){
                    line.input = line.period_name_request * 0.02;
                }

                line.uom2 = 'KG';
            });
        },
        onClickButton(event) {

            this.$emit("input", this.lines);
        }
    },

    computed: {
        // orderByFormulas() {
        //     return _.orderBy(this.formulas, "leaf_formula");
        // },
    }
};
</script>
