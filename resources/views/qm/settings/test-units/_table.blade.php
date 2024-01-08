<table class="table program_info_tb testUnits_tb">
    <thead>
        <tr>
            {{-- <th class="text-center">
                <div>ลำดับที่</div>
            </th> --}}
            <th class="text-center">
                <div>สถานะการใช้งาน</div>
            </th>
            <th class="text-center">
                <div>ชื่อ หน่วยการทดสอบ</div>
            </th>
            <th class="text-left">
                <div>รายละเอียด หน่วยการทดสอบ</div>
            </th>
            <th class="text-center">
                <div> </div>
            </th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1; 
        @endphp
        @foreach ($units as $unit)
        <tr>
            {{-- <td class="text-center" style="vertical-align:middle">
                {{ $i++ }}
            </td> --}}
            <td class="text-center" style="vertical-align:middle" data-sort="{{ $unit->enable_flag }}">
                @include('shared._status_active', ['isActive' =>  $unit->enable_flag == "Y" ? true : false ])
            </td>
            <td class="text-center" style="vertical-align:middle">
                {{$unit->qcunit_code}}
            </td>
            <td style="vertical-align:middle">
                {{$unit->qcunit_desc}}
            </td>
            <td class="text-right" style="vertical-align:middle">
                <a type="button" href="{{ route('qm.settings.test-unit.edit', \Crypt::encryptString($unit->qcunit_code)) }}" class="{{ $btnTrans['edit']['class'] }}">
                    <i class="{{ $btnTrans['edit']['icon'] }}" aria-hidden="true"></i> {{ $btnTrans['edit']['text'] }}  
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{-- <div class="d-flex justify-content-end md:tw-my-0 tw-my-2 lg:tw-px-0 tw-px-2" style="padding-top: 15px;">
    {!! $units->links('shared._pagination') !!}
</div> --}}

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var dataTable = $('.testUnits_tb');
            dataTable.DataTable({
                bPaginate: true,
                searching: false,
                bInfo: false,
                columnDefs: [
                   { orderable: false, targets: 3 }
                ]
            });
        });
    </script>
@stop

