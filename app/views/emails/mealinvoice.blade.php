<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Meal Invoice/Details</title>
</head>
<body>

<p>Dear <b>Mr {{ $member_name }}</b>,</p>
<p>This is to inform you that the session, {{ $month->name }} has been completed successfully.
You will find details in the document attached to this mail. </p>

<p>If you find any discrepancy, please voice your issue to the manager immediately.</p>

<p>You can visit for Updated Meal Details by Clicking: <a target="_blank" href="{{ URL::to('/').'/'.$flat_short_name }}">{{ $flat }} Meal System</a> </p>

<p>Thank you.<br>
    <strong>{{ $flat }} Meal System</strong>
    <br>Powered By - General Meal System<br>
    If you have any query , please talk to manager of the session or send a mail to <u>{{ $flat_email}}</u> (Manager's Email)
</p>



</body>
</html>
