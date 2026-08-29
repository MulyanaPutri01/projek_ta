@extends('layouts.app')

@section('content')
    <h1>Tambah Kategori</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kategori.store') }}" method="POST">
        @csrf
        <label for="id_kategori">ID Kategori:</label>
        <input type="text" name="id_kategori" id="id_kategori" value="{{ old('id_kategori') }}" required maxlength="2">
        <br>
        <label for="nama_kategori">Nama Kategori:</label>
        <input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori') }}" required maxlength="15">
        <br>
        <button type="submit">Simpan</button>
    </form>
@endsection
