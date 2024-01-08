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
                                ค้นหาแผนการผลิตรายปักษ์ :
                            </label>
                            <div class="input-group col-lg-7">
                                <input type="text" class="col-lg-12 form-control" id="input1" placeholder="Search">
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#SearchModal2"><i class="fa fa-search"></i>
                                        </button>
                                </span>

                                <!-- Modal ค้นหาแผนการผลิตรายปักษ์-->
                                <div class="modal fade" id="SearchModal2" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel"
                                     aria-hidden="true">
                                    <div class="modal-dialog search-modal" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="SearchModal2Label">
                                                    ค้นหาแผนการผลิตรายปักษ์</h3>
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
                        <h5>ติดตามแผนการผลิตประจำปักษ์</h5>
                    </div>
                    <div class="col-lg-8">
                        <div class="text-right">
                            <button type="submit" class="btn btn-w-m btn-info">
                                <i class="fa fa-print"></i> พิมพ์
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="ibox-content pt-4">
                <div class="row">
                    <div class="col-lg-4 col-sm-12">
                        <div class="form-group row">
                            <label class="col-lg-6 col-form-label">
                                แผนการผลิตรายปักษ์
                            </label>
                            <label class="col-lg-6 col-form-label">
                                <span class="text-primary">ปักษ์ที่ 3 ครั้งที่ 1</span>
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-6 col-sm-12">
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="input3"> คงคลัง ณ เช้าวันที่</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" id="input3" disabled>
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
                        <div class="tabs-container tab-custom">
                            <!-- link tab -->
                            <ul class="nav nav-tabs">
                                <li><a class="nav-link active" data-toggle="tab" href="#tab-1">คงคลังกองผลิตภัณฑ์</a>
                                </li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-2">คาดการณ์คงคลังล่วงหน้า</a></li>
                            </ul>
                            <!-- end link tab -->
                            <div class="tab-content in-tab-custom">
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
                                                        <th rowspan="2" style="min-width:200px">ตราบุหรี่</th>
                                                        <th rowspan="2">คงคลังบุหรี่ ระบบ AS/RS</th>
                                                        <th>ผลิตส่ง AS/RS </th>
                                                        <th>ยอดจำหน่าย</th>
                                                        <th rowspan="2">เฉลี่ยจำหน่าย/วัน ย้อนหลัง 10 วันขาย</th>
                                                        <th rowspan="2">คงคลังพอจำหน่าย (วัน)</th>
                                                        <th>ผลิตได้</th>
                                                        <th>ค้างส่ง AS/RS</th>
                                                        <th rowspan="2">ประมาณการจำหน่ายประจำเดือน</th>
                                                        <th rowspan="2">คงคลังเพียงพอต่อประมาณการจำหน่ายในเดือน (วัน)</th>
                                                        <th rowspan="2">วันที่บนซองบุหรี่</th>
                                                    </tr>
                                                    <tr>
                                                        <th rowspan="2">11/5/2020</th>
                                                        <th rowspan="2">11/5/2020</th>
                                                        <th>11/5/2020</th>
                                                        <th>11/5/2020</th>
                                                    </tr>

                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="text-left">
                                                            สายฝน 90
                                                        </td>
                                                        <td class="text-right">2.66</td>
                                                        <td class="text-right">2.66</td>
                                                        <td class="text-right">1.66</td>
                                                        <td class="text-right">1.0</td>
                                                        <td class="text-right">26.5</td>
                                                        <td class="text-right">62.43</td>
                                                        <td class="text-right">1.66</td>
                                                        <td class="text-right">1.0</td>
                                                        <td class="text-right">26.5</td>
                                                        <td class="text-right">62.43</td>
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
                                                        <td class="text-right">-</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-right">รวมบุหรี่ 7.8</td>
                                                        <td class="text-right table-success">1,897,265</td>
                                                        <td class="text-right table-success">3,600,000</td>
                                                        <td class="text-right table-success">4054</td>
                                                        <td class="text-right table-success">95,225,600</td>
                                                        <td class="text-right table-success">534</td>
                                                        <td class="text-right table-success">4,543</td>
                                                        <td class="text-right table-success">4,534,535,345</td>
                                                        <td class="text-right table-success">345</td>
                                                        <td class="text-right table-success">3,342,424</td>
                                                        <td class="text-right table-success">345</td>
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
                                                        <td class="text-right table-success">345</td>
                                                    </tr>

                                                    <!-- end row1 -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- End tab1-table1 -->


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

                                                    <div class="tab2-table1 mt-4">
                                                        <div class="row sale-date mb-3">
                                                            <div class="col-lg-3 col-sm-12">
                                                                <div class="form-group row">
                                                                    <label class="col-lg-5 col-form-label" for="input4"> จำนวนวันขาย</label>
                                                                    <div class="col-lg-4">
                                                                        <input type="text" class="form-control" id="input4" disabled>
                                                                    </div>
                                                                    <label class="col-lg-3 col-form-label">วัน</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-12">
                                                                <div class="form-group row">
                                                                    <label class="col-lg-5 col-form-label" for="input5">คงเหลือวันขาย</label>
                                                                    <div class="col-lg-4">
                                                                        <input type="text" class="form-control" id="input5" disabled>
                                                                    </div>
                                                                    <label class="col-lg-3 col-form-label">วัน</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- tab2 table1 -->

                                                        <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                <tr class="tr-header">
                                                                    <th colspan="2">ตราบุหรี่</th>
                                                                    <th>คงคลังบุหรี่ ระบบ AS/RS</th>
                                                                    <th>เฉลี่ยขายย้อนหลัง 10 วัน</th>
                                                                    <th>คาดว่าจะได้ผลผลิตทั้งปักษ์</th>
                                                                    <th>ได้จริงผลผลิตจริง</th>
                                                                    <th>ค้างผลิต</th>
                                                                    <th>คาดว่าจะได้ผลผลิตที่<br>เหลือตามแผนปักษ์</th>
                                                                    <th>ประมาณการจำหน่าย<br>คงเหลือ</th>
                                                                    <th>คาดว่าคงคลังคงเหลือ</th>
                                                                    <th>คาดว่าคงคลังคงเหลือ (วัน)</th>
                                                                </tr>

                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td class="text-center" rowspan="3"  style="min-width:120px"> บุหรี่ 7.8 </td>
                                                                    <td class="text-left"  style="min-width:230px"> สายฝน 90 </td>
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
                                                                    <td class="text-right">รวม 7.8</td>
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

                                                                <tr>
                                                                    <td class="text-center" colspan="2">รวมทั้งหมด</td>
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
                                                    <!-- End tab2 table1 -->

                                                </div>
                                            </div>
                                        </div>
                                        <!-- End table -->
                                    </div>
                                </div>
                                <!-- End content tab2 -->

                            </div>
                        </div>
                    </div>
                    <!-- end in tab -->

                </div>
            </div>
        </div>
        <!-- end tab -->

    </div>
</template>


<style scoped>
.sale-date input  {
    height: 35px !important;
}
.tab-custom ul.nav.nav-tabs li {
    width: 50%;
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
    border: 0  !important;
    padding: 20px 0 !important;
}

tr.tr-header.table-pp th {
    min-width: 100px;
}

.modal-body {
    padding: 15px !important;
}

.text-primary {
    color: #1ab394 !important;
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
