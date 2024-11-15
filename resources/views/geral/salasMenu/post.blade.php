@extends('geral.sala')
@section('nome', 'Mural')
@section('parte')
    <div class="text-start">
        <br>
        <div class="d-flex justify-content-between align-items-center ">
            <h1>{{ $post->titulo }}</h1>
            @if (auth()->user()->userType == 1)
                <button type="button" class="btn btn-danger rounded-circle d-flex justify-content-center align-items-center"
                    style="width: 40px; height: 40px" data-bs-toggle="modal" data-bs-target="#deletePostModal">
                    <i class="bi bi-trash" style="font-size: 25px"></i>
                </button>
            @endif
        </div>
        <div class="row  align-items-center border-top border-3 border-primary-subtle border-bottom ">
            <p class="fs-5">{!! $post->texto !!}</p>
        </div>

        <br>
        <div>
            <p>Área de comentários <i class="bi bi-chat-left-text"></i></p>


            <!-- Modal comentário -->
            <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
                <div class="modal-dialog border-primary-subtle border-3 modal-dialog-scrollable modal-dialog-centered">
                    <div class="modal-content border-primary-subtle border-3 text-center">
                        <div class="modal-header border-3 border-primary">
                            <h1 class="modal-title border-3 fs-5 text-center" id="commentModalLabel">Comentário</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formComment" action="{{ route('mural.postComment') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="slug" value="{{ $salas->salaSlug }}">
                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                <input type="hidden" name="postName" value="{{ $post->titulo }}">
                                <input type="hidden" name="criador_id" value="{{ auth()->user()->id }}">
                                <div class="form-floating">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" name="texto"
                                            style="height: 250px"></textarea>
                                        <label for="floatingTextarea2">Texto</label>
                                    </div>
                                </div><br>
                                @error('texto')
                                    <div class="error">
                                        <p class="text-danger-emphasis border border-primary rounded-pill"
                                            style="font-size: 13px;">{{ $message }}</p>
                                    </div>
                                @enderror
                                <div class="modal-footer border-3 border-primary">
                                    <button class="btn btn-danger" data-bs-dismiss="modal">Voltar</button>
                                    <button id="submitButton" class="btn btn-success">Publicar</button>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const form = document.getElementById('formComment'); // ou o ID do seu formulário
                                            const submitButton = document.getElementById('submitButton');

                                            form.addEventListener('submit', function() {
                                                // Desabilita o botão de submissão para evitar múltiplos envios
                                                submitButton.disabled = true;
                                                submitButton.innerText = "Aguarde..."; // opcional, para feedback visual
                                            });
                                        });
                                    </script>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal delete comment -->
            <div class="modal fade text-center" id="deletePostModal" tabindex="-1" aria-labelledby="deletePostModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable border-danger-subtle">
                    <div class="modal-content border-danger-subtle">
                        <div class="modal-header border-danger-subtle bg-danger-subtle">
                            <h1 class="modal-title fs-5 w-100 text-center" id="deletePostModalLabel">Aviso</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body bg-secondary-subtle">
                            Você tem certeza de que quer deletar sua postagem? <br>
                            Se fizer isso, ela será apagada permanentemente!
                        </div>
                        <div class="modal-footer border-danger-subtle bg-danger-subtle">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                            <a href="{{ route('mural.postDelete', ['salaSlug' => $salas->salaSlug, 'idPost' => $post->id]) }}"
                                class="btn btn-danger">Deletar</a>
                        </div>
                    </div>
                </div>
            </div>

            @isset($comments)
                <div class="container"> </div>
                <div class="row mb-3" style="max-width: 40%">
                    @foreach ($comments as $comment)
                        <div class="border-bottom border-3 border-primary  d-flex mb-2" style="">
                            <div class="fs-5 mb-0">{{ $comment->creator_name }}</div>
                            <p class="mb-0 ms-3" style="font-size:10px; margin-bottom: 0; align-self:flex-end;">
                                {{ $comment->created_at }}</p>
                        </div>
                        <div class="card-body border-3 border-bottom border-primary-subtle">
                            <p class="card-text">{{ $comment->texto }}</p>
                        </div>
                    @endforeach
                </div>
            @endisset
        </div>
    </div>
    <div class="p-3 position-fixed " style="bottom: 15px; right: 10px;">
        <div class="mt-auto text-sm-end ">
            <button type="button" class="btn btn-primary rounded-circle " style="width: 80px; height: 80px"
                data-bs-toggle="modal" data-bs-target="#commentModal">
                <i class="bi bi-plus-circle-dotted heading" style="font-size: 40px"></i>
            </button>
        </div>
    </div>
@endsection
