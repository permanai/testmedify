@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="form-group mb-2 d-flex gap-2">
                <a href="{{url('master-items/form/new')}}" class="btn btn-secondary">+ Master Items Baru</a>
                <a href="{{url('master-items/export-excel')}}" class="btn btn-success">&#8659; Download Excel</a>
            </div>
            <div class="card">
                <div class="card-header">Daftar Master Items</div>

                <div class="card-body">
                    @include('master_items.index.filter')
                    @include('master_items.index.table')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
<script>
    var MasterItems = {
        searchUrl:  '{{ url("master-items/search") }}',
        viewUrl:    '{{ url("master-items/view") }}',
        storageUrl: '{{ asset("storage/master_items") }}',
    };
</script>
<script src="{{ asset('js/master-items.js') }}"></script>
@endsection