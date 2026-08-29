@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Donatur</h1>
        <form action="{{ route('donatur.update', $donatur->id_donatur) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama_donatur">Nama Donatur</label>
                <input type="text" name="nama_donatur" class="form-control" value="{{ $donatur->nama_donatur }}" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" name="alamat" class="form-control" value="{{ $donatur->alamat }}" required>
            </div>
            
            <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" value="{{ $donatur->tanggal }}" required>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </form>
    </div>
@endsection
