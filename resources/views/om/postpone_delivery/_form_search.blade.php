<div class="col-xl-6 m-auto">
    <form method="get" action="{{ url('/') }}/om/postpone-delivery/search">
        <div class="form-group">
            <label class="d-block">รหัสร้านค้า</label>
            <div class="row space-5">
                <div class="col-6">
                    <div class="input-icon">
                        <input type="text" class="form-control" name="customer_number" id="customer_number" placeholder="" value="{{ (request()) ? request()->customer_number : '' }}" list="customer-list" onchange="custchange(this.value);">
                        <i class="fa fa-search"></i>
                        <datalist id="customer-list">
                            @foreach ($customers as $item)
                                @if ($item['customer_number'] != '')
                                <option value="{{ $item['customer_number'] }}">{{ $item['customer_name'] }}</option>
                                @endif
                            @endforeach
                        </datalist>
                    </div>
                </div>
                <div class="col-6">
                    <input type="text" id="customer_name" readonly name="customer_name" class="form-control" value="{{ (request()) ? request()->customer_name : '' }}">
                </div>
            </div><!--row-->
        </div><!--form-group-->

        <div class="form-group">
            <div class="row space-5">
                <div class="col-md-6">
                    <label class="d-block">ปีงบประมาณ</label>
                    <select class="custom-select select2" style="width: 100%;" id="year" name="year" data-placeholder="ปีงบประมาณ">
                        <option value="all">&nbsp;</option>
                        @foreach ($budgetYear as $item)
                        <option value="{{ $item->budget_year }}" {{ ((request() && (request()->year == $item->budget_year)) || ($periodActive->budget_year == $item->budget_year)) ? 'selected' : '' }}>{{ ($item->budget_year + 543) }}</option>
                        @endforeach
                    </select>
                    {{-- <input type="text" class="form-control" name="year" id="year" placeholder="" value="{{ (request()) ? request()->year : '' }}"> --}}
                </div>
                <div class="col-md-6">
                    <label class="d-block">งวดที่</label>
                    <select class="custom-select select2" style="width: 100%;" id="installment" name="installment" data-placeholder="">
                        <option value="all">&nbsp;</option>
                        @if ($period)
                            @foreach ($period as $item)
                            <option value="{{ $item->period_line_id }}" {{ ((request() && (request()->installment == $item->period_line_id)) || ($periodActive->period_line_id == $item->period_line_id)) ? 'selected' : '' }}>{{ ($item->period_no) }}</option>
                            @endforeach
                        @endif
                    </select>
                    {{-- <input type="text" class="form-control" name="installment" id="installment" placeholder="" value="{{ (request()) ? request()->installment : '' }}"> --}}
                </div>
            </div><!--row-->
        </div><!--form-group-->

        <div class="form-group mb-0">
            <label class="d-block">วันส่งประจำงวด</label>
                <datepicker-th
                    style="width: 100%"
                    class="form-control"
                    name="date"
                    id="date"
                    placeholder="โปรดเลือกวันที่"
                    value="{{ (request()) ? request()->date : '' }}"
                    format="{{ trans("date.js-format") }}">
        </div><!--form-group-->

        <div class="form-buttons mt-0" style="border:0">
            <button class="btn btn-lg btn-white" type="submit"><i class="fa fa-search"></i> ค้นหา</button>
        </div>
    </form>
</div><!--col-xl-6-->