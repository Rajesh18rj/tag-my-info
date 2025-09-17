<!DOCTYPE html>
<html>
<head>
    <title>QR Code Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

<h2>QR Code Details</h2>

<div class="row mt-4">
    <!-- Left side: QR -->
    <div class="col-md-6 text-center">
        {!! QrCode::size(200)->generate(url('/qr-details/' . $qr->id)) !!}
        <p class="mt-2"><strong>QR Code:</strong> {{ $qr->code }}</p>
    </div>

    <!-- Right side: Details -->
    <div class="col-md-6">
        @if($qr->details)
            <p><strong>Name:</strong> {{ $qr->details->name }}</p>
            <p><strong>Email:</strong> {{ $qr->details->email }}</p>
            <p><strong>Description:</strong> {{ $qr->details->description }}</p>
        @else
            <p>No details mapped yet.</p>
        @endif
    </div>
</div>

</body>
</html>
