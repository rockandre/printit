<?php

namespace App\Http\Controllers;

use App\User;
use App\Request;
use Khill\Lavacharts\Lavacharts;

class HomeController extends Controller
{
    /*
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

       //Statistics!!

    public function getColoredPrints(){
        $requests = Request::where('status', 2)->where('colored', 1)->get();
        $counterColoredPrints = 0;

        foreach ($requests as $request) {
            $counterColoredPrints += $request->quantity;
        }

        return $counterColoredPrints;
    }

    public function getBlackAndWhitePrints(){
        $requests = Request::where('status', 2)->where('colored', 0)->get();
        $counterBlackAndWhite = 0;

        foreach ($requests as $request) {
            $counterBlackAndWhite += $request->quantity;
        }

        return $counterBlackAndWhite;
    }


    public function totalPrints(){
        $requests = Request::where('status', 2)->get();
        $totalPrints = 0;

        foreach ($requests as $request) {
            $totalPrints += $request->quantity;
        }

        return $totalPrints;
    }

    public function diaryPrints(){
        $today = Date("Y-m-d");
        $requests = Request::where('status', 2)->where('closed_date', $today)->get();
        $todayPrints = 0; 

        foreach ($requests as $request) {
            $todayPrints += $requests->quantity;
        }

        return $todayPrints;
    }



    public function averageDiaryActualMouth(){      
        $today = Date("Y-m");
        $requests = Request::where('status', 2)->where('closed_date', $today)->get();
        $averagePrints = 0;

        foreach ($requests as $request) {

            $averagePrints += $requests->quantity;
        }
        $averagePrints = $averagePrints / Date("d");

        return $averagePrints;
    }


    public function index()
    {
        $lava = new Lavacharts;

        $statistics = [];
        $statistics['coloredPrints'] = $this->getColoredPrints();
        $statistics['blackAndWhite'] = $this->getBlackAndWhitePrints();
        $statistics['totalPrints'] = $this->totalPrints();
        $statistics['diaryPrints'] = $this->diaryPrints();
        $statistics['averagePrints'] = $this->averageDiaryActualMouth();

        $votes  = $lava->DataTable();

        $votes->addStringColumn('Colored vs BlackAndWhite')
        ->addNumberColumn('Percent')
        ->addRow(['Colored', $statistics['coloredPrints']])
        ->addRow(['Black and White', $statistics['blackAndWhite']]);

        $lava->PieChart('IMDB', $votes, [
            'title'  => 'Percentagens',
            'is3D'   => true,
            'slices' => [
            ['offset' => 0.2],
            ['offset' => 0.25],
            ['offset' => 0.3]
            ]
            ], 'chart-div');
        return view('home',compact('data', 'statistics'));
        }

    }
