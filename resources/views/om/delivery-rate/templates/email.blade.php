<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-param" content="_token">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>
    <p>เรียน ผู้ที่เกี่ยวข้อง</p>
    <p>&nbsp;</p>
    <p>เนื่องจากวันที่ {{ FormatDate::DateThai($data['date']) }} ราคาน้ำมันมีการเปลี่ยนแปลงเป็น {{ $data['new_oil'] }} บาทต่อลิตร ซึ่งเปลี่ยนแปลงจากเดิม {{ $data['text_price'] }} บาทต่อลิตร (เดิมราคา {{ $data['old_oil'] }} บาทต่อลิตร) จากการคำนวณอัตราค่าขนส่งบุหรี่ใหม่ จะอยู่ที่ {{ $data['newprice'] }} บาท/หีบ ขอให้ผู้ที่เกี่ยวข้องดำเนินการปรับอัตราค่าขนส่งบุหรี่ใหม่ในระบบด้วย</p>
    <p>&nbsp;</p>
    <p>จึงเรียนมาเพื่อโปรดดำเนินการ</p>
</body>
</html>