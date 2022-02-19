$(document).ready(function() {

    const defaultSettings = {
        pageLength: 50,
        info: false,
        language: {
            paginate: {
                previous: "<i class='uil uil-angle-left'>",
                next: "<i class='uil uil-angle-right'>"
            },
            search: "Найти:",
            lengthMenu:     "Показать _MENU_ записей",
        },
        drawCallback: function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        }
    };

    //Datatables
    $('#clients-datatable').DataTable({
        ...defaultSettings,
        columns: [null, {orderable: false}, {orderable: false}]
    });

    $('#basic-datatable').DataTable({
        ...defaultSettings,
        columns: [null, {orderable: false}]
    });

    $('#users-datatable').DataTable({
        ...defaultSettings,
        columns: [null, null, null, {orderable: false}, {orderable: false}, {orderable: false}]
    });

    $('.shipments-datatable').DataTable({
        ...defaultSettings,
        scrollX: true
    });

    $('#reports_employees').DataTable({
        ...defaultSettings,
        columns: [null, null, null, {orderable: false}]
    });

    $('#employee_report').DataTable({
        ...defaultSettings
    });

    $('#report_employee').DataTable({
        ...defaultSettings
    });


    //Buttons examples
    var table = $('#datatable-buttons').DataTable({
        lengthChange: false,
        buttons: ['copy', 'print'],
        "language": {
            "paginate": {
                "previous": "<i class='uil uil-angle-left'>",
                "next": "<i class='uil uil-angle-right'>"
            }
        },
        "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        }
    });

    // Multi Selection Datatable
    $('#selection-datatable').DataTable({
        select: {
            style: 'multi'
        },
        "language": {
            "paginate": {
                "previous": "<i class='uil uil-angle-left'>",
                "next": "<i class='uil uil-angle-right'>"
            }
        },
        "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        }
    });

    // Key Datatable
    $('#key-datatable').DataTable({
        keys: true,
        "language": {
            "paginate": {
                "previous": "<i class='uil uil-angle-left'>",
                "next": "<i class='uil uil-angle-right'>"
            }
        },
        "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        }
    });

    table.buttons().container()
        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
} );
    