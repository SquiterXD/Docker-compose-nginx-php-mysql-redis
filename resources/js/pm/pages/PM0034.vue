<template>
    <div>
        <div class="ibox ">
            <div class="ibox-title">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <h5>รายการจัดเตรียมวัตถุดิบ</h5>
                    </div>
                    <div class="col-lg-8">
                        <div class="text-right">
                            <button type="submit" class="btn btn-default">
                                <i class="fa fa-search"></i>&nbsp;&nbsp;ค้นหา
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i>&nbsp;&nbsp;บันทึก
                            </button>
                            <button class="btn btn-info">
                                <i class="fa fa-file"></i>&nbsp;&nbsp;รายละเอียดแผนบุหรี่รายเดือน คำนวณปริมาณการผลิต
                            </button>
                            <button type="submit" class="btn btn-info">
                                <i class="fa fa-plus"></i>&nbsp;&nbsp;คำนวณปริมาณการผลิต
                            </button>

                        </div>
                    </div>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">

                    <div class="col-lg-6 col-sm-12 b-r">
                        <div class="form-group row mt-3">
                            <label class="col-lg-3 col-form-label" for="">
                                ปีงบประมาณ
                            </label>
                            <div class="col-lg-9">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="">
                                ประจำเดือน
                            </label>

                            <div class="col-lg-9">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="">
                                เวอร์ชั่น
                            </label>
                            <div class="col-lg-9">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-6 col-sm-12">

                        <div class="form-group row mt-3">
                            <label class="col-lg-3 col-form-label" for="">
                                วันที่สร้าง
                            </label>
                            <div class="col-lg-9">
                                <input class="form-control" type="date" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="">
                                ระบบการพิมพ์
                            </label>
                            <div class="col-lg-9">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label" for="">
                                ประเภทสิ่งพิมพ์
                            </label>
                            <div class="col-lg-9">
                                <input class="form-control" type="text" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- table1 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-lg-4">
                                <h5>รายละเอียดแผนบุหรี่จากฝ่ายขายครั้งที่ 1</h5>
                            </div>

                        </div>
                    </div>

                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="tr-header">
                                        <th width="6%">
                                            ตราบุหรี่
                                        </th>
                                        <th width="10%">
                                            รหัสวัตถุดิบ
                                        </th>
                                        <th width="30%">
                                            ประมาณการจำหน่าย (หีบ)
                                        </th>
                                        <th width="10%">
                                            จำนวน (ล้านมวน)
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!--  row 1-->
                                    <tr>
                                        <td class="col-readonly text-center">กรุงทอง 90 </td>
                                        <td class="col-readonly text-center">15012301 </td>
                                        <td class="col-readonly text-center">1,400 </td>
                                        <td class="col-readonly text-center">14 </td>

                                    </tr>
                                    <tr>
                                        <td class="col-readonly text-center">กรุงทอง 90 </td>
                                        <td class="col-readonly text-center">15012301 </td>
                                        <td class="col-readonly text-center">1,400 </td>
                                        <td class="col-readonly text-center">14 </td>

                                    </tr>
                                    <tr>
                                        <td class="col-readonly text-center">กรุงทอง 90 </td>
                                        <td class="col-readonly text-center">15012301 </td>
                                        <td class="col-readonly text-center">1,400 </td>
                                        <td class="col-readonly text-center">14 </td>

                                    </tr>
                                    <tr>
                                        <td class="col-readonly text-center">กรุงทอง 90 </td>
                                        <td class="col-readonly text-center">15012301 </td>
                                        <td class="col-readonly text-center">1,400 </td>
                                        <td class="col-readonly text-center">14 </td>

                                    </tr>
                                    <!--  row 1-->
                                    <!-- end row กระดาษพันก้นกรอง-->


                                    <!-- end กระดาษพันก้นกรอง -->

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end table1 -->
        <!-- table2 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <!-- <div class="col-lg-12">
                                <h5>รายละเอียดแผนบุหรี่จากฝ่ายขายครั้งที่ 1</h5>
                            </div>  -->
                            <div class="col-lg-12">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i>&nbsp;&nbsp;บันทึก
                                    </button>
                                    <button class="btn btn-info">
                                        <i class="fa fa-print"></i>&nbsp;&nbsp;พิมพ์
                                    </button>
                                </div>
                           </div>
                        </div>
                    </div>

                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="tr-header t2">
                                        <th>
                                            ตราบุหรี่
                                        </th>
                                        <th>
                                            จำนวน (ล้านมวน)
                                        </th>
                                        <th>
                                            รหัสสินค้าสำเร็จรูป
                                        </th>
                                        <th class="minwidth">
                                            รายละเอียด
                                        </th>
                                        <th>
                                            ใช้ต่อสัปดาห์
                                        </th>
                                        <th>
                                            จำนวนพอใช้ได้<br>อีก (สัปดาห์)
                                        </th>
                                        <th>
                                            คงคลังฝ่ายจัดหา
                                        </th>
                                        <th>
                                            คงคลังฝ่ายผลิต
                                        </th>
                                        <th>
                                            คงคลังโรงพิมพ์
                                        </th>
                                        <th>
                                            ความต้องการต่อเดือน
                                        </th>
                                        <th>
                                            สั่งผลิตประจำเดือน
                                        </th>
                                        <th>
                                            หน่วยนับ (จัดเก็บ)
                                        </th>
                                        <th>
                                            จำนวนที่ต้องผลิต
                                        </th>
                                        <th>
                                            จำนวนที่ควรผลิต
                                        </th>
                                        <th>
                                            หน่วยนับ(ผลิต)
                                        </th>
                                        <th>
                                            แปลงหน่วย (ชื้น)
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <!--  row 1-->
                                    <tr>
                                        <td class="col-readonly text-center">กรุงทอง 90 </td>
                                        <td class="col-readonly text-center">14</td>
                                        <td class="col-readonly text-left">11030DGL018</td>
                                        <td class="col-readonly text-left">กระดาษพันก้นกรองบุหรี่ กรุงทอง 90 </td>
                                        <td class="text-center">150.00</td>
                                        <td class="text-center">2.35</td>
                                        <td class="text-center">0.00 </td>
                                        <td class="text-center">52.50 </td>
                                        <td class="text-center">300.00</td>
                                        <td class="text-right">94.50 </td>
                                        <td class="text-right">0 </td>
                                        <td class="text-center">Bobbin</td>
                                        <td class="text-right">- </td>
                                        <td class="text-right">- </td>
                                        <td class="text-center"> ROL</td>
                                        <td class="text-right">-</td>
                                    </tr>
                                    <!-- End row 1-->
                                    <!-- row 2-->
                                    <tr>
                                        <td class="col-readonly text-center">กรุงทอง 90 </td>
                                        <td class="col-readonly text-center">14</td>
                                        <td class="col-readonly text-left">11030DGL018</td>
                                        <td class="col-readonly text-left">กระดาษพันก้นกรองบุหรี่ กรุงทอง 90 </td>
                                        <td class="text-center">150.00</td>
                                        <td class="text-center">2.35</td>
                                        <td class="text-center">0.00 </td>
                                        <td class="text-center">52.50 </td>
                                        <td class="text-center">300.00</td>
                                        <td class="text-right">94.50 </td>
                                        <td class="text-right">0 </td>
                                        <td class="text-center">Bobbin</td>
                                        <td class="text-right">- </td>
                                        <td class="text-right">- </td>
                                        <td class="text-center"> ROL</td>
                                        <td class="text-right">-</td>
                                    </tr>
                                    <!-- End row 2-->

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end table2 -->
    </div>
</template>

<script>

</script>
<style scoped>
    .minwidth {
        min-width: 250px !important;
    }

    tr.tr-header.t2 th {
        min-width: 100px;
    }

    .ibox-title {
    padding: 20px;
    }

</style>
