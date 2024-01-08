{!! Form::select('supplier_id', $supplierLists , $defaultSupplierId,  ["class" => 'form-control input-sm select2', "id"=>"ddl_supplier_id", "autocomplete" => "off","style"=>"width:100%"]) !!}
<script type="text/javascript">
	$(document).ready(function(){
		$("select[name='supplier_id']").change(function(){
            var supplierId = $("select[name='supplier_id'] option:selected").val();
            getSupplierSites(supplierId);
        });

        function getSupplierSites(supplierId)
        {
            let orgId = $("select[name='org_id'] option:selected").val();
            $.ajax({
                url: "{{ url('/') }}/ie/reimbursements/get_supplier_sites",
                type: 'GET',
                data: {supplier_id: supplierId,
                        org_id: orgId},
                beforeSend: function( xhr ) {
                    $("#div_detail_supplier_bank").html('');
                    $("select[name='supplier_id']").prop("disabled", true);
                    $("select[name='supplier_site_id']").prop("disabled", true);
                }
            })
            .done(function(result) {
                $("#div_ddl_supplier_site_id").html(result);
                $("select[name='supplier_site_id']").select2({width: "100%"});
                $("select[name='supplier_id']").prop("disabled", false);
            })
            .then(() => {
                let supplierSiteId = $("select[name='supplier_site_id'] option:selected").val();
                if(supplierSiteId){
                    getSupplierBankDetail(supplierId, supplierSiteId);
                }
            });
        }

        function getSupplierBankDetail(supplierId, supplierSiteId)
        {
            let orgId = $("select[name='org_id'] option:selected").val();
            $.ajax({
                url: "{{ url('/') }}/ie/reimbursements/get_supplier_bank_detail",
                type: 'GET',
                data: {supplier_id: supplierId,
                        supplier_site_id: supplierSiteId,
                        org_id: orgId},
                beforeSend: function( xhr ) {
                    $("#div_detail_supplier_bank").html('');
                    $("select[name='supplier_id']").prop("disabled", true);
                    $("select[name='supplier_site_id']").prop("disabled", true);
                }
            })
            .done(function(result) {
                $("#div_detail_supplier_bank").html(result);
                $("select[name='supplier_id']").prop("disabled", false);
                $("select[name='supplier_site_id']").prop("disabled", false);
            });
        }
	});
</script>