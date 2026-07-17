<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <title>Smart Waste Bin Report</title>

    <style>

        body{
            font-family: DejaVu Sans, sans-serif;
            font-size:12px;
            color:#333;
        }

        h1,h2,h3{
            margin:0;
        }

        .header{
            text-align:center;
            border-bottom:2px solid #2E7D32;
            padding-bottom:15px;
            margin-bottom:25px;
        }

        .header h1{
            color:#2E7D32;
        }

        .summary{
            width:100%;
            margin-bottom:25px;
        }

        .summary td{
            border:1px solid #ddd;
            padding:12px;
        }

        .title{
            background:#2E7D32;
            color:white;
            font-weight:bold;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:15px;
        }

        th{
            background:#2E7D32;
            color:white;
            padding:10px;
            border:1px solid #ddd;
        }

        td{
            padding:8px;
            border:1px solid #ddd;
        }

        .success{
            color:#2E7D32;
            font-weight:bold;
        }

        .full{
            color:red;
            font-weight:bold;
        }

        .maintenance{
            color:orange;
            font-weight:bold;
        }

        .footer{
            margin-top:40px;
            text-align:center;
            font-size:10px;
            color:#666;
        }

    </style>

</head>

<body>

<div class="header">

    <h1>SMART WASTE BIN</h1>

    <h2>Laporan Monitoring</h2>

    <br>

    Dicetak :

    {{ $generatedAt->format('d M Y H:i:s') }}

</div>

<table class="summary">

<tr>

<td class="title">Total Sorting</td>

<td>{{ $totalSorting }}</td>

<td class="title">Full Events</td>

<td>{{ $fullEvents }}</td>

</tr>

</table>

<h3>Current Bin Status</h3>

<table>

<thead>

<tr>

<th>Bin</th>

<th>Capacity</th>

<th>Status</th>

</tr>

</thead>

<tbody>

@foreach($bins as $bin)

<tr>

<td>

{{ $bin->name }}

</td>

<td>

{{ $bin->capacity }}%

</td>

<td>

@if($bin->computed_status=="Full")

<span class="full">

Full

</span>

@elseif($bin->computed_status=="Maintenance")

<span class="maintenance">

Maintenance

</span>

@else

<span class="success">

Normal

</span>

@endif

</td>

</td>

</tr>

@endforeach

</tbody>

</table>

<br><br>

<h3>Latest Activity</h3>

<table>

<thead>

<tr>

<th>Time</th>

<th>Bin</th>

<th>Status</th>

<th>Message</th>

<th>Triggered By</th>

</tr>

</thead>

<tbody>

@foreach($history as $item)

<tr>

<td>

{{ optional($item->created_at)->format('d/m/Y H:i') }}

</td>

<td>

{{ $item->bin_name }}

</td>

<td>

{{ $item->status }}

</td>

<td>

{{ $item->message }}

</td>

<td>

{{ $item->triggered_by }}

</td>

</tr>

@endforeach

</tbody>

</table>

<div class="footer">

    Dicetak otomatis oleh

    <b>Smart Waste Bin Monitoring System</b>

<br>

Politeknik Negeri Batam

</div>

</body>

</html>