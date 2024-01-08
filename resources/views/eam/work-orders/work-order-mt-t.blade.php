<script>
  let checkConfirmMtSuccess = true; // ยืนยันการบันทึกอะไหล่เสร็จเรียบร้อย
  var idReMaterial = '';
  var maxSeq = '';

  async function workOrderMtAll(status) {
    $("#savePartBtnCheckBox").prop('checked', false).prop('disabled', true);
    await $.ajax({
      url: "{{ route('eam.ajax.work-order.mt.all',['']) }}/" + wip_entity_id,
      method: 'GET',
      success: function (response) {
        if (response.data.length > 0) {
          setTableSavePartFn({response: response, status: status});
        } else {
          setDefaultTableSavePartFn()
        }
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
     await checkConfirmMt()
  }

  function setTableSavePartFn(response) {
    let data                = response.response;
    let status              = response.status;
    let sum10               = 0;
    let indexShow           = 10;
    let tbodyTableSavePart  = '';
    if (data.data.length > 0) {
      data.data.filter(row => {
        maxSeq = Math.max(row.attribute9);
        if ($("#savePartBtnCheckBox").prop('disabled') != true) {
          if (row.quantity_issued == '') {
            $("#savePartBtnCheckBox").prop('disabled', true);
          }
        }
        $("#checkboxAllTable").prop('disabled', false);
        let optionWorkOrder = ''
          optionWorkOrder += `<option value=""></option>`
        for (let data of dataDropDownWorkOrder) {
          optionWorkOrder += `<option value="${data.operation_seq_num}" 
                                      ${row.operation_seq_num == data.operation_seq_num ? 'selected' : ''}>
                                      ${data.operation_seq_num}
                              </option>`
        }
        let optionItemType = ''
          optionItemType += `<option value=""></option>`
        for (let data of dataDropDownItemType) {
          if (data.lookup_code == 0) {
            optionItemType += `<option  value="${data.lookup_code}" 
                                        ${data.lookup_code == 0 ? 'selected' : ''}>
                                        ${data.meaning}
                              </option>`
          }
        }
        let optionSuvinventory = ''
          optionSuvinventory += `<option value=""></option>`
        for (let data of dataDropDownSubinventory) {
          optionSuvinventory += `<option  value="${data.name}" 
                                          ${row.supply_subinventory == data.name ? 'selected' : ''}>
                                          ${data.name}
                                </option>`
        }
        let optionLocator = ''
          optionLocator += `<option value=""></option>`
        for (let data of dataDropDownLocator) {
          if (data.subinventory_name == row.supply_subinventory) {
            optionLocator += `<option value="${data.locator_name}" 
                                      ${row.supply_locator_code == data.locator_name ? 'selected' : ''}>
                                      ${data.subinventory_name}.${data.locator_name}
                              </option>`
          }
        }
        tbodyTableSavePart += `<tr>`
        tbodyTableSavePart += `<td class="text-center">
                                  <input  type="checkbox" 
                                          onclick="checkBoxOnClick()" 
                                          name="case[]" 
                                          ${statusDisabledMt ? 'disabled' : ''}
                                          ${row.quantity_issued == row.required_quantity ? 'disabled' : ''}>
                                  <input type="hidden" class="sum10" value="${+sum10 + 10}">
                              </td>`
        tbodyTableSavePart += `<td><select  class="form-control workOrderTbMT" 
                                            required 
                                            disabled>`+optionWorkOrder+`</select></td>`
        tbodyTableSavePart += `<td><select  class="form-control itemTypeTbMT" 
                                            required 
                                            disabled>`+optionItemType+`</select></td>`
        tbodyTableSavePart += `<td>
                                <div class="input-group">
                                  <select id="itemCode${+sum10 + 10}" 
                                          name="item_code" 
                                          class="itemCode form-control readonly" 
                                          data-server="/eam/ajax/lov/item-inventory"  
                                          data-id="item_code" 
                                          data-field="select"
                                          required
                                          disabled>
                                  </select>
                                  <div class="input-group-append">
                                    <span class="input-group-append">
                                      <button onclick="itemCodeLovBtnTableOnclick('itemCode${+sum10 + 10}')" type="button" class="btn btn-default" disabled><i class="fa fa-search"></i></button>
                                    </span>
                                  </div>
                                </div>
                              </td>`
        tbodyTableSavePart += `<td><input type="text" id="item_desc_${+sum10 + 10}"
                                          class="form-control" 
                                          value="" 
                                          required 
                                          ${row.item_type_id == '0' ? 'disabled' : ''} 
                                          autocomplete="off">
                              </td>`
        tbodyTableSavePart += `<td style="text-align: center; vertical-align: middle;">
                                <input  type="checkbox" 
                                        id="check${+sum10 + 10}"
                                        ${row.attribute6 == null ? '' : 'disabled'}
                                        ${row.wms_issue == 'Yes' ? 'checked' : ''} 
                                        value=${row.wms_issue}
                                        onclick="handleClick(this)">
                              </td>`
        tbodyTableSavePart += `<td>
                                  <input  onkeypress="return /[0-9\-]/i.test(event.key)" 
                                          type="text" 
                                          class="form-control" 
                                          value="${row.required_quantity ? row.required_quantity : ''}" 
                                          required 
                                          autocomplete="off" 
                                          ${row.attribute6 == null ? '' : 'disabled'}>
                                </td>`
        tbodyTableSavePart += `<td>
                                  <input  type="text" 
                                          class="form-control" 
                                          value="${row.attribute6 ? row.attribute6 : ''}" 
                                          disabled 
                                          autocomplete="off">
                                </td>`
        tbodyTableSavePart += `<td>
                                  <input  type="text" 
                                          class="form-control" 
                                          value="${row.quantity_issued ? row.quantity_issued : ''}" 
                                          disabled
                                          autocomplete="off">
                              </td>`
        tbodyTableSavePart += `<td>
                                  <select class="form-control" 
                                          required 
                                          disabled>
                                    <option value="${row.item_primary_uom_code ? row.item_primary_uom_code : ''}">
                                      ${row.item_primary_uom_code ? row.item_primary_uom_code : ''}
                                    </option>
                                  </select>
                              </td>`
        tbodyTableSavePart += `<td>
                                  <input  type="text" 
                                          class="form-control" 
                                          value="${row.unit_price ? row.unit_price : '0'}" 
                                          ${statusDisabledMt ? 'disabled' : row.item_type_id == '0' ? 'disabled' : ''} 
                                          autocomplete="off">
                              </td>`
        tbodyTableSavePart += `<td>
                                    <select class="form-control subinventoryTbMT" 
                                            ${row.wms_issue == 'Yes' ? 'disabled' : ''}>
                                            `+optionSuvinventory+`
                                    </select>
                                </td>`
        tbodyTableSavePart += `<td>
                                  <select class="form-control locatorTbMT"
                                          ${row.wms_issue == 'Yes' ? 'disabled' : ''}>
                                          `+optionLocator+`
                                  </select>
                              </td>`
        tbodyTableSavePart += `<td>
                                  <input  type="text" 
                                          class="form-control" 
                                          value="${row.quantity_on_hand ? row.quantity_on_hand : ''}" 
                                          disabled 
                                          autocomplete="off">
                              </td>`
        tbodyTableSavePart += `<td class="d-none">
                                  <input  type="text" 
                                          class="form-control" 
                                          value="${row.pr_number ? row.pr_number : ''}" 
                                          hidden 
                                          disabled 
                                          autocomplete="off">
                              </td>`
        tbodyTableSavePart += `<td class="d-none">
                                  <input  type="text" 
                                          class="form-control" 
                                          value="${row.po_number ? row.po_number : ''}" 
                                          hidden 
                                          disabled 
                                          autocomplete="off">
                              </td>`
        tbodyTableSavePart += `<td class="d-none">
                                  <input  type="text" 
                                          class="form-control" 
                                          value="${row.received_qty ? row.received_qty : ''}" 
                                          hidden 
                                          disabled 
                                          autocomplete="off">
                              </td>`
        tbodyTableSavePart += `<td class="${statusDisabledMt ? 'd-none' : status && row.item_type_id == '0' ? '' : 'd-none'}">
                                <button onclick="setDataLovTableSavePart('itemCode${+sum10 + 10}')" 
                                        type="button" 
                                        ${statusDisabledMt ? 'disabled' : status && row.item_type_id == '0' ? '' : 'disabled'} 
                                        ${!row.quantity_issued ? 'disabled' : ''} class="btn btn-primary btn-sm">
                                        คืนอะไหล่
                                </button>
                              </td>`
        tbodyTableSavePart += `<td class="d-none">
                                  <input  type="text" 
                                          value="${row.material_id ? row.material_id : ''}" 
                                          hidden 
                                          autocomplete="off">
                              </td>`
        tbodyTableSavePart += `<td class="d-none">
                                  <input  type="text" 
                                          value="${row.inventory_item_id ? row.inventory_item_id : ''}" 
                                          hidden 
                                          autocomplete="off">
                              </td>`
        tbodyTableSavePart += `<td class="d-none">
                                  <input  type="text" 
                                          class="form-control" 
                                          value="" 
                                          hidden 
                                          autocomplete="off">
                              </td>`
        tbodyTableSavePart += `<td class="d-none">
                                  <input  type="text" 
                                          class="form-control" 
                                          value="${row.attribute9 ? row.attribute9 : 1}" 
                                          hidden 
                                          autocomplete="off">
                              </td>`
        tbodyTableSavePart += `</tr>`
        sum10 += 10
      })
    }
    $("#setTbodyTableSavePart").html(tbodyTableSavePart);
    changItemType();
    changSubinventory();
    changLocator();
    readonly();   
    setSelect2InEAM0010TbodyTableSavePart();
    triggerSelect2InEAM0010();

    sum10 = 0;
    data.data.filter(row => {
      $(`#item_desc_${+sum10 + 10}`).val(row.item_description ? row.item_description : '').trigger('change');
      sum10 += 10;
      //Default Item Type
      var newOptionItemCode = new Option(row.item_code, row.item_code, true, true);
      $(`#itemCode${indexShow}`).append(newOptionItemCode).trigger('change');
      $(`#itemCode${indexShow}`).val(row.item_code ? row.item_code : '').trigger('change');
      
      let onHand = $(`#itemCode${indexShow}`).parents('tr').find("td:eq(13) input[type='text']");
      let itemCode = $(`#itemCode${indexShow}`).val();
      let subinventory = $(`#itemCode${indexShow}`).parents('tr').find("td:eq(11) select").val();
      $.ajax({
        url: "{{ route('eam.ajax.work-order.itemonhand.get') }}",
        method: 'GET',
        data: {
          'p_subinventory_name':  subinventory,
          'p_locator_name':       '',
          'p_item_code':          itemCode
        },
        success: function (response) {
          onHand.val('');
          let total = 0
          response.data.filter((row)=>{
            total += +row.on_hand
          })
          onHand.val(total);
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
      indexShow += 10
    }) 
  }

  $("#addSavePartBtn").click(() => {
    setAddTableSavePartFn()
  })

  function setAddTableSavePartFn() {
    let sum10       = 0;
    let listData    = [];
    let listData2   = [];
    let maxVal      = 0;

    if(maxSeq == 0){
      maxSeq = 4;
    }else{
      maxSeq += 1;
    }

    $("#setTbodyTableSavePart td .sum10").each(function() {
      if ($(this).val() > maxVal) {
        maxVal = $(this).val()
      }
      sum10 += 10
      listData.push(parseInt(sum10))
      listData2.push(parseInt($(this).val()))
    })

    if (sum10 != maxVal) {
      var result = [];
        listData2.filter((row2)=>{
          const index = listData.indexOf(row2);
          if (index > -1) {
            listData.splice(index, 1);
          }
        })
      sum10 = (listData[0] - 10)
    }

    let optionWorkOrder = '';
      optionWorkOrder += `<option value=""></option>`
    for (let data of dataDropDownWorkOrder) {
      optionWorkOrder += `<option value="${data.operation_seq_num}" 
                                  ${'10' == data.operation_seq_num ? 'selected' : ''}>
                                  ${data.operation_seq_num}
                          </option>`
    }

    let optionItemType = '';
      optionItemType += `<option value=""></option>`
    for (let data of dataDropDownItemType) {
      if (data.lookup_code == 0) {
        optionItemType += `<option  value="${data.lookup_code}" 
                                    ${data.lookup_code == 0 ? 'selected' : ''}>
                                    ${data.meaning}
                          </option>`
      }
    }

    let optionSuvinventory = '';
      optionSuvinventory += `<option value=""></option>`
    for (let data of dataDropDownSubinventory) {
      optionSuvinventory += `<option value="${data.name}">${data.name}</option>`
    }

    let optionLocator = `<option value=""></option>`
    let tbodyTableSavePart = ''
    tbodyTableSavePart += `<tr>`
    tbodyTableSavePart += `<td class="text-center">
                              <input type="checkbox" onclick="checkBoxOnClick()" name="case[]">
                              <input type="hidden" class="sum10" value="${+sum10 + 10}">
                          </td>`
    tbodyTableSavePart += `<td>
                              <select class="form-control workOrderTbMT" required >`+optionWorkOrder+`</select>
                          </td>`
    tbodyTableSavePart += `<td>
                              <select class="form-control itemTypeTbMT" required disabled>`+optionItemType+`</select>
                          </td>`
    tbodyTableSavePart += `<td>
                            <div class="input-group">
                              <select id="itemCode${+sum10 + 10}" 
                                      name="item_code" 
                                      class="itemCode form-control clearable readonly"
                                      data-server="/eam/ajax/lov/item-inventory"  
                                      data-id="item_code" 
                                      data-field="select"
                                      required
                                      data-setAjaxDetailItemCode = "itemCode${+sum10 + 10}"
                                      data-typeAjaxDetailItemCode = "itemCode${+sum10 + 10}">
                              </select>
                              <div class="input-group-append">
                                <span class="input-group-append">
                                  <button onclick="itemCodeLovBtnTableOnclick('itemCode${+sum10 + 10}')" 
                                          type="button" 
                                          class="btn btn-default">
                                          <i class="fa fa-search"></i>
                                  </button>
                                </span>
                              </div>
                            </div>
                          </td>`
    tbodyTableSavePart += `<td><input id="itemCodeDesc${+sum10 + 10}" 
                                      type="text" 
                                      class="form-control" 
                                      value="" 
                                      required 
                                      disabled 
                                      autocomplete="off"></td>`
    tbodyTableSavePart += `<td style="text-align: center; vertical-align: middle;">
                            <input  type="checkbox" 
                                    id="checkbox${+sum10 + 10}"
                                    onclick="handleClick(this)">
                          </td>`                         
    tbodyTableSavePart += `<td>
                              <input  onkeypress="return /[0-9\-]/i.test(event.key)" 
                                      type="text" 
                                      class="form-control" 
                                      value="" 
                                      required 
                                      autocomplete="off">
                          </td>`
    tbodyTableSavePart += `<td>
                              <input  type="text" 
                                      class="form-control" 
                                      value="" 
                                      disabled 
                                      autocomplete="off">
                          </td>`
    tbodyTableSavePart += `<td>
                              <input  type="text" 
                                      class="form-control" 
                                      value="" disabled 
                                      autocomplete="off">
                          </td>`
    tbodyTableSavePart += `<td>
                              <select class="form-control" 
                                      required 
                                      disabled>
                              </select>
                          </td>`
    tbodyTableSavePart += `<td>
                              <input  type="text" 
                                      class="form-control" 
                                      value="" 
                                      autocomplete="off" 
                                      disabled>
                          </td>`
    tbodyTableSavePart += `<td>
                              <select class="form-control subinventoryTbMT" >`+optionSuvinventory+`</select>
                          </td>`
    tbodyTableSavePart += `<td>
                              <select class="form-control locatorTbMT">`+optionLocator+`</select>
                          </td>`
    tbodyTableSavePart += `<td>
                              <input  type="text" 
                                      class="form-control" 
                                      value="" 
                                      disabled 
                                      autocomplete="off">
                          </td>`
    tbodyTableSavePart += `<td class="d-none">
                              <input type="text" class="form-control" value="" disabled autocomplete="off">
                          </td>`
    tbodyTableSavePart += `<td class="d-none">
                              <input type="text" class="form-control" value="" disabled autocomplete="off">
                          </td>`
    tbodyTableSavePart += `<td class="d-none">
                              <input type="text" class="form-control" value="" disabled autocomplete="off">
                          </td>`
    tbodyTableSavePart += `<td class="d-none">
                              <button onclick="setDataLovTableSavePart('itemCode${+sum10 + 10}')" 
                                      disabled 
                                      type="button" 
                                      class="btn btn-primary btn-sm"> คืนอะไหล่ 
                              </button>
                          </td>`
    tbodyTableSavePart += `<td class="d-none">
                              <input  type="text" 
                                      value="" 
                                      hidden 
                                      autocomplete="off">
                          </td>`
    tbodyTableSavePart += `<td class="d-none">
                              <input  type="text" 
                                      value="" 
                                      hidden 
                                      autocomplete="off">
                          </td>`
    tbodyTableSavePart += `<td class="d-none">
                              <input  type="text" 
                                      class="form-control" 
                                      value="add" 
                                      hidden 
                                      autocomplete="off">
                          </td>`
    tbodyTableSavePart += `<td class="d-none">
                              <input  type="text" 
                                      class="form-control" 
                                      value="${maxSeq}" 
                                      hidden 
                                      autocomplete="off">
                          </td>`
    tbodyTableSavePart += `</tr>`
    $("#setTbodyTableSavePart").append(tbodyTableSavePart);
    changItemType();
    changSubinventory();
    changLocator();
    readonly();
    setSelect2InEAM0010TbodyTableSavePart();
    triggerSelect2InEAM0010();

    $(`#itemCode${+sum10 + 10}`).on('select2:select', function (e) {
      $(this).select2('data')[0].text = $(this).select2('data')[0].id;
    });

    $(`#itemCode${+sum10 + 10}`).on('select2:clear', function (e) {
      $(`#itemCodeDesc${+sum10 + 10}`).val('');
      $(`#itemCode${+sum10 + 10}`).parents('tr')
                                  .find("td:eq(8) select")
                                  .html('');
      $(`#itemCode${+sum10 + 10}`).parents('tr').find("td:eq(9) input[type='text']").val('');
      $(`#itemCode${+sum10 + 10}`).parents('tr')
                                  .find("td:eq(18) input[type='text']")
                                  .val('')
    });
  }

  function setDefaultTableSavePartFn() {
    let seq                 = 1;
    let sum10               = 0;
    let tbodyTableSavePart  = '';
    let optionWorkOrder     = '';
        optionWorkOrder += `<option value=""></option>`
    for (const [i, data] of dataDropDownWorkOrder.entries()) {
      optionWorkOrder += `<option value="${data.operation_seq_num}" ${i == '0' ? 'selected' : ''}>${data.operation_seq_num}</option>`
    }
    
    let optionItemType = ''
      optionItemType += `<option value=""></option>`
    for (let data of dataDropDownItemType) {
      if (data.lookup_code == 0) {
        optionItemType += `<option value="${data.lookup_code}" ${data.lookup_code == 0 ? 'selected' : ''}>${data.meaning}</option>`
      }
    }

    let optionSuvinventory = ''
      optionSuvinventory += `<option value=""></option>`
    for (let data of dataDropDownSubinventory) {
      optionSuvinventory += `<option value="${data.name}">${data.name}</option>`
    }
    let optionLocator = `<option value=""></option>`

    $("#checkboxAllTable").prop('disabled', false);
    for (i = 0; i < 3; i++) {
      tbodyTableSavePart += `<tr>`
      tbodyTableSavePart += `<td class="text-center">
                              <input  type="checkbox" 
                                      onclick="checkBoxOnClick()" 
                                      name="case[]" 
                                      ${statusDisabledMt ? 'disabled' : ''}>
                              <input type="hidden" class="sum10" value="${+sum10 + 10}">
                            </td>`
      tbodyTableSavePart += `<td>
                                  <select  class="form-control workOrderTbMT" 
                                          ${i == '0' ? 'required' : ''} 
                                          ${statusDisabledMt ? 'disabled' : ''}>
                                          `+optionWorkOrder+`
                                  </select>
                            </td>`
      tbodyTableSavePart += `<td>
                                <select class="form-control itemTypeTbMT" 
                                        ${i == '0' ? 'required' : ''} 
                                        ${statusDisabledMt ? 'disabled' : 'disabled'}>
                                        `+optionItemType+`
                                </select>
                            </td>`
      tbodyTableSavePart += `<td>
                              <div class="input-group">
                                <select id="itemCode${+sum10 + 10}" 
                                        name="item_code" 
                                        class="itemCode form-control clearable readonly"
                                        data-server="/eam/ajax/lov/item-inventory"  
                                        data-id="item_code" 
                                        data-field="select"
                                        data-setAjaxDetailItemCode = "itemCode${+sum10 + 10}"
                                        data-typeAjaxDetailItemCode = "itemCode${+sum10 + 10}"
                                        ${statusDisabledMt ? 'disabled' : ''}
                                        ${i == '0' ? 'required' : ''}>
                                </select>
                                <div class="input-group-append">
                                  <span class="input-group-append">
                                    <button onclick="itemCodeLovBtnTableOnclick('itemCode${+sum10 + 10}')" 
                                            type="button" 
                                            class="btn btn-default" ${statusDisabledMt ? 'disabled' : ''}>
                                            <i class="fa fa-search"></i>
                                    </button>
                                  </span>
                                </div>
                              </div>
                            </td>`
      tbodyTableSavePart += `<td>
                                <input  type="text" 
                                        class="form-control" 
                                        value="" ${i == '0' ? 'required' : ''} 
                                        disabled 
                                        autocomplete="off">
                            </td>`
      tbodyTableSavePart += `<td style="text-align: center; vertical-align: middle;">
                                <input  type="checkbox" 
                                        id="checkbox${+sum10 + 10}"
                                        onclick="handleClick(this)">
                            </td>`
      tbodyTableSavePart += `<td>
                                <input  onkeypress="return /[0-9\-]/i.test(event.key)" 
                                        type="text" 
                                        class="form-control" 
                                        value="" ${i == '0' ? 'required' : ''} 
                                        autocomplete="off" 
                                        ${statusDisabledMt ? 'disabled' : ''}>
                            </td>`
      tbodyTableSavePart += `<td>
                                <input  type="text" 
                                        class="form-control" 
                                        value="" 
                                        disabled 
                                        autocomplete="off">
                            </td>`
      tbodyTableSavePart += `<td>
                                <input  type="text" 
                                        class="form-control" 
                                        value="" 
                                        disabled 
                                        autocomplete="off">
                            </td>`
      tbodyTableSavePart += `<td>
                                <select class="form-control" 
                                        disabled ${i == '0' ? 'required' : ''}>
                                </select>
                            </td>`
      tbodyTableSavePart += `<td>
                                <input  type="text"
                                        class="form-control" 
                                        value="" 
                                        autocomplete="off" 
                                        disabled>
                            </td>`
      tbodyTableSavePart += `<td>
                                <select class="form-control subinventoryTbMT"
                                        ${statusDisabledMt ? 'disabled' : ''}>`+optionSuvinventory+`
                                </select>
                            </td>`
      tbodyTableSavePart += `<td>
                                <select class="form-control locatorTbMT"
                                        ${statusDisabledMt ? 'disabled' : ''}>`+optionLocator+`
                                </select>
                            </td>`
      tbodyTableSavePart += `<td>
                                <input  type="text" 
                                        class="form-control" 
                                        value="" 
                                        disabled 
                                        autocomplete="off">
                            </td>`
      tbodyTableSavePart += `<td class="d-none">
                                <input  type="text"
                                        class="form-control" 
                                        value="" 
                                        disabled 
                                        autocomplete="off">
                            </td>`
      tbodyTableSavePart += `<td class="d-none">
                                <input  type="text" 
                                        class="form-control" 
                                        value="" 
                                        disabled 
                                        autocomplete="off">
                            </td>`
      tbodyTableSavePart += `<td class="d-none">
                                <input  type="text"
                                        class="form-control" 
                                        value="" 
                                        disabled 
                                        autocomplete="off">
                            </td>`
      tbodyTableSavePart += `<td class="d-none">
                                <button onclick="setDataLovTableSavePart('itemCode${+sum10 + 10}')" 
                                        type="button" 
                                        disabled 
                                        class="btn btn-primary btn-sm">
                                        คืนอะไหล่
                                </button>
                            </td>`
      tbodyTableSavePart += `<td class="d-none">
                                <input  type="text" value="" hidden autocomplete="off">
                            </td>`
      tbodyTableSavePart += `<td class="d-none">
                                <input  type="text" value="" hidden autocomplete="off">
                            </td>`
      tbodyTableSavePart += `<td class="d-none">
                                <input  type="text" 
                                        class="form-control" 
                                        value="add" 
                                        hidden 
                                        autocomplete="off">
                            </td>`
      tbodyTableSavePart += `<td class="d-none">
                              <input  type="text" 
                                      class="form-control" 
                                      value="${seq}" 
                                      hidden 
                                      autocomplete="off">
                          </td>`
      tbodyTableSavePart += `</tr>`
      sum10 += 10;
      seq += 1;
    }
    $("#setTbodyTableSavePart").html(tbodyTableSavePart);
    changItemType();
    changSubinventory();
    changLocator();
    readonly();
    setSelect2InEAM0010TbodyTableSavePart();
    triggerSelect2InEAM0010();   
  }

  $("#checkboxAllTable").click((e) => { 
    var table = $(e.target).closest('table');
    if ($("#checkboxAllTable").prop('checked')) {
      $('td input:checkbox:not([disabled]):not([id])', table).prop('checked', $("#checkboxAllTable").prop('checked'));
    } else {
      $('td input:checkbox:not([id])', table).prop('checked', $("#checkboxAllTable").prop('checked'));
    }
    checkBoxOnClick()
  })

  function checkBoxOnClick() {
    let statusCheckBox = true
    let checkItemType = false
    $("#setTbodyTableSavePart input[type='checkbox']:checked").each(function() {
      if ($(this).parents('tr').find("td:eq(2) select").val() == '0') {
        statusCheckBox = false
      } else {
        checkItemType = true
      }

      if($(this).parents('tr').find("td:eq(8) input[type='text']").val() != null){
        $("#deleteSavePartBtn").attr('disabled', false);
      }else{
        $("#deleteSavePartBtn").attr('disabled', true);
      }
    })

    if (checkItemType) {
      $("#resourceSavePartBtn").attr('disabled', true);
    } else if ($("#jobReceiptStatus").val() == '3') {
      let repairDateStartArr = vmDateTimePickerAll.repairDateStart.pValue;
          repairDateStartArr = repairDateStartArr.split(' ');
      let repairDateStartDate = repairDateStartArr[0].split('/'); 
      let repairDateStartTime = repairDateStartArr[1]; 
      let dateStartFormatGetTime = new Date((parseInt( repairDateStartDate[2])-543)+'/'+
                                                  repairDateStartDate[1]+'/'+
                                                  repairDateStartDate[0]+' '+
                                                  repairDateStartTime).getTime()
      let dateNowFormatGetTime = new Date(Date.now()).getTime();
      
      if(dateNowFormatGetTime >= dateStartFormatGetTime){
        $("#resourceSavePartBtn").attr('disabled', false);
        if(statusCheckBox){
          $("#resourceSavePartBtn").attr('disabled', true);
        }
      }else{
        $("#resourceSavePartBtn").attr('disabled', true);
      }
    } else {
      $("#resourceSavePartBtn").attr('disabled', true);
    }

    if($("#setTbodyTableSavePartNon input[type='checkbox']").length != 
       $("#setTbodyTableSavePartNon input[type='checkbox']:checked").length){
      $("#checkboxAllTableNon").prop('checked',false);
    }else{
      $("#checkboxAllTableNon").prop('checked',true);
    }

    if($("#setTbodyTableSavePart input[type='checkbox']:not([id])").length != 
       $("#setTbodyTableSavePart input[type='checkbox']:checked:not([id])").length){
      $("#checkboxAllTable").prop('checked',false);
    }else{
      $("#checkboxAllTable").prop('checked',true);
    }
  }
  
  $("#saveSavePartBtn").click(() => {
    $("#saveSavePartBtnHide").click();
  })
  function formSaveSavePartBtnHide() {  
    swal({
        title: `\nคุณแน่ใจไหม?`,
        text: 'กรุณายืนยันการบันทึกข้อมูล',
        type: 'warning',
        dangerMode: true,
        showCancelButton: true,
        closeOnCancel: true,
        cancelButtonText: 'ยกเลิก',
        showConfirmButton: true,
        closeOnConfirm: true,
        confirmButtonText: 'ดำเนินการต่อ',
        allowClickOutside: true,
        closeOnClickOutside: true,
      },
      function(){  
        let dataSave = []
        $("#setTbodyTableSavePart tr").each(function() {
          if ($(this).find("td:eq(1) select").val() != '' && 
              $(this).find("td:eq(2) select").val() != '' && 
              $(this).find("td:eq(3) select").val() != '' && 
              $(this).find("td:eq(6) input[type='text']").val() != '') {
            let data = {
              operation_seq_num:      $(this).find("td:eq(1) select").val(),
              item_type_id:           $(this).find("td:eq(2) select").val(),
              item_type_desc:         $(this).find("td:eq(2) option:selected").text(),
              item_code:              $(this).find("td:eq(3) select").val(),
              item_description:       $(this).find("td:eq(4) input[type='text']").val(),
              attribute2:             $(this).find("td:eq(2) select").val() == '0' ? '' : 
                                      $(this).find("td:eq(4) input[type='text']").val(),
              required_quantity:      $(this).find("td:eq(6) input[type='text']").val(),
              attribute6:             $(this).find("td:eq(7) input[type='text']").val(),
              quantity_issued:        $(this).find("td:eq(8) input[type='text']").val(),
              item_primary_uom_code:  $(this).find("td:eq(9) select").val(),
              unit_price:             $(this).find("td:eq(10) input[type='text']").val(),              
              supply_subinventory:    $(this).find("td:eq(11) select").val(),
              supply_locator_code:    $(this).find("td:eq(12) select").val(),
              quantity_on_hand:       $(this).find("td:eq(13) input[type='text']").val(),
              pr_number:              $(this).find("td:eq(14) input[type='text']").val(),
              po_number:              $(this).find("td:eq(15) input[type='text']").val(),
              received_qty:           $(this).find("td:eq(16) input[type='text']").val(),
              program_code:           'EAM0011',
              wip_entity_id:          wip_entity_id,
              or_wip_entity_id:       or_wip_entity_id,
              material_id:            $(this).find("td:eq(18) input[type='text']").val(),
              organization_id:        organization_id,
              inventory_item_id:      $(this).find("td:eq(19) input[type='text']").val(),
              wms_issue:              $(this).find("td:eq(5) input[type='checkbox']").val(), 
              seq:                    $(this).find("td:eq(21) input[type='text']").val()
            }
            dataSave.push(data)
          }
        })
        if (dataSave.length > 0) {
          $.ajax({
            url: "{{ route('eam.ajax.work-order.mt.store') }}",
            type: "POST",
            headers: {
              'Accept': 'application/json',
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            data: JSON.stringify({data: dataSave}),
            success: function (response) {
              swal("Success", response.message, "success");
              workOrderMtAll(true);
              $("#checkboxAllTable").prop('checked', false);
            },
            error: function (jqXHR, textStatus, errorRhrown) {
              swal("Error", jqXHR.responseJSON.message, "error");
            }
          })
        } else {
          swal("กรุณาเพิ่มรายการ", "", "warning");
        }
      }
    )
  }

  $("#deleteSavePartBtn").click(() => {
    let dataSaveCheckAdd = []
    let dataSave = []
    let statusDel = false
    $("#setTbodyTableSavePart input[type='checkbox']:checked:not([id])").each(function() {
      if ($(this).parents('tr').find("td:eq(20) input[type='text']").val() == 'add') {
        dataSaveCheckAdd.push($(this).parents('tr'));
      } else {
        let data = {
          operation_seq_num:      $(this).parents('tr').find("td:eq(1) select").val(),
          item_type_id:           $(this).parents('tr').find("td:eq(2) select").val(),
          item_type_desc:         $(this).parents('tr').find("td:eq(2) option:selected").text(),
          item_code:              $(this).parents('tr').find("td:eq(3) select").val(),
          item_description:       $(this).parents('tr').find("td:eq(4) input[type='text']").val(),
          required_quantity:      $(this).parents('tr').find("td:eq(6) input[type='text']").val(),
          attribute6:             $(this).parents('tr').find("td:eq(7) input[type='text']").val(),
          quantity_issued:        $(this).parents('tr').find("td:eq(8) input[type='text']").val(),
          item_primary_uom_code:  $(this).parents('tr').find("td:eq(9) select").val(),
          unit_price:             $(this).parents('tr').find("td:eq(10) input[type='text']").val(),
          supply_subinventory:    $(this).parents('tr').find("td:eq(11) select").val(),
          supply_locator_code:    $(this).parents('tr').find("td:eq(12) select").val(),
          quantity_on_hand:       $(this).parents('tr').find("td:eq(13) input[type='text']").val(),
          pr_number:              $(this).parents('tr').find("td:eq(14) input[type='text']").val(),
          po_number:              $(this).parents('tr').find("td:eq(15) input[type='text']").val(),
          received_qty:           $(this).parents('tr').find("td:eq(16) input[type='text']").val(),
          program_code:           'EAM0011',
          wip_entity_id:          wip_entity_id,
          or_wip_entity_id:       or_wip_entity_id,
          material_id:            $(this).parents('tr').find("td:eq(18) input[type='text']").val(),
          organization_id:        organization_id,
          inventory_item_id:      $(this).parents('tr').find("td:eq(19) input[type='text']").val(),
          attribute2:             $(this).parents('tr').find("td:eq(2) select").val() == '0' ? '' : 
                                  $(this).parents('tr').find("td:eq(4) input[type='text']").val(),
          wms_issue:              $(this).parents('tr').find("td:eq(5) input[type='checkbox']").val(),
          seq:                    $(this).parents('tr').find("td:eq(21) input[type='text']").val()
        }
        dataSave.push(data)
        if (data.quantity_issued) {
          statusDel = true
        }
      }
    })
    if (dataSave.length > 0) {
      if (statusDel) {
        swal("มีข้อมูลช่องจำนวนที่ตัดใช้แล้วเกิดขึ้น จะไม่สามารถลบรายการนั้นๆ ได้", "", "warning");
      } else {
        $.ajax({
          url: "{{ route('eam.ajax.work-order.mt.delete') }}",
          type: "POST",
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
          data: JSON.stringify({data: dataSave}),
          success: function (response) {
            swal("Success", response.message, "success");
            workOrderMtAll(true);
            $("#checkboxAllTable").prop('checked', false);
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      }
    } else if (dataSaveCheckAdd.length > 0) {
      dataSaveCheckAdd.filter(row => {
        $(row).remove();
      })
    } else {
      swal("กรุณาเลือกรายการ", "", "warning");
    }
  })

  function setDataLovTableSavePart(id) {
    idReMaterial =            id ? id : '';
    let operationSeqNum =     $("#" + id).parents('tr').find("td:eq(1) select").val();
    let itemCode =            $("#" + id).parents('tr').find("td:eq(3) select").val();
    let supplySubinventory =  $("#" + id).parents('tr').find("td:eq(11) select").val();
    let locatorCode =         $("#" + id).parents('tr').find("td:eq(12) select").val();
    $.ajax({
      url: "{{ route('eam.ajax.work-order.mtShowReMaterial') }}",
      method: 'POST',
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
      },
      data: JSON.stringify({
        p_operation_seq_num: operationSeqNum,
        p_wip_entity_id: wip_entity_id,
        p_item_code: itemCode,
        p_supply_subinventory: supplySubinventory,
        p_locator_code: locatorCode,
      }),   
      success: function (response) {
        $("#detailTableSavePartChild").modal('show');
        setDefaultSavePartBtnChild(response.data);
        setSelect2InEAM0010DetailTableSavePartChild();
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
  }

  function setDefaultSavePartBtnChild(row) {
    $("#setSavePartBtnChild").html('');
    let tbodyTableSavePartChild = '';
    let select = true;
    _.each(row, function(value, index) {
      tbodyTableSavePartChild += `<tr class="tr_clone">`
      tbodyTableSavePartChild += `<td class="d-none">
                                    <input  type="text" 
                                            class="form-control sum10" 
                                            value="10" 
                                            disabled 
                                            autocomplete="off">
                                  </td>`
      tbodyTableSavePartChild += `<td>
                                    <input  type="text" 
                                            class="form-control" 
                                            value="${value.wip_entity_name}" 
                                            disabled 
                                            autocomplete="off">
                                  </td>`
      tbodyTableSavePartChild += `<td>
                                    <input  type="text" 
                                            class="form-control" 
                                            value="${value.operation_seq_num}" 
                                            disabled 
                                            autocomplete="off">
                                  </td>`
      tbodyTableSavePartChild += `<td>
                                    <input  type="text" 
                                            class="form-control" 
                                            value="${value.item_code}" 
                                            disabled 
                                            autocomplete="off">
                                  </td>`
      tbodyTableSavePartChild += `<td>
                                    <input  type="text" 
                                            class="form-control" 
                                            value="${value.item_description}" 
                                            disabled 
                                            autocomplete="off">
                                  </td>`
      tbodyTableSavePartChild += `<td>
                                    <input  type="text" 
                                            class="form-control" 
                                            value="${value.required_quantity}" 
                                            disabled 
                                            autocomplete="off">
                                  </td>`
      tbodyTableSavePartChild += `<td>
                                    <input  id="quantityIssued_${index}"
                                            type="text" 
                                            class="form-control" 
                                            value="${value.quantity_issued}" 
                                            disabled 
                                            autocomplete="off">
                                  </td>`
      tbodyTableSavePartChild += `<td>
                                    <input  id="reMaterial_${index}"
                                            type="number" 
                                            onkeypress="checkValueRe({index: ${index}})"
                                            onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? 
                                                                          true : 
                                                                          !isNaN(Number(event.key)) && event.code!=='Space'"
                                            class="form-control" 
                                            min="1" 
                                            step="1"
                                            autocomplete="off">
                                  </td>`
      // item primary uom code
      tbodyTableSavePartChild += `<td>
                                    <input  type="text" 
                                            class="form-control" 
                                            value="${value.primary_unit_of_measure}" 
                                            disabled 
                                            autocomplete="off">
                                  </td>`
      tbodyTableSavePartChild += `<td>
                                    <input  id="dateTableMt${index}" 
                                            type="text" 
                                            class="form-control" 
                                            value="" 
                                            autocomplete="off"
                                            required>
                                  </td>`
      tbodyTableSavePartChild += `<td>
                                    <input  type="text"
                                            class="form-control" 
                                            value="${value.supply_subinventory}" 
                                            disabled 
                                            autocomplete="off">
                                  </td>`
      tbodyTableSavePartChild += `<td>
                                    <input  type="text" 
                                            class="form-control" 
                                            value="${value.locator_code}" 
                                            disabled 
                                            autocomplete="off">
                                  </td>`
      tbodyTableSavePartChild += `<td>
                                    <input  type="text" 
                                            class="form-control" 
                                            value="${value.lot_number}" 
                                            disabled 
                                            autocomplete="off">
                                  </td>`
      // inventory item id
      tbodyTableSavePartChild += `<td class="d-none">
                                    <input  type="text" 
                                            value="${value.inventory_item_id}" 
                                            hidden>
                                  </td>`
      // material id
      tbodyTableSavePartChild += `<td class="d-none">
                                    <input  type="text" 
                                            value="${value.material_id}" 
                                            hidden>
                                  </td>`
      // item type id
      tbodyTableSavePartChild += `<td class="d-none">
                                    <input  type="text" 
                                            value="${value.item_type_id}" 
                                            hidden>
                                  </td>`
      // item type desc
      tbodyTableSavePartChild += `<td class="d-none">
                                    <input  type="text" 
                                            value="${value.item_type_desc}" 
                                            hidden>
                                  </td>`
      tbodyTableSavePartChild += `</tr>`
    });

    $("#setSavePartBtnChild").append(tbodyTableSavePartChild);

    _.each(row, function(value, index) {
      let indexDate = `dateTableMt${index}`;
      setDateTimePickerAll({idDate: indexDate, nameDate: '', onchange: false, date: '', disabled: false, required: true});
      vmDateTimePickerAll[indexDate].pValue = getDateTime();
    });
  }
  
  $("#resourceSavePartBtn").click(() => {
    swal({
        title: `\nคุณแน่ใจไหม?`,
        text: 'กรุณายืนยันการตัดใช้อะไหล่',
        type: 'warning',
        dangerMode: true,
        showCancelButton: true,
        closeOnCancel: true,
        cancelButtonText: 'ยกเลิก',
        showConfirmButton: true,
        closeOnConfirm: true,
        confirmButtonText: 'ดำเนินการต่อ',
        allowClickOutside: true,
        closeOnClickOutside: true,
      },
      function(isConfirm){  
        if(isConfirm){
          loader('show');
          let dataSave = []
          $("#setTbodyTableSavePart input[type='checkbox']:checked:not([id])").each(function() {
            let data = {
              operation_seq_num:      $(this).parents('tr').find("td:eq(1) select").val(),
              item_type_id:           $(this).parents('tr').find("td:eq(2) select").val(),
              item_type_desc:         $(this).parents('tr').find("td:eq(2) option:selected").text(),
              item_code:              $(this).parents('tr').find("td:eq(3) select").val(),
              item_description:       $(this).parents('tr').find("td:eq(4) input[type='text']").val(),
              required_quantity:      $(this).parents('tr').find("td:eq(6) input[type='text']").val(),
              attribute6:             $(this).parents('tr').find("td:eq(7) input[type='text']").val(),
              quantity_issued:        $(this).parents('tr').find("td:eq(8) input[type='text']").val(),
              item_primary_uom_code:  $(this).parents('tr').find("td:eq(9) select").val(),
              unit_price:             $(this).parents('tr').find("td:eq(10) input[type='text']").val(),
              supply_subinventory:    $(this).parents('tr').find("td:eq(11) select").val(),
              supply_locator_code:    $(this).parents('tr').find("td:eq(12) select").val(),
              quantity_on_hand:       $(this).parents('tr').find("td:eq(13) input[type='text']").val(),
              pr_number:              $(this).parents('tr').find("td:eq(14) input[type='text']").val(),
              po_number:              $(this).parents('tr').find("td:eq(15) input[type='text']").val(),
              received_qty:           $(this).parents('tr').find("td:eq(16) input[type='text']").val(),
              program_code:           'EAM0011',
              wip_entity_id:          wip_entity_id,
              or_wip_entity_id:       or_wip_entity_id,
              material_id:            $(this).parents('tr').find("td:eq(18) input[type='text']").val(),
              organization_id:        organization_id,
              inventory_item_id:      $(this).parents('tr').find("td:eq(19) input[type='text']").val(),
              attribute2:             $(this).parents('tr').find("td:eq(2) select").val() == '0' ? '' : 
                                      $(this).parents('tr').find("td:eq(4) input[type='text']").val(),
              wms_issue:              $(this).parents('tr').find("td:eq(5) input[type='checkbox']").val(),
              seq:                    $(this).parents('tr').find("td:eq(21) input[type='text']").val()
            }
            dataSave.push(data)
          })
          if (dataSave.length > 0) {
            $.ajax({
              url: "{{ route('eam.ajax.work-order.mt.issue') }}",
              type: "POST",
              headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
              },
              data: JSON.stringify({data: dataSave}),
              success: function (response) {
                swal("Success", response.message, "success");
                dropDownWoMtLot();
                workOrderMtAll(true);
                $("#checkboxAllTable").prop('checked', false);
                loader('hide');
              },
              error: function (jqXHR, textStatus, errorRhrown) {
                swal("Error", jqXHR.responseJSON.message, "error");
                loader('hide');
              }
            })
          } else {
            swal("กรุณาเลือกรายการ", "", "warning");
          }
        }
      }
    )
  })

  $("#saveSavePartBtnChild").click(() => {
    $("#saveSavePartBtnChildHide").click();
  })

  function formSaveSavePartBtnChildHide() {
    let dataSave = [] 
    $("#setSavePartBtnChild tr").each(function() {
      let data = {
        material_id:            $(this).find("td:eq(14) input[type='text']").val(),
        operation_seq_num:      $(this).find("td:eq(2) input[type='text']").val(),
        wip_entity_id:          wip_entity_id,
        wip_entity_name:        $(this).find("td:eq(1) input[type='text']").val(),
        organization_id:        organization_id,
        inventory_item_id:      $(this).find("td:eq(13) input[type='text']").val(),
        item_code:              $(this).find("td:eq(3) input[type='text']").val(),
        item_description:       $(this).find("td:eq(4) input[type='text']").val(),
        required_quantity:      $(this).find("td:eq(5) input[type='text']").val(),
        quantity_issued:        $(this).find("td:eq(6) input[type='text']").val(),
        quantity_return:        $(this).find("td:eq(7) input[type='number']").val(),
        item_primary_uom_code:  $(this).find("td:eq(8) input[type='text']").val(),
        transaction_date:       $(this).find("td:eq(9) input[type='text']").val(),
        subinventory:           $(this).find("td:eq(10) input[type='text']").val(),
        locator_code:           $(this).find("td:eq(11) input[type='text']").val(),
        lot_no:                 $(this).find("td:eq(12) input[type='text']").val(),
        item_type_id:           $(this).find("td:eq(15) input[type='text']").val(),
        item_type_desc:         $(this).find("td:eq(16) input[type='text']").val(),
        or_wip_entity_id:       or_wip_entity_id,
      }
      dataSave.push(data)
    })
    if (dataSave.length > 0) {
      $.ajax({
        url: "{{ route('eam.ajax.work-order.mt.return') }}",
        type: "POST",
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        data: JSON.stringify({data: dataSave}),
        success: function (response) {
          swal("Success", response.message, "success");
          if(idReMaterial){
            setDataLovTableSavePart(idReMaterial)
          }
          workOrderMtAll(true);
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    } else {
      swal("กรุณาเพิ่มรายการ", "", "warning");
    } 
  }

  function handleClick(cb) {
    if(cb.checked){
      cb.value = 'Yes';
      $("#" + cb.id).parents('tr').find("td:eq(11) select").prop('disabled', true);
      $("#" + cb.id).parents('tr').find("td:eq(12) select").prop('disabled', true);
    }else{
      cb.value = 'No';
      $("#" + cb.id).parents('tr').find("td:eq(11) select").prop('disabled', false);
      $("#" + cb.id).parents('tr').find("td:eq(12) select").prop('disabled', false);
    }
  } 

  async function checkValueRe(data) {
    setTimeout(await function() {
      let valueReMaterial = 0;
      let valueQuantityIssued = 0;
      valueReMaterial = $("#reMaterial_" + data.index).val();
      valueQuantityIssued = $("#quantityIssued_" + data.index).val();

      if(parseInt(valueReMaterial) > parseInt(valueQuantityIssued)){
        swal("Error", 'ไม่สามารถกรอก จำนวนที่ต้องการคืนน้อยกว่าได้', "error");
        $("#reMaterial_" + data.index).val('').trigger('change');
      }
    }, 100)
  }
  
</script>