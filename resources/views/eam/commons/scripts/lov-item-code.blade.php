<script>
    var dataLovItemCode             = [];
    var idLovItemCode               = '';
    var idLovItemCodeDesc           = '';
    var idLovItemCodeTable          = '';
    var inModalItemCode             = false;
    var url                         = '';
    var thisLovItemInventory        = '';
    var thisLovItemInventoryDesc    = '';
    var thisLovItemInventoryDesc2   = '';
    var dataItemCode                = [];

    function itemInventory(data) {
        thisLovItemInventory        = data.data1;
        thisLovItemInventoryDesc    = data.data2;
        thisLovItemInventoryDesc2   = data.data3;
        lovItemCode('0');
    }

    function lovItemCode(data) {
        url = data == '0' ? "{{ route('eam.ajax.lov.item-inventory') }}" :
            "{{ route('eam.ajax.lov.item-nonstock') }}"
        $.ajax({
            url: url,
            method: 'GET',
            success: function(response) {
                $("#detailItemCodeLov").modal('show');
                $("#modalItemCodeSearchItemCode").val('');
                $("#modalItemCodeSearchItemDescription").val('');
                $("#modalItemCodeSearchItemPartNumber").val('');
                $("#modalItemCodeSearchOldItemNumber").val('');
                $("#modalItemCodeSearchPartNumberOld").val('');
                $("#modalItemCodeSearchMachine01").val('');
                $("#modalItemCodeSearchMachine02").val('');
                dataLovItemCode = response.original.data;
                setLovItemCodeFn(response.original);
            },
            error: function(jqXHR, textStatus, errorRhrown) {
                swal("Error", jqXHR.responseJSON.message, "error");
            }
        })
    }

    function itemCodeLovBtnTableOnclick(data) {
        idLovItemCodeTable = data
        lovItemCode(0)
    }

    function itemCodeNonLovBtnTableOnclick(data) {
        idLovItemCodeTable = data
        lovItemCode(2)
    }

    function itemCodeLovBtnOnclick(data) {
        $("#nameLovItemCode").html(data.nameItemCodeModal)
        idLovItemCode = data.idItemCodeModal
        if (data.desc) {
            idLovItemCodeDesc = data.idItemCodeModal + 'Desc'
        } else {
            idLovItemCodeDesc = ''
        }
        inModalItemCode = data.inModal
        idLovItemCodeTable = ''
        lovItemCode('0');
    }

    function itemCodeNonStockLovBtnOnclick(data) {
        $("#nameLovItemCode").html(data.nameItemCodeModal)
        idLovItemCode = data.idItemCodeModal
        if (data.desc) {
            idLovItemCodeDesc = data.idItemCodeModal + 'Desc'
        } else {
            idLovItemCodeDesc = ''
        }
        inModalItemCode = data.inModal
        idLovItemCodeTable = ''
        lovItemCode('1');
    }
    $("#modalSearchItemCodeLov").click(() => {
        $.ajax({
            url: url,
            method: 'GET',
            data: {
                'item_code': $("#modalItemCodeSearchItemCode").val(),
                'item_description': $("#modalItemCodeSearchItemDescription").val(),
                'part_number': $("#modalItemCodeSearchItemPartNumber").val(),
                'old_item_number': $("#modalItemCodeSearchOldItemNumber").val(),
                'part_number_old': $("#modalItemCodeSearchPartNumberOld").val(),
                'machine_01': $("#modalItemCodeSearchMachine01").val(),
                'machine_02': $("#modalItemCodeSearchMachine02").val(),
                'subinventory': $("#modalItemCodeSearchSubinventory").val(),
                'locator_name': $("#modalItemCodeSearchLocator").val(),
            },
            success: function(response) {
                dataLovItemCode = response.original.data;
                if (response.original.data.length < 1) {
                    swal("ค้นหาข้อมูลไม่พบ", "", "warning");
                    $("#setLovItemCode").html('');
                    $('#setLovItemCodePagination').html('');
                } else {
                    setLovItemCodeFn(response.original);
                }
            },
            error: function(jqXHR, textStatus, errorRhrown) {
                swal("Error", jqXHR.responseJSON.message, "error");
            }
        })
    })

    function setLovItemCodeFn(data) {
        let theadLovItemCode = ''
        if (data.data.length > 0) {
            data.data.filter(row => {
                theadLovItemCode += `<tr>`
                theadLovItemCode += `<td class="pointer" onclick="setDataLovItemCode('` + row.item_code +
                    `')">${row.item_code ? row.item_code : ''}</td>`
                theadLovItemCode += `<td class="pointer" onclick="setDataLovItemCode('` + row.item_code +
                    `')">${row.item_description ? row.item_description : ''}</td>`
                theadLovItemCode += `<td class="pointer" onclick="setDataLovItemCode('` + row.item_code +
                    `')">${row.part_number ? row.part_number : ''}</td>`
                theadLovItemCode += `<td class="pointer" onclick="setDataLovItemCode('` + row.item_code +
                    `')">${row.old_item_number ? row.old_item_number : ''}</td>`
                theadLovItemCode += `<td class="pointer" onclick="setDataLovItemCode('` + row.item_code +
                    `')">${row.part_number_old ? row.part_number_old : ''}</td>`
                theadLovItemCode += `<td class="pointer" onclick="setDataLovItemCode('` + row.item_code +
                    `')">${row.machine_01 ? row.machine_01 : ''}</td>`
                theadLovItemCode += `<td class="pointer" onclick="setDataLovItemCode('` + row.item_code +
                    `')">${row.machine_02 ? row.machine_02 : ''}</td>`
                theadLovItemCode += `<td class="pointer" onclick="setDataLovItemCode('` + row.item_code +
                    `')">${row.subinventory ? row.subinventory : ''}</td>`
                theadLovItemCode += `<td class="pointer" onclick="setDataLovItemCode('` + row.item_code +
                    `')">${row.locator_name ? row.locator_name : ''}</td>`
                theadLovItemCode += `</tr>`
            })
        }
        $("#setLovItemCode").html(theadLovItemCode);

        let html = '<ul class="pagination float-right">';
        $.each(data.links, function(i, link) {
            html +=
                `<li class="footable-page ${link.active ? 'active' : ''}"><a onclick="searchLovItemCodePagination('` +
                link.url + `')">${link.label}</a></li>`
        });
        html += '</ul>';
        $('#setLovItemCodePagination').html(html);
    }

    function searchLovItemCodePagination(data) {
        if (data != 'null') {
            $.ajax({
                url: data,
                method: 'GET',
                data: {
                    'item_code': $("#modalItemCodeSearchItemCode").val(),
                    'item_description': $("#modalItemCodeSearchItemDescription").val(),
                    'part_number': $("#modalItemCodeSearchItemPartNumber").val(),
                    'old_item_number': $("#modalItemCodeSearchOldItemNumber").val(),
                    'part_number_old': $("#modalItemCodeSearchPartNumberOld").val(),
                    'machine_01': $("#modalItemCodeSearchMachine01").val(),
                    'machine_02': $("#modalItemCodeSearchMachine02").val(),
                    'subinventory': $("#modalItemCodeSearchSubinventory").val(),
                    'locator_name': $("#modalItemCodeSearchLocator").val(),
                },
                success: function(response) {
                    dataLovItemCode = response.original.data;
                    if (response.original.data.length < 1) {
                        swal("ค้นหาข้อมูลไม่พบ", "", "warning");
                        $("#setLovItemCode").html('');
                        $('#setLovItemCodePagination').html('');
                    } else {
                        setLovItemCodeFn(response.original);
                    }
                },
                error: function(jqXHR, textStatus, errorRhrown) {
                    swal("Error", jqXHR.responseJSON.message, "error");
                }
            })
        }
    }

    function setDataLovItemCode(data) {
        $("#detailItemCodeLov").modal('hide');
        for (const row of dataLovItemCode) {
            if (row.item_code == data) {
                if (thisLovItemInventory != '') {
                    if (thisLovItemInventoryDesc == 'td:eq(2)') {
                        $(thisLovItemInventory).parents('tr').find("td:eq(2) input[type='text']").val(row.item_description);
                    }

                    if (thisLovItemInventoryDesc2 == 'td:eq(8)') {
                        $(thisLovItemInventory).parents('tr').find("td:eq(8) select").html(
                            `<option value="${row.primary_uom}">${row.primary_uom}</option>`);
                        $(thisLovItemInventory).parents('tr').find("td:eq(10) input[type='text']").val(row.inventory_item_id);
                    }

                    var newOption = new Option(row.item_code, row.item_code, true, true);
                    $(thisLovItemInventory).parents('div.input-group').find("select").append(newOption).trigger('change');
                    $(thisLovItemInventory).parents('div.input-group').find("select").trigger('change');
                    $(thisLovItemInventory).parents('div.input-group').find("select").val(row.item_code);

                } else {
                    if (idLovItemCode) {
                        if (idLovItemCodeDesc) {
                            $("#" + idLovItemCode).val(row.item_code);
                            $("#" + idLovItemCodeDesc).val(row.item_description);
                        } else {
                            $("#" + idLovItemCode).val(row.item_code + ' - ' + row.item_description);
                        }
                    } else {
                        if ($("#" + idLovItemCodeTable).parents('tr').find("td:eq(2) select").val() == '0') {
                            if($("#"+idLovItemCodeTable).is('select')) {
                                var newOption = new Option(row.item_code, row.item_code, true, true);
                                $('#'+idLovItemCodeTable).append(newOption).trigger('change');
                                $('#'+idLovItemCodeTable).trigger('change');
                                $('#'+idLovItemCodeTable).val(row.item_code).trigger('change');
                            } else {
                                $("#"+idLovItemCodeTable).val(row.item_code);
                            }
                            
                            $("#" + idLovItemCodeTable) .parents('tr')
                                                        .find("td:eq(4) input[type='text']").val(row.item_description);
                            $("#" + idLovItemCodeTable) .parents('tr')
                                                        .find("td:eq(9) select")
                                                        .html(`<option value="${row.primary_uom}">${row.primary_uom}</option>`);
                            $("#" + idLovItemCodeTable) .parents('tr')
                                                        .find("td:eq(19) input[type='text']")
                                                        .val(row.inventory_item_id)
                            if ($("#" + idLovItemCodeTable).parents('tr').find("td:eq(2) select").val() == '0') {
                                let itemCost = $("#" + idLovItemCodeTable).parents('tr').find("td:eq(10) input[type='text']")
                                $.ajax({
                                    url: "{{ route('eam.ajax.work-order.itemcost.get') }}",
                                    method: 'GET',
                                    data: {
                                        'p_item_code': data
                                    },
                                    success: function(response) {
                                        if (response) {
                                            itemCost.val(response.data ? response.data.item_cost : '');
                                        }
                                    },
                                    error: function(jqXHR, textStatus, errorRhrown) {
                                        swal("Error", jqXHR.responseJSON.message, "error");
                                    }
                                })
                            }

                            if($("#" + idLovItemCodeTable).parents('tr').find("td:eq(1) select").val()){
                                let operationSeqNum = $("#" + idLovItemCodeTable).parents('tr').find("td:eq(1) select").val();
                                $.ajax({
                                    url: "{{ route('eam.ajax.work-order.mtCheckCutThroughWMS') }}",
                                    method: 'POST',
                                    headers: {
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                    },
                                    data: JSON.stringify({
                                        p_operation_seq_num: operationSeqNum,
                                        p_wip_entity_id: wip_entity_id
                                    }),   
                                    success: function(response) {
                                        if (response) {
                                            if(response.data == 'Yes'){
                                                $("#" + idLovItemCodeTable).parents('tr').find("td:eq(5) input[type='checkbox']").prop('checked', true);
                                                $("#" + idLovItemCodeTable).parents('tr').find("td:eq(5) input[type='checkbox']").val(response.data);
                                                $("#" + idLovItemCodeTable).parents('tr').find("td:eq(11) select").prop('disabled', true);
                                                $("#" + idLovItemCodeTable).parents('tr').find("td:eq(12) select").prop('disabled', true);
                                            }else{
                                                $("#" + idLovItemCodeTable).parents('tr').find("td:eq(5) input[type='checkbox']").prop('checked', false);
                                                $("#" + idLovItemCodeTable).parents('tr').find("td:eq(5) input[type='checkbox']").val(response.data);
                                                $("#" + idLovItemCodeTable).parents('tr').find("td:eq(11) select").prop('disabled', false);
                                                $("#" + idLovItemCodeTable).parents('tr').find("td:eq(12) select").prop('disabled', false);
                                            }
                                        }
                                    },
                                    error: function(jqXHR, textStatus, errorRhrown) {
                                        swal("Error", jqXHR.responseJSON.message, "error");
                                    }
                                })                                
                            }
                        } else {
                            $("#" + idLovItemCodeTable).val(row.item_code);
                            $("#" + idLovItemCodeTable) .parents('tr')
                                                        .find("td:eq(4) input[type='text']")
                                                        .val(row.item_description);
                            $("#" + idLovItemCodeTable) .parents('tr')
                                                        .find("td:eq(6) select")
                                                        .html(`<option value="${row.primary_uom}">${row.primary_uom}</option>`);
                            $("#" + idLovItemCodeTable) .parents('tr')
                                                        .find("td:eq(26) input[type='text']")
                                                        .val(row.inventory_item_id);
                        }
                        
                        if($("#"+idLovItemCodeTable).is('select')) {
                            var newOption = new Option(row.item_code, row.item_code, true, true);
                            $('#'+idLovItemCodeTable).append(newOption).trigger('change');
                            $('#'+idLovItemCodeTable).trigger('change');
                            $('#'+idLovItemCodeTable).val(row.item_code).trigger('change');
                        } else {
                            $("#"+idLovItemCodeTable).val(row.item_code);
                        }
                    }                    
                }
                break
            }
        }
    }

    function clearDescItemCode(data) {
        data.parents('tr').find("td:eq(4) input[type='text']").val('');
        data.parents('tr').find("td:eq(7) select").html(`<option value=""></option>`);
    }
    $("#detailItemCodeLov").on('hidden.bs.modal', () => {
        if (inModalItemCode) {
            $('body').addClass('modal-open')
            inModalItemCode = false
        }
    })
</script>

<script>
    loadSubinventory();
    loadLocator();

    $('.js-example-basic-single').select2({
        dropdownParent: $('#detailItemCodeLov'),
        width: '100%',
    });

    function loadSubinventory() {
        $.ajax({
            url: "{{ route('eam.ajax.lov.get-subinventory') }}",
            method: 'GET',
            success: function(response) {
                let optionSuvinventory = '';
                optionSuvinventory += `<option value=""></option>`
                for (let data of response.data) {
                    optionSuvinventory += `<option value="${data.name}">${data.name}</option>`;
                }
                $('#modalItemCodeSearchSubinventory').html(optionSuvinventory);
            },
            error: function(jqXHR, textStatus, errorRhrown) {
                swal("Error", jqXHR.responseJSON.message, "error");
            }
        });
    }

    function loadLocator() {
        $.ajax({
            url: "{{ route('eam.ajax.lov.get-locator') }}",
            method: 'GET',
            success: function(response) {
                let optionLocator = '';
                optionLocator += `<option value=""></option>`
                for (let data of response.data) {
                    optionLocator +=
                        `<option value="${data.subinventory_name + '.' + data.locator_name}">${data.subinventory_name + '.' + data.locator_name}</option>`;
                }
                $('#modalItemCodeSearchLocator').html(optionLocator);
            },
            error: function(jqXHR, textStatus, errorRhrown) {
                swal("Error", jqXHR.responseJSON.message, "error");
            }
        });
    }

    $('#modalItemCodeSearchSubinventory').on('select2:select', function(e) {
        let id = e.params.data.id;
        $.ajax({
            url: "{{ route('eam.ajax.lov.get-locator') }}",
            method: 'GET',
            success: function(response) {
                let optionLocator = '';
                let data1 = response.data;

                data1 = data1.filter(x => {
                    return x.subinventory_name == id
                });
                optionLocator += `<option value=""></option>`
                for (let data of data1) {
                    optionLocator +=
                        `<option value="${data.subinventory_name + '.' + data.locator_name}">${data.subinventory_name + '.' + data.locator_name}</option>`;
                }
                $('#modalItemCodeSearchLocator').html(optionLocator);
            },
            error: function(jqXHR, textStatus, errorRhrown) {
                swal("Error", jqXHR.responseJSON.message, "error");
            }
        });
    });

    function dataListItemCode() {
      $.ajax({
        url: "{{ route('eam.ajax.lov.item-inventory') }}",
        method: 'GET',
        success: function (response) {
            dataItemCode = response.original.data;
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    }
</script>
