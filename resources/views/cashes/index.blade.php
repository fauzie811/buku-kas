@extends('layouts.app')

<?php
function appendUrlParams($data = [])
{
    parse_str($_SERVER['QUERY_STRING'], $old_data);
    $data = array_merge($old_data, $data);
    return http_build_query($data);
}
?>

@section('content')
<div class="container">
    @if($errors->any())
    {!! implode('', $errors->all('<div class="alert alert-danger" role="alert">:message</div>')) !!}
    @endif
    <ul class="nav nav-pills nav-fill mb-4">
        @foreach ($cashbooks as $cb)
        <li class="nav-item">
            <a href="{{ route('cashes.index') }}?{{ appendUrlParams(['cashbook_id' => $cb->id]) }}" class="nav-link{{ $cb->id == $cashbook_id ? ' active' : '' }}">{{ $cb->name }}</a>
        </li>
        @endforeach
    </ul>
    <div class="row">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">Pencarian</div>
                <div class="card-body">
                    <form action="{{ route('cashes.index') }}" method="GET">
                        <div class="form-row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="date_start">Tanggal Awal</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="date_start" id="date_start"
                                            value={{ $date_start ? $date_start : '' }} autocomplete="off" data-provide="datepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="date_end">Tanggal Akhir</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="date_end" id="date_end"
                                            value={{ $date_end ? $date_end : '' }} autocomplete="off" data-provide="datepicker">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Keterangan</label>
                            <input type="text" name="description" id="description" class="form-control"
                                value="{{ $description ? $description : '' }}">
                        </div>
                        <div class="form-row">
                            <div class="col-sm">
                                <button type="submit" class="btn btn-block btn-primary">Cari</button>
                            </div>
                            <div class="col-sm">
                                <a href="{{ route('cashes.index') }}?cashbook_id={{ $cashbook_id }}" class="btn btn-light btn-block">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="card">
                <div class="card-header">Tambah</div>
                <div class="card-body">
                    <form action="{{ route('cashes.store') }}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="cashbook_id" value="{{ $cashbook_id }}">
                        <div class="form-row">
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="date">Tanggal</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                        </div>
                                        <input type="text" name="date" id="date"
                                            class="form-control" value="{{ date('Y-m-d') }}"
                                            autocomplete="off" data-provide="datepicker">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="form-group">
                                    <label for="cash_type_id">Jenis</label>
                                    <select name="cash_type_id" id="cash_type_id" class="form-control">
                                        <optgroup label="Kas Masuk">
                                            @foreach ($cash_types_in as $type)
                                            <option value="{{ $type->id }}">Kas Masuk: {{ $type->description }}</option>
                                            @endforeach
                                        </optgroup>
                                        <optgroup label="Kas Keluar">
                                            @foreach ($cash_types_out as $type)
                                            <option value="{{ $type->id }}">Kas Keluar: {{ $type->description }}
                                            </option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="amount">Nominal</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" name="amount" id="amount" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="description">Keterangan</label>
                                    <input type="text" name="description" id="description" class="form-control"
                                        required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="card mb-3">
        <div class="card-header">Ringkasan</div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2">Kas Masuk</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cash_in_totals as $key => $value)
                            <tr>
                                <td>{{ $key }}</td>
                                <td class="text-right">Rp {{ number_format($value, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="font-weight-bold">TOTAL</td>
                                <td class="font-weight-bold text-right text-success">Rp
                                    {{ number_format($cash_in_total, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-sm">
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2">Kas Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cash_out_totals as $key => $value)
                            <tr>
                                <td>{{ $key }}</td>
                                <td class="text-right">Rp {{ number_format($value, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="font-weight-bold">TOTAL</td>
                                <td class="font-weight-bold text-right text-danger">Rp
                                    {{ number_format($cash_out_total, 0, ',', '.') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-sm">
                    <canvas id="cashChart" height="180"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Hasil Pencarian</div>
        <div class="card-body">
            @if (sizeof($cashes) > 0)
            <div class="text-right">
                <a href="{{ route('cashes.excel') }}?cashbook_id={{ $cashbook_id }}&date_start={{ $date_start }}&date_end={{ $date_end }}&description={{ $description }}"
                    class="btn btn-success">
                    <i class="far fa-file-excel"></i> XLSX
                </a>
            </div>
            <table class="table table-sm mt-3">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Keterangan</th>
                        <th class="text-nowrap text-right">Kas Masuk</th>
                        <th class="text-nowrap text-right">Kas Keluar</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cashes as $cash)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-nowrap">{{ $cash->date->format('Y-m-d') }}</td>
                        <td>
                            <strong class="text-nowrap">{{ $cash->cash_type->type_str }}</strong>:<br>
                            <span class="text-nowrap">{{ $cash->cash_type->description }}</span>
                        </td>
                        <td>{{ $cash->description }}</td>
                        <td class="text-right text-nowrap">
                            {{ $cash->cash_type->type === 'in' ? $cash->amount_str : '' }}</td>
                        <td class="text-right text-nowrap">
                            {{ $cash->cash_type->type === 'out' ? $cash->amount_str : '' }}</td>
                        <td class="text-right text-nowrap">
                            <a href="{{ route('cashes.edit', $cash->id) }}" class="btn btn-sm btn-warning"><i
                                    class="far fa-edit"></i></a>
                            <form class="delete-form d-inline-block" action="{{ route('cashes.destroy', $cash->id) }}"
                                method="post">
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
            @else
            Tidak ada hasil pencarian.
            @endif
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-9">
        </div>
        <div class="col-3">
            <div class="card">
                <div class="card-header">Ringkasan</div>
                <div class="card-body">
                    @if (sizeof($cashes) > 0)
                    a
                    @else
                    Tidak ada hasil pencarian.
                    @endif
                </div>
            </div>
        </div>
    </div> --}}
</div>
@endsection

@section('scripts')
<script>
    jQuery(document).ready(function($) {
        $('.delete-form').submit(function(event) {
            if( !confirm('Hapus data ini?') )
                event.preventDefault();
        })
        // $('#date_start').datepicker({
        //     endDate: $('#date_end').val(),
        // });
        // $('#date_end').datepicker({
        //     startDate: $('#date_start').val(),
        // });
    })
    new Chart($('#cashChart'), {
        type: 'pie',
        data: {
            labels: ['Kas Masuk', 'Kas Keluar'],
            datasets: [{
                data: [{{ $cash_in_total }}, {{ $cash_out_total }}],
                backgroundColor: ['#38c172', '#e3342f']
            }],
        },
        options: {
            tooltips: {
                callbacks: {
                    label: function(tooltipItem, data) {
                        var label = data.labels[tooltipItem.index] || '';

                        if (label) {
                            label += ': Rp ';
                        }
                        label += data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        return label;
                    }
                }
            }
        }
    })
</script>
@endsection
