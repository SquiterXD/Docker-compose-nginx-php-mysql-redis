<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>รายงานผลผลิต</title>
	<script>
        function subst() {
            var vars = {};
            var x = document.location.search.substring(1).split("&");
            for (var i in x) {
                var z = x[i].split("=", 2);
                vars[z[0]] = unescape(z[1]);
            }
            var _body = document.body;
            var _div;
            //if current page number == last page number
            if (vars["page"] == vars["topage"]) {
                document.querySelectorAll(".extra2")[0].setAttribute("style","height:100px;");
                document.querySelectorAll(".extra2")[0].setAttribute("class","showDiv");
                document.querySelectorAll(".extra1")[0].setAttribute("class","displayNoneDiv");
            }
            else{
                document.querySelectorAll(".extra2")[0].setAttribute("class","displayNoneDiv");
            }
        };
	</script>
	<style type="text/css">
        @font-face{
            font-family: 'SarabunSans';
            font-style: 'normal';
            src: url("file://{!! public_path('/fonts/Sarabun-Regular.ttf') !!}") format('truetype');
        }

        body {
            font-family: 'SarabunSans';
            font-size: 10px;
        }

        .extra {
            color: red;
        }
        .showDiv{
            display:block;
        }
        .displayNoneDiv{
            display:none;
        }
    </style>
</head>
<body onload="subst()">
	<div class="extra2">
		<table style="width: 100%;">
			<thead>
				<tr style="width: 100%;">
	                <td style="text-align: center;">(.......................................................)</td>
	                <td style="text-align: center;">(.......................................................)</td>
	                <td style="text-align: center;">(.......................................................)</td>
	                <td style="text-align: center;">(.......................................................)</td>
				</tr>
				<tr style="width: 100%;">
	                <td style="text-align: center;">ผู้บันทึกรายการ</td>
	                <td style="text-align: center;">หัวหน้ากอง</td>
	                <td style="text-align: center;">รองผู้อำนวยการฝ่ายโรงงานผลิตยาสูบ</td>
	                <td style="text-align: center;">ผู้อำนวยการฝ่ายโรงงานผลิตยาสูบ</td>
				</tr>
			</thead>
		</table>
	</div>
</body>
</html>