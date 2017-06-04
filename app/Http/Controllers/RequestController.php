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
        $requests = Requests::leftJoin('users', 'requests.owner_id', '=', 'users.id')
        ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
        ->select('requests.*', 'users.name', 'departments.name');

        $queries = [];

        if(request()->has('description')) {
            $requests = $requests->where('description', 'LIKE', '%'.request('description').'%');
            $queries['description'] = request('description');
        }

        if(request()->has('user') && request('user') != -1) {
            $requests = $requests->where('owner_id', request('user'));
            $queries['user'] = request('user');
        }

        if(request()->has('department') && request('department') != -1) {
            $requests = $requests->where('users.department_id', request('department'));
            $queries['department'] = request('department');
        }

        if(request()->has('status') && request('status') != -1) {
            $requests = $requests->where('status', request('status'));
            $queries['status'] = request('status');
        }

        if(request()->has('date')) {
            $date = Carbon::createFromFormat('d-m-Y', request('date'));
            $requests = $requests->whereDay('requests.created_at', '=', $date->format('d'))
            ->whereMonth('requests.created_at', '=', $date->format('m'))
            ->whereYear('requests.created_at', '=', $date->format('Y'));
            $queries['date'] = request('date');
        }

        if (request()->has('orderByParam')) {

            if (request('orderByParam') == 'requestType') {
                $requests = $requests->orderBy('paper_size', request('orderByType'))
                                     ->orderBy('paper_type', request('orderByType'))
                                     ->orderBy('colored', request('orderByType'));
                $queries['orderByParam'] = request('orderByParam');
                $queries['orderByType'] = request('orderByType');
            }
            else {
                $requests = $requests->orderBy(request('orderByParam'), request('orderByType'));
                $queries['orderByParam'] = request('orderByParam');
                $queries['orderByType'] = request('orderByType');
            }
        } else {
            $requests = $requests->orderBy('users.name', 'asc');
        }

        if(Auth::user()->isAdmin())
        {
            $requests = $requests->paginate(10)->appends($queries);
        } else {
            $requests = $requests->where('requests.owner_id', Auth::user()->id)->paginate(10)->appends($queries);
        }

        $users = User::orderBy('name', 'asc')->get();
        $departments = Department::orderBy('name', 'asc')->get();

        return view('requests.list', compact('requests', 'users', 'departments'));
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
            $due_date = Carbon::createFromFormat('d-m-Y', $date)->toDateString();
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

        return redirect()->route('requests.list');
    }
}
