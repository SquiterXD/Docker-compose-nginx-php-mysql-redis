<hr>
<div class="row pt-2" style="color: #c32323;">
    <div class="col-md-2 text-right"> <h3> <strong> Transactions </strong> </h3> </div>
    <div class="col-md-10 pl-0"> <hr style="border-color: #c32323 !important;"> </div>
</div>
<table class="table table-hover transactions_tb">
    <thead>
        <tr>
            <th width="10%" class="text-left pl-2 pr-1">
                <div> Source </div>
            </th>
            <th width="10%" class="text-left pl-2 pr-1">
                <div> Categoty </div>
            </th>
            <th width="10%" class="text-text pl-2 pr-1">
                <div> Balance Type </div>
            </th>
            <th width="8%" class="text-left pl-2 pr-1">
                <div> Type </div>
            </th>
            <th width="13%" class="text-left pl-2 pr-1">
                <div> Transaction # </div>
            </th>
            <th width="12%" class="text-left pl-2 pr-1">
                <div> Description </div>
            </th>
            <th width="2%" class="text-left pl-2">
                <div> Currency </div>
            </th>
            <th width="8%" class="text-right pl-2">
                <div> Debit </div>
            </th>
            <th width="8%" class="text-right pl-2">
                <div> Credit </div>
            </th>
        </tr>
    </thead>
    <tbody>
        {{-- @if (count($transactions)) --}}
            @foreach($transactions as $transaction)
                <tr style="font-size: 13px;">
                    <td class="text-left">
                        {{ $transaction->source }}
                    </td>
                    <td class="text-left">
                        {{ $transaction->category }}
                    </td>
                    <td class="text-left" data-sort-value="{{ $transaction->actual_flag_num }}">
                        {{ balanceType($transaction->actual_flag_num) }}
                    </td>
                    <td class="text-left">
                        {{ $transaction->encumbrance_type ?? '-' }}
                    </td>
                    <td class="text-left" style="font-size: 11px;">
                        {{ $transaction->transaction_number }}
                    </td>
                    <td class="text-left">
                        {{ $transaction->description }}
                    </td>
                    <td class="text-left">
                        {{ $transaction->currency_code }}
                    </td>
                    <td class="text-right">
                        {{ number_format($transaction->entered_dr ?? 0, 2) }}
                    </td>
                    <td class="text-right">
                        {{ number_format($transaction->entered_cr ?? 0, 2) }}
                    </td>
                </tr>
            @endforeach
        {{-- @else
            <tr>
                <td colspan="6" class="text-center" style="width=100%"><h2> No data transactions </h2></td>
            </tr>
        @endif --}}
    </tbody>
</table>

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            var dataTable = $('.transactions_tb');
            var loadingHtml = '<div class="sk-spinner sk-spinner-wave"> <div class="sk-rect1"></div> <div class="sk-rect2"></div> <div class="sk-rect3"></div> <div class="sk-rect4"></div> <div class="sk-rect5"></div> </div>';
            dataTable.DataTable({
                pageLength: 25,
                responsive: true,
                // dom: '<"html5buttons"B>lTfgitp',
                bFilter: false,
                aaSorting: [],
                bPaginate:true,
                bInfo: false,
                columnDefs: [
                    // { className: "text-center", "targets": [ 0 ] , type: "string", orderable : false },
                ],
                language: {
                    loadingRecords: loadingHtml,
                },
                buttons: [
                ],
            });
        });
    </script>
@stop