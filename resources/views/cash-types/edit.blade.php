@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Jenis Kas</div>
                <div class="card-body">
                    <form action="{{ route('cash-types.update', $cashType->id) }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group row">
                            <label for="type" class="col-md-4 col-form-label text-md-right">Jenis</label>
                            <div class="col-md-4">
                                <select name="type" id="type" class="form-control">
                                    <option value="in" {{ $cashType->type === 'in' ? ' selected' : '' }}>Kas Masuk
                                    </option>
                                    <option value="out" {{ $cashType->type === 'out' ? ' selected' : '' }}>Kas Keluar
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Keterangan</label>
                            <div class="col-md-4">
                                <input type="text" name="description" id="description" class="form-control" required
                                    value="{{ $cashType->description }}">
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection