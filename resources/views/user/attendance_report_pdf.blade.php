<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        td:first-child {
            text-align: left;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .logo img {
            width: 100px;
        }
    </style>
</head>

<body>
    <div class="logo">
        <img src="{{ public_path('image/logo.png') }}" alt="Logo">
    </div>

    <h4 style="text-align: center;;">SOCCKSARGEN REGIONAL ATHLETIC ASSOCIATION MEET 2025</h4>
    <p style="text-align: center;">Koronadal City, South Cotabato</p>
    <p style="text-align: center;">Region XII</p>
    <p style="text-align: center;">March 1 - 17, 2025</p>


    <h3 style="text-align: center; margin-top: 35px;">Attendance Report</h3>
    <p style="text-align: center;">
        @if(isset($startDate) && isset($endDate) && $startDate && $endDate)
            Period: from {{ \Carbon\Carbon::parse($startDate)->format('F j, Y') }} to {{ \Carbon\Carbon::parse($endDate)->format('F j, Y') }}.
        @endif
        @if(isset($division))
            Division: {{ $division }}.
        @endif
        @if(isset($role))
            Role: {{ $role }}.
        @endif
    </p>

    <table>
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Full Name</th>
                <th scope="col">Role</th>
                <th scope="col">Division</th>
                <th scope="col">Time Record</th>
                <th scope="col">Date Record</th>
                <th scope="col">Recorded By</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($attendances as $record)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $record->participant->name }}</td>
                    <td>{{ $record->participant->participant_role }}</td>
                    <td>{{ $record->participant->division }}</td>
                    <td>{{ \Carbon\Carbon::parse($record->time_recorded)->format('h:i:s A') }}</td>
                    <td>{{ $record->created_at->format('F j, Y') }}</td>
                    <td>{{ $record->user->name }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No attendance record found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div>
        <h3>Prepared by:</h3>
        <h2>{{Auth::user()->name}}</h2>
        <p style="font-size: 14px">{{ ucfirst(Auth::user()->role) }}</p>
        <p style="font-size: 14px">Generated on: {{ \Carbon\Carbon::now()->format('F j, Y') }}</p>
    </div>
</body>

</html>
