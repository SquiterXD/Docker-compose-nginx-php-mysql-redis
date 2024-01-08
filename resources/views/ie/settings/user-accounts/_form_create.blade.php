{!! Form::open(['route' => ['ie.settings.user-accounts.store'], 'method' => 'POST','id' => 'form-create-account', 'class' => 'form-horizontal']) !!}
    <div class="row m-b-sm">
        <div class="col-md-12">
            <label for="">
                <div>Code <small>(รหัส)</small> <span class="text-danger">*</span></div>
            </label>
            {!! Form::text('code', $account->code, ["class" => 'form-control input-sm', "id" => "txt_code", "autocomplete" => "off","style"=>"width:100%"]) !!}
        </div>
    </div>
    <div class="row m-b-sm">
        <div class="col-md-6">
            <label for="">
                <div>Employee Number <small>(รหัสพนักงาน)</small> <span class="text-danger">*</span></div>
            </label>
            {!! Form::text('employee_number', $account->employee_number, ["class" => 'form-control input-sm', "id" => "txt_employee_number", "autocomplete" => "off","style"=>"width:100%", 'readonly']) !!}
        </div>
        <div class="col-md-6">
            <label for="">
                <div>Employee Name <small>(ชื่อพนักงาน)</small> <span class="text-danger">*</span></div>
            </label>
            {!! Form::text('employee_name', $account->employee_name, ["class" => 'form-control input-sm', "id" => "txt_employee_name", "autocomplete" => "off","style"=>"width:100%", 'readonly']) !!}
        </div>
    </div>
    <div class="row m-b-sm">
        <div class="col-md-6">
            <label for="">
                <div>Bank Code <small>(รหัสธนาคาร)</small> <span class="text-danger">*</span></div>
            </label>
            <select name="bank_code" id="txt_bank_code" class="form-control select2 input-sm" autocomplete="off" style="width:100%">
                <option value="">-</option>
                @foreach ($bankInfos as $bank)
                    <option value="{{ $bank->bank_code }}" {{ $bank->bank_code == $account->bank_code ? 'selected' : '' }}>{{ $bank->bank_code }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6">
            <label for="">
                <div>Bank Name <small>(ชื่อธนาคาร)</small> <span class="text-danger">*</span></div>
            </label>
            <select name="bank_name" id="txt_bank_name" class="form-control select2 input-sm" autocomplete="off" style="width:100%">
                <option value="">-</option>
                @foreach ($bankInfos as $bank)
                    <option value="{{ $bank->bank }}" {{ $bank->bank == $account->bank_name ? 'selected' : '' }}>{{ $bank->bank }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row m-b-sm">
        <div class="col-md-6">
            <label for="">
                <div>Branch Number <small>(รหัสสาขา)</small> <span class="text-danger">*</span></div>
            </label>
            {!! Form::text('branch_number', $account->branch_number, ["class" => 'form-control input-sm', "id" => "txt_branch_number", "autocomplete" => "off", "style"=>"width:100%", "maxlength"=>"4"]) !!}
        </div>
        <div class="col-md-6">
            <label for="">
                <div>Branch Name <small>(สาขา)</small> <span class="text-danger">*</span></div>
            </label>
            {!! Form::text('branch_name', $account->branch_name, ["class" => 'form-control input-sm', "id" => "txt_branch_name", "autocomplete" => "off", "style"=>"width:100%"]) !!}
        </div>
    </div>
    <div class="row m-b-sm">
        <div class="col-md-6">
            <label for="">
                <div>Account Name <small>(ชื่อบัญชี)</small> <span class="text-danger">*</span></div>
            </label>
            {!! Form::text('account_name', $account->account_name, ["class" => 'form-control input-sm', "id" => "txt_account_name", "autocomplete" => "off","style"=>"width:100%"]) !!}
        </div>
        <div class="col-md-6">
            <label for="">
                <div>Account Number <small>(เลขที่บัญชี)</small> <span class="text-danger">*</span></div>
            </label>
            {!! Form::text('account_number', $account->account_number, ["class" => 'form-control input-sm', "id" => "txt_account_number", "autocomplete" => "off","style"=>"width:100%"]) !!}
        </div>
    </div>
    <div class="text-right">
        <button type="submit" class="btn btn-primary" data-loading-text="<i class='fa fa-spinner fa-spin'></i> Saving ...">
            Save
        </button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
    </div>
{!! Form::close()!!}

<script type="text/javascript">
    
    $(document).ready(function() {

        var bankInfos = jQuery.parseJSON(JSON.stringify({!! $bankInfos->toJson() !!}));

        $('#txt_bank_code').change(function() {
            let bankCode = $(this).val();
            let find = bankInfos.find((item) => {
                return item.bank_code == bankCode;
            });
            $('#txt_bank_name').val(find.bank);
        });

        $('#txt_bank_name').change(function() {
            let bankName = $(this).val();
            let find = bankInfos.find((item) => {
                return item.bank == bankName;
            });
            $('#txt_bank_code').val(find.bank_code);
        });
    });

</script>