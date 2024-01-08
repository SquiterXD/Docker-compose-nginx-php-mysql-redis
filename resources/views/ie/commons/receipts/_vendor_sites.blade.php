@if ($vendorId == 'other')
    {!! Form::select('vendor_site_code', [''=>'-'], null , ["class" => 'form-control input-sm select2', "autocomplete" => "off", "style"=>"font-size:11px;width:100%" , 'id'=>'ddl_vendor_site_code', 'disabled'=>'disabled']) !!}
@else
    {!! Form::select('vendor_site_code', $vendorSiteLists, null , ["class" => 'form-control input-sm select2', "autocomplete" => "off", "style"=>"font-size:11px;width:100%" , 'id'=>'ddl_vendor_site_code']) !!}
@endif