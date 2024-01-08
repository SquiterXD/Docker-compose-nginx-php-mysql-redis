<template>

    <div class="table-responsive">

        <table class="table table-bordered table-sticky mb-0" style="min-width: 1000px;">
            <thead>
                <tr>
                    <th width="30%" class="text-center freeze-col" style="min-width: 480px; max-width: 480px;"> 
                        <div class="freeze-col-content" style="padding: 0px;">
                            <div class="text-center tw-inline-block tw-py-4" style="min-width: 200px; max-width: 200px;">
                                รหัสสินค้า
                            </div>
                            <div class="text-center tw-inline-block tw-py-4" style="min-width: 260px; max-width: 260px; border-left: 1px solid #ddd;">
                                ตราบุหรี่ 
                            </div>
                        </div>
                    </th>
                    <th width="40%" class="text-center" style="min-width: 440px;"> ประมาณการจำหน่าย(พันมวน) </th>
                    <th width="30%" class="text-center" style="min-width: 220px;"> ประมาณจำหน่าย(ล้านมวน)  </th>
                </tr>
            </thead>
            <tbody v-if="salePlanItems.length > 0">
                <template v-for="(salePlanItem, index) in salePlanItems">
                    <tr :key="`${index}`">
                        <td width="30%" class="text-center freeze-col" style="min-width: 480px; max-width: 480px;"> 
                            <div class="freeze-col-content" style="padding: 0px;">
                                <div class="text-center tw-inline-block tw-py-4" style="min-width: 200px; max-width: 200px;">
                                    {{ salePlanItem.item_code }}
                                </div>
                                <div class="text-center tw-inline-block tw-py-4" style="min-width: 260px; max-width: 260px; border-left: 1px solid #ddd;">
                                    {{ salePlanItem.item_description }} 
                                </div>
                            </div>
                        </td>
                        <td width="40%" class="text-right" style="min-width: 440px;"> {{ salePlanItem.quantity }} </td>
                        <td width="30%" class="text-right" style="min-width: 220px;"> {{ salePlanItem.quantity_m }} </td>
                    </tr>
                </template>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="4">
                        <h2 class="p-5 text-center text-muted"> ไม่พบข้อมูล </h2>
                    </td>
                </tr>
            </tbody>

        </table>

    </div>
                    
</template>

<script>

export default {
    
    props: ["salePlans"],

    data() {
        return {
            salePlanItems: this.salePlans.map(item => {
                return {
                    ...item,
                    quantity: Number((parseFloat(item.quantity))).toLocaleString(undefined, {minimumFractionDigits: 3,maximumFractionDigits: 3}),
                    quantity_m: Number((parseFloat(item.quantity) / 1000)).toLocaleString(undefined, {minimumFractionDigits: 3,maximumFractionDigits: 3}),
                    amount: Number((parseFloat(item.amount))).toLocaleString(undefined, {minimumFractionDigits: 3,maximumFractionDigits: 3}),
                    amount_t: Number((parseFloat(item.amount) / 1000)).toLocaleString(undefined, {minimumFractionDigits: 3,maximumFractionDigits: 3}),
                    amount_m: Number((parseFloat(item.amount) / 1000000)).toLocaleString(undefined, {minimumFractionDigits: 3,maximumFractionDigits: 3}),
                }
            }),
        }
    },
    computed: {

    },
    methods: {

    }

}

</script>