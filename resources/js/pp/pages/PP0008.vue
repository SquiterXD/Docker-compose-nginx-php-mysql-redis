<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-lg-6">
                                <h5>กองวางแผนและบริหารผลิตภัณฑ์</h5>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <label class="col-lg-3 col-form-label text-right" for="select1">
                                        รายงาน :
                                    </label>
                                    <div class="input-group col-lg-9">
                                        <select class="form-control m-b" name="select1" id="select1">
                                            <option>ประมาณการจำหน่ายประจำปี</option>
                                        </select>
                                        <button type="button" class="btn btn-w-m btn-default btn-search"
                                                data-toggle="modal"
                                                data-target=".bd-example-modal-lg"><i
                                            class="fa fa-search"></i>
                                            ค้นหา
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>ชื่อรายงาน</th>
                                        <th>ประเภท</th>
                                        <th>หมายเหตุ</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>PP_REP01</td>
                                        <td>รายงานผลผลิตประจำเดือน(WIP)</td>
                                        <td>pdf/excel</td>
                                        <td>รอตัวอย่างเอกสาร</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal ค้นหาแผนการผลิตรายปักษ์-->
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
             aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 id="SearchModal2Label" class="modal-title">
                            ค้นหา</h3>
                        <button type="button" data-dismiss="modal" aria-label="Close"
                                class="close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class=" row">
                            <div class="col-lg-12 col-sm-12 pl-5">
                                <div class="form-group row">
                                    <label class="col-lg-2 col-form-label" for="select2">
                                        ปีงบประมาณ
                                    </label>
                                    <div class="input-group col-lg-7">
                                        <select class="form-control m-b" name="select2" id="select2">
                                            <option>2562</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-2">
                                        <button type="button" class="btn btn-w-m btn-default btn-search"
                                                data-toggle="modal"
                                                data-target=".bd-example-modal-lg"><i
                                            class="fa fa-search"></i>
                                            ค้นหา
                                        </button>
                                    </div>
                                </div>
                                <div class="text-center pt-3">
                                    <button type="button" class="btn btn-w-m btn-info"><i class="fa fa-print"></i> พิมพ์
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
</script>
<style scoped>
th,
td {
    vertical-align: middle !important;
    text-align: center;
}
.btn-search {
    height: 40px;
}
.modal-dialog.modal-lg {
    height: 80%;
    top: 10%;
}

</style>
