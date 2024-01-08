<script>
  var maxSeq = '';

  async function workOrderMtAllNon(status) {
    $("#savePartBtnCheckBox").prop('checked', false).prop('disabled', true);
    await $.ajax({
      url: "{{ route('eam.ajax.work-order.mtdirect.all',['']) }}/" + wip_entity_id,
      method: 'GET',
      success: function (response) {
        console.log(response);
        if (response.data.length > 0) {
          setTableSavePartNonFn({response: response, status: status});
        } else {
          setDefaultTableSavePartNonFn()
        }
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
    await checkConfirmMt()
  }

  async function setTableSavePartNonFn(response) {
    let data                  = response.response;
    let status                = response.status;
    let sum10                 = 0;
    let tbodyTableSavePartNon = '';
    let indexShow             = 10;
    let mustReload            = false;
    $("#checkboxAllTableNon").prop('disabled', false);
    if (data.data.length > 0) {
      data.data.filter(row => { 
        maxSeq = Math.max(row.attribute9);
        if ($("#savePartBtnCheckBox").prop('disabled') != true) {
          if (row.received_qty == '') {
            $("#savePartBtnCheckBox").prop('disabled', true);
          }
        }
        let optionWorkOrder = ''
          optionWorkOrder += `<option value=""></option>`
        for (let data of dataDropDownWorkOrder) {
          optionWorkOrder += `<option value="${data.operation_seq_num}" ${row.operation_seq_num == data.operation_seq_num ? 'selected' : ''}>${data.operation_seq_num}</option>`
        }
        let optionItemType = ''
          optionItemType += `<option value=""></option>`
        for (let data of dataDropDownItemType) {
          if (data.lookup_code == 2) {
            optionItemType += `<option value="${data.lookup_code}" ${data.lookup_code == 2 ? 'selected' : ''}>${data.meaning}</option>`
          }
        }

        let tdPrHtml = `
            <div class="input-group">
              <input id="prNumber${+sum10 + 10}" type="text" class="form-control readonly" value="${row.pr_number ? row.pr_number : ''}" required disabled autocomplete="off">
              <div class="input-group-append">
                <span class="input-group-append">
                  <button onclick="delPrNumber('prNumber${+sum10 + 10}')" type="button" class="btn btn-default" ${statusDisabledPrNumber ? 'disabled' : row.pr_numbe == '' ? 'disabled' : ''}><i class="fa fa-trash"></i></button>
                </span>
              </div>
            </div>
        `;

        if (row.loading_pr_flag == 'Y') {
            tdPrHtml = `
                <div style="background-color: #e9ecef; opacity: 1;">
                    <div style="height: 36px; padding-top: 5px;" >
                        <div class="sk-spinner sk-spinner-fading-circle">
                            <div class="sk-circle1 sk-circle"></div>
                            <div class="sk-circle2 sk-circle"></div>
                            <div class="sk-circle3 sk-circle"></div>
                            <div class="sk-circle4 sk-circle"></div>
                            <div class="sk-circle5 sk-circle"></div>
                            <div class="sk-circle6 sk-circle"></div>
                            <div class="sk-circle7 sk-circle"></div>
                            <div class="sk-circle8 sk-circle"></div>
                            <div class="sk-circle9 sk-circle"></div>
                            <div class="sk-circle10 sk-circle"></div>
                            <div class="sk-circle11 sk-circle"></div>
                            <div class="sk-circle12 sk-circle"></div>
                        </div>
                    </div>
                </div>
                <input id="prNumber${+sum10 + 10}" type="hidden" name="" value="">
            `;
            mustReload = true;
        }

        tbodyTableSavePartNon += `<tr>`
        tbodyTableSavePartNon += `<td class="text-center">
                                    <input  type="checkbox" 
                                            onclick="checkBoxOnClick()" 
                                            name="case[]" 
                                            ${statusDisabledMt ? 'disabled' : ''}>
                                    <input type="hidden" class="sum10" value="${+sum10 + 10}">
                                </td>`
        tbodyTableSavePartNon += `<td><select class="form-control workOrderTbMT" 
                                              required 
                                              ${row.pr_number ? 'disabled' : ''}
                                              ${statusDisabledMt ? 'disabled' : ''}>`+optionWorkOrder+`
                                      </select>
                                  </td>`
        tbodyTableSavePartNon += `<td><select class="form-control itemTypeTbMT" 
                                              required ${statusDisabledMt ? 'disabled' : 'disabled'}>`+optionItemType+`
                                      </select>
                                  </td>`
        tbodyTableSavePartNon += `<td>
                                    <div class="input-group">
                                      <select id="itemCodeNon${+sum10 + 10}"
                                              name="item_code" 
                                              class="itemCode form-control readonly" 
                                              data-server="/eam/ajax/lov/item-nonstock"  
                                              data-id="item_code" 
                                              data-field="select"
                                              required
                                              ${row.pr_number ? 'disabled' : ''}
                                              ${statusDisabledMt ? 'disabled' : ''}>
                                      </select>
                                      <div class="input-group-append">
                                        <span class="input-group-append">
                                          <button onclick="itemCodeNonLovBtnTableOnclick('itemCodeNon${+sum10 + 10}')" 
                                                  type="button" 
                                                  class="btn btn-default" 
                                                  ${statusDisabledMt ? 'disabled' : ''}>
                                                  <i class="fa fa-search"></i>
                                          </button>
                                        </span>
                                      </div>
                                    </div>
                                  </td>`
        tbodyTableSavePartNon += `<td><input  id="itemDesNon${+sum10 + 10}"
                                              type="text" 
                                              class="form-control" ${row.pr_number ? 'disabled' : ''} 
                                              required ${statusDisabledMt ? 'disabled' : ''} 
                                              autocomplete="off">
                                  </td>`
        tbodyTableSavePartNon += `<td><input  id="requiredQuantity${+sum10 + 10}" 
                                              onkeypress="checkValue({index: ${+sum10 + 10}})"                                                 
                                              onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? 
                                                                            true : 
                                                                            !isNaN(Number(event.key)) && event.code!=='Space'" 
                                              type="number" 
                                              class="form-control" 
                                              ${row.pr_number ? 'disabled' : ''} 
                                              value="${row.required_quantity ? row.required_quantity : ''}" 
                                              required 
                                              autocomplete="off" 
                                              ${statusDisabledMt ? 'disabled' : ''}>
                                  </td>`
        tbodyTableSavePartNon += `<td><select class="form-control" 
                                              required disabled>
                                              <option value="${row.item_primary_uom_code ? row.item_primary_uom_code : ''}">${row.item_primary_uom_code ? row.item_primary_uom_code : ''}</option>
                                      </select>
                                  </td>`
        tbodyTableSavePartNon += `<td><input  type="text" 
                                              min="1"
                                              onkeydown="javascript: return ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Period'].includes(event.code) ? 
                                                                    true : 
                                                                    !isNaN(Number(event.key)) && event.code!=='Space'" 
                                              class="form-control" 
                                              ${row.pr_number ? 'disabled' : ''} 
                                              value="${row.unit_price ? row.unit_price : '0'}" 
                                              ${statusDisabledMt ? 'disabled' : ''} 
                                              autocomplete="off">
                                  </td>`
        tbodyTableSavePartNon += `<td >${tdPrHtml}</td>`
        tbodyTableSavePartNon += `<td>
                                    <input  type="text" 
                                            class="form-control" 
                                            value="${row.po_number ? row.po_number : ''}" 
                                            disabled 
                                            autocomplete="off">
                                  </td>`
        tbodyTableSavePartNon += `<td>
                                    <input  type="text" 
                                            class="form-control" 
                                            value="${row.received_qty ? row.received_qty : ''}" 
                                            disabled 
                                            autocomplete="off">
                                  </td>`
        tbodyTableSavePartNon += `<td class="d-none">
                                    <input  type="text" 
                                            value="${row.attribute1 ? row.attribute1 : ''}" 
                                            hidden 
                                            autocomplete="off">
                                  </td>`
        tbodyTableSavePartNon += `<td class="d-none">
                                    <input  type="text" 
                                            value="${row.attribute3 ? row.attribute3 : ''}" 
                                            hidden 
                                            autocomplete="off">
                                  </td>`
        tbodyTableSavePartNon += `<td class="d-none">
                                    <input  type="text"
                                            value="${row.attribute4 ? row.attribute4 : ''}" 
                                            hidden 
                                            autocomplete="off">
                                  </td>`
        tbodyTableSavePartNon += `<td class="d-none">
                                    <input  type="text" 
                                            value="${row.attribute5 ? row.attribute5 : ''}" 
                                            hidden 
                                            autocomplete="off">
                                  </td>`
        tbodyTableSavePartNon += `<td class="d-none">
                                    <input  type="text" 
                                            value="${row.attribute6 ? row.attribute6 : ''}" 
                                            hidden 
                                            autocomplete="off">
                                  </td>`
        tbodyTableSavePartNon += `<td class="d-none">
                                    <input  type="text" 
                                            value="${row.attribute7 ? row.attribute7 : ''}" 
                                            hidden 
                                            autocomplete="off">
                                  </td>`
        tbodyTableSavePartNon += `<td class="d-none">
                                    <input  type="text" 
                                            value="${row.attribute8 ? row.attribute8 : ''}" 
                                            hidden 
                                            autocomplete="off">
                                  </td>`
        tbodyTableSavePartNon += `<td class="d-none">
                                    <input  type="text" 
                                            value="${row.attribute9 ? row.attribute9 : ''}" 
                                            hidden 
                                            autocomplete="off">
                                  </td>`
        tbodyTableSavePartNon += `<td class="d-none">
                                    <input  type="text" 
                                            value="${row.attribute10 ? row.attribute10 : ''}" 
                                            hidden 
                                            autocomplete="off">
                                  </td>`
        tbodyTableSavePartNon += `<td class="d-none">
                                    <input  type="text" 
                                            value="${row.attribute11 ? row.attribute11 : ''}" 
                                            hidden 
                                            autocomplete="off">
                                  </td>`
        tbodyTableSavePartNon += `<td class="d-none">
                                    <input  type="text" 
                                            value="${row.attribute12 ? row.attribute12 : ''}" 
                                            hidden 
                                            autocomplete="off">
                                  </td>`
        tbodyTableSavePartNon += `<td class="d-none">
                                    <input  type="text" 
                                            value="${row.attribute13 ? row.attribute13 : ''}" 
                                            hidden 
                                            autocomplete="off">
                                  </td>`
        tbodyTableSavePartNon += `<td class="d-none">
                                    <input  type="text" 
                                            value="${row.attribute14 ? row.attribute14 : ''}" 
                                            hidden 
                                            autocomplete="off">
                                  </td>`
        tbodyTableSavePartNon += `<td class="d-none">
                                    <input  type="text" 
                                            value="${row.attribute15 ? row.attribute15 : ''}" 
                                            hidden 
                                            autocomplete="off">
                                  </td>`
        tbodyTableSavePartNon += `<td class="d-none">
                                    <input  type="text" 
                                            value="${row.material_id ? row.material_id : ''}" 
                                            hidden 
                                            autocomplete="off">
                                  </td>`
        tbodyTableSavePartNon += `<td class="d-none">
                                    <input  type="text" 
                                            value="${row.inventory_item_id ? row.inventory_item_id : ''}" 
                                            hidden 
                                            autocomplete="off">
                                  </td>`
        tbodyTableSavePartNon += `<td class="d-none">
                                    <input  type="text" 
                                            value="" 
                                            hidden 
                                            autocomplete="off">
                                  </td>`
        tbodyTableSavePartNon += `</tr>`
        sum10 += 10
      })
    }
    $("#setTbodyTableSavePartNon").html(tbodyTableSavePartNon);
    if (mustReload) {
        await setTimeout(function(){
            workOrderMtAllNon(status)
        }, 15000); // 15 s
    }
    readonly();
    setSelect2InEAM0010TbodyTableSavePartNon();

    data.data.filter(row => {
      //Default Item Type
      var newOptionItemCode = new Option(row.item_code, row.item_code, true, true);
      $(`#itemCodeNon${indexShow}`).append(newOptionItemCode).trigger('change');
      $(`#itemCodeNon${indexShow}`).val(row.item_code ? row.item_code : '').trigger('change');
      $(`#itemDesNon${indexShow}`).val(row.item_description ? row.item_description : '').trigger('change');
      indexShow += 10
    })
  }

  $("#addSavePartNonBtn").click(() => {
    setAddTableSavePartNonFn()
  })

  function setAddTableSavePartNonFn() {
    let sum10     = 0;
    let listData  = [];
    let listData2 = [];
    let maxVal    = 0;

    if(maxSeq == 0){
      maxSeq = 4;
    }else{
      maxSeq += 1;
    }

    console.log(maxSeq, 'setAddTableSavePartNonFn');

    $("#setTbodyTableSavePartNon td .sum10").each(function() {
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
    let tbodyTableSavePartNon = ''
    let optionWorkOrder = ''
      optionWorkOrder += `<option value=""></option>`
    for (let data of dataDropDownWorkOrder) {
      optionWorkOrder += `<option value="${data.operation_seq_num}" ${'10' == data.operation_seq_num ? 'selected' : ''}>${data.operation_seq_num}</option>`
    }
    let optionItemType = ''
      optionItemType += `<option value=""></option>`
    for (let data of dataDropDownItemType) {
      if (data.lookup_code == 2) {
        optionItemType += `<option value="${data.lookup_code}" ${data.lookup_code == 2 ? 'selected' : ''}>${data.meaning}</option>`
      }
    }
    tbodyTableSavePartNon += `<tr>`
    tbodyTableSavePartNon += `<td class="text-center">
                                <input  type="checkbox" 
                                        onclick="checkBoxOnClick()" 
                                        name="case[]">
                                        <input type="hidden" class="sum10" value="${+sum10 + 10}">
                              </td>`
    tbodyTableSavePartNon += `<td>
                                <select class="form-control workOrderTbMT" required >`+optionWorkOrder+`</select>
                              </td>`
    tbodyTableSavePartNon += `<td>
                                <select class="form-control itemTypeTbMT" required disabled>`+optionItemType+`</select>
                              </td>`
    tbodyTableSavePartNon += `<td>
                                <div class="input-group">
                                  <select id="itemCodeNon${+sum10 + 10}"
                                          name="item_code" 
                                          class="itemCode form-control clearable readonly" 
                                          data-server="/eam/ajax/lov/item-nonstock"  
                                          data-id="item_code" 
                                          data-field="select"
                                          required
                                          data-setAjaxDetailItemCodeNon = "itemCodeNon${+sum10 + 10}"
                                          data-typeAjaxDetailItemCodeNon = "itemCodeNon${+sum10 + 10}">
                                  </select>
                                  <div class="input-group-append">
                                    <span class="input-group-append">
                                      <button onclick="itemCodeNonLovBtnTableOnclick('itemCodeNon${+sum10 + 10}')" type="button" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </span>
                                  </div>
                                </div>
                              </td>`
    tbodyTableSavePartNon += `<td><input  type="text" 
                                          class="form-control" 
                                          value="" 
                                          required 
                                          autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td><input  id="requiredQuantityAdd${+sum10 + 10}"
                                          onkeypress="checkValue({index: ${+sum10 + 10}})"
                                          onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? 
                                                                        true : 
                                                                        !isNaN(Number(event.key)) && event.code!=='Space'" 
                                          type="number" 
                                          class="form-control" 
                                          value="" 
                                          required 
                                          autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td><select class="form-control" 
                                          required 
                                          disabled>
                                  </select>
                              </td>`
    tbodyTableSavePartNon += `<td><input  onkeydown="javascript: return ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Period'].includes(event.code) ? 
                                                                          true : 
                                                                          !isNaN(Number(event.key)) && event.code!=='Space'"
                                          min="1"
                                          type="text" 
                                          class="form-control" 
                                          value="" 
                                          autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td>
                                <div class="input-group">
                                  <input id="prNumber${+sum10 + 10}" type="text" class="form-control readonly" value="" required disabled autocomplete="off">
                                  <div class="input-group-append">
                                    <span class="input-group-append">
                                      <button onclick="delPrNumber('prNumber${+sum10 + 10}')" type="button" class="btn btn-default" disabled><i class="fa fa-trash"></i></button>
                                    </span>
                                  </div>
                                </div>
                              </td>`
    tbodyTableSavePartNon += `<td>
                                <input type="text" class="form-control" value="" disabled autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td>
                                <input type="text" class="form-control" value="" disabled autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="${maxSeq}" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="add" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `</tr>`
    $("#setTbodyTableSavePartNon").append(tbodyTableSavePartNon);
    readonly();
    setSelect2InEAM0010TbodyTableSavePartNon();
    triggerSelect2InEAM0010();

    $(`#itemCodeNon${+sum10 + 10}`).on('select2:select', function (e) {
      $(this).select2('data')[0].text = $(this).select2('data')[0].id;
    });

    $(`#itemCodeNon${+sum10 + 10}`).on('select2:clear', function (e) {
      $(`#itemCodeNon${+sum10 + 10}`).parents('tr').find("td:eq(4) input[type='text']").val('');
      $(`#itemCodeNon${+sum10 + 10}`).parents('tr')
                                     .find("td:eq(6) select")
                                     .html('');
    });
  }

  function setDefaultTableSavePartNonFn() {
    let sum10                 = 0;
    let tbodyTableSavePartNon = '';
    let optionWorkOrder       = '';
    let seq                   = 1;
      optionWorkOrder += `<option value=""></option>`
    for (const [i, data] of dataDropDownWorkOrder.entries()) {
      optionWorkOrder += `<option value="${data.operation_seq_num}" ${i == '0' ? 'selected' : ''}>${data.operation_seq_num}</option>`
    }
    
    let optionItemType = ''
      optionItemType += `<option value=""></option>`
    for (let data of dataDropDownItemType) {
      if (data.lookup_code == 2) {
        optionItemType += `<option value="${data.lookup_code}" ${data.lookup_code == 2 ? 'selected' : ''}>${data.meaning}</option>`
      }
    }

    $("#checkboxAllTableNon").prop('disabled', false);

    for (i = 0; i < 3; i++) {
      tbodyTableSavePartNon += `<tr>`
      tbodyTableSavePartNon += `<td class="text-center">
                                  <input  type="checkbox" 
                                          onclick="checkBoxOnClick()" 
                                          name="case[]" 
                                          ${statusDisabledMt ? 'disabled' : ''}>
                                          <input type="hidden" class="sum10" value="${+sum10 + 10}">
                                </td>`
      tbodyTableSavePartNon += `<td>
                                  <select class="form-control workOrderTbMT" 
                                          ${i == '0' ? 'required' : ''} 
                                          ${statusDisabledMt ? 'disabled' : ''}>`+optionWorkOrder+`
                                  </select>
                                </td>`
      tbodyTableSavePartNon += `<td>
                                  <select class="form-control itemTypeTbMT" 
                                          ${i == '0' ? 'required' : ''} 
                                          ${statusDisabledMt ? 'disabled' : 'disabled'}>`+optionItemType+`
                                  </select>
                                </td>`
      tbodyTableSavePartNon += `<td>
                                <div class="input-group">
                                  <select id="itemCodeNon${+sum10 + 10}"
                                          name="item_code" 
                                          class="itemCode form-control clearable readonly" 
                                          data-server="/eam/ajax/lov/item-nonstock"  
                                          data-id="item_code" 
                                          data-field="select"
                                          ${i == '0' ? 'required' : ''}
                                          ${statusDisabledMt ? 'disabled' : ''}
                                          data-setAjaxDetailItemCodeNon = "itemCodeNon${+sum10 + 10}"
                                          data-typeAjaxDetailItemCodeNon = "itemCodeNon${+sum10 + 10}">
                                  </select>
                                  <div class="input-group-append">
                                    <span class="input-group-append">
                                      <button onclick="itemCodeNonLovBtnTableOnclick('itemCodeNon${+sum10 + 10}')"
                                              type="button" 
                                              class="btn btn-default">
                                        <i class="fa fa-search"></i>
                                      </button>
                                    </span>
                                  </div>
                                </div>
                              </td>`
      tbodyTableSavePartNon += `<td><input  type="text" 
                                            class="form-control" 
                                            value="" ${i == '0' ? 'required' : ''} 
                                            autocomplete="off"
                                            ${statusDisabledMt ? 'disabled' : ''}>
                                </td>`
      tbodyTableSavePartNon += `<td>
                                    <input  id="requiredQuantityDF${i}"
                                            onkeypress="checkValue({index: ${i}})"
                                            onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? 
                                                                          true : 
                                                                          !isNaN(Number(event.key)) && event.code!=='Space'" 
                                            type="number" 
                                            class="form-control" 
                                            value="" ${i == '0' ? 'required' : ''} 
                                            autocomplete="off" 
                                            ${statusDisabledMt ? 'disabled' : ''}>
                                </td>`
      tbodyTableSavePartNon += `<td>
                                  <select class="form-control" 
                                          disabled ${i == '0' ? 'required' : ''}>
                                  </select>
                                </td>`
      tbodyTableSavePartNon += `<td>
                                  <input  onkeydown="javascript: return ['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight', 'Period'].includes(event.code) ? 
                                                                          true : 
                                                                          !isNaN(Number(event.key)) && event.code!=='Space'" 
                                          smin="1"
                                          type="text" 
                                          class="form-control" 
                                          value="" 
                                          autocomplete="off" 
                                          ${statusDisabledMt ? 'disabled' : ''}>
                                </td>`
      tbodyTableSavePartNon += `<td>
                                  <div class="input-group">
                                    <input  id="prNumber${+sum10 + 10}" 
                                            type="text" 
                                            class="form-control readonly" 
                                            value="" 
                                            required 
                                            disabled 
                                            autocomplete="off">
                                    <div class="input-group-append">
                                      <span class="input-group-append">
                                        <button onclick="delPrNumber('prNumber${+sum10 + 10}')" 
                                                type="button" 
                                                class="btn btn-default" 
                                                disabled>
                                                <i class="fa fa-trash"></i>
                                        </button>
                                      </span>
                                    </div>
                                  </div>
                                </td>`
                                tbodyTableSavePartNon += `<td>
                                <input type="text" class="form-control" value="" disabled autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td>
                                <input type="text" class="form-control" value="" disabled autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="${seq}" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `<td class="d-none">
                                <input type="text" value="add" hidden autocomplete="off">
                              </td>`
    tbodyTableSavePartNon += `</tr>`
    sum10 += 10;
    seq += 1;
    }
    $("#setTbodyTableSavePartNon").html(tbodyTableSavePartNon);
    readonly();
    setSelect2InEAM0010TbodyTableSavePartNon();
    triggerSelect2InEAM0010();
  }

  $("#checkboxAllTableNon").click((e) => { 
    var table = $(e.target).closest('table');
    if ($("#checkboxAllTableNon").prop('checked')) {
      $('td input:checkbox:not([disabled])', table).prop('checked', $("#checkboxAllTableNon").prop('checked'));
    } else {
      $('td input:checkbox', table).prop('checked', $("#checkboxAllTableNon").prop('checked'));
    }
  })

  $("#saveSavePartNonBtn").click(() => {
    $("#saveSavePartNonBtnHide").click();
  })

  function formSaveSavePartNonBtnHide() { 
    swal({
        title: `\nคุณแน่ใจไหม?`, // new line is a workaround for icon cover text
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
      $("#setTbodyTableSavePartNon tr").each(function() {
        if (($(this).find("td:eq(1) select").val() != '' && $(this).find("td:eq(1) select").val() != null) && 
            ($(this).find("td:eq(2) select").val() != '' && $(this).find("td:eq(2) select").val() != null) && 
            ($(this).find("td:eq(3) select").val() != '' && $(this).find("td:eq(3) select").val() != null) && 
            ($(this).find("td:eq(5) input").val() != '' && $(this).find("td:eq(5) input").val() != null)) {
          let data = {
            attribute1:             $(this).find("td:eq(11) input[type='text']").val(),
            attribute2:             $(this).find("td:eq(4) input[type='text']").val(),
            attribute3:             $(this).find("td:eq(5) input[type='text']").val(),
            attribute4:             $(this).find("td:eq(13) input[type='text']").val(),
            attribute5:             $(this).find("td:eq(14) input[type='text']").val(),
            attribute6:             $(this).find("td:eq(15) input[type='text']").val(),
            attribute7:             $(this).find("td:eq(16) input[type='text']").val(),
            attribute8:             $(this).find("td:eq(17) input[type='text']").val(),
            attribute9:             $(this).find("td:eq(18) input[type='text']").val(),
            attribute10:            $(this).find("td:eq(19) input[type='text']").val(),
            attribute11:            $(this).find("td:eq(20) input[type='text']").val(),
            attribute12:            $(this).find("td:eq(21) input[type='text']").val(),
            attribute13:            $(this).find("td:eq(22) input[type='text']").val(),
            attribute14:            $(this).find("td:eq(23) input[type='text']").val(),
            attribute15:            $(this).find("td:eq(24) input[type='text']").val(),
            material_id:            $(this).find("td:eq(25) input[type='text']").val(),
            inventory_item_id:      $(this).find("td:eq(26) input[type='text']").val(),
            item_code:              $(this).find("td:eq(3) select").val(),
            item_description:       $(this).find("td:eq(4) input[type='text']").val(),
            item_primary_uom_code:  $(this).find("td:eq(6) select").val(),
            item_type_desc:         $(this).find("td:eq(2) option:selected").text(),
            item_type_id:           $(this).find("td:eq(2) select").val(),
            operation_seq_num:      $(this).find("td:eq(1) select").val(),
            or_wip_entity_id:       or_wip_entity_id,
            organization_id:        organization_id,
            po_number:              $(this).find("td:eq(9) input[type='text']").val(),
            pr_number:              $(this).find("td:eq(8) input[type='text']").val(),
            received_qty:           $(this).find("td:eq(10) input[type='text']").val(),
            required_quantity:      $(this).find("td:eq(5) input[type='number']").val(),
            unit_price:             $(this).find("td:eq(7) input[type='text']").val(),
            wip_entity_id:          wip_entity_id,
          }
          dataSave.push(data)
        }
      })
      if (dataSave.length > 0) {
        $.ajax({
          url: "{{ route('eam.ajax.work-order.mtdirect.store') }}",
          type: "POST",
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
          data: JSON.stringify({data: dataSave}),
          success: function (response) {
            swal("Success", response.message, "success");
            workOrderMtAllNon(true);
          },
          error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
          }
        })
      } else {
        swal("กรุณาเพิ่มรายการ", "", "warning");
      }
    })
  }

  $("#deleteSavePartNonBtn").click(() => {
    let dataSaveCheckAdd = []
    let dataSave = []
    $("#setTbodyTableSavePartNon input[type='checkbox']:checked").each(function() {
      if ($(this).parents('tr').find("td:eq(27) input[type='text']").val() == 'add') {
        dataSaveCheckAdd.push($(this).parents('tr'));
      } else {
        let data = {
          attribute1:             $(this).parents('tr').find("td:eq(11) input[type='text']").val(),
          attribute2:             $(this).parents('tr').find("td:eq(4) input[type='text']").val(),
          attribute3:             $(this).parents('tr').find("td:eq(5) input[type='text']").val(),
          attribute4:             $(this).parents('tr').find("td:eq(13) input[type='text']").val(),
          attribute5:             $(this).parents('tr').find("td:eq(14) input[type='text']").val(),
          attribute6:             $(this).parents('tr').find("td:eq(15) input[type='text']").val(),
          attribute7:             $(this).parents('tr').find("td:eq(16) input[type='text']").val(),
          attribute8:             $(this).parents('tr').find("td:eq(17) input[type='text']").val(),
          attribute9:             $(this).parents('tr').find("td:eq(18) input[type='text']").val(),
          attribute10:            $(this).parents('tr').find("td:eq(19) input[type='text']").val(),
          attribute11:            $(this).parents('tr').find("td:eq(20) input[type='text']").val(),
          attribute12:            $(this).parents('tr').find("td:eq(21) input[type='text']").val(),
          attribute13:            $(this).parents('tr').find("td:eq(22) input[type='text']").val(),
          attribute14:            $(this).parents('tr').find("td:eq(23) input[type='text']").val(),
          attribute15:            $(this).parents('tr').find("td:eq(24) input[type='text']").val(),
          material_id:            $(this).parents('tr').find("td:eq(25) input[type='text']").val(),
          inventory_item_id:      $(this).parents('tr').find("td:eq(26) input[type='text']").val(),
          item_code:              $(this).parents('tr').find("td:eq(3) select").val(),
          item_description:       $(this).parents('tr').find("td:eq(4) input[type='text']").val(),
          item_primary_uom_code:  $(this).parents('tr').find("td:eq(6) select").val(),
          item_type_desc:         $(this).parents('tr').find("td:eq(2) option:selected").text(),
          item_type_id:           $(this).parents('tr').find("td:eq(2) select").val(),
          operation_seq_num:      $(this).parents('tr').find("td:eq(1) select").val(),
          or_wip_entity_id:       or_wip_entity_id,
          organization_id:        organization_id,
          po_number:              $(this).parents('tr').find("td:eq(9) input[type='text']").val(),
          pr_number:              $(this).parents('tr').find("td:eq(8) input[type='text']").val(),
          received_qty:           $(this).parents('tr').find("td:eq(10) input[type='text']").val(),
          required_quantity:      $(this).parents('tr').find("td:eq(5) input[type='number']").val(),
          unit_price:             $(this).parents('tr').find("td:eq(7) input[type='text']").val(),
          wip_entity_id:          wip_entity_id,
        }
        dataSave.push(data)
      }
    })
    if (dataSave.length > 0) {
      $.ajax({
        url: "{{ route('eam.ajax.work-order.mtdirect.delete') }}",
        type: "POST",
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        data: JSON.stringify({data: dataSave}),
        success: function (response) {
          swal("Success", response.message, "success");
          workOrderMtAllNon(true);
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    } else if (dataSaveCheckAdd.length > 0) {
      dataSaveCheckAdd.filter(row => {
        $(row).remove();
      })
    } else {
      swal("กรุณาเลือกรายการ", "", "warning");
    }

    if($("#setTbodyTableSavePartNon input[type='checkbox']").length == 0){
      $("#checkboxAllTableNon").prop('checked',false);
    }else{
      if($("#setTbodyTableSavePartNon input[type='checkbox']:checked").length != 
         $("#setTbodyTableSavePartNon input[type='checkbox']").length){
        $("#checkboxAllTableNon").prop('checked',false);
      }else{
        $("#checkboxAllTableNon").prop('checked',true);
      }
    }
  })

  function delPrNumber(data) {
    swal({
      title: "ต้องการลบ PR Number หรือไม่",
      text: "",
      type: "warning",
      showCancelButton: true
    },
    function(){
      let dataSave = [{
        attribute1:             $("#"+data).parents('tr').find("td:eq(11) input[type='text']").val(),
        attribute2:             $("#"+data).parents('tr').find("td:eq(4) input[type='text']").val(),
        attribute3:             $("#"+data).parents('tr').find("td:eq(5) input[type='text']").val(),
        attribute4:             $("#"+data).parents('tr').find("td:eq(13) input[type='text']").val(),
        attribute5:             $("#"+data).parents('tr').find("td:eq(14) input[type='text']").val(),
        attribute6:             $("#"+data).parents('tr').find("td:eq(15) input[type='text']").val(),
        attribute7:             $("#"+data).parents('tr').find("td:eq(16) input[type='text']").val(),
        attribute8:             $("#"+data).parents('tr').find("td:eq(17) input[type='text']").val(),
        attribute9:             $("#"+data).parents('tr').find("td:eq(18) input[type='text']").val(),
        attribute10:            $("#"+data).parents('tr').find("td:eq(19) input[type='text']").val(),
        attribute11:            $("#"+data).parents('tr').find("td:eq(20) input[type='text']").val(),
        attribute12:            $("#"+data).parents('tr').find("td:eq(21) input[type='text']").val(),
        attribute13:            $("#"+data).parents('tr').find("td:eq(22) input[type='text']").val(),
        attribute14:            $("#"+data).parents('tr').find("td:eq(23) input[type='text']").val(),
        attribute15:            $("#"+data).parents('tr').find("td:eq(24) input[type='text']").val(),
        material_id:            $("#"+data).parents('tr').find("td:eq(25) input[type='text']").val(),
        inventory_item_id:      $("#"+data).parents('tr').find("td:eq(26) input[type='text']").val(),
        item_code:              $("#"+data).parents('tr').find("td:eq(3) select").val(),
        item_description:       $("#"+data).parents('tr').find("td:eq(4) input[type='text']").val(),
        item_primary_uom_code:  $("#"+data).parents('tr').find("td:eq(6) select").val(),
        item_type_desc:         $("#"+data).parents('tr').find("td:eq(2) option:selected").text(),
        item_type_id:           $("#"+data).parents('tr').find("td:eq(2) select").val(),
        operation_seq_num:      $("#"+data).parents('tr').find("td:eq(1) select").val(),
        or_wip_entity_id:       or_wip_entity_id,
        organization_id:        organization_id,
        po_number:              $("#"+data).parents('tr').find("td:eq(9) input[type='text']").val(),
        pr_number:              $("#"+data).parents('tr').find("td:eq(8) input[type='text']").val(),
        received_qty:           $("#"+data).parents('tr').find("td:eq(10) input[type='text']").val(),
        required_quantity:      $("#"+data).parents('tr').find("td:eq(5) input[type='number']").val(),
        unit_price:             $("#"+data).parents('tr').find("td:eq(7) input[type='text']").val(),
        wip_entity_id:          wip_entity_id,
      }]

      $.ajax({
        url: "{{ route('eam.ajax.work-order.mtdirectpr.delete') }}",
        type: "POST",
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        data: JSON.stringify({data: dataSave}),
        success: function (response) {
          swal("Success", response.message, "success");
          workOrderMtAllNon(true);
        },
        error: function (jqXHR, textStatus, errorRhrown) {
          swal("Error", jqXHR.responseJSON.message, "error");
        }
      })
    })
  }

  async function checkValue(data) {
    setTimeout(await function() {
      let valueRequiredQuantity = 0;
      let valueRequiredQuantityAdd = 0;
      let valueRequiredQuantityDF = 0;
      valueRequiredQuantity = $("#requiredQuantity" + data.index).val();
      valueRequiredQuantityAdd = $("#requiredQuantityAdd" + data.index).val();
      valueRequiredQuantityDF = $("#requiredQuantityDF" + data.index).val();

      if(valueRequiredQuantity == 0){
        swal("Error", 'ไม่สามารถกรอก จำนวนที่ต้องการใช้น้อยกว่าหรือเท่ากับ 0 ได้', "error");
        $("#requiredQuantity" + data.index).val('').trigger('change');
      }

      if(valueRequiredQuantityAdd == 0){
        swal("Error", 'ไม่สามารถกรอก จำนวนที่ต้องการใช้น้อยกว่าหรือเท่ากับ 0 ได้', "error");
        $("#requiredQuantityAdd" + data.index).val('').trigger('change');
      }

      if(valueRequiredQuantityDF == 0){
        swal("Error", 'ไม่สามารถกรอก จำนวนที่ต้องการใช้น้อยกว่าหรือเท่ากับ 0 ได้', "error");
        $("#requiredQuantityDF" + data.index).val('').trigger('change');
      }
    }, 100)
  }
</script>