<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use App\Request as Requests;
use Khill\Lavacharts\Lavacharts;
use Carbon\Carbon;

class DepartmentController extends Controller
{
	public function statistics($id) {
		$department = Department::findOrFail($id);

		$statistics = [];

		$coloredPrints = $this->getColoredPrints($department->id);
		$blackAndWhitePrints = $this->getBlackAndWhitePrints($department->id);

		$statistics['total'] = $this->getTotalPrints($department->id);
		$statistics['today'] = $this->todayPrints($department->id);
		$statistics['dailyMonth'] = $this->averageDailyActualMouth($department->id);

        $lava = new Lavacharts; // See note below for Laravel

        $colorsVsBlackAndWhite = $lava->DataTable();
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

        return view('departments.show', compact('lava', 'statistics', 'department'));
    }

    public function getTotalPrints($id)
    {
    	$totalPrints = 0;

    	$requests = Requests::leftJoin('users', 'requests.owner_id', 'users.id')
    	->leftJoin('departments', 'users.department_id', 'departments.id')
    	->where('requests.status', 2)
    	->where('departments.id', $id)
    	->get();

    	foreach ($requests as $request) {
    		$totalPrints += $request->quantity;
    	}

    	return $totalPrints;
    }

    public function getColoredPrints($id)
    {
    	$coloredPrints = 0;

    	$requests = Requests::leftJoin('users', 'requests.owner_id', 'users.id')
    	->leftJoin('departments', 'users.department_id', 'departments.id')
    	->where('requests.status', 2)
    	->where('requests.colored', 1)
    	->where('departments.id', $id)
    	->get();

    	foreach ($requests as $request) {
    		$coloredPrints += $request->quantity;
    	}

    	return $coloredPrints;
    }

    public function getBlackAndWhitePrints($id)
    {
    	$blackAndWhitePrints = 0;

    	$requests = Requests::leftJoin('users', 'requests.owner_id', 'users.id')
    	->leftJoin('departments', 'users.department_id', 'departments.id')
    	->where('requests.status', 2)
    	->where('requests.colored', 0)
    	->where('departments.id', $id)
    	->get();

    	foreach ($requests as $request) {
    		$blackAndWhitePrints += $request->quantity;
    	}

    	return $blackAndWhitePrints;
    }

    public function todayPrints($id){
        $today = Carbon::now();
        $requests = Requests::leftJoin('users', 'requests.owner_id', 'users.id')
					    	->leftJoin('departments', 'users.department_id', 'departments.id')
					    	->where('requests.status', 2)
    						->where('departments.id', $id)
					    	->whereDay('requests.created_at', '=', $today->format('d'))
				            ->whereMonth('requests.created_at', '=', $today->format('m'))
				            ->whereYear('requests.created_at', '=', $today->format('Y'))
				            ->get();
        $todayPrints = 0; 

        foreach ($requests as $request) {
            $todayPrints += $request->quantity;
        }

        return $todayPrints;
    }

    public function averageDailyActualMouth($id){      
        $today = Carbon::now();
        $requests = Requests::leftJoin('users', 'requests.owner_id', 'users.id')
					    	->leftJoin('departments', 'users.department_id', 'departments.id')
					    	->where('requests.status', 2)
    						->where('departments.id', $id)
				            ->whereMonth('requests.created_at', '=', $today->format('m'))
				            ->whereYear('requests.created_at', '=', $today->format('Y'))
				            ->get();
        $averagePrints = 0;

        foreach ($requests as $request) {
            $averagePrints += $request->quantity;
        }
        $averagePrints = $averagePrints / $today->format('d');

        return $averagePrints;
    }
}
