<div
 style="overflow-x:scroll; white-space: nowrap;"
 >
    <table class="table program_info_tb" id="program_info_tb_datatable">
        <thead>
            <tr>
                <th class="text-center">
                    <div>สถานะการใช้งาน</div>
                </th>
                <th class="text-left">
                    <div>Organization</div>
                </th>
                <th class="text-left">
                    <div>ประเภทการเบิก</div>
                </th>
                <th class="text-left">
                    <div>ประเภทวัตถุดิบ</div>
                </th>
                <th class="text-left">
                    <div>รายละเอียด</div>
                </th>
                <th class="text-left">
                    <div>Organization รับวัตถุดิบ</div>
                </th>
                <th class="text-center">
                    <div>คลังจัดเก็บ</div>
                </th>
                <th class="text-center">
                    <div>สถานที่จัดเก็บ</div>
                </th>
                <th class="text-center">
                    <div> </div>
                </th>
            </tr>
        </thead>
        @if (count($ListSetupTransfer) <= 0)
            <tbody>
                <tr>
                    <td colspan="7" class="text-center" style="vertical-align: middle;">
                        <h2> ไม่พบข้อมูลในระบบ </h2>
                    </td>
                </tr>
            </tbody>
        @else
            <tbody>
                {{-- @foreach ($ListSetupTransfer as $setupTransfer)
                <tr>
                    <td class="text-center" style="vertical-align: middle;">          
                        @include('shared._status_active', ['isActive' => $setupTransfer->enable_flag == 'Y' ? true : false])
                    </td>
                    <td class="text-left" style="vertical-align: middle;">
                        {{ $setupTransfer->organization_code }}
                    </td>
                    <td class="text-left" style="vertical-align: middle;">
                        {{ $setupTransfer->request_type }}
                    </td>
                    <td class="text-left" style="vertical-align: middle;">
                        {{ $setupTransfer->item_cat_code }}
                    </td>
                    <td class="text-left" style="vertical-align: middle;">
                        {{ $setupTransfer->description }}
                    </td>
                    <td class="text-left" style="vertical-align: middle;">
                        {{ $setupTransfer->to_organization_code. " : " .$setupTransfer->organization_name }}
                    </td>
                    <td class="text-center" style="vertical-align: middle;">
                        {{ $setupTransfer->to_subinventory_code }}
                    </td>
                    <td class="text-center" style="vertical-align: middle;">
                        {{ $setupTransfer->to_locator_segment2 }}
                    </td>
                    <td class="text-center" style="vertical-align: middle;">
                        <a  type="button" href="{{ route('pm.settings.setup-transfer.edit', $setupTransfer->setup_trans_id) }}" 
                            class="{{ $btnTrans['edit']['class'] }}">
                            <i class="{{ $btnTrans['edit']['icon'] }}" aria-hidden="true"></i> {{ $btnTrans['edit']['text'] }}
                        </a>
                    </td>
                </tr>            
                @endforeach --}}
            </tbody>
        @endif
    </table>
</div>
