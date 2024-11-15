@extends('geral.sala')
@section('nome', 'mural33')
@section('parte')
    @isset($categorias)
        @foreach ($categorias as $categoria)
            <div class="p-1 d-flex justify-content-between align-items-center border-primary-subtle border-3 border-bottom">
                <p class="fs-3 fw-bold mb-0 text-start">{{ $categoria->name }}</p>
                @if (auth()->user()->userType == 1)
                    <button type="button" class="btn btn-danger rounded-circle d-flex justify-content-center align-items-center"
                        style="width: 40px; height: 40px" data-bs-toggle="modal" data-bs-target="#deleteCategoriaModal">
                        <i class="bi bi-trash" style="font-size: 25px"></i>
                    </button>
                    @isset($atividades)
                        @if ($categorias->count() == 0)
                        @else
                            <div class="p-3 position-fixed " style="bottom: 100px; right: 10px;">
                                <div class="mt-auto text-sm-end ">
                                    <button type="button" class="btn btn-info rounded-circle " style="width: 80px; height: 80px"
                                        data-bs-toggle="modal" data-bs-target="#atividadeModal">
                                        <i class="bi bi-plus-circle-dotted heading" style="font-size: 40px"></i>
                                    </button>
                                </div>
                            </div>
                        @endif
                    @endisset
                @endif

            </div>

            </div> <br>
            @foreach ($atividades as $atividade)
    @if ($atividade->categoria_id == $categoria->id)
        <a href="{{ route('atividade.atividade', ['slug' => $salas->salaSlug, 'atividadeTitulo' => $atividade->titulo, 'id' => $atividade->id]) }}"
            class="btn border-secondary d-flex align-items-center p-3 mb-3 rounded border-2"
            style="width: 100%; text-align: left; color: var(--bs-body-color); background-color: var(--bs-body-bg);">
            <div class="icon-container d-flex align-items-center justify-content-center rounded-circle me-3"
                style="width: 65px; height: 65px; background-color: #0b5ed7;">
                <i class="bi bi-file-earmark-text-fill" style="font-size: 30px; color: white;"></i>
            </div>
            
            <!-- Div para conteúdo da atividade -->
            <div class="d-flex justify-content-between w-100">
                <!-- Conteúdo à esquerda -->
                <div>
                    <h5 class="mb-1" style="color: var(--bs-body-color);">{{ $atividade->titulo }}</h5>
                    <p class="mb-0" style="color: var(--bs-body-color);">
                        {!! Str::limit($atividade->texto, 200, '...') !!}
                    </p>
                </div>
                
                <!-- Status à direita -->
                <div class="text-end">
                    @php
                        // Verifica se o aluno entregou a atividade
                        $entregue = $notas->where('atividade_id', $atividade->id)
                                          ->where('aluno_id', auth()->user()->id)
                                          ->first();
                    @endphp

                    @if ($entregue)
                        <h5 class="mb-0">Nota: {{ $entregue->pontuacao }}</h5>
                    @else
                        <h5 class="mb-0">Atividade pendente</h5>
                    @endif
                </div>
            </div>
        </a>
    @endif
@endforeach
            <br><br>
        @endforeach

    @endisset


    @if (auth()->user()->userType == 1)
        <div class="p-3 position-fixed " style="bottom: 15px; right: 10px;">
            <div class="mt-auto text-sm-end ">
                <button type="button" class="btn btn-primary rounded-circle " style="width: 80px; height: 80px"
                    data-bs-toggle="modal" data-bs-target="#categoriaModal">
                    <i class="bi bi-plus-circle-dotted heading" style="font-size: 40px"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Modal delete categoria -->
    <div class="modal fade text-center" id="deleteCategoriaModal" tabindex="-1" aria-labelledby="deleteCategoriaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable border-danger-subtle">
            <div class="modal-content border-danger-subtle">
                <div class="modal-header border-danger-subtle bg-danger-subtle">
                    <h1 class="modal-title fs-5 w-100 text-center" id="deleteCategoriaModalLabel">Aviso</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg-secondary-subtle">
                    <form action="{{ route('categoria.delete') }}" id="formdeletecategoria" method="POST">
                        @csrf
                        <input type="hidden" name="salaSlug" value="{{ $salas->salaSlug }}">
                        <div class="input-group mb-3">

                            <span class="input-group-text">Categoria</span>
                            <select class="form-select" aria-label="Default select example" name="categoria">
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->name }}</option>
                                @endforeach
                            </select>

                        </div>
                        Você tem certeza de que quer deletar a categoria? <br>
                        Se fizer isso, ela será apagada permanentemente!
                </div>
                <div class="modal-footer border-danger-subtle bg-danger-subtle">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                    <button id="submitButton" class="btn btn-danger">Deletar</button>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const form = document.getElementById('formdeletecategoria'); // ou o ID do seu formulário
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
    <!-- Modal Categoria -->
    <div class="modal fade" id="categoriaModal" tabindex="-1" aria-labelledby="categoriaModalLabel" aria-hidden="true">
        <div class="modal-dialog border-primary-subtle modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content border-primary-subtle text-center">
                <div class="modal-header border-primary">
                    <h1 class="modal-title fs-5 text-center" id="categoriaModalLabel">Criar categoria</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formCategoria" action="{{ route('categoria.criar') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="sala_id" value="{{ $salas->id }}">
                        <input type="hidden" name="slug" value="{{ $salas->salaSlug }}">
                        <div class="input-group mb-3">
                            <span class="input-group-text">#</span>
                            <div class="form-floating">
                                <input type="text" class="form-control" placeholder="Titulo" id="floatingInputGroup1"
                                    name="name">
                                <label for="floatingInputGroup1">Nome da categoria</label>
                            </div>
                        </div>
                        @error('name')
                            <div class="error">
                                <p class="text-danger-emphasis border border-danger rounded-pill" style="font-size: 13px;">
                                    {{ $message }}
                                </p>
                            </div>
                        @enderror
                </div>
                <div class="modal-footer border-primary">
                    <button class="btn btn-danger" data-bs-dismiss="modal">Voltar</button>
                    <button id="submitButton" class="btn btn-primary">Criar</button>
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const form = document.getElementById('formCategoria'); // ou o ID do seu formulário
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
    <!-- Modal Atividades -->
    <div class="modal fade" id="atividadeModal" tabindex="-1" aria-labelledby="atividadeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog border-primary-subtle modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content border-primary-subtle text-center">
                <div class="modal-header border-primary">
                    <h1 class="modal-title fs-5 text-center" id="atividadeModalLabel">Criar atividade</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAtividade" action="{{ route('atividade.criate') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="sala_id" value="{{ $salas->id }}">
                        <input type="hidden" name="slug" value="{{ $salas->salaSlug }}">

                        <!-- Campo de Título -->
                        <div class="input-group mb-3">
                            <span class="input-group-text">#</span>
                            <div class="form-floating">
                                <input type="text" class="form-control" placeholder="Titulo" id="floatingInputGroup1"
                                    name="titulo">
                                <label for="floatingInputGroup1">Título da atividade</label>
                            </div>
                        </div>
                        @error('titulo')
                            <div class="error">
                                <p class="text-danger-emphasis border border-danger rounded-pill" style="font-size: 13px;">
                                    {{ $message }}
                                </p>
                            </div>
                        @enderror

                        <!-- Campo de Categoria -->
                        <div class="input-group mb-3">
                            <span class="input-group-text">Categoria</span>
                            <select class="form-select" aria-label="Default select example" name="categoria">
                                @foreach ($categorias as $categoria)
                                    <option value="{{ $categoria->id }}">{{ $categoria->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('categoria')
                            <div class="error">
                                <p class="text-danger-emphasis border border-danger rounded-pill" style="font-size: 13px;">
                                    {{ $message }}
                                </p>
                            </div>
                        @enderror

                        <!-- Editor Quill -->
                        <div class="form-floating " data-bs-theme="light">
                            <div id="editor" class="rounded text-light"></div>
                            <input type="hidden" name="content" id="content">
                        </div>
                        <br>

                        <style>
                            /* Estilos do Editor Quill */
                            .ql-snow,
                            .ql-bubble {
                                background-color: #1a1d20;
                                color: white;
                            }

                            .ql-editor {
                                height: 200px;
                            }

                            .ql-toolbar {
                                background-color: #17191b;
                                border: none;
                            }

                            .ql-toolbar button:hover {
                                background-color: #555;
                                color: white;
                            }

                            .ql-editor.ql-blank::before {
                                color: #ffffff;
                            }

                            .ql-editor {
                                caret-color: #f0f0f0;
                            }

                            .ql-snow .ql-editor {
                                border: 1px solid #444;
                            }

                            .ql-snow .ql-toolbar {
                                border-bottom: 1px solid #555;
                            }

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

                        <!-- Script para inicializar o Quill e evitar múltiplos envios -->
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                // Inicializa o editor Quill
                                var quill = new Quill('#editor', {
                                    theme: 'snow',
                                    placeholder: 'Digite o texto da sua atividade',
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
                                            }]
                                        ]
                                    }
                                });

                                // Captura o formulário e o botão de submissão
                                var form = document.getElementById('formAtividade');
                                var submitButton = document.getElementById('submitButton');

                                // Garante que o Quill está configurado e que o botão funcione uma única vez
                                form.addEventListener('submit', function(event) {
                                    event.preventDefault(); // Impede o envio padrão para evitar múltiplos envios

                                    // Define o conteúdo do editor no campo oculto
                                    document.getElementById('content').value = quill.root.innerHTML;

                                    // Desativa o botão após o primeiro clique e altera o texto
                                    if (!submitButton.disabled) {
                                        submitButton.disabled = true;
                                        submitButton.innerText = "Aguarde...";

                                        // Envia o formulário após garantir que o conteúdo foi preenchido
                                        form.submit();
                                    }
                                });
                            });
                        </script>
                </div>

                <!-- Footer do Modal com Botões -->
                <div class="modal-footer border-primary">
                    <button class="btn btn-danger" data-bs-dismiss="modal">Voltar</button>
                    <button id="submitButton" class="btn btn-primary">Criar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
