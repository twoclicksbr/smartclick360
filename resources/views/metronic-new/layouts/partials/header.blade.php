<header class="flex items-center transition-[height] shrink-0 bg-background py-4 lg:py-0 lg:h-(--header-height)"
    data-kt-sticky="true"
    data-kt-sticky-class="transition-[height] fixed z-10 top-0 left-0 right-0 shadow-xs backdrop-blur-md bg-background/70"
    data-kt-sticky-name="header" data-kt-sticky-offset="200px" id="header">
    <!-- Container -->
    <div class="kt-container-fixed flex flex-wrap gap-2 items-center lg:gap-4" id="header_container">
        
        <div class="flex items-stretch gap-10 grow">
            
            <!-- Logo -->
            @include('site.metronic.layouts.partials.headers.logo')
            <!-- Logo -->
            
            <!-- Mega Menu -->
            @include('site.metronic.layouts.partials.headers.menu')
            <!-- End of Mega Men -->
        </div>
        
        <!-- Topbar -->
        @include('site.metronic.layouts.partials.headers.topbar-header')
        <!-- End of Topbar -->
    </div>
    <!-- End of Container -->
</header>
