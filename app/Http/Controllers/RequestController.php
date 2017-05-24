<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Request as Requests;
use App\Printer;

class RequestController extends Controller
{
	public function show()
	{
		$requests = Requests::paginate(10);

		return view('requests.list', compact('requests'));
	}

    public function refuseRequest($id)
    {
    	$request = Requests::findOrFail($id);

    	return view('requests.refuse', compact('request'));
    }

    public function updateRefuseRequest(Request $request, $id)
    {
    	$requestToUpdate = Requests::findOrFail($id);

    	$requestToUpdate->status = 1;

    	$requestToUpdate->refused_reason = $request['refusemessage'];

    	$requestToUpdate->save();

    	return redirect()->route('requests.show')->with('success', 'Pedido recusado com sucesso!');
    }

    public function finishRequest($id) 
    {
    	$request = Requests::findOrFail($id);

    	$printers = Printer::all();

    	return view('requests.finish', compact('request', 'printers'));
    }

    public function updateFinishRequest(Request $request, $id)
    {
    	$requestToUpdate = Requests::findOrFail($id);

    	$requestToUpdate->status = 2;

    	$requestToUpdate->printer_id = $request['printerused'];

    	$requestToUpdate->save();

    	return redirect()->route('requests.show')->with('success', 'Pedido concluido com sucesso!');
    }
}
