<?php

namespace App\Http\Controllers;

use App\User;
use App\Request as Requests;
use App\Department;
use Khill\Lavacharts\Lavacharts;
use Carbon\Carbon;

class HomeController extends Controller
{
    

    public function getColoredPrints(){
        $requests = Requests::where('status', 2)->where('colored', 1)->get();
        $counterColoredPrints = 0;

        foreach ($requests as $request) {
            $counterColoredPrints += $request->quantity;
        }

        return $counterColoredPrints;
    }

    public function getBlackAndWhitePrints(){
        $requests = Requests::where('status', 2)->where('colored', 0)->get();
        $counterBlackAndWhite = 0;

        foreach ($requests as $request) {
            $counterBlackAndWhite += $request->quantity;
        }

        return $counterBlackAndWhite;
    }


    public function totalPrints(){
        $requests = Requests::where('status', 2)->get();
        $totalPrints = 0;

        foreach ($requests as $request) {
            $totalPrints += $request->quantity;
        }

        return $totalPrints;
    }

    public function todayPrints(){
        $today = Carbon::now();
        $requests = Requests::where('status', 2)->whereDay('requests.created_at', '=', $today->format('d'))
            ->whereMonth('requests.created_at', '=', $today->format('m'))
            ->whereYear('requests.created_at', '=', $today->format('Y'))->get();
        $todayPrints = 0; 

        foreach ($requests as $request) {
            $todayPrints += $request->quantity;
        }

        return $todayPrints;
    }

    public function averageDailyActualMouth(){      
        $today = Carbon::now();
        $requests = Requests::where('status', 2)->whereMonth('requests.created_at', '=', $today->format('m'))
            ->whereYear('requests.created_at', '=', $today->format('Y'))->get();
        $averagePrints = 0;

        foreach ($requests as $request) {
            $averagePrints += $request->quantity;
        }
        $averagePrints = $averagePrints / $today->format('d');

        return $averagePrints;
    }

    public function departmentsStats() {
        $departments = Department::orderBy('name', 'asc')->get();

        $departmentStats = [];
        $totalPrints = 0;

        foreach ($departments as $department) {
            $requests = Requests::leftJoin('users', 'requests.owner_id', 'users.id')
                                ->leftJoin('departments', 'users.department_id', 'departments.id')
                                ->where('requests.status', 2)
                                ->where('departments.id', $department->id)
                                ->get();
            foreach ($requests as $request) {
                $totalPrints += $request->quantity;
            }

            $departmentStats[$department->id]['total'] = $totalPrints;

            $totalPrints = 0;
        }

        return $departmentStats;
    }


    public function index()
    {
		$lava = new Lavacharts; // See note below for Laravel

		$colorsVsBlackAndWhite = $lava->DataTable();

        $statistics = [];

        $coloredPrints = $this->getColoredPrints();
        $blackAndWhitePrints = $this->getBlackAndWhitePrints();

        $statistics['total'] = $this->totalPrints();
        $statistics['today'] = $this->todayPrints();
        $statistics['dailyMonth'] = $this->averageDailyActualMouth();

        $departmentStats = $this->departmentsStats();

		$colorsVsBlackAndWhite->addStringColumn('Cores')
		->addNumberColumn('Percentagem')
		->addRow(['Preto e Branco', $coloredPrints])
		->addRow(['Cores', $blackAndWhitePrints]);

		$lava->PieChart('Cores VS Preto e Branco', $colorsVsBlackAndWhite, [
			'title'  => 'Cores VS Preto e Branco',
			'is3D'   => true,
			'slices' => [
            ['offset' => 0.2],
            ]
            ]);


        $departments = Department::orderBy('name', 'asc')->get();

		return view('home', compact('lava', 'departments', 'statistics', 'departmentStats'));
	}
}   