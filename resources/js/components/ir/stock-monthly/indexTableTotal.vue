<template>
  <div class="table-responsive margin_top_20">
    <table class="table table-striped">
      <thead>
        <tr class="text-right">
          <th class="width_table"></th>
          <th class="width_table">Total Amount <br>มูลค่าสินค้ารวม (บาท)</th>
          <th class="width_table">Total Coverage Amount <br>มูลค่าทุนประกันรวม</th>
          <th class="width_table">Total Premium <br>ค่าเบี้ยประกันรวม</th>
          <th class="width_table">Total Duty Fee <br>อากรรวม</th>
          <th class="width_table">Total Vat <br>ภาษีมูลค่าเพิ่มรวม</th>
          <th class="width_table">Total Net Amount <br>ค่าเบี้ยประกันสุทธิรวม</th>
        </tr>
      </thead>
      <tbody id="table_total">
        <tr class="text-right">
          <td>{{rowTotal.inventory_desc}}</td>
          <td>{{formatCurrency(rowTotal.inventory_amount)}}</td>
          <td>{{formatCurrency(rowTotal.inventory_cover_amount)}}</td>
          <td>{{formatCurrency(rowTotal.inventory_insu_amount)}}</td>
          <td>{{formatCurrency(rowTotal.inventory_duty_amount)}}</td>
          <td>{{formatCurrency(rowTotal.inventory_vat_amount)}}</td>
          <td>{{formatCurrency(rowTotal.inventory_net_amount)}}</td>
        </tr>
        <tr class="text-right">
          <td>{{rowTotal.manual_desc}}</td>
          <td>{{formatCurrency(rowTotal.manual_amount)}}</td>
          <td>{{formatCurrency(rowTotal.manual_cover_amount)}}</td>
          <td class="el_field_table"
             >
            <div class="currency_right"> 
              {{formatCurrency(rowTotal.manual_insu_amount)}}
            </div>
          </td>
          <td>{{formatCurrency(rowTotal.manual_duty_amount)}}</td>
          <td>{{formatCurrency(rowTotal.manual_vat_amount)}}</td>
          <td>{{formatCurrency(rowTotal.manual_net_amount)}}</td>
        </tr>
        <tr class="text-right">
          <td>{{rowTotal.total_desc}}</td>
          <td>{{formatCurrency(rowTotal.total_amount)}}</td>
          <td>{{formatCurrency(rowTotal.total_cover_amount)}}</td>
          <td>{{formatCurrency(rowTotal.total_insu_amount)}}</td>
          <td>{{formatCurrency(rowTotal.total_duty_amount)}}</td>
          <td>{{formatCurrency(rowTotal.total_vat_amount)}}</td>
          <td>{{formatCurrency(rowTotal.total_net_amount)}}</td>
        </tr>
      </tbody>
      <tfoot></tfoot>
    </table>
  </div>
</template>

<script>
  export default {
    name: 'ir-stock-monthly-index-table-total',
    data () {
      return {
        index: 0
      }
    },
    props: [
      'rowTotal',
      'formatCurrency'
    ],
    methods: {
      getDataManualInsuAmount (value) {
        this.rowTotal.manual_insu_amount = value
        this.$emit('change-manual-insu-amount', value)
      }
    }
  }
</script>
