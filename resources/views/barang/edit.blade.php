@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                    <form action="{{ route('barang.update', $rsetBarang->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="pull-right">
                                <a class="btn btn-primary" href="{{ route('barang.index') }}"> Back</a>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Merk</label>
                                <input type="text" class="form-control @error('merk') is-invalid @enderror" name="merk" value="{{ old('merk', $rsetBarang->merk) }}" placeholder="Masukkan Nama Barang">

                                <!-- error message untuk nama -->
                                @error('merk')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Seri</label>
                                <input type="text" class="form-control @error('seri') is-invalid @enderror" name="seri" value="{{ old('seri', $rsetBarang->seri) }}" placeholder="Masukkan Nama Barang">

                                <!-- error message untuk seri -->
                                @error('seri')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Stok</label>
                                <input type="text" class="form-control" value="{{ $rsetBarang->stok }}" readonly>
                                <small class="text-muted">Stok tidak dapat diubah melalui formulir ini. Lakukan perubahan stok melalui Barang Masuk dan Barang Keluar.</small>
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Spesifikasi</label>
                                <input type="text" class="form-control @error('spesifikasi') is-invalid @enderror" name="spesifikasi" value="{{ old('spesifikasi', $rsetBarang->spesifikasi) }}" placeholder="Masukkan spesifikasi Barang">

                                <!-- error message untuk spesifikasi -->
                                @error('spesifikasi')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- <div class="form-group">
                                <label class="font-weight-bold">Kategori</label>
                                <div class="form-check">
                                    <select class="form-select" name="kategori" aria-label="Default select example">
                                        @foreach($akategori as $key=>$val)
                                            @if($rsetBarang->kategori==$key)
                                                <option value="{{ $key }}" selected>{{ $val }}</option>
                                            @else
                                                <option value="{{ $key }}">{{ $val }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                error message untuk kategori
                                @error('kategori')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div> -->

                            <!-- <div class="form-group">
                                <label class="font-weight-bold">FOTO</label>
                                <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto">
                                error message untuk foto
                                @error('foto')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div> -->

                            <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection