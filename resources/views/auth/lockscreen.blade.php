@extends('layouts.auth')

@section('title', 'Desbloquear')

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
                                        <h5 class="text-primary">Olá, {{ explode(' ', session('name'))[0] }} 👋</h5>
                                        <p class="text-muted">Digite sua senha para continuar no SmartClick360.</p>

                                        @if (session('error'))
                                            <div class="alert-dismissible alert-danger mt-2">
                                                {{ session('error') }}
                                            </div>
                                        @endif

                                        @if (session('success'))
                                            <!-- Success Alert -->
                                            <div class="alert alert-success alert-dismissible fade show material-shadow"
                                                role="alert">
                                                {{ session('success') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        @endif


                                        <div class="mt-4">

                                            @if ($errors->has('error'))
                                                <!-- Danger Alert -->
                                                <div class="alert alert-danger alert-dismissible fade show material-shadow"
                                                    role="alert">
                                                    {{ $errors->first('error') }}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                        aria-label="Close"></button>
                                                </div>
                                            @endif

                                            <form method="POST" action="{{ route('auth.unlock') }}">
                                                @csrf
                                                <input type="hidden" name="email" value="{{ session('email') }}">

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

                                                <div class="mb-2 mt-4">
                                                    <button type="submit"
                                                        class="btn btn-success w-100">Desbloquear</button>
                                                </div>
                                            </form>

                                            <!-- end form -->
                                        </div>

                                        <div class="mt-5 text-center">
                                            <p class="mb-0">Não sou {{ explode(' ', session('name'))[0] }}! <a
                                                    href="{{ route('logout') }}"
                                                    class="fw-semibold text-primary text-decoration-underline">Desconectar</a>
                                            </p>
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
