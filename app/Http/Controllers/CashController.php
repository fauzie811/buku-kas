<?php

namespace App\Http\Controllers;

use App\Cash;
use App\Cashbook;
use App\CashType;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Calculation;

class CashController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cashbook_id = $request->query('cashbook_id');
        $date_start = $request->query('date_start');
        $date_end = $request->query('date_end');
        $description = $request->query('description');

        if ($cashbook_id === null) {
            $cashbook_id = 1;
        }
        if ($date_start === null) {
            $date_start = date('Y-m-01');
        }
        if ($date_end === null) {
            $date_end = date('Y-m-d');
        }

        $query = Cash::with(['cashbook', 'cash_type'])
            ->whereBetween('date', [$date_start, $date_end]);

        if (!empty($description)) {
            $query->where('description', 'LIKE', '%' . $description . '%');
        }

        if (!empty($cashbook_id)) {
            $query->where('cashbook_id', $cashbook_id);
        }

        $cashes = $query->get();

        $cashbooks = Cashbook::all();

        $cash_types_in = CashType::where('type', 'in')->get();
        $cash_types_out = CashType::where('type', 'out')->get();

        $cash_in_totals = [];
        $cash_in_total = 0;
        $cash_out_totals = [];
        $cash_out_total = 0;
        foreach ($cashes as $cash) {
            $cash_desc = $cash->cash_type->description;
            if ($cash->cash_type->type === 'in') {
                if (!isset($cash_in_totals[$cash_desc])) {
                    $cash_in_totals[$cash_desc] = 0;
                }
                $cash_in_totals[$cash_desc] += $cash->amount;
                $cash_in_total += $cash->amount;
            } else {
                if (!isset($cash_out_totals[$cash_desc])) {
                    $cash_out_totals[$cash_desc] = 0;
                }
                $cash_out_totals[$cash_desc] += $cash->amount;
                $cash_out_total += $cash->amount;
            }
        }

        return view(
            'cashes.index',
            compact([
                'cashbook_id', 'date_start', 'date_end', 'description', 'cashes', 'cashbooks', 'cash_in_totals', 'cash_out_totals',
                'cash_in_total', 'cash_out_total', 'cash_types_in', 'cash_types_out',
            ])
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'cashbook_id' => ['required', 'exists:cashbooks,id'],
            'date' => ['nullable', 'date'],
            'cash_type_id' => ['required', 'exists:cash_types,id'],
            'amount' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
        ]);

        Cash::create($request->only(['cashbook_id', 'date', 'cash_type_id', 'amount', 'description']));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cash  $cash
     * @return \Illuminate\Http\Response
     */
    public function show(Cash $cash)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cash  $cash
     * @return \Illuminate\Http\Response
     */
    public function edit(Cash $cash)
    {
        $cashbooks = Cashbook::all();
        $cash_types_in = CashType::where('type', 'in')->get();
        $cash_types_out = CashType::where('type', 'out')->get();

        return view('cashes.edit', compact('cash', 'cashbooks', 'cash_types_in', 'cash_types_out'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cash  $cash
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cash $cash)
    {
        $this->validate($request, [
            'cashbook_id' => ['nullable', 'exists:cashbooks,id'],
            'date' => ['nullable', 'date'],
            'cash_type_id' => ['nullable', 'exists:cash_types,id'],
            'amount' => ['nullable', 'numeric'],
            'description' => ['nullable', 'string'],
        ]);

        $cash->update($request->only(['cashbook_id', 'date', 'cash_type_id', 'amount', 'description']));

        return redirect()->route('cashes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cash  $cash
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cash $cash)
    {
        $cash->delete();

        return redirect()->route('cashes.index');
    }

    public function excel(Request $request)
    {
        $cashbook_id = $request->query('cashbook_id');
        $date_start = $request->query('date_start');
        $date_end = $request->query('date_end');
        $description = $request->query('description');

        if ($date_start === null) {
            $date_start = date('Y-m-01');
        }
        if ($date_end === null) {
            $date_end = date('Y-m-d');
        }

        $query = Cash::with('cash_type')
            ->whereBetween('date', [$date_start, $date_end]);

        if (!empty($description)) {
            $query->where('description', 'LIKE', '%' . $description . '%');
        }

        $query->where('cashbook_id', $cashbook_id);

        $cashes = $query->get();

        /**
         * @var \App\Cashbook $cashbook
         */
        $cashbook = Cashbook::find($cashbook_id);

        $filename = "Laporan Kas ({$cashbook->name}) $date_start - $date_end";
        Excel::create($filename, function ($excel) use ($filename, $cashes, $cashbook) {
            $excel->setTitle($filename);

            $excel->sheet($cashbook->name, function ($sheet) use ($cashes) {
                $sheet->setAutoSize(false);
                $data = [];
                foreach ($cashes as $cash) {
                    $data[] = [
                        'Tanggal' => $cash->date,
                        'Jenis' => $cash->cash_type->type_str . ': ' . $cash->cash_type->description,
                        'Keterangan' => $cash->description,
                        'Kas Masuk' => $cash->cash_type->type === 'in' ? $cash->amount : 0,
                        'Kas Keluar' => $cash->cash_type->type === 'out' ? $cash->amount : 0,
                    ];
                }
                $count = count($data);
                $sheet->setColumnFormat(array(
                    'A' => 'yyyy-mm-dd;@',
                    'D' => '_-[$Rp-id-ID]* #,##0_-;-[$Rp-id-ID]* #,##0_-;_-[$Rp-id-ID]* "-"_-;_-@_-',
                    'E' => '_-[$Rp-id-ID]* #,##0_-;-[$Rp-id-ID]* #,##0_-;_-[$Rp-id-ID]* "-"_-;_-@_-',
                ));
                $sheet->cells('A1:E1', function ($cells) {
                    $cells->setBackground('#dddddd');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontWeight('bold');
                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                });
                $sheet->cells('A2:E' . ($count + 1), function ($cells) {
                    $cells->setValignment('center');
                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                });
                $sheet->cells('A' . ($count + 2) . ':E' . ($count + 2), function ($cells) {
                    $cells->setValignment('center');
                    $cells->setBorder('thin', 'thin', 'thin', 'thin');
                });
                $sheet->cells('A' . ($count + 2) . ':E' . ($count + 2), function ($cells) {
                    $cells->setFontWeight('bold');
                });
                $sheet->setWidth([
                    'A' => '12',
                    'B' => '25',
                    'C' => '70',
                    'D' => '18',
                    'E' => '18',
                ]);
                $sheet->setBorder('A1:E' . ($count + 2), 'thin');
                $sheet->fromArray($data);
                $sheet->row($count + 2, [
                    '',
                    '',
                    'TOTAL',
                    '=SUM(D2:D' . ($count + 1) . ')',
                    '=SUM(E2:E' . ($count + 1) . ')',
                ]);
                PHPExcel_Calculation::getInstance($sheet->getParent())
                    ->calculateFormula('=SUM(D2:D' . ($count + 1) . ')', 'D' . ($count + 2), $sheet->getCell('D' . ($count + 2)));
                PHPExcel_Calculation::getInstance($sheet->getParent())
                    ->calculateFormula('=SUM(E2:E' . ($count + 1) . ')', 'E' . ($count + 2), $sheet->getCell('E' . ($count + 2)));
            });
        })->download('xlsx');
    }
}
