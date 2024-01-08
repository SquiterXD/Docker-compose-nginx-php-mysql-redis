@extends('layouts.app')

@section('title', 'เคลมประกันภัย')

@section('page-title')
    <x-get-page-title menu="" url="{{ $fixUrl }}" />
@stop

@section('page-title-action')
    @if ($profile->program_code == 'IRP0010')
        <a href="{{ route('ir.claim-insurance.create') }}" type="button" class="btn-lg tw-w-25 {{ trans('btn.create.class') }}">
            <i class="{{ trans('btn.create.icon') }}"></i> {{ trans('btn.create.text') }}
        </a>
    @endif
@stop

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>
                        {{ $profile->program_code == 'IRP0010'? 'แจ้งเหตุการเคลมประกันภัย (Claim Insurance)': 'ข้อมูลรายละเอียดการเคลมประกันภัย (Detail Claim Insurance)' }}
                    </h5>
                </div>
                <div class="ibox-content pt-1">
                    <claim-insurance-search
                        :search="{{ json_encode($search) }}"
                        :btn-trans="{{ json_encode($btnTrans) }}"
                        :url="{{ json_encode($url) }}"
                        :profile="{{ json_encode($profile) }}"
                        >
                    </claim-insurance-search>
                    <hr>
                    @include('ir.claim-insurance._table')

                   {{--  @if ($profile->program_code == 'IRP0010')
                        <claim-index-table-irp0010
                            :claims="{{ json_encode($claims) }}"
                            :url="{{ json_encode($url) }}"
                            :profile="{{ json_encode($profile) }}"
                            :btn-trans="{{ json_encode($btnTrans) }}"
                        > </claim-index-table-irp0010>
                    @else
                        <claim-index-table-irp0011
                            :claims="{{ json_encode($claims) }}"
                            :url="{{ json_encode($url) }}"
                            :profile="{{ json_encode($profile) }}"
                            :btn-trans="{{ json_encode($btnTrans) }}"
                        > </claim-index-table-irp0011>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var dataTableClaim = $('.tb-claim');
            var loadingHtml = '<div class="sk-spinner sk-spinner-wave"> <div class="sk-rect1"></div> <div class="sk-rect2"></div> <div class="sk-rect3"></div> <div class="sk-rect4"></div> <div class="sk-rect5"></div> </div>';

            dataTableClaim.css("width","auto");
            dataTableClaim.DataTable({
                pageLength: 25,
                responsive: true,
                scrollX: true,
                dom: '<"html5buttons"B>lTfgitp',
                bFilter: false,
                aaSorting: [],
                bPaginate:true,
                bInfo: false,
                fixedHeader: true,
                columnDefs: [
                ],
                language: {
                    loadingRecords: loadingHtml,
                },
                buttons: [
                    //
                ],
            });
        });
    </script>
@stop