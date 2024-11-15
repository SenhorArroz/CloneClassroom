<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('titulo')</title>
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<header>
  <nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="{{ session('tema') }}">
    <div class="container-fluid">
      
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link @if ($viewName == 'home')
              active
            @endif" aria-current="page" href="{{route('site.home')}}">Home</a>
          </li>
          @auth
            <li class="nav-item">
              <a class="nav-link @if ($viewName == 'salasdeaula')
                active
              @endif" href="{{route('site.salasdeaula')}}">Salas de aula</a>
            </li>
          @endauth
        </ul>
        @auth
        <a href="{{ route('tema.trocar') }}" class="link-body-emphasis link-underline link-underline-opacity-0 fs-5">
          @if (session('tema') == 'dark')
          <i class="bi bi-brightness-low" style="font-size: 30px"></i>
          @else
          <i class="bi bi-brightness-low-fill" style="font-size: 30px"></i>
          @endif
      </a>
          <ul class="navbar-nav  mb-2 mb-lg-0 " style="width: 10%">
            
            <li class="nav-item dropdown" >
              <a class="nav-link dropdown-toggle @if ($viewName == 'perfil')
              active
            @endif" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Olá, {{auth()->user()->firstName}}!
              </a>
              <ul class="dropdown-menu ">
                <li><a class="dropdown-item" href="{{ route('site.perfil', auth()->user()->userSlug ) }}">Perfil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('login.logout') }}">Logout</a></li>
              </ul>
            </li>
          </ul>
        @else
        <ul class="navbar-nav  mb-2 mb-lg-0 " >
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login.loginView') }}">Login/Registrar</a>
          </li>
        </ul>
        
        @endauth
      </div>
    </div>
  </nav>
  
</header>
<body data-bs-theme="{{ session('tema') }}">
  @php
    @endphp
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  @yield('conteudo')
</body>
</html>