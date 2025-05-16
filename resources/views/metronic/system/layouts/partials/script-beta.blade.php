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

<script>
    // document.querySelectorAll('[id^="sc360_"],[id$="_date_filter"]').forEach(function(el) {
    //     flatpickr(el, {
    //         locale: flatpickr.l10ns.pt,
    //         dateFormat: "d/m/Y",
    //         mode: "range"
    //     });
    // });

    flatpickr(`#sc360_{{ $module }}_date_validity`, {
        locale: flatpickr.l10ns.pt,
        dateFormat: "d/m/Y",
        mode: "range",
        allowInput: true
    });

    document.getElementById(`sc360_{{ $module }}_date_validity_clear`)?.addEventListener('click', function() {
        document.getElementById(`sc360_{{ $module }}_date_validity`)._flatpickr?.clear();
    });
</script>

<link rel="stylesheet" href="{{ asset('assets/metronic/css/custom.css') }}">

<script>
    $(function() {
        if ($.fn.DataTable.isDataTable('#sc360_{{ $module }}_table')) {
            $('#sc360_{{ $module }}_table').DataTable().destroy();
        }
        
        const table = $('#sc360_{{ $module }}_table').DataTable({
            paging: true,
            ordering: true,
            searching: true,
            columnDefs: [{
                targets: 0,
                orderable: false,
                searchable: false,
                className: 'text-start'
            }]
        });

        $('#date-type-filter').select2({
            minimumResultsForSearch: Infinity
        });

        const key = `date_type_filter_{{ $module }}`;
        const saved = localStorage.getItem(key) || 'updated_at';
        $('#date-type-filter').val(saved).trigger('change');

        $('#date-type-filter').on('change', function() {
            const selected = $(this).val();
            const key = `date_type_filter_{{ $module }}`;

            localStorage.setItem(key, selected);

            // Atualiza o data-field usado pelo flatpickr
            const $input = $('input[data-sc360-filter-date]');
            $input.attr('data-field', selected);

            // Atualiza os registros filtrados
            applyFilters();
        });

        $(document).on('change', '#checkAll', function() {
            $('.row-checkbox').prop('checked', this.checked);
        });

        // Monitorar mudanças via Flatpickr
        $('#date-start, #date-end').flatpickr({
            dateFormat: "d/m/Y",
            onChange: function() {
                console.log('🔥 Data alterada via flatpickr');
                applyFilters();
            }
        });

        function applyFilters() {
            console.log('applyFilters executado');

            const search = searchInput?.value.toLowerCase() || '';
            const searchId = searchIdInput?.value || '';
            const ids = expandIdList(searchId);
            const status = document.querySelector('[data-sc360-filter="status"]')?.value || '';
            const master = document.querySelector('[data-sc360-filter="master"]')?.value || '';
            const validity = validityInput?.value || '';
            const table = document.querySelector('#sc360_{{ $module }}_table');

            const dateType = document.getElementById('date-type-filter')?.value || 'updated_at';
            const dateRange = document.querySelector('[id^="sc360_"][id$="_date_filter"]')?.value || '';

            table?.querySelectorAll('tbody tr').forEach(tr => {
                const cells = tr.querySelectorAll('td');
                const id = cells[1]?.innerText.trim() || '';
                const statusText = cells[5]?.textContent.replace(/\s+/g, '').toLowerCase() || '';
                const masterHtml = cells[3]?.innerHTML.replace(/\s+/g, '').toLowerCase() || '';
                const validityText = cells[4]?.textContent.trim() || '';
                const content = tr.textContent.toLowerCase();

                let matchesValidity = true;
                let matchesDateType = true;

                if (dateRange) {
                    let startStr, endStr;
                    if (dateRange.includes(' até ')) {
                        [startStr, endStr] = dateRange.split(' até ');
                    } else {
                        startStr = endStr = dateRange;
                    }

                    const [startDay, startMonth, startYear] = startStr.split('/');
                    const [endDay, endMonth, endYear] = endStr.split('/');
                    const startDate = new Date(`${startYear}-${startMonth}-${startDay}T00:00:00`);
                    const endDate = new Date(`${endYear}-${endMonth}-${endDay}T23:59:59`);

                    const raw = dateType === 'created_at' ?
                        tr.getAttribute('data-created-at') :
                        tr.getAttribute('data-updated-at');

                    const [cellDay, cellMonth, cellYear] = (raw || '').split('/');
                    const cellDate = new Date(`${cellYear}-${cellMonth}-${cellDay}T12:00:00`);

                    matchesDateType = !isNaN(cellDate) && cellDate >= startDate && cellDate <= endDate;
                }

                if (validity) {
                    let startStr, endStr;
                    if (validity.includes(' até ')) {
                        [startStr, endStr] = validity.split(' até ');
                    } else {
                        startStr = endStr = validity;
                    }

                    const [startDay, startMonth, startYear] = startStr.split('/');
                    const [endDay, endMonth, endYear] = endStr.split('/');
                    const startDate = new Date(`${startYear}-${startMonth}-${startDay}`);
                    const endDate = new Date(`${endYear}-${endMonth}-${endDay}`);
                    const [cellDay, cellMonth, cellYear] = validityText.split('/');
                    const cellDate = new Date(`${cellYear}-${cellMonth}-${cellDay}`);

                    matchesValidity = cellDate >= startDate && cellDate <= endDate;
                }

                const match =
                    (!search || content.includes(search)) &&
                    (!searchId || ids.includes(id)) &&
                    (!status || (
                        (status === '1' && statusText.includes('público')) ||
                        (status === '0' && statusText.includes('inativo'))
                    )) &&
                    (!master || (
                        (master === '1' && masterHtml.includes('ki-crown-2')) ||
                        (master === '0' && !masterHtml.includes('ki-crown-2'))
                    )) &&
                    matchesValidity &&
                    matchesDateType;

                tr.style.display = match ? '' : 'none';
            });
        }

        $(function() {
            const table = $('#sc360_{{ $module }}_table').DataTable({
                paging: true,
                ordering: true,
                searching: true,
                columnDefs: [{
                    targets: 0,
                    orderable: false,
                    searchable: false,
                    className: 'text-start'
                }]
            });

            $('#date-type-filter').select2({
                minimumResultsForSearch: Infinity
            });

            const key = `date_type_filter_{{ $module }}`;
            const saved = localStorage.getItem(key) || 'updated_at';
            $('#date-type-filter').val(saved).trigger('change');

            $('#date-type-filter').on('change', function() {
                const selected = $(this).val();
                localStorage.setItem(key, selected);
                $('input[data-sc360-filter-date]').attr('data-field', selected);
                applyFilters();
            });

            $('#date-start, #date-end').flatpickr({
                dateFormat: "d/m/Y",
                onChange: function() {
                    console.log('🔥 Data alterada via flatpickr');
                    applyFilters();
                }
            });

            $(document).on('change', '#checkAll', function() {
                $('.row-checkbox').prop('checked', this.checked);
            });

            applyFilters();
        });

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

        // Executar filtro ao iniciar página
        applyFilters();
    });
</script>

<script>
    document.getElementById('dt_expiration')?.addEventListener('change', function() {
        const expirationDate = new Date(this.value);
        if (!isNaN(expirationDate)) {
            expirationDate.setDate(expirationDate.getDate() + 7);
            const formatted = expirationDate.toISOString().split('T')[0];
            document.getElementById('dt_limit_access').value = formatted;
        }
    });
</script>

<script>
    document.getElementById('switch_active')?.addEventListener('change', function() {
        const label = document.getElementById('label_active');
        label.textContent = this.checked ? 'Público' : 'Inativo';
    });
</script>

<script>
    const toggleBtn = document.getElementById('toggle-filter-fields');
    const filterDiv = document.getElementById('filter-fields');
    const isVisible = localStorage.getItem('sc360_filter_visible') === 'true';

    filterDiv.classList.toggle('d-none', !isVisible);

    toggleBtn?.addEventListener('click', function() {
        const nowVisible = filterDiv.classList.toggle('d-none') === false;
        localStorage.setItem('sc360_filter_visible', nowVisible);
    });
</script>


<script>
    function waitForElement(id, callback) {
        const el = document.getElementById(id);
        if (el) return callback(el);
        const interval = setInterval(() => {
            const el = document.getElementById(id);
            if (el) {
                clearInterval(interval);
                callback(el);
            }
        }, 100);
    }

    document.addEventListener('DOMContentLoaded', function() {
        waitForElement('sc360_credential_date_filter', function(filterDateInput) {
            const filterDateClearBtn = document.getElementById('sc360_credential_date_clear');
            const dateTypeSelect = document.getElementById('date-type-filter');

            // Inicializa flatpickr
            const picker = flatpickr(filterDateInput, {
                locale: flatpickr.l10ns.pt,
                dateFormat: "d/m/Y",
                mode: "range",
                allowInput: true,
                onChange: function() {
                    console.log('🔥 Data alterada via flatpickr');
                    applyFilters();
                }
            });

            // Função de limpeza robusta
            const clearDate = () => {
                console.log('🧹 Limpando campo de data');
                if (picker) {
                    picker.clear();
                }

                // força limpeza total por segurança
                filterDateInput.value = '';
                filterDateInput.dispatchEvent(new Event('input', {
                    bubbles: true
                }));
                filterDateInput.dispatchEvent(new Event('change', {
                    bubbles: true
                }));

                applyFilters();
            };

            // Botão de limpar
            filterDateClearBtn?.addEventListener('click', clearDate);

            // Ao trocar o tipo de data
            dateTypeSelect?.addEventListener('change', function() {
                console.log('🔄 Tipo de data trocado:', this.value);
                clearDate();
            });
        });
    });
</script>



<script>
    $('[data-sc360-filter]').each(function() {
        const $select = $(this);
        const placeholder = $select.attr('data-placeholder') || 'Filtro';

        $select.select2({
            placeholder: placeholder,
            minimumResultsForSearch: Infinity
        });

        $select.on('select2:select', function() {
            if ($select.val() === 'all') {
                $select.val('').trigger('change.select2');
            }
            applyFilters();
        });
    });

    const searchInput = document.querySelector('[data-kt-ecommerce-order-filter="search"]');
    const searchIdInput = document.querySelector('[data-kt-ecommerce-order-filter="search-id"]');
    const validityInput = document.getElementById('sc360_{{ $module }}_date_validity');
    const validityClearBtn = document.getElementById('sc360_{{ $module }}_date_validity_clear');

    searchInput?.addEventListener('input', applyFilters);
    searchIdInput?.addEventListener('input', applyFilters);
    validityInput?.addEventListener('input', applyFilters);
    validityClearBtn?.addEventListener('click', function() {
        validityInput.value = '';
        applyFilters();
    });



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

        const search = searchInput?.value.toLowerCase() || '';
        const searchId = searchIdInput?.value || '';
        const ids = expandIdList(searchId);
        const status = document.querySelector('[data-sc360-filter="status"]')?.value || '';
        const master = document.querySelector('[data-sc360-filter="master"]')?.value || '';
        const validity = validityInput?.value || '';
        const table = document.querySelector('#sc360_{{ $module }}_table');

        const dateType = document.getElementById('date-type-filter')?.value || 'updated_at';
        const dateRange = document.querySelector('[id^="sc360_"][id$="_date_filter"]')?.value || '';


        table?.querySelectorAll('tbody tr').forEach(tr => {
            const cells = tr.querySelectorAll('td');
            const id = cells[1]?.innerText.trim() || '';
            const statusText = cells[5]?.textContent.replace(/\s+/g, '').toLowerCase() || '';
            const masterHtml = cells[3]?.innerHTML.replace(/\s+/g, '').toLowerCase() || '';
            const validityText = cells[4]?.textContent.trim() || '';
            const content = tr.textContent.toLowerCase();

            let matchesValidity = true;
            let matchesDateType = true;

            if (dateRange) {
                let startStr, endStr;

                if (dateRange.includes(' até ')) {
                    [startStr, endStr] = dateRange.split(' até ');
                } else {
                    startStr = endStr = dateRange;
                }

                const [startDay, startMonth, startYear] = startStr.split('/');
                const [endDay, endMonth, endYear] = endStr.split('/');
                const startDate = new Date(`${startYear}-${startMonth}-${startDay}T00:00:00`);
                const endDate = new Date(`${endYear}-${endMonth}-${endDay}T23:59:59`);

                const dateType = document.getElementById('date-type-filter')?.value || 'updated_at';
                const raw = dateType === 'created_at' ?
                    tr.getAttribute('data-created-at') :
                    tr.getAttribute('data-updated-at');

                const [cellDay, cellMonth, cellYear] = (raw || '').split('/');
                const cellDate = new Date(`${cellYear}-${cellMonth}-${cellDay}T12:00:00`);

                console.log('Filtro de data', {
                    raw,
                    dateType,
                    cellDate,
                    startDate,
                    endDate
                });

                if (!isNaN(cellDate) && !isNaN(startDate) && !isNaN(endDate)) {
                    matchesDateType = cellDate >= startDate && cellDate <= endDate;
                } else {
                    matchesDateType = true;
                }
            }


            if (validity) {
                let startStr, endStr;

                if (validity.includes(' até ')) {
                    [startStr, endStr] = validity.split(' até ');
                } else {
                    startStr = endStr = validity;
                }

                const [startDay, startMonth, startYear] = startStr.split('/');
                const [endDay, endMonth, endYear] = endStr.split('/');
                const startDate = new Date(`${startYear}-${startMonth}-${startDay}`);
                const endDate = new Date(`${endYear}-${endMonth}-${endDay}`);

                const [cellDay, cellMonth, cellYear] = validityText.split('/');
                const cellDate = new Date(`${cellYear}-${cellMonth}-${cellDay}`);

                matchesValidity = cellDate.getTime() >= startDate.getTime() &&
                    cellDate.getTime() <= endDate.getTime();
            }



            // function applyFilters() {
            //     console.log('applyFilters executado');

            //     const tipo = $('#date-type-filter').val();
            //     const inicioStr = $('#date-start').val();
            //     const fimStr = $('#date-end').val();

            //     const inicio = moment(inicioStr, 'DD/MM/YYYY').startOf('day');
            //     const fim = moment(fimStr, 'DD/MM/YYYY').endOf('day');

            //     $('#sc360_{{ $module }}_table tbody tr').each(function() {
            //         const raw = $(this).data(tipo);
            //         const cellDate = moment(raw, 'DD/MM/YYYY');

            //         console.log('Filtro de data', {
            //             raw,
            //             dateType: tipo,
            //             cellDate,
            //             startDate: inicio.toDate(),
            //             endDate: fim.toDate()
            //         });

            //         const visivel = cellDate.isSameOrAfter(inicio) && cellDate.isSameOrBefore(fim);
            //         $(this).toggle(visivel);
            //     });

            //     const table = $('#sc360_{{ $module }}_table').DataTable();
            //     table.draw(false);
            // }







            const match =
                (!search || content.includes(search)) &&
                (!searchId || ids.includes(id)) &&
                (!status || (
                    (status === '1' && statusText.includes('público')) ||
                    (status === '0' && statusText.includes('inativo'))
                )) &&
                (!master || (
                    (master === '1' && masterHtml.includes('ki-crown-2')) ||
                    (master === '0' && !masterHtml.includes('ki-crown-2'))
                )) &&
                matchesValidity &&
                matchesDateType;

            tr.style.display = match ? '' : 'none';


        });
    }
</script>
