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
                            <label class="col-lg-6 col-form-label text-right" for="input1">
                                ค้นหาประมาณการจัดซื้อแสตมป์ :
                            </label>
                            <div class="input-group col-lg-6">
                                <input type="text" class="col-lg-12 form-control" id="input1" placeholder="Search">
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#SearchModal2"><i class="fa fa-search"></i>
                                     </button>
                                </span>

                                <!-- Modal ค้นหาประมาณการจัดซื้อแสตมป์-->
                                <div class="modal fade" id="SearchModal2" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog search-modal" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="SearchModal2Label">
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
                                                        <th>ปริมาณการจัดซื้อแสตมป์</th>
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
                        <h5>ประมาณการจัดซื้อแสตมปืรายเดือน</h5>
                    </div>
                    <div class="col-lg-8">
                        <div class="text-right">
                            <button class="btn btn-w-m btn-success" data-toggle="modal" data-target="#ModalCreate">
                                <i class="fa fa-plus"></i> สร้าง
                            </button>
                            <button type="submit" class="btn btn-w-m btn-warning" data-toggle="modal"
                                    data-target="#ModalEdit">
                                <i class="fa fa-edit" aria-hidden="true"></i> แก้ไข
                            </button>
                            <button type="submit" class="btn btn-w-m btn-primary">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก
                            </button>

                            <button type="submit" class="btn btn-w-m btn-default" data-toggle="modal"
                                    data-target="#ModalCopy">
                                <i class="fa fa-copy" aria-hidden="true"></i><strong> คัดลอกแผน</strong>
                            </button>
                            <button type="submit" class="btn btn-w-m btn-info">
                                <i class="fa fa-print"></i> พิมพ์
                            </button>
                        </div>
                    </div>

                    <!-- Modal Create-->
                    <div class="modal fade" id="ModalCreate" tabindex="-1" role="dialog"
                         aria-labelledby="ModalCreateLabel"
                         aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="ModalCreateLabel">สร้างประมาณการจัดซื้อแสตมป์รายเดือน</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <label class="col-lg-6 col-form-label" for="input2">
                                            ปีงบประมาณ
                                        </label>
                                        <div class="col-lg-6">
                                            <select class="form-control m-b" name="input2" id="input2">
                                                <option>ปี 2564 เดือน พฤสจิกายน</option>
                                                <option>ปี 2564 เดือน ธันวาคม</option>
                                                <option>ปี 2565 เดือน พฤสจิกายน</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-6 col-form-label" for="input3">
                                            ประมาณการใช้แสตมป์จากแผนการผลิตประจำปักษ์
                                        </label>
                                        <div class="col-lg-6">
                                            <select class="form-control m-b" name="input3" id="input3">
                                                <option> ปักษืที่ 3 ครั้งที่ 1</option>
                                                <option> ปักษืที่ 3 ครั้งที่ 2</option>
                                                <option> ปักษืที่ 3 ครั้งที่ 3</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row mt-3">
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
                    <!--End Modal Create -->

                    <!-- Edit plan-->
                    <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="ModalEditLabel"
                         aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="ModalEditLabel">แก้ไขประมาณการจัดซื้อรายเดือน</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center">
                                        <h2>
                                            เนื่องจากประมาณการมีสถานะ Active ยืนยันที่จะแก้ไขประมาณการ
                                        </h2>

                                    </div>
                                    <div class="form-group row mt-3">
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
                    <!--End Modal Edit plan -->

                    <!-- Modal Copy plan-->
                    <div class="modal fade" id="ModalCopy" tabindex="-1" role="dialog" aria-labelledby="ModalCopy"
                         aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="ModalCopyLabel">
                                        คัดลอกประมาณการจัดซื้อแสตมป์รายเดือน</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <label class="col-lg-6 col-form-label" for="input4">
                                            จากประมาณการจัดซื้อแสตมป์รายเดือน
                                        </label>
                                        <div class="col-lg-6">
                                            <select class="form-control m-b" name="input4" id="input4">
                                                <option>ปีงบประมาร 2564 เดือน พฤสจิกายน ครั้งที่ 1</option>
                                                <option>ปีงบประมาร 2564 เดือน พฤสจิกายน ครั้งที่ 2</option>
                                                <option>ปีงบประมาร 2564 เดือน พฤสจิกายน ครั้งที่ 3</option>
                                            </select>
                                        </div>

                                        <label class="col-lg-6 col-form-label" for="input5">
                                            เป็นประมาณการจัดซื้อแสตมป์รายเดือน
                                        </label>
                                        <div class="col-lg-6">
                                            <select class="form-control m-b" name="input5" id="input5">
                                                <option>ปีงบประมาร 2564 เดือน พฤสจิกายน ครั้งที่ 1</option>
                                                <option>ปีงบประมาร 2564 เดือน พฤสจิกายน ครั้งที่ 2</option>
                                                <option>ปีงบประมาร 2564 เดือน พฤสจิกายน ครั้งที่ 3</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row mt-3">
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
                    <!--End Modal Create -->
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">

                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label">
                                ปีงบประมาณ
                            </label>
                            <label class="col-lg-2 col-form-label text-danger">
                                2564
                            </label>

                            <label class="col-lg-2 col-form-label">
                                ประจำเดือน
                            </label>

                            <label class="col-lg-2 col-form-label text-danger">
                                พฤศจิกายน
                            </label>

                            <label class="col-lg-2 col-form-label">
                                ครั้งที่
                            </label>

                            <label class="col-lg-2 col-form-label text-danger">
                                1
                            </label>
                        </div>

                        <div class="form-group row ">
                            <label class="col-lg-5 col-form-label">
                                ประมาณการใช้จากแผนผลิตรายปักษ์
                            </label>
                            <label class="col-lg-7 col-form-label text-danger">
                                ปักษ์ที่ 3 ครั้งที่ 1
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
                                สถานะ
                            </label>
                            <div class="col-lg-4">
                                <select class="form-control m-b" name="status" id="input8">
                                    <option>Inactive</option>
                                    <option>Active</option>
                                    <option>option 3</option>
                                    <option>option 4</option>
                                </select>
                            </div>
                            <label class="col-lg-2 col-form-label" for="input9">
                                ผู้บันทึก
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="text" id="input9">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label" for="input10">
                                วันที่อนุมัติ
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="date" id="input10">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <!-- Tab-->
                        <div class="tabs-container tab-custom">
                            <!-- link tab -->
                            <ul class="nav nav-tabs">
                                <li><a class="nav-link active" data-toggle="tab" href="#tab-1">ประมาณการจัดซื้อแสตมปรายตรา</a>
                                </li>
                                <li><a class="nav-link" data-toggle="tab"
                                       href="#tab-2">รวมประมาณการจัดซื้อแสตมป์รายตรา</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-3">ประมาณการจัดซื้อแสตมป์ตามกลุ่มราคา</a>
                                </li>
                            </ul>
                            <!-- end link tab -->
                            <div class="tab-content in-tab-custom">
                                <div id="tab-1" class="tab-pane active">
                                    <!-- content tab1 -->
                                    <div class="panel-body">
                                        <div class="row mt-3">
                                            <div class="col-lg-3 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-5 col-form-label" for="select2">
                                                        ประเภทแสตมป์
                                                    </label>
                                                    <div class="col-lg-7">
                                                        <select class="form-control m-b" name="select2" id="select2">
                                                            <option>95 ม้วน</option>
                                                            <option>195 ม้วน</option>
                                                            <option>555 ม้วน</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="select3">
                                                        ตราบุหรี่
                                                    </label>
                                                    <div class="col-lg-7">
                                                        <select class="form-control m-b" name="select3" id="select3">
                                                            <option>กรองทิพย์ 90</option>
                                                            <option>กรองทิพย์ 90</option>
                                                            <option>กรองทิพย์ 90</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label" for="input11">
                                                        ม้วนละ
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" type="text" id="input11">
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">
                                                        ดวง
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="input12">
                                                        ราคาต่อดวง
                                                    </label>
                                                    <div class="col-lg-5">
                                                        <input class="form-control" type="text" id="input12">
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">
                                                        บาท
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- table1 -->
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr class="tr-header">
                                                    <th rowspan="2" style=""> วันที่</th>
                                                    <th rowspan="2" style="min-width: 150px"> คงคลังเช้า (ดวง)
                                                    </th>
                                                    <th colspan="3" style=""> รับเข้า</th>
                                                    <th rowspan="2" style="min-width: 150px"> ประมาณการใช้
                                                        (ดวง)
                                                    </th>
                                                    <th colspan="2" style=""> คงคลังเย็น</th>
                                                    <th rowspan="2" style=""> พอใช้ (วัน)</th>

                                                </tr>
                                                <tr class="tr-header">
                                                    <th style="min-width: 120px">ดวง</th>
                                                    <th style="min-width: 120px"> ม้วน</th>
                                                    <th style="min-width: 120px"> จำนวนเงิน</th>
                                                    <th style="min-width: 150px"> ดวง</th>
                                                    <th style="min-width: 120px"> ม้วน</th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="text-left">11/1/2563</td>
                                                    <td class="text-right">89,7265.00</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">897,265.00</td>
                                                    <td class="text-right">22.43</td>
                                                    <td class="text-right">3.89</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">11/1/2563</td>
                                                    <td class="text-right">89,7265.00</td>
                                                    <td class="text-right">40.00</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">95,225,600.00</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">897,265.00</td>
                                                    <td class="text-right">22.43</td>
                                                    <td class="text-right">3.89</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">11/1/2563</td>
                                                    <td class="text-right">89,7265.00</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">897,265.00</td>
                                                    <td class="text-right">22.43</td>
                                                    <td class="text-right">3.89</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">11/1/2563</td>
                                                    <td class="text-right">89,7265.00</td>
                                                    <td class="text-right">40.00</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">95,225,600.00</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">897,265.00</td>
                                                    <td class="text-right">22.43</td>
                                                    <td class="text-right">3.89</td>
                                                </tr>
                                                <tr class="table-fixed">
                                                    <td class="text-right table-success" colspan="2">รวม</td>
                                                    <td class="text-right table-success">89,7265.00</td>
                                                    <td class="text-right table-success">-</td>
                                                    <td class="text-right table-success">897,265.00</td>
                                                    <td class="text-right table-success">-</td>
                                                    <td colspan="3"></td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- End  table1 -->

                                    </div>
                                </div>
                                <!-- End content tab1 -->

                                <!-- Content tab2 -->
                                <div id="tab-2" class="tab-pane">
                                    <div class="panel-body">

                                        <!-- table -->

                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr class="tr-header">
                                                    <th style="min-width:120px">   </th>
                                                    <th> TUK TUK  </th>
                                                    <th>กรองพิพย์90</th>
                                                    <th>สามิต90</th>
                                                    <th>สายฝน90</th>
                                                    <th>กรุงทอง90</th>
                                                    <th>SMS แดง ม้วน</th>
                                                    <th> SMS เขียว</th>
                                                    <th>GOAL แดง</th>
                                                    <th> GOAL เขียว</th>
                                                    <th>LINE แดง</th>
                                                    <th> LINE เขียว</th>
                                                    <th>WONDERS แดง </th>
                                                    <th>WONDERS เขียว</th>
                                                    <th>LINE 7.1 แดง</th>
                                                    <th> LINE 7.1 เขียว</th>
                                                    <th>KT7.15</th>
                                                    <th> KNIGHT BLUE</th>
                                                    <th>รวม</th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="text-center">1 พ.ย 63</td>
                                                    <td class="text-right">1,6000,000,000</td>
                                                    <td class="text-right">434,345,345</td>
                                                    <td class="text-right">4545,455</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">23,356,546</td>
                                                    <td class="text-right">1,300</td>
                                                    <td class="text-right">2,345,345,345</td>
                                                    <td class="text-right">356,546</td>
                                                    <td class="text-right">56,546</td>
                                                    <td class="text-right">300</td>
                                                    <td class="text-right">2,345,345,345</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">3,443,434</td>
                                                    <td class="text-right">45,345</td>
                                                    <td class="text-right">345,456</td>
                                                    <td class="text-right">34,5345,345,456</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">2 พ.ย 63</td>
                                                    <td class="text-right">356,546</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">3,443,434</td>
                                                    <td class="text-right">45,345</td>
                                                    <td class="text-right">345,456</td>
                                                    <td class="text-right">1,6000,000,000</td>
                                                    <td class="text-right">434,345,345</td>
                                                    <td class="text-right">4545,455</td>
                                                    <td class="text-right">56,546</td>
                                                    <td class="text-right">300</td>
                                                    <td class="text-right">2,345,345,345</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">3,443,434</td>
                                                    <td class="text-right">45,345</td>
                                                    <td class="text-right">345,456</td>
                                                    <td class="text-right">34,5345,345,456</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">3 พ.ย 63</td>
                                                    <td class="text-right">356,546</td>
                                                    <td class="text-right">1,6000,000,000</td>
                                                    <td class="text-right">434,345,345</td>
                                                    <td class="text-right">4545,455</td>
                                                    <td class="text-right">56,546</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">3,443,434</td>
                                                    <td class="text-right">45,345</td>
                                                    <td class="text-right">345,456</td>
                                                    <td class="text-right">300</td>
                                                    <td class="text-right">2,345,345,345</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">3,443,434</td>
                                                    <td class="text-right">45,345</td>
                                                    <td class="text-right">345,456</td>
                                                    <td class="text-right">34,5345,345,456</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center table-success">รวมเดือน พ.ย 63</td>
                                                    <td class="text-right table-success">1,6000,000,000</td>
                                                    <td class="text-right table-success">434,345,345</td>
                                                    <td class="text-right table-success">-</td>
                                                    <td class="text-right table-success">-</td>
                                                    <td class="text-right table-success">300</td>
                                                    <td class="text-right table-success">2,345,345,345</td>
                                                    <td class="text-right table-success">-</td>
                                                    <td class="text-right table-success">4545,455</td>
                                                    <td class="text-right table-success">56,546</td>
                                                    <td class="text-right table-success">300</td>
                                                    <td class="text-right table-success">356,546</td>
                                                    <td class="text-right table-success">2,345,345,345</td>
                                                    <td class="text-right table-success">-</td>
                                                    <td class="text-right table-success">-</td>
                                                    <td class="text-right table-success">3,443,434</td>
                                                    <td class="text-right table-success">45,345</td>
                                                    <td class="text-right table-success">345,456</td>
                                                    <td class="text-right table-success">34,5345,345,456</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>


                                        <!-- End table -->

                                    </div>
                                </div>
                                <!-- End content tab2 -->

                                <!-- Content tab3 -->
                                <div id="tab-3" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="row mt-3">
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-5 col-form-label" for="select4">
                                                        ประเภทแสตมป์
                                                    </label>
                                                    <div class="col-lg-7">
                                                        <select class="form-control m-b" name="select4" id="select4">
                                                            <option>95 ม้วน</option>
                                                            <option>195 ม้วน</option>
                                                            <option>555 ม้วน</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label" for="input13">
                                                        ม้วนละ
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" type="text" id="input13">
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">
                                                        ดวง
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="input14">
                                                        ราคาต่อดวง
                                                    </label>
                                                    <div class="col-lg-5">
                                                        <input class="form-control" type="text" id="input14">
                                                    </div>
                                                    <label class="col-lg-2 col-form-label">
                                                        บาท
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- table -->
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr class="tr-header">
                                                    <th rowspan="2" style=""> วันที่</th>
                                                    <th rowspan="2" style="min-width: 150px"> คงคลังเช้า (ดวง)
                                                    </th>
                                                    <th colspan="3" style=""> รับเข้า</th>
                                                    <th rowspan="2" style="min-width: 150px"> ประมาณการใช้
                                                        (ดวง)
                                                    </th>
                                                    <th colspan="2" style=""> คงคลังเย็น</th>
                                                    <th rowspan="2" style=""> พอใช้ (วัน)</th>

                                                </tr>
                                                <tr class="tr-header">
                                                    <th style="min-width: 120px">ดวง</th>
                                                    <th style="min-width: 120px"> ม้วน</th>
                                                    <th style="min-width: 120px"> จำนวนเงิน</th>
                                                    <th style="min-width: 150px"> ดวง</th>
                                                    <th style="min-width: 120px"> ม้วน</th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="text-left">11/1/2563</td>
                                                    <td class="text-right">89,7265.00</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">897,265.00</td>
                                                    <td class="text-right">22.43</td>
                                                    <td class="text-right">3.89</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">11/1/2563</td>
                                                    <td class="text-right">89,7265.00</td>
                                                    <td class="text-right">40.00</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">95,225,600.00</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">897,265.00</td>
                                                    <td class="text-right">22.43</td>
                                                    <td class="text-right">3.89</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">11/1/2563</td>
                                                    <td class="text-right">89,7265.00</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">897,265.00</td>
                                                    <td class="text-right">22.43</td>
                                                    <td class="text-right">3.89</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-left">11/1/2563</td>
                                                    <td class="text-right">89,7265.00</td>
                                                    <td class="text-right">40.00</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">95,225,600.00</td>
                                                    <td class="text-right">-</td>
                                                    <td class="text-right">897,265.00</td>
                                                    <td class="text-right">22.43</td>
                                                    <td class="text-right">3.89</td>
                                                </tr>
                                                <tr class="table-fixed">
                                                    <td class="text-right table-success" colspan="2">รวม</td>
                                                    <td class="text-right table-success">89,7265.00</td>
                                                    <td class="text-right table-success">-</td>
                                                    <td class="text-right table-success">897,265.00</td>
                                                    <td class="text-right table-success">-</td>
                                                    <td colspan="3"></td>
                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- End table -->

                                    </div>
                                </div>
                                <!-- End content tab3 -->

                            </div>
                        </div>
                        <!-- end tab -->

                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<style scoped>
tr.table-fixed {
    position: sticky;
    /*left: 0;*/
    background-color: #fff;
}

.tab-custom ul.nav.nav-tabs li {
    width: 33.33%;
    text-align: center;
}

.tabs-container.tab-custom .panel-body {
    border: 1px solid #ffffff !important;
    border-radius: 2px !important;
    padding: 20px 0 !important;
}

.tab-custom .nav-tabs .nav-item.show .nav-link,
.tab-custom .nav-tabs .nav-link.active {
    color: #ffffff;
    background-color: #19b394;
    border-color: #19b394 #19b394 #fff;
    padding-top: 15px !important;
    padding-bottom: 15px !important;
}

.tab-custom .nav-tabs .nav-link {
    border: 1px solid transparent !important;
    padding-top: 15px !important;
    padding-bottom: 15px !important;
}

.tabs-container .tab-content. .in-tab-custom .panel-body {
    border: 0 !important;
    padding: 20px 0 !important;
}

.modal-body {
    padding: 15px !important;
}

/* modal กลางหน้าจอ */
.modal-dialog {
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
