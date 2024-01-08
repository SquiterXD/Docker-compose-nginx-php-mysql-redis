<div class="table-responsive">
    <table class="table table-bordered text-center table-hover f13" id="tbOrderLine">
        <thead>
            <tr class="align-middle">
                <th rowspan="2">รายการที่</th>
                <th colspan="3">ยอดส่งครั้งหลังสุด</th>
                <th rowspan="2" class="w-150">รหัสสินค้า</th>
                <th rowspan="2">ชื่อผลิตภัณฑ์</th>
                <th colspan="3">จำนวนที่สั่ง</th>
                <th colspan="3">อนุมัติสั่ง</th>
                <th rowspan="2" style="min-width: 160px;">ราคาขาย/<br>หน่วย</th>
                <th rowspan="2">จำนวนเงิน</th>
                <th rowspan="2">คงคลังทั้งหมด</th>
                @if (request()->order_type == 1065)
                <th rowspan="2" style="width: 55px">ลบ</th>
                @endif
            </tr>
            <tr class="align-middle">
                <!--ยอดส่งครั้งหลังสุด-->
                <th class="w-80"><small>วันที่</small></th>
                <th class="w-80"><small>จำนวน</small></th>
                <th class="w-80"><small>หน่วย</small></th>

                <!--จำนวนที่สั่ง-->
                <th style="min-width:80px;"><small>จำนวน</small></th>
                <th><small>รหัสหน่วยนับ</small></th>
                <th><small>หน่วยนับ</small></th>

                <!--อนุมัติสั่ง-->
                <th style="min-width:80px;"><small>จำนวน</small></th>
                <th><small>รหัสหน่วยนับ</small></th>
                <th><small>หน่วยนับ</small></th>

            </tr>
        </thead>
        <tbody>
        @if (isset($data['orderLine']) && !@empty($data['orderLine']))
            @foreach ($data['orderLine'] as $key_quota => $dataItem)
            <tr class="align-middle" id="tr_item_{{ $dataItem->line_number }}">
                <td>
                    <input type="hidden" class="form-control" readonly name="program_code[{{ $dataItem->line_number }}]" placeholder="" value="{{ $dataItem->program_code }}">
                    <input type="hidden" class="form-control" readonly name="line_number[{{ $dataItem->line_number }}]" placeholder="" value="{{ $dataItem->line_number }}">
                    <span class="runLine">{{ $dataItem->line_number }}</span>
                </td>
                <td><span id="date_latest_{{ $dataItem->line_number }}">{{ $data['latest'][$dataItem->item_id]['order_date'] }}</span></td>
                <td><span id="amount_latest_{{ $dataItem->line_number }}">{{ $data['latest'][$dataItem->item_id]['order_quantity'] }}</span></td>
                <td><span id="uom_latest_{{ $dataItem->line_number }}">{{ $data['latest'][$dataItem->item_id]['order_uom'] }}</span></td>
                <td>
                    <input type="text" class="form-control" readonly name="item_id[{{ $dataItem->line_number }}]" placeholder="" value="{{ $dataItem->item_code }}">
                </td>
                <td class="text-left"><span id="item_name_{{ $dataItem->line_number }}">{{ $dataItem->item_description }}</span></td>

                <td>
                    <input type="text" class="form-control md text-center"
                    value="{{ $dataItem->order_quantity }}"
                    name="order_quantity[{{ $dataItem->line_number }}]"
                    data-line="{{ $dataItem->line_number }}"
                    data-id="{{ $dataItem->item_id }}"
                    data-price="{{ $dataItem->unit_price }}"
                    id="orderQuantity_{{ $dataItem->line_number }}"
                    {{ ($data['order']->order_status == 'Draft') ? '' : 'readonly' }}
                    onkeyup="orderQuantity(this)"
                    onkeypress="return isCheckNumber(event)"
                    >
                </td>
                <td>
                    <span id="uom_code_{{ $dataItem->line_number }}">{{ $dataItem->uom_code }}</span>
                {{-- {{ $dataItem->uom_code }} --}}
                </td>
                <td>
                {{ $dataItem->uom }}
                </td>

                <td><input type="text" class="form-control md text-center"
                    value="{{ ($dataItem->approve_quantity != '' || $dataItem->program_code == 'OMP0019') ? $dataItem->approve_quantity : $dataItem->order_quantity }}"
                    id="approveQuantity_{{ $dataItem->line_number }}" onkeyup="approveQuantity(this)" onkeypress="return isCheckNumber(event)"
                    name="approve_quantity[{{ $dataItem->line_number }}]"
                    data-line="{{ $dataItem->line_number }}"
                    data-id="{{ $dataItem->item_id }}"
                    data-price="{{ $dataItem->unit_price }}"
                    autocomplete="off"
                    {{ ($data['order']->order_status != 'Draft' && !is_null($data['order']->order_status)) ? 'disabled' : '' }}
                    ></td>
                <td>
                    <span id="uom_code_approve_{{ $dataItem->line_number }}">{{ $dataItem->uom_code }}</span>
                <td>
                    {{-- <select class="custom-select select2 uom_select" data-id="{{ $dataItem->line_number }}" aria-readonly="true" name="uom_code[{{ $dataItem->line_number }}]" id="uom_code_{{ $dataItem->line_number }}" data-placeholder="หน่วยนับ">
                        @foreach($data['uomList'] as $item)
                            @if($item->item_id == $dataItem->item_id)
                                @foreach($item->uom_list as $uom)
                                <option value="{{ $uom['uom_code'] }}" {{ ($dataItem->uom_code == $uom['uom_code']) ? 'selected' : '' }} data-line="{{ $dataItem->line_number }}" data-price="{{ $uom['price_unit'] }}" data-measure="{{ $uom['unit_of_measure'] }}">{{ $uom['unit_of_measure'] }}</option>
                                @endforeach
                            @endif
                        @endforeach
                    </select> --}}
                    {{ $dataItem->uom }}
                </td>

                <td class="text-right">
                    <span id="item_price_text_{{ $dataItem->line_number }}" style="display:none;">{{ number_format($dataItem->unit_price,2) }}</span>
                    <input type="text" class="form-control md text-center unit_price_text"
                    id="unit_price_text_{{ $dataItem->line_number }}"
                    name="unit_price_text[{{ $dataItem->line_number }}]"
                    onkeyup="changePrice(this)" onkeypress="return isCheckNumber(event)"
                    data-line="{{ $dataItem->line_number }}"
                    data-id="{{ $dataItem->item_id }}"
                    data-price="{{ $dataItem->unit_price }}"
                    value="{{ number_format($dataItem->unit_price,2) }}"
                    {{ ($data['order']->order_status == 'Draft' && $dataItem->program_code != 'OMP0003') ? '' : 'readonly' }}
                    >
                    <input type="hidden" class="form-control md text-center unit_price"
                    id="unit_price_{{ $dataItem->line_number }}"
                    name="unit_price[{{ $dataItem->line_number }}]"
                    onkeyup="changePrice(this)" onkeypress="return isCheckNumber(event)"
                    data-line="{{ $dataItem->line_number }}"
                    data-id="{{ $dataItem->item_id }}"
                    data-price="{{ $dataItem->unit_price }}"
                    value="{{ $dataItem->unit_price }}"
                    {{ ($data['order']->order_status == 'Draft') ? '' : 'disabled' }}
                    >
                </td>

                <td class="text-right">
                    <span id="sum_amount_text_{{ $dataItem->line_number }}" class="sum_amount_text_{{ $dataItem->item_id }}_{{ $dataItem->line_number }}">{{ number_format($dataItem->amount,2) }}</span>
                    <input type="hidden" class="sum_amount_item" id="sum_amount_{{ $dataItem->line_number }}" name="sum_amount[{{ $dataItem->line_number }}]" value="{{ ($dataItem->amount == null) ? 0 : $dataItem->amount }}"/>
                </td>
                <td class="text-center">
                    {{ number_format($dataItem->onhand,2) }}
                </td>
                <!-- <td>
                    @if($data['order']->order_status == 'Draft' || is_null($data['order']->order_status))
                    <a class="fa fa-times red" href="javascript:void(0)" onclick="removeItemLine({{ $dataItem->line_number }},{{ $dataItem->order_line_id }})"></a>
                    @else
                    <a class="fa fa-times" href="javascript:void(0)"></a>
                    @endif
                </td> -->
            </tr>
            @endforeach
        @endif
        </tbody>
    </table>
</div><!--table-responsive-->
