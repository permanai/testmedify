@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2">
                <a href="{{url('kategori')}}" class="btn btn-secondary">Kembali ke Daftar Kategori</a>
            </div>
            <div class="card mb-3">
                <div class="card-header">Detail Kategori</div>

                <div class="card-body">
                    <table>
                        <tr>
                            <th>Kode</th>
                            <td>:</td>
                            <td>{{$data->kode}}</td>
                        </tr>
                        <tr>
                            <th>Nama</th>
                            <td>:</td>
                            <td>{{$data->nama}}</td>
                        </tr>
                    </table>
                    <div class="mt-2">
                        <a class="btn btn-info" href="{{url('kategori/form/edit')}}/{{$data->id}}">Edit</a>
                        <a class="btn btn-danger" href="{{url('kategori/delete')}}/{{$data->id}}" onclick="return confirm('Are you sure you want to delete this kategori?');">Delete</a>
                        <a class="btn btn-success" href="{{url('kategori/pdf')}}/{{$data->id}}" target="_blank">&#8659; Download PDF</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">Item dalam Kategori "{{$data->nama}}"</div>

                <div class="card-body">
                    @if($data->masterItems->count() > 0)
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Jenis</th>
                                <th>Harga Beli</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data->masterItems as $index => $item)
                            <tr>
                                <td>{{$index + 1}}</td>
                                <td>{{$item->kode}}</td>
                                <td>{{$item->nama}}</td>
                                <td>{{$item->jenis}}</td>
                                <td>{{number_format($item->harga_beli)}}</td>
                                <td>
                                    <a href="{{url('master-items/view')}}/{{$item->kode}}" class="btn btn-primary btn-sm">View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p class="text-muted">Belum ada item dalam kategori ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
@endsection
