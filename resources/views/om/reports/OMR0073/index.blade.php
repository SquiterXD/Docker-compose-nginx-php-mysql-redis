<html>
<head>
	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style>

		.page-break {
	        page-break-after: always;
	    }
	    table {
		  width: 100%;
		}
	</style>
	@include('reports._style')
</head>
<body>
	
	<table>
		<tr>
			<td style="font-weight: bold;">โปรแกรม : OMR0073</td>
			<td style="text-align: center; font-weight: bold;">การยาสูบแห่งประเทศไทย</td>
			<td style="text-align: right; font-weight: bold;">{{$ldate}}</td>
		</tr>
		<tr>
			<td style="font-weight: bold;">สั่งพิมพ์ : {{ Auth::user()->name }} </td>
			<td style="text-align: center; font-weight: bold;" >รายงานประมารการจำหน่ายรายเดือน </td>
			<td style="text-align: right; font-weight: bold;">{{$time}}</td>
		</tr>
		<tr>
			<td> </td>
			<td style="text-align: center; font-weight: bold;">ปีงบประมาณ ครั้งที่</td>
			<td style="text-align: right; font-weight: bold;">หน้า : </td>
		</tr>
		<tr>
			<td> </td>
			<td> </td>
			<td style="text-align: right; font-weight: bold;">หน่วย : บุหรี่(พันมวน)/ยาเส้น(หีบ)</td>
		</tr>
	</table>



</body>
</html>




