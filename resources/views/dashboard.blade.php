
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Welcome, {{ Auth::user()->nama_takmir }}</h1>

        dttyuimk dxertghyiumkm,
        <!-- Role-based content -->
        @if (Auth::user()->role->nama_role == 'admin')
            <h2>Admin Dashboard</h2>
            <p>Konten khusus admin.</p>
        @elseif (Auth::user()->role->nama_role == 'bendahara')
            <h2>Bendahara Dashboard</h2>
            <p>Konten khusus bendahara.</p>
        @elseif (Auth::user()->role->nama_role == 'sekretaris')
            <h2>Sekretaris Dashboard</h2>
            <p>Konten khusus sekretaris.</p>
        @else
            <p>You have no role assigned.</p>
        @endif

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>
</body>
</html>
