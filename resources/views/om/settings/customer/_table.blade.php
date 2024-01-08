<div class="table-responsive">
    <table class="table table-bordered">
        <thead>            
            <tr>
                <th class="text-center"><div style="width: 50px;">ประเภทลูกค้า</div></th>
                <th class="text-center"><div style="width: 120px;">ผู้มีอำนาจอนุมัติ</div></th>
                <th class="text-center"><div style="width: 120px;">ตำแหน่ง</div></th>
                <th class="text-center"><div style="width: 90px;">Email</div></th>
                <th class="text-center"><div style="width: 70px;">Primary Approval</div></th>
                <th class="text-center"><div style="width: 50px;">Status</th>
                <th><div style="width: 50px;"></div></th>
            </tr>
        </thead>
        <tbody> 
            @foreach ($customers as $customer)
            {{-- {{dd($customer, $customer->employee)}} --}}
                <tr>                    
                    <td> 
                        {{ $customer->customer_type }} 
                    </td>
                    <td> 
                        {{ $customer->employee_name }} 
                    </td>
                    <td> 
                        {{ $customer->position_name }} 
                    </td>
                    <td> 
                        {{ $customer->email }} 
                    </td>
                    <td align="center"> 
                        @include('shared._status_active', ['isActive' => $customer->primary_approval == 'Y'])
                    </td>
                    <td align="center"> 
                        @include('shared._status_active', ['isActive' => $customer->status == 'Active'])
                    </td> 
                    <td class="text-center">
                        <a href="{{ route('om.settings.customer.edit', $customer->customer_approval_id) }}" class="btn btn-warning btn-xs">
                            <i class="fa fa-edit m-r-xs"></i> แก้ไข
                        </a>
                    </td>
                </tr>
            @endforeach            
        </tbody>
    </table>
</div>
<div class="d-flex justify-content-center">
    {{ $customers->links() }}
</div>


@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var dataTable = $('.program_info_tb');
            var loadingHtml = '<div class="sk-spinner sk-spinner-wave"> <div class="sk-rect1"></div> <div class="sk-rect2"></div> <div class="sk-rect3"></div> <div class="sk-rect4"></div> <div class="sk-rect5"></div> </div>';
            dataTable.DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                bFilter: false,
                aaSorting: [],
                bPaginate:true,
                bInfo: false,
                language: {
                    loadingRecords: loadingHtml,
                },
                buttons: [
                ],
            });
        });
    </script>
@stop
