<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth:api');
    // }

    public function update(User $user, Request $request) {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if($request->password != null){
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return response()->json(['message' => 'Perfil atualizado com sucesso', 'user' => $user]);
    }

    
}
