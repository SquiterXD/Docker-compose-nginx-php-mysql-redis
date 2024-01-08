<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">กรุณาเลือกบัญชี</h4>
        </div>
        <div class="modal-body">
            <div>
                <div class="form-group row">
                    <label for="company_code" class="col-sm-4 col-form-label">Company Code</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags sel-debit" style="width: 100%;" name="company_code" id="company_code">
                            @foreach ($segment['company'] as $item)
                            <option value="{{ $item->company_code }}" data-value="{{ $item->description }}" {{ $accont_gl->segment1 == $item->company_code? 'selected' : '' }}>{{ $item->company_code }} - {{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="evm" class="col-sm-4 col-form-label">EVM</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags sel-debit" style="width: 100%;" name="evm" id="evm">
                            @foreach ($segment['evm'] as $item)
                            <option value="{{ $item->evm_code }}" data-value="{{ $item->description }}" {{ $accont_gl->segment2 == $item->evm_code? 'selected' : '' }}>{{ $item->evm_code }} - {{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Department Code</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags sel-debit" style="width: 100%;" name="department_code" id="department_code">
                            @foreach ($segment['dept'] as $item)
                            <option value="{{ $item->department_code }}" data-value="{{ $item->description }}" {{ $accont_gl->segment3 == $item->department_code? 'selected' : '' }}>{{ $item->department_code }} - {{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Cost Center</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags sel-debit" style="width: 100%;" name="cost_center" id="cost_center">
                            {{-- @foreach ($segment['costCenter'] as $item)
                            <option value="{{ $item->cost_center_code }}">{{ $item->cost_center_code }} - {{ $item->description }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Budget Year</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags sel-debit" style="width: 100%;" id="budget_year" name="budget_year">
                            @foreach ($segment['budgetYear'] as $item)
                            <option value="{{ $item->budget_year }}" data-value="{{ $item->description }}" {{ $accont_gl->segment5 == $item->budget_year? 'selected' : '' }}>{{ $item->budget_year }} - {{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Budget Type</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags sel-debit" style="width: 100%;" id="budget_type" name="budget_type">
                            @foreach ($segment['budgetType'] as $item)
                            <option value="{{ $item->budget_type }}" data-value="{{ $item->description }}" {{ $accont_gl->segment6 == $item->budget_type? 'selected' : '' }}>{{ $item->budget_type }} - {{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Budget Detail</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags sel-debit" style="width: 100%;" id="budget_detail" name="budget_detail">
                            {{-- @foreach ($segment['budgetDetail'] as $item)
                            <option value="{{ $item->budget_detail }}">{{ $item->budget_detail }} - {{ $item->description }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Budget Reason</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags sel-debit" style="width: 100%;" id="budget_reason" name="budget_reason">
                            @foreach ($segment['budgetReason'] as $item)
                            <option value="{{ $item->budget_reason }}" data-value="{{ $item->description }}" {{ $accont_gl->segment8 == $item->budget_reason? 'selected' : '' }}>{{ $item->budget_reason }} - {{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Main Account</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags sel-debit" style="width: 100%;" id="main_account" name="main_account">
                            @foreach ($segment['mainAccount'] as $item)
                            <option value="{{ $item->main_account }}" data-value="{{ $item->description }}" {{ $accont_gl->segment9 == $item->main_account? 'selected' : '' }}>{{ $item->main_account }} - {{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Sub Account</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags sel-debit" style="width: 100%;" id="sub_account" name="sub_account">
                            {{-- @foreach ($segment['subAccount'] as $item)
                            <option value="{{ $item->sub_account }}">{{ $item->sub_account }} - {{ $item->description }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Reserved1</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags sel-debit" style="width: 100%;" id="reserved1" name="reserved1">
                            @foreach ($segment['reserved1'] as $item)
                            <option value="{{ $item->reserved1 }}" data-value="{{ $item->description }}" {{ $accont_gl->segment11 == $item->reserved1? 'selected' : '' }}>{{ $item->reserved1 }} - {{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Reserved2</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags sel-debit" style="width: 100%;" id="reserved2" name="reserved2">
                            @foreach ($segment['reserved2'] as $item)
                            <option value="{{ $item->reserved2 }}" data-value="{{ $item->description }}"  {{ $accont_gl->segment12 == $item->reserved2? 'selected' : '' }}>{{ $item->reserved2 }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" onclick="SaveChoseDedit();">บันทึก</button>
        </div>
      </div>

    </div>
</div>


<!-- Modal -->
<div id="modalCreditNote" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">กรุณาเลือกบัญชี</h4>
        </div>
        <div class="modal-body">
            <div>
                <div class="form-group row">
                    <label for="cr_company_code" class="col-sm-4 col-form-label">Company Code</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags sel-credit" style="width: 100%;" name="cr_company_code" id="cr_company_code">
                            @foreach ($segment['company'] as $item)
                            <option value="{{ $item->company_code }}" data-value="{{ $item->description }}" {{ $accont_cr_gl->segment1 == $item->company_code? 'selected' : '' }}>{{ $item->company_code }} - {{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="cr_evm" class="col-sm-4 col-form-label">EVM</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags sel-credit" style="width: 100%;" name="cr_evm" id="cr_evm">
                            @foreach ($segment['evm'] as $item)
                            <option value="{{ $item->evm_code }}" data-value="{{ $item->description }}" {{ $accont_cr_gl->segment2 == $item->evm_code? 'selected' : '' }}>{{ $item->evm_code }} - {{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Department Code</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags sel-credit" style="width: 100%;" name="cr_department_code" id="cr_department_code">
                            @foreach ($segment['dept'] as $item)
                            <option value="{{ $item->department_code }}" data-value="{{ $item->description }}" {{ $accont_cr_gl->segment3 == $item->department_code? 'selected' : '' }}>{{ $item->department_code }} - {{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Cost Center</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags sel-credit" style="width: 100%;" name="cr_cost_center" id="cr_cost_center">
                            {{-- @foreach ($segment['costCenter'] as $item)
                            <option value="{{ $item->cost_center_code }}">{{ $item->cost_center_code }} - {{ $item->description }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Budget Year</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags sel-credit" style="width: 100%;" id="cr_budget_year" name="cr_budget_year">
                            @foreach ($segment['budgetYear'] as $item)
                            <option value="{{ $item->budget_year }}" data-value="{{ $item->description }}" {{ $accont_cr_gl->segment5 == $item->budget_year? 'selected' : '' }}>{{ $item->budget_year }} - {{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Budget Type</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags sel-credit" style="width: 100%;" id="cr_budget_type" name="cr_budget_type">
                            @foreach ($segment['budgetType'] as $item)
                            <option value="{{ $item->budget_type }}" data-value="{{ $item->description }}" {{ $accont_cr_gl->segment6 == $item->budget_type? 'selected' : '' }}>{{ $item->budget_type }} - {{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Budget Detail</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags sel-credit" style="width: 100%;" id="cr_budget_detail" name="cr_budget_detail">
                            {{-- @foreach ($segment['budgetDetail'] as $item)
                            <option value="{{ $item->budget_detail }}">{{ $item->budget_detail }} - {{ $item->description }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Budget Reason</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags sel-credit" style="width: 100%;" id="cr_budget_reason" name="cr_budget_reason">
                            @foreach ($segment['budgetReason'] as $item)
                            <option value="{{ $item->budget_reason }}" data-value="{{ $item->description }}" {{ $accont_cr_gl->segment8 == $item->budget_reason? 'selected' : '' }}>{{ $item->budget_reason }} - {{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Main Account</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags sel-credit" style="width: 100%;" id="cr_main_account" name="cr_main_account">
                            @foreach ($segment['mainAccount'] as $item)
                            <option value="{{ $item->main_account }}" data-value="{{ $item->description }}" {{ $accont_cr_gl->segment9 == $item->main_account? 'selected' : '' }}>{{ $item->main_account }} - {{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Sub Account</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags sel-credit" style="width: 100%;" id="cr_sub_account" name="cr_sub_account">
                            {{-- @foreach ($segment['subAccount'] as $item)
                            <option value="{{ $item->sub_account }}">{{ $item->sub_account }} - {{ $item->description }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Reserved1</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags sel-credit" style="width: 100%;" id="cr_reserved1" name="cr_reserved1">
                            @foreach ($segment['reserved1'] as $item)
                            <option value="{{ $item->reserved1 }}" data-value="{{ $item->description }}" {{ $accont_cr_gl->segment11 == $item->reserved1? 'selected' : '' }}>{{ $item->reserved1 }} - {{ $item->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-4 col-form-label">Reserved2</label>
                    <div class="col-sm-8">
                        <select class="form-control select2-tags sel-credit" style="width: 100%;" id="cr_reserved2" name="cr_reserved2">
                            @foreach ($segment['reserved2'] as $item)
                            <option value="{{ $item->reserved2 }}" data-value="{{ $item->description }}" {{ $accont_cr_gl->segment12 == $item->reserved2? 'selected' : '' }}>{{ $item->reserved2 }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" onclick="SaveChoseCredit();">บันทึก</button>
        </div>
      </div>

    </div>
</div>

