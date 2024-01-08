<div class="mt-3">
    <div v-if="isLoading">
        <div class="sk-spinner sk-spinner-wave">
            <div class="sk-rect1"></div>
            <div class="sk-rect2"></div>
            <div class="sk-rect3"></div>
            <div class="sk-rect4"></div>
            <div class="sk-rect5"></div>
        </div>
    </div>
    <div v-if="!isLoading"
        class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="text-center"><div style="width: 80px;">รหัสลูกค้า</div></th>
                <th class="text-center"><div style="width: 160px;">ชื่อลูกค้า</div></th>
                <th class="text-center"><div style="width: 100px;">เลขที่ใบสั่งซื้อ</div></th>
                <th class="text-center"><div style="width: 110px;">เลขที่ใบเตรียมขาย</div></th>
                <th class="text-center"><div style="width: 100px;">เลขที่ Invoice</div></th>
                <th class="text-center"><div style="width: 80px;">กลุ่มเงินเชื่อ</div></th>
                <th class="text-center"><div style="width: 120px;">จำนวนวันปลอดดอก</div></th>
                <th class="text-center"><div style="width: 100px;">ยอดหนี้คงเหลือ</div></th>
                <th class="text-center"><div style="width: 80px;">ค่าปรับ</div></th>
                <th class="text-center"><div style="width: 140px;">วันที่ครบกำหนดชำระ</div></th>
                <th></th>
            </tr>
            </thead>
            {{-- <tbody> --}}
            <tbody v-if="DataLists.length > 0">
                <tr v-for="list in DataLists">
                    <td>@{{ list.customer_number }}</td>
                    <td>@{{ list.customer_name }}</td>
                    <td>@{{ list.order_number }}</td>
                    <td>@{{ list.prepare_order_number }}</td>
                    <td>@{{ list.pick_release_no }}</td>
                    {{-- <td></td> --}}
                    <td align="center">@{{ list.credit_group_code == '0' ? 'สด' : list.credit_group_code }}</td>
                    <td align="center">@{{ list.due_days }}</td>
                    {{-- <td></td> --}}
                    <td align="right">
                        {{-- @{{ list.outstanding_debt }} --}}
                        @{{ formatPrice(list.outstanding_debt) }}
                    </td>
                    <td align="right">@{{ fine(list.outstanding_debt) }}</td>
                    {{-- <td>@{{ list.due_date ? parseToDateTh(list.due_date) : '' }}</td> --}}
                    <td align="center">@{{ formatDate(list.due_date) }}</td>
                    <td>
                        {{-- @{{ getTest(list) }} --}}
                        @{{ getYear(list) }}
                    </td>
                </tr>
                {{-- <template v-for="(list, index) in DataLists">
                    <tr>
                        <td>@{{ totalAmount }}</td>
                        <td colspan="9"></td>
                    </tr> --}}
                    {{-- <tr>
                        <td colspan="6" class="text-center"><b>@{{index}}</b></td>
                    </tr> --}}
                    {{-- <tr v-for="(list, i) in lists">
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr> --}}
                {{-- </template> --}}
                {{-- <tr v-for="(list, i) in DataLists">
                    <td colspan="6"></td>
                </tr> --}}
                {{-- <tr v-for="(list, i) in DataLists">
                    <td class="text-center">@{{ i + 1 }}</td>
                    <td>@{{ list.item_number }}</td>
                    <td>@{{ list.description }}</td>
                    <td class="text-right">@{{ list.b }}</td>
                    <td class="text-center">@{{ list.unit_of_measure }}</td>
                    <td>
                        <button type="button" class="btn btn-w-m btn-default" data-toggle="modal" data-target="#detailReportModal"
                            @click.prevent="onShowDetailClicked(list)">
                            รายละเอียด
                        </button>
                        @include('pm.ingredient-preparation._detail_modal')
                    </td>
                </tr> --}}
            </tbody>
            {{-- <tbody v-if="DataLists.length <= 0">
                <tr>
                    <td colspan="10" align="center"><b>No Data</b></td>
                </tr>
            </tbody> --}}
        </table>
    </div>
</div>
