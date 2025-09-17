<!DOCTYPE html>
<html>
<head>
    <title>Map Data to QR</title>
</head>
<body>
<h2>Mapping Data to QR: {{ $qr->code }}</h2>

@if(session('error'))
    <div style="color: red; font-weight: bold;">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div style="color: red;">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<form action="{{ route('qr.store') }}" method="POST">
    @csrf
    <input type="hidden" name="qr_code_id" value="{{ $qr->id }}">

    <label>Name:</label>
    <input type="text" name="name" required><br><br>

    <label>Email:</label>
    <input type="email" name="email" required><br><br>

    <label>Description:</label>
    <textarea name="description"></textarea><br><br>

    <label>UID:</label>
    <input type="text" name="uid" required><br><br>

    <label>PIN:</label>
    <input type="text" name="pin" required><br><br>

    <button type="submit">Save</button>
</form>
</body>
</html>
