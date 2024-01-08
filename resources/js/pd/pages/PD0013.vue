<template>
    <div>
        <div class="ibox ">
            <div class="ibox-title">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <h5>ประมาณการใช้วัตถุดิบตามประมาณยอดจำหน่าย :</h5>
                    </div>
                    <div class="col-lg-8">
                        <div class="text-right">
                            <button class="btn btn-w-m btn-success" data-toggle="modal" data-target="#ModalCreate">
                                <i class="fa fa-plus"></i> สร้าง
                            </button>
                            <button type="submit" class="btn btn-w-m btn-default" data-toggle="modal"
                                    data-target="#ModalSearch">
                                <i class="fa fa-search" aria-hidden="true"></i> ค้นหา
                            </button>
                            <button type="submit" class="btn btn-w-m btn-primary">
                                <i class="fa fa-floppy-o" aria-hidden="true"></i> บันทึก
                            </button>

                            <button type="submit" class="btn btn-w-m btn-default" data-toggle="modal"
                                    data-target="#ModalCopy">
                                <i class="fa fa-copy" aria-hidden="true"></i><strong> คัดลอกประมาณ</strong>
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
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="ModalCreateLabel">
                                        สร้างประมาณการใช้วัตถุดิบตามประมาณยอดจำหน่าย</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label" for="select1">
                                                    ปีงบประมาณ
                                                </label>
                                                <div class="col-lg-6">
                                                    <select class="form-control" name="select1" id="select1">
                                                        <option>2565</option>
                                                        <option>2566</option>
                                                        <option>2567</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-6 col-form-label" for="input1">
                                                    ประมาณยอดจำหน่ายปี
                                                </label>
                                                <div class="col-lg-6">
                                                    <input class="form-control" type="text" id="input1">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-lg-6 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label" for="input3">
                                                    ครั้งที่
                                                </label>
                                                <div class="col-lg-3">
                                                    <input class="form-control" type="text" id="input3">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label" for="input4">
                                                    ครั้งที่
                                                </label>
                                                <div class="col-lg-3">
                                                    <input class="form-control" type="text" id="input4">
                                                </div>
                                                <label class="col-lg-3 col-form-label" for="input5">
                                                    ปรับครั้งที่
                                                </label>
                                                <div class="col-lg-3">
                                                    <input type="text" class="form-control" id="input5">
                                                </div>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="form-group row mt-4">
                                        <div class="col-lg-12 text-center">
                                            <button type="button" class="btn btn-primary col-lg-2 p-2">
                                                <i class="fa fa-check"></i>ตกลง
                                            </button>
                                            <button type="button" class="btn btn-danger col-lg-2 p-2"
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

                    <!-- Edit Search -->
                    <div class="modal fade" id="ModalSearch" tabindex="-1" role="dialog"
                         aria-labelledby="ModalSearchLabel"
                         aria-hidden="true">
                        <div class="modal-dialog search-modal modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="ModalSearchLabel">ค้นหาประมาณยอดประจำปี</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <div class="col-lg-12">
                                        <div class="form-group row">
                                            <label class="col-lg-6 col-form-label" for="input6">
                                                ประมาณยอดประจำปี:
                                            </label>
                                            <div class="col-lg-4">
                                                <input class="form-control" type="text" id="input6">
                                            </div>
                                            <div class="col-lg-2">
                                                <button type="button" class="btn btn-default col-lg-12 p-2">
                                                    <i class="fa fa-search"></i> ค้นหา
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th style="width:25%">ปีงบประมาณ</th>
                                                    <th style="width:25%">ครั้งที่</th>
                                                    <th style="width:25%">วันที่อนุมัติ</th>
                                                    <th style="width:25%">ปรับครั้งที่</th>
                                                </tr>

                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>2562</td>
                                                    <td>1</td>
                                                    <td>09/08/2561</td>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                    <td>2562</td>
                                                    <td>1</td>
                                                    <td>09/08/2561</td>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                    <td>2562</td>
                                                    <td>1</td>
                                                    <td>09/08/2561</td>
                                                    <td>-</td>
                                                </tr>
                                                <tr>
                                                    <td>2562</td>
                                                    <td>1</td>
                                                    <td>09/08/2561</td>
                                                    <td>-</td>
                                                </tr>
                                                </tbody>

                                            </table>
                                        </div>

                                    </div>
                                    <div class="form-group row mt-3">
                                        <div class="col-lg-12 text-center">
                                            <button type="button" class="btn btn-primary col-lg-2 p-2">
                                                <i class="fa fa-check"></i>ตกลง
                                            </button>
                                            <button type="button" class="btn btn-danger col-lg-2 p-2"
                                                    data-dismiss="modal">
                                                <i class="fa fa-times"></i>ยกเลิก
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Modal search -->

                    <!-- Modal Copy plan-->
                    <div class="modal fade" id="ModalCopy" tabindex="-1" role="dialog" aria-labelledby="ModalCopy"
                         aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="ModalCopyLabel">
                                        คัดลอกประมาณการใช้วัตถุดิบตามประมาณยอดจำหน่าย</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <div class="row">
                                        <div class="col-lg-6 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-lg-5 col-form-label" for="select2">
                                                    ประมาณการใหม่ปีงบประมาณ
                                                </label>
                                                <div class="col-lg-7">
                                                    <select class="form-control" name="select2" id="select2">
                                                        <option>2565</option>
                                                        <option>2566</option>
                                                        <option>2567</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-5 col-form-label" for="input7">
                                                    ประมาณยอดจำหน่ายปี
                                                </label>
                                                <div class="col-lg-7">
                                                    <input class="form-control" type="text" id="input7">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label" for="input8">
                                                    ครั้งที่
                                                </label>
                                                <div class="col-lg-3">
                                                    <input class="form-control" type="text" id="input8">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-lg-2 col-form-label" for="input9">
                                                    ครั้งที่
                                                </label>
                                                <div class="col-lg-3">
                                                    <input class="form-control" type="text" id="input9">
                                                </div>
                                                <label class="col-lg-3 col-form-label" for="input10">
                                                    ปรับครั้งที่
                                                </label>
                                                <div class="col-lg-3">
                                                    <input type="text" class="form-control" id="input10">
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group row mt-4">
                                        <div class="col-lg-12 text-center">
                                            <button type="button" class="btn btn-primary col-lg-2 p-2"><i
                                                class="fa fa-check"></i>ตกลง
                                            </button>
                                            <button type="button" class="btn btn-danger col-lg-2 p-2"
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
                    <div class="col-lg-6 col-sm-12 row">
                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group row">
                            <span class="col-lg-8 col-form-label">
                                ปีงบประมาณ
                            </span>
                                <span class="col-lg-4 col-form-label">
                                <span class="remark">2564</span>
                            </span>
                            </div>
                            <div class="form-group row">
                            <span class="col-lg-8 col-form-label">
                                ครั้งที่
                            </span>
                                <span class="col-lg-4 col-form-label">
                                <span class="remark">1</span>
                            </span>
                            </div>

                            <div class="form-group row">
                            <span class="col-lg-8 col-form-label">
                                ครั้งที่
                            </span>
                                <span class="col-lg-4 col-form-label">
                                <span class="remark">1</span>
                            </span>
                            </div>
                        </div>

                        <div class="col-lg-6 col-sm-12">
                            <div class="form-group row">
                                <label class="col-lg-9 col-form-label">
                                    อ้างอิงค่า LLD
                                </label>
                                <label class="col-lg-3 col-form-label">
                                    <span class="remark">2563</span>
                                </label>
                            </div>
                            <div class="form-group row">
                            <span class="col-lg-9 col-form-label">
                              ประมาณการยอดจำหน่ายปี
                            </span>
                                <span class="col-lg-3 col-form-label">
                                <span class="remark">2565</span>
                            </span>
                            </div>
                            <div class="form-group row">
                            <span class="col-lg-9 col-form-label">
                                ปรับครั้งที่
                            </span>
                                <span class="col-lg-3 col-form-label">
                                <span class="remark">-</span>
                            </span>
                            </div>
                        </div>
                        <div class="col-lg-12 col-sm-12">
                            <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="select3">
                                    ประเภท
                                </label>
                                <div class="col-lg-8">
                                    <select class="form-control" name="select3" id="select3">
                                        <option>ใบยาในประเทศ</option>
                                        <option>ใบยาต่างประเทศ</option>
                                        <option>เครื่องปรุงบุหรี่</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label" for="input11">
                                วันที่สร้าง
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="date" id="input11">
                            </div>
                            <label class="col-lg-2 col-form-label" for="input12">
                                วันที่แก้ไขล่าสุด
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="date" id="input12">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label" for="select4">
                                สถานะ
                            </label>
                            <div class="col-lg-4">
                                <select class="form-control" name="select4" id="select4">
                                    <option>ใบยาในประเทศ</option>
                                    <option>ใบยาต่างประเทศ</option>
                                    <option>เครื่องปรุงบุหรี่</option>
                                </select>
                            </div>
                            <label class="col-lg-2 col-form-label" for="input14">
                                ผู้บันทึก
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="text" id="input14">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label" for="input15">
                                วันที่อนุมัติ
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="date" id="input15">
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
                                <li><a class="nav-link active" data-toggle="tab" href="#tab-1">เวอร์จิเนีย</a>
                                </li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-2">เบอร์เลย์</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-3">เตอร์กริช </a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-4"> แผ่นยาสูบ</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-5">เครื่องปรุงบุหรี่</a></li>
                            </ul>
                            <!-- end link tab -->
                            <div class="tab-content in-tab-custom">
                                <div id="tab-1" class="tab-pane active">
                                    <!-- content tab1 -->

                                    <div class="panel-body">
                                        <!-- table1 -->
                                        <div class="tab1-table1">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr class="tr-header">
                                                        <th rowspan="3" style="min-width: 150px;"> ตราบุหรี่</th>
                                                        <th rowspan="3" style="min-width: 150px;">
                                                            ประมาณ<br>ยอดจำหน่าย<br>(ล้านมวน)
                                                        </th>
                                                        <th rowspan="3" style="min-width: 150px;">LLD<br>(กก./พันมวน)
                                                        </th>
                                                        <th rowspan="3" style="min-width: 150px;">จำนวนที่ใช้ต่อปี<br>(กก.)
                                                        </th>
                                                        <th rowspan="3" style="min-width: 150px;">จำนวนที่ใช้ต่อเดือน<br>(กก.)
                                                        </th>
                                                        <th colspan="8" class="bg-warning"> ใบยา</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="2" class="bg-primary">AG/ZO/RE</th>
                                                        <th colspan="2" class="bg-primary">AG/ZO/RE-R</th>
                                                        <th colspan="2" class="bg-primary">AG/ZO/RO</th>
                                                        <th colspan="2" class="bg-primary">AG/ZO/RO-R</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="min-width: 50px;">%</th>
                                                        <th style="min-width:100px;">กก.</th>
                                                        <th style="min-width: 50px;">%</th>
                                                        <th style="min-width:100px;">กก.</th>
                                                        <th style="min-width: 50px;">%</th>
                                                        <th style="min-width:100px;">กก.</th>
                                                        <th style="min-width: 50px;">%</th>
                                                        <th style="min-width:100px;">กก.</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <!-- Row1 -->
                                                    <tr>
                                                        <td class="text-left">กรุงทอง 90</td>
                                                        <td class="text-right">100</td>
                                                        <td class="text-right">0.83</td>
                                                        <td class="text-right">83,000.00
                                                        </td>
                                                        <td class="text-right">6916.666667
                                                        </td>
                                                        <td class="text-right">1.00</td>
                                                        <td class="text-right">830.00</td>
                                                        <td class="text-right">2.00</td>
                                                        <td class="text-right">1,660.00</td>
                                                        <td class="text-right">3.00</td>
                                                        <td class="text-right">2,490.00</td>
                                                        <td class="text-right">4.00</td>
                                                        <td class="text-right">3,320.00</td>
                                                    </tr>
                                                    <!-- End Row1 -->
                                                    <!-- Row2 -->
                                                    <tr>
                                                        <td class="text-left table-active">รวมการใช้ใบยา 6 เดือน</td>
                                                        <td class="text-right">100</td>
                                                        <td class="text-right">0.83</td>
                                                        <td class="text-right">83,000.00
                                                        </td>
                                                        <td class="text-right">6916.666667
                                                        </td>
                                                        <td class="text-right">1.00</td>
                                                        <td class="text-right">830.00</td>
                                                        <td class="text-right">2.00</td>
                                                        <td class="text-right">1,660.00</td>
                                                        <td class="text-right">3.00</td>
                                                        <td class="text-right">2,490.00</td>
                                                        <td class="text-right">4.00</td>
                                                        <td class="text-right">3,320.00</td>
                                                    </tr>
                                                    <!-- End Row2 -->

                                                    <!-- Row3 -->
                                                    <tr>
                                                        <td class="text-left table-active">รวมการใช้ใบยาทั้งปี</td>
                                                        <td class="text-right">100</td>
                                                        <td class="text-right">0.83</td>
                                                        <td class="text-right">83,000.00
                                                        </td>
                                                        <td class="text-right">6916.666667
                                                        </td>
                                                        <td class="text-right">1.00</td>
                                                        <td class="text-right">830.00</td>
                                                        <td class="text-right">2.00</td>
                                                        <td class="text-right">1,660.00</td>
                                                        <td class="text-right">3.00</td>
                                                        <td class="text-right">2,490.00</td>
                                                        <td class="text-right">4.00</td>
                                                        <td class="text-right">3,320.00</td>
                                                    </tr>
                                                    <!-- End Row3 -->

                                                    <!-- Row4 -->
                                                    <tr>
                                                        <td class="text-left table-active">อัตราการใช้ต่อเดือน</td>
                                                        <td class="text-right">100</td>
                                                        <td class="text-right">0.83</td>
                                                        <td class="text-right">83,000.00
                                                        </td>
                                                        <td class="text-right">6916.666667
                                                        </td>
                                                        <td class="text-right">1.00</td>
                                                        <td class="text-right">830.00</td>
                                                        <td class="text-right">2.00</td>
                                                        <td class="text-right">1,660.00</td>
                                                        <td class="text-right">3.00</td>
                                                        <td class="text-right">2,490.00</td>
                                                        <td class="text-right">4.00</td>
                                                        <td class="text-right">3,320.00</td>
                                                    </tr>
                                                    <!-- End Row4 -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- End  table1 -->
                                    </div>
                                </div>
                                <!-- End content tab1 -->

                                <!-- Content tab2 -->
                                <div id="tab-2" class="tab-pane">
                                    <div class="panel-body">

                                        <!-- table -->
                                        <div class="tab2-table1">
                                            <div class="table-responsive">
                                                <!-- table1 -->
                                                <div class="tab2-table1">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <tr class="tr-header">
                                                                <th rowspan="3" style="min-width: 150px;"> ตราบุหรี่</th>
                                                                <th rowspan="3" style="min-width: 150px;">
                                                                    ประมาณ<br>ยอดจำหน่าย<br>(ล้านมวน)
                                                                </th>
                                                                <th rowspan="3" style="min-width: 150px;">LLD<br>(กก./พันมวน)
                                                                </th>
                                                                <th rowspan="3" style="min-width: 150px;">จำนวนที่ใช้ต่อปี<br>(กก.)
                                                                </th>
                                                                <th rowspan="3" style="min-width: 150px;">จำนวนที่ใช้ต่อเดือน<br>(กก.)
                                                                </th>
                                                                <th colspan="8" class="bg-warning"> ใบยา</th>
                                                            </tr>
                                                            <tr>
                                                                <th colspan="2" class="bg-primary">AG/ZO/RE</th>
                                                                <th colspan="2" class="bg-primary">AG/ZO/RE-R</th>
                                                                <th colspan="2" class="bg-primary">AG/ZO/RO</th>
                                                                <th colspan="2" class="bg-primary">AG/ZO/RO-R</th>
                                                            </tr>
                                                            <tr>
                                                                <th style="min-width: 50px;">%</th>
                                                                <th style="min-width:100px;">กก.</th>
                                                                <th style="min-width: 50px;">%</th>
                                                                <th style="min-width:100px;">กก.</th>
                                                                <th style="min-width: 50px;">%</th>
                                                                <th style="min-width:100px;">กก.</th>
                                                                <th style="min-width: 50px;">%</th>
                                                                <th style="min-width:100px;">กก.</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <!-- Row1 -->
                                                            <tr>
                                                                <td class="text-left">กรองทิพย์ 90</td>
                                                                <td class="text-right">200</td>
                                                                <td class="text-right">0.77</td>
                                                                <td class="text-right">154,000.00
                                                                </td>
                                                                <td class="text-right">12,833.33
                                                                </td>
                                                                <td class="text-right">1.00</td>
                                                                <td class="text-right">8,300.00</td>
                                                                <td class="text-right">2.00</td>
                                                                <td class="text-right">1,660.00</td>
                                                                <td class="text-right">3.00</td>
                                                                <td class="text-right">2,490.00</td>
                                                                <td class="text-right">4.00</td>
                                                                <td class="text-right">3,320.00</td>
                                                            </tr>
                                                            <!-- End Row1 -->
                                                            <!-- Row2 -->
                                                            <tr>
                                                                <td class="text-left table-active">รวมการใช้ใบยา 6 เดือน</td>
                                                                <td class="text-right">100</td>
                                                                <td class="text-right">0.83</td>
                                                                <td class="text-right">83,000.00
                                                                </td>
                                                                <td class="text-right">6916.666667
                                                                </td>
                                                                <td class="text-right">1.00</td>
                                                                <td class="text-right">830.00</td>
                                                                <td class="text-right">2.00</td>
                                                                <td class="text-right">1,660.00</td>
                                                                <td class="text-right">3.00</td>
                                                                <td class="text-right">2,490.00</td>
                                                                <td class="text-right">4.00</td>
                                                                <td class="text-right">3,320.00</td>
                                                            </tr>
                                                            <!-- End Row2 -->

                                                            <!-- Row3 -->
                                                            <tr>
                                                                <td class="text-left table-active">รวมการใช้ใบยาทั้งปี</td>
                                                                <td class="text-right">100</td>
                                                                <td class="text-right">0.83</td>
                                                                <td class="text-right">83,000.00
                                                                </td>
                                                                <td class="text-right">6916.666667
                                                                </td>
                                                                <td class="text-right">1.00</td>
                                                                <td class="text-right">830.00</td>
                                                                <td class="text-right">2.00</td>
                                                                <td class="text-right">1,660.00</td>
                                                                <td class="text-right">3.00</td>
                                                                <td class="text-right">2,490.00</td>
                                                                <td class="text-right">4.00</td>
                                                                <td class="text-right">3,320.00</td>
                                                            </tr>
                                                            <!-- End Row3 -->

                                                            <!-- Row4 -->
                                                            <tr>
                                                                <td class="text-left table-active">อัตราการใช้ต่อเดือน</td>
                                                                <td class="text-right">100</td>
                                                                <td class="text-right">0.83</td>
                                                                <td class="text-right">83,000.00
                                                                </td>
                                                                <td class="text-right">6916.666667
                                                                </td>
                                                                <td class="text-right">1.00</td>
                                                                <td class="text-right">830.00</td>
                                                                <td class="text-right">2.00</td>
                                                                <td class="text-right">1,660.00</td>
                                                                <td class="text-right">3.00</td>
                                                                <td class="text-right">2,490.00</td>
                                                                <td class="text-right">4.00</td>
                                                                <td class="text-right">3,320.00</td>
                                                            </tr>
                                                            <!-- End Row4 -->
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!-- End  table1 -->
                                            </div>
                                        </div>

                                        <!-- End table -->
                                    </div>
                                </div>
                                <!-- End content tab2 -->

                                <!-- Content tab3 -->
                                <div id="tab-3" class="tab-pane">
                                    <div class="panel-body">

                                        <!-- table3 -->
                                        <div class="tab3-table1">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr class="tr-header">
                                                        <th rowspan="3" style="min-width: 150px;"> ตราบุหรี่</th>
                                                        <th rowspan="3" style="min-width: 150px;">
                                                            ประมาณ<br>ยอดจำหน่าย<br>(ล้านมวน)
                                                        </th>
                                                        <th rowspan="3" style="min-width: 150px;">LLD<br>(กก./พันมวน)
                                                        </th>
                                                        <th rowspan="3" style="min-width: 150px;">จำนวนที่ใช้ต่อปี<br>(กก.)
                                                        </th>
                                                        <th rowspan="3" style="min-width: 150px;">จำนวนที่ใช้ต่อเดือน<br>(กก.)
                                                        </th>
                                                        <th colspan="8" class="bg-warning"> ใบยา</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="2" class="bg-primary">AG/ZO/RE</th>
                                                        <th colspan="2" class="bg-primary">AG/ZO/RE-R</th>
                                                        <th colspan="2" class="bg-primary">AG/ZO/RO</th>
                                                        <th colspan="2" class="bg-primary">AG/ZO/RO-R</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="min-width: 50px;">%</th>
                                                        <th style="min-width:100px;">กก.</th>
                                                        <th style="min-width: 50px;">%</th>
                                                        <th style="min-width:100px;">กก.</th>
                                                        <th style="min-width: 50px;">%</th>
                                                        <th style="min-width:100px;">กก.</th>
                                                        <th style="min-width: 50px;">%</th>
                                                        <th style="min-width:100px;">กก.</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <!-- Row1 -->
                                                    <tr>
                                                        <td class="text-left">สายฝน 90</td>
                                                        <td class="text-right">300</td>
                                                        <td class="text-right">0.83</td>
                                                        <td class="text-right">83,000.00
                                                        </td>
                                                        <td class="text-right">6916.666667
                                                        </td>
                                                        <td class="text-right">1.00</td>
                                                        <td class="text-right">830.00</td>
                                                        <td class="text-right">2.00</td>
                                                        <td class="text-right">1,660.00</td>
                                                        <td class="text-right">3.00</td>
                                                        <td class="text-right">2,490.00</td>
                                                        <td class="text-right">4.00</td>
                                                        <td class="text-right">3,320.00</td>
                                                    </tr>
                                                    <!-- End Row1 -->
                                                    <!-- Row2 -->
                                                    <tr>
                                                        <td class="text-left table-active">รวมการใช้ใบยา 6 เดือน</td>
                                                        <td class="text-right">100</td>
                                                        <td class="text-right">0.83</td>
                                                        <td class="text-right">83,000.00
                                                        </td>
                                                        <td class="text-right">6916.666667
                                                        </td>
                                                        <td class="text-right">1.00</td>
                                                        <td class="text-right">830.00</td>
                                                        <td class="text-right">2.00</td>
                                                        <td class="text-right">1,660.00</td>
                                                        <td class="text-right">3.00</td>
                                                        <td class="text-right">2,490.00</td>
                                                        <td class="text-right">4.00</td>
                                                        <td class="text-right">3,320.00</td>
                                                    </tr>
                                                    <!-- End Row2 -->

                                                    <!-- Row3 -->
                                                    <tr>
                                                        <td class="text-left table-active">รวมการใช้ใบยาทั้งปี</td>
                                                        <td class="text-right">100</td>
                                                        <td class="text-right">0.83</td>
                                                        <td class="text-right">83,000.00
                                                        </td>
                                                        <td class="text-right">6916.666667
                                                        </td>
                                                        <td class="text-right">1.00</td>
                                                        <td class="text-right">830.00</td>
                                                        <td class="text-right">2.00</td>
                                                        <td class="text-right">1,660.00</td>
                                                        <td class="text-right">3.00</td>
                                                        <td class="text-right">2,490.00</td>
                                                        <td class="text-right">4.00</td>
                                                        <td class="text-right">3,320.00</td>
                                                    </tr>
                                                    <!-- End Row3 -->

                                                    <!-- Row4 -->
                                                    <tr>
                                                        <td class="text-left table-active">อัตราการใช้ต่อเดือน</td>
                                                        <td class="text-right">100</td>
                                                        <td class="text-right">0.83</td>
                                                        <td class="text-right">83,000.00
                                                        </td>
                                                        <td class="text-right">6916.666667
                                                        </td>
                                                        <td class="text-right">1.00</td>
                                                        <td class="text-right">830.00</td>
                                                        <td class="text-right">2.00</td>
                                                        <td class="text-right">1,660.00</td>
                                                        <td class="text-right">3.00</td>
                                                        <td class="text-right">2,490.00</td>
                                                        <td class="text-right">4.00</td>
                                                        <td class="text-right">3,320.00</td>
                                                    </tr>
                                                    <!-- End Row4 -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- End  table3 -->
                                    </div>
                                </div>
                                <!-- End content tab3 -->

                                <!-- Content tab4 -->
                                <div id="tab-4" class="tab-pane">
                                    <div class="panel-body">

                                        <!-- table4 -->
                                        <div class="tab4-table1">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr class="tr-header">
                                                        <th rowspan="3" style="min-width: 150px;"> ตราบุหรี่</th>
                                                        <th rowspan="3" style="min-width: 150px;">
                                                            ประมาณ<br>ยอดจำหน่าย<br>(ล้านมวน)
                                                        </th>
                                                        <th rowspan="3" style="min-width: 150px;">LLD<br>(กก./พันมวน)
                                                        </th>
                                                        <th rowspan="3" style="min-width: 150px;">จำนวนที่ใช้ต่อปี<br>(กก.)
                                                        </th>
                                                        <th rowspan="3" style="min-width: 150px;">จำนวนที่ใช้ต่อเดือน<br>(กก.)
                                                        </th>
                                                        <th colspan="8" class="bg-warning"> ใบยา</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="2" class="bg-primary">AG/ZO/RE</th>
                                                        <th colspan="2" class="bg-primary">AG/ZO/RE-R</th>
                                                        <th colspan="2" class="bg-primary">AG/ZO/RO</th>
                                                        <th colspan="2" class="bg-primary">AG/ZO/RO-R</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="min-width: 50px;">%</th>
                                                        <th style="min-width:100px;">กก.</th>
                                                        <th style="min-width: 50px;">%</th>
                                                        <th style="min-width:100px;">กก.</th>
                                                        <th style="min-width: 50px;">%</th>
                                                        <th style="min-width:100px;">กก.</th>
                                                        <th style="min-width: 50px;">%</th>
                                                        <th style="min-width:100px;">กก.</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <!-- Row1 -->
                                                    <tr>
                                                        <td class="text-left">SMS แดง</td>
                                                        <td class="text-right">400</td>
                                                        <td class="text-right">0.83</td>
                                                        <td class="text-right">83,000.00
                                                        </td>
                                                        <td class="text-right">6916.666667
                                                        </td>
                                                        <td class="text-right">1.00</td>
                                                        <td class="text-right">830.00</td>
                                                        <td class="text-right">2.00</td>
                                                        <td class="text-right">1,660.00</td>
                                                        <td class="text-right">3.00</td>
                                                        <td class="text-right">2,490.00</td>
                                                        <td class="text-right">4.00</td>
                                                        <td class="text-right">3,320.00</td>
                                                    </tr>
                                                    <!-- End Row1 -->
                                                    <!-- Row2 -->
                                                    <tr>
                                                        <td class="text-left table-active">รวมการใช้ใบยา 6 เดือน</td>
                                                        <td class="text-right">100</td>
                                                        <td class="text-right">0.83</td>
                                                        <td class="text-right">83,000.00
                                                        </td>
                                                        <td class="text-right">6916.666667
                                                        </td>
                                                        <td class="text-right">1.00</td>
                                                        <td class="text-right">830.00</td>
                                                        <td class="text-right">2.00</td>
                                                        <td class="text-right">1,660.00</td>
                                                        <td class="text-right">3.00</td>
                                                        <td class="text-right">2,490.00</td>
                                                        <td class="text-right">4.00</td>
                                                        <td class="text-right">3,320.00</td>
                                                    </tr>
                                                    <!-- End Row2 -->

                                                    <!-- Row3 -->
                                                    <tr>
                                                        <td class="text-left table-active">รวมการใช้ใบยาทั้งปี</td>
                                                        <td class="text-right">100</td>
                                                        <td class="text-right">0.83</td>
                                                        <td class="text-right">83,000.00
                                                        </td>
                                                        <td class="text-right">6916.666667
                                                        </td>
                                                        <td class="text-right">1.00</td>
                                                        <td class="text-right">830.00</td>
                                                        <td class="text-right">2.00</td>
                                                        <td class="text-right">1,660.00</td>
                                                        <td class="text-right">3.00</td>
                                                        <td class="text-right">2,490.00</td>
                                                        <td class="text-right">4.00</td>
                                                        <td class="text-right">3,320.00</td>
                                                    </tr>
                                                    <!-- End Row3 -->

                                                    <!-- Row4 -->
                                                    <tr>
                                                        <td class="text-left table-active">อัตราการใช้ต่อเดือน</td>
                                                        <td class="text-right">100</td>
                                                        <td class="text-right">0.83</td>
                                                        <td class="text-right">83,000.00
                                                        </td>
                                                        <td class="text-right">6916.666667
                                                        </td>
                                                        <td class="text-right">1.00</td>
                                                        <td class="text-right">830.00</td>
                                                        <td class="text-right">2.00</td>
                                                        <td class="text-right">1,660.00</td>
                                                        <td class="text-right">3.00</td>
                                                        <td class="text-right">2,490.00</td>
                                                        <td class="text-right">4.00</td>
                                                        <td class="text-right">3,320.00</td>
                                                    </tr>
                                                    <!-- End Row4 -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- End  table4 -->
                                    </div>
                                </div>
                                <!-- End content tab4 -->
                                <!-- Content tab5 -->
                                <div id="tab-5" class="tab-pane">

                                    <div class="panel-body">

                                        <!-- table5 -->
                                        <div class="tab5-table1">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr class="tr-header">
                                                        <th rowspan="3" style="min-width: 150px;"> ตราบุหรี่</th>
                                                        <th rowspan="3" style="min-width: 150px;">
                                                            ประมาณ<br>ยอดจำหน่าย<br>(ล้านมวน)
                                                        </th>
                                                        <th rowspan="3" style="min-width: 150px;">LLD<br>(กก./พันมวน)
                                                        </th>
                                                        <th rowspan="3" style="min-width: 150px;">จำนวนที่ใช้ต่อปี<br>(กก.)
                                                        </th>
                                                        <th rowspan="3" style="min-width: 150px;">จำนวนที่ใช้ต่อเดือน<br>(กก.)
                                                        </th>
                                                        <th colspan="8" class="bg-warning">เครื่องปรุงบุหรี่</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="2" class="bg-primary">Tobacco Flavour 001</th>
                                                        <th colspan="2" class="bg-primary">Tobacco Flavour 002</th>
                                                        <th colspan="2" class="bg-primary">White sugar</th>
                                                    </tr>
                                                    <tr>
                                                        <th style="min-width: 100px;">การใช้ต่อ 100 กก.</th>
                                                        <th style="min-width: 100px;">กก.</th>
                                                        <th style="min-width: 100px;">การใช้ต่อ 100 กก.</th>
                                                        <th style="min-width: 100px;">กก.</th>
                                                        <th style="min-width: 100px;">การใช้ต่อ 100 กก.</th>
                                                        <th style="min-width: 100px;">กก.</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <!-- Row1 -->
                                                    <tr>
                                                        <td class="text-left">กรุงทอง 90</td>
                                                        <td class="text-right">100</td>
                                                        <td class="text-right">0.83</td>
                                                        <td class="text-right">83,000.00
                                                        </td>
                                                        <td class="text-right">6916.666667
                                                        </td>
                                                        <td class="text-right">1.00</td>
                                                        <td class="text-right">830.00</td>
                                                        <td class="text-right">2.00</td>
                                                        <td class="text-right">1,660.00</td>
                                                        <td class="text-right">3.00</td>
                                                        <td class="text-right">2,490.00</td>
                                                    </tr>
                                                    <!-- End Row1 -->
                                                    <!-- Row2 -->
                                                    <tr>
                                                        <td class="text-left table-active">รวมการใช้ 6 เดือน</td>
                                                        <td class="text-right">100</td>
                                                        <td class="text-right">0.83</td>
                                                        <td class="text-right">83,000.00
                                                        </td>
                                                        <td class="text-right">6916.666667
                                                        </td>
                                                        <td class="text-right">1.00</td>
                                                        <td class="text-right">830.00</td>
                                                        <td class="text-right">2.00</td>
                                                        <td class="text-right">1,660.00</td>
                                                        <td class="text-right">3.00</td>
                                                        <td class="text-right">2,490.00</td>
                                                    </tr>
                                                    <!-- End Row2 -->

                                                    <!-- Row3 -->
                                                    <tr>
                                                        <td class="text-left table-active">รวมการใช้ทั้งปี</td>
                                                        <td class="text-right">100</td>
                                                        <td class="text-right">0.83</td>
                                                        <td class="text-right">83,000.00
                                                        </td>
                                                        <td class="text-right">6916.666667
                                                        </td>
                                                        <td class="text-right">1.00</td>
                                                        <td class="text-right">830.00</td>
                                                        <td class="text-right">2.00</td>
                                                        <td class="text-right">1,660.00</td>
                                                        <td class="text-right">3.00</td>
                                                        <td class="text-right">2,490.00</td>
                                                    </tr>
                                                    <!-- End Row3 -->

                                                    <!-- Row4 -->
                                                    <tr>
                                                        <td class="text-left table-active">อัตราการใช้ต่อเดือน</td>
                                                        <td class="text-right">100</td>
                                                        <td class="text-right">0.83</td>
                                                        <td class="text-right">83,000.00
                                                        </td>
                                                        <td class="text-right">6916.666667
                                                        </td>
                                                        <td class="text-right">1.00</td>
                                                        <td class="text-right">830.00</td>
                                                        <td class="text-right">2.00</td>
                                                        <td class="text-right">1,660.00</td>
                                                        <td class="text-right">3.00</td>
                                                        <td class="text-right">2,490.00</td>
                                                    </tr>
                                                    <!-- End Row4 -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- End  table5 -->
                                    </div>
                                </div>
                                <!-- End content tab5 -->

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
.tab-custom ul.nav.nav-tabs li {
    width: 20%;
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


</style>
