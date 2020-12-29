<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 14pt;
        }
    </style>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Meal Details/Invoice</title>
</head>
<body>

<div class="container">
    <h2>{{ $flat->flat_full_name }} Meal System</h2>
    <h3>Session: {{ $meals->month->name }} <span style="font-size: 8pt"> {{ $meals->month->start_time }} --> {{  $meals->month->closing_time  }}</span></h3>


    <h3>Dear <b>Mr {{ $meals->member->name }}</b></h3>
    <p>Thank You for sharing meal with us. Your details stated below:</p>

    <h3>Meal Rate: {{ $meal_rate ? $meal_rate : 0.00 }} BDT</h3>
    <h3>Total Meal: {{ $meals->count }} BDT</h3>
    <h3>Amount Paid: {{ $meals->balance + $total_bazar }} BDT</h3>
    <h3>Amount Due: {{ $meals->balance + $total_bazar }} BDT</h3>


    <table style="width:100%">
        <tr>
            <th>Particulars</th>
            <th>Details</th>
        </tr>
        <tr>
            <td>Meal Month/Session</td>
            <td><b>{{ $meals->month->name }}</b>, From {{ $meals->month->start_time }} to {{  $meals->month->closing_time  }}</td>
        </tr>
        <tr>
            <td>Total Meal Consumed</td>
            <td><b>{{ $meals->count }}</b></td>
        </tr>

        <tr>
            <td>Deposit to Manager</td>
            <td> {{ $meals->balance }}/- BDT</td>
        </tr>
        <?php $sum = 0.0 ?>
        @if(count($bazars) > 0 )
            <tr>
                <td rowspan="{{ count($bazars) + 1 }}">Bazar Done till Date</td>
            </tr>


            @foreach($bazars as $bazar)
                <?php $sum += $bazar->amount; ?>
                <tr>
                    <td> {{ $bazar->amount }}/- BDT  on {{ $bazar->date }} </td>
                </tr>
            @endforeach
        @endif

        <tr>
            <td>Total Spent</td>
            <td><b>{{ $meals->balance + $sum }}/- BDT</b></td>
        </tr>

    </table>

    <p>You can visit for Updated Meal Details by Clicking: <a target="_blank" href="{{ URL::to('/').'/'.$flat->flat_short_name }}">{{ URL::to('/').'/'.$flat->flat_short_name }}</a> </p>
    <p>Thank you.<br>
        <strong>{{ isset($flat) ? $flat->flat_full_name : '' }} Meal System</strong>
        <br>Powered By - General Meal System<br>
        If you have any query, please talk to manager of the session or send a mail to <u>{{ $flat->flat_email}}</u> (Manager's Email)
    </p>





</div>


</body>
</html>