<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sala;
use \App\Models\User;
use \App\Models\Salas_aluno;
use Illuminate\Support\Str;

class SalasController extends Controller
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
            'name' => 'required',
            'descricao' => 'required|max:40',
        ], [
                'name.required' => 'Ponha um nome na sala!',
                'descricao.required' => 'Ponha uma descrição na sala!',
                'descricao.max' => 'Maximo de 40 caracteres',
            ]);
        $sala = $request->all();
        $bytes = openssl_random_pseudo_bytes(5, $strong);
        if (!$strong) {
            exit();
        }
        $hex = bin2hex($bytes);
        $sala['codigo'] = $hex;
        $sala['salaSlug'] = Str::slug($sala['name']);
        if ($request->hasFile('image')) {
            $imageName = md5($request->image->getClientOriginalName() . strtotime('now')) . '.' . $request->image->extension();
            $request->image->move('storage/public/img/salas', $imageName);
            $sala['image'] = $imageName;
        } else {
            return redirect()->back()->with('erro', 'Escolha uma foto para a sala!');
        }



        $sala = Sala::create($sala);
        return redirect()->route('site.salasdeaula');
    }
    public function join(Request $request){
        $sala = Sala::where('codigo', $request['codigoSala'])->first();
        $join = [
            'id_user' => $request['user_id'],
            'id_salas' => $sala->id,
        ];
        $join = Salas_aluno::create($join);
        return redirect()->route('site.salasdeaula');
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $delete = Sala::where('id', $id)->delete();
        return redirect()->route('site.salasdeaula');
    }
}
