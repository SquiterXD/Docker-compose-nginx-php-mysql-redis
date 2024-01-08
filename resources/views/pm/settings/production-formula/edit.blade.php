@extends('layouts.app')

@section('title', 'PMS0033')

@section('page-title')
    <x-get-page-title menu="" url="{{ $url }}" />

    {{-- <h2>สูตรการผลิต</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>PM</a>
        </li>
        <li class="breadcrumb-item">
            <a>Settings</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('pm.settings.production-formula.index') }}">สูตรการผลิต</a>
        </li>
    </ol> --}}
@stop

@section('content')
    <div>
        <div class="ibox">
            
            {{-- <form action="{{ route('pm.settings.production-formula.update', $ingredient->ingredient_id) }}" method="POST" class="disable-on-submit">
                @csrf
                @method('PUT')
                <div class="ibox-title">
                    <div class="row">
                        <div class="col-3">
                            <h3 class="no-margins"> กำหนดสูตรผลิตภัณฑ์ </h3>
                        </div>
                        <div class="col-9 text-right">
                            <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                            <a href="{{ route('pm.settings.production-formula.index') }}" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-times"></i> ยกเลิก </a>
                        </div>
                    </div>
                </div> --}}
                {{-- --------- --}}
                {{-- <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    <h5>กำหนดสูตรผลิตภัณฑ์</h5>
                </div> --}}

                @php
                    if ($organizationCode == 'MPG' || $organizationCode == 'M12' || $organizationCode == 'M06') {
                        $orgMutiWip = true;
                    } else {
                        $orgMutiWip = false;
                    }
                        // dd($orgMutiWip);
                    
                @endphp
                
                <production-formula-edit
                    :users="{{ json_encode($users) }}"
                    :machine-types="{{ json_encode($machineTypes) }}"
                    :routings="{{ json_encode($routings) }}"
                    :wip-steps="{{ json_encode($wipSteps) }}"
                    :oprns="{{ json_encode($oprns) }}"
                    :user="{{ json_encode(auth()->user()) }}"
                    :organizations="{{ json_encode($organizations) }}"
                    :default-value="{{ json_encode($header)}}"
                    :default-ingredient-step="{{ json_encode($ingredientStep)}}"
                    :default-ingredient-items="{{ json_encode($lines)}}"
                    :default-ingredient-steps="{{ json_encode($ingredientSteps)}}"
                    :oprn-class="{{ json_encode($oprnClass) }}"
                    :items="{{ json_encode($items) }}"
                    :formula-status="{{ json_encode($formulaStatus) }}"
                    :wip-step-headers="{{ json_encode($wipStepHeaders) }}"
                    :url-save="{{ json_encode(route('pm.settings.production-formula.update', $header->recipe_id)) }}"
                    :url-reset="{{ json_encode(route('pm.settings.production-formula.index')) }}"
                    :formula-types="{{ json_encode($formulaTypes) }}"
                    :trans-date="{{ json_encode(trans('date')) }}"
                    :organization-code="{{ json_encode($organizationCode) }}"
                    :years="{{ json_encode($years)}}"
                    :org-muti-wip="{{ json_encode($orgMutiWip)}}"
                    >
                </production-formula-edit>
     
                    {{-- <div class="row clearfix m-t-lg text-right">
                        <div class="col-sm-12">
                            <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> บันทึก </button>
                            <a href="{{ route('pm.settings.production-formula.index') }}" type="button" class="btn btn-sm btn-warning"> <i class="fa fa-times"></i> ยกเลิก </a>
                        </div>
                    </div> --}}
            {{-- </form> --}}
        </div>
    </div>
@endsection
