<div>
    <h4>สูตรการผลิต</h4>
    <div class="row">
        <div class="col-md-4">
            <label class="ml-3"> <b>รหัสสินค้า</b>  </label>
            <label class="ml-3">{{ $ingredient->item ?  $ingredient->item->item_number . ' ' . $ingredient->item->item_desc : '' }}</label>
        </div>
        <div class="col-md-4">
            <label> <b>Orgranization</b> </label>
            <label class="ml-3">{{ $ingredient->organization ? $ingredient->organization->organization_code : '' }}</label>
        </div>
        <div class="col-md-3">
            <label> <b>สถานะ</b> </label>
            <label class="ml-3">{{ $ingredient->status }}</label>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-4">
            <label class="ml-3"> <b>ประเภทสูตร</b> </label>
            <label class="ml-3">{{ $ingredient->folmula_type }} </label>
        </div>
        <div class="col-md-4">
            <label> <b>Version</b> </label>
            <label class="ml-3">{{ $ingredient->version }} </label>
        </div>
        <div class="col-md-3">
            <label> <b>ผู้อนุมัติ</b> </label>
            <label class="ml-3">{{ $ingredient->user ? $ingredient->user->user_name : '' }}</label>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-4">
            <label class="ml-3"> <b>ขั้นตอนการทำงาน</b> </label>
            <label class="ml-3"> {{ $ingredient->opmRouting ? $ingredient->opmRouting->oprn_class_desc : '' }} </label>
        </div>
        <div class="col-md-4">
            <label> <b>ประเภทเครื่องจักร</b> </label>
            <label class="ml-3">
                @if ($ingredient->organization->organization_code == 'M05')
                    {{ $ingredient->machineGroupF  ? $ingredient->machineGroupF->description : '' }}  
                @else
                    {{ $ingredient->machineType  ? $ingredient->machineType->description : '' }}
                @endif
            </label>
        </div>
        
        <div class="col-md-3">
            <label> <b>วันที่เริ่มใช้งาน</b> </label>
            <label class="ml-3">{{ $ingredient->start_date ? date(trans('date.format-date'),strtotime($ingredient->start_date)) : '' }}</label>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-4">
            <label class="ml-3"> <b>จำนวนผลผลิต</b> </label>
            <label class="ml-3">{{ number_format($ingredient->qty) }}</label>
        </div>
        <div class="col-md-4">
            <label> <b>วันที่สร้าง</b> </label>
            <label>{{ $ingredient->created_at ? date(trans('date.format-date'),strtotime($ingredient->created_at)) : '' }}</label>
        </div>
        <div class="col-md-3">
            <label> <b>วันที่สิ้นสุดการใช้งาน</b> </label>
            <label class="ml-3">{{ $ingredient->end_date ? date(trans('date.format-date'),strtotime($ingredient->end_date)) : '' }}</label>
        </div>
    </div>
</div>