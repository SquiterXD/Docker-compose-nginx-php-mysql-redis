{{-- 
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var headerData  = @json($headers, JSON_PRETTY_PRINT);
            for (let i in headerData) {
                let heade = headerData[i];
                if (heade.active_flag === 'Y') {
                    $(`input[name="active${heade.header_id}"]`).prop('checked', true)
                } else {
                    $(`input[name="active${heade.header_id}"]`).prop('checked', false)
                }
            }
        });
        function changeActive (obj) {
            console.log(obj);
            $.ajax({
                url: "{{ url('ir/ajax/updateActiveFlag') }}",
                method: 'GET',
                data: {
                    'header_id': obj.code,
                    'active_flag': obj.flg === 'N' ? 'Y' : obj.flg === 'Y' ? 'N' : 'Y'
                },
                success: function (result){
                    console.log('success ', result)
                    swal("Success", "บันทึกสำเร็จ!", "success");
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log('error ', jqXHR, textStatus, errorThrown)
                }
            });
        }
    </script>
@stop --}}

