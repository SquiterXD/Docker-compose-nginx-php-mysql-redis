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
            <th class="text-center" style="min-width: 130px;">Period <br>เดือนปิดบัญชี</th>
            <th class="text-center" style="min-width: 130px;">Policy No. <br>กรมธรรม์ชุดที่</th>
            <th class="text-center" style="min-width: 200px;">Policy Description <br>รายละเอียดกรมธรรม์ชุดที่</th>
            <th class="text-center" style="min-width: 170px;">Total Coverage Amount <br>มูลค่าทุนประกันรวม</th>
            <th class="text-center" style="min-width: 120px;">Total Premium <br>ค่าเบี้ยประกันรวม</th>
            <th class="text-center" style="min-width: 130px;">Count <br>จำนวนรายการ</th>
            <th class="text-center" style="min-width: 150px;">Department Code <br>รหัสหน่วยงาน</th>
            <th class="text-center" style="min-width: 200px;">Department <br>หน่วยงาน</th>
            <th class="text-center" style="min-width: 145px;">Document Number <br>เลขที่เอกสาร</th>
          </tr>
        </thead>
        <tbody  id="table_search" >
          <tr v-show="tableHeader.length > 0"
              v-for="(data, index) in tableHeader"
              :key="index" class="mouse-over"
              @click="clickRow(data, index)"
              :class="`style_row_show ${index === activeIndex ? 'highlight' : ''}`">
            <td class="text-center" 
                style="">
              <a  type="button" 
                  :href="`/ir/stocks/monthly/edit/${data.header_id}`"
                  class="btn btn-warning btn-xs">
                <span v-if="isNullOrUndefined(data.document_number)">View / Edit</span>
                <span v-else>Select</span>
              </a>
            </td>
            <td style="">
              {{setFirstLetterUpperCase(data.status)}}
            </td>
            <td class="text-center" style="">
              {{showYearBE('year', data.period_year)}}
            </td>
            <td class="text-center" style="">
              {{isNullOrUndefined(data.period_name) ? 
              showPeriodNameFormat(data.period_name) :
              isNullOrUndefined(data.period_name)}}
            </td>
            <td class="text-center"
                style="">
              {{isNullOrUndefined(data.policy_set_number)}}
            </td>
            <td style="">
              {{isNullOrUndefined(data.policy_set_description)}}
            </td>
            <td class="text-right">{{ formatCurrency(data.total_cover_amount) }}</td>
            <td class="text-right">{{ formatCurrency(data.total_insu_amount) }}</td>
            <td class="text-right">
              {{isNullOrUndefined(data.total_rec) || isNullOrUndefined(data.total_rec) === 0 ?
              formatCurrency(data.total_rec) :
              isNullOrUndefined(data.total_rec)}}
            </td>
            <td class="text-center"
                style="">
              {{isNullOrUndefined(data.department_code)}}
            </td>
            <td style="">
              {{isNullOrUndefined(data.department_desc)}}
            </td>
            <td style="">
              {{isNullOrUndefined(data.document_number)}}
            </td>
          </tr>
          <tr class="text-center mouse-over" v-if="tableHeader.length === 0"><td colspan="10">ไม่มีข้อมูล</td></tr>
        </tbody>
        <tfoot></tfoot>
      </table>
    </div>
  </div>
</template>
<script>
  export default {
    name: 'ir-stock-monthly-index-table-header',

    props: [
      'isNullOrUndefined',
      'tableHeader',
      'showPeriodNameFormat',
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
          }else {
            dataTableTotal.push({
              policy_set_number: item.policy_set_number,
              group_name:        'กรมธรรม์ชุดที่ '+item.policy_set_number,
              amount:            item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_amount       ? parseFloat(item.total_amount)       : 0 : 0,
              coverage:          item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_cover_amount ? parseFloat(item.total_cover_amount) : 0 : 0,
              premium:           item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_insu_amount  ? parseFloat(item.total_insu_amount)  : 0 : 0,
              duty_fee:          item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_duty_amount  ? parseFloat(item.total_duty_amount)  : 0 : 0,
              net_amount:        item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_net_amount   ? parseFloat(item.total_net_amount)   : 0 : 0,
              vat:               item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_vat_amount   ? parseFloat(item.total_vat_amount)   : 0 : 0,
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
      clickRow (row, index) {
        let obj = {
          department_code: this.isNullOrUndefined(row.department_code),
          department_desc: this.isNullOrUndefined(row.department_desc),
          document_number: this.isNullOrUndefined(row.document_number),
          period_from: '',
          period_to: '',
          policy_set_description: this.isNullOrUndefined(row.policy_set_description),
          policy_set_header_id: this.isNullOrUndefined(row.policy_set_header_id),
          status: this.isNullOrUndefined(row.status),
          year: this.isNullOrUndefined(row.year),
          inventory_desc: 'Inventory',
          inventory_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.inventory_amount),
          inventory_cover_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.inventory_cover_amount),
          inventory_insu_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.inventory_insu_amount),
          manual_desc: 'Manual',
          manual_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.manual_amount),
          manual_cover_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.manual_cover_amount),
          manual_insu_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.manual_insu_amount),
          total_desc: 'Total',
          total_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_amount),
          total_cover_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_cover_amount),
          total_insu_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_insu_amount),
          insurance_start_date: '',
          insurance_end_date: '',
          period_name: this.isNullOrUndefined(row.period_name),
          total_rec: this.isNullOrUndefined(row.total_rec),
          inventory_duty_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.inventory_duty_amount),
          inventory_vat_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.inventory_vat_amount),
          inventory_net_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.inventory_net_amount),
          manual_duty_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.manual_duty_amount),
          manual_vat_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.manual_vat_amount),
          manual_net_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.manual_net_amount),
          total_duty_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_duty_amount),
          total_vat_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_vat_amount),
          total_net_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_net_amount)
        }
        this.$emit('click-row', obj);
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
