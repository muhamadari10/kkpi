
$(document).ajaxStart(function () {
    Pace.restart()
});

$(document).ready(function () {

    var achievementList = {
        id: 'achievementList',
        column: [
            {
                "data": "id",
                "orderable": false,
                'sortable': true,
                "visible": false,
            },
            {
                "data": "external_code",
                "orderable": false
            },
            {
                "data": "project_name",
                "orderable": false
            },
            {
                "data": "sector_name",
                "orderable": false
            },
            {
                "data": "fund_indication_name",
                "orderable": false
            },
            {
                "data": "currency",
                "orderable": false
            },
            {
                "data": "total_fund",
                "orderable": false,
                "render": $.fn.dataTable.render.number('.', ',', 2)
            },
            {
                "data": "status_code_name",
                "orderable": false
            },
            {
                "data": "pjp_name",
                "orderable": false
            },
            {
                "data": "output",
                "orderable": false
            },
            {
                "data": "status",
                "orderable": false
            },
            {
                "data": "description",
                "orderable": false
            },
            {
                "data": "contact_person",
                "orderable": false
            },
            {
                "data": "start_date",
                "orderable": false,
                "render": function (data) {
                    // console.log(data);
                    var dateFormat = data.split('/');
                    return dateFormat[1] + '/' + dateFormat[0] + '/' + dateFormat[2];
                }
            },
            {
                "data": "end_date",
                "orderable": false,
                "render": function (data) {
                    // console.log(data);
                    var dateFormat = data.split('/');
                    return dateFormat[1] + '/' + dateFormat[0] + '/' + dateFormat[2];
                }
            },
            {
                "data": "transaction_date",
                "orderable": false,
                "render": function (data) {
                    // console.log(data);
                    var dateFormat = data.split('/');
                    return dateFormat[1] + '/' + dateFormat[0] + '/' + dateFormat[2];
                }
            },
            {
                "data": "construction_date",
                "orderable": false,
                "render": function (data) {
                    // console.log(data);
                    var dateFormat = data.split('/');
                    return dateFormat[1] + '/' + dateFormat[0] + '/' + dateFormat[2];
                }
            },
            {
                "data": "operation_date",
                "orderable": false,
                "render": function (data) {
                    // console.log(data);
                    var dateFormat = data.split('/');
                    return dateFormat[1] + '/' + dateFormat[0] + '/' + dateFormat[2];
                }
            },
            {
                "data": "project_status",
                "orderable": false
            }
        ],
        // function: _gridAction,
        order: [[1, 'desc']],
        length: [[10, 50, 100, 250, 500, 1000], [10, 50, 100, 250, 500, 1000]],
        search: false,
        button: [
            { 
                extend: 'copyHtml5', 
                className: 'btn bg-default btn-xs',
                title: 'Laporan Pencapaian Proyek',
            },
            { 
                extend: 'excelHtml5', 
                className: 'btn bg-success btn-xs',
                title: 'Laporan Pencapaian Proyek',
            },
            //   { extend: 'csvHtml5', className: 'btn bg-red btn-xs' },
            ],
    }

    window.achievementGrid      = new grid(achievementList);
    window.achievementGrid.url  = current_url + "/grid/achievement_list";
    window.achievementGrid.type = 'GET';
    window.achievementGrid.init();

    var table = achievementGrid.getTablesID();

    $("#projectOpt").select2({
        ajax: {
            url: current_url + "/ajax/project_option",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                };
            },
            processResults: function (data) {
                return {
                    results: data.data
                };
            },
            cache: true
        },
        placeholder: 'Proyek',
    });
    
    $("#provinceOpt").select2({
        ajax: {
            url: current_url + "/ajax/province_option",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                };
            },
            processResults: function (data) {
                return {
                    results: data.data
                };
            },
            cache: true
        },
        placeholder: 'Provinsi',
    });
    
    $("#pjpOpt").select2({
        ajax: {
            url: current_url + "/ajax/pjp_option",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                };
            },
            processResults: function (data) {
                return {
                    results: data.data
                };
            },
            cache: true
        },
        placeholder: 'PJP',
    });

    $("#sectorOpt").select2({
        ajax: {
            url: current_url + "/ajax/sector_option",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                };
            },
            processResults: function (data) {
                return {
                    results: data.data
                };
            },
            cache: true
        },
        placeholder: 'Sektor',
    });


    $('#reportSubmit').on('click', function () {

        window.achievementGrid.data = {
            sectorFt: $("#sectorOpt").val(),
            projectFt: $("#projectOpt").val(),
            pjpFt: $("#pjpOpt").val(),
            provinceFt: $("#provinceOpt").val(),
        };

        window.achievementGrid.table.draw();

    });

});
