<!-- resources/views/admin/report-pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Loan Refund Full Report</title>
  <style>
    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 10.5px;
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
      font-size: 10px;
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

@php
  $sortCodes = [
    'Access Bank plc' => '044',
    'Alpha Morgan Bank' => '108',
    'Citibank Nigeria Ltd' => '023',
    'Ecobank Nigeria Plc' => '050',
    'Fidelity Bank Plc' => '070',
    'First Bank Nigeria Ltd' => '011',
    'First City Monument Bank Plc' => '214',
    'Globus Bank Ltd' => '103',
    'Guaranty Trust Bank Plc' => '058',
    'Jaiz Bank Plc' => '301',
    'Keystone Bank Ltd' => '082',
    'Lotus Bank' => '303',
    'Nova Commercial Bank Ltd' => '461',
    'Polaris Bank Plc' => '076',
    'Premium Trust Bank' => '105',
    'Providus Bank Ltd' => '101',
    'Signature Bank Ltd' => '106',
    'Stanbic IBTC Bank Plc' => '221',
    'Standard Chartered Bank Nigeria Ltd' => '068',
    'Sterling Bank' => '232',
    'SunTrust Bank Nigeria Ltd' => '100',
    'Taj Bank' => '626',
    'Titan Trust Bank Ltd' => '102',
    'Union Bank of Nigeria Plc' => '032',
    'United Bank for Africa Plc' => '033',
    'Unity Bank Plc' => '215',
    'Wema Bank Plc' => '035',
    'Zenith Bank Plc' => '057',
  ];
@endphp

<table>
  <thead>
    <tr>
      <th style="width: 12%;">Full Name</th>
      <th style="width: 7%;">Matric No</th>
      <th style="width: 10%;">Department</th>
      <th style="width: 5%;">Level</th>
      <th style="width: 8%;">Faculty</th>
      <th style="width: 8%;">Loan Amount</th>
      <th style="width: 6%;">Levies</th>
      <th style="width: 8%;">Amount Paid</th>
      <th style="width: 9%;">Refund</th>
      <th style="width: 9%;">NELFUND Tracking ID</th>
      <th style="width: 10%;">Account Info</th>
      <th style="width: 6%;">Bank</th>
      <th style="width: 6%;">Sort Code</th>
      <th style="width: 8%;">Phone</th>
      <th style="width: 10%;">Email</th>
      <th style="width: 10%;">Hostel</th>
      <th style="width: 10%;">Submitted At</th>
      <th style="width: 10%;">Approved At</th>
      <th style="width: 10%;">Disbursed At</th>
      <th style="width: 6%;">Status</th>
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
      <td>₦{{ number_format($app->student->refund_amount, 2) }}</td>
      <td>{{ $app->tracking_id }}</td>
      <td>{{ $app->account_name }}<br>{{ $app->account_number }}</td>
      <td>{{ $app->bank_name }}</td>
      <td>{{ $sortCodes[$app->bank_name] ?? 'N/A' }}</td>
      <td>{{ $app->phone }}</td>
      <td>{{ $app->email }}</td>
      <td>{{ $app->hostel }}</td>
      <td>{{ optional($app->submitted_at)->format('d M Y, h:i A') }}</td>
      <td>{{ optional($app->approved_at)->format('d M Y, h:i A') }}</td>
      <td>{{ optional($app->disbursed_at)->format('d M Y, h:i A') }}</td>
      <td>{{ ucfirst($app->status) }}</td>
    </tr>
    @endforeach
  </tbody>
</table>

<div class="footer">
  Report generated on {{ now()->format('d M Y, h:i A') }}
</div>

</body>
</html>
