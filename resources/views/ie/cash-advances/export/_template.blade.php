<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
   <table>
    <thead>
        <tr style="border-bottom: 1px solid #000000;">
            <th>No.</th>
            <th>Document #</th>
            <th>Status</th>
            <th>Requester Name</th>
            <th>Requester Company</th>
            <th>Requester Department</th>
            <th>Requester Bank Name</th>
            <th>Requester Account No.</th>
            <th>Requester Account Name</th>
            <th>Purpose</th>
            <th>Amount</th>
            <th>Currency</th>
        </tr>
    </thead>
    <tbody>
        <?php $rownum = 1; ?>
        @foreach($cashAdvances as $cashAdvance)
        <tr>
            <td>{{ $rownum }}</td>
            <td>{{ $cashAdvance->document_no }}</td>
            <td>{{ $cashAdvance->status }}</td>
            <td>{{ $cashAdvance->user->name }}</td>
            <td>{{ $cashAdvance->user->employee->company_name }}</td>
            <td>{{ $cashAdvance->user->employee->department_name }}</td>
            <td>{{ $cashAdvance->user->employee->bank_name }}</td>
            <td>{{ $cashAdvance->user->employee->bank_account_num }}</td>
            <td>{{ $cashAdvance->user->employee->vendor_name }}</td>
            <td>{{ $cashAdvance->purpose }}</td>
            <td>{{ $cashAdvance->amount ? number_format($cashAdvance->amount,2) : '0.00' }}</td>
            <td>{{ $cashAdvance->currency_id }}</td>
        </tr>
        @endforeach
    </tbody>
   </table>
</body>
</html>