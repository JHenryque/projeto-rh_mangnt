<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmAccountEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function home(): View
    {
        Auth::user()->can('admin') ? : abort(403, 'You are not allowed to access this page');

        // colleact all infomation about the organization
        $data = [];

        // get total number of colaboratos (deleted_at is null)
        $data['total_colaborators'] = User::whereNull('deleted_at')->count();

        // total colaborators deleted
        $data['total_colaborators_deleted'] = User::onlyTrashed()->count();

        // total salary for all colaboratos
        $data['total_salary'] = User::withoutTrashed()->with('detail')->get()->sum(function ($colaborator) {
            return $colaborator->detail->salary;
        });

        // formatado o valor
        $data['total_salary'] = number_format($data['total_salary'], 2, ',', '.') . ' $';

        // total colaborators by department
        $data['total_colaborators_per_department'] = User::withoutTrashed()->with('department')->get()->groupBy('department_id')->map(function ($department) {
            return [
                'department' => $department->first()->department->name ?? " - ",
                'total' => $department->count(),
            ];
        });

        // total salaru by department
        $data['total_colaborators_by_department'] = User::withoutTrashed()->with('department', 'detail')->get()->groupBy('department_id')->map(function ($department) {
            return [
                'department' => $department->first()->department->name ?? " - ",
                'total' => $department->sum(function ($colaborator) {
                    return $colaborator->detail->salary;
                }),
            ];
        });


        return view('home', compact('data'));
    }

}
