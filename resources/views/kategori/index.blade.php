@extends('layouts.adm-main')

@section('content')

@if ($message = Session::get('success'))
    <div class="container">
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    </div>
@endif
@if(session('Gagal'))
    <div class="alert alert-danger mt-3">
        {{session('Gagal')}}
    </div>
@endif

    <div class="container">
        <div class="row mb-3">
            <div class="col-lg-12">
                <h2>Daftar Kategori</h2>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-12 d-flex justify-content-between">
                <a class="btn btn-success" href="{{ route('kategori.create') }}"> Tambah kategori </a>
                <form action="{{ route('kategori.index') }}" method="GET" class="form-inline">
                    <div class="input-group">
                        <input type="text" name="query" class="form-control" placeholder="Cari kategori..." value="{{ request('query') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Kategori</th>
                    <th>Jenis</th>
                    <th style="width: 15%">action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rsetKategori as $rowkategori)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $rowkategori->kategori }}</td>
                        <td>{{ $rowkategori->ketkategorik }}</td>
                        <td>
                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('kategori.destroy', $rowkategori->id) }}" method="POST">
                                <a class="btn btn-sm btn-dark" href="{{ route('kategori.show', $rowkategori->id) }}"><i class="fa fa-eye"></i></a>
                                <a class="btn btn-sm btn-primary" href="{{ route('kategori.edit', $rowkategori->id) }}"><i class="fa fa-pencil-alt"></i></a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {!! $rsetKategori->links('pagination::bootstrap-5') !!}
    </div>

@endsection
