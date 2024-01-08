<div class="row">
    {{-- <div class="col-md-4">
        <dl class="dl-horizontal form-inline">
            <dt>
                ชุดการผลิต
            </dt>
            <lable class="ml-3">{{ $routing->routing_no }}</lable>
        </dl>
    </div> --}}
    <div class="col-md-4">
        <dl class="dl-horizontal form-inline">
            <dt>
                คำอธิบายชุดการผลิต
            </dt>
            <lable class="ml-3">{{ $routing->routing_description }}</lable>
        </dl>
    </div>
    <div class="col-md-4">
        <dl class="dl-horizontal form-inline">
            <dt>   
                Organization
            </dt>
            <lable class="ml-3">{{ $routing->organization ? $routing->organization->organization_code . ' : ' . $routing->organization->organization_desc : '' }}</lable>
        </dl>
    </div>
</div>