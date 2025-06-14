<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ColaboratorsController;
use App\Http\Controllers\ConfirmAccountController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RhManagementController;
use App\Http\Controllers\RhUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::middleware('guest')->group(function () {

    // email confirmation and password definition
    Route::get('/confirm-account/{id}', [ConfirmAccountController::class, 'confirmAccount'])->name('confirm-account');
    Route::post('/confirm-account', [ConfirmAccountController::class, 'confirmAccountSubmit'])->name('confirm-account-submit');

});

Route::middleware('auth')->group(function () {

    Route::redirect('/', 'home');
    Route::get('/home', function (){
        // ckeck if user is admin
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.home');
        } else if (auth()->user()->role === 'rh') {
            return  redirect()->route('rh.management.home');
        } else {
            return redirect()->route('colaborator');
        }
    })->name('home');

    // admin home
    Route::get('/admin/home', [AdminController::class, 'home'])->name('admin.home');

    // user profile page
    Route::get('/user/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::post('/user/profile/update-user-data', [ProfileController::class, 'updateUserData'])->name('user.profile.update-user-data');
    Route::post('/user/profile/update-password', [ProfileController::class, 'updatePassword'])->name('user.profile.update');
    Route::post('/user/profile/update-user-address', [ProfileController::class, 'updateUserAddress'])->name('user.profile.update-user-address');

    // user departments
    Route::get('/departments', [DepartmentController::class, 'index'])->name('departments');
    Route::get('/departments/new-department', [DepartmentController::class, 'newDepartment'])->name('departments.new-department');
    Route::post('/departments/create-department', [DepartmentController::class, 'createDepartment'])->name('departments.create-department');

    Route::get('/departments/edit-department/{id}', [DepartmentController::class, 'editDepartment'])->name('departments.edit-department');
    Route::post('/departments/update-department', [DepartmentController::class, 'updateDepartment'])->name('departments.update-department');

    Route::get('/departments/delete-department{id}', [DepartmentController::class, 'deleteDepartment'])->name('departments.delete-department');
    Route::get('/departments/delete-department-confirm/{id}', [DepartmentController::class, 'deleteDepartmentConfirm'])->name('departments.delete-department-confirm');

    // rh colaborators
    Route::get('/rh-users', [RhUserController::class, 'index'])->name('colaborators.rh-users');
    Route::get('/rh-users/new-colaborators', [RhUserController::class, 'newColarator'])->name('colaborators.new-colaborator');
    Route::post('/rh-users/create-colaborators', [RhUserController::class, 'createRhColarator'])->name('colaborators.create-colaborator');

    // detail rh colaborator
    Route::get('/rh-users/edit-colarator/{id}', [RhUserController::class, 'editRhColarator'])->name('colaborators.edit-colarator');
    Route::post('/rh-user/update-colaborator', [RhUserController::class, 'updateRhColarator'])->name('colaborators.update-colaborator');
    Route::get('rh-user/deleted-colaborator/{id}', [RhUserController::class, 'deleteRhColarator'])->name('colaborators.delete-colarator');
    Route::get('rh-user/deleted-confirm/{id}', [RhUserController::class, 'deleteRhColaratorConfirm'])->name('colaborators.delete-confirm');
    Route::get('/rh-users/restore/{id}', [RhUserController::class, 'restoreRhColaborator'])->name('colaborators.rh.restore');

    // rh management
    Route::get('/rh-users/management/home', [RhManagementController::class, 'home'])->name('rh.management.home');
    Route::get('/rh-users/management/new-colaborator', [RhManagementController::class, 'newColarator'])->name('rh.management.new-colaborator');
    Route::post('/rh-users/management/create-colaborator', [RhManagementController::class, 'createColarator'])->name('rh.management.create-colaborator');
    Route::get('/rh-users/management/edit-colaborator/{id}', [RhManagementController::class, 'editColaborator'])->name('rh.management.edit-colaborator');
    Route::post('/rh-users/management/update-colaborator', [RhManagementController::class, 'updateColaborator'])->name('rh.management.update-colaborator');
    Route::get('/rh-users/management/details/{id}', [RhManagementController::class, 'ShowDetails'])->name('rh.management.details');

    Route::get('/rh-users/management/delete/{id}', [RhManagementController::class, 'deleteColaborator'])->name('rh.management.delete');
    Route::get('/rh-users/management/delete-confirm/{id}', [RhManagementController::class, 'deleteColaboratorConfirm'])->name('rh.management.delete-confirmation');
    Route::get('/rh-users/management/restore/{id}', [RhManagementController::class, 'restoreColaborator'])->name('rh.management.restore');


    // admin colaboratirs list
    Route::get('/colaborators', [ColaboratorsController::class, 'index'])->name('colaborators.all-colaborators');
    Route::get('/colaborators/details/{id}', [ColaboratorsController::class, 'showDetails'])->name('colaborators.show-details');
    Route::get('/colaborators/delete/{id}', [ColaboratorsController::class, 'deleteColaborator'])->name('colaborators.delete');
    Route::get('/colaborators/delete-confirm/{id}', [ColaboratorsController::class, 'deleteColaboratorConfirmation'])->name('colaborators.delete-confirm');
    Route::get('/colaborators/restore/{id}', [ColaboratorsController::class, 'restoreColaborator'])->name('colaborators.restore');

    // home colaborator
    Route::get('/colaborator', [ColaboratorsController::class, 'home'])->name('colaborator');

    // inicio rh
});

