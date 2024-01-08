<template>
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr class="text-right">
          <th style="min-width: 200px;">Total Amount<br>มูลค่าทุนประกันรวม</th>
          <th style="min-width: 200px;">Total Premium<br>ค่าเบี้ยประกันรวม</th>
          <!-- <th style="min-width: 200px;">Total Duty Fee<br>อากรรวม</th>
          <th style="min-width: 200px;">Vat <br>ภาษีมูลค่าเพิ่มรวม</th> -->
          <th style="min-width: 200px;">มูลค่าทุนประกัน เพิ่ม/ลด รวม</th>
          <th style="min-width: 150px;">ค่าเบี้ยประกัน เพิ่ม/ลด รวม</th>
          <th style="min-width: 250px;">Total Net Amount<br>ค่าเบี้ยประกันสุทธิต่อเดือนรวม</th>
        </tr>
      </thead>
      <tbody>
        <tr class="text-right" 
            v-show="tableTotal.length > 0"
            v-for="(data, index) in tableTotal"
            :key="index">
          <td>{{setZeroWhenIsNullOrUndefined(data.total_cover_amount)}}</td>
          <td>{{setZeroWhenIsNullOrUndefined(data.total_insu_amount)}}</td>
          <!-- <td>{{setZeroWhenIsNullOrUndefined(data.revenue_stamp)}}</td> -->
          <!-- <td>{{setZeroWhenIsNullOrUndefined(data.vat_amount)}}</td> -->
          <td>{{setZeroWhenIsNullOrUndefined(data.coverage_amount_cal)}}</td>
          <td>{{setZeroWhenIsNullOrUndefined(data.insurance_amount_cal)}}</td>
          <td>{{setZeroWhenIsNullOrUndefined(data.net_amount)}}</td>
        </tr>
        <tr class="text-center" v-if="tableTotal.length === 0"><td colspan="7">ไม่มีข้อมูล</td></tr>
      </tbody>
      <tfoot></tfoot>
    </table>
  </div>
</template>

<script>
export default {
  name: 'ir-expense-stock-asset-table-total',
  data () {
    return {}
  },
  props: [
    'tableTotal',
    'formatCurrency'
  ],
    methods: {
    setZeroWhenIsNullOrUndefined (value) {
      if (value === '' || value === null || value === undefined) {
        return this.formatCurrency('0')
      }
      return this.formatCurrency(value)
    }
  }
}
</script>
