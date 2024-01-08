<script>
    dataDropDownCheckOnHand = []
    $.ajax({
        url: "{{ route('eam.ajax.lov.get-check-on-hand-machine01') }}",
        method: 'GET',
        success: function (response) {
            dataDropDownCheckOnHand = response.data
            let optionCheckOnHand = ''
            optionCheckOnHand += `<option value=""></option>`
            for (let data of response.data) {
                optionCheckOnHand += `<option value="${data.machine_01}">${data.machine_01}</option>`
            }
            $('#machine01').html(optionCheckOnHand)
        },
            error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
        }
    })
</script>