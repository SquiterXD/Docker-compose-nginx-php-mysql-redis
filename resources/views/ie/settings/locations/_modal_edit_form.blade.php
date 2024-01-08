{!! Form::model($location, ['route' => ['ie.settings.locations.update', $location->location_id], 'class' => 'form-horizontal', 'method' => 'patch'] ) !!}
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h3 class="m-b-md">
        <div>Edit Location</div>
        <div><small>แก้ไขข้อมูลพื้นที่</small></div>
    </h3>
    <hr class="m-b-xs">
    <div class="row clearfix">
        <div class="col-sm-12">
            <div class="form-group mt-2">
                <div class="row">
                    <div class="col-sm-4">
                        <label>
                            <div>Name</div>
                            <div><small>ชื่อ</small></div>
                        </label>
                        {{-- {!! Form::text('name', null , ["class" => 'form-control', "autocomplete" => "off"]) !!} --}}
                    </div>
                    <div class="col-sm-8">
                        {{ $location->name }}
                        {!! Form::hidden('name', null,) !!}
                    </div>
                </div>
            </div>
            {{-- <div class="form-group">
                <div class="col-sm-12">
                    <label>
                        <div>Description <span class="text-danger">*</span></div>
                        <div><small>รายละเอียด</small></div>
                    </label>
                    {!! Form::text('description', null , ["class" => 'form-control', "autocomplete" => "off"]) !!}
                </div>
            </div> --}}
            <div class="form-group">
                <div class="row">
                    <label class="col-sm-4">
                        <div>Operating Unit<span class="text-danger">*</span></div>
                        <div class="m-r-sm"><small>สถานที่ปฏิบัติการ</small></div>
                    </label>
                    <div class="col-sm-8">
                        {!! Form::select('org_id', $operatingUnits, null , ["class" => 'form-control input-sm select2', "autocomplete" => "off",'id'=>'ddl_org_id']) !!}
                        {{-- @foreach($operatingUnits as $ou)
                            <div>
                                <label>
                                    {!! Form::checkbox('accessible_orgs[]', $ou->organization_id , in_array($ou->organization_id, $location->accessible_orgs)) !!} {{ $ou->name }}
                                </label>
                            </div>
                        @endforeach --}}
                    </div>
                </div>
            </div>
            {{-- <div class="form-group">
                <div class="col-sm-12">
                    <label class="col-xs-6 control-label no-padding" style="text-align: left;">
                        <div>Active ?</div>
                        <div class="m-r-sm"><small>เปิดใช้งาน</small></div>
                    </label>
                    <div class="col-xs-6">
                        <div>
                            {!! Form::checkbox('active', true, null,["class"=>"js-switch"] ) !!}
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    <div class="row clearfix m-t-sm text-right">
        <div class="col-sm-12">
            <button class="btn btn-sm btn-primary" type="submit">
                Save
            </button>
            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
        </div>
    </div>
{!! Form::close()!!}