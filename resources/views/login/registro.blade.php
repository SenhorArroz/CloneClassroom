@extends('layout')
@section('titulo', 'Registro')
@section('conteudo')
    <div class="card text-center position-absolute top-50 start-50 translate-middle" style="width: 25%">
        <div class="card-header">
            Registrar
        </div>
        <div class="card-body">
            <form action="{{ route('login.registrar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="input-group mb-3">
                    <span class="input-group-text" style="">P</span>
                    <div class="form-floating">
                        <input type="text" class="form-control" placeholder="Primeiro nome" id="floatingInputGroup1"
                            name="firstName">
                        <label for="floatingInputGroup1">Primeiro nome</label>
                    </div>
                </div>
                @error('firstName')
                    <div class="error">
                        <p class="text-danger-emphasis border border-danger rounded-pill" style="font-size: 13px;">{{ $message }}</p>
                    </div>
                @enderror
                <div class="input-group mb-3">
                    <span class="input-group-text">S</span>
                    <div class="form-floating">
                        <input type="text" class="form-control" placeholder="Sobrenome" id="floatingInputGroup1"
                            name="lastName">
                        <label for="floatingInputGroup1">Sobrenome</label>
                    </div>
                </div>
                @error('lastName')
                    <div class="error">
                        <p class="text-danger-emphasis border border-danger rounded-pill" style="font-size: 13px;">{{ $message }}</p>
                    </div>
                @enderror
                <div class="input-group mb-3">
                    <span class="input-group-text">@</span>
                    <div class="form-floating">
                        <input type="email" class="form-control" placeholder="E-mail" id="floatingInputGroup1"
                            name="email">
                        <label for="floatingInputGroup1">E-mail</label>
                    </div>
                </div>
                @error('email')
                    <div class="error">
                        <p class="text-danger-emphasis border border-danger rounded-pill" style="font-size: 13px;">{{ $message }}</p>
                    </div>
                @enderror
                <div class="input-group mb-3">
                    <span class="input-group-text">#</span>
                    <div class="form-floating">
                        <input type="password" class="form-control" placeholder="Senha" id="floatingInputGroup1"
                            name="password">
                        <label for="floatingInputGroup1">Senha</label>
                    </div>
                </div>
                @error('password')
                    <div class="error">
                        <p class="text-danger-emphasis border border-danger rounded-pill" style="font-size: 13px;">{{ $message }}</p>
                    </div>
                @enderror
                <div class="form-floating">
                    <select class="form-select" id="floatingSelect" aria-label="Floating label select example"
                        name="userType">
                        <option value="0">Aluno</option>
                        <option value="1">Professor</option>
                    </select>
                    <label for="floatingSelect">Tipo do usuário</label>
                </div>
                <br>
                <button href="#" class="btn btn-primary">Registrar</button>
            </form>
        </div>
        <div class="card-footer text-body-secondary">
            <p>Já possui uma conta? <a href="{{ route('login.loginView') }}">Login</a></p>
        </div>
    </div>



@endsection
