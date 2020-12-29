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
        .striped-border {
            border: 1px dashed #000;
            /*width: 50%;*/
            /*margin: auto;*/
            margin-right: 45%;
            /*margin-bottom: 5%;*/
            /*left: 0;*/
        }
    </style>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <title>Meal Details/Invoice - {{ $flat->flat_short_name }} | General Meal System </title>
</head>
<body>

<div class="container">
    <h2>{{ $flat->flat_full_name }} Meal System</h2>
    <h3>Session: {{ $meals->month->name }} <span style="font-size: 8pt"> {{ $meals->month->start_time }} --> {{  $meals->month->closing_time  }}</span></h3>


    <h4>Dear <b>Mr {{ $meals->member->name }}</b></h4>
    <p>Thank You for sharing meal with us. Your details stated below:</p>

    <div class="row">
        <div class="col-xs-6">
            <h4>Meal Rate: {{ $meal_rate ? $meal_rate : 0.00 }}</h4>
            <h4>Consumed Meal: {{ $meals->count }}</h4>
        </div>
        <div class="col-xs-6">
            <?php
                $total = ($meal_rate * $meals->count);
                $paid = ($meals->balance + $total_bazar);
                $due = $total - $paid;
            ?>
            <h4>Total Payable: {{ number_format($total, 2) }} BDT</h4>
            <h4>Amount Paid: {{ number_format($paid, 2) }} BDT</h4>
            <hr class="striped-border">
                @if($due > 0)
                    <h4 style="color: red;">Due: <strong>{{ number_format(abs($due)) }} BDT</strong></h4>
                    <span style="font-size: 8pt">**Please pay the mentioned amount as soon as possible.</span>
                @else
                    <h4 style="color: green;">Surplus: <strong>{{ number_format(abs($due)) }} BDT</strong></h4>
                    <span style="font-size: 8pt">*Be patient. You will receive the mentioned amount after others' due settled</span>
                @endif

        </div>

    </div>




    <table style="width:80%">
        <tr>
            <th>Particulars</th>
            <th>Details</th>
        </tr>
        <tr>
            <td>Member Name</td>
            <td>{{ $meals->member->name }}</td>
        </tr>
        <tr>
            <td>Month/Session Duration</td>
            <td>{{ DateTime::createFromFormat('Y-m-d', $meals->month->start_time)->format('F d, Y') }}
                    to
                {{ DateTime::createFromFormat('Y-m-d', $meals->month->closing_time)->format('F d, Y') }}</td>
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
    <br>
    <p>You can visit for Updated Meal Details by Clicking: <a  href="{{ URL::to('/').'/'.$flat->flat_short_name }}"><u>
            {{ URL::to('/').'/'.$flat->flat_short_name }}</u></a> </p>
    <p>Thank you.<br>
        <strong>Meal Manager</strong>
        <br>
        <br>The Entire System is Powered By - General Meal System<br>
        If you have any query, please talk to manager of the session or send a mail to <u>{{ $flat->email}}</u> (Manager's Email)
    </p>





</div>


</body>
</html>