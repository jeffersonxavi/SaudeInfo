<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <!-- Barra lateral -->
        <aside id="toggle-sidebar" class="sidebar">
            <nav>
                <a href="{{ route('dashboard') }}">
                    <i class="material-icons">dashboard</i>
                    <span class="sidebar-text">Home</span>
                </a>
                <a href="#submenu1" class="has-submenu">
                <i class="material-icons">menu</i>
                <span class="sidebar-text">Submenu</span>
                </a>
                <ul id="submenu1" class="submenu ">
                    <li><a href="#">Item 1</a></li>
                    <li><a href="#">Item 2</a></li>
                    <li><a href="#">Item 3</a></li>
                </ul>

                <a href="#submenu2" class="has-submenu">
                    <i class="material-icons">person</i>
                    <span class="sidebar-text">Perfil</span>
                </a>
                <ul id="submenu2" class="submenu ">
                <li><a href="{{ route('profile.edit') }}">Configurações</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="material-icons">logout</i>
                                <span class="sidebar-text">Sair</span>
                            </a>
                        </form>
                    </li>
                </ul>
                <a href="{{ route('profile.edit') }}">
                    <i class="material-icons">tag</i>
                    <span class="sidebar-text">Outros</span>
                </a>
                <a href="{{ route('profile.edit') }}">
                    <i class="material-icons">person</i>
                    <span class="sidebar-text">Perfil</span>
                </a>
                <a href="#!">
                    <i class="material-icons">dashboard</i>
                    <span class="sidebar-text">Dashboard</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="material-icons">logout</i>
                        <span class="sidebar-text">Sair</span>
                    </a>
                </form>
            </nav>
        </aside>
        <!-- Conteúdo principal -->
        <main class="main">
            @yield('content')
        </main>
        
        <!-- JavaScript para controlar a barra lateral -->
        <script src="js/sidebar.js"></script>
</script>
    </body>
</html>
