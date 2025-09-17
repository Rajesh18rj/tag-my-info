<!DOCTYPE html>
<html>
<head>
    <title>QR List</title>
</head>
<body>
<h2>All QR Codes</h2>

@if(session('success')) <p style="color:green">{{ session('success') }}</p> @endif
@if(session('error')) <p style="color:red">{{ session('error') }}</p> @endif

<a href="{{ route('qr.form') }}">Map Data to Free QR</a>
<br><br>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>UID</th>
        <th>PIN</th>
        <th>Code</th>
        <th>Code Image</th>
        <th>Status</th>
        <th>Details</th>
    </tr>
    @foreach($qrcodes as $qr)
        <tr>
            <td>{{ $qr->id }}</td>
            <td>{{ $qr->uid }}</td>
            <td>{{ $qr->pin }}</td>
            <td>{{ $qr->code }}</td>
            <td>
                {!! QrCode::size(120)->generate(url('/qr-details/' . $qr->id)) !!}
            </td>


            <td>{{ $qr->status ? 'Used' : 'Free' }}</td>
            <td>
                @if($qr->detail)
                    {{ $qr->detail->name }} ({{ $qr->detail->email }})
                @else
                    -
                @endif
            </td>
        </tr>
    @endforeach
</table>
</body>
</html>
