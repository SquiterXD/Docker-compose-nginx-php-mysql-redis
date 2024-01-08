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

<div class="modal fade" id="detailDepartmentLov" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
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
                <input id="modalDepartmentSearchCode" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">ชื่อหน่วยงาน</label>
              <div class="col-sm-8">
                <input id="modalDepartmentSearchName" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="text-right">
              <button id="modalSearchDepartmentLov" class="btn btn-default btn-lg size-btn mt-1" role="button" aria-pressed="true">
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

<div class="modal fade" id="detailModalExcel" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Upload</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Select File</label>
              <div class="col-sm-9">
                <form id="detailModalExcelForm" method="POST" enctype="multipart/form-data" target="ifram_taget">  @csrf
                  <div class="input-group">
                    <div class="custom-file">
                      <input id="modalFile" type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" class="custom-file-input" name="file" required autocomplete="off">
                      <label class="custom-file-label" style="overflow: hidden; height: 34px; display: block; line-height: 23px;" for="modalFile"></label>
                    </div>
                  </div>
                  <button id="modalModalExcelBtnHidden" type="submit" class="btn btn-success" hidden></button>
                </form>
                <iframe id="iframId" src="#" frameborder="0" name="ifram_taget" class="d-none"></iframe>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="text-right">
              <button id="modalModalImageAddBtn" type="button" class="btn btn-primary btn-lg size-btn">ตกลง</button>
              <button type="button" class="btn btn-secondary btn-lg size-btn" data-dismiss="modal">ยกเลิก</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="PMreportModal" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">

    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">พิมพ์รายงาน</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col-sm-12">
            <label class="col-sm-3 col-form-label">Parameter</label>
            <div class="form-row justify-content-center">

              <div class="col-sm-10" >
                <div class="input-group">
                  <label class="col-sm-5 col-form-label" for="PMreportYear">ปีงบประมาณ <span class="pl-1 text-danger">*</span></label>
                  <select id="PMreportYear" class="select" style="width:250px" required>
                  </select>
                </div>

                <div class="input-group">
                  <label class="col-sm-5 col-form-label" for="PMreportDepOwner">หน่วยงานเจ้าของเครื่องจักร</label>
                  <div style="position: relative; width: 100% !important;">
                    <select id="PMreportDepOwner" class="select" style="width:250px">
                    </select>
                    <button type="button" id="PMreportDepOwnerReset" class="close" style="position: absolute; right: 25px; top: 1px;"><span aria-hidden="true">&times;</span></button>
                  </div>
                </div>

                <div class="input-group">
                  <label class="col-sm-5 col-form-label" for="PMreportDepResponse">หน่วยงานรับงาน</label>
                  <div style="position: relative; width: 100% !important;">
                    <select id="PMreportDepResponse" class="select" style="width:250px">
                    </select>
                    <button type="button" id="PMreportDepResponseReset" class="close" style="position: absolute; right: 25px; top: 1px;"><span aria-hidden="true">&times;</span></button>
                  </div>
                </div>

                <div class="input-group">
                  <label class="col-sm-5 col-form-label" for="PMreportUser">ผู้จัดทำแผน <span class="pl-1 text-danger">*</span></label>
                  <select id="PMreportUser" class="select" style="width:250px" required>
                  </select>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer justify-content-end">
        <div class="row">
          <div class="col-sm-10" >
            <button id="PMreportBtn" type="button" class="btn btn-primary btn-lg size-btn"><i class="fa fa-print fa-lg"></i>&nbsp; พิมพ์</button>
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
                <input id="modalAreaSearchAreaCode" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">description</label>
              <div class="col-sm-8">
                <input id="modalAreaSearchAreaName" type="text" class="form-control" autocomplete="off">
              </div>
            </div>
          </div>
          <div class="col-lg-7">
            <div class="text-right">
              <button id="modalSearchAreaLov" class="btn btn-default btn-lg size-btn" role="button" aria-pressed="true">
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
