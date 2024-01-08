<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @include('om.reports._style')
    <style>
        * {
            font-size: 2.05em;
        }
    </style>
</head>
<body>
    @foreach($results as $result)
    @if(count($results) > 1)
    <p style="page-break-after: always;"></p>
    @endif
    <div style="position: relative">
        
        <div>{{ Carbon\Carbon::parse($result->delivery_date)->addYears(543)->format('d/m/Y') }}</div>
        <div style="position: absolute; top:105px; text-align:right;width:77%">{{ $result->customer_name }}</div>
        <div style="position: absolute; top:255px; text-align:left;width:100%">{{ $result->item_description }}</div>
        <div style="position: absolute; top:255px; text-align:right;width:77%;">{{ $result->approve_carton }} ห่อ</div>
        <div style="position: absolute; top:405px; text-align:left;width:100%">{{ $result->pick_release_no }}</div>
        <div style="position: absolute; top:405px; text-align:right;width:77%">{{ $result->city }}</div>
        <div style="position: absolute; top:465px; text-align:right;width:77%">{{ $result->province_name }}</div>
    </div>
    @endforeach
</body>
</html>