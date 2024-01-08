var dataArrRequestEquipNo = [];

function triggerSelect2()
{   
    $(  '.ibox-content select[data-server],' +
        '#eam0006 #setTbodyTable select[data-server!=""],' + 
        '#eam0007 #detailReportWorkOrder select[data-server],'+
        '#eam0017 #setTbodyTable select[data-server!=""],'+
        '#eam0017 #detailReportBillMaterials select[data-server],'+
        '#eam0010 #detailReportWorkReceipt select[data-server]').each(function (el, item) {
        if($(item).val() != null) {
            return true;
        }
        var url = $(item).attr('data-server')
        var field = $(item).attr('data-field')
        var text = $(item).attr('data-text')
        var id = $(item).attr('data-id')

        // หน่วยงาน
        var dataDepartment = $(item).attr('data-department');

        // ผู้รับแจ้ง
        var setAjaxRepairerId = $(item).attr('data-setAjaxRepairerId');

        //ผู้รับแจ้ง
        var setAjaxNotifierId = $(item).attr('data-setAjaxNotifierId');

        var setAjaxSummaryLaborDepartmentDesc = $(item).attr('data-setAjaxSummaryLaborDepartmentDesc');
        var setAjaxSummaryLaborDepartment = $(item).attr('data-setAjaxSummaryLaborDepartment');
        var typeAjaxSummaryLaborDepartment = $(item).attr('data-typeAjaxSummaryLaborDepartmentDesc');

        var setAjaxReportSummaryMonthOwningDepartmentDesc = $(item).attr('data-setAjaxReportSummaryMonthOwningDepartmentDesc');
        var setAjaxReportSummaryMonthOwningDepartment = $(item).attr('data-setAjaxReportSummaryMonthOwningDepartment');
        var typeAjaxReportSummaryMonthOwningDepartment = $(item).attr('data-typeAjaxReportSummaryMonthOwningDepartment');

        var setAjaxReportSummaryMonthInformDeptDesc = $(item).attr('data-setAjaxReportSummaryMonthInformDeptDesc');
        var setAjaxReportSummaryMonthInformDept = $(item).attr('data-setAjaxReportSummaryMonthInformDept');
        var typeAjaxReportSummaryMonthInformDept = $(item).attr('data-typeAjaxReportSummaryMonthInformDept');

        var setAjaxMNTHistoryDepartment = $(item).attr('data-setAjaxMNTHistoryDepartment');
        var setAjaxMNTHistoryDepartmentDesc = $(item).attr('data-setAjaxMNTHistoryDepartmentDesc');
        var typeAjaxMNTHistoryDepartment = $(item).attr('data-typeAjaxMNTHistoryDepartment');

        var setAjaxMNTHistoryOwningDepartment = $(item).attr('data-setAjaxMNTHistoryOwningDepartment');
        var setAjaxMNTHistoryOwningDepartmentDesc = $(item).attr('data-setAjaxMNTHistoryOwningDepartmentDesc');
        var typeAjaxMNTHistoryOwningDepartment = $(item).attr('data-typeAjaxMNTHistoryOwningDepartment');

        var setAjaxMNTHistoryEmployee = $(item).attr('data-setAjaxMNTHistoryEmployee');
        var setAjaxMNTHistoryEmployeeDesc = $(item).attr('data-setAjaxMNTHistoryEmployeeDesc');
        var typeAjaxMNTHistoryEmployee = $(item).attr('data-typeAjaxMNTHistoryEmployee');

        var setAjaxMaintenanceDepartment = $(item).attr('data-setAjaxMaintenanceDepartment');
        var setAjaxMaintenanceDepartmentDesc = $(item).attr('data-setAjaxMaintenanceDepartmentDesc');
        var typeAjaxMaintenanceDepartment = $(item).attr('data-typeAjaxMaintenanceDepartment');

        var setAjaxMaintenanceOwningDepartment = $(item).attr('data-setAjaxMaintenanceOwningDepartment');
        var setAjaxMaintenanceOwningDepartmentDesc = $(item).attr('data-setAjaxMaintenanceOwningDepartmentDesc');
        var typeAjaxMaintenanceOwningDepartment = $(item).attr('data-typeAjaxMaintenanceOwningDepartment');

        var setAjaxMaintenanceEmployee = $(item).attr('data-setAjaxMaintenanceEmployee');
        var setAjaxMaintenanceEmployeeDesc = $(item).attr('data-setAjaxMaintenanceEmployeeDesc');
        var typeAjaxMaintenanceEmployee = $(item).attr('data-typeAjaxMaintenanceEmployee');

        var setAjaxWOCostDepartment = $(item).attr('data-setAjaxWOCostDepartment');
        var setAjaxWOCostDepartmentDesc = $(item).attr('data-setAjaxWOCostDepartmentDesc');
        var typeAjaxWOCostDepartment = $(item).attr('data-typeAjaxWOCostDepartment');

        var setAjaxWOCostOwningDepartment = $(item).attr('data-setAjaxWOCostOwningDepartment');
        var setAjaxWOCostOwningDepartmentDesc = $(item).attr('data-setAjaxWOCostOwningDepartmentDesc');
        var typeAjaxWOCostOwningDepartment = $(item).attr('data-typeAjaxWOCostOwningDepartment');

        var setAjaxWOComStatusDepartment = $(item).attr('data-setAjaxWOComStatusDepartment');
        var setAjaxWOComStatusDepartmentDesc = $(item).attr('data-setAjaxWOComStatusDepartmentDesc');
        var typeAjaxWOComStatusDepartment = $(item).attr('data-typeAjaxWOComStatusDepartment');

        var setAjaxWOComStatusOwningDepartment = $(item).attr('data-setAjaxWOComStatusOwningDepartment');
        var setAjaxWOComStatusOwningDepartmentDesc = $(item).attr('data-setAjaxWOComStatusOwningDepartmentDesc');
        var typeAjaxWOComStatusOwningDepartment = $(item).attr('data-typeAjaxWOComStatusOwningDepartment');

        var setAjaxSummaryMatStatusDepartment = $(item).attr('data-setAjaxSummaryMatStatusDepartment');
        var setAjaxSummaryMatStatusDepartmentDesc = $(item).attr('data-setAjaxSummaryMatStatusDepartmentDesc');
        var typeAjaxSummaryMatStatusDepartment = $(item).attr('data-typeAjaxSummaryMatStatusDepartment');

        var selectEAM0006AssetNumber = $(item).attr('data-selectEAM0006AssetNumber');
        var typeEAM0006AssetNumber = $(item).attr('data-typeEAM0006AssetNumber');

        var setAjaxWorkOrderNumberInEAM0007 = $(item).attr('data-setAjaxWorkOrderNumberInEAM0007')
        var typeWorkOrderNumberInEAM0007 = $(item).attr('data-typeWorkOrderNumberInEAM0007')

        var setAjaxWorkAssetNumberInEAM0007 = $(item).attr('data-setAjaxWorkAssetNumberInEAM0007')
        var typeWorkAssetNumberInEAM0007 = $(item).attr('data-typeWorkAssetNumberInEAM0007')

        var setAjaxModalReportWorkOrderNotifyingAgencyInEAM0007 = $(item).attr('data-setAjaxModalReportWorkOrderNotifyingAgencyInEAM0007');
        var setAjaxModalReportWorkOrderNotifyingAgencyInEAM0007Desc = $(item).attr('data-setAjaxModalReportWorkOrderNotifyingAgencyInEAM0007Desc');
        var typeModalReportWorkOrderNotifyingAgencyInEAM0007 = $(item).attr('data-typeModalReportWorkOrderNotifyingAgencyInEAM0007');

        var setAjaxModalReportWorkOrderReportingAgencyInEAM0007 = $(item).attr('data-setAjaxModalReportWorkOrderReportingAgencyInEAM0007');
        var setAjaxModalReportWorkOrderReportingAgencyInEAM0007Desc = $(item).attr('data-setAjaxModalReportWorkOrderReportingAgencyInEAM0007Desc');
        var typeModalReportWorkOrderReportingAgencyInEAM0007 = $(item).attr('data-typeModalReportWorkOrderReportingAgencyInEAM0007');

        var setAjaxReportingAgencyInEAM0007 = $(item).attr('data-setAjaxReportingAgencyInEAM0007')
        var typeReportingAgencyInEAM0007 = $(item).attr('data-typeReportingAgencyInEAM0007')

        var setAjaxNotifyingAgencyInEAM0007 = $(item).attr('data-setAjaxNotifyingAgencyInEAM0007')
        var typeNotifyingAgencyInEAM0007 = $(item).attr('data-typeNotifyingAgencyInEAM0007')

        var setAjaxSelectEAM0014GetWipEntityId = $(item).attr('data-setAjaxSelectEAM0014GetWipEntityId');

        var setAjaxSelectEAM0016GetWipEntityId = $(item).attr('data-setAjaxSelectEAM0016GetWipEntityId');

        var setAjaxItemCode = $(item).attr('data-setAjaxItemCode');
        var setAjaxItemCodeDesc = $(item).attr('data-setAjaxItemCodeDesc');
        var setAjaxPrimaryUom = $(item).attr('data-setAjaxPrimaryUom');
        var setAjaxInventoryItemId = $(item).attr('data-setAjaxInventoryItemId');

        var setAjaxEAM0017ModalReportBillMaterialsRequestStatus = $(item).attr('data-setAjaxEAM0017ModalReportBillMaterialsRequestStatus');
        var setAjaxEAM0017ModalReportBillMaterialsRequestStatusDesc = $(item).attr('data-setAjaxEAM0017ModalReportBillMaterialsRequestStatusDesc');
        var typeAjaxEAM0017ModalReportBillMaterialsRequestStatus = $(item).attr('data-typeAjaxEAM0017ModalReportBillMaterialsRequestStatus');

        var setAjaxEAM0017ModalReportBillMaterialsAgency = $(item).attr('data-setAjaxEAM0017ModalReportBillMaterialsAgency');
        var setAjaxEAM0017ModalReportBillMaterialsAgencyDesc = $(item).attr('data-setAjaxEAM0017ModalReportBillMaterialsAgencyDesc');
        var typeAjaxEAM0017ModalReportBillMaterialsAgency = $(item).attr('data-typeAjaxEAM0017ModalReportBillMaterialsAgency');

        var typeAjaxEAM0017RequestEquipNo = $(item).attr('data-typeAjaxEAM0017RequestEquipNo');

        var setAjaxEAM0010WorkReceiptNumber = $(item).attr('data-setAjaxEAM0010WorkReceiptNumber');
        var typeAjaxEAM0010WorkReceiptNumber = $(item).attr('data-typeAjaxEAM0010WorkReceiptNumber');

        var setAjaxEAM0010AssetNumber = $(item).attr('data-setAjaxEAM0010AssetNumber');
        var typeAjaxEAM0010AssetNumber = $(item).attr('data-typeAjaxEAM0010AssetNumber');

        var setAjaxModalReportSummaryEmployee = $(item).attr('data-setAjaxModalReportSummaryEmployee');
        var setAjaxModalReportSummaryEmployeeDesc = $(item).attr('data-setAjaxModalReportSummaryEmployeeDesc');
        var typeAjaxModalReportSummaryEmployee = $(item).attr('data-typeAjaxModalReportSummaryEmployee');

        $(item).select2({
            minimumInputLength: 2,
            language: 'th',
            placeholder: "เลือกข้อมูล",
            allowClear: true,
            ajax: {
                url: url,
                dataType: 'json',
                contentType: 'application/json',
                data: function (parm) {
                    var query = {};
                    query[field] = parm.term;
                    query['select2'] = 1;
                    query['page'] = parm.page || 1
                    if(dataDepartment != null) {
                        if($("#eam0003").attr('id') === 'eam0003'){
                            query['p_department_code'] = $("#notifyingAgency").val();
                        }else if($("#eam0010").attr('id') === 'eam0010'){
                            query['p_department_code'] = $("#notifyingAgency").val();
                        }else{
                            query['p_department_code'] = department_code;
                        }
                    }
                    return query;
                },
                processResults: function (data) {
                    if (typeof data.data.data === "undefined") {
                        var data = data.data
                    } else {
                        var data = data.data.data
                    }

                    if (typeof id === 'undefined') {
                        return false;
                    }
                    
                    if (typeof text !== 'undefined') {       
                        if(typeAjaxSummaryLaborDepartment){
                            dataLovDepartment = data
                        }

                        if(typeAjaxReportSummaryMonthOwningDepartment){
                            dataLovDepartment = data
                        }  
                        
                        if(typeAjaxReportSummaryMonthInformDept){
                            dataLovDepartment = data
                        } 
                        
                        if(typeAjaxMNTHistoryDepartment){
                            dataLovDepartment = data
                        } 

                        if(typeAjaxMNTHistoryOwningDepartment){
                            dataLovDepartment = data
                        } 

                        if(typeAjaxMNTHistoryEmployee){
                            dataLovEmployee = data
                        } 

                        if(typeAjaxMaintenanceDepartment){
                            dataLovDepartment = data
                        } 

                        if(typeAjaxMaintenanceOwningDepartment){
                            dataLovDepartment = data
                        } 

                        if(typeAjaxMaintenanceEmployee){
                            dataLovEmployee = data
                        } 

                        if(typeAjaxWOCostDepartment){
                            dataLovDepartment = data
                        } 

                        if(typeAjaxWOCostOwningDepartment){
                            dataLovDepartment = data
                        }
                        
                        if(typeAjaxWOComStatusDepartment){
                            dataLovDepartment = data
                        } 

                        if(typeAjaxWOComStatusOwningDepartment){
                            dataLovDepartment = data
                        }

                        if(typeAjaxSummaryMatStatusDepartment){
                            dataLovDepartment = data
                        }

                        if(typeEAM0006AssetNumber){
                            dataLovAssetNumber = data
                        }

                        if(typeWorkOrderNumberInEAM0007){
                            dataLovWorkOrderNumber = data
                        }

                        if(typeWorkAssetNumberInEAM0007){
                            dataLovAssetNumber = data
                        }

                        if(typeModalReportWorkOrderNotifyingAgencyInEAM0007){
                            dataLovDepartment = data
                        }

                        if(typeModalReportWorkOrderReportingAgencyInEAM0007){
                            dataLovDepartment = data
                        }

                        if(typeAjaxEAM0017ModalReportBillMaterialsAgency){
                            dataLovRequestStatus = data
                        }

                        if(typeAjaxEAM0017RequestEquipNo){
                            dataArrRequestEquipNo = data
                        }

                        if(typeAjaxEAM0017ModalReportBillMaterialsRequestStatus){
                            dataLovRequestStatus = data
                        }

                        if(typeAjaxEAM0010WorkReceiptNumber){
                            dataLovWorkReceiptNumber = data
                        }

                        if(typeAjaxEAM0010AssetNumber){
                            dataLovAssetNumber = data
                        }

                        if(typeReportingAgencyInEAM0007){
                            dataLovDepartment = data
                        }

                        if(typeNotifyingAgencyInEAM0007){
                            dataLovDepartment = data
                        }

                        if(typeAjaxModalReportSummaryEmployee){
                            dataLovEmployee = data
                        }

                        return {
                            results: $.map(data, function (item) {    
                                if($("#eam0017").attr('id') == 'eam0017' && id == 'item_code'){
                                    return {
                                        text: item[id] + " - " + item['item_description'],
                                        id: item[id],
                                        'data-json': item
                                    }
                                }else{
                                    return {
                                        text: item[id] + " - " + item[text],
                                        id: item[id],
                                        'data-json': item
                                    }
                                }                                
                            })
                        };
                    } else {       
                        if(typeAjaxSummaryLaborDepartment){
                            dataLovDepartment = data
                        }

                        if(typeAjaxReportSummaryMonthOwningDepartment){
                            dataLovDepartment = data
                        } 
                        
                        if(typeAjaxReportSummaryMonthInformDept){
                            dataLovDepartment = data
                        } 
                        
                        if(typeAjaxMNTHistoryDepartment){
                            dataLovDepartment = data
                        } 

                        if(typeAjaxMNTHistoryOwningDepartment){
                            dataLovDepartment = data
                        } 

                        if(typeAjaxMNTHistoryEmployee){
                            dataLovEmployee = data
                        } 

                        if(typeAjaxMaintenanceDepartment){
                            dataLovDepartment = data
                        } 

                        if(typeAjaxMaintenanceOwningDepartment){
                            dataLovDepartment = data
                        } 

                        if(typeAjaxMaintenanceEmployee){
                            dataLovEmployee = data
                        }

                        if(typeAjaxWOCostDepartment){
                            dataLovDepartment = data
                        } 

                        if(typeAjaxWOCostOwningDepartment){
                            dataLovDepartment = data
                        } 

                        if(typeAjaxWOComStatusDepartment){
                            dataLovDepartment = data
                        }

                        if(typeAjaxWOComStatusOwningDepartment){
                            dataLovDepartment = data
                        }

                        if(typeAjaxSummaryMatStatusDepartment){
                            dataLovDepartment = data
                        }

                        if(typeEAM0006AssetNumber){
                            dataLovAssetNumber = data
                        }

                        if(typeWorkOrderNumberInEAM0007){
                            dataLovWorkOrderNumber = data
                        }

                        if(typeModalReportWorkOrderNotifyingAgencyInEAM0007){
                            dataLovDepartment = data
                        }

                        if(typeModalReportWorkOrderReportingAgencyInEAM0007){
                            dataLovDepartment = data
                        }

                        if(typeAjaxEAM0017ModalReportBillMaterialsRequestStatus){
                            dataLovRequestStatus = data
                        }

                        if(typeAjaxEAM0017ModalReportBillMaterialsAgency){
                            dataLovRequestStatus = data
                        }

                        if(typeAjaxEAM0017RequestEquipNo){
                            dataArrRequestEquipNo = data
                        }

                        if(typeAjaxEAM0010WorkReceiptNumber){
                            dataLovWorkReceiptNumber = data
                        }

                        if(typeAjaxEAM0010AssetNumber){
                            dataLovAssetNumber = data
                        }

                        if(typeReportingAgencyInEAM0007){
                            dataLovDepartment = data
                        }

                        if(typeNotifyingAgencyInEAM0007){
                            dataLovDepartment = data
                        }

                        if(typeAjaxModalReportSummaryEmployee){
                            dataLovEmployee = data
                        }

                        return {
                            results: $.map(data, function (item) {
                                if($("#eam0032").attr('id') == 'eam0032' && id == 'wip_entity_name'){
                                    return {
                                        text: item[id],
                                        id: item[id],
                                        'data-json': item
                                    }
                                }else if ($("#eam0032").attr('id') == 'eam0032' && id == 'employee_number'){
                                    return {
                                        text: item[id] + " - " + item['full_name'],
                                        id: item[id],
                                        'data-json': item
                                    }
                                }else if ($("#eam0033").attr('id') == 'eam0033' && id == 'wip_entity_name') {
                                    return {
                                        text: item[id],
                                        id: item[id],
                                        'data-json': item
                                    }
                                }else if ($("#eam0033").attr('id') == 'eam0033' && id == 'employee_number') {
                                    return {
                                        text: item[id] + " - " + item['full_name'],
                                        id: item[id],
                                        'data-json': item
                                    }
                                }else if ($("#eam0021").attr('id') == 'eam0021'){
                                    return {
                                        text: item[id],
                                        id: item[id],
                                        'data-json': item
                                    }
                                }else if ($("#eam0022").attr('id') == 'eam0022'){
                                    return {
                                        text: item[id],
                                        id: item[id],
                                        'data-json': item
                                    }
                                }else{
                                    return {
                                        text: item[id],
                                        id: item[id],
                                        'data-json': item
                                    }
                                }                                
                            })
                        };
                    }
                }
            }
        });
        if(typeof setAjaxSummaryLaborDepartment != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovDepartmentDesc = setAjaxSummaryLaborDepartmentDesc;
                idLovDepartment = setAjaxSummaryLaborDepartment;
                var data = $(this).select2('data')[0]['data-json'];
                setDataLovDepartment(data.department_code)
            });
        }

        if(typeof setAjaxReportSummaryMonthOwningDepartment != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovDepartmentDesc = setAjaxReportSummaryMonthOwningDepartmentDesc;
                idLovDepartment = setAjaxReportSummaryMonthOwningDepartment;
                var data = $(this).select2('data')[0]['data-json'];
                setDataLovDepartment(data.department_code)
            });
        }

        if(typeof setAjaxReportSummaryMonthInformDept != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovDepartmentDesc = setAjaxReportSummaryMonthInformDeptDesc;
                idLovDepartment = setAjaxReportSummaryMonthInformDept;
                var data = $(this).select2('data')[0]['data-json'];
                setDataLovDepartment(data.department_code)
            });
        }

        if(typeof setAjaxMNTHistoryDepartment != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovDepartmentDesc = setAjaxMNTHistoryDepartmentDesc;
                idLovDepartment = setAjaxMNTHistoryDepartment;
                var data = $(this).select2('data')[0]['data-json'];
                setDataLovDepartment(data.department_code)
            });
        }

        if(typeof setAjaxMNTHistoryOwningDepartment != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovDepartmentDesc = setAjaxMNTHistoryOwningDepartmentDesc;
                idLovDepartment = setAjaxMNTHistoryOwningDepartment;
                var data = $(this).select2('data')[0]['data-json'];
                setDataLovDepartment(data.department_code)
            });
        }

        if(typeof setAjaxMNTHistoryEmployee != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovEmployeeDesc = setAjaxMNTHistoryEmployeeDesc;
                idLovEmployee = setAjaxMNTHistoryEmployee;
                var data = $(this).select2('data')[0]['data-json'];
                setDataLovEmployee(data.employee_number)
            });
        }

        if(typeof setAjaxMaintenanceDepartment != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovDepartmentDesc = setAjaxMaintenanceDepartmentDesc;
                idLovDepartment = setAjaxMaintenanceDepartment;
                var data = $(this).select2('data')[0]['data-json'];
                setDataLovDepartment(data.department_code)
            });
        }

        if(typeof setAjaxMaintenanceOwningDepartment != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovDepartmentDesc = setAjaxMaintenanceOwningDepartmentDesc;
                idLovDepartment = setAjaxMaintenanceOwningDepartment;
                var data = $(this).select2('data')[0]['data-json'];
                setDataLovDepartment(data.department_code)
            });
        }

        if(typeof setAjaxMaintenanceEmployee != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovEmployeeDesc = setAjaxMaintenanceEmployeeDesc;
                idLovEmployee = setAjaxMaintenanceEmployee;
                var data = $(this).select2('data')[0]['data-json'];
                setDataLovEmployee(data.employee_number)
            });
        }

        if(typeof setAjaxWOCostDepartment != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovDepartmentDesc = setAjaxWOCostDepartmentDesc;
                idLovDepartment = setAjaxWOCostDepartment;
                var data = $(this).select2('data')[0]['data-json'];
                setDataLovDepartment(data.department_code)
            });
        }

        if(typeof setAjaxWOCostOwningDepartment != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovDepartmentDesc = setAjaxWOCostOwningDepartmentDesc;
                idLovDepartment = setAjaxWOCostOwningDepartment;
                var data = $(this).select2('data')[0]['data-json'];
                setDataLovDepartment(data.department_code)
            });
        }

        if(typeof setAjaxWOComStatusDepartment != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovDepartmentDesc = setAjaxWOComStatusDepartmentDesc;
                idLovDepartment = setAjaxWOComStatusDepartment;
                var data = $(this).select2('data')[0]['data-json'];
                setDataLovDepartment(data.department_code)
            });
        }

        if(typeof setAjaxWOComStatusOwningDepartment != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovDepartmentDesc = setAjaxWOComStatusOwningDepartmentDesc;
                idLovDepartment = setAjaxWOComStatusOwningDepartment;
                var data = $(this).select2('data')[0]['data-json'];
                setDataLovDepartment(data.department_code)
            });
        }

        if(typeof setAjaxSummaryMatStatusDepartment != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovDepartmentDesc = setAjaxSummaryMatStatusDepartmentDesc;
                idLovDepartment = setAjaxSummaryMatStatusDepartment;
                var data = $(this).select2('data')[0]['data-json'];
                setDataLovDepartment(data.department_code)
            });
        }

        if(typeof selectEAM0006AssetNumber != 'undefined') {
            $(item).on('select2:select', function(e) {
                thisLovAssetNumber = this
                thisLovAssetNumberDesc = 'td:eq(2)'
                thisLovAssetNumberArea = 'td:eq(5)'
                thisLovAssetNumberDepartment = 'td:eq(4)'
                var data = $(this).select2('data')[0]['data-json'];
                if(typeof data != 'undefined'){
                    setDataLovAssetNumber(data.asset_number)
                }else{
                    var data = $(this).select2('data')[0].id;
                    setDataLovAssetNumber(data)
                }
            });
        }

        if(typeof setAjaxWorkOrderNumberInEAM0007 != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovWorkOrderNumber = setAjaxWorkOrderNumberInEAM0007
                var data = $(this).select2('data')[0]['data-json'];                
                if(typeof data != 'undefined'){
                    setDataLovWorkOrderNumber(data.work_request_number)
                }else{
                    var data = $(this).select2('data')[0].id;
                    setDataLovWorkOrderNumber(data)
                }
            });
        }

        if(typeof setAjaxWorkAssetNumberInEAM0007 != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovAssetNumber = setAjaxWorkAssetNumberInEAM0007
                var data = $(this).select2('data')[0]['data-json'];
                if(typeof data != 'undefined'){
                    setDataLovAssetNumber(data.asset_number)
                }else{
                    var data = $(this).select2('data')[0].id;
                    setDataLovAssetNumber(data)
                }
            });
        }

        if(typeof setAjaxModalReportWorkOrderNotifyingAgencyInEAM0007 != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovDepartment = setAjaxModalReportWorkOrderNotifyingAgencyInEAM0007;
                idLovDepartmentDesc = setAjaxModalReportWorkOrderNotifyingAgencyInEAM0007Desc;
                var data = $(this).select2('data')[0]['data-json'];
                setDataLovDepartment(data.department_code)
            });
        }

        if(typeof setAjaxModalReportWorkOrderReportingAgencyInEAM0007 != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovDepartment = setAjaxModalReportWorkOrderReportingAgencyInEAM0007;
                idLovDepartmentDesc = setAjaxModalReportWorkOrderReportingAgencyInEAM0007Desc;
                var data = $(this).select2('data')[0]['data-json'];
                setDataLovDepartment(data.department_code)
            });
        }

        if(typeof setAjaxSelectEAM0014GetWipEntityId != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovWorkReceiptNumber = setAjaxSelectEAM0014GetWipEntityId;
                var data = $(this).select2('data')[0]['data-json'];
                wip_entity_id = data.wip_entity_id
            });
        }

        if(typeof setAjaxSelectEAM0016GetWipEntityId != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovWorkReceiptNumber = setAjaxSelectEAM0016GetWipEntityId;
                var data = $(this).select2('data')[0]['data-json'];
                wip_entity_id = data.wip_entity_id
            });
        }

        if(typeof setAjaxItemCode != 'undefined') {
            $(item).on('select2:select', function(e) {
                var label = $(this).find('option:selected').text();
                var array = [];
                
                thisLovItemInventory = setAjaxItemCode;
                thisLovItemInventoryDesc = setAjaxItemCodeDesc;

                var data = $(this).select2('data')[0]['data-json'];

                if(typeof data !== "undefined"){
                    label = label.split(' - ');
                    delete label[0];
                    _.each(label, function(item) {
                        if(typeof item != 'undefined') array.push(item)
                    })
                    text = array.join(' - ');

                    if($("#" + thisLovItemInventoryDesc).is('input')) {
                        $("#" + thisLovItemInventoryDesc).val(text)
                    }

                    if($("#" + setAjaxPrimaryUom).is('input')) {
                        $("#" + setAjaxPrimaryUom).val(data.primary_uom).trigger('change');
                    }

                    if($("#" + setAjaxInventoryItemId).is('input')) {
                        $("#" + setAjaxInventoryItemId).val(data.inventory_item_id).trigger('change');
                    }    
                }else{
                    _.each(dataItemCode, function(item) {
                        if(item.item_code == $("#" + thisLovItemInventory).val()){
                            if($("#" + thisLovItemInventoryDesc).is('input')) {
                                $("#" + thisLovItemInventoryDesc).val(item.item_description)
                            }
        
                            if($("#" + setAjaxPrimaryUom).is('input')) {
                                $("#" + setAjaxPrimaryUom).val(item.primary_uom).trigger('change');
                            }
        
                            if($("#" + setAjaxInventoryItemId).is('input')) {
                                $("#" + setAjaxInventoryItemId).val(item.inventory_item_id).trigger('change');
                            }    
                        }
                    })
                }

            });
        }

        if(typeof setAjaxEAM0017ModalReportBillMaterialsRequestStatus != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovRequestStatus = setAjaxEAM0017ModalReportBillMaterialsRequestStatus;
                idLovRequestStatusDesc = setAjaxEAM0017ModalReportBillMaterialsRequestStatusDesc;
                var data = $(this).select2('data')[0]['data-json'];
                $(this).select2('data')[0].text = data.lookup_code + '. ' + data.meaning;
                setDataLovRequestStatus(data.meaning)
            });
        }
        
        if(typeof setAjaxEAM0017ModalReportBillMaterialsAgency != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovDepartment = setAjaxEAM0017ModalReportBillMaterialsAgency;
                idLovDepartmentDesc = setAjaxEAM0017ModalReportBillMaterialsAgencyDesc;
                var data = $(this).select2('data')[0]['data-json'];
                $("#" + idLovDepartmentDesc).val(data.description).trigger('change');
            });
        }

        if(typeof setAjaxRepairerId != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovEmployeeWebId = setAjaxRepairerId;
                var data = $(this).select2('data')[0]['data-json'];
                $("#" + idLovEmployeeWebId).val(data.user_id).trigger('change');
            });
        }
        
        if(typeof setAjaxNotifierId != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovEmployeeWebId = setAjaxNotifierId;
                var data = $(this).select2('data')[0]['data-json'];
                $("#" + idLovEmployeeWebId).val(data.user_id).trigger('change');
            });
        }
        if(typeof setAjaxEAM0010WorkReceiptNumber != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovWorkReceiptNumber = setAjaxEAM0010WorkReceiptNumber;
                var data = $(this).select2('data')[0]['data-json'];
                if(typeof data != 'undefined'){
                    setDataLovWorkReceiptNumber(data.wip_entity_name)
                }else{
                    var data = $(this).select2('data')[0].id;
                    setDataLovWorkReceiptNumber(data)
                }
            });
        }

        if(typeof setAjaxEAM0010AssetNumber != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovAssetNumber = setAjaxEAM0010AssetNumber;
                var data = $(this).select2('data')[0]['data-json'];
                setDataLovAssetNumber(data.asset_number)
            });
        }

        if(typeof setAjaxReportingAgencyInEAM0007 != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovDepartment = setAjaxEAM0010AssetNumber;
                var data = $(this).select2('data')[0]['data-json'];
                if(typeof data != 'undefined'){
                    setDataLovDepartment(data.department_code)
                }else{
                    var data = $(this).select2('data')[0].id;
                    setDataLovDepartment(data)
                }
            });
        }

        if(typeof setAjaxNotifyingAgencyInEAM0007 != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovDepartment = setAjaxNotifyingAgencyInEAM0007;
                var data = $(this).select2('data')[0]['data-json'];
                if(typeof data != 'undefined'){
                    setDataLovDepartment(data.department_code)
                }else{
                    var data = $(this).select2('data')[0].id;
                    setDataLovDepartment(data)
                }
            });
        }

        if(typeof setAjaxModalReportSummaryEmployee != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovEmployeeDesc = setAjaxModalReportSummaryEmployeeDesc;
                idLovEmployee = setAjaxModalReportSummaryEmployee;
                var data = $(this).select2('data')[0]['data-json'];
                setDataLovEmployee(data.employee_number)
            });
        }

    })

}

function triggerSelect2InEAM0010(){
    $('#eam0010 #setTbodyTableOperation select[data-server],'+
      '#eam0010 #setTbodyTableGroupTechnicians select[data-server],'+
      '#eam0010 #setTbodyTableSavePart select[data-server],'+
      '#eam0010 #setTbodyTableSavePartNon select[data-server],'+
      '#eam0010 #setTbodyTableSaveCost select[data-server],'+
      '#eam0010 #setTbodyTableComplete select[data-server]').each(function (el, item) {
        if($(item).val() != null) {
            return true;
        }
        var url = $(item).attr('data-server')
        var field = $(item).attr('data-field')
        var text = $(item).attr('data-text')
        var id = $(item).attr('data-id')

        var setAjaxDetailItemCode = $(item).attr('data-setAjaxDetailItemCode');
        var typeAjaxDetailItemCode = $(item).attr('data-typeAjaxDetailItemCode');

        var setAjaxDetailItemCodeNon = $(item).attr('data-setAjaxDetailItemCodeNon');
        var typeAjaxDetailItemCodeNon = $(item).attr('data-typeAjaxDetailItemCodeNon');

        var setAjaxDetailEmployeeTbLB = $(item).attr('data-setAjaxDetailEmployeeTbLB');
        var setAjaxDetailEmployeeTbLBId = $(item).attr('data-setAjaxDetailEmployeeTbLBId');
        var typeAjaxDetailEmployeeTbLB = $(item).attr('data-typeAjaxDetailEmployeeTbLB');

        $(item).select2({
            minimumInputLength: 2,
            language: 'th',
            placeholder: "เลือกข้อมูล",
            allowClear: true,
            ajax: {
                url: url,
                dataType: 'json',
                contentType: 'application/json',
                data: function (parm) {
                    var query = {};
                    query[field] = parm.term;
                    query['select2'] = 1;
                    query['page'] = parm.page || 1

                    return query;
                },
                processResults: function (data) {
                    if (typeof data.data.data === "undefined") {
                        var data = data.data
                    } else {
                        var data = data.data.data
                    }

                    if (typeof id === 'undefined') {
                        return false;
                    }
                    
                    if (typeof text !== 'undefined') {   
                        if(typeAjaxDetailItemCode){
                            dataLovItemCode = data
                        }

                        if(typeAjaxDetailItemCodeNon){
                            dataLovItemCode = data
                        }

                        if(typeAjaxDetailEmployeeTbLB){
                            dataLovResourceEmployee = data
                        }

                        return {
                            results: $.map(data, function (item) {                                      
                                return {
                                    text: item[id] + " - " + item[text],
                                    id: item[id],
                                    'data-json': item
                                }
                            })
                        };
                    } else {   
                        if(typeAjaxDetailItemCode){
                            dataLovItemCode = data
                        }

                        if(typeAjaxDetailItemCodeNon){
                            dataLovItemCode = data
                        }

                        if(typeAjaxDetailEmployeeTbLB){
                            dataLovResourceEmployee = data
                        }

                        if($("#eam0010").attr('id') == 'eam0010' && id == 'item_code'){
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        text: item[id] + " - " + item.item_description,
                                        id: item[id],
                                        'data-json': item
                                    }                                                        
                                })
                            };
                        }else if ($("#eam0010").attr('id') == 'eam0010' && id == 'employee_number'){
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        text: item[id] + " - " + item.full_name,
                                        id: item[id],
                                        'data-json': item
                                    }                                                        
                                })
                            };
                        }else{
                            return {
                                results: $.map(data, function (item) {
                                    return {
                                        text: item[id],
                                        id: item[id],
                                        'data-json': item
                                    }                                                        
                                })
                            };
                        }                        
                    }
                }
                
            }
            
        });

        if(typeof setAjaxDetailItemCode != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovItemCodeTable = setAjaxDetailItemCode;
                var data = $(this).select2('data')[0]['data-json'];
                setDataLovItemCode(data.item_code)
            });
        }

        if(typeof setAjaxDetailItemCodeNon != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovItemCodeTable = setAjaxDetailItemCodeNon;
                var data = $(this).select2('data')[0]['data-json'];
                setDataLovItemCode(data.item_code)
            });
        }

        if(typeof setAjaxDetailEmployeeTbLB != 'undefined') {
            $(item).on('select2:select', function(e) {
                idLovResourceEmployee = setAjaxDetailEmployeeTbLB;
                idLovResourceEmployeeId = setAjaxDetailEmployeeTbLBId;
                locationResourceEmployee = 'technicianGroupOrde';
                var data = $(this).select2('data')[0]['data-json'];
                if(typeof data != 'undefined'){
                    setDataLovResourceEmployee(data.employee_number);
                }else{
                    var data = $(this).select2('data')[0].id;
                    setDataLovResourceEmployee(data);
                }
            });
        }
    })
}

function getDetailRequestEquipNo() {
    var setAjaxEAM0017RequestEquipNo = $('#eam0017 #requestEquipNo').attr('data-setAjaxEAM0017RequestEquipNo');

    if(typeof setAjaxEAM0017RequestEquipNo != 'undefined') {
        $('#eam0017 #requestEquipNo').on('select2:select', function(e) {
            idLovRequestEquipNo = setAjaxEAM0017RequestEquipNo;
            dataLovRequestEquipNo = dataArrRequestEquipNo;
            var data = $(this).select2('data')[0]['data-json'];
            if(typeof data != 'undefined'){
                setDataLovRequestEquipNo(data.request_equip_no)
            }else{
                var data = $(this).select2('data')[0].id;
                setDataLovRequestEquipNo(data)
            }
        });
    }
}

function setSelect2InEAM0006() {
    $('#eam0006 #setTbodyTable select[data-server!=""]').select2({
        placeholder: "เลือกข้อมูล",
        allowClear: true,
    })
}

function setSelect2InEAM0007() {
    $('#eam0007 #detailReportWorkOrder select[data-server!=""]').select2({
        placeholder: "เลือกข้อมูล",
        allowClear: true,
    })
}

function setSelect2InEAM0017() {
    // console.log($('#eam0017 #setTbodyTable select[data-server!=""][class^="select2-hidden-accessible"]'), 'setSelect2InEAM0017')
    $('#eam0017 #setTbodyTable select[data-server!=""]:not(.select2-hidden-accessible)').select2({
        placeholder: "เลือกข้อมูล",
        allowClear: true,
    })
}

function setSelect2InEAM0010Modal() {
    $('#eam0010 #detailReportWorkReceipt select[data-server!=""]').select2({
        placeholder: "เลือกข้อมูล",
        allowClear: true,
    })
}

function setSelect2InEAM0010TbodyTableGroupTechnicians() {
    $('#eam0010 #setTbodyTableGroupTechnicians select[data-server!=""]').select2({
        placeholder: "เลือกข้อมูล",
        allowClear: true,
    })
}

function setSelect2InEAM0010TbodyTableSavePart() {
    $('#eam0010 #setTbodyTableSavePart select[data-server!=""]').select2({
        placeholder: "เลือกข้อมูล",
        allowClear: true,
    })
}

function setSelect2InEAM0010TbodyTableSavePartNon() {
    $('#eam0010 #setTbodyTableSavePartNon select[data-server!=""]').select2({
        placeholder: "เลือกข้อมูล",
        allowClear: true,
    })
}

function setSelect2InEAM0010TbodyTableSaveCost() {
    $('#eam0010 #setTbodyTableSaveCost select[data-server!=""]').select2({
        placeholder: "เลือกข้อมูล",
        allowClear: true,
    })
}

function setSelect2InEAM0010DetailTableSavePartChild() {
    $('#eam0010 #detailTableSavePartChild select[data-server!=""]').select2({
        placeholder: "เลือกข้อมูล",
        allowClear: true,
    })
}

function setSelect2InEAM0003DetailAssetCategoryLov() {
    $('#eam0003 #detailAssetCategoryLov select[data-server!=""]').select2({
        placeholder: "เลือกข้อมูล",
        allowClear: true,
    })
}

$(function () {
    $('.ibox-content select[data-server!=""]:not(#referenceWorkReceipt)').select2({
        placeholder: "เลือกข้อมูล",
        allowClear: true,
    })

    triggerSelect2();

    if($("#eam0017").attr('id') === 'eam0017'){
        getDetailRequestEquipNo();
    }

    if($("#eam0010").attr('id') === 'eam0010'){
        triggerSelect2InEAM0010();
    }
})
