<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmAccountEmail;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RhManagementController extends Controller
{

    public function home()
    {
        Auth::user()->can('rh') ? : abort(403, 'You are not authorized to view this page');

        // get all colaboratrs that are not role admin nor role rh
        $colaborators = User::with('detail', 'department')->where('role', 'colaborator')->withTrashed()->get();

        return view('colaborators.colaborators')->with('colaborators', $colaborators);
    }

    public function newColarator()
    {
        Auth::user()->can('rh') ? : abort(403, 'You are not authorized to view this page');

        $departments = Department::where('id', '>', 2)->get();

        // if there are no derpatments, abort request
        if ($departments->count() === 0)
        {
            abort(403, 'You are not authorized to view this page');
        }

        return view('colaborators.add-colaborator', compact('departments'));
    }

    public function createColarator(Request $request)
    {
        Auth::user()->can('rh') ? : abort(403, 'You are not allowed to access this page');

        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|max:255|unique:users,email',
            'select_department'=>'required|exists:departments,id',
            'address'=>'required|string|max:255',
            'zip_code'=>'required|string|max:10',
            'city'=>'required|string|max:50',
            'phone'=>'required|string|max:50',
            'salary'=>'required|decimal:2',
            'admission_date'=>'required|date_format:Y-m-d',
        ]);

        // check if department id maior 2
        if ($request->select_department <= 2)
        {
            return redirect()->route('home');
        }

        // create user confirmation token
        $token = Str::random(60);

        // create new rh use
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->confirmation_token = $token;
        $user->role = 'colaborator';
        $user->department_id = $request->select_department;
        $user->permissions = '["colaborator"]';
        $user->save();

        // save user details
        $user->detail()->create([
            'address'=> $request->address,
            'zip_code'=> $request->zip_code,
            'city' => $request->city,
            'phone'=> $request->phone,
            'salary'=> $request->salary,
            'admission_date'=> $request->admission_date,
        ]);

        // send email to user
        Mail::to($user->email)->send(new ConfirmAccountEmail(route('confirm-account', $token)));

        return redirect()->route('rh.management.home')->with('success', 'Colaborator created successfully');
    }

    public function editColaborator($id)
    {
        Auth::user()->can('rh') ? : abort(403, 'You are not allowed to access this page');

        $colaborator = User::with('detail')->findOrFail($id);
        $departments = Department::where('id', '>', 2)->get();

        return view('colaborators.edit-colaborator', compact('colaborator', 'departments'));

    }

    public function updateColaborator(Request $request)
    {
        Auth::user()->can('rh') ? : abort(403, 'You are not allowed to access this page');

        $request->validate([]);

        // check if department is valid
        if ($request->select_department <= 2) {
            return redirect()->route('home');
        }

        $user = User::with('detail')->findOrFail($request->user_id);
        $user->detail->salary = $request->salary;
        $user->detail->admission_date  = $request->admission_date;
        $user->department_id = $request->select_department;

        $user->save();
        $user->detail->save();

        return redirect()->route('rh.management.home')->with('success', 'Colaborator updated successfully');

    }

    public function ShowDetails($id)
    {
        Auth::user()->can('rh') ? : abort(403, 'You are not allowed to access this page');
        $colaborator = User::with('detail', 'department')->findOrFail($id);
        return view('colaborators.show-details', compact('colaborator'));
    }

    public function deleteColaborator($id)
    {
        Auth::user()->can('rh') ? : abort(403, 'You are not allowed to access this page');
        $colaborator = User::with('detail')->findOrFail($id);
        return view('colaborators.delete-colaborator', compact('colaborator'));
    }

    public function deleteColaboratorConfirm($id)
    {
        Auth::user()->can('rh') ? : abort(403, 'You are not allowed to access this page');

        $colaborator = User::findOrFail($id);

        $colaborator->delete();

        return redirect()->route('rh.management.home')->with('success', 'Colaborator deleted successfully');
    }

    public function restoreColaborator($id)
    {
        Auth::user()->can('rh') ? : abort(403, 'You are not allowed to access this page');

        $colaborator = User::withTrashed()->findOrFail($id);

        $colaborator->restore();

        return redirect()->route('rh.management.home')->with('success', 'Colaborator restored successfully');
    }

}
