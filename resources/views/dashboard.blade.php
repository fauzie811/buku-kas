@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="{{ asset('vendor/morris.js/morris.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg">
            <div class="card mb-4 text-white bg-primary">
                <div class="card-header">Saldo Akhir</div>
                <div class="card-body">
                    @foreach ($stats as $stat)
                        <div>{{ $stat['cashbook'] }}</div>
                        <div class="h1 text-right">{{ rupiah($stat['balance']) }}</div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg">
            <div class="card mb-4 text-white bg-success">
                <div class="card-header">Total Kas Masuk</div>
                <div class="card-body">
                    @foreach ($stats as $stat)
                        <div>{{ $stat['cashbook'] }}</div>
                        <div class="h1 text-right">{{ rupiah($stat['cash_in_total']) }}</div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg">
            <div class="card mb-4 text-white bg-danger">
                <div class="card-header">Total Kas Keluar</div>
                <div class="card-body">
                    @foreach ($stats as $stat)
                        <div>{{ $stat['cashbook'] }}</div>
                        <div class="h1 text-right">{{ rupiah($stat['cash_out_total']) }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">Laporan Kas Tahun {{ date('Y', strtotime('-1 year')) }}</div>
                <div class="card-body">
                    <div class="chart" id="last-year-chart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">Log Aktivitas</div>
                <div>
                    <ul class="timeline">
                        @foreach ($logs as $log)
                        <li class="{{ $log->color }}">
                            <strong>{{ $log->user->name }}</strong> {{ $log->description }}<br>
                            @if ($log->details)
                            <a href="{{ route('cashes.show', $log->details['id']) }}"><small>{{ $log->details_str }}</small></a>
                            @endif
                            <div class="text-muted"><small><i class="far fa-clock"></i>
                                    {{ $log->created_at->format('Y-m-d H:i:s') }}</small></div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('vendor/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('vendor/morris.js/morris.min.js') }}"></script>
<script>
    jQuery(function($) {
        var baseUrl = '{{ url('/') }}';
        $.ajax({
	    	url: baseUrl+'/json/last-year-chart',
	    	dataType: 'json',
	    }).done(function (results){
			if (results.length == 0) {
				$("#last-year-chart").html('<span>Tidak ada transaksi</span>');
			} else {
				new Morris.Line({
					element: 'last-year-chart',
					resize: true,
					data: results,
					lineColors: ['#38c172', '#e3342f'],
					xkey: 'month',
					ykeys: ['cash_in', 'cash_out'],
					labels: ['Kas Masuk', 'Kas Keluar'],
                    hideHover: 'auto',
                    parseTime: false,
                    // preUnits: 'Rp ',
				});
			}
	    })
    });
</script>
@endsection
