@extends('layouts.app')
@section('title', 'PMS0033')
@section('page-title')
    <x-get-page-title menu="" url="{{ $url }}" />
@stop

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox">
        @php
          $formulaType = $header->FormulaType ? $header->FormulaType->description : '';
        @endphp
          
        <production-formula-show 
        :header="{{ json_encode($header) }}"
        :url-inactive="{{ json_encode(route('pm.settings.production-formula.inactive', $header->recipe_id)) }}"
        :url-active="{{ json_encode(route('pm.settings.production-formula.active', $header->recipe_id)) }}"
        :url-approve="{{ json_encode(route('pm.settings.production-formula.approve', $header->recipe_id)) }}"
        :btn-trans="{{ json_encode($btnTrans) }}"
        :wip-steps="{{ json_encode($wipSteps) }}"
        :formula-type="{{ json_encode($formulaType) }}"
        inline-template>
        
            <div class="ibox-title" align="right">
              <div class="modal" id="modal-confirm-date" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-body" style="text-align: left">
                      <label for="">วันที่เริ่มใช้งาน</label>
                        <ct-datepicker
                          class="my-1 col-sm-12 form-control"
                          style="width: 200px"
                          :value="_fm_date"
                          placeholder="โปรดเลือกวันที่เริ่มใช้งาน"
                          @change="getValueTransactionDate"
                        />
                    </div>
                    <div class="modal-footer">
                      <button @click="approveSubmit()" type="button" class="btn btn-primary">บันทึก</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        ยกเลิก
                      </button>
                    </div>
                  </div>
                </div>
              </div> 
              {{-- {{ ($header->invoice_flag == 'Y') ? 'disabled' : '' }} --}}
              <a href="#"  data-toggle="modal" data-target="#copy_{{ $header->recipe_id }}" title="Edit" class="btn btn-success btn-xs">
                คัดลอกสูตร
              </a>
              @include('pm.settings.production-formula._modal_copy_new')
              @if ($header->status == 'New')
              <a @click="approve()" href="#" class="btn btn-success btn-xs {{ ($header->invoice_flag == 'Y') ? 'disabled' : '' }}">
                  อนุมัติสูตร
                </a>
              @endif
              @if ($header->status != 'Obsolete/Archived')
                <a @click="inactive()" type="button" class="btn btn-warning btn-xs {{ ($header->invoice_flag == 'Y') ? 'disabled' : '' }}" href="#">
                  ยกเลิกสูตร
                </a>
              @endif
              @if ($header->status == 'Obsolete/Archived')
              <a @click="active()" type="button" class="btn btn-success btn-xs {{ ($header->invoice_flag == 'Y') ? 'disabled' : '' }}" href="#">
                  เปิดใช้งานสูตร
                </a>
              @endif
              <a href="{{ route('pm.settings.production-formula.index') }}" class="btn btn-danger btn-xs">
                ย้อนกลับ
              </a>
            </div>
        </production-formula-show>
        <div class="ibox-content">
          @php
            if ($header->organization->organization_code == 'M05') {
              $machine = $header->machineGroupF  ? $header->machineGroupF->description : '';
            }else {
              $machine = $header->machineType  ? $header->machineType->description : '';
            }

            $uomName = $header->uomHeader ? $header->uomHeader->from_unit_of_measure : '';
            $wipStep = $header->opmRouting ? $header->opmRouting->oprn_desc : '';
            // $formulaType = $header->FormulaType ? $header->FormulaType->description : '';
          @endphp
          @if ($wipStep || $organizationCode == 'MPG' || $organizationCode == 'M12' || $organizationCode == 'M06')
            @include('pm.settings.production-formula._ingradient_new')
            @include('pm.settings.production-formula._ingradient_item_new')
          @else 
            <production-formula-show-content
              :header="{{ json_encode($header) }}"
              :wip-steps="{{ json_encode($wipSteps) }}"
              :user-name="{{ json_encode($header->user ? $header->user->user_name : '') }}"
              :start-date="{{ json_encode(parseToDateTh($header->start_date)) }}"
              :end-date="{{ json_encode(parseToDateTh($header->end_date)) }}"
              :machine="{{ json_encode($machine) }}"
              :uom-name="{{ json_encode($uomName) }}"
              :wip-step="{{ json_encode($wipStep) }}"
              :lines="{{ json_encode($lines) }}"
              :oprns="{{ json_encode($oprns) }}"
              :items="{{ json_encode($itemAlls) }}"
              :formula-type="{{ json_encode($formulaType) }}">
            </production-formula-show-content> 
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection