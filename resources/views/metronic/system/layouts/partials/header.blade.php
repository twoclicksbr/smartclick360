<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: false, lg: true}"
    data-kt-sticky-name="app-header-sticky" data-kt-sticky-offset="{default: false, lg: '300px'}">
    <!--begin::Header container-->
    <div class="app-container container-xxl d-flex align-items-stretch justify-content-between"
        id="kt_app_header_container">
        <!--begin::Header mobile toggle-->
        <div class="d-flex align-items-center d-lg-none ms-n2 me-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_header_menu_toggle">
                <i class="ki-outline ki-abstract-14 fs-2"></i>
            </div>
        </div>
        <!--end::Header mobile toggle-->
        
        <!--begin::Logo-->
        @include('metronic.system.layouts.partials.headers.logo')
        <!--end::Logo-->
        
        <!--begin::Header wrapper-->
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
            
            <!--begin::Menu wrapper-->
            @include('metronic.system.layouts.partials.headers.menu')
            <!--end::Menu wrapper-->
            
            <!--begin::Navbar-->
            <div class="app-navbar flex-shrink-0">
                
                <!--begin::Notifications-->
                {{-- @include('metronic.system.layouts.partials.headers.utility-notifications') --}}
                <!--end::Notifications-->
                
                <!--begin::Quick links-->
                {{-- @include('metronic.system.layouts.partials.headers.utility-links') --}}
                <!--end::Quick links-->
                
                <!--begin::Chat-->
                {{-- @include('metronic.system.layouts.partials.headers.utility-chat') --}}
                <!--end::Chat-->
                
                <!--begin::User menu-->
                @include('metronic.system.layouts.partials.headers.utility-user')
                <!--end::User menu-->


            </div>
            <!--end::Navbar-->
        </div>
        <!--end::Header wrapper-->
    </div>
    <!--end::Header container-->
</div>
