@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">Edit Buku Kas</div>
                <div class="card-body">
                    <form action="{{ route('cashbooks.update', $cashbook->id) }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Keterangan</label>
                            <div class="col-md-4">
                                <input type="text" name="name" id="name" class="form-control" required
                                    value="{{ $cashbook->name }}">
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
