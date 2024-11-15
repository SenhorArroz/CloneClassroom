<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\View;
use \App\Models\User;
use \App\Models\Sala;
use \App\Models\Post;
use App\Models\Atividade;
use App\Models\Pergunta;
use App\Models\Resposta;
use App\Models\Entregasatividade;
use App\Models\Categoria;
use App\Models\Comentariospost;
use \App\Models\Salas_aluno;
use Illuminate\Support\Facades\Session;

use function PHPUnit\Framework\returnSelf;

class SiteController extends Controller
{
    public function index()
    {
        $tema = Session::put('tema', 'dark');
        $viewName = 'home';
        return view('geral.home', compact('viewName'));
    }
    public function loginView()
    {
        $viewName = 'login';
        return view('login.login', compact('viewName'));
    }
    public function registrarView()
    {
        $viewName = 'registro';
        return view('login.registro', compact('viewName'));
    }
    public function perfil($slug)
    {
        if (!Auth::check()) {
            return redirect()->route('site.home');
        }
        $viewName = 'perfil';
        $user = User::where('userSlug', $slug)->first();
        return view('geral.perfil', compact('user', 'viewName'));
    }
    public function salasdeaula()
    {
        if (!Auth::check()) {
            return redirect()->route('site.home');
        }
        $viewName = 'salasdeaula';
        $alunoSalas = [];
        if (Auth::user()->userType == 0) {
            $alunoSalas = Salas_aluno::where('id_user', Auth::user()->id)->get();
        }
        $salas = Sala::paginate(4);
        return view('geral.salasdeaula', compact('viewName', 'salas', 'alunoSalas'));
    }
    //views da sala
    public function acessarSala($slug)
    {
        if (!Auth::check()) {
            return redirect()->route('site.home');
        }
        $viewName = 'salasdeaula';
        $salas = Sala::where('salaSlug', $slug)->first();
        $professor = User::where('id', $salas->criador_id)->first();
        $posts = Post::where('sala_id', $salas->id)->get();
        return view('geral.salasMenu.mural', compact('salas', 'viewName', 'posts', 'professor'));
    }

    public function salaMural($slug)
    {
        if (!Auth::check()) {
            return redirect()->route('site.home');
        }
        $viewName = 'salasdeaula';
        $salas = Sala::where('salaSlug', $slug)->first();
        $professor = User::where('id', $salas->criador_id)->first();
        $posts = Post::where('sala_id', $salas->id)->get();
        return view('geral.salasMenu.mural', compact('salas', 'viewName', 'posts', 'professor'));
    }
    public function salaAtividades($slug)
    {
        if (!Auth::check()) {
            return redirect()->route('site.home');
        }
        $viewName = 'salasdeaula';
        $salas = Sala::where('salaSlug', $slug)->first();
        $categorias = Categoria::where('sala_id', $salas->id)->orderBy('id', 'desc')->get();
        $atividades = Atividade::where('sala_id', $salas->id)->get();
        $notas = Entregasatividade::where('aluno_id', Auth::user()->id)->get();
        return view('geral.salasMenu.atividades', compact('salas', 'notas', 'viewName', 'atividades', 'categorias'));
    }
    public function acessarAtividade($slug, $atividadeTitulo, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('site.home');
        }
        $viewName = 'salasdeaula';
        $salas = Sala::where('salaSlug', $slug)->first();
        $atividade = Atividade::where('id', $id)->first();
        $perguntas = Pergunta::where('atividade_id', $atividade->id)->with('respostas')->get();
        $alunosId = Salas_aluno::where('id_salas', $salas->id)->get();
        $alunos = [];

        foreach ($alunosId as $alunoIdObj) {
            // Obtém o aluno pelo ID
            $aluno = User::find($alunoIdObj->id_user);
            // Filtra as notas da atividade específica
            $notasFiltradas = $aluno->notas($atividade->id)->get();
            // Armazena as informações do aluno e as notas filtradas
            $alunos[] = [
                'aluno' => $aluno,
                'notas' => $notasFiltradas
            ];
        }

        return view('geral.salasMenu.atividadeView', compact('salas', 'viewName', 'atividade', 'perguntas', 'alunos'));
    }
    public function salaIntegrantes($slug)
    {
        if (!Auth::check()) {
            return redirect()->route('site.home');
        }
        $viewName = 'salasdeaula';
        $salas = Sala::where('salaSlug', $slug)->first();
        $professor = User::where('id', $salas->criador_id)->first();
        $alunosId = Salas_aluno::where('id_salas', $salas->id)->get();
        $alunos = [];
        foreach ($alunosId as $id) {
            $alunos[] = User::where('id', $id->id_user)->first();
        }
        return view('geral.salasMenu.integrantes', compact('salas', 'viewName', 'professor', 'alunos'));
    }
    public function postView($slug, $postName, $id)
    {
        $viewName = 'salasdeaula';
        $salas = Sala::where('salaSlug', $slug)->first();
        $professor = User::where('id', $salas->criador_id)->first();
        $post = Post::where('id', $id)->first();

        $comments = Comentariospost::where('post_id', $post->id)->with('creator')->orderBy('id', 'asc')->get()->map(function ($comment) {
            $comment->creator_name = $comment->creator->firstName . ' ' . $comment->creator->lastName;
            return $comment;
        });;
        return view('geral.salasMenu.post', compact('viewName', 'salas', 'professor', 'post', 'comments'));
    }
    public function trocarTema(){
        $tema = Session::get('tema', 'light');
        $newTheme = $tema === 'light' ? 'dark' : 'light';
        Session::put('tema', $newTheme);
        return redirect()->back();
    }
}
