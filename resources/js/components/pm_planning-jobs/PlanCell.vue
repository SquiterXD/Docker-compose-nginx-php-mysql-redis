<template>
    <div>
        <div class="text-right">
            <el-popover placement="right" width="400" trigger="click">
                <el-table :data="groupByDates">
                    <el-table-column
                        width="100"
                        property="blend_no"
                        label="Blen no."
                    ></el-table-column>
                    <el-table-column
                        width="100"
                        property="plan_quantity_format"
                        label="จำนวน(KG)"
                    ></el-table-column>
                    <el-table-column
                        width="200"
                        property="finish_good"
                        label="สินค้า"
                    ></el-table-column>
                </el-table>

                <div slot="reference" style="cursor: pointer">
                    <div class="h6 my-1">{{ showBlends() }}</div>
                    <div v-if="showQuantity">
                        <hr class="py-0 my-1" />
                        <!-- <div>{{ d.plan_quantity || 0 }}</div> -->
                        {{ displayQuantity() }}
                    </div>
                </div>
            </el-popover>
        </div>
    </div>
</template>

<script>
import { Decimal } from "decimal.js";

export default {
    props: ["date", "groupByDates", "showQuantity"],
    data() {
        return {
            //   showQuantity: true,
        };
    },

    methods: {
        showBlends() {
            if (!this.groupByDates) {
                return;
            }
            let blendNos = this.groupByDates.map(i => {
                return i.blend_no;
            });

            return blendNos.join("/") || "-";
        },

        displayQuantity() {
            return this.groupByDates?.reduce((accum, item) => {
                if (item && item.plan_quantity) {
                    return accum.add(Decimal(item.plan_quantity));
                }

                return accum;
            }, Decimal(0));
        }
    }
};
</script>
