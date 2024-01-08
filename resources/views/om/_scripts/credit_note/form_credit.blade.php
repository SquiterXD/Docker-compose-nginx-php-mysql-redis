<!-- Modal -->
<div id="modalCreditNote" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Modal Header</h4>
        </div>
        <div class="modal-body">
            <div>
                <div class="form-group row">
                    <label for="company_code" class="col-sm-4 col-form-label">Company Code</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags" style="width: 100%;" name="company_code" id="company_code">
                            @foreach ($segment['company'] as $item)
                            <option value="{{ $item->company_code }}">{{ $item->company_code }} - {{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="evm" class="col-sm-4 col-form-label">EVM</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags" style="width: 100%;" name="evm" id="evm">
                            @foreach ($segment['evm'] as $item)
                            <option value="{{ $item->evm_code }}">{{ $item->evm_code }} - {{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Department Code</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags" style="width: 100%;" name="department_code" id="department_code">
                            @foreach ($segment['dept'] as $item)
                            <option value="{{ $item->department_code }}">{{ $item->department_code }} - {{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Cost Center</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags" style="width: 100%;" name="cost_center" id="cost_center">
                            {{-- @foreach ($segment['costCenter'] as $item)
                            <option value="{{ $item->cost_center_code }}">{{ $item->cost_center_code }} - {{ $item->description }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Budget Year</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags" style="width: 100%;">
                            @foreach ($segment['budgetYear'] as $item)
                            <option value="{{ $item->budget_year }}">{{ $item->budget_year }} - {{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Budget Type</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags" style="width: 100%;" id="budget_type" name="budget_type">
                            @foreach ($segment['budgetType'] as $item)
                            <option value="{{ $item->budget_type }}">{{ $item->budget_type }} - {{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Budget Detail</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags" style="width: 100%;" id="budget_detail" name="budget_detail">
                            {{-- @foreach ($segment['budgetDetail'] as $item)
                            <option value="{{ $item->budget_detail }}">{{ $item->budget_detail }} - {{ $item->description }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Budget Reason</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags" style="width: 100%;">
                            @foreach ($segment['budgetReason'] as $item)
                            <option value="{{ $item->budget_reason }}">{{ $item->budget_reason }} - {{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Main Account</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags" style="width: 100%;" id="main_account" name="main_account">
                            @foreach ($segment['mainAccount'] as $item)
                            <option value="{{ $item->main_account }}">{{ $item->main_account }} - {{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Sub Account</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags" style="width: 100%;" id="sub_account" name="sub_account">
                            {{-- @foreach ($segment['subAccount'] as $item)
                            <option value="{{ $item->sub_account }}">{{ $item->sub_account }} - {{ $item->description }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Reserved1</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags" style="width: 100%;">
                            @foreach ($segment['reserved1'] as $item)
                            <option value="{{ $item->reserved1 }}">{{ $item->reserved1 }} - {{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Reserved2</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags" style="width: 100%;">
                            @foreach ($segment['reserved2'] as $item)
                            <option value="{{ $item->reserved2 }}">{{ $item->reserved2 }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" onclick="SaveChoseCredit()">save</button>
        </div>
      </div>

    </div>
</div>

