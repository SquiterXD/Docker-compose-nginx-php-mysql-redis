<div class="modal fade" id="detailAssetNumberLov" data-backdrop="static" role="dialog">
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
                        <input id="modalAssetNumberSearchAssetNumber" type="text" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Description</label>
                        <div class="col-sm-8">
                        <input id="modalAssetNumberSearchDescription" type="text" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Serial Number</label>
                        <div class="col-sm-8">
                        <input id="modalAssetNumberSearchSerialNumber" type="text" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    </div>
                    <div class="col-lg-7">
                    <div class="text-right">
                        <button id="modalSearchAssetNumberLov" href="#" class="btn btn-primary btn-lg size-btn" role="button" aria-pressed="true">
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

<div class="modal fade" id="detailDepartmentLov" role="dialog" data-backdrop="static"
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