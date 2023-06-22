@extends('layouts.guest')
@section('content')
<style>
    .logo-img {
        width: 100px;
        min-height: 100px;
        border-radius: 50%;
        object-fit: cover;
        transition: transform 0.4s;
        display: block;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 15px;
    }
</style>
<div class="login">
    <img src="{{ url('img/fundo_login_register.jpg') }}" alt="imagem de login" class="login__img">
    <form class="login__form" method="POST" action="{{ route('login') }}">
        @error('password')
        <span class="m-8 " style="color:red;">
            {{ $message }}
        </span>
        @enderror
        @csrf
        <!-- <img src="{{ url('img/1.png') }}" alt="imagem de login" class="logo-img"> -->
        <img class="logo-img" src="{{ url('img/8.png') }}" alt="Foto do Usuário">
        <!-- <h1 class="login__title">Login</h1> -->
        <!-- Campos de entrada para email e senha -->
        <div class="login__content">
            <div class="login__box">
                <i class="ri-user-line login__icon"></i>

                <div class="login__box-input">
                    <input id="email" class="login__input @error('email') is-invalid @enderror" type="email" name="email" :value="old('email')" required autofocus autocomplete="username">
                    <label for="" class="login__label">Email</label>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="login__box">
                <i class="ri-lock-2-line login__icon"></i>
                <div class="login__box-input">
                    <input id="login-pass" class="login__input @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="current-password">
                    <label for="" class="login__label">Senha</label>
                    <i class="ri-eye-off-line login__eye" id="login-eye"></i>
                </div>
            </div>

        </div>
        <button type="submit" class="login__button">Entrar</button>

        <p class="login__register">
            Não tem uma conta? <a href="{{ route('register') }}">Cadastre-se</a>
        </p>
    </form>
</div>
<script>
    /* MOSTRAR/ESCONDER - SENHA */
    const mostrarEsconderSenha = (loginPass, loginEye) => {
        const input = document.getElementById(loginPass),
            iconEye = document.getElementById(loginEye)
        iconEye.addEventListener('click', () => {
            // Mudar senha para texto
            if (input.type === 'password') {
                // Mudar para texto
                input.type = 'text'

                // Mudar ícone
                iconEye.classList.add('ri-eye-line')
                iconEye.classList.remove('ri-eye-off-line')
            } else {
                // Mudar para senha
                input.type = 'password'

                // Mudar ícone
                iconEye.classList.remove('ri-eye-line')
                iconEye.classList.add('ri-eye-off-line')
            }
        })
    }
    mostrarEsconderSenha('login-pass', 'login-eye')
</script>
@endsection