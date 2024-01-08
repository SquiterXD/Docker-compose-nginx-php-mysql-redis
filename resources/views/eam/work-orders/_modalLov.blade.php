<div class="modal fade" id="detailReportWorkReceipt" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">พิมพ์รายงาน</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <form id="detailReportWorkReceiptAction" target="_blank" method="GET" class="w-100">
                        <div class="col-11 mb-3">
                            <h4>Parameter</h4>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group row justify-content-center">
                                <label class="col-sm-3 col-form-label">เลขที่ใบรับงาน ตั้งแต่</label>
                                <div class="col-sm-4">
                                    <input id="modalWReportWorkReceiptWorkReceiptStart" type="text"
                                        class="form-control" name="p_wip_entity_name" autocomplete="off">
                                </div>
                                <div class="col-sm-4"></div>
                            </div>
                            <div class="form-group row justify-content-center">
                                <label class="col-sm-3 col-form-label">เลขที่ใบรับงาน ถึง</label>
                                <div class="col-sm-4">
                                    <input id="modalWReportWorkReceiptWorkReceiptEnd" type="text" class="form-control"
                                        name="p_wip_entity_name_to" autocomplete="off">
                                </div>
                                <div class="col-sm-4"></div>
                            </div>
                            <div class="form-group row justify-content-center">
                                <label class="col-sm-3 col-form-label">ประมาณวันที่เริ่ม ตั้งแต่</label>
                                <div class="col-sm-4">
                                    <input id="modalReportWorkReceiptDateStart" type="text"
                                        class="form-control dateTable" autocomplete="off">
                                    <input id="modalReportWorkReceiptDateStartHide" type="text" hidden
                                        class="form-control" name="p_scheduled_start_date" autocomplete="off">
                                </div>
                                <div class="col-sm-4"></div>
                            </div>
                            <div class="form-group row justify-content-center">
                                <label class="col-sm-3 col-form-label">ประมาณวันที่เริ่ม ถึง</label>
                                <div class="col-sm-4">
                                    <input id="modalReportWorkReceiptDateEnd" type="text" class="form-control dateTable"
                                        autocomplete="off">
                                    <input id="modalReportWorkReceiptDateEndHide" type="text" hidden
                                        class="form-control" name="p_scheduled_start_date_to" autocomplete="off">
                                </div>
                                <div class="col-sm-4"></div>
                            </div>
                            <div class="form-group row justify-content-center">
                                <label class="col-sm-3 col-form-label">พื้นที่ ตั้งแต่</label>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        {{-- <input id="modalReportWorkReceiptAreaS" type="text"
                                            class="form-control clearable" name="p_area_code" readonly
                                            autocomplete="off"> --}}
                                        <select id="modalReportWorkReceiptAreaS" 
                                                class="form-control clearable" 
                                                data-server="/eam/ajax/lov/area"  
                                                data-id="area" 
                                                data-text="description" 
                                                data-field="select"
                                                name="p_area_code">
                                        </select>
                                        <div class="input-group-append">
                                            <span class="input-group-append">
                                                <button onclick="areaBtnReportOnclick('modalReportWorkReceiptAreaS')"
                                                    type="button" class="btn btn-default"><i
                                                        class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>
                            <div class="form-group row justify-content-center">
                                <label class="col-sm-3 col-form-label">พื้นที่ ถึง</label>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        {{-- <input id="modalReportWorkReceiptAreaE" type="text"
                                            class="form-control clearable" name="p_area_code_to" readonly
                                            autocomplete="off"> --}}
                                        <select id="modalReportWorkReceiptAreaE" 
                                                class="form-control clearable" 
                                                data-server="/eam/ajax/lov/area"  
                                                data-id="area" 
                                                data-text="description" 
                                                data-field="select"
                                                name="p_area_code_to">
                                        </select>
                                        <div class="input-group-append">
                                            <span class="input-group-append">
                                                <button onclick="areaBtnReportOnclick('modalReportWorkReceiptAreaE')"
                                                    type="button" class="btn btn-default"><i
                                                        class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>
                            <div class="form-group row justify-content-center">
                                <label class="col-sm-3 col-form-label">Asset Number</label>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        {{-- <input id="modalReportWorkReceiptAssetNumber" type="text"
                                            class="form-control clearable" name="p_asset_number" readonly
                                            autocomplete="off"> --}}
                                        <select id="modalReportWorkReceiptAssetNumber" 
                                                class="form-control clearable readonly" 
                                                data-server="/eam/ajax/lov/assetnumber"  
                                                data-id="asset_number" 
                                                data-text="description" 
                                                data-field="select"
                                                name="p_asset_number">
                                        </select>
                                        <div class="input-group-append">
                                            <span class="input-group-append">
                                                <button
                                                    onclick="assetNumberBtnReportOnclick('modalReportWorkReceiptAssetNumber')"
                                                    type="button" class="btn btn-default"><i
                                                        class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>
                            <div class="form-group row justify-content-center">
                                <label class="col-sm-3 col-form-label">สถานะใบรับงาน</label>
                                <div class="col-sm-4">
                                    <select id="modalReportWorkReceiptStatus" class="form-control"></select>
                                    <input id="modalReportWorkReceiptStatusDesc" class="d-none"
                                        name="p_status_desc" type="text">
                                </div>
                                <div class="col-sm-4"></div>
                            </div>
                            <div class="form-group row justify-content-center">
                                <label class="col-sm-3 col-form-label">หน่วยงานผู้รับแจ้ง</label>
                                <div class="col-sm-4">
                                    <div class="input-group">
                                        {{-- <input id="modalReportWorkReceiptNotifyingAgency" type="text"
                                            class="form-control clearable" name="p_owning_department_code" readonly
                                            autocomplete="off"> --}}
                                        <select id="modalReportWorkReceiptNotifyingAgency" 
                                                name="p_owning_department_code" 
                                                class="form-control clearable readonly" 
                                                data-server="/eam/ajax/lov/departments"
                                                data-id="department_code" 
                                                data-text="description"
                                                data-field="select"
                                                data-setAjaxEAM0010ModalReportWorkReceiptNotifyingAgency='modalReportWorkReceiptNotifyingAgency'>
                                        </select>
                                        <div class="input-group-append">
                                            <span class="input-group-append">
                                                <button
                                                    onclick="departmentLovBtnOnclick({nameDepartmentModal: 'หน่วยงานผู้รับแจ้ง', idDepartmentModal: 'modalReportWorkReceiptNotifyingAgency', desc: true, inModal: true})"
                                                    type="button" class="btn btn-default"><i
                                                    class="fa fa-search"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <label class="col-form-label">&nbsp;</label>
                                <div class="col-sm-4">
                                    <input id="modalReportWorkReceiptNotifyingAgencyDesc" type="text"
                                        class="form-control" name="p_owning_department_desc" disabled
                                        autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <button id="printBtnHide" class="d-none"></button>
                    </form>
                    <div class="col-lg-11">
                        <div class="text-right">
                            <button id="modalReportWorkReceiptPrint" class="btn btn-primary btn-lg size-btn mt-1"
                                role="button" aria-pressed="true">
                                พิมพ์
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailAreaLov" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Area</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">code</label>
                            <div class="col-sm-8">
                                <input id="modalAreaSearchAreaCode" type="text" class="form-control"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">description</label>
                            <div class="col-sm-8">
                                <input id="modalAreaSearchAreaName" type="text" class="form-control"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="text-right">
                            <button id="modalSearchAreaLov" class="btn btn-default btn-lg size-btn mt-1" role="button"
                                aria-pressed="true">
                                <i class="fa fa-search"></i> ค้นหา
                            </button>
                        </div>
                    </div>
                    <div class="col-12">
                        <div style="overflow-x:auto;">
                            <table class="table mt-4">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="min-width: 150px;">
                                            <div>code</div>
                                        </th>
                                        <th class="text-center" style="min-width: 300px;">
                                            <div>description</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="setLovArea"></tbody>
                            </table>
                        </div>
                        <table class="float-right">
                            <tfoot>
                                <tr>
                                    <td colspan="10" class="footable-visible" id="setLovAreaPagination">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailClassLov" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="nameWipClass" class="modal-title">Class</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Class Code</label>
                            <div class="col-sm-8">
                                <input id="modalClassSearchClassCode" type="text" class="form-control"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Description</label>
                            <div class="col-sm-8">
                                <input id="modalClassSearchClassName" type="text" class="form-control"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="text-right">
                            <button id="modalSearchClassLov" class="btn btn-default btn-lg size-btn mt-1" role="button"
                                aria-pressed="true">
                                <i class="fa fa-search"></i> ค้นหา
                            </button>
                        </div>
                    </div>
                    <div class="col-12">
                        <div style="overflow-x:auto;">
                            <table class="table mt-4">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="min-width: 150px;">
                                            <div>Class Code</div>
                                        </th>
                                        <th class="text-center" style="min-width: 300px;">
                                            <div>Description</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="setLovClass"></tbody>
                            </table>
                        </div>
                        <table class="float-right">
                            <tfoot>
                                <tr>
                                    <td colspan="10" class="footable-visible" id="setLovClassPagination">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailWorkReceiptNumberLov" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เลขที่ใบรับงาน</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">ใบรับงาน</label>
                            <div class="col-sm-8">
                                <input id="modalWorkReceiptNumberSearchWorkReceiptNumber" type="text"
                                    class="form-control" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="text-right">
                            <button id="modalSearchWorkReceiptNumberLov" class="btn btn-default btn-lg size-btn mt-1"
                                role="button">
                                <i class="fa fa-search"></i> ค้นหา
                            </button>
                        </div>
                    </div>
                    <div class="col-12" style="overflow-x:scroll;">
                        <table class="table mt-4">
                            <thead>
                                <tr>
                                    <th class="text-center" style="min-width: 150px;" width="150px">
                                        <div>เลขที่ใบรับงาน</div>
                                    </th>
                                    <th class="text-center" style="min-width: 150px;" width="150px">
                                        <div>ประเภทของใบรับงาน</div>
                                    </th>
                                    <th class="text-center" style="min-width: 160px;" width="160px">
                                        <div>ชื่อเครื่องจักร (Number)</div>
                                    </th>
                                    <th class="text-center" style="min-width: 150px;" width="150px">
                                        <div>คำอธิบายใบสั่งงาน</div>
                                    </th>
                                    <th class="text-center" style="min-width: 150px;" width="150px">
                                        <div>ประมาณวันที่เริ่มซ่อม</div>
                                    </th>
                                    <th class="text-center" style="min-width: 150px;" width="150px">
                                        <div>ประมาณวันที่ซ่อมเสร็จ</div>
                                    </th>
                                    <th class="text-center" style="min-width: 150px;" width="150px">
                                        <div>เลขที่ใบสั่งงาน</div>
                                    </th>
                                    <th class="text-center" style="min-width: 150px;" width="150px">
                                        <div>สถานะการตัดใช้อะไหล่</div>
                                    </th>
                                    <th class="text-center" style="min-width: 150px;" width="150px">
                                        <div>สถานะการบันทึกค่าแรง</div>
                                    </th>
                                    <th class="text-center" style="min-width: 165px;" width="165px">
                                        <div>สถานะการ Complete งาน</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="setLovWorkReceiptNumber"></tbody>
                        </table>
                    </div>
                    <div class="col-12">
                        <table class="float-right">
                            <tfoot>
                                <tr>
                                    <td colspan="10" class="footable-visible" id="setLovWorkReceiptNumberPagination">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailWorkOrderNumberLov" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">เลขที่ใบสั่งงาน</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">เลขที่ใบสั่งงาน</label>
                            <div class="col-sm-8">
                                <input id="modalWorkOrderNumberSearchWorkOrderNumber" type="text"
                                    class="form-control" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="text-right">
                            <button id="modalSearchWorkOrderNumberLov" class="btn btn-default btn-lg size-btn mt-1"
                                role="button">
                                <i class="fa fa-search"></i> ค้นหา
                            </button>
                        </div>
                    </div>
                    <div class="col-12">
                        <div style="overflow-x:auto;">
                            <table class="table mt-4">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="min-width: 130px;">
                                            <div>เลขที่ใบสั่งงาน</div>
                                        </th>
                                        <th class="text-center" style="min-width: 150px;">
                                            <div>ประเภทของใบสั่งงาน</div>
                                        </th>
                                        <th class="text-center" style="min-width: 200px;">
                                            <div>สถานะใบสั่งงาน</div>
                                        </th>
                                        <th class="text-center" style="min-width: 250px;">
                                            <div>ชื่อเครื่องจักร</div>
                                        </th>
                                        <th class="text-center" style="min-width: 300px;">
                                            <div>คำอธิบายใบสั่งงาน</div>
                                        </th>
                                        <th class="text-center" style="min-width: 130px;">
                                            <div>วันที่แจ้งซ่อม</div>
                                        </th>
                                        <th class="text-center" style="min-width: 200px;">
                                            <div>ผู้แจ้งซ่อม</div>
                                        </th>
                                        <th class="text-center" style="min-width: 250px;">
                                            <div>หน่วยงานผู้แจ้ง</div>
                                        </th>
                                        <th class="text-center" style="min-width: 130px;">
                                            <div>เลขที่ใบรับงาน</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="setLovWorkOrderNumber"></tbody>
                            </table>
                        </div>
                        <table class="float-right">
                            <tfoot>
                                <tr>
                                    <td colspan="10" class="footable-visible" id="setLovWorkOrderNumberPagination">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailAssetNumberLov" data-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Asset Number</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Asset Number</label>
                            <div class="col-sm-8">
                                <input id="modalAssetNumberSearchAssetNumber" type="text" class="form-control"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Description</label>
                            <div class="col-sm-8">
                                <input id="modalAssetNumberSearchDescription" type="text" class="form-control"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Serial Number</label>
                            <div class="col-sm-8">
                                <input id="modalAssetNumberSearchSerialNumber" type="text" class="form-control"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="text-right">
                            <button id="modalSearchAssetNumberLov" href="#"
                                class="btn btn-default btn-lg size-btn mt-1" role="button" aria-pressed="true">
                                <i class="fa fa-search"></i> ค้นหา
                            </button>
                        </div>
                    </div>
                    <div class="col-12">
                        <div style="overflow-x:auto;">
                            <table class="table mt-4">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="min-width: 250px;">
                                            <div>Asset Number</div>
                                        </th>
                                        <th class="text-center" style="min-width: 300px;">
                                            <div>Description</div>
                                        </th>
                                        <th class="text-center" style="min-width: 200px;">
                                            <div>Serial Number</div>
                                        </th>
                                        <th class="text-center" style="min-width: 150px;">
                                            <div>Parent</div>
                                        </th>
                                        <th class="text-center" style="min-width: 60px;">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="setLovAssetNumber"></tbody>
                            </table>
                        </div>
                        <table class="float-right">
                            <tfoot>
                                <tr>
                                    <td colspan="10" class="footable-visible" id="setLovAssetNumberPagination">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailAssetNumberLovChild" data-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Asset Number</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div style="overflow-x:auto;">
                            <table class="table mt-4">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="min-width: 250px;">
                                            <div>Asset Number</div>
                                        </th>
                                        <th class="text-center" style="min-width: 300px;">
                                            <div>Description</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="setLovAssetNumberChild"></tbody>
                            </table>
                        </div>
                        <table class="float-right">
                            <tfoot>
                                <tr>
                                    <td colspan="10" class="footable-visible" id="setLovAssetNumberChildPagination">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailItemCodeLov" tabindex="-1" role="dialog" data-backdrop="static"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Item Code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Item Code</label>
                            <div class="col-sm-8">
                                <input id="modalItemCodeSearchItemCode" type="text" class="form-control"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Item Description</label>
                            <div class="col-sm-8">
                                <input id="modalItemCodeSearchItemDescription" type="text" class="form-control"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Part Number</label>
                            <div class="col-sm-8">
                                <input id="modalItemCodeSearchItemPartNumber" type="text" class="form-control"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Old Item Number</label>
                            <div class="col-sm-8">
                                <input id="modalItemCodeSearchOldItemNumber" type="text" class="form-control"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Part Number Old</label>
                            <div class="col-sm-8">
                                <input id="modalItemCodeSearchPartNumberOld" type="text" class="form-control"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Machine 01</label>
                            <div class="col-sm-8">
                                <input id="modalItemCodeSearchMachine01" type="text" class="form-control"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Machine 02</label>
                            <div class="col-sm-8">
                                <input id="modalItemCodeSearchMachine02" type="text" class="form-control"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Subinventory</label>
                            <div class="col-sm-8">
                                <select class="js-example-basic-single" id="modalItemCodeSearchSubinventory" name="modalItemCodeSearchSubinventory">
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Locator</label>
                            <div class="col-sm-8">
                                <select class="js-example-basic-single" id="modalItemCodeSearchLocator" name="modalItemCodeSearchLocator">
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="text-right">
                            <button id="modalSearchItemCodeLov" class="btn btn-default btn-lg size-btn mt-1"
                                role="button" aria-pressed="true">
                                <i class="fa fa-search"></i> ค้นหา
                            </button>
                        </div>
                    </div>
                    <div class="col-12">
                        <h4>Item Master</h4>
                    </div>
                    <div class="col-12">
                        <div style="overflow-x:auto;">
                            <table class="table mt-4">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="min-width: 150px;">
                                            <div>Item Code</div>
                                        </th>
                                        <th class="text-center" style="min-width: 250px;">
                                            <div>Item Description</div>
                                        </th>
                                        <th class="text-center" style="min-width: 150px;">
                                            <div>Part Number</div>
                                        </th>
                                        <th class="text-center" style="min-width: 150px;">
                                            <div>Old Item Number</div>
                                        </th>
                                        <th class="text-center" style="min-width: 150px;">
                                            <div>Part Number Old</div>
                                        </th>
                                        <th class="text-center" style="min-width: 150px;">
                                            <div>Machine 01</div>
                                        </th>
                                        <th class="text-center" style="min-width: 150px;">
                                            <div>Machine 02</div>
                                        </th>
                                        <th class="text-center" style="min-width: 150px;">
                                            <div>Subinventory</div>
                                        </th>
                                        <th class="text-center" style="min-width: 150px;">
                                            <div>Locator</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="setLovItemCode"></tbody>
                            </table>
                        </div>
                        <table class="float-right">
                            <tfoot>
                                <tr>
                                    <td colspan="10" class="footable-visible" id="setLovItemCodePagination">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailTableSavePartChild" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">คืนอะไหล่</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-right">
                            <button id="saveSavePartBtnChild" class="btn btn-primary btn-lg size-btn mt-1"
                                role="button">
                                บันทึก
                            </button>
                        </div>
                    </div>
                    <div class="col-12" style="overflow-x:scroll;">
                        <form onsubmit="formSaveSavePartBtnChildHide();return false;">
                            <table class="table mt-4">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="min-width: 160px;" width="13%">
                                            <label>เลขที่ใบรับงาน </label>
                                        </th>
                                        <th class="text-center" style="min-width: 100px;" width="13%">
                                            <label>ขั้นตอนที่ </label>
                                        </th>
                                        <th class="text-center" style="min-width: 160px;" width="13%">
                                            <label>Item Code </label>
                                        </th>
                                        <th class="text-center" style="min-width: 180px;" width="15%">
                                            <label>Item Description </label>
                                        </th>
                                        <th class="text-center" style="min-width: 120px;" width="12%">
                                            <label>จำนวนที่ต้องใช้ </label>
                                        </th>
                                        <th class="text-center" style="min-width: 120px;" width="12%">
                                            <label>จำนวนที่ตัดใช้แล้ว </label>
                                        </th>
                                        <th class="text-center" style="min-width: 140px;" width="14%">
                                            <label>จำนวนที่ต้องการคืน </label>
                                        </th>
                                        <th class="text-center" style="min-width: 100px;" width="12%">
                                            <label>หน่วยนับ </label>
                                        </th>
                                        <th class="text-center" style="min-width: 210px;" width="18%">
                                            <label>Transaction Date </label>
                                        </th>
                                        <th class="text-center" style="min-width: 120px;" width="12%">
                                            <label>Subinventory </label>
                                        </th>
                                        <th class="text-center" style="min-width: 180px;" width="12%">
                                            <label>Locator </label>
                                        </th>
                                        <th class="text-center" style="min-width: 120px;" width="12%">
                                            <label>Lot Number<label class="pl-1 text-danger">*</label></label>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="setSavePartBtnChild"></tbody>
                            </table>
                            <button id="saveSavePartBtnChildHide" class="d-none"></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailDepartmentLov" tabindex="-1" role="dialog" data-backdrop="static"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="nameLovDepartment" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">รหัสหน่วยงาน</label>
                            <div class="col-sm-8">
                                <input id="modalDepartmentSearchCode" type="text" class="form-control"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">ชื่อหน่วยงาน</label>
                            <div class="col-sm-8">
                                <input id="modalDepartmentSearchName" type="text" class="form-control"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="text-right">
                            <button id="modalSearchDepartmentLov" class="btn btn-default btn-lg size-btn mt-1"
                                role="button" aria-pressed="true">
                                <i class="fa fa-search"></i> ค้นหา
                            </button>
                        </div>
                    </div>
                    <div class="col-12">
                        <div style="overflow-x:auto;">
                            <table class="table mt-4">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="min-width: 150px;">
                                            <div>รหัสหน่วยงาน</div>
                                        </th>
                                        <th class="text-center" style="min-width: 300px;">
                                            <div>ชื่อหน่วยงาน</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="setLovDepartment"></tbody>
                            </table>
                        </div>
                        <table class="float-right">
                            <tfoot>
                                <tr>
                                    <td colspan="10" class="footable-visible" id="setLovDepartmentPagination">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailEmployeeLov" tabindex="-1" role="dialog" data-backdrop="static"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="nameLovEmployee" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">รหัสพนักงาน</label>
                            <div class="col-sm-8">
                                <input id="modalEmployeeSearchEmpCode" type="text" class="form-control"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">ชื่อพนักงาน</label>
                            <div class="col-sm-8">
                                <input id="modalEmployeeSearchEmpName" type="text" class="form-control"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="text-right">
                            <button id="modalSearchEmployeeLov" class="btn btn-default btn-lg size-btn mt-1"
                                role="button" aria-pressed="true">
                                <i class="fa fa-search"></i> ค้นหา
                            </button>
                        </div>
                    </div>
                    <div class="col-12">
                        <div style="overflow-x:auto;">
                            <table class="table mt-4">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="min-width: 150px;">
                                            <div>รหัสพนักงาน</div>
                                        </th>
                                        <th class="text-center" style="min-width: 300px;">
                                            <div>ชื่อพนักงาน</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="setLovEmployee"></tbody>
                            </table>
                        </div>
                        <table class="float-right">
                            <tfoot>
                                <tr>
                                    <td colspan="10" class="footable-visible" id="setLovEmployeePagination">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailResourceEmployee" tabindex="-1" role="dialog" data-backdrop="static"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="nameLovResourceEmployee" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">รหัสพนักงาน</label>
                            <div class="col-sm-8">
                                <input id="modalResourceEmployeeSearchEmpCode" type="text" class="form-control"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">ชื่อพนักงาน</label>
                            <div class="col-sm-8">
                                <input id="modalResourceEmployeeSearchEmpName" type="text" class="form-control"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="text-right">
                            <button id="modalSearchResourceEmployeeLov" class="btn btn-default btn-lg size-btn mt-1"
                                role="button" aria-pressed="true">
                                <i class="fa fa-search"></i> ค้นหา
                            </button>
                        </div>
                    </div>
                    <div class="col-12">
                        <div style="overflow-x:auto;">
                            <table class="table mt-4">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="min-width: 150px;">
                                            <div>รหัสพนักงาน</div>
                                        </th>
                                        <th class="text-center" style="min-width: 300px;">
                                            <div>ชื่อพนักงาน</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="setLovResourceEmployee"></tbody>
                            </table>
                        </div>
                        <table class="float-right">
                            <tfoot>
                                <tr>
                                    <td colspan="10" class="footable-visible" id="setLovResourceEmployeePagination">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailCloseRepairWork" data-backdrop="static" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">ปิดงานซ่อม</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12">
            <label class="col-form-label">โปรแกรมนำส่งอะไหล่เข้าคลัง</label>
            <form onsubmit="modalCloseRepairWorkSaveBtnFn();return false;">
              <table class="table mt-4">
                <tbody id="setCloseRepairWork"></tbody>
              </table>
              <button id="modalCloseRepairWorkSaveBtnHide" class="d-none" ></button>
            </form>
          </div>
          <div class="col-lg-12 mt-4">
            <div class="text-center">
              <button id="modalCloseRepairWorkSaveBtn" type="button" class="btn btn-primary btn-lg size-btn mt-1">บันทึก</button>
              <button type="button" class="btn btn-danger btn-lg size-btn mt-1" data-dismiss="modal">ยกเลิก</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="detailCancelCloseJob" data-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ยกเลิก Complete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <label class="col-form-label">ระบุเหตุผล</label>
                        <textarea id="cancelCloseJobText" class="form-control textArea-2" name="description"></textarea>
                    </div>
                    <div class="col-12 mt-4">
                        <div class="text-center">
                            <button id="modalCancelCloseJobSaveBtn" type="button"
                                class="btn btn-primary btn-lg size-btn mt-1">บันทึก</button>
                            <button type="button" class="btn btn-danger btn-lg size-btn mt-1"
                                data-dismiss="modal">ยกเลิก</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailModalImage" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">รูปภาพ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-5"></div>
                    <!-- <div class="col-lg-7">
            <div class="text-right">
              <button id="viewImageBtn" class="btn btn-primary btn-lg size-btn mt-1" role="button">
                 ดูรูป
              </button>
            </div>
          </div> -->
                    <div class="col-lg-7 mt-4">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">เลขที่ใบสั่งงาน</label>
                            <div class="col-sm-8">
                                <input id="modalImageSearchWorkOrderNumber" type="text" class="form-control" disabled
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div style="overflow-x:auto;">
                            <!-- <table class="table mt-4">
                <thead>
                  <tr>
                    <th class="text-center" style="min-width: 90px;">
                      <div>ลำดับ</div>
                    </th>
                    <th class="text-center" style="min-width: 300px;">
                      <div>ชื่อไฟล์</div>
                    </th>
                  </tr>
                </thead>
                <tbody id="setModalFile"></tbody>
              </table> -->
                            <div id="setModalFileNew"></div>
                        </div>
                        <input id="selectImageDelete" class="d-none" type="text" autocomplete="off">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailModalImageView" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ดูรูป</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img id='setShowImageFileFn' class="w-100" alt="">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="detailEmployeeWebLov" tabindex="-1" role="dialog" data-backdrop="static"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="nameLovEmployeeWeb" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-5">
                        <!-- <div class="form-group row">
              <label class="col-sm-4 col-form-label">รหัสพนักงาน</label>
              <div class="col-sm-8">
                <input id="modalEmployeeWebSearchEmpCode" type="text" class="form-control" autocomplete="off">
              </div>
            </div> -->
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">ชื่อพนักงาน</label>
                            <div class="col-sm-8">
                                <input id="modalEmployeeWebSearchEmpName" type="text" class="form-control"
                                    autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="text-right">
                            <button id="modalSearchEmployeeWebLov" class="btn btn-default btn-lg size-btn mt-1"
                                role="button" aria-pressed="true">
                                <i class="fa fa-search"></i> ค้นหา
                            </button>
                        </div>
                    </div>
                    <div class="col-12">
                        <div style="overflow-x:auto;">
                            <table class="table mt-4">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="min-width: 150px;">
                                            <div>รหัสพนักงาน</div>
                                        </th>
                                        <th class="text-center" style="min-width: 300px;">
                                            <div>ชื่อพนักงาน</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="setLovEmployeeWeb"></tbody>
                            </table>
                        </div>
                        <table class="float-right">
                            <tfoot>
                                <tr>
                                    <td colspan="10" class="footable-visible" id="setLovEmployeeWebPagination">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
