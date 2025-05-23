<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index()
    {
        Auth::user()->can('admin') ? : abort(403, 'You are not allowed to access this page');

        $departments = Department::all();
        return view('department.departments', compact('departments'));
    }

    public function newDepartment(): View {
        Auth::user()->can('admin') ? : abort(403, 'You are not allowed to access this page');
        return view('department.add-department');
    }

    public function createDepartment(Request $request) {
        Auth::user()->can('admin') ? : abort(403, 'You are not allowed to access this page');
        $request->validate([
            'name' => 'required|string|max:50|unique:departments',
        ],[
            'name.required' => 'Campo nome obrigatorio.',
            'name.string' => 'Campo nome deve ser letras.',
            'name.max' => 'Campo nome deve ter :max caracteres.',
            'name.unique'=> 'Nome ja existe.',
        ]);

        Department::create([
            'name'=> $request->name,
        ]);

        return redirect()->route('departments');
    }

    public function editDepartment(Department $department): View
    {
        return view('department.edit-department', compact('department'));
    }

    public function updateDepartment(Request $request, Department $department) {
        Auth::user()->can('admin') ? : abort(403, 'You are not allowed to access this page');
    }
}
