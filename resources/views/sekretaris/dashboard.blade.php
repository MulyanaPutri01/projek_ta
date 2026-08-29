@include('layouts.header')
@include('layouts.sidebar')
<main id="main" class="main">
    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
          <li class="breadcrumb-item active">Sekretaris</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1>Welcome, {{ Auth::user()->nama_takmir }}</h1>

                </h2>
            </div>
        </div>
    </div>

@include('layouts.footer')
