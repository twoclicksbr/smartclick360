@extends('metronic.auth.layouts.html')

@php
    $title = 'Login';
@endphp

@section('head')
    @include('metronic.auth.layouts.partials.head')
@endsection

@section('content')
    <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-10">

        <!--begin::Heading-->
        <div class="text-center mb-11">

            <!--begin::Title-->
            <h1 class="text-gray-900 fw-bolder mb-3">Bem vindo de volta!</h1>
            <p class="text-muted">Efetue login para entrar no <b>SmartClick360</b>.</p>
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
        <form class="form w-100" method="POST" action="{{ route('login.post') }}">
            @csrf

            <!--begin::Input group=-->
            <div class="fv-row mb-8">
                <!--begin::Email-->
                <input type="text" placeholder="E-mail" name="email" autocomplete="off"
                    class="form-control bg-transparent" />
                <!--end::Email-->
            </div>
            <!--end::Input group=-->
            <div class="fv-row mb-3">
                <!--begin::Password-->
                <input type="password" placeholder="Senha" name="password" autocomplete="off"
                    class="form-control bg-transparent" />
                <!--end::Password-->
            </div>
            <!--end::Input group=-->
            <!--begin::Wrapper-->
            <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
                <div></div>
                <!--begin::Link-->
                <a href="#" class="link-primary">Esqueceu
                    sua Senha?</a>
                <!--end::Link-->
            </div>
            <!--end::Wrapper-->
            <!--begin::Submit button-->
            <div class="d-grid mb-10">
                <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                    <!--begin::Indicator label-->
                    <span class="indicator-label">Entrar</span>
                    <!--end::Indicator label-->
                    <!--begin::Indicator progress-->
                    <span class="indicator-progress">Aguarde por favor...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    <!--end::Indicator progress-->
                </button>
            </div>
            <!--end::Submit button-->
            <!--begin::Sign up-->
            <div class="text-gray-500 text-center fw-semibold fs-6">Ainda não faz parte do time?
                <a href="#" class="link-primary">Cadastre-se</a>
            </div>
            <!--end::Sign up-->
        </form>
        <!--end::Form-->
    </div>
@endsection

@section('script')
    @include('metronic.auth.layouts.partials.script')
@endsection
