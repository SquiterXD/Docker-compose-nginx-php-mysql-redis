<div class="row mt-2">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"> 
            <strong> ทวีป </strong> <span class="text-danger">*</span>
        </div>
        <div align="center">
            <select name="continent_name" class="form-control">
                <option></option>
                @foreach ($continents as $continent)
                    <option value="{{ $continent->value }}">{{ $continent->meaning }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"> 
            <strong> ประเทศ </strong> <span class="text-danger">*</span>
        </div>
        <div align="center">
            <div align="center">
                <select name="geography_name" class="form-control">
                    <option></option>
                    @foreach ($hzGeographies as $hzGeography)
                        <option value="{{ $hzGeography->geography_id }}">{{ $hzGeography->geography_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"> 
            <strong> รหัสประเทศ </strong> <span class="text-danger">*</span>
        </div>
        <div align="center">
            <input type="text" class="form-control col-12" name="country_code">
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="form-group pl-12 pr-2 mb-0 col-lg-6 col-md-6 col-sm-6 col-xs-6 offset-md-3 mt-2">
        <div class="control-label mb-2"> 
            <strong> Status </strong> <span class="text-danger">*</span>
        </div>
        <div align="center">
            <div align="center">
                <select name="status" class="form-control">
                    <option value="Active" >Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
        </div>
    </div>
</div>