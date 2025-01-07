@extends('layout')
@section('titulo', 'Salas de aula')
@section('conteudo')

    @if (auth()->user()->userType == 1)
        <div>
            <div class="p-2">
                <div class="card border-primary-subtle border-3" style="height: 92vh">
                    <div class="card-header bg-secondary-subtle text-center border-primary border-3">
                        <h4>Suas salas de aula, professor(a) {{ auth()->user()->firstName }}!</h4>
                    </div>
                    <div class="card-body text-center d-flex flex-column">
                        @if ($salas->count() == 0)
                            <h5>Não há salas de aula registradas</h5>
                        @else
                            <div class="container-fluid text-center">
                                <div class="row row-cols-1 row-cols-lg-4 g-3 g-lg-4">

                                    @foreach ($salas as $sala)
                                        @if ($sala->criador_id == auth()->user()->id)
                                            <div class="col">
                                                <div class="p-5">
                                                    <div class="card border-primary-subtle border-3" style="width: 20rem;">
                                                        <img src="storage/public/img/salas/{{ $sala->image }}"
                                                            class="card-img-top" alt="..." style=" height: 13rem">
                                                        <div class="card-body">
                                                            <h5 class="card-title fs-5">{{ $sala->name }}</h5>
                                                            <p class="card-text fs-6">
                                                                {{ Str::limit($sala->descricao, 40, '...') }}</p>
                                                            <a href="{{ route('sala.sala', $sala->salaSlug) }}"
                                                                class="btn btn-primary">Visualizar</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex flex-column">
                        <div class="d-flex justify-content-around ">{{ $salas->links() }}</div>
                        <div class="p-3 position-fixed " style="bottom: 15px; right: 10px;">
                            <div class="mt-auto text-sm-end ">
                                <button type="button" class="btn btn-primary rounded-circle "
                                    style="width: 80px; height: 80px" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    <i class="bi bi-plus-circle-dotted heading" style="font-size: 40px"></i>
                                </button>
                            </div>


                        </div>
                    </div>
                </div>
            </div>


        </div>


        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog border-success modal-dialog-scrollable">
                <div class="modal-content border-primary-subtle text-center">
                    <div class="modal-header border-primary">
                        <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Cria sala de aula</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formCriarSala" action="{{ route('sala.create') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="criador_id" value="{{ auth()->user()->id }}">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">#</span>
                                <input type="text" class="form-control" placeholder="Nome da sala de aula"
                                    aria-label="ENome da sala de aula" aria-describedby="basic-addon1" name="name">
                            </div>
                            @error('name')
                                <div class="error ">
                                    <p class="text-danger-emphasis border border-danger rounded-pill" style="font-size: 13px;">{{ $message }}</p>
                                </div>
                            @enderror
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" name="descricao"
                                    style="height: 200px"></textarea>
                                <label for="floatingTextarea2">Descrição</label>
                            </div><br>
                            @error('descricao')
                                <div class="error">
                                    <p class="text-danger-emphasis border border-danger rounded-pill" style="font-size: 13px;">{{ $message }}</p>
                                </div>
                            @enderror
                            <div class="input-group mb-3">
                                <label class="input-group-text" for="inputGroupFile01">Imagem</label>
                                <input type="file" class="form-control" id="inputGroupFile01" name="image"
                                    accept="image/*" required>
                            </div>
                    </div>
                    <div class="modal-footer border-primary">
                        <button class="btn btn-danger" data-bs-dismiss="modal">Voltar</button>
                        <button id="submitButton" class="btn btn-primary">Criar</button>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const form = document.getElementById('formCriarSala'); // ou o ID do seu formulário
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
    @else
        <div>
            <div class="p-2">
                <div class="card border-primary-subtle border-3" style="height: 92vh">
                    <div class="card-header bg-secondary-subtle text-center border-primary border-3">
                        <h4>Suas salas de aula, {{ auth()->user()->firstName }}!</h4>
                    </div>
                    <div class="card-body text-center d-flex flex-column">
                        @if ($salas->count() == 0)
                            <h5>Não há salas de aula registradas</h5>
                        @else
                            <div class="container-fluid text-center">
                                <div class="row row-cols-1 row-cols-lg-4 g-3 g-lg-4">
                                    @foreach ($salas as $sala)
                                        @foreach ($alunoSalas as $item)
                                            @if ($sala->id == $item->id_salas)
                                                <div class="col">
                                                    <div class="p-5">
                                                        <div class="card border-success" style="width: 20rem;">
                                                            <img src="storage/public/img/salas/{{ $sala->image }}"
                                                                class="card-img-top" alt="..."
                                                                style=" height: 13rem">
                                                            <div class="card-body">
                                                                <h5 class="card-title fs-5">{{ $sala->name }}</h5>
                                                                <p class="card-text fs-6">
                                                                    {{ Str::limit($sala->descricao, 20, '...') }}
                                                                </p>
                                                                <a href="{{ route('sala.sala', $sala->salaSlug) }}"
                                                                    class="btn btn-primary">Visualizar</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex flex-column">
                        <div class="d-flex justify-content-around ">{{ $salas->links() }}</div>
                        <div class="p-3 position-fixed " style="bottom: 15px; right: 10px;">
                            <div class="mt-auto text-sm-end ">
                                <button type="button" class="btn btn-success rounded-circle "
                                    style="width: 80px; height: 80px" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal">
                                    <i class="bi bi-plus-circle-dotted heading" style="font-size: 40px"></i>
                                </button>
                            </div>


                        </div>
                    </div>
                </div>
            </div>


        </div>


        <!-- Modal -->
        <div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered border-success">
                <div class="modal-content text-center border-success">
                    <div class="modal-header border-danger">
                        <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Entrar em uma sala de aula</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body ">
                        <form action="{{ route('sala.join') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">#</span>
                                <input type="text" class="form-control" placeholder="Código da sala"
                                    aria-label="Código da sala" aria-describedby="basic-addon1" name="codigoSala">
                            </div>

                    </div>
                    <div class="modal-footer border-danger">
                        <button class="btn btn-danger" data-bs-dismiss="modal">Voltar</button>
                        <button class="btn btn-success">Criar</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>


    @endif
@endsection
