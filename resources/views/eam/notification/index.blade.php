@extends('layouts.app')

@section('title', 'Main page')

@section('content')
<div id="notification" class="ibox">
    <div class="ibox-content">
        <div class="tabs-container">
            <ul class="nav nav-tabs" role="tablist">
                <li>
                    <a  class="nav-link active" 
                        data-toggle="tab" 
                        href="#tab-1"
                        id="tab1"> 
                        แผนซ่อมบำรุง
                        <span class="dot">
                            <div style="text-align: center; 
                                        padding-top: 6px;
                                        color: #FFFFFF;">
                                {{ $lengthDataMaintenancePending }}
                            </div>
                        </span>
                    </a>
                </li>
                <li>
                    <a  class="nav-link" 
                        data-toggle="tab" 
                        href="#tab-2"
                        id="tab2"> 
                        เปิดงานซ่อม
                        <span class="dot">
                            <div style="text-align: center; 
                                        padding-top: 6px;
                                        color: #FFFFFF;">
                                {{ $lengthDataOpenJobPending }}
                            </div>
                        </span>
                    </a>
                </li>
                <li>
                    <a  class="nav-link" 
                        data-toggle="tab" 
                        href="#tab-3"
                        id="tab3"> 
                        ปิดงานซ่อม
                        <span class="dot">
                            <div style="text-align: center; 
                                        padding-top: 6px;
                                        color: #FFFFFF;">
                                {{ $lengthDataCloseJobPending }}
                            </div>
                        </span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" id="tab-1" class="tab-pane active">
                    <section class="tab">
                        <nav style="padding-top: 5px;">
                            <a href="#maintenancePending" class="active"> รอดำเนินการ </a>
                            <a href="#maintenanceSucceed"> สำเร็จ </a>
                        </nav>
                    </section>

                    <section class="tab animated fadeInRight" id="maintenancePending">
                        <nav>
                            <a href="#maintenancePending" class="active"> รอดำเนินการ </a>
                            <a href="#maintenanceSucceed"> สำเร็จ </a>
                        </nav>
                        <div class="row" style="padding-top: 10px;">
                            <div class="col-6 form-group">
                                <label> ปีงบประมาณ </label>
                                <div>
                                    <select id="yearPlan" 
                                            class="form-control" 
                                            required
                                            style="width: 100% !important;"></select>
                                </div>
                            </div>
                            <div class="col-6 form-group">
                                <label> Version </label>
                                <div>
                                    <select id="versionPlan" 
                                            class="form-control" 
                                            disabled 
                                            style="width: 100% !important;"></select>
                                </div>
                            </div>                            
                        </div>
                        <div class="row" style="padding-top: 5px;">
                            <div class="col-6 form-group">
                                <label> วันที่เริ่มซ่อม </label>
                                <div>
                                    <datepicker-th
                                        style="width: 100%"
                                        class="form-control md:tw-mb-0 tw-mb-2"
                                        name="input_date"
                                        id="scheduledStartDate"
                                        placeholder="โปรดเลือกวันที่"
                                        value="{{ old("input_date") }}"
                                        format="{{ trans("date.js-format") }}">
                                </div>
                            </div>
                            <div class="col-6 form-group">
                                <label> วันที่ซ่อมเสร็จ </label>
                                <div>
                                    <datepicker-th
                                        style="width: 100%"
                                        class="form-control md:tw-mb-0 tw-mb-2"
                                        name="input_date"
                                        id="scheduledCompletionDate"
                                        placeholder="โปรดเลือกวันที่"
                                        value="{{ old("input_date") }}"
                                        format="{{ trans("date.js-format") }}">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="padding-top: 5px;">
                            <div class="col-12 form-group">
                                <label> Asset Number </label>
                                <div>
                                    <div class="input-group">
                                        <select id="assetNumber" 
                                                class="form-control clearable readonly" 
                                                data-server="/eam/ajax/lov/assetnumber"  
                                                data-id="asset_number" 
                                                data-text="description" 
                                                data-field="select"
                                                style="width: 100% !important;">
                                        </select>
                                        <div class="input-group-append">
                                            <span class="input-group-append">
                                            <button id="assetNumberLovBtn" 
                                                    type="button" 
                                                    class="btn btn-default" >
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="col-12 form-group" style="text-align: right;">
                                <button id="searchTableMaintenancePendingBtn" 
                                        class="{{ $btnTrans['search']['class'] }}" 
                                        role="button" 
                                        aria-pressed="true">
                                    <i class="{{ $btnTrans['search']['icon'] }}"></i> 
                                    {{ $btnTrans['search']['text'] }}
                                </button>
                                <button id="undoTableMaintenancePendingBtn" 
                                        class="btn btn-danger" 
                                        role="button" 
                                        aria-pressed="true">
                                    <i class="fa fa-undo"></i> ล้างค่า
                                </button>
                            </div>                            
                        </div>
                        <div class="row">
                            <table class="table">
                                <thead>
                                <tr id="setTheadTableMaintenancePending"></tr>
                                </thead>
                                <tbody id="setTbodyTableMaintenancePending"></tbody>
                            </table>
                            <table class="float-center">
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="footable-visible" id="setTableMaintenancePendingPagination">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>                            
                        </div>                        
                    </section>

                    <section class="tab animated fadeInRight" id="maintenanceSucceed">
                        <nav>
                            <a href="#maintenancePending"> รอดำเนินการ </a>
                            <a href="#maintenanceSucceed" class="active"> สำเร็จ </a>
                        </nav>
                        <div class="row">
                            <table class="table">
                                <thead>
                                <tr id="setTheadTableMaintenanceSucceed"></tr>
                                </thead>
                                <tbody id="setTbodyTableMaintenanceSucceed"></tbody>
                            </table>
                            <table class="float-center">
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="footable-visible" id="setTableMaintenancePaginationSucceed">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>                            
                        </div>
                    </section>
                </div>

                <div role="tabpanel" id="tab-2" class="tab-pane">
                    <section class="tab">
                        <nav style="padding-top: 5px;">
                            <a href="#openJobPending" class="active"> รอดำเนินการ </a>
                            <a href="#openJobSucceed"> สำเร็จ </a>
                        </nav>
                    </section>

                    <section class="tab animated fadeInRight" id="openJobPending">
                        <nav>
                            <a href="#openJobPending" class="active"> รอดำเนินการ </a>
                            <a href="#openJobSucceed"> สำเร็จ </a>
                        </nav>
                        <div class="row" style="padding-top: 10px;">
                            <div class="col-6 form-group">
                                <label> วันที่เริ่มซ่อมตั้งแต่ </label>
                                <div>
                                    <datepicker-th
                                        style="width: 100%"
                                        class="form-control md:tw-mb-0 tw-mb-2"
                                        name="input_date"
                                        id="expectedStartDate"
                                        placeholder="โปรดเลือกวันที่"
                                        value="{{ old("input_date") }}"
                                        format="{{ trans("date.js-format") }}">
                                </div>
                            </div>
                            <div class="col-6 form-group">
                                <label> วันที่เริ่มซ่อมถึง </label>
                                <div>
                                    <datepicker-th
                                        style="width: 100%"
                                        class="form-control md:tw-mb-0 tw-mb-2"
                                        name="input_date"
                                        id="expectedCompletionDate"
                                        placeholder="โปรดเลือกวันที่"
                                        value="{{ old("input_date") }}"
                                        format="{{ trans("date.js-format") }}">
                                </div>
                            </div>
                        </div>                   
                        <div class="row" style="padding-top: 5px;">
                            <div class="col-6 form-group">
                                <label> Asset Number </label>
                                <div>
                                    <div class="input-group">
                                        <select id="assetNumberOpenJob" 
                                                class="form-control clearable readonly" 
                                                data-server="/eam/ajax/lov/assetnumber"  
                                                data-id="asset_number" 
                                                data-text="description" 
                                                data-field="select"
                                                style="width: 100% !important;">
                                        </select>
                                        <div class="input-group-append">
                                            <span class="input-group-append">
                                            <button id="assetNumberOpenJobLovBtn" 
                                                    type="button" 
                                                    class="btn btn-default" >
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 form-group">
                                <label>หน่วยงานผู้แจ้ง</label>
                                <div>
                                    <div class="input-group">
                                        <select id="reportingAgencyOpenJob" 
                                                name="owning_dept_code" 
                                                class="form-control clearable readonly" 
                                                data-server="/eam/ajax/lov/departments"
                                                data-id="department_code" 
                                                data-text="description"
                                                data-field="select"
                                                style="width: 100% !important;">
                                        </select>
                                        <div class="input-group-append">
                                            <span class="input-group-append">
                                                <button id="reportingAgencyLovBtn" 
                                                        onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานผู้แจ้ง', idDepartmentModal: 'reportingAgencyOpenJob', desc: false, inModal: false})" 
                                                        type="button" 
                                                        class="btn btn-default">
                                                        <i class="fa fa-search"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="col-12 form-group" style="text-align: right;">
                                <button id="searchTableOpenJobPendingBtn" 
                                        class="{{ $btnTrans['search']['class'] }}" 
                                        role="button" 
                                        aria-pressed="true">
                                    <i class="{{ $btnTrans['search']['icon'] }}"></i> 
                                    {{ $btnTrans['search']['text'] }}
                                </button>
                                <button id="undoTableOpenJobPendingBtn" 
                                        class="btn btn-danger" 
                                        role="button" 
                                        aria-pressed="true">
                                    <i class="fa fa-undo"></i> ล้างค่า
                                </button>
                            </div>                            
                        </div>
                        <div class="row">
                            <table class="table" style="width: 100% !important;">
                                <thead>
                                    <tr id="setTheadTableOpenJobPending"></tr>
                                </thead>
                                <tbody id="setTbodyTableOpenJobPending"></tbody>
                            </table>
                            <table class="float-center">
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="footable-visible" id="setTableOpenJobPendingPagination">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>                            
                        </div>
                    </section>

                    <section class="tab animated fadeInRight" id="openJobSucceed">
                        <nav>
                            <a href="#openJobPending"> รอดำเนินการ </a>
                            <a href="#openJobSucceed" class="active"> สำเร็จ </a>
                        </nav>
                        <div class="row">
                            <table class="table">
                                <thead>
                                <tr id="setTheadTableOpenJobSucceed"></tr>
                                </thead>
                                <tbody id="setTbodyTableOpenJobSucceed"></tbody>
                            </table>
                            <table class="float-center">
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="footable-visible" id="setTableopenJobPaginationSucceed">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>                            
                        </div>
                    </section>
                </div>
                
                <div role="tabpanel" id="tab-3" class="tab-pane">
                    <section class="tab">
                        <nav style="padding-top: 5px;">
                            <a href="#closeJobPending" class="active"> รอดำเนินการ </a>
                            <a href="#closeJobSucceed"> สำเร็จ </a>
                        </nav>
                    </section>

                    <section class="tab animated fadeInRight" id="closeJobPending">
                        <nav>
                            <a href="#closeJobPending" class="active"> รอดำเนินการ </a>
                            <a href="#closeJobSucceed"> สำเร็จ </a>
                        </nav>                                       
                        <div class="row" style="padding-top: 10px;">
                            <div class="col-4 form-group">
                                <label> Asset Number </label>
                                <div>
                                    <div class="input-group">
                                        <select id="assetNumberCloseJob" 
                                                class="form-control clearable readonly" 
                                                data-server="/eam/ajax/lov/assetnumber"  
                                                data-id="asset_number" 
                                                data-text="description" 
                                                data-field="select"
                                                style="width: 100% !important;">
                                        </select>
                                        <div class="input-group-append">
                                            <span class="input-group-append">
                                                <button id="assetNumberCloseJobLovBtn" 
                                                        type="button" 
                                                        class="btn btn-default" >
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>         
                            <div class="col-4 form-group">
                                <label> หน่วยงานรับงาน </label>
                                <div>
                                    <div class="input-group">
                                        <select id="departmentCloseJob" 
                                                class="form-control clearable readonly" 
                                                data-server="/eam/ajax/lov/departments"  
                                                data-id="department_code" 
                                                data-text="description" 
                                                data-field="select"
                                                style="width: 100% !important;">
                                        </select>
                                        <div class="input-group-append">
                                            <span class="input-group-append">
                                            <button onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานแจ้งซ่อม', idDepartmentModal: 'departmentCloseJob', desc: false, inModal: false})" 
                                                    type="button" 
                                                    class="btn btn-default"
                                                    id="departmentLovBtn">
                                                <i class="fa fa-search"></i>
                                            </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>                 
                            <div class="col-4 form-group">
                                <label> ประเภทใบรับงาน </label>
                                <div>
                                    <select id="workReceiptType" 
                                            class="form-control" 
                                            name=""
                                            style="width: 100% !important;"></select>
                                </div>
                            </div>                                    
                        </div>
                        <div>
                            <div class="col-12 form-group" style="text-align: right;">
                                <button id="searchTableCloseJobPendingBtn" 
                                        class="{{ $btnTrans['search']['class'] }}" 
                                        role="button" 
                                        aria-pressed="true">
                                    <i class="{{ $btnTrans['search']['icon'] }}"></i> 
                                    {{ $btnTrans['search']['text'] }}
                                </button>
                                <button id="undoTableCloseJobPendingBtn" 
                                        class="btn btn-danger" 
                                        role="button" 
                                        aria-pressed="true">
                                    <i class="fa fa-undo"></i> ล้างค่า
                                </button>
                            </div>                            
                        </div>
                        <div class="row">
                            <table class="table" style="width: 100% !important;">
                                <thead>
                                    <tr id="setTheadTableCloseJobPending"></tr>
                                </thead>
                                <tbody id="setTbodyTableCloseJobPending"></tbody>
                            </table>
                            <table class="float-center">
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="footable-visible" id="setTableCloseJobPendingPagination">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>                            
                        </div>
                    </section>

                    <section class="tab animated fadeInRight" id="openJobSucceed">
                        <nav>
                            <a href="#closeJobPending"> รอดำเนินการ </a>
                            <a href="#closeJobSucceed" class="active"> สำเร็จ </a>
                        </nav>
                        <div class="row">
                            <table class="table">
                                <thead>
                                <tr id="setTheadTableCloseJobSucceed"></tr>
                                </thead>
                                <tbody id="setTbodyTableCloseJobSucceed"></tbody>
                            </table>
                            <table class="float-center">
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="footable-visible" id="setTableCloseJobSucceedPagination">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>                            
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    @include('eam.notification._modalLov');
</div>
@endsection
@section('scripts')
    @include('eam.commons.scripts.drop-down-year-plan');
    @include('eam.commons.scripts.lov-asset-number');
    @include('eam.commons.scripts.drop-down-work-receipt-type');
    @include('eam.commons.scripts.lov-department');
    @include('eam.commons.scripts.loader');
    <script>
        setDataDefaultTableMaintenancePendingFn();
        setDataDefaultTableMaintenanceSucceedFn();
        setDataDefaultTableOpenJobPendingFn();
        setDataDefaultTableOpenJobSucceedFn();
        setDataDefaultTableCloseJobPendingFn();
        setDataDefaultTableCloseJobSucceedFn();
        loader('hide');

        $("#tab1").click(() => {
            window.location.href = '#maintenancePending';
        })

        $("#tab2").click(() => {
            window.location.href = '#openJobPending';
        })

        $("#tab3").click(() => {
            window.location.href = '#closeJobPending';
        })

        $("#yearPlan").change(() => {
            if ($("#yearPlan").val() != '') {
                $.ajax({
                    url: "{{ route('eam.ajax.plan.version-plan',['']) }}/" + $("#yearPlan").val(),
                    method: 'GET',
                    success: function (response) {
                        let optionVersionPlan = ''
                        optionVersionPlan += `<option value=""></option>`
                        for (let data of response.data) {
                            if (data.version_plan) {
                                optionVersionPlan +=    `<option value="    ${data.version_plan}">
                                                                            ${data.version_plan}
                                                        </option>`
                            }
                        }
                        $("#versionPlan").prop('disabled', false);
                        $("#versionPlan").html(optionVersionPlan);
                    },
                    error: function (jqXHR, textStatus, errorRhrown) {
                        swal("Error", jqXHR.responseJSON.message, "error");
                    }
                })
            }        
        })

        $("#searchTableMaintenancePendingBtn").click(() => {
            loader('show');
            $.ajax({
                url: "{{ route('eam.ajax.notification.searchTableMaintenancePending') }}",
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: JSON.stringify({
                    'year_plan':    $("#yearPlan").val() ? 
                                    $("#yearPlan").val() : '',
                    'version_plan': $("#versionPlan").val() ? 
                                    $("#versionPlan").val() : '',
                    'scheduled_start_date': $("#scheduledStartDate").val() ? 
                                            $("#scheduledStartDate").val() : '',
                    'scheduled_completion_date':    $("#scheduledCompletionDate").val() ? 
                                                    $("#scheduledCompletionDate").val() : '',
                    'asset_number': $("#assetNumber").val() ? 
                                    $("#assetNumber").val() : '',
                    'asset_desc':   $("#assetNumber option:selected").text() ? 
                                    $("#assetNumber option:selected").text().split(' - ')[1] : '',
                }),
                success: function (response) {
                    if (response.data.data.length > 0) {
                        setTableMaintenancePendingFn(response.data);
                        window.location.href = '#maintenancePending'
                    } else {
                        swal("ค้นหาข้อมูลไม่พบ", "", "warning");
                        $("#setTbodyTableMaintenancePending").html('');
                        $('#setTableMaintenancePendingPagination').html('');
                    }
                    loader('hide');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    swal("Error", jqXHR.responseText.message, "error");
                    loader('hide');
                }
            });
        })

        $("#undoTableMaintenancePendingBtn").click(() => {
            $("#yearPlan").val('').trigger('change');
            $("#versionPlan").val('').trigger('change');
            $("#versionPlan").prop('disabled', true);
            $("#assetNumber").val('').trigger('change');
            $("#scheduledStartDate").val('').trigger('change');
            $("#scheduledCompletionDate").val('').trigger('change');
            setDataDefaultTableMaintenancePendingFn();
        })

        $("#searchTableOpenJobPendingBtn").click(() => {
            loader('show');
            $.ajax({
                url: "{{ route('eam.ajax.notification.searchTableOpenJobPending') }}",
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: JSON.stringify({
                    'expected_start_date':  $("#expectedStartDate").val() ? 
                                            $("#expectedStartDate").val() : '',
                    'expected_end_date':    $("#expectedCompletionDate").val() ? 
                                            $("#expectedCompletionDate").val() : '',
                    'owning_dept_code':     $("#reportingAgencyOpenJob").val() ? 
                                            $("#reportingAgencyOpenJob").val() : '',
                    'owning_dept_desc':     $("#reportingAgencyOpenJob option:selected").text() ? 
                                            $("#reportingAgencyOpenJob option:selected").text().split(' - ')[1] : '',
                    'asset_number': $("#assetNumberOpenJob").val() ? 
                                    $("#assetNumberOpenJob").val() : '',
                    'asset_desc':   $("#assetNumberOpenJob option:selected").text() ? 
                                    $("#assetNumberOpenJob option:selected").text().split(' - ')[1] : '',
                }),
                success: function (response) {
                    if (response.data.data.length > 0) {
                        setTableOpenJobPendingFn(response.data);
                        window.location.href = '#openJobPending'
                    } else {
                        swal("ค้นหาข้อมูลไม่พบ", "", "warning");
                        $("#setTbodyTableOpenJobPending").html('');
                        $('#setTableOpenJobPendingPagination').html('');
                    }
                    loader('hide');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    swal("Error", jqXHR.responseText.message, "error");
                    loader('hide');
                }
            });
        })

        $("#undoTableOpenJobPendingBtn").click(() => {
            $("#expectedStartDate").val('').trigger('change');
            $("#expectedCompletionDate").val('').trigger('change');
            $("#assetNumberOpenJob").val('').trigger('change');
            $("#reportingAgencyOpenJob").val('').trigger('change');
            setDataDefaultTableOpenJobPendingFn();
        })

        $("#searchTableCloseJobPendingBtn").click(() => {
            loader('show');
            $.ajax({
                url: "{{ route('eam.ajax.notification.searchTableCloseJobPending') }}",
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: JSON.stringify({
                    'work_order_type_id':       $("#workReceiptType").val() ? 
                                                $("#workReceiptType").val() : '',
                    'owning_department_code':   $("#departmentCloseJob").val() ? 
                                                $("#departmentCloseJob").val() : '',
                    'asset_number':             $("#assetNumberCloseJob").val() ? 
                                                $("#assetNumberCloseJob").val() : '',
                }),
                success: function (response) {
                    if (response.data.data.length > 0) {
                        setTableCloseJobPendingFn(response.data);
                        window.location.href = '#closeJobPending'
                    } else {
                        swal("ค้นหาข้อมูลไม่พบ", "", "warning");
                        $("#setTbodyTableCloseJobPending").html('');
                        $('#setTableCloseJobPendingPagination').html('');
                    }
                    loader('hide');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    swal("Error", jqXHR.responseText.message, "error");
                    loader('hide');
                }
            });
        })

        $("#undoTableCloseJobPendingBtn").click(() => {
            $("#assetNumberCloseJob").val('').trigger('change');
            $("#departmentCloseJob").val('').trigger('change');
            $("#workReceiptType").val('').trigger('change');
            setDataDefaultTableCloseJobPendingFn();
        })

        // Table Maintenance Pending
        let theadTableMaintenancePending = ''
        theadTableMaintenancePending += `<th class="text-center"></th>`
        theadTableMaintenancePending += `<th></th>`
        theadTableMaintenancePending += `<th></th>`

        $("#setTheadTableMaintenanceSucceed").html(theadTableMaintenancePending);
        function setTableMaintenancePendingFn(data) {
            let tbodyTable = ''
            if (Object.keys(data.data).length > 0) {
                _.each(data.data, function(row) {
                    tbodyTable +=   `<tr>`
                    tbodyTable +=   `<th scope="row">
                                        <div    class="oval" 
                                                style="background: {{$colorTagHigh['tag']}}">
                                            <div style="padding-top: 2px; 
                                                        color: #FFFFFF;
                                                        text-align: center;">
                                                {{ $colorTagHigh['meaning'] }}
                                            </div>
                                        </div>
                                    </th>`
                    tbodyTable +=   `<td>
                                        <div style="width: 800px; padding-left: 15px;">
                                            <b>{{'แผนซ่อมบำรุงเครื่องจักร ปีงบประมาณ ' }}</b> ${row.year_plan ? row.year_plan : ''}
                                            <b>{{'Version '}}</b> ${row.version_plan ? row.version_plan : ''}
                                            <br>
                                            <b>{{'รหัสเครื่องจักร : '}}</b>  ${row.asset_number ? row.asset_number : ''} {{' : '}} 
                                                                ${row.asset_desc ? row.asset_desc : ''}
                                            <br>
                                            <b>{{'ทำการซ่อมช่วงวันที่ : '}}</b>
                                            ${row.scheduled_start_date_th ? row.scheduled_start_date_th : ''} {{' - '}} 
                                            ${row.scheduled_completion_date_th ? row.scheduled_completion_date_th : ''}
                                        </div>
                                    </td>`
                    tbodyTable +=   `<td style="width: 120px;">
                                        <a  class="{{ $btnTrans['displayInfo']['class'] }}" 
                                            role="button" 
                                            aria-pressed="true"
                                            target="_blank"
                                            href="{{ route('eam.transaction.preventive-maintenance-plan') }}?year=${row.year_plan}&version=${row.version_plan}">
                                            <i class="{{ $btnTrans['displayInfo']['icon'] }}"></i> 
                                            {{ $btnTrans['displayInfo']['text'] }}
                                        </a>                                        
                                    </td>`
                    tbodyTable +=   `</tr>`
                })                
            }
            $("#setTbodyTableMaintenancePending").html(tbodyTable);

            let pagination = '<ul class="pagination float-center">';
            $.each(data.links , function( i , link ){
                pagination +=   `<li class="footable-page ${link.active ? 'active' : ''}">
                                    <a onclick="searchTableMaintenancePendingPagination('` + link.url + `')">${link.label}</a>
                                </li>`
            });
            pagination += '</ul>';
            $('#setTableMaintenancePendingPagination').html(pagination);
        }        

        function searchTableMaintenancePendingPagination(data) {
            if (data != 'null') {
                $.ajax({
                    url: data,
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (Object.keys(response.data.data).length > 0) {
                            setTableMaintenancePendingFn(response.data);
                            window.location.href = '#maintenancePending'
                        } else {
                            swal("ค้นหาข้อมูลไม่พบ", "", "warning");
                            $("#setTbodyTableMaintenancePending").html('');
                            $('#setTableMaintenancePendingPagination').html('');
                        }
                        loader('hide');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        swal("Error", jqXHR.responseText.message, "error");
                        loader('hide');
                    }
                });
            }
        }

        function setDataDefaultTableMaintenancePendingFn(){
            $.ajax({
                url: "{{ route('eam.ajax.notification.setDataMaintenancePending') }}",
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },                
                success: function (response) {
                    if (response.data.data.length > 0) {
                        setTableMaintenancePendingFn(response.data);
                        window.location.href = '#maintenancePending';
                    } else {
                        // swal("ค้นหาข้อมูลไม่พบ", "", "warning");
                        $("#setTbodyTableMaintenancePending").html('');
                        $('#setTableMaintenancePendingPagination').html('');
                    }      
                    loader('hide');              
                },
                    error: function (jqXHR, textStatus, errorThrown) {
                    swal("Error", jqXHR.responseJSON.message, "error");
                    loader('hide');
                }
            });
        }  

        // Table Maintenance Succeed
        let theadTableMaintenanceSucceed = ''
        theadTableMaintenanceSucceed += `<th class="text-center"></th>`
        theadTableMaintenanceSucceed += `<th></th>`
        theadTableMaintenanceSucceed += `<th></th>`

        $("#setTheadTableMaintenanceSucceed").html(theadTableMaintenanceSucceed);
        function setTableMaintenanceSucceedFn(data) {
            let tbodyTable = ''
            if (data.data.length > 0) {
                data.data.filter(row => {
                    tbodyTable +=   `<tr>`
                    tbodyTable +=   `<th scope="row">
                                        <div    class="oval" 
                                                style="background: {{$colorTagHigh['tag']}}">
                                            <div style="padding-top: 2px; 
                                                        color: #FFFFFF;
                                                        text-align: center;">
                                                {{ $colorTagHigh['meaning'] }}
                                            </div>
                                        </div>
                                    </th>`
                    tbodyTable +=   `<td>
                                        <div style="width: 800px; padding-left: 15px;">
                                            <b>{{'แผนซ่อมบำรุงเครื่องจักร ปีงบประมาณ ' }}</b> ${row.year_plan ? row.year_plan : ''}
                                            <b>{{'Version '}}</b> ${row.version_plan ? row.version_plan : ''}
                                            <br>
                                            <b>{{'รหัสเครื่องจักร : '}}</b>  ${row.asset_number ? row.asset_number : ''} {{' : '}} 
                                                                ${row.asset_desc ? row.asset_desc : ''}
                                            <br>
                                            <b>{{'ทำการซ่อมช่วงวันที่ : '}}</b>
                                            ${row.scheduled_start_date_th ? row.scheduled_start_date_th : ''} {{' - '}} 
                                            ${row.scheduled_completion_date_th ? row.scheduled_completion_date_th : ''}
                                        </div>
                                    </td>`
                    tbodyTable +=   `<td style="width: 120px;">
                                        <button id="searchBtn" 
                                                class="{{ $btnTrans['displayInfo']['class'] }}" 
                                                role="button" 
                                                aria-pressed="true">
                                            <i class="{{ $btnTrans['displayInfo']['icon'] }}"></i> 
                                            {{ $btnTrans['displayInfo']['text'] }}
                                        </button>
                                    </td>`
                    tbodyTable +=   `</tr>`
                })
            }
            $("#setTbodyTableMaintenanceSucceed").html(tbodyTable);

            let pagination = '<ul class="pagination float-center">';
            $.each(data.links , function( i , link ){
                pagination +=   `<li class="footable-page ${link.active ? 'active' : ''}">
                                    <a onclick="searchTableMaintenanceSucceedPagination('` + link.url + `')">${link.label}</a>
                                </li>`
            });
            pagination += '</ul>';
            $('#setTableMaintenancePaginationSucceed').html(pagination);
        } 

        function searchTableMaintenanceSucceedPagination(data) {
            if (data != 'null') {
                $.ajax({
                    url: data,
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.data.data.length > 0) {
                            setTableMaintenanceSucceedFn(response.data);
                            window.location.href = '#maintenanceSucceed'
                        } else {
                            swal("ค้นหาข้อมูลไม่พบ", "", "warning");
                            $("#setTbodyTableMaintenancePending").html('');
                            $('#setTableMaintenancePendingPagination').html('');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        swal("Error", jqXHR.responseText.message, "error");
                    }
                });
            }
        }
        
        function setDataDefaultTableMaintenanceSucceedFn(){
            $.ajax({
                url: "{{ route('eam.ajax.notification.setDataMaintenanceSucceed') }}",
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },                
                success: function (response) {
                    if (response.data.data.length > 0) {
                        setTableMaintenanceSucceedFn(response.data);
                        // window.location.href = '#maintenanceSucceed'
                    } else {
                        // swal("ค้นหาข้อมูลไม่พบ", "", "warning");
                        $("#setTbodyTableMaintenanceSucceed").html('');
                        $('#setTableMaintenanceSucceedPagination').html('');
                    }
                },
                    error: function (jqXHR, textStatus, errorThrown) {
                    swal("Error", jqXHR.responseJSON.message, "error");
                }
            });
        }  
        
        // Table OpenJob Pending
        let theadTableOpenJobPending = ''
        theadTableOpenJobPending += `<th class="text-center"></th>`
        theadTableOpenJobPending += `<th></th>`
        $("#setTheadTableOpenJobPending").html(theadTableOpenJobPending);

        function setDataDefaultTableOpenJobPendingFn(){
            $.ajax({
                url: "{{ route('eam.ajax.notification.setDataOpenJobPending') }}",
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },                
                success: function (response) {
                    if (response.data.data.length > 0) {
                        setTableOpenJobPendingFn(response.data);
                        // window.location.href = '#openJobPending'
                    } else {
                        // swal("ค้นหาข้อมูลไม่พบ", "", "warning");
                        $("#setTbodyTableOpenJobPending").html('');
                        $('#setTableOpenJobPendingPagination').html('');
                    }
                },
                    error: function (jqXHR, textStatus, errorThrown) {
                    swal("Error", jqXHR.responseJSON.message, "error");
                }
            });
        }  

        function setTableOpenJobPendingFn(data) {
            let tbodyTable = ''
            if (data.data.length > 0) {
                data.data.filter(row => {
                    tbodyTable +=   `<tr>`
                    tbodyTable +=   `<th scope="row">
                                        <div    class="oval" 
                                                style="background: ${row.code_color_priority ? row.code_color_priority : ''}">
                                            <div style="padding-top: 2px; 
                                                        color: #FFFFFF;
                                                        text-align: center;">
                                                ${row.work_request_priority_desc ? row.work_request_priority_desc : ''}
                                            </div>
                                        </div>
                                    </th>`
                    tbodyTable +=   `<td style="padding-left: 15px;">
                                        <div>
                                            <b>{{'รายการแจ้งซ่อมเครื่องจักร/แจ้งผลิตชิ้นส่วนอะไหล่รอเปิดใบรับงาน เลขที่ ' }}</b>
                                            <a  style="color: blue; text-decoration: underline;"
                                                href="{{ route('eam.work-requests.create') }}?id=${row.work_request_id}"
                                                target="_blank">
                                                ${row.work_request_number ? row.work_request_number : ''}
                                            </a>
                                            <br>                    
                                            <b>{{'รหัสเครื่องจักร : ' }}</b> ${row.asset_number ? row.asset_number : ''} {{ ':' }} 
                                                                ${row.asset_desc ? row.asset_desc : ''}
                                            <br>
                                            <b>{{'   ประเภทใบสั่งงาน : ' }}</b> ${row.work_request_type_desc ? row.work_request_type_desc : ''}
                                            <br>
                                            <b>{{'คำอธิบายใบสั่งงาน : ' }}</b> ${row.description ? row.description : ''}
                                            <br>
                                            <b>{{'หน่วยงานผู้รับแจ้ง : ' }}</b> ${row.receiving_dept_code ? row.receiving_dept_code : ''} {{ ':' }} 
                                                                  ${row.receiving_dept_desc ? row.receiving_dept_desc : ''}
                                            <br>
                                            <b>{{'   วันที่แจ้งซ่อม : ' }}</b> ${row.expected_start_date_th ? row.expected_start_date_th : ''}
                                        </div>
                                    </td>`
                    tbodyTable +=   `</tr>`
                })
            }
            $("#setTbodyTableOpenJobPending").html(tbodyTable);

            let pagination = '<ul class="pagination float-center">';
            $.each(data.links , function( i , link ){
                pagination +=   `<li class="footable-page ${link.active ? 'active' : ''}">
                                    <a onclick="searchTableOpenJobPendingPagination('` + link.url + `')">${link.label}</a>
                                </li>`
            });
            pagination += '</ul>';
            $('#setTableOpenJobPendingPagination').html(pagination);
        } 

        function searchTableOpenJobPendingPagination(data) {
            if (data != 'null') {
                $.ajax({
                    url: data,
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.data.data.length > 0) {
                            setTableOpenJobPendingFn(response.data);
                            window.location.href = '#openJobPending'
                        } else {
                            swal("ค้นหาข้อมูลไม่พบ", "", "warning");
                            $("#setTbodyTableOpenJobPending").html('');
                            $('#setTableOpenJobPendingPagination').html('');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        swal("Error", jqXHR.responseText.message, "error");
                    }
                });
            }
        }

        // Table OpenJob Succeed
        let theadTableOpenJobSucceed = ''
        theadTableOpenJobSucceed += `<th class="text-center"></th>`
        theadTableOpenJobSucceed += `<th></th>`

        $("#setTheadTableOpenJobSucceed").html(theadTableOpenJobSucceed);
        function setDataDefaultTableOpenJobSucceedFn(){
            $.ajax({
                url: "{{ route('eam.ajax.notification.setDataOpenJobSucceed') }}",
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },                
                success: function (response) {
                    if (response.data.data.length > 0) {
                        setTableOpenJobSucceedFn(response.data);
                        // window.location.href = '#openJobSucceed'
                    } else {
                        // swal("ค้นหาข้อมูลไม่พบ", "", "warning");
                        $("#setTbodyTableOpenJobSucceed").html('');
                        $('#setTableOpenJobSucceedPagination').html('');
                    }
                },
                    error: function (jqXHR, textStatus, errorThrown) {
                    swal("Error", jqXHR.responseJSON.message, "error");
                }
            });
        }

        function setTableOpenJobSucceedFn(data) {
            let tbodyTable = ''
            if (data.data.length > 0) {
                data.data.filter(row => {
                    tbodyTable +=   `<tr>`
                    tbodyTable +=   `<th scope="row">
                                        <div    class="oval" 
                                                style="background: ${row.code_color_priority ? row.code_color_priority : ''}">
                                            <div style="padding-top: 2px; 
                                                        color: #FFFFFF;
                                                        text-align: center;">
                                                ${row.work_request_priority_desc ? row.work_request_priority_desc : ''}
                                            </div>
                                        </div>
                                    </th>`
                    tbodyTable +=   `<td style="padding-left: 15px;">                                        
                                        <div>
                                            <b>{{'รายการแจ้งซ่อมเครื่องจักร/แจ้งผลิตชิ้นส่วนอะไหล่รอเปิดใบรับงาน เลขที่ ' }}</b>
                                            <a  style="color: blue; text-decoration: underline;"
                                                href="{{ route('eam.work-requests.create') }}?id=${row.work_request_id}"
                                                target="_blank">
                                                ${row.work_request_number ? row.work_request_number : ''}
                                            </a>
                                            <br>                    
                                            <b>{{'รหัสเครื่องจักร : ' }}</b> ${row.asset_number ? row.asset_number : ''} {{ ':' }} 
                                                                         ${row.asset_desc ? row.asset_desc : ''}
                                            <br>
                                            <b>{{'   ประเภทใบสั่งงาน : ' }}</b> ${row.work_request_type_desc ? 
                                                                                row.work_request_type_desc : ''}
                                            <br>
                                            <b>{{'คำอธิบายใบสั่งงาน : ' }}</b> ${row.description ? row.description : ''}
                                            <br>
                                            <b>{{'หน่วยงานผู้รับแจ้ง : ' }}</b>  ${row.receiving_dept_code ? row.receiving_dept_code : ''} 
                                                                            {{ ':' }} 
                                                                            ${row.receiving_dept_desc ? row.receiving_dept_desc : ''}
                                            <br>
                                            <b>{{'   วันที่แจ้งซ่อม : ' }}</b> ${row.expected_start_date_th ? row.expected_start_date_th : ''}
                                        </div>
                                    </td>`
                    tbodyTable +=   `</tr>`
                })
            }
            $("#setTbodyTableOpenJobSucceed").html(tbodyTable);

            let pagination = '<ul class="pagination float-center">';
            $.each(data.links , function( i , link ){
                pagination +=   `<li class="footable-page ${link.active ? 'active' : ''}">
                                    <a onclick="searchTableOpenJobSucceedPagination('` + link.url + `')">${link.label}</a>
                                </li>`
            });
            pagination += '</ul>';
            $('#setTableopenJobPaginationSucceed').html(pagination);
        } 

        function searchTableOpenJobSucceedPagination(data) {
            if (data != 'null') {
                $.ajax({
                    url: data,
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.data.data.length > 0) {
                            setTableOpenJobSucceedFn(response.data);
                            window.location.href = '#openJobSucceed'
                        } else {
                            swal("ค้นหาข้อมูลไม่พบ", "", "warning");
                            $("#setTbodyTableOpenJobSucceed").html('');
                            $('#setTableopenJobPaginationSucceed').html('');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        swal("Error", jqXHR.responseText.message, "error");
                    }
                });
            }
        }

        // Table CloseJob Pending
        let setTheadTableCloseJobPending = ''
        setTheadTableCloseJobPending += `<th class="text-center"></th>`
        setTheadTableCloseJobPending += `<th></th>`
        $("#setTheadTableCloseJobPending").html(setTheadTableCloseJobPending);

        function setDataDefaultTableCloseJobPendingFn(){
            $.ajax({
                url: "{{ route('eam.ajax.notification.setDataCloseJobPending') }}",
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },                
                success: function (response) {
                    if (response.data.data.length > 0) {
                        setTableCloseJobPendingFn(response.data);
                        // window.location.href = '#closeJobPending'
                    } else {
                        // swal("ค้นหาข้อมูลไม่พบ", "", "warning");
                        $("#setTbodyTablecloseJobPending").html('');
                        $('#setTablecloseJobPendingPagination').html('');
                    }
                },
                    error: function (jqXHR, textStatus, errorThrown) {
                    swal("Error", jqXHR.responseJSON.message, "error");
                }
            });
        }

        function setTableCloseJobPendingFn(data) {
            let tbodyTable = ''
            if (data.data.length > 0) {
                data.data.filter(row => {
                    tbodyTable +=   `<tr>`
                    tbodyTable +=   `<th scope="row">
                                        <div    class="oval" 
                                                style="background: ${row.code_color_priority ? row.code_color_priority : ''}">
                                            <div style="padding-top: 2px; 
                                                        color: #FFFFFF;
                                                        text-align: center;">
                                                ${row.work_request_priority_desc ? row.work_request_priority_desc : ''}
                                            </div>
                                        </div>
                                    </th>`
                    tbodyTable +=   `<td style="padding-left: 15px;">
                                        <div>
                                            <b>{{'รายการงานซ่อมเครื่องจักร/ผลิตชิ้นส่วนอะไหล่รอปิดงาน เลขที่ ' }}</b> 
                                            <a  style="color: blue; text-decoration: underline;"
                                                href="{{ route('eam.work-orders.list-repair-jobs-waiting-close') }}?wip_entity_name=${row.wip_entity_name}&wip_entity_id=${row.wip_entity_id}"
                                                target="_blank">
                                                ${row.wip_entity_name ? row.wip_entity_name : ''}
                                            </a>
                                            <br>                    
                                            <b>{{'รหัสเครื่องจักร : ' }}</b> ${row.asset_number ? row.asset_number : ''} {{ ':' }} 
                                                                ${row.asset_desc ? row.asset_desc : ''}
                                            <b>{{'   ประเภทใบรับงาน : ' }}</b> ${row.work_order_type_desc ? row.work_order_type_desc : ''}
                                            <br>
                                            <b>{{'คำอธิบายใบสั่งงาน : ' }}</b> ${row.description ? row.description : ''}
                                            <br>
                                            <b>{{'หน่วยงานรับงาน : ' }}</b> ${row.owning_department_code ? row.owning_department_code : ''} 
                                                                    {{ ':' }} 
                                                                          ${row.owning_department_desc ? row.owning_department_desc : ''}
                                        </div>
                                    </td>`
                    tbodyTable +=   `</tr>`
                })
            }
            $("#setTbodyTableCloseJobPending").html(tbodyTable);

            let pagination = '<ul class="pagination float-center">';
            $.each(data.links , function( i , link ){
                pagination +=   `<li class="footable-page ${link.active ? 'active' : ''}">
                                    <a onclick="searchTableCloseJobPendingPagination('` + link.url + `')">${link.label}</a>
                                </li>`
            });
            pagination += '</ul>';
            $('#setTableCloseJobPendingPagination').html(pagination);
        }

        function searchTableCloseJobPendingPagination(data) {
            if (data != 'null') {
                $.ajax({
                    url: data,
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.data.data.length > 0) {
                            setTableCloseJobPendingFn(response.data);
                            window.location.href = '#closeJobPending'
                        } else {
                            swal("ค้นหาข้อมูลไม่พบ", "", "warning");
                            $("#setTbodyTableCloseJobPending").html('');
                            $('#setTableCloseJobPendingPagination').html('');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        swal("Error", jqXHR.responseText.message, "error");
                    }
                });
            }
        }

        // Table CloseJob Succeed
        let setTheadTableCloseJobSucceed = ''
        setTheadTableCloseJobSucceed += `<th class="text-center"></th>`
        setTheadTableCloseJobSucceed += `<th></th>`

        $("#setTheadTableCloseJobSucceed").html(setTheadTableCloseJobSucceed);
        function setDataDefaultTableCloseJobSucceedFn(){
            $.ajax({
                url: "{{ route('eam.ajax.notification.setDataCloseJobSucceed') }}",
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },                
                success: function (response) {
                    if (response.data.data.length > 0) {
                        setTableCloseJobSucceedFn(response.data);
                        // window.location.href = '#closeJobSucceed'
                    } else {
                        // swal("ค้นหาข้อมูลไม่พบ", "", "warning");
                        $("#setTbodyTablecloseJobSucceed").html('');
                        $('#setTablecloseJobSucceedPagination').html('');
                    }
                },
                    error: function (jqXHR, textStatus, errorThrown) {
                    swal("Error", jqXHR.responseJSON.message, "error");
                }
            });
        }

        function setTableCloseJobSucceedFn(data) {
            let tbodyTable = ''
            if (data.data.length > 0) {
                data.data.filter(row => {
                    tbodyTable +=   `<tr>`
                    tbodyTable +=   `<th scope="row">
                                        <div    class="oval" 
                                                style="background: ${row.code_color_priority ? row.code_color_priority : ''}">
                                            <div style="padding-top: 2px; 
                                                        color: #FFFFFF;
                                                        text-align: center;">
                                                ${row.work_request_priority_desc ? row.work_request_priority_desc : ''}
                                            </div>
                                        </div>
                                    </th>`
                    tbodyTable +=   `<td style="padding-left: 15px;">
                                        <div>
                                            <b>{{'รายการงานซ่อมเครื่องจักร/ผลิตชิ้นส่วนอะไหล่รอปิดงาน เลขที่ ' }}</b>
                                            <a  style="color: blue; text-decoration: underline;"
                                                href="{{ route('eam.work-orders.list-repair-jobs-waiting-close') }}?wip_entity_name=${row.wip_entity_name}&wip_entity_id=${row.wip_entity_id}"
                                                target="_blank">
                                                ${row.wip_entity_name ? row.wip_entity_name : ''}
                                            </a>
                                            <br>                    
                                            <b>{{'รหัสเครื่องจักร : ' }}</b> ${row.asset_number ? row.asset_number : ''} {{ ':' }} 
                                                                ${row.asset_desc ? row.asset_desc : ''}
                                            <b>{{'   ประเภทใบรับงาน : ' }}</b> ${row.work_order_type_desc ? row.work_order_type_desc : ''}
                                            <br>
                                            <b>{{'คำอธิบายใบสั่งงาน : ' }}</b> ${row.description ? row.description : ''}
                                            <br>
                                            <b>{{'หน่วยงานรับงาน : ' }}</b> ${row.owning_department_code ? row.owning_department_code : ''} 
                                                                    {{ ':' }} 
                                                                   ${row.owning_department_desc ? row.owning_department_desc : ''}
                                        </div>
                                    </td>`
                    tbodyTable +=   `</tr>`
                })
            }
            $("#setTbodyTableCloseJobSucceed").html(tbodyTable);

            let pagination = '<ul class="pagination float-center">';
            $.each(data.links , function( i , link ){
                pagination +=   `<li class="footable-page ${link.active ? 'active' : ''}">
                                    <a onclick="searchTableCloseJobSucceedPagination('` + link.url + `')">${link.label}</a>
                                </li>`
            });
            pagination += '</ul>';
            $('#setTableCloseJobSucceedPagination').html(pagination);
        }

        function searchTableCloseJobSucceedPagination(data) {
            if (data != 'null') {
                $.ajax({
                    url: data,
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        if (response.data.data.length > 0) {
                            setTableCloseJobSucceedFn(response.data);
                            window.location.href = '#closeJobSucceed'
                        } else {
                            swal("ค้นหาข้อมูลไม่พบ", "", "warning");
                            $("#setTbodyTableCloseJobSucceed").html('');
                            $('#setTableCloseJobSucceedPagination').html('');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        swal("Error", jqXHR.responseText.message, "error");
                    }
                });
            }
        }
        
    </script>   

    <script src="/js/eam-selected.js"></script>
    <link rel="stylesheet" href="{{ asset('/eamselected.css') }}">
@endsection