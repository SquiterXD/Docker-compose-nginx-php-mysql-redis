<div class="table-responsive">
    <table class="table table-bordered" id="example">
        <thead>
            <tr>
                <th>
                    <div style="width: 80px;">Document Code</div>
                </th>
                <th>
                    <div style="width: 80px;">คำอธิบาย</div>
                </th>
                <th>
                    <div style="width: 100px;">โครงสร้าง Running number</div>
                </th>
                <th>
                    <div style="width: 25px;">เลขล่าสุด</div>
                </th>
                <th class="text-center">
                    <div style="width: 15px;">Active</div>
                </th>
                <th>
                    <div style="width: 18px;"></div>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($headers as $header)
                <tr>
                    <td>{{ $header->doc_seq_code }}</td>
                    <td>{{ $header->doc_seq_description }}</td>
                    <td>{{ $header->format_combine }}</td>
                    <td>{{ $header->last_number }}</td>
                    <td class="text-center">
                        @include('shared._status_active', ['isActive' =>  $header->active_flag == 'Y' ])
                    </td>
                    <td>
                        <a href="{{ route('running-number.edit', $header->doc_seq_header_id) }}" class="btn btn-warning btn-sm">
                            <i class="fa fa-edit"></i> แก้ไข
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@section('scripts')
    <script type="text/javascript">
        // $(document).ready(function() {
        //     $('#example').DataTable();
        // });

        $(document).ready(function () {
            var dataTable = $('#example');
            // var loadingHtml = '<div class="sk-spinner sk-spinner-wave"> <div class="sk-rect1"></div> <div class="sk-rect2"></div> <div class="sk-rect3"></div> <div class="sk-rect4"></div> <div class="sk-rect5"></div> </div>';
            dataTable.DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                bFilter: false,
                aaSorting: [],
                bPaginate:true,
                bInfo: false,
                // columnDefs: [
                //     { className: "text-center", "targets": [ 0 ] , type: "string", orderable : false },
                // ],
                // language: {
                //     loadingRecords: loadingHtml,
                // },
                buttons: [
                ],
            });
        });
    </script>
@stop
