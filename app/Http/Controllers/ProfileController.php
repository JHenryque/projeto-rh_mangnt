<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    //
     public function index(): View
     {
         $colaborator = User::with('detail', 'department')->findOrFail(auth()->id());

         return view('user.profile')->with('colaborator', $colaborator);
     }

     public function updatePassword(Request $request)
     {
         $request->validate([
             'current_password' => 'required|min:8|max:16',
             'new_password' => 'required|min:8|max:16|different:current_password',
             'new_password_confirmation' => 'required|same:new_password',
         ],
         [
             'current_password.required' => 'Campo Senha obrigatorio',
             'new_password.required' => 'Campo nova Senha obrigatorio',
             'new_password.different' => 'A nova senha tem de ser diferente do que a senha atual',
             'new_password_confirmation.required' => 'Campo Repetir a Senha obrigatorio',
             'new_password_confirmation.same' => 'A senha tem de ser igual a que a senha nova',
         ]);

         $user = auth()->user();

         //check if the current password is correct
         if (!password_verify($request->current_password, $user->password))
         {
             return redirect()->back()->with('error', 'Senha nova incorreta!');
         }

         $user->password = bcrypt($request->new_password);
         $user->save();
         return redirect()->back()->with('success', 'Senha alterada com sucesso!');
     }

     public function updateUserData(Request $request)
     {
         // form validation
         $request->validate([
             'name' => 'required|min:16|max:255',
             'email' => 'required|email|max:255|unique:users,email,'. auth()->id(),
         ],
             [
                 'name.required' => 'Campo Nome é obrigatorio',
                 'email.required' => 'Campo E-mail é obrigatorio',

             ]);

         // update user data
         $user = auth()->user();
         $user->name = $request->name;
         $user->email = $request->email;
         $user->save();

         return redirect()->back()->with('success_change_data', 'Alterada Usuario com sucesso!');
     }

     public function updateUserAddress(Request $request)
     {
         $request->validate([
             'address' => 'required|min:3|max:100',
             'zip_code' => 'required|min:8|max:8',
             'city' => 'required|min:3|max:50',
             'phone' => 'required|min:11|max:15'
         ]);

         $user = User::with('detail')->findOrFail(auth()->id());
         $user->detail->address = $request->address;
         $user->detail->zip_code = $request->zip_code;
         $user->detail->city = $request->city;
         $user->detail->phone = $request->phone;
         $user->detail->save();

         return redirect()->back()->with('success_change_address', 'Alterada Usuario com sucesso!');

     }
}
