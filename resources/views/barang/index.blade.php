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
                    <h2>Daftar Barang</h2>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-lg-12 d-flex justify-content-between">
                    <a class="btn btn-success" href="{{ route('barang.create') }}"> Tambah Barang </a>
                    <form action="{{ route('barang.index') }}" method="GET" class="form-inline">
                        <div class="input-group">
                            <input type="text" name="query" class="form-control" placeholder="Cari barang..." value="{{ request('query') }}">
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
                <tr>
                    <th>NO</th>
                    <th>Merk</th>
                    <th>Seri</th>
                    <th>Spesifikasi</th>
                    <th>Stok</th>
                    <th>Kategori</th>
                    <th>Action</th>
                </tr>
            
                @foreach ($rsetBarang as $rowbarang)
                
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $rowbarang->merk }}</td>
                        <td>{{ $rowbarang->seri }}</td>
                        <td>{{ $rowbarang->spesifikasi }}</td>
                        <td>{{ $rowbarang->stok }}</td>
                        <td>{{ optional($rowbarang->kategori)->kategori}}</td>
                        <td>
                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('barang.destroy',$rowbarang->id) }}" method="POST">
                                <a class="btn btn-sm btn-dark"  href="{{ route('barang.show',$rowbarang->id) }}"><i class="fa fa-eye"></i></a>        
                                <a class="btn btn-sm btn-primary" href="{{ route('barang.edit',$rowbarang->id) }}"><i class="fa fa-pencil-alt"></i></a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </table>

            {!! $rsetBarang->links('pagination::bootstrap-5') !!}
        </div>
        
@endsection