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
        margin-top: 1px;
        /* margin-bottom: 50px; */
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 15px;
        
    }

</style>
<div class="login">
    <img src="{{ url('img/fundo_login_register.jpg') }}" alt="imagem de login" class="login__img">
    <form class="login__form" method="POST" action="{{ route('register') }}">
        @csrf
        <img id="margin" class="logo-img" src="{{ url('img/8.png') }}" alt="Foto do Usuário">
        <div class="login__content">
            <div class="login__box">
                <i class="ri-user-line login__icon"></i>
                <div class="login__box-input">
                    <input id="name" class="login__input @error('name') is-invalid @enderror" type="name" name="name" :value="old('name')" required autofocus autocomplete="username">
                    <label for="" class="login__label">Nome</label>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
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
                    <input id="login-pass" class="login__input @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="new-password" />
                    <label for="" class="login__label">Senha</label>
                    <i class="ri-eye-off-line login__eye" id="login-eye"></i>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="login__box">
                <i class="ri-lock-2-line login__icon"></i>

                <div class="login__box-input">
                    <input id="login-pass" class="login__input" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <label for="" class="login__label">Confirmar Senha</label>
                    <!-- <i class="ri-eye-off-line login__eye" id="login-eye"></i> -->
                </div>
            </div>
        </div>
        <button type="submit" class="login__button">Cadastrar</button>
        <p class="login__register">
            Já possui uma conta? <a href="{{ route('login') }}">Entrar</a>
        </p>
    </form>
</div>
<script>
    /* MOSTRAR/ESCONDER - SENHA */
    const mostrarEsconderSenha = (loginPass, loginEye) => {
        const input = document.getElementById(loginPass),
            iconEye = document.getElementById(loginEye)

        iconEye.addEventListener('click', () => {
            if (input.type === 'password') {
                input.type = 'text'
                iconEye.classList.add('ri-eye-line')
                iconEye.classList.remove('ri-eye-off-line')
            } else {
                input.type = 'password'
                iconEye.classList.remove('ri-eye-line')
                iconEye.classList.add('ri-eye-off-line')
            }
        })
    }
    mostrarEsconderSenha('login-pass', 'login-eye')
</script>
@endsection