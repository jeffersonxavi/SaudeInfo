<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <!-- Or for RTL support -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />

    <link rel="stylesheet" type="text/css" href="{{ url('css/style.css') }}">
    <link rel="stylesheet" href="{{ url('css/app.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" />
    @stack('css')
</head>

<body class="font-sans antialiased">
    <!-- Barra lateral -->
    <aside id="toggle-sidebar" class="sidebar">
        <header class="sidebar-header">
            <img class="logo-img" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSlS4NN2iQeZb2Iybsk7vGsK8SKdVUYdRtuM02kppYdmI3iw7u_22sgsVeiyGZznmMFeSw&usqp=CAU" alt="Foto do Usuário">

        </header>
        <nav>
            <a href="{{ route('dashboard') }}">
                <i class="material-icons">dashboard</i>
                <span class="sidebar-text">Home</span>
            </a>
            @can('admin')
            <a href="#submenu1" class="has-submenu">
                <i class="material-icons">menu</i>
                <span class="sidebar-text">Cadastro</span>
            </a>
            <ul id="submenu1" class="submenu">
                <li><a href="{{ route('pacientes.index') }}"><i class="fas fa-user fa-xs"></i> Pacientes</a></li>
                <li><a href="{{ route('profissionais.index') }}"><i class="fas fa-user-md fa-xs"></i> Profissional</a></li>
                <li><a href="{{ route('agendas.index') }}"><i class="far fa-calendar-alt fa-xs"></i> Agenda Profissional</a></li>
                <li><a href="{{ route('tipos-consultas.index') }}"><i class="fas fa-clipboard-list fa-xs"></i> Tipos de Consultas</a></li>
                <li><a href="{{ route('consultas.index') }}"><i class="far fa-calendar-check fa-xs"></i> Consultas</a></li>
                <li><a href="{{ route('avisos.index') }}"><i class="fas fa-bell fa-xs"></i> Avisos</a></li>
            </ul>
            @elsecan('profissional')
            <a href="{{ route('consultas.index') }}">
                <i class="material-icons">assignment</i>
                <span class="sidebar-text">Consultas</span>
            </a>
            <a href="{{ route('agendas.index') }}">
                <i class="material-icons">calendar_today</i>
                <span class="sidebar-text">Agenda</span>
            </a>
            <a href="{{ route('avisos.index') }}">
                <i class="material-icons">notifications</i>
                <span class="sidebar-text">Avisos</span>
            </a>
            <a href="{{ route('profissionais.edit', auth()->user()->profissional->id)}} ">
                <i class="material-icons">settings</i>
                <span class="sidebar-text">Gerenciamento</span>
            </a>
            @elsecan('user')
            <a href="{{ route('consultas.index') }}">
                <i class="material-icons">assignment</i>
                <span class="sidebar-text">Consultas</span>
            </a>
            <a href="{{ route('pacientes.edit', auth()->user()->paciente->id)}} ">
                <i class="material-icons">settings</i>
                <span class="sidebar-text">Gerenciamento</span>
            </a>
            @endcan
            <a href="{{ route('profile.edit') }}">
                <i class="material-icons">person</i>
                <span class="sidebar-text">Perfil</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="cursor-pointer">
                    <i class="material-icons clickable-icon">logout</i>
                    <span class="sidebar-text clickable-text">Sair</span>
                </a>
            </form>
        </nav>
    </aside>

    <!-- Conteúdo principal -->
    <main class="main">
        @yield('content')
        @if(isset($slot))
        {{ $slot }}
        @endif
    </main>
    <!-- JavaScript para controlar a barra lateral -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="{{ url('js/sidebar.js') }}"></script>
    <script src="{{ url('js/app.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.css" />
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.js"></script> -->
</body>

</html>