<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

Route::get('/email', function () {
    Mail::raw('Hello World RH MANGNT', function (Message $message) {
        $message->to('teste@teste.com')->subject('Hello World RH MANGNT!')->from('rh@gmail.com');
    });

    echo '<h1>Email enviado com sucesso!</h1><br>';
});

Route::get('/admin', function () {
   $admin = \App\Models\User::with('detail','department')->find(1);
   dd($admin->toArray());
});
