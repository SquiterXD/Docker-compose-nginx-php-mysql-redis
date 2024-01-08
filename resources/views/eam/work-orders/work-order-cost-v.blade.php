<script>
  $("#viewCompeletBtn").click(() => {
    $.ajax({
      url: "{{ route('eam.ajax.work-order.cost.all',['']) }}/" + wip_entity_id,
      method: 'GET',
      success: function (response) {
        setTableViewCompleteFn(response);
        $('#hideTbViewComplete').css('display', '')
        $("#btnHideViewComplete").removeClass("pointer fa fa-caret-down");
        $("#btnHideViewComplete").addClass("pointer fa-caret-up fa");
      },
      error: function (jqXHR, textStatus, errorRhrown) {
        swal("Error", jqXHR.responseJSON.message, "error");
      }
    })
  })
  function setTableViewCompleteFn(data) {
    let tbodyTableViewComplete = ''
    if (data.data.length > 0) {
      data.data.filter(row => {
        tbodyTableViewComplete += `<tr>`
        tbodyTableViewComplete += `<td><input type="text" class="form-control" value="${row.cost_category_meaning ? row.cost_category_meaning : ''}" disabled autocomplete="off"></td>`
        tbodyTableViewComplete += `<td><input type="text" class="form-control" value="${row.actual_total_cost ? row.actual_total_cost : ''}" disabled autocomplete="off"></td>`
        tbodyTableViewComplete += `<td><input type="text" class="form-control" value="${row.actual_material_cost ? row.actual_material_cost : ''}" disabled autocomplete="off"></td>`
        tbodyTableViewComplete += `<td><input type="text" class="form-control" value="${row.actual_labor_cost ? row.actual_labor_cost : ''}" disabled autocomplete="off"></td>`
        tbodyTableViewComplete += `<td><input type="text" class="form-control" value="${row.actual_equipment_cost ? row.actual_equipment_cost : ''}" disabled autocomplete="off"></td>`
        tbodyTableViewComplete += `</tr>`
      })
    }
    $("#setTbodyTableViewComplete").html(tbodyTableViewComplete);
  }
</script>