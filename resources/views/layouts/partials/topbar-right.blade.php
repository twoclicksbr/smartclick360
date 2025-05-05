<div class="d-flex align-items-center">

    <div class="dropdown d-md-none topbar-head-dropdown header-item">
        <button type="button" class="btn btn-icon btn-topbar material-shadow-none btn-ghost-secondary rounded-circle"
            id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="bx bx-search fs-22"></i>
        </button>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">
            <form class="p-3">
                <div class="form-group m-0">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search ..."
                            aria-label="Recipient's username">
                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- @include('layouts.partials.topbar.language') --}}
    @include('layouts.partials.topbar.apps')
    {{-- @include('layouts.partials.topbar.cart') --}}
    {{-- @include('layouts.partials.topbar.fullscreen') --}}
    @include('layouts.partials.topbar.theme')
    {{-- @include('layouts.partials.topbar.notifications') --}}
    @include('layouts.partials.topbar.user')
</div>
