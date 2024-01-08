<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Export Text File</title>
</head>
<body>
    <form action="" method="POST">
        {{ csrf_field() }}
        <h1>Export file</h1>
        <input type="date" name="date" id="">
        <button type="submit" name="type" value="BALANCE_UPDATE">BALANCE Update</button>
        <button type="submit" name="type" value="CREDIT_UPDATE">CREDIT Update</button>
        <button type="submit" name="type" value="DEBT_UPDATE">DEBT Update</button>
        <button type="submit" name="type" value="CARRIER_UPDATE">CARRIER Update</button>
        <button type="submit" name="type" value="CARRIER_BKK_UPDATE">CARRIER_BKK Update</button>
    </form>
</body>
</html>