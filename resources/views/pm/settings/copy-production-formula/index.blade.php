@extends('layouts.app')
@section('title', 'PMS0033.1')
@section('page-title')
    <x-get-page-title menu="" url="{{ $url }}" />
@stop
{{-- @section('page-title-action')
    <a href="{{ route('pm.settings.production-formula.create') }}" class="btn btn-success btn-xs">
        <i class="fa fa-plus"></i>  สร้าง
    </a>
@stop --}}

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <div class="row">
                        <div class="col-9">
                            <h3 class="no-margins"> คัดลอกสูตรมาตรฐาน </h3>
                        </div>
                        <div class="col-3">
                            {{-- <button class="btn btn-md btn-white" data-toggle="modal" data-target="#modal-search-formula">
                                <i class="fa fa-search"></i> ค้นหา
                            </button>
                            @include('pm.settings.production-formula._search_modal')
                            <a href="{{ route('pm.settings.production-formula.create') }}" class="btn btn-success">
                                <i class="fa fa-plus"></i>  สร้าง
                            </a> --}}
                        </div>
                    </div>
                </div>
                <div class="ibox-content" style="border-bottom: 0px;">
                    <search-copy-formula
                        :search_data="{{ json_encode($searchData) }}"
                        :trans_btn="{{ json_encode(trans('btn')) }}"
                        :period-year-list="{{ json_encode($periodYearList) }}"
                        :to-period-years="{{ json_encode($toPeriodYears) }}"
                    />
                </div>
                <div class="ibox-content">
                    @if ($countData)
                        
                    {{-- <a href="#" id="copy-formula-click" class="btn btn-success mb-2"> คัดลอกสูตร </a> --}}
                        @include('pm.settings.copy-production-formula._table')
                    @endif
                </div>
                



                {{-- <!-- Modal -->
                <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">คัดลอกสูตร</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body text-left">
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2 text-right"><label class="mt-2"> ปีงบประมาณ </label></div>
                                    <div class="col-md-5">
                                        <select class="form-control" id="year">
                                            @foreach ($periodYears as $periodYear)
                                                <option value="{{$periodYear->year_thai}}">{{ $periodYear->year_thai}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-warning btn-sm" data-dismiss="modal" id="close"> <i class="fa fa-times"></i> ยกเลิก</button>
                                <button class="btn btn-primary btn-sm" id="submitButton"> <i class="fa fa-save"></i> บันทึก</button>
                            </div>
                        </div>
                    </div>
                </div> --}}
                
            </div>
        </div>
    </div>

    <script type="application/javascript">
        var table;
        $(function() {
            $(document).on('click', '#copy-formula-click', function() {
                let checkedValue = []
                let checkData = false

                var to_period_year = "{{ $searchData['to_period_year'] }}"
                checkedValue.push('year=' + to_period_year)
                
                _.each($('.list-checkbox'), function(i) {
                    if($(i).prop('checked') === true){
                        checkData = true
                        checkedValue.push('value[]=' + $(i).val())
                    }
                })
                // checkedValue.push('year=' + $( "#year option:selected" ).text())
                // console.log($( "#year option:selected" ).text());
                // console.log(checkedValue.join('&'));
                // console.log(checkData);

                // --------- Approve List ---------
                _.each($('.approve-checkbox'), function(i) {
                    if($(i).prop('checked') === true){
                        checkData = true
                        checkedValue.push('approve_value[]=' + $(i).val())
                    }
                })


                if (checkData && to_period_year) {
                    location.href = '/pm/settings/copy-production-formula/copy?' + checkedValue.join('&')
                } else if(!checkData && to_period_year){
                    swal({
                        title: " กรุณาเลือกสูตรที่ต้องการคัดลอก "
                    });
                }
                else if(checkData && !to_period_year){
                    swal({
                        title: " กรุณาเลือกปีงบประมาณ"
                    });
                }else {
                    swal({
                        title: " กรุณาใส่ข้อมูลให้ครบถ้วน "
                    });
                }

                // $('#myModal').modal('show');

                // let checkedValue = []
                // _.each($('.list-checkbox'), function(i) {
                //     if($(i).prop('checked') === true){
                //         checkedValue.push('value[]=' + $(i).val())
                //     }
                // })
                // console.log(checkedValue.join('&'));
                // location.href = '/pm/settings/production-formula/copy-formula?' + checkedValue.join('&')
            });
            // $(document).on('click', '#close', function() {
            //     console.log('close myModal');
            //     $('#myModal').modal('hide');
            // });
            // $(document).on('click', '#submitButton', function() {
            //     let checkedValue = []
            //     _.each($('.list-checkbox'), function(i) {
            //         if($(i).prop('checked') === true){
            //             checkedValue.push('value[]=' + $(i).val())
            //         }
            //     })
            //     checkedValue.push('year=' + $( "#year option:selected" ).text())
            //     // console.log($( "#year option:selected" ).text());
            //     // console.log(checkedValue.join('&'));
            //     location.href = '/pm/settings/production-formula/copy-formula?' + checkedValue.join('&')
            // });

            // --------- Copy All ---------
            $(document).on('click', '#checkbox-all', function() {
                // if($(this).prop('checked')) { 
                //     $('.list-checkbox').attr('checked',true)
                // } else {
                //     $('.list-checkbox').removeAttr('checked')
                // }
                $('.list-checkbox').not(this).prop('checked', this.checked);
            });

            // --------- Approve All ---------
            $(document).on('click', '#approve-checkbox-all', function() {
                // if($(this).prop('checked')) { 
                //     $('.list-checkbox').attr('checked',true)
                // } else {
                //     $('.list-checkbox').removeAttr('checked')
                // }
                $('.approve-checkbox').not(this).prop('checked', this.checked);
            });

            $.fn.dataTable.ext.errMode = 'none';
            var urlParams = new URLSearchParams(window.location.search);
            var search = {
                machineGroup: urlParams.get("machineGroup"),
                LineMf: urlParams.get("LineMf"),
                work: urlParams.get("work"),
                machine: urlParams.get("machine"),
            }
            table = $('#production-formula-datatable').dataTable({
                ordering: false,
                searching: false,
                "serverSide": false,
                "processing": true,
                dom: '',
                // "paging": false,
                aLengthMenu: [
                    [-1],
                    ["All"]
                ],
                columns: [
                    {
                        data: '_checkbox'
                    },
                    {
                        data: '_checkbox_approve'
                    },
                    {
                        data: '_item_number'
                    },
                    {
                        data: '_item_desc'
                    },
                    {
                        data: '_f_description'
                    },
                    {
                        data: '_routing_desc'
                    },
                    {
                        data: 'version'
                    },
                    {
                        data: '_label_status'
                    },
                    {
                        data: '_oprn_desc'
                    },
                    {
                        data: '_machineGroupF'
                    },
                    {
                        data: 'period_year'
                    },
                    {
                        data: '_start_date'
                    },
                    {
                        data: '_end_date'
                    },
                    // {
                    //     data: '_action'
                    // },
                ],
                "ajax": {
                    "url": "",
                    "dataType": "json",
                    "type": "GET",
                    "data": {
                        _token: "{{ csrf_token() }}",
                        search: search,
                    }
                },
            })
        })
    </script>
@endsection
