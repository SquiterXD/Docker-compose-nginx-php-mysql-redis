<div class="table-responsive">
    <table class="table table-bordered text-center table-hover f13" id="tbOrderLine">
        <thead>
            <tr class="align-middle">
                <th rowspan="2">รายการที่</th>
                <th colspan="2" class="d-none">ยอดส่งครั้งหลังสุด</th>
                <th rowspan="2" class="w-150">รหัสสินค้า</th>
                <th rowspan="2">ชื่อผลิตภัณฑ์</th>
                <th colspan="3">จำนวนที่สั่ง</th>
                <th colspan="3">อนุมัติสั่ง</th>
                <th rowspan="2" style="min-width: 160px;">ราคาขาย/<br>พันมวน/ซอง</th>
                <th rowspan="2">จำนวนเงิน</th>
                <th rowspan="2">โควต้า/งวด<br>(พันมวน/ซอง)</th>
                <th rowspan="2">คงเหลือ/งวด<br>(พันมวน/ซอง)</th>
                <th rowspan="2">คงคลังทั้งหมด<br>(พันมวน/ซอง)</th>
                <th rowspan="2" style="width: 55px">ลบ</th>
            </tr>
            <tr class="align-middle">
                <!--ยอดส่งครั้งหลังสุด-->
                <th class="w-80 d-none" ><small>วันที่</small></th>
                <th class="w-80 d-none"><small>พันมวน/ซอง</small></th>

                <!--จำนวนที่สั่ง-->
                <th style="min-width:80px;"><small>หีบ</small></th>
                <th style="min-width:80px;"><small>ห่อ</small></th>
                <th style="min-width:80px;"><small>คิดเป็น<br>พันมวน/ซอง</small></th>

                <!--อนุมัติสั่ง-->
                <th style="min-width:80px;"><small>หีบ</small></th>
                <th style="min-width:80px;"><small>ห่อ</small></th>
                <th style="min-width:80px;"><small>คิดเป็น<br>พันมวน/ซอง</small></th>
            </tr>
        </thead>
        <tbody>
        @if (isset($data['orderLine']) && !@empty($data['orderLine']))
            @php $run = 1 ; @endphp
            @foreach ($data['orderLine'] as $key_quota => $dataItem)
            @php $credit_group_code = (is_null($dataItem->credit_group_code)) ? 0 : $dataItem->credit_group_code ; @endphp
            @php $quota_group_code = (is_null($dataItem->quota_group_code)) ? 0 : $dataItem->quota_group_code ; @endphp
            @php $quota_line_id = (is_null($dataItem->quota_line_id)) ? 0 : $dataItem->quota_line_id ; @endphp
            <tr class="align-middle" id="tr_item_{{ $run }}">
                <td>
                    <input type="hidden" class="form-control" readonly name="program_code[{{ $quota_group_code }}][{{ $quota_line_id }}][{{ $dataItem->item_id }}][{{ $dataItem->line_number }}]" placeholder="" value="{{ $dataItem->program_code }}">
                    <input type="hidden" class="form-control" readonly name="line_number[{{ $quota_group_code }}][{{ $quota_line_id }}][{{ $dataItem->item_id }}][{{ $dataItem->line_number }}]" placeholder="" value="{{ $run }}">
                    <span class="runLine">{{ $run }}</span>
                </td>
                <td class="d-none"><span id="date_latest_{{ $run }}">{{ $data['latest'][$dataItem->item_id]['order_date'] }}</span></td>
                <td class="d-none"><span id="amount_latest_{{ $run }}">{{ $data['latest'][$dataItem->item_id]['order_quantity'] }}</span></td>
                <td>
                    <input type="text" class="form-control" readonly name="" placeholder="" value="{{ $dataItem->item_code }}">
                </td>
                <td class="text-left"><span id="item_name_{{ $run }}">{{ $dataItem->item_description }}</span></td>

                <td>
                    <input type="text" class="form-control md text-center order_cardboardbox"
                    value="{{ $dataItem->order_cardboardbox }}"
                    name="chest_amount[{{ $quota_group_code }}][{{ $quota_line_id }}][{{ $dataItem->item_id }}][{{ $dataItem->line_number }}]"
                    data-run="{{ $run }}"
                    data-id="{{ $dataItem->item_id }}"
                    data-price="{{ $dataItem->unit_price }}"
                    data-quata="{{ $quota_group_code }}"
                    data-group="{{ $credit_group_code }}"
                    data-line="{{ $quota_line_id }}"
                    id="chestAmount_{{ $run }}"
                    {{ ($data['order']->order_status == 'Draft') ? '' : 'disabled' }}
                    onkeyup="chestAmount(this)"
                    onkeypress="return isCheckNumber(event)"
                    autocomplete="off"
                    >
                </td>
                <td>
                    <input type="text" class="form-control md text-center order_carton"
                    value="{{ $dataItem->order_carton }}"
                    name="wrap_amount[{{ $quota_group_code }}][{{ $quota_line_id }}][{{ $dataItem->item_id }}][{{ $dataItem->line_number }}]"
                    data-run="{{ $run }}"
                    data-id="{{ $dataItem->item_id }}"
                    data-price="{{ $dataItem->unit_price }}"
                    data-quata="{{ $quota_group_code }}"
                    data-group="{{ $credit_group_code }}"
                    data-line="{{ $quota_line_id }}"
                    id="wrapAmount_{{ $run }}"
                    {{ ($data['order']->order_status == 'Draft') ? '' : 'disabled' }}
                    onkeyup="wrapAmount(this)"
                    onkeypress="return isCheckNumber(event)"
                    autocomplete="off"
                    >
                </td>
                <td>
                    <span id="order_quantity_text_{{ $run }}" class="order_quantity_text_{{ $quota_group_code }}_{{ $quota_line_id }}_{{ $dataItem->item_id }}_{{ $dataItem->line_number }}">{{ number_format($dataItem->order_quantity,2) }}</span>
                    <input type="hidden"
                    id="order_quantity_{{ $run }}"
                    name="order_quantity[{{ $quota_group_code }}][{{ $quota_line_id }}][{{ $dataItem->item_id }}][{{ $dataItem->line_number }}]"
                    class="order_quantity_group_{{ $quota_group_code }} order_quantity"
                    {{ ($data['order']->order_status == 'Draft') ? '' : 'disabled' }}
                    value="{{ $dataItem->order_quantity }}" />
                </td>

                <td><input type="text" class="form-control md text-center approve_cardboardbox" value="{{ ($dataItem->approve_cardboardbox != '' || $dataItem->program_code == 'OMP0019') ? $dataItem->approve_cardboardbox : $dataItem->order_cardboardbox }}"
                    id="approveChestAmount_{{ $run }}" onkeyup="approveChestAmount(this)" onkeypress="return isCheckNumber(event)"
                    name="approve_chest_amount[{{ $quota_group_code }}][{{ $quota_line_id }}][{{ $dataItem->item_id }}][{{ $dataItem->line_number }}]"
                    data-run="{{ $run }}"
                    data-id="{{ $dataItem->item_id }}"
                    data-price="{{ $dataItem->unit_price }}"
                    data-quata="{{ $quota_group_code }}"
                    data-group="{{ $credit_group_code }}"
                    data-line="{{ $quota_line_id }}"
                    {{ ($data['order']->order_status != 'Draft' && !is_null($data['order']->order_status)) ? 'disabled' : '' }}
                    autocomplete="off"
                    ></td>
                <td>
                    <input type="text" class="form-control md text-center approve_carton" value="{{ ($dataItem->approve_carton != '' || $dataItem->program_code == 'OMP0019') ? $dataItem->approve_carton : $dataItem->order_carton }}"
                    id="approveWrapAmount_{{ $run }}" onkeyup="approveWrapAmount(this)" onkeypress="return isCheckNumber(event)"
                    name="approve_wrap_amount[{{ $quota_group_code }}][{{ $quota_line_id }}][{{ $dataItem->item_id }}][{{ $dataItem->line_number }}]"
                    data-run="{{ $run }}"
                    data-id="{{ $dataItem->item_id }}"
                    data-price="{{ $dataItem->unit_price }}"
                    data-quata="{{ $quota_group_code }}"
                    data-group="{{ $credit_group_code }}"
                    data-line="{{ $quota_line_id }}"
                    {{ ($data['order']->order_status != 'Draft' && !is_null($data['order']->order_status)) ? 'disabled' : '' }}
                    autocomplete="off"
                    ></td>
                <td>
                    <span id="order_quantity_approve_text_{{ $run }}" class="order_quantity_approve_text_{{ $quota_group_code }}_{{ $quota_line_id }}_{{ $dataItem->item_id }}_{{ $dataItem->line_number }}">
                        {{ ($dataItem->approve_quantity != '' || $dataItem->program_code == 'OMP0019') ? number_format($dataItem->approve_quantity,2) : number_format($dataItem->order_quantity,2) }}
                    </span>
                    <input type="hidden" id="order_quantity_approve_{{ $run }}" class="order_quantity_approve_group_{{ $quota_group_code }} approve_quantity"
                    name="order_quantity_approve[{{ $quota_group_code }}][{{ $quota_line_id }}][{{ $dataItem->item_id }}][{{ $dataItem->line_number }}]"
                    value="{{ ($dataItem->approve_quantity != '' || $dataItem->program_code == 'OMP0019') ? $dataItem->approve_quantity : $dataItem->order_quantity }}"/>
                </td>

                <td class="text-right">
                    <span id="item_price_text_{{ $run }}" style="display:none;">{{ number_format($dataItem->unit_price,2) }}</span>
                    <input type="text" class="form-control md text-center unit_price_text"
                    id="unit_price_text_{{ $run }}"
                    name="unit_price_text[{{ $quota_group_code }}][{{ $quota_line_id }}][{{ $dataItem->item_id }}][{{ $dataItem->line_number }}]"
                    onkeyup="changePrice(this)" onkeypress="return isCheckNumber(event)"
                    data-run="{{ $run }}"
                    data-id="{{ $dataItem->item_id }}"
                    data-price="{{ $dataItem->unit_price }}"
                    data-quata="{{ $quota_group_code }}"
                    data-group="{{ $credit_group_code }}"
                    data-line="{{ $quota_line_id }}"
                    value="{{ number_format($dataItem->unit_price,2) }}"
                    {{ ($data['order']->order_status == 'Draft' && $dataItem->program_code != 'OMP0003') ? '' : 'readonly' }}
                    >
                    <input type="hidden" class="form-control md text-center unit_price"
                    id="unit_price_{{ $run }}"
                    name="unit_price[{{ $quota_group_code }}][{{ $quota_line_id }}][{{ $dataItem->item_id }}][{{ $dataItem->line_number }}]"
                    onkeyup="changePrice(this)" onkeypress="return isCheckNumber(event)"
                    data-run="{{ $run }}"
                    data-id="{{ $dataItem->item_id }}"
                    data-price="{{ $dataItem->unit_price }}"
                    data-quata="{{ $quota_group_code }}"
                    data-group="{{ $credit_group_code }}"
                    data-line="{{ $quota_line_id }}"
                    value="{{ $dataItem->unit_price }}"
                    {{ ($data['order']->order_status == 'Draft') ? '' : 'disabled' }}
                    >
                </td>

                <td class="text-right">
                    <span id="sum_amount_text_{{ $run }}" class="sum_amount_text_{{ $quota_group_code }}_{{ $quota_line_id }}_{{ $dataItem->item_id }}_{{ $dataItem->line_number }}">{{ number_format($dataItem->amount,2) }}</span>
                    <input type="hidden" class="sum_amount_item" data-group="{{ $credit_group_code }}" id="sum_amount_{{ $run }}" name="sum_amount[{{ $quota_group_code }}][{{ $quota_line_id }}][{{ $dataItem->item_id }}][{{ $dataItem->line_number }}]" value="{{ ($dataItem->amount == null) ? 0 : $dataItem->amount }}"/>
                </td>

                <td class="text-right"><span id="item_quata_received_text_{{ $run }}" data-amount="{{ $data['orderLineQuota'][$quota_line_id]['received_quota'] }}" class="item_quata_received_text_{{ $quota_group_code }}">{{ number_format($data['orderLineQuota'][$quota_line_id]['received_quota'],2) }}</span></td>
                {{-- <td class="text-right" style="display:none;"><span id="item_quata_use_text_{{ $run }}" class="item_quata_use_text_{{ $quota_group_code }}">{{ number_format($data['useQuata'][$quota_group_code],2) }}</span></td> --}}
                <td class="text-right">
                    <span id="item_quata_remaining_text_{{ $run }}" data-amount="{{ ($data['orderLineQuota'][$quota_line_id]['remaining_quota']) }}" class="item_quata_remaining_text_{{ $dataItem->quota_group_code }}">
                        {{ ($data['orderLineQuota'][$quota_line_id]['remaining_quota'] > 0) ? number_format($data['orderLineQuota'][$quota_line_id]['remaining_quota'],2) : number_format(0,2) }}
                    </span>
                </td>
                <td class="text-right">
                    <span id="item_onhand_quantity_text_{{ $run }}" class="item_onhand_quantity_text">
                        @if(count($data['orderLineQuota'][$quota_line_id]['quota']) > 0)
                            {{ number_format($data['orderLineQuota'][$quota_line_id]['quota'][0]->onhand,2) }}
                        @else
                            {{ number_format(0,2) }}
                        @endif
                    </span>
                </td>
                <td>
                    @if($data['order']->order_status == 'Draft' || is_null($data['order']->order_status))
                    <a class="fa fa-times red" href="javascript:void(0)" onclick="removeItemLine({{ $run }},{{ $dataItem->order_line_id }})"></a>
                    @else
                    <a class="fa fa-times" href="javascript:void(0)"></a>
                    @endif
                </td>
            </tr>
            @php $run += 1 ; @endphp
            @endforeach
        @endif
        </tbody>
        <tfoot>
            <tr class="align-middle font-weight-bold">
                <td></td>
                <td class="d-none"></td>
                <td class="d-none"></td>
                <td></td>
                <td>รวม</td>
                <td id="summary_order_cardboardbox">0.00</td>
                <td id="summary_order_carton">0.00</td>
                <td id="summary_order">0.00</td>
                <td id="summary_approve_cardboardbox">0.00</td>
                <td id="summary_approve_carton">0.00</td>
                <td id="summary_approve">0.00</td>
                <td id="summary_unit_price"></td>
                <td id="summary_price">0.00</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div><!--table-responsive-->
