<template>
    <div>
        <div class="ibox ">
            <div class="ibox-title">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h5>กองวางแผนและบริหารผลิตภัณฑ์</h5>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <label class="col-lg-5 col-form-label text-right" for="input1">
                                ค้นหาประมาณการจัดซื้อแสตมป์ :
                            </label>
                            <div class="input-group col-lg-7">
                                <input type="text" class="col-lg-12 form-control" id="input1">
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#SearchModal"><i class="fa fa-search"></i>
                                        </button>
                                </span>

                                <!-- Modal ค้นหาประมาณการจัดซื้อแสตมปื -->
                                <div class="modal fade" id="SearchModal" tabindex="-1" role="dialog"
                                     aria-labelledby="SearchModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog search-modal" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="SearchModalLabel">
                                                    ค้นหาประมาณการจัดซื้อแสตมป์</h3>
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
        </div>

        <div class="ibox ">
            <div class="ibox-title">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <h5>ติดตามการใช้แสตมป์รายวัน</h5>
                    </div>
                    <div class="col-lg-8">
                        <div class="text-right">
                            <button type="submit" class="btn btn-w-m btn-primary">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก
                            </button>
                            <button type="submit" class="btn btn-w-m btn-info">
                                <i class="fa fa-print"></i> พิมพ์
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ibox-content pt-4">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group row">
                            <span class="col-lg-5 col-form-label">
                              ประมาณการจัดซื้อแสตมป์รายเดือน
                            </span>
                            <span class="col-lg-7 col-form-label text-success">
                                ปีงบประมาณ 2564 เดือน พฤศจิกายน ครั้งที่ 1
                            </span>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-5 col-form-label" for="input2">
                                ประเภทแสตมป์
                            </label>
                            <label class="col-lg-6 col-form-label">
                                <input class="form-control" type="text" id="input2">
                            </label>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-5 col-form-label" for="input4">
                                ม้วนละ
                            </label>
                            <label class="col-lg-5 col-form-label">
                                <input class="form-control" type="text" id="input4">
                            </label>
                            <label class="col-lg-2 col-form-label">
                                ดวง
                            </label>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-5 col-form-label" for="input5">
                                ราคาต่อดวง
                            </label>
                            <label class="col-lg-5 col-form-label">
                                <input class="form-control" type="text" id="input5">
                            </label>
                            <label class="col-lg-2 col-form-label">
                                บาท
                            </label>
                        </div>

                    </div>


                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label" for="input6">
                                วันที่สร้าง
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="date" id="input6">
                            </div>
                            <label class="col-lg-2 col-form-label" for="input7">
                                วันที่แก้ไขล่าสุด
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="date" id="input7">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label" for="input8">
                                วันที่ปัจจุบัน
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="date" id="input8">
                            </div>
                            <label class="col-lg-2 col-form-label" for="input9">
                                ผู้บันทึก
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="text" id="input9">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  Table1 -->
        <div class="ibox">
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr class="tr-header">
                            <th rowspan="2" style="min-width: 100px">วันที่</th>
                            <th rowspan="2" style="min-width: 130px;">คงคลังเช้า<br>(ดวง)</th>
                            <th colspan="3">รับเข้า</th>
                            <th rowspan="2" style="min-width: 130px;">รับแสตมป์เคลม</th>
                            <th rowspan="2" style="min-width: 130px;">ใช้จริง<br>(ดวง)</th>
                            <th rowspan="2">สูญหาย <br>(ดวง)</th>
                            <th rowspan="2">ไม่สมบูรณ์ <br>(ดวง)</th>
                            <th rowspan="2" style="min-width: 130px;">รวมใช้จริง <br>(ดวง)</th>
                            <th rowspan="2" style="min-width: 130px;">ประมาณการใช้ <br>(ดวง)</th>
                            <th colspan="2">คงคลัง <br>(ดวง)</th>
                            <th colspan="2">รวมคงคลังเย็น</th>
                            <th rowspan="2" style="min-width: 130px;">พอใช้<br> (วัน)</th>
                        </tr>
                        <tr>
                            <th style="min-width: 120px">ดวง</th>
                            <th style="min-width: 120px">ม้วน</th>
                            <th style="min-width: 120px">จำนวนเงิน</th>
                            <th style="min-width: 120px">ฝ่ายโรงงาน</th>
                            <th style="min-width: 120px">กองคลัง</th>
                            <th style="min-width: 120px">ดวง</th>
                            <th style="min-width: 120px">ม้วน</th>
                        </tr>

                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-left">11/1/2563</td>
                            <td class="text-right">897,265</td>
                            <td class="text-right">1,600,000</td>
                            <td class="text-right">40</td>
                            <td class="text-right">95,225,600</td>
                            <td class="text-right">-</td>
                            <td class="text-right">-</td>
                            <td class="text-right">-</td>
                            <td class="text-right">-</td>
                            <td class="text-right">-</td>
                            <td class="text-right">897,265</td>
                            <td class="text-right">1,600,000</td>
                            <td class="text-right">2,497,265</td>
                            <td class="text-right">62.43</td>
                            <td class="text-right">3.43</td>
                            <td class="text-right">3.43</td>
                        </tr>
                        <tr>
                            <td class="text-left">13/4/2563</td>
                            <td class="text-right">1,897,265</td>
                            <td class="text-right">3,600,000</td>
                            <td class="text-right">4054</td>
                            <td class="text-right">95,225,600</td>
                            <td class="text-right">534</td>
                            <td class="text-right">4,543</td>
                            <td class="text-right">4,534,535,345</td>
                            <td class="text-right">-</td>
                            <td class="text-right">-</td>
                            <td class="text-right">897,265</td>
                            <td class="text-right">1,600,000</td>
                            <td class="text-right">2,497,265</td>
                            <td class="text-right">62.43</td>
                            <td class="text-right">343.43</td>
                            <td class="text-right">333.43</td>
                        </tr>
                        <tr>
                            <td class="text-right" colspan="2">รวม</td>
                            <td class="text-right table-success">1,897,265</td>
                            <td class="text-right table-success">3,600,000</td>
                            <td class="text-right table-success">4054</td>
                            <td class="text-right table-success">95,225,600</td>
                            <td class="text-right table-success">534</td>
                            <td class="text-right table-success">4,543</td>
                            <td class="text-right table-success">4,534,535,345</td>
                            <td class="text-right table-success">345</td>
                            <td class="text-right table-success">3,342,424</td>
                            <td class="text-right" colspan="6"></td>

                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!--  End Table1 -->

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
