@extends('layout')
@section('titulo', $salas->name)
@section('conteudo')

    @auth
        <div class="p-2">
            <div class="card border-primary-subtle border-3" style="height: 92vh">
                <div class="card-header bg-secondary-subtle border-3 text-center border-primary">
                    <div class="btn-group w-100 h-100" role="group" aria-label="Basic example">
                        @if (auth()->user()->userType == 1)
                            <a class="btn bg-secondary-subtle" data-bs-toggle="offcanvas" href="#offcanvasInfo" role="button"
                                aria-controls="offcanvasInfo">
                                Informações
                            </a>
                            <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasInfo"
                                aria-labelledby="offcanvasInfoLabel">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title" id="offcanvasInfoLabel">Informações da sala</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body text-center">
                                    <div>
                                        <p>{{ $salas->descricao }}</p>
                                        <h4>Código da sala: {{ $salas->codigo }}</h4>
                                        <br><br>
                                          <h1 class="fs-4 mb-0 text-danger border-bottom border-danger-subtle">Área de perigo</h1>
                                          <br><buatton type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Deletar sala de aula</button>
                                           
                                    </div>
                                    
                                </div>
                            </div>
                        @endif
                        <a href="{{ route('sala.mural', $salas->salaSlug) }}" class="btn bg-secondary-subtle">Mural</a>
                        <a href="{{ route('sala.atividade', $salas->salaSlug) }}" class="btn bg-secondary-subtle">Atividades</a>
                        <a href="{{ route('sala.integrantes', $salas->salaSlug) }}"
                            class="btn bg-secondary-subtle">Integrantes</a>
                    </div>
                </div>
                <div class="card-body text-center d-flex flex-column overflow-auto">
                    <div class="container-fluid text-center">
                        <div class="">
                            @yield('parte')
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <!-- Modal delete-->
<div class="modal fade text-center" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable border-danger-subtle">
    <div class="modal-content border-danger-subtle">
      <div class="modal-header border-danger-subtle bg-danger-subtle">
        <h1 class="modal-title fs-5 w-100 text-center" id="deleteModalLabel">Aviso</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body bg-secondary-subtle">
        Você tem certeza de que quer deletar a sua sala de aula? <br>
        Se fizer isso, ela e o seu conteúdo serão apagados permanentemente! 
      </div>
      <div class="modal-footer border-danger-subtle bg-danger-subtle">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
        <a href="{{ route('sala.delete', $salas->id) }}" class="btn btn-danger">Deletar</a>
      </div>
    </div>
  </div>
</div>
    @else
    @endauth
@endsection
