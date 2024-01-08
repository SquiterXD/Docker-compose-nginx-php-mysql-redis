<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                {{-- รหัส, คำอธิบาย, บัญชี, ชื่อบัญชี, วันที่เริ่มต้นใช้งาน, วันที่สิ้นสุดการใช้งาน, ใช้งาน --}}
                <th class="text-center">
                    <div style="width: 80px;"> รหัส </div>
                </th>
                <th class="text-center">
                    <div style="width: 180px;"> คำอธิบาย </div>
                </th>
                <th class="text-center">
                    <div style="width: 280px;"> บัญชี </div>
                </th>
                <th class="text-center">
                    <div style="width: 280px;"> ชื่อบัญชี </div>
                </th>
                <th class="text-center">
                    <div style="width: 80px;"> วันที่เริ่มต้นใช้งาน </div>
                </th>
                <th class="text-center">
                    <div style="width: 80px;"> วันที่สิ้นสุดการใช้งาน </div>
                </th>
                <th class="text-center">
                    <div style="width: 50px;"> ใช้งาน </div>
                </th>
                {{-- <th class="test-center" witdth="20%"> 
                    <div> รหัสบัญชี </div>
                </th> --}}
                <th>
                    <div style="width: 80px;"></div>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accountAliases as $account)
                <tr>
                    <td> {{ $account->account_code }} </td>
                    <td> {{ $account->description }} </td>
                    <td> {{ $account->fullGlCode }} </td>
                    <td> {{ $account->account_combine_desc }} </td>
                    <td> 
                        {{ $account->start_date ? date(trans('date.format-date'), strtotime($account->start_date)) : '' }} 
                    </td>
                    <td> 
                        {{ $account->end_date ? date(trans('date.format-date'), strtotime($account->end_date)) : '' }} 
                    </td>
                    <td class="text-center"> 
                        @include('shared._status_active', ['isActive' => $account->active_flag == 'Y']) 
                    </td>
                    <td class="text-center">
                        <a href="{{ route('om.settings.account-mapping.edit', $account->account_id) }}" class="btn btn-warning btn-xs">
                            <i class="fa fa-edit m-r-xs"></i> แก้ไข
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {{ $accountAliases->links() }}
</div>
