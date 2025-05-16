@extends('metronic.system.layouts.app')

@php

    $module = 'credential';
    $title = 'Credenciais';
    $page_title = 'Credenciais';
    $page_descrition = 'Gerencie contas de acesso ao sistema, representando organizações ou grupos.';

    $datatableColumns = [
        ['data' => 'id', 'render' => 'checkboxRender', 'orderable' => false], // Checkbox
        ['data' => 'id', 'name' => 'id'], // Id
        ['data' => 'username', 'name' => 'username'], // Username
        ['data' => 'master', 'render' => 'statusRender'], // Master
        ['data' => 'validade', 'render' => 'dateRender'], // Validade
        ['data' => 'active', 'render' => 'statusRender'], // Status
        ['data' => null, 'render' => 'actionsRender', 'orderable' => false], // Ações
    ];

@endphp

@section('content')
    <!--begin::Main-->
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Products-->
                <div class="card card-flush">
                    <!--begin::Card header-->
                    


                    <div class="card-header d-flex justify-content-start align-items-center py-5 gap-2 gap-md-5 pb-0">

                        <button type="button" class="btn btn-sm btn-light-success" data-bs-toggle="modal"
                            data-bs-target="#modalCredential">
                            <i class="ki-outline ki-plus fs-2"></i> Novo
                        </button>

                        <button type="button" class="btn btn-sm btn-light-primary" id="toggle-filter-fields">
                            <i class="ki-outline ki-magnifier fs-2"></i> Pesquisar
                        </button>

                        <button type="button" class="btn btn-sm btn-light-danger d-none" id="sc360_clear_filters">
                            <i class="ki-outline ki-abstract-11 fs-2"></i> Limpar Filtros
                        </button>

                        <button type="button" class="btn btn-sm btn-light-warning" id="sc360_print_results">
                            <i class="ki-outline ki-printer fs-2"></i> Imprimir
                        </button>

                    </div>


                    <div id="filter-fields" class="card-header align-items-center py-5 gap-2 gap-md-5 pt-0 w-100 d-none">
                        <div class="row w-100 gx-3 gy-2 align-items-center">
                            <div class="col-md-1 col-12">
                                <div class="d-flex align-items-center position-relative my-2">
                                    <i class="ki-outline ki-underlining fs-3 position-absolute ms-4"></i>
                                    <input type="text" data-kt-ecommerce-order-filter="search-id"
                                        class="form-control form-control-solid ps-12" placeholder="Id" />
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="d-flex align-items-center position-relative my-2">
                                    <i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i>
                                    <input type="text" data-kt-ecommerce-order-filter="search"
                                        class="form-control form-control-solid ps-12" placeholder="Pesquisar" />
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="true" data-placeholder="Filtrar por"
                                    data-kt-ecommerce-order-filter="date_type" id="date-type-filter" data-sc360-filter>
                                    <option></option>
                                    <option value="created_at">Data de Criação</option>
                                    <option value="updated_at" selected>Data de Alteração</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="input-group">
                                    <input class="form-control form-control-solid rounded rounded-end-0"
                                        placeholder="Data de Pesquisa" id="sc360_{{ $module }}_date_filter" />
                                    <button class="btn btn-icon btn-light" id="sc360_{{ $module }}_date_clear">
                                        <i class="ki-outline ki-cross fs-2"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-2 col-12">
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="true" data-placeholder="Status" data-sc360-filter="status">
                                    <option></option>
                                    <option value="all">Todos</option>
                                    <option value="1">Público</option>
                                    <option value="0">Inativo</option>
                                </select>
                            </div>
                        </div>

                        <div class="row w-100 gx-3 gy-2 align-items-center">
                            <div class="col-md-2 col-12">
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="true" data-placeholder="Master" data-sc360-filter="master">
                                    <option></option>
                                    <option value="all">Todos</option>
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-solid rounded rounded-end-0"
                                        id="sc360_{{ $module }}_date_validity" placeholder="Validade" />
                                    <button class="btn btn-icon btn-light"
                                        id="sc360_{{ $module }}_date_validity_clear">
                                        <i class="ki-outline ki-cross fs-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->

                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="sc360_{{ $module }}_table">
                            <thead class="">
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="text-start w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                            <input class="form-check-input" type="checkbox" data-kt-check="true"
                                                data-kt-check-target="#sc360_{{ $module }}_table .form-check-input"
                                                value="1" />
                                        </div>
                                    </th>
                                    <th class="w-10px" nowrap>Id:</th>
                                    <th class="" nowrap>Username:</th>
                                    <th class="w-15px" nowrap>Master:</th>
                                    <th class="w-15px" nowrap>Validade:</th>
                                    <th class="w-15px" nowrap>Status:</th>
                                    <th class="w-10px">Ações:</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">

                                @foreach ($credentials as $item)
                                    <tr data-created-at="{{ \Carbon\Carbon::parse($item['created_at'])->format('d/m/Y') }}"
                                        data-updated-at="{{ \Carbon\Carbon::parse($item['updated_at'])->format('d/m/Y') }}">
                                        <td class="text-start">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="{{ $item['id'] }}" />
                                            </div>
                                        </td>

                                        <td class="text-start" data-kt-ecommerce-order-filter="order_id">
                                            {{ $item['id'] }}
                                        </td>

                                        <td class="text-start">{{ $item['username'] }}</td>

                                        <td class="text-center pe-0">
                                            @if ($item['is_master'])
                                                <div class="badge badge-light-danger"><i
                                                        class="ki-solid ki-crown-2 text-danger"></i></div>
                                            @endif
                                        </td>

                                        <td class="text-start" data-order="{{ \Carbon\Carbon::parse($item['dt_expiration'])->format('d/m/Y') }}">
                                            <span
                                                class="badge badge-light-secondary">
                                                {{ \Carbon\Carbon::parse($item['dt_expiration'])->format('d/m/Y') }}
                                            </span>
                                        </td>

                                        <td class="text-start pe-0" data-order="Completed">
                                            <!--begin::Badges-->
                                            @if ($item['active'])
                                                <div class="badge badge-light-success">Público</div>
                                            @else
                                                <div class="badge badge-light-danger">Inativo</div>
                                            @endif
                                            <!--end::Badges-->
                                        </td>

                                        <td class="text-start">
                                            <a href="#"
                                                class="btn btn-sm btn-light-primary btn-flex btn-center btn-active-light-primary"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Ações
                                                <i class="ki-outline ki-down fs-5 ms-1"></i></a>
                                            <!--begin::Menu-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                data-kt-menu="true">
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="apps/ecommerce/sales/details.html"
                                                        class="menu-link px-3">View</a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="apps/ecommerce/sales/edit-order.html"
                                                        class="menu-link px-3">Edit</a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3"
                                                        data-kt-ecommerce-order-filter="delete_row">Delete</a>
                                                </div>
                                                <!--end::Menu item-->
                                            </div>
                                            <!--end::Menu-->
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>

                        <script>
                            $('#sc360_{{ $module }}_table').DataTable({
                                ajax: 'URL_DA_API',
                                columns: {!! json_encode($datatableColumns) !!}
                            });
                        </script>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Products-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Content wrapper-->
    </div>
    <!--end:::Main-->
@endsection





@section('content1')
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Content-->
            <div id="kt_app_content" class="app-content flex-column-fluid">
                <!--begin::Products-->
                <div class="card card-flush">
                    <!--begin::Card header-->

                    <div class="card-header d-flex justify-content-start align-items-center py-5 gap-2 gap-md-5 pb-0">

                        <button type="button" class="btn btn-sm btn-light-success" data-bs-toggle="modal"
                            data-bs-target="#modalCredential">
                            <i class="ki-outline ki-plus fs-2"></i> Novo
                        </button>

                        <button type="button" class="btn btn-sm btn-light-primary" id="toggle-filter-fields">
                            <i class="ki-outline ki-magnifier fs-2"></i> Pesquisar
                        </button>

                    </div>

                    <!--Start::Card Search-->

                    <div id="filter-fields" class="card-header align-items-center py-5 gap-2 gap-md-5 pt-0 w-100 d-none">

                        <div class="row w-100 gx-3 gy-2 align-items-center">

                            <div class="col-md-1 col-12">
                                <div class="d-flex align-items-center position-relative my-2">
                                    <i class="ki-outline ki-underlining fs-3 position-absolute ms-4"></i>
                                    <input type="text" data-kt-ecommerce-order-filter="search-id"
                                        class="form-control form-control-solid ps-12" placeholder="Id" />
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="d-flex align-items-center position-relative my-2">
                                    <i class="ki-outline ki-magnifier fs-3 position-absolute ms-4"></i>
                                    <input type="text" data-kt-ecommerce-order-filter="search"
                                        class="form-control form-control-solid ps-12" placeholder="Pesquisar" />
                                </div>
                            </div>

                            <div class="col-md-2 col-12">
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="true" data-placeholder="Filtrar por"
                                    data-kt-ecommerce-order-filter="date_type" id="date-type-filter" data-sc360-filter>
                                    <option></option>
                                    <option value="created_at">Data de Criação</option>
                                    <option value="updated_at" selected>Data de Alteração</option>
                                </select>
                            </div>

                            <div class="col-md-3 col-12">
                                <div class="input-group">
                                    <input class="form-control form-control-solid rounded rounded-end-0"
                                        placeholder="Data de Pesquisa" id="sc360_{{ $module }}_date_filter" />
                                    <button class="btn btn-icon btn-light" id="sc360_{{ $module }}_date_clear">
                                        <i class="ki-outline ki-cross fs-2"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-2 col-12">
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="true" data-placeholder="Status" data-sc360-filter="status">
                                    <option></option>
                                    <option value="all">Todos</option>
                                    <option value="1">Público</option>
                                    <option value="0">Inativo</option>
                                </select>
                            </div>

                        </div>

                        <div class="row w-100 gx-3 gy-2 align-items-center">

                            <div class="col-md-2 col-12">
                                <select class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="true" data-placeholder="Master" data-sc360-filter="master">
                                    <option></option>
                                    <option value="all">Todos</option>
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>


                            <div class="col-md-3 col-12">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-solid rounded rounded-end-0"
                                        id="sc360_{{ $module }}_date_validity" placeholder="Validade" />
                                    <button class="btn btn-icon btn-light"
                                        id="sc360_{{ $module }}_date_validity_clear">
                                        <i class="ki-outline ki-cross fs-2"></i>
                                    </button>
                                </div>
                            </div>











                        </div>

                    </div>


                    <!--End::Card Search-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->

                        <table id="sc360_{{ $module }}_table"
                            class="table align-middle table-row-dashed fs-6 gy-6">
                            <thead>
                                <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                    <th class="text-center align-middle" style="">
                                        <div class="form-check form-check-sm form-check-custom form-check-solid"><input
                                                class="form-check-input" type="checkbox" id="checkAll" /></div>
                                    </th>
                                    <th style="width: 5%">ID:</th>
                                    <th style="width: ">Usuário:</th>
                                    <th style="width: 10%">Master:</th>
                                    <th style="width: 10%">Validade:</th>
                                    <th style="width: 10%">Status:</th>
                                    <th style="width: 5%">Ações:</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($credentials as $item)
                                    <tr data-created-at="{{ \Carbon\Carbon::parse($item['created_at'])->format('d/m/Y') }}"
                                        data-updated-at="{{ \Carbon\Carbon::parse($item['updated_at'])->format('d/m/Y') }}">
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input row-checkbox" type="checkbox"
                                                    value="{{ $item['id'] }}" />
                                            </div>
                                        </td>
                                        <td>{{ $item['id'] }}</td>
                                        <td>{{ $item['username'] }}</td>
                                        <td>
                                            @if ($item['is_master'])
                                                <div class="badge badge-light-danger"><i
                                                        class="ki-solid ki-crown-2 text-danger"></i></div>
                                            @endif
                                        </td>
                                        <td class="text-muted">{{-- <span class="badge badge-light-success">
                                                {{ \Carbon\Carbon::parse($item['dt_expiration'])->setTimezone('America/Sao_Paulo')->format('d/m/Y') }}
                                            </span> --}} @php
                                            $exp = \Carbon\Carbon::parse($item['dt_expiration'])
                                                ->setTimezone('America/Sao_Paulo')
                                                ->startOfDay();
                                            $limit = \Carbon\Carbon::parse($item['dt_limit_access'])
                                                ->setTimezone('America/Sao_Paulo')
                                                ->startOfDay();
                                            $hoje = \Carbon\Carbon::now('America/Sao_Paulo')->startOfDay();

                                            if ($hoje->greaterThanOrEqualTo($limit)) {
                                                $classe = 'info';
                                            } elseif ($exp->greaterThanOrEqualTo($hoje)) {
                                                $classe = 'danger';
                                            } elseif ($exp->greaterThanOrEqualTo($hoje->copy()->subDays(7))) {
                                                $classe = 'warning';
                                            } elseif ($exp->greaterThan($hoje->copy()->subDays(30))) {
                                                $classe = 'success';
                                            } else {
                                                $classe = 'secondary';
                                            }
                                        @endphp <span
                                                class="badge badge-light-secondary">{{-- {{ $item['dt_expiration']->format('d/m/Y') }} --}}
                                                {{ \Carbon\Carbon::parse($item['dt_expiration'])->format('d/m/Y') }}
                                            </span></td>
                                        <td>
                                            @if ($item['active'])
                                                <div class="badge badge-light-success">Público</div>
                                            @else
                                                <div class="badge badge-light-danger">Inativo</div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown"><button
                                                    class="btn btn-sm btn-light-primary btn-active-light-primary dropdown-toggle"
                                                    type="button" data-bs-toggle="dropdown" aria-expanded="false"><i
                                                        class="ki-duotone ki-abstract-28"><span
                                                            class="path1"></span><span class="path2"></span></i>Ações
                                                </button>
                                                <ul class="dropdown-menu menu-rounded">
                                                    <li><a class="dropdown-item text-warning" href="#"><i
                                                                class="ki-duotone ki-notepad-edit me-2 text-warning"><span
                                                                    class="path1"></span><span
                                                                    class="path2"></span></i>Editar </a></li>
                                                    <li><a class="dropdown-item text-danger" href="#"><i
                                                                class="ki-duotone ki-trash-square me-2 text-danger"><span
                                                                    class="path1"></span><span
                                                                    class="path2"></span><span
                                                                    class="path3"></span><span
                                                                    class="path4"></span></i>Deletar </a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        < !--end::Table-->
                    </div>
                    < !--end::Card body-->
                </div>
                < !--end::Products-->
            </div>
            < !--end::Content-->
        </div>
        < !--end::Content wrapper-->
    </div>
@endsection
