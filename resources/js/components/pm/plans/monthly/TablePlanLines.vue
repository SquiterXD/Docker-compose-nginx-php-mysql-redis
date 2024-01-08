<template>

    <div class="table-responsive">

        <table class="table table-bordered table-sticky mb-0" style="min-width: 2200px;">
            <thead>
                <tr>
                    <th class="text-center freeze-col" style="min-width: 580px;"> 
                        <div class="freeze-col-content" style="padding: 0px;">
                            <div class="text-center tw-inline-block tw-align-top tw-py-8" style="min-width: 120px; max-width: 120px;">
                                ตราบุหรี่  
                            </div>
                            <div class="text-center tw-inline-block tw-align-top tw-py-8" style="min-width: 130px; max-width: 130px; border-left: 1px solid #ddd;">
                                <span> รหัสสินค้าสำเร็จรูป </span>
                            </div>
                            <div class="text-center tw-inline-block tw-align-top tw-py-8" style="min-width: 300px; max-width: 300px; border-left: 1px solid #ddd;">
                                รายละเอียด
                            </div>
                        </div>
                    </th>
                    <th class="text-center" style="min-width: 83px;"> ประมาณจำหน่าย(ล้านมวน)  </th>
                    <th class="text-center" style="min-width: 120px;"> 
                        <el-tooltip placement="top">
                            <div slot="content">(ซองบุหรี่) --> (ประมาณการจำหน่าย(ล้านมวน)*1,000,000)/ซอง(20)<br/>(กระดาษพันก้นกรอง) --> ประมาณการจำหน่าย(ล้านมวน)*1,000,000</div>
                            <span> ความต้องการต่อเดือน </span>
                        </el-tooltip>
                    </th>
                    <th class="text-center" style="min-width: 120px;"> 
                        <el-tooltip placement="top">
                            <div slot="content">(ซองบุหรี่) --> ยอดคงคลังรวม / ความต้องการต่อเดือน<br/>(กระดาษพันก้นกรอง) --> ยอดคงคลังรวม (Bobbin) / (ความต้องการต่อเดือน/(จำนวนชิ้น/Bobbin))</div>
                            <span> จำนวนพอใช้ได้อีก (เดือน) </span>
                        </el-tooltip>
                    </th>
                    <th class="text-center" style="min-width: 120px;"> พอใช้ถึงเดือน </th>

                    <template v-if="planLineItems.length > 0">
                        <th v-if="planLineItems[0].subinventory_01" class="text-center" style="min-width: 120px;"> {{ planLineItems[0].subinventory_01 }} </th>
                        <th v-if="planLineItems[0].subinventory_02" class="text-center" style="min-width: 120px;"> {{ planLineItems[0].subinventory_02 }} </th>
                        <th v-if="planLineItems[0].subinventory_03" class="text-center" style="min-width: 120px;"> {{ planLineItems[0].subinventory_03 }} </th>
                        <th v-if="planLineItems[0].subinventory_04" class="text-center" style="min-width: 120px;"> {{ planLineItems[0].subinventory_04 }} </th>
                        <th v-if="planLineItems[0].subinventory_05" class="text-center" style="min-width: 120px;"> {{ planLineItems[0].subinventory_05 }} </th>
                        <th v-if="planLineItems[0].subinventory_06" class="text-center" style="min-width: 120px;"> {{ planLineItems[0].subinventory_06 }} </th>
                        <th v-if="planLineItems[0].subinventory_07" class="text-center" style="min-width: 120px;"> {{ planLineItems[0].subinventory_07 }} </th>
                        <th v-if="planLineItems[0].subinventory_08" class="text-center" style="min-width: 120px;"> {{ planLineItems[0].subinventory_08 }} </th>
                        <th v-if="planLineItems[0].subinventory_09" class="text-center" style="min-width: 120px;"> {{ planLineItems[0].subinventory_09 }} </th>
                        <th v-if="planLineItems[0].subinventory_10" class="text-center" style="min-width: 120px;"> {{ planLineItems[0].subinventory_10 }} </th>
                    </template>

                    <th class="text-center" style="min-width: 120px;"> ยอดคงคลังรวม </th>
                    <th class="text-center" style="min-width: 83px;"> หน่วยนับ(จัดเก็บ) </th>
                    <th class="text-center" style="min-width: 120px;"> 
                        <el-tooltip placement="top">
                            <div slot="content">(ซองบุหรี่) --> (ความต้องการต่อเดือน-ยอดคงคลังรวม)/(จำนวนชิ้น/ROL)<br/>(กระดาษพันก้นกรอง) --> (ความต้องการต่อเดือน/(จำนวนชิ้น/Bobbin)-ยอดคงคลังรวม)/(Bobbin/ROL)</div>
                            <span> จำนวนที่ต้องผลิต </span>
                        </el-tooltip>
                    </th>
                    <th class="text-center" style="min-width: 160px;"> จำนวนที่ควรผลิต </th>
                    <th class="text-center" style="min-width: 83px;"> หน่วยนับ(ผลิต) </th>
                    <th class="text-center" style="min-width: 124px;"> 
                        <el-tooltip placement="top">
                            <div slot="content">(ซองบุหรี่) --> จำนวนที่ควรผลิต * (จำนวนชิ้น/ROL)<br/>(กระดาษพันก้นกรอง) --> จำนวนที่ควรผลิต * (จำนวนชิ้น/ROL)</div>
                            <span> แปลงหน่วย(ชิ้น) </span>
                        </el-tooltip> 
                    </th>
                </tr>
            </thead>
            <tbody v-if="planLineItems.length > 0">
                <template v-for="(planLineItem, index) in planLineItems">
                    <!-- <tr :key="`${index}`" v-bind:style="{ backgroundColor: Number(planLineItem.total_onhand) > Number(planLineItem.monthly_used) ? '#FDF5EF' : (!planLineItem.ingredient_request_uom ? '#FFEEEE': '') }"> -->
                    <tr :key="`${index}`" v-bind:style="{ backgroundColor: Number(planLineItem.ingredient_request_qty) <= 0 ? '#FDF5EF' : (!planLineItem.ingredient_request_uom ? '#FFEEEE': '') }">
                        <td class="freeze-col text-center"> 
                            <!-- <div class="freeze-col-content" style="padding: 0px;" v-bind:style="{ minWidth: '580px', backgroundColor: Number(planLineItem.total_onhand) > Number(planLineItem.monthly_used) ? '#FDF5EF' : (!planLineItem.ingredient_request_uom ? '#FFEEEE': '') }"> -->
                            <div class="freeze-col-content" style="padding: 0px;" v-bind:style="{ minWidth: '580px', backgroundColor: Number(planLineItem.ingredient_request_qty) <= 0 ? '#FDF5EF' : (!planLineItem.ingredient_request_uom ? '#FFEEEE': '') }">
                                <div class="text-center tw-inline-block tw-align-top tw-py-4 tw-pr-2" style="min-width: 120px;max-width: 120px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; min-height: 51px;">
                                    {{ planLineItem.product_item_desc }} 
                                </div>
                                <div class="text-center tw-inline-block tw-align-top tw-py-4 tw-px-2" style="min-width: 130px; max-width: 130px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; min-height: 51px; border-left: 1px solid #ddd;">
                                    {{ planLineItem.inv_item_number }}
                                </div>
                                <div class="text-left tw-inline-block tw-align-top tw-py-4 tw-pl-2" style="min-width: 300px; max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; min-height: 51px; border-left: 1px solid #ddd;">
                                    {{ planLineItem.inv_item_desc }}
                                </div>
                            </div>
                        </td>
                        <td class="text-right" style="min-width: 83px;"> {{ planLineItem.product_require_qty_m ? Number(planLineItem.product_require_qty_m).toLocaleString(undefined, {minimumFractionDigits: 3,maximumFractionDigits: 3}) : "0.000" }} </td>
                        <td class="text-right" style="min-width: 120px;"> {{ planLineItem.monthly_used ? Number(planLineItem.monthly_used).toLocaleString(undefined, {minimumFractionDigits: 0,maximumFractionDigits: 0}) : "0" }} </td>
                        <td class="text-right" style="min-width: 120px;"> {{ planLineItem.remaining ? Number(planLineItem.remaining).toLocaleString(undefined, {minimumFractionDigits: 0,maximumFractionDigits: 0}) : "0" }} </td>
                        <td class="text-right" style="min-width: 120px;"> {{ planLineItem.remaining_date }} </td>
                        
                        <td v-if="planLineItems[0].subinventory_01" class="text-right" style="min-width: 120px;"> 
                            <div v-if="planHeaderData.status == '1'">
                                <vue-numeric 
                                    separator="," 
                                    v-bind:precision="0" 
                                    v-bind:minus="false"
                                    :id="`input_onhand_01_${index}`"
                                    class="form-control input-sm text-right"
                                    :name="`onhand_01_${index}`"
                                    v-model="planLineItem.onhand_01"
                                    @change="onSubInventoryOnhandValueChanged(planLineItem)"
                                ></vue-numeric>
                            </div>
                            <div v-else>
                                {{ planLineItem.onhand_01 ? Number(planLineItem.onhand_01).toLocaleString(undefined, {minimumFractionDigits: 0,maximumFractionDigits: 0}) : "0" }} 
                            </div>
                        </td>
                        <td v-if="planLineItems[0].subinventory_02" class="text-right" style="min-width: 120px;"> 
                            <div v-if="planHeaderData.status == '1'">
                                <vue-numeric 
                                    separator="," 
                                    v-bind:precision="0" 
                                    v-bind:minus="false"
                                    :id="`input_onhand_02_${index}`"
                                    class="form-control input-sm text-right"
                                    :name="`onhand_02_${index}`"
                                    v-model="planLineItem.onhand_02"
                                    @change="onSubInventoryOnhandValueChanged(planLineItem)"
                                ></vue-numeric>
                            </div>
                            <div v-else>
                                {{ planLineItem.onhand_02 ? Number(planLineItem.onhand_02).toLocaleString(undefined, {minimumFractionDigits: 0,maximumFractionDigits: 0}) : "0" }} 
                            </div>
                        </td>
                        <td v-if="planLineItems[0].subinventory_03" class="text-right" style="min-width: 120px;"> 
                            <div v-if="planHeaderData.status == '1'">
                                <vue-numeric 
                                    separator="," 
                                    v-bind:precision="0" 
                                    v-bind:minus="false"
                                    :id="`input_onhand_03_${index}`"
                                    class="form-control input-sm text-right"
                                    :name="`onhand_03_${index}`"
                                    v-model="planLineItem.onhand_03"
                                    @change="onSubInventoryOnhandValueChanged(planLineItem)"
                                ></vue-numeric>
                            </div>
                            <div v-else>
                                {{ planLineItem.onhand_03 ? Number(planLineItem.onhand_03).toLocaleString(undefined, {minimumFractionDigits: 0,maximumFractionDigits: 0}) : "0" }} 
                            </div>
                        </td>
                        <td v-if="planLineItems[0].subinventory_04" class="text-right" style="min-width: 120px;"> 
                            <div v-if="planHeaderData.status == '1'">
                                <vue-numeric 
                                    separator="," 
                                    v-bind:precision="0" 
                                    v-bind:minus="false"
                                    :id="`input_onhand_04_${index}`"
                                    class="form-control input-sm text-right"
                                    :name="`onhand_04_${index}`"
                                    v-model="planLineItem.onhand_04"
                                    @change="onSubInventoryOnhandValueChanged(planLineItem)"
                                ></vue-numeric>
                            </div>
                            <div v-else>
                                {{ planLineItem.onhand_04 ? Number(planLineItem.onhand_04).toLocaleString(undefined, {minimumFractionDigits: 0,maximumFractionDigits: 0}) : "0" }} 
                            </div>
                        </td>
                        <td v-if="planLineItems[0].subinventory_05" class="text-right" style="min-width: 120px;"> 
                            <div v-if="planHeaderData.status == '1'">
                                <vue-numeric 
                                    separator="," 
                                    v-bind:precision="0" 
                                    v-bind:minus="false"
                                    :id="`input_onhand_05_${index}`"
                                    class="form-control input-sm text-right"
                                    :name="`onhand_05_${index}`"
                                    v-model="planLineItem.onhand_05"
                                    @change="onSubInventoryOnhandValueChanged(planLineItem)"
                                ></vue-numeric>
                            </div>
                            <div v-else>
                                {{ planLineItem.onhand_05 ? Number(planLineItem.onhand_05).toLocaleString(undefined, {minimumFractionDigits: 0,maximumFractionDigits: 0}) : "0" }} 
                            </div>
                        </td>
                        <td v-if="planLineItems[0].subinventory_06" class="text-right" style="min-width: 120px;"> 
                            <div v-if="planHeaderData.status == '1'">
                                <vue-numeric 
                                    separator="," 
                                    v-bind:precision="0" 
                                    v-bind:minus="false"
                                    :id="`input_onhand_06_${index}`"
                                    class="form-control input-sm text-right"
                                    :name="`onhand_06_${index}`"
                                    v-model="planLineItem.onhand_06"
                                    @change="onSubInventoryOnhandValueChanged(planLineItem)"
                                ></vue-numeric>
                            </div>
                            <div v-else>
                                {{ planLineItem.onhand_06 ? Number(planLineItem.onhand_06).toLocaleString(undefined, {minimumFractionDigits: 0,maximumFractionDigits: 0}) : "0" }} 
                            </div>
                        </td>
                        <td v-if="planLineItems[0].subinventory_07" class="text-right" style="min-width: 120px;"> 
                            <div v-if="planHeaderData.status == '1'">
                                <vue-numeric 
                                    separator="," 
                                    v-bind:precision="0" 
                                    v-bind:minus="false"
                                    :id="`input_onhand_07_${index}`"
                                    class="form-control input-sm text-right"
                                    :name="`onhand_07_${index}`"
                                    v-model="planLineItem.onhand_07"
                                    @change="onSubInventoryOnhandValueChanged(planLineItem)"
                                ></vue-numeric>
                            </div>
                            <div v-else>
                                {{ planLineItem.onhand_07 ? Number(planLineItem.onhand_07).toLocaleString(undefined, {minimumFractionDigits: 0,maximumFractionDigits: 0}) : "0" }} 
                            </div>
                        </td>
                        <td v-if="planLineItems[0].subinventory_08" class="text-right" style="min-width: 120px;"> 
                            <div v-if="planHeaderData.status == '1'">
                                <vue-numeric 
                                    separator="," 
                                    v-bind:precision="0" 
                                    v-bind:minus="false"
                                    :id="`input_onhand_08_${index}`"
                                    class="form-control input-sm text-right"
                                    :name="`onhand_08_${index}`"
                                    v-model="planLineItem.onhand_08"
                                    @change="onSubInventoryOnhandValueChanged(planLineItem)"
                                ></vue-numeric>
                            </div>
                            <div v-else>
                                {{ planLineItem.onhand_08 ? Number(planLineItem.onhand_08).toLocaleString(undefined, {minimumFractionDigits: 0,maximumFractionDigits: 0}) : "0" }} 
                            </div>
                        </td>
                        <td v-if="planLineItems[0].subinventory_09" class="text-right" style="min-width: 120px;"> 
                            <div v-if="planHeaderData.status == '1'">
                                <vue-numeric 
                                    separator="," 
                                    v-bind:precision="0" 
                                    v-bind:minus="false"
                                    :id="`input_onhand_09_${index}`"
                                    class="form-control input-sm text-right"
                                    :name="`onhand_09_${index}`"
                                    v-model="planLineItem.onhand_09"
                                    @change="onSubInventoryOnhandValueChanged(planLineItem)"
                                ></vue-numeric>
                            </div>
                            <div v-else>
                                {{ planLineItem.onhand_09 ? Number(planLineItem.onhand_09).toLocaleString(undefined, {minimumFractionDigits: 0,maximumFractionDigits: 0}) : "0" }} 
                            </div>
                        </td>
                        <td v-if="planLineItems[0].subinventory_10" class="text-right" style="min-width: 120px;"> 
                            <div v-if="planHeaderData.status == '1'">
                                <vue-numeric 
                                    separator="," 
                                    v-bind:precision="0" 
                                    v-bind:minus="false"
                                    :id="`input_onhand_10_${index}`"
                                    class="form-control input-sm text-right"
                                    :name="`onhand_10_${index}`"
                                    v-model="planLineItem.onhand_10"
                                    @change="onSubInventoryOnhandValueChanged(planLineItem)"
                                ></vue-numeric>
                            </div>
                            <div v-else>
                                {{ planLineItem.onhand_10 ? Number(planLineItem.onhand_10).toLocaleString(undefined, {minimumFractionDigits: 0,maximumFractionDigits: 0}) : "0" }} 
                            </div>
                        </td>

                        <td class="text-right" style="min-width: 120px;"> {{ planLineItem.total_onhand ? Number(planLineItem.total_onhand).toLocaleString(undefined, {minimumFractionDigits: 0,maximumFractionDigits: 0}) : "0" }} </td>
                        <td class="text-center" style="min-width: 83px;"> {{ planLineItem.ingredient_request_uom_desc }} </td>
                        <td class="text-right" style="min-width: 120px;"> 
                            {{ planLineItem.ingredient_require_qty ? Number(planLineItem.ingredient_require_qty).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}) : "0.00" }} 
                        </td>
                        <td class="text-right" style="min-width: 160px;" > 
                            <div v-if="planHeaderData.status == '1'">
                                <vue-numeric 
                                    separator="," 
                                    v-bind:precision="0" 
                                    v-bind:minus="false"
                                    :id="`input_ingredient_request_qty_${index}`"
                                    class="form-control input-sm text-right"
                                    :name="`ingredient_request_qty_${index}`"
                                    v-model="planLineItem.ingredient_request_qty"
                                    @change="onIngredientReqestQtyValueChanged(planLineItem)"
                                ></vue-numeric>
                            </div>
                            <div v-else>
                                {{ planLineItem.ingredient_request_qty ? Number(planLineItem.ingredient_request_qty).toLocaleString(undefined, {minimumFractionDigits: 0,maximumFractionDigits: 0}) : "0" }}
                            </div>
                        </td>
                        <td class="text-center" style="min-width: 83px;"> {{ planLineItem.onhand_uom }} </td>
                        <td class="text-right" style="min-width: 124px;">  {{ planLineItem.converted_ingredient_request_qty ? Number(planLineItem.converted_ingredient_request_qty).toLocaleString(undefined, {minimumFractionDigits: 3,maximumFractionDigits: 3}) : "0.000" }}</td>
                    </tr>
                </template>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="20">
                        <h2 class="p-5 text-center text-muted"> ไม่พบข้อมูล </h2>
                    </td>
                </tr>
            </tbody>

        </table>

    </div>
                    
</template>

<script>

import VueNumeric from 'vue-numeric'

export default {
    
    props: ["planHeader","planLines","uomCodes"],

    components: {
        VueNumeric
    },

    watch: {
        planHeader : function (value) {
            this.planHeaderData = value;
        },
    },


    data() {

        return {

            planHeaderData: this.planHeader,
            planLineItems: this.planLines.map(item => {
                return {
                    ...item,
                    product_require_qty_m: Number((parseFloat(item.product_require_qty) / 1000)),
                    weekly_used_m: Number((parseFloat(item.weekly_used) / 1000000)),
                    remaining_m: Number((parseFloat(item.remaining) / 1000000)),
                    monthly_used_m: Number((parseFloat(item.monthly_used) / 1000000)),
                    ingredient_require_qty: Number(item.total_onhand) > Number(item.monthly_used) ? 0 : Number(parseFloat(item.ingredient_require_qty)),
                    ingredient_request_qty: item.ingredient_request_qty ? Number(Math.ceil(parseFloat(item.ingredient_request_qty))) : (Number(item.total_onhand) > Number(item.monthly_used) ? 0 : Number(Math.ceil(parseFloat(item.ingredient_require_qty)))),
                    converted_ingredient_request_qty: item.ingredient_request_qty ? Number(parseFloat(item.ingredient_request_qty) * parseFloat(item.product_uom_qty)) : 0,
                    ingredient_request_uom_desc : this.getUomCodeDescription(this.uomCodes, item.ingredient_request_uom),
                }
            }).sort((a, b) => {
                return ('' + a.inv_item_number).localeCompare(b.inv_item_number);
            }),

        }

    },

    mounted() {

        this.planLineItems.forEach((planLineItem) => {
            planLineItem.converted_ingredient_request_qty = planLineItem.ingredient_request_qty ? Number(parseFloat(planLineItem.ingredient_request_qty) * parseFloat(planLineItem.product_uom_qty)) : 0;
        });

        // EMIT UPDATE PARENT PLAN LINES
        this.emitPlanLineChanged();

    },

    computed: {

    },
    methods: {

        async onSubInventoryOnhandValueChanged(planLineItem){

            const onhand01 = planLineItem.onhand_01 ? planLineItem.onhand_01 : 0;
            const onhand02 = planLineItem.onhand_02 ? planLineItem.onhand_02 : 0;
            const onhand03 = planLineItem.onhand_03 ? planLineItem.onhand_03 : 0;
            const onhand04 = planLineItem.onhand_04 ? planLineItem.onhand_04 : 0;
            const onhand05 = planLineItem.onhand_05 ? planLineItem.onhand_05 : 0;
            const onhand06 = planLineItem.onhand_06 ? planLineItem.onhand_06 : 0;
            const onhand07 = planLineItem.onhand_07 ? planLineItem.onhand_07 : 0;
            const onhand08 = planLineItem.onhand_08 ? planLineItem.onhand_08 : 0;
            const onhand09 = planLineItem.onhand_09 ? planLineItem.onhand_09 : 0;
            const onhand10 = planLineItem.onhand_10 ? planLineItem.onhand_10 : 0;

            const totalOnhand = onhand01 + onhand02 + onhand03 + onhand04 + onhand05 + onhand06 + onhand07 + onhand08 + onhand09 + onhand10;
            planLineItem.total_onhand = totalOnhand;

            await this.getRemainingDate(this.planHeaderData, planLineItem);

            this.$emit("onPlanLineChanged", {
                planLineItems: this.planLineItems
            });

        },

        onIngredientReqestQtyValueChanged(planLineItem){

            planLineItem.converted_ingredient_request_qty = planLineItem.ingredient_request_qty ? Number(parseFloat(planLineItem.ingredient_request_qty) * parseFloat(planLineItem.product_uom_qty)) : 0,

            this.$emit("onPlanLineChanged", {
                planLineItems: this.planLineItems
            });

        },

        getUomCodeDescription(uomCodes, uomCode) {
            const foundUomCode = uomCodes.find(item => item.uom_code == uomCode);
            return foundUomCode ? foundUomCode.unit_of_measure : "";
        },

        async getRemainingDate(planHeader, planLineItem) {

            // // SHOW LOADING
            // this.isLoading = true;

            // REFRESH DATA
            var params = { 
                period_year: planHeader.year, 
                period_name: planHeader.period,
                plan_header: JSON.stringify(planHeader),
                monthly_used: planLineItem.monthly_used,
                total_onhand: planLineItem.total_onhand,
            };
            await axios.get("/ajax/pm/plans/monthly/get-remaining-date-txt", { params })
            .then(res => {
                const resData = res.data.data;
                if(resData.status == "success") {
                    planLineItem.remaining_date = resData.remaining_date;
                } else {
                    swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูล "พอใช้ถึงเดือน" | ${resData.message}`, "error");
                }
            }).catch((error) => {
                console.log(error);
                swal("เกิดข้อผิดพลาด", `ไม่สามารถดึงข้อมูล "พอใช้ถึงเดือน" | ${error.message}`, "error");
                return ;
            });
            
            // // HIDE LOADING
            // this.isLoading = false;

        },

        emitPlanLineChanged() {
            this.$emit("onPlanLineChanged", {
                planLineItems: this.planLineItems
            });
        },
        
    }

}

</script>