<template>
    <div class="table-responsive margin_top_20">
        <table class="table table-striped">
            <thead>
            <tr class="text-right">
                <th class="width_table">Total Asset Cost <br>ราคาทุนรวม (บาท)</th>
                <th class="width_table">Total Coverage Amount <br>มูลค่าทุนประกันรวม</th>
                <th class="width_table">Total Premium <br>ค่าเบี้ยประกันรวม</th>
                <th class="width_table">Total Duty Fee <br>อากรรวม</th>
                <th class="width_table">Total Vat <br>ภาษีมูลค่าเพิ่มรวม</th>
                <th class="width_table">Total Net Amount <br>ค่าเบี้ยประกันสุทธิรวม</th>
                <th class="width_table" style="vertical-align: middle;">ค่าเบี้ยประกันเรียกเก็บสุทธิรวม</th>
            </tr>
            </thead>
            <tbody id="table_total">
            <tr class="text-right" v-show="tableTotal.length > 0"
                v-for="(data, index) in tableTotal" :key="index">
                <td>{{setZeroWhenIsNullOrUndefined(data.total_cost)}}</td>
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
                v-show="receivables.length > 0 && tableTotal.length > 0 && !checkStatusNew(statusRowTableHeader)">
                <td colspan="6">{{isNullOrUndefined(data.receivable_name)}}</td>
                <!-- <td>{{setZeroWhenIsNullOrUndefined(data.net_amount)}}</td> -->
                <td>{{formatCurrency(formatData(data.receivable_name, receivables))}}</td>
            </tr>
            <tr class="text-center" v-if="tableTotal.length === 0">
                <td colspan="7">ไม่มีข้อมูล</td>
            </tr>
            </tbody>
            <tfoot></tfoot>
        </table>
    </div>
</template>

<script>
    export default {
        name: 'ir-asset-plan-index-table-total',
        data() {
            return {}
        },
        props: [
            'tableTotal',
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
            },
            totalRecInsuAmount() {
                let data = 0
                this.receivables.filter(row => {
                    data += +Number(row.net_amount).toFixed(2);
                    // data += +row.net_amount;
                })
                return data;
            }
        },
        methods: {
            setZeroWhenIsNullOrUndefined(value) {
                if (value === '' || value === null || value === undefined || isNaN(value)) {
                    return this.formatCurrency('0')
                }
                return this.formatCurrency(value)
            },
            formatSum(v1, v2, v3) {
                return Number(Number(Number(v1).toFixed(2)) + Number(Number(v2).toFixed(2)) + Number(Number(v3).toFixed(2))).toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            },
            formatData(type, array) {
                let data = 0
                array.filter(row => {

                    if (row.receivable_name == type) {
                        data += +Number(row.net_amount).toFixed(2);
                    }
                    
                })
                return data;
            },
        }
    }
</script>
