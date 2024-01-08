@extends('layouts.app')
<style>
    .hidden {
        display: none;
    }

    .ajax_loader {
        position: fixed;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        background: rgba(0, 0, 0, 0);
        z-index: 10;
    }

    .ajax_loader i {
        position: fixed;
        top: 50%;
        left: 50%;
        font-size: 100px;
    }

    .customer_list {
        display: none;
        position: absolute;
        min-width: 150%;
        overflow: auto;
        background-color: #ffffff;
        border-color: #e7eaec;
        border-image: none;
        border-style: solid;
        border-width: 1px;
        margin-top: 3%;
        z-index: 5;
    }

    .customer_list ul{
        list-style-type: none;
        background-color: #ffffff;
        padding: 0;
        margin: 0;
    }

    .customer_list li {
        background-color: #ffffff;
        padding-left: 1rem;
        padding-right: 1rem;
        white-space: nowrap;
    }

    .customer_list li:hover {
        background-color: #e7eaec;
    }

</style>

@section('title', 'อนุมัติใบเตรียมการขายเพื่อตั้งหนี้')

@section('page-title')
    <h2>Customer Search</h2>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/">หน้าหลัก</a>
        </li>
        <li class="breadcrumb-item active">
            <strong>ข้อมูลลูกค้า สำหรับขายต่างประเทศ</strong>
        </li>
    </ol>
@stop


<div class="ajax_loader hidden"><i class="fa fa-spinner fa-spin"></i></div>
@section('content')
    <div class="ibox">
        <div class="ibox-title">
            <h3>อนุมัติใบเตรียมการขายเพื่อตั้งหนี้</h3>
        </div>
        <div class="ibox-content">
            <div class="row space-50 justify-content-md-center flex-column mw-xl-1000 mt-md-4">
                <div class="col-xl-6 m-auto">

                    <div class="form-group">
                        <h3 class="black mb-3">ค้นหารายการที่ต้องการ</h3>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="d-block">วันที่ส่ง</label>
                                <div class="input-icon">
                                    <input type="text" class="form-control date" name="date_first" id="date_first"
                                        placeholder="" value="">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="d-block">ถึงวันที่</label>
                                <div class="input-icon">
                                    <input type="text" class="form-control date" name="date_last" id="date_last"
                                        placeholder="" value="">
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>
                        <!--row-->
                    </div>
                    <!--form-group-->

                    <div class="form-group">
                        <label class="d-block">เลขที่ใบเตรียมขาย</label>
                        <div class="input-icon">
                            <input type="text" class="form-control" name="order_number" id="order_number" placeholder=""
                                value="">
                            <i class="fa fa-search"></i>
                        </div>
                    </div>
                    <!--form-group-->

                    <div class="form-group">
                        <label class="d-block">ลูกค้า</label>
                        <div class='row space-50 justify-content-md-center' id='loading'></div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-icon">
                                    <input type="text" class="form-control" name="customer_number" id="customer_number"
                                        placeholder="" value="">
                                    <i class="fa fa-search"></i>
                                </div>
                                <div class="customer_list">
                                    <ul id="list">
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" disabled="" name="customer_name" id="customer_name"
                                    placeholder="" value="">
                            </div>
                        </div>
                        <!--row-->
                    </div>
                    <!--form-group-->

                    <div class="form-group">
                        <label class="d-block">สถานะการอนุมัติ</label>
                        <select class="custom-select" id="order_confirm">
                            <option value="Y">อนุมัติ</option>
                            <option value="N">ยังไม่ได้อนุมัติ</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="d-block">สถานะการรับชำระ</label>
                        <select class="custom-select" id="order_status">
                            <option value="2">รับชำระเงินแล้ว</option>
                            <option value="1">ยังไม่รับชำระ</option>
                        </select>
                    </div>

                    <div class="form-buttons no-border">
                        <button class="btn btn-lg btn-white" type="button" id="searchItem"><i class="fa fa-search"></i>
                            ค้นหา</button>
                    </div>
                </div>
                <!--col-xl-6-->

                <div class="col-md-12">
                    <hr class="lg">

                    <div class="form-header-buttons flex-md-row-reverse">
                        <div class="buttons d-flex">
                            <button class="btn btn-md btn-primary" type="button" id="confirm_order"><i
                                    class="fa fa-check"></i>
                                อนุมัติ</button>
                            <button class="btn btn-md btn-danger" type="button" id="cancel_order"><i
                                    class="fa fa-times"></i>
                                ยกเลิก</button>
                        </div>
                        <!--buttons-->

                        <button class="btn btn-md btn-white has-checkbox mt-2 mt-md-0" type="button">
                            <div class="i-checks">
                                <label class="" id='select-all'>
                                    <input type="checkbox" value="option_0" style="position: absolute;opacity: 0;">
                                    <span> เลือกทั้งหมด</span>
                                </label>
                            </div>
                        </button>
                    </div>
                    <!--form-header-buttons-->

                    <div class="hr-line-dashed"></div>

                    <div class="table-responsive">
                        <table class="table table-bordered text-center table-hover f13">
                            <thead>
                                <tr class="align-middle">
                                    <th>Select</th>
                                    <th>รายการที่</th>
                                    <th>เลขที่ใบเตรียมขาย</th>
                                    <th>วันที่ส่ง</th>
                                    <th>ชื่อลูกค้า</th>
                                    <th>เงินเชื่อ</th>
                                    <th>เงินสด</th>
                                    <th>จำนวนเงิน</th>
                                    <th>สถานะการรับ<br>ชำระเงิน</th>
                                    <th>อนุมัติ</th>
                                </tr>
                            </thead>
                            <tbody id="data">
                            </tbody>
                        </table>
                    </div>
                    <!--table-responsive-->

                    <div class="d-flex mt-4 mb-5">
                        <div class="d-flex ml-auto mr-4">สั่งซื้อปกติ <span class="box-label"
                                style="background-color: #1c84c6"></span></div>
                        <div class="d-flex">สั่งซื้อเกินโควต้า <span class="box-label" style="background-color:red"></span>
                        </div>
                    </div>
                    <!--d-flex-->
                </div>
            </div>
            <!--row-->
        </div>
        <!--ibox-content-->
    </div>
@endsection

@section('scripts')

    <script>
        $(document).ready(function() {
            let selectCount = 0;
            const customerList = @json($customer);
            let prepare = @json($data);

            const ShowData = (_data) => {
                selectCount = 0;
                let table = "";
                if (_data == null || _data.length == 0) {
                    table = "ไม่มีข้อมูล"
                } else {
                    for (let i = 0; i < _data.length; i++) {
                        let number = _data[i].number != null ? _data[i].number : "-";
                        let date = _data[i].delivery_date != null ? _data[i].delivery_date : "-";
                        let customer = _data[i].customer_name != null ? _data[i].customer_name : "-";
                        let credit = _data[i].credit_amount != null ? _data[i].credit_amount : '0';
                        let cash = _data[i].cash_amount != null ? _data[i].cash_amount : '0';
                        let total = _data[i].grand_total != null ? _data[i].grand_total : '0';
                        let statusAmount = _data[i].statusAmount == null ? '<td>-</td>' : _data[i]
                            .statusAmount == 2 ?
                            '<td class="td-green">รับชำระเงินแล้ว</td>' : _data[i].statusAmount == 1 ?
                            '<td class="td-red">ยังไม่ได้โอน</td>' :
                            '<td class="td">ยังไม่ถึงกำหนดชำระเงิน</td>';
                        let color = _data[i].quota == null ? "tr-text-blue" : _data[i].quota == -1 ?
                            "tr-text-red" : "tr-text-blue";
                        table +=
                            `<tr class="${color}">
                                   <td>
                                     <div class="i-checks wihtout-text m-auto">
                                         <label class="" id="select-${i}">
                                             <div class="icheckbox_square-green" id="select2-${i}">
                                             <input type="checkbox" value="option_2" name="a" style="position: absolute; opacity: 0;">
                                             <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
                                             </ins>
                                             </div>
                                         </label>
                                     </div>
                                   </td>
                                   <td>${i+1}</td>
                                   <td>${number }</td>
                                   <td>${date}</td>
                                   <td class="text-left">${customer}</td>
                                   <td class="text-right">${credit}</td>
                                   <td class="text-right">${cash}</td>
                                   <td class="text-right">${total}</td>
                                   ${statusAmount}
                                   <td>
                                   <div class="i-checks wihtout-text m-auto disabled">
                                        <label class=>
                                             <div class="icheckbox_square-green" id="check-${i}">
                                             <input type="checkbox" value="option_2" name="a" style="position: absolute; opacity: 0;">
                                             <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                             </div>
                                        </label>
                                    </div>
                                   </td>
                             </tr>`;
                    }
                }

                document.getElementById("data").innerHTML = table;

                for (let i = 0; i < _data.length; i++) {
                    $("#select-" + i).hover(() => {
                        $("#select-" + i).addClass("hover");
                        $("#select2-" + i).addClass("hover");
                    }, () => {
                        $("#select-" + i).removeClass("hover");
                        $("#select2-" + i).removeClass("hover");
                    })

                    $("#select2-" + i).mouseup(() => {
                        if ($("#select2-" + i).hasClass("checked")) {
                            $("#select2-" + i).removeClass("checked");
                            selectCount--;
                        } else {
                            $("#select2-" + i).addClass("checked");
                            selectCount++;
                        }
                        if (selectCount == _data.length) {
                            if (!$("#select-all").children(":first").hasClass("checked"))
                                $("#select-all").children(":first").addClass("checked");
                        } else {
                            $("#select-all").children(":first").removeClass("checked");
                        }
                    });

                    if (_data[i].confirm == 'Y') $("#check-" + i).addClass("checked");
                }

                const selectAll = () => {
                    let check = $("#select-all").children(":first").hasClass("checked");
                    for (let i = 0; i < _data.length; i++) {
                        if (check) $("#select2-" + i).addClass("checked");
                        else $("#select2-" + i).removeClass("checked");
                    }
                    if (check)
                        selectCount = _data.length;
                    else
                        selectCount = 0;
                }

                $("#select-all").click(selectAll);
                $("#select-all").children().click(selectAll);
                $("#select-all").children().children().click(selectAll);
            }
            ShowData(prepare);

            $('.date').datepicker();

            const closeCustomer = (str) => {
                $(".customer_list").hide();
                $('#loading').html('');
                if (str != null) $('#customer_name').val(str);
            }

            const selectCustomer = (num, str) => {
                $('#customer_number').val(num);
                closeCustomer(str);
            }

            const searchCustomer = () => {
                if ($('#customer_number').val() != "") {
                    let search = $('#customer_number').val();
                    let str = "";
                    const listShow = customerList.filter(val => val.customer_number.includes(search));
                    if (listShow.length > 0 && listShow[0].customer_number != search) {
                        listShow.forEach((val, index) => {
                            if (index < 10) {
                                str +=
                                    `<li id="li${index}" >${val.customer_number} - ${val.customer_name}</li>`;
                            }
                        });
                        $(".customer_list").show();
                        $("#list").html(str);
                        $('#loading').html('กำลังค้นหา');
                        $('#customer_name').val("");

                        listShow.forEach((val, index) => {
                            if (index < 10) {
                                $('#li' + index).mousedown(() => {
                                    selectCustomer(val.customer_number, val.customer_name);
                                });
                            }
                        });

                    } else if (listShow.length > 0) {
                        closeCustomer(listShow[0].customer_name);
                    }
                } else {
                    closeCustomer("");
                }
            }

            $('#customer_number').keyup(() => {
                if (customerList != null && customerList.length > 0)
                    searchCustomer();
            });

            $("#customer_number").focusout(() => {
                closeCustomer(null);
            });

            $('#searchItem').click(() => {
                $(".hidden").show();
                $('#tablebody').html('')
                swal("", 'กำลังโหลดข้อมูล', "");
                let data = {
                    "_token": "{{ csrf_token() }}",
                    date_first: $('#date_first').val(),
                    date_last: $('#date_last').val(),
                    order_number: $('#order_number').val(),
                    customer_number: $('#customer_number').val(),
                    status: $('#order_status').val(),
                    confirm: $('#order_confirm').val(),
                }
                console.log(data);
                $.ajax({
                    url: "{{ route('om.ajax.order.approveprepare.search') }}",
                    method: 'post',
                    data: data,
                    success: function(response) {

                        $(".hidden").hide();
                        console.log(response.result)
                        if (response.status == "success") {
                            swal('สำเร็จ!', 'ค้นหาข้อมูลสำเร็จ', 'success');
                            prepare = response.result;
                            ShowData(response.result);
                        }
                    },
                    error: function(jqXHR, textStatus, errorRhrown) {
                        $(".hidden").hide();
                        swal("Error", 'ไม่สามารถค้นหาได้', "error");
                    }
                })
            })

            $('#confirm_order').click(() => {
                let data = {
                    "_token": "{{ csrf_token() }}",
                    "key": []
                }
                for (let i = 0; i < prepare.length; i++) {
                    if ($("#select2-" + i).hasClass("checked") && prepare[i].confirm != 'Y') {
                        data.key.push(prepare[i].number);
                    }
                }
                if (data.key.length != 0) {
                    swal("", 'กำลังดำเนินการ', "");
                    $(".hidden").show();
                    console.log(data);
                    $.ajax({
                        url: "{{ route('om.ajax.order.approveprepare.confirm') }}",
                        method: 'post',
                        data: data,
                        success: function(response) {

                            $(".hidden").hide();
                            console.log(response)
                            if (response.status == "success") {
                                swal('สำเร็จ!', 'อนุมัติเสร็จสิ้น', 'success');
                                prepare = response.result;
                                ShowData(response.result);
                            }
                        },
                        error: function(jqXHR, textStatus, errorRhrown) {

                            $(".hidden").hide();
                            swal("Error", 'ไม่สามารถดำเนินการได้', "error");
                        }
                    });
                }
            });

            $('#cancel_order').click(() => {
                let data = {
                    "_token": "{{ csrf_token() }}",
                    "key": []
                }
                for (let i = 0; i < prepare.length; i++) {
                    if ($("#select2-" + i).hasClass("checked") && prepare[i].confirm == 'Y') {
                        data.key.push(prepare[i].number);
                    }
                }
                if (data.key.length != 0) {
                    swal("", 'กำลังดำเนินการ', "");
                    $(".hidden").show();
                    console.log(data);
                    $.ajax({
                        url: "{{ route('om.ajax.order.approveprepare.cancel') }}",
                        method: 'post',
                        data: data,
                        success: function(response) {

                            $(".hidden").hide();
                            console.log(response)
                            if (response.status == "success") {
                                swal('สำเร็จ!', 'ยกเลิกเสร็จสิ้น', 'success');
                                prepare = response.result;
                                ShowData(response.result);
                            }
                        },
                        error: function(jqXHR, textStatus, errorRhrown) {

                            $(".hidden").hide();
                            swal("Error", 'ไม่สามารถดำเนินการได้', "error");
                        }
                    });
                }
            });

        });

    </script>

@endsection
