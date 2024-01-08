<template>
    <div class="table-responsive margin_top_20">
        <table class="table table-striped">
            <thead>
            <tr class="text-right">
                <th class="width_table">Transaction Amount <br>จำนวนเงิน (บาท)</th>
                <th class="width_table">Total Coverage Amount <br>มูลค่าทุนประกัน เพิ่ม/ลดรวม</th>
                <th class="width_table">Total Premium <br>ค่าเบี้ยประกัน เพิ่ม/ลดรวม</th>
                <th class="width_table">Total Duty Fee <br>อากรรวม</th>
                <th class="width_table">Total Vat <br>ภาษีมูลค่าเพิ่มรวม</th>
                <th class="width_table">Total Net Amount <br>ค่าเบี้ยประกัน เพิ่ม/ลดสุทธิรวม</th>
                <th class="width_table" style="vertical-align: middle;">ค่าเบี้ยประกัน เพิ่ม/ลดเรียกเก็บสุทธิรวม</th>
            </tr>
            </thead>
            <tbody id="table_total">
            <tr class="text-right"
                v-show="dataRowsTableTotal.length > 0"
                v-for="(data, index) in dataRowsTableTotal"
                :key="index">
                <td>{{setZeroWhenIsNullOrUndefined(data.total_adjustment_cost)}}</td>
                <td>{{setZeroWhenIsNullOrUndefined(data.total_cover_amount)}}</td>
                <td>{{setZeroWhenIsNullOrUndefined(data.total_insu_amount)}}</td>
                <td>{{setZeroWhenIsNullOrUndefined(data.total_duty_amount)}}</td>
                <td>{{setZeroWhenIsNullOrUndefined(data.total_vat_amount)}}</td>
                <td>{{formatSum(data.total_insu_amount,data.total_duty_amount,data.total_vat_amount)}}</td>
                <td>{{setZeroWhenIsNullOrUndefined(data.total_rec_insu_amount)}}</td>
            </tr>
            <tr class="text-right"
                v-for="(data, index) in newDataReceivables"
                :key="`rec_${index}`"
                v-show="receivables.length > 0 && dataRowsTableTotal.length > 0 && !checkStatusNew(statusRowTableHeader)">
                <td colspan="6">{{isNullOrUndefined(data.receivable_name)}}</td>
                <td>{{setZeroWhenIsNullOrUndefined(data.net_amount)}}</td>
            </tr>
            <tr class="text-center" v-if="dataRowsTableTotal.length === 0">
                <td colspan="7">ไม่มีข้อมูล</td>
            </tr>
            </tbody>
            <tfoot></tfoot>
        </table>
    </div>
</template>

<script>
    export default {
        name: 'ir-asset-increase-index-table-total',
        data() {
            return {}
        },
        props: [
            'dataRowsTableTotal',
            'formatCurrency',
            'isNullOrUndefined',
            'statusRowTableHeader',
            'checkStatusNew',
            'receivables'
        ],
        computed: {
            newDataReceivables() {
                return Array.from(this.receivables.reduce(
                    (m, {receivable_name, net_amount}) => m.set(receivable_name, (m.get(receivable_name) || 0) + +net_amount), new Map
                ), ([receivable_name, net_amount]) => ({receivable_name, net_amount}));
            }
        },
        methods: {
            setZeroWhenIsNullOrUndefined(value) {
                if (value === '' || value === null || value === undefined) {
                    return this.formatCurrency('0')
                }
                return this.formatCurrency(value)
            },
            formatSum(v1, v2, v3=0) {
                return Number(Number(Number(v1).toFixed(2)) + Number(Number(v2).toFixed(2)) + Number(Number(v3).toFixed(2))).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }
        }
    }
</script>
