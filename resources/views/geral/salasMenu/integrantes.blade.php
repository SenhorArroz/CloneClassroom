@extends('geral.sala')
@section('nome', 'mural33')
@section('parte')
    <div class="container"> </div>
    <div class="row mb-3" style="max-width: 40%">
        <div class="border-bottom border-3 border-primary-subtle  d-flex mb-5" style="">
            <h1 class="fs-3 mb-0">Professor(a): {{ $professor->firstName . ' ' . $professor->lastName }}</h1>
        </div>
        <div class="border-bottom border-3 border-primary  d-flex mb-2" style="">
            <h1 class="fs-6 mb-0">Área de alunos</h1>
        </div>
        @foreach ($alunos as $aluno)
            <div class="border-bottom border-3 border-primary-subtle  d-flex mb-0" style="">
                <div class="fs-5 mb-0">{{ $aluno->firstName . ' ' . $aluno->lastName }}</div>
            </div>
        @endforeach
        <br>

    </div>
    </div>
@endsection
