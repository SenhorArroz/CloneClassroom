@extends('layout')
@section('titulo', 'Login')
@section('conteudo')
    <div class="card text-center position-absolute top-50 start-50 translate-middle " style="width: 25%">
        <div class="card-header">
            Login
        </div>
        <div class="card-body">
            <form action="{{ route('login.login') }}" method="POST" enctype="multipart/form-data">
                @csrf
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
                <div class="form-check text-start">
                    <input class="form-check-input" type="checkbox" name="remember" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Lembrar de mim
                    </label>
                </div>
                <br>
                <button href="#" class="btn btn-primary">Logar</button>
            </form>
        </div>
        <div class="card-footer text-body-secondary">
            <p>Ainda não possui uma conta? <a href="{{ route('login.registrarView') }}">Registrar</a></p>
        </div>
    </div>
@endsection
