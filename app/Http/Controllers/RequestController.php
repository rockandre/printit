<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Request as Requests;
use App\Printer;
use Illuminate\Support\Facades\Auth;

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

    public function create()
    {
        $request = new Requests();
        return view('requests.create', compact('request'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => 'required|string|min:5',
            'due_date' => 'nullable|date|after:today',
            'quantity' => 'required|integer|min:1|max:50',
            'colored' => 'required|in:0,1',
            'stapled' => 'required|in:0,1',
            'front_back' => 'required|in:0,1',
            'paper_size' => 'required|in:3,4',
            'paper_type' => 'required|in:0,1,2',
            'file' => 'required|mimes:jpeg,bmp,png,tiff,doc,xlsx,pdf,pptx,odt',

        ]);

        $date = $request->due_date;
        $due_date = null;
        if(!is_null($date)){
            $due_date = \Carbon\Carbon::createFromFormat('d-m-Y', $date)->toDateString();
        }

        $fileName = null;
        if( $request->hasFile('file') ) {
            $file = $request->file('file');
            $path = $file->store('print-jobs/' . auth()->id());
            $fileName = basename($path);
        }
        
        $user = Auth::id();
        Requests::create([
                'status' => 0,
                'description' => request('description'),
                'due_date' => $due_date,
                'quantity' => request('quantity'),
                'colored' => request('colored'),
                'stapled' => request('stapled'),
                'front_back' => request('front_back'),
                'paper_size' => request('paper_size'),
                'paper_type' => request('paper_type'),
                'file' => $fileName,
                'owner_id' => $user
        ]);

        return redirect()->route('requests.show');
    }

    public function edit(Requests $request)
    {
        return view('requests.edit', compact('request'));
    }

    public function update(Request $request, Requests $requestToUpdate)
    {
        $this->validate($request, [
            'description' => 'required|string|min:5',
            'due_date' => 'nullable|date|after:today',
            'quantity' => 'required|integer|min:1|max:50',
            'colored' => 'required|in:0,1',
            'stapled' => 'required|in:0,1',
            'front_back' => 'required|in:0,1',
            'paper_size' => 'required|in:3,4',
            'paper_type' => 'required|in:0,1,2',
            'file' => 'required|mimes:jpeg,bmp,png,tiff,doc,xlsx,pdf,pptx,odt',

        ]);

        $date = $request->due_date;
        $due_date = null;
        if(!is_null($date)){
            $due_date = \Carbon\Carbon::createFromFormat('d-m-Y', $date)->toDateString();
        }

        $fileName = null;
        if( $request->hasFile('file') ) {
            $file = $request->file('file');
            $path = $file->store('print-jobs/' . auth()->id());
            $fileName = basename($path);
        }
        
        $requestToUpdate->fill($request->except('due_date', 'file'));
        $requestToUpdate->due_date = $due_date;
        $requestToUpdate->file = $fileName;
        $requestToUpdate->save();
        
        return redirect()->route('requests.show');
    }
}
