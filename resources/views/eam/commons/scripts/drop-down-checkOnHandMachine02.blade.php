<script>
    dataDropDownCheckOnHand = []
    $.ajax({
        url: "{{ route('eam.ajax.lov.get-check-on-hand-machine02') }}",
        method: 'GET',
        success: function (response) {
            dataDropDownCheckOnHand = response.data
            let optionCheckOnHand = ''
            optionCheckOnHand += `<option value=""></option>`
            for (let data of response.data) {
                optionCheckOnHand += `<option value="${data.machine_02}">${data.machine_02}</option>`
            }
            $('#machine02').html(optionCheckOnHand)
        },
            error: function (jqXHR, textStatus, errorRhrown) {
            swal("Error", jqXHR.responseJSON.message, "error");
        }
    })
</script>