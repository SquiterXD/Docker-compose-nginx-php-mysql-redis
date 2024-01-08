@extends('layouts.app')
<style>
    div.dataTables_wrapper div.dataTables_length select{
        width: 75px!important;
    }

    .form-control:disabled, .form-control[readonly] {
        background-color: #e9ecef !important;
        opacity: 1 !important;
    }

    table.dataTable {
        font-size: 0.9rem;
    }

    .datepicker table {
        font-size: 0.9rem !important;
    }

    .table-responsive {
        border: unset !important;
    }

    #page-wrapper {
        width: calc(100% - 220px) !important;
    }

</style>


@section('title', 'หนี้ค้างชำระ')

@section('custom_css')
    <!-- Toastr style -->
    <link href="{!! asset('custom/custom.css') !!}" rel="stylesheet">
    <link href="{!! asset('custom/sweetalert/sweetalert2.css') !!}" rel="stylesheet">
@stop


@section('page-title')
    <x-get-page-title :menu="$menu" url="" />
    {{-- <h2>
        OMP0065 หนี้ค้างชำระ สำหรับขายต่างประเทศ
    </h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าแรก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>หนี้ค้างชำระ สำหรับขายต่างประเทศ</strong>
        </li>
    </ol> --}}
@stop

@section('content')

    <div class="ibox">
        <div class="ibox-title">
            <h3>{{ !empty($menu->menu_title) ? $menu->menu_title : '' }}</h3>
        </div>
        <div class="ibox-content">
            <div class="row space-50 justify-content-md-center flex-column mw-xl-1000 mt-md-4">
                <div class="col-xl-6 m-auto">
                    <form id="formSearchOverdueDebt" autocomplete="none" enctype="multipart/form-data">
                        <div class="form-group">
                            <h3 class="black mb-3">ค้นหารายการที่ต้องการ</h3>

                            <label class="d-block">รหัสลูกค้า</label>
                            <div class="row">
                                <div class="col-md-4">
                                    {{-- <div class="input-icon">
                                        <input type="text" class="form-control" name="customer_number" id="customer_number" placeholder="" value="" style="text-transform: uppercase;">
                                        <i class="fa fa-search"></i>
                                    </div> --}}
                                    <div class="input-icon">
                                        <input type="text" class="form-control" name="customer_number" id="customer_number" list="customer-list" value="" onchange="selectCustomer()" autocomplete="off">
                                        <i class="fa fa-search"></i>
                                        <datalist id="customer-list">

                                            <option value=""> &nbsp; </option>
                                            @foreach ($customerList as $item)
                                            @if (!empty($item->customer_number))
                                            <option value="{{ $item->customer_number }}">{{ $item->customer_name }}</option>
                                            @endif
                                            @endforeach

                                        </datalist>
                                        <i class="fa fa-search"></i>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" readonly name="customer_name" id="customer_name" placeholder="" value="">
                                </div>
                            </div><!--row-->
                        </div><!--form-group-->

                        <div class="form-group">
                            <label class="d-block">วันที่ครบกำหนดชำระ</label>
                            <div class="input-icon">
                                <input type="text" class="form-control date" name="payment_duedate" id="payment_duedate" placeholder="" value="">
                                <i class="fa fa-calendar"></i>
                            </div>
                        </div><!--form-group-->


                        <div class="form-buttons no-border">
                            <button class="btn btn-lg btn-white" type="button" id="btnSearch" onclick="searchOverdueDebt()"><i class="fa fa-search"></i> ค้นหา</button>
                        </div>
                    </form>
                </div><!--col-xl-6-->

                <div class="col-md-12">
                    <hr class="lg">

                    <div id="reloadtable">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center table-hover dataTables-example f13 min-1200" >
                                <thead>
                                    <tr class="align-middle">
                                        <th>รหัสลูกค้า</th>
                                        <th>ชื่อลูกค้า</th>
                                        <th>เลขที่ใบสั่งซื้อ</th>
                                        <th>เลขที่ใบ Sale Confirmation</th>
                                        <th>เลขที่ PI</th>
                                        <th>เลขที่ Invoice</th>
                                        <th>จำนวนวันปลอดดอก</th>
                                        <th>ยอดหนี้คงเหลือ</th>
                                        <th>ค่าปรับ</th>
                                        <th>วันครบกำหนดชำระ</th>
                                    </tr>
                                </thead>
                                <tbody id="resultOrder">
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div><!--row-->
        </div><!--ibox-content-->
    </div><!--ibox-->

@endsection

@section('scripts')
    <script src="{!! asset('custom/sweetalert/sweetalert2.all.min.js') !!}"></script>
    <!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){
        $('.date').datepicker({ format: 'dd/mm/yyyy' });
    });

    $('.dataTables-example').DataTable().clear().draw();
</script>

<script>

    let customerList        = {!! json_encode($customerList) !!};

    var table = 0;
    function searchOverdueDebt()
    {

        // var id = $('#customer_number').val();

        // if (id == '') {
        //     Swal.fire({
        //         icon: 'warning',
        //         text: 'กรุณากรอกรหัสลูกค้า',
        //         showConfirmButton: true
        //     });
        // }else{

            swal.showLoading();
            const formData = new FormData(document.getElementById("formSearchOverdueDebt"));
            formData.append('_token','{{ csrf_token() }}');

            $.ajax({
                url         : '{{ url("om/ajax/overdue-debt/search") }}',
                type        : 'post',
                data        : formData,
                cache       : false,
                processData : false,
                contentType : false,
                success     : function(res){
                    console.log(res);
                    var data = res.data;
                    var html = '';
                    var orderList = data.data;
                    if(data.status == 'success'){

                        defaultTable();

                        $.each(orderList, function(key,val){

                            html += '<tr class="align-middle">';
                            html += '    <td>'+val.customer_number+'</td>';
                            html += '    <td class="text-left">'+val.customer_name+'</td>';
                            html += '    <td>'+val.order_number+'</td>';
                            html += '    <td>'+val.prepare_order_number+'</td>';
                            html += '    <td>'+val.pi_number+'</td>';
                            html += '    <td>'+val.pick_release_no+'</td>';
                            html += '    <td>'+val.group_tag+'</td>';
                            html += '    <td>'+numberFormat(val.total_amount)+'</td>';
                            html += '    <td>'+numberFormat(val.fines)+'</td>';
                            html += '    <td>'+val.payment_duedate+'</td>';
                            html += '</tr>';

                        });

                        $('#resultOrder').html(html);

                        Swal.fire({
                            icon: 'success',
                            text: 'ค้นหารายการข้อมูลเรียบร้อยแล้ว',
                            showConfirmButton: false,
                            timer: 2500
                        });

                        if (orderList.length > 0) {

                            $('.dataTables-example').DataTable({
                                order: [ 2, "desc" ],
                                pageLength: 10,
                                responsive: true,
                            });
                        }else{
                            $('.dataTables-example').DataTable().clear().draw();
                        }
                    }else{

                        $('.dataTables-example').DataTable().clear().draw();
                        Swal.fire({
                            icon: 'warning',
                            text: 'ไม่พบที่ค้นหา',
                            showConfirmButton: true
                        });
                    }
                }
            });
        // }
    }

    function selectCustomer()
    {

        var number = $("#customer_number").val();
        numberLine = 1;

        if(number != ''){
            var itemName = '';


            $.each(customerList, function(key,val){
                if (val.customer_number == number) {
                    itemName = val.customer_name;
                }
            });

            $("#customer_name").val(itemName);

        }else{
            $('#customer_name').val('');
        }
    }

    function numberFormat(nStr)
    {
        nStr = $.trim(nStr) != '' ? nStr : 0;
        nStr = parseFloat(nStr).toFixed(2);
        nStr = Math.round(nStr * 1000) / 1000;
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '.00';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }

        x2 = x2.length == 2 ? x2.toString()+'0' : x2;
        return x1 + x2;
    }

    function defaultTable()
    {
        var html = '';

        html += '<div class="table-responsive">';
        html += '    <table class="table table-bordered text-center table-hover dataTables-example f13 min-1200" >';
        html += '        <thead>';
        html += '            <tr class="align-middle">';
        html += '                <th>รหัสลูกค้า</th>';
        html += '                <th>ชื่อลูกค้า</th>';
        html += '                <th>เลขที่ใบสั่งซื้อ</th>';
        html += '                <th>เลขที่ใบ Sale Confirmation</th>';
        html += '                <th>เลขที่ PI</th>';
        html += '                <th>เลขที่ Invoice</th>';
        html += '                <th>จำนวนวันปลอดดอก</th>';
        html += '                <th>ยอดหนี้คงเหลือ</th>';
        html += '                <th>ค่าปรับ</th>';
        html += '                <th>วันครบกำหนดชำระ</th>';
        html += '            </tr>';
        html += '        </thead>';
        html += '        <tbody id="resultOrder">';
        html += '        </tbody>';
        html += '    </table>';
        html += '</div>';

        $('#reloadtable').html(html);
    }

</script>
@stop
