<template>
    <div class="container-fluid">
        <div class="row d-flex justify-content-end mb-3">
            <div class="col-lg-10">
                <div class="float-right">
                    <button type="button" :class="btn_trans.create.class"><i
                        :class="btn_trans.create.icon"></i>
                        {{ btn_trans.create.text }}
                    </button>
                    <button type="button" :class="btn_trans.search.class" data-toggle="modal"
                            data-target=".bd-search-modal-lg"><i
                        :class="btn_trans.search.icon"></i>
                        {{ btn_trans.search.text }}
                    </button>
                    <button type="button" :class="btn_trans.save.class"><i
                        :class="btn_trans.save.icon"></i>
                        {{ btn_trans.save.text }}
                    </button>
                    <button type="button" :class="btn_trans.edit.class" data-toggle="modal"
                            data-target="#updateButtonModalCenter"><i
                        :class="btn_trans.edit.icon"></i>
                        {{ btn_trans.edit.text }}
                    </button>
                    <button type="button" :class="btn_trans.copyFormula.class" data-toggle="modal"
                            data-target="#copyButtonModalCenter">
                        <i :class="btn_trans.copyFormula.icon"></i>
                        {{ btn_trans.copyFormula.text }}
                    </button>
                    <button type="button" :class="btn_trans.copySimulatorFormula.class" data-toggle="modal"
                            data-target="#copySimulateButtonModalCenter">
                        <i :class="btn_trans.copySimulatorFormula.icon"></i>
                        {{ btn_trans.copySimulatorFormula.text }}
                    </button>
                    <button type="button" :class="btn_trans.editHistory.class" data-toggle="modal"
                            data-target=".bd-history-update-modal-lg"><i
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
                                <h5>สูตรมาตรฐานยาเส้นปรุง</h5>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label pl-3" for="input1">ยาเส้นปรุง Blend
                                        No.<span style="color: red">*</span></label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="input1">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label pl-3" for="select1">รสชาติ:</label>
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <select class="form-control m-b" name="select1" id="select1">
                                                    <option>อเมริกัน</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="input2">ปริมาณ<span
                                                        style="color: red">*</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" id="input2">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group row">
                                                    <label class="col-lg-4 col-form-label" for="input3">หน่วย<span
                                                        style="color: red">*</span></label>
                                                    <div class="col-lg-8">
                                                        <input type="text" class="form-control" id="input3">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label pl-3"
                                           for="input4">รายละเอียด:</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="input4">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label pl-3" for="input5">หมายเหตุ:</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="input5">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-sm-4 col-form-label" for="input6">วันที่สร้าง:</label>
                                    <div class="col-lg-8">
                                        <input type="date" class="form-control" id="input6">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-sm-4 col-form-label" for="select2">สถานะ:</label>
                                    <div class="col-lg-8">
                                        <select class="form-control m-b" name="select1" id="select2">
                                            <option>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-sm-4 col-form-label" for="input9">วันที่อนุมัติ:</label>
                                    <div class="col-lg-8">
                                        <input type="date" class="form-control" id="input9">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-sm-4 col-form-label"
                                           for="input10">วันที่เริ่มใช้:</label>
                                    <div class="col-lg-8">
                                        <input type="date" class="form-control" id="input10">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="input7">วันที่แก้ไขล่าสุด</label>
                                    <div class="col-lg-8">
                                        <input type="date" class="form-control" id="input7">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-4 col-form-label" for="input8">ผู้บันทึก</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="input8">
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
                                <li><a class="nav-link" data-toggle="tab" href="#tab-4">บุหรี่</a></li>
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
                                                        <label class="label-input col-lg-12 pl-0 pr-0">
                                                            <input type="text" class="form-control input-field">
                                                        </label>
                                                    </td>
                                                    <td class="col-readonly text-left">Leaf Formula A</td>
                                                    <td>
                                                        <label class="label-input col-lg-12 pl-0 pr-0">
                                                            <input type="text" class="form-control input-field number">
                                                        </label>
                                                    </td>
                                                    <td class="remove"><i class="fa fa-trash-o"></i></td>
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
                                                    <label class="col-lg-3 col-sm-4 col-form-label pl-3" for="input11">Leaf
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
                                                    <th class="header" style="width: 4%;">
                                                        <div>
                                                            <label>
                                                                <input class="align-middle" type="checkbox" value="">
                                                            </label>
                                                        </div>
                                                    </th>
                                                    <th class="header" style="width: 15%;">รหัสวัตถุดิบ</th>
                                                    <th class="header" style="width: 54%;">เกรดใบยา</th>
                                                    <th class="header" style="width: 15%;">สัดส่วน%</th>
                                                    <th class="header" style="width: 10%;">ปริมาณที่ใช้<br>(กก.)</th>
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
                                                        <label class="label-input col-lg-12 pl-0 pr-0">
                                                            <input type="text" class="form-control input-field">
                                                        </label>
                                                    </td>
                                                    <td class="col-readonly text-left">BA</td>
                                                    <td>
                                                        <label class="label-input col-lg-12 pl-0 pr-0">
                                                            <input type="text"
                                                                   class="form-control input-field number">
                                                        </label>
                                                    </td>
                                                    <td class="col-readonly">-</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="total col-readonly">รวม</td>
                                                    <td class="col-readonly number">70.00</td>
                                                    <td class="col-readonly"></td>
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
                                                    <th class="header" style="width: 4%;">เลือก</th>
                                                    <th class="header" style="width: 15%;">Leaf Formula</th>
                                                    <th class="header" style="width: 26%;">รายละเอียด</th>
                                                    <th class="header" style="width: 15%;">Casing No.</th>
                                                    <th class="header" style="width: 26%;">รายละเอียด</th>
                                                    <th class="header" style="width: 14%;">รายละเอียดเพิ่มเติม</th>
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
                                                    <td>
                                                        <label class="label-input col-lg-12 pl-0 pr-0">
                                                            <input type="text" class="form-control input-field">
                                                        </label>
                                                    </td>
                                                    <td class="col-readonly text-left">Leaf Formula A</td>
                                                    <td>
                                                        <label class="label-input col-lg-12 pl-0 pr-0">
                                                            <input type="text" class="form-control input-field">
                                                        </label>
                                                    </td>
                                                    <td class="col-readonly text-left">สายปรุง C01</td>
                                                    <td class="button-detail">
                                                        <button type="button" :class="btn_trans.detail.class"
                                                                data-toggle="modal" data-target="#detailsModal"><i
                                                            :class="btn_trans.detail.icon"></i>
                                                            {{ btn_trans.detail.text }}
                                                        </button>
                                                    </td>
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
                                                        <th class="header" style="width: 4%;">เลือก</th>
                                                        <th class="header" style="width: 15%;">Flavor No.</th>
                                                        <th class="header" style="width: 67%;">รายละเอียด</th>
                                                        <th class="header" style="width: 14%;">รายละเอียดเพิ่มเติม</th>
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
                                                        <td class="col-readonly text-left">สารหอม F01</td>
                                                        <td class="button-detail">
                                                            <button type="button" :class="btn_trans.detail.class"
                                                                    data-toggle="modal" data-target="#detailsModal"><i
                                                                :class="btn_trans.detail.icon"></i>
                                                                {{ btn_trans.detail.text }}
                                                            </button>
                                                        </td>
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
                                                        <th class="header" style="width: 4%;">เลือก</th>
                                                        <th class="header" style="width: 15%;">รหัสบุหรี่</th>
                                                        <th class="header" style="width: 67%;">รายละเอียด</th>
                                                        <th class="header" style="width: 14%;">รายละเอียดเพิ่มเติม</th>
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
                                                        <td class="col-readonly text-left">Goal ซองแดง</td>
                                                        <td class="button-detail">
                                                            <button type="button" :class="btn_trans.detail.class"
                                                                    data-toggle="modal" data-target="#detailsModal"><i
                                                                :class="btn_trans.detail.icon"></i>
                                                                {{ btn_trans.detail.text }}
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- End  table1 -->
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
                                                        <th class="header" style="width: 92%;">รายละเอียดวัตถุห่อมวน
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
                                                        <td>1</td>
                                                        <td class="col-readonly text-left">กระดาษมวนคุณภาพที่1</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- end  table2 -->
                                        </div>
                                        <!-- End table -->
                                    </div>
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
                                                        <th class="header" style="width: 15%;">รหัสวัตถุดิบ</th>
                                                        <th class="header" style="width: 65%;">รายละเอียด</th>
                                                        <th class="header" style="width: 10%;">ปริมาณที่ใช้</th>
                                                        <th class="header" style="width: 10%;">หน่วย</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td class="col-readonly text-left">1002000BA</td>
                                                        <td class="col-readonly text-left">BA</td>
                                                        <td class="col-readonly text-left">56.00</td>
                                                        <td class="col-readonly text-left">KG</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- End table -->
                                        </div>
                                        <!-- End table -->
                                    </div>
                                </div>
                                <!-- End content tab5 -->
                            </div>
                        </div>
                        <!-- end tab -->
                        <!--        modal search-->
                        <div class="modal fade bd-search-modal-lg" tabindex="-1" role="dialog"
                             aria-labelledby="myLargeModalLabel"
                             aria-hidden="true">
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
                    </div>
                    <div class="modal fade" id="detailsModal" tabindex="-1" role="dialog"
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
                                                <label class="col-lg-3 col-sm-4 col-form-label pl-3"
                                                       for="input16">
                                                    Casing No.</label>
                                                <div class="col-lg-4">
                                                    <input type="text" class="form-control" id="input16"
                                                           disabled>
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
                    <!-- Modal btn copy -->
                    <div class="modal fade" id="copyButtonModalCenter" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="copyModalLongTitle">คัดลอกสูตร</h3>
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
                                            <div class="col-lg-8 pl-0">
                                                <input type="text" class="form-control" id="input17"
                                                       disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-sm-4 col-form-label" for="select3">
                                                เป็นสูตร
                                            </label>
                                            <div class="col-lg-4 pl-0">
                                                <select class="form-control m-b" name="select3"
                                                        id="select3">
                                                    <option>สูตรใช้จริง</option>
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

                    <!-- Modal btn copySimulate  -->
                    <div class="modal fade" id="copySimulateButtonModalCenter" tabindex="-1"
                         role="dialog"
                         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="copySimulateModalLongTitle">
                                        คัดลอกสูตรเป็นสูตรจำลอง</h3>
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
                                                <input type="text" class="form-control" id="input19"
                                                       disabled>
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
                    <!-- Modal btn history update  -->
                    <div class="modal fade bd-history-update-modal-lg" tabindex="-1" role="dialog"
                         aria-labelledby="myLargeModalLabel"
                         aria-hidden="true">
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
                    <!-- Modal btn update  -->
                    <div class="modal fade" id="updateButtonModalCenter" tabindex="-1" role="dialog"
                         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="updateButton">แก้ไข</h3>
                                    <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <h1 style="text-align: center">เนื่องจากสูตรมีสถานะ Active <br/>
                                        ยืนยันที่จะแก้ไขสูตร</h1>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" :class="btn_trans.ok.class"><i
                                        :class="btn_trans.ok.icon"></i>
                                        {{ btn_trans.ok.text }}
                                    </button>
                                    <button type="button" :class="btn_trans.cancel.class"><i
                                        :class="btn_trans.cancel.icon"></i>
                                        {{ btn_trans.cancel.text }}
                                    </button>
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
    data() {
        return {}
    },
}
</script>
<style scoped>

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

label.col-lg-4.col-form-label {
    padding: 7px;
}

label.col-lg-3.col-form-label {
    padding: 7px;
}

td.total {
    text-align: right;
}

.col-readonly {
    background: #e9ecef42 !important;
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

.check-center {
    text-align: center;
}

label.label-input {
    margin-bottom: 0rem;
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

td.remove {
    text-align: center;
}

td.button-detail {
    text-align: center;
}

.modal-dialog {
    padding-top: 0px;
}

.modal-dialog.modal-lg {
    padding-top: 10%;
}

.modal-footer {
    justify-content: center;
}
</style>
