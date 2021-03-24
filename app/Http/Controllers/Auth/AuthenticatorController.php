<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthenticatorController extends Controller
{
    public function register(Request $request)
    {
        // nome email senha
        $request->validate([
            'name' => 'string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $user->save();

        return response()->json(['resp' => 'Usuário Criado com sucesso!'], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credenciais = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if(!Auth::attempt($credenciais)) {
            return response()->json('Acesso Negado', 401);
        }

        $user = $request->user();
        return response()->json('Você fez o login com sucesso', 201);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(['resp' => 'Você fez o logout com sucesso!'], 201);
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
