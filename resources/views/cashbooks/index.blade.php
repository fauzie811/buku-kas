@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-3">
            <div class="card mb-4">
                <div class="card-header">Tambah Buku Kas</div>
                <div class="card-body">
                    <form action="{{ route('cashbooks.store') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">Keterangan</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-header">Buku Kas</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Keterangan</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cashbooks as $cashbook)
                            <tr>
                                <td>{{ $cashbook->id }}</td>
                                <td>{{ $cashbook->name }}</td>
                                <td class="text-right">
                                    <a href="{{ route('cashbooks.edit', $cashbook->id) }}"
                                        class="btn btn-sm btn-warning" title="Edit">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    @can('admin')
                                    <form class="delete-form d-inline-block"
                                        action="{{ route('cashbooks.destroy', $cashbook->id) }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    jQuery(document).ready(function($) {
        $('.delete-form').submit(function(event) {
            if( !confirm('Hapus data ini?') )
                event.preventDefault();
        })
    })
</script>
@endsection
