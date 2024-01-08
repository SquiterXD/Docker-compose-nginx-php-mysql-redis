@if (!$itemData && $step > 1 && $step != 4 && $step != 5)
    <div class="alert alert-danger alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        ไม่พบรหัสวัตถุดิบ item id: {{ optional($itemReq)->item_id }}
    </div>
@else
    @if ($itemData && $step == 3)
        <div class="alert alert-success alert-dismissable">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
            บันทึกข้อมูลสำเร็จ
        </div>
    @endif

    @if ($currentData)
        <div class="form-group row text-left mb-2">
            <div class="col-4 text-right">
                <h3 class="font-bold no-margins">วันที่ทำรายการ :</h3>
            </div>
            <div class="col-8">
                <h4 class="text-muted no-margins">{{ $currentData->transfer_date }}</h4>
            </div>
        </div>
    @endif
@endif



{{-- currentData --}}


{{-- @if (!$itemData) --}}
@if (true)
    {{-- <div class="alert alert-danger alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        ไม่พบรหัสวัตถุดิบ item id: {{ optional($itemReq)->item_id }}
    </div> --}}
@else
    <div class="form-group row text-left mb-2">
        <div class="col-3 text-right">
            <h3 class="font-bold no-margins">รหัสวัตถุดิบ:</h3>
        </div>
        <div class="col-9">
            <h4 class="text-muted no-margins">{{ $itemData->item_number }}</h4>
        </div>
    </div>
    <div class="form-group row text-left mb-2">
        <div class="col-3 text-right">
            <h3 class="font-bold no-margins">รายละเอียด:</h3>
        </div>
        <div class="col-9">
            <h4 class="text-muted no-margins">{{ $itemData->item_desc }}</h4>
        </div>
    </div>

    @if ($machineGroupReq)
        <div class="hr-line-dashed"></div>
        <h2 class="text-left font-bold no-margins  pb-3 text-muted">เครื่องจักร</h2>
        @if (!$machineGroupData)
            <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                ไม่พบรหัสเครื่องจักร machine group: {{ optional($machineGroupReq)->machine_group }}
            </div>
        @else
            <div class="form-group row text-left mb-2 ">
                <div class="col-3 text-right">
                    <h4 class="font-bold no-margins">รหัสเครื่องจักร:</h4>
                </div>
                <div class="col-9">
                    <h4 class="text-muted no-margins">{{ $machineGroupData->machine_group }}</h4>
                </div>
            </div>
            {{-- @if ($itemData->inventory_item_id != $compareItemData->inventory_item_id)
                <div class="hr-line-dashed"></div>
                <div class="form-group row text-left ">
                    <div class="col-12 text-center">
                        <h3 class="font-bold no-margins text-danger">
                            <i class="fa fa-times fa-2x"></i>
                            วัตถุดิบไม่ตรงกับที่ต้องการใช้
                        </h3>
                    </div>
                </div>
            @endif --}}
        @endif
    @endif

    @if ($step == 3 && $assigneeReq)
        <div class="hr-line-dashed"></div>
        <h2 class="text-left font-bold no-margins  pb-3 text-muted">ผู้รับโอน</h2>
        @if (!$assigneeData)
            <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                ไม่พบรหัสผู้รับโอน user id: {{ optional($assigneeReq)->user_id }}
            </div>
        @else
            <div class="form-group row text-left mb-2 ">
                <div class="col-3 text-right">
                    <h4 class="font-bold no-margins">ชื่อผู้รับโอน:</h4>
                </div>
                <div class="col-9">
                    <h4 class="text-muted no-margins">{{ $assigneeData->name }}</h4>
                </div>
            </div>
        @endif
    @endif
@endif