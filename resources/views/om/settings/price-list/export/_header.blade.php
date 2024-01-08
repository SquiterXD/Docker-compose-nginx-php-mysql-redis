<div class="row">
    <div class="col-md-6">
        <dl class="dl-horizontal form-inline">
            <dt>
                ชื่อรายการราคาสินค้า
            </dt>
            <lable class="ml-3">{{ $header->name }}</lable>
        </dl>
    </div>
    <div class="col-md-6">
        <dl class="dl-horizontal form-inline">
            <dt>
                รายละเอียด
            </dt>
            <lable class="ml-3">{{ $header->description }}</lable>
        </dl>
    </div>
</div>
{{-- <div class="row">
    <div class="col-md-6">
        <dl class="dl-horizontal form-inline">
            <dt>
                สกุลเงิน
            </dt>
            <lable class="ml-3">{{ $header->currency }}</lable>
        </dl>
    </div>
</div> --}}
<div class="row">
    <div class="col-md-6">
        <dl class="dl-horizontal form-inline">
            <dt>
                วันที่ใช้งาน
            </dt>
            <lable class="ml-3">
                {{ $header->effective_dates_from ? date(trans('date.format-date'),strtotime($header->effective_dates_from)) : '' }}
            </lable>
        </dl>
    </div>
    <div class="col-md-6">
        <dl class="dl-horizontal form-inline">
            <dt>
                วันที่สิ้นสุดใช้งาน
            </dt>
            <lable class="ml-3">
                {{ $header->effective_dates_to ? date(trans('date.format-date'),strtotime($header->effective_dates_to)) : '' }}
            </lable>
        </dl>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <dl class="dl-horizontal form-inline">
            <dt>
                สกุลเงิน
            </dt>
            <lable class="ml-3">{{ $header->currency }}</lable>
        </dl>
    </div>
    <div class="col-md-6">
        <dl class="dl-horizontal form-inline">
            <dt>
                หมายเหตุรายการ
            </dt>
            <lable class="ml-3">{{ $header->comments }}</lable>
        </dl>
    </div>
</div>
