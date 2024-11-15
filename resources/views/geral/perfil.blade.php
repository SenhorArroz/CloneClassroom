@extends('layout')
@section('titulo', 'Perfil')
@section('conteudo')
<div class="p-5">
    <div class="p-5">
        <div class="card border-3 border-primary-subtle">
            <div class="card-header text-center border-3 border-primary-subtle">
                Informações pessoais
            </div>
            <div class="card-body">
                        <h5> Verifique ou atualize suas informações pessoais</h5><br>
                        <form action="{{route('perfil.update')}}" method="POST" enctype="multipart/form-data">
                          @csrf
                          <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                          <div class="input-group flex-nowrap" style="width: 70%">
                            <span class="input-group-text" id="addon-wrapping">Primeiro nome</span>
                            <input type="text" class="form-control" name="firstName"  placeholder="Username" aria-label="Username" aria-describedby="addon-wrapping" value="{{ $user->firstName}}">
                          </div>
                          <br>
                          <div class="input-group flex-nowrap" style="width: 70%">
                            <span class="input-group-text" id="addon-wrapping">Sobrenome</span>
                            <input type="text" class="form-control" placeholder="Username" name="lastName" aria-label="Username" aria-describedby="addon-wrapping" value="{{ $user->lastName}}">
                          </div>
                          <br>
                          <div class="input-group flex-nowrap" style="width: 70%">
                            <span class="input-group-text" id="addon-wrapping">E-mail</span>
                            <input type="text" class="form-control" placeholder="Username" name="email" aria-label="Username" aria-describedby="addon-wrapping" value="{{ $user->email}}">
                          </div>
                          <br>
                          <button class="btn btn-outline-success">Atualizar dados
                          </button>
                        </form>
                        
                          <br>
                          <h5>Tipo de usuário:</h5>
                          <p> @if ($user->userType == 0)
                              Aluno
                              @else
                              Professor
                          @endif </p>
                        <p></p>
            </div>
            
    </div>
</div>

@endsection