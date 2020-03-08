@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-9">
            <div class="card">
                <div class="card-header">Jenis Kas</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Jenis</th>
                                <th>Keterangan</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cash_types as $cash_type)
                            <tr>
                                <td>{{ $cash_type->id }}</td>
                                <td>{{ $cash_type->type === 'in' ? 'Kas Masuk' : 'Kas Keluar' }}</td>
                                <td>{{ $cash_type->description }}</td>
                                <td class="text-right">
                                    <a href="{{ route('cash-types.edit', $cash_type->id) }}"
                                        class="btn btn-sm btn-warning" title="Edit">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <form class="delete-form d-inline-block"
                                        action="{{ route('cash-types.destroy', $cash_type->id) }}" method="post">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-header">Tambah Jenis Kas</div>
                <div class="card-body">
                    <form action="{{ route('cash-types.store') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="type">Jenis</label>
                            <select name="type" id="type" class="form-control">
                                <option value="in">Kas Masuk</option>
                                <option value="out">Kas Keluar</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Keterangan</label>
                            <input type="text" name="description" id="description" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Tambah</button>
                    </form>
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