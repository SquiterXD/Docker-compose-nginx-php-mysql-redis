<h2> แผนการผลิต : {{ $productType }} </h2>
<form id="om-sales-form">
    @if (count($saleForecasts) > 0)
        <div class="row col-12" style="font-size: 15px;">
            <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2">
                <label class=" tw-font-bold tw-uppercase mb-1"> ปักษ์ : </label>
                <span> {{ optional($saleForecasts->first())->biweekly_no }} </span>
            </div>

            <div class="form-group pl-2 pr-2 mb-0 col-lg-2 col-md-4 col-sm-6 col-xs-6 mt-2">
                <label class=" tw-font-bold tw-uppercase mb-1"> ครั้งที่ : </label>
                <span>
                    {{ optional($saleForecasts->first())->version ?? 0 }}
                </span>
            </div>

            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-4 col-sm-6 col-xs-6 mt-2">
                <label class=" tw-font-bold tw-uppercase mb-1"> จำนวนวันขาย : </label>
                <span>
                    {{ optional($saleForecasts->first())->OmBiWeekly->day_for_sale ?? 0 }} วัน
                </span>
            </div>

            <div class="form-group pl-2 pr-2 mb-0 col-lg-3 col-md-4 col-sm-6 col-xs-6 mt-2">
                <label class=" tw-font-bold tw-uppercase mb-1"> วันที่อนุมัติ : </label>
                <span>
                    {{ optional($saleForecasts->first())->OmSalesForecast->approve_date_format ?? '' }}
                </span>
            </div>
        </div>
    @endif
    <div class="hr-line-dashed"></div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" style="vertical-align: middle;" style="width: 3%;">
                       <div> ลำดับ </div> 
                    </th>
                    <th class="text-center" style="vertical-align: middle;" style="width: 8%;">
                       <div> รหัสบุหรี่ </div>
                    </th>
                    <th class="text-center" style="vertical-align: middle;" style="width: 20%;">
                       <div> ตราบุหรี่ </div>
                    </th>
                    <th class="text-center" style="vertical-align: middle;" style="width: 10%;">
                       <div> ประมาณการจำหน่าย<br>(พันมวน) </div>
                    </th>
                    <th class="text-center" style="vertical-align: middle;" style="width: 10%;">
                       <div> ประมาณการจำหน่าย<br>(ล้านมวน) </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @if (count($saleForecasts) <= 0)
                   <tr>
                        <td colspan="5" class="text-center" style="vertical-align: middle;">
                            <h2> ไม่พบข้อมูลที่ค้นหาในระบบ </h2>
                        </td>
                    </tr>
                @else
                    @foreach ($saleForecasts as $index => $saleForecast)
                        <tr>
                        <td class="text-center">
                            <div> {{ $index+1 }} </div>
                        </td>
                        <td class="text-left">
                            <div> {{ $saleForecast->item_code }} </div>
                        </td>
                        <td class="text-left">
                            <div> {{ $saleForecast->item_description }} </div>
                        </td>
                        <td class="text-right">
                            <div> {{ $saleForecast->forecast_qty_format }} </div>
                        </td>
                        <td class="text-right">
                            <div> {{ $saleForecast->forecast_million_qty_format }} </div>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <th colspan="3" class="text-right">รวมประมาณการจำหน่าย</th>
                        <th style="background-color: #34d399;" class="text-right text-white">
                            {{ getSumFormat($saleForecasts, 'forecast_qty', 3) }}
                        </th>
                        <th style="background-color: #34d399;" class="text-right text-white">
                            {{ getSumFormat($saleForecasts, 'forecast_million_qty', 3) }}
                        </th>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</form>