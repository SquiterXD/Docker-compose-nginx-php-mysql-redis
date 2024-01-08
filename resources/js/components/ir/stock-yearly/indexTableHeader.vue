<template>
  <div class="margin_top_20">
    <div class="table-responsive">
      <table class="table table-striped table_style">
        <thead>
          <tr class="text-center">
            <th class="text-nowrap" v-show="tableTotal.length > 0"></th>
            <th class='text-right'>Total Amount<br>มูลค่าสินค้ารวม (บาท)</th>
            <th class='text-right'>Total Coverage Amount<br>มูลค่าทุนประกันรวม</th>
            <th class='text-right'>Total Premium<br>ค่าเบี้ยประกันรวม</th>
            <th class='text-right'>Total Duty Fee<br>อากรรวม</th>
            <th class='text-right'>Total Vat<br>ภาษีมูลค่าเพิ่มรวม</th>
            <th class='text-right'>Total Net Amount<br>ค่าเบี้ยประกันสุทธิรวม</th>
          </tr>
        </thead>
        <tbody id="table_search">
          <template v-for="(data, index) in tableTotal">
            <tr class="text-right" :key="index">
              <td class="text-nowrap" style="font-weight: bold;">{{ data.group_name }}</td>
              <td>{{formatCurrency(data.amount)}}</td>
              <td>{{formatCurrency(data.coverage)}}</td>
              <td>{{formatCurrency(data.premium)}}</td>
              <td>{{formatCurrency(data.duty_fee)}}</td>
              <td>{{formatCurrency(data.vat)}}</td>
              <td>{{formatCurrency(data.net_amount)}}</td>
            </tr>
          </template>
          <tr class="text-center" v-show="tableTotal.length === 0"><td colspan="99">ไม่มีข้อมูล</td></tr>
        </tbody>
        <tfoot></tfoot>
      </table>
    </div>
    <div class="table-responsive">
      <table class="table table-bordered"
        style="display: block; overflow: auto; max-height: 500px;">
        <thead>
          <tr>
            <th class="text-center" style="min-width: 120px;">Action</th>
            <th class="text-center" style="min-width: 110px;">IR Status <br>สถานะ</th>
            <th class="text-center" style="min-width: 110px;">Year <br>ปี</th>
            <th class="text-center" style="min-width: 170px;">Period From <br>ข้อมูลย้อนหลังตั้งแต่เดือน</th>
            <th class="text-center" style="min-width: 170px;">Period To <br>ถึงเดือน</th>
            <th class="text-center" style="min-width: 130px;">Policy No. <br>กรมธรรม์ชุดที่</th>
            <th class="text-center" style="min-width: 200px;">Policy Description <br>รายละเอียดกรมธรรม์ชุดที่</th>
            <th class="text-center" style="min-width: 170px;">Total Coverage Amount <br>มูลค่าทุนประกันรวม</th>
            <th class="text-center" style="min-width: 120px;">Total Premium <br>ค่าเบี้ยประกันรวม</th>
            <th class="text-center" style="min-width: 130px;">Count <br>จำนวนรายการ</th>
            <th class="text-center" style="min-width: 150px;">Department Code <br>รหัสหน่วยงาน</th>
            <th class="text-center" style="min-width: 200px;">Department <br>หน่วยงาน</th>
            <th class="text-center" style="min-width: 130px;">วันที่คุ้มครองตั้งแต่</th>
            <th class="text-center" style="min-width: 130px;">วันที่คุ้มครองถึง</th>
            <th class="text-center" style="min-width: 145px;">Document Number <br>เลขที่เอกสาร</th>
            <th class="text-center" style="min-width: 145px;">Reference <br>Document</th>
          </tr>
        </thead>
        <tbody  id="table_search">
          <tr 
            v-show="tableHeader.length > 0"
            v-for="(data, index) in tableHeader" 
            :key="index" class="mouse-over"
            @click="clickRow(data, index)" 
            :class="`style_row_show ${index === activeIndex ? 'highlight' : ''}`">
            <td class="text-center">
              <a type="button" :href="`/ir/stocks/yearly/edit/${data.header_id}`"
                class="btn btn-warning btn-xs">
                <span v-if="isNullOrUndefined(data.document_number)">View / Edit</span>
                <span v-else>Select</span>
              </a>
            </td>
            <td>{{setFirstLetterUpperCase(data.status)}}</td>
            <td class="text-center">{{showYearBE('year', data.period_year)}}</td>
            <td class="text-center">{{showYearBE('month', data.period_from)}}</td>
            <td class="text-center">{{showYearBE('month', data.period_to)}}</td>
            <td class="text-center">{{isNullOrUndefined(data.policy_set_number)}}</td>
            <td>
              {{isNullOrUndefined(data.policy_set_description)}}
            </td>
            <td class="text-right">{{ formatCurrency(data.total_cover_amount) }}</td>
            <td class="text-right">{{ formatCurrency(data.total_insu_amount) }}</td>
            <td class="text-right">
              {{isNullOrUndefined(data.total_rec) || isNullOrUndefined(data.total_rec) === 0 ?
              formatCurrency(data.total_rec) :
              isNullOrUndefined(data.total_rec)}}
            </td>
            <td class="text-center">{{isNullOrUndefined(data.department_code)}}</td>
            <td>{{isNullOrUndefined(data.department_desc)}}</td>
            <td class="text-center">{{showYearBE('date', data.insurance_start_date)}}</td>
            <td class="text-center">{{showYearBE('date', data.insurance_end_date)}}</td>
            <td>
              <div>{{isNullOrUndefined(data.document_number)}}</div>
            </td>
            <td><div>{{isNullOrUndefined(data.reference_document_number)}}</div></td>
          </tr>
          <tr class="text-center mouse-over" v-show="tableHeader.length === 0"><td colspan="14">ไม่มีข้อมูล</td></tr>
        </tbody>
        <tfoot></tfoot>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ir-stock-yearly-index-table-header',

  props: [
    'isNullOrUndefined',
    'tableHeader',
    'setFirstLetterUpperCase',
    'showYearBE',
    'checkStatusNew',
    'formatCurrency'
  ],

  data () {
    return {
      activeIndex: ''
    }
  },

  computed: {
    tableTotal () {
      const vm = this;
      let find = null;
      let total_amount = 0;
      let total_coverage = 0;
      let total_premium = 0;
      let total_duty_fee = 0;
      let total_net_amount = 0;
      let total_vat = 0;
      let dataTableTotal = [];

      if(vm.tableHeader.length === 0) return dataTableTotal;

      vm.tableHeader.forEach((item) => {
        // if ( !['CONFIRMED', 'INTERFACE'].includes(item.status) ) return

        find = null;
        find = dataTableTotal.find((search)=>{
          return search.policy_set_number == item.policy_set_number;
        });

        if(find){
          find.amount     += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_amount       ? parseFloat(item.total_amount)       : 0 : 0;
          find.coverage   += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_cover_amount ? parseFloat(item.total_cover_amount) : 0 : 0;
          find.premium    += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_insu_amount  ? parseFloat(item.total_insu_amount)  : 0 : 0;
          find.duty_fee   += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_duty_amount  ? parseFloat(item.total_duty_amount)  : 0 : 0;
          find.net_amount += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_net_amount   ? parseFloat(item.total_net_amount)   : 0 : 0;
          find.vat        += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_vat_amount   ? parseFloat(item.total_vat_amount)   : 0 : 0;
          find.status     =  item.status;
        }else {
          dataTableTotal.push({
            policy_set_number: item.policy_set_number,
            group_name:        'กรมธรรม์ชุดที่ '+ item.policy_set_number,
            amount:            item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_amount       ? parseFloat(item.total_amount)       : 0 : 0,
            coverage:          item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_cover_amount ? parseFloat(item.total_cover_amount) : 0 : 0,
            premium:           item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_insu_amount  ? parseFloat(item.total_insu_amount)  : 0 : 0,
            duty_fee:          item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_duty_amount  ? parseFloat(item.total_duty_amount)  : 0 : 0,
            net_amount:        item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_net_amount   ? parseFloat(item.total_net_amount)   : 0 : 0,
            vat:               item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_vat_amount   ? parseFloat(item.total_vat_amount)   : 0 : 0,
            status:            item.status,
          });
        }

        total_amount     += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_amount       ? parseFloat(item.total_amount)       : 0 : 0;
        total_coverage   += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_cover_amount ? parseFloat(item.total_cover_amount) : 0 : 0;
        total_premium    += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_insu_amount  ? parseFloat(item.total_insu_amount)  : 0 : 0;
        total_duty_fee   += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_duty_amount  ? parseFloat(item.total_duty_amount)  : 0 : 0;
        total_net_amount += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_net_amount   ? parseFloat(item.total_net_amount)   : 0 : 0;
        total_vat        += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_vat_amount   ? parseFloat(item.total_vat_amount)   : 0 : 0;

      });

      dataTableTotal.push({
        group_name: 'Total',
        amount:     total_amount,
        coverage:   total_coverage,
        premium:    total_premium,
        duty_fee:   total_duty_fee,
        net_amount: total_net_amount,
        vat:        total_vat,
      });

      return dataTableTotal;
    }
  },
  
  watch: {
    'tableHeader' (newVal, oldVal) {
      this.activeIndex = '';
    }
  },

  methods: {
    clickRow (dataRow, index) {
       
      let setRow = {
        department_code: this.isNullOrUndefined(dataRow.department_code),
        department_desc: this.isNullOrUndefined(dataRow.department_desc),
        document_number: this.isNullOrUndefined(dataRow.document_number),
        period_from: this.isNullOrUndefined(dataRow.period_from),
        period_to: this.isNullOrUndefined(dataRow.period_to),
        policy_set_description: this.isNullOrUndefined(dataRow.policy_set_description),
        policy_set_header_id: this.isNullOrUndefined(dataRow.policy_set_header_id),
        status: this.isNullOrUndefined(dataRow.status),
        period_year: this.isNullOrUndefined(dataRow.period_year),
        inventory_desc: 'Inventory',
        inventory_amount: this.checkStatusNew(dataRow.status) ? 0 : this.isNullOrUndefined(dataRow.inventory_amount),
        inventory_cover_amount: this.checkStatusNew(dataRow.status) ? 0 : this.isNullOrUndefined(dataRow.inventory_cover_amount),
        inventory_insu_amount: this.checkStatusNew(dataRow.status) ? 0 : this.isNullOrUndefined(dataRow.inventory_insu_amount),
        manual_desc: 'Manual',
        manual_amount: this.checkStatusNew(dataRow.status) ? 0 : this.isNullOrUndefined(dataRow.manual_amount),
        manual_cover_amount: this.checkStatusNew(dataRow.status) ? 0 : this.isNullOrUndefined(dataRow.manual_cover_amount),
        manual_insu_amount: this.checkStatusNew(dataRow.status) ? 0 : this.isNullOrUndefined(dataRow.manual_insu_amount),
        total_desc: 'Total',
        total_amount: this.checkStatusNew(dataRow.status) ? 0 : this.isNullOrUndefined(dataRow.total_amount),
        total_cover_amount: this.checkStatusNew(dataRow.status) ? 0 : this.isNullOrUndefined(dataRow.total_cover_amount),
        total_insu_amount: this.checkStatusNew(dataRow.status) ? 0 : this.isNullOrUndefined(dataRow.total_insu_amount),
        insurance_start_date: this.isNullOrUndefined(dataRow.insurance_start_date),
        insurance_end_date: this.isNullOrUndefined(dataRow.insurance_end_date),
        period_name: this.isNullOrUndefined(dataRow.period_name),
        inventory_duty_amount: this.checkStatusNew(dataRow.status) ? 0 : this.isNullOrUndefined(dataRow.inventory_duty_amount),
        inventory_vat_amount: this.checkStatusNew(dataRow.status) ? 0 : this.isNullOrUndefined(dataRow.inventory_vat_amount),
        inventory_net_amount: this.checkStatusNew(dataRow.status) ? 0 : this.isNullOrUndefined(dataRow.inventory_net_amount),
        manual_duty_amount: this.checkStatusNew(dataRow.status) ? 0 : this.isNullOrUndefined(dataRow.manual_duty_amount),
        manual_vat_amount: this.checkStatusNew(dataRow.status) ? 0 : this.isNullOrUndefined(dataRow.manual_vat_amount),
        manual_net_amount: this.checkStatusNew(dataRow.status) ? 0 : this.isNullOrUndefined(dataRow.manual_net_amount),
        total_duty_amount: this.checkStatusNew(dataRow.status) ? 0 : this.isNullOrUndefined(dataRow.total_duty_amount),
        total_vat_amount: this.checkStatusNew(dataRow.status) ? 0 : this.isNullOrUndefined(dataRow.total_vat_amount),
        total_net_amount: this.checkStatusNew(dataRow.status) ? 0 : this.isNullOrUndefined(dataRow.total_net_amount)
      }
      this.$emit('click-row', setRow)
      this.activeIndex = index;
    }
  },
}
</script>

<style scoped>
  th, td {
    padding: 0.25rem;
  }
  th {
    background: white;
    position: sticky;
    top: 0; /* Don't forget this, required for the stickiness */
  }
  .mouse-over:hover {
    background-color: #d4edda!important;
  }
</style>
