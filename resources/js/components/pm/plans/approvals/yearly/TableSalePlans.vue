<template>

    <div class="table-responsive" style="max-height: 320px;">

        <table class="table table-sticky table-bordered mb-0" style="min-width: 1306px;">
            <thead>
                <tr>
                    <th class="text-center freeze-col" style="min-width: 320px;"> 
                        <div class="freeze-col-content" style="padding: 0px;">
                            <div class="text-center tw-inline-block tw-py-4" style="min-width: 100px; max-width: 100px;">
                                รหัสสินค้า
                            </div>
                            <div class="text-center tw-inline-block tw-py-4" style="min-width: 180px; max-width: 180px; border-left: 1px solid #ddd;">
                                ตราบุหรี่ 
                            </div>
                        </div>
                    </th>
                    <th style="min-width: 92px; max-width: 92px;" class="text-center"> ตุลาคม </th>
                    <th style="min-width: 92px; max-width: 92px;" class="text-center"> พฤศจิกายน </th>
                    <th style="min-width: 92px; max-width: 92px;" class="text-center"> ธันวาคม </th>
                    <th style="min-width: 92px; max-width: 92px;" class="text-center"> มกราคม </th>
                    <th style="min-width: 92px; max-width: 92px;" class="text-center"> กุมภาพันธ์ </th>
                    <th style="min-width: 92px; max-width: 92px;" class="text-center"> มีนาคม </th>
                    <th style="min-width: 92px; max-width: 92px;" class="text-center"> เมษายน </th>
                    <th style="min-width: 92px; max-width: 92px;" class="text-center"> พฤษภาคม </th>
                    <th style="min-width: 92px; max-width: 92px;" class="text-center"> มิถุนายน </th>
                    <th style="min-width: 92px; max-width: 92px;" class="text-center"> กรกฎาคม </th>
                    <th style="min-width: 92px; max-width: 92px;" class="text-center"> สิงหาคม </th>
                    <th style="min-width: 92px; max-width: 92px;" class="text-center"> กันยายน </th>
                    <th style="min-width: 200px; max-width: 200px;" class="text-center"> รวม </th>
                </tr>
            </thead>

            <tbody v-if="salePlanItems.length > 0">
                <template v-for="(salePlanItem, bIndex) in salePlanItems">
                    <tr :key="`${bIndex}`">
                        <td class="text-center freeze-col" style="min-width: 320px;"> 
                            <div class="freeze-col-content" style="padding: 0px;">
                                <div class="text-center tw-inline-block tw-py-4" style="min-width: 100px; max-width: 100px;">
                                    {{ salePlanItem.item_code }}
                                </div>
                                <div class="text-center tw-inline-block tw-py-4" style="min-width: 180px; max-width: 180px; border-left: 1px solid #ddd;">
                                    {{ salePlanItem.item_description }} 
                                </div>
                            </div>
                        </td>
                        <td style="min-width: 92px; max-width: 92px;" class="text-right"> {{ salePlanItem.oct_converted }} </td>
                        <td style="min-width: 92px; max-width: 92px;" class="text-right"> {{ salePlanItem.nov_converted }} </td>
                        <td style="min-width: 92px; max-width: 92px;" class="text-right"> {{ salePlanItem.dec_converted }} </td>
                        <td style="min-width: 92px; max-width: 92px;" class="text-right"> {{ salePlanItem.jan_converted }} </td>
                        <td style="min-width: 92px; max-width: 92px;" class="text-right"> {{ salePlanItem.feb_converted }} </td>
                        <td style="min-width: 92px; max-width: 92px;" class="text-right"> {{ salePlanItem.mar_converted }} </td>
                        <td style="min-width: 92px; max-width: 92px;" class="text-right"> {{ salePlanItem.apr_converted }} </td>
                        <td style="min-width: 92px; max-width: 92px;" class="text-right"> {{ salePlanItem.may_converted }} </td>
                        <td style="min-width: 92px; max-width: 92px;" class="text-right"> {{ salePlanItem.jun_converted }} </td>
                        <td style="min-width: 92px; max-width: 92px;" class="text-right"> {{ salePlanItem.jul_converted }} </td>
                        <td style="min-width: 92px; max-width: 92px;" class="text-right"> {{ salePlanItem.aug_converted }} </td>
                        <td style="min-width: 92px; max-width: 92px;" class="text-right"> {{ salePlanItem.sep_converted }} </td>
                        <td style="min-width: 200px; max-width: 200px;" class="text-right"> {{ salePlanItem.total_converted }} </td>
                    </tr>
                </template>
                <tr>
                    <th style="min-width: 320px; max-width: 320px;" class="text-left tw-bg-white freeze-col"> 
                        <div class="freeze-col-content" style="padding: 0px;">
                            <div class="tw-inline-block tw-py-4">
                                ยอดรวมทุกตรา 
                            </div>
                        </div>
                    </th>
                    <td style="min-width: 92px; max-width: 92px;" class="text-right"> {{ salePlanSummaryItem.oct_converted }} </td>
                    <td style="min-width: 92px; max-width: 92px;" class="text-right"> {{ salePlanSummaryItem.nov_converted }} </td>
                    <td style="min-width: 92px; max-width: 92px;" class="text-right"> {{ salePlanSummaryItem.dec_converted }} </td>
                    <td style="min-width: 92px; max-width: 92px;" class="text-right"> {{ salePlanSummaryItem.jan_converted }} </td>
                    <td style="min-width: 92px; max-width: 92px;" class="text-right"> {{ salePlanSummaryItem.feb_converted }} </td>
                    <td style="min-width: 92px; max-width: 92px;" class="text-right"> {{ salePlanSummaryItem.mar_converted }} </td>
                    <td style="min-width: 92px; max-width: 92px;" class="text-right"> {{ salePlanSummaryItem.apr_converted }} </td>
                    <td style="min-width: 92px; max-width: 92px;" class="text-right"> {{ salePlanSummaryItem.may_converted }} </td>
                    <td style="min-width: 92px; max-width: 92px;" class="text-right"> {{ salePlanSummaryItem.jun_converted }} </td>
                    <td style="min-width: 92px; max-width: 92px;" class="text-right"> {{ salePlanSummaryItem.jul_converted }} </td>
                    <td style="min-width: 92px; max-width: 92px;" class="text-right"> {{ salePlanSummaryItem.aug_converted }} </td>
                    <td style="min-width: 92px; max-width: 92px;" class="text-right"> {{ salePlanSummaryItem.sep_converted }} </td>
                    <td style="min-width: 200px; max-width: 200px;" class="text-right"> {{ salePlanSummaryItem.total_converted }} </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="13">
                        <h2 class="p-5 text-center text-muted"> ไม่พบข้อมูล </h2>
                    </td>
                </tr>
            </tbody>

        </table>

    </div>
                    
</template>

<script>

export default {
    
    props: ["salePlans", "salePlanSummary"],

    data() {
        return {
            salePlanItems: this.salePlans.map(item => {
                return {
                    ...item,
                    oct_converted: Number(parseFloat(item.oct) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
                    nov_converted: Number(parseFloat(item.nov) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
                    dec_converted: Number(parseFloat(item.dec) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
                    jan_converted: Number(parseFloat(item.jan) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
                    feb_converted: Number(parseFloat(item.feb) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
                    mar_converted: Number(parseFloat(item.mar) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
                    apr_converted: Number(parseFloat(item.apr) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
                    may_converted: Number(parseFloat(item.may) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
                    jun_converted: Number(parseFloat(item.jun) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
                    jul_converted: Number(parseFloat(item.jul) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
                    aug_converted: Number(parseFloat(item.aug) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
                    sep_converted: Number(parseFloat(item.sep) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
                    total_converted: Number(parseFloat(item.total) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
                }
            }),
            salePlanSummaryItem: {
                ...this.salePlanSummary,
                oct_converted: Number(parseFloat(this.salePlanSummary.oct) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
                nov_converted: Number(parseFloat(this.salePlanSummary.nov) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
                dec_converted: Number(parseFloat(this.salePlanSummary.dec) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
                jan_converted: Number(parseFloat(this.salePlanSummary.jan) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
                feb_converted: Number(parseFloat(this.salePlanSummary.feb) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
                mar_converted: Number(parseFloat(this.salePlanSummary.mar) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
                apr_converted: Number(parseFloat(this.salePlanSummary.apr) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
                may_converted: Number(parseFloat(this.salePlanSummary.may) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
                jun_converted: Number(parseFloat(this.salePlanSummary.jun) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
                jul_converted: Number(parseFloat(this.salePlanSummary.jul) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
                aug_converted: Number(parseFloat(this.salePlanSummary.aug) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
                sep_converted: Number(parseFloat(this.salePlanSummary.sep) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
                total_converted: Number(parseFloat(this.salePlanSummary.total) / 1000).toLocaleString(undefined, {minimumFractionDigits: 2,maximumFractionDigits: 2}),
            }
        }
    },
    computed: {

    },
    methods: {

        

    }

}

</script>