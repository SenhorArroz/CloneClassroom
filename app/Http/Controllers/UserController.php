<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $request->validate([
            'firstName' => 'required',
            'lastName' => 'required',
            'password' => 'required|min:8', // Pelo menos 8 caracteres
            'email' => 'required|email',
            'userType' => 'required',
        ], [
                'firstName.required' => 'O primeiro nome é obrigatório.',
                'lastName.required' => 'O sobrenome é obrigatório.',
                'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
                'password.required' => 'A senha é obrigatória.',
                'userType.required' => 'O tipo do usuário é obrigatório.',
                'email.email' => 'Ponha um email válido!',
                'email.required' => 'Email é obrigatório.',
            ]);
        // Pega tudo que foi passado no form
        $user = $request->all();
        //Define e encripta a senha
        $user['password'] = bcrypt($request->password);
        //Coloca os dois nomes em uma var para fazer a slug
        $nome = $user['firstName'] . ' ' . $user['lastName'];
        $user['userSlug'] = Str::slug($nome);
        //cria usuário
        $newUser = User::create($user);
        Auth::login($newUser);
        return redirect()->route('site.home');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Pega tudo que foi passado no form
        $user = $request->all();
        //Encontra o usuário
        $registro = User::findOrFail($user['id']);
        // Define os novos valores
        $registro->firstName = $user['firstName'];
        $registro->lastName = $user['lastName'];
        $registro->email = $user['email'];
        $novoNome = $user['firstName'] . ' ' . $user['lastName'];
        $registro->userSlug = Str::slug($novoNome);
        // Salva no DB
        $registro->save();
        // Volta para profile
        return redirect()->route('site.perfil', $registro->userSlug);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
