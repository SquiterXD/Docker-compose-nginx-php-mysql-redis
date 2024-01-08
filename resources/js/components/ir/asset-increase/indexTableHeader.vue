<template>
  <div>
    <div class="table-responsive">
      <table class="table table-striped table_style">
        <thead>
          <tr class="text-center">
            <th class="text-nowrap" v-show="tableTotal.length > 0"></th>
            <th class='text-center'>Total Amount<br>มูลค่าสินค้ารวม (บาท)</th>
            <th class='text-center'>Total Coverage Amount<br>มูลค่าทุนประกันรวม</th>
            <th class='text-center'>Total Premium<br>ค่าเบี้ยประกันรวม</th>
            <th class='text-center'>Total Duty Fee<br>อากรรวม</th>
            <th class='text-center'>Total Vat<br>ภาษีมูลค่าเพิ่มรวม</th>
            <th class='text-center'>Total Net Amount<br>ค่าเบี้ยประกันสุทธิรวม</th>
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
      </table>
    </div>
  <div class="table-responsive">
    <table  class="table table-bordered"
            style="display: block; overflow: auto; max-height: 500px;">
      <thead>
        <tr>
          <th style="min-width: 120px;" class="text-center">Action</th>
          <th style="min-width: 110px;" class="text-center">IR Status <br>สถานะ</th>
          <th class="text-center" style="min-width: 110px;">Year <br>ปี</th>
          <!-- <th style="min-width: 110px;" class="text-center">Revision <br>ครั้งที่</th> -->
          <th style="min-width: 130px;" class="text-center">Policy No. <br>กรมธรรม์ชุดที่</th>
          <th style="min-width: 200px; width: 1%;" class="text-center">Policy Description <br>รายละเอียดกรมธรรม์ชุดที่</th>
          <th class="text-center" style="min-width: 200px;">Total Coverage Amount <br>มูลค่าทุนประกันรวม</th>
          <th class="text-center" style="min-width: 120px;">Total Premium <br>ค่าเบี้ยประกันรวม</th>
          <th style="min-width: 120px;" class="text-center">Count <br>จำนวนรายการ</th>
          <th class="text-center" style="min-width: 160px;">วันที่คิดค่าเบี้ยตั้งแต่</th>
          <th class="text-center" style="min-width: 160px;">วันที่คิดค่าเบี้ยถึง</th>
          <th style="min-width: 100px;" class="text-center">จำนวนวัน</th>
          <th class="text-center" style="min-width: 160px;">วันที่ขึ้นทะเบียน/ตัดจำหน่ายตั้งแต่</th>
          <th class="text-center" style="min-width: 160px;">วันที่ขึ้นทะเบียน/ตัดจำหน่ายถึง</th>
          <th style="min-width: 150px;" class="text-center">Document Number <br>เลขที่เอกสาร</th>
          <th style="min-width: 120px;" class="text-center">Reference <br>Document</th>
        </tr>
      </thead>
      <tbody id="table_search">
        <tr v-show="rows.length > 0"
            v-for="(data, index) in rows"
            :key="index" class="mouse-over"
            @click="clickRow(data, index)"
            :class="`style_row_show ${index === activeIndex ? 'highlight' : ''}`">
          <td class="text-center">
            <a  type="button"
                :href="`/ir/assets/asset-increase/edit/${data.header_id}`"
                class="btn btn-warning btn-xs">
              <span v-if="isNullOrUndefined(data.document_number)">View / Edit</span>
              <span v-else>Select</span>
            </a>
          </td>
          <td>{{setFirstLetterUpperCase(data.status)}}</td>
          <td class="text-center">{{showYearBE('year', data.year)}}</td>
          <!-- <td class="text-center">{{isNullOrUndefined(data.revision)}}</td> -->
          <td class="text-center">
            {{isNullOrUndefined(data.policy_set_number)}}
          </td>
          <td>{{isNullOrUndefined(data.policy_set_description)}}</td>
          <td class="text-right">{{formatCurrency(data.total_cover_amount)}}</td>
          <td class="text-right">{{formatCurrency(data.total_insu_amount)}}</td>
          <td class="text-right">
            {{isNullOrUndefined(data.count_asset) || isNullOrUndefined(data.count_asset) === 0 ?
              formatCurrency(data.count_asset) :
              isNullOrUndefined(data.count_asset)}}
          </td>
          <td class="text-center">{{showYearBE('date', data.start_calculate_date)}}</td>
          <td class="text-center">{{showYearBE('date', data.end_calculate_date)}}</td>
          <td class="text-center">{{isNullOrUndefined(data.days)}}</td>
          <!-- <td>{{isNullOrUndefined(data.start_calculate_date)}}</td>
          <td>{{isNullOrUndefined(data.end_calculate_date)}}</td> -->
          <td class="text-center">{{showYearBE('date', data.start_addition_date)}}</td>
          <td class="text-center">{{showYearBE('date', data.end_addition_date)}}</td>
          <td>{{isNullOrUndefined(data.document_number)}}</td>
          <td>{{isNullOrUndefined(data.reference_document_number)}}</td>
        </tr>
        <tr class="text-center" v-if="rows.length === 0"><td colspan="14">ไม่มีข้อมูล</td></tr>
      </tbody>
      <tfoot></tfoot>
    </table>
  </div>
  </div>
</template>
<script>
  export default {
    name: 'ir-asset-increase-index-table-header',
    data () {
      return {
        rows: [],
        activeIndex: '',
        // receivables: [{
        //   rec_insu_name: 'สหภาพ',
        //   rec_insu_amount: '100'
        // }, {
        //   rec_insu_name: 'สหกรณ์',
        //   rec_insu_amount: '300'
        // }]
      }
    },
    props: [
      'isNullOrUndefined',
      'tableHeader',
      'formatCurrency',
      'search',
      'setFirstLetterUpperCase',
      'showYearBE',
      'checkStatusNew'
    ],
    methods: {
      clickRow (row, index) {
        let obj = {
          header_id: row.header_id,
          document_number: this.isNullOrUndefined(row.document_number),
          asset_status: this.isNullOrUndefined(row.asset_status),
          policy_set_description: this.isNullOrUndefined(row.policy_set_description),
          policy_set_header_id: this.isNullOrUndefined(row.policy_set_header_id),
          status: this.isNullOrUndefined(row.status),
          count_asset: this.isNullOrUndefined(row.count_asset),
          as_of_date: '',
          insurance_start_date: '',
          insurance_end_date: '',
          year: this.isNullOrUndefined(row.year),
          total_adjustment_cost: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_adjustment_cost),
          total_cover_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_cover_amount),
          total_insu_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_insu_amount),
          total_vat_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_vat_amount),
          total_net_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_net_amount),
          total_rec_insu_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_rec_insu_amount),
          revision: this.isNullOrUndefined(row.revision),
          start_calculate_date: this.isNullOrUndefined(row.start_calculate_date),
          end_calculate_date: this.isNullOrUndefined(row.end_calculate_date),
          start_addition_date: this.isNullOrUndefined(row.start_addition_date),
          end_addition_date: this.isNullOrUndefined(row.end_addition_date),
          receivables: row.type,
          total_duty_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_duty_amount)
        }
        this.$emit('click-row', obj);
        this.activeIndex = index;
      }
    },
    watch: {
      'tableHeader' (newVal, oldVal) {
        this.rows = newVal
        this.activeIndex = '';
      }
    },
    updated () {
      this.rows = this.tableHeader
    },
    computed: {
      tableTotal () {
        const vm                  = this;
        let find                  = null;
        let total_adjustment_cost = 0;
        let total_cover_amount    = 0;
        let total_premium         = 0;
        let total_duty_fee        = 0;
        let total_net_amount      = 0;
        let total_vat_amount      = 0;
        let dataTableTotal        = [];
        let check                 = [];

        if(vm.tableHeader.length === 0) return dataTableTotal;

          vm.tableHeader.forEach((item) => {

          find = null;
          find = dataTableTotal.find((search)=>{
            return search.policy_set_number == item.policy_set_number;
          });

          if(find){
            find.amount     += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_adjustment_cost ? parseFloat(item.total_adjustment_cost) : 0 : 0;
            find.coverage   += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_cover_amount    ? parseFloat(item.total_cover_amount)    : 0 : 0;
            find.premium    += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_insu_amount     ? parseFloat(item.total_insu_amount)     : 0 : 0;
            find.duty_fee   += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_duty_amount     ? parseFloat(item.total_duty_amount)     : 0 : 0;
            find.net_amount += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_net_amount      ? parseFloat(item.total_net_amount)      : 0 : 0;
            find.vat        += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_vat_amount      ? parseFloat(item.total_vat_amount)      : 0 : 0;
            find.status      = item.status;
          }else {
            check = dataTableTotal.find((list)=>{
              return list.group_name == item.group_name;
            });

            if (check) {
                check.amount     += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_adjustment_cost ? parseFloat(item.total_adjustment_cost) : 0 : 0;
                check.coverage   += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_cover_amount    ? parseFloat(item.total_cover_amount)    : 0 : 0;
                check.premium    += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_insu_amount     ? parseFloat(item.total_insu_amount)     : 0 : 0;
                check.duty_fee   += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_duty_amount     ? parseFloat(item.total_duty_amount)     : 0 : 0;
                check.net_amount += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_net_amount      ? parseFloat(item.total_net_amount)      : 0 : 0;
                check.vat        += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_vat_amount      ? parseFloat(item.total_vat_amount)      : 0 : 0;
                check.status      = item.status;

            } else {
              dataTableTotal.push({
                policy_set_number: item.policy_set_number,
                group_name:        item.group_name,
                amount:            item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_adjustment_cost ? parseFloat(item.total_adjustment_cost) : 0 : 0,
                coverage:          item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_cover_amount    ? parseFloat(item.total_cover_amount)    : 0 : 0,
                premium:           item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_insu_amount     ? parseFloat(item.total_insu_amount)     : 0 : 0,
                duty_fee:          item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_duty_amount     ? parseFloat(item.total_duty_amount)     : 0 : 0,
                net_amount:        item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_net_amount      ? parseFloat(item.total_net_amount)      : 0 : 0,
                vat:               item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_vat_amount      ? parseFloat(item.total_vat_amount)      : 0 : 0,
                status:            item.status,
              });
            }

          }

          total_adjustment_cost += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_adjustment_cost ? parseFloat(item.total_adjustment_cost) : 0 : 0;
          total_cover_amount    += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_cover_amount    ? parseFloat(item.total_cover_amount)    : 0 : 0;
          total_premium         += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_insu_amount     ? parseFloat(item.total_insu_amount)     : 0 : 0;
          total_duty_fee        += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_duty_amount     ? parseFloat(item.total_duty_amount)     : 0 : 0;
          total_net_amount      += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_net_amount      ? parseFloat(item.total_net_amount)      : 0 : 0;
          total_vat_amount      += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_vat_amount      ? parseFloat(item.total_vat_amount)      : 0 : 0;

        });

        dataTableTotal.push({
          group_name: 'Total',
          amount:      total_adjustment_cost,
          coverage:    total_cover_amount,
          premium:     total_premium,
          duty_fee:    total_duty_fee,
          net_amount:  total_net_amount,
          vat:         total_vat_amount,
        });

        return dataTableTotal;
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

