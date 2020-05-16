@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">Edit Kas</div>
                <div class="card-body">
                    <form action="{{ route('cashes.update', $cash->id) }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <div class="form-group row">
                            <label for="cashbook_id" class="col-md-4 col-form-label text-md-right">Buku Kas</label>
                            <div class="col-md-4">
                                <select name="cashbook_id" id="cashbook_id" class="form-control">
                                    @foreach ($cashbooks as $cashbook)
                                    <option value="{{ $cashbook->id }}"
                                        {{ $cash->cashbook_id === $cashbook->id ? ' selected' : '' }}>
                                        {{ $cashbook->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right">Tanggal</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="text" name="date" id="date" class="form-control" required
                                        value="{{ $cash->date }}" data-provide="datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cash_type_id" class="col-md-4 col-form-label text-md-right">Jenis</label>
                            <div class="col-md-4">
                                <select name="cash_type_id" id="cash_type_id" class="form-control">
                                    <optgroup label="Kas Masuk">
                                        @foreach ($cash_types_in as $type)
                                        <option value="{{ $type->id }}"
                                            {{ $cash->cash_type_id === $type->id ? ' selected' : '' }}>Kas Masuk:
                                            {{ $type->description }}</option>
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Kas Keluar">
                                        @foreach ($cash_types_out as $type)
                                        <option value="{{ $type->id }}"
                                            {{ $cash->cash_type_id === $type->id ? ' selected' : '' }}>Kas Keluar:
                                            {{ $type->description }}
                                        </option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Keterangan</label>
                            <div class="col-sm">
                                <input type="text" name="description" id="description" class="form-control" required
                                    value="{{ $cash->description }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="amount" class="col-md-4 col-form-label text-md-right">Nominal</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Rp</span>
                                    </div>
                                    <input type="text" name="amount" id="amount" class="form-control" required
                                        value="{{ $cash->amount }}">
                                </div>
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
