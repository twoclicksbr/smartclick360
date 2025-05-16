<!DOCTYPE html>
<html lang="pt-BR">

<head>
    @yield('head')
</head>

<body
    class="flex flex-col min-h-screen antialiased text-base text-foreground bg-background [--header-height-default:95px] data-kt-[sticky-header=on]:[--header-height:60px] [--header-height:var(--header-height-default)] [--header-height-mobile:70px]">

    <!-- Theme Mode -->
    <script>
        const defaultThemeMode = 'light';
        let themeMode;

        if (document.documentElement) {
            if (localStorage.getItem('kt-theme')) {
                themeMode = localStorage.getItem('kt-theme');
            } else if (document.documentElement.hasAttribute('data-kt-theme-mode')) {
                themeMode = document.documentElement.getAttribute('data-kt-theme-mode');
            } else {
                themeMode = defaultThemeMode;
            }

            if (themeMode === 'system') {
                themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }

            document.documentElement.classList.add(themeMode);
        }
    </script>
    <!-- End of Theme Mode -->

    <div class="flex flex-col in-data-kt-[sticky-header=on]:pt-[--header-height-default]">
        @yield('header')
        @yield('topbar-page')

        <main class="flex-grow">
            @yield('content')
        </main>

        @yield('footer')
    </div>

    @yield('modal')
    @yield('scripts')

</body>

</html>
