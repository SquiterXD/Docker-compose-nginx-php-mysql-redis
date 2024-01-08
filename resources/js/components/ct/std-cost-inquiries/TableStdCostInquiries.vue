<template>

    <div>

        <div class="table-responsive" style="max-height: 600px;">

            <table class="table table-bordered table-sticky mb-0">
                <thead>
                    <tr>
                        <th width="7%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> ปีบัญชีงบประมาณ </th>
                        <th width="7%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> ศูนย์ต้นทุน </th>
                        <th width="5%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> ครั้งที่ </th>
                        <th width="8%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> ผลิตภัณฑ์ </th>
                        <th width="12%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> รายการผลิตภัณฑ์ </th>
                        <th width="12%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> ราคา INV </th>
                        <th width="12%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> ราคาต้นทุน </th>
                        <th width="7%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> หน่วยนับ </th>
                        <th width="5%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> รหัส ORG </th>
                        <th width="12%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> ชื่อ ORG </th>
                        <!-- <th width="5%" class="text-center tw-text-xs md:tw-table-cell" style="z-index: 2;"> สถานะราคา </th> -->
                    </tr>
                </thead>
                <tbody v-if="stdCostInquirieItems.length > 0">

                    <template v-for="(stdCostInquirieItem, index) in stdCostInquirieItems">

                        <tr :key="`${index}`" v-bind:class="[ stdCostInquirieItem.status_cost == 'N' ? 'tw-text-red-400' : '']">

                            <td class="text-center md:tw-table-cell">
                                {{ stdCostInquirieItem.period_year_thai }}
                            </td>
                            <td class="text-left md:tw-table-cell">
                                {{ stdCostInquirieItem.cost_code }} : {{ stdCostInquirieItem.cost_desc }}
                            </td>
                            <td class="text-center md:tw-table-cell">
                                {{ stdCostInquirieItem.version_no }}
                            </td>
                            <td class="text-center md:tw-table-cell">
                                {{ stdCostInquirieItem.item_number }} 
                            </td>
                            <td class="text-left md:tw-table-cell">
                                {{ stdCostInquirieItem.description }} 
                            </td>
                            <td class="text-right md:tw-table-cell">
                                {{ stdCostInquirieItem.item_cost ? Number(stdCostInquirieItem.item_cost).toLocaleString(undefined, {minimumFractionDigits: 9,maximumFractionDigits: 9}) : "0.000000000" }} 
                            </td>
                            <td class="text-right md:tw-table-cell">
                                {{ stdCostInquirieItem.total_cost_per_unit ? Number(stdCostInquirieItem.total_cost_per_unit).toLocaleString(undefined, {minimumFractionDigits: 9,maximumFractionDigits: 9}) : "0.000000000" }} 
                            </td>
                            <td class="text-center md:tw-table-cell">
                                {{ stdCostInquirieItem.uom_desc }} 
                            </td>
                            <td class="text-center md:tw-table-cell">
                                {{ stdCostInquirieItem.organization_code }} 
                            </td>
                            <td class="text-center md:tw-table-cell">
                                {{ stdCostInquirieItem.organization_name }} 
                            </td>
                            <!-- <td class="text-center text-nowrap"> 
                                {{ stdCostInquirieItem.status_cost }} 
                            </td> -->

                        </tr>

                    </template>

                </tbody>
                <tbody v-else>
                    <tr>
                        <td colspan="11">
                            <h2 class="p-5 text-center text-muted">ไม่พบข้อมูล</h2>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <loading :active.sync="isLoading" :is-full-page="true"></loading>

    </div>
                    
</template>

<script>

import VueNumeric from 'vue-numeric'
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';

export default {
    
    props: [
        "periodYearValue", 
        "stdCostInquiries", 
    ],

    components: { Loading, VueNumeric },

    watch: {
        periodYearValue : function (value) {
            this.periodYear = value;
        },
        stdCostInquiries : function (value) {

            this.stdCostInquirieItems = value.map(item => {
                return {
                    ...item,
                }
            });

        },
    },

    data() {

        return {

            periodYear: this.periodYearValue,
            stdCostInquirieItems: this.stdCostInquiries.map(item => {
                return {
                    ...item,
                }
            }),
            
            isLoading: false

        }

    },

    mounted() {

        // this.emitStdcostAccountsChanged();

    },

    computed: {

    },
    methods: {

        formatNumber(value) {
            let result = value.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            return result;
        },

        isNumber: function(evt) {
            evt = (evt) ? evt : window.event;
            var charCode = (evt.which) ? evt.which : evt.keyCode;
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault();;
            } else {
                return true;
            }
        }

    }

}

</script>