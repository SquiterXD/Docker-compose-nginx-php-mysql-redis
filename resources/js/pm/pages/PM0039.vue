<template>
    <div>
        <div class="row d-flex justify-content-end mb-3">
            <div class="col-lg-10">
                <div class="float-right">
                    <button type="button" :class="btn_trans.search.class" data-toggle="modal"
                            data-target=".bd-search-modal-lg"><i
                        :class="btn_trans.search.icon"></i>
                        {{ btn_trans.search.text }}
                    </button>
                    <button type="button" :class="btn_trans.createJob.class" @click.prevent="confirm"><i
                        :class="btn_trans.createJob.icon"></i>
                        {{ btn_trans.createJob.text }}
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <div class="row align-items-center">
                            <div class="col-sm-12 col-lg-4 align-middle">
                                <h4>แจ้งเตือนปริมาณคงคลังสารปรุง</h4>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label">วันที่:</label>
                                    <div class="col-lg-9">
                                        <input type="date" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-4 col-form-label">รหัสสินค้าสำเร็จรูป:</label>
                                    <div class="col-lg-9">
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr align="center">
                                    <th>
                                        <div class="check-center">
                                            <label class="label-input">
                                                <input class="align-middle" type="checkbox"
                                                       value="">
                                            </label>
                                        </div>
                                    </th>
                                    <th style="min-width: 150px;">รหัสสินค้าสำเร็จรูป</th>
                                    <th style="min-width: 250px;">รายละเอียด</th>
                                    <th style="min-width: 100px;">คงคลัง</th>
                                    <th style="min-width: 100px;">Lot No.</th>
                                    <th style="min-width: 150px;">ปริมาณจัดเก็บต่ำสุด</th>
                                    <th style="min-width: 150px;">ปริมาณเฝ้าระวังต่ำสุด</th>
                                    <th style="min-width: 100px;">หน่วยนับ</th>
                                    <th style="min-width: 200px;">จำนวนที่ต้องผลิต<strong style="color: red">*</strong>
                                    </th>
                                    <th style="min-width: 150px;">เลขคำสั่งผลิต</th>
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
                                    <td class="col-readonly">100400040</td>
                                    <td class="col-readonly">TONKA BEAN FLAVOUR</td>
                                    <td class="col-readonly">20.00</td>
                                    <td class="col-readonly">999</td>
                                    <td class="col-readonly">30-06-2564</td>
                                    <td class="col-readonly">500.00</td>
                                    <td class="col-readonly">KG</td>
                                    <td>
                                        <label class="label-input col-lg-12 pl-0 pr-0">
                                            <input type="text" class="form-control input-field">
                                        </label>
                                    </td>
                                    <td class="col-readonly">63-0V18-001</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                            <div class="col-lg-12 col-sm-12 pl-0">
                                <div class="form-group row">
                                    <label class="col-lg-3 col-sm-6 col-form-label" for="innput23">
                                        xxxxx</label>
                                    <div class="col-lg-4">
                                        <input type="text" class="form-control" id="innput23">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-lg-3 col-form-label" for="innput24">
                                        xxxxxx
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
                                        <th class="header">xxxx</th>
                                        <th class="header">xxxxx</th>
                                        <th class="header">xxxxx</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="col-readonly"></td>
                                        <td class="col-readonly"></td>
                                        <td class="col-readonly"></td>
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

</template>
<script>

export default {
    props: {
        btn_trans: {type: Object},
    },
    methods: {
        confirm() {
            swal({
                title: 'เปิดคำสั่งผลิต',
                text: "Item 100400040:TONKA BEAN FLAVOUR \nจำนวน 360 KG",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1ab394',
                cancelButtonColor: '#ED5565',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true
            })
        }
    },
}
</script>

<style scoped>
th,
td {
    vertical-align: middle !important;
}

th.header {
    text-align: center;
}

.col-readonly {
    background: #e9ecef42 !important;
}

.check-center {
    text-align: center;
}

input.form-control.input-field {
    border: 0px;
}

input.form-control.input-field:focus {
    outline: 1px solid #1ab394;
}

</style>
