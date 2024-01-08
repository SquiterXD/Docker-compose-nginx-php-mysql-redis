@extends('layouts.app')
@section('title', 'PMS0030')
@section('page-title')
  <h2>PMS0030: กำหนดพื้นที่วางของ</h2>
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <a href="/">Home</a>
    </li>
    <li class="breadcrumb-item">
      <a>PM</a>
    </li>
    <li class="breadcrumb-item active">
        <a href="{{ route('pm.settings.max-storage.index') }}">กำหนดพื้นที่วางของ</a>
    </li>
  </ol>
@stop
@section('page-title-action')
    <a href="{{ route('pm.settings.max-storage.create') }}" class="btn btn-success btn-xs">
        <i class="fa fa-plus"></i>  สร้าง
    </a>
@stop


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="ibox-tools"></div>
                    <h5>กำหนดพื้นที่วางของ</h5>
                </div>
                <div class="ibox-content">
                    @include('pm.settings.max-storage._table')
                </div>
            </div>
        </div>
    </div>

    <script type="application/javascript">
        var table;
           $(function() {
                $.fn.dataTable.ext.errMode = 'none';
               var urlParams = new URLSearchParams(window.location.search);
               var search = {
                //    wipTransaction:urlParams.get("search[wipTransaction]"), 
                //    itemcat:urlParams.get("search[itemcat]"), 
                //    transaction:urlParams.get("search[transaction]"), 
               }
               table = $('#max-storage-datatable').dataTable({
                   ordering: false,
                   searching: false,
                   "serverSide": true,
                   "processing": true,
                   columns: [
                       {data: '_html_enable_flag'},
                       {data: 'item_group.item_cat_segment2_desc'},
                       {data: 'max_qty'},
                       {data: 'uom.unit_of_measure'},
                       {data: 'organization_label'},
                       {data: 'action'},
                   ],
                   "ajax": {
                       "url": "",
                       "dataType": "json",
                       "type": "GET",
                       "data": {
                           _token: "{{ csrf_token() }}",
                        //    search: search,
                       }
                   },
               })
           })
       </script>
@endsection