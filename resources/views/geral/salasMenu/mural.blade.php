@extends('geral.sala')
@section('nome', 'Mural')
@section('parte')
    @isset($posts)
        @foreach ($posts as $post)
            <div class="card border border border border-light-subtle mb-3 text-start" style=" height: 100%; width: 100%;">
                <div
                    class="card-header border border-light-subtle d-flex justify-content-between bg-secondary-subtle align-items-center fs-5 ">
                    {{ $professor->firstName . ' ' . $professor->lastName }}
                    <a href="{{ route('mural.post', ['slug' => $salas->salaSlug, 'postName' => $post->titulo, 'id' => $post->id]) }}"
                        class="btn btn-outline-light"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-chat-left-text" viewBox="0 0 16 16">
                            <path
                                d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H4.414A2 2 0 0 0 3 11.586l-2 2V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z" />
                            <path
                                d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6m0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5" />
                        </svg></a>
                </div>

                <div class="card-body ">
                    <h5 class="card-title">{{ $post->titulo }}</h5>
                    <p class="card-text">{!! $post->texto !!}</p>
                </div>
            </div>
        @endforeach
    @endisset
    @if (auth()->user()->userType == 1)
        <div class="p-3 position-fixed " style="bottom: 15px; right: 10px;">
            <div class="mt-auto text-sm-end ">
                <button type="button" class="btn btn-primary rounded-circle " style="width: 80px; height: 80px"
                    data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="bi bi-plus-circle-dotted heading" style="font-size: 40px"></i>
                </button>
            </div>
        </div>
    @endif


    <!-- Modal comentário -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog border-primary-subtle modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content border-primary-subtle text-center">
                <div class="modal-header border-primary">
                    <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Criar postagem</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formPost" action="{{ route('sala.post') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="sala_id" value="{{ $salas->id }}">
                        <input type="hidden" name="slug" value="{{ $salas->salaSlug }}">
                        <input type="hidden" name="criador_id" value="{{ auth()->user()->id }}">
                        <div class="input-group mb-3">
                            <span class="input-group-text">#</span>
                            <div class="form-floating">
                                <input type="text" class="form-control" placeholder="Titulo" id="floatingInputGroup1"
                                    name="titulo">
                                <label for="floatingInputGroup1">Titulo</label>
                            </div>
                        </div>
                        @error('titulo')
                            <div class="error">
                                <p class="text-danger-emphasis border border-danger rounded-pill" style="font-size: 13px;">
                                    {{ $message }}</p>
                            </div>
                        @enderror
                        <div class="form-floating " data-bs-theme="light">
                            <div id="editor" class="rounded text-light"></div>
                            <input type="hidden" name="content" id="content">
                            @error('content')
                                <div class="error">
                                    <p class="text-danger-emphasis border border-danger rounded-pill" style="font-size: 13px;">
                                        {{ $message }}</p>
                                </div>
                            @enderror
                        </div><br>
                        <style>
                            /* Customizando o Quill para dark mode */
                            .ql-snow,
                            .ql-bubble {
                                background-color: #1a1d20;
                                /* Cor de fundo escura para o editor */
                                color: white;
                                /* Cor do textox' */
                            }

                            .ql-editor {
                                height: 400px;
                                /* Ajuste a altura conforme necessário */
                            }

                            /* Personalizando a barra de ferramentas (toolbar) */
                            .ql-toolbar {
                                background-color: #17191b;
                                border: none;
                            }

                            /* Barra de ferramentas ativa com hover */
                            .ql-toolbar button:hover {
                                background-color: #555;
                                color: white;
                            }

                            /* Ajuste para o placeholder (texto de placeholder) */
                            .ql-editor.ql-blank::before {
                                color: #ffffff;
                                /* Cor do texto de placeholder */
                            }

                            /* Ajuste na cor do cursor */
                            .ql-editor {
                                caret-color: #f0f0f0;
                                /* Cor do cursor */
                            }

                            /* Ajuste de bordas */
                            .ql-snow .ql-editor {
                                border: 1px solid #444;
                            }

                            .ql-snow .ql-toolbar {
                                border-bottom: 1px solid #555;
                            }

                            /* Cor das listas e links */
                            .ql-editor ul,
                            .ql-editor ol {
                                color: white;
                            }

                            .ql-editor a {
                                color: #3498db;
                            }

                            .ql-editor a:hover {
                                color: #2980b9;
                            }
                        </style>
                        <script>
                            var quill = new Quill('#editor', {
                                theme: 'snow',
                                placeholder: 'Digite seu post',
                                modules: {
                                    toolbar: [
                                        [{
                                            'list': 'ordered'
                                        }, {
                                            'list': 'bullet'
                                        }],
                                        ['bold', 'italic', 'underline'],
                                        ['link', 'blockquote'],
                                        [{
                                            'align': []
                                        }],
                                    ]
                                }
                            });

                            // Enviar o conteúdo do Quill para o campo oculto antes de enviar o formulário
                            var form = document.querySelector('form');
                            form.onsubmit = function() {
                                var content = document.querySelector('#content');
                                content.value = quill.root.innerHTML; // Pega o conteúdo HTML do Quill
                            };
                        </script>
                </div>
                <div class="modal-footer border-primary">
                    <button class="btn btn-danger" data-bs-dismiss="modal">Voltar</button>
                    <button id="submitButton" class="btn btn-primary">Publicar</button>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const form = document.getElementById('formPost'); // ou o ID do seu formulário
                            const submitButton = document.getElementById('submitButton');

                            form.addEventListener('submit', function() {
                                // Desabilita o botão de submissão para evitar múltiplos envios
                                submitButton.disabled = true;
                                submitButton.innerText = "Aguarde..."; // opcional, para feedback visual
                            });
                        });
                    </script>
                </div>
                </form>

            </div>
        </div>
    </div>
@endsection
