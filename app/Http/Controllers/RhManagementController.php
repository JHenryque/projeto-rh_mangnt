<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RhManagementController extends Controller
{

    public function home()
    {
        Auth::user()->can('rh') ? : abort(403, 'You are not authorized to view this page');

        // get all colaboratrs that are not role admin nor role rh
        $colaborators = User::with('detail', 'department')->where('role', 'colaborator')->get();

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
}
