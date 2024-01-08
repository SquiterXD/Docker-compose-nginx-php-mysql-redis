<template>
    <div>
        <div class="row d-flex justify-content-end mb-3">
            <div class="col-lg-10">
                <div class="float-right">
                    <button type="button" :class="btn_trans.create.class">
                        <i :class="btn_trans.create.icon"></i>
                        {{ btn_trans.create.text }}
                    </button>
                    <button type="button" :class="btn_trans.search.class"
                            data-toggle="modal" data-target="#searchModal">
                        <i :class="btn_trans.search.icon"></i>
                        {{ btn_trans.search.text }}
                    </button>
                    <button type="button" :class="btn_trans.save.class">
                        <i :class="btn_trans.save.icon"></i>
                        {{ btn_trans.save.text }}
                    </button>
                    <button type="button" :class="btn_trans.copyFormula.class"
                            data-toggle="modal" data-target="#copyModal">
                        <i :class="btn_trans.copyFormula.icon"></i>
                        {{ btn_trans.copyFormula.text }}
                    </button>
                    <button type="button" :class="btn_trans.copyProduct.class"
                            data-toggle="modal" data-target="#copySimulateModal">
                        <i :class="btn_trans.copyProduct.icon"></i>
                        {{ btn_trans.copyProduct.text }}
                    </button>
                    <button type="button" :class="btn_trans.editHistory.class"
                            data-toggle="modal" data-target="#historyModal"><i
                        :class="btn_trans.editHistory.icon"></i>
                        {{ btn_trans.editHistory.text }}
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-sm-12 col-lg-2 align-middle">
                                <h5>จำลองสูตรยาเส้นปรุง</h5>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label" for="input1">ยาเส้นปรุง Blend
                                        No.<span style="color: red">*</span></label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="input1">
                                    </div>
                                    <label class="col-lg-1 col-form-label" for="input2">ตัวอย่าง</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="input2">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3"></label>
                                    <div class="col-lg-3"><label class="col-form-label">
                                        <input type="radio" checked="checked" value="option1" id="optionsRadios1"
                                               name="optionsRadios"
                                               class="mr-3 pt-2">ราคา Standard
                                    </label>
                                    </div>
                                    <label class="col-lg-2  col-form-label">
                                        <input class="mr-3" type="radio" checked="" value="option2"
                                               id="optionsRadios2" name="optionsRadios">ราคาวันที่
                                    </label>
                                    <label class="col-lg-4">
                                        <input type="date" class="form-control" id="input8">
                                    </label>
                                </div>

                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label" for="select1">รสชาติ</label>
                                    <div class="col-lg-3">
                                        <select class="form-control m-b" name="select1" id="select1">
                                            <option>อมเริกัน</option>
                                        </select>
                                    </div>
                                    <label class="col-lg-1 col-form-label" for="input3">ปริมาณ<span
                                        style="color: red">*</span></label>
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control" id="input3">
                                    </div>
                                    <label class="col-lg-1 col-form-label" for="input4">หน่วย</label>
                                    <div class="col-lg-2">
                                        <input type="text" class="form-control" id="input4">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label" for="input5">ต้นทุนอ้างอิงบุหรี่</label>
                                    <div class="col-lg-5">
                                        <input type="text" class="form-control" id="input5">
                                    </div>
                                    <label class="col-lg-4">
                                        <input type="text" class="form-control">
                                    </label>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label" for="input6">รายละเอียด</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="input6">
                                    </div>
                                    <label class="col-lg-1 col-form-label" for="input7">หมายเหตุ</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control pr-0" id="input7">
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-4">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="input9">วันที่สร้าง</label>
                                    <div class="col-lg-8">
                                        <input type="date" class="form-control" id="input9">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="input10">วันที่แก้ไขล่าสุด</label>
                                    <div class="col-lg-8">
                                        <input type="date" class="form-control" id="input10">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="input16">ผู้บันทึก</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="input16">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="tabs-container tab-custom">
                            <!-- link tab -->
                            <ul class="nav nav-tabs">
                                <li><a class="nav-link active" data-toggle="tab" href="#tab-1">Leaf Formula</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-2">Casing</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-3">Flavor</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-4">วัตถุห่อมวน</a></li>
                                <li><a class="nav-link" data-toggle="tab" href="#tab-5">ทั้งหมด</a></li>
                            </ul>
                            <!-- end link tab -->
                            <div class="tab-content in-tab-custom">
                                <div id="tab-1" class="tab-pane active">
                                    <!-- content tab1 -->
                                    <div class="panel-body">
                                        <!-- table1 -->
                                        <div class="col-sm-12 col-lg-12 pr-0 mb-3">
                                            <div class="text-right">
                                                <div class="text-right">
                                                    <button type="button" :class="btn_trans.add.class"><i
                                                        :class="btn_trans.add.icon"></i>
                                                        {{ btn_trans.add.text }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="header" style="width: 4%;"></th>
                                                    <th class="header" style="width: 15%;">Leaf Formula</th>
                                                    <th class="header" style="width: 60%;">รายละเอียด</th>
                                                    <th class="header" style="width: 15%;">สัดส่วน%</th>
                                                    <th class="header" style="width: 6%;">ลบ</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="align-middle">
                                                        <div class="check-center">
                                                            <label class="label-input">
                                                                <input class="center" type="radio"
                                                                       value="option1" id="optionsRadios1"
                                                                       name="optionsRadios">
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <label class="label-input col-lg-12 pl-0 pr-0 mb-0">
                                                            <input type="text" class="form-control input-field">
                                                        </label>
                                                    </td>
                                                    <td class="col-readonly text-left">Leaf Formula A</td>
                                                    <td>
                                                        <label class="label-input col-lg-12 pl-0 pr-0">
                                                            <input type="text" class="form-control input-field number">
                                                        </label>
                                                    </td>
                                                    <td class="check-center"><i class="fa fa-trash-o"></i></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="total col-readonly">รวม</td>
                                                    <td class="col-readonly number">80.00</td>
                                                    <td class="col-readonly"></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- End  table1 -->
                                        <!-- start  table2 -->
                                        <div class="row align-items-center mt-4">
                                            <div class="col-sm-12 col-lg-6 align-middle">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-sm-4 col-form-label" for="input11">Leaf
                                                        Formula</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" id="input11" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-lg-6 mb-4">
                                                <div class="text-right">
                                                    <button type="button" :class="btn_trans.add.class"><i
                                                        :class="btn_trans.add.icon"></i>
                                                        {{ btn_trans.add.text }}
                                                    </button>
                                                    <button type="button" :class="btn_trans.deleteList.class"><i
                                                        :class="btn_trans.deleteList.icon"></i>
                                                        {{ btn_trans.deleteList.text }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="header">
                                                        <div>
                                                            <label>
                                                                <input class="align-middle" type="checkbox">
                                                            </label>
                                                        </div>
                                                    </th>
                                                    <th class="header" style="min-width: 150px">รหัสวัตถุดิบ</th>
                                                    <th class="header" style="min-width: 250px;">เกรดใบยา</th>
                                                    <th class="header" style="min-width: 100px">Lot</th>
                                                    <th class="header" style="min-width: 120px;">ต้นทุนต่อหน่วย<br>(บาท)
                                                    </th>
                                                    <th class="header">สัดส่วน<br>%</th>
                                                    <th class="header" style="min-width: 120px;">ปริมาณที่ใช้<br>(กก.)
                                                    </th>
                                                    <th class="header" style="min-width: 130px;">
                                                        ต้นทุนวัตถุดิบที่ใช้<br>(บาท)
                                                    </th>
                                                    <th class="header" style="min-width: 80px;">ปรับราคา<br>(%)</th>
                                                    <th class="header" style="min-width: 100px;">ราคาปรับลด/<br>เพิ่ม(บาท)
                                                    </th>
                                                    <th class="header" style="min-width: 150px;">ต้นทุนหลังปรับราคา<br>(บาท)
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="align-middle">
                                                        <div class="check-center">
                                                            <label class="label-input">
                                                                <input class="align-middle" type="checkbox" value="">
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <label class="label-input col-lg-12 pl-0 pr-0 mb-0">
                                                            <input type="text" class="form-control input-field">
                                                        </label>
                                                    </td>
                                                    <td class="col-readonly">BA</td>
                                                    <td>
                                                        <label class="label-input col-lg-12 pl-0 pr-0 mb-0">
                                                            <select class="form-control select-lot" name="account">
                                                                <option>6061</option>
                                                            </select>
                                                        </label>
                                                    </td>
                                                    <td class="col-readonly number">10.00</td>
                                                    <td>
                                                        <label class="label-input col-lg-12 pl-0 pr-0 mb-0">
                                                            <input type="text" class="form-control input-field number">
                                                        </label>
                                                    </td>
                                                    <td class="col-readonly number">56.00</td>
                                                    <td class="col-readonly number">560.0000</td>
                                                    <td>
                                                        <label class="label-input col-lg-12 pl-0 pr-0 mb-0">
                                                            <input type="text" class="form-control input-field number">
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="label-input col-lg-12 pl-0 pr-0 mb-0">
                                                            <input type="text" class="form-control input-field number">
                                                        </label>
                                                    </td>
                                                    <td class="col-readonly number">560.0000</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="total col-readonly"><b>รวม</b></td>
                                                    <td class="col-readonly number">70.00</td>
                                                    <td class="col-readonly number">56.00</td>
                                                    <td class="col-readonly number">560.0000</td>
                                                    <td class="col-readonly number">-</td>
                                                    <td class="col-readonly number">-</td>
                                                    <td class="col-readonly number">560.0000</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- end  table2 -->
                                    </div>
                                </div>
                                <!-- End content tab1 -->
                                <!-- Content tab2 -->
                                <div id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        <div class="row align-items-center mt-4">
                                            <div class="col-sm-12 col-lg-12 mb-2">
                                                <div class="text-right">
                                                    <button type="button" :class="btn_trans.add.class"><i
                                                        :class="btn_trans.add.icon"></i>
                                                        {{ btn_trans.add.text }}
                                                    </button>
                                                    <button type="button" :class="btn_trans.deleteList.class"><i
                                                        :class="btn_trans.deleteList.icon"></i>
                                                        {{ btn_trans.deleteList.text }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- table -->
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="header">เลือก</th>
                                                    <th class="header" style="min-width:120px">Leaf Formula</th>
                                                    <th class="header" style="min-width:200px">รายละเอียด</th>
                                                    <th class="header" style="min-width:120px">Casing No.</th>
                                                    <th class="header" style="min-width:200px">รายละเอียด</th>
                                                    <th class="header" style="min-width:80px">สถานะ</th>
                                                    <th class="header" style="min-width:120px">ต้นทุนต่อหน่วย<br>(บาท)
                                                    </th>
                                                    <th class="header" style="min-width:120px">ปรับราคา<br>(%)</th>
                                                    <th class="header" style="min-width:120px">ราคาปรับลด/<br>เพิ่ม(บาท)
                                                    </th>
                                                    <th class="header" style="min-width:140px">ต้นทุนหลังปรับราคา<br>(บาท)
                                                    </th>
                                                    <th class="header" style="min-width:150px">รายละเอียดเพิ่มเติม</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="check-center">
                                                            <label class="label-input">
                                                                <input class="align-middle" type="checkbox"
                                                                       value="checked">
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <label class="label-input col-lg-12 pl-0 pr-0">
                                                            <input type="text" class="form-control input-field">
                                                        </label>
                                                    </td>
                                                    <td class="col-readonly">Leaf Formula A</td>
                                                    <td>
                                                        <label class="label-input col-lg-12 pl-0 pr-0">
                                                            <input type="text" class="form-control input-field">
                                                        </label>
                                                    </td>
                                                    <td class="col-readonly">สายปรุง C01</td>
                                                    <td class="col-readonly">ตามสูตร</td>
                                                    <td class="col-readonly number">200.0000</td>
                                                    <td>
                                                        <label class="label-input col-lg-12 pl-0 pr-0">
                                                            <input type="text" class="form-control input-field number">
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <label class="label-input col-lg-12 pl-0 pr-0">
                                                            <input type="text" class="form-control input-field number">
                                                        </label>
                                                    </td>
                                                    <td class="col-readonly number">200.0000</td>
                                                    <td class="button-detail">
                                                        <button type="button" :class="btn_trans.detail.class"
                                                                data-toggle="modal" data-target="#detailCasingModal">
                                                            <i :class="btn_trans.detail.icon"></i>
                                                            {{ btn_trans.detail.text }}
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" class="col-readonly total"><b>รวม</b></td>
                                                    <td class="col-readonly number">200.0000</td>
                                                    <td class="col-readonly number">-</td>
                                                    <td class="col-readonly number">-</td>
                                                    <td class="col-readonly number">200.0000</td>
                                                    <td class="col-readonly"></td>
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
                                        <div class="row align-items-center mt-4">
                                            <div class="col-sm-12 col-lg-12 mb-2">
                                                <div class="text-right">
                                                    <button type="button" :class="btn_trans.add.class"><i
                                                        :class="btn_trans.add.icon"></i>
                                                        {{ btn_trans.add.text }}
                                                    </button>
                                                    <button type="button" :class="btn_trans.deleteList.class"><i
                                                        :class="btn_trans.deleteList.icon"></i>
                                                        {{ btn_trans.deleteList.text }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- table -->
                                        <div class="table-responsive">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th class="header">เลือก</th>
                                                        <th class="header" style="min-width: 120px">Flavor No.</th>
                                                        <th class="header" style="min-width: 200px">รายละเอียด</th>
                                                        <th class="header" style="min-width: 80px">สถานะ</th>
                                                        <th class="header" style="min-width: 120px">ต้นทุนต่อหน่วย<br>(บาท)
                                                        </th>
                                                        <th class="header" style="min-width: 120px">ปรับราคา<br>(%)</th>
                                                        <th class="header" style="min-width: 120px">ราคาปรับลด/<br>เพิ่ม(บาท)
                                                        </th>
                                                        <th class="header" style="min-width: 140px">
                                                            ต้นทุนหลังปรับราคา<br>(บาท)
                                                        </th>
                                                        <th class="header" style="min-width: 150px">
                                                            รายละเอียดเพิ่มเติม
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <div class="check-center">
                                                                <label class="label-input">
                                                                    <input class="align-middle" type="checkbox"
                                                                           value="">
                                                                </label>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <label class="label-input col-lg-12 pl-0 pr-0">
                                                                <input type="text" class="form-control input-field">
                                                            </label>
                                                        </td>
                                                        <td class="col-readonly">สารหอม F01</td>
                                                        <td class="col-readonly">ตามสูตร</td>
                                                        <td class="col-readonly number">100.0000</td>
                                                        <td>
                                                            <label class="label-input col-lg-12 pl-0 pr-0">
                                                                <input type="text"
                                                                       class="form-control input-field number">
                                                            </label>
                                                        </td>
                                                        <td>
                                                            <label class="label-input col-lg-12 pl-0 pr-0">
                                                                <input type="text"
                                                                       class="form-control input-field number">
                                                            </label>
                                                        </td>
                                                        <td class="col-readonly number">100.0000</td>
                                                        <td class="button-detail">
                                                            <button type="button" :class="btn_trans.detail.class"
                                                                    data-toggle="modal"
                                                                    data-target="#detailFlavorModal"><i
                                                                :class="btn_trans.detail.icon"></i>
                                                                {{ btn_trans.detail.text }}
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="4" class="col-readonly total"><b>รวม</b></td>
                                                        <td class="col-readonly number">100.0000</td>
                                                        <td class="col-readonly number">-</td>
                                                        <td class="col-readonly number">-</td>
                                                        <td class="col-readonly number">100.0000</td>
                                                        <td class="col-readonly number"></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- End table -->
                                    </div>
                                </div>
                                <!-- End content tab3 -->
                                <!-- Content tab4 -->
                                <div id="tab-4" class="tab-pane">
                                    <div class="panel-body">
                                        <!-- start  table2 -->
                                        <div class="row align-items-center mt-4">
                                            <div class="col-sm-12 col-lg-12 mb-2">
                                                <div class="text-right">
                                                    <button type="button" :class="btn_trans.add.class"><i
                                                        :class="btn_trans.add.icon"></i>
                                                        {{ btn_trans.add.text }}
                                                    </button>
                                                    <button type="button" :class="btn_trans.deleteList.class"><i
                                                        :class="btn_trans.deleteList.icon"></i>
                                                        {{ btn_trans.deleteList.text }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="header" style="width: 4%;">เลือก</th>
                                                    <th class="header" style="width: 4%;">ลำดับ</th>
                                                    <th class="header" style="width: 92%;">รายละเอียดวัตถุห่อมวน</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="check-center">
                                                            <label class="label-input">
                                                                <input class="align-middle" type="checkbox" value="">
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="col-readonly">1</td>
                                                    <td class="col-readonly">กระดาษมวนคุณภาพที่1</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- end  table2 -->
                                    </div>
                                    <!-- End table -->
                                </div>
                                <!-- End content tab4 -->
                                <!-- Content tab5 -->
                                <div id="tab-5" class="tab-pane">
                                    <div class="panel-body">
                                        <!-- table -->
                                        <div class="table-responsive">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th class="header" style="min-width: 120px">รหัสวัตถุดิบ</th>
                                                        <th class="header" style="min-width: 300px">รายละเอียด</th>
                                                        <th class="header">Lot</th>
                                                        <th class="header">สถานะ</th>
                                                        <th class="header">ต้นทุนต่อหน่วย<br>(บาท)</th>
                                                        <th class="header">ปริมาณที่ใช้</th>
                                                        <th class="header">หน่วย</th>
                                                        <th class="header">ปรับราคา<br>(%)</th>
                                                        <th class="header">ราคาปรับลด/<br>เพิ่ม(บาท)</th>
                                                        <th class="header">ต้นทุนหลังปรับราคา<br>(บาท)</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="col-readonly">1002000BA</td>
                                                        <td class="col-readonly">BA</td>
                                                        <td class="col-readonly">6061</td>
                                                        <td class="col-readonly">ตามสูตร</td>
                                                        <td class="col-readonly number">10.0000</td>
                                                        <td class="col-readonly number">56.00</td>
                                                        <td class="col-readonly">KG</td>
                                                        <td class="col-readonly number">-</td>
                                                        <td class="col-readonly number">-</td>
                                                        <td class="col-readonly number">560.0000</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8" class="col-readonly total">รวมต้นทุนทั้งหมด</td>
                                                        <td class="col-readonly number">-</td>
                                                        <td class="col-readonly number">560.0000</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="8" class="col-readonly total">ต้นทุนต่อกิโลกรัม
                                                        </td>
                                                        <td class="col-readonly number">-</td>
                                                        <td class="col-readonly number">23.0260</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- End table -->
                                        <div class="col-sm-12 col-lg-6 align-middle mt-5">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-sm-4 col-form-label" for="input23">อ้างอิงต้นทุนมวน</label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" id="input23" disabled>
                                                </div>
                                                <label class="col-lg-4" for="input24">
                                                    <input type="text" class="form-control" id="input24" disabled>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="header" style="width: 4%;">ลำดับ</th>
                                                    <th class="header" style="width: 14%;">รหัสวัตถุดิบ</th>
                                                    <th class="header" style="width: 40%;">รายละเอียด</th>
                                                    <th class="header" style="width: 17%;">ปริมาณที่ใช้สำหรับ 1
                                                        ล้านมวน
                                                    </th>
                                                    <th class="header" style="width: 8%;">หน่วย</th>
                                                    <th class="header" style="width: 17%;">ต้นทุนต่อ 1 ล้านมวน(บาท)</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="col-readonly">30</td>
                                                    <td class="col-readonly">1001001</td>
                                                    <td class="col-readonly">ยาเส้นปรุง B01</td>
                                                    <td class="col-readonly number">770.00</td>
                                                    <td class="col-readonly">KG</td>
                                                    <td class="col-readonly number">17,730.02000</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="col-readonly total">รวมต้นทุนต่อ 1 ล้านมวน
                                                    </td>
                                                    <td class="col-readonly number">17,730.02000</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="col-readonly total">รวมต้นทุนต่อ 1 ซอง</td>
                                                    <td class="col-readonly number">0.02000</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!--                                        table-3-->
                                        <div class="col-sm-12 col-lg-6 align-middle mt-5">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-sm-4 col-form-label">อ้างอิงต้นทุนมวน</label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" disabled>
                                                </div>
                                                <label class="col-lg-4" for="input24">
                                                    <input type="text" class="form-control" disabled>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="header" style="width: 4%;">ลำดับ</th>
                                                    <th class="header" style="width: 14%;">รหัสวัตถุดิบ</th>
                                                    <th class="header" style="width: 40%;">รายละเอียด</th>
                                                    <th class="header" style="width: 17%;">ปริมาณที่ใช้สำหรับ 1
                                                        ล้านมวน
                                                    </th>
                                                    <th class="header" style="width: 8%;">หน่วย</th>
                                                    <th class="header" style="width: 17%;">ต้นทุนต่อ 1 ล้านมวน(บาท)</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="col-readonly">30</td>
                                                    <td class="col-readonly">1001001</td>
                                                    <td class="col-readonly">ยาเส้นปรุง B01</td>
                                                    <td class="col-readonly number">770.00</td>
                                                    <td class="col-readonly">KG</td>
                                                    <td class="col-readonly number">17,730.02000</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="col-readonly total">รวมต้นทุนต่อ 1 ล้านมวน
                                                    </td>
                                                    <td class="col-readonly number">17,730.02000</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="col-readonly total">รวมต้นทุนต่อ 1 ซอง</td>
                                                    <td class="col-readonly number">0.02000</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" class="col-readonly total">รวมต้นทุนทั้งหมดต่อ 1
                                                        ซอง
                                                    </td>
                                                    <td class="col-readonly number">59.5459</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- End content tab5 -->
                            </div>
                        </div>
                        <!-- end tab -->
                        <!--modal search -->
                        <div class="modal fade" id="searchModal" tabindex="-1" role="dialog"
                             aria-labelledby="searchModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3>ค้นหา</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row pl-5 pr-5">
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-sm-6 col-form-label" for="innput23">
                                                        Blend No.</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" id="innput23">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label" for="innput24">
                                                        รายละเอียด
                                                    </label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" id="innput24">
                                                    </div>
                                                    <div class="col-lg-5 pr-0">
                                                        <div class="float-right">
                                                            <button type="button" :class="btn_trans.search.class"><i
                                                                :class="btn_trans.search.icon"></i>
                                                                {{ btn_trans.search.text }}
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th class="header">Blend No.</th>
                                                        <th class="header">ตัวอย่าง</th>
                                                        <th class="header">รายละเอียด</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="col-readonly">B01</td>
                                                        <td class="col-readonly">1</td>
                                                        <td class="col-readonly">ยาเส้นปรุง B01</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal btn copySimulate  -->
                        <div class="modal fade" id="copyModal" tabindex="-1"
                             role="dialog"
                             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="copySimulateModalLongTitle">
                                            คัดลอกสูตร</h3>
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-lg-12 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-sm-8 col-form-label"
                                                       for="input19">
                                                    จากสูตร Blend No.</label>
                                                <div class="col-lg-8 pl-0">
                                                    <input type="text" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-sm-4 col-form-label" for="input20">
                                                    เป็นสูตร Blend No.
                                                </label>
                                                <div class="col-lg-4 pl-0">
                                                    <input type="text" class="form-control" id="input20">
                                                </div>
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="input21"
                                                       style="padding: 7px">
                                                    ตัวอย่างที่
                                                </label>
                                                <div class="col-lg-2 pl-0">
                                                    <input type="text" class="form-control" id="input21" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" :class="btn_trans.confirm.class"><i
                                            :class="btn_trans.confirm.icon"></i>
                                            {{ btn_trans.confirm.text }}
                                        </button>
                                        <button type="button" :class="btn_trans.cancel.class"><i
                                            :class="btn_trans.cancel.icon"></i>
                                            {{ btn_trans.cancel.text }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--modal copy simulate -->
                        <div class="modal fade" id="copySimulateModal" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="copyModalLongTitle">คัดลอกเป็นสูตรผลิตภัณฑ์</h3>
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-lg-12 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-sm-8 col-form-label"
                                                       for="input17">
                                                    จากสูตร Blend No.</label>
                                                <div class="col-lg-4 pl-0">
                                                    <input type="text" class="form-control" id="input17"
                                                           disabled>
                                                </div>
                                                <label class="col-lg-2 col-sm-4 col-form-label" style="padding: 7px">
                                                    ตัวอย่างที่
                                                </label>
                                                <div class="col-lg-2 pl-0">
                                                    <input type="text" class="form-control" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-sm-4 col-form-label" for="select3">
                                                    เป็นสูตร
                                                </label>
                                                <div class="col-lg-4 pl-0">
                                                    <select class="form-control m-b" name="select3"
                                                            id="select3">
                                                        <option>สูตรทดลอง</option>
                                                    </select>
                                                </div>
                                                <label class="col-lg-2 col-sm-4 col-form-label" for="input19"
                                                       style="padding: 7px">
                                                    Blend No.
                                                </label>
                                                <div class="col-lg-2 pl-0">
                                                    <input type="text" class="form-control" id="input19">
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" :class="btn_trans.confirm.class"><i
                                            :class="btn_trans.confirm.icon"></i>
                                            {{ btn_trans.confirm.text }}
                                        </button>
                                        <button type="button" :class="btn_trans.cancel.class"><i
                                            :class="btn_trans.cancel.icon"></i>
                                            {{ btn_trans.cancel.text }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal btn history update  -->
                        <div class="modal fade" id="historyModal" tabindex="-1" role="dialog"
                             aria-labelledby="searchModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3>ประวัติการแก้ไข Blend No.</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="col-lg-12 col-sm-12">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-sm-8 col-form-label pl-3"
                                                       for="input22">
                                                    ประวัติการแก้ไข Blend No.</label>
                                                <div class="col-lg-2">
                                                    <input type="text" class="form-control" id="input22"
                                                           disabled>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>ครั้งที่</th>
                                                        <th>ผู้แก้ไข</th>
                                                        <th>วันที่แก้ไข</th>
                                                        <th>Tap</th>
                                                        <th colspan="3">Field ที่แก้ไข</th>
                                                        <th>ข้อมูลเดิม</th>
                                                        <th>ข้อมูลที่แก้ไข</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="col-readonly">3</td>
                                                        <td class="col-readonly">MCR</td>
                                                        <td class="col-readonly">20/6/63</td>
                                                        <td class="col-readonly">Casing</td>
                                                        <td class="col-readonly">Leaf Formular</td>
                                                        <td class="col-readonly">-</td>
                                                        <td class="col-readonly">-</td>
                                                        <td class="col-readonly">A</td>
                                                        <td class="col-readonly">C</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal btn detail casing  -->
                        <div class="modal fade" id="detailCasingModal" tabindex="-1" role="dialog"
                             aria-labelledby="detailsModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailsModalLabel">Casing No.</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-sm-4 col-form-label pl-3">
                                                        Casing No.</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th class="header">รหัสวัตถุดิบ</th>
                                                            <th class="header">รายละเอียด</th>
                                                            <th class="header">ปริมาณที่ใช้</th>
                                                            <th class="header">หน่วย</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>1001001</td>
                                                            <td>Hotantis</td>
                                                            <td>4.00</td>
                                                            <td>KG</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal btn detail flavor  -->
                        <div class="modal fade" id="detailFlavorModal" tabindex="-1" role="dialog"
                             aria-labelledby="detailsModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailsFlavorModalLabel">Flavor No.</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="col-lg-12 col-sm-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-sm-4 col-form-label pl-3">
                                                        Flavor No.</label>
                                                    <div class="col-lg-4">
                                                        <input type="text" class="form-control" disabled>
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th class="header">รหัสวัตถุดิบ</th>
                                                            <th class="header">รายละเอียด</th>
                                                            <th class="header">ปริมาณที่ใช้</th>
                                                            <th class="header">หน่วย</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>100400019</td>
                                                            <td>Tobacco Flavour 002</td>
                                                            <td>20.00</td>
                                                            <td>GMS</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
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
export default {
    props: {
        btn_trans: {type: Object},
    },
}
</script>
<style>
.sale-date input {
    height: 35px !important;
}

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

/* modal กลางหน้าจอ */
.history-update-modal-lg {
    height: 80% !important;
    padding-top: 10%;
}

/* modal กลางหน้าจอ */
.modal-dialog.modal-lg {
    padding-top: 10%;
}

.col-readonly {
    background: #e9ecef42 !important;
}

input.form-control.input-field {
    border: 0px;
}

input.form-control.input-field:focus {
    outline: 1px solid #1ab394;
}

th.header {
    text-align: center;
}

.check-center {
    text-align: center;
}

td.total {
    text-align: right;
}

i.fa.fa-trash-o {
    font-size: 16px;
}

td.col-readonly.text-left {
    text-align: left;
}

input.form-control.input-field.number {
    text-align: right;
}

td.col-readonly.number {
    text-align: right;
}

select.form-control.select-lot {
    border: none;
}

select.form-control.select-lot:focus {
    outline: 1px solid #1ab394;
}

td.button-detail {
    text-align: center;
}

.modal-footer {
    justify-content: center;
}

</style>
