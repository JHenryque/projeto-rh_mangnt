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

    public function editDepartment($id)
    {
        Auth::user()->can('admin') ? : abort(403, 'You are not allowed to access this page');

        // check if id
        if ($this->isDepartmentBlocked($id))
        {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id); // esse metodo vai busca o id se nao encontra vai aprece uma mensagem generica

        return view('department.edit-department', compact('department'));
    }

    public function updateDepartment(Request $request) {
        Auth::user()->can('admin') ? : abort(403, 'You are not allowed to access this page');

        $id = $request->id;

        $request->validate([
            'id' => 'required',
            'name' => 'required|string|max:50|unique:departments', $id,
        ],[
            'name.required' => 'Campo nome obrigatorio.',
            'name.string' => 'Campo nome deve ser letras.',
            'name.max' => 'Campo nome deve ter :max caracteres.',
            'name.unique'=> 'Nome ja existe.',
        ]);

        // check if id
        if ($this->isDepartmentBlocked($id))
        {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);

        $department->update([
            'name'=> $request->name,
        ]);

        return redirect()->route('departments');
    }

    public function deleteDepartment($id)
    {
        Auth::user()->can('admin') ?: abort(403, 'You are not allowed to access this page');


        // check if id
        if ($this->isDepartmentBlocked($id))
        {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);

        return view('department.delete-department-confirm', compact('department'));
    }

    public function deleteDepartmentConfirm($id) {
        Auth::user()->can('admin') ? : abort(403, 'You are not allowed to access this page');

        if ($this->isDepartmentBlocked($id))
        {
            return redirect()->route('departments');
        }

        $department = Department::findOrFail($id);
        $department->delete();

        // update all colaborators department to null
        User::where('department_id', $id)->update(['department_id' => null]);

        return redirect()->route('departments');
    }

    public function isDepartmentBlocked($id) {
        return in_array(intval($id), [1,2]);
    }
}
