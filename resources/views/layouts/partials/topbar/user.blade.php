<div class="dropdown ms-sm-3 header-item topbar-user">
    <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <span class="d-flex align-items-center">
            <img class="rounded-circle header-profile-user" src="../assets/images/users/avatar-1.jpg" alt="Header Avatar">
            <span class="text-start ms-xl-2">
                <span
                    class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ explode(' ', session('name'))[0] }}</span>
                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">{{ session('username') }}</span>
            </span>
        </span>
    </button>
    <div class="dropdown-menu dropdown-menu-end">
        <!-- item-->
        <h6 class="dropdown-header">{{ session('email') }}</h6>
        <a class="dropdown-item" href="#">
            <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i>
            <span class="align-middle">Perfil</span>
        </a>
        <a class="dropdown-item" href="#">
            <i class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i>
            <span class="align-middle">Mensagens</span>
        </a>
        <a class="dropdown-item" href="#">
            <i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i>
            <span class="align-middle">Tarefas</span>
        </a>
        <a class="dropdown-item" href="#">
            <i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i>
            <span class="align-middle">Ajuda</span>
        </a>
        <div class="dropdown-divider"></div>
        {{-- <a class="dropdown-item" href="#">
            <i class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i>
            <span class="align-middle">Balance: <b>$5971.67</b></span>
        </a> --}}
        <a class="dropdown-item" href="#">
            {{-- <span class="badge bg-success-subtle text-success mt-1 float-end">New</span> --}}
            <i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i>
            <span class="align-middle">Configurações</span>
        </a>
        <a class="dropdown-item" href="{{ route('auth.lock') }}">
            <i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i>
            <span class="align-middle">Bloquear</span>
        </a>
        <a class="dropdown-item" href="{{ route('logout') }}">
            <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
            <span class="align-middle" data-key="t-logout">Desconectar</span>
        </a>
    </div>
</div>
