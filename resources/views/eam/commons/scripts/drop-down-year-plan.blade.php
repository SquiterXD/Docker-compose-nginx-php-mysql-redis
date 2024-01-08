
<script>
  var yearNotification = {!! json_encode($year ?? '') !!};
  $.ajax({
    url: "{{ route('eam.ajax.lov.period-year') }}",
    method: 'GET',
    success: function (response) {
      let optionYearPlan = ''
      optionYearPlan += `<option value=""></option>`
      for (let data of response.data) {
        optionYearPlan += `<option value="${data.period_year}">${data.period_year}</option>`

        if(yearNotification){
          optionYearPlan += `<option  value="${yearNotification}" 
                                      ${yearNotification == data.period_year ? 'selected' : ''}>
                                      ${data.period_year}
                            </option>`
        }
      }
      $("#yearPlan").html(optionYearPlan);
      $("#yearPlan").trigger('change');
    },
    error: function (jqXHR, textStatus, errorRhrown) {
      swal("Error", jqXHR.responseJSON.message, "error");
    }
  })
</script>