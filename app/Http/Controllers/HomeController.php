<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Khill\Lavacharts\Lavacharts;

class HomeController extends Controller
{
    /*
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$lava = new Lavacharts; // See note below for Laravel

		$reasons = $lava->DataTable();

		$reasons->addStringColumn('Reasons')
		->addNumberColumn('Percent')
		->addRow(['Check Reviews', 5])
		->addRow(['Watch Trailers', 2])
		->addRow(['See Actors Other Work', 4])
		->addRow(['Settle Argument', 89]);

		$lava->PieChart('IMDB', $reasons, [
			'title'  => 'Reasons I visit IMDB',
			'is3D'   => true,
			'slices' => [
				['offset' => 0.2],
				['offset' => 0.25],
				['offset' => 0.3]
				]
			]);


		return view('home', compact('lava'));
	}
}
