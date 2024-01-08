<template>
    <div>
        <div class="row d-flex justify-content-end mb-3">
            <div class="col-lg-10">
                <div class="float-right">
                    <button type="button" :class="btn_trans.search.class" data-toggle="modal" data-target="#search"><i
                        :class="btn_trans.search.icon"></i>
                        {{ btn_trans.search.text }}
                    </button>
                    <button type="button" :class="btn_trans.fetch.class"><i
                        :class="btn_trans.fetch.icon"></i>
                        {{ btn_trans.fetch.text }}
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-sm-12 col-lg-4 align-middle">
                                <h5>สายงานผู้ชำนาญการปรุง</h5>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label" for="input1">ค่า LLD
                                        ปีงบประมาณ:</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="input1" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th class="header" style="width: 15%">รหัสบุหรี่</th>
                                    <th class="header" style="width: 15%">ตราบุหรี่</th>
                                    <th class="header" style="width: 30%">Blend No.</th>
                                    <th class="header" style="width: 30%">LLD(กก./พันมวน)</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="col-readonly text-left">15012301</td>
                                    <td class="col-readonly text-left">กรุงทอง 90</td>
                                    <td class="col-readonly text-left bg-gray">B01</td>
                                    <td class="col-readonly bg-gray text-right">0.51</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="col-readonly text-right"><b>รวม</b></td>
                                    <td class="col-readonly bg-gray text-right">0.51</td>
                                </tr>
                                <tr>
                                    <td class="col-readonly text-left">15012302</td>
                                    <td class="col-readonly text-left">กรงทิพย์ 90</td>
                                    <td class="col-readonly text-left bg-gray">B01</td>
                                    <td class="col-readonly bg-gray text-right">0.77</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="col-readonly text-right"><b>รวม</b></td>
                                    <td class="col-readonly bg-gray text-right">0.77</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Modal search -->
                        <div class="modal fade" id="search" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-lg-12 col-sm-12 pl-5 mb-2 pt-3">
                                                <div class="form-group row pl-5">
                                                    <label class="col-2 col-form-label" for="input2">
                                                        ปีงบประมาณ</label>
                                                    <div class="col-lg-6">
                                                        <input type="text" class="form-control" id="input2">
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <button type="button" :class="btn_trans.search.class"><i
                                                            :class="btn_trans.search.icon"></i>
                                                            {{ btn_trans.search.text }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="text-center">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                        <tr>
                                                            <th>ปีงบประมาณ</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td>2563</td>
                                                        </tr>
                                                        <tr>
                                                            <td>2564</td>
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
th,
td {
    vertical-align: middle !important;
    text-align: center;

}

/* modal กลางหน้าจอ */
.modal-dialog {
    height: 80% !important;
    padding-top: 10%;
}

/* end modal กลางหน้าจอ*/
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
