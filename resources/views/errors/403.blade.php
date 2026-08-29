@section('title', 'Inventaris')
@include('layouts.header')
@include('layouts.sidebar')
<main id="main" class="main">
    <div class="container">
        <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
        <h1>403</h1>
        <h2>Maaf, Anda tidak memiliki akses ke halaman ini  - Akses Ditolak </h2>
        <a href="{{ url('/dashboard') }}" class="btn btn-primary">Kembali ke Dashboard</a>
        </section>
    </div>
</main>
@include('layouts.footer')
