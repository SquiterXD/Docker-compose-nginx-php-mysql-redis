<script>

    var line_remove = [];
    var outstanding_id = []
    let productlist = {};
    let message_alert = '';

    var elOrLineLast = $("#tbOrderLine > tbody")

    var quata_remaining = [];
    $.each(contractQuata, function(i, obj_c) {
        quata_remaining[obj_c.group.lookup_code] = obj_c.remaining_quota
        $.each(obj_c.quota, function( key, obj ) {
            var data = {
                'group' : obj_c.group,
                'item' : obj,
                'received_quota' : obj_c.received_quota,
                'remaining_quota' : obj_c.remaining_quota
            }
            itemList.push(data)
        });
        // itemList.push(item)
    });

    function delay(callback, ms) {
        var timer = 0;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function () {
            callback.apply(context, args);
            }, ms || 0);
        };
    }

    function addOrderLine() {
        runOrderLine++
        // if(runLine < totalLine){
        //     runLine = totalLine
        // }
        Swal.showLoading()
        var htmlOrderLine = '<tr class="align-middle" id="tr_item_'+runLine+'">'+
                '<td><span class="runLine">'+runLine+'</span>'+
                    '<input type="hidden" class="form-control" readonly id="program_code_'+runLine+'" placeholder="" value="">'+
                    '<input type="hidden" id="line_number_'+runLine+'" class="form-control" readonly placeholder="" value="'+runLine+'">'+
                '</td>'+
                '<td><span id="date_latest_'+runLine+'">-</span></td>'+
                '<td><span id="amount_latest_'+runLine+'">0.00</span></td>'+
                '<td><span id="uom_latest_'+runLine+'"></span></td>'+
                '<td>'+
                    '<input type="text" class="form-control" data-id="'+runLine+'" name="item_id['+runLine+']" id="item_id_'+runLine+'" placeholder="" list="product-list-'+runLine+'" onchange="changeItem(this);" autocomplete="off">'+
                    '<datalist id="product-list-'+runLine+'">'+
                    '</datalist>'+
                '</td>'+
                '<td class="text-left"><span id="item_name_'+runLine+'"></span></td>'+

                '<td><input type="text" class="form-control md text-center" id="orderQuantity_'+runLine+'" '+((type_save == "create" || type_save == "update") ? "readonly" : "")+' onkeyup="orderQuantity(this)" onkeypress="return isCheckNumber(event)" value=""></td>'+
                '<td>'+
                    '<span id="uom_code_'+runLine+'"></span>'+
                    //  '<select class="custom-select select2 uom_select" data-id="'+runLine+'" aria-readonly="true" name="uom_code['+runLine+']" id="uom_code_'+runLine+'" data-placeholder="หน่วยนับ">'+
                    //     '<option value=""></option>'+
                    // '</select>'+
                '</td>'+
                '<td><span id="uom_desc_'+runLine+'"></span></td>'+

                '<td><input type="text" class="form-control md text-center" id="approveQuantity_'+runLine+'" readonly onkeyup="approveQuantity(this)" onkeypress="return isCheckNumber(event)" value=""></td>'+
                '<td><span id="uom_code_approve_'+runLine+'"></span></td>'+
                '<td>'+
                    '<select class="custom-select select2 uom_select" data-id="'+runLine+'" aria-readonly="true" name="uom_approve['+runLine+']" id="uom_approve_'+runLine+'" data-placeholder="หน่วยนับ">'+
                        '<option value=""></option>'+
                    '</select>'+
                // <span id="uom_approve_'+runLine+'"></span>
                '</td>'+

                '<td class="text-right">'+
                    '<span id="item_price_text_'+runLine+'" style="display:none;">0</span>'+
                    '<input type="text" class="form-control md text-center unit_price_text" readonly id="unit_price_text_'+runLine+'" onkeyup="changePrice(this)" onkeypress="return isCheckNumber(event)"/>'+
                    '<input type="hidden" class="form-control md text-center unit_price" readonly id="unit_price_'+runLine+'" onkeyup="changePrice(this)" onkeypress="return isCheckNumber(event)"/>'+
                '</td>'+
                '<td class="text-right">'+
                    '<span id="sum_amount_text_'+runLine+'">0</span>'+
                    '<input type="hidden" class="sum_amount_item" id="sum_amount_'+runLine+'"/>'+
                '</td>'+
                '<td><span id="onhand_'+runLine+'"></span>'+
                '<td><a class="fa fa-times red" href="javascript:void(0)" onclick="removeItem('+runLine+')"></a></td>'+
            '</tr>';

        elOrLineLast.append(htmlOrderLine);

        $('.select2').select2();

        // console.log(itemList)

        setTimeout(async function(){
            await $.each(itemList, function( key, obj ) {
                // $('#item_id_'+runOrderLine)
                // .append($('<option></option>')
                // .val(obj.item.item_id)
                // .html(obj.item.item_code +' '+ obj.item.item_description ));

                $('#product-list-'+runLine)
                .append($('<option></option>')
                .val(obj.item.item_code)
                .html(obj.item.item_description ));
            });
            Swal.close()
            runLine++
        }, 2000);

    }

    async function removeItem(index) {
        $('#tr_item_'+index).remove()
        runLine = 0
        await $('.runLine').map( function(key){
            runLine += 1
            $(this).html(runLine);
        })
        runLine = $('.runLine').length + 1
        updateCredit()

    }

    async function removeItemLine(index,line_id) {
        $('#tr_item_'+index).remove()
        runLine = 0
        await $('.runLine').map( function(key){
            runLine += 1
            $(this).html(runLine);
        })
        runLine = $('.runLine').length + 1
        line_remove.push(line_id)
        updateCredit()

    }

    function changeItem(e) {
        var val = $(e).val()
        var el = $(e)
        var id = $(e).data('id')

        $('#date_latest_'+id).html('-')
        $('#amount_latest_'+id).html('0.00')

        var filterednames = itemList.filter(function(obj) {
            var item = obj.item

            var group = obj.group
            var received_quota = obj.received_quota
            var remaining_quota = obj.remaining_quota
            var onhand_quantity = obj.onhand_quantity

            if(item.item_code === val){
                // chest amount

                var elpc = $('#program_code_'+id)
                setElAttr(elpc,'name','program_code['+id+']')
                $('#program_code_'+id).val('OMP0019')

                var eln = $('#line_number_'+id)
                setElAttr(eln,'name','line_number['+id+']')

                var elc = $('#orderQuantity_'+id)

                setElAttr(elc,'name','order_quantity['+id+']')
                setElAttr(elc,'data-run',id)
                setElAttr(elc,'data-type','create')
                setElAttr(elc,'data-id',item.item_id)
                setElAttr(elc,'data-price',item.price_unit)
                setElAttr(elc,'data-line',id)

                var elcA = $('#approveQuantity_'+id)
                elcA.attr("readonly", false);
                setElAttr(elcA,'name','approve_quantity['+id+']')
                setElAttr(elcA,'data-type','create')
                setElAttr(elcA,'data-run',id)
                setElAttr(elcA,'data-id',item.item_id)
                setElAttr(elcA,'data-price',item.price_unit)
                setElAttr(elcA,'data-line',id)
                // chest amount

                $('#uom_code_'+id).html(item.product_uom_code)
                $('#uom_code_approve_'+id).html(item.product_uom_code)

                // $('#uom_desc_'+id).html(item.unit_of_measure)
                $('#uom_approve_'+id).html(item.unit_of_measure)


                var elP = $('#unit_price_'+id)
                elP.attr("readonly", false);
                setElAttr(elP,'name','unit_price['+id+']')
                setElAttr(elP,'data-type','create')
                setElAttr(elP,'data-run',id)
                setElAttr(elP,'data-id',item.item_id)
                setElAttr(elP,'data-price',item.price_unit)
                setElAttr(elP,'data-line',id)

                var elPT = $('#unit_price_text_'+id)
                elPT.attr("readonly", false);
                setElAttr(elPT,'name','unit_price_text['+id+']')
                setElAttr(elPT,'data-type','create')
                setElAttr(elPT,'data-run',id)
                setElAttr(elPT,'data-id',item.item_id)
                setElAttr(elPT,'data-price',item.price_unit)
                setElAttr(elPT,'data-line',id)

                $('#sum_amount_text_'+id).addClass('sum_amount_text_'+id)
                setElAttr($('#sum_amount_'+id),'name','sum_amount['+id+']')
                setElAttr($('#sum_amount_'+id),'data-group',item.credit_group_code)


                $('#item_name_'+id).html(item.item_description)
                $('#item_price_text_'+id).html(formatMoney(item.price_unit,2))
                setElAttr($('#unit_price_'+id),'name','unit_price['+id+']')
                setElAttr($('#unit_price_text_'+id),'name','unit_price_text['+id+']')

                $('#unit_price_'+id).val(item.price_unit)
                $('#unit_price_text_'+id).val(formatMoney(item.price_unit,0))


                $('#date_latest_'+id).html(latest[item.item_id].order_date)
                $('#amount_latest_'+id).html(formatMoney(latest[item.item_id].order_quantity,2))
                $('#uom_latest_'+id).html((latest[item.item_id].order_uom))

                $('#onhand_'+id).html(formatMoney(item.onhand,2))


                $.each( item.uom_list, function( key, v ) {
                    // var newOption = new Option(v.unit_of_measure, v.uom_code, true, true);
                    // $('#uom_code_'+id).append(newOption).trigger('change');
                    // $('#uom_code_'+id).data('price',v.price_unit).trigger('change');
                    // $('#uom_code_'+id).data('measure',v.unit_of_measure).trigger('change');
                    // $('#uom_code_'+id).append('<option value="'+v.uom_code+'" data-type="create" data-line="'+id+'" data-price="'+v.price_unit+'" data-measure="'+v.unit_of_measure+'">'+v.unit_of_measure+'</option>');
                    $('#uom_approve_'+id).append('<option value="'+v.uom_code+'" data-type="create" data-line="'+id+'" data-price="'+v.price_unit+'" data-measure="'+v.unit_of_measure+'">'+v.unit_of_measure+'</option>');
                    // $('#uom_code_'+id).val(v.uom_code);
                    // $('#uom_code_'+id).data('type','create');
                    // $('#uom_code_'+id).data('line',id);
                    // $('#uom_code_'+id).data('price',v.price_unit);
                    // $('#uom_code_'+id).data('measure',v.unit_of_measure);

                });


                $('#uom_approve_'+id).trigger('change');
                $('#uom_code_'+id).trigger('change');


            }
        });
    }

    $(document).on('change', '.uom_select', function() {

        console.log('asdasd')
        var uom = $(this).val();

        var price = $(this).select2().find(":selected").data("price");
        var measure = $(this).select2().find(":selected").data("measure");

        // console.log(uom,price,measure)

        var line = $(this).select2().find(":selected").data('line')

        $('#uom_desc_'+line).html(measure)
        $('#uom_code_'+line).html(uom)
        $('#uom_code_approve_'+line).html(uom)

        // var price = $(e).data('price')
        $('#unit_price_'+line).val(price)
        $('#unit_price_text_'+line).val(formatMoney(price,2))
        var type = $(this).select2().find(":selected").data('type')


        var val = $('#approveQuantity_'+line).val()

        var sum = price*val;

        console.log(price,val,sum)

        $('#sum_amount_'+line).val(sum);
        $('#sum_amount_text_'+line).html(formatMoney(sum),2);

        updateCredit();

    })

    $(".uom_select2").change(async function() {
        console.log('asdasd')
    });

    $(document).on('click', '.outstanding_no' , function() {

        var no = $(this).data('no')
        var group = $(this).data('group')
        var amount = $(this).data('amount')
        var penalty = $(this).data('penalty')
        var remaining_amount = $("input[name='use_remaining_amount["+group+"]']").val()
        var outstanding = $("input[name='outstanding["+no+"]']").val()

        if ($("#outstanding_no_"+no).prop('checked')) {
            $("input[name='use_remaining_amount["+group+"]']").val(parseFloat(remaining_amount) + parseFloat(amount))
            $("input[name='outstanding["+no+"]']").val(amount)
            $("input[name='outstanding_id["+no+"]']").val(no)
            $("input[name='outstanding_rm["+no+"]']").val('')
            over_fine_amount += parseFloat(amount) + parseFloat(penalty);
        }else{
            $("input[name='use_remaining_amount["+group+"]']").val(parseFloat(remaining_amount) - parseFloat(amount))
            $("input[name='outstanding["+no+"]']").val(0)
            $("input[name='outstanding_id["+no+"]']").val('')
            $("input[name='outstanding_rm["+no+"]']").val(no)
            over_fine_amount -= parseFloat(amount) + parseFloat(penalty);
        }

        var fine = over_fine_amount - cancel_over;
        $('#over_fine_amount').val(formatMoney((fine < 0) ? 0 : fine,2))

        updateCredit()
    })

    $(document).on('click', '.cancel_outstanding_no' , function() {

        var no = $(this).data('no')
        var group = $(this).data('group')
        var amount = $(this).data('amount')
        var penalty = $(this).data('penalty')
        var remaining_amount = $("input[name='use_remaining_amount["+group+"]']").val()
        var outstanding = $("input[name='cancel_outstanding["+no+"]']").val()

        if ($("#cancel_outstanding_no_"+no).prop('checked')) {
            // $("input[name='use_remaining_amount["+group+"]']").val(parseFloat(remaining_amount) + parseFloat(amount))
            $("input[name='cancel_outstanding["+no+"]']").val(amount)
            $("input[name='cancel_outstanding_id["+no+"]']").val(no)
            $("input[name='cancel_outstanding_rm["+no+"]']").val('')
            cancel_over += parseFloat(amount) + parseFloat(penalty);
        }else{
            // $("input[name='use_remaining_amount["+group+"]']").val(parseFloat(remaining_amount) - parseFloat(amount))
            $("input[name='cancel_outstanding["+no+"]']").val(0)
            $("input[name='cancel_outstanding_id["+no+"]']").val('')
            $("input[name='cancel_outstanding_rm["+no+"]']").val(no)
            cancel_over -= parseFloat(amount) + parseFloat(penalty);
        }

        var fine = over_fine_amount - cancel_over;

        $('#cancel_over_fine_amount').val(formatMoney(cancel_over,2))
        $('#over_fine_amount').val(formatMoney((fine < 0) ? 0 : fine,2))

        // updateCredit()
    })

    function setElAttr(el,attr,val) {
        $(el).attr(attr,val)
    }

    async function orderQuantity(e) {
        var val = $(e).val()

        var id = $(e).data('id')
        var run = $(e).data('run')
        var price = $(e).data('price')

        // console.log(val,id,quata,group,line,price)

        if(isNaN($(e).val()) || $(e).val() == ''){
            $('#approveQuantity_'+run).val('')
        }

        updateCredit()

    }

    async function approveQuantity(e) {
        var val = $(e).val()
        var id = $(e).data('id')
        var line = $(e).data('line')
        // var price = $(e).data('price')
        var price = $('#unit_price_'+line).val()
        var type = $(e).data('type')

        if(type == 'create'){
            $('#orderQuantity_'+line).val(val)
        }

        var sum = price*val;

        $('#sum_amount_'+line).val(sum);
        $('#sum_amount_text_'+line).html(formatMoney(sum),2);

        updateCredit();

    }

    async function changePrice(e) {
        var val = $(e).val()
        var id = $(e).data('id')
        var run = $(e).data('run')
        // var quata = $(e).data('quata')
        // var group = $(e).data('group')
        var line = $(e).data('line')
        var price = formatConvertMoney($(e).val())

        $('#unit_price_'+run).val(price)
        var val = $('#orderQuantity_'+line).val()

        var sum = price*val;

        $('#sum_amount_'+line).val(sum);
        $('#sum_amount_text_'+line).html(formatMoney(sum),2);

        updateCredit();

        // setTimeout(function() {
            $('#unit_price_text_'+run).val(formatMoney(price,2))
        // }, 1000);

    }

    async function checkLimitApproveItemQuota(quata,group,line,id,price,run){
        var chest = $("input[name='approve_chest_amount["+quata+"]["+line+"]["+id+"]["+run+"]']").val() / 0.1;
        var wrap = $("input[name='approve_wrap_amount["+quata+"]["+line+"]["+id+"]["+run+"]']").val() * 0.2;
        // var min = $("input[name='min_amount["+quata+"]["+line+"]["+id+"]']").val();

        var sum = (chest+wrap)

        setTimeout(function() {
            $('#order_quantity_approve_'+run).val(sum)
            $('#order_quantity_approve_text_'+run).html(formatMoney(sum,2))
            $("input[name='order_quantity_approve["+quata+"]["+line+"]["+id+"]["+run+"]']").val(sum);
        }, 1000);
    }

    async function updateCredit() {
        // console.log('asdasd')
        setTimeout(async function() {
            // useAmount = 0
            // arrUseAmount = [];
            // var remaining_amount = formatConvertMoney($('#remaining_amount').val());
            // var grand = 0;
            // var over_fine = parseFloat($('#over_fine_amount').val(),2)

            // await $('.sum_amount_item').map( function(key){
            //     // arrUseAmount[$(this).data('group')] = 0
            // })
            var cash_amount = 0;
            await $('.sum_amount_item').map( function(key){
                cash_amount += parseFloat($(this).val(),2)
            })

            $('#cash_amount').val(formatMoney(cash_amount,2));

            $('#credit_amount').val(formatMoney(0,2))

            $('#grand_total').val(formatMoney((parseFloat(cash_amount,2)),2))

            updatePaymentDay()
        }, 1000);
    }

    function updateItemQuota(quata,line,id,sum,price,type,run){
        console.log(type)
        if(type == 'create'){
            $(".order_quantity_text_"+quata+"_"+line+"_"+id+"_"+run).html(formatMoney(sum,2))
            $("input[name='order_quantity["+quata+"]["+line+"]["+id+"]["+run+"]']").val(sum);
        }

        $(".sum_amount_text_"+quata+"_"+line+"_"+id+"_"+run).html(formatMoney((sum * price),2))

        // $(".total_sum_quota_"+quata+"_"+line+"_"+id).html(formatMoney(sum * price))
        $("input[name='sum_amount["+quata+"]["+line+"]["+id+"]["+run+"]']").val(sum * price);
    }

    async function updatePaymentDay() {

        var count_day_amount = 0
        await $('.use_received_amount').map( function(key){
            // console.log($(this).data('group'));
            var dateth = $('.day_amount_amount_'+$(this).data('group')).data('dateth')
            var amount = $("input[name='use_amount["+$(this).data('group')+"]']").val();
            $('.day_amount_amount_'+$(this).data('group')).html(formatMoney((amount),2))

            if(amount > 0){
                $('.day_amount_'+$(this).data('group')).css('display','table-row')
                $('#payment_duedate').val(dateth)
                count_day_amount += 1;
            }else{
                $('.day_amount_'+$(this).data('group')).css('display','none')
            }
        })

        if(formatConvertMoney($('#cash_amount').val()) > 0){
            count_day_amount += 1;
            $('.day_amount_amount_0').html($('#cash_amount').val())
            $('.day_amount_0').css('display','table-row')
        }else{
            $('.day_amount_amount_0').html(formatMoney((0),2))
            $('.day_amount_0').css('display','none')
        }

        if(count_day_amount <= 1){
            $('#payment_duedate_date').css('display','block')
            $('#payment_duedate_modal').css('display','none')
        }else{
            $('#payment_duedate_date').css('display','none')
            $('#payment_duedate_modal').css('display','block')
        }

        // await $('.unit_price').map( function(key){
        //     console.log($(this).data('group'));
        // })
    }

    function viewDayAmount() {
        $('#datePaymentModal').modal('show')
    }

    function viewOutstanding() {
        $('#Outstanding').modal('show')
    }


    $("#btn_save").click(async function() {
        $('#form_type').val('save')
        message_alert = 'ต้องการบันทึกข้อมูลใช่หรือไม่'
        $("#form-order").submit()
    });

    $("#btn_confirm").click(async function() {
        $('#form_type').val('confirm')
        $("#form-order").submit()
        message_alert = 'ต้องการยืนยันข้อมูลใช่หรือไม่'
    });

    $("#btn_approve").click(async function() {
        $('#form_type').val('approve')
        $("#form-order").submit()
        message_alert = 'ต้องการส่งข้อมูลอนุมัติตั้งหนี้ ใช่หรือไม่'
    });

    async function setDayAmount(date){

        let fb = this // this
        let formData = new FormData();
        await formData.append('date', date);
        await formData.append('order_number', $('#order_number').val());
        await formData.append('customer_number', $('#customer_number').val());
        await formData.append('_token','{{ csrf_token() }}');

        $.ajax({
            type: 'post',
            url: "{{ route('om.ajax.order.prepare.set_dayamount') }}",
            data: formData,
            enctype: 'multipart/form-data',
            cache: false,
            contentType: false,
            processData: false,
            success: function (result) {
                var day_amount_amount = [];
                var day_amount_style = [];
                $.each( result.data.dayAmount, function( key, v ) {
                    day_amount_amount[v.credit_group_code] = $('.day_amount_amount_'+v.credit_group_code).html()
                    day_amount_style[v.credit_group_code] = $('.day_amount_'+v.credit_group_code).attr('style')
                });

                $("#tb_day_amount > tbody").html('');
                $.each( result.data.dayAmount, function( key, v ) {
                    $("#tb_day_amount > tbody").append(
                        '<tr class="day_amount_'+v.credit_group_code+'" style="'+day_amount_style[v.credit_group_code]+'">'+
                            '<td><span class="day_amount_description">'+v.description+'</span></td>'+
                            '<td class="text-right day_amount_amount_'+v.credit_group_code+'" data-dateth="'+v.date_th+'"><span class="day_amount_amount">'+day_amount_amount[v.credit_group_code]+'</span></td>'+
                            '<td><span class="day_amount_date_th">'+v.date_th+'</span></td>'+
                        '</tr>'
                    );
                });

                if($('#pick_release_approve_date').val() == ''){
                    $('#payment_duedate').val(result.data.dayAmountActive)
                }

            },
            error: function (error) {
                console.log(error)
            }
        });

    }

    $("#form-order").submit(async function(e) {
            e.preventDefault();
            let fb = this // this
            let formData = new FormData(fb);

            await $.each(fileChoose,async function(index, file) {
            if(typeof file !== "undefined")
                await formData.append('attachment[]', file);
            });
            await formData.append('line_remove[]', line_remove);


            // if ($('#order_number').val() == '') {
            //     Swal.fire({
            //         title: 'เกิดข้อผิดพลาด',
            //         text: "กรุณากรอกเลขที่ใบสั่งซื้อ",
            //         icon: 'warning',
            //         showConfirmButton: false,
            //         timer: 3000
            //     });
            // }
            if($('#customer_number').val() == ''){
                Swal.fire({
                    title: 'เกิดข้อผิดพลาด',
                    text: "กรุณาเลือกรหัสลูกค้า",
                    icon: 'warning',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
            else if($('#shipment_by').val() == ''){
                Swal.fire({
                    title: 'เกิดข้อผิดพลาด',
                    text: "กรุณาเลือกข้อมูลส่งโดย",
                    icon: 'warning',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
            else{
            // if(data_select){
                Swal.fire({
                    title: 'แจ้งเตือน',
                    text: message_alert,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#1ab394',
                    cancelButtonColor: '#e7eaec',
                    confirmButtonText: 'ยืนยัน',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.showLoading()
                        $.ajax({
                            type: 'post',
                            url: $(fb).data('action'),
                            data: formData,
                            enctype: 'multipart/form-data',
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (result) {
                                if(!result.status){
                                    Swal.fire({
                                        title: 'เกิดข้อผิดพลาด',
                                        text: "กรุณาตรวจสอบข้อมูลอีกครั้ง",
                                        icon: 'warning',
                                        showConfirmButton: false,
                                        timer: 3000
                                    });
                                }else{

                                    Swal.fire({
                                        title: 'บันทึกข้อมูล',
                                        text: "บันทึกข้อมูลสำเร็จ",
                                        icon: 'success',
                                        showConfirmButton: false,
                                        timer: 3000
                                    });

                                    setTimeout(function() {
                                        window.location.href = "{{ url('/') }}/om/order/prepare/search?prepare_order_number="+result.prepare_order_number;
                                    }, 2000);

                                }

                            },
                            error: function (error) {
                                console.log(error)
                            }
                        });
                    }else{
                        Swal.close()
                    }
                })
            }
            // }else{
            //     swal('กรุณาเลือกสินค้าอย่างน้อย 1 รายการ')
            // }


        })

</script>
