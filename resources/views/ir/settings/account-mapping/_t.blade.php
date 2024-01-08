<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">
                    <div> รหัส (Code) </div>
                </th>
                <th class="text-center">
                    <div> คำอธิบาย (Description) </div>
                </th>
                <th class="text-center" witdth="20%"> 
                    <div> รหัสบัญชี (Account Code) </div>
                </th>
                <th class="text-center">
                    <div> Active </div>
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($accountAlls as $account)
                <tr>
                    <td> {{ $account->account_code }} </td>
                    <td> {{ $account->description }} </td>
                    <td> {{ $account->fullGlCode }} </td>
                    <td class="text-center">
                        <a href="{{ route('ir.settings.account-mapping.edit', $account->account_id) }}" class="btn btn-warning btn-xs">
                            <i class="fa fa-edit m-r-xs"></i> แก้ไข
                        </a>
                    </td>
                </tr>
            @endforeach
               
        </tbody>
    </table>
</div>
{{-- <div class="m-t-sm text-right">
    {{ $accountAlls->links() }}
</div> --}}
