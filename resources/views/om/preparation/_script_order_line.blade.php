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

    function clearOrderLine() {
        elOrLineLast.html('')
        updateCredit()
        runLine = 1
        isItem = false;
        $('#over_fine_amount').val(parseFloat(0,2))
    }

    function addOrderLine(runLineChange=0) {
        if(runLineChange != 0){
            // removeItem(runLineChange)
        }
        runOrderLine++
        // if(runLine < totalLine){
        //     runLine = totalLine
        // }
        // Swal.showLoading()
        var htmlOrderLine = '<tr class="align-middle" id="tr_item_'+runLine+'">'+
                '<td><span class="runLine">'+runLine+'</span>'+
                    '<input type="hidden" class="form-control" readonly id="program_code_'+runLine+'" placeholder="" value="">'+
                    '<input type="hidden" id="line_number_'+runLine+'" class="form-control" readonly placeholder="" value="'+runLine+'">'+
                '</td>'+
                '<td class="d-none"><span id="date_latest_'+runLine+'">-</span></td>'+
                '<td class="d-none"><span id="amount_latest_'+runLine+'">0.00</span></td>'+
                '<td>'+
                    '<input type="text" class="form-control" data-id="'+runLine+'" name="item_id['+runLine+']" id="item_id_'+runLine+'" placeholder="" list="product-list-'+runLine+'" autocomplete="off" onchange="changeItem(this);">'+
                    '<datalist id="product-list-'+runLine+'">'+
                    '</datalist>'+
                    // '<select class="custom-select select2 select-item-list" onchange="changeItem(this);" data-id="'+runLine+'" aria-readonly="true" name="item_id['+runLine+']" id="item_id_'+runLine+'" data-placeholder="รหัสสินค้า">'+
                    //     '<option value=""></option>'+
                    // '</select>'+
                '</td>'+
                '<td class="text-left"><span id="item_name_'+runLine+'"></span></td>'+

                '<td><input type="text" class="form-control md text-center order_cardboardbox" id="chestAmount_'+runLine+'" '+((type_save == "update") ? "readonly" : "")+' autocomplete="off" onkeyup="chestAmount(this)" onkeypress="return isCheckNumber(event)" value=""></td>'+
                '<td><input type="text" class="form-control md text-center order_carton" id="wrapAmount_'+runLine+'" '+((type_save == "update") ? "readonly" : "")+' autocomplete="off" onkeyup="wrapAmount(this)" onkeypress="return isCheckNumber(event)" value=""></td>'+
                '<td><span id="order_quantity_text_'+runLine+'"></span><input class="order_quantity" type="hidden" id="order_quantity_'+runLine+'"/></td>'+

                '<td><input type="text" class="form-control md text-center approve_cardboardbox" id="approveChestAmount_'+runLine+'" readonly onkeyup="approveChestAmount(this)" autocomplete="off" onkeypress="return isCheckNumber(event)" value=""></td>'+
                '<td><input type="text" class="form-control md text-center approve_carton" id="approveWrapAmount_'+runLine+'" readonly onkeyup="approveWrapAmount(this)" autocomplete="off" onkeypress="return isCheckNumber(event)" value=""></td>'+
                '<td><span id="order_quantity_approve_text_'+runLine+'"></span><input class="approve_quantity" type="hidden" id="order_quantity_approve_'+runLine+'"/></td>'+

                '<td class="text-right">'+
                    '<span id="item_price_text_'+runLine+'" style="display:none;">0</span>'+
                    '<input type="text" class="form-control md text-center unit_price_text" readonly id="unit_price_text_'+runLine+'" onkeyup="changePrice(this)" onkeypress="return isCheckNumber(event)"/>'+
                    '<input type="hidden" class="form-control md text-center unit_price" readonly id="unit_price_'+runLine+'" onkeyup="changePrice(this)" onkeypress="return isCheckNumber(event)"/>'+
                '</td>'+
                '<td class="text-right">'+
                    '<span id="sum_amount_text_'+runLine+'">0</span>'+
                    '<input type="hidden" class="sum_amount_item" id="sum_amount_'+runLine+'"/>'+
                '</td>'+
                '<td class="text-right" style="display:none;">'+
                    '<span id="item_quata_use_text_'+runLine+'"></span>'+
                '</td>'+
                '<td class="text-right">'+
                    '<span id="item_quata_received_text_'+runLine+'"></span>'+
                '</td>'+
                '<td class="text-right">'+
                    '<span id="item_quata_remaining_text_'+runLine+'"></span>'+
                '</td>'+
                '<td class="text-right">'+
                    '<span id="item_onhand_quantity_text_'+runLine+'"></span>'+
                '</td>'+
                '<td><a class="fa fa-times red" href="javascript:void(0)" onclick="removeItem('+runLine+')"></a></td>'+
            '</tr>';

        elOrLineLast.append(htmlOrderLine).ready(function() {
            $.each(itemList, function( key, obj ) {
                // $('#product-list-'+runLine)
                // .append($('<option></option>')
                // .val(obj.item.item_code)
                // .html(obj.item.item_description ));
                $('#product-list-'+runLine).html(html_product_lists)
            });
            // Swal.close()
            runLine++
        });

        isItem = true
        $('.select2').select2();
        console.log(itemList, 'itemList')
        // setTimeout(async function(){
        //     await $.each(itemList, function( key, obj ) {

        //         $('#product-list-'+runLine)
        //         .append($('<option></option>')
        //         .val(obj.item.item_code)
        //         .html(obj.item.item_description ));
        //     });
        //     Swal.close()
        //     runLine++
        // }, 2000);

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
        var id = $(e).attr('data-id')


        $('#date_latest_'+id).html('-')
        $('#amount_latest_'+id).html('0.00')

        var filterednames = itemList.filter(async function(obj) {
            var item = obj.item

            var group = obj.group
            var received_quota = obj.received_quota
            var remaining_quota = obj.remaining_quota
            var onhand_quantity = obj.onhand_quantity

            if(item.item_code === val){
                // chest amount

                var elpc = $('#program_code_'+id)
                setElAttr(elpc,'name','program_code['+group.lookup_code+']['+item.quota_line_id+']['+item.item_id+']['+id+']')
                $('#program_code_'+id).val('OMP0019')

                var eln = $('#line_number_'+id)
                setElAttr(eln,'name','line_number['+group.lookup_code+']['+item.quota_line_id+']['+item.item_id+']['+id+']')


                var elc = $('#chestAmount_'+id)
                elc.val('')
                setElAttr(elc,'name','chest_amount['+group.lookup_code+']['+item.quota_line_id+']['+item.item_id+']['+id+']')
                elc.attr("readonly", false);
                // setElAttr(elc,'class','order_cardboardbox')
                setElAttr(elc,'data-run',id)
                setElAttr(elc,'data-type','create')
                setElAttr(elc,'data-id',item.item_id)
                setElAttr(elc,'data-price',item.price_unit)
                setElAttr(elc,'data-quata',group.lookup_code)
                setElAttr(elc,'data-group',item.credit_group_code)
                setElAttr(elc,'data-line',item.quota_line_id)

                var elcA = $('#approveChestAmount_'+id)
                elcA.val('')
                setElAttr(elcA,'name','approve_chest_amount['+group.lookup_code+']['+item.quota_line_id+']['+item.item_id+']['+id+']')
                elcA.attr("readonly", false);
                setElAttr(elcA,'data-type','create')
                setElAttr(elcA,'data-run',id)
                setElAttr(elcA,'data-id',item.item_id)
                setElAttr(elcA,'data-price',item.price_unit)
                setElAttr(elcA,'data-quata',group.lookup_code)
                setElAttr(elcA,'data-group',item.credit_group_code)
                setElAttr(elcA,'data-line',item.quota_line_id)
                // chest amount

                // wrap amount
                var elw = $('#wrapAmount_'+id)
                elw.val('')
                setElAttr(elw,'name','wrap_amount['+group.lookup_code+']['+item.quota_line_id+']['+item.item_id+']['+id+']')
                elw.attr("readonly", false);
                setElAttr(elw,'data-type','create')
                setElAttr(elw,'data-run',id)
                setElAttr(elw,'data-id',item.item_id)
                setElAttr(elw,'data-price',item.price_unit)
                setElAttr(elw,'data-quata',group.lookup_code)
                setElAttr(elw,'data-group',item.credit_group_code)
                setElAttr(elw,'data-line',item.quota_line_id)

                var elwA = $('#approveWrapAmount_'+id)
                elwA.val('')
                setElAttr(elwA,'name','approve_wrap_amount['+group.lookup_code+']['+item.quota_line_id+']['+item.item_id+']['+id+']')
                elwA.attr("readonly", false);
                setElAttr(elwA,'data-type','create')
                setElAttr(elwA,'data-run',id)
                setElAttr(elwA,'data-id',item.item_id)
                setElAttr(elwA,'data-price',item.price_unit)
                setElAttr(elwA,'data-quata',group.lookup_code)
                setElAttr(elwA,'data-group',item.credit_group_code)
                setElAttr(elwA,'data-line',item.quota_line_id)
                // wrap amount

                var elP = $('#unit_price_'+id)
                elP.val('')
                setElAttr(elP,'name','unit_price['+group.lookup_code+']['+item.quota_line_id+']['+item.item_id+']['+id+']')
                elP.attr("readonly", false);
                setElAttr(elP,'data-type','create')
                setElAttr(elP,'data-run',id)
                setElAttr(elP,'data-id',item.item_id)
                setElAttr(elP,'data-price',item.price_unit)
                setElAttr(elP,'data-quata',group.lookup_code)
                setElAttr(elP,'data-group',item.credit_group_code)
                setElAttr(elP,'data-line',item.quota_line_id)

                var elPT = $('#unit_price_text_'+id)
                elPT.val('')
                setElAttr(elPT,'name','unit_price_text['+group.lookup_code+']['+item.quota_line_id+']['+item.item_id+']['+id+']')
                elPT.attr("readonly", false);
                setElAttr(elPT,'data-type','create')
                setElAttr(elPT,'data-run',id)
                setElAttr(elPT,'data-id',item.item_id)
                setElAttr(elPT,'data-price',item.price_unit)
                setElAttr(elPT,'data-quata',group.lookup_code)
                setElAttr(elPT,'data-group',item.credit_group_code)
                setElAttr(elPT,'data-line',item.quota_line_id)

                $('#order_quantity_text_'+id).addClass('order_quantity_text_'+group.lookup_code+'_'+item.quota_line_id+'_'+item.item_id+'_'+id).html('')
                $('#order_quantity_'+id).addClass('order_quantity_group_'+group.lookup_code)
                $('#order_quantity_'+id).val('')
                setElAttr($('#order_quantity_'+id),'name','order_quantity['+group.lookup_code+']['+item.quota_line_id+']['+item.item_id+']['+id+']')

                $('#order_quantity_approve_text_'+id).addClass('order_quantity_approve_text_'+group.lookup_code+'_'+item.quota_line_id+'_'+item.item_id+'_'+id).html('')
                $('#order_quantity_approve_'+id).addClass('order_quantity_approve_group_'+group.lookup_code)
                $('#order_quantity_approve_'+id).val('')
                setElAttr($('#order_quantity_approve_'+id),'name','order_quantity_approve['+group.lookup_code+']['+item.quota_line_id+']['+item.item_id+']['+id+']')

                $('#sum_amount_text_'+id).addClass('sum_amount_text_'+group.lookup_code+'_'+item.quota_line_id+'_'+item.item_id+'_'+id).html('')
                $('#sum_amount_text_'+id).val('')
                setElAttr($('#sum_amount_'+id),'name','sum_amount['+group.lookup_code+']['+item.quota_line_id+']['+item.item_id+']['+id+']')
                setElAttr($('#sum_amount_'+id),'data-group',item.credit_group_code)


                $('#item_name_'+id).html(item.item_description)
                $('#item_price_text_'+id).html(formatMoney(item.price_unit,2))
                setElAttr($('#unit_price_'+id),'name','unit_price['+group.lookup_code+']['+item.quota_line_id+']['+item.item_id+']['+id+']')
                setElAttr($('#unit_price_text_'+id),'name','unit_price_text['+group.lookup_code+']['+item.quota_line_id+']['+item.item_id+']['+id+']')

                $('#unit_price_'+id).val(item.price_unit)
                $('#unit_price_text_'+id).val(formatMoney(item.price_unit,2))

                $('#item_quata_remaining_text_'+id).html(formatMoney(remaining_quota,2))
                quata_remaining[group.lookup_code] = remaining_quota

                $('#item_quata_received_text_'+id).html(formatMoney(received_quota,2))
                setElAttr($('#item_quata_received_text_'+id),'data-amount',received_quota)

                $('#item_onhand_quantity_text_'+id).html(formatMoney(item.onhand,2))
                setElAttr($('#item_onhand_quantity_text_'+id),'data-amount',item.onhand)

                $('#item_quata_use_text_'+id).addClass('item_quata_use_text_'+group.lookup_code)
                $('#item_quata_remaining_text_'+id).addClass('item_quata_remaining_text_'+group.lookup_code)
                setElAttr($('#item_quata_remaining_text_'+id),'data-amount',remaining_quota)
                // console.log(quata_remaining)
                $('#item_quata_received_text_'+id).addClass('item_quata_received_text_'+group.lookup_code)
                // $('#item_onhand_quantity_text_'+id).addClass('item_onhand_quantity_text')

                $('#date_latest_'+id).html(latest[item.item_id].order_date)
                $('#amount_latest_'+id).html(formatMoney(latest[item.item_id].order_quantity,2))

                // await checkLimitItemQuota(group.lookup_code,item.credit_group_code,item.quota_line_id,item.item_id,item.price_unit,'create',id)
                await checkLimitApproveItemQuota(group.lookup_code,item.credit_group_code,item.quota_line_id,item.item_id,item.price_unit,'create',id)
            }
        });
    }

    $(document).on('keyup', '.order_cardboardbox', function(i) {
        $(this).parents('tr').find('.approve_cardboardbox').val($(this).val())
        $(this).parents('tr').find('.approve_cardboardbox').trigger('keypess').trigger('keyup')
    })
    $(document).on('keyup', '.order_carton', function(i) {
        $(this).parents('tr').find('.approve_carton').val($(this).val())
        $(this).parents('tr').find('.approve_carton').trigger('keypess').trigger('keyup')
    })
    // $("#delivery_date").change(async function() {
    //     console.log('asdasd')
    // });

    // $(".outstanding_no").each(async function() {
    //     var no = $(this).data('no')
    //     var group = $(this).data('group')
    //     var amount = $(this).data('amount')
    //     var penalty = $(this).data('penalty')
    //     var remaining_amount = $("input[name='use_remaining_amount["+group+"]']").val()
    //     var outstanding = $("input[name='outstanding["+no+"]']").val()

    //     if($('#'))
    //     if ($("#outstanding_no_"+no).prop('checked')) {
    //         $("input[name='use_remaining_amount["+group+"]']").val(parseFloat(remaining_amount) + parseFloat(amount))
    //         $("input[name='outstanding["+no+"]']").val(amount)
    //         $("input[name='outstanding_id["+no+"]']").val(no)
    //         $("input[name='outstanding_rm["+no+"]']").val('')
    //         over_fine_amount += parseFloat(amount) + parseFloat(penalty);
    //     }else{
    //         $("input[name='use_remaining_amount["+group+"]']").val(parseFloat(remaining_amount) - parseFloat(amount))
    //         $("input[name='outstanding["+no+"]']").val(0)
    //         $("input[name='outstanding_id["+no+"]']").val('')
    //         $("input[name='outstanding_rm["+no+"]']").val(no)
    //         over_fine_amount -= parseFloat(amount) + parseFloat(penalty);
    //     }

    //     var fine = over_fine_amount - cancel_over;
    //     $('#over_fine_amount').val(formatMoney((fine < 0) ? 0 : fine,2))

    //     updateCredit()
    // })

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
            cancel_over += parseFloat(penalty);
            over_fine_amount -= penalty
        }else{
            // $("input[name='use_remaining_amount["+group+"]']").val(parseFloat(remaining_amount) - parseFloat(amount))
            $("input[name='cancel_outstanding["+no+"]']").val(0)
            $("input[name='cancel_outstanding_id["+no+"]']").val('')
            $("input[name='cancel_outstanding_rm["+no+"]']").val(no)
            cancel_over -= parseFloat(penalty);
            over_fine_amount += penalty
        }

        var fine = over_fine_amount - cancel_over;

        $('#cancel_over_fine_amount').val(formatMoney(cancel_over,2))
        $('#over_fine_amount').val(formatMoney((over_fine_amount < 0) ? 0 : over_fine_amount,2))

        updateCredit()
    })

    function setElAttr(el,attr,val) {
        $(el).attr(attr,val)
    }

    async function updateSummary() {
        $summary_order_cardboardbox = 0
        await $('.order_cardboardbox').map( function(key){
            if($(this).val() != NaN && $(this).val() !=''){
                $summary_order_cardboardbox += parseFloat($(this).val())
            }
        })

        $('#summary_order_cardboardbox').html(formatMoney($summary_order_cardboardbox,2))
        // --------------------------
        $summary_order_carton = 0
        await $('.order_carton').map( function(key){
            if($(this).val() != NaN && $(this).val() !=''){
                $summary_order_carton += parseFloat($(this).val())
            }
        })
        $('#summary_order_carton').html(formatMoney($summary_order_carton,2))
        // --------------------------
        $summary_order = 0
        await $('.order_quantity').map( function(key){
            if($(this).val() != NaN && $(this).val() !=''){
                $summary_order += parseFloat($(this).val())
            }
        })
        $('#summary_order').html(formatMoney($summary_order,2))
    }

    async function updateApproveSummary() {
        $summary_approve_cardboardbox = 0
        await $('.approve_cardboardbox').map( function(key){
            if($(this).val() != NaN && $(this).val() !=''){
                $summary_approve_cardboardbox += parseFloat($(this).val())
            }
        })
        $('#summary_approve_cardboardbox').html(formatMoney($summary_approve_cardboardbox,2))
        // --------------------------
        $summary_approve_carton = 0
        await $('.approve_carton').map( function(key){
            if($(this).val() != NaN && $(this).val() !=''){
                $summary_approve_carton += parseFloat($(this).val())
            }
        })
        $('#summary_approve_carton').html(formatMoney($summary_approve_carton,2))
        // --------------------------
        $summary_approve = 0
        await $('.approve_quantity').map( function(key){
            if($(this).val() != NaN && $(this).val() !=''){
                $summary_approve += parseFloat($(this).val())
            }
        })
        $('#summary_approve').html(formatMoney($summary_approve,2))

        $summary_price = 0
        await $('.sum_amount_item').map( function(key){
            if($(this).val() != NaN && $(this).val() !=''){
                $summary_price += parseFloat($(this).val())
            }
        })
        $('#summary_price').html(formatMoney($summary_price,2))
    }

    async function chestAmount(e) {
        var val = $(e).val()
        var id = $(e).attr('data-id')
        var run = $(e).attr('data-run')
        var quata = $(e).attr('data-quata')
        var group = $(e).attr('data-group')
        var line = $(e).attr('data-line')
        var price = $(e).attr('data-price')
        var type = $(e).attr('data-type')

        // console.log(val,id,quata,group,line,price)

        // if(isNaN($(e).val()) || $(e).val() == ''){
        //     $('#approveChestAmount_'+run).val('')
        // }

        // var sum = await checkLimitItemQuota(quata,group,line,id,price,'',run)

        // if(type == 'create'){
            var chest = $("input[name='chest_amount["+quata+"]["+line+"]["+id+"]["+run+"]']").val() / 0.1;
            var wrap = $("input[name='wrap_amount["+quata+"]["+line+"]["+id+"]["+run+"]']").val() * 0.2;
            // var min = $("input[name='min_amount["+quata+"]["+line+"]["+id+"]']").val();
            var sum = (chest + (wrap))

            $(".order_quantity_text_"+quata+"_"+line+"_"+id+"_"+run).html(formatMoney(sum,2))
            $("input[name='order_quantity["+quata+"]["+line+"]["+id+"]["+run+"]']").val(sum);
        // }


        updateSummary()


    }

    async function approveChestAmount(e) {
        var val = $(e).val()
        var id = $(e).attr('data-id')
        var run = $(e).attr('data-run')
        var quata = $(e).attr('data-quata')
        var group = $(e).attr('data-group')
        var line = $(e).attr('data-line')
        // var price = $(e).attr('data-price')
        var price = $('#unit_price_'+run).val()
        var type = $(e).attr('data-type')

        // if(type == 'create'){
        //     $('#chestAmount_'+run).val(val)
        // }

        if(price <= 0){
            $('#item_quata_received_text_'+run).html('0.00')
            $('#item_quata_remaining_text_'+run).html('0.00')
        }else{
            $('#item_quata_received_text_'+run).html(formatMoney($('#item_quata_received_text_'+run).attr('data-amount'),2))
            $('#item_quata_remaining_text_'+run).html(formatMoney($('#item_quata_remaining_text_'+run).attr('data-amount'),2))
        }

        updateApproveSummary()
        // if(isNaN($('#chestAmount_'+run).val()) || $('#chestAmount_'+run).val() == ''){
        //     $(e).val('')
        // }

        // if(parseInt(val) > parseInt($('#chestAmount_'+run).val())){
        //     $(e).val($('#chestAmount_'+run).val())
        // }
        await checkLimitApproveItemQuota(quata,group,line,id,price,type,run)
        // await checkLimitItemQuota(quata,group,line,id,price,type,run)


    }

    async function wrapAmount(e) {
        var val = $(e).val()
        var id = $(e).attr('data-id')
        var run = $(e).attr('data-run')
        var quata = $(e).attr('data-quata')
        var group = $(e).attr('data-group')
        var line = $(e).attr('data-line')
        var price = $(e).attr('data-price')
        var type = $(e).attr('data-type')

        // if(isNaN($(e).val()) || $(e).val() == ''){
        //     $('#approveWrapAmount_'+run).val('')
        // }

        // var sum = await checkLimitItemQuota(quata,group,line,id,price,'',run)

        // if(type == 'create'){
            var chest = $("input[name='chest_amount["+quata+"]["+line+"]["+id+"]["+run+"]']").val() / 0.1;
            var wrap = $("input[name='wrap_amount["+quata+"]["+line+"]["+id+"]["+run+"]']").val() * 0.2;
            // var min = $("input[name='min_amount["+quata+"]["+line+"]["+id+"]']").val();
            var sum = (chest+wrap)

            $(".order_quantity_text_"+quata+"_"+line+"_"+id+"_"+run).html(formatMoney(sum,2))
            $("input[name='order_quantity["+quata+"]["+line+"]["+id+"]["+run+"]']").val(sum);
        // }

        updateSummary()
        // updateCredit()

    }

    async function approveWrapAmount(e) {
        var val = $(e).val()
        var id = $(e).attr('data-id')
        var run = $(e).attr('data-run')
        var quata = $(e).attr('data-quata')
        var group = $(e).attr('data-group')
        var line = $(e).attr('data-line')
        // var price = $(e).attr('data-price')
        var price = $('#unit_price_'+run).val()
        var type = $(e).attr('data-type')

        // if(type == 'create'){
        //     $('#wrapAmount_'+run).val(val)
        // }

        if(price <= 0){
            $('#item_quata_received_text_'+run).html('0.00')
            $('#item_quata_remaining_text_'+run).html('0.00')
        }else{
            $('#item_quata_received_text_'+run).html(formatMoney($('#item_quata_received_text_'+run).attr('data-amount'),2))
            $('#item_quata_remaining_text_'+run).html(formatMoney($('#item_quata_remaining_text_'+run).attr('data-amount'),2))
        }

        updateApproveSummary()
        // if(isNaN($('#wrapAmount_'+run).val()) || $('#wrapAmount_'+run).val() == ''){
        //     $(e).val('')
        // }

        // if(parseInt(val) > parseInt($('#wrapAmount_'+run).val())){
        //     $(e).val($('#wrapAmount_'+run).val())
        // }
        await checkLimitApproveItemQuota(quata,group,line,id,price,type,run)
        // await checkLimitItemQuota(quata,group,line,id,price,type,run)

    }

    async function changePrice(e) {
        var val = $(e).val()
        var id = $(e).attr('data-id')
        var run = $(e).attr('data-run')
        var quata = $(e).attr('data-quata')
        var group = $(e).attr('data-group')
        var line = $(e).attr('data-line')
        var price = formatConvertMoney($(e).val())
        $('#unit_price_'+run).val(price)
        // console.log(price)
        var type = $(e).attr('data-type')
        $('#item_price_text_'+run).html(formatMoney(price))

        if(price <= 0){
            $('#item_quata_received_text_'+run).html('0.00')
            $('#item_quata_remaining_text_'+run).html('0.00')
        }else{
            $('#item_quata_received_text_'+run).html(formatMoney($('#item_quata_received_text_'+run).attr('data-amount'),2))
            $('#item_quata_remaining_text_'+run).html(formatMoney($('#item_quata_remaining_text_'+run).attr('data-amount'),2))
        }

        await checkLimitApproveItemQuota(quata,group,line,id,price,type,run)
        // await checkLimitItemQuota(quata,group,line,id,price,type,run)


        // setTimeout(function() {
            $('#unit_price_text_'+run).val(formatMoney(price,2))
        // }, 1000);

    }

    async function checkLimitApproveItemQuota(quata,group,line,id,price,type='',run){
        var chest = $("input[name='approve_chest_amount["+quata+"]["+line+"]["+id+"]["+run+"]']").val() / 0.1;
        var wrap = $("input[name='approve_wrap_amount["+quata+"]["+line+"]["+id+"]["+run+"]']").val() * 0.2;
        // var min = $("input[name='min_amount["+quata+"]["+line+"]["+id+"]']").val();

        var sum = (chest+wrap)

        // setTimeout(function() {
            $('#order_quantity_approve_'+run).val(sum)
            $('#order_quantity_approve_text_'+run).html(formatMoney(sum,2))
            $("input[name='order_quantity_approve["+quata+"]["+line+"]["+id+"]["+run+"]']").val(sum);
        // }, 1000);

        await updateItemQuota(quata,line,id,sum,price,type,run)

        calculatorGroup(quata,line,group,id)
    }

    // async function checkLimitItemQuota(quata,group,line,id,price,type='',run){
    //     // console.log(quata,line,id)
    //     // console.log($("input[name='chest_amount["+quata+"]["+line+"]["+id+"]']").val())
    //     var chest = $("input[name='approve_chest_amount["+quata+"]["+line+"]["+id+"]["+run+"]']").val() / 0.1;
    //     var wrap = $("input[name='approve_wrap_amount["+quata+"]["+line+"]["+id+"]["+run+"]']").val() * 0.2;
    //     // var min = $("input[name='min_amount["+quata+"]["+line+"]["+id+"]']").val();
    //     // console.log(chest,wrap)
    //     var sum = (chest+wrap)

    //     // await updateItemQuota(quata,line,id,sum,price,type,run)

    //     // calculatorGroup(quata,line,group,id)

    //     // console.log(sum)
    //     // if(sum < min){
    //     //     swal("ยอดสั่งซื้อขั้นต่ำ "+min+" พันมวน");
    //     //     return false
    //     // }else{
    //         // updateItemQuota(quata,line,id,sum,price)
    //     //     return sum
    //     // }
    // }

    async function calculatorGroup(quata,line,group,id){

        // var max = $("input[name='max_amount["+quata+"]["+line+"]["+id+"]']").val();
        var sum_quota = 0
        var remaining = $(".item_quata_remaining_text_"+quata).html()
        // console.log(remaining)
        var remaining = quata_remaining[quata]

        // console.log(quata)
        $(".item_quata_use_text_"+quata).html('')
        await $('.order_quantity_approve_group_'+quata).map( function(key){
            console.log($(this).val())
            sum_quota += parseFloat($(this).val())
        })
        // console.log(sum_quota)
        // await $('.order_quantity_group_'+quata).map( function(key){
        //     // console.log($(this).val())
        //     sum_quota += parseFloat($(this).val())
        // })

        setTimeout(function() {
            $(".item_quata_use_text_"+quata).html(formatMoney(sum_quota,2))
            if(sum_quota > remaining){
                $(".item_quata_remaining_text_"+quata).html(formatMoney(0,2))
            }else{
                $(".item_quata_remaining_text_"+quata).html(formatMoney((parseFloat(remaining) - parseFloat(sum_quota)),2))
            }
        }, 1000);

        updateCredit()


        // await $('.order_quantity_'+quata+'_'+line).map( function(key){
        //     if ($('#checked_product_'+quata+'_'+line+'_'+$(this).data('id')).prop('checked')) {
        //         sum_quota += parseInt($(this).val())
        //     }
        // })

        // if(sum_quota > max){
        //     $(".total_use_quota_"+quata+"_"+line).html(formatMoney(max))
        // }else{
        //     $(".total_use_quota_"+quata+"_"+line).html(formatMoney(sum_quota))
        // }

        // var total_remaining_amount = $("input[name='total_remaining_amount["+group+"]']").val()
        // var sum_amount = await sumByGroupTotal(group,total_remaining_amount)
        // var user_group = await calculatorUseGroup(group)
        // // var sum_use_group = total_remaining_amount - sum_amount

        // updateUseGroup(user_group.sum)
        // setCredit(user_group)
    }

    async function updateCredit() {
        console.log('asdasd')
        setTimeout(async function() {
            useAmount = 0
            arrUseAmount = [];
            var remaining_amount = formatConvertMoney($('#remaining_amount').val());
            var grand = 0;
            var over_fine = parseFloat($('#over_fine_amount').val(),2)

            await $('.sum_amount_item').map( function(key){
                arrUseAmount[$(this).attr('data-group')] = 0
            })

            await $('.sum_amount_item').map( function(key){
                // console.log($(this).val())
                arrUseAmount[$(this).attr('data-group')] = arrUseAmount[$(this).attr('data-group')] + parseFloat($(this).val(),2)
                useAmount += parseFloat($(this).val(),2)
                // console.log('arrUseAmount : ' + arrUseAmount)
            })

            // console.log('useAmount : ' + useAmount)

            var amount = useAmount
            var arrAmount = arrUseAmount
            // console.log('arrAmount : ' + arrAmount)
            // console.log('arrUseAmount : ' + arrUseAmount)
            var credit_amount = 0
            var cash_amount = 0
            await $('.use_received_amount').map( function(key){

                var remaining = $(this).attr('data-remaining')

                var use_amount = $("input[name='use_amount["+$(this).attr('data-group')+"]']").val()
                // console.log(use_amount)
                var use_received_amount = $("input[name='use_received_amount["+$(this).attr('data-group')+"]']").val()
                var use_remaining_amount = $("input[name='use_remaining_amount["+$(this).attr('data-group')+"]']").val()

                // console.log(use_remaining_amount)

                if(use_remaining_amount < arrAmount[$(this).attr('data-group')]){
                    var calAmount = use_remaining_amount
                    $("input[name='use_amount["+$(this).attr('data-group')+"]']").val(use_remaining_amount)
                    credit_amount += parseFloat(use_remaining_amount,2)
                    arrAmount[$(this).attr('data-group')] -= parseFloat(calAmount,2)
                }else{


                    if(arrAmount[$(this).attr('data-group')] == undefined){
                        var calAmount = parseFloat(use_remaining_amount,2) - parseFloat(0,2)
                        $("input[name='use_amount["+$(this).attr('data-group')+"]']").val(0)
                        credit_amount += 0
                        arrAmount[$(this).attr('data-group')] -= 0
                    }else{
                        var calAmount = parseFloat(use_remaining_amount,2) - parseFloat(arrAmount[$(this).attr('data-group')],2)
                        $("input[name='use_amount["+$(this).attr('data-group')+"]']").val(arrAmount[$(this).attr('data-group')])
                        credit_amount += parseFloat(arrAmount[$(this).attr('data-group')],2)
                        arrAmount[$(this).attr('data-group')] -= parseFloat(arrAmount[$(this).attr('data-group')],2)
                    }


                    // console.log('use_remaining_amount ' + use_remaining_amount)
                    // console.log('amount ' + amount)
                    // console.log('calAmount ' + calAmount)

                }

                // console.log('amount ' + amount)
                if(arrAmount[$(this).attr('data-group')] < 0){
                    arrAmount[$(this).attr('data-group')] = 0
                }


                // if(use_remaining_amount < amount){
                //     var calAmount = use_remaining_amount
                //     $("input[name='use_amount["+$(this).attr('data-group')+"]']").val(remaining)
                //     credit_amount += remaining
                //     amount -= parseFloat(calAmount,2)
                // }else{
                //     var calAmount = parseFloat(use_remaining_amount,2) - parseFloat(amount,2)
                //     $("input[name='use_amount["+$(this).attr('data-group')+"]']").val(amount)
                //     credit_amount += amount
                //     // console.log('use_remaining_amount ' + use_remaining_amount)
                //     // console.log('amount ' + amount)
                //     // console.log('calAmount ' + calAmount)
                //     amount -= parseFloat(amount,2)
                // }

                // // console.log('amount ' + amount)
                // if(amount < 0){
                //     amount = 0
                // }

                // console.log(amount)
                // console.log($("input[name='use_amount["+$(this).attr('data-group')+"]']").val())
                // console.log($("input[name='use_received_amount["+$(this).attr('data-group')+"]']").val())
                // console.log($("input[name='use_remaining_amount["+$(this).attr('data-group')+"]']").val())
            })

            // console.log(arrAmount)
            // console.log('amount ' + amount)


            $('#credit_amount').val(formatMoney(credit_amount,2))

            // if(useAmount <= remaining_amount){
            //     $('#credit_amount').val(formatMoney(useAmount,2))
            //     grand += useAmount
            // }else{
            //     $('#credit_amount').val(formatMoney(remaining_amount,2))
            //     grand += remaining_amount
            // }
            var amount_cash = 0;
            await arrAmount.map( function(v){
                if(isNaN(v)){
                    amount_cash += 0
                }else{
                    amount_cash += v
                }
                // arrUseAmount[$(this).attr('data-group')] += parseFloat($(this).val(),2)
                // useAmount += parseFloat($(this).val(),2)
            })

            if(amount_cash > 0){
                $('#cash_amount').val(formatMoney(amount_cash,2))
                cash_amount = amount_cash
            }else{
                $('#cash_amount').val(formatMoney(0,2))
            }
            // var cash_amount = useAmount - remaining_amount;

            // if(cash_amount > 0){
            //     $('#cash_amount').val(formatMoney(cash_amount,2))
            //     grand += cash_amount
            // }else{
            //     $('#cash_amount').val(formatMoney(0,2))
            // }

            let grand_total = (parseFloat(credit_amount,2) + parseFloat(cash_amount,2));
            if(grand_total < 0){
                $('#grand_total').val(formatMoney(0))
            }else{
                $('#grand_total').val(formatMoney(grand_total,2))
            }

            let grand_total_text = ((parseFloat(cash_amount,2) + parseFloat(over_fine_amount,2)) - remaining_amount_balance);
            console.log('grand_total_text : '+over_fine_amount)
            if(grand_total_text < 0){
                $('#grand_total_text').val(formatMoney(0))
            }else{
                $('#grand_total_text').val(formatMoney(grand_total_text,2))
            }

            updatePaymentDay()
        }, 1000);
    }

    function updateItemQuota(quata,line,id,sum,price,type,run){
        if(type == 'create'){
            // $(".order_quantity_text_"+quata+"_"+line+"_"+id+"_"+run).html(formatMoney(sum,2))
            // $("input[name='order_quantity["+quata+"]["+line+"]["+id+"]["+run+"]']").val(sum);
        }

        $(".sum_amount_text_"+quata+"_"+line+"_"+id+"_"+run).html(formatMoney((sum * price),2))

        // $(".total_sum_quota_"+quata+"_"+line+"_"+id).html(formatMoney(sum * price))
        $("input[name='sum_amount["+quata+"]["+line+"]["+id+"]["+run+"]']").val(sum * price);
    }

    async function updatePaymentDay() {

        var count_day_amount = 0
        await $('.use_received_amount').map( function(key){
            // console.log($(this).attr('data-group'));
            var dateth = $('.day_amount_amount_'+$(this).attr('data-group')).attr('data-dateth')
            var amount = $("input[name='use_amount["+$(this).attr('data-group')+"]']").val();
            $('.day_amount_amount_'+$(this).attr('data-group')).html(formatMoney((amount),2))

            console.log('updatePaymentDay', amount, dateth, $('.day_amount_amount_'+$(this).attr('data-group')))
            if(amount > 0){
                $('.day_amount_'+$(this).attr('data-group')).css('display','table-row')
                $('#payment_duedate').val(dateth)
                count_day_amount += 1;
            }else{
                $('.day_amount_'+$(this).attr('data-group')).css('display','none')
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
        //     console.log($(this).attr('data-group'));
        // })
    }

    function viewDayAmount() {
        $('#datePaymentModal').modal('show')
    }

    function viewOutstanding() {
        $('#Outstanding').modal('show')
    }
    
    function verifyData() {
        // Defined
        let items = $('[name*="item_id"]')
        
        // Check value
        _.each(items, function(item) {
            let ref_id = $(item).attr('data-id')
            if($(item).val() != '') {
                if($('[id="chestAmount_'+ref_id+'"]').val() == '' && $('[id="wrapAmount_'+ref_id+'"]').val() == '' ) {
                    throw new Error('ข้อมูลจำนวนที่สั่ง ไม่ได้กรอกข้อมูล');
                }

                if($('[id="approveChestAmount_'+ref_id+'"]').val() == '' && $('[id="approveWrapAmount_'+ref_id+'"]').val() == '' ) {
                    throw new Error('ข้อมูลจำนวนที่อนุมัติสั่ง ไม่ได้กรอกข้อมูล');
                }
            }
        })
    }


    $("#btn_save").click(async function() {
        $('#form_type').val('save')
        try {
            verifyData();
        } catch (error) {
            swal.fire({
                title:'แจ้งเตือน',
                text: error.message,
                icon:'error'
            })
            return false;
        }
        message_alert = 'ต้องการบันทึกข้อมูลใช่หรือไม่'
        $("#form-order").submit()
    });

    $("#btn_confirm").click(async function() {
        $('#form_type').val('confirm')
        try {
            verifyData();
        } catch (error) {
            swal.fire({
                title:'แจ้งเตือน',
                text: error.message,
                icon:'error'
            })
            return false;
        }
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
                console.log('setDayAmount', result.data.dayAmount)

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


            if (isItem == false) {
                Swal.fire({
                    title: 'เกิดข้อผิดพลาด',
                    text: "กรุณาสร้างรายการสินค้า",
                    icon: 'warning',
                    showConfirmButton: false,
                    timer: 3000
                });
            }else if($('#customer_number').val() == ''){
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
                                console.log(result)
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
