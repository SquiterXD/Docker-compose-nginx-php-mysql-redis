<template>
    <div>
        <div class="ibox">
            <div class="ibox-title">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h5> กองวางแผนและบริหารผลิตภัณฑ์ </h5>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <label class="col-lg-6 col-form-label text-right" for="input1">
                                ค้นหาประมาณการผลิตประจำปักษ์ :
                            </label>
                            <div class="input-group col-lg-6">
                                <input type="text" class="col-lg-12 form-control" id="input1" placeholder="Search">
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#SearchModal2"><i class="fa fa-search"></i>
                                     </button>
                                </span>
                            </div>
                            <!-- Modal  ค้นหาประมาณการผลิตประจำปักษ์-->
                            <div class="modal fade" id="SearchModal2" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog search-modal" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="SearchModal2Label">
                                                ค้นหาประมาณการผลิตประจำปักษ์</h3>
                                            <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-sm table-hover">
                                                <thead>
                                                <tr>
                                                    <th>ปริมาณการจผลิตประจำปักษ์</th>
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

        <div class="ibox ">
            <div class="ibox-title">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <h5>ประมาณการผลิตประจำปักษ์ :</h5>
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
                                    <h3 class="modal-title" id="ModalCreateLabel"> สร้างประมาณการผลิตประจำปักษ์</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <label class="col-lg-5 col-form-label" for="input2">
                                            ประมาณการผลิตประจำปักษ์
                                        </label>
                                        <div class="col-lg-7">
                                            <select class="form-control m-b" name="input2" id="input2">
                                                <option>ปี 2564 เดือน พฤสจิกายน ปักษ์ 4</option>
                                                <option>ปี 2564 เดือน ธันวาคม ปักษ์ 4</option>
                                                <option>ปี 2565 เดือน พฤสจิกายน ปักษ์ 4</option>
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
                                    <h3 class="modal-title" id="ModalEditLabel">แก้ไขประมาณการผลิตประจำปักษ์</h3>
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
                                        คัดลอกประมาณการผลิตประจำปักษ์</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <label class="col-lg-6 col-form-label" for="select1">
                                            จากประมาณการผลิตประจำปักษ์
                                        </label>
                                        <div class="col-lg-6">
                                            <select class="form-control m-b" name="select1" id="select1">
                                                <option>ปีงบประมาร 2564 เดือน พฤสจิกายน ครั้งที่ 1</option>
                                                <option>ปีงบประมาร 2564 เดือน พฤสจิกายน ครั้งที่ 2</option>
                                                <option>ปีงบประมาร 2564 เดือน พฤสจิกายน ครั้งที่ 3</option>
                                            </select>
                                        </div>

                                        <label class="col-lg-6 col-form-label" for="select2">
                                            เป็นประมาณการผลิตประจำปักษ์
                                        </label>
                                        <div class="col-lg-6">
                                            <select class="form-control m-b" name="select2" id="select2">
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
                    <!--End Modal Copy plan -->
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-3 col-sm-12">
                        <div class="form-group row">
                            <span class="col-lg-8 col-form-label">
                                ประมาณการผลิตประจำปี
                            </span>
                            <span class="col-lg-4 col-form-label">
                                <span class="remark">2564</span>
                            </span>
                        </div>
                        <div class="form-group row">
                            <span class="col-lg-8 col-form-label">
                                ปักษ์ที่
                            </span>
                            <span class="col-lg-4 col-form-label">
                                <span class="remark">1</span>
                            </span>
                        </div>
                    </div>

                    <div class="col-lg-3 col-sm-12">
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label">
                                ประจำเดือน
                            </label>
                            <label class="col-lg-3 col-form-label">
                                <span class="remark">พฤศจิกายน</span>
                            </label>
                        </div>
                        <div class="form-group row">
                            <span class="col-lg-4 col-form-label">
                               ครั้งที่
                            </span>
                            <span class="col-lg-3 col-form-label">
                                <span class="remark">1</span>
                            </span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label" for="input3">
                                วันที่สร้าง
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="date" id="input3">
                            </div>
                            <label class="col-lg-2 col-form-label" for="input4">
                                วันที่แก้ไขล่าสุด
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="date" id="input4">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label" for="input5">
                                สถานะ
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="text" id="input5">
                            </div>
                            <label class="col-lg-2 col-form-label" for="input6">
                                ผู้บันทึก
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="text" id="input6">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label" for="input7">
                                วันที่อนุมัติ
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="date" id="input7">
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
                                <li><a class="nav-link active" data-toggle="tab" href="#tab-1">ประมาณกำลังการผลิต </a>
                                </li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-2"> ประมาณการผลิตแยกรายตรา</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-3">ประมาณการผลิตรายวัน</a>
                                </li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-4"> ประมาณการผลิตรายปักษ์</a></li>
                            </ul>
                            <!-- end link tab -->
                            <div class="tab-content in-tab-custom">
                                <div id="tab-1" class="tab-pane active">
                                    <!-- content tab1 -->
                                    <div class="panel-body">
                                        <!-- tab1 table1 -->
                                        <div class="row mt-3 align-items-center">
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label" for="input8">
                                                        ปักษ์ที่</label>
                                                    <div class="col-lg-8">
                                                        <select class="form-control" name="account" id="input8">
                                                            <option>4</option>
                                                            <option>5</option>
                                                            <option>6</option>
                                                            <option>7</option>
                                                        </select>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="input9">ประสิทธิภาพเครื่องจักร
                                                        (%)</label>
                                                    <div class="col-lg-5">
                                                        <input type="text" class="form-control" id="input9">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 text-right mt-4 mb-3">
                                            หน่วย : ล้านมวน
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr class="tr-header">
                                                    <th rowspan="2" colspan="2">เครื่องจักรมวน 7.8</th>
                                                    <th rowspan="2" style="min-width: 150px">ความเร็วเครื่องจักร<br>ต่อนาที
                                                        (มวน)
                                                    </th>
                                                    <th rowspan="2" style="min-width: 150px">ประสิทธิภาพ<br>เครื่องจักร
                                                        (%)
                                                    </th>
                                                    <th style="min-width: 120px;" rowspan="2">ผลผลิตตามประสิทธิภาพ
                                                        <br>ต่อนาที (มวน)
                                                    </th>
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
                                                    <th style="min-width: 120px">รวม</th>
                                                </tr>
                                                <tr>

                                                    <th>9</th>
                                                    <th>9</th>
                                                    <th>13</th>
                                                    <th>13</th>
                                                    <th>0</th>
                                                    <th>9</th>
                                                    <th>9</th>
                                                    <th>9</th>
                                                    <th>9</th>
                                                    <th>9</th>
                                                    <th>0</th>
                                                    <th>0</th>
                                                    <th>0</th>
                                                </tr>

                                                </thead>
                                                <tbody>
                                                <!-- Row1-->
                                                <tr>
                                                    <td class="text-center" rowspan="2" style="min-width: 120px;">F6 -
                                                        L1
                                                    </td>
                                                    <td class="text-left" style="min-width: 150px;">Protos 90 E No.1
                                                    </td>
                                                    <td class="text-right table-active">10,000</td>
                                                    <td class="text-right">80</td>
                                                    <td class="text-right table-active">8,000</td>
                                                    <td class="text-right table-active">34.455</td>
                                                    <td class="text-right table-active">234.452</td>
                                                    <td class="text-right table-active">12.233</td>
                                                    <td class="text-right table-active">4.32</td>
                                                    <td class="text-right  bg-primary">-</td>
                                                    <td class="text-right  bg-primary">-</td>
                                                    <td class="text-right  bg-primary">-</td>
                                                    <td class="text-right  bg-primary">-</td>
                                                    <td class="text-right table-active">45.455</td>
                                                    <td class="text-right table-active">6.452</td>
                                                    <td class="text-right table-active">5.233</td>
                                                    <td class="text-right table-active">4.32</td>
                                                    <td class="text-right table-active"></td>

                                                </tr>
                                                <!-- End Row1-->
                                                <!-- Row2-->

                                                <tr>

                                                    <td class="text-left" style="min-width: 150px;"> Protos 90 E No.2
                                                    </td>
                                                    <td class="text-right table-active">10,000</td>
                                                    <td class="text-right">80</td>
                                                    <td class="text-right table-active">8,000</td>
                                                    <td class="text-right table-active">34.455</td>
                                                    <td class="text-right table-active">234.452</td>
                                                    <td class="text-right table-active">12.233</td>
                                                    <td class="text-right table-active">4.32</td>
                                                    <td class="text-right  bg-primary">-</td>
                                                    <td class="text-right  bg-primary">-</td>
                                                    <td class="text-right  bg-primary">-</td>
                                                    <td class="text-right  bg-primary">-</td>
                                                    <td class="text-right table-active">45.455</td>
                                                    <td class="text-right table-active">6.452</td>
                                                    <td class="text-right table-active">5.233</td>
                                                    <td class="text-right table-active">4.32</td>
                                                    <td class="text-right table-active"></td>

                                                </tr>
                                                <!-- End Row2-->

                                                <!-- Row3-->
                                                <tr>

                                                    <td class="text-right table-active" colspan="4">รวม</td>
                                                    <td class="text-right table-success">80</td>
                                                    <td class="text-right table-success">8,000</td>
                                                    <td class="text-right table-success">34.455</td>
                                                    <td class="text-right table-success">234.452</td>
                                                    <td class="text-right table-success">12.233</td>
                                                    <td class="text-right table-success">4.32</td>
                                                    <td class="text-right table-success">-</td>
                                                    <td class="text-right table-success">-</td>
                                                    <td class="text-right table-success">-</td>
                                                    <td class="text-right table-success">453.354</td>
                                                    <td class="text-right table-success">45.455</td>
                                                    <td class="text-right table-success">6.452</td>
                                                    <td class="text-right table-success">5.233</td>
                                                    <td class="text-right table-success">4.32</td>

                                                </tr>

                                                <!-- End Row3-->
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- End tab1 table1 -->


                                        <!-- tab1 table2 -->

                                        <div class="col-lg-12 text-right mt-4 mb-3">
                                            หน่วย : ล้านมวน
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr class="tr-header">
                                                    <th rowspan="2" colspan="2">เครื่องจักรมวน 7.1</th>
                                                    <th rowspan="2" style="min-width: 150px">
                                                        ความเร็วเครื่องจักร<br>ต่อนาที
                                                        (ชิ้น)
                                                    </th>
                                                    <th rowspan="2" style="min-width: 150px">
                                                        ประสิทธิภาพ<br>เครื่องจักร
                                                        (%)
                                                    </th>
                                                    <th style="min-width: 120px;" rowspan="2">
                                                        ผลผลิตตามประสิทธิภาพ
                                                        <br>ต่อนาที (ชิ้น)
                                                    </th>
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
                                                    <th style="min-width: 120px">รวม</th>
                                                </tr>
                                                <tr>

                                                    <th>9</th>
                                                    <th>9</th>
                                                    <th>13</th>
                                                    <th>13</th>
                                                    <th>0</th>
                                                    <th>9</th>
                                                    <th>9</th>
                                                    <th>9</th>
                                                    <th>9</th>
                                                    <th>9</th>
                                                    <th>0</th>
                                                    <th>0</th>
                                                    <th>0</th>
                                                </tr>

                                                </thead>
                                                <tbody>
                                                <!-- Row1-->
                                                <tr>
                                                    <td class="text-center" rowspan="2"
                                                        style="min-width: 120px;">F6 - L10
                                                    </td>
                                                    <td class="text-left" style="min-width: 150px;">
                                                        GD 121 No.7
                                                    </td>
                                                    <td class="text-right table-active">10,000</td>
                                                    <td class="text-right">80</td>
                                                    <td class="text-right table-active">8,000</td>
                                                    <td class="text-right table-active">34.455</td>
                                                    <td class="text-right table-active">234.452</td>
                                                    <td class="text-right table-active">12.233</td>
                                                    <td class="text-right table-active">4.32</td>
                                                    <td class="text-right  bg-primary">-</td>
                                                    <td class="text-right  bg-primary">-</td>
                                                    <td class="text-right  bg-primary">-</td>
                                                    <td class="text-right  bg-primary">-</td>
                                                    <td class="text-right table-active">45.455</td>
                                                    <td class="text-right table-active">6.452</td>
                                                    <td class="text-right table-active">5.233</td>
                                                    <td class="text-right table-active">4.32</td>
                                                    <td class="text-right table-active"></td>

                                                </tr>
                                                <!-- End Row1-->

                                                <!-- Row2-->

                                                <tr>

                                                    <td class="text-left" style="min-width: 150px;">
                                                        GD 121 No.8
                                                    </td>
                                                    <td class="text-right table-active">10,000</td>
                                                    <td class="text-right">80</td>
                                                    <td class="text-right table-active">8,000</td>
                                                    <td class="text-right bg-danger">34.455</td>
                                                    <td class="text-right bg-danger">-</td>
                                                    <td class="text-right bg-danger">-</td>
                                                    <td class="text-right bg-danger">-</td>
                                                    <td class="text-right bg-danger">-</td>
                                                    <td class="text-right bg-danger">-</td>
                                                    <td class="text-right bg-danger">-</td>
                                                    <td class="text-right bg-danger">-</td>
                                                    <td class="text-right bg-danger">-</td>
                                                    <td class="text-right bg-danger">-</td>
                                                    <td class="text-right bg-danger">-</td>
                                                    <td class="text-right bg-danger">-</td>
                                                    <td class="text-right table-active"></td>

                                                </tr>
                                                <!-- End Row2-->

                                                <!-- Row3-->
                                                <tr>

                                                    <td class="text-right table-active" colspan="4">
                                                        รวม
                                                    </td>
                                                    <td class="text-right table-success">80</td>
                                                    <td class="text-right table-success">8,000</td>
                                                    <td class="text-right table-success">34.455</td>
                                                    <td class="text-right table-success">234.452</td>
                                                    <td class="text-right table-success">12.233</td>
                                                    <td class="text-right table-success">4.32</td>
                                                    <td class="text-right table-success">-</td>
                                                    <td class="text-right table-success">-</td>
                                                    <td class="text-right table-success">-</td>
                                                    <td class="text-right table-success">453.354</td>
                                                    <td class="text-right table-success">45.455</td>
                                                    <td class="text-right table-success">6.452</td>
                                                    <td class="text-right table-success">5.233</td>
                                                    <td class="text-right table-success">4.32</td>

                                                </tr>

                                                <!-- End Row3-->
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- End tab1 table2 -->

                                        <!-- tab1 table3 -->


                                        <div class="col-lg-12 text-right mt-4 mb-3">
                                            หน่วย : ล้านชิ้น
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr class="tr-header">
                                                    <th rowspan="2" colspan="2">เครื่องจักรก้นกรอง</th>
                                                    <th rowspan="2" style="min-width: 150px">
                                                        ความเร็วเครื่องจักร<br>ต่อนาที
                                                        (มวน)
                                                    </th>
                                                    <th rowspan="2" style="min-width: 150px">
                                                        ประสิทธิภาพ<br>เครื่องจักร
                                                        (%)
                                                    </th>
                                                    <th style="min-width: 120px;" rowspan="2">
                                                        ผลผลิตตามประสิทธิภาพ
                                                        <br>ต่อนาที (มวน)
                                                    </th>
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
                                                    <th style="min-width: 120px">รวม</th>
                                                </tr>
                                                <tr>

                                                    <th>9</th>
                                                    <th>9</th>
                                                    <th>13</th>
                                                    <th>13</th>
                                                    <th>0</th>
                                                    <th>9</th>
                                                    <th>9</th>
                                                    <th>9</th>
                                                    <th>9</th>
                                                    <th>9</th>
                                                    <th>0</th>
                                                    <th>0</th>
                                                    <th>0</th>
                                                </tr>

                                                </thead>
                                                <tbody>
                                                <!-- Row1-->
                                                <tr>
                                                    <td class="text-center" rowspan="2"
                                                        style="min-width: 120px;">F6 - L10
                                                    </td>
                                                    <td class="text-left" style="min-width: 150px;">
                                                        GD 121 No.7
                                                    </td>
                                                    <td class="text-right table-active">10,000</td>
                                                    <td class="text-right">80</td>
                                                    <td class="text-right table-active">8,000</td>
                                                    <td class="text-right table-active">34.455</td>
                                                    <td class="text-right table-active">234.452</td>
                                                    <td class="text-right table-active">12.233</td>
                                                    <td class="text-right table-active">4.32</td>
                                                    <td class="text-right  bg-primary">-</td>
                                                    <td class="text-right  bg-primary">-</td>
                                                    <td class="text-right  bg-primary">-</td>
                                                    <td class="text-right  bg-primary">-</td>
                                                    <td class="text-right table-active">45.455</td>
                                                    <td class="text-right table-active">6.452</td>
                                                    <td class="text-right table-active">5.233</td>
                                                    <td class="text-right table-active">4.32</td>
                                                    <td class="text-right table-active"></td>

                                                </tr>
                                                <!-- End Row1-->

                                                <!-- Row2-->

                                                <tr>

                                                    <td class="text-left" style="min-width: 150px;">
                                                        GD 121 No.8
                                                    </td>
                                                    <td class="text-right table-active">10,000</td>
                                                    <td class="text-right">80</td>
                                                    <td class="text-right table-active">8,000</td>
                                                    <td class="text-right table-active">34.455</td>
                                                    <td class="text-right table-active">234.452</td>
                                                    <td class="text-right table-active">12.233</td>
                                                    <td class="text-right table-active">4.32</td>
                                                    <td class="text-right  bg-primary">-</td>
                                                    <td class="text-right  bg-primary">-</td>
                                                    <td class="text-right  bg-primary">-</td>
                                                    <td class="text-right  bg-primary">-</td>
                                                    <td class="text-right table-active">45.455</td>
                                                    <td class="text-right table-active">6.452</td>
                                                    <td class="text-right table-active">5.233</td>
                                                    <td class="text-right table-active">4.32</td>
                                                    <td class="text-right table-active"></td>

                                                </tr>
                                                <!-- End Row2-->

                                                <!-- Row3-->
                                                <tr>

                                                    <td class="text-right table-active" colspan="4">
                                                        รวม
                                                    </td>
                                                    <td class="text-right table-success">80</td>
                                                    <td class="text-right table-success">8,000</td>
                                                    <td class="text-right table-success">34.455</td>
                                                    <td class="text-right table-success">234.452</td>
                                                    <td class="text-right table-success">12.233</td>
                                                    <td class="text-right table-success">4.32</td>
                                                    <td class="text-right table-success">-</td>
                                                    <td class="text-right table-success">-</td>
                                                    <td class="text-right table-success">-</td>
                                                    <td class="text-right table-success">453.354</td>
                                                    <td class="text-right table-success">45.455</td>
                                                    <td class="text-right table-success">6.452</td>
                                                    <td class="text-right table-success">5.233</td>
                                                    <td class="text-right table-success">4.32</td>

                                                </tr>

                                                <!-- End Row3-->
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- End tab1 table3 -->

                                        <!-- tab1 table4 -->
                                        <div class="tab1-table4 mt-5">
                                            <div class="col-lg-12 text-right mt-4 mb-3">
                                                หน่วย : ล้านมวน/ล้านชิ้น
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr class="tr-header table-pp">
                                                        <th colspan="2" style="min-width:350px">ชั่วโมงทำงาน</th>
                                                        <th colspan="2">ปักษ์ที่ 4</th>
                                                        <th colspan="2">ปักษ์ที่ 5</th>
                                                        <th colspan="2">ปักษ์ที่ 6</th>
                                                        <th colspan="2">ปักษ์ที่ 7</th>
                                                        <th colspan="2">ปักษ์ที่ 8</th>
                                                        <th colspan="2">ปักษ์ที่ 9</th>
                                                    </tr>

                                                    </thead>
                                                    <tbody>
                                                    <!--  ชั่วโมงทำงาน -->
                                                    <tr>
                                                        <td class="text-left" colspan="2">จำนวนวันทำงาน 8
                                                            ชั่วโมง (วัน)
                                                        </td>
                                                        <td class="text-right" colspan="2">-</td>
                                                        <td class="text-right" colspan="2">-</td>
                                                        <td class="text-right" colspan="2">-</td>
                                                        <td class="text-right" colspan="2">-</td>
                                                        <td class="text-right" colspan="2">-</td>
                                                        <td class="text-right" colspan="2">-</td>

                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" colspan="2">จำนวนวันทำงาน 9
                                                            ชั่วโมง (วัน)
                                                        </td>
                                                        <td class="text-right" colspan="2">20.00</td>
                                                        <td class="text-right" colspan="2">20.00</td>
                                                        <td class="text-right" colspan="2">21.00</td>
                                                        <td class="text-right" colspan="2">16.00</td>
                                                        <td class="text-right" colspan="2">12.00</td>
                                                        <td class="text-right" colspan="2">1686.00</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" colspan="2">จำนวนวันทำงาน 13
                                                            ชั่วโมง (วัน)
                                                        </td>
                                                        <td class="text-right" colspan="2">-</td>
                                                        <td class="text-right" colspan="2">-</td>
                                                        <td class="text-right" colspan="2">-</td>
                                                        <td class="text-right" colspan="2">4.00</td>
                                                        <td class="text-right" colspan="2">8.00</td>
                                                        <td class="text-right" colspan="2">55.00</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right" colspan="2">รวมวันทำงาน</td>
                                                        <td class="text-right table-success" colspan="2">60,000</td>
                                                        <td class="text-right table-success" colspan="2">960,000
                                                        </td>
                                                        <td class="text-right table-success" colspan="2">1,960,000
                                                        </td>
                                                        <td class="text-right table-success" colspan="2">11,960,000
                                                        </td>
                                                        <td class="text-right table-success" colspan="2">211,960,000
                                                        </td>
                                                        <td class="text-right table-success" colspan="2">
                                                            12,11,960,000
                                                        </td>
                                                    </tr>

                                                    <!-- end ชั่วโมงทำงาน -->

                                                    <!-- row สั่งผลิต -->

                                                    <tr class="tr-header table-pp">
                                                        <th colspan="2">
                                                            <div class="row">
                                                                <label class="col-lg-3 col-form-label" for="input10">
                                                                    สั่งผลิต </label>
                                                                <input class="form-control col-lg-3" type="text"
                                                                       id="input10">
                                                                <span class="col-lg-2 col-form-label"> %</span>
                                                            </div>
                                                        </th>
                                                        <th style="min-width: 120px;">กำลังการผลิต</th>
                                                        <th style="min-width: 120px;">สั่งผลิต</th>
                                                        <th style="min-width: 120px;">กำลังการผลิต</th>
                                                        <th style="min-width: 120px;">สั่งผลิต</th>
                                                        <th style="min-width: 120px;">กำลังการผลิต</th>
                                                        <th style="min-width: 120px;">สั่งผลิต</th>
                                                        <th style="min-width: 120px;">กำลังการผลิต</th>
                                                        <th style="min-width: 120px;">สั่งผลิต</th>
                                                        <th style="min-width: 120px;">กำลังการผลิต</th>
                                                        <th style="min-width: 120px;">สั่งผลิต</th>
                                                        <th style="min-width: 120px;">กำลังการผลิต</th>
                                                        <th style="min-width: 120px;">สั่งผลิต</th>
                                                    </tr>

                                                    <!-- สั่งผลิต row1 -->
                                                    <tr>
                                                        <td rowspan="4">เครื่องจักรมวน 7.8</td>
                                                        <td class="text-left">F6 - L1</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">215.040</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">80,000</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">215.040</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">215.040</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">215.040</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">215.040</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">F6 - L2</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">215.040</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">80,000</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">215.040</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">215.040</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">215.040</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">215.040</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">F6 - L3</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">215.040</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">80,000</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">215.040</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">215.040</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">215.040</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">215.040</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left">รวมผลผลิต</td>
                                                        <td class="text-right table-success">777.44</td>
                                                        <td class="text-right table-success">88.096</td>
                                                        <td class="text-right table-success">67.360</td>
                                                        <td class="text-right table-success">67.360</td>
                                                        <td class="text-right table-success">43.677</td>
                                                        <td class="text-right table-success">67.360</td>
                                                        <td class="text-right table-success">43.677</td>
                                                        <td class="text-right table-success">43.677</td>
                                                        <td class="text-right table-success">44.33</td>
                                                        <td class="text-right table-success">56.912</td>
                                                        <td class="text-right table-success">7.677</td>
                                                        <td class="text-right table-success">4.419</td>
                                                    </tr>

                                                    <!-- end สั่งผลิต row1 -->

                                                    <!-- สั่งผลิต row2 -->
                                                    <tr>
                                                        <td rowspan="2">เครื่องจักรมวน 7.1</td>
                                                        <td class="text-left">F6 - L1</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">215.040</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">215.040</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">215.040</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">215.040</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">215.040</td>
                                                    </tr>


                                                    <tr>
                                                        <td class="text-left">รวมผลผลิต</td>
                                                        <td class="text-right table-success">777.44</td>
                                                        <td class="text-right table-success">88.096</td>
                                                        <td class="text-right table-success">67.360</td>
                                                        <td class="text-right table-success">43.677</td>
                                                        <td class="text-right table-success">44.33</td>
                                                        <td class="text-right table-success">56.912</td>
                                                        <td class="text-right table-success">7.677</td>
                                                        <td class="text-right table-success">777.44</td>
                                                        <td class="text-right table-success">88.096</td>
                                                        <td class="text-right table-success">67.360</td>
                                                        <td class="text-right table-success">43.677</td>
                                                        <td class="text-right table-success">44.33</td>
                                                    </tr>

                                                    <!-- end สั่งผลิต row2 -->
                                                    <!-- สั่งผลิต row3 -->
                                                    <tr>
                                                        <td rowspan="2">เครื่องจักรก้นกรอง</td>
                                                        <td class="text-left">ก้นกรอง Mono Acetate</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">215.040</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">215.040</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">215.040</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">215.040</td>
                                                        <td class="text-right">307.200</td>
                                                        <td class="text-right">215.040</td>
                                                    </tr>


                                                    <tr>
                                                        <td class="text-left">รวมผลผลิต</td>
                                                        <td class="text-right table-success">777.44</td>
                                                        <td class="text-right table-success">88.096</td>
                                                        <td class="text-right table-success">67.360</td>
                                                        <td class="text-right table-success">43.677</td>
                                                        <td class="text-right table-success">67.360</td>
                                                        <td class="text-right table-success">43.677</td>
                                                        <td class="text-right table-success">44.33</td>
                                                        <td class="text-right table-success">56.912</td>
                                                        <td class="text-right table-success">44.33</td>
                                                        <td class="text-right table-success">56.912</td>
                                                        <td class="text-right table-success">7.677</td>
                                                        <td class="text-right table-success">4.419</td>
                                                    </tr>

                                                    <!-- end สั่งผลิต row3 -->


                                                    <!-- End row สั่งผลิต -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- End tab1 table4 -->

                                        <!-- tab1 table5 -->
                                        <div class="tab1-table5">
                                            <div class="col-lg-12 text-right mt-4 mb-3">
                                                หน่วย : ล้านมวน/ล้านขึ้น
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr class="tr-header">
                                                        <th colspan="16">
                                                            ประมาณกำลังการผลิตเครื่องจักร
                                                        </th>
                                                    </tr>
                                                    <tr class="tr-header table-pp">
                                                        <th colspan="2" style="min-width:250px;">
                                                            <div class="row">
                                                                    <span class="col-lg-4 col-form-label" for="input11">
                                                                        สั่งผลิต </span>
                                                                <input class="form-control col-lg-3" type="text"
                                                                       id="input11">
                                                                <span class="col-lg-2 col-form-label">
                                                                        %</span>
                                                            </div>
                                                        </th>
                                                        <th>กำลังการผลิต<br>(8 ชม.)</th>
                                                        <th>ผลิตได้<br>(8 ชม.)</th>
                                                        <th>กำลังการผลิต <br>(9 ชม.)</th>
                                                        <th>ผลิตได้<br>(9 ชม.)</th>
                                                        <th>กำลังการผลิต<br>(13 ชม.)</th>
                                                        <th>ผลิตได้<br>(13 ชม.)</th>
                                                        <th>ผลิตเพิ่มได้<br>(4 ชม.)</th>
                                                        <th>วันผลิต/ต่อปักษ์<br>(วัน)</th>
                                                        <th>จำนวนวันเพิ่ม 4 ชม.</th>
                                                        <th>ผลผลิตทั้งปักษ์</th>
                                                        <th>ขาดผลผลิตช่วงลดกำลัง</th>
                                                        <th>ขาดผลผลิต ช่วง PM</th>
                                                        <th>ผลผลิตหักลดกำลัง</th>
                                                        <th>ผลผลิตหักลดกำลัง PM</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-center" rowspan="3" style="width:100px;">
                                                            บุหรี่ 7.8
                                                        </td>
                                                        <td class="text-left">F6-L1</td>
                                                        <td class="text-right">13.44</td>
                                                        <td class="text-right">12.096</td>
                                                        <td class="text-right">15.360</td>
                                                        <td class="text-right">9.677</td>
                                                        <td class="text-right">54.33</td>
                                                        <td class="text-right">6.912</td>
                                                        <td class="text-right">9.677</td>
                                                        <td class="text-right">2.419</td>
                                                        <td class="text-right">60.97</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right ">54.33</td>
                                                        <td class="text-right">รวม</td>
                                                        <td class="text-right">23,040</td>
                                                        <td class="text-right">23,040</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left">F6-L1</td>
                                                        <td class="text-right">13.44</td>
                                                        <td class="text-right">12.096</td>
                                                        <td class="text-right">15.360</td>
                                                        <td class="text-right">9.677</td>
                                                        <td class="text-right">54.33</td>
                                                        <td class="text-right">6.912</td>
                                                        <td class="text-right">9.677</td>
                                                        <td class="text-right">2.419</td>
                                                        <td class="text-right">60.97</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">54.33</td>
                                                        <td class="text-right">รวม</td>
                                                        <td class="text-right">23,040</td>
                                                        <td class="text-right">23,040</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left">รวมกำลังการผลิต</td>
                                                        <td class="text-right table-success">777.44</td>
                                                        <td class="text-right table-success">88.096</td>
                                                        <td class="text-right table-success">67.360</td>
                                                        <td class="text-right table-success">43.677</td>
                                                        <td class="text-right table-success">44.33</td>
                                                        <td class="text-right table-success">56.912</td>
                                                        <td class="text-right table-success">7.677</td>
                                                        <td class="text-right table-success">4.419</td>
                                                        <td class="text-right table-success">60.97</td>
                                                        <td class="text-right table-success">0.00</td>
                                                        <td class="text-right table-success">54.33</td>
                                                        <td class="text-right table-success">รวม</td>
                                                        <td class="text-right table-success">53,040</td>
                                                        <td class="text-right table-success">11,111</td>
                                                    </tr>


                                                    <tr>
                                                        <td class="text-center" rowspan="2">
                                                            บุหรี่ 7.1
                                                        </td>
                                                        <td class="text-left">F6-L10</td>
                                                        <td class="text-right">13.44</td>
                                                        <td class="text-right">12.096</td>
                                                        <td class="text-right">15.360</td>
                                                        <td class="text-right">9.677</td>
                                                        <td class="text-right">54.33</td>
                                                        <td class="text-right">6.912</td>
                                                        <td class="text-right">9.677</td>
                                                        <td class="text-right">2.419</td>
                                                        <td class="text-right">60.97</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">54.33</td>
                                                        <td class="text-right">รวม</td>
                                                        <td class="text-right">23,040</td>
                                                        <td class="text-right">23,040</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">รวมกำลังการผลิต</td>
                                                        <td class="text-right table-success">777.44</td>
                                                        <td class="text-right table-success">88.096</td>
                                                        <td class="text-right table-success">67.360</td>
                                                        <td class="text-right table-success">43.677</td>
                                                        <td class="text-right table-success">44.33</td>
                                                        <td class="text-right table-success">56.912</td>
                                                        <td class="text-right table-success">7.677</td>
                                                        <td class="text-right table-success">4.419</td>
                                                        <td class="text-right table-success">60.97</td>
                                                        <td class="text-right table-success">0.00</td>
                                                        <td class="text-right table-success">54.33</td>
                                                        <td class="text-right table-success">รวม</td>
                                                        <td class="text-right table-success">53,040</td>
                                                        <td class="text-right table-success">11,111</td>
                                                    </tr>


                                                    <tr>
                                                        <td class="text-center" rowspan="2">
                                                            ก้นกรอง
                                                        </td>
                                                        <td class="text-left">ก้นกรอง Menthol</td>
                                                        <td class="text-right">12.096</td>
                                                        <td class="text-right">15.360</td>
                                                        <td class="text-right">9.677</td>
                                                        <td class="text-right">54.33</td>
                                                        <td class="text-right">6.912</td>
                                                        <td class="text-right">9.677</td>
                                                        <td class="text-right">2.419</td>
                                                        <td class="text-right">60.97</td>
                                                        <td class="text-right">23.00</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">54.33</td>
                                                        <td class="text-right">รวม</td>
                                                        <td class="text-right">23,040</td>
                                                        <td class="text-right">23,040</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">รวมกำลังการผลิต</td>
                                                        <td class="text-right table-success">777.44</td>
                                                        <td class="text-right table-success">88.096</td>
                                                        <td class="text-right table-success">67.360</td>
                                                        <td class="text-right table-success">43.677</td>
                                                        <td class="text-right table-success">44.33</td>
                                                        <td class="text-right table-success">56.912</td>
                                                        <td class="text-right table-success">7.677</td>
                                                        <td class="text-right table-success">4.419</td>
                                                        <td class="text-right table-success">60.97</td>
                                                        <td class="text-right table-success">0.00</td>
                                                        <td class="text-right table-success">54.33</td>
                                                        <td class="text-right table-success">รวม</td>
                                                        <td class="text-right table-success">53,040</td>
                                                        <td class="text-right table-success">11,111</td>
                                                    </tr>


                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- End tab1 table5 -->
                                    </div>
                                </div>
                                <!-- End content tab1 -->

                                <!-- Content tab2 -->
                                <div id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <!-- table -->
                                        <!-- tab2 table1 -->
                                        <div class="tab2-table1 mt-5">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr class="tr-header">
                                                        <th style="min-width:150px;">เดือน</th>
                                                        <th colspan="3"> พฤศจิกายน</th>
                                                        <th colspan="3"> ธันวาคม</th>

                                                    </tr>

                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-center" rowspan="2">จำนวนวันขาย (วัน)</td>
                                                        <td style="min-width: 150px">ปักษ์ที่ 3</td>
                                                        <td style="min-width: 150px">ปักษ์ที่ 4</td>
                                                        <td style="min-width: 150px">รวม</td>
                                                        <td style="min-width: 150px">ปักษ์ที่ 5</td>
                                                        <td style="min-width: 120px">ปักษ์ที่ 6</td>
                                                        <td style="min-width: 120px">รวม</td>
                                                    </tr>
                                                    <tr>
                                                        <td>10</td>
                                                        <td>11</td>
                                                        <td>21</td>
                                                        <td>11</td>
                                                        <td>14</td>
                                                        <td>25</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- End tab2 table1 -->


                                        <!-- tab2 table2 -->
                                        <div class="tab2-table2 mt-5">
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-6 col-form-label" for="input12">
                                                        เฉลี่ยขายย้อนหลัง 10 วัน สิ้นสุด ณ วันที่
                                                    </label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" type="text" id="input12" disabled>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr class="tr-header">
                                                        <th colspan="2" rowspan="2">ตราบุหรี่</th>
                                                        <th colspan="5">ปัก4</th>
                                                        <th colspan="5">ธันวาคม</th>

                                                    </tr>
                                                    <tr class="tr-header">
                                                        <th>ประมาณการขายทั้งเดือน<br>(หีบ)</th>
                                                        <th>ประมาณการขาย<br>ปักษ์ที่ 4</th>
                                                        <th>เฉลี่ยขายย้อนหลัง<br>(ล้านมวน)</th>
                                                        <th>เฉลี่ยประมาณการ<br>(ล้านมวน)</th>
                                                        <th>ประมาณการขายทั้งเดือน<br>(หีบ)</th>
                                                        <th>คเฉลี่ยขาย</th>
                                                        <th>ประมาณการขาย<br>ปักษ์ที่ 5</th>
                                                        <th>ประมาณการขาย<br>ปักษ์ที่ 6</th>
                                                        <th>เฉลี่ยประมาณการ<br>(ล้านมวน)</th>
                                                    </tr>

                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-center" rowspan="3" style="min-width:120px">
                                                            บุหรี่ 7.8
                                                        </td>
                                                        <td class="text-left" style="min-width:230px"> สายฝน 90</td>
                                                        <td class="text-right">2.66</td>
                                                        <td class="text-right">2.66</td>
                                                        <td class="text-right">1.66</td>
                                                        <td class="text-right">1.0</td>
                                                        <td class="text-right">26.5</td>
                                                        <td class="text-right">62.43</td>
                                                        <td class="text-right">1.66</td>
                                                        <td class="text-right">1.0</td>
                                                        <td class="text-right">26.5</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left">WONDER S ซองสีเขียว</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">-</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-right">รวมทั้งหมด</td>
                                                        <td class="text-right table-success">1,897,265</td>
                                                        <td class="text-right table-success">3,600,000</td>
                                                        <td class="text-right table-success">4054</td>
                                                        <td class="text-right table-success">95,225,600</td>
                                                        <td class="text-right table-success">534</td>
                                                        <td class="text-right table-success">4,543</td>
                                                        <td class="text-right table-success">4,534,535,345</td>
                                                        <td class="text-right table-success">345</td>
                                                        <td class="text-right table-success">3,342,424</td>
                                                    </tr>

                                                    <!-- end row1 -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- End tab2 table2 -->

                                        <!-- tab2 table3 -->
                                        <div class="tab2-table3 mt-5">
                                            <div class="col-lg-12 text-right mt-4 mb-3">
                                                หน่วย : ล้านมวน
                                            </div>
                                            <div class="row mt-3 align-items-center">
                                                <div class="col-lg-4 col-sm-12">
                                                    <div class="form-group row">
                                                        <label class="col-lg-4 col-form-label" for="select3">
                                                            เลือกข้อมูล</label>
                                                        <div class="col-lg-5">
                                                            <select class="form-control" name="select3" id="select3">
                                                                <option>เฉลี่ยขาย</option>
                                                                <option>เฉลี่ยขาย</option>
                                                            </select>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr class="tr-header">
                                                        <th rowspan="2" colspan="2">ตราบุหรี่</th>
                                                        <th rowspan="2">ผลิต / BATCH</th>
                                                        <th rowspan="2" style="min-width: 120px;">อัตราการใช้ใบยา<br>
                                                            ต่อ 1 ล้านมวน (กก.)
                                                        </th>
                                                        <th rowspan="2" style="min-width: 120px;">ข้อมูลที่ใช้</th>
                                                        <th rowspan="2" style="min-width: 120px;">คงคลัง</th>
                                                        <th colspan="3">ปักษ์ที่ 3</th>
                                                        <th rowspan="3">คงคลังสิ้นปักษ์</th>
                                                        <th rowspan="2">พอจำหน่าย<br>(วัน)</th>
                                                        <th colspan="4">ปักษ์ที่ 4</th>
                                                        <th rowspan="2">คงคลังสิ้นปักษ์</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="min-width: 120px;">สั่งผลิต</th>
                                                        <th style="min-width: 120px;">วันขาย</th>
                                                        <th style="min-width: 120px;">ประมาณขาย</th>
                                                        <th style="min-width: 120px;">จำนวนชุด</th>
                                                        <th style="min-width: 120px;">สั่งผลิต</th>
                                                        <th style="min-width: 120px;">ปริมาณใบยา</th>
                                                        <th style="min-width: 120px;">ประมาณขาย</th>
                                                    </tr>

                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-center" rowspan="3" style="min-width:100px">
                                                            บุหรี่ 7.8
                                                        </td>
                                                        <td class="text-left" style="min-width:200px"> สายฝน 90</td>
                                                        <td class="text-right">2.66</td>
                                                        <td class="text-right">2.66</td>
                                                        <td class="text-right">
                                                            <select class="form-control" name="select3">
                                                                <option>เฉลี่ยขาย</option>
                                                                <option>เฉลี่ยขาย</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-right">1.0</td>
                                                        <td class="text-right">26.5</td>
                                                        <td class="text-right">62.43</td>
                                                        <td class="text-right">226.5</td>
                                                        <td class="text-right">1.0</td>
                                                        <td class="text-right">26.5</td>
                                                        <td class="text-right">26.5</td>
                                                        <td class="text-right">62.43</td>
                                                        <td class="text-right">45.55</td>
                                                        <td class="text-right">564.443</td>
                                                        <td class="text-right"> 57.741</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" style="min-width:200px">WONDER S
                                                            ซองสีแดง
                                                        </td>
                                                        <td class="text-right">22.66</td>
                                                        <td class="text-right">23.46</td>
                                                        <td class="text-right">
                                                            <select class="form-control" name="select3">
                                                                <option>เฉลี่ยขาย</option>
                                                                <option>เฉลี่ยขาย</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-right">132.0</td>
                                                        <td class="text-right">526.5</td>
                                                        <td class="text-right">762.43</td>
                                                        <td class="text-right">31.66</td>
                                                        <td class="text-right">331.0</td>
                                                        <td class="text-right">526.5</td>
                                                        <td class="text-right">662.43</td>
                                                        <td class="text-right">726.5</td>
                                                        <td class="text-right">526.5</td>
                                                        <td class="text-right">762.43</td>
                                                        <td class="text-right">31.66</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-right" colspan="4">รวมทั้งหมด</td>
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
                                        <!-- End tab2 table3 -->

                                        <!-- tab2 table4 -->
                                        <div class="tab2-table4 mt-5">
                                            <div class="col-lg-12 text-right mt-4 mb-3">
                                                หน่วย : ล้านชิ้น
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">

                                                    <!--  Table ประมาณการผลิต-->
                                                    <thead>
                                                    <tr class="tr-header">
                                                        <th style="min-width: 25%">ประมาณการผลิต</th>
                                                        <th style="min-width: 25%">ปักษ์ที่ 3</th>
                                                        <th style="min-width: 25%">ปักษ์ที่ 4</th>
                                                        <th style="min-width: 25%">ปักษ์ที่ 5</th>
                                                    </tr>

                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-left">ก้นกรอง (Mono Acetate)</td>
                                                        <td class="text-right">69.00</td>
                                                        <td class="text-right">2.66</td>
                                                        <td class="text-right">17.00</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left">ก้นกรอง (Menthol)</td>
                                                        <td class="text-right">17.00</td>
                                                        <td class="text-right">17.66</td>
                                                        <td class="text-right">17.00</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-right">รวม</td>
                                                        <td class="text-right table-success">17.00</td>
                                                        <td class="text-right table-success">17.66</td>
                                                        <td class="text-right table-success">69.00</td>
                                                    </tr>
                                                    </tbody>
                                                    <!--End Table ประมาณการผลิต-->

                                                    <!-- Table ประมาณการใช้ -->

                                                    <thead>
                                                    <tr class="tr-header">
                                                        <th style="width: 25%">ประมาณการใช้</th>
                                                        <th style="width: 25%">ปักษ์ที่ 3</th>
                                                        <th style="width: 25%">ปักษ์ที่ 4</th>
                                                        <th style="width: 25%">ปักษ์ที่ 5</th>
                                                    </tr>

                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-left">ก้นกรอง (Mono Acetate) 7.1</td>
                                                        <td class="text-right">69.00</td>
                                                        <td class="text-right">2.66</td>
                                                        <td class="text-right">17.66</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left">ก้นกรอง (Menthol) 7.1</td>
                                                        <td class="text-right">17.00</td>
                                                        <td class="text-right">17.66</td>
                                                        <td class="text-right">69.00</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-right">รวม</td>
                                                        <td class="text-right table-success">17.00</td>
                                                        <td class="text-right table-success">17.66</td>
                                                        <td class="text-right table-success">17.66</td>
                                                    </tr>
                                                    </tbody>
                                                    <!-- End Table ประมาณการใช้ -->

                                                </table>
                                            </div>
                                        </div>
                                        <!-- End tab2 table4 -->

                                        <!-- End table -->

                                    </div>
                                </div>
                                <!-- End content tab2 -->

                                <!-- Content tab3 -->
                                <div id="tab-3" class="tab-pane">
                                    <div class="panel-body">

                                        <!-- table -->
                                        <!-- tab3 table1 -->
                                        <div class="tab3-table1">
                                            <div class="row align-items-center mb-3">
                                                <div class="col-lg-6 col-sm-12">
                                                    <div class="row">
                                                        <label class="col-lg-2 col-form-label"
                                                               for="input13">เดือน</label>
                                                        <div class="col-lg-5">
                                                            <select class="form-control" name="month" id="input13">
                                                                <option>พฤศจิกายน</option>
                                                                <option>ธันวาคม</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-5">
                                                            <button type="button"
                                                                    class="btn btn-warning col-lg-12 btn-lg">
                                                                <i class="fa fa-edit"></i> แก้ไขแผนการผลิตรายวัน
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

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
                                                        <td class="text-left" rowspan="2" style="min-width: 350px;">F6 -
                                                            L1 (P 90 E No.1 - 2 & G.D.121 No.3 - 4)
                                                        </td>
                                                        <td class="text-center bg-primary" colspan="12">sms เขียว
                                                            61.45
                                                        </td>
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
                                                        <td class="text-left" rowspan="2" style="min-width: 350px;">F6 -
                                                            L2 (P 90 E No.5 - 6 & 9 - 10)
                                                        </td>
                                                        <td class="text-center bg-danger" colspan="2">sms แดง 55.30</td>
                                                        <td class="text-center bg-primary" colspan="10">wsa เขียว
                                                            48.69
                                                        </td>

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
                                        <!-- End tab3 table1 -->


                                        <!-- tab3 table2 -->
                                        <div class="tab3-table2">
                                            <div class="row align-items-center mb-3 mt-4">
                                                <lable class="col-lg-2">
                                                    <select class="form-control" name="sms">
                                                        <option>SMS เขียว</option>
                                                        <option>SMS แดง</option>
                                                    </select>
                                                </lable>
                                            </div>
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
                                        <!-- End tab3 table2 -->

                                        <!-- End table -->

                                    </div>
                                </div>
                                <!-- End content tab3 -->

                                <!-- Content tab4 -->
                                <div id="tab-4" class="tab-pane">
                                    <div class="panel-body">

                                        <!-- table -->
                                        <!-- tab4 table1 -->
                                        <div class="tab4-table1">
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="input14">
                                                        คงคลังบุหรี่ปัจจุบัน ณ วันที่
                                                    </label>
                                                    <div class="col-lg-5">
                                                        <input class="form-control" type="text" id="input14" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th colspan="9"> สรุปประมาณการผลิต</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="3" style="min-width: 500px;">บุหรี่ 7.8</th>
                                                        <th colspan="3" style="min-width: 500px;">บุหรี่ 7.1</th>
                                                        <th colspan="3" style="min-width: 500px;">ก้นกรอง</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <!-- Row1 -->
                                                    <tr>
                                                        <td class="text-left">คงคลังบุหรี่ปัจจุบัน</td>
                                                        <td class="col-readonly">401.05</td>
                                                        <td class="text-right">ล้านมวน</td>

                                                        <td class="text-left">คงคลังบุหรี่ปัจจุบัน</td>
                                                        <td class="col-readonly">401.05</td>
                                                        <td class="text-right">ล้านมวน</td>

                                                        <td class="text-left">คงคลังบุหรี่ปัจจุบัน</td>
                                                        <td class="col-readonly">401.05</td>
                                                        <td class="text-right">ล้านมวน</td>
                                                    </tr>
                                                    <!-- End Row1 -->
                                                    <!-- Row2 -->
                                                    <tr>
                                                        <td>
                                                            <label class="col-form-label pull-left" for="input15">
                                                                ประมาณการจำหน่ายถึงสิ้นปักษ์
                                                            </label>
                                                            <div style="width:70px;" class="pull-right">
                                                                <input type="text"
                                                                       class="form-control form-mediumItem text-center"
                                                                       id="input15">
                                                            </div>
                                                        </td>
                                                        <td class="col-readonly">426.402</td>
                                                        <td class="text-right">ล้านมวน</td>

                                                        <td class="text-left">
                                                            <label class="col-form-label pull-left" for="input16">
                                                                ประมาณการจำหน่ายถึงสิ้นปักษ์
                                                            </label>
                                                            <div style="width:70px;" class="pull-right">
                                                                <input type="text"
                                                                       class="form-control form-mediumItem text-center"
                                                                       id="input16">
                                                            </div>
                                                        </td>
                                                        <td class="col-readonly">2.69</td>
                                                        <td class="text-right">ล้านมวน</td>

                                                        <td class="text-left">
                                                            <label class="col-form-label pull-left" for="input17">
                                                                ประมาณการใช้ก้นกรองถึงสิ้นปักษ์
                                                            </label>
                                                            <div style="width:70px;" class="pull-right">
                                                                <input type="text"
                                                                       class="form-control form-mediumItem text-center"
                                                                       id="input17">
                                                            </div>
                                                        </td>
                                                        <td class="col-readonly">401.05</td>
                                                        <td class="text-right">ล้านชิ้น</td>
                                                    </tr>
                                                    <!-- End Row 2-->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- End tab4 table1 -->


                                        <!-- tab4 table2 -->
                                        <div class="tab4-table2">
                                            <div class="col-lg-12 text-right mt-3 mb-3">
                                                หน่วย : ล้านมวน
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr class="tr-header">
                                                        <th rowspan="2" colspan="2">ตราบุหรี่</th>
                                                        <th colspan="3" class="text-right">ปักษ์ปัจจุบัน ปักษ์ที่</th>
                                                        <th class="col-readonly">3</th>
                                                        <th colspan="2" class="text-right">สั่งผลิตใหม่ ปักษ์ที่</th>
                                                        <th class="col-readonly">4</th>
                                                        <th rowspan="2">คาดว่าคงคลังคงเหลือ</th>
                                                        <th rowspan="2">คาดว่าคงคลังคงเหลือ (วัน)</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="min-width: 120px;">คงคลังปัจจุบันใน ASRS</th>
                                                        <th style="min-width: 120px;">ประมาณการผลิต</th>
                                                        <th style="min-width: 120px;">เหลือวันขาย (วัน)</th>
                                                        <th style="min-width: 120px;">เฉลี่ยขาย/วัน</th>
                                                        <th style="min-width: 120px;">ประมาณการขายในปักษ์</th>
                                                        <th style="min-width: 120px;">เป้าหมาย (สั่งผลิต)</th>
                                                        <th style="min-width: 120px;">คาดว่าจะได้ผลผลิต</th>
                                                    </tr>

                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-center" rowspan="3" style="min-width:100px">
                                                            บุหรี่ 7.8
                                                        </td>
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
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" style="min-width:200px">WONDER S
                                                            ซองสีแดง
                                                        </td>
                                                        <td class="text-right">22.66</td>
                                                        <td class="text-right">23.46</td>
                                                        <td class="text-right">144.66</td>
                                                        <td class="text-right">132.0</td>
                                                        <td class="text-right">526.5</td>
                                                        <td class="text-right">762.43</td>
                                                        <td class="text-right">31.66</td>
                                                        <td class="text-right">662.43</td>
                                                        <td class="text-right">726.5</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left" style="min-width:200px">รวม</td>
                                                        <td class="text-right table-success">1,897,265</td>
                                                        <td class="text-right table-success">3,600,000</td>
                                                        <td class="text-right table-success">4054</td>
                                                        <td class="text-right table-success">95,225,600</td>
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
                                        <!-- End tab4 table2 -->

                                        <!-- tab4 table3 -->
                                        <div class="tab4-table3">
                                            <div class="col-lg-12 text-right mt-3 mb-3">
                                                หน่วย : บาท
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr class="tr-header">
                                                        <th colspan="5">ประมาณค่าใช้จ่ายล่วงเวลา</th>
                                                    </tr>
                                                    <tr class="tr-header">
                                                        <th style="width:15%;">หน่วยงาน</th>
                                                        <th style="width:15%;">ประเภทพนักงาน</th>
                                                        <th style="width:20%;">อัตราค่าใช้จ่ายต่อชั่วโมงล่วงเวลา
                                                            (บาท)
                                                        </th>
                                                        <th style="width:15%;">จำนวนชั่วโมงล่วงเวลา</th>
                                                        <th style="width:35%;">รวมเป็นค่าใช้จ่าย</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td rowspan="2" class="text-left">
                                                            ฝ่ายผลิตด้านใบยา
                                                        </td>
                                                        <td class="text-left">พนักงานรายเดือน</td>
                                                        <td class="text-right">18348.32</td>
                                                        <td>8</td>
                                                        <td class="text-right">4036630.43</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">พนักงานรายชั่วโมง</td>
                                                        <td class="text-right">18348.32</td>
                                                        <td>8</td>
                                                        <td class="text-right">4,129,472.60</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right" colspan="2">รวม</td>
                                                        <td class="text-right">37,118.65</td>
                                                        <td>8</td>
                                                        <td class="text-right">8,166,103.00</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-right" colspan="4">รวมทั้งหมด</th>
                                                        <th class="text-right table-success">17,629,766.00</th>
                                                    </tr>
                                                    </tbody>

                                                </table>
                                            </div>
                                        </div>
                                        <!-- End tab4 table3 -->

                                        <!-- End table -->

                                    </div>
                                </div>
                                <!-- End content tab4 -->

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
/*tr.table-fixed {*/
/*    position: sticky;*/
/*    !*left: 0;*!*/
/*    background-color: #fff;*/
/*}*/

.tab-custom ul.nav.nav-tabs li {
    width: 25%;
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
