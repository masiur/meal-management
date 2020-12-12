<!DOCTYPE html>
<html lang="en-US">
   <head>
      <meta charset="utf-8">
      <style>
         table, th, td {
         border: 1px solid black;
         border-collapse: collapse;
         }
      </style>
   </head>
   <body>
      <p>Dear <b>Mr {{ $member_name }}</b>,</p>
      <p>Please find the details as follows:</p>
      <table style="width:80%">
         <tr>
            <th>Particulars</th>
            <th>Details</th>
         </tr>
         <tr>
            <td>Meal Month/Session</td>
            <td><b>{{ $month->name }}</b>, From {{ $month->start_time }}</td>
         </tr>
         <tr>
            <td>No. of Meal Consumed till date</td>
            <td><b>{{ $meal_count }}</b></td>
         </tr>
         
         <tr>
            <td>Deposit Balance</td>
            <td> {{ $balance }}/- BDT</td>
         </tr>
         <?php $sum = 0.0 ?>
         @if(count($bazars) > 0 )
            <tr>
               <td rowspan="{{ count($bazars) + 1 }}">Bazar Done till Date</td>
            </tr>
            

            @foreach($bazars as $bazar)
            <?php $sum += $bazar->amount; ?> 
            <tr>
               <td> Date: {{ $bazar->date }} - Amount: {{ $bazar->amount }}/- BDT</td>
            </tr>
            @endforeach
         @endif

         <tr>
            <td>Total Spent</td>
            <td><b>{{ $balance + $sum }}/- BDT</b></td>
         </tr>

      </table>

      <p>You can visit for Updated Meal Details by Clicking: <a target="_blank" href="{{ URL::to('/').'/'.$flat_short_name }}">{{ $flat }} Meal System</a> </p>
      <p>Thank you.<br>
         <strong>{{ $flat }} Meal System</strong>
         <br>Powered By - General Meal System<br>
         If you have any query, please talk to manager of the session or send a mail to <u>{{ $flat_email}}</u> (Manager's Email)
      </p>
   </body>
</html>

