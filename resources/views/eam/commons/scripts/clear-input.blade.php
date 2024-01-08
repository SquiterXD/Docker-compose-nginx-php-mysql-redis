<script>
  function tog(v){return v?'addClass':'removeClass';} 
  $(document).on('input', '.clearable', function(){
    $(this)[tog(this.value)]('x');
  }).on('mousemove', '.x', function( e ){
    $(this)[tog(this.offsetWidth-18 < e.clientX-this.getBoundingClientRect().left)]('onX');   
  }).on('click', '.onX', function(){
    $(this).removeClass('x onX').val('');
    if ($(this).attr('id') == 'workOrderNumber' && $("#eam0007").attr('id') === 'eam0007') {
      clearDataLovWorkOrderNumber()
    } else if ($(this).attr('id') == 'modalReportWorkOrderNotifyingAgency' && $("#eam0007").attr('id') === 'eam0007') {
      $("#modalReportWorkOrderNotifyingAgencyDesc").val('')
    } else if ($(this).attr('id') == 'modalReportWorkOrderReportingAgency' && $("#eam0007").attr('id') === 'eam0007') {
      $("#modalReportWorkOrderReportingAgencyDesc").val('')
    } else if ($(this).attr('id') == 'assetNumber' && $("#eam0007").attr('id') === 'eam0007') {
      $("#machineName").val('')
    } else if ($(this).attr('id') == 'workReceiptNumber' && $("#eam0010").attr('id') === 'eam0010') {
      clearDataLovWorkReceiptNumber()
    } else if ($(this).attr('class').split(' ')[0] == 'itemCode' && $("#eam0010").attr('id') === 'eam0010') {
      clearDescItemCode($(this))
    } else if ($(this).attr('class').split(' ')[0] == 'employeeTbLB' && $("#eam0010").attr('id') === 'eam0010') {
      clearDescEmployeeTbLB($(this))
    } else if ($(this).attr('id') == 'workReceiptNumber' && $("#eam0014").attr('id') === 'eam0014') {
      wip_entity_id = ''
    } else if ($(this).attr('id') == 'workReceiptNumber' && $("#eam0016").attr('id') === 'eam0016') {
      wip_entity_id = ''
    } else if ($(this).attr('id') == 'assetVNumber' && $("#eam0003").attr('id') === 'eam0003') {
      clearDataLovResourceAssetNumber()
    } else if ($(this).attr('id') == 'modalReportWorkReceiptNotifyingAgency' && $("#eam0010").attr('id') === 'eam0010') {
      $("#modalReportWorkReceiptNotifyingAgencyDesc").val('')
    } else if ($(this).attr('id') == 'modalReportSummaryMonthInformDept') {
      $("#modalReportSummaryMonthInformDeptDesc").val('')
    } else if ($(this).attr('id') == 'modalReportSummaryMonthOwningDepartment') {
      $("#modalReportSummaryMonthOwningDepartmentDesc").val('')
    } else if ($(this).attr('class').split(' ')[0] == 'assetNumber' && $("#eam0006").attr('id') === 'eam0006') {
      clearDescAssetNumber($(this))
    } else if ($(this).attr('id') == 'requestEquipNo' && $("#eam0017").attr('id') === 'eam0017') {
      $("#requestStatus").html('')
      $("#setTbodyTable").html('')
    } else if ($(this).attr('class').split(' ')[0] == 'itemCode' && $("#eam0017").attr('id') === 'eam0017') {
      $(this).parents('tr').find("td:eq(2) input[type='text']").val('');
      $(this).parents('tr').find("td:eq(8) select").html(`<option value=""></option>`);
    } else if ($(this).attr('id') == 'assetNumber' && $("#eam0010").attr('id') === 'eam0010') {
      $("#activitiesToDo").html(`<option value=""></option>`);
      departmentCodeInAssetNumber = ''
      $("#machineName").val('');
      $("#machineGroup").val('');
      $("#class").val('');
      $("#class").removeClass('x');
    } else if ($(this).attr('id') == 'mntHistoryDepartment' && $("#eam0033").attr('id') === 'eam0033') {
      $("#mntHistoryDepartmentDesc").val('')
    } else if ($(this).attr('id') == 'mntHistoryOwningDepartment' && $("#eam0033").attr('id') === 'eam0033') {
      $("#mntHistoryOwningDepartmentDesc").val('')
    } else if ($(this).attr('id') == 'mntHistoryEmployee' && $("#eam0033").attr('id') === 'eam0033') {
      $("#mntHistoryEmployeeDesc").val('')
    } else if ($(this).attr('id') == 'maintenanceDepartment' && $("#eam0034").attr('id') === 'eam0034') {
      $("#maintenanceDepartmentDesc").val('')
    } else if ($(this).attr('id') == 'maintenanceOwningDepartment' && $("#eam0034").attr('id') === 'eam0034') {
      $("#maintenanceOwningDepartmentDesc").val('')
    } else if ($(this).attr('id') == 'maintenanceEmployee' && $("#eam0034").attr('id') === 'eam0034') {
      $("#maintenanceEmployeeDesc").val('')
    } else if ($(this).attr('id') == 'woComStatusDepartment' && $("#eam0039").attr('id') === 'eam0039') {
      $("#woComStatusDepartmentDesc").val('')
    } else if ($(this).attr('id') == 'woComStatusOwningDepartment' && $("#eam0039").attr('id') === 'eam0039') {
      $("#woComStatusOwningDepartmentDesc").val('')
    } else if ($(this).attr('id') == 'woCostOwningDepartment' && $("#eam0038").attr('id') === 'eam0038') {
      $("#woCostOwningDepartmentDesc").val('')
    } else if ($(this).attr('id') == 'woCostDepartment' && $("#eam0038").attr('id') === 'eam0038') {
      $("#woCostDepartmentDesc").val('')
    } else if ($(this).attr('id') == 'summaryLaborDepartment' && $("#eam0024").attr('id') === 'eam0024') {
      $("#summaryLaborDepartmentDesc").val('')
    } else if ($(this).attr('id') == 'summaryMatStatusDepartment' && $("#eam0041").attr('id') === 'eam0041') {
      $("#summaryMatStatusDepartmentDesc").val('')
    }
  });
</script>
