@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="{{ asset('vendor/morris.js/morris.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm">
            <div class="card text-white bg-primary">
                <div class="card-header">Saldo Akhir</div>
                <div class="card-body">
                    <div class="h1 text-right">{{ rupiah($balance) }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="card text-white bg-success">
                <div class="card-header">Total Kas Masuk</div>
                <div class="card-body">
                    <div class="h1 text-right">{{ rupiah($cash_in_total) }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="card text-white bg-danger">
                <div class="card-header">Total Kas Keluar</div>
                <div class="card-body">
                    <div class="h1 text-right">{{ rupiah($cash_out_total) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">Laporan Kas Tahun Lalu</div>
        <div class="card-body">
            <div class="chart" id="last-year-chart" style="height: 300px;"></div>
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
				new Morris.Bar({
					element: 'last-year-chart',
					resize: true,
					data: results,
					barColors: ['#38c172', '#e3342f'],
					xkey: 'month',
					ykeys: ['cash_in', 'cash_out'],
					labels: ['Kas Masuk', 'Kas Keluar'],
					hideHover: 'auto'
				});
			}
	    })
    });
</script>
@endsection