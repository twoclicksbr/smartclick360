@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div class="bg-overlay"></div>
        <div class="auth-page-content overflow-hidden pt-lg-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card overflow-hidden card-bg-fill galaxy-border-none">
                            <div class="row g-0">
                                {{-- Esquerda com logo e quotes --}}
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4 auth-one-bg h-100">
                                        <div class="bg-overlay"></div>
                                        <div class="position-relative h-100 d-flex flex-column">
                                            <div class="mb-4">
                                                <a href="/" class="d-block">
                                                    <img src="{{ asset('assets/images/logo-light.png') }}" alt="logo"
                                                        height="18">
                                                </a>
                                            </div>
                                            <div class="mt-auto">
                                                <div class="mb-3">
                                                    <i class="ri-double-quotes-l display-4 text-success"></i>
                                                </div>
                                                <div id="qoutescarouselIndicators" class="carousel slide"
                                                    data-bs-ride="carousel">
                                                    <div class="carousel-inner text-center text-white-50 pb-5">
                                                        <div class="carousel-item active">
                                                            <p class="fs-15 fst-italic">"Bem-vindo ao SmartClick360. <br>
                                                                Comece agora a sua gestão eficiente."</p>
                                                        </div>
                                                        <div class="carousel-item">
                                                            <p class="fs-15 fst-italic">"Flexível. Poderoso. <br> Tudo em um
                                                                só lugar."</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Direita com formulário --}}
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">
                                        <h5 class="text-primary">Bem vindo!</h5>
                                        <p class="text-muted">Acesse o SmartClick360.</p>

                                        @if ($errors->has('login'))
                                            <div class="alert alert-danger">{{ $errors->first('login') }}</div>
                                        @endif

                                        <form method="POST" action="{{ route('auth.login') }}">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="email" class="form-label">Usuário</label>
                                                <input type="text" class="form-control" id="email" name="email"
                                                    required autofocus>
                                            </div>

                                            <div class="mb-3">
                                                <label for="password-input" class="form-label">Senha</label>
                                                <div class="position-relative auth-pass-inputgroup mb-3">
                                                    <input type="password" class="form-control pe-5 password-input"
                                                        name="password" id="password-input" required>
                                                    <button
                                                        class="btn btn-link position-absolute end-0 top-0 text-muted password-addon"
                                                        type="button" id="password-addon">
                                                        <i class="ri-eye-fill align-middle"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="remember">
                                                <label class="form-check-label" for="remember">Lembrar-me</label>
                                            </div>

                                            <div class="mt-4">
                                                <button class="btn btn-success w-100" type="submit">Entrar</button>
                                            </div>
                                        </form>

                                        <div class="mt-5 text-center">
                                            <p class="mb-0">Não tem uma conta? <a href="#"
                                                    class="fw-semibold text-primary text-decoration-underline">Confira os
                                                    Planos</a></p>
                                        </div>
                                    </div>
                                </div>
                                {{-- Fim coluna direita --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer galaxy-border-none">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <p class="mb-0">
                            &copy;
                            <script>
                                document.write(new Date().getFullYear())
                            </script> SmartClick360
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
@endsection
