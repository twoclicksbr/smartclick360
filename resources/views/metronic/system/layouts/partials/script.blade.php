<!--begin::Javascript-->
<script>
    var hostUrl = "/assets/metronic/";
</script>

<!--begin::Global Javascript Bundle-->
<script src="/assets/metronic/plugins/global/plugins.bundle.js"></script>
<script src="/assets/metronic/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->

<!--begin::Vendors Javascript-->
<script src="/assets/metronic/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
<script src="/assets/metronic/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Vendors Javascript-->

<!--begin::Custom Javascript-->
<script src="/assets/metronic/js/widgets.bundle.js"></script>
<script src="/assets/metronic/js/custom/widgets.js"></script>
<script src="/assets/metronic/js/custom/apps/chat/chat.js"></script>
<script src="/assets/metronic/js/custom/utilities/modals/upgrade-plan.js"></script>
<script src="/assets/metronic/js/custom/utilities/modals/new-target.js"></script>
<script src="/assets/metronic/js/custom/utilities/modals/create-app.js"></script>
<script src="/assets/metronic/js/custom/utilities/modals/users-search.js"></script>
<script src="/assets/metronic/js/custom/apps/ecommerce/sales/listing.js"></script>
<!--end::Custom Javascript-->

<script src="{{ asset('/assets/metronic/plugins/custom/flatpickr/flatpickr.bundle.js') }}"></script>
<script src="{{ asset('/assets/metronic/plugins/custom/flatpickr/pt.js') }}"></script>

<script></script>




<!--begin::Javascript-->

<script>
    let table;
    let searchInput;
    let searchIdInput;
    let validityInput;
    let validityClearBtn;

    $(function() {
        const filterKey = `sc360_filters_{{ $module }}`;

        function initDataTable() {
            if ($.fn.DataTable.isDataTable('#sc360_{{ $module }}_table')) {
                $('#sc360_{{ $module }}_table').DataTable().destroy();
            }

            table = $('#sc360_{{ $module }}_table').DataTable({
                paging: true,
                ordering: true,
                searching: true,
                info: false,
                language: {
                    url: "/assets/metronic/plugins/custom/datatables/lang/pt-BR.json"
                },
                lengthMenu: [1, 10, 25, 50, 100],
                pageLength: 10,
                order: [
                    [1, 'desc']
                ],
                columnDefs: [{
                        targets: 0,
                        orderable: false,
                        searchable: false,
                        className: 'sorting_disabled text-start'
                    },
                    {
                        targets: -1,
                        orderable: false
                    }
                ]
            });

            // 👇 aqui adiciona:
            table.on('preDraw.dt', function() {
                const info = table.page.info();
                if (info.recordsDisplay !== info.recordsTotal) {
                    table.page('first');
                }
            });
        }

        function expandIdList(input) {
            const result = [];
            input.split(',').forEach(part => {
                const trimmed = part.trim();
                if (trimmed.includes('-')) {
                    const [start, end] = trimmed.split('-').map(Number);
                    if (!isNaN(start) && !isNaN(end)) {
                        for (let i = start; i <= end; i++) result.push(i.toString());
                    }
                } else if (trimmed) {
                    result.push(trimmed);
                }
            });
            return result;
        }

        function applyFilters() {
            console.log('applyFilters executado');

            saveFiltersToStorage();

            const search = searchInput?.value.toLowerCase() || '';
            const searchId = searchIdInput?.value || '';
            const ids = expandIdList(searchId);
            const status = document.getElementById('sc360_{{ $module }}_status')?.value || '';
            const master = $('[data-sc360-filter="master"]').val() || '';
            const validity = validityInput?.value || '';
            const dateType = $('#date-type-filter').val() || 'updated_at';
            const dateRange = $('#sc360_{{ $module }}_date_filter').val() || '';

            $('#sc360_{{ $module }}_table tbody tr').each(function() {
                const cells = $(this).find('td');
                const id = cells.eq(1).text().trim();
                const statusText = cells.eq(5).text().replace(/\s+/g, '').toLowerCase();
                const masterHtml = cells.eq(3).html().replace(/\s+/g, '').toLowerCase();
                const validityText = cells.eq(4).text().trim();
                const content = $(this).text().toLowerCase();

                let matchesValidity = true;
                let matchesDateType = true;

                if (dateRange) {
                    let [startStr, endStr] = dateRange.includes(' até ') ? dateRange.split(' até ') : [
                        dateRange, dateRange
                    ];
                    const [sd, sm, sy] = startStr.split('/');
                    const [ed, em, ey] = endStr.split('/');
                    const startDate = new Date(`${sy}-${sm}-${sd}T00:00:00`);
                    const endDate = new Date(`${ey}-${em}-${ed}T23:59:59`);
                    const raw = dateType === 'created_at' ? $(this).data('created-at') : $(this).data(
                        'updated-at');
                    const [cd, cm, cy] = (raw || '').split('/');
                    const cellDate = new Date(`${cy}-${cm}-${cd}T12:00:00`);
                    matchesDateType = !isNaN(cellDate) && cellDate >= startDate && cellDate <= endDate;
                }

                if (validity) {
                    let [startStr, endStr] = validity.includes(' até ') ? validity.split(' até ') : [
                        validity, validity
                    ];
                    const [sd, sm, sy] = startStr.split('/');
                    const [ed, em, ey] = endStr.split('/');
                    const [cd, cm, cy] = validityText.split('/');
                    const startDate = new Date(`${sy}-${sm}-${sd}`);
                    const endDate = new Date(`${ey}-${em}-${ed}`);
                    const cellDate = new Date(`${cy}-${cm}-${cd}`);
                    matchesValidity = cellDate >= startDate && cellDate <= endDate;
                }

                const match =
                    (!search || content.includes(search)) &&
                    (!searchId || ids.includes(id)) &&
                    (!status || ((status === '1' && statusText.includes('público')) || (status ===
                        '0' && statusText.includes('inativo')))) &&
                    (!master || ((master === '1' && masterHtml.includes('ki-crown-2')) || (master ===
                        '0' && !masterHtml.includes('ki-crown-2')))) &&
                    matchesValidity &&
                    matchesDateType;

                $(this).toggle(match);
            });

            // controla visibilidade do botão de limpar
            if (hasActiveFilters()) {
                $('#sc360_clear_filters').removeClass('d-none');
            } else {
                $('#sc360_clear_filters').addClass('d-none');
            }
        }

        function saveFiltersToStorage() {
            const data = {
                search: searchInput?.value || '',
                searchId: searchIdInput?.value || '',
                status: document.getElementById('sc360_{{ $module }}_status')?.value || '',
                master: $('[data-sc360-filter="master"]').val() || '',
                dateType: $('#date-type-filter').val() || '',
                dateRange: $('#sc360_{{ $module }}_date_filter').val() || '',
                validity: $('#sc360_{{ $module }}_date_validity').val() || ''
            };
            localStorage.setItem(filterKey, JSON.stringify(data));
        }

        function loadFiltersFromStorage() {
            const saved = localStorage.getItem(filterKey);
            if (!saved) return;
            const data = JSON.parse(saved);

            $('#date-type-filter').val(data.dateType || '').trigger('change');
            $('#sc360_{{ $module }}_date_filter').val(data.dateRange || '');
            $('#sc360_{{ $module }}_date_validity').val(data.validity || '');
            $('[data-sc360-filter="status"]').val(data.status || '').trigger('change');
            $('#sc360_{{ $module }}_status').val(data.status || '').trigger('change.select2');
            searchInput.value = data.search || '';
            searchIdInput.value = data.searchId || '';
        }

        function hasActiveFilters() {
            let hasFilter = false;
            document.querySelectorAll('#filter-fields input, #filter-fields select').forEach(el => {
                const value = el.value?.trim();
                if (value && value !== '' && value !== 'all') {
                    hasFilter = true;
                }
            });
            return hasFilter;
        }

        // Inicializações
        initDataTable();
        searchInput = document.getElementById('sc360_{{ $module }}_search');
        searchIdInput = document.getElementById('sc360_{{ $module }}_search_id');
        validityInput = document.getElementById('sc360_{{ $module }}_date_validity');
        validityClearBtn = document.getElementById('sc360_{{ $module }}_date_validity_clear');

        // filtros select
        $('[data-sc360-filter]').each(function() {
            const $select = $(this);
            const placeholder = $select.attr('data-placeholder') || 'Filtro';
            $select.select2({
                placeholder,
                minimumResultsForSearch: Infinity
            }).on('select2:select', function() {
                if ($select.val() === 'all') {
                    $select.val('').trigger('change.select2');
                }
                applyFilters();
            });
        });

        // flatpickr - data principal
        flatpickr(`#sc360_{{ $module }}_date_filter`, {
            locale: flatpickr.l10ns.pt,
            dateFormat: "d/m/Y",
            mode: "range",
            allowInput: true,
            onChange: function() {
                applyFilters();
            }
        });

        $('#sc360_{{ $module }}_date_clear').on('click', function() {
            $('#sc360_{{ $module }}_date_filter').val('');
            applyFilters();
        });

        // flatpickr - validade
        flatpickr(`#sc360_{{ $module }}_date_validity`, {
            locale: flatpickr.l10ns.pt,
            dateFormat: "d/m/Y",
            mode: "range",
            allowInput: true
        });

        validityClearBtn?.addEventListener('click', function() {
            validityInput._flatpickr?.clear();
            applyFilters();
        });

        // eventos de digitação
        searchInput?.addEventListener('input', applyFilters);
        searchIdInput?.addEventListener('input', applyFilters);
        validityInput?.addEventListener('input', applyFilters);

        // checkAll
        $(document).on('change', '#checkAll', function() {
            $('.row-checkbox').prop('checked', this.checked);
        });

        // toggle filtros visuais
        const toggleBtn = document.getElementById('toggle-filter-fields');
        const filterDiv = document.getElementById('filter-fields');
        const isVisible = localStorage.getItem('sc360_filter_visible') === 'true';
        filterDiv?.classList.toggle('d-none', !isVisible);

        toggleBtn?.addEventListener('click', function() {
            const nowVisible = filterDiv.classList.toggle('d-none') === false;
            localStorage.setItem('sc360_filter_visible', nowVisible);
        });

        // botão: limpar filtros
        $('#sc360_clear_filters').on('click', function() {
            localStorage.removeItem(filterKey);

            $('#filter-fields').find('input, select').each(function() {
                if (this.tagName === 'SELECT') {
                    $(this).val('').trigger('change.select2');
                } else {
                    $(this).val('');
                }
            });

            applyFilters();
        });

        // executa
        loadFiltersFromStorage();
        applyFilters();
    });

    $('#sc360_print_results').on('click', function() {
        const table = document.querySelector('#sc360_{{ $module }}_table');
        if (!table) return;

        const clonedTable = table.cloneNode(true);

        // remove 1ª coluna (checkbox) e última (ações)
        const ths = clonedTable.querySelectorAll('thead th');
        if (ths.length >= 2) {
            ths[0]?.remove(); // checkbox
            ths[ths.length - 1]?.remove(); // ações
        }

        clonedTable.querySelectorAll('tbody tr').forEach(row => {
            if (row.style.display === 'none') {
                row.remove(); // remove linhas ocultas
            } else {
                row.querySelectorAll('td')[0]?.remove(); // remove checkbox
                row.querySelectorAll('td')[row.cells.length - 1]?.remove(); // remove ações
            }
        });

        const printWindow = window.open('', '', 'width=1000,height=700');
        printWindow.document.write(`
        <html>
            <head>
                <title>Impressão</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; }
                    table { border-collapse: collapse; width: 100%; }
                    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
                    th { background-color: #f2f2f2; }
                </style>
            </head>
            <body>
                <h2>Resultado da Pesquisa</h2>
                ${clonedTable.outerHTML}
            </body>
        </html>
    `);
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
    });
</script>
