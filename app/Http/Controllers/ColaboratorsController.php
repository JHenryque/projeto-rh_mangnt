<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColaboratorsController extends Controller
{
    public function index()
    {
        Auth::user()->can('admin') ? : abort(403, 'You are not allowed to access this page');

        $colaborators = User::with('detail', 'department')
            ->where('role', '<>', 'admin')
            ->get();

        return view('colaborators.admin-all-colaborators', compact('colaborators'));
    }

    public function showDetails($id)
    {
        Auth::user()->can('admin', 'rh') ? : abort(403, 'You are not allowed to access this page');

        // check if id the same as the auth user
        if (Auth::user()->id === $id) {
            return redirect()->route('home');
        }

        $colaborator = User::with('detail', 'department')
            ->where('id', $id)
            ->first();

         return view('colaborators.show-details')->with('colaborator', $colaborator);
    }

    public function deleteColaborator($id)
    {
        Auth::user()->can('admin', 'rh') ? : abort(403, 'You are not allowed to access this page');

        // check if id the same as the auth user
        if (Auth::user()->id === $id) {
            return redirect()->route('home');
        }

        $colaborator = User::findOrFail($id);
        return view('colaborators.soft-delete-colaborator')->with('colaborator', $colaborator);
    }

    public function deleteColaboratorConfirmation($id)
    {
        Auth::user()->can('admin') ? : abort(403, 'You are not allowed to access this page');

        $colaborator = User::findOrFail($id);
        $colaborator->delete();

        return redirect()->route('colaborators.all-colaborators');
    }
}
