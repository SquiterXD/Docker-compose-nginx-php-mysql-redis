@if (!$itemData)
    <div class="alert alert-danger alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        ไม่พบรหัสวัตถุดิบ item id: {{ $itemReq->item_id }}
    </div>
@else
<h2 class="text-left font-bold no-margins pt-3 pb-3 text-muted">วัตถุดิบในรายงาน</h2>

    <div class="form-group row text-left mb-2 ">
        <div class="col-3 text-right">
            <h3 class="font-bold no-margins">วันที่ในเอกสาร:</h3>
        </div>
        <div class="col-9">
            <h4 class="text-muted no-margins">{{ parseToDateTh($transferDate) }}</h4>
        </div>
    </div>

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
            <h4 class="text-muted no-margins">{{ $itemData->description }}</h4>
        </div>
    </div>

    @if ($step == 2 && $compareItemReq)
        <div class="hr-line-dashed"></div>
        <h2 class="text-left font-bold no-margins pt-3 pb-3 text-muted">วัตถุดิบบนชั้นวาง</h2>
        @if (!$compareItemData)
            <div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                ไม่พบรหัสวัตถุดิบบนชั้นวางของ item id: {{ $compareItemReq->item_id }}
            </div>
        @else
            <div class="form-group row text-left mb-2 ">
                <div class="col-3 text-right">
                    <h3 class="font-bold no-margins">รหัสวัตถุดิบ:</h3>
                </div>
                <div class="col-9">
                    <h4 class="text-muted no-margins">{{ $compareItemData->item_number }}</h4>
                </div>
            </div>
            <div class="form-group row text-left mb-2">
                <div class="col-3 text-right">
                    <h3 class="font-bold no-margins">รายละเอียด:</h3>
                </div>
                <div class="col-9">
                    <h4 class="text-muted no-margins">{{ $compareItemData->item_desc }}</h4>
                </div>
            </div>

            @if ($itemData->inventory_item_id != $compareItemData->inventory_item_id)
                <div class="hr-line-dashed"></div>
                <div class="form-group row text-left ">
                    <div class="col-12 text-center">
                        <h3 class="font-bold no-margins text-danger">
                            <i class="fa fa-times fa-2x"></i>
                            วัตถุดิบไม่ตรงกับที่ต้องการใช้
                        </h3>
                    </div>
                </div>
            @endif
        @endif
    @endif
@endif

@if ($step == 1)

@endif


