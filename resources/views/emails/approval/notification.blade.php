<!DOCTYPE html>
<html>
<head>
    <title>ขออนุมัติการสร้างลูกค้าใหม่ {{ $details['request_number'] }} : {{ $details['customer_name'] }}</title>
</head>
<body>
    <p>ขออนุมัติการสร้างลูกค้าใหม่ {{ $details['request_number'] }} : {{ $details['customer_name'] }}</p>
    <br />
    <p>เรียน ผู้มีอำนาจ</p>
    <br />
    <p>เนื่องจากมีการขออนุมัติการสร้างร้านค้า โดยมีรายละเอียดดังนี้<br/>
    หมายเลขขออนุมัติ : {{ $details['request_number'] }<br/>
    ชื่อร้านค้า : {{ $details['customer_name'] }}</p><br/>
    <p>โดยสามารถดูรายละเอียดร้านค้าและทำการอนุมัติผ่าน WEB ได้ โดยกดที่ลิงค์ด้านล่าง</p><br/>
    <div>
        <a href="{{ $details['url'] }}">คลิกที่นี่เพื่ออนุมัติ</a>
    </div>
</body>
</html>
