<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Statistik Tiket</title>
    <style type="text/css">
        .border {
            border-color: #000000;
            border-style: double;
            border-top-width: 3px;
            border-bottom-width: 1.5px;
            border-left-width: 0px;
            border-right-width: 0px;
            margin-top: 5px;
        }

        .border-dua {
            border-color: #000000;
            border-style: solid;
            margin-left: auto;
            margin-right: auto;

            border-width: 1px;
            margin-top: 0;
            text-align: center;
        }

        .table-bordered {
            border-collapse: collapse;
            width: 100%;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table-bordered th {
            padding-top: 12px;
            padding-bottom: 12px;
            background-color: #f2f2f2;
            color: black;
        }

        .table-container {
            width: 100%;
        }

        .table-container td {
            width: 50%;
            font-size: 14px;
            font-family: Arial, sans-serif;
        }
    </style>

</head>

<body>
    <table>
        <tr>
            <th><img style="width:150px;" src="{{ asset('images/logo.jpg') }}"></img></th>
            <th style="font-family: arial; font-size: 25px; padding-left: 30px; color:"><span style="color: red">PT
                    SAMCO
                    FARMA</span><br>
                <small style="font-size: 14px; font-weight: normal; margin-bottom: 0;">
                    (PHARMACEUTICAL & CHEMICAL INDUSTRIES)
                </small><br>
                <small style="font-size: 12px; font-weight: normal; margin-bottom: 0;">
                    Jl. Jend Gatot Subroto Km. 1,2 No. 27 Cibodas – Tangerang, Banten 15138
                </small><br>
                <small style="font-size: 12px; font-weight: normal; margin-bottom: 0;">
                    Telp. : (021) 5525810 ext 270, Fax. : (021) 5537097
                </small><br>
                <small style="font-size: 12px; font-weight: normal; margin-top: 0;">
                    Website : <a href="www.samcofarma.co.id">www.samcofarma.co.id</a> E-mail : <a
                        href="mailto:cs@samcofarma.co.id">cs@samcofarma.co.id</a>
                </small>
            </th>
            <th><img style="width:100px;" src="{{ asset('images/certificate.jpg') }}"></img></th>
        </tr>
    </table>
    <div class="border">
    </div>
    <div style="float: right; margin-top: 20px">
        <b>
            @if (request('start_date') && request('end_date'))
                {{ toDateIndo(request('start_date')) . ' - ' . toDateIndo(request('end_date')) }}
            @else
                {{ toMonthIndo(date('m')) }}
            @endif
        </b>
    </div>
    <table class="table table-bordered" style="margin-top: 50px">
        <thead>
            <th>#</th>
            <th>{{ __('Asset Name') }}</th>
            <th>{{ __('Service') }}</th>
            <th>{{ __('Downtime') }}</th>
        </thead>
        <tbody>
            @php
                $totalService = 0;
                $totalDowntime = 0;
            @endphp
            @foreach ($monthlyTicket as $t)
                @php
                    $totalService += $t['service_count'];
                    $totalDowntime += $t['downtime'];
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $t['asset_name'] }}</td>
                    <td>{{ $t['service_count'] . ' Kali' }} </td>
                    <td>{{ $t['downtime'] . 'Menit' }} </td>
                </tr>
            @endforeach
            <tr>
                <td style="font-size: 14px; text-align: center" colspan="2"><b>{{ __('Total') }}</b></td>
                <td><b>{{ $totalService . ' Kali' }}</b></td>
                <td><b>{{ $totalDowntime . 'Menit' }}</b></td>
            </tr>
    </table>
    <table width="100%" style="margin-top: 13px">
        <tr>
            <td width="90%"></td>
            <td style="font-size: 14px; font-family: arial;"><strong>{{ __('Approved by') }}</strong>
                <br><br><br><br>
                Supriyo
            </td>
        </tr>
    </table>
</body>

</html>
