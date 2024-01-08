{!! Form::select('supplier_site_id', count($supplierSiteLists) > 1 ? [''=>'-']+$supplierSiteLists : $supplierSiteLists, null,  ["class" => 'form-control input-sm select2', "id"=>"ddl_supplier_site_id", "autocomplete" => "off","style"=>"width:100%"]) !!}
<script type="text/javascript">
	$(document).ready(function(){

		$("select[name='supplier_site_id']").change(function(){
            var supplierId = $("select[name='supplier_id'] option:selected").val();
            var supplierSiteId = $("select[name='supplier_site_id'] option:selected").val();
            getSupplierBankDetail(supplierId, supplierSiteId);
        });

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