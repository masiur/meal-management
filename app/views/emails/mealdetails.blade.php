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
            <td>{{ $meal_count }} BDT</td>
         </tr>
         <tr>
            <td>Deposit Balance</td>
            <td> {{ $balance }}/- BDT</td>
         </tr>
         <tr>
            <td rowspan="{{ count($bazars) + 2 }}">Bazar Done till Date</td>
         </tr>
         @foreach($bazars as $date => $amount)
         <tr>
            <td> Date: {{ $date }} - Amount: {{ $amount }}/- BDT</td>
         </tr>
         @endforeach
         
      </table>
      <p>Thank you.<br>
         <strong>{{ $flat }} Meal System</strong>
         <br>Powered By - General Meal System<br>
         If you have any query, please talk to manager of the session or send a mail to <u>{{ $flat_email}}</u> (Manager's Email)
      </p>
   </body>
</html>

