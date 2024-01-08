@extends('layouts.app')

@section('title', 'Product Group By Sub-Inventory')

{{-- @section('page-title')
    <h2><x-get-program-code url="/ir/settings/product-header" />: ข้อมูลกลุ่มสินค้าแยกตามคลังสินค้า</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">Home</a>
        </li>
        <li class="breadcrumb-item">
            <a>IR</a>
        </li>
        <li class="breadcrumb-item">
            <a>Settings</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('ir.settings.product-header.index') }}"><x-get-program-code url="/ir/settings/product-header" />: ข้อมูลกลุ่มสินค้าแยกตามคลังสินค้า</a>
        </li>
        <li class="breadcrumb-item">
            <strong>แก้ไข</strong>
        </li>
    </ol>
@stop --}}

@section('page-title')
  <x-get-page-title menu="" url="/ir/settings/product-header" />
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                        <div class="row col-lg-10 col-md-4">
                            <label class="col-lg-3 col-md-6 col-form-label text-left" style="padding-top: 20px;">
                            <strong> กรมธรรม์ชุดที่ (Policy No.) : </strong>
                            </label>
                                <div class='col-lg-7 col-md-7 w-100' style="padding-top: 6px; padding-top: 20px;">
                                    {{ ($header->groupProduct ? $header->groupProduct->policySetHeader : '') ? $header->groupProduct->policySetHeader['policy_set_number'].' : '.$header->groupProduct->policySetHeader['policy_set_description'] : ' ' }} 
                                </div>
                        </div>

                        <div class="row col-lg-10 col-md-4">
                            <label class="col-lg-3 col-md-6 col-form-label text-left" style="padding-top: 20px;">
                            <strong> กลุ่มของทรัพย์สิน : </strong>
                            </label>
                                <div class='col-lg-7 col-md-7 w-100' style="padding-top: 6px; padding-top: 20px;">
                                    {{ ($header->groupProduct ? $header->groupProduct->assetGroup : '') ? $header->groupProduct->assetGroup['description'] : '' }} 
                                </div>
                        </div>

                        <div class="row col-lg-10 col-md-4">
                            <label class="col-lg-3 col-md-6 col-form-label text-left" style="padding-top: 20px;">
                            <strong> รายการ : </strong>
                            </label>
                                <div class='col-lg-7 col-md-7 w-100' style="padding-top: 6px; padding-top: 20px;">
                                    {{ $header->groupProduct ? $header->groupProduct['description'] : ' ' }} 
                                </div>
                        </div>

                        <div class="row col-lg-10 col-md-4">
                            <label class="col-lg-3 col-md-6 col-form-label text-left" style="padding-top: 20px;">
                            <strong> ประเภทค่าใช้จ่าย : </strong>
                            </label>
                                <div class='col-lg-7 col-md-7 w-100' style="padding-top: 6px; padding-top: 20px;">
                                    {{ ($header->groupProduct ? $header->groupProduct->accountsMapping : '') ? $header->groupProduct->accountsMapping['account_code']. " : " .$header->groupProduct->accountsMapping['description'] : '' }}
                                </div>
                        </div>

                        <div class="row col-lg-10 col-md-4">
                            <label class="col-lg-3 col-md-6 col-form-label text-left" style="padding-top: 20px;">
                            <strong> รหัสบัญชี : </strong>
                            </label>
                                <div class='col-lg-7 col-md-7 w-100' style="padding-top: 6px; padding-top: 20px;">
                                    {{ ($header->groupProduct ? $header->groupProduct->accountsMapping : '') ? $header->groupProduct->accountsMapping['account_combine'] : ' ' }} 
                                </div>
                        </div>

                        <div class="row col-lg-10 col-md-4">
                            <label class="col-lg-3 col-md-6 col-form-label text-left" style="padding-top: 20px;">
                            <strong> รหัสหน่วยงาน : </strong>
                            </label>
                                <div class='col-lg-7 col-md-7 w-100' style="padding-top: 6px; padding-top: 20px;">
                                    {{ $header->department ? $header->department->department_code. ' : ' .$header->department->description : '' }} 
                                </div>
                        </div>

                        <div class="row col-lg-10 col-md-4">
                            <label class="col-lg-3 col-md-6 col-form-label text-left" style="padding-top: 20px;">
                            <strong> รหัสคลังสินค้า : </strong>
                            </label>
                                <div class='col-lg-7 col-md-7 w-100' style="padding-top: 6px; padding-top: 20px;">
                                    {{ $header->subInventory ? $header->subInventory->subinventory_code. ' : ' .$header->subInventory->subinventory_desc : '' }} 
                                </div>
                        </div>

                        <div class="row col-lg-10 col-md-4">
                            <label class="col-lg-3 col-md-6 col-form-label text-left" style="padding-top: 20px;">
                            <strong> กลุ่มสินค้าย่อย : </strong>
                            </label>
                                <div class='col-lg-7 col-md-7 w-100' style="padding-top: 6px; padding-top: 20px;">
                                    {{-- {{ $header->subGroups ? $header->subGroups->sub_group_code. " : " .$header->subGroups->sub_group_description : '' }}  --}}
                                    {{ $header ? $header->sub_group_code. " : " .$header->sub_group_desc : '' }}
                                </div>
                        </div>

                    {!! Form::open(['route' => ['ir.settings.product-header.update'] , "method" => "put" , "autocomplete" => "off", 'class' => 'form-horizontal']) !!}
                    
                        <product-inv-edit-componies :header = "{{ json_encode($header) }}"
                                                    :back-url = "{{ json_encode(route('ir.settings.product-header.index')) }}"
                                                    :item-locators = "{{ json_encode($itemLocators) }}"
                                                    :item-categories = "{{ json_encode($itemCategories) }}"
                                                    :data = "{{ json_encode(request()->data) }}"
                                                    :btn-trans = "{{ json_encode($btnTrans) }}">
                        </product-inv-edit-componies>

                    {{-- <div class="row clearfix text-right">
                        <div class="col" style="margin-top: 15px;">
                            <button class="btn btn-success" type="submit"> 
                                <i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก 
                            </button>
                            <a href="{{ route('ir.settings.product-header.index') }}" type="button" class="btn btn-danger">
                                <i class="fa fa-times" aria-hidden="true"></i> ยกเลิก
                            </a>
                        </div>
                    </div> --}}

                    {!! Form::close() !!}
                    
                </div>
            </div>
        </div>
    </div>
@endsection