<div class="row w-100 gx-3 gy-2 align-items-center">
    <div class="col-md-1 col-12">
        <div class="d-flex align-items-center position-relative my-2">
            <i class="ki-outline ki-underlining fs-3 position-absolute ms-4"></i>
            <input type="text" id="sc360_{{ $module }}_search_id" class="form-control form-control-solid ps-12"
                placeholder="Id" />
        </div>
    </div>
    <div class="col-md-4 col-12">
        <div class="d-flex align-items-center position-relative my-2">
            <i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i>
            <input type="text" id="sc360_{{ $module }}_search" class="form-control form-control-solid ps-12"
                placeholder="Pesquisar" />
        </div>
    </div>
    <div class="col-md-2 col-12">
        <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
            data-placeholder="Filtrar por" id="sc360_{{ $module }}_date_type" data-sc360-filter="date_type"
            data-sc360-filter>
            <option></option>
            <option value="created_at">Data de Criação</option>
            <option value="updated_at" selected>Data de Alteração</option>
        </select>
    </div>
    <div class="col-md-3 col-12">
        <div class="input-group">
            <input class="form-control form-control-solid rounded rounded-end-0" placeholder="Data de Pesquisa"
                id="sc360_{{ $module }}_date_filter" />
            <button class="btn btn-icon btn-light" id="sc360_{{ $module }}_date_clear">
                <i class="ki-outline ki-cross fs-2"></i>
            </button>
        </div>
    </div>
    <div class="col-md-2 col-12">
        <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
            data-placeholder="Status" id="sc360_{{ $module }}_status" data-sc360-filter="status">
            <option></option>
            <option value="all">Todos</option>
            <option value="1">Público</option>
            <option value="0">Inativo</option>
        </select>
    </div>
</div>
