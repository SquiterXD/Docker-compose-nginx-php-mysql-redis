<!DOCTYPE html>
<html>
    <head>
        {{-- <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> --}}
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" media=print>
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        {{-- <link rel="stylesheet" href="{{ asset('css/report.css') }}"> --}}
        @include('ir.reports.irr1110._style')
            <script>
                function subst() {
                    var vars={};
                    var x=document.location.search.substring(1).split('&');
                    console.log(x);
                    for (var i in x) {var z=x[i].split('=',2);vars[z[0]] = unescape(z[1]);}
                    var x=['frompage','topage','page','webpage','section','subsection','subsubsection'];
                    for (var i in x) {
                        var y = document.getElementsByClassName(x[i]);
                        for (var j=0; j<y.length; ++j) y[j].textContent = vars[x[i]];
                    }
                }
            </script>
    </head>
    <body  onload="subst()">
        @foreach ($ptirStockHeaders->groupBy('policy_set_desc') as $policySetDes =>  $ptirStockHeader)
            @include('ir.reports.irr1110.pdf._table', ['policySetDes' => $policySetDes])
        @endforeach
    </body>
</html>

