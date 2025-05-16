<div id="kt_app_toolbar" class="app-toolbar py-6">
    <!--begin::Toolbar container-->
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex align-items-start">
        <!--begin::Toolbar container-->
        {{-- <div class="d-flex flex-column flex-row-fluid mt-20">

            <!--begin::Breadcrumb wrapper-->
            @include('metronic.system.layouts.partials.topbar.breadcrumb')
            <!--end::Breadcrumb wrapper=-->

            <!--begin::Page-Title wrapper=-->
            @include('metronic.system.layouts.partials.topbar.page-title')
            <!--end::Page-Title wrapper=-->

        </div> --}}

        <div class="d-none d-lg-flex flex-column flex-row-fluid mt-5">
            @include('metronic.system.layouts.partials.topbar.breadcrumb')
            @include('metronic.system.layouts.partials.topbar.page-title')
        </div>
        

        <div class="d-block d-lg-none flex-column flex-row-fluid mt-20">
            @include('metronic.system.layouts.partials.topbar.breadcrumb')
            @include('metronic.system.layouts.partials.topbar.page-title')
        </div>
        <!--end::Toolbar container=-->
    </div>
    <!--end::Toolbar container-->
</div>
