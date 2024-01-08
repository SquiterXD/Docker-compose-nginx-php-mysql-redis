<div class="table-responsive">
    <table class="table table-bordered text-center table-hover f13 min-1400" id="tbOrderLine">
        <thead>
            <tr class="align-middle">
                <th rowspan="2">รายการที่</th>
                <th colspan="2">ยอดส่งครั้งหลังสุด</th>
                <th rowspan="2" class="w-130">รหัสสินค้า</th>
                <th rowspan="2">ชื่อผลิตภัณฑ์</th>
                <th colspan="3">จำนวนที่สั่ง</th>
                <th colspan="3">อนุมัติสั่ง</th>
                <th rowspan="2" style="min-width: 160px;">ราคาขาย/<br>พันมวน</th>
                <th rowspan="2">จำนวนเงิน</th>
                <th rowspan="2">โควต้า/งวด<br>(พันมวน)</th>
                <th rowspan="2">คงเหลือ/งวด<br>(พันมวน)</th>
                <th rowspan="2">คงคลังทั้งหมด<br>(พันมวน)</th>
                <th rowspan="2" style="width: 55px">ลบ</th>
            </tr>
            <tr class="align-middle">
                <!--ยอดส่งครั้งหลังสุด-->
                <th class="w-80"><small>วันที่</small></th>
                <th class="w-80"><small>พันมวน</small></th>

                <!--จำนวนที่สั่ง-->
                <th class="w-80"><small>หีบ</small></th>
                <th class="w-80"><small>ห่อ</small></th>
                <th class="w-80"><small>คิดเป็น<br>พันมวน</small></th>

                <!--อนุมัติสั่ง-->
                <th class="w-80"><small>หีบ</small></th>
                <th class="w-80"><small>ห่อ</small></th>
                <th class="w-80"><small>คิดเป็น<br>พันมวน</small></th>
            </tr>
        </thead>
        <tbody>
            @if (isset($data['orderLine']) && !@empty($data['orderLine']))
                @php $run = 1 ; @endphp
                @foreach ($data['contractQuata'] as $key => $val)
                    @foreach ($val['quota'] as $key_quota => $quota)
                        @if (isset($data['orderLine'][$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id]))
                            @php $dataItem = $data['orderLine'][$val['group']->lookup_code][$quota->quota_line_id][$quota->item_id] ; @endphp
                                <tr class="align-middle" id="tr_item_{{ $run }}">
                                    <td><span class="runLine">{{ $run }}</span></td>
                                    <td><span id="date_latest_{{ $run }}">{{ $data['latest'][$quota->item_id]['order_date'] }}</span></td>
                                    <td><span id="amount_latest_{{ $run }}">{{ $data['latest'][$quota->item_id]['order_quantity'] }}</span></td>
                                    <td>
                                        <div class="input-icon">
                                            <input type="text" class="form-control" readonly name="" placeholder="" value="{{ $dataItem->item_code }}">
                                            <i class="fa fa-search"></i>
                                        </div>
                                    </td>
                                    <td class="text-left"><span id="item_name_{{ $run }}">{{ $dataItem->item_description }}</span></td>

                                    <td>
                                        <input type="text" class="form-control md text-center"
                                        value="{{ $dataItem->order_cardboardbox }}"
                                        name="chest_amount[{{ $val['group']->lookup_code }}][{{ $quota->quota_line_id }}][{{ $quota->item_id }}]"
                                        data-run="{{ $run }}"
                                        data-id="{{ $dataItem->item_id }}"
                                        data-price="{{ $quota->price_unit }}"
                                        data-quata="{{ $val['group']->lookup_code }}"
                                        data-group="{{ $quota->credit_group_code }}"
                                        data-line="{{ $quota->quota_line_id }}"
                                        id="chestAmount_{{ $run }}"
                                        readonly
                                        {{ ($data['order']->order_status == 'Draft') ? '' : 'disabled' }}
                                        onkeyup="chestAmount(this)"
                                        onkeypress="return isCheckNumber(event)"
                                        >
                                    </td>
                                    <td>
                                        <input type="text" class="form-control md text-center"
                                        value="{{ $dataItem->order_carton }}"
                                        name="wrap_amount[{{ $val['group']->lookup_code }}][{{ $quota->quota_line_id }}][{{ $quota->item_id }}]"
                                        data-run="{{ $run }}"
                                        data-id="{{ $dataItem->item_id }}"
                                        data-price="{{ $quota->price_unit }}"
                                        data-quata="{{ $val['group']->lookup_code }}"
                                        data-group="{{ $quota->credit_group_code }}"
                                        data-line="{{ $quota->quota_line_id }}"
                                        id="wrapAmount_{{ $run }}"
                                        readonly
                                        {{ ($data['order']->order_status == 'Draft') ? '' : 'disabled' }}
                                        onkeyup="wrapAmount(this)"
                                        onkeypress="return isCheckNumber(event)"
                                        >
                                    </td>
                                    <td>
                                        <span id="order_quantity_text_{{ $run }}" class="order_quantity_text_{{ $val['group']->lookup_code }}_{{ $quota->quota_line_id }}_{{ $quota->item_id }}">{{ number_format($dataItem->order_quantity,2) }}</span>
                                        <input type="hidden"
                                        id="order_quantity_{{ $run }}"
                                        name="order_quantity[{{ $val['group']->lookup_code }}][{{ $quota->quota_line_id }}][{{ $quota->item_id }}]"
                                        class="order_quantity_group_{{ $val['group']->lookup_code }}"
                                        {{ ($data['order']->order_status == 'Draft') ? '' : 'disabled' }}
                                        value="{{ $dataItem->order_quantity }}" />
                                    </td>

                                    <td><input type="text" class="form-control md text-center" value="{{ ($dataItem->approve_cardboardbox != '') ? $dataItem->approve_cardboardbox : $dataItem->order_cardboardbox }}"
                                        id="approveChestAmount_{{ $run }}" onkeyup="approveChestAmount(this)" onkeypress="return isCheckNumber(event)"
                                        name="approve_chest_amount[{{ $val['group']->lookup_code }}][{{ $quota->quota_line_id }}][{{ $quota->item_id }}]"
                                        data-run="{{ $run }}"
                                        data-id="{{ $dataItem->item_id }}"
                                        data-price="{{ $dataItem->unit_price }}"
                                        data-quata="{{ $val['group']->lookup_code }}"
                                        data-group="{{ $quota->credit_group_code }}"
                                        data-line="{{ $quota->quota_line_id }}"
                                        {{ ($data['order']->order_status != 'Draft' && !is_null($data['order']->order_status)) ? 'disabled' : '' }}
                                        ></td>
                                    <td>
                                        <input type="text" class="form-control md text-center" value="{{ ($dataItem->approve_carton != '') ? $dataItem->approve_carton : $dataItem->order_carton }}"
                                        id="approveWrapAmount_{{ $run }}" onkeyup="approveWrapAmount(this)" onkeypress="return isCheckNumber(event)"
                                        name="approve_wrap_amount[{{ $val['group']->lookup_code }}][{{ $quota->quota_line_id }}][{{ $quota->item_id }}]"
                                        data-run="{{ $run }}"
                                        data-id="{{ $dataItem->item_id }}"
                                        data-price="{{ $dataItem->unit_price }}"
                                        data-quata="{{ $val['group']->lookup_code }}"
                                        data-group="{{ $quota->credit_group_code }}"
                                        data-line="{{ $quota->quota_line_id }}"
                                        {{ ($data['order']->order_status != 'Draft' && !is_null($data['order']->order_status)) ? 'disabled' : '' }}
                                        ></td>
                                    <td>
                                        <span id="order_quantity_approve_text_{{ $run }}" class="order_quantity_approve_text_{{ $val['group']->lookup_code }}_{{ $quota->quota_line_id }}_{{ $quota->item_id }}">
                                            {{ ($dataItem->approve_quantity != '') ? number_format($dataItem->approve_quantity,2) : number_format($dataItem->order_quantity,2) }}
                                        </span>
                                        <input type="hidden" id="order_quantity_approve_{{ $run }}" class="order_quantity_approve_group_{{ $val['group']->lookup_code }}"
                                        name="order_quantity_approve[{{ $val['group']->lookup_code }}][{{ $quota->quota_line_id }}][{{ $quota->item_id }}]"
                                        value="{{ ($dataItem->approve_quantity != '') ? $dataItem->approve_quantity : $dataItem->order_quantity }}"/>
                                    </td>

                                    <td class="text-right">
                                        <span id="item_price_text_{{ $run }}" style="display:none;">{{ number_format($quota->price_unit,2) }}</span>
                                        <input type="text" class="form-control md text-center"
                                        id="unit_price_{{ $run }}"
                                        name="unit_price[{{ $val['group']->lookup_code }}][{{ $quota->quota_line_id }}][{{ $quota->item_id }}]"
                                        onkeyup="changePrice(this)" onkeypress="return isCheckNumber(event)"
                                        data-run="{{ $run }}"
                                        data-id="{{ $dataItem->item_id }}"
                                        data-price="{{ $dataItem->unit_price }}"
                                        data-quata="{{ $val['group']->lookup_code }}"
                                        data-group="{{ $quota->credit_group_code }}"
                                        data-line="{{ $quota->quota_line_id }}"
                                        value="{{ $dataItem->unit_price }}"
                                        {{ ($data['order']->order_status == 'Draft') ? '' : 'disabled' }}
                                        >
                                        <!-- <input type="hidden" id="unit_price_{{ $run }}" name="unit_price[{{ $val['group']->lookup_code }}][{{ $quota->quota_line_id }}][{{ $quota->item_id }}]"/> -->
                                    </td>
                                    <td class="text-right">
                                        <span id="sum_amount_text_{{ $run }}" class="sum_amount_text_{{ $val['group']->lookup_code }}_{{ $quota->quota_line_id }}_{{ $quota->item_id }}">{{ number_format($dataItem->total_amount,2) }}</span>
                                        <input type="hidden" class="sum_amount_item" id="sum_amount_{{ $run }}" name="sum_amount[{{ $val['group']->lookup_code }}][{{ $quota->quota_line_id }}][{{ $quota->item_id }}]" value="{{ ($dataItem->total_amount == null) ? 0 : $dataItem->total_amount }}"/>
                                    </td>

                                    <td class="text-right"><span id="item_quata_received_text_{{ $run }}" class="item_quata_received_text_{{ $val['group']->lookup_code }}">{{ number_format($val['received_quota'],2) }}</span></td>

                                    {{-- <td class="text-right" style="display:none;"><span id="item_quata_use_text_{{ $run }}" class="item_quata_use_text_{{ $val['group']->lookup_code }}">{{ number_format($data['useQuata'][$val['group']->lookup_code],2) }}</span></td> --}}

                                    <td class="text-right"><span id="item_quata_remaining_text_{{ $run }}" class="item_quata_remaining_text_{{ $val['group']->lookup_code }}">{{ number_format($val['received_quota'] - $dataItem->approve_quantity,2) }}
                                        <!-- {{ number_format($val['remaining_quota'],2) }} -->
                                    </span></td>

                                    <td class="text-right"><span id="item_onhand_quantity_text_{{ $run }}" class="item_onhand_quantity_text">{{ number_format($quota->onhand,2) }}</span></td>
                                    <td>
                                        @if($data['order']->order_status == 'Draft' || is_null($data['order']->order_status))
                                        <a class="fa fa-times red" href="javascript:void(0)" onclick="removeItem({{ $run }})"></a>
                                        @else
                                        <a class="fa fa-times" href="javascript:void(0)"></a>
                                        @endif
                                    </td>
                                </tr>
                            @php $run += 1 ; @endphp
                        @endif
                    @endforeach
                @endforeach
            @endif
            {{-- <tr class="align-middle">
                <td>1.1</td>
                <td>05/06/2563</td>
                <td>10.00</td>
                <td>
                    <div class="input-icon">
                        <input type="text" class="form-control"  name="" placeholder="" value="2301">
                        <i class="fa fa-search"></i>
                    </div>
                </td>
                <td class="text-left">กรองทิพย์ 90</td>

                <td><input type="text" class="form-control md text-center" value="0" name=""></td>
                <td><input type="text" class="form-control md text-center" value="5" name=""></td>
                <td>1</td>

                <td><input type="text" class="form-control md text-center" value="0" name=""></td>
                <td><input type="text" class="form-control md text-center" value="0" name=""></td>
                <td>0</td>

                <td class="text-right">4,337.50</td>
                <td class="text-right">0.00</td>
                <td class="text-right">1,000.00</td>

                <td class="text-right">1,000.00</td>

                <td class="text-right">540</td>

                <td><a class="fa fa-times red" href="#"></a></td>
            </tr> --}}
        </tbody>
    </table>
</div><!--table-responsive-->
