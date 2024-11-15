<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Atividade;
use App\Models\Categoria;
use App\Models\Pergunta;
use App\Models\Resposta;
use App\Models\Entregasatividade;
use App\Models\Comentariospost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class MenuSalaController extends Controller
{
    public function criarPost(Request $request){
        $comment = $request->all();
        $request->validate([
            'titulo' => 'required',
            'content' => 'required',
        ], [
                'titulo.required' => 'Ponha um título na postagem.',
                'content.required' => 'Escreva um texto para postar.',
            ]);
        $post = Post::create([
            'sala_id' => $comment['sala_id'],
            'titulo' => $comment['titulo'],
            'texto' => $comment['content'],
        ]);
        return redirect()->route('sala.mural', $request['slug']);
    }
    public function deletePost($salaSlug, $idPost){
        $delete = Post::where('id', $idPost)->delete();
        return redirect()->route('sala.mural', $salaSlug);
    }
    public function criarCommentPost(Request $request){
        $comment = $request->all();
        $request->validate([
            'texto' => 'required',
        ], [
                'texto.required' => 'Escreva um texto para postar.',
            ]);
        $post = Comentariospost::create([
            'post_id' => $comment['post_id'],
            'criador_id' => $comment['criador_id'],
            'texto' => $comment['texto'],
        ]);
        $post = Post::where('id');
        $slug = $request['slug'];
        $postName = $request['postName'];
        $id = $request['post_id'];
        return redirect()->route('mural.post', ['slug' => $slug, 'postName' => $postName, 'id' => $id]);
    }

    public function criarCategoria(Request $request){
        $request->validate([
            'name' => 'required',
        ], [
                'name.required' => 'Escreva um nome para a categoria.',
            ]);

        $comment = $request->all();
        $categoria = Categoria::create([
            'name' => $comment['name'],
            'sala_id' => $comment['sala_id'],
        ]);
        return redirect()->route('sala.atividade', ['slug' => $comment['slug']]);
    }
    public function deletarCategoria(Request $request){
        $delete = Categoria::where('id', $request->categoria)->delete();
        return redirect()->route('sala.atividade', $request->salaSlug);
    }
    public function criarAtividade(Request $request){
        $request->validate([
            'titulo' => 'required',
            'categoria' => 'required',
        ], [
                'titulo.required' => 'Escreva um titulo para a atividade.',
                'categoria.required' => 'Selecione uma categoria!',
            ]);
        $atividade = Atividade::create([
            'titulo' => $request['titulo'],
            'categoria_id' => $request['categoria'],
            'texto' => $request['content'],
            'sala_id' => $request['sala_id'],
        ]);
        return redirect()->route('sala.atividade', ['slug' => $request['slug']]);
    }
    public function deletarAtividade($salaSlug, $idAtividade){
        $delete = Atividade::where('id', $idAtividade)->delete();
        return redirect()->route('sala.atividade', $salaSlug);
    }
    public function criarPergunta(Request $request){
        $pergunta = Pergunta::create([
            'titulo' => $request->titulo,
            'texto' => $request->content,
            'pontos' => $request->pontuacao,
            'atividade_id' => $request->atividade_id,
        ]);
        foreach ($request->resposta as $index => $respostaTexto) {
            $resposta = Resposta::create([
                'numero_resposta' => $index + 1,
                'texto' => $respostaTexto,
                'is_correta' => ($index + 1 == $request->selectOption), 
                'pergunta_id' => $pergunta->id, 
            ]);
        }
        return redirect()->route('atividade.atividade', ['slug' => $request['slug'], 'atividadeTitulo' => $request['atividadeTitulo'], 'id' => $request['atividade_id']]);

    }
    public function responderAtividade(Request $request){
        // Validação: garante que cada pergunta tenha uma resposta
    $request->validate([
        'respostaIndex' => 'required|array',
        'respostaIndex.*' => 'required', // Cada pergunta precisa de uma resposta selecionada
    ], [
        'respostaIndex.required' => 'Por favor, selecione uma resposta para cada pergunta.',
        'respostaIndex.*.required' => 'Todas as perguntas devem ter uma resposta selecionada.',
    ]);

    // Recupera as perguntas da atividade especificada
    $perguntas = Pergunta::where('atividade_id', $request->atividade_id)->with('respostas')->get();

    // Recupera o aluno autenticado
    $aluno = Auth::user();
    $pontuacaoTotal = 0; // Pontuação final do aluno para a atividade
    $feio = 0;
    // Itera pelas perguntas e respostas fornecidas
    foreach ($perguntas as $pergunta) {
        $respostaAluno = $request->respostaIndex[$feio]; // ID da resposta escolhida
        $feio += 1;

        // Verifica se a resposta do aluno é correta (ajuste conforme sua lógica de pontuação)
        $respostaCorreta = $pergunta->respostas->where('is_correta', true)->first();
        $respostaEscolhida = $pergunta->respostas->where('numero_resposta', $respostaAluno)->first();

        if ($respostaEscolhida && $respostaCorreta && $respostaEscolhida->id == $respostaCorreta->id) {
            $pontuacaoTotal += $pergunta->pontos; // Adiciona a pontuação específica da pergunta
        }
    }
    Entregasatividade::updateOrCreate(
        [
            'aluno_id' => $aluno->id,
            'atividade_id' => $request->atividade_id,
        ],
        [
            'pontuacao' => $pontuacaoTotal,
        ]
    );
    
    return redirect()->back()->with('success', 'Atividade respondida com sucesso! Sua pontuação foi salva.');
    }
}
