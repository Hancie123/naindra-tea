<?php

namespace App\Http\Controllers;
use App\Models\TeaBillModel;
use DB;
use App\Models\FertilizerModel;
use App\Models\TeaModel;
use Illuminate\Http\Request;
use App\Models\ChemicalExpensesModel;
use App\Models\employeesmodel;


class roundcontroller extends Controller
{
    public function roundsystem(Request $request){

        $remark=$request['remarks'];

        $teabills = TeaModel::groupBy('remarks')
        ->select('remarks', DB::raw('MAX(tea_id) as tea_id'))
        ->orderBy('tea_id', 'desc')
        ->get();

        $tearecord = TeaModel::select('remarks','nep_date','total_tea_kg','plucked_time','total_amount')
        ->where('remarks', $remark)
        ->get();
        $tearecordcount = $tearecord->count();

        $teabillquery = DB::table('tea_bills')
        ->join('employees', 'employees.Employees_ID', '=', 'tea_bills.employee_id')
        ->select('employees.Name', 'tea_bills.remarks',
            DB::raw('MAX(tea_bills.teabill_id) as teabill_id'),
            DB::raw('MAX(tea_bills.nep_date) as nep_date'),
            DB::raw('SUM(tea_bills.wage_kg) as total_wage_kg'),
            DB::raw('SUM(tea_bills.wage_amount) as total_wage_amount'),
            DB::raw('SUM(tea_bills.ot_amount) as total_ot_amount'),
            DB::raw('SUM(tea_bills.tea_kg) as total_tea_kg'),
            DB::raw('SUM(tea_bills.total_amount) as total_amount'))
        ->where('remarks', $remark)
        ->groupBy('employees.Name', 'tea_bills.remarks')
        ->OrderBy('total_amount','desc')
        ->get();

        $teabillcount=$teabillquery->count();

        $fertilizer = FertilizerModel::select()
    ->where('remarks', $remark)
    ->get();

        $chemical=ChemicalExpensesModel::select()
        ->where('remarks', $remark)
        ->get();

        $countchemical=$chemical->count();

        $countfertilizer=$fertilizer->count();

        $totalemployeesamount = TeaBillModel::where('remarks', $remark)
        ->sum('total_amount');
    

        // Fetch the sum of 'total_amount' from ChemicalExpensesModel
        $chemicalexpenses = ChemicalExpensesModel::where('remarks', $remark)
        ->sum('total_amount');


            $fertilizerexpenses = FertilizerModel::where('remarks', $remark)
            ->sum('total_amount');

            $totaltea = TeaModel::where('remarks', $remark)
            ->sum('total_tea_kg');

            $teaincome = TeaModel::where('remarks', $remark)
            ->sum('total_amount');

    
        $total_expenses=$totalemployeesamount+$chemicalexpenses+$fertilizerexpenses;
        $netprofit=$teaincome-$total_expenses;

        return view('admin/tea_reports/rounds',compact('teabills','remark',
        'tearecord','tearecordcount','teabillquery','teabillcount','fertilizer','countfertilizer',
        'countchemical','fertilizer','chemical','netprofit','total_expenses','teaincome','totaltea'));

    }
}
