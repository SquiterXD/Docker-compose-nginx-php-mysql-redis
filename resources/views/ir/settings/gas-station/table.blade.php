<div class="table-responsive margin_top_20">
    <table  class="table text-nowrap data_tb table-bordered" style="display: block; overflow: auto; max-height: 500px; position: sticky;">
      <thead>
        <tr>
          <th style="min-width: 200px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">ประเภทสถานีน้ำมัน</th>
          <th style="min-width: 110px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">กลุ่ม</th>
          <th style="min-width: 200px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">วันที่คิดค่าเบี้ยประกัน</th>
          <th style="min-width: 110px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">ทุนประกัน</th>
          <th style="min-width: 110px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">ขอคืนภาษีได้</th>
          <th style="min-width: 110px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">ภาษี (%)</th>
          <th style="min-width: 110px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">อากร (บาท)</th>
          <th style="min-width: 200px; width: 1%; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">รหัสบัญชี</th>
          <th style="min-width: 110px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">Active</th>
          <th style="min-width: 110px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($dataLists as $data)
            <tr>
                <td class="text-left">{{ $data->type_code }}</td>
                <td class="text-center">{{ $data->group ? $data->group->meaning : '' }}</td>
                <td class="text-center">{{ $data->insurance_date ? parseToDateTh($data->insurance_date) : '' }}</td>
                <td class="text-right">
                    {{ number_format($data->coverage_amount, 2) }}
                </td>
                <td  class="text-center">
                    {{-- <div  class="form-check"
                        style="position: inherit;">
                    <input  class="form-check-input" 
                            type="checkbox"
                            v-model="data.return_vat_flag"
                            @change="changeCheckedReturnVatFlg(data)"
                            style="position: inherit;">
                    </div> --}}
                    <gas-station-return-flag 
                        :gas-station="{{ json_encode($data) }}">
                    </gas-station-return-flag>
                </td>
                <td  class="text-center">
                    {{ number_format($data->vat_percent, 2) }}
                </td>
                <td  class="text-right">
                    {{  number_format($data->revenue_stamp_percent, 2) }}
                </td>
                <td  class="text-left">{{ $data->accountMapping ? $data->accountMapping->account_combine : '' }}</td>
                <td  class="text-center">
                    <gas-station-active-flag 
                        :gas-station="{{ json_encode($data) }}">
                    </gas-station-active-flag>
                </td>
                <td  class="text-center">
                    <a href="{{ route('ir.settings.gas-station.edit', $data->gas_station_id) }}" class="{{ trans('btn.edit.class') }} btn-sm tw-w-25">
                        <i class="{{ trans('btn.edit.icon') }}"></i> {{ trans('btn.edit.text') }}
                    </a>
                </td>
            </tr>
        @endforeach
      </tbody>
    </table>
</div>
@section('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        var dataTable = $('.data_tb');
        var loadingHtml = '<div class="sk-spinner sk-spinner-wave"> <div class="sk-rect1"></div> <div class="sk-rect2"></div> <div class="sk-rect3"></div> <div class="sk-rect4"></div> <div class="sk-rect5"></div> </div>';
        dataTable.DataTable({
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            bFilter: false,
            aaSorting: [],
            bPaginate:true,
            bInfo: false,
            columnDefs: [
                // { className: "text-center", "targets": [ 0 ] , type: "string", orderable : false },
            ],
            language: {
                loadingRecords: loadingHtml,
            },
            buttons: [
            ],
        });
    });
</script>
@stop