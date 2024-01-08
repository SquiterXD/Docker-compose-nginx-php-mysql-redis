{!! Form::open(['route' => ['ir.settings.sub-groups.index'] , "method" => "get" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
    <sub-groups-search-component    :policy-set-headers = "{{ json_encode($policySetHeaders) }}"
                                    :search = "{{ json_encode($search) }}">
    </sub-groups-search-component>

    {{-- <div class="col">
        <div class="col" style="margin-top: 30px;">
            <button class="btn btn-light" type="submit">
                <i class="fa fa-search" aria-hidden="true"></i> ค้นหา 
            </button>
            <a href="{{ route('ir.settings.sub-groups.index') }}" type="button" class="btn btn-danger"> 
                รีเซ็ต
            </a>
        </div>
    </div> --}}

    <div class="row clearfix text-right">
        <div class="col" style="margin-top: 15px; margin-right: 5px;">
            <button class="{{ $btnTrans['search']['class'].' btn-sm'}}" type="submit"> 
                <i class="{{ $btnTrans['search']['icon']}}" aria-hidden="true"></i> 
                {{ $btnTrans['search']['text']}} 
            </button>
            <a href="{{ route('ir.settings.sub-groups.index') }}" type="button" class="btn btn-warning btn-sm"> 
                <i class="fa fa-undo"></i> รีเซ็ต
            </a>
        </div>
    </div>
{!! Form::close() !!}