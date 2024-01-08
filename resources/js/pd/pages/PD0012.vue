<template>
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-sm-12 col-lg-6 align-middle">
                                <h5>ปรับประมาณการยอดจำหน่าย</h5>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-lg-4 col-sm-4 col-form-label"
                                           for="input1">ปรับประมาณการยอดจำหน่าย</label>
                                    <div class="col-lg-8">
                                        <input type="text" class="form-control" id="input1">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-lg-2 col-sm-4 col-form-label" for="input2">ปรับครั้งที่:</label>
                                    <div class="col-lg-10">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <input type="text" class="form-control" id="input2">
                                            </div>
                                            <label class="col-lg-3 col-sm-4 col-form-label"
                                                   for="input3">ปรับเปลี่ยน(%):</label>
                                            <div class="col-lg-5">
                                                <input type="text" class="form-control" id="input3">
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
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-sm-12 col-lg-12">
                                <div class="text-right">
                                    <button type="button" :class="btn_trans.create.class" data-toggle="modal"
                                            data-target="#create"><i
                                        :class="btn_trans.create.icon"></i>
                                        {{ btn_trans.create.text }}
                                    </button>
                                    <button type="button" :class="btn_trans.save.class"><i
                                        :class="btn_trans.save.icon"></i>
                                        {{ btn_trans.save.text }}
                                    </button>
                                    <button type="button" :class="btn_trans.print.class"><i
                                        :class="btn_trans.print.icon"></i>
                                        {{ btn_trans.print.text }}
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
                                            <th class="header" style="width: 10%">รหัสบุหรี่</th>
                                            <th class="header" style="width: 20%">ตราบุหรี่</th>
                                            <th class="header" style="width: 30%">
                                                ประมาณการจำหน่ายทั้งปีงบประมาณ(ล้านมวน)
                                            </th>
                                            <th class="header" style="width: 30%">
                                                ประมาณการจำหน่ายหลังปรับเปลี่ยน(ล้านมวน)
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="col-readonly">15012301</td>
                                            <td class="col-readonly">กรุงทอง 90</td>
                                            <td class="col-readonly bg-gray text-right">1,500,000.00</td>
                                            <td class="text-right">1,530,000.00</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="col-readonly text-right"><b>รวม</b></td>
                                            <td class="col-readonly text-right bg-gray">1,500,000.00</td>
                                            <td class="col-readonly text-right bg-gray">1,530,000.00</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Modal btn สร้าง-->
                        <div class="modal fade" id="create" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title">สร้าง</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group row" style="margin-right: 15px">
                                                    <label for="input14" class="col-lg-4 col-sm-4 col-form-label">ปรับเปลี่ยนประมาณยอดจำหน่ายปี</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" id="input14" class="form-control"></div>
                                                    <div class="col-lg-2">
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
                                                    <th class="header">ปีงบประมาณ</th>
                                                    <th class="header">ครั้งที่</th>
                                                    <th class="header">วันที่อนุมัติ</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>2562</td>
                                                    <td>1</td>
                                                    <td>09/08/2561</td>
                                                </tr>
                                                <tr>
                                                    <td>2562</td>
                                                    <td>2</td>
                                                    <td>11/10/2561</td>
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

button.btn.btn-w-m.btn-default {
    height: 40px;
}

.ibox-title {
    padding: 15px 20px 8px 15px;
}

.col-readonly {
    background: #e9ecef42 !important;
}

th.header {
    text-align: center;
}

td.col-readonly.bg-gray {
    background: #c0c6cc42 !important;
}


</style>
