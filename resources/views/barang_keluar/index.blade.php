@extends('layouts.adm-main')

@section('content')
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        @if ($error = Session::get('qty_keluar'))
            <div class="alert alert-danger">
                <p>{{ $error }}</p>
            </div>
        @endif
        
        <div class="col-lg-12 margin-tb m-4">
            <div class="pull-left">
                <h2>Daftar Barang Keluar</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('barang_keluar.create') }}"> Tambah Barang Keluar </a>
            </div>
        </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>TANGGAL KELUAR</th>
                            <th>JUMLAH KELUAR</th>
                            <th>BARANG</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rsetBarangKeluar as $rowbarangkeluar)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $rowbarangkeluar->tgl_keluar  }}</td>
                                <td>{{ $rowbarangkeluar->qty_keluar  }}</td>
                                <td>{{ $rowbarangkeluar->barang->merk  }} {{ $rowbarangkeluar->barang->seri  }}</td>
                                <td>
                                    <form action="{{ route('barang_keluar.destroy', $rowbarangkeluar->id) }}" method="POST">
                                    <a href="{{ route('barang_keluar.show', $rowbarangkeluar->id) }}" class="btn btn-sm btn-dark"><i class="fa fa-eye"></i></a>
                                    <a href="{{ route('barang_keluar.edit', $rowbarangkeluar->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil-alt"></i></a>    
                                    @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <div class="alert">
                                Data barang belum tersedia!
                            </div>
                        @endforelse
                    </tbody>
                   
                </table>
                {!! $rsetBarangKeluar->links('pagination::bootstrap-5') !!}


            </div>
        </div>
    </div>
@endsection
