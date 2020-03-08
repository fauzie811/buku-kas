<?php

namespace App\Http\Controllers;

use App\Cash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cash_in_total = Cache::rememberForever('cash_in_total', function () {
           return Cash::with('cash_type')->whereHas('cash_type', function($q) {
               $q->where('type', 'in');
           })->get()->sum('amount');
        });
        $cash_out_total = Cache::rememberForever('cash_out_total', function () {
           return Cash::with('cash_type')->whereHas('cash_type', function($q) {
               $q->where('type', 'out');
           })->get()->sum('amount');
        });
        $balance = $cash_in_total - $cash_out_total;
        return view('dashboard', compact('cash_in_total', 'cash_out_total', 'balance'));
    }

    public function lastYearChart()
    {
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $rows = [];
        foreach ($months as $m) {
            $rows[] = [
                'month' => $m,
                'cash_in' => 0,
                'cash_out' => 0,
            ];
        }
        array_map(function($item) use (&$rows, $months) {
            $rows[intval($item->month) - 1]['cash_in'] = intval($item->total_amount);
        }, DB::table('cashes')
            ->join('cash_types', 'cashes.cash_type_id', '=', 'cash_types.id')
            ->select(
                DB::raw('SUM(cashes.amount) AS total_amount'), 
                DB::raw("DATE_FORMAT(cashes.date, '%c') as month")
            )
            ->where('cash_types.type', 'in')
            ->whereYear('cashes.date', date('Y', strtotime('-1 year')))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get()->toArray());
        array_map(function($item) use (&$rows, $months) {
            $rows[intval($item->month) - 1]['cash_out'] = intval($item->total_amount);
        }, DB::table('cashes')
            ->join('cash_types', 'cashes.cash_type_id', '=', 'cash_types.id')
            ->select(
                DB::raw('SUM(cashes.amount) AS total_amount'), 
                DB::raw("DATE_FORMAT(cashes.date, '%c') as month")
            )
            ->where('cash_types.type', 'out')
            ->whereYear('cashes.date', date('Y', strtotime('-1 year')))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get()->toArray());

        return response()->json($rows);
    }
}
