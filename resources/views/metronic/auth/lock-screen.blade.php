@extends('metronic.auth.layouts.html')

@php
    $title = 'Bloqueado';
@endphp

@section('head')
    @include('metronic.auth.layouts.partials.head')
@endsection

@section('content')
    <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-10">

        <!--begin::Heading-->
        <div class="text-center mb-11">

            <!--begin::Title-->
            <h1 class="text-gray-900 fw-bolder mb-3">Sessão bloqueada.</h1>
            <p class="text-muted">Informe sua senha para continuar no <b>SmartClick360</b>.</p>
            <!--end::Title-->

        </div>
        <!--begin::Heading-->

        @if (session('error_title') && session('error_message'))
            <!--begin::Alert-->
            <div class="alert alert-dismissible bg-light-danger d-flex flex-column flex-sm-row p-5 mb-10">
                <!--begin::Icon-->
                <i class="ki-duotone ki-message-text-2 fs-2hx text-danger me-4 mb-5 mb-sm-0"><span class="path1"></span><span
                        class="path2"></span><span class="path3"></span></i>
                <!--end::Icon-->

                <!--begin::Wrapper-->
                <div class="d-flex flex-column pe-0 pe-sm-10">
                    <!--begin::Title-->
                    <h4 class="fw-semibold">{{ session('error_title') }}</h4>
                    <!--end::Title-->

                    <!--begin::Content-->
                    <span>{{ session('error_message') }}</span>
                    <!--end::Content-->
                </div>
                <!--end::Wrapper-->

                <!--begin::Close-->
                <button type="button"
                    class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
                    data-bs-dismiss="alert">
                    <i class="ki-duotone ki-cross fs-1 text-danger"><span class="path1"></span><span
                            class="path2"></span></i>
                </button>
                <!--end::Close-->
            </div>
            <!--end::Alert-->
        @endif



        <!--begin::Form-->
        <form class="form w-100" method="POST" action="{{ route('unlock') }}">
            @csrf

            <input type="hidden" name="email" value="{{ session('auth_email') }}">

            <h2 class="fv-row mb-3 fs-2">
                {{ session('auth_firstName') }}
            </h2>

            <div class="fv-row mb-3">
                <input type="email" placeholder="E-mail" autocomplete="off" value="{{ session('auth_email') }}"
                    class="form-control bg-transparent" required readonly />
            </div>

            <div class="fv-row mb-3">
                <input type="password" placeholder="Senha" name="password" autocomplete="off"
                    class="form-control bg-transparent" required />
            </div>

            <div class="d-grid mb-10">
                <button type="submit" class="btn btn-primary">Desbloquear</button>
            </div>

            <div class="text-gray-500 text-center fw-semibold fs-6">Não sou: {{ session('auth_firstName') }}. 
                <a href="{{ route('auth.logout') }}" class="link-primary">Desconectar</a>
            </div>
        </form>

        <!--end::Form-->


    </div>
@endsection

@section('script')
    @include('metronic.auth.layouts.partials.script')
@endsection
