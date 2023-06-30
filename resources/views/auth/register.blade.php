@extends('layouts.guest')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css" />
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

    .login__row {
        display: flex;
        align-items: center;
    }

    .select2 {
        flex-grow: 1;
        margin-right: 10px;
        height: 0%;
    }

    #chave {
        height: 34px;
    }

    .error-message {
        color: red;
        font-size: 14px;
        margin-top: 5px;
        align-items: center;
        /* Estilos adicionais personalizados */
        background-color: #ffcccc;
        border: 1px solid #ff9999;
        padding: 5px;
        border-radius: 4px;
        text-align: center;
    }
    .copy {
                    color: #888;
                    font-size: 14px;
                    text-align: center;
                    margin-top: 10px;
                }
</style>

<div class="login">
    <img src="{{ url('img/fundo_login_register.jpg') }}" alt="imagem de login" class="login__img">
    <form class="login__form" method="POST" action="{{ route('register') }}">
        @csrf
        <!-- <img id="margin" class="logo-img" src="{{ url('img/8.png') }}" alt="Foto do Usuário"> -->
        <div class="login__content">
            <div class="login__box">
                <i class="ri-user-line login__icon"></i>
                <div class="login__box-input">
                    <input id="name" class="login__input @error('name') is-invalid @enderror" type="name" name="name" value="{{old('name')}}" required autofocus autocomplete="username">
                    <label for="" class="login__label">Nome</label>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="login__box">
                <i class="ri-user-line login__icon"></i>

                <div class="login__box-input">
                    <input id="email" class="login__input @error('email') is-invalid @enderror" type="email" name="email" value="{{old('email')}}" required autofocus autocomplete="username">
                    <label for="" class="login__label">Email</label>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="login__box">
                <i class="ri-lock-2-line login__icon"></i>

                <div class="login__box-input">
                    <input id="login-pass" maxlength="15" class="login__input @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="new-password" />
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
                    <input id="login-pass" maxlength="15" class="login__input" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <label for="" class="login__label">Confirmar Senha</label>
                </div>
            </div>
            <div class="login__row">
                <!-- <div class="login__box"> -->
                <div class="login__box-input">
                    <select id="role" class="login__input select2" style="background-color: rgba(245, 245, 245, 0.9); color: #333; width: 170px;" name="role" required>
                        <option value="" disabled selected>SELECIONE</option>
                        <option value="admin">ADMINISTRADOR</option>
                        <option value="profissional">PROFISSIONAL</option>
                    </select>
                    <label for="role" class="login__label">Tipo de Usuário:</label>
                    <!-- </div> -->
                </div>

                <div class="login__box">
                    <i class="ri-key-line login__icon"></i>
                    <div class="login__box-input">
                        <input id="chave" class="login__input" type="chave" name="chave" :value="old('chave')" required autofocus autocomplete="userchave">
                        <label for="chave" class="login__label">Chave:</label>
                    </div>
                </div>

            </div>
            @error('chave')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="login__button">Cadastrar</button>
        <p class="login__register">
            Já possui uma conta? <a href="{{ route('login') }}">Entrar</a>
        </p>
        <p class="login__register copy">&copy;  Saúde Tech - 2023</p>
    </form>
</div>
<script>
    $('#role').select2({
        theme: "bootstrap-5",
    });
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