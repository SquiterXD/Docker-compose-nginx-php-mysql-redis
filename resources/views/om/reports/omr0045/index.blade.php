<!DOCTYPE html>
<html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{{ $programCode }}</title>
    {{-- <link href="{{ public_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/> --}}
    <script src="{!! asset('js/vendor/app.js') !!}" type="text/javascript"></script>
    <script>
        var i=0;
        function downloadPdf(url,filename){
            var data = '';
            $.ajax({
                type: 'GET', url: url, data: data, xhrFields: { responseType: 'blob' },
                success: function(response){
                    var blob = new Blob([response]);
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = filename+".pdf";
                    link.click();
                    i++;
                    if(i==2){ window.close(); }
                },
                error: function(blob){ console.log(blob); }
            });
        }
        $(document).ready(function(){
            //Donwload
            //downloadPdf('{!! str_replace('&amp;','&',$url)."&typecode=20" !!}','OMR0045_L');
            //downloadPdf('{!! str_replace('&amp;','&',$url)."&typecode=10" !!}','OMR0045');

            // Open new tab
            window.open('{!! str_replace('&amp;','&',$url)."&typecode=20" !!}','_blank');
            window.location='{!! str_replace('&amp;','&',$url)."&typecode=10" !!}';
        });
        </script>
    </head>
    <body></body>
</html>
