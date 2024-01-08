<template>
    <div>
        <div class="ibox">
            <div class="ibox-title">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h5>งบเดือน</h5>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <label class="col-lg-5 col-form-label text-right" for="input10">
                                 การใช้แสตมป์เดือน :
                            </label>
                            <div class="input-group col-lg-7">
                                <input type="text" class="col-lg-12 form-control" id="input10">
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#SearchModal2"><i class="fa fa-search"></i>
                                        </button>
                                </span>

                                <!-- Modal  ค้นหาการใช้แสตมป์เดือน -->
                                <div class="modal fade" id="SearchModal2" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog search-modal" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="SearchModal2Label">
                                                    ค้นหาการใช้แสตมป์เดือน</h3>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-sm table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>ประมาณการจัตซื้อแสตมป์</th>
                                                        <th>สถานะ</th>
                                                        <th>วันที่แก้ไขล่าสุด</th>
                                                        <th>หมดอายุการใช้งาน</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-left">ปีงบประมาณ 2564 เดือน ตุลาคม ครั้งที่ 1
                                                        </td>
                                                        <td>Inactive</td>
                                                        <td>8/10/2019</td>
                                                        <td>Expired</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">ปิงบประมาณ 2563 เดือน ตุลาคม ครั้งที่ 2
                                                        </td>
                                                        <td>Active</td>
                                                        <td>12/10/2019</td>
                                                        <td>Expired</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">บีงบประมาณ 2564 เดือน พฤศจิกายน ครั้งที่
                                                            1
                                                        </td>
                                                        <td>Inactive</td>
                                                        <td>20/10/2020</td>
                                                        <td>-</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <div class="form-group row mt-4">
                                                    <div class="col-lg-12 text-center">
                                                        <button type="button" class="btn btn-primary col-lg-4 p-2"><i
                                                            class="fa fa-check"></i>ตกลง
                                                        </button>
                                                        <button type="button" class="btn btn-danger col-lg-4 p-2"
                                                                data-dismiss="modal"><i
                                                            class="fa fa-times"></i>ยกเลิก
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!--End Modal -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--  Table -->
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr class="tr-header">
                            <th style="min-width: 120px">ตราบุหรี่</th>
                            <th style="min-width: 100px">ใช้เดือนนี้</th>
                            <th style="min-width: 100px">สูญหาย</th>
                            <th style="min-width: 100px">เสียหาย</th>
                            <th style="min-width: 100px">ไม่สมบูรณ์</th>
                            <th style="min-width: 100px">ใช้สะสม</th>
                            <th style="min-width: 100px">สูญหายสะสม</th>
                            <th style="min-width: 100px">เสียหายสะสม</th>
                            <th style="min-width: 100px">ไม่สมบูรณ์สะสม</th>
                            <th style="min-width: 100px">คงเหลือยกมา</th>
                            <th style="min-width: 100px">รับเดือนนี้</th>
                            <th style="min-width: 100px">รวมรับ</th>
                            <th style="min-width: 100px">รวมใช้จริงเดือนนี้</th>
                            <th style="min-width: 100px">คงเหลือยกไป</th>
                        </tr>

                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-center table-warning">กรองทิพย์ 90</td>
                            <td class="text-right">458,358</td>
                            <td class="text-right">456</td>
                            <td class="text-right">400</td>
                            <td class="text-right">95,225,600</td>
                            <td class="text-right table-primary">-</td>
                            <td class="text-right table-primary">43</td>
                            <td class="text-right table-primary">34</td>
                            <td class="text-right table-primary">3,424</td>
                            <td class="text-right">65,546</td>
                            <td class="text-right">897,265</td>
                            <td class="text-right">1,600,000</td>
                            <td class="text-right">2,497,265</td>
                            <td class="text-right">62.43</td>
                        </tr>
                        <tr>
                            <td class="text-center table-warning">สามิต 90</td>
                            <td class="text-right">4,458,358</td>
                            <td class="text-right">456,677</td>
                            <td class="text-right">400,566</td>
                            <td class="text-right">1, 95,225,600</td>
                            <td class="text-right table-primary">-</td>
                            <td class="text-right table-primary">43</td>
                            <td class="text-right table-primary">34</td>
                            <td class="text-right table-primary">3,424</td>
                            <td class="text-right">65,546</td>
                            <td class="text-right">897,265</td>
                            <td class="text-right">1,600,000</td>
                            <td class="text-right">2,497,265</td>
                            <td class="text-right">62.43</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--  End Table-->

    </div>
</template>

<style scoped>
.modal-body {
    padding: 15px !important;
}

/* modal กลางหน้าจอ */
.modal-dialog.search-modal {
    height: 80% !important;
    padding-top: 10%;
}
/* end modal กลางหน้าจอ*/

/*เฉพาะ modal หน้านี้*/
@media (min-width: 576px) {
    .modal-dialog.search-modal {
        max-width: 700px !important;
    }
}
/* end เฉพาะ modal หน้านี้*/

</style>
