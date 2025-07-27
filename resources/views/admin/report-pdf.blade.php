<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Loan Refund Full Report</title>
  <style>
    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 11px;
      margin: 10px 20px;
      color: #333;
    }

    h3 {
      text-align: center;
      color: #0d47a1;
      margin-bottom: 15px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed;
    }

    th, td {
      border: 1px solid #aaa;
      padding: 5px 6px;
      vertical-align: top;
      word-wrap: break-word;
      font-size: 10.5px;
    }

    th {
      background-color: #e3f2fd;
      font-weight: bold;
      text-align: left;
    }

    .footer {
      text-align: right;
      font-size: 10px;
      color: #888;
      margin-top: 10px;
    }
  </style>
</head>
<body>

<h3>Loan Refund Request Report</h3>

<table>
  <thead>
    <tr>
      <th style="width: 14%;">Student Name</th>
      <th style="width: 8%;">Matric No</th>
      <th style="width: 10%;">Department</th>
      <th style="width: 5%;">Level</th>
      <th style="width: 9%;">Faculty</th>
      <th style="width: 8%;">Loan Amount</th>
      <th style="width: 7%;">Levies</th>
      <th style="width: 8%;">Amount Paid</th>
      <th style="width: 9%;">Tracking ID</th>
      <th style="width: 10%;">Account Info</th>
      <th style="width: 5%;">Bank</th>
      <th style="width: 5%;">Status</th>
      <th style="width: 10%;">Submitted On</th>
    </tr>
  </thead>
  <tbody>
    @foreach($applications as $app)
    <tr>
      <td>{{ $app->student->full_name }}</td>
      <td>{{ $app->student->matric_number }}</td>
      <td>{{ $app->student->department }}</td>
      <td>{{ $app->student->level }}</td>
      <td>{{ $app->student->faculty }}</td>
      <td>₦{{ number_format($app->student->loanamount, 2) }}</td>
      <td>₦{{ number_format($app->student->levies, 2) }}</td>
      <td>₦{{ number_format($app->student->amountpaid, 2) }}</td>
      <td>{{ $app->tracking_id }}</td>
      <td>
        {{ $app->account_name }}<br>
        {{ $app->account_number }}
      </td>
      <td>{{ $app->bank_name }}</td>
      <td>{{ ucfirst($app->status) }}</td>
      <td>{{ $app->created_at->format('d M Y, h:i A') }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

<div class="footer">
  Report generated on {{ now()->format('d M Y, h:i A') }}
</div>

</body>
</html>
