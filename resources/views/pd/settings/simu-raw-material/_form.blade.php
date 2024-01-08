{{-- 
<div class="row mt-2">
    <div class="col-md-6">
        <div class="form-group mt-2">
            <div class="control-label mb-2"> 
                <strong> รหัสวัตถุดิบ </strong> <span class="text-danger">*</span>
            </div>
            <div align="center">
                <input type="text" class="form-control col-12" name="material_code" value="{{ old('material_code') }}">
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group mt-2">
            <div class="control-label mb-2"> 
                <strong> รายละเอียด </strong> <span class="text-danger">*</span>
            </div>
            <div align="center">
                <input type="text" class="form-control col-12" name="description" value="{{ old('description') }}">
            </div>
        </div>
    </div>
</div> --}}

{{-- --------------------------------------------------------------------------------------------------- --}}



<simu-form :simulation-types="{{ json_encode($simulationTypes) }}" 
           :uoms="{{ json_encode($uoms) }}"
           :old="{{ json_encode(Session::getOldInput()) }}">
</simu-form>


{{-- <div class="row mt-2">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"> 
            <strong> รหัสวัตถุดิบ </strong> <span class="text-danger">*</span>
        </div>
        <div align="center">
            <input type="text" class="form-control col-12" name="material_code" value="{{ old('material_code') }}">
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"> 
            <strong> รายละเอียด </strong> <span class="text-danger">*</span>
        </div>
        <div align="center">
            <input type="text" class="form-control col-12" name="description" value="{{ old('description') }}">
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"> 
            <strong> ประเภทวัตถุดิบจำลอง </strong> <span class="text-danger">*</span>
        </div>
        <div align="center">
            <select name="material_type" class="form-control">
                <option value="">-</option>
                @foreach ($simulationTypes as $simulationType)
                    <option value="{{ $simulationType->lookup_code }}" > {{ $simulationType->meaning }} </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"> 
            <strong> ราคาต่อหน่วย </strong> <span class="text-danger">*</span>
        </div>
        <div align="center">
            <input type="text" class="form-control col-12" name="price" value="{{ old('price') }}">
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"> 
            <strong> หน่วย </strong> <span class="text-danger">*</span>
        </div> 
        <div>
            <select name="uom_code" class="form-control">
                <option value="">-</option>
                @foreach ($uoms as $uom)
                    <option value="{{ $uom->uom_code }}" > {{ $uom->description }} </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"> 
            <strong> วันที่เริ่ม </strong> <span class="text-danger">*</span>
        </div>
        <div align="center">
            <date-test></date-test>
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"> 
            <strong> วันที่สิ้นสุด </strong> <span class="text-danger">*</span>
        </div>
        <div align="center" >
           <date-test></date-test>
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"> 
            <strong> หมายเหตุ </strong>
        </div>
        <div align="center">
            <input type="text" class="form-control col-12" name="remark" value="{{ old('remark') }}">
        </div>
    </div>
</div> --}}
{{-- <div class="row mt-2">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"> 
        </div>
        <div>
            <a href="#" class="btn btn-white btn-xs">
                สร้างวัตถุดิบในกล่อง
            </a>
        </div>
    </div>
</div> --}}