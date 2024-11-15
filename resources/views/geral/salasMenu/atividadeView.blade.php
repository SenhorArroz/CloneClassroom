@extends('geral.sala')
@section('nome', 'Mural')
@section('parte')
    <div class="text-start">
        <br>
        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-auto">
                <h1>{{ $atividade->titulo }}</h1>
            </div>
            @if (auth()->user()->userType == 1)
                <div class="col-auto">
                    <button type="button"
                        class="btn btn-danger rounded-circle d-flex justify-content-center align-items-center"
                        style="width: 40px; height: 40px" data-bs-toggle="modal" data-bs-target="#deleteAtividadeModal">
                        <i class="bi bi-trash" style="font-size: 25px"></i>
                    </button>
                </div>
            @endif
        </div>

        <div class="row  align-items-center border-top border-3 border-primary-subtle border-bottom ">
            <p class="fs-5">{!! $atividade->texto !!}</p>
        </div>
        <br>
        <div>
            <h5>Questões <i class="bi bi-pencil"></i></h5>
        </div>
        <!-- Div das perguntas -->
        <form action="{{ route('atividade.responder') }}" id="quizForm" onsubmit="return validateRadioGroups()"
            method="POST" enctype="multipart/form-data">
            @csrf
            <div class="d-flex justify-content-between">
                <div class="row mb-3" style="width: 60%">
                    @isset($perguntas)
                    @foreach ($perguntas as $index => $pergunta)
                    <div class="border-bottom border-3 border-primary d-flex mb-2">
                        <h3 class="fs-5 mb-0">{{ $pergunta->titulo }}</h3>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{!! $pergunta->texto !!}</p>
                        @foreach ($pergunta->respostas as $resposta)
                            <div>
                                <input class="form-check-input" type="radio" name="respostaIndex[{{ $index }}]"
                                    value="{{ $resposta->numero_resposta }}" id="resposta_{{ $index }}_{{ $resposta->numero_resposta }}">
                                <label class="form-check-label" for="resposta_{{ $index }}_{{ $resposta->numero_resposta }}">
                                    {{ $resposta->texto }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="border-bottom border-primary-subtle border-3"></div>
                    <br>
                @endforeach
                    @endisset
                </div>

                <!-- Div lado -->
                <div class="border border-primary-subtle border-3 rounded p-3 align-self-start" style="width: 40%;">
                    @if (auth()->user()->userType == 1)

                        @foreach ($alunos as $dados)
                            <div class="border border-secondary d-flex align-items-center p-3 mb-3 rounded border-2"
                                style="width: 100%; text-align: left; color: var(--bs-body-color); background-color: var(--bs-body-bg);">
                                <div class="icon-container d-flex align-items-center justify-content-center rounded-circle me-3"
                                    style="width: 65px; height: 65px; background-color: #0b5ed7;">
                                    <i class="bi bi-person-circle" style="font-size: 30px; color: white;"></i>
                                </div>
                                <div>
                                    <!-- Acessando os dados do aluno -->
                                    <h5 class="mb-1" style="color: var(--bs-body-color);">
                                        {{ $dados['aluno']->firstName . ' ' . $dados['aluno']->lastName }}</h5>

                                    <!-- Acessando as notas do aluno para a atividade específica -->
                                    @forelse ($dados['notas'] as $nota)
                                        <p>Nota: {{ $nota->pontuacao }}</p>
                                    @empty
                                        <p>Este aluno não possui notas para esta atividade.</p>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach
                    @else
                        @foreach ($alunos as $dados)
                            @if ($dados['aluno']->id == auth()->user()->id)
                                @forelse ($dados['notas'] as $nota)
                                <div class="text-center">
                                <h3>atividade entregue</h3>
                                    <p>Nota: {{ $nota->pontuacao }}</p>
                                </div>
                                @empty
                                    <input type="hidden" name="atividade_id" value="{{ $atividade->id }}">
                                    <button type="submit" class="btn btn-primary" style="width: 100%"
                                        data-bs-toggle="modal" data-bs-target="#exampleModal">
                                        Entregar atividade
                                    </button>
                                @endforelse
                            @endif
                        @endforeach


                    @endif
                </div>
        </form>
        <script>
            function validateAnswers() {
        const questionGroups = document.querySelectorAll('input[type="radio"]'); // Seleciona todos os radio buttons
        const uniqueGroups = new Set(); // Conjunto para armazenar todos os grupos de perguntas

        // Adiciona cada grupo ao conjunto (evita repetição)
        questionGroups.forEach((radio) => {
            uniqueGroups.add(radio.name);
        });

        // Itera por cada grupo e verifica se uma resposta foi selecionada
        for (let groupName of uniqueGroups) {
            const radios = document.querySelectorAll(`input[name="${groupName}"]`);
            const isAnswered = Array.from(radios).some(radio => radio.checked);

            if (!isAnswered) {
                alert(`Por favor, selecione uma resposta para todas as perguntas.`);
                return false; // Bloqueia o envio do formulário
            }
        }

        return true; // Permite o envio se todas as perguntas tiverem uma resposta
    }

    // Associa a função ao formulário
    document.getElementById("quizForm").onsubmit = validateAnswers;

        </script>

        @if (auth()->user()->userType == 1)
            <div class="p-3 position-fixed " style="bottom: 15px; right: 10px;">
                <div class="mt-auto text-sm-end ">
                    <button type="button" class="btn btn-primary rounded-circle " style="width: 80px; height: 80px"
                        data-bs-toggle="modal" data-bs-target="#questaoModal">
                        <i class="bi bi-plus-circle-dotted heading" style="font-size: 40px"></i>
                    </button>
                </div>
            </div>
        @endif
    </div>
    <section> {{-- Modais --}}
        <!-- Modal delete atividade -->
        <div class="modal fade text-center" id="deleteAtividadeModal" tabindex="-1"
            aria-labelledby="deleteAtividadeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable border-danger-subtle">
                <div class="modal-content border-danger-subtle border-3">
                    <div class="modal-header border-danger-subtle bg-danger-subtle border-3">
                        <h1 class="modal-title fs-5 w-100 text-center" id="deleteAtividadeModalLabel">Aviso</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body bg-secondary-subtle border-3">
                        Você tem certeza de que quer deletar essa atividade? <br>
                        Se fizer isso, ela será apagada permanentemente!
                    </div>
                    <div class="modal-footer border-danger-subtle bg-danger-subtle border-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Voltar</button>
                        <a href="{{ route('atividade.delete', ['salaSlug' => $salas->salaSlug, 'idAtividade' => $atividade->id]) }}"
                            class="btn btn-danger">Deletar</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal perguntas -->
        <div class="modal fade" id="questaoModal" tabindex="-1" aria-labelledby="questaoModalLabel" aria-hidden="true">
            <div class="modal-dialog border-primary-subtle modal-dialog-scrollable modal-dialog-centered">
                <div class="modal-content border-primary-subtle border-3 text-center">
                    <div class="modal-header border-3 border-primary">
                        <h1 class="modal-title fs-5 text-center" id="questaoModalLabel">Criar questão</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('pergunta.create') }}" method="POST" enctype="multipart/form-data"
                            id="formPergunta">
                            @csrf
                            <input type="hidden" name="sala_id" value="{{ $salas->id }}">
                            <input type="hidden" name="slug" value="{{ $salas->salaSlug }}">
                            <input type="hidden" name="atividade_id" value="{{ $atividade->id }}">
                            <input type="hidden" name="atividadeTitulo" value="{{ $atividade->titulo }}">
                            <div class="input-group mb-3">
                                <span class="input-group-text">#</span>
                                <div class="form-floating">
                                    <input type="text" class="form-control" placeholder="Titulo"
                                        id="floatingInputGroup1" name="titulo">
                                    <label for="floatingInputGroup1">Título da questão</label>
                                </div>

                            </div>
                            @error('titulo')
                                <div class="error">
                                    <p class="text-danger-emphasis border border-danger rounded-pill"
                                        style="font-size: 13px;">
                                        {{ $message }}
                                    </p>
                                </div>
                            @enderror
                            <div class="input-group mb-3">
                                <span class="input-group-text">#</span>
                                <div class="form-floating">
                                    <input type="number" min="0" max="100"class="form-control"
                                        placeholder="Titulo" id="floatingInputGroup1" name="pontuacao">
                                    <label for="floatingInputGroup1">Pontuação</label>
                                </div>

                            </div>
                            <div class="form-floating " data-bs-theme="light">
                                <div id="editor" class="rounded text-light"></div>
                                <input type="hidden" name="content" id="content">
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
                                    height: 200px;
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
                                document.addEventListener('DOMContentLoaded', function() {
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
                                                }],
                                            ]
                                        }
                                    });

                                    var form = document.getElementById('formPergunta');
                                    const submitButton = document.getElementById('submitButton');
                                    form.addEventListener('submit', function(event) {
                                        var content = document.getElementById('content');
                                        submitButton.disabled = true;
                                        submitButton.innerText = "Aguarde...";
                                        content.value = quill.root.innerHTML; // Pega o conteúdo HTML do Quill
                                        console.log("Conteúdo capturado:", content
                                            .value); // Exibe o conteúdo no console para verificação
                                    });
                                });
                            </script>
                            <!-- Campo Select no topo -->
                            <div class="mb-3">
                                <label for="campoSelect" class="form-label">Selecione a resposta correta</label>
                                <select class="form-select" id="campoSelect" name="selectOption">
                                    <option value="1">Resposta 1</option>
                                    <!-- Primeira opção para o primeiro campo -->
                                </select>
                            </div>

                            <div id="input-container">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">#</span>
                                    <div class="form-floating">
                                        <input type="text" class="form-control" placeholder="Resposta"
                                            id="floatingInputGroup1" name="resposta[]">
                                        <label for="floatingInputGroup1">Resposta 1</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Campo oculto para rastrear a contagem dos campos -->
                            <input type="hidden" id="fieldCount" name="fieldCount" value="1">

                            <button type="button" class="btn btn-primary" id="add-input-btn">Adicionar
                                Campo</button>
                    </div>
                    <div class="modal-footer border-primary border-3">
                        <button class="btn btn-danger" data-bs-dismiss="modal">Voltar</button>
                        <button id="submitButton" class="btn btn-primary">Publicar</button>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const form = document.getElementById('formPergunta'); // ou o ID do seu formulário
                                const submitButton = document.getElementById('submitButton');

                                form.addEventListener('submit', function() {
                                    // Desabilita o botão de submissão para evitar múltiplos envios
                                    submitButton.disabled = true;
                                    submitButton.innerText = "Aguarde..."; // opcional, para feedback visual
                                });
                            });
                        </script>
                        </script>
                    </div>
                    </form>
                    <script>
                        let fieldCount = 1; // Variável para rastrear o número de campos

                        document.getElementById('add-input-btn').addEventListener('click', function() {
                            fieldCount++; // Incrementa o contador a cada novo campo adicionado

                            const inputContainer = document.getElementById('input-container');

                            // Criando o novo grupo de entrada com a estrutura especificada
                            const newInputGroup = document.createElement('div');
                            newInputGroup.classList.add('input-group', 'mb-3');

                            const span = document.createElement('span');
                            span.classList.add('input-group-text');
                            span.textContent = '#';

                            const formFloating = document.createElement('div');
                            formFloating.classList.add('form-floating');

                            const newInput = document.createElement('input');
                            newInput.type = 'text';
                            newInput.classList.add('form-control');
                            newInput.placeholder = 'Resposta';
                            newInput.name = 'resposta[]';

                            const newLabel = document.createElement('label');
                            newLabel.textContent = `Resposta ${fieldCount}`;

                            // Estrutura do novo campo
                            formFloating.appendChild(newInput);
                            formFloating.appendChild(newLabel);

                            newInputGroup.appendChild(span);
                            newInputGroup.appendChild(formFloating);

                            // Adicionando o novo grupo ao contêiner principal
                            inputContainer.appendChild(newInputGroup);

                            // Atualizando o campo oculto com o valor atual de fieldCount
                            document.getElementById('fieldCount').value = fieldCount;

                            // Adicionando uma nova opção ao campo Select
                            const select = document.getElementById('campoSelect');
                            const newOption = document.createElement('option');
                            newOption.value = fieldCount;
                            newOption.textContent = `Resposta ${fieldCount}`;
                            select.appendChild(newOption);
                        });
                    </script>
                </div>
            </div>
        </div>
    </section>

@endsection
