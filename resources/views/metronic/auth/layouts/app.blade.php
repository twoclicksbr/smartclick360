<div class="d-flex flex-column flex-root" id="kt_app_root">
    <!--begin::Page bg image-->
    <style>
        body {
            background-image: url('{{ asset('assets/metronic/media/auth/bg4.jpg') }}');
        }

        [data-bs-theme="dark"] body {
            background-image: url('{{ asset('assets/metronic/media/auth/bg4-dark.jpg') }}');
        }
    </style>
    <!--end::Page bg image-->
    <!--begin::Authentication - Sign-in -->
    <div class="d-flex flex-column flex-column-fluid flex-lg-row">


        <!--begin::Aside-->
        <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
            <!--begin::Aside-->
            <div class="d-flex flex-center flex-lg-start flex-column">
                <!--begin::Logo-->
                <a href="index.html" class="mb-7">
                    <img alt="Logo" class="h-100px" src="{{ asset('assets/metronic/media/logos/logo-light-2x.png') }}" />
                </a>
                <!--end::Logo-->
                <!--begin::Title-->
                <h2 class="text-white fw-normal m-0">
                    Gestão Inteligente com Visão 360°
                </h2>
                <!--end::Title-->
            </div>
            <!--begin::Aside-->
        </div>
        <!--begin::Aside-->


        <!--begin::Body-->
        <div
            class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
            <!--begin::Card-->
            <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                <!--begin::Wrapper-->
                
                @yield('content')

                <!--end::Wrapper-->
                <!--begin::Footer-->
                <div class="d-flex flex-stack px-lg-10">
                    <!--begin::Languages-->

                    <!--end::Languages-->
                    <!--begin::Links-->
                    <div class="d-flex fw-semibold text-primary fs-base gap-5">

                        <a href="#" class="btn btn-light-primary btn-sm me-2 mb-2">
                            <i class="ki-solid ki-document fs-3"></i>
                            Termos
                        </a>

                        <a href="#" class="btn btn-light-primary btn-sm me-2 mb-2" target="_blank">
                            <i class="ki-solid ki-abstract-13 fs-3"></i>
                            Planos
                        </a>

                        <a href="#" class="btn btn-light-primary btn-sm me-2 mb-2" target="_blank">
                            <i class="ki-solid ki-phone fs-3"></i>
                            Contato
                        </a>

                    </div>
                    <!--end::Links-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Authentication - Sign-in-->
</div>
