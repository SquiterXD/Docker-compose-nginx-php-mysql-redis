@extends('layouts.app')

@section('title', 'ประมาณการค่าใช้จ่ายล่วงเวลาประจำปักษ์')

@section('page-title')
    <h2> <x-get-program-code url="/planning/overtimes-plan"/>: ประมาณการค่าใช้จ่ายล่วงเวลาประจำปักษ์</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a>ประมาณการผลิตประจำปักษ์</a>
        </li>
        <li class="breadcrumb-item active">
            <a>ประมาณการค่าใช้จ่ายล่วงเวลาประจำปักษ์</a>
        </li>
    </ol>
@stop
@section('page-title-action')
    <planning-overtimes-plan-create
        :working-hour="{{ json_encode($workingHour) }}"
        :working-holiday="{{ json_encode($workingHoliday) }}"
        :product-types="{{ json_encode($productTypes) }}"
        :default-input="{{ json_encode($defaultInput) }}"
        :search-input="{{ json_encode($searchInput) }}"
        :budget-years="{{ json_encode($budgetYears) }}"
        :bi-weekly-details="{{ json_encode($biWeeklyDetails) }}"
        date-format="{{ trans('date.format-month-pp') }}"
        :btn-trans="{{ json_encode($btnTrans) }}"
        :url="{{ json_encode($url) }}"
    >
    </planning-overtimes-plan-create>
@stop


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content pt-1">
                    <planning-overtimes-plan
                        :search="{{ json_encode($search) }}"
                        :ot-main="{{ json_encode($otMain) }}"
                        :working-hour="{{ json_encode($workingHour) }}"
                        :working-holiday="{{ json_encode($workingHoliday) }}"
                        :product-types="{{ json_encode($productTypes) }}"
                        :default-input="{{ json_encode($defaultInput) }}"
                        :search-input="{{ json_encode($searchInput) }}"
                        :budget-years="{{ json_encode($budgetYears) }}"
                        :bi-weekly-details="{{ json_encode($biWeeklyDetails) }}"
                        date-format="{{ trans('date.format-month-pp') }}"
                        :btn-trans="{{ json_encode($btnTrans) }}"
                        :url="{{ json_encode($url) }}"
                        :departments="{{ json_encode($departments) }}"
                        :date-arr="{{ json_encode($dateArr) }}"
                        :color-code="{{ json_encode($colorCode) }}"
                        :dept-reports="{{ json_encode($deptReports) }}"
                    >
                    </planning-overtimes-plan>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
    </script>
@stop