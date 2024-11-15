<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    
    public function auth(Request $request)
    {
        $credenciais = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ], [
            'email.required' => 'O campo de email é obrigatório!',
            'email.email' => 'O email não é válido!',
            'password.required' => 'A senha é obrigatória!',
        ]);
        if(Auth::attempt($credenciais, $request->remember)){
            $request->session()->regenerate();
            return redirect()->route('site.salasdeaula');
        }else{
            return redirect()->back()->with('erro', 'Usuário ou senha inválido!');
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('site.home'));
    }
    public function create(){
        return view('login.registro');
    }
}
