<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;
use App\Http\Controllers\ProfileController;

Route::get('/email', function () {
    Mail::raw('Hello World RH MANGNT', function (Message $message) {
        $message->to('teste@teste.com')->subject('Hello World RH MANGNT!')->from('rh@gmail.com');
    });

    echo '<h1>Email enviado com sucesso!</h1><br>';
});

Route::get('/admin', function () {
   $admin = \App\Models\User::with('detail','department')->find(1);

   return view('admin', compact('admin'));
});

Route::view('/login', 'auth.login')->name('login');

Route::middleware('auth')->group(function () {

    Route::redirect('/', 'home');
    Route::view('/home', 'home')->name('home');

    // user profile page
    Route::get('/user/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::post('/user/profile', [ProfileController::class, 'updatePassword'])->name('user.profile.update');
    Route::post('/user/profile', [ProfileController::class, 'profileUserChangeData'])->name('user.profile.update');
});
