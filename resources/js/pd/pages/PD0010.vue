<template>
    <div>
        <div class="row d-flex justify-content-end mb-3">
            <div class="col-lg-10">
                <div class="float-right">
                    <button type="button" :class="btn_trans.blendNo.class" data-toggle="modal" data-target="#blendNo">
                        {{ btn_trans.blendNo.text }}
                    </button>
                    <button type="button" :class="btn_trans.brandCigarette.class" data-toggle="modal"
                            data-target="#brandCigarette">
                        {{ btn_trans.brandCigarette.text }}
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
                                <h5>แทนเกรดใบยา</h5>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label" for="select1">ประเภทใบยา</label>
                                    <div class="col-lg-9">
                                        <select class="form-control" name="select1" id="select1">
                                            <option>ใบยาในประเทศ</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label" for="select2">ชนิดใบยา</label>
                                    <div class="col-lg-9">
                                        <select class="form-control" name="select2" id="select2">
                                            <option>เวอร์จิเนีย</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label"
                                           for="input1">แทนด้วยรหัสใบยา:</label>
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="input1">
                                            </div>
                                            <label class="col-lg-6" for="input2">
                                                <input type="text" class="form-control" id="input2">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label" for="input3">รหัสใบยา:</label>
                                    <div class="col-lg-9">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="input3">
                                            </div>
                                            <label class="col-lg-6" for="input4">
                                                <input type="text" class="form-control" id="input4">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label" for="input5">Lot</label>
                                    <div class="col-lg-9">
                                        <select class="form-control" name="select2" id="input5">
                                            <option>6263</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label"
                                           for="input9">อนุมัติใช้วันที่:</label>
                                    <div class="col-lg-9">
                                        <input type="date" class="form-control" id="input9">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-sm-12 col-lg-12">
                                <div class="text-right">
                                    <button type="button" :class="btn_trans.saveOfGrade.class"><i
                                        :class="btn_trans.saveOfGrade.icon"></i>
                                        {{ btn_trans.saveOfGrade.text }}
                                    </button>
                                    <button type="button" :class="btn_trans.historyOfGrade.class" data-toggle="modal"
                                            data-target="#history">
                                        {{ btn_trans.historyOfGrade.text }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="header">เลือก</th>
                                            <th class="header" style="min-width: 250px">Blend No.</th>
                                            <th class="header" style="min-width: 100px;">สัดส่วนในสูตร<br>(%)</th>
                                            <th class="header" style="min-width: 100px;">รหัสใบยาเดิม</th>
                                            <th class="header" style="min-width: 100px;">รายละเอียด</th>
                                            <th class="header" style="min-width: 100px;">Lot</th>
                                            <th class="header" style="min-width: 150px;">สัดส่วนเดิม(%)</th>
                                            <th class="header" style="min-width: 100px;">รหัสใบยาใหม่</th>
                                            <th class="header" style="min-width: 100px;">รายละเอียด</th>
                                            <th class="header" style="min-width: 100px;">Lot</th>
                                            <th class="header" style="min-width: 150px;">สัดส่วนใหม่(%)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <div class="abc-checkbox text-center">
                                                    <label for="input6">
                                                        <input type="checkbox" id="input6">
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="col-readonly">B01</td>
                                            <td class="col-readonly number">70.00</td>
                                            <td class="col-readonly">1002000BA</td>
                                            <td class="col-readonly">BA</td>
                                            <td class="col-readonly">6162</td>
                                            <td>
                                                <label class="label-input col-lg-12 pl-0 pr-0 mb-0">
                                                    <input type="text" class="form-control input-field number">
                                                </label>
                                            </td>
                                            <td class="col-readonly">1002000BA</td>
                                            <td class="col-readonly">BA</td>
                                            <td class="col-readonly number">6263</td>
                                            <td>
                                                <label class="label-input col-lg-12 pl-0 pr-0 mb-0">
                                                    <input type="text" class="form-control input-field number">
                                                </label>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Modal btn Blend No.  -->
                        <div class="modal fade" id="blendNo" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <label class="col-lg-2 col-sm-4 col-form-label" for="input7">Blend
                                                No.</label>
                                            <div class="col-lg-9">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="input7">
                                                    </div>
                                                    <label class="col-lg-6" for="input8">
                                                        <input type="text" class="form-control" id="input8"
                                                               disabled>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>รหัสบุหรี่</th>
                                                    <th>ตราบุหรี่</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>15012337</td>
                                                    <td>SMS แดง</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal btn ตราบุหรี่-->
                        <div class="modal fade" id="brandCigarette" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <label class="col-lg-2 col-sm-4 col-form-label"
                                                   for="input10">ตราบุหรี่</label>
                                            <div class="col-lg-9">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="input10">
                                                    </div>
                                                    <label class="col-lg-6" for="input11">
                                                        <input type="text" class="form-control" id="input11"
                                                               disabled>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Blend No.</th>
                                                    <th>รายละเอียด</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>Bo1</td>
                                                    <td>ยาเส้นปรุง B01</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal btn ใบแทนเกรด-->
                        <div class="modal fade" id="history" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group row">
                                            <label class="col-lg-2 col-sm-4 col-form-label"
                                                   for="input12">ประวัติแทนเกรด</label>
                                            <div class="col-lg-9">
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <input type="text" class="form-control" id="input12">
                                                    </div>
                                                    <label class="col-lg-3" for="input13">
                                                        <input type="text" class="form-control" id="input13" disabled>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="header">ครั้งที่</th>
                                                    <th class="header">แทนด้วยรหัสใบยา</th>
                                                    <th class="header">รายละเอียด</th>
                                                    <th class="header">Lot</th>
                                                    <th class="header">วันที่อนุมัติใช้แทน</th>
                                                    <th class="header">วันที่บันทึก</th>
                                                    <th class="header">ผู้บันทึก</th>
                                                    <th class="header"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="col-readonly">2</td>
                                                    <td class="col-readonly">100200BA</td>
                                                    <td class="col-readonly">BA</td>
                                                    <td class="col-readonly">6162</td>
                                                    <td class="col-readonly">01/08/2019</td>
                                                    <td class="col-readonly">15/07/2019</td>
                                                    <td class="col-readonly">MCR</td>
                                                    <td class="button-detail">
                                                        <button type="button" :class="btn_trans.detail.class"
                                                                data-toggle="modal" data-target="#detail">
                                                            <i :class="btn_trans.detail.icon"></i>
                                                            {{ btn_trans.detail.text }}
                                                        </button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal btn รายละเอียด ประวัติแทนเกรดใบยา-->
                        <div class="modal fade" id="detail" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <h3 class="modal-title mb-3">ครั้งที่ 2</h3>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-sm-4 col-form-label" for="input14">แทนด้วยรหัสใบยา</label>
                                                    <div class="col-lg-10">
                                                        <div class="row">
                                                            <div class="col-lg-5">
                                                                <input type="text" class="form-control"
                                                                       id="input14">
                                                            </div>
                                                            <label class="col-lg-3" for="input15">
                                                                <input type="text" class="form-control" id="input15"
                                                                       disabled>
                                                            </label>
                                                            <label class="col-lg-4" for="input17">
                                                                <input type="text" class="form-control" id="input17"
                                                                       disabled>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-2 col-sm-4 col-form-label" for="input16">อนุมัติใช้วันที่</label>
                                                    <div class="col-lg-10">
                                                        <input type="date" class="form-control" id="input16">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="header" style="min-width:100px">Blend No.</th>
                                                    <th class="header" style="min-width:150px">สัดส่วนในสูตร(%)</th>
                                                    <th class="header" style="min-width:100px">รหัสใบยาเดิม</th>
                                                    <th class="header" style="min-width:100px">รายละเอียด</th>
                                                    <th class="header">Lot</th>
                                                    <th class="header" style="min-width:150px">สัดส่วนเดิม(%)</th>
                                                    <th class="header" style="min-width:100px">รหัสใบยาใหม่</th>
                                                    <th class="header" style="min-width:100px">รายละเอียด</th>
                                                    <th class="header">Lot</th>
                                                    <th class="header" style="min-width:150px">สัดส่วนใหม่(%)</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>B01</td>
                                                    <td>70.00</td>
                                                    <td>1002000BA</td>
                                                    <td>BA</td>
                                                    <td>6061</td>
                                                    <td>20.00</td>
                                                    <td>100200BA</td>
                                                    <td>BA</td>
                                                    <td>6162</td>
                                                    <td>80.00</td>
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
<style scoped>

.sale-date input {
    height: 35px !important;
}

.tab-custom ul.nav.nav-tabs li {
    width: 20%;
    text-align: center;
}

.ibox-title {
    padding: 15px 20px 8px 15px;
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

input.form-control.input-field.number {
    text-align: right;
}

td.col-readonly.number {
    text-align: right;
}

td.button-detail {
    text-align: center;
}


</style>
