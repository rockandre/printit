<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Request as Requests;
use App\Printer;

class RequestController extends Controller
{
	public function listRequests()
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

    	return redirect()->route('requests.list')->with('success', 'Pedido recusado com sucesso!');
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

    	$requestToUpdate->closed_user_id = Auth::user()->id;

    	$requestToUpdate->save();

    	return redirect()->route('requests.list')->with('success', 'Pedido concluido com sucesso!');
    }

    public function deleteRequest(Requests $request)
    {
        $request->delete();

        return redirect()->route('requests.list')->with('success', 'Pedido eliminado com sucesso!');
    }

    public function showRequest($id)
    {
        $request = Requests::findOrFail($id);

        return view('requests.show', compact('request'));
    }

    public function evaluateRequest(Request $request, $id)
    {
        $requestToEval = Requests::findOrFail($id);

        $requestToEval->satisfaction_grade = $request['rating'];

        $requestToEval->save();

        return redirect()->route('show.request', $requestToEval->id)->with('success', 'Pedido avaliado com sucesso!');
    }
}
