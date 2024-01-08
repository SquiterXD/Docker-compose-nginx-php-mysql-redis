<div class="table-responsive mt-2" style="max-height: 500px;">
    <table class="table text-nowrap data_tb table-bordered">
        <thead>
            <tr>
              <th style="min-width: 70px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">ลำดับ</th>
              <th style="min-width: 160px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">ทะเบียนรถ</th>
              <th style="min-width: 160px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">ชุดกรมธรรม์</th>
              <th style="min-width: 140px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">กลุ่ม</th>
              <th style="min-width: 400px; width: 1%; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">ประเภทรถ</th>
              <th style="min-width: 135px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">ยี่ห้อรถ</th>
              <th style="min-width: 120px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">ขอคืนภาษีได้</th>
              <th style="min-width: 120px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">ภาษี (%)</th>
              <th style="min-width: 120px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">อากร (%)</th>
              <th style="min-width: 150px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">รหัสทรัพย์สิน</th>
              <th style="min-width: 200px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">รหัสบัญชี</th>
              <th style="min-width: 140px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">วันที่ดึงข้อมูลจากระบบ FA</th>
              <th style="min-width: 120px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">Active</th>
              <th style="min-width: 120px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">สถานะการขาย</th>
              <th style="min-width: 120px; position: sticky; background-color: #f7f7f7; z-index: 9999; top: 0;" class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataList as $data)
                <tr>
                    <td class="text-center"> {{ $loop->iteration }}</td>
                    <td class="text-left"> {{ $data->license_plate }}</td>
                    <td class="text-left"> 
                        {{ $data->policy_set_number }} {{ $data->policy_set_number ? ':' : ''}} {{ $data->policy_set_description }}
                    </td>
                    <td class="text-left"> {{ $data->policySet ? $data->policySet->group_desc : '' }}</td>
                    <td class="text-left"> {{ $data->vehicle_type_name }}</td>
                    <td class="text-center"> {{ $data->vehicle_brand_name }}</td>
                    <td class="text-center" data-sort="{{ $data->return_vat_flag == 'Y' ? true : false }}">
                        <input type="checkbox" name="return_vat_flag" style="position: inherit;" {{ $data->return_vat_flag == 'Y' ? 'checked' : '' }} disabled>                        
                    </td>
                    <td class="text-center">
                        {{-- {{dd($data->policyGroupSet->getPremiumRate($data->policy_set_header_id, null, null, date("Y")), $data->policyGroupSet->getLastRecordRate($data->policy_set_header_id))}} --}}
                        {{-- {{ $data->vat_percent }} --}}
                        @php
                            $vat_percent = '';
                            if ($data->policyGroupSet) {
                                $policyGroupSet = $data->policyGroupSet->getPremiumRate($data->policy_set_header_id, null, null, date("Y"));
                                $vat_percent = $policyGroupSet ? $policyGroupSet->tax : '';
                            }
                        @endphp
                        {{ $vat_percent }}
                    </td>
                    <td class="text-center">
                        {{ $data->revenue_stamp_percent ? $data->revenue_stamp_percent : $data->revenue_stamp_percent }}
                    </td>
                    <td class="text-center">
                        {{ $data->asset_number }}
                    </td>
                    <td class="text-left">
                        {{ $data->account_number }}
                    </td>
                    <td class="text-center">
                        @if ($data->asset_number)                        
                            {{ date(trans('date.format'),strtotime($data->creation_date)) }}
                        @endif
                    </td>
                    <td class="text-center" data-sort="{{ $data->active_flag == 'Y' ? true : false }}">
                        <vehicle-active-flag 
                            :vehicle="{{ json_encode($data) }}">
                        </vehicle-active-flag>
                    </td>
                    <td class="text-center" data-sort="{{ $data->sold_flag == 'Y' ? true : false }}">
                        <input type="checkbox" name="sold_flag" style="position: inherit;" {{ $data->sold_flag == 'Y' ? 'checked' : '' }} disabled>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('ir.settings.vehicle.edit', $data->vehicle_id) }}" class="{{ trans('btn.edit.class') }} btn-sm tw-w-25">
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
                pageLength: 25,
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