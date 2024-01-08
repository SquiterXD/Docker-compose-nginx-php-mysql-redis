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
              <td>{{formatCurrency(data.cost)}}</td>
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
          <th class="text-center" style="min-width: 110px;">IR Status <br>สถานะ</th>
          <th class="text-center" style="min-width: 110px;">Year <br>ปี</th>
          <th class="text-center" style="min-width: 130px;">Policy No. <br>กรมธรรม์ชุดที่</th>
          <th class="text-center" style="min-width: 200px;; width: 1%;">Policy Description <br>รายละเอียดกรมธรรม์ชุดที่</th>
          <th class="text-center" style="min-width: 200px;">Total Coverage Amount <br>มูลค่าทุนประกันรวม</th>
          <th class="text-center" style="min-width: 120px;">Total Premium <br>ค่าเบี้ยประกันรวม</th>
          <th style="min-width: 120px;" class="text-center">Count <br>จำนวนรายการ</th>
          <th class="text-center" style="min-width: 140px;">As Of Date <br>ณ วันที่</th>
          <th class="text-center" style="min-width: 140px;">วันที่คุ้มครองตั้งแต่</th>
          <th class="text-center" style="min-width: 140px;">วันที่คุ้มครองถึง</th>
          <th class="text-center" style="min-width: 150px;">Document Number <br>เลขที่เอกสาร</th>
          <th class="text-center" style="min-width: 120px;">Reference <br>Document</th>
        </tr>
      </thead>
      <tbody  id="table_search">
        <tr v-show="tableHeader.length > 0"
            v-for="(data, index) in tableHeader"
            :key="index" class="mouse-over"
            @click="clickRow(data, index)"
            :class="`style_row_show ${index === activeIndex ? 'highlight' : ''}`">
          <td class="text-center">
            <a  type="button"
                :href="`/ir/assets/asset-plan/edit/${data.header_id}`"
                class="btn btn-warning btn-xs">
              <span v-if="isNullOrUndefined(data.document_number)">View / Edit</span>
              <span v-else>Select</span>
            </a>
          </td>
          <td>{{setFirstLetterUpperCase(data.status)}}</td>
          <td class="text-center">{{showYearBE('year', data.year)}}</td>
          <td class="text-center">
            <!-- {{isNullOrUndefined(data.policy_set_header_id)}} -->
            {{isNullOrUndefined(data.policy_set_number)}}
          </td>
          <td>{{isNullOrUndefined(data.policy_set_description)}}</td>
          <td class="text-right">{{formatCurrency(data.total_cover_amount)}}</td>
          <td class="text-right">{{formatCurrency(data.total_insu_amount)}}</td>
          <td class="text-right">{{formatCurrency(data.count_asset)}}</td>
          <td class="text-center">{{showYearBE('date', data.as_of_date)}}</td>
          <td class="text-center">{{showYearBE('date', data.insurance_start_date)}}</td>
          <td class="text-center">{{showYearBE('date', data.insurance_end_date)}}</td>
          <td>{{isNullOrUndefined(data.document_number)}}</td>
          <td>{{isNullOrUndefined(data.reference_document_number)}}</td>
        </tr>
        <tr class="text-center mouse-over" v-if="tableHeader.length === 0"><td colspan="11">ไม่มีข้อมูล</td></tr>
      </tbody>
      <tfoot></tfoot>
    </table>
  </div>
</div>
</template>
<script>
  export default {
    name: 'ir-asset-plan-index-table-header',
    data () {
      return {
        activeIndex: ''
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
          as_of_date: this.isNullOrUndefined(row.as_of_date),
          insurance_start_date: this.isNullOrUndefined(row.insurance_start_date),
          insurance_end_date: this.isNullOrUndefined(row.insurance_end_date),
          year: this.isNullOrUndefined(row.year),
          total_cost: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_cost),
          total_cover_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_cover_amount),
          total_insu_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_insu_amount),
          total_vat_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_vat_amount),
          total_net_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_net_amount),
          total_rec_insu_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_rec_insu_amount),
          receivables: row.type,
          total_duty_amount: this.checkStatusNew(row.status) ? 0 : this.isNullOrUndefined(row.total_duty_amount)
        }
        this.$emit('click-row', obj)
        this.activeIndex = index;
      }
    },
    watch: {
      'tableHeader' (newVal, oldVal) {
        this.activeIndex = '';
      }
    },
    computed: {
      tableTotal () {
        const vm = this;
        let find = null;
        let total_cost = 0;
        let total_coverage = 0;
        let total_premium = 0;
        let total_duty_fee = 0;
        let total_net_amount = 0;
        let total_vat = 0;
        let dataTableTotal = [];
        let check = [];

        if(vm.tableHeader.length === 0) return dataTableTotal;

        vm.tableHeader.forEach((item) => {

          find = null;
          find = dataTableTotal.find((search)=>{
            return search.policy_set_number == item.policy_set_number;
          });

          if(find){
            find.cost       += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_cost         ? parseFloat(item.total_cost)         : 0 : 0;
            find.coverage   += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_cover_amount ? parseFloat(item.total_cover_amount) : 0 : 0;
            find.premium    += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_insu_amount  ? parseFloat(item.total_insu_amount)  : 0 : 0;
            find.duty_fee   += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_duty_amount  ? parseFloat(item.total_duty_amount)  : 0 : 0;
            find.net_amount += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_net_amount   ? parseFloat(item.total_net_amount)   : 0 : 0;
            find.vat        += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_vat_amount   ? parseFloat(item.total_vat_amount)   : 0 : 0;
            find.status      = item.status;
          }else {
            check = dataTableTotal.find((list)=>{
              return list.group_name == item.group_name;
            });

            if (check) {
                check.cost       += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_cost         ? parseFloat(item.total_cost)         : 0 : 0;
                check.coverage   += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_cover_amount ? parseFloat(item.total_cover_amount) : 0 : 0;
                check.premium    += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_insu_amount  ? parseFloat(item.total_insu_amount)  : 0 : 0;
                check.duty_fee   += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_duty_amount  ? parseFloat(item.total_duty_amount)  : 0 : 0;
                check.net_amount += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_net_amount   ? parseFloat(item.total_net_amount)   : 0 : 0;
                check.vat        += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_vat_amount   ? parseFloat(item.total_vat_amount)   : 0 : 0;
                check.status      = item.status;

            } else {
              dataTableTotal.push({
                policy_set_number: item.policy_set_number,
                group_name:        item.group_name,
                cost:              item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_cost         ? parseFloat(item.total_cost)         : 0 : 0,
                coverage:          item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_cover_amount ? parseFloat(item.total_cover_amount) : 0 : 0,
                premium:           item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_insu_amount  ? parseFloat(item.total_insu_amount)  : 0 : 0,
                duty_fee:          item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_duty_amount  ? parseFloat(item.total_duty_amount)  : 0 : 0,
                net_amount:        item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_net_amount   ? parseFloat(item.total_net_amount)   : 0 : 0,
                vat:               item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_vat_amount   ? parseFloat(item.total_vat_amount)   : 0 : 0,
                status:            item.status,
              });
            }


            // dataTableTotal.push({
            //   policy_set_number: item.policy_set_number,
            //   group_name: item.group_name,
            //   amount: item.total_amount ? parseFloat(item.total_amount) : 0,
            //   coverage: item.total_cover_amount ? parseFloat(item.total_cover_amount) : 0,
            //   premium: item.total_insu_amount ? parseFloat(item.total_insu_amount) : 0,
            //   duty_fee: item.total_duty_amount ? parseFloat(item.total_duty_amount) : 0,
            //   net_amount: item.total_net_amount ? parseFloat(item.total_net_amount) : 0,
            //   vat: item.total_vat_amount ? parseFloat(item.total_vat_amount) : 0,
            // });

          }

          total_cost       += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_cost         ? parseFloat(item.total_cost)         : 0 : 0;
          total_coverage   += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_cover_amount ? parseFloat(item.total_cover_amount) : 0 : 0;
          total_premium    += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_insu_amount  ? parseFloat(item.total_insu_amount)  : 0 : 0;
          total_duty_fee   += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_duty_amount  ? parseFloat(item.total_duty_amount)  : 0 : 0;
          total_net_amount += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_net_amount   ? parseFloat(item.total_net_amount)   : 0 : 0;
          total_vat        += item.status == 'CONFIRMED' || item.status == 'INTERFACE' ? item.total_vat_amount   ? parseFloat(item.total_vat_amount)   : 0 : 0;

        });

        dataTableTotal.push({
          group_name: 'Total',
          cost:       total_cost,
          coverage:   total_coverage,
          premium:    total_premium,
          duty_fee:   total_duty_fee,
          net_amount: total_net_amount,
          vat:        total_vat,
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
