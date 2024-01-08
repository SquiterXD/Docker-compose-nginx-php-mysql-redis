@extends('layouts.app')

@section('title', 'อนุมัติแบบฟอร์มการขออนุมัติสั่งซื้อกรณีพิเศษ')

@section('page-title')
    <h2>อนุมัติแบบฟอร์มการขออนุมัติสั่งซื้อกรณีพิเศษ</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>อนุมัติแบบฟอร์มการขออนุมัติสั่งซื้อกรณีพิเศษ</strong>
        </li>
    </ol>
@stop

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="ibox">
        <div class="ibox-title">
            <h3>อนุมัติแบบฟอร์มการขออนุมัติสั่งซื้อกรณีพิเศษ</h3>
        </div>
        <div class="ibox-content">
            <form method="get" autocomplete="off">
            <div class="row space-50 justify-content-md-center flex-column mw-xl-1000 mt-md-4"><!--justify-content-md-center-->

                <div class="col-xl-6 m-auto">

                    <div class="form-group">
                        <h3 class="black mb-3">ค้นหารายการที่ต้องการ</h3>
                        <label class="d-block">รหัสร้านค้า</label>
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
                    </div><!--form-group-->

                    <div class="form-group">
                        <label class="d-block">ชื่อร้านค้า</label>
                        <input type="text" class="form-control" readonly name="customer_name" id="customer_name" placeholder="" value="{{ (request()) ? request()->customer_name : '' }}">
                    </div><!--form-group-->

                    <div class="form-group">
                        <label class="d-block">งวดวันที่</label>
                        <div class="input-icon">
                            <input type="text" class="form-control date" id="period_date" name="period_date" placeholder="" value="{{ (request()) ? request()->period_date : '' }}">
                            <i class="fa fa-calendar"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="d-block">สถานะ</label>
                        <select class="custom-select" name="approve_status" id="approve_status">
                            <option value=""></option>
                            <option value="รอการอนุมัติ" {{ (request() && request()->approve_status == 'รอการอนุมัติ') ? 'selected' : '' }}>รอการอนุมัติ</option>
                            <option value="อนุมัติ" {{ (request() && request()->approve_status == 'อนุมัติ') ? 'selected' : '' }}>อนุมัติ</option>
                            <option value="ไม่อนุมัติ" {{ (request() && request()->approve_status == 'ไม่อนุมัติ') ? 'selected' : '' }}>ไม่อนุมัติ</option>
                        </select>
                    </div>

                    <div class="form-buttons no-border">
                        <button class="btn btn-lg btn-white" type="submit"><i class="fa fa-search"></i> ค้นหา</button>
                    </div>
                </div><!--col-xl-6-->

                <div class="col-xl-10 m-auto">
                     <hr class="lg">

                    <div class="table-responsive-md">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr class="align-middle text-center">
                                    <th style="width: 150px">สถานะ</th>
                                    <th>รายละเอียด</th>
                                    <th style="width: 170px">แบบฟอร์มขออนุมัติ<br>กรณีพิเศษ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($follows as $item)
                                <tr>
                                    <td>{{ $item['approve_status'] }}</td>
                                    <td class="text-left">
                                        รหัสลูกค้า : &lt;{{ $item['customer_number'] }}&gt; {{ $item['customer_name'] }}<br>
                                        วันที่แจ้งขออนุมัติการสั่งซื้อบุหรี่ กรณีพิเศษ : {{ FormatDate::DateThai($item['creation_date']) }}<br>
                                        สั่งซื้อบุหรี่ กรณีพิเศษ (วันที่/งวด) : {{ FormatDate::DateThai($item['to_period_date']) }}<br>
                                    </td>
                                    <td><a class="fa fa-print p-3 f20" href="{{ url('om/form-order/show/'.$item['form_header_id']) }}"></a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div><!--table-responsive-md-->
                </div><!--col-xl-12-->
            </div><!--row-->
            </form>
        </div><!--ibox-content-->
    </div><!--ibox-->


</div>
@endsection

@section('scripts')
<script src="{!! asset('js/lodash.js') !!}" type="text/javascript"></script>

<script>
    let customerlists = {!! json_encode($customers) !!};

    $(document).ready(function(){
        $('.date').datepicker();
    });

    function custchange(v){
        if(v != ''){
            var index = _.findIndex(customerlists, function(o) {return o['customer_number'] == v;});
            if(index != -1){
                $('#customer_name').val(customerlists[index]['customer_name']);
            }
        }else{
            $('#customer_name').val('');
        }
    }
</script>
@endsection
