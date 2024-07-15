<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print {{ $ticket->code }}</title>
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
    </style>

</head>

<body>
    <table>
        <tr>
            <th><img style="width:150px;" src="{{ asset('images/logo.jpg') }}"></img></th>
            <th style="font-family: arial; font-size: 25px; padding-left: 30px; color:"><span style="color: red">PT SAMCO
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
    <p></p>
    <p style="text-align: center; font-family: arial; font-size: 15px; text-transform: uppercase;margin-bottom: 0px">
        <b>PERMINTAAN PEKERJAAN</b>
    </p>
    <div class="border-dua" style="width: 170px;"></div>
    <p style="text-align: center; font-size: 14px; font-family: arial; line-height: -4em; margin-top: 0;">Nomor:
        {{ $ticket->type == 'produksi' ? 'SF/TK-003.2' : 'SF/MIS-004' }}</p>
    <div style="text-align: center; margin-top: 5px">
        <table>
            <tr>
                <td width="250" style="vertical-align: top;">
                    <table style="margin-left: 0px; margin-right: auto;">
                        <tr>
                            <td width="80"
                                style="font-size: 14px; font-family: arial; padding-left: 1%; padding-top: 15px;">
                                {{ __('Staff Name') }}
                            <td style="padding-left: -40%; padding-top: 15px;">:</td>
                            <td style="font-size: 14px; font-family: arial; padding-left: -40%; padding-top: 15px;">
                                {{ $ticket->staff->name }}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; font-family: arial; padding-left: 1%;"> {{ __('Position') }}
                            <td style="padding-left: -40%;">:</td>
                            <td style="font-size: 14px; font-family: arial; padding-left: -40%;">
                                {{ $ticket->staff->position }}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; font-family: arial; padding-left: 1%;">
                                {{ __('Ticket Category') }}
                            <td style="padding-left: -40%;">:</td>
                            <td style="font-size: 14px; font-family: arial; padding-left: -40%;">
                                {{ Str::ucfirst($ticket->asset->category) }}</td>
                        </tr>
                        @if ($ticket->asset->type != 'service')
                            <tr>
                                <td style="font-size: 14px; font-family: arial; padding-left: 1%;">
                                    {{ __('Asset Number') }}
                                <td style="padding-left: -40%;">:</td>
                                <td style="font-size: 14px; font-family: arial; padding-left: -40%;">
                                    {{ $ticket->asset->code }}</td>
                            </tr>
                        @endif
                        <tr>
                            <td style="font-size: 14px; font-family: arial; padding-left: 1%;">
                                {{ $ticket->asset->type == 'service' ? __('Service Name') : __('Asset Name') }}
                            <td style="padding-left: -40%;">:</td>
                            <td style="font-size: 14px; font-family: arial; padding-left: -40%;">
                                {{ $ticket->asset->name }}</td>
                        </tr>
                        @if ($ticket->type == 'produksi')
                            <tr>
                                <td style="font-size: 14px; font-family: arial; padding-left: 1%;">{{ __('Location') }}
                                <td style="padding-left: -40%;">:</td>
                                <td style="font-size: 14px; font-family: arial; padding-left: -40%;">
                                    {{ $ticket->asset?->location?->name }}</td>
                            </tr>
                        @else
                            <tr>
                                <td style="font-size: 14px; font-family: arial; padding-left: 1%;">{{ __('PIC') }}
                                <td style="padding-left: -40%;">:</td>
                                <td style="font-size: 14px; font-family: arial; padding-left: -40%;">
                                    {{ __($ticket->asset?->pic?->name) }}</td>
                            </tr>
                        @endif
                        @if ($ticket->asset->type != 'service')
                            <tr>
                                <td style="font-size: 14px; font-family: arial; padding-left: 1%;">
                                    {{ __('Condition') }}
                                <td style="padding-left: -40%;">:</td>
                                <td style="font-size: 14px; font-family: arial; padding-left: -40%;">
                                    {{ __($ticket->condition) }}</td>
                            </tr>
                        @endif
                    </table>
                </td>
                <td style="vertical-align: top;" width="215">
                    <table style="margin-left: 0px; margin-right: auto;">
                        <tr>
                            <td width="80"
                                style="font-size: 14px; font-family: arial; padding-left: 1%; padding-top: 15px;">
                                {{ __('Damaged Time') }}
                            <td style="padding-left: -40%; padding-top: 15px">:</td>
                            <td style="font-size: 14px; font-family: arial; padding-left: -40%; padding-top: 15px;">
                                {{ toDateTimeIndo($ticket->damage_time) }}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; font-family: arial; padding-left: 1%;">{{ __('Process Time') }}
                            <td style="padding-left: -40%;">:</td>
                            <td style="font-size: 14px; font-family: arial; padding-left: -40%;">
                                {{ toDateTimeIndo($ticket->start_time) }}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; font-family: arial; padding-left: 1%;">{{ __('Finish Time') }}
                            <td style="padding-left: -40%;">:</td>
                            <td style="font-size: 14px; font-family: arial; padding-left: -40%;">
                                {{ toDateTimeIndo($ticket->finish_time) }}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; font-family: arial; padding-left: 1%;">{{ __('Downtime') }}
                            <td style="padding-left: -40%;">:</td>
                            <td style="font-size: 14px; font-family: arial; padding-left: -40%;">
                                {{ downtime($ticket->start_time, $ticket->finish_time) }}</td>
                        </tr>
                        {{-- <tr>
                        <td style="font-size: 14px; font-family: arial; padding-left: 1%;">{{ __("Problem Analysis") }}
                        <td style="padding-left: -40%;">:</td>
                        <td style="font-size: 14px; font-family: arial; padding-left: -40%;">{{ $ticket->problem_analysis }}</td>
                    </tr>        
                    <tr>
                        <td style="font-size: 14px; font-family: arial; padding-left: 1%;">{{ __("Problem Action") }}
                        <td style="padding-left: -40%;">:</td>
                        <td style="font-size: 14px; font-family: arial; padding-left: -40%;">{{ $ticket->action }}</td>
                    </tr>      --}}
                    </table>
                </td>
            </tr>
        </table>
        <table class="table table-bordered" style="margin-top: 20px; font-size: 14px">
            <thead>
                <tr>
                    {{-- <th style="text-align: center; font-size: 14px;">{{ __('Problem Analysis') }}</th> --}}
                    <th style="text-align: center">{{ __('Problem Action') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    {{-- <td>{{ $ticket->problem_analysis }}</td> --}}
                    <td>{{ $ticket->action }}</td>
                </tr>
            </tbody>
        </table>
        @if ($ticket->type = 'produksi' && $ticket->sparepart->count() > 0)
            <p
                style="text-align: center; font-family: arial; font-size: 15px; text-transform: uppercase;margin-bottom: 0px">
                <b>{{ __('Use of spare parts') }}</b>
            </p>
            <div class="border-dua" style="width: 200px;"></div>
            <table class="table table-bordered" style="margin-top: 20px; font-size: 14px">
                <thead>
                    <tr>
                        <th style="text-align: center; font-size: 14px;">No</th>
                        <th style="text-align: center">{{ __('Name') }}</th>
                        <th style="text-align: center">{{ __('Sum') }}</th>
                        <th style="text-align: center">{{ __('Unit') }}</th>
                        <th style="text-align: center">{{ __('Information') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ticket->sparepart as $item)
                        <tr>
                            <td style="text-align: center">{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td style="text-align: center">{{ $item->total }}</td>
                            <td style="text-align: center">{{ $item->unit }}</td>
                            <td>{{ $item->information != null ? $item->information : '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <br><br>
    <div>
        <table>
            <tr>
                <td width="400"></td>
                <td style="font-size: 14px; font-family: arial;">Jakarta, {{ toDateIndo($ticket->updated_at) }}</td>
            </tr>
            <tr>
                <td style="font-size: 14px; font-family: arial;">{{ __('Known By') }}</td>
            </tr>
            <tr>
                <td style="font-size: 14px; font-family: arial;">{{ __('Staff Leader') }}</td>
                <td style="font-size: 14px; font-family: arial;">{{ __('Technician Boss') }} </td>
            </tr>
            <tr>
                <td style="font-size: 14px; font-family: arial;"><br><br><br><br> <b>{{ $ticket->boss?->name }}</b>
                </td>
                <td style="font-size: 14px; font-family: arial;">
                    <br><br><br><br><b>{{ $ticket->technicianBoss?->name }}</b>
                </td>
            </tr>
        </table>
    </div>
    <div style="margin-top: 20px">
        <table>
            <tr>
                <td style="font-size: 14px; font-family: arial;text-align: center"width="500">{{ __('Report By') }}
                </td>
            </tr>
            <tr>
                <td style="font-size: 14px; font-family: arial;text-align: center">
                    <br><br><br><br><b>{{ $ticket->staff?->name }}</b>
                </td>
            </tr>
        </table>
    </div>
    <div style="margin-top: 10px">
        <table>
            <tr>
                <td width="500" style="font-size: 14px; font-family: arial; text-align: center;">
                    {{ __('Done By') }}
                    <br>
                </td>
            </tr>
            <tr>
                <td style="font-size: 14px; font-family: arial; text-align: center;">{{ __('Technician') }}</td>
            </tr>
        </table>

        @php
            $technicians = $ticket->technician->where('status', 1);
            $technicianCount = $technicians->count();
        @endphp

        <table border="0" style="margin-top: 100px;">
            <tr>
                @if ($technicianCount == 1)
                    <td style="font-size: 14px; font-family: Arial; width: 660px; text-align: center;">
                        <b>{{ $technicians->first()->technician->name }}</b>
                    </td>
                @else
                    @foreach ($technicians as $index => $tech)
                        <td
                            style="font-size: 14px; font-family: Arial; width: 280px; {{ $index % 2 == 0 ? 'text-align: right;' : '' }}">
                            <b>{{ $tech->technician->name }}</b>
                        </td>
                    @endforeach
                    @if ($technicianCount % 2 == 1)
                        <td style="font-size: 14px; font-family: Arial; width: 280px;"></td>
                    @endif
                @endif
            </tr>
        </table>



    </div>
</body>

</html>
