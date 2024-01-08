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
                                ค้นหาแผนการผลิตประจำปักษ์ :
                            </label>
                            <div class="input-group col-lg-7">
                                <input type="text" class="col-lg-12 form-control" id="input1" placeholder="Search">
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#SearchModal2"><i class="fa fa-search"></i>
                                     </button>
                                </span>

                                <!-- Modal ค้นหาแผนการผลิตประจำปักษ์์-->
                                <div class="modal fade" id="SearchModal2" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog search-modal" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="SearchModal2Label">
                                                    ค้นหาแผนการผลิตประจำปักษ์ </h3>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-sm table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th>ปรับแผนการผลิตประจำปักษ์</th>
                                                        <th>สถานะ</th>
                                                        <th>วันที่แก้ไขล่าสุด</th>
                                                        <th>อายุการใช้งาน</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-left">ปีงบประมาณ 2564 เดือน ตุลาคม ครั้งที่ 1
                                                        </td>
                                                        <td>Active</td>
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
                                                        <td>Active</td>
                                                        <td>20/10/2020</td>
                                                        <td>-</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                                <div class="form-group row mt-4">
                                                    <div class="col-lg-12 text-center">
                                                        <button type="button" class="btn btn-primary col-lg-4 p-2">
                                                            <i class="fa fa-check"></i>ตกลง
                                                        </button>
                                                        <button type="button" class="btn btn-danger col-lg-4 p-2"
                                                                data-dismiss="modal">
                                                            <i class="fa fa-times"></i>ยกเลิก
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
                        <h5>ปรับแผนการผลิตประจำปักษ์</h5>
                    </div>
                    <div class="col-lg-8">
                        <div class="text-right">
                            <button type="submit" class="btn btn-w-m btn-success">
                                <i class="fa fa-plus" aria-hidden="true"></i> ปรับแผน
                            </button>
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
                            <label class="col-lg-3 col-form-label">
                                ปีงบประมาณ
                            </label>
                            <label class="col-lg-3 col-form-label text-danger">
                                2564
                            </label>

                            <label class="col-lg-3 col-form-label">
                                ประจำเดือน
                            </label>

                            <label class="col-lg-3 col-form-label text-danger">
                                พฤศจิกายน
                            </label>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">
                                ปักษ์ที่
                            </label>
                            <label class="col-lg-3 col-form-label text-danger">
                                3
                            </label>

                            <label class="col-lg-3 col-form-label">
                                ปรับครั้งที่
                            </label>

                            <label class="col-lg-3 col-form-label text-danger">
                                1
                            </label>
                        </div>

                        <div class="form-group row ">
                            <label class="col-lg-3 col-form-label" for="textarea1">
                                หมายเหตุ
                            </label>
                            <div class="col-lg-9">
                                <textarea class="form-control" id="textarea1" rows="5"></textarea>
                            </div>

                        </div>
                    </div>


                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label" for="input2">
                                วันที่สร้าง
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="date" id="input2">
                            </div>
                            <label class="col-lg-2 col-form-label" for="input3">
                                วันที่แก้ไขล่าสุด
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="date" id="input3">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label" for="input4">
                                สถานะ
                            </label>
                            <div class="col-lg-4">
                                <select class="form-control m-b" name="status" id="input4">
                                    <option>Inactive</option>
                                    <option>Active</option>
                                    <option>option 3</option>
                                    <option>option 4</option>
                                </select>
                            </div>
                            <label class="col-lg-2 col-form-label" for="input5">
                                ผู้บันทึก
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="text" id="input5">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label" for="input6">
                                วันที่อนุมัติ
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="date" id="input6">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Table 1-->
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="col-lg-12 text-right mt-3 mb-3">
                            หน่วย : ล้านมวน
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr class="tr-header">
                                    <th rowspan="2">ตราบุหรี่</th>
                                    <th rowspan="2">คงคลัง</th>
                                    <th rowspan="2">เฉลี่ยขายย้อนหลัง<br> (ล้านมวน)</th>
                                    <th colspan="3">ปักษ์ที่ 3</th>
                                    <th rowspan="2">คงคลังสิ้นปักษ์</th>
                                    <th rowspan="2">พอจำหน่าย (วัน)</th>
                                    <th colspan="3">ปักษ์ที่ 3 (ปรับ)</th>
                                    <th rowspan="2">คงคลังสิ้นปักษ์</th>
                                    <th rowspan="2">พอจำหน่าย (วัน)</th>
                                </tr>
                                <tr>
                                    <th style="min-width: 120px;">สั่งผลิต</th>
                                    <th style="min-width: 120px;">วันขาย</th>
                                    <th style="min-width: 120px;">ประมาณขาย</th>
                                    <th style="min-width: 120px;">สั่งผลิต</th>
                                    <th style="min-width: 120px;">วันขาย</th>
                                    <th style="min-width: 120px;">ประมาณขาย</th>
                                </tr>

                                </thead>
                                <tbody>
                                <tr>
                                    <td class="text-center" rowspan="3" style="min-width:100px"> บุหรี่ 7.8</td>
                                    <td class="text-left" style="min-width:200px"> สายฝน 90</td>
                                    <td class="text-right">2.66</td>
                                    <td class="text-right">2.66</td>
                                    <td class="text-right">1.66</td>
                                    <td class="text-right">1.0</td>
                                    <td class="text-right">26.5</td>
                                    <td class="text-right">62.43</td>
                                    <td class="text-right">1.66</td>
                                    <td class="text-right">1.0</td>
                                    <td class="text-right">26.5</td>
                                    <td class="text-right">26.5</td>
                                    <td class="text-right">62.43</td>
                                </tr>

                                <tr>
                                    <td class="text-left" style="min-width:200px">WONDER S ซองสีแดง</td>
                                    <td class="text-right">22.66</td>
                                    <td class="text-right">23.46</td>
                                    <td class="text-right">144.66</td>
                                    <td class="text-right">132.0</td>
                                    <td class="text-right">526.5</td>
                                    <td class="text-right">762.43</td>
                                    <td class="text-right">31.66</td>
                                    <td class="text-right">331.0</td>
                                    <td class="text-right">526.5</td>
                                    <td class="text-right">662.43</td>
                                    <td class="text-right">726.5</td>
                                </tr>

                                <tr>
                                    <td class="text-left" style="min-width:200px">รวมทั้งหมด</td>
                                    <td class="text-right table-success">1,897,265</td>
                                    <td class="text-right table-success">3,600,000</td>
                                    <td class="text-right table-success">4054</td>
                                    <td class="text-right table-success">95,225,600</td>
                                    <td class="text-right table-success">534</td>
                                    <td class="text-right table-success">4,543</td>
                                    <td class="text-right table-success">4,534,535,345</td>
                                    <td class="text-right table-success">3,342,424</td>
                                    <td class="text-right table-success">345</td>
                                    <td class="text-right table-success">3,342,424</td>
                                    <td class="text-right table-success">345</td>
                                </tr>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- End Table 1-->

        <!-- Table 2-->

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="col-lg-12 text-right mt-3 mb-3">
                            หน่วย : ล้านชิ้น
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered">

                                <!--  Table ประมาณการผลิต-->
                                <thead>
                                <tr class="tr-header">
                                    <th style="width: 33%">ประมาณการผลิต</th>
                                    <th style="width: 33%">ปักษ์ที่ 3</th>
                                    <th style="width: 33%">ปักษ์ที่ 3 (ปรับแผน)</th>
                                </tr>

                                </thead>
                                <tbody>
                                <tr>
                                    <td class="text-left">ก้นกรอง (Mono Acetate)</td>
                                    <td class="text-right">69.00</td>
                                    <td class="text-right">2.66</td>
                                </tr>

                                <tr>
                                    <td class="text-left">ก้นกรอง (Menthol)</td>
                                    <td class="text-right">17.00</td>
                                    <td class="text-right">17.66</td>
                                </tr>

                                <tr>
                                    <td class="text-right">รวม</td>
                                    <td class="text-right table-success">17.00</td>
                                    <td class="text-right table-success">17.66</td>
                                </tr>
                                </tbody>
                                <!--End Table ประมาณการผลิต-->

                                <!-- Table ประมาณการใช้ -->

                                <thead>
                                <tr class="tr-header">
                                    <th style="width: 33%">ประมาณการใช้</th>
                                    <th style="width: 33%">ปักษ์ที่ 3</th>
                                    <th style="width: 33%">ปักษ์ที่ 3 (ปรับแผน)</th>
                                </tr>

                                </thead>
                                <tbody>
                                <tr>
                                    <td class="text-left">ก้นกรอง (Mono Acetate) 7.1</td>
                                    <td class="text-right">69.00</td>
                                    <td class="text-right">2.66</td>
                                </tr>

                                <tr>
                                    <td class="text-left">ก้นกรอง (Menthol) 7.1</td>
                                    <td class="text-right">17.00</td>
                                    <td class="text-right">17.66</td>
                                </tr>

                                <tr>
                                    <td class="text-right">รวม</td>
                                    <td class="text-right table-success">17.00</td>
                                    <td class="text-right table-success">17.66</td>
                                </tr>
                                </tbody>
                                <!-- End Table ประมาณการใช้ -->

                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- End Table 2-->

        <!-- Table 3-->

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-sm-12">
                                <div class="row">
                                    <label class="col-lg-2 col-form-label" for="input8">เดือน</label>
                                    <div class="col-lg-5">
                                        <select class="form-control" name="month" id="input8">
                                            <option>พฤศจิกายน</option>
                                            <option>ธันวาคม</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-5">
                                        <button type="button" class="btn btn-warning col-lg-12 btn-lg">
                                            <i class="fa fa-edit"></i> แก้ไขแผนการผลิตรายวัน
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-bordered">

                                <!--  Table -->
                                <thead>
                                <tr class="tr-header">
                                    <th style="min-width: 120px;" colspan="2"></th>
                                    <th style="min-width: 120px">5-Nov-20</th>
                                    <th style="min-width: 120px">6-Nov-20</th>
                                    <th style="min-width: 120px">7-Nov-20</th>
                                    <th style="min-width: 120px">8-Nov-20</th>
                                    <th style="min-width: 120px">9-Nov-20</th>
                                    <th style="min-width: 120px">10-Nov-20</th>
                                    <th style="min-width: 120px">11-Nov-20</th>
                                    <th style="min-width: 120px">12-Nov-20</th>
                                    <th style="min-width: 120px">13-Nov-20</th>
                                    <th style="min-width: 120px">14-Nov-20</th>
                                    <th style="min-width: 120px">15-Nov-20</th>
                                    <th style="min-width: 120px">16-Nov-20</th>
                                </tr>
                                <tr>
                                    <th class="text-left" colspan="2">ขอบเขตเครื่องจักร</th>
                                    <th class="text-right">9</th>
                                    <th class="text-right">9</th>
                                    <th class="text-right bg-success">0</th>
                                    <th class="text-right bg-success">0</th>
                                    <th class="text-right">9</th>
                                    <th class="text-right">9</th>
                                    <th class="text-right">9</th>
                                    <th class="text-right">9</th>
                                    <th class="text-right">9</th>
                                    <th class="text-right bg-success">0</th>
                                    <th class="text-right bg-success">0</th>
                                    <th class="text-right">9</th>
                                </tr>

                                </thead>
                                <tbody>
                                <!-- Row1-->
                                <tr>
                                    <td class="text-center" rowspan="2">1</td>
                                    <td class="text-left" rowspan="2" style="min-width: 350px;">F6 - L1 (P 90 E No.1 - 2
                                        & G.D.121 No.3 - 4)
                                    </td>
                                    <td class="text-center table-active" colspan="2">sms เขียว 61.45</td>
                                    <td class="text-center bg-primary" colspan="10">sms เขียว 61.45</td>
                                </tr>

                                <tr>
                                    <td class="text-right">17.00</td>
                                    <td class="text-right">17.66</td>
                                    <td class="text-right bg-success"></td>
                                    <td class="text-right bg-success"></td>
                                    <td class="text-right">17.00</td>
                                    <td class="text-right">17.66</td>
                                    <td class="text-right">17.00</td>
                                    <td class="text-right">17.66</td>
                                    <td class="text-right">17.00</td>
                                    <td class="text-right bg-success"></td>
                                    <td class="text-right bg-success"></td>
                                    <td class="text-right">17.66</td>
                                </tr>
                                <!-- End Row1-->

                                <!-- Row2-->
                                <tr>
                                    <td class="text-center" rowspan="2">2</td>
                                    <td class="text-left" rowspan="2" style="min-width: 350px;">F6 - L4 (P 90 No.17 -
                                        20)
                                    </td>
                                    <td class="text-center table-active" colspan="2">sms แดง 55.30</td>
                                    <td class="text-center bg-danger" colspan="10">sms แดง 55.30</td>

                                </tr>

                                <tr>
                                    <td class="text-right">17.00</td>
                                    <td class="text-right">17.66</td>
                                    <td class="text-right bg-success"></td>
                                    <td class="text-right bg-success"></td>
                                    <td class="text-right">17.00</td>
                                    <td class="text-right">17.66</td>
                                    <td class="text-right">17.00</td>
                                    <td class="text-right">17.66</td>
                                    <td class="text-right">17.00</td>
                                    <td class="text-right bg-success"></td>
                                    <td class="text-right bg-success"></td>
                                    <td class="text-right">17.66</td>
                                </tr>

                                <!-- End Row2-->
                                </tbody>
                                <!--End Table เดือน-->
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- End Table 3-->

        <!-- Table 4-->

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-sm-12">
                                <div class="row">
                                    <div class="col-lg-5">
                                        <label class="col-lg-12">
                                            <select class="form-control" name="sms">
                                                <option>SMS เขียว</option>
                                                <option>SMS แดง</option>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-bordered table-fixed">

                                <!--  Table -->
                                <thead>
                                <tr class="tr-header">
                                    <th style="min-width: 220px;"></th>
                                    <th style="min-width: 120px">5-Nov-20</th>
                                    <th style="min-width: 120px">6-Nov-20</th>
                                    <th style="min-width: 120px">7-Nov-20</th>
                                    <th style="min-width: 120px">8-Nov-20</th>
                                    <th style="min-width: 120px">9-Nov-20</th>
                                    <th style="min-width: 120px">10-Nov-20</th>
                                    <th style="min-width: 120px">11-Nov-20</th>
                                    <th style="min-width: 120px">12-Nov-20</th>
                                    <th style="min-width: 120px">13-Nov-20</th>
                                    <th style="min-width: 120px">14-Nov-20</th>
                                    <th style="min-width: 120px">15-Nov-20</th>
                                    <th style="min-width: 120px">16-Nov-20</th>
                                </tr>

                                </thead>
                                <tbody>
                                <!-- Row-->
                                <tr>
                                    <td class="text-right">คงคลังเข้าเช้า</td>
                                    <td class="text-right">17.00</td>
                                    <td class="text-right">27.66</td>
                                    <td class="text-right">57.00</td>
                                    <td class="text-right">77.66</td>
                                    <td class="text-right">47.00</td>
                                    <td class="text-right bg-success">187.66</td>
                                    <td class="text-right bg-success">187.00</td>
                                    <td class="text-right">417.66</td>
                                    <td class="text-right">47.00</td>
                                    <td class="text-right">187.66</td>
                                    <td class="text-right bg-success">187.00</td>
                                    <td class="text-right bg-success">417.66</td>
                                </tr>

                                <tr>
                                    <td class="text-right">ขาย</td>
                                    <td class="text-right">17.00</td>
                                    <td class="text-right">27.66</td>
                                    <td class="text-right">57.00</td>
                                    <td class="text-right">77.66</td>
                                    <td class="text-right">47.00</td>
                                    <td class="text-right bg-success">187.66</td>
                                    <td class="text-right bg-success">187.00</td>
                                    <td class="text-right">417.66</td>
                                    <td class="text-right">47.00</td>
                                    <td class="text-right">187.66</td>
                                    <td class="text-right bg-success">187.00</td>
                                    <td class="text-right bg-success">417.66</td>
                                </tr>
                                <!-- End Row-->


                                </tbody>
                                <!--End Table เดือน-->
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- End Table 4-->
    </div>
</template>


<style scoped>

.table-fixed th:first-child, .table-fixed td:first-child {
    position: sticky;
    left: 0;
    background-color: #f5f5f6;
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
.modal-body {
    padding: 15px !important;
}
</style>
