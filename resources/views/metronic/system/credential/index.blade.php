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

                    @include('metronic.system.layouts.partials.btn-actions')

                    <div id="filter-fields" class="card-header align-items-center py-5 gap-2 gap-md-5 pt-0 w-100 d-none">

                        @include('metronic.system.layouts.partials.filter-base')

                        <div class="row w-100 gx-3 gy-2 align-items-center">
                            <div class="col-md-2 col-12">
                                <select class="form-select form-select-solid" data-control="select2" data-hide-search="true"
                                    data-placeholder="Master" data-sc360-filter="master">
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
                                                <input class="form-check-input" type="checkbox"
                                                    value="{{ $item['id'] }}" />
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

                                        <td class="text-start"
                                            data-order="{{ \Carbon\Carbon::parse($item['dt_expiration'])->format('d/m/Y') }}">
                                            <span class="badge badge-light-secondary">
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

    @include("metronic.system.$module.modal")
@endsection
