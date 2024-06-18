@extends('layouts.adm-main')

@section('content')

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif
@if(session('Gagal'))
    <div class="alert alert-danger mt-3">
        {{session('Gagal')}}
    </div>
@endif

        <div class="col-lg-12 margin-tb m-4">
            <div class="pull-left">
                <h2>Daftar Barang Masuk</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('barang_masuk.create') }}"> Tambah Barang Masuk </a>
            </div>
        </div>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>TANGGAL MASUK</th>
                            <th>JUMLAH MASUK</th>
                            <th>BARANG</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rsetBarangMasuk as $rowbarangmasuk)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $rowbarangmasuk->tgl_masuk  }}</td>
                                <td>{{ $rowbarangmasuk->qty_masuk  }}</td>
                                <td>{{ $rowbarangmasuk->barang->merk  }} </td>
                                <td>
                                    <form action="{{ route('barang_masuk.destroy', $rowbarangmasuk->id) }}" method="POST">
                                    <a href="{{ route('barang_masuk.show', $rowbarangmasuk->id) }}" class="btn btn-sm btn-dark"><i class="fa fa-eye"></i></a>
                                    <a href="{{ route('barang_masuk.edit', $rowbarangmasuk->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil-alt"></i></a>
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
                {!! $rsetBarangMasuk->links('pagination::bootstrap-5') !!}

            </div>
        </div>
    </div>
@endsection
