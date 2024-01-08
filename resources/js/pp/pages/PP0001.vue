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
                            <label class="col-lg-6 col-form-label" for="input1">
                                ค้นหาประมาณการผลิตประจำปีงบประมาณ :
                            </label>
                            <div class="col-lg-6">
                                <input class="form-control" type="text" autocomplete="off" placeholder="Search" id="input1">
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
                        <h5></h5>
                    </div>
                    <div class="col-lg-8">
                        <div class="text-right">
                            <button class="btn btn-w-m btn-success" data-toggle="modal" data-target="#ModalCreate">
                                <i class="fa fa-plus"></i> สร้าง
                            </button>
                            <button type="submit" class="btn btn-w-m btn-warning">
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
                    </div>

                    <div class="col-lg-3 col-sm-12">
                        <div class="form-group row">
                            <label class="col-lg-4 col-form-label" for="">
                                ครั้งที่
                            </label>
                            <label class="col-lg-3 col-form-label" for="">
                                <span class="remark">1</span>
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label" for="input2">
                                วันที่สร้าง
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="text"  id="input2">
                            </div>
                            <label class="col-lg-2 col-form-label" for="">
                                วันที่แก้ไขล่าสุด
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label" for="">
                                สถานะ
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                            <label class="col-lg-2 col-form-label" for="">
                                ผู้บันทึก
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-2 col-form-label" for="">
                                วันที่อนุมัติ
                            </label>
                            <div class="col-lg-4">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- tab -->
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">

                    <!-- in tab -->
                    <div class="ibox-content">
                        <div class="tabs-container pp001">
                            <!-- link tab -->
                            <ul class="nav nav-tabs">
                                <li><a class="nav-link active" data-toggle="tab" href="#tab-1"> ประมาณกำลังการผลิต</a>
                                </li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-2">ประมาณการผลิตแยกรายตรา</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-3">ประมาณการผลิตทั้งปีงบประมาณ</a>
                                </li>
                            </ul>
                            <!-- end link tab -->
                            <div class="tab-content tab-pp001">
                                <div id="tab-1" class="tab-pane active">
                                    <!-- content tab1 -->
                                    <div class="panel-body">
                                        <!-- tab1-table1 -->
                                        <div class="tab1-table1 ">
                                            <div class="col-lg-12 text-right mt-4 mb-3">
                                                หน่วย : ล้านมวน
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr class="tr-header">
                                                        <th colspan="14">
                                                            แผนการซ่อมบำรงและลดกำลังการผลิตเครื่องจักรมวน 7.8
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-left" rowspan="100" width="23%">
                                                            กำหนดการหยุดซ่อมบำรุงประจำปี ลดกำลังการผลิตต่อวัน
                                                        </td>
                                                        <td>ต.ค.</td>
                                                        <td>พ.ย.</td>
                                                        <td>ธ.ค.</td>
                                                        <td>ม.ค.</td>
                                                        <td>ก.พ.</td>
                                                        <td>มี.ค.</td>
                                                        <td>เม.ย.</td>
                                                        <td>พ.ค.</td>
                                                        <td>มิ.ย.</td>
                                                        <td>ก.ค.</td>
                                                        <td>ส.ค.</td>
                                                        <td>ก.ย.</td>
                                                        <td>รวม</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">-</td>
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
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">-</td>
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

                                                    <!-- end row1 -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- End tab1-table1 -->

                                        <!-- tab1-table2 -->
                                        <div class="tab1-table2">
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
                                                                    <span class="col-lg-4 col-form-label" for="">
                                                                        สั่งผลิต </span>
                                                                <input class="form-control col-lg-3" type="text"
                                                                       autocomplete="off">
                                                                <span class="col-lg-2 col-form-label" for="">
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
                                                        <th>วันผลิต/ปี<br>(วัน)</th>
                                                        <th>จำนวนวันเพิ่ม 4 ชม.</th>
                                                        <th>ผลผลิตทั้งปี</th>
                                                        <th>ขาดผลผลิตช่วงลดกำลัง</th>
                                                        <th>ขาดผลผลิต</th>
                                                        <th>ผลผลิตหักลดกำลัง</th>
                                                        <th>ผลผลิตหักลดกำลัง PM</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-center" rowspan="3" width="10%">
                                                            บุหรี่ 7.8
                                                        </td>
                                                        <td class="text-left" width="20%">F6-L1</td>
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
                                                        <td class="text-left" width="20%">F6-L1</td>
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
                                                        <td class="text-left" width="20%">รวมกำลังการผลิต</td>
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
                                                        <td class="text-center" rowspan="2" width="10%">
                                                            บุหรี่ 7.1
                                                        </td>
                                                        <td class="text-left" width="20%">F6-L10</td>
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
                                                        <td class="text-left" width="20%">รวมกำลังการผลิต</td>
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
                                                        <td class="text-center" rowspan="2" width="10%">
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
                                                        <td class="text-left" width="20%">รวมกำลังการผลิต</td>
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
                                        <!-- End tab1-table2 -->

                                        <!-- tab1-table3 -->
                                        <div class="tab1-table3 mt-5">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr class="tr-header table-pp">
                                                        <th colspan="2" style="min-width:350px">ชั่วโมงทำงาน</th>
                                                        <th colspan="2">ตุลาคม</th>
                                                        <th colspan="2">พฤศจิกายน</th>
                                                        <th colspan="2">ธันวาคม</th>
                                                        <th colspan="2">มกราคม</th>
                                                        <th colspan="2">กุมภาพันธ์</th>
                                                        <th colspan="2">รวมทั้งปี</th>
                                                    </tr>

                                                    </thead>
                                                    <tbody>
                                                    <!--  ชั่วโมงทำงาน -->
                                                    <tr>
                                                        <td class="text-left" colspan="2" width="">จำนวนวันทำงาน 8
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
                                                        <td class="text-left" colspan="2" width="">จำนวนวันทำงาน 9
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
                                                        <td class="text-left" colspan="2" width="">จำนวนวันทำงาน 13
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
                                                        <td class="text-right" colspan="2" width="">รวมวันทำงาน</td>
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
                                                                    <span class="col-lg-3 col-form-label" for="">
                                                                        สั่งผลิต </span>
                                                                <input class="form-control col-lg-3" type="text"
                                                                       autocomplete="off">
                                                                <span class="col-lg-2 col-form-label" for="">
                                                                        %</span>
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
                                                        <td>F6 - L1</td>
                                                        <td>307.200</td>
                                                        <td>215.040</td>
                                                        <td>307.200</td>
                                                        <td>80,000</td>
                                                        <td>307.200</td>
                                                        <td>215.040</td>
                                                        <td>307.200</td>
                                                        <td>215.040</td>
                                                        <td>307.200</td>
                                                        <td>215.040</td>
                                                        <td>307.200</td>
                                                        <td>215.040</td>
                                                    </tr>
                                                    <tr>
                                                        <td>F6 - L2</td>
                                                        <td>307.200</td>
                                                        <td>215.040</td>
                                                        <td>307.200</td>
                                                        <td>215.040</td>
                                                        <td>307.200</td>
                                                        <td>215.040</td>
                                                        <td>307.200</td>
                                                        <td>307.200</td>
                                                        <td>215.040</td>
                                                        <td>307.200</td>
                                                        <td>215.040</td>
                                                        <td>215.040</td>
                                                    </tr>
                                                    <tr>
                                                        <td>F6 - L3</td>
                                                        <td>307.200</td>
                                                        <td>215.040</td>
                                                        <td>307.200</td>
                                                        <td>307.200</td>
                                                        <td>307.200</td>
                                                        <td>215.040</td>
                                                        <td>307.200</td>
                                                        <td>215.040</td>
                                                        <td>307.200</td>
                                                        <td>215.040</td>
                                                        <td>307.200</td>
                                                        <td>215.040</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-right">รวมผลผลิต</td>
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
                                                        <td>F6 - L1</td>
                                                        <td>307.200</td>
                                                        <td>215.040</td>
                                                        <td>307.200</td>
                                                        <td>215.040</td>
                                                        <td>307.200</td>
                                                        <td>215.040</td>
                                                        <td>307.200</td>
                                                        <td>307.200</td>
                                                        <td>307.200</td>
                                                        <td>215.040</td>
                                                        <td>307.200</td>
                                                        <td>215.040</td>
                                                    </tr>


                                                    <tr>
                                                        <td class="text-right">รวมผลผลิต</td>
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
                                                        <td>ก้นกรอง Mono Acetate</td>
                                                        <td>307.200</td>
                                                        <td>215.040</td>
                                                        <td>307.200</td>
                                                        <td>215.040</td>
                                                        <td>307.200</td>
                                                        <td>215.040</td>
                                                        <td>307.200</td>
                                                        <td>215.040</td>
                                                        <td>307.200</td>
                                                        <td>307.200</td>
                                                        <td>215.040</td>
                                                        <td>307.200</td>
                                                    </tr>


                                                    <tr>
                                                        <td class="text-right">รวมผลผลิต</td>
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
                                        <!-- End tab1-table3 -->


                                    </div>
                                </div>
                                <!-- End content tab1 -->

                                <!-- Content tab2 -->
                                <div id="tab-2" class="tab-pane">
                                    <div class="panel-body">

                                        <!-- table -->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="ibox ">
                                                    <!-- tab2 table1 -->
                                                    <div class="tab2-table1">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered mt-4">
                                                                <thead>
                                                                <tr class="tr-header">
                                                                    <th rowspan="2" style="min-width:200px;">
                                                                        วันทำงาน
                                                                    </th>
                                                                    <th colspan="2"> ตุลาคม</th>
                                                                    <th colspan="2"> พฤศจิกายน</th>
                                                                    <th colspan="2"> ธันวาคม</th>
                                                                    <th colspan="2"> มกราคม</th>
                                                                    <th colspan="2"> กุมภาพันธ์</th>
                                                                    <th colspan="2"> มีนาคม</th>
                                                                    <th colspan="2"> รวมทั้งปี</th>

                                                                </tr>
                                                                <tr class="tr-header">
                                                                    <th style="min-width:120px;"> จำนวน(วัน)</th>
                                                                    <th style="min-width:120px;">จำนวน(ชั่วโมง)</th>
                                                                    <th style="min-width:120px;"> จำนวน(วัน)</th>
                                                                    <th style="min-width:120px;">จำนวน(ชั่วโมง)</th>
                                                                    <th style="min-width:120px;"> จำนวน(วัน)</th>
                                                                    <th style="min-width:120px;">จำนวน(ชั่วโมง)</th>
                                                                    <th style="min-width:120px;"> จำนวน(วัน)</th>
                                                                    <th style="min-width:120px;">จำนวน(ชั่วโมง)</th>
                                                                    <th style="min-width:120px;"> จำนวน(วัน)</th>
                                                                    <th style="min-width:120px;">จำนวน(ชั่วโมง)</th>
                                                                    <th style="min-width:120px;"> จำนวน(วัน)</th>
                                                                    <th style="min-width:120px;">จำนวน(ชั่วโมง)</th>
                                                                    <th style="min-width:120px;"> จำนวน(วัน)</th>
                                                                    <th style="min-width:120px;">จำนวน(ชั่วโมง)</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>

                                                                <tr>
                                                                    <td class="text-left">8 ชั่วโมง</td>
                                                                    <td class="text-right">-</td>
                                                                    <td class="text-right">-</td>
                                                                    <td class="text-right">-</td>
                                                                    <td class="text-right">-</td>
                                                                    <td class="text-right">-</td>
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
                                                                    <td class="text-left">9 ชั่วโมง</td>
                                                                    <td class="text-right">20.00</td>
                                                                    <td class="text-right">20.00</td>
                                                                    <td class="text-right">21.00</td>
                                                                    <td class="text-right">16.00</td>
                                                                    <td class="text-right">12.00</td>
                                                                    <td class="text-right">21.00</td>
                                                                    <td class="text-right">16.00</td>
                                                                    <td class="text-right">12.00</td>
                                                                    <td class="text-right">21.00</td>
                                                                    <td class="text-right">16.00</td>
                                                                    <td class="text-right">12.00</td>
                                                                    <td class="text-right">1686.00</td>
                                                                    <td class="text-right">12.00</td>
                                                                    <td class="text-right">1686.00</td>
                                                                </tr>


                                                                <tr>
                                                                    <td class="text-right" width="">รวมวันทำงาน</td>
                                                                    <td class="text-right table-success">60,000</td>
                                                                    <td class="text-right table-success">960,000
                                                                    </td>
                                                                    <td class="text-right table-success">1,960,000
                                                                    </td>
                                                                    <td class="text-right table-success">11,960,000
                                                                    </td>
                                                                    <td class="text-right table-success">211,960,000
                                                                    </td>
                                                                    <td class="text-right table-success">
                                                                        12,11,960,000
                                                                    </td>
                                                                    <td class="text-right table-success">1,960,000
                                                                    </td>
                                                                    <td class="text-right table-success">11,960,000
                                                                    </td>
                                                                    <td class="text-right table-success">211,960,000
                                                                    </td>
                                                                    <td class="text-right table-success">
                                                                        12,11,960,000
                                                                    </td>
                                                                    <td class="text-right table-success">1,960,000
                                                                    </td>
                                                                    <td class="text-right table-success">11,960,000
                                                                    </td>
                                                                    <td class="text-right table-success">211,960,000
                                                                    </td>
                                                                    <td class="text-right table-success">
                                                                        9,444,960,000
                                                                    </td>
                                                                </tr>


                                                                <tr>
                                                                    <td class="text-left">วันทำงานปกติ</td>
                                                                    <td class="text-right">20</td>
                                                                    <td class="text-right">180</td>
                                                                    <td class="text-right">21</td>
                                                                    <td class="text-right">189</td>
                                                                    <td class="text-right">16</td>
                                                                    <td class="text-right">144</td>
                                                                    <td class="text-right">12</td>
                                                                    <td class="text-right">96</td>
                                                                    <td class="text-right">16</td>
                                                                    <td class="text-right">128</td>
                                                                    <td class="text-right">32</td>
                                                                    <td class="text-right">184</td>
                                                                    <td class="text-right">1488</td>
                                                                    <td class="text-right">666</td>

                                                                </tr>
                                                                <tr>
                                                                    <td class="text-left">วันหยุด PM</td>
                                                                    <td class="text-right">20</td>
                                                                    <td class="text-right">180</td>
                                                                    <td class="text-right">21</td>
                                                                    <td class="text-right">189</td>
                                                                    <td class="text-right">16</td>
                                                                    <td class="text-right">144</td>
                                                                    <td class="text-right">12</td>
                                                                    <td class="text-right">96</td>
                                                                    <td class="text-right">16</td>
                                                                    <td class="text-right">128</td>
                                                                    <td class="text-right">32</td>
                                                                    <td class="text-right">184</td>
                                                                    <td class="text-right">1488</td>
                                                                    <td class="text-right">666</td>

                                                                </tr>

                                                                <tr>
                                                                    <td class="text-left">วันขาย</td>
                                                                    <td class="text-right table-primary">20</td>
                                                                    <td class="text-right table-primary">180</td>
                                                                    <td class="text-right table-primary">21</td>
                                                                    <td class="text-right table-primary">189</td>
                                                                    <td class="text-right table-primary">16</td>
                                                                    <td class="text-right table-primary">144</td>
                                                                    <td class="text-right table-primary">12</td>
                                                                    <td class="text-right table-primary">96</td>
                                                                    <td class="text-right table-primary">16</td>
                                                                    <td class="text-right table-primary">128</td>
                                                                    <td class="text-right table-primary">32</td>
                                                                    <td class="text-right table-primary">184</td>
                                                                    <td class="text-right table-primary">1488</td>
                                                                    <td class="text-right table-primary">666</td>

                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>

                                                    <!-- End tab2 table1 -->
                                                    <!-- tab2 table2 -->
                                                    <div class="tab2-table2 mt-5">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered ">
                                                                <thead>
                                                                <tr>
                                                                    <th class="tr-header" rowspan="3" colspan="2">
                                                                        ตราบุหรี่
                                                                    </th>
                                                                    <th rowspan="3" style="min-width:120px;">
                                                                        ผลิต/BATCH <br>(ล้านมวน)
                                                                    </th>
                                                                    <th rowspan="3" style="min-width:120px;">
                                                                        อัตราการใช้ใบยาต่อ 1 ล้านมวน<br>(กก.)
                                                                    </th>
                                                                    <th rowspan="3" style="min-width:120px;">
                                                                        คงคลัง<br> (ล้านมวน)
                                                                    </th>
                                                                    <th colspan="4">ตุลาคม</th>
                                                                    <th rowspan="3" style="min-width:120px;">คงเหลือ
                                                                        <br>(ล้านมวน)
                                                                    </th>
                                                                    <th colspan="4">พฤศจิกายน</th>
                                                                    <th rowspan="3" style="min-width:120px;">
                                                                        คงเหลือ<br> (ล้านมวน)
                                                                    </th>
                                                                    <th rowspan="3" style="min-width:120px;">รวมผลิต
                                                                        <br>(ล้านมวน)
                                                                    </th>
                                                                    <th rowspan="3" style="min-width:120px;">
                                                                        รวมจำหน่าย <br>(ล้านมวน)
                                                                    </th>
                                                                    <th rowspan="3" style="min-width:120px;">
                                                                        ขาด/เกิน <br>(ล้านมวน)
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <th colspan="3">ผลิต</th>
                                                                    <th rowspan="2">จำหน่าย<br>(ล้านมวน)</th>
                                                                    <th colspan="3">ผลิต</th>
                                                                    <th rowspan="2">จำหน่าย<br>(ล้านมวน)</th>
                                                                </tr>
                                                                <tr>
                                                                    <th style="min-width:120px;">จำนวน<br>(ชุด)</th>
                                                                    <th style="min-width:120px;">
                                                                        สั่งผลิต<br>(ล้านมวน)
                                                                    </th>
                                                                    <th style="min-width:120px;">ปริมาณใบยา<br>(กก.)
                                                                    </th>
                                                                    <th style="min-width:120px;">จำนวน<br>(ชุด)</th>
                                                                    <th style="min-width:120px;">
                                                                        สั่งผลิต<br>(ล้านมวน)
                                                                    </th>
                                                                    <th style="min-width:120px;">ปริมาณใบยา<br>(กก.)
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td rowspan="2" style="min-width:150px;">บุหรี่
                                                                        7.8
                                                                    </td>
                                                                    <td style="min-width:200px;" class="text-left">
                                                                        สามิต 90
                                                                    </td>
                                                                    <td class="text-right">13.00</td>
                                                                    <td class="text-right">600.00</td>
                                                                    <td class="text-right">0.09</td>
                                                                    <td class="text-right"><small>0.10</small></td>
                                                                    <td class="text-right">1.30</td>
                                                                    <td class="text-right">780.00</td>
                                                                    <td class="text-right">0.32</td>
                                                                    <td class="text-right">1.07</td>
                                                                    <td class="text-right"><small>-</small></td>
                                                                    <td class="text-right">-</td>
                                                                    <td class="text-right">-</td>
                                                                    <td class="text-right">0.10</td>
                                                                    <td class="text-right">0.78</td>
                                                                    <td class="text-right">7.80</td>
                                                                    <td class="text-right">4.60</td>
                                                                    <td class="text-right">3.20</td>
                                                                </tr>

                                                                <tr>

                                                                    <td style="min-width:200px;" class="text-left">
                                                                        กรุงทอง 90
                                                                    </td>
                                                                    <td class="text-right">4565.00</td>
                                                                    <td class="text-right">564.00</td>
                                                                    <td class="text-right">2342.09</td>
                                                                    <td class="text-right"><small>45.10</small></td>
                                                                    <td class="text-right">324.30</td>
                                                                    <td class="text-right">780.00</td>
                                                                    <td class="text-right">0.32</td>
                                                                    <td class="text-right">1.07</td>
                                                                    <td class="text-right"><small>434.0</small></td>
                                                                    <td class="text-right">-</td>
                                                                    <td class="text-right">-</td>
                                                                    <td class="text-right">1,500.10</td>
                                                                    <td class="text-right">387.78</td>
                                                                    <td class="text-right">5555.80</td>
                                                                    <td class="text-right">34.60</td>
                                                                    <td class="text-right">35345.20</td>
                                                                </tr>
                                                                <tr>

                                                                    <td colspan="4" class="text-right">รวม</td>
                                                                    <td class="table-success text-right">4565.00
                                                                    </td>
                                                                    <td class="table-success text-right">
                                                                        <small>45.10</small></td>
                                                                    <td class="table-success text-right"><span
                                                                        class="remark">2342.09</span></td>
                                                                    <td class="table-success text-right">780.00</td>
                                                                    <td class="table-success text-right">0.32</td>
                                                                    <td class="table-success text-right">1.07</td>
                                                                    <td class="table-success text-right">
                                                                        <small>434.0</small></td>
                                                                    <td class="table-success text-right"><span
                                                                        class="remark">3434.00</span></td>
                                                                    <td class="table-success text-right">343.00</td>
                                                                    <td class="table-success text-right">-</td>
                                                                    <td class="table-success text-right">387.78</td>
                                                                    <td class="table-success text-right"><span
                                                                        class="remark">1,3434.00</span></td>
                                                                    <td class="table-success text-right">5555.80
                                                                    </td>
                                                                    <td class="table-success text-right">35345.20
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <!-- End tab2 table2 -->


                                                    <!-- tab2 table3 -->
                                                    <div class="tab2-table3 mt-5">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                <tr class="tr-header table-pp">
                                                                    <th style="min-width:350px">ประมาณการผลิต</th>
                                                                    <th style="min-width:250px">ตุลาคม</th>
                                                                    <th style="min-width:250px">พฤศจิกายน</th>
                                                                    <th style="min-width:250px">ธันวาคม</th>
                                                                    <th style="min-width:250px">มกราคม</th>
                                                                    <th style="min-width:250px">กุมภาพันธ์</th>
                                                                    <th style="min-width:250px">รวมทั้งปี</th>
                                                                </tr>

                                                                </thead>
                                                                <tbody>
                                                                <!--  ประมาณการผลิต -->
                                                                <tr>
                                                                    <td class="text-left" width="">ก้นกรอง (Mono
                                                                        Acetate) (ล้านซิ้น)
                                                                    </td>
                                                                    <td class="text-right">53.760</td>
                                                                    <td class="text-right">64.45</td>
                                                                    <td class="text-right">45.5645</td>
                                                                    <td class="text-right">56.00</td>
                                                                    <td class="text-right">56.677</td>
                                                                    <td class="text-right">456.44</td>
                                                                </tr>

                                                                <tr>
                                                                    <td class="text-right" width="">รวม</td>
                                                                    <td class="text-right table-success">20.00</td>
                                                                    <td class="text-right table-success">20.00</td>
                                                                    <td class="text-right table-success">21.00</td>
                                                                    <td class="text-right table-success">16.00</td>
                                                                    <td class="text-right table-success">12.00</td>
                                                                    <td class="text-right table-success">1686.00
                                                                    </td>
                                                                </tr>
                                                                <!-- end ชั่วโมงทำงาน -->
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <!-- End tab2 table3 -->

                                                </div>
                                            </div>
                                        </div>
                                        <!-- End table -->
                                    </div>
                                </div>
                                <!-- End content tab2 -->

                                <!-- Content tab3 -->
                                <div id="tab-3" class="tab-pane">
                                    <div class="panel-body">
                                        <!-- tab3 table1 -->
                                        <div class="tab3-table1 mt-5">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr class="tr-header">
                                                        <th colspan="14"> ประมาณการผลิต</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-left" style="min-width:350px;">
                                                            บุหรี่ 7.8
                                                        </td>
                                                        <td>ต.ค.</td>
                                                        <td>พ.ย.</td>
                                                        <td>ธ.ค.</td>
                                                        <td>ม.ค.</td>
                                                        <td>ก.พ.</td>
                                                        <td>มี.ค.</td>
                                                        <td>เม.ย.</td>
                                                        <td>พ.ค.</td>
                                                        <td>มิ.ย.</td>
                                                        <td>ก.ค.</td>
                                                        <td>ส.ค.</td>
                                                        <td>ก.ย.</td>
                                                        <td>รวม</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left">1.ประมาณการจำหน่าย</td>
                                                        <td class="text-right">1,139.27</td>
                                                        <td class="text-right">1,139.27</td>
                                                        <td class="text-right">4,666.00</td>
                                                        <td class="text-right">4,455.00</td>
                                                        <td class="text-right">8,453.00</td>
                                                        <td class="text-right">4,574.00</td>
                                                        <td class="text-right">4,265.00</td>
                                                        <td class="text-right">1,355.00</td>
                                                        <td class="text-right">6,565.00</td>
                                                        <td class="text-right">8,544.00</td>
                                                        <td class="text-right">7,234.00</td>
                                                        <td class="text-right">1,256.00</td>
                                                        <td class="text-right table-success">2,456.00</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-left">2.ประมาณการผลิต 8 ชม.</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right">-</td>
                                                        <td class="text-right table-success">-</td>
                                                    </tr>

                                                    <!-- end row1 -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- End tab3 table1 -->

                                        <!-- tab3 table2 -->
                                        <div class="tab3-table2  mt-4">
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
                                                        <th style="width:15%;">จำนวนชั่วโมงล่วงเวลา (ชั่วโมง)</th>
                                                        <th style="width:35%;">รวมเป็นค่าใช้จ่าย (บาท)</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td rowspan="2" class="text-left">
                                                            ฝ่ายผลิตด้านใบยา
                                                        </td>
                                                        <td class="text-left">พนักงานรายเดือน</td>
                                                        <td class="text-right">18348.32</td>
                                                        <td>220</td>
                                                        <td class="text-right">4036630.43</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left">พนักงานรายชั่วโมง</td>
                                                        <td class="text-right">18348.32</td>
                                                        <td>220</td>
                                                        <td class="text-right">4,129,472.60</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-right" colspan="2">รวม</td>
                                                        <td class="text-right">37,118.65</td>
                                                        <td>220</td>
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
                                        <!-- End tab3 table2 -->
                                    </div>
                                </div>
                                <!-- End content tab3 -->
                            </div>
                        </div>
                    </div>
                    <!-- end in tab -->

                </div>
            </div>
        </div>
        <!-- end tab -->

        <!-- Modal Create-->
        <div class="modal fade" id="ModalCreate" tabindex="-1" role="dialog" aria-labelledby="ModalCreateLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="ModalCreateLabel">สร้างแผนประมาณการผลิตบุหรี่ประจำปี</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-lg-7 col-form-label" for="">
                                สร้างแผนประมาณการผลิตบุหรี่ประจำปี
                            </label>
                            <div class="col-lg-5">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-7 col-form-label" for="">
                                ครั้งที่
                            </label>
                            <div class="col-lg-5">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-7 col-form-label" for="">
                                อ้างอิงประมาณประมาณการจำหน่ายรายปี
                            </label>
                            <div class="col-lg-5">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-7 col-form-label" for="">
                                ครั้งที่
                            </label>
                            <div class="col-lg-5">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-7 col-form-label" for="">
                                เป็นประมาณการผลิตบุหรี่ปีงบประมาณ
                            </label>
                            <div class="col-lg-5">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-7 col-form-label" for="">
                                ครั้งที่
                            </label>
                            <div class="col-lg-5">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row mt-3">
                            <div class="col-lg-12 text-center">
                                <button type="button" class="btn btn-primary col-lg-4 p-2"><i
                                    class="fa fa-check"></i>ตกลง
                                </button>
                                <button type="button" class="btn btn-danger col-lg-4 p-2" data-dismiss="modal"><i
                                    class="fa fa-times"></i>ยกเลิก
                                </button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--End Modal Create -->

        <!-- Modal Copy plan-->
        <div class="modal fade" id="ModalCopy" tabindex="-1" role="dialog" aria-labelledby="ModalCopy"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="ModalCopyLabel">คัดลอกแผนประมาณการผลิตบุหรี่ประจำปีงบประมาณ</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-lg-6 col-form-label" for="">
                                คัดลอกแผนประมาณการผลิตบุหรี่ประจำปีงบประมาณ
                            </label>
                            <div class="col-lg-6">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>

                            <label class="col-lg-6 col-form-label" for="">
                                เป็นประมาณการผลิตบุหรี่ปีงบประมาณ
                            </label>
                            <div class="col-lg-6">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row mt-3">
                            <div class="col-lg-12 text-center">
                                <button type="button" class="btn btn-primary col-lg-4 p-2"><i
                                    class="fa fa-check"></i>ตกลง
                                </button>
                                <button type="button" class="btn btn-danger col-lg-4 p-2" data-dismiss="modal"><i
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
</template>


<style scoped>
.pp001 ul.nav.nav-tabs li {
    width: 33.33%;
    text-align: center;
}

.tab-pp001 .tabs-container .panel-body {
    border: 1px solid #ffffff !important;
    border-radius: 2px !important;
    padding: 20px 0px !important;
}

.pp001 .nav-tabs .nav-item.show .nav-link,
.pp001 .nav-tabs .nav-link.active {
    color: #ffffff;
    background-color: #19b394;
    border-color: #19b394 #19b394 #fff;
    padding-top: 15px !important;
    padding-bottom: 15px !important;
}

.pp001 .nav-tabs .nav-link {
    border: 1px solid transparent !important;
    padding-top: 15px !important;
    padding-bottom: 15px !important;
}

.tabs-container .tab-content.tab-pp001 .panel-body {
    border: 0px !important;
    padding: 20px 0px !important;
}

tr.tr-header.table-pp th {
    min-width: 100px;
}

.modal-body {
    padding: 15px !important;
}

</style>
