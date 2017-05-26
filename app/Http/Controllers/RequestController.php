<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Request as Requests;
use App\Printer;
use App\User;
use App\Department;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RequestController extends Controller
{
	public function listRequests()
	{
		$requests = Requests::paginate(10);
        $funcionarios = User::all();
        $departamentos = Department::all();
        return view('requests.list', compact('requests', 'funcionarios', 'departamentos'));
    }

    public function filter(Request $filter)
    {
        $requests = null;
        $description = $filter['description'];
        $user_id = $filter['user_id'];
        $department_id = $filter['department_id'];
        $status= $filter['estado'];
        $date = $filter['date'];
        //echo $date;
        $requests = new Requests();
        if($user_id != -1) {
            $requests = $requests->where('owner_id', $user_id);
        }

        if($status != -1) {
            $requests = $requests->where('status', $status);
        }

        if($department_id != -1) {
            $requests = $requests
            ->join('users', 'requests.owner_id', '=', 'users.id')->where('users.department_id', $department_id)->select('requests.*');
        }

        if(!is_null($description) && !empty($description)) {
            $requests = $requests->where('description', 'like', '%' . $description . '%');
        }

        if(!is_null($date) && !empty($date)){
            $date = Carbon::createFromFormat('d-m-Y', $date);
            $requests = $requests->whereDay('created_at', '=', $date->format('d'))
            ->whereMonth('created_at', '=', $date->format('m'))
            ->whereYear('created_at', '=', $date->format('Y'));
        }

        $requests = $requests->paginate(10);
        
        $funcionarios = User::all();
        $departamentos = Department::all();
        return view('requests.list', compact('requests', 'funcionarios', 'departamentos'));

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

        

        //return $user;

    	$requestToUpdate->status = 2;

    	$requestToUpdate->printer_id = $request['printerused'];

    	$requestToUpdate->closed_user_id = Auth::user()->id;

        $requestToUpdate->closed_date = Carbon::now();

        $requestToUpdate->user->print_counts += $requestToUpdate->quantity;

        $requestToUpdate->save();
        $requestToUpdate->user->save();

        

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
            $due_date = Carbon::createFromFormat('d-m-Y', $date)->toDateString();
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

        return redirect()->route('requests.list');
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
